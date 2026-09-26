<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnrollmentController extends Controller
{
    public function enroll(Course $course)
    {
        $user = Auth::user();

        if ($course->status !== 'approved') {
            return back()->with('error', 'This course is not available for enrollment.');
        }

        if ($user->isEnrolledIn($course)) {
            return back()->with('info', 'You are already enrolled in this course.');
        }

        Enrollment::create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'enrolled_at' => now(),
        ]);

        return redirect()->route('courses.learn', $course->slug)
            ->with('success', 'Successfully enrolled! Start learning now.');
    }

    public function unenroll(Course $course)
    {
        Auth::user()->enrollments()->where('course_id', $course->id)->delete();

        return redirect()->route('courses.show', $course->slug)
            ->with('success', 'You have been unenrolled from this course.');
    }
}
