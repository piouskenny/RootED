@extends('layouts.app')

@section('title', 'RootED — Admin Dashboard')

@section('content')
<div class="max-w-7xl mx-auto space-y-8">

    <!-- WELCOME HEADER SECTION -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end gap-6 pb-6 border-b border-brand-charcoal/10 relative">
        <div class="space-y-3">
            <!-- View Mode Tag -->
            <div class="flex items-center gap-2 text-[10px] font-bold text-brand-charcoal/40 uppercase tracking-widest">
                <span class="inline-block w-1.5 h-1.5 border border-brand-charcoal/40 rounded-sm"></span>
                <span>Admin &bull; {{ $user->name }}</span>
            </div>
            
            <!-- Headline -->
            <h1 class="font-serif text-4xl sm:text-5xl font-bold tracking-tight text-brand-charcoal leading-none">
                Users
            </h1>
            
            <!-- Sub-headline -->
            <p class="text-sm font-medium text-brand-charcoal/70 max-w-xl">
                Manage accounts, role assignments, and locale preferences.
            </p>
        </div>

        <!-- CTA Buttons -->
        <div class="flex items-center gap-3">
            <button class="flex items-center gap-2 px-5 py-2.5 bg-white border-2 border-brand-charcoal rounded-xl text-xs font-bold uppercase tracking-wider hover:bg-brand-cream/80 active:translate-y-[1px] transition-all shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                <span>Export CSV</span>
            </button>
            <button class="flex items-center gap-2 px-5 py-2.5 bg-brand-terracotta text-white font-bold uppercase tracking-wider rounded-xl neo-border neo-shadow neo-button-hover active:translate-y-[2px] active:shadow-sm transition-all duration-150">
                <span>+ New user</span>
            </button>
        </div>
    </div>

    <!-- MAIN TABLE SECTION -->
    <div class="bg-white neo-border neo-shadow rounded-2xl overflow-hidden flex flex-col">
        
        <!-- Table Toolbar -->
        <div class="p-6 border-b border-brand-charcoal/10 flex flex-col sm:flex-row justify-between items-center gap-4 bg-brand-cream/40">
            <!-- Search -->
            <div class="relative w-full sm:w-96">
                <input type="text" placeholder="Search users..." class="w-full pl-10 pr-4 py-2.5 bg-white neo-border rounded-xl text-sm font-medium placeholder-brand-charcoal/40 focus:outline-none focus:ring-2 focus:ring-brand-charcoal/20">
                <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none text-brand-charcoal/40">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                </div>
            </div>

            <!-- Filters -->
            <div class="flex items-center gap-2">
                <button class="px-3 py-1.5 bg-brand-charcoal text-white rounded-lg text-[10px] font-bold uppercase tracking-wider neo-border-sm">All</button>
                <button class="px-3 py-1.5 bg-white text-brand-charcoal/60 hover:bg-brand-cream rounded-lg border-2 border-transparent text-[10px] font-bold uppercase tracking-wider transition-colors">Learners</button>
                <button class="px-3 py-1.5 bg-white text-brand-charcoal/60 hover:bg-brand-cream rounded-lg border-2 border-transparent text-[10px] font-bold uppercase tracking-wider transition-colors">Instructors</button>
                <button class="px-3 py-1.5 bg-white text-brand-charcoal/60 hover:bg-brand-cream rounded-lg border-2 border-transparent text-[10px] font-bold uppercase tracking-wider transition-colors">Admins</button>
            </div>
        </div>

        <!-- Table Data -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-[800px]">
                <thead>
                    <tr class="border-b border-brand-charcoal/10 text-[9px] font-bold uppercase tracking-wider text-brand-charcoal/50 bg-brand-cream/20">
                        <th class="px-6 py-4">Name</th>
                        <th class="px-6 py-4">Email</th>
                        <th class="px-6 py-4">Role</th>
                        <th class="px-6 py-4">Locale</th>
                        <th class="px-6 py-4">Joined</th>
                        <th class="px-6 py-4"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-brand-charcoal/5">
                    
                    @forelse($usersList as $listUser)
                    <tr class="hover:bg-brand-cream/30 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full border border-brand-charcoal bg-brand-cream flex items-center justify-center text-xs font-bold font-serif text-brand-charcoal">{{ strtoupper(substr($listUser->name, 0, 1)) }}</div>
                                <span class="font-bold text-sm text-brand-charcoal">{{ $listUser->name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-xs font-medium text-brand-charcoal/70 uppercase tracking-widest">{{ $listUser->email }}</span>
                        </td>
                        <td class="px-6 py-4">
                            @if($listUser->role === 'admin')
                                <span class="px-2.5 py-1 text-[9px] font-bold uppercase tracking-wider rounded-md border border-[#F4A8C8]/50 bg-[#FCE8F0] text-[#B02868]">Admin</span>
                            @elseif($listUser->role === 'instructor')
                                <span class="px-2.5 py-1 text-[9px] font-bold uppercase tracking-wider rounded-md border border-culture-hausa/30 bg-culture-hausa-bg text-[#A06000]">Instructor</span>
                            @else
                                <span class="px-2.5 py-1 text-[9px] font-bold uppercase tracking-wider rounded-md border border-brand-charcoal/20 bg-brand-charcoal/5 text-brand-charcoal/60">Learner</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-xs font-bold text-brand-charcoal">{{ strtoupper($listUser->locale) }}-NG</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-xs font-medium text-brand-charcoal/60 font-mono">{{ $listUser->created_at->format('Y-m-d') }}</span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2 opacity-60 group-hover:opacity-100 transition-opacity">
                                <button class="w-7 h-7 rounded border border-brand-charcoal/20 flex items-center justify-center hover:bg-brand-cream hover:text-brand-charcoal transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                                </button>
                                <button class="w-7 h-7 rounded border border-brand-charcoal/20 flex items-center justify-center hover:bg-culture-yoruba-bg hover:text-culture-yoruba transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-sm font-medium text-brand-charcoal/50">
                            No users found.
                        </td>
                    </tr>
                    @endforelse

                </tbody>
            </table>
        </div>

        <!-- Pagination / Footer -->
        <div class="px-6 py-4 border-t border-brand-charcoal/10 flex justify-between items-center text-[10px] font-bold uppercase tracking-wider text-brand-charcoal/50">
            <span>Showing {{ $usersList->firstItem() ?? 0 }} to {{ $usersList->lastItem() ?? 0 }} of {{ $usersList->total() }}</span>
            <div class="flex items-center gap-4">
                @if(!$usersList->onFirstPage())
                    <a href="{{ $usersList->previousPageUrl() }}" class="hover:text-brand-charcoal">Prev</a>
                @endif
                <span>Page {{ $usersList->currentPage() }} / {{ $usersList->lastPage() }}</span>
                @if($usersList->hasMorePages())
                    <a href="{{ $usersList->nextPageUrl() }}" class="hover:text-brand-charcoal">Next</a>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection
