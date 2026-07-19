@extends('layouts.auth')

@section('title', 'RootED — Admin Access')

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

            <!-- Title -->
            <h1 id="page-title" class="font-serif text-3xl sm:text-4xl text-brand-charcoal font-bold tracking-tight mb-4 leading-tight">
                Admin Console Access
            </h1>
            <p id="page-subtitle" class="text-sm text-brand-charcoal/60 mb-8 font-medium">
                Enter your administrative credentials to manage RootED system nodes, translations, and users.
            </p>

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
            <form action="{{ route('admin.login') }}" method="POST" class="space-y-6">
                @csrf
                <input type="hidden" name="locale" id="input-locale" value="en">
                <!-- Email Input -->
                <div>
                    <label for="email" id="lbl-email" class="block text-sm font-bold mb-1.5 text-brand-charcoal">Admin Email Address</label>
                    <div class="relative">
                        <input type="email" id="email" name="email" required placeholder="admin@root-ed.org" class="w-full px-4 py-3 bg-brand-cream/45 neo-border rounded-xl focus:outline-none focus:bg-white focus:ring-2 focus:ring-brand-terracotta font-medium placeholder-brand-charcoal/40 transition-colors duration-150">
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
                        <span id="lbl-remember" class="text-brand-charcoal/80">Remember this station</span>
                    </label>
                    
                    <a href="#" id="link-forgot" class="text-brand-terracotta hover:underline decoration-2">Forgot Password?</a>
                </div>

                <!-- Submit Button -->
                <button type="submit" id="btn-submit" class="w-full py-4 px-6 bg-brand-charcoal text-white font-bold uppercase tracking-wider rounded-xl neo-border neo-shadow neo-button-hover text-center cursor-pointer">
                    Initialize Console
                </button>
            </form>
        </div>

        <!-- Footer Call -->
        <div class="mt-10 pt-6 border-t border-brand-charcoal/10 flex flex-col sm:flex-row justify-between items-center gap-4">
            <p id="lbl-no-account" class="text-sm font-medium text-brand-charcoal/70">Need support?</p>
            <a href="mailto:support@root-ed.org" id="link-support" class="px-5 py-2 bg-brand-cream neo-border neo-shadow-sm rounded-lg text-sm font-bold hover:bg-brand-cream/80 active:translate-y-0.5 active:shadow-none transition-all duration-150">
                Contact System Admins
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
                <span class="text-xs font-bold uppercase tracking-widest text-brand-charcoal/50">Admin Context Frame</span>
                <div id="culturalTag" class="flex items-center gap-1.5 px-3 py-1 text-xs font-bold uppercase tracking-wider rounded-full neo-border" style="background-color: var(--color-culture-igbo-bg); color: var(--color-culture-igbo);">
                    <span id="culturalTagIcon" class="inline-block w-2 h-2 rounded-full" style="background-color: var(--color-culture-igbo);"></span>
                    <span id="culturalTagText">IGBO</span>
                </div>
            </div>

            <!-- Mini Dashboard Card preview -->
            <div class="bg-white neo-border neo-shadow rounded-xl p-5 mb-6 relative z-10 transition-all duration-300 transform" id="roleCardPreview">
                <!-- Card Header -->
                <div class="flex justify-between items-center text-xs font-bold text-brand-charcoal/40 mb-3 uppercase tracking-wider">
                    <span>System Node &bull; RootED Admin</span>
                    <span id="badge-streak">Console Status</span>
                </div>
                
                <!-- Live Greeting -->
                <h3 id="preview-greet" class="font-serif text-3xl text-brand-charcoal font-bold tracking-tight mb-2 leading-tight">
                    Aliko Maikano.
                </h3>
                
                <!-- Live Sub-text -->
                <p id="preview-desc" class="text-sm font-medium text-brand-charcoal/70 mb-4 leading-relaxed">
                    All nodes running optimally. 3 culture-tag reviews pending approval.
                </p>
            </div>

            <!-- Cultural Micro-Fact card -->
            <div class="bg-white/50 neo-border neo-shadow-sm rounded-xl p-4 text-xs font-medium text-brand-charcoal/80 leading-relaxed mb-6">
                <span class="inline-block px-1.5 py-0.5 bg-brand-charcoal text-white rounded text-[10px] uppercase font-bold tracking-wider mb-2">Security Standard</span>
                <p id="fact-text">This console regulates localization translations and cultural tagging models. All database transactions are stored with cryptographic hashes to avoid data modification.</p>
            </div>
        </div>

        <!-- West African Traditional Geometric Pattern Container -->
        <div class="h-16 w-full neo-border rounded-xl bg-brand-charcoal text-brand-cream flex items-center justify-center overflow-hidden relative" id="chevronFooter">
            <div class="absolute inset-0 opacity-15" style="background-image: repeating-linear-gradient(45deg, var(--color-brand-cream), var(--color-brand-cream) 10px, transparent 10px, transparent 20px);"></div>
            <span class="font-serif italic text-lg tracking-wider relative z-10" id="motto-text">Aka aja aja na-ebute ọnụ mmanụ mmanụ</span>
        </div>

    </div>
