@extends('layouts.app')

@section('title', 'RootED — Instructor Dashboard')

@section('content')
<div class="max-w-7xl mx-auto space-y-8">

    <!-- WELCOME HEADER SECTION -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end gap-6 pb-6 border-b border-brand-charcoal/10 relative">
        <div class="space-y-3">
            <!-- View Mode Tag -->
            <div class="flex items-center gap-2 text-[10px] font-bold text-brand-charcoal/40 uppercase tracking-widest">
                <span class="inline-block w-1.5 h-1.5 rounded-full bg-brand-charcoal/40"></span>
                <span>Instructor View &bull; {{ $user->name }}</span>
            </div>
            
            <!-- Headline -->
            <h1 class="font-serif text-4xl sm:text-5xl font-bold tracking-tight text-brand-charcoal leading-none">
                My courses
            </h1>
            
            <!-- Sub-headline -->
            <p class="text-sm font-medium text-brand-charcoal/70 max-w-xl">
                Publish, tag, and track engagement across your culturally-tagged content.
            </p>
        </div>

        <!-- CTA Buttons -->
        <div class="flex items-center gap-3">
            <a href="{{ route('instructor.courses.create') }}" class="px-5 py-2.5 bg-white border-2 border-brand-charcoal rounded-xl text-xs font-bold uppercase tracking-wider hover:bg-brand-cream/80 active:translate-y-[1px] transition-all shadow-sm">
                + New course
            </a>
            <a href="{{ route('instructor.content.create') }}" class="flex items-center gap-2 px-5 py-2.5 bg-brand-terracotta text-white font-bold uppercase tracking-wider rounded-xl neo-border neo-shadow neo-button-hover active:translate-y-[2px] active:shadow-sm transition-all duration-150">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                <span>New content</span>
            </a>
        </div>
    </div>

    {{-- Flash success message --}}
    @if(session('success'))
    <div id="flash-success" class="flex items-center gap-3 bg-[#E2F5EA] border border-[#2B8B5C]/30 text-[#2B8B5C] px-5 py-4 rounded-xl text-sm font-bold">
        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
        {{ session('success') }}
    </div>
    @endif

    <!-- STATS GRID -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        
        <!-- Stat 1 -->
        <div class="bg-white neo-border neo-shadow-sm rounded-xl p-6 hover:-translate-y-1 transition-transform flex flex-col justify-between min-h-[140px]">
            <p class="text-xs font-bold uppercase tracking-wider text-brand-charcoal/50">Active Courses</p>
            <div>
                <p class="font-serif text-5xl font-bold text-brand-charcoal leading-none mb-2">{{ $courses->count() }}</p>
                <p class="text-[10px] font-bold uppercase tracking-widest text-brand-charcoal/60">{{ $publishedCount }} Published &bull; {{ $draftCount }} Draft</p>
            </div>
        </div>

        <!-- Stat 2 -->
        <div class="bg-white neo-border neo-shadow-sm rounded-xl p-6 hover:-translate-y-1 transition-transform flex flex-col justify-between min-h-[140px]">
            <p class="text-xs font-bold uppercase tracking-wider text-brand-charcoal/50">Total Students</p>
            <div>
                <p class="font-serif text-5xl font-bold text-brand-charcoal leading-none mb-2">{{ number_format($totalStudents) }}</p>
                <p class="text-[10px] font-bold uppercase tracking-widest text-brand-charcoal/60">ACROSS ALL COURSES</p>
            </div>
        </div>

        <!-- Stat 3 -->
        <div class="bg-white neo-border neo-shadow-sm rounded-xl p-6 hover:-translate-y-1 transition-transform flex flex-col justify-between min-h-[140px]">
            <p class="text-xs font-bold uppercase tracking-wider text-brand-charcoal/50">Content Items</p>
            <div>
                <p class="font-serif text-5xl font-bold text-brand-charcoal leading-none mb-2">{{ number_format($totalContentItems) }}</p>
                <p class="text-[10px] font-bold uppercase tracking-widest text-brand-charcoal/60">ITEMS TOTAL</p>
            </div>
        </div>

        <!-- Stat 4 -->
        <div class="bg-white neo-border neo-shadow-sm rounded-xl p-6 hover:-translate-y-1 transition-transform flex flex-col justify-between min-h-[140px]">
            <p class="text-xs font-bold uppercase tracking-wider text-brand-charcoal/50">Avg. Completion</p>
            <div>
                <p class="font-serif text-5xl font-bold text-brand-charcoal leading-none mb-2">{{ $avgCompletion }}%</p>
                <p class="text-[10px] font-bold uppercase tracking-widest text-brand-charcoal/60">LAST 30 DAYS</p>
            </div>
        </div>
    </div>

    <!-- MAIN CONTENT LAYOUT -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
        
        <!-- Left: Course List Table (Takes 2 columns) -->
        <div class="lg:col-span-2 bg-white neo-border neo-shadow rounded-2xl overflow-hidden flex flex-col">
            <!-- Header -->
            <div class="bg-brand-cream border-b border-brand-charcoal/10 px-6 py-5 flex justify-between items-center">
                <h2 class="font-serif text-xl font-bold text-brand-charcoal">My courses</h2>
                <span class="text-[10px] font-bold uppercase tracking-wider text-brand-charcoal/50">{{ $courses->count() }} COURSES</span>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-brand-charcoal/10 text-[10px] font-bold uppercase tracking-wider text-brand-charcoal/50 bg-brand-cream/20">
                            <th class="px-6 py-5">Course</th>
                            <th class="px-6 py-5">Tag</th>
                            <th class="px-6 py-5">Lang</th>
                            <th class="px-6 py-5">Students</th>
                            <th class="px-6 py-5">Status</th>
                            <th class="px-6 py-5"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-brand-charcoal/5">
                        
                        @forelse($courses as $course)
                        <tr class="hover:bg-brand-cream/30 transition-colors group cursor-pointer" onclick="window.location='{{ route('instructor.courses.show', $course) }}'">
                            <td class="px-6 py-5">
                                <p class="font-bold text-sm text-brand-charcoal leading-snug">{{ $course->title }}</p>
                                <p class="text-[10px] font-medium text-brand-charcoal/50 mt-1.5 uppercase tracking-wider">{{ $course->modules_count }} MODULES</p>
                            </td>
                            <td class="px-6 py-5">
                                @if($course->tag === 'yoruba')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 text-[10px] font-bold uppercase rounded-full border border-culture-yoruba/30 bg-culture-yoruba-bg text-culture-yoruba">
                                        <span class="w-1.5 h-1.5 bg-culture-yoruba rotate-45"></span>
                                        Yoruba
                                    </span>
                                @elseif($course->tag === 'hausa')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 text-[10px] font-bold uppercase rounded-full border border-culture-hausa/30 bg-culture-hausa-bg text-culture-hausa">
                                        <span class="w-1.5 h-1.5 bg-culture-hausa"></span>
                                        Hausa
                                    </span>
                                @elseif($course->tag === 'igbo')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 text-[10px] font-bold uppercase rounded-full border border-culture-igbo/30 bg-culture-igbo-bg text-culture-igbo">
                                        <span class="w-1.5 h-1.5 border border-culture-igbo rounded-full"></span>
                                        Igbo
                                    </span>
                                @elseif($course->tag === 'northern_nigeria')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 text-[10px] font-bold uppercase rounded-full border border-[#1D70B8]/30 bg-[#F0F4F8] text-[#1D70B8]">
                                        <span class="w-1.5 h-1.5 bg-[#1D70B8] rotate-45"></span>
                                        Northern Nigeria
                                    </span>
                                @elseif($course->tag === 'panafrican')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 text-[10px] font-bold uppercase rounded-full border border-culture-panafrican/30 bg-culture-panafrican-bg text-culture-panafrican">
                                        <span class="w-1.5 h-1.5 bg-culture-panafrican rounded-full"></span>
                                        Pan-African
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 text-[10px] font-bold uppercase rounded-full border border-culture-universal/30 bg-culture-universal-bg text-culture-universal">
                                        <span class="w-1.5 h-1.5 border border-culture-universal rounded-sm"></span>
                                        Universal
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-5">
                                <div class="flex gap-1.5">
                                    @foreach($course->langs as $lang)
                                        <span class="w-7 h-5 rounded-md border border-brand-charcoal/20 text-[9px] flex items-center justify-center font-bold text-brand-charcoal bg-white">{{ $lang }}</span>
                                    @endforeach
                                </div>
                            </td>
                            <td class="px-6 py-5 font-serif font-bold text-base">{{ number_format($course->students_count) }}</td>
                            <td class="px-6 py-5">
                                {{-- Inline status toggle form --}}
                                <form action="{{ route('instructor.courses.toggle-status', $course) }}" method="POST" onclick="event.stopPropagation()">
                                    @csrf
                                    @if($course->status === 'Published')
                                        <button type="submit" title="Click to revert to Draft"
                                            class="px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider rounded border border-[#2B8B5C]/30 text-[#2B8B5C] bg-[#E2F5EA] hover:bg-[#d4f0df] transition-colors cursor-pointer">
                                            ✓ Published
                                        </button>
                                    @else
                                        <button type="submit" title="Click to Publish"
                                            class="px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider rounded border border-amber-400/50 text-amber-700 bg-amber-50 hover:bg-amber-100 transition-colors cursor-pointer">
                                            ⚡ Draft
                                        </button>
                                    @endif
                                </form>
                            </td>
                            <td class="px-6 py-5 text-right">
                                <a href="{{ route('instructor.courses.show', $course) }}" onclick="event.stopPropagation()" class="px-4 py-1.5 border-2 border-brand-charcoal/20 rounded-lg shadow-sm text-xs font-bold hover:bg-brand-cream hover:border-brand-charcoal/40 transition-colors">View</a>
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <p class="text-sm font-medium text-brand-charcoal/50">You haven't created any courses yet.</p>
                            </td>
                        </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>
        </div>

        <!-- Right: Sidebar Widget (Takes 1 column) -->
        <div class="lg:col-span-1 space-y-6">
            
            <!-- Content by Culture -->
            <div class="bg-brand-cream neo-border neo-shadow-sm rounded-xl p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="font-serif font-bold text-brand-charcoal text-lg">Content by culture</h3>
                    <span class="text-[9px] font-bold uppercase tracking-wider text-brand-charcoal/50">{{ $totalContentItems }} ITEMS</span>
                </div>

                @if($totalContentItems > 0)
                <div class="space-y-4">
                    <!-- Yoruba Progress -->
                    <div>
                        <div class="flex justify-between items-center mb-1">
                            <span class="inline-flex items-center gap-1 text-[8px] font-bold uppercase border border-culture-yoruba bg-white px-2 py-0.5 rounded text-culture-yoruba">
                                <span class="w-1 h-1 bg-culture-yoruba rotate-45"></span> Yoruba
                            </span>
                            <span class="text-xs font-serif font-bold">{{ $tagCounts['yoruba'] }}</span>
                        </div>
                        <div class="w-full h-1.5 bg-white border border-brand-charcoal/10 rounded-full overflow-hidden">
                            <div class="h-full bg-culture-yoruba" style="width: {{ ($tagCounts['yoruba'] / $totalContentItems) * 100 }}%"></div>
                        </div>
                    </div>

                    <!-- Hausa Progress -->
                    <div>
                        <div class="flex justify-between items-center mb-1">
                            <span class="inline-flex items-center gap-1 text-[8px] font-bold uppercase border border-culture-hausa bg-white px-2 py-0.5 rounded text-culture-hausa">
                                <span class="w-1 h-1 bg-culture-hausa"></span> Hausa
                            </span>
                            <span class="text-xs font-serif font-bold">{{ $tagCounts['hausa'] }}</span>
                        </div>
                        <div class="w-full h-1.5 bg-white border border-brand-charcoal/10 rounded-full overflow-hidden">
                            <div class="h-full bg-culture-hausa" style="width: {{ ($tagCounts['hausa'] / $totalContentItems) * 100 }}%"></div>
                        </div>
                    </div>

                    <!-- Igbo Progress -->
                    <div>
                        <div class="flex justify-between items-center mb-1">
                            <span class="inline-flex items-center gap-1 text-[8px] font-bold uppercase border border-culture-igbo bg-white px-2 py-0.5 rounded text-culture-igbo">
                                <span class="w-1 h-1 border border-culture-igbo rounded-full"></span> Igbo
                            </span>
                            <span class="text-xs font-serif font-bold">{{ $tagCounts['igbo'] }}</span>
                        </div>
                        <div class="w-full h-1.5 bg-white border border-brand-charcoal/10 rounded-full overflow-hidden">
                            <div class="h-full bg-culture-igbo" style="width: {{ ($tagCounts['igbo'] / $totalContentItems) * 100 }}%"></div>
                        </div>
                    </div>

                    <!-- Northern Nigeria Progress -->
                    <div>
                        <div class="flex justify-between items-center mb-1">
                            <span class="inline-flex items-center gap-1 text-[8px] font-bold uppercase border border-[#1D70B8] bg-white px-2 py-0.5 rounded text-[#1D70B8]">
                                <span class="w-1.5 h-1 bg-[#1D70B8] rotate-45"></span> Northern Nigeria
                            </span>
                            <span class="text-xs font-serif font-bold">{{ $tagCounts['northern_nigeria'] }}</span>
                        </div>
                        <div class="w-full h-1.5 bg-white border border-brand-charcoal/10 rounded-full overflow-hidden">
                            <div class="h-full bg-[#1D70B8]" style="width: {{ ($tagCounts['northern_nigeria'] / $totalContentItems) * 100 }}%"></div>
                        </div>
                    </div>

                    <!-- Pan-African Progress -->
                    <div>
                        <div class="flex justify-between items-center mb-1">
                            <span class="inline-flex items-center gap-1 text-[8px] font-bold uppercase border border-culture-panafrican bg-white px-2 py-0.5 rounded text-culture-panafrican">
                                <span class="w-1 h-1 bg-culture-panafrican rounded-full"></span> Pan-African
                            </span>
                            <span class="text-xs font-serif font-bold">{{ $tagCounts['panafrican'] }}</span>
                        </div>
                        <div class="w-full h-1.5 bg-white border border-brand-charcoal/10 rounded-full overflow-hidden">
                            <div class="h-full bg-culture-panafrican" style="width: {{ ($tagCounts['panafrican'] / $totalContentItems) * 100 }}%"></div>
                        </div>
                    </div>

                    <!-- Universal Progress -->
                    <div>
                        <div class="flex justify-between items-center mb-1">
                            <span class="inline-flex items-center gap-1 text-[8px] font-bold uppercase border border-culture-universal bg-white px-2 py-0.5 rounded text-culture-universal">
                                <span class="w-1 h-1 border border-culture-universal rounded-sm"></span> Universal
                            </span>
                            <span class="text-xs font-serif font-bold">{{ $tagCounts['universal'] }}</span>
                        </div>
                        <div class="w-full h-1.5 bg-white border border-brand-charcoal/10 rounded-full overflow-hidden">
                            <div class="h-full bg-culture-universal" style="width: {{ ($tagCounts['universal'] / $totalContentItems) * 100 }}%"></div>
                        </div>
                    </div>
                </div>
                @else
                <div class="py-8 text-center border border-dashed border-brand-charcoal/20 rounded-xl">
                    <p class="text-sm font-medium text-brand-charcoal/50">No content found.</p>
                </div>
                @endif

                <!-- Suggestion Card -->
                @if($courses->count() > 0)
                <div class="mt-6 p-4 bg-culture-igbo-bg/50 border border-culture-igbo/30 rounded-xl">
                    <p class="text-[9px] font-bold uppercase tracking-wider flex items-center gap-1.5 text-brand-charcoal/60 mb-2">
                        <span class="w-1.5 h-1.5 bg-culture-igbo rounded-full animate-pulse"></span>
                        Suggestion
                    </p>
                    <p class="text-xs font-medium text-brand-charcoal leading-relaxed">
                        Add Igbo-tagged content to <strong>Web Development</strong> — 22% of enrolled students prefer Igbo.
                    </p>
                </div>
                @endif
            </div>

        </div>
    </div>

</div>
@endsection
