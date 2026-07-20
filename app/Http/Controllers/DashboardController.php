<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class DashboardController extends Controller
{
    /**
     * Apply authentication middleware to all controller methods.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display the learner dashboard.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        // Admin routing
        if ($user->role === 'admin') {
            $usersList = User::orderBy('created_at', 'desc')->paginate(10);
            return view('admin-dashboard', [
                'user' => $user,
                'usersList' => $usersList,
            ]);
        }

        // Instructor routing
        if ($user->role === 'instructor') {
            // Load courses with their contents and enrollment counts dynamically
            $courses = $user->courses()->with('contents')->withCount('enrollments')->get();
            $publishedCount = $courses->where('status', 'Published')->count();
            $draftCount = $courses->where('status', 'Draft')->count();
            $totalStudents = $courses->sum('enrollments_count');
            $totalModules = $courses->sum('modules_count');

            // Calculate content items and culture tag counts dynamically
            $tagCounts = [
                'yoruba' => 0,
                'hausa' => 0,
                'igbo' => 0,
                'northern_nigeria' => 0,
                'panafrican' => 0,
                'universal' => 0,
            ];
            $totalContentItems = 0;

            foreach ($courses as $course) {
                $contentCount = $course->contents->count();
                $totalContentItems += $contentCount;

                foreach ($course->contents as $content) {
                    $culture = $content->culture_tag ?? 'universal';
                    if (isset($tagCounts[$culture])) {
                        $tagCounts[$culture]++;
                    } else {
                        $tagCounts['universal']++;
                    }
                }
            }

            $avgCompletion = $courses->isNotEmpty() ? round($courses->avg('avg_completion')) : 0;

            return view('instructor-dashboard', [
                'user' => $user,
                'courses' => $courses,
                'publishedCount' => $publishedCount,
                'draftCount' => $draftCount,
                'totalStudents' => $totalStudents,
                'totalModules' => $totalModules,
                'tagCounts' => $tagCounts,
                'totalContentItems' => $totalContentItems,
                'avgCompletion' => $avgCompletion,
            ]);
        }

        // Learner routing
        // Define cultural greeting mappings
        $greetings = [
            'yoruba'      => 'Ẹ̀kúàbọ̀, ' . explode(' ', $user->name)[0] . '.',
            'hausa'       => 'Sannu, ' . explode(' ', $user->name)[0] . '.',
            'igbo'        => 'Nnọọ, ' . explode(' ', $user->name)[0] . '.',
            'panafrican'  => 'Ubuntu, ' . explode(' ', $user->name)[0] . '.',
            'universal'   => 'Welcome, ' . explode(' ', $user->name)[0] . '.',
        ];

        // Pick greeting based on preferred culture frame, default to 'universal'
        $cultureFrame = $user->culture_frame ?? 'universal';
        $greeting = $greetings[$cultureFrame] ?? $greetings['universal'];

        // Format current date matching: TODAY  TUESDAY, 7 MAY
        $currentDate = strtoupper(now()->translatedFormat('l, j F'));

        // Load active enrolled courses
        $enrolledCourses = $user->enrolledCourses()->with('contents')->get();
        $enrolledCourseIds = $enrolledCourses->pluck('id')->toArray();

        // Load recommended courses (published, not enrolled yet)
        $recommendedCourses = \App\Models\Course::where('status', 'Published')
            ->whereNotIn('id', $enrolledCourseIds)
            ->with(['contents', 'instructor'])
            ->get();

        // Calculate progress stats
        $totalEnrolled = $enrolledCourses->count();
        $completedCoursesCount = $enrolledCourses->filter(function($course) {
            return $course->pivot->progress === 100;
        })->count();

        $overallCompletion = $totalEnrolled > 0 ? round(($completedCoursesCount / $totalEnrolled) * 100) : 0;
        $avgProgress = $totalEnrolled > 0 ? round($enrolledCourses->avg('pivot.progress')) : 0;

        return view('dashboard', [
            'user' => $user,
            'greeting' => $greeting,
            'currentDate' => $currentDate,
            'cultureFrame' => $cultureFrame,
            'enrolledCourses' => $enrolledCourses,
            'recommendedCourses' => $recommendedCourses,
            'overallCompletion' => $overallCompletion,
            'avgProgress' => $avgProgress,
            'totalEnrolled' => $totalEnrolled,
        ]);
    }
}
