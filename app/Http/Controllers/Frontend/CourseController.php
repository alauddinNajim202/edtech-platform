<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Category;
use App\Models\LessonProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $query = Course::where('status', 'approved')->with(['instructor', 'category', 'tags']);

        if ($request->filled('category')) {
            $query->whereHas('category', fn($q) => $q->where('slug', $request->category));
        }

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%')
                ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        $courses = $query->latest()->paginate(12);
        $categories = Category::all();

        return view('frontend.courses.index', compact('courses', 'categories'));
    }

    public function show($slug)
    {
        $course = Course::where('slug', $slug)
            ->where('status', 'approved')
            ->with(['instructor', 'category', 'tags', 'modules.lessons'])
            ->firstOrFail();

        $isEnrolled = Auth::check() ? Auth::user()->isEnrolledIn($course) : false;
        $totalLessons = $course->modules->flatMap->lessons->count();

        return view('frontend.courses.show', compact('course', 'isEnrolled', 'totalLessons'));
    }

    public function learn($slug, $lessonId = null)
    {
        $course = Course::where('slug', $slug)
            ->where('status', 'approved')
            ->with(['instructor', 'category', 'modules.lessons'])
            ->firstOrFail();

        $user = Auth::user();

        if (!$user->isEnrolledIn($course)) {
            return redirect()->route('courses.show', $course->slug)
                ->with('error', 'Please enroll in this course first.');
        }

        // Get completed lesson IDs as a plain array for use in the view
        $completedLessonIds = LessonProgress::where('user_id', $user->id)
            ->where('is_completed', true)
            ->pluck('lesson_id')
            ->toArray();

        $allLessons = $course->modules->flatMap->lessons;
        $totalLessons = $allLessons->count();
        $completedCount = $allLessons->filter(fn($l) => in_array($l->id, $completedLessonIds))->count();
        $progressPercent = $totalLessons > 0 ? (int) round(($completedCount / $totalLessons) * 100) : 0;

        // Determine active lesson
        $activeLesson = null;
        if ($lessonId) {
            $activeLesson = $allLessons->firstWhere('id', $lessonId);
        }

        // If no valid active lesson provided, find the first incomplete lesson, or just the first lesson
        if (!$activeLesson && $totalLessons > 0) {
            $activeLesson = $allLessons->first(fn($l) => !in_array($l->id, $completedLessonIds)) ?? $allLessons->first();
        }
        
        // Find next lesson for the "Next" button
        $nextLesson = null;
        if ($activeLesson) {
            $currentIndex = $allLessons->search(fn($l) => $l->id === $activeLesson->id);
            if ($currentIndex !== false && $currentIndex < $totalLessons - 1) {
                $nextLesson = $allLessons[$currentIndex + 1];
            }
        }

        return view('frontend.courses.learn', compact(
            'course',
            'completedLessonIds',
            'progressPercent',
            'totalLessons',
            'completedCount',
            'activeLesson',
            'nextLesson'
        ));
    }

    public function completeLesson(Request $request, $slug, $lessonId)
    {
        $course = Course::where('slug', $slug)->firstOrFail();
        $user = Auth::user();

        if (!$user->isEnrolledIn($course)) {
            abort(403);
        }

        LessonProgress::updateOrCreate(
            ['user_id' => $user->id, 'lesson_id' => $lessonId],
            ['is_completed' => true, 'completed_at' => now()]
        );
        
        // Update learning activity streak
        \App\Models\LearningActivity::updateOrCreate(
            ['user_id' => $user->id, 'activity_date' => now()->toDateString()],
            ['minutes_studied' => \Illuminate\Support\Facades\DB::raw('minutes_studied + 5')] // dummy 5 mins
        );

        if ($request->has('next_lesson_id')) {
            return redirect()->route('courses.learn', ['course' => $slug, 'lesson' => $request->next_lesson_id]);
        }

        return redirect()->route('courses.learn', $slug)->with('success', 'Lesson marked as complete!');
    }
}
