<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Course;
use App\Models\CourseContent;
use App\Models\Enrollment;
use Illuminate\Support\Facades\Auth;

class LearnerCourseController extends Controller
{
    /**
     * Display a course details for a learner.
     */
    public function show(Course $course)
    {
        // Enforce that course must be published to be visible, unless user is already enrolled
        $isEnrolled = Auth::user()->enrolledCourses()->where('courses.id', $course->id)->exists();
        
        if ($course->status !== 'Published' && !$isEnrolled) {
            abort(404, 'Course not found or not published.');
        }

        $course->load('contents');
        $enrollment = Auth::user()->enrollments()->where('course_id', $course->id)->first();

        return view('courses.show', compact('course', 'enrollment', 'isEnrolled'));
    }

    /**
     * Enroll the student in a course.
     */
    public function enroll(Course $course)
    {
        if ($course->status !== 'Published') {
            return back()->with('error', 'You cannot enroll in a draft course.');
        }

        $user = Auth::user();
        
        // Check if already enrolled
        $isEnrolled = $user->enrolledCourses()->where('courses.id', $course->id)->exists();
        if ($isEnrolled) {
            return redirect()->route('courses.show', $course)->with('success', 'You are already enrolled in this course.');
        }

        // Create enrollment
        $user->enrolledCourses()->attach($course->id, [
            'completed_contents' => json_encode([]),
            'progress' => 0,
        ]);

        // Increment students count
        $course->increment('students_count');

        return redirect()->route('courses.show', $course)->with('success', 'Successfully enrolled in ' . $course->title . '!');
    }

    /**
     * Toggle module completion status for a course.
     */
    public function toggleModule(Course $course, CourseContent $content)
    {
        $user = Auth::user();
        $enrollment = $user->enrollments()->where('course_id', $course->id)->firstOrFail();

        $completed = $enrollment->completed_contents ?? [];

        if (in_array($content->id, $completed)) {
            // Mark incomplete
            $completed = array_values(array_diff($completed, [$content->id]));
        } else {
            // Mark complete
            $completed[] = $content->id;
        }

        // Calculate progress percentage
        $totalModules = $course->contents()->count();
        $progress = $totalModules > 0 ? round((count($completed) / $totalModules) * 100) : 0;

        $enrollment->update([
            'completed_contents' => $completed,
            'progress' => $progress,
        ]);

        // Dynamically update course average completion of all enrolled students
        $avgCompletion = round($course->enrollments()->avg('progress') ?? 0);
        $course->update(['avg_completion' => $avgCompletion]);

        return back()->with('success', 'Module completion updated!');
    }
}
