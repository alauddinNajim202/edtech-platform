<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CurriculumController extends Controller
{
    public function index(Course $course)
    {
        // Ensure only the instructor of this course can access it
        if ($course->instructor_id !== auth()->id()) {
            abort(403);
        }

        $course->load(['modules' => function ($query) {
            $query->orderBy('order');
        }, 'modules.lessons' => function ($query) {
            $query->orderBy('order');
        }, 'modules.lessons.resources']);

        return view('instructor.courses.curriculum', compact('course'));
    }

    public function storeModule(Request $request, Course $course)
    {
        if ($course->instructor_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $order = $course->modules()->max('order') + 1;

        $course->modules()->create([
            'title' => $request->title,
            'order' => $order,
        ]);

        return back()->with('success', 'Module created successfully.');
    }

    public function storeLesson(Request $request, Module $module)
    {
        $course = $module->course;
        if ($course->instructor_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'video' => 'required|mimes:mp4,mov,ogg,qt|max:500000', // max 500MB
            'is_preview' => 'boolean',
        ]);

        $order = $module->lessons()->max('order') + 1;

        $videoPath = null;
        if ($request->hasFile('video')) {
            $videoPath = $request->file('video')->store('lessons/videos', 'public');
        }

        $module->lessons()->create([
            'title' => $request->title,
            'video_path' => $videoPath,
            'duration_seconds' => 300, // Dummy 5 minutes for now (ideally parsed using FFMPEG)
            'is_preview' => $request->has('is_preview'),
            'order' => $order,
        ]);

        return back()->with('success', 'Lesson added successfully.');
    }

    public function storeResource(Request $request, Lesson $lesson)
    {
        $course = $lesson->module->course;
        if ($course->instructor_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'file' => 'required|file|max:50000', // max 50MB
        ]);

        $file = $request->file('file');
        $filePath = $file->store('lessons/resources', 'public');
        
        $lesson->resources()->create([
            'name' => $request->name,
            'file_path' => $filePath,
            'file_type' => $file->getClientOriginalExtension(),
            'file_size' => $file->getSize(),
        ]);

        return back()->with('success', 'Resource attached to lesson.');
    }
}
