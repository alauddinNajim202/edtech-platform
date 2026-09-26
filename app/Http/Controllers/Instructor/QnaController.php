<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\LessonQuestion;
use Illuminate\Http\Request;

class QnaController extends Controller
{
    public function index()
    {
        $questions = LessonQuestion::whereHas('lesson.module.course', function ($query) {
                $query->where('instructor_id', auth()->id());
            })
            ->with(['lesson.module.course', 'user', 'replies.user'])
            ->latest()
            ->paginate(20);

        return view('instructor.qna.index', compact('questions'));
    }

    public function reply(Request $request, LessonQuestion $question)
    {
        $request->validate([
            'body' => 'required|string|max:1000',
        ]);

        // Ensure the logged-in instructor actually owns the course
        if ($question->lesson->module->course->instructor_id !== auth()->id()) {
            abort(403);
        }

        $question->replies()->create([
            'user_id' => auth()->id(),
            'body' => $request->body,
        ]);

        return back()->with('success', 'Reply posted successfully.');
    }
}
