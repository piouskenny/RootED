@extends('layouts.app')

@section('title', 'RootED — Add New Course')

@section('content')
<div class="max-w-7xl mx-auto space-y-8 pb-16">

    <!-- HEADER SECTION -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end gap-6 pb-6 border-b border-brand-charcoal/10 relative">
        <div class="space-y-3">
            <div class="flex items-center gap-2 text-[10px] font-bold text-brand-charcoal/40 uppercase tracking-widest">
                <span class="inline-block w-1.5 h-1.5 rounded-full bg-brand-charcoal/40"></span>
                <span>Add Course &bull; Instructor Panel</span>
            </div>
            <h1 class="font-serif text-4xl sm:text-5xl font-bold tracking-tight text-brand-charcoal leading-none">
                Create new course
            </h1>
        </div>
        <div>
            <a href="/dashboard" class="px-5 py-2.5 bg-white border-2 border-brand-charcoal rounded-xl text-xs font-bold uppercase tracking-wider hover:bg-brand-cream/80 active:translate-y-[1px] transition-all shadow-sm">
                &larr; Back to Dashboard
            </a>
        </div>
    </div>

    <!-- MAIN FORM WRAPPER -->
    <form method="POST" action="{{ route('instructor.courses.store') }}" id="courseCreatorForm" class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
        @csrf

        <!-- LEFT: COURSE DETAILS (Takes 2 Columns) -->
        <div class="lg:col-span-2 space-y-6">

            <!-- COURSE FIELDS CARD -->
            <div class="bg-white neo-border neo-shadow rounded-xl p-6 space-y-6">
                <!-- Course Title -->
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-brand-charcoal/60 mb-2" for="title">
                        Course Title
                    </label>
                    <input type="text" name="title" id="title" required oninput="updateLivePreview()"
                           class="w-full rounded-xl border-2 border-brand-charcoal p-3.5 bg-white font-sans text-brand-charcoal focus:outline-none focus:border-brand-terracotta transition-colors shadow-sm text-sm" 
                           placeholder="e.g. Yoruba Oral Literature & Modern Storytelling">
                </div>

                <!-- Course Description -->
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-brand-charcoal/60 mb-2" for="description">
                        Description
                    </label>
                    <textarea name="description" id="description" rows="6" oninput="updateLivePreview()"
                              class="w-full rounded-xl border-2 border-brand-charcoal p-4 bg-white font-sans text-brand-charcoal focus:outline-none focus:border-brand-terracotta transition-colors shadow-sm text-sm" 
                              placeholder="Describe the learning objectives, cultural frameworks, and curriculum structure..."></textarea>
                </div>

                <!-- Price Field -->
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-brand-charcoal/60 mb-2" for="price">
                        Course Fee / Price (USD)
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-sm font-bold text-brand-charcoal/45">
                            $
                        </span>
                        <input type="number" name="price" id="price" step="0.01" min="0" oninput="updateLivePreview()"
                               class="w-full rounded-xl border-2 border-brand-charcoal py-3.5 pl-8 pr-4 bg-white font-sans text-brand-charcoal focus:outline-none focus:border-brand-terracotta transition-colors shadow-sm text-sm" 
                               placeholder="0.00 (Free)">
                    </div>
                </div>

                <!-- Status Button Selector -->
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

            <!-- SUBMIT BUTTONS BAR -->
            <div class="text-right">
                <button type="submit" class="w-full sm:w-auto px-6 py-3 bg-brand-terracotta text-white font-bold uppercase tracking-wider rounded-xl neo-border neo-shadow neo-button-hover active:translate-y-[2px] active:shadow-sm transition-all duration-150 text-xs">
                    Create Course
                </button>
            </div>

        </div>

        <!-- RIGHT: SIDEBAR LOCALIZATION & PREVIEWS (Takes 1 Column) -->
        <div class="lg:col-span-1 space-y-6">

            <!-- LOCALIZATION CARD -->
            <div class="bg-white neo-border neo-shadow-sm rounded-xl p-6 space-y-6">
                <div>
                    <h3 class="text-2xs font-bold uppercase tracking-wider text-brand-charcoal/40 mb-4">Localization</h3>
                    
                    <!-- Language Multiselect Button Checks -->
                    <label class="block text-xs font-bold uppercase tracking-wider text-brand-charcoal/60 mb-2.5">
                        Linguistic Frames
                    </label>
                    
                    <!-- Hidden Checkboxes for Laravel Array Form Handling -->
                    <div id="hidden_langs_container">
                        <input type="checkbox" name="langs[]" id="chk_lang_EN" value="EN" class="hidden" checked>
                        <input type="checkbox" name="langs[]" id="chk_lang_YO" value="YO" class="hidden">
                        <input type="checkbox" name="langs[]" id="chk_lang_HA" value="HA" class="hidden">
                        <input type="checkbox" name="langs[]" id="chk_lang_IG" value="IG" class="hidden">
                    </div>

                    <div class="grid grid-cols-2 gap-2">
                        <!-- English Badge Button -->
                        <button type="button" onclick="toggleLanguage('EN')" id="btn_lang_EN"
                                class="py-2.5 px-3 rounded-xl border-2 border-brand-charcoal bg-brand-charcoal text-white text-xs font-bold uppercase tracking-wider transition-all">
                            English (EN)
                        </button>

                        <!-- Yoruba Badge Button -->
                        <button type="button" onclick="toggleLanguage('YO')" id="btn_lang_YO"
                                class="py-2.5 px-3 rounded-xl border-2 border-brand-charcoal/20 bg-white text-brand-charcoal hover:bg-brand-cream/50 text-xs font-bold uppercase tracking-wider transition-all">
                            Yorùbá (YO)
                        </button>

                        <!-- Hausa Badge Button -->
                        <button type="button" onclick="toggleLanguage('HA')" id="btn_lang_HA"
                                class="py-2.5 px-3 rounded-xl border-2 border-brand-charcoal/20 bg-white text-brand-charcoal hover:bg-brand-cream/50 text-xs font-bold uppercase tracking-wider transition-all">
                            Hausa (HA)
                        </button>

                        <!-- Igbo Badge Button -->
                        <button type="button" onclick="toggleLanguage('IG')" id="btn_lang_IG"
                                class="py-2.5 px-3 rounded-xl border-2 border-brand-charcoal/20 bg-white text-brand-charcoal hover:bg-brand-cream/50 text-xs font-bold uppercase tracking-wider transition-all">
                            Igbo (IG)
                        </button>
                    </div>
                </div>

                <!-- Culture Tag Selection -->
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-brand-charcoal/60 mb-3">
                        Culture tag
                    </label>
                    
                    <input type="hidden" name="tag" id="tag" value="universal">
                    
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

            <!-- COURSE CARD PREVIEW -->
            <div class="bg-white neo-border neo-shadow-sm rounded-xl p-6">
                <h3 class="text-2xs font-bold uppercase tracking-wider text-brand-charcoal/40 mb-4">Course Preview</h3>
                
                <!-- Inner Course Preview Card -->
                <div class="bg-white border-2 border-brand-charcoal rounded-xl overflow-hidden shadow-sm flex flex-col">
                    <!-- Preview Card Header -->
                    <div class="bg-brand-cream border-b border-brand-charcoal/10 px-4 py-3.5 flex justify-between items-center">
                        <span id="previewTagBadge" class="inline-flex items-center gap-1.5 px-3 py-1 text-[9px] font-bold uppercase rounded-full border border-culture-universal/30 bg-culture-universal-bg text-culture-universal">
                            <span class="w-1.5 h-1.5 border border-culture-universal rounded-sm inline-block" id="previewBadgeDot"></span>
                            <span id="previewBadgeText">Universal</span>
                        </span>
                        
                        <!-- Modules Count -->
                        <span class="text-[8px] font-bold uppercase tracking-wider text-brand-charcoal/50">
                            0 MODULES
                        </span>
                    </div>

                    <!-- Preview Card Body -->
                    <div class="p-4 flex-grow flex flex-col justify-between min-h-[100px]">
                        <div>
                            <p id="previewTitle" class="font-bold text-sm text-brand-charcoal leading-snug">
                                Course Title
                            </p>
                            <p id="previewDesc" class="text-[10px] text-brand-charcoal/60 mt-2 line-clamp-3 leading-relaxed">
                                Course description will display here...
                            </p>
                        </div>
                        
                        <!-- Languages & Price Footer -->
                        <div class="flex justify-between items-center gap-3 border-t border-brand-charcoal/5 mt-4 pt-3">
                            <div class="flex gap-1.5" id="previewLangsContainer">
                                <span class="w-7 h-5 rounded border border-brand-charcoal/20 text-[8px] flex items-center justify-center font-bold text-brand-charcoal bg-white">EN</span>
                            </div>
                            <div class="font-serif font-bold text-sm text-brand-charcoal" id="previewPrice">
                                Free
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </form>
</div>
@endsection

