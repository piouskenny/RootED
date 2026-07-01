<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;
use App\Models\CourseContent;

class CourseContentController extends Controller
{
    public function create()
    {
        $courses = Auth::user()->courses()->get();
        return view('instructor.content.create', compact('courses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'type' => 'required|string|in:Reading,Video,PDF,Quiz',
            'title' => 'required|string|max:255',
            'body' => 'nullable|string',
            'language' => 'required|string',
            'culture_tag' => 'required|string|in:yoruba,hausa,igbo,northern_nigeria,panafrican,universal',
            'status' => 'required|string|in:Draft,Published',
            'file' => 'nullable|file|mimes:pdf,mp4,mov,avi|max:20480',
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('course_content', 'public');
        }

        $course = Auth::user()->courses()->findOrFail($request->course_id);

        $content = $course->contents()->create([
            'type' => $request->type,
            'title' => $request->title,
            'body' => $request->body,
            'language' => $request->language,
            'culture_tag' => $request->culture_tag,
            'status' => $request->status,
            'file_path' => $filePath,
        ]);

        // Update Course Stats
        $cultureItems = $course->culture_items ?? [];
        $cultureTag = $content->culture_tag;
        
        if (!isset($cultureItems[$cultureTag])) {
            $cultureItems[$cultureTag] = 0;
        }
        $cultureItems[$cultureTag]++;

        $course->update([
            'modules_count' => $course->contents()->count(),
            'culture_items' => $cultureItems,
        ]);

        return redirect()->route('dashboard')->with('success', 'Content added successfully!');
    }

    /**
     * Store a new module (content) directly from the course single page.
     */
    public function storeModule(Request $request, Course $course)
    {
        // Ensure the instructor owns this course
        abort_if($course->instructor_id !== Auth::id(), 403);

        $request->validate([
            'type'        => 'required|string|in:Reading,Video,PDF,Quiz',
            'title'       => 'required|string|max:255',
            'body'        => 'nullable|string',
            'language'    => 'required|string',
            'culture_tag' => 'required|string|in:yoruba,hausa,igbo,northern_nigeria,panafrican,universal',
            'status'      => 'required|string|in:Draft,Published',
            'file'        => 'nullable|file|mimes:pdf,mp4,mov,avi|max:20480',
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('course_content', 'public');
        }

        $content = $course->contents()->create([
            'type'        => $request->type,
            'title'       => $request->title,
            'body'        => $request->body,
            'language'    => $request->language,
            'culture_tag' => $request->culture_tag,
            'status'      => $request->status,
            'file_path'   => $filePath,
        ]);

        // Update Course Stats
        $cultureItems = $course->culture_items ?? [];
        $cultureTag   = $content->culture_tag;

        if (!isset($cultureItems[$cultureTag])) {
            $cultureItems[$cultureTag] = 0;
        }
        $cultureItems[$cultureTag]++;

        $course->update([
            'modules_count' => $course->contents()->count(),
            'culture_items' => $cultureItems,
        ]);

        return redirect()->route('instructor.courses.show', $course)->with('success', 'Module added successfully!');
    }
}
