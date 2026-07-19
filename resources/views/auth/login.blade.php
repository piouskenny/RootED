@extends('layouts.auth')

@section('title', 'RootED — Sign In')

@section('content')
<div class="max-w-5xl mx-auto w-full grid grid-cols-1 lg:grid-cols-12 gap-8 items-stretch">
    
    <!-- LEFT COLUMN: AUTH FORM CARD (Takes 7 cols on lg) -->
    <div class="lg:col-span-7 bg-white neo-border neo-shadow rounded-2xl p-6 sm:p-10 flex flex-col justify-between relative overflow-hidden bg-radial from-white to-brand-cream/30">
        
        <!-- Decorative corner accent -->
        <div class="absolute top-0 right-0 w-16 h-16 pointer-events-none border-b border-l border-brand-charcoal/10 rounded-bl-full bg-brand-cream/40"></div>
        
        <div>
            <!-- Header bar with Logo & Locale Picker -->
            <div class="flex justify-between items-center mb-8">
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
            <div class="mb-8">
                <label id="lbl-role-select" class="block text-xs font-bold uppercase tracking-wider text-brand-charcoal/60 mb-2">Select Account Type</label>
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
            <h1 id="page-title" class="font-serif text-3xl sm:text-4xl text-brand-charcoal font-bold tracking-tight mb-8 leading-tight">
                Welcome back to RootED
            </h1>

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
            <form action="{{ route('login') }}" method="POST" class="space-y-6">
                @csrf
                <input type="hidden" name="role" id="input-role" value="learner">
                <input type="hidden" name="locale" id="input-locale" value="en">
                <!-- Email Input -->
                <div>
                    <label for="email" id="lbl-email" class="block text-sm font-bold mb-1.5 text-brand-charcoal">Email Address</label>
                    <div class="relative">
                        <input type="email" id="email" name="email" required placeholder="name@example.com" class="w-full px-4 py-3 bg-brand-cream/45 neo-border rounded-xl focus:outline-none focus:bg-white focus:ring-2 focus:ring-brand-terracotta font-medium placeholder-brand-charcoal/40 transition-colors duration-150">
                        <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-brand-charcoal/30">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" /></svg>
                        </div>
                    </div>
                </div>

                <!-- Password Input -->
                <div>
                    <label for="password" id="lbl-password" class="block text-sm font-bold mb-1.5 text-brand-charcoal">Password</label>
                    <div class="relative">
                        <input type="password" id="password" name="password" required placeholder="••••••••" class="w-full px-4 py-3 bg-brand-cream/45 neo-border rounded-xl focus:outline-none focus:bg-white focus:ring-2 focus:ring-brand-terracotta font-medium placeholder-brand-charcoal/40 transition-colors duration-150">
                        <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-brand-charcoal/30">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                        </div>
                    </div>
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex flex-wrap items-center justify-between gap-4 text-sm font-bold">
                    <label class="flex items-center gap-2.5 cursor-pointer select-none">
                        <input type="checkbox" name="remember" class="sr-only peer">
                        <div class="w-5 h-5 bg-brand-cream neo-border rounded peer-checked:bg-brand-terracotta flex items-center justify-center text-white peer-checked:neo-border-brand-charcoal transition-colors duration-150">
                            <svg class="w-3.5 h-3.5 fill-current hidden peer-checked:block" viewBox="0 0 20 20"><path d="M0 11l2-2 5 5L18 3l2 2L7 18z"/></svg>
                        </div>
                        <span id="lbl-remember" class="text-brand-charcoal/80">Keep me signed in</span>
                    </label>
                    
                    <a href="#" id="link-forgot" class="text-brand-terracotta hover:underline decoration-2">Forgot Password?</a>
                </div>

                <!-- Submit Button -->
                <button type="submit" id="btn-submit" class="w-full py-4 px-6 bg-brand-terracotta text-white font-bold uppercase tracking-wider rounded-xl neo-border neo-shadow neo-button-hover text-center cursor-pointer">
                    Enter Classroom
                </button>
            </form>
        </div>

        <!-- Footer Sign-up Call -->
        <div class="mt-10 pt-6 border-t border-brand-charcoal/10 flex flex-col sm:flex-row justify-between items-center gap-4">
            <p id="lbl-no-account" class="text-sm font-medium text-brand-charcoal/70">New to RootED?</p>
            <a href="/users/register" id="link-register" class="px-5 py-2 bg-brand-cream neo-border neo-shadow-sm rounded-lg text-sm font-bold hover:bg-brand-cream/80 active:translate-y-0.5 active:shadow-none transition-all duration-150">
                Create an account
            </a>
        </div>
    </div>

    <!-- RIGHT COLUMN: CULTURAL DASHBOARD PREVIEW PANEL (Takes 5 cols on lg) -->
    <div class="lg:col-span-5 bg-brand-cream neo-border neo-shadow rounded-2xl p-6 sm:p-8 flex flex-col justify-between relative overflow-hidden bg-radial from-brand-cream via-brand-cream/85 to-[#FAF6F0]">
        
        <!-- Absolute decorative circles -->
        <div class="absolute -top-12 -right-12 w-32 h-32 rounded-full border-2 border-brand-charcoal/5 pointer-events-none"></div>
        <div class="absolute -bottom-16 -left-16 w-48 h-48 rounded-full border-2 border-brand-charcoal/5 pointer-events-none"></div>

        <div>
            <!-- Cultural tag representation indicator -->
            <div class="flex justify-between items-center mb-6">
                <span class="text-xs font-bold uppercase tracking-widest text-brand-charcoal/50">Cultural Framing Preview</span>
                <div id="culturalTag" class="flex items-center gap-1.5 px-3 py-1 text-xs font-bold uppercase tracking-wider rounded-full neo-border" style="background-color: var(--color-culture-yoruba-bg); color: var(--color-culture-yoruba);">
                    <span id="culturalTagIcon" class="inline-block w-2 h-2 rotate-45" style="background-color: var(--color-culture-yoruba);"></span>
                    <span id="culturalTagText">YORUBA</span>
                </div>
            </div>

            <!-- Mini Dashboard Card preview mimicking the visual design in the brief -->
            <div class="bg-white neo-border neo-shadow rounded-xl p-5 mb-6 relative z-10 transition-all duration-300 transform" id="roleCardPreview">
                <!-- Card Header -->
                <div class="flex justify-between items-center text-xs font-bold text-brand-charcoal/40 mb-3 uppercase tracking-wider">
                    <span>Today &bull; Friday, 19 June</span>
                    <span id="badge-streak">Learner Streak</span>
                </div>
                
                <!-- Live Greeting -->
                <h3 id="preview-greet" class="font-serif text-3xl text-brand-charcoal font-bold tracking-tight mb-2 leading-tight">
                    Sannu / Ekuabo / Nnoo!
                </h3>
                
                <!-- Live Sub-text -->
                <p id="preview-desc" class="text-sm font-medium text-brand-charcoal/70 mb-4 leading-relaxed">
                    Access your culturally framed learning paths, courses, and streak goals.
                </p>

                <!-- Mini streak progress bar or detail -->
                <div class="pt-4 border-t border-brand-charcoal/10" id="progressContainer">
                    <div class="flex justify-between items-center text-xs font-bold text-brand-charcoal/60 mb-2">
                        <span>Current Course Progress</span>
                        <span>62%</span>
                    </div>
                    <div class="w-full bg-brand-cream neo-border h-4 rounded-full p-0.5 overflow-hidden">
                        <div class="bg-brand-terracotta h-full rounded-full transition-all duration-500" style="width: 62%;"></div>
                    </div>
                </div>
            </div>

            <!-- Cultural Micro-Fact card -->
            <div class="bg-white/50 neo-border neo-shadow-sm rounded-xl p-4 text-xs font-medium text-brand-charcoal/80 leading-relaxed mb-6">
                <span class="inline-block px-1.5 py-0.5 bg-brand-charcoal text-white rounded text-[10px] uppercase font-bold tracking-wider mb-2">Localization Note</span>
                <p id="fact-text">Did you know? RootED adjusts not only text translations, but customizes study schedules based on local regional holidays, farming cycles, and cultural celebration frameworks across West Africa.</p>
            </div>
        </div>

        <!-- West African Traditional Geometric Pattern Container -->
        <div class="h-16 w-full neo-border rounded-xl bg-brand-charcoal text-brand-cream flex items-center justify-center overflow-hidden relative" id="chevronFooter">
            <div class="absolute inset-0 opacity-15" style="background-image: repeating-linear-gradient(45deg, var(--color-brand-cream), var(--color-brand-cream) 10px, transparent 10px, transparent 20px);"></div>
            <span class="font-serif italic text-lg tracking-wider relative z-10" id="motto-text">Imo ko l'opin — Knowledge is endless</span>
        </div>

    </div>
