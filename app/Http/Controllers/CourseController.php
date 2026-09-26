<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Category;
use App\Models\Tag;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::where('instructor_id', Auth::id())->latest()->paginate(10);
        return view('instructor.courses.index', compact('courses'));
    }

    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('instructor.courses.create', compact('categories', 'tags'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $course = new Course([
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . uniqid(),
            'description' => $request->description,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'instructor_id' => Auth::id(),
            'status' => 'pending',
        ]);

        if ($request->hasFile('thumbnail')) {
            $course->thumbnail = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        $course->save();

        if ($request->has('tags')) {
            $course->tags()->sync($request->tags);
        }

        return redirect()->route('instructor.courses.index')->with('success', 'Course created successfully and is pending admin approval.');
    }

    public function show(Course $course)
    {
        if ($course->instructor_id !== Auth::id()) abort(403);
        return view('instructor.courses.show', compact('course'));
    }

    public function edit(Course $course)
    {
        if ($course->instructor_id !== Auth::id()) abort(403);
        $categories = Category::all();
        $tags = Tag::all();
        return view('instructor.courses.edit', compact('course', 'categories', 'tags'));
    }

    public function update(Request $request, Course $course)
    {
        if ($course->instructor_id !== Auth::id()) abort(403);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'tags' => 'nullable|array',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $course->title = $request->title;
        $course->description = $request->description;
        $course->price = $request->price;
        $course->category_id = $request->category_id;

        if ($request->hasFile('thumbnail')) {
            if ($course->thumbnail) {
                Storage::disk('public')->delete($course->thumbnail);
            }
            $course->thumbnail = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        $course->save();

        if ($request->has('tags')) {
            $course->tags()->sync($request->tags);
        } else {
            $course->tags()->detach();
        }

        return redirect()->route('instructor.courses.index')->with('success', 'Course updated successfully.');
    }

    public function destroy(Course $course)
    {
        if ($course->instructor_id !== Auth::id()) abort(403);
        
        if ($course->thumbnail) {
            Storage::disk('public')->delete($course->thumbnail);
        }
        
        $course->delete();
        return redirect()->route('instructor.courses.index')->with('success', 'Course deleted successfully.');
    }
}
