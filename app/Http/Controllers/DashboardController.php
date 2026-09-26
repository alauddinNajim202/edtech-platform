<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\LessonProgress;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // ── Enrolled courses ──────────────────────────────────────────
        $enrolledCourses = $user->enrolledCourses()
            ->with(['category', 'instructor', 'modules.lessons'])
            ->where('courses.status', 'approved')
            ->orderByPivot('created_at', 'desc')
            ->get();

        $enrolledCount = $enrolledCourses->count();

        // Fetch all completed lesson IDs for this user in one query
        $completedLessonIds = LessonProgress::where('user_id', $user->id)
            ->where('is_completed', true)
            ->pluck('lesson_id')
            ->flip(); // flip for O(1) lookup

        // Attach progress data to each enrolled course
        $coursesWithProgress = $enrolledCourses->map(function ($course) use ($completedLessonIds) {
            $allLessons = $course->modules->flatMap->lessons;
            $totalLessons = $allLessons->count();
            $completedCount = $allLessons->filter(
                fn($lesson) => $completedLessonIds->has($lesson->id)
            )->count();

            $course->progress_percent = $totalLessons > 0
                ? (int) round(($completedCount / $totalLessons) * 100)
                : 0;
            $course->completed_lessons = $completedCount;
            $course->total_lessons = $totalLessons;

            return $course;
        });

        // ── Continue learning = latest in-progress course ─────────────
        $continueLearning = $coursesWithProgress
            ->filter(fn($c) => $c->progress_percent < 100)
            ->first();

        // ── Certificates = 100% completed courses ─────────────────────
        $certificateCount = $coursesWithProgress
            ->filter(fn($c) => $c->progress_percent === 100)
            ->count();

        // ── Total learning hours (from watched_seconds) ───────────────
        $totalSeconds = LessonProgress::where('user_id', $user->id)->sum('watched_seconds');
        $totalHours = round($totalSeconds / 3600, 1);

        // ── Weekly streak (Mon–Sun) ───────────────────────────────────
        $weekStart = Carbon::now()->startOfWeek(Carbon::MONDAY);

        // Get distinct study dates for this week in one query
        $studiedDates = LessonProgress::where('user_id', $user->id)
            ->whereDate('updated_at', '>=', $weekStart->toDateString())
            ->whereDate('updated_at', '<=', $weekStart->copy()->addDays(6)->toDateString())
            ->selectRaw('DATE(updated_at) as study_date')
            ->distinct()
            ->pluck('study_date')
            ->flip();

        $weekDays = [];
        for ($i = 0; $i < 7; $i++) {
            $date = $weekStart->copy()->addDays($i);
            $weekDays[] = [
                'label'   => mb_substr($date->isoFormat('ddd'), 0, 1), // M T W T F S S
                'date'    => $date->toDateString(),
                'studied' => $studiedDates->has($date->toDateString()),
                'today'   => $date->isToday(),
            ];
        }

        $streakCount = collect($weekDays)->filter(fn($d) => $d['studied'])->count();

        // ── Recommended courses (approved, not yet enrolled) ──────────
        $enrolledIds = $enrolledCourses->pluck('id')->toArray();
        $recommendedCourses = Course::where('status', 'approved')
            ->whereNotIn('id', $enrolledIds)
            ->with(['category', 'instructor'])
            ->inRandomOrder()
            ->take(4)
            ->get();

        return view('dashboard', compact(
            'enrolledCount',
            'coursesWithProgress',
            'continueLearning',
            'certificateCount',
            'totalHours',
            'weekDays',
            'streakCount',
            'recommendedCourses',
        ));
    }
}
