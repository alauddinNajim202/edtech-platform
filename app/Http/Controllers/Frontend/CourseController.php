<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Category;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $query = Course::where('status', 'approved')->with(['instructor', 'category', 'tags']);

        if ($request->has('category')) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $courses = $query->latest()->paginate(12);
        $categories = Category::all();

        return view('frontend.courses.index', compact('courses', 'categories'));
    }

    public function show($slug)
    {
        $course = Course::where('slug', $slug)
            ->where('status', 'approved')
            ->with(['instructor', 'category', 'tags'])
            ->firstOrFail();

        return view('frontend.courses.show', compact('course'));
    }

    public function learn($slug)
    {
        $course = Course::where('slug', $slug)
            ->where('status', 'approved')
            ->with(['instructor', 'category', 'modules.lessons'])
            ->firstOrFail();

        return view('frontend.courses.learn', compact('course'));
    }
}
