@extends('layouts.app')

@section('title', 'RootED — Content Editor')

@section('content')
<div class="max-w-7xl mx-auto space-y-8 pb-16">

    <!-- HEADER / NAVIGATION ACCENT -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end gap-6 pb-6 border-b border-brand-charcoal/10 relative">
        <div class="space-y-3">
            <div class="flex items-center gap-2 text-[10px] font-bold text-brand-charcoal/40 uppercase tracking-widest">
                <span class="inline-block w-1.5 h-1.5 rounded-full bg-brand-charcoal/40"></span>
                <span>New Content Item &bull; Module 1 &bull; Yoruba Oral Literature</span>
            </div>
            <h1 class="font-serif text-4xl sm:text-5xl font-bold tracking-tight text-brand-charcoal leading-none">
                Content editor
            </h1>
        </div>
        <div>
            <a href="/dashboard" class="px-5 py-2.5 bg-white border-2 border-brand-charcoal rounded-xl text-xs font-bold uppercase tracking-wider hover:bg-brand-cream/80 active:translate-y-[1px] transition-all shadow-sm">
                &larr; Back to Dashboard
            </a>
        </div>
    </div>

    <!-- MAIN FORM WRAPPER -->
    <form method="POST" action="{{ route('instructor.content.store') }}" enctype="multipart/form-data" id="contentEditorForm" class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
        @csrf

        <!-- LEFT: MAIN EDITOR (Takes 2 Columns) -->
        <div class="lg:col-span-2 space-y-6">

            <!-- SELECT COURSE & STATUS CARD -->
            <div class="bg-white neo-border neo-shadow-sm rounded-xl p-6 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Course Selector -->
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-brand-charcoal/60 mb-2" for="course_id">
                            Course Association
                        </label>
                        <div class="relative">
                            <select name="course_id" id="course_id" required
                                    class="w-full rounded-xl border-2 border-brand-charcoal p-3.5 bg-white text-sm font-bold text-brand-charcoal focus:outline-none focus:border-brand-terracotta shadow-sm appearance-none">
                                <option value="" disabled selected>-- Choose a course --</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}">{{ $course->title }}</option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-brand-charcoal">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                            </div>
                        </div>
                    </div>

                    <!-- Status Selector -->
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-brand-charcoal/60 mb-2" for="status_btn_group">
                            Publishing Status
                        </label>
                        <input type="hidden" name="status" id="status" value="Draft">
                        <div class="flex p-1 bg-brand-cream border-2 border-brand-charcoal rounded-xl relative shadow-sm h-[52px] items-center" id="status_btn_group">
                            <button type="button" onclick="setStatus('Draft')" id="status_draft"
                                    class="flex-1 py-2 text-xs font-bold rounded-lg bg-brand-charcoal text-white border border-brand-charcoal transition-all">
                                Draft
                            </button>
                            <button type="button" onclick="setStatus('Published')" id="status_published"
                                    class="flex-1 py-2 text-xs font-bold rounded-lg text-brand-charcoal/60 hover:bg-brand-charcoal/5 transition-all">
                                Published
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CONTENT TYPE SEGMENTED BUTTONS -->
            <div class="bg-white neo-border neo-shadow-sm rounded-xl p-6 space-y-4">
                <label class="block text-xs font-bold uppercase tracking-wider text-brand-charcoal/60">
                    Type
                </label>
                <input type="hidden" name="type" id="type" value="Reading">
                
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                    <!-- Reading Option -->
                    <button type="button" onclick="setContentType('Reading')" id="type_reading"
                            class="flex items-center justify-center gap-2 py-3 px-4 rounded-xl border-2 border-brand-charcoal bg-brand-charcoal text-white font-bold text-xs uppercase tracking-wider transition-all shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                        <span>Reading</span>
                    </button>

                    <!-- Video Option -->
                    <button type="button" onclick="setContentType('Video')" id="type_video"
                            class="flex items-center justify-center gap-2 py-3 px-4 rounded-xl border-2 border-brand-charcoal bg-white text-brand-charcoal hover:bg-brand-cream/50 font-bold text-xs uppercase tracking-wider transition-all shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" /></svg>
                        <span>Video</span>
                    </button>

                    <!-- PDF Option -->
                    <button type="button" onclick="setContentType('PDF')" id="type_pdf"
                            class="flex items-center justify-center gap-2 py-3 px-4 rounded-xl border-2 border-brand-charcoal bg-white text-brand-charcoal hover:bg-brand-cream/50 font-bold text-xs uppercase tracking-wider transition-all shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                        <span>PDF</span>
                    </button>

                    <!-- Quiz Option -->
                    <button type="button" onclick="setContentType('Quiz')" id="type_quiz"
                            class="flex items-center justify-center gap-2 py-3 px-4 rounded-xl border-2 border-brand-charcoal bg-white text-brand-charcoal hover:bg-brand-cream/50 font-bold text-xs uppercase tracking-wider transition-all shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <span>Quiz</span>
                    </button>
                </div>
            </div>

            <!-- TITLE & BODY INPUT CARD -->
            <div class="bg-white neo-border neo-shadow rounded-xl p-6 space-y-6">
                <!-- Title Field -->
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-brand-charcoal/60 mb-2" for="title">
                        Title
                    </label>
                    <input type="text" name="title" id="title" required oninput="updateLivePreview()"
                           class="w-full rounded-xl border-2 border-brand-charcoal p-3.5 bg-white font-sans text-brand-charcoal focus:outline-none focus:border-brand-terracotta transition-colors shadow-sm text-sm" 
                           placeholder="e.g. Origins of Ìjálá: the hunter's voice">
                </div>

                <!-- Body Text Area (Reading & Quiz) -->
                <div id="bodyInputContainer">
                    <label class="block text-xs font-bold uppercase tracking-wider text-brand-charcoal/60 mb-2" id="bodyLabel" for="body">
                        Body
                    </label>
                    <textarea name="body" id="body" rows="9" oninput="updateLivePreview()"
                              class="w-full rounded-xl border-2 border-brand-charcoal p-4 bg-white font-sans text-brand-charcoal focus:outline-none focus:border-brand-terracotta transition-colors shadow-sm text-sm" 
                              placeholder="Ìjálá is a chanted form of Yoruba poetry traditionally performed by hunters in praise of the deity Ògún..."></textarea>
                    
                    <div class="flex justify-between items-center mt-2 px-1">
                        <span class="text-[10px] font-bold text-brand-charcoal/40 uppercase tracking-wider" id="charCountLabel">
                            MARKDOWN SUPPORTED &bull; <span id="charCount">0</span> CHARS
                        </span>
                        <span class="text-[10px] font-bold text-brand-charcoal/40 uppercase tracking-wider">
                            AUTO-SAVED 12S AGO
                        </span>
                    </div>
                </div>

                <!-- File Upload Container (Video & PDF) -->
                <div id="fileUploadContainer" class="hidden space-y-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-brand-charcoal/60 mb-1" id="fileLabel">
                        Upload File
                    </label>
                    <div onclick="document.getElementById('file').click()"
                         class="border-2 border-dashed border-brand-charcoal/20 rounded-xl p-8 bg-brand-cream/20 text-center flex flex-col items-center justify-center gap-3 cursor-pointer hover:border-brand-terracotta transition-colors group">
                        <div class="w-12 h-12 rounded-full bg-white neo-border flex items-center justify-center text-brand-charcoal group-hover:scale-105 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" /></svg>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-brand-charcoal uppercase tracking-wider">Drag & drop your file here</p>
                            <p class="text-[10px] text-brand-charcoal/50 mt-1 uppercase font-semibold" id="fileHelpText">PDF or MP4 formats up to 20MB</p>
                        </div>
                        <span class="px-3 py-1.5 bg-white border border-brand-charcoal text-[9px] font-bold uppercase rounded-lg shadow-sm" id="fileSelectBtn">
                            Browse Files
                        </span>
                        <span class="text-xs font-bold text-brand-terracotta hidden" id="fileNameDisplay"></span>
                    </div>
                    <input type="file" name="file" id="file" class="hidden" onchange="handleFileSelected(this)" accept="video/*,application/pdf">
                </div>
            </div>

            <!-- DECORATIVE / SUBMIT BUTTONS BAR -->
            <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                <div class="flex items-center gap-3 w-full sm:w-auto">
                    <button type="button" class="flex-1 sm:flex-initial px-4 py-2.5 border-2 border-brand-charcoal/20 hover:border-brand-charcoal/50 rounded-xl text-xs font-bold text-brand-charcoal bg-white shadow-sm transition-colors">
                        + Add cultural note
                    </button>
                    <button type="button" class="flex-1 sm:flex-initial px-4 py-2.5 border-2 border-brand-charcoal/20 hover:border-brand-charcoal/50 rounded-xl text-xs font-bold text-brand-charcoal bg-white shadow-sm transition-colors">
                        + Add example
                    </button>
                </div>
                
                <button type="submit" class="w-full sm:w-auto px-6 py-3 bg-brand-terracotta text-white font-bold uppercase tracking-wider rounded-xl neo-border neo-shadow neo-button-hover active:translate-y-[2px] active:shadow-sm transition-all duration-150 text-xs">
                    Save Content Item
                </button>
            </div>

        </div>

        <!-- RIGHT: SIDEBAR LOCALIZATION & PREVIEWS (Takes 1 Column) -->
        <div class="lg:col-span-1 space-y-6">

            <!-- LOCALIZATION PANEL -->
            <div class="bg-white neo-border neo-shadow-sm rounded-xl p-6 space-y-6">
                <div>
                    <h3 class="text-2xs font-bold uppercase tracking-wider text-brand-charcoal/40 mb-4">Localization</h3>
                    
                    <!-- Language Selection -->
                    <label class="block text-xs font-bold uppercase tracking-wider text-brand-charcoal/60 mb-2" for="language">
                        Language
                    </label>
                    <div class="relative">
                        <select name="language" id="language" onchange="updateLivePreview()"
                                class="w-full rounded-xl border-2 border-brand-charcoal p-3 bg-white text-xs font-bold uppercase tracking-wider focus:outline-none focus:border-brand-terracotta shadow-sm appearance-none">
                            <option value="en" selected>English (EN)</option>
                            <option value="yo">Yorùbá (YO)</option>
                            <option value="ha">Hausa (HA)</option>
                            <option value="ig">Igbo (IG)</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-brand-charcoal">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                        </div>
                    </div>
                </div>

                <!-- Culture Tag Selection -->
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-brand-charcoal/60 mb-3">
                        Culture tag
                    </label>
                    
                    <input type="hidden" name="culture_tag" id="culture_tag" value="universal">
                    
                    <div class="flex flex-col gap-2.5">
                        <!-- Yoruba -->
                        <button type="button" onclick="setCultureTag('yoruba')" id="tag_yoruba"
                                class="flex items-center justify-between px-4 py-2.5 rounded-xl border-2 border-culture-yoruba/30 bg-culture-yoruba-bg/50 text-culture-yoruba text-2xs font-bold uppercase tracking-wider transition-all hover:bg-culture-yoruba-bg">
                            <span class="flex items-center gap-2">
                                <span class="w-2.5 h-2.5 bg-culture-yoruba rotate-45 inline-block"></span>
                                Yoruba
                            </span>
                            <span class="w-3.5 h-3.5 rounded-full border-2 border-culture-yoruba/40 flex items-center justify-center" id="indicator_yoruba"></span>
                        </button>

                        <!-- Hausa -->
                        <button type="button" onclick="setCultureTag('hausa')" id="tag_hausa"
                                class="flex items-center justify-between px-4 py-2.5 rounded-xl border-2 border-culture-hausa/30 bg-culture-hausa-bg/50 text-culture-hausa text-2xs font-bold uppercase tracking-wider transition-all hover:bg-culture-hausa-bg">
                            <span class="flex items-center gap-2">
                                <span class="w-2.5 h-2.5 bg-culture-hausa inline-block"></span>
                                Hausa
                            </span>
                            <span class="w-3.5 h-3.5 rounded-full border-2 border-culture-hausa/40 flex items-center justify-center" id="indicator_hausa"></span>
                        </button>

                        <!-- Igbo -->
                        <button type="button" onclick="setCultureTag('igbo')" id="tag_igbo"
                                class="flex items-center justify-between px-4 py-2.5 rounded-xl border-2 border-culture-igbo/30 bg-culture-igbo-bg/50 text-culture-igbo text-2xs font-bold uppercase tracking-wider transition-all hover:bg-culture-igbo-bg">
                            <span class="flex items-center gap-2">
                                <span class="w-2.5 h-2.5 border border-culture-igbo rounded-full inline-block"></span>
                                Igbo
                            </span>
                            <span class="w-3.5 h-3.5 rounded-full border-2 border-culture-igbo/40 flex items-center justify-center" id="indicator_igbo"></span>
                        </button>

                        <!-- Northern Nigeria -->
                        <button type="button" onclick="setCultureTag('northern_nigeria')" id="tag_northern_nigeria"
                                class="flex items-center justify-between px-4 py-2.5 rounded-xl border-2 border-[#1D70B8]/30 bg-[#F0F4F8] text-[#1D70B8] text-2xs font-bold uppercase tracking-wider transition-all hover:bg-[#E1EBF5]">
                            <span class="flex items-center gap-2">
                                <span class="w-2.5 h-2.5 bg-[#1D70B8] rotate-45 inline-block"></span>
                                Northern Nigeria
                            </span>
                            <span class="w-3.5 h-3.5 rounded-full border-2 border-[#1D70B8]/40 flex items-center justify-center" id="indicator_northern_nigeria"></span>
                        </button>

                        <!-- Pan-African -->
                        <button type="button" onclick="setCultureTag('panafrican')" id="tag_panafrican"
                                class="flex items-center justify-between px-4 py-2.5 rounded-xl border-2 border-culture-panafrican/30 bg-culture-panafrican-bg/50 text-culture-panafrican text-2xs font-bold uppercase tracking-wider transition-all hover:bg-culture-panafrican-bg">
                            <span class="flex items-center gap-2">
                                <span class="w-2.5 h-2.5 bg-culture-panafrican rounded-full inline-block"></span>
                                Pan-African
                            </span>
                            <span class="w-3.5 h-3.5 rounded-full border-2 border-culture-panafrican/40 flex items-center justify-center" id="indicator_panafrican"></span>
                        </button>

                        <!-- Universal -->
                        <button type="button" onclick="setCultureTag('universal')" id="tag_universal"
                                class="flex items-center justify-between px-4 py-2.5 rounded-xl border-2 border-brand-charcoal/20 bg-brand-cream text-brand-charcoal text-2xs font-bold uppercase tracking-wider transition-all hover:bg-brand-charcoal/5">
                            <span class="flex items-center gap-2">
                                <span class="w-2.5 h-2.5 border border-brand-charcoal rounded-sm inline-block"></span>
                                Universal
                            </span>
                            <span class="w-3.5 h-3.5 rounded-full border-2 border-brand-charcoal/30 flex items-center justify-center" id="indicator_universal"></span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- PREVIEW AS LEARNER PANEL -->
            <div class="bg-white neo-border neo-shadow-sm rounded-xl p-6">
                <h3 class="text-2xs font-bold uppercase tracking-wider text-brand-charcoal/40 mb-4">Preview as learner</h3>
                
                <!-- Inner Preview Card -->
                <div class="neo-border rounded-xl p-4 bg-brand-cream/50 min-h-[140px] relative overflow-hidden flex flex-col justify-between">
                    <!-- Card Top Header -->
                    <div class="flex items-center justify-between gap-2 border-b border-brand-charcoal/5 pb-2">
                        <!-- Culture Badge -->
                        <span id="previewTagBadge" class="inline-flex items-center gap-1 px-2.5 py-0.5 text-[8px] font-bold uppercase rounded-full border border-culture-universal/30 bg-culture-universal-bg text-culture-universal">
                            <span class="w-1 h-1 border border-culture-universal rounded-sm inline-block" id="previewBadgeDot"></span>
                            <span id="previewBadgeText">Universal</span>
                        </span>
                        
                        <!-- Language Badge -->
                        <span id="previewLangBadge" class="w-6 h-4.5 rounded border border-brand-charcoal/20 text-[8px] flex items-center justify-center font-bold text-brand-charcoal bg-white uppercase">
                            EN
                        </span>
                    </div>

                    <!-- Card Body -->
                    <div class="flex-grow my-4">
                        <h4 id="previewTitle" class="font-serif text-base font-bold text-brand-charcoal leading-snug">
                            Origins of Ìjálá: the hunter's voice
                        </h4>
                        <p id="previewBody" class="text-[10px] text-brand-charcoal/70 mt-1.5 leading-relaxed line-clamp-4">
                            Ìjálá is a chanted form of Yoruba poetry traditionally performed by hunters in praise of the deity Ògún.
                        </p>
                    </div>
                </div>
            </div>

            <!-- VISIBILITY CHECK PANEL -->
            <div class="bg-white neo-border neo-shadow-sm rounded-xl p-6 space-y-4">
                <h3 class="text-2xs font-bold uppercase tracking-wider text-brand-charcoal/40 mb-2">Visibility check</h3>
                
                <div class="space-y-3.5 text-2xs font-bold text-brand-charcoal">
                    <!-- Reach Criteria -->
                    <div class="flex items-start gap-2.5" id="criteria_reach">
                        <span class="text-emerald-600 text-sm leading-none" id="reach_icon">✓</span>
                        <p class="leading-relaxed" id="reach_text">
                            Will reach all 2,311 enrolled students
                        </p>
                    </div>

                    <!-- Fallback Criteria -->
                    <div class="flex items-start gap-2.5">
                        <span class="text-emerald-600 text-sm leading-none">✓</span>
                        <p class="leading-relaxed">
                            Universal fallback enabled
                        </p>
                    </div>

                    <!-- Warning Criteria -->
                    <div class="flex items-start gap-2.5" id="criteria_warning">
                        <span class="text-red-500 text-sm leading-none" id="warning_icon">✗</span>
                        <p class="leading-relaxed text-brand-charcoal/60" id="warning_text">
                            Will reach all learners across culture tags
                        </p>
                    </div>
                </div>
            </div>

        </div>

    </form>