</div>
@endsection

@section('scripts')
<script>
    // State management variables
    let currentLocale = 'en';
    let currentRole = 'learner';

    // UI Dictionaries
    const translations = {
        en: {
            title: "Welcome back to RootED",
            lbl_role_select: "Select Account Type",
            lbl_email: "Email Address",
            lbl_password: "Password",
            lbl_remember: "Keep me signed in",
            link_forgot: "Forgot Password?",
            btn_submit: "Enter Classroom",
            lbl_no_account: "New to RootED?",
            link_register: "Create an account",
            learner_greet: "Sannu, Adaeze.",
            learner_desc: "You're 62% through this week's plan. One module left for the streak.",
            instructor_greet: "Ekuabo, Dr. Adebayo.",
            instructor_desc: "You have 12 assignments awaiting grading across Yoruba Oral Literature.",
            admin_greet: "Aliko Maikano.",
            admin_desc: "All nodes running optimally. 3 culture-tag reviews pending approval.",
            streak_badge: "Activity Streak",
            motto: "Knowledge is endless",
            fact: "Did you know? RootED adjusts not only text translations, but customizes study schedules based on local regional holidays, farming cycles, and cultural celebration frameworks across West Africa."
        },
        yo: {
            title: "Káàbọ̀ padà sí RootED",
            lbl_role_select: "Yan Iru Akọọlẹ Rẹ",
            lbl_email: "Àdírẹ́sì Imeeli",
            lbl_password: "Ọ̀rọ̀-ìpamọ́",
            lbl_remember: "Jẹ́ kí n wọlé nìṣó",
            link_forgot: "Gbagbe Ọ̀rọ̀-ìpamọ́?",
            btn_submit: "Wọle sí Kíláàsì",
            lbl_no_account: "Ṣe tuntun sí RootED?",
            link_register: "Ṣe àkọsílẹ̀ tuntun",
            learner_greet: "Ẹ̀kúàbọ̀, Adaeze.",
            learner_desc: "O ti pari 62% ti ètò ọ̀sẹ̀ yìí. Module kan péré lo kù láti parí aṣeyọrí rẹ.",
            instructor_greet: "Ẹ n lẹ́, Dr. Adébáyọ̀.",
            instructor_desc: "O ni awọn iṣẹ-ṣiṣe 12 ti o n duro de iyasọtọ labẹ Litireso Yoruba.",
            admin_greet: "Aliko Maikano.",
            admin_desc: "Gbogbo awọn ọna ṣiṣe n ṣiṣẹ daradara. Awọn atunwo ede 3 n duro de ifọwọsi.",
            streak_badge: "Igbelewọn Iṣẹ",
            motto: "Ìmọ̀ kò lọ́pin",
            fact: "Ṣe o mọ? RootED kii ṣe iyipada ede nikan, ṣugbọn o n ṣatunṣe awọn akoko ikẹkọ gẹgẹbi awọn isinmi agbegbe ati awọn ayẹyẹ aṣa ni Ila-oorun ati Iwọ-oorun Afirika."
        },
        ha: {
            title: "Barka da dawowa RootED",
            lbl_role_select: "Zaɓi Nau'in Asusunku",
            lbl_email: "Adireshin Imel",
            lbl_password: "Kalmar sirri",
            lbl_remember: "Ci gaba da shiga",
            link_forgot: "Mantu da kalmar sirri?",
            btn_submit: "Shiga Aji",
            lbl_no_account: "Sabo ne a RootED?",
            link_register: "Ƙirƙiri asusu",
            learner_greet: "Sannu, Adaeze.",
            learner_desc: "Kun kammala kashi 62% na tsarin wannan makon. Ragowar darasi guda don cika burinku.",
            instructor_greet: "Sannu da aiki, Dr. Adebayo.",
            instructor_desc: "Kuna da ayyuka guda 12 da ke jiran tantancewa a ƙarƙashin Adabin Yoruba.",
            admin_greet: "Aliko Maikano.",
            admin_desc: "Dukkanin ayyuka suna gudana lami lafiya. Tace harsuna 3 na jiran yardar ku.",
            streak_badge: "Darajar Aiki",
            motto: "Ilimi shi ne jagora",
            fact: "Ko kun sani? RootED ba wai kawai fassara kalmomi yake yi ba, har ma yana daidaita tsarin karatu daidai da hutun yankuna, lokutan noma, da al'adun Yammacin Afirika."
        },
        ig: {
            title: "Nnọọ na RootED",
            lbl_role_select: "Họrọ Ụdị Akaụntụ",
            lbl_email: "Adreesị Imeelụ",
            lbl_password: "Okwuntughe",
            lbl_remember: "Mee ka m banye",
            link_forgot: "Chefuru Okwuntughe?",
            btn_submit: "Banye n'Klas",
            lbl_no_account: "Ị dị ọhụrụ na RootED?",
            link_register: "Mepụta akaụntụ",
            learner_greet: "Nnọọ, Adaeze.",
            learner_desc: "I mechaala 62% nke atụmatụ izu a. Naanị otu modul fọrọ n'ụzọ.",
            instructor_greet: "Ndeewo, Dr. Adebayo.",
            instructor_desc: "Ị nwere ọrụ ụmụ akwụkwọ 12 na-eche akara gị n'okpuru Akwụkwọ Ọnụ Yoruba.",
            admin_greet: "Aliko Maikano.",
            admin_desc: "Sistemụ niile na-arụ ọrụ nke ọma. Nyocha omenala 3 na-eche nkwado gị.",
            streak_badge: "Mgba mbọ gị",
            motto: "Aka aja aja na-ebute ọnụ mmanụ mmanụ",
            fact: "Ì maara? RootED abụghị naanị ịsụgharị asụsụ, ọ na-ahazi atụmatụ ọmụmụ gị dabere na ezumike mpaghara, oge ọrụ ugbo, na mmemme omenala na West Africa."
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

    // Main Locale Selector Function
    function changeLocale(lang) {
        currentLocale = lang;
        currentLocaleLabel.textContent = lang.toUpperCase();
        
        // Update document layout language direction / lang tag
        document.documentElement.setAttribute('lang', lang);
        
        // Sync to hidden input
        document.getElementById('input-locale').value = lang;

        // Update translations
        document.getElementById('page-title').textContent = translations[lang].title;
        document.getElementById('lbl-role-select').textContent = translations[lang].lbl_role_select;
        document.getElementById('lbl-email').textContent = translations[lang].lbl_email;
        document.getElementById('lbl-password').textContent = translations[lang].lbl_password;
        document.getElementById('lbl-remember').textContent = translations[lang].lbl_remember;
        document.getElementById('link-forgot').textContent = translations[lang].link_forgot;
        document.getElementById('btn-submit').textContent = translations[lang].btn_submit;
        document.getElementById('lbl-no-account').textContent = translations[lang].lbl_no_account;
        document.getElementById('link-register').textContent = translations[lang].link_register;
        
        // Update Preview Cards Content
        document.getElementById('motto-text').textContent = translations[lang].motto;
        document.getElementById('fact-text').textContent = translations[lang].fact;
        document.getElementById('badge-streak').textContent = translations[lang].streak_badge;

        // Dynamic greeting updates based on role
        updateRolePreview();
    }

    // Role Switcher function
    function setRole(role) {
        currentRole = role;
        
        // Sync to hidden input
        document.getElementById('input-role').value = role;
        
        // Reset button active classes
        const roles = ['learner', 'instructor'];
        roles.forEach(r => {
            const btn = document.getElementById(`btn-role-${r}`);
            if (r === role) {
                btn.className = "py-2.5 px-2 text-sm font-bold rounded-lg transition-all duration-200 bg-brand-charcoal text-white neo-border";
            } else {
                btn.className = "py-2.5 px-2 text-sm font-bold rounded-lg transition-all duration-200 text-brand-charcoal hover:bg-brand-charcoal/5";
            }
        });

        // Trigger dynamic styling and content updates
        updateRolePreview();
    }

    // Dynamic Preview Updating logic
    function updateRolePreview() {
        const greetElem = document.getElementById('preview-greet');
        const descElem = document.getElementById('preview-desc');
        const tagElem = document.getElementById('culturalTag');
        const tagText = document.getElementById('culturalTagText');
        const tagIcon = document.getElementById('culturalTagIcon');
        const progressContainer = document.getElementById('progressContainer');
        const roleCardPreview = document.getElementById('roleCardPreview');

        // Apply translations
        greetElem.textContent = translations[currentLocale][`${currentRole}_greet`];
        descElem.textContent = translations[currentLocale][`${currentRole}_desc`];

        // Style the cultural card depending on the active role to mimic diverse framing
        if (currentRole === 'learner') {
            // Learner uses Yoruba cultural styling (Terracotta/Red accents)
            tagText.textContent = "YORUBA";
            tagIcon.style.borderRadius = "0"; // Diamond shape (default square rotated)
            tagElem.style.backgroundColor = "var(--color-culture-yoruba-bg)";
            tagElem.style.color = "var(--color-culture-yoruba)";
            tagIcon.style.backgroundColor = "var(--color-culture-yoruba)";
            progressContainer.style.display = "block";
            
            // Re-apply progress bar colors
            progressContainer.querySelector('div.bg-brand-cream + div > div').className = "bg-brand-terracotta h-full rounded-full transition-all duration-500";
        } else if (currentRole === 'instructor') {
            // Instructor uses Hausa cultural styling (Gold/Mustard accents)
            tagText.textContent = "HAUSA";
            tagIcon.style.borderRadius = "0"; // Square shape
            tagElem.style.backgroundColor = "var(--color-culture-hausa-bg)";
            tagElem.style.color = "var(--color-culture-hausa)";
            tagIcon.style.backgroundColor = "var(--color-culture-hausa)";
            progressContainer.style.display = "block";
            
            // Customize progress bar inside instructor to look like grading compliance or streak
            progressContainer.querySelector('div.bg-brand-cream + div > div').className = "bg-culture-hausa h-full rounded-full transition-all duration-500";
        } else if (currentRole === 'admin') {
            // Admin uses Igbo cultural styling (Green accents)
            tagText.textContent = "IGBO";
            tagIcon.style.borderRadius = "50%"; // Triangle or Circle shape
            tagElem.style.backgroundColor = "var(--color-culture-igbo-bg)";
            tagElem.style.color = "var(--color-culture-igbo)";
            tagIcon.style.backgroundColor = "var(--color-culture-igbo)";
            progressContainer.style.display = "none"; // Hide progress bar for admin system nodes
        }
    }
</script>
@endsection
