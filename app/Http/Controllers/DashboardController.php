<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        return view('dashboard', [
            'user' => $user,
            'greeting' => $greeting,
            'currentDate' => $currentDate,
            'cultureFrame' => $cultureFrame,
        ]);
    }
}
