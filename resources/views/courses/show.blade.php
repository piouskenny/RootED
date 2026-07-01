@extends('layouts.app')

@section('title', 'RootED — ' . $course->title)

@section('content')
<div class="max-w-7xl mx-auto space-y-8 pb-16">

    {{-- ───────────────── HEADER ───────────────── --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end gap-6 pb-6 border-b border-brand-charcoal/10 relative">
        <div class="space-y-3">
            {{-- Breadcrumb --}}
            <div class="flex items-center gap-2 text-[10px] font-bold text-brand-charcoal/40 uppercase tracking-widest">
                <a href="{{ route('dashboard') }}" class="hover:text-brand-charcoal/70 transition-colors">Dashboard</a>
                <span>/</span>
                <span>Courses</span>
                <span>/</span>
                <span>{{ $course->title }}</span>
            </div>

            <h1 class="font-serif text-4xl sm:text-5xl font-bold tracking-tight text-brand-charcoal leading-none">
                {{ $course->title }}
            </h1>

            <div class="flex items-center gap-3 flex-wrap">
                @php
                    $tagColors = [
                        'yoruba'           => ['border-culture-yoruba/30', 'bg-culture-yoruba-bg', 'text-culture-yoruba'],
                        'hausa'            => ['border-culture-hausa/30', 'bg-culture-hausa-bg', 'text-culture-hausa'],
                        'igbo'             => ['border-culture-igbo/30', 'bg-culture-igbo-bg', 'text-culture-igbo'],
                        'northern_nigeria' => ['border-[#1D70B8]/30', 'bg-[#F0F4F8]', 'text-[#1D70B8]'],
                        'panafrican'       => ['border-culture-panafrican/30', 'bg-culture-panafrican-bg', 'text-culture-panafrican'],
                        'universal'        => ['border-brand-charcoal/20', 'bg-white', 'text-brand-charcoal/60'],
                    ];
                    $tc = $tagColors[$course->tag] ?? $tagColors['universal'];
                    $tagLabel = ucwords(str_replace('_', ' ', $course->tag));
                @endphp

                {{-- Culture Tag --}}
                <span class="inline-flex items-center gap-1.5 px-3 py-1 text-[10px] font-bold uppercase rounded-full border {{ $tc[0] }} {{ $tc[1] }} {{ $tc[2] }}">
                    {{ $tagLabel }}
                </span>

                {{-- Language Badges --}}
                @foreach($course->langs as $lang)
                    <span class="w-7 h-5 rounded-md border border-brand-charcoal/20 text-[9px] flex items-center justify-center font-bold text-brand-charcoal bg-white">{{ $lang }}</span>
                @endforeach
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="flex items-center gap-3 shrink-0">
            <a href="{{ route('dashboard') }}" class="px-5 py-2.5 bg-white border-2 border-brand-charcoal rounded-xl text-xs font-bold uppercase tracking-wider hover:bg-brand-cream/80 active:translate-y-[1px] transition-all shadow-sm">
                &larr; Dashboard
            </a>
            @if(!$isEnrolled)
                <form action="{{ route('courses.enroll', $course) }}" method="POST">
                    @csrf
                    <button type="submit" class="flex items-center gap-2 px-5 py-2.5 bg-brand-terracotta text-white font-bold uppercase tracking-wider rounded-xl neo-border neo-shadow neo-button-hover active:translate-y-[2px] active:shadow-sm transition-all duration-150">
                        <span>Enroll Now</span>
                    </button>
                </form>
            @endif
        </div>
    </div>

    {{-- ───────────────── FLASH MESSAGE ───────────────── --}}
    @if(session('success'))
    <div id="flash-success" class="flex items-center gap-3 bg-[#E2F5EA] border border-[#2B8B5C]/30 text-[#2B8B5C] px-5 py-4 rounded-xl text-sm font-bold shadow-sm">
        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
        {{ session('success') }}
    </div>
    @endif

    {{-- ───────────────── ENROLLMENT BANNER ───────────────── --}}
    @if($isEnrolled)
        <div class="bg-white neo-border neo-shadow-sm rounded-2xl p-6 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="space-y-2 flex-1">
                <div class="flex items-center gap-2">
                    <span class="inline-block w-2.5 h-2.5 rounded-full bg-[#2B8B5C] animate-pulse"></span>
                    <h3 class="font-bold text-sm uppercase tracking-wider text-brand-charcoal/70">You are enrolled in this course</h3>
                </div>
                <p class="text-xs text-brand-charcoal/60 leading-relaxed">
                    Click on any module below to open it and read the content. Tick the checkbox to mark it as complete and track your progress.
                </p>
            </div>

            {{-- Progress Bar --}}
            <div class="w-full md:w-80 space-y-1">
                <div class="flex justify-between items-center text-xs font-bold text-brand-charcoal/60">
                    <span>Your Progress</span>
                    <span>{{ $enrollment->progress }}%</span>
                </div>
                <div class="w-full bg-brand-cream border border-brand-charcoal/20 h-4 rounded-full p-0.5 overflow-hidden">
                    <div class="bg-brand-terracotta h-full rounded-full transition-all duration-500" style="width: {{ $enrollment->progress }}%;"></div>
                </div>
                <p class="text-[10px] text-brand-charcoal/40 font-medium">
                    {{ count($enrollment->completed_contents ?? []) }} of {{ $course->contents->count() }} modules completed
                </p>
            </div>
        </div>
    @else
        <div class="bg-brand-cream neo-border rounded-2xl p-6 sm:p-8 flex flex-col md:flex-row md:items-center justify-between gap-8">
            <div class="space-y-2 max-w-xl">
                <h3 class="font-serif text-xl font-bold text-brand-charcoal">Ready to start learning?</h3>
                <p class="text-xs sm:text-sm text-brand-charcoal/60 leading-relaxed">
                    Enroll now to unlock access to all module resources, track your completion, and personalize your West African cultural learning experience.
                </p>
            </div>
            <form action="{{ route('courses.enroll', $course) }}" method="POST" class="shrink-0">
                @csrf
                <button type="submit" class="w-full sm:w-auto flex items-center justify-center gap-2 px-8 py-3.5 bg-brand-terracotta text-white font-bold uppercase tracking-wider rounded-xl neo-border neo-shadow neo-button-hover active:translate-y-[2px] active:shadow-sm transition-all duration-150">
                    <span>Enroll In Course</span>
                </button>
            </form>
        </div>
    @endif

    {{-- ───────────────── MODULES LIST ───────────────── --}}
    <div id="modules" class="bg-white neo-border neo-shadow rounded-2xl overflow-hidden">
        <div class="bg-brand-cream border-b border-brand-charcoal/10 px-6 py-5 flex justify-between items-center">
            <h2 class="font-serif text-xl font-bold text-brand-charcoal">Course Curriculum</h2>
            <span class="text-[10px] font-bold uppercase tracking-wider text-brand-charcoal/50">{{ $course->contents->count() }} MODULES</span>
        </div>

        @if($course->contents->count() > 0)
            <div class="divide-y divide-brand-charcoal/5">
                @foreach($course->contents->sortBy('created_at') as $index => $module)
                    @php
                        $typeIcons = [
                            'Reading' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253',
                            'Video'   => 'M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z',
                            'PDF'     => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z',
                            'Quiz'    => 'M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
                        ];
                        $ctc = $tagColors[$module->culture_tag] ?? $tagColors['universal'];
                        $ctLabel = ucwords(str_replace('_', ' ', $module->culture_tag));
                        $isCompleted = false;
                        if ($isEnrolled && $enrollment && is_array($enrollment->completed_contents)) {
                            $isCompleted = in_array($module->id, $enrollment->completed_contents);
                        }
                    @endphp

                    <div class="flex items-start gap-4 px-6 py-5 hover:bg-brand-cream/30 transition-colors group {{ $isCompleted ? 'opacity-70' : '' }}">

                        {{-- Step Number / Completion Toggle --}}
                        @if($isEnrolled)
                            <form action="{{ route('courses.modules.toggle', [$course, $module]) }}" method="POST" class="shrink-0 mt-0.5">
                                @csrf
                                <button type="submit"
                                    title="{{ $isCompleted ? 'Mark as incomplete' : 'Mark as complete' }}"
                                    class="w-8 h-8 rounded-full border-2 flex items-center justify-center transition-all shadow-sm hover:scale-105 active:scale-95
                                        {{ $isCompleted ? 'bg-[#2B8B5C] border-[#2B8B5C] text-white' : 'bg-white border-brand-charcoal/25 text-transparent hover:border-brand-charcoal' }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </button>
                            </form>
                        @else
                            <div class="shrink-0 mt-0.5 w-8 h-8 rounded-full bg-brand-charcoal/5 border border-brand-charcoal/15 flex items-center justify-center text-brand-charcoal/40 text-xs font-bold">
                                {{ $index + 1 }}
                            </div>
                        @endif

                        {{-- Module Content --}}
                        <div class="flex-1 min-w-0">
                            {{-- Title row --}}
                            <div class="flex flex-wrap items-center gap-2 mb-1.5">
                                <p class="font-bold text-sm text-brand-charcoal leading-snug {{ $isCompleted ? 'line-through text-brand-charcoal/40' : '' }}">
                                    {{ $module->title }}
                                </p>

                                {{-- Type badge --}}
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[9px] font-bold uppercase bg-brand-charcoal/5 border border-brand-charcoal/10 text-brand-charcoal/60">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $typeIcons[$module->type] ?? $typeIcons['Reading'] }}"/>
                                    </svg>
                                    {{ $module->type }}
                                </span>

                                {{-- Culture tag --}}
                                <span class="px-2 py-0.5 text-[9px] font-bold uppercase rounded border {{ $ctc[0] }} {{ $ctc[1] }} {{ $ctc[2] }}">{{ $ctLabel }}</span>

                                {{-- Language --}}
                                <span class="w-7 h-5 rounded border border-brand-charcoal/20 text-[9px] flex items-center justify-center font-bold text-brand-charcoal bg-white">{{ strtoupper($module->language) }}</span>

                                @if($isCompleted)
                                    <span class="px-2 py-0.5 rounded text-[9px] font-bold uppercase bg-[#E2F5EA] border border-[#2B8B5C]/20 text-[#2B8B5C]">Completed</span>
                                @endif
                            </div>

                            {{-- Body preview --}}
                            @if($module->body)
                                <p class="text-xs leading-relaxed {{ $isCompleted ? 'text-brand-charcoal/30' : 'text-brand-charcoal/50' }} line-clamp-2">
                                    {{ $module->body }}
                                </p>
                            @endif
                        </div>

                        {{-- Open Module Button (enrolled only) --}}
                        @if($isEnrolled)
                            <button
                                onclick="openModule('{{ addslashes($module->title) }}', '{{ addslashes($module->body) }}', '{{ $module->type }}')"
                                class="shrink-0 self-center flex items-center gap-1.5 px-3 py-1.5 border border-brand-charcoal/20 rounded-lg text-xs font-bold bg-white hover:bg-brand-terracotta hover:text-white hover:border-brand-terracotta transition-all duration-150">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Open
                            </button>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <div class="flex flex-col items-center justify-center py-20 gap-4">
                <div class="w-16 h-16 rounded-2xl bg-brand-cream border-2 border-brand-charcoal/10 flex items-center justify-center">
                    <svg class="w-8 h-8 text-brand-charcoal/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                </div>
                <div class="text-center">
                    <p class="font-bold text-sm text-brand-charcoal/60 mb-1">No modules available yet</p>
                    <p class="text-xs text-brand-charcoal/40">This course curriculum is currently being prepared.</p>
                </div>
            </div>
        @endif
    </div>

</div>

{{-- ───────────────── MODULE READER MODAL ───────────────── --}}
<div id="module-modal" class="fixed inset-0 z-50 hidden" aria-modal="true" role="dialog">
    {{-- Backdrop --}}
    <div id="modal-backdrop" class="absolute inset-0 bg-brand-charcoal/60 backdrop-blur-sm" onclick="closeModule()"></div>

    {{-- Panel --}}
    <div class="relative z-10 flex items-center justify-center min-h-screen p-4">
        <div class="bg-white neo-border neo-shadow rounded-2xl w-full max-w-2xl max-h-[85vh] flex flex-col animate-none" id="modal-panel">
            {{-- Modal Header --}}
            <div class="flex items-start justify-between gap-4 px-6 py-5 border-b border-brand-charcoal/10 shrink-0">
                <div class="min-w-0">
                    <p id="modal-type" class="text-[10px] font-bold uppercase tracking-wider text-brand-charcoal/40 mb-1"></p>
                    <h3 id="modal-title" class="font-serif text-xl font-bold text-brand-charcoal leading-snug"></h3>
                </div>
                <button onclick="closeModule()" class="shrink-0 w-8 h-8 rounded-full border border-brand-charcoal/20 flex items-center justify-center text-brand-charcoal/50 hover:bg-brand-cream hover:text-brand-charcoal transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            {{-- Modal Body --}}
            <div class="flex-1 overflow-y-auto px-6 py-6">
                <div id="modal-body" class="prose prose-sm max-w-none text-brand-charcoal/80 leading-relaxed text-sm whitespace-pre-line"></div>
            </div>

            {{-- Modal Footer --}}
            <div class="px-6 py-4 border-t border-brand-charcoal/10 flex justify-end shrink-0">
                <button onclick="closeModule()" class="px-5 py-2 bg-brand-charcoal text-white text-xs font-bold uppercase tracking-wider rounded-lg hover:bg-brand-charcoal/80 transition-colors">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    // Auto-dismiss flash
    var flash = document.getElementById('flash-success');
    if (flash) {
        setTimeout(function() {
            flash.style.transition = 'opacity 0.5s ease';
            flash.style.opacity = '0';
            setTimeout(function() { flash.remove(); }, 500);
        }, 4000);
    }

    // Module reader modal
    function openModule(title, body, type) {
        document.getElementById('modal-title').textContent = title;
        document.getElementById('modal-body').textContent = body || 'No content available for this module yet.';
        document.getElementById('modal-type').textContent = type + ' Module';
        var modal = document.getElementById('module-modal');
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeModule() {
        document.getElementById('module-modal').classList.add('hidden');
        document.body.style.overflow = '';
    }

    // Close on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeModule();
    });
</script>
@endsection