@section('scripts')
<script>
    // Style configurations for culture badges
    const cultureStyleConfig = {
        yoruba: {
            badgeClass: "border-culture-yoruba/30 bg-culture-yoruba-bg text-culture-yoruba",
            dotClass: "w-1.5 h-1.5 bg-culture-yoruba rotate-45 inline-block"
        },
        hausa: {
            badgeClass: "border-culture-hausa/30 bg-culture-hausa-bg text-culture-hausa",
            dotClass: "w-1.5 h-1.5 bg-culture-hausa inline-block"
        },
        igbo: {
            badgeClass: "border-culture-igbo/30 bg-culture-igbo-bg text-culture-igbo",
            dotClass: "w-1.5 h-1.5 border border-culture-igbo rounded-full inline-block"
        },
        northern_nigeria: {
            badgeClass: "border-[#1D70B8]/30 bg-[#F0F4F8] text-[#1D70B8]",
            dotClass: "w-1.5 h-1.5 bg-[#1D70B8] rotate-45 inline-block"
        },
        panafrican: {
            badgeClass: "border-culture-panafrican/30 bg-culture-panafrican-bg text-culture-panafrican",
            dotClass: "w-1.5 h-1.5 bg-culture-panafrican rounded-full inline-block"
        },
        universal: {
            badgeClass: "border-culture-universal/30 bg-culture-universal-bg text-culture-universal",
            dotClass: "w-1.5 h-1.5 border border-culture-universal rounded-sm inline-block"
        }
    };

    // Tracking selected languages
    let selectedLangs = ['EN'];

    function toggleLanguage(lang) {
        const checkbox = document.getElementById(`chk_lang_${lang}`);
        const button = document.getElementById(`btn_lang_${lang}`);
        
        if (checkbox.checked) {
            // Prevent removing English if it's the only one, or ensure at least one lang
            if (selectedLangs.length === 1 && selectedLangs[0] === lang) {
                return;
            }
            checkbox.checked = false;
            selectedLangs = selectedLangs.filter(l => l !== lang);
            
            button.classList.remove('bg-brand-charcoal', 'text-white');
            button.classList.add('bg-white', 'text-brand-charcoal', 'border-brand-charcoal/20', 'hover:bg-brand-cream/50');
        } else {
            checkbox.checked = true;
            selectedLangs.push(lang);
            
            button.classList.remove('bg-white', 'text-brand-charcoal', 'border-brand-charcoal/20', 'hover:bg-brand-cream/50');
            button.classList.add('bg-brand-charcoal', 'text-white');
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
        document.getElementById('tag').value = tag;

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

        updateLivePreview();
    }

    function updateLivePreview() {
        const titleVal = document.getElementById('title').value || "Yoruba Oral Literature & Modern Storytelling";
        const descVal = document.getElementById('description').value || "Describe the learning objectives, cultural frameworks, and curriculum structure...";
        const tagVal = document.getElementById('tag').value;
        const priceVal = parseFloat(document.getElementById('price').value);

        // Update preview title and desc
        document.getElementById('previewTitle').innerText = titleVal;
        document.getElementById('previewDesc').innerText = descVal;

        // Update preview price
        const priceDisplay = document.getElementById('previewPrice');
        if (isNaN(priceVal) || priceVal <= 0) {
            priceDisplay.innerText = "Free";
        } else {
            priceDisplay.innerText = `$${priceVal.toFixed(2)}`;
        }

        // Update languages container in preview
        const langsContainer = document.getElementById('previewLangsContainer');
        langsContainer.innerHTML = '';
        selectedLangs.forEach(lang => {
            const span = document.createElement('span');
            span.className = "w-7 h-5 rounded border border-brand-charcoal/20 text-[8px] flex items-center justify-center font-bold text-brand-charcoal bg-white";
            span.innerText = lang;
            langsContainer.appendChild(span);
        });

        // Update Preview Tag Badge
        const tagConfig = cultureStyleConfig[tagVal];
        const badge = document.getElementById('previewTagBadge');
        const dot = document.getElementById('previewBadgeDot');
        const text = document.getElementById('previewBadgeText');

        badge.className = `inline-flex items-center gap-1.5 px-3 py-1 text-[9px] font-bold uppercase rounded-full border ${tagConfig.badgeClass}`;
        dot.className = tagConfig.dotClass;
        text.innerText = tagVal.replace('_', ' ');
    }

    // Initialize triggers on page load
    document.addEventListener('DOMContentLoaded', () => {
        setCultureTag('universal');
        setStatus('Draft');
        updateLivePreview();
    });
</script>
@endsection
