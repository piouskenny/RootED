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
                        'universal'        => ['border-culture-universal/30', 'bg-culture-universal-bg', 'text-culture-universal'],
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

                {{-- Status Toggle Form --}}
                <form action="{{ route('instructor.courses.toggle-status', $course) }}" method="POST" class="inline-block">
                    @csrf
                    @if($course->status === 'Published')
                        <button type="submit" title="Click to revert to Draft" class="px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider rounded border border-[#2B8B5C]/30 text-[#2B8B5C] bg-[#E2F5EA] hover:bg-[#d4f0df] transition-colors">
                            Published ✓
                        </button>
                    @else
                        <button type="submit" title="Click to Publish Course" class="px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider rounded border border-brand-charcoal/30 text-brand-charcoal bg-brand-charcoal/5 hover:bg-brand-charcoal/10 transition-colors">
                            Draft ⚡
                        </button>
                    @endif
                </form>
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="flex items-center gap-3 shrink-0">
            <a href="{{ route('dashboard') }}" class="px-5 py-2.5 bg-white border-2 border-brand-charcoal rounded-xl text-xs font-bold uppercase tracking-wider hover:bg-brand-cream/80 active:translate-y-[1px] transition-all shadow-sm">
                &larr; Dashboard
            </a>
            <button onclick="openAddModuleModal()" class="flex items-center gap-2 px-5 py-2.5 bg-brand-terracotta text-white font-bold uppercase tracking-wider rounded-xl neo-border neo-shadow neo-button-hover active:translate-y-[2px] active:shadow-sm transition-all duration-150">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                <span>Add Module</span>
            </button>
        </div>
    </div>

    {{-- ───────────────── SUCCESS FLASH ───────────────── --}}
    @if(session('success'))
    <div id="flash-success" class="flex items-center gap-3 bg-[#E2F5EA] border border-[#2B8B5C]/30 text-[#2B8B5C] px-5 py-4 rounded-xl text-sm font-bold">
        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
        {{ session('success') }}
    </div>
    @endif

    {{-- ───────────────── STATS ROW ───────────────── --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
        <div class="bg-white neo-border neo-shadow-sm rounded-xl p-6 hover:-translate-y-1 transition-transform flex flex-col justify-between min-h-[120px]">
            <p class="text-xs font-bold uppercase tracking-wider text-brand-charcoal/50">Modules</p>
            <div>
                <p class="font-serif text-5xl font-bold text-brand-charcoal leading-none mb-1">{{ $course->contents->count() }}</p>
                <p class="text-[10px] font-bold uppercase tracking-widest text-brand-charcoal/60">CONTENT ITEMS</p>
            </div>
        </div>

        <div class="bg-white neo-border neo-shadow-sm rounded-xl p-6 hover:-translate-y-1 transition-transform flex flex-col justify-between min-h-[120px]">
            <p class="text-xs font-bold uppercase tracking-wider text-brand-charcoal/50">Enrolled Students</p>
            <div>
                <p class="font-serif text-5xl font-bold text-brand-charcoal leading-none mb-1">{{ number_format($course->students_count) }}</p>
                <p class="text-[10px] font-bold uppercase tracking-widest text-brand-charcoal/60">LEARNERS</p>
            </div>
        </div>

        <div class="bg-white neo-border neo-shadow-sm rounded-xl p-6 hover:-translate-y-1 transition-transform flex flex-col justify-between min-h-[120px]">
            <p class="text-xs font-bold uppercase tracking-wider text-brand-charcoal/50">Avg. Completion</p>
            <div>
                <p class="font-serif text-5xl font-bold text-brand-charcoal leading-none mb-1">{{ $course->avg_completion }}%</p>
                <p class="text-[10px] font-bold uppercase tracking-widest text-brand-charcoal/60">COURSE PROGRESS</p>
            </div>
        </div>
    </div>

    {{-- ───────────────── MODULES LIST ───────────────── --}}
    <div class="bg-white neo-border neo-shadow rounded-2xl overflow-hidden">
        <div class="bg-brand-cream border-b border-brand-charcoal/10 px-6 py-5 flex justify-between items-center">
            <h2 class="font-serif text-xl font-bold text-brand-charcoal">Course Modules</h2>
            <div class="flex items-center gap-3">
                <span class="text-[10px] font-bold uppercase tracking-wider text-brand-charcoal/50">{{ $course->contents->count() }} MODULES</span>
                <button onclick="openAddModuleModal()" class="px-4 py-1.5 bg-brand-charcoal text-white rounded-lg text-xs font-bold uppercase tracking-wider hover:bg-brand-charcoal/80 transition-colors">
                    + Add Module
                </button>
            </div>
        </div>

        @if($course->contents->count() > 0)
        <div class="divide-y divide-brand-charcoal/5">
            @foreach($course->contents->sortBy('created_at') as $module)
            @php
                $typeIcons = [
                    'Reading' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253',
                    'Video'   => 'M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z',
                    'PDF'     => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z',
                    'Quiz'    => 'M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
                ];
                $ctc = $tagColors[$module->culture_tag] ?? $tagColors['universal'];
                $ctLabel = ucwords(str_replace('_', ' ', $module->culture_tag));
            @endphp
            <div class="flex items-start gap-5 px-6 py-5 hover:bg-brand-cream/30 transition-colors group">
                {{-- Module Number --}}
                <div class="shrink-0 w-9 h-9 rounded-xl bg-brand-cream border-2 border-brand-charcoal/10 flex items-center justify-center font-serif font-bold text-sm text-brand-charcoal/70 group-hover:border-brand-charcoal/30 transition-colors">
                    {{ $loop->iteration }}
                </div>

                {{-- Module Info --}}
                <div class="flex-1 min-w-0">
                    <div class="flex flex-wrap items-center gap-2 mb-1">
                        <p class="font-bold text-sm text-brand-charcoal leading-snug">{{ $module->title }}</p>

                        {{-- Type Badge --}}
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[9px] font-bold uppercase bg-brand-charcoal/5 border border-brand-charcoal/10 text-brand-charcoal/60">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $typeIcons[$module->type] ?? $typeIcons['Reading'] }}" />
                            </svg>
                            {{ $module->type }}
                        </span>

                        {{-- Culture Tag --}}
                        <span class="px-2 py-0.5 text-[9px] font-bold uppercase rounded border {{ $ctc[0] }} {{ $ctc[1] }} {{ $ctc[2] }}">{{ $ctLabel }}</span>

                        {{-- Language --}}
                        <span class="w-7 h-5 rounded border border-brand-charcoal/20 text-[9px] flex items-center justify-center font-bold text-brand-charcoal bg-white">{{ strtoupper($module->language) }}</span>
                    </div>

                    @if($module->body)
                    <p class="text-xs text-brand-charcoal/50 leading-relaxed line-clamp-2">{{ $module->body }}</p>
                    @endif
                </div>

                {{-- Status + Date --}}
                <div class="shrink-0 text-right space-y-1.5 flex flex-col items-end">
                    @if($module->status === 'Published')
                        <span class="block px-2.5 py-1 text-[9px] font-bold uppercase tracking-wider rounded border border-[#2B8B5C]/30 text-[#2B8B5C] bg-[#E2F5EA]">Published</span>
                    @else
                        <span class="block px-2.5 py-1 text-[9px] font-bold uppercase tracking-wider rounded border border-brand-charcoal/20 text-brand-charcoal/60 bg-brand-charcoal/5">Draft</span>
                    @endif
                    <p class="text-[9px] text-brand-charcoal/40 font-medium">{{ $module->created_at->format('d M Y') }}</p>
                    
                    <div class="flex items-center gap-2 mt-2 pt-1">
                        <a href="{{ route('instructor.modules.edit', $module) }}" class="text-[9px] font-bold text-brand-charcoal/60 hover:text-brand-terracotta transition-colors uppercase tracking-wider">
                            Edit
                        </a>
                        <span class="text-brand-charcoal/20 text-[10px] font-medium">|</span>
                        <form action="{{ route('instructor.modules.destroy', $module) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this module?');" class="inline">
                            @csrf
                            <button type="submit" class="text-[9px] font-bold text-red-600/70 hover:text-red-600 transition-colors uppercase tracking-wider cursor-pointer bg-transparent border-0 p-0">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        @else
        {{-- Empty State --}}
        <div class="flex flex-col items-center justify-center py-20 gap-4">
            <div class="w-16 h-16 rounded-2xl bg-brand-cream border-2 border-brand-charcoal/10 flex items-center justify-center">
                <svg class="w-8 h-8 text-brand-charcoal/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
            </div>
            <div class="text-center">
                <p class="font-bold text-sm text-brand-charcoal/60 mb-1">No modules yet</p>
                <p class="text-xs text-brand-charcoal/40">Add your first module to get this course started.</p>
            </div>
            <button onclick="openAddModuleModal()" class="mt-2 flex items-center gap-2 px-5 py-2.5 bg-brand-terracotta text-white font-bold uppercase tracking-wider rounded-xl neo-border neo-shadow neo-button-hover active:translate-y-[2px] transition-all duration-150 text-xs">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                Add First Module
            </button>
        </div>
        @endif
    </div>

</div>


{{-- ═══════════════════ ADD MODULE MODAL ═══════════════════ --}}
<div id="addModuleModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 hidden" aria-modal="true" role="dialog">
    {{-- Backdrop --}}
    <div class="absolute inset-0 bg-brand-charcoal/60 backdrop-blur-sm" onclick="closeAddModuleModal()"></div>

    {{-- Modal Panel --}}
    <div class="relative bg-white neo-border neo-shadow rounded-2xl w-full max-w-[95%] sm:max-w-2xl max-h-[90vh] flex flex-col overflow-hidden">

        {{-- Modal Header --}}
        <div class="bg-brand-cream border-b border-brand-charcoal/10 px-6 py-4 flex justify-between items-center z-10 shrink-0">
            <div>
                <h3 class="font-serif text-xl font-bold text-brand-charcoal">Add Module</h3>
                <p class="text-[10px] font-bold uppercase tracking-wider text-brand-charcoal/50 mt-0.5">{{ $course->title }}</p>
            </div>
            <button onclick="closeAddModuleModal()" class="w-9 h-9 flex items-center justify-center rounded-xl border-2 border-brand-charcoal/20 hover:bg-brand-cream hover:border-brand-charcoal/40 transition-colors">
                <svg class="w-4 h-4 text-brand-charcoal/60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        {{-- Module Form --}}
        <form method="POST" action="{{ route('instructor.courses.modules.store', $course) }}" enctype="multipart/form-data" id="addModuleForm" class="flex flex-col flex-1 overflow-hidden">
            @csrf

            {{-- Scrollable Form Fields --}}
            <div class="flex-1 overflow-y-auto p-6 space-y-5">
                {{-- Validation Errors --}}
                @if($errors->any())
                <div class="bg-red-50 border border-red-200 rounded-xl p-4 space-y-1">
                    @foreach($errors->all() as $error)
                    <p class="text-xs text-red-600 font-medium">{{ $error }}</p>
                    @endforeach
                </div>
                @endif

            {{-- Module Title --}}
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-brand-charcoal/60 mb-2" for="module_title">
                    Module Title <span class="text-brand-terracotta">*</span>
                </label>
                <input type="text" name="title" id="module_title" required
                       value="{{ old('title') }}"
                       placeholder="e.g., Introduction to Yoruba Oral Tradition"
                       class="w-full rounded-xl border-2 border-brand-charcoal p-3.5 bg-white text-sm font-medium text-brand-charcoal placeholder-brand-charcoal/30 focus:outline-none focus:border-brand-terracotta shadow-sm">
            </div>

            {{-- Content Type --}}
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-brand-charcoal/60 mb-3">
                    Content Type <span class="text-brand-terracotta">*</span>
                </label>
                <input type="hidden" name="type" id="modal_type" value="{{ old('type', 'Reading') }}">
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-2.5">
                    @php
                        $contentTypes = [
                            ['Reading', 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253'],
                            ['Video',   'M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z'],
                            ['PDF',     'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                            ['Quiz',    'M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
                        ];
                    @endphp
                    @foreach($contentTypes as [$typeVal, $iconPath])
                    <button type="button" onclick="setModalType('{{ $typeVal }}')" id="modal_type_{{ strtolower($typeVal) }}"
                            class="flex items-center justify-center gap-1.5 py-2.5 px-3.5 rounded-xl border-2 {{ old('type', 'Reading') === $typeVal ? 'border-brand-charcoal bg-brand-charcoal text-white' : 'border-brand-charcoal bg-white text-brand-charcoal hover:bg-brand-cream/50' }} font-bold text-[11px] uppercase tracking-wider transition-all shadow-sm">
                        <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="{{ $iconPath }}" />
                        </svg>
                        <span>{{ $typeVal }}</span>
                    </button>
                    @endforeach
                </div>
            </div>

            {{-- Language + Culture Tag --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-brand-charcoal/60 mb-2" for="modal_language">
                        Language <span class="text-brand-terracotta">*</span>
                    </label>
                    <div class="relative">
                        <select name="language" id="modal_language" required
                                class="w-full rounded-xl border-2 border-brand-charcoal p-3.5 bg-white text-sm font-bold text-brand-charcoal focus:outline-none focus:border-brand-terracotta shadow-sm appearance-none">
                            <option value="en" {{ old('language') == 'en' ? 'selected' : '' }}>EN — English</option>
                            <option value="yo" {{ old('language') == 'yo' ? 'selected' : '' }}>YO — Yoruba</option>
                            <option value="ha" {{ old('language') == 'ha' ? 'selected' : '' }}>HA — Hausa</option>
                            <option value="ig" {{ old('language') == 'ig' ? 'selected' : '' }}>IG — Igbo</option>
                            <option value="fr" {{ old('language') == 'fr' ? 'selected' : '' }}>FR — French</option>
                            <option value="ar" {{ old('language') == 'ar' ? 'selected' : '' }}>AR — Arabic</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-brand-charcoal">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-brand-charcoal/60 mb-2" for="modal_culture_tag">
                        Culture Tag <span class="text-brand-terracotta">*</span>
                    </label>
                    <div class="relative">
                        <select name="culture_tag" id="modal_culture_tag" required
                                class="w-full rounded-xl border-2 border-brand-charcoal p-3.5 bg-white text-sm font-bold text-brand-charcoal focus:outline-none focus:border-brand-terracotta shadow-sm appearance-none">
                            <option value="yoruba"           {{ old('culture_tag') == 'yoruba'           ? 'selected' : '' }}>Yoruba</option>
                            <option value="hausa"            {{ old('culture_tag') == 'hausa'            ? 'selected' : '' }}>Hausa</option>
                            <option value="igbo"             {{ old('culture_tag') == 'igbo'             ? 'selected' : '' }}>Igbo</option>
                            <option value="northern_nigeria" {{ old('culture_tag') == 'northern_nigeria' ? 'selected' : '' }}>Northern Nigeria</option>
                            <option value="panafrican"       {{ old('culture_tag') == 'panafrican'       ? 'selected' : '' }}>Pan-African</option>
                            <option value="universal"        {{ old('culture_tag') == 'universal'        ? 'selected' : '' }}>Universal</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-brand-charcoal">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Publishing Status --}}
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-brand-charcoal/60 mb-2">
                    Publishing Status
                </label>
                <input type="hidden" name="status" id="modal_status" value="{{ old('status', 'Draft') }}">
                <div class="flex p-1 bg-brand-cream border-2 border-brand-charcoal rounded-xl relative shadow-sm h-[52px] items-center">
                    <button type="button" onclick="setModalStatus('Draft')" id="modal_status_draft"
                            class="flex-1 py-2 text-xs font-bold rounded-lg {{ old('status', 'Draft') === 'Draft' ? 'bg-brand-charcoal text-white border border-brand-charcoal' : 'text-brand-charcoal/60 hover:bg-brand-charcoal/5' }} transition-all">
                        Draft
                    </button>
                    <button type="button" onclick="setModalStatus('Published')" id="modal_status_published"
                            class="flex-1 py-2 text-xs font-bold rounded-lg {{ old('status') === 'Published' ? 'bg-brand-charcoal text-white border border-brand-charcoal' : 'text-brand-charcoal/60 hover:bg-brand-charcoal/5' }} transition-all">
                        Published
                    </button>
                </div>
            </div>

            {{-- Body / Description --}}
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-brand-charcoal/60 mb-2" for="modal_body">
                    Description / Body
                </label>
                <textarea name="body" id="modal_body" rows="4"
                          placeholder="Write a description or the full body of this module..."
                          class="w-full rounded-xl border-2 border-brand-charcoal p-3.5 bg-white text-sm font-medium text-brand-charcoal placeholder-brand-charcoal/30 focus:outline-none focus:border-brand-terracotta shadow-sm resize-none leading-relaxed">{{ old('body') }}</textarea>
            </div>

            {{-- File Upload --}}
            <div id="modal_file_area" class="hidden">
                <label class="block text-xs font-bold uppercase tracking-wider text-brand-charcoal/60 mb-2" for="modal_file">
                    Upload File
                </label>
                <label for="modal_file" class="flex flex-col items-center justify-center gap-3 w-full h-32 border-2 border-dashed border-brand-charcoal/30 rounded-xl bg-brand-cream/50 hover:bg-brand-cream cursor-pointer transition-colors">
                    <svg class="w-8 h-8 text-brand-charcoal/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                    </svg>
                    <span class="text-xs font-bold text-brand-charcoal/50 uppercase tracking-wider">Click to upload PDF or video</span>
                    <input type="file" name="file" id="modal_file" class="hidden" accept=".pdf,.mp4,.mov,.avi">
                </label>
                <p id="modal_file_name" class="mt-2 text-xs font-medium text-brand-charcoal/50 hidden"></p>
            </div>

            {{-- Submit Row --}}
            <div class="flex items-center justify-end gap-3 px-6 py-4 border-t border-brand-charcoal/10 bg-brand-cream/40 shrink-0">
                <button type="button" onclick="closeAddModuleModal()"
                        class="px-5 py-2.5 bg-white border-2 border-brand-charcoal/20 rounded-xl text-xs font-bold uppercase tracking-wider hover:bg-brand-cream hover:border-brand-charcoal/40 transition-all">
                    Cancel
                </button>
                <button type="submit"
                        class="flex items-center gap-2 px-6 py-2.5 bg-brand-terracotta text-white font-bold uppercase tracking-wider rounded-xl neo-border neo-shadow neo-button-hover active:translate-y-[2px] active:shadow-sm transition-all duration-150 text-xs">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Save Module
                </button>
            </div>
        </form>
    </div>
</div>


@section('scripts')
<script>
    // Modal open / close
    const modal = document.getElementById('addModuleModal');

    function openAddModuleModal() {
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeAddModuleModal() {
        modal.classList.add('hidden');
        document.body.style.overflow = '';
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeAddModuleModal();
    });

    // Content Type Toggle
    const allTypes = ['reading', 'video', 'pdf', 'quiz'];
    const fileArea = document.getElementById('modal_file_area');

    function setModalType(type) {
        document.getElementById('modal_type').value = type;

        allTypes.forEach(function(t) {
            var btn = document.getElementById('modal_type_' + t);
            if (!btn) return;
            var isActive = (t === type.toLowerCase());
            btn.classList.remove('bg-brand-charcoal', 'text-white', 'bg-white', 'text-brand-charcoal', 'hover:bg-brand-cream/50');
            if (isActive) {
                btn.classList.add('bg-brand-charcoal', 'text-white');
            } else {
                btn.classList.add('bg-white', 'text-brand-charcoal', 'hover:bg-brand-cream/50');
            }
        });

        fileArea.classList.toggle('hidden', !['PDF', 'Video'].includes(type));
    }

    // Status Toggle
    function setModalStatus(status) {
        document.getElementById('modal_status').value = status;

        var draftBtn   = document.getElementById('modal_status_draft');
        var publishBtn = document.getElementById('modal_status_published');

        [draftBtn, publishBtn].forEach(function(btn) {
            btn.classList.remove('bg-brand-charcoal', 'text-white', 'border', 'border-brand-charcoal', 'text-brand-charcoal/60', 'hover:bg-brand-charcoal/5');
        });

        if (status === 'Draft') {
            draftBtn.classList.add('bg-brand-charcoal', 'text-white', 'border', 'border-brand-charcoal');
            publishBtn.classList.add('text-brand-charcoal/60', 'hover:bg-brand-charcoal/5');
        } else {
            publishBtn.classList.add('bg-brand-charcoal', 'text-white', 'border', 'border-brand-charcoal');
            draftBtn.classList.add('text-brand-charcoal/60', 'hover:bg-brand-charcoal/5');
        }
    }

    // File name display
    var fileInput = document.getElementById('modal_file');
    var fileLabel = document.getElementById('modal_file_name');
    if (fileInput) {
        fileInput.addEventListener('change', function() {
            if (this.files.length > 0) {
                fileLabel.textContent = this.files[0].name;
                fileLabel.classList.remove('hidden');
            } else {
                fileLabel.classList.add('hidden');
            }
        });
    }

    // Auto-open modal on validation errors
    @if($errors->any())
    openAddModuleModal();
    @endif

    // Auto-dismiss flash
    var flash = document.getElementById('flash-success');
    if (flash) {
        setTimeout(function() {
            flash.style.transition = 'opacity 0.5s ease';
            flash.style.opacity = '0';
            setTimeout(function() { flash.remove(); }, 500);
        }, 4000);
    }
</script>
@endsection

@endsection
