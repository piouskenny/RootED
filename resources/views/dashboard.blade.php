@extends('layouts.app')

@section('title', 'RootED — Dashboard')

@section('content')
<div class="max-w-7xl mx-auto space-y-10">

    <!-- WELCOME HEADER SECTION -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 bg-white/40 backdrop-blur-sm neo-border neo-shadow rounded-2xl p-6 sm:p-8 relative overflow-hidden">
        
        <!-- Subtle West African motif element in background -->
        <div class="absolute -right-8 -bottom-8 w-32 h-32 rounded-full border border-brand-charcoal/5 pointer-events-none"></div>

        <div class="space-y-2 relative z-10">
            <!-- Date -->
            <div class="flex items-center gap-2 text-xs font-bold text-brand-charcoal/50 uppercase tracking-widest">
                <span class="inline-block w-1.5 h-1.5 rounded-full bg-brand-terracotta"></span>
                <span>Today &bull; {{ $currentDate }}</span>
            </div>
            
            <!-- Greeting -->
            <h1 class="font-serif text-4xl sm:text-5xl font-bold tracking-tight text-brand-charcoal leading-tight">
                {{ $greeting }}
            </h1>
            
            <!-- Sub-headline -->
            <p class="text-sm sm:text-base font-medium text-brand-charcoal/70 max-w-xl leading-relaxed">
                @if($totalEnrolled > 0)
                    You have completed {{ $overallCompletion }}% of your enrolled courses overall, with an average progress of {{ $avgProgress }}% across {{ $totalEnrolled }} active {{ Str::plural('course', $totalEnrolled) }}.
                @else
                    You are not enrolled in any courses yet. Choose a course from the recommendations below to start learning!
                @endif
            </p>
        </div>

        <!-- CTA "Keep Going" Button -->
        @if($totalEnrolled > 0)
            <a href="{{ route('courses.show', $enrolledCourses->first()) }}" class="relative z-10 flex items-center justify-center gap-3 px-6 py-3.5 bg-brand-terracotta text-white font-bold uppercase tracking-wider rounded-xl neo-border neo-shadow neo-button-hover active:translate-y-[2px] active:shadow-sm transition-all duration-150 shrink-0">
                <span>Keep going</span>
                <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M4 4l12 6-12 6z"/></svg>
            </a>
        @else
            <a href="#recommendations" class="relative z-10 flex items-center justify-center gap-3 px-6 py-3.5 bg-brand-terracotta text-white font-bold uppercase tracking-wider rounded-xl neo-border neo-shadow neo-button-hover active:translate-y-[2px] active:shadow-sm transition-all duration-150 shrink-0">
                <span>Explore Courses</span>
                <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M4 4l12 6-12 6z"/></svg>
            </a>
        @endif
    </div>

    <!-- "THIS WEEK" SCHEDULE BOX -->
    <div class="bg-brand-cream neo-border neo-shadow rounded-2xl overflow-hidden">
        <!-- Section title banner -->
        <div class="bg-brand-charcoal text-brand-cream px-6 py-3 flex justify-between items-center text-xs font-bold uppercase tracking-wider">
            <div class="flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-brand-terracotta"></span>
                <span>This Week</span>
            </div>
            <span>3 Items Due</span>
        </div>

        <!-- Task List Items Container -->
        <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-6 items-stretch">
            
            <!-- Item 1 (Yoruba Course Homework) -->
            <div class="bg-white neo-border neo-shadow-sm rounded-xl p-5 flex flex-col justify-between hover:translate-y-[-2px] transition-transform duration-200">
                <div class="flex items-start justify-between gap-4 mb-4">
                    <div class="flex flex-col text-center bg-brand-cream neo-border-sm rounded-lg p-2 min-w-[50px]">
                        <span class="text-[10px] font-bold uppercase tracking-wider text-brand-charcoal/50">Wed</span>
                        <span class="text-xl font-bold font-serif leading-tight">08</span>
                    </div>
                    <div class="space-y-1 text-left flex-1">
                        <h4 class="font-bold text-sm text-brand-charcoal leading-snug">Module 2: Oriki — praise as identity</h4>
                        <p class="text-[10px] font-bold uppercase tracking-wide text-brand-charcoal/40">Reading &bull; 15 Min</p>
                    </div>
                </div>
                <div class="flex">
                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 text-[9px] font-bold uppercase rounded-full border bg-culture-yoruba-bg text-culture-yoruba border-culture-yoruba/30">
                        <span class="w-1 h-1 bg-culture-yoruba rotate-45"></span>
                        Yoruba
                    </span>
                </div>
            </div>

            <!-- Item 2 (Yoruba Quiz) -->
            <div class="bg-white neo-border neo-shadow-sm rounded-xl p-5 flex flex-col justify-between hover:translate-y-[-2px] transition-transform duration-200">
                <div class="flex items-start justify-between gap-4 mb-4">
                    <div class="flex flex-col text-center bg-brand-cream neo-border-sm rounded-lg p-2 min-w-[50px]">
                        <span class="text-[10px] font-bold uppercase tracking-wider text-brand-charcoal/50">Thu</span>
                        <span class="text-xl font-bold font-serif leading-tight">09</span>
                    </div>
                    <div class="space-y-1 text-left flex-1">
                        <h4 class="font-bold text-sm text-brand-charcoal leading-snug">Quiz: forms of ìjálá</h4>
                        <p class="text-[10px] font-bold uppercase tracking-wide text-brand-charcoal/40">Quiz &bull; 6 Min</p>
                    </div>
                </div>
                <div class="flex">
                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 text-[9px] font-bold uppercase rounded-full border bg-culture-yoruba-bg text-culture-yoruba border-culture-yoruba/30">
                        <span class="w-1 h-1 bg-culture-yoruba rotate-45"></span>
                        Yoruba
                    </span>
                </div>
            </div>

            <!-- Item 3 (Hausa Assignment) -->
            <div class="bg-white neo-border neo-shadow-sm rounded-xl p-5 flex flex-col justify-between hover:translate-y-[-2px] transition-transform duration-200">
                <div class="flex items-start justify-between gap-4 mb-4">
                    <div class="flex flex-col text-center bg-brand-cream neo-border-sm rounded-lg p-2 min-w-[50px]">
                        <span class="text-[10px] font-bold uppercase tracking-wider text-brand-charcoal/50">Fri</span>
                        <span class="text-xl font-bold font-serif leading-tight">10</span>
                    </div>
                    <div class="space-y-1 text-left flex-1">
                        <h4 class="font-bold text-sm text-brand-charcoal leading-snug">Cooperative finance worksheet</h4>
                        <p class="text-[10px] font-bold uppercase tracking-wide text-brand-charcoal/40">Assignment &bull; Due 5PM</p>
                    </div>
                </div>
                <div class="flex">
                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 text-[9px] font-bold uppercase rounded-full border bg-culture-hausa-bg text-culture-hausa border-culture-hausa/30">
                        <span class="w-1 h-1 bg-culture-hausa rounded-none"></span>
                        Hausa
                    </span>
                </div>
            </div>

        </div>
    </div>

    <!-- "YOUR COURSES" GRID -->
    @php
        $cardStyles = [
            'yoruba' => [
                'bg' => 'bg-culture-yoruba-bg',
                'border' => 'border-culture-yoruba/30',
                'text' => 'text-culture-yoruba',
                'bar' => 'bg-brand-terracotta',
                'shape' => 'absolute right-12 top-12 w-20 h-20 bg-brand-charcoal/5 rotate-45 pointer-events-none group-hover:scale-110 transition-transform duration-300'
            ],
            'hausa' => [
                'bg' => 'bg-culture-hausa-bg',
                'border' => 'border-culture-hausa/30',
                'text' => 'text-culture-hausa',
                'bar' => 'bg-culture-hausa',
                'shape' => 'absolute right-12 top-12 w-24 h-16 bg-brand-charcoal/5 -skew-x-12 pointer-events-none group-hover:scale-110 transition-transform duration-300'
            ],
            'igbo' => [
                'bg' => 'bg-culture-igbo-bg/40',
                'border' => 'border-culture-igbo/30',
                'text' => 'text-culture-igbo',
                'bar' => 'bg-culture-igbo',
                'shape' => 'absolute right-12 top-12 w-20 h-20 bg-brand-charcoal/5 border border-brand-charcoal/10 rounded-full pointer-events-none group-hover:scale-110 transition-transform duration-300'
            ],
            'northern_nigeria' => [
                'bg' => 'bg-[#F0F4F8]',
                'border' => 'border-[#1D70B8]/30',
                'text' => 'text-[#1D70B8]',
                'bar' => 'bg-[#1D70B8]',
                'shape' => 'absolute right-12 top-12 w-20 h-20 bg-[#1D70B8]/5 rotate-12 pointer-events-none group-hover:scale-110 transition-transform duration-300'
            ],
            'panafrican' => [
                'bg' => 'bg-culture-panafrican-bg/50',
                'border' => 'border-culture-panafrican/30',
                'text' => 'text-culture-panafrican',
                'bar' => 'bg-culture-panafrican',
                'shape' => 'absolute right-12 top-12 w-20 h-20 bg-culture-panafrican/5 pointer-events-none group-hover:scale-110 transition-transform duration-300'
            ],
            'universal' => [
                'bg' => 'bg-white',
                'border' => 'border-brand-charcoal/20',
                'text' => 'text-brand-charcoal/60',
                'bar' => 'bg-brand-charcoal',
                'shape' => 'absolute right-12 top-12 w-20 h-20 bg-brand-charcoal/5 pointer-events-none group-hover:scale-110 transition-transform duration-300'
            ],
        ];
    @endphp

    <div class="space-y-4">
        <!-- Section Header -->
        <div class="flex justify-between items-end border-b border-brand-charcoal/10 pb-2">
            <h2 class="font-serif text-3xl font-bold text-brand-charcoal">Your courses</h2>
            <span class="text-xs font-bold uppercase tracking-wider text-brand-charcoal/50">{{ $totalEnrolled }} Active</span>
        </div>

        <!-- Course Cards Container -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            
            @forelse($enrolledCourses as $course)
                @php
                    $style = $cardStyles[$course->tag] ?? $cardStyles['universal'];
                @endphp
                <div onclick="window.location='{{ route('courses.show', $course) }}'" class="{{ $style['bg'] }} neo-border neo-shadow rounded-2xl p-6 sm:p-8 flex flex-col justify-between relative overflow-hidden group min-h-[260px] cursor-pointer">
                    <div class="{{ $style['shape'] }}"></div>

                    <div class="space-y-4 relative z-10">
                        <!-- Badges -->
                        <div class="flex justify-between items-center">
                            <span class="px-2.5 py-0.5 text-[9px] font-bold uppercase rounded-md border {{ $style['border'] }} bg-white {{ $style['text'] }}">
                                {{ ucwords(str_replace('_', ' ', $course->tag)) }}
                            </span>
                            <div class="flex gap-1">
                                @foreach($course->langs as $lang)
                                    <span class="w-5 h-5 rounded-full bg-white neo-border-sm text-[9px] flex items-center justify-center font-bold text-brand-charcoal">{{ $lang }}</span>
                                @endforeach
                            </div>
                        </div>

                        <!-- Title -->
                        <div class="space-y-1">
                            <h3 class="font-serif text-2xl font-bold text-brand-charcoal leading-snug group-hover:text-brand-terracotta transition-colors">
                                {{ $course->title }}
                            </h3>
                            @if($course->instructor)
                                <p class="text-xs font-medium text-brand-charcoal/60">By {{ $course->instructor->name }}</p>
                            @endif
                        </div>
                    </div>

                    <!-- Progress Bar & Module Count -->
                    <div class="pt-6 border-t border-brand-charcoal/10 relative z-10">
                        <div class="flex justify-between items-center text-xs font-bold text-brand-charcoal/60 mb-2">
                            <span>{{ $course->contents->count() }} Modules</span>
                            <span>{{ $course->pivot->progress }}%</span>
                        </div>
                        <div class="w-full bg-white neo-border h-3.5 rounded-full p-0.5 overflow-hidden">
                            <div class="{{ $style['bar'] }} h-full rounded-full transition-all duration-500" style="width: {{ $course->pivot->progress }}%;"></div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-2 bg-white border-2 border-dashed border-brand-charcoal/20 rounded-2xl py-12 text-center">
                    <p class="text-sm text-brand-charcoal/50 font-bold uppercase tracking-wider">You are not enrolled in any courses yet.</p>
                </div>
            @endforelse

        </div>
    </div>

    <!-- "PICKED FOR YOU" SECTION -->
    <div id="recommendations" class="space-y-4">
        <!-- Section Header -->
        <div class="flex justify-between items-end border-b border-brand-charcoal/10 pb-2">
            <h2 class="font-serif text-3xl font-bold text-brand-charcoal">Picked for you</h2>
            <span class="text-xs font-bold uppercase tracking-wider text-brand-charcoal/50">{{ $recommendedCourses->count() }} Available</span>
        </div>

        <!-- Recommendations Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            
            @forelse($recommendedCourses as $course)
                @php
                    $style = $cardStyles[$course->tag] ?? $cardStyles['universal'];
                @endphp
                <div onclick="window.location='{{ route('courses.show', $course) }}'" class="{{ $style['bg'] }} neo-border neo-shadow-sm rounded-xl p-5 flex flex-col justify-between hover:translate-y-[-2px] transition-all duration-200 cursor-pointer group relative overflow-hidden">
                    <div class="{{ $style['shape'] }}"></div>
                    <div class="space-y-4 relative z-10">
                        <div class="flex justify-between items-center">
                            <span class="px-2.5 py-0.5 text-[8px] font-bold uppercase rounded-md border {{ $style['border'] }} bg-white {{ $style['text'] }}">
                                {{ ucwords(str_replace('_', ' ', $course->tag)) }}
                            </span>
                            <div class="flex gap-1">
                                @foreach($course->langs as $lang)
                                    <span class="w-4 h-4 rounded-full bg-brand-cream text-[8px] flex items-center justify-center font-bold text-brand-charcoal">{{ $lang }}</span>
                                @endforeach
                            </div>
                        </div>
                        <h3 class="font-serif text-lg font-bold text-brand-charcoal leading-snug group-hover:text-brand-terracotta transition-colors">
                            {{ $course->title }}
                        </h3>
                        @if($course->instructor)
                            <p class="text-[10px] font-medium text-brand-charcoal/50">By {{ $course->instructor->name }}</p>
                        @endif
                    </div>
                    <div class="pt-4 mt-6 border-t border-brand-charcoal/10 flex justify-between items-center text-[10px] font-bold uppercase tracking-wider text-brand-charcoal/50 relative z-10">
                        <span>{{ $course->contents->count() }} Modules</span>
                        <span>{{ number_format($course->students_count) }} Students</span>
                    </div>
                </div>
            @empty
                <div class="col-span-3 bg-white border-2 border-dashed border-brand-charcoal/20 rounded-2xl py-12 text-center">
                    <p class="text-xs text-brand-charcoal/50 font-bold uppercase tracking-wider">No course recommendations available at this time.</p>
                </div>
            @endforelse

        </div>
    </div>

