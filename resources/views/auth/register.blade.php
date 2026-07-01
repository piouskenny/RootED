@extends('layouts.auth')

@section('title', 'RootED — Register')

@section('content')
<div class="max-w-5xl mx-auto w-full grid grid-cols-1 lg:grid-cols-12 gap-8 items-stretch">
    
    <!-- LEFT COLUMN: AUTH FORM CARD (Takes 7 cols on lg) -->
    <div class="lg:col-span-7 bg-white neo-border neo-shadow rounded-2xl p-6 sm:p-10 flex flex-col justify-between relative overflow-hidden bg-radial from-white to-brand-cream/30">
        
        <!-- Decorative corner accent -->
        <div class="absolute top-0 right-0 w-16 h-16 pointer-events-none border-b border-l border-brand-charcoal/10 rounded-bl-full bg-brand-cream/40"></div>
        
        <div>
            <!-- Header bar with Logo & Locale Picker -->
            <div class="flex justify-between items-center mb-6">
                <!-- Logo -->
                <a href="/" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 rounded-full bg-brand-charcoal text-brand-cream flex items-center justify-center font-bold text-lg neo-border group-hover:scale-105 transition-transform duration-200">
                        R
                    </div>
                    <span class="font-serif text-2xl font-bold tracking-tight group-hover:text-brand-terracotta transition-colors duration-200">rootED</span>
                </a>

                <!-- Interactive Locale Picker -->
                <div class="relative inline-block text-left" id="localeDropdownContainer">
                    <button type="button" id="localeBtn" class="flex items-center gap-2 px-3 py-1.5 bg-brand-cream neo-border neo-shadow-sm rounded-lg text-sm font-semibold hover:bg-brand-cream/80 active:translate-y-0.5 active:shadow-none transition-all duration-150">
                        <span id="currentLocaleLabel">EN</span>
                        <svg class="w-4 h-4 text-brand-charcoal" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <!-- Dropdown Panel -->
                    <div id="localeMenu" class="hidden absolute right-0 mt-2 w-36 bg-white neo-border neo-shadow-sm rounded-xl py-1.5 z-50 animate-in fade-in slide-in-from-top-2 duration-100">
                        <button onclick="changeLocale('en')" class="w-full text-left px-4 py-2 text-sm font-medium hover:bg-brand-cream transition-colors duration-150 flex items-center gap-2">
                            <span class="w-5 text-xs text-brand-charcoal/50">EN</span>
                            <span>English</span>
                        </button>
                        <button onclick="changeLocale('yo')" class="w-full text-left px-4 py-2 text-sm font-medium hover:bg-brand-cream transition-colors duration-150 flex items-center gap-2">
                            <span class="w-5 text-xs text-brand-charcoal/50">YO</span>
                            <span>Yorùbá</span>
                        </button>
                        <button onclick="changeLocale('ha')" class="w-full text-left px-4 py-2 text-sm font-medium hover:bg-brand-cream transition-colors duration-150 flex items-center gap-2">
                            <span class="w-5 text-xs text-brand-charcoal/50">HA</span>
                            <span>Hausa</span>
                        </button>
                        <button onclick="changeLocale('ig')" class="w-full text-left px-4 py-2 text-sm font-medium hover:bg-brand-cream transition-colors duration-150 flex items-center gap-2">
                            <span class="w-5 text-xs text-brand-charcoal/50">IG</span>
                            <span>Igbo</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Role Selector Tabs -->
            <div class="mb-5">
                <label id="lbl-role-select" class="block text-xs font-bold uppercase tracking-wider text-brand-charcoal/60 mb-2">I want to register as:</label>
                <div class="grid grid-cols-2 p-1 bg-brand-cream neo-border rounded-xl relative">
                    <button type="button" onclick="setRole('learner')" id="btn-role-learner" class="py-2.5 px-2 text-sm font-bold rounded-lg transition-all duration-200 bg-brand-charcoal text-white neo-border">
                        Learner
                    </button>
                    <button type="button" onclick="setRole('instructor')" id="btn-role-instructor" class="py-2.5 px-2 text-sm font-bold rounded-lg transition-all duration-200 text-brand-charcoal hover:bg-brand-charcoal/5">
                        Instructor
                    </button>
                </div>
            </div>

            <!-- Title -->
            <h1 id="page-title" class="font-serif text-3xl text-brand-charcoal font-bold tracking-tight mb-2 leading-tight">
                Create your RootED account
            </h1>
            <p id="page-subtitle" class="text-sm font-medium text-brand-charcoal/60 mb-6">Choose your language and set up your cultural learning preferences.</p>

            <!-- Validation Errors -->
            @if ($errors->any())
                <div class="mb-6 p-4 bg-culture-yoruba-bg text-culture-yoruba neo-border rounded-xl font-bold text-sm">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form -->
            <form action="{{ route('register') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="role" id="input-role" value="{{ old('role', 'learner') }}">
                <input type="hidden" name="locale" id="input-locale" value="{{ old('locale', 'en') }}">
                <input type="hidden" name="culture_frame" id="input-culture-frame" value="{{ old('culture_frame', 'yoruba') }}">
                
                <!-- Full Name Input -->
                <div>
                    <label for="name" id="lbl-name" class="block text-sm font-bold mb-1 text-brand-charcoal">Full Name</label>
                    <div class="relative">
                        <input type="text" id="name" name="name" required placeholder="Adaeze Nwachukwu" class="w-full px-4 py-2.5 bg-brand-cream/45 neo-border rounded-xl focus:outline-none focus:bg-white focus:ring-2 focus:ring-brand-terracotta font-medium placeholder-brand-charcoal/40 transition-colors duration-150">
                        <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-brand-charcoal/30">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                        </div>  
                    </div>
                </div>

                <!-- Email Input -->
                <div>
                    <label for="email" id="lbl-email" class="block text-sm font-bold mb-1 text-brand-charcoal">Email Address</label>
                    <div class="relative">
                        <input type="email" id="email" name="email" required placeholder="adaeze@domain.ng" class="w-full px-4 py-2.5 bg-brand-cream/45 neo-border rounded-xl focus:outline-none focus:bg-white focus:ring-2 focus:ring-brand-terracotta font-medium placeholder-brand-charcoal/40 transition-colors duration-150">
                        <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-brand-charcoal/30">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" /></svg>
                        </div>
                    </div>
                </div>

                <!-- Cultural Framing Selection Grid -->
                <div>
                    <label id="lbl-culture-frame" class="block text-sm font-bold mb-1.5 text-brand-charcoal">Select Cultural Frame Preference</label>
                    <div class="grid grid-cols-2 sm:grid-cols-5 gap-2">
                        <!-- Yoruba -->
                        <button type="button" onclick="setCultureFrame('yoruba')" id="btn-culture-yoruba" class="py-2 px-1 text-xs font-bold rounded-lg border-2 border-brand-charcoal shadow-sm transition-all duration-150 bg-culture-yoruba-bg text-culture-yoruba scale-[1.03] ring-2 ring-brand-charcoal">
                            Yorùbá
                        </button>
                        <!-- Hausa -->
                        <button type="button" onclick="setCultureFrame('hausa')" id="btn-culture-hausa" class="py-2 px-1 text-xs font-bold rounded-lg border-2 border-brand-charcoal shadow-sm hover:translate-y-[-1px] transition-all duration-150 bg-culture-hausa-bg text-culture-hausa">
                            Hausa
                        </button>
                        <!-- Igbo -->
                        <button type="button" onclick="setCultureFrame('igbo')" id="btn-culture-igbo" class="py-2 px-1 text-xs font-bold rounded-lg border-2 border-brand-charcoal shadow-sm hover:translate-y-[-1px] transition-all duration-150 bg-culture-igbo-bg text-culture-igbo">
                            Igbo
                        </button>
                        <!-- Pan-African -->
                        <button type="button" onclick="setCultureFrame('panafrican')" id="btn-culture-panafrican" class="py-2 px-1 text-xs font-bold rounded-lg border-2 border-brand-charcoal shadow-sm hover:translate-y-[-1px] transition-all duration-150 bg-culture-panafrican-bg text-culture-panafrican">
                            Pan-African
                        </button>
                        <!-- Universal -->
                        <button type="button" onclick="setCultureFrame('universal')" id="btn-culture-universal" class="py-2 px-1 text-xs font-bold rounded-lg border-2 border-brand-charcoal shadow-sm hover:translate-y-[-1px] transition-all duration-150 bg-culture-universal-bg text-culture-universal col-span-2 sm:col-span-1">
                            Universal
                        </button>
                    </div>
                </div>

                <!-- Password Row -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="password" id="lbl-password" class="block text-sm font-bold mb-1 text-brand-charcoal">Password</label>
                        <input type="password" id="password" name="password" required placeholder="••••••••" class="w-full px-4 py-2.5 bg-brand-cream/45 neo-border rounded-xl focus:outline-none focus:bg-white focus:ring-2 focus:ring-brand-terracotta font-medium placeholder-brand-charcoal/40 transition-colors duration-150">
                    </div>
                    <div>
                        <label for="password_confirmation" id="lbl-confirm" class="block text-sm font-bold mb-1 text-brand-charcoal">Confirm Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required placeholder="••••••••" class="w-full px-4 py-2.5 bg-brand-cream/45 neo-border rounded-xl focus:outline-none focus:bg-white focus:ring-2 focus:ring-brand-terracotta font-medium placeholder-brand-charcoal/40 transition-colors duration-150">
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" id="btn-submit" class="w-full py-4 px-6 bg-brand-terracotta text-white font-bold uppercase tracking-wider rounded-xl neo-border neo-shadow neo-button-hover text-center cursor-pointer mt-4">
                    Start Learning
                </button>
            </form>
        </div>

        <!-- Footer Sign-in Call -->
        <div class="mt-8 pt-5 border-t border-brand-charcoal/10 flex flex-col sm:flex-row justify-between items-center gap-4">
            <p id="lbl-already-account" class="text-sm font-medium text-brand-charcoal/70">Already have an account?</p>
            <a href="/users/login" id="link-login" class="px-5 py-2 bg-brand-cream neo-border neo-shadow-sm rounded-lg text-sm font-bold hover:bg-brand-cream/80 active:translate-y-0.5 active:shadow-none transition-all duration-150">
                Sign in here
            </a>
        </div>
    </div>

    <!-- RIGHT COLUMN: DYNAMIC CULTURE FRAME PREVIEW (Takes 5 cols on lg) -->
    <div class="lg:col-span-5 bg-brand-cream neo-border neo-shadow rounded-2xl p-6 sm:p-8 flex flex-col justify-between relative overflow-hidden bg-radial from-brand-cream via-brand-cream/85 to-[#FAF6F0]">
        
        <!-- Background graphic shapes representing West African heritage patterns -->
        <div class="absolute -top-12 -right-12 w-32 h-32 rounded-full border-2 border-brand-charcoal/5 pointer-events-none"></div>
        <div class="absolute -bottom-16 -left-16 w-48 h-48 rounded-full border-2 border-brand-charcoal/5 pointer-events-none"></div>

        <div>
            <!-- Custom header badge mimicking the brief's dynamic framing -->
            <div class="flex justify-between items-center mb-6">
                <span class="text-xs font-bold uppercase tracking-widest text-brand-charcoal/50">Selected Feed Framing</span>
                <div id="culturalTag" class="flex items-center gap-1.5 px-3 py-1 text-xs font-bold uppercase tracking-wider rounded-full neo-border" style="background-color: var(--color-culture-yoruba-bg); color: var(--color-culture-yoruba);">
                    <span id="culturalTagIcon" class="inline-block w-2 h-2 rotate-45" style="background-color: var(--color-culture-yoruba);"></span>
                    <span id="culturalTagText">YORUBA</span>
                </div>
            </div>

            <!-- Custom Mock Dashboard Course Card inspired by the actual UI design attached -->
            <div class="bg-white neo-border neo-shadow rounded-2xl p-5 mb-6 relative z-10 transition-all duration-300 transform" id="courseCardFrame">
                
                <!-- Tag row -->
                <div class="flex justify-between items-center mb-4">
                    <span id="courseCultureBadge" class="px-2 py-0.5 text-[10px] font-bold uppercase rounded-md border" style="background-color: var(--color-culture-yoruba-bg); color: var(--color-culture-yoruba); border-color: var(--color-culture-yoruba);">
                        Yoruba
                    </span>
                    <div class="flex gap-1" id="courseLanguages">
                        <span class="w-5 h-5 rounded-full bg-brand-cream neo-border-sm text-[9px] flex items-center justify-center font-bold text-brand-charcoal">EN</span>
                        <span class="w-5 h-5 rounded-full bg-brand-cream neo-border-sm text-[9px] flex items-center justify-center font-bold text-brand-charcoal">YO</span>
                    </div>
                </div>

                <!-- Dynamic Course Title -->
                <h3 id="courseTitle" class="font-serif text-xl sm:text-2xl text-brand-charcoal font-bold tracking-tight mb-1 leading-snug">
                    Yoruba Oral Literature & Modern Storytelling
                </h3>
                <p id="courseInstructor" class="text-xs font-medium text-brand-charcoal/50 mb-6">Dr. Oluwaseyi Adebayo</p>

                <!-- Course Progress and Action Bar -->
                <div class="pt-4 border-t border-brand-charcoal/10">
                    <div class="flex justify-between items-center text-xs font-bold text-brand-charcoal/60 mb-2">
                        <span>Course Completion</span>
                        <span id="courseProgressText">62%</span>
                    </div>
                    <div class="w-full bg-brand-cream neo-border h-4 rounded-full p-0.5 overflow-hidden mb-4">
                        <div id="courseProgressBar" class="bg-brand-terracotta h-full rounded-full transition-all duration-500" style="width: 62%;"></div>
                    </div>
                    
                    <button type="button" class="w-full py-2 bg-brand-cream text-brand-charcoal font-bold text-xs uppercase tracking-wider rounded-lg border-2 border-brand-charcoal shadow-sm hover:translate-y-[-1px] active:translate-y-[1px] active:shadow-none transition-all duration-150">
                        Resume Module
                    </button>
                </div>
            </div>

            <!-- Dynamic Course Description & Why Cultural Framing is Important -->
            <div class="bg-white/50 neo-border rounded-xl p-4 text-xs font-medium text-brand-charcoal/80 leading-relaxed">
                <span class="inline-block px-1.5 py-0.5 bg-brand-charcoal text-white rounded text-[10px] uppercase font-bold tracking-wider mb-2">Why Cultural Framing?</span>
                <p id="preview-framework-desc">Your dashboard feed compiles content framed with Yoruba oral traditional paradigms (e.g. Oriki structures, traditional poetry forms). It contextualizes modern digital principles through indigenous systems of knowing.</p>
            </div>
        </div>

        <!-- West African Traditional Geometric Pattern Container -->
        <div class="h-16 w-full neo-border rounded-xl bg-brand-charcoal text-brand-cream flex items-center justify-center overflow-hidden relative mt-6">
            <div class="absolute inset-0 opacity-15" style="background-image: repeating-linear-gradient(45deg, var(--color-brand-cream), var(--color-brand-cream) 10px, transparent 10px, transparent 20px);"></div>
            <span class="font-serif italic text-lg tracking-wider relative z-10" id="motto-text">Imo ko l'opin — Knowledge is endless</span>
        </div>

    </div>
