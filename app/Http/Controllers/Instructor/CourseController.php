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

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'tag' => 'required|string|in:yoruba,hausa,igbo,northern_nigeria,panafrican,universal',
            'langs' => 'required|array',
            'langs.*' => 'string',
        ]);

        $course = Auth::user()->courses()->create([
            'title' => $request->title,
            'tag' => $request->tag,
            'langs' => $request->langs,
            'modules_count' => 0,
            'students_count' => 0,
            'culture_items' => [],
            'avg_completion' => 0,
            'status' => 'Draft',
        ]);

        return redirect()->route('dashboard')->with('success', 'Course created successfully!');
    }
}
