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

    /**
     * Localize content (Reading text or Quiz questions) to a target language.
     */
    public function localizeContent(Request $request, Course $course, CourseContent $content)
    {
        $targetLang = strtolower($request->query('lang', 'en'));

        $title = $content->title;
        $body  = $content->body;

        // If English requested, return as-is immediately
        if ($targetLang === 'en') {
            return response()->json([
                'title'    => $title,
                'body'     => $body,
                'language' => 'EN',
                'type'     => $content->type,
            ]);
        }

        // Detect whether the body is a JSON Quiz array
        $quizData  = json_decode($body, true);
        $isJsonQuiz = json_last_error() === JSON_ERROR_NONE && is_array($quizData);

        if ($isJsonQuiz) {
            // Translate each question and each option individually
            $translatedQuiz = [];
            foreach ($quizData as $item) {
                $translatedOpts = [];
                foreach ($item['options'] as $opt) {
                    $translatedOpts[] = $this->apiTranslate($opt, $targetLang);
                }
                $translatedQuiz[] = [
                    'question' => $this->apiTranslate($item['question'], $targetLang),
                    'options'  => $translatedOpts,
                    'answer'   => $item['answer'],
                ];
            }
            $translatedBody  = json_encode($translatedQuiz);
            $translatedTitle = $this->apiTranslate($title, $targetLang);
        } else {
            // Plain reading content — translate title and body
            $translatedTitle = $this->apiTranslate($title, $targetLang);
            $translatedBody  = $this->apiTranslate($body, $targetLang);
        }

        return response()->json([
            'title'    => $translatedTitle,
            'body'     => $translatedBody,
            'language' => strtoupper($targetLang),
            'type'     => $content->type,
        ]);
    }

    // ─────────────────────────────────────────────
    // Private helpers
    // ─────────────────────────────────────────────

    /**
     * Translate $text to $lang using the MyMemory free API.
     * Long text is automatically split into ≤450-char chunks.
     * Falls back to the original text on any network / API failure.
     */
    private function apiTranslate(string $text, string $lang): string
    {
        $text = trim($text);
        if ($text === '') {
            return $text;
        }

        // MyMemory language-pair codes for our supported languages
        $langMap = ['yo' => 'yo', 'ha' => 'ha', 'ig' => 'ig'];
        $pair    = 'en|' . ($langMap[$lang] ?? $lang);

        $chunks     = $this->chunkText($text, 450);
        $translated = [];

        foreach ($chunks as $chunk) {
            $url = 'https://api.mymemory.translated.net/get?' . http_build_query([
                'q'        => $chunk,
                'langpair' => $pair,
            ]);

            try {
                $ctx = stream_context_create([
                    'http' => ['timeout' => 12, 'ignore_errors' => true],
                    'ssl'  => ['verify_peer' => false, 'verify_peer_name' => false],
                ]);

                $raw = @file_get_contents($url, false, $ctx);

                if ($raw === false) {
                    $translated[] = $chunk;
                    continue;
                }

                $data = json_decode($raw, true);

                $result = $data['responseData']['translatedText'] ?? null;

                if (
                    isset($data['responseStatus']) &&
                    $data['responseStatus'] === 200 &&
                    $result !== null &&
                    !str_starts_with((string) $result, 'MYMEMORY WARNING')
                ) {
                    $translated[] = $result;
                } else {
                    $translated[] = $chunk; // fall back to original chunk
                }
            } catch (\Throwable $e) {
                $translated[] = $chunk;
            }
        }

        return implode(' ', $translated);
    }

    /**
     * Split text into chunks of at most $maxLen characters, breaking on spaces.
     */
    private function chunkText(string $text, int $maxLen = 450): array
    {
        if (mb_strlen($text) <= $maxLen) {
            return [$text];
        }

        $chunks  = [];
        $words   = explode(' ', $text);
        $current = '';

        foreach ($words as $word) {
            $candidate = $current === '' ? $word : "$current $word";
            if (mb_strlen($candidate) > $maxLen) {
                if ($current !== '') {
                    $chunks[] = $current;
                }
                $current = $word;
            } else {
                $current = $candidate;
            }
        }

        if ($current !== '') {
            $chunks[] = $current;
        }

        return $chunks;
    }
}