</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // We can hook dynamic client-side translations here if needed, 
        // but the Laravel backend SetLocale middleware is already actively 
        // updating all dates and user model variables upon page load!
        
        // Dynamically adjust top nav indicators based on user's selected preference
        const cultureFrame = '{{ $cultureFrame }}';
        const label = document.getElementById('navCulturalLabel');
        const dot = document.getElementById('navCulturalDot');
        
        if (label && dot) {
            if (cultureFrame === 'yoruba') {
                label.textContent = 'YORUBA FRAMING';
                dot.className = 'inline-block w-2.5 h-2.5 rounded-full bg-culture-yoruba';
            } else if (cultureFrame === 'hausa') {
                label.textContent = 'HAUSA FRAMING';
                dot.className = 'inline-block w-2.5 h-2.5 rounded-full bg-culture-hausa';
            } else if (cultureFrame === 'igbo') {
                label.textContent = 'IGBO FRAMING';
                dot.className = 'inline-block w-2.5 h-2.5 rounded-full bg-culture-igbo';
            } else if (cultureFrame === 'panafrican') {
                label.textContent = 'PAN-AFRICAN FRAMING';
                dot.className = 'inline-block w-2.5 h-2.5 rounded-full bg-culture-panafrican';
            } else {
                label.textContent = 'UNIVERSAL FRAMING';
                dot.className = 'inline-block w-2.5 h-2.5 rounded-full bg-culture-universal';
            }
        }
    });
</script>
@endsection