</div>
@endsection

@section('scripts')
<script>
    // Visibility database (mock student preferences)
    const visibilityData = {
        yoruba: {
            reach: 247,
            name: "Yoruba",
            warning: "Hausa",
            warningText: "Will not reach Hausa-only learners"
        },
        hausa: {
            reach: 412,
            name: "Hausa",
            warning: "Yoruba",
            warningText: "Will not reach Yoruba-only learners"
        },
        igbo: {
            reach: 1184,
            name: "Igbo",
            warning: "Hausa",
            warningText: "Will not reach Hausa-only learners"
        },
        northern_nigeria: {
            reach: 156,
            name: "Northern Nigeria",
            warning: "Yoruba",
            warningText: "Will not reach Yoruba-only learners"
        },
        panafrican: {
            reach: 318,
            name: "Pan-African",
            warning: "Hausa",
            warningText: "Will not reach Hausa-only learners"
        },
        universal: {
            reach: 2311,
            name: "Universal",
            warning: "None",
            warningText: "Will reach all learners across culture tags"
        }
    };

    // Style configuration mapping for dynamic UI rendering
    const cultureStyleConfig = {
        yoruba: {
            badgeClass: "border-culture-yoruba/30 bg-culture-yoruba-bg text-culture-yoruba",
            dotClass: "w-1 h-1 bg-culture-yoruba rotate-45 inline-block"
        },
        hausa: {
            badgeClass: "border-culture-hausa/30 bg-culture-hausa-bg text-culture-hausa",
            dotClass: "w-1 h-1 bg-culture-hausa inline-block"
        },
        igbo: {
            badgeClass: "border-culture-igbo/30 bg-culture-igbo-bg text-culture-igbo",
            dotClass: "w-1.5 h-1.5 border border-culture-igbo rounded-full inline-block"
        },
        northern_nigeria: {
            badgeClass: "border-[#1D70B8]/30 bg-[#F0F4F8] text-[#1D70B8]",
            dotClass: "w-1 h-1 bg-[#1D70B8] rotate-45 inline-block"
        },
        panafrican: {
            badgeClass: "border-culture-panafrican/30 bg-culture-panafrican-bg text-culture-panafrican",
            dotClass: "w-1 h-1 bg-culture-panafrican rounded-full inline-block"
        },
        universal: {
            badgeClass: "border-culture-universal/30 bg-culture-universal-bg text-culture-universal",
            dotClass: "w-1 h-1 border border-culture-universal rounded-sm inline-block"
        }
    };

    function setContentType(type) {
        document.getElementById('type').value = type;

        // Reset button stylings
        ['Reading', 'Video', 'PDF', 'Quiz'].forEach(t => {
            const btn = document.getElementById(`type_${t.toLowerCase()}`);
            if (t === type) {
                btn.classList.remove('bg-white', 'text-brand-charcoal', 'hover:bg-brand-cream/50');
                btn.classList.add('bg-brand-charcoal', 'text-white');
            } else {
                btn.classList.remove('bg-brand-charcoal', 'text-white');
                btn.classList.add('bg-white', 'text-brand-charcoal', 'hover:bg-brand-cream/50');
            }
        });

        // Toggle file upload container
        const fileContainer = document.getElementById('fileUploadContainer');
        const bodyContainer = document.getElementById('bodyInputContainer');
        const fileInput = document.getElementById('file');
        
        if (type === 'Video' || type === 'PDF') {
            fileContainer.classList.remove('hidden');
            bodyContainer.classList.add('hidden');
            fileInput.required = true;
            
            // Adjust file acceptance filters
            if (type === 'Video') {
                fileInput.accept = "video/*";
                document.getElementById('fileHelpText').innerText = "MP4, MOV or AVI formats up to 20MB";
            } else {
                fileInput.accept = "application/pdf";
                document.getElementById('fileHelpText').innerText = "PDF document up to 10MB";
            }
        } else {
            fileContainer.classList.add('hidden');
            bodyContainer.classList.remove('hidden');
            fileInput.required = false;
            
            if (type === 'Quiz') {
                document.getElementById('bodyLabel').innerText = "Quiz Content (Questions, Answers)";
                document.getElementById('charCountLabel').innerHTML = "JSON/Text format supported";
            } else {
                document.getElementById('bodyLabel').innerText = "Body";
                document.getElementById('charCountLabel').innerHTML = "MARKDOWN SUPPORTED &bull; <span id=\"charCount\">0</span> CHARS";
            }
        }
        
        updateLivePreview();
    }

    function setStatus(status) {
        document.getElementById('status').value = status;

        const draftBtn = document.getElementById('status_draft');
        const publishedBtn = document.getElementById('status_published');

        if (status === 'Draft') {
            draftBtn.className = "flex-1 py-2 text-xs font-bold rounded-lg bg-brand-charcoal text-white border border-brand-charcoal transition-all";
            publishedBtn.className = "flex-1 py-2 text-xs font-bold rounded-lg text-brand-charcoal/60 hover:bg-brand-charcoal/5 transition-all";
        } else {
            publishedBtn.className = "flex-1 py-2 text-xs font-bold rounded-lg bg-brand-charcoal text-white border border-brand-charcoal transition-all";
            draftBtn.className = "flex-1 py-2 text-xs font-bold rounded-lg text-brand-charcoal/60 hover:bg-brand-charcoal/5 transition-all";
        }
    }

    function setCultureTag(tag) {
        document.getElementById('culture_tag').value = tag;

        // Reset indicators and highlight
        const tags = ['yoruba', 'hausa', 'igbo', 'northern_nigeria', 'panafrican', 'universal'];
        tags.forEach(t => {
            const btn = document.getElementById(`tag_${t}`);
            const ind = document.getElementById(`indicator_${t}`);
            
            if (t === tag) {
                btn.style.borderWidth = '2px';
                btn.classList.add('neo-shadow-sm');
                ind.innerHTML = '<span class="w-1.5 h-1.5 rounded-full bg-current"></span>';
            } else {
                btn.style.borderWidth = '2px';
                btn.classList.remove('neo-shadow-sm');
                ind.innerHTML = '';
            }
        });

        // Update Visibility Panel
        const vData = visibilityData[tag];
        const reachText = document.getElementById('reach_text');
        const warningText = document.getElementById('warning_text');
        const warningIcon = document.getElementById('warning_icon');
        const criteriaWarning = document.getElementById('criteria_warning');
        
        if (tag === 'universal') {
            reachText.innerHTML = `Will reach all 2,311 enrolled students`;
            warningText.innerHTML = `Will reach all learners across culture tags`;
            warningText.className = "leading-relaxed text-brand-charcoal/60";
            warningIcon.innerText = "✓";
            warningIcon.className = "text-emerald-600 text-sm leading-none";
        } else {
            reachText.innerHTML = `Will reach ${vData.reach} students with ${vData.name} preference`;
            warningText.innerHTML = vData.warningText;
            warningText.className = "leading-relaxed text-brand-charcoal/60 font-semibold";
            warningIcon.innerText = "✗";
            warningIcon.className = "text-red-500 text-sm leading-none";
        }

        updateLivePreview();
    }

    function handleFileSelected(input) {
        const display = document.getElementById('fileNameDisplay');
        const btn = document.getElementById('fileSelectBtn');
        if (input.files && input.files[0]) {
            display.innerText = `Selected file: ${input.files[0].name}`;
            display.classList.remove('hidden');
            btn.innerText = "Change File";
        } else {
            display.innerText = '';
            display.classList.add('hidden');
            btn.innerText = "Browse Files";
        }
        updateLivePreview();
    }

    function updateLivePreview() {
        const titleVal = document.getElementById('title').value || "Untitled Content";
        const bodyVal = document.getElementById('body').value || "No content written yet...";
        const tagVal = document.getElementById('culture_tag').value;
        const langVal = document.getElementById('language').value;
        const typeVal = document.getElementById('type').value;

        // Character count
        document.getElementById('charCount').innerText = bodyVal.length;

        // Preview Title and Body
        document.getElementById('previewTitle').innerText = titleVal;
        
        const previewBody = document.getElementById('previewBody');
        if (typeVal === 'Video') {
            const fileInput = document.getElementById('file');
            const hasFile = fileInput.files && fileInput.files[0];
            previewBody.innerHTML = `<span class="italic text-brand-charcoal/50">Media Content: Video Player Preview<br>(${hasFile ? fileInput.files[0].name : "No video file uploaded"})</span>`;
        } else if (typeVal === 'PDF') {
            const fileInput = document.getElementById('file');
            const hasFile = fileInput.files && fileInput.files[0];
            previewBody.innerHTML = `<span class="italic text-brand-charcoal/50">Media Content: PDF Reader Preview<br>(${hasFile ? fileInput.files[0].name : "No PDF file uploaded"})</span>`;
        } else {
            previewBody.innerText = bodyVal;
        }

        // Preview Language
        document.getElementById('previewLangBadge').innerText = langVal;

        // Preview Tag Badge
        const tagConfig = cultureStyleConfig[tagVal];
        const badge = document.getElementById('previewTagBadge');
        const dot = document.getElementById('previewBadgeDot');
        const text = document.getElementById('previewBadgeText');

        badge.className = `inline-flex items-center gap-1 px-2.5 py-0.5 text-[8px] font-bold uppercase rounded-full border ${tagConfig.badgeClass}`;
        dot.className = tagConfig.dotClass;
        text.innerText = tagVal.replace('_', ' ');
    }

    // Initialize triggers on page load
    document.addEventListener('DOMContentLoaded', () => {
        setContentType('Reading');
        setCultureTag('universal');
        setStatus('Draft');
    });
</script>
@endsection