</div>
@endsection

@section('scripts')
<script>
    // State Variables
    let currentLocale = '{{ old('locale', 'en') }}';
    let currentRole = '{{ old('role', 'learner') }}';
    let currentCulture = '{{ old('culture_frame', 'yoruba') }}';

    document.addEventListener('DOMContentLoaded', () => {
        setRole(currentRole);
        setCultureFrame(currentCulture);
        changeLocale(currentLocale);
    });

    // UI Translation Data
    const translations = {
        en: {
            title: "Create your RootED account",
            subtitle: "Choose your language and set up your cultural learning preferences.",
            lbl_role_select: "I want to register as:",
            lbl_name: "Full Name",
            lbl_email: "Email Address",
            lbl_culture_frame: "Select Cultural Frame Preference",
            lbl_password: "Password",
            lbl_confirm: "Confirm Password",
            btn_submit_learner: "Start Learning",
            btn_submit_instructor: "Start Teaching",
            lbl_already_account: "Already have an account?",
            link_login: "Sign in here",
            motto: "Knowledge is endless"
        },
        yo: {
            title: "Ṣe àkọsílẹ̀ àkọọlẹ RootED rẹ",
            subtitle: "Yan ede rẹ ki o ṣeto awọn ayanfẹ ikẹkọ aṣa rẹ.",
            lbl_role_select: "Mo fẹ forukọsilẹ bi:",
            lbl_name: "Orukọ Kikun",
            lbl_email: "Àdírẹ́sì Imeeli",
            lbl_culture_frame: "Yan Ayanfẹ Eto Aṣa Rẹ",
            lbl_password: "Ọ̀rọ̀-ìpamọ́",
            lbl_confirm: "Mú Ọ̀rọ̀-ìpamọ́ Dunjú",
            btn_submit_learner: "Bẹ̀rẹ̀ sí Kẹ́kọ̀ọ́",
            btn_submit_instructor: "Bẹ̀rẹ̀ sí Kọ́ni",
            lbl_already_account: "Ṣe o ti forukọsilẹ tẹlẹ?",
            link_login: "Wọlé síbí",
            motto: "Ìmọ̀ kò lọ́pin"
        },
        ha: {
            title: "Ƙirƙiri asusun RootED nku",
            subtitle: "Zaɓi harshenku kuma saita abubuwan da kuka fi so don koyo na al'ada.",
            lbl_role_select: "Ina son yin rajista a matsayin:",
            lbl_name: "Cikakken Suna",
            lbl_email: "Adireshin Imel",
            lbl_culture_frame: "Zaɓi Tsarin Al'adar da kuka Fi So",
            lbl_password: "Kalmar sirri",
            lbl_confirm: "Tabbatar da Kalmar Sirri",
            btn_submit_learner: "Fara Koyo",
            btn_submit_instructor: "Fara Koyarwa",
            lbl_already_account: "Kuna da asusu riga?",
            link_login: "Shiga nan",
            motto: "Ilimi shi ne jagora"
        },
        ig: {
            title: "Mepụta akaụntụ RootED gị",
            subtitle: "Họrọ asụsụ gị wee hie omenala mmụta kacha gị mma.",
            lbl_role_select: "Achọrọ m ịdebanye aha dị ka:",
            lbl_name: "Aha zuru ezu",
            lbl_email: "Adreesị Imeelụ",
            lbl_culture_frame: "Họrọ Omenala Ị Chọrọ ka Egosipụta Ihe Gị",
            lbl_password: "Okwuntughe",
            lbl_confirm: "Kwado Okwuntughe",
            btn_submit_learner: "Fara Mmụta",
            btn_submit_instructor: "Fara Nkụzi",
            lbl_already_account: "Ị nwere akaụntụ n'oge gara aga?",
            link_login: "Banye ebe a",
            motto: "Aka aja aja na-ebute ọnụ mmanụ mmanụ"
        }
    };

    // Course Preview Content data modeled directly after the user dashboard mock image
    const coursesDb = {
        yoruba: {
            tagName: "YORUBA",
            tagColor: "var(--color-culture-yoruba)",
            tagBg: "var(--color-culture-yoruba-bg)",
            title: "Yoruba Oral Literature & Modern Storytelling",
            instructor: "Dr. Oluwaseyi Adebayo",
            progress: "62%",
            langs: ["EN", "YO"],
            shape: "rotate-45",
            desc: "Your dashboard feed compiles content framed with Yoruba oral traditional paradigms (e.g. Oriki structures, traditional poetry forms). It contextualizes modern digital principles through indigenous systems of knowing."
        },
        hausa: {
            tagName: "HAUSA",
            tagColor: "var(--color-culture-hausa)",
            tagBg: "var(--color-culture-hausa-bg)",
            title: "Cassava-to-Market: Smallholder Agriculture",
            instructor: "Prof. Bilkisu Maikano",
            progress: "28%",
            langs: ["EN", "HA", "YO"],
            shape: "rounded-none",
            desc: "Your dashboard feed compiles content framed with Hausa agricultural cooperatives and community lending principles (e.g. Adashi forms). Real-world agricultural markets are explained using local socio-economic paradigms."
        },
        igbo: {
            tagName: "IGBO",
            tagColor: "var(--color-culture-igbo)",
            tagBg: "var(--color-culture-igbo-bg)",
            title: "Igbo Apprenticeship & The Modern Startup",
            instructor: "Mazi Chinedu Okafor",
            progress: "45%",
            langs: ["EN", "IG"],
            shape: "rounded-full",
            desc: "Your dashboard feed compiles content framed with the traditional Igbo Apprenticeship System (Imu-Ahia) as an entrepreneurial business incubator, connecting historic trade setups with modern tech startup culture."
        },
        panafrican: {
            tagName: "PAN-AFRICAN",
            tagColor: "var(--color-culture-panafrican)",
            tagBg: "var(--color-culture-panafrican-bg)",
            title: "Pan-African Business Ethics & Leadership",
            instructor: "Dr. Kwame Nkrumah Jnr.",
            progress: "15%",
            langs: ["EN"],
            shape: "scale-75 rotate-12",
            desc: "Your dashboard feed compiles content framed with historical Pan-African models, collective community ethics (Ubuntu), and post-colonial leadership philosophies. Modern commerce is analyzed from a continent-wide perspective."
        },
        universal: {
            tagName: "UNIVERSAL",
            tagColor: "var(--color-culture-universal)",
            tagBg: "var(--color-culture-universal-bg)",
            title: "Introduction to Web Development & Design",
            instructor: "RootED Technical Team",
            progress: "5%",
            langs: ["EN", "IG", "YO", "HA"],
            shape: "rounded-lg",
            desc: "Your dashboard feed compiles content with universal technical frameworks, utilizing clean, translation-only interfaces for coding syntax. It presents standardized global tech guidelines without localized framing."
        }
    };

    // Locale Dropdown Toggle
    const localeBtn = document.getElementById('localeBtn');
    const localeMenu = document.getElementById('localeMenu');
    const currentLocaleLabel = document.getElementById('currentLocaleLabel');

    localeBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        localeMenu.classList.toggle('hidden');
    });

    document.addEventListener('click', () => {
        localeMenu.classList.add('hidden');
    });

    // Translate UI Elements
    function changeLocale(lang) {
        currentLocale = lang;
        currentLocaleLabel.textContent = lang.toUpperCase();
        
        document.documentElement.setAttribute('lang', lang);
        
        // Sync to hidden input
        document.getElementById('input-locale').value = lang;

        document.getElementById('page-title').textContent = translations[lang].title;
        document.getElementById('page-subtitle').textContent = translations[lang].subtitle;
        document.getElementById('lbl-role-select').textContent = translations[lang].lbl_role_select;
        document.getElementById('lbl-name').textContent = translations[lang].lbl_name;
        document.getElementById('lbl-email').textContent = translations[lang].lbl_email;
        document.getElementById('lbl-culture-frame').textContent = translations[lang].lbl_culture_frame;
        document.getElementById('lbl-password').textContent = translations[lang].lbl_password;
        document.getElementById('lbl-confirm').textContent = translations[lang].lbl_confirm;
        document.getElementById('lbl-already-account').textContent = translations[lang].lbl_already_account;
        document.getElementById('link-login').textContent = translations[lang].link_login;
        document.getElementById('motto-text').textContent = translations[lang].motto;

        // Submit button text based on role + locale
        updateSubmitButtonText();
    }

    // Toggle Role (Learner/Instructor)
    function setRole(role) {
        currentRole = role;
        
        // Sync to hidden input
        document.getElementById('input-role').value = role;
        
        const btnLearner = document.getElementById('btn-role-learner');
        const btnInstructor = document.getElementById('btn-role-instructor');
        
        if (role === 'learner') {
            btnLearner.className = "py-2.5 px-2 text-sm font-bold rounded-lg transition-all duration-200 bg-brand-charcoal text-white neo-border";
            btnInstructor.className = "py-2.5 px-2 text-sm font-bold rounded-lg transition-all duration-200 text-brand-charcoal hover:bg-brand-charcoal/5";
        } else {
            btnInstructor.className = "py-2.5 px-2 text-sm font-bold rounded-lg transition-all duration-200 bg-brand-charcoal text-white neo-border";
            btnLearner.className = "py-2.5 px-2 text-sm font-bold rounded-lg transition-all duration-200 text-brand-charcoal hover:bg-brand-charcoal/5";
        }

        updateSubmitButtonText();
    }

    function updateSubmitButtonText() {
        const submitBtn = document.getElementById('btn-submit');
        if (currentRole === 'learner') {
            submitBtn.textContent = translations[currentLocale].btn_submit_learner;
        } else {
            submitBtn.textContent = translations[currentLocale].btn_submit_instructor;
        }
    }

    // Toggle Culture Frame Selection
    function setCultureFrame(culture) {
        currentCulture = culture;
        
        // Sync to hidden input
        document.getElementById('input-culture-frame').value = culture;
        
        const cultures = ['yoruba', 'hausa', 'igbo', 'panafrican', 'universal'];
        
        cultures.forEach(c => {
            const btn = document.getElementById(`btn-culture-${c}`);
            if (c === culture) {
                // Active Button styling
                btn.className = `py-2 px-1 text-xs font-bold rounded-lg border-2 border-brand-charcoal shadow-sm transition-all duration-150 bg-culture-${c}-bg text-culture-${c} scale-[1.03] ring-2 ring-brand-charcoal`;
            } else {
                // Inactive button styling
                btn.className = `py-2 px-1 text-xs font-bold rounded-lg border-2 border-brand-charcoal shadow-sm hover:translate-y-[-1px] transition-all duration-150 bg-culture-${c}-bg text-culture-${c}`;
            }
        });

        // Update preview panel content
        updatePreviewPanel();
    }

    // Update Right Column Dashboard Preview panel
    function updatePreviewPanel() {
        const data = coursesDb[currentCulture];
        
        // Update tags
        const culturalTag = document.getElementById('culturalTag');
        const culturalTagText = document.getElementById('culturalTagText');
        const culturalTagIcon = document.getElementById('culturalTagIcon');
        
        culturalTagText.textContent = data.tagName;
        culturalTag.style.backgroundColor = data.tagBg;
        culturalTag.style.color = data.tagColor;
        
        // Reset shape formatting on small tag icons
        culturalTagIcon.className = "inline-block w-2 h-2 " + data.shape;
        culturalTagIcon.style.backgroundColor = data.tagColor;
        
        // Update inside Card
        const courseCultureBadge = document.getElementById('courseCultureBadge');
        courseCultureBadge.textContent = data.tagName.charAt(0) + data.tagName.slice(1).toLowerCase();
        courseCultureBadge.style.backgroundColor = data.tagBg;
        courseCultureBadge.style.color = data.tagColor;
        courseCultureBadge.style.borderColor = data.tagColor;

        document.getElementById('courseTitle').textContent = data.title;
        document.getElementById('courseInstructor').textContent = data.instructor;
        document.getElementById('courseProgressText').textContent = data.progress;
        
        // Update progress bar
        const progressBar = document.getElementById('courseProgressBar');
        progressBar.style.width = data.progress;
        progressBar.style.backgroundColor = data.tagColor;

        // Languages row
        const langContainer = document.getElementById('courseLanguages');
        langContainer.innerHTML = '';
        data.langs.forEach(lang => {
            const span = document.createElement('span');
            span.className = "w-5 h-5 rounded-full bg-brand-cream border border-brand-charcoal/20 text-[9px] flex items-center justify-center font-bold text-brand-charcoal";
            span.textContent = lang;
            langContainer.appendChild(span);
        });

        // Update framework description card
        document.getElementById('preview-framework-desc').textContent = data.desc;
    }
</script>
@endsection
