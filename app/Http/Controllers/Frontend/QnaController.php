<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Models\LessonQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QnaController extends Controller
{
    public function storeQuestion(Request $request, Lesson $lesson)
    {
        $request->validate([
            'body' => 'required|string|max:1000',
        ]);

        // Basic check if the user is enrolled could be added here, 
        // but for now anyone who can access the route can ask.

        $lesson->questions()->create([
            'user_id' => Auth::id(),
            'body' => $request->body,
        ]);

        return back()->with('success', 'Question posted successfully.');
    }

    public function storeReply(Request $request, LessonQuestion $question)
    {
        $request->validate([
            'body' => 'required|string|max:1000',
        ]);

        $question->replies()->create([
            'user_id' => Auth::id(),
            'body' => $request->body,
        ]);

        return back()->with('success', 'Reply posted successfully.');
    }
}
