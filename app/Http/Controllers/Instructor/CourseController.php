<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;

class CourseController extends Controller
{
    public function create()
    {
        return view('instructor.courses.create');
    }

    public function show(Course $course)
    {
        // Ensure the instructor owns this course
        abort_if($course->instructor_id !== Auth::id(), 403);

        $course->load('contents');

        return view('instructor.courses.show', compact('course'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'tag' => 'required|string|in:yoruba,hausa,igbo,northern_nigeria,panafrican,universal',
            'langs' => 'required|array',
            'langs.*' => 'string',
            'status' => 'required|string|in:Draft,Published',
        ]);

        $course = Auth::user()->courses()->create([
            'title' => $request->title,
            'tag' => $request->tag,
            'langs' => $request->langs,
            'modules_count' => 0,
            'students_count' => 0,
            'culture_items' => [],
            'avg_completion' => 0,
            'status' => $request->status,
        ]);

        return redirect()->route('dashboard')->with('success', 'Course created successfully!');
    }

    public function toggleStatus(Course $course)
    {
        // Ensure the instructor owns this course
        abort_if($course->instructor_id !== Auth::id(), 403);

        $newStatus = $course->status === 'Published' ? 'Draft' : 'Published';
        $course->update(['status' => $newStatus]);

        return redirect()->back()
            ->with('success', 'Course status changed to ' . $newStatus . ' successfully!');
    }
}