</div>
@endsection

@section('scripts')
<script>
    // State management variables
    let currentLocale = 'en';

    // UI Dictionaries
    const translations = {
        en: {
            title: "Admin Console Access",
            subtitle: "Enter your administrative credentials to manage RootED system nodes, translations, and users.",
            lbl_email: "Admin Email Address",
            lbl_password: "Password",
            lbl_remember: "Remember this station",
            btn_submit: "Initialize Console",
            lbl_no_account: "Need support?",
            link_support: "Contact System Admins",
            admin_greet: "Aliko Maikano.",
            admin_desc: "All nodes running optimally. 3 culture-tag reviews pending approval.",
            motto: "Aka aja aja na-ebute ọnụ mmanụ mmanụ",
            fact: "This console regulates localization translations and cultural tagging models. All database transactions are stored with cryptographic hashes to avoid data modification."
        },
        yo: {
            title: "Iwọle Si Kọnsọlu Alakoso",
            subtitle: "Tẹ awọn alaye alakoso rẹ sii lati ṣakoso awọn apa eto RootED, awọn itumọ, ati awọn olumulo.",
            lbl_email: "Àdírẹ́sì Imeeli Alakoso",
            lbl_password: "Ọ̀rọ̀-ìpamọ́",
            lbl_remember: "Ranti ibudo yii",
            btn_submit: "Bẹrẹ Kọnsọlu",
            lbl_no_account: "Nilo atilẹyin?",
            link_support: "Kan si Alakoso Eto",
            admin_greet: "Aliko Maikano.",
            admin_desc: "Gbogbo awọn ọna ṣiṣe n ṣiṣẹ daradara. Awọn atunwo ede 3 n duro de ifọwọsi.",
            motto: "Ìmọ̀ kò lọ́pin",
            fact: "Kọnsọlu yii n ṣakoso awọn itumọ isọdibilẹ ati awọn awoṣe isọdọtun aṣa. Gbogbo awọn iṣowo data ti wa ni ipamọ pẹlu awọn hash cryptographic."
        },
        ha: {
            title: "Shiga Kwamitin Gudanarwa",
            subtitle: "Shigar da bayanan gudanarwa don sarrafa nodes na RootED, fassarori, da masu amfani.",
            lbl_email: "Adireshin Imel na Gudanarwa",
            lbl_password: "Kalmar sirri",
            lbl_remember: "Tuna wannan tashar",
            btn_submit: "Fara Gudanarwa",
            lbl_no_account: "Kuna buƙatar tallafi?",
            link_support: "Tuntuɓi Masu Gudanarwa",
            admin_greet: "Aliko Maikano.",
            admin_desc: "Dukkanin ayyuka suna gudana lami lafiya. Tace harsuna 3 na jiran yardar ku.",
            motto: "Ilimi shi ne jagora",
            fact: "Wannan kwamitin yana sarrafa fassarar gida da samfuran tagging na al'ada. Duk ma'amalar bayanai ana adana su da hashes cryptographic."
        },
        ig: {
            title: "Nnweta Portal Nchịkwa",
            subtitle: "Tinye nzere nchịkwa gị iji jikwaa modul RootED, nsụgharị, na ndị ọrụ.",
            lbl_email: "Adreesị Imeelụ Nchịkwa",
            lbl_password: "Okwuntughe",
            lbl_remember: "Cheta ebe a",
            btn_submit: "Malite Njikwa",
            lbl_no_account: "Chọrọ enyemaka?",
            link_support: "Kpọtụrụ Nchịkwa Sistemụ",
            admin_greet: "Aliko Maikano.",
            admin_desc: "Sistemụ niile na-arụ ọrụ nke ọma. Nyocha omenala 3 na-eche nkwado gị.",
            motto: "Aka aja aja na-ebute ọnụ mmanụ mmanụ",
            fact: "Njikwa a na-achịkwa nsụgharị mpaghara na ụdị omenala. A na-echekwa azụmahịa data niile na nchebe cryptographic hashes."
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
        document.getElementById('page-subtitle').textContent = translations[lang].subtitle;
        document.getElementById('lbl-email').textContent = translations[lang].lbl_email;
        document.getElementById('lbl-password').textContent = translations[lang].lbl_password;
        document.getElementById('lbl-remember').textContent = translations[lang].lbl_remember;
        document.getElementById('btn-submit').textContent = translations[lang].btn_submit;
        document.getElementById('lbl-no-account').textContent = translations[lang].lbl_no_account;
        document.getElementById('link-support').textContent = translations[lang].link_support;
        
        // Update Preview Cards Content
        document.getElementById('motto-text').textContent = translations[lang].motto;
        document.getElementById('fact-text').textContent = translations[lang].fact;
        
        document.getElementById('preview-greet').textContent = translations[lang].admin_greet;
        document.getElementById('preview-desc').textContent = translations[lang].admin_desc;
    }
</script>
@endsection
