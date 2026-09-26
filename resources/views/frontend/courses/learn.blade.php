<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $course->title }} — EdTech Pro</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .sidebar-scroll::-webkit-scrollbar { width: 4px; }
        .sidebar-scroll::-webkit-scrollbar-track { background: #f3f4f6; }
        .sidebar-scroll::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 10px; }
    </style>
</head>
<body class="bg-gray-950 text-white flex flex-col h-screen overflow-hidden"
      x-data="{ sidebarOpen: true, activeTab: 'overview' }">

    <!-- Minimal Top Nav -->
    <header class="flex-shrink-0 flex items-center justify-between px-6 py-3 bg-gray-900/80 backdrop-blur-md border-b border-white/10 z-10">
        <div class="flex items-center gap-6">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                <div class="w-7 h-7 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center shadow-md">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
                <span class="font-black text-white hidden md:block">EdTech <span class="text-indigo-400">Pro</span></span>
            </a>
            <div class="hidden sm:flex flex-col leading-tight">
                <span class="text-white font-bold text-sm truncate max-w-xs md:max-w-sm">{{ Str::limit($course->title, 50) }}</span>
                <div class="flex items-center gap-2 mt-0.5">
                    <div class="bg-gray-700 rounded-full h-1.5 w-32">
                        <div class="bg-indigo-500 h-1.5 rounded-full transition-all duration-500" style="width: {{ $progressPercent }}%"></div>
                    </div>
                    <span class="text-gray-400 text-xs font-semibold">{{ $progressPercent }}%</span>
                </div>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <button @click="sidebarOpen = !sidebarOpen" class="hidden sm:flex items-center gap-2 px-3 py-1.5 bg-white/10 hover:bg-white/20 rounded-lg text-sm font-semibold text-gray-300 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path></svg>
                <span x-text="sidebarOpen ? 'Hide Curriculum' : 'Show Curriculum'" class="hidden md:block"></span>
            </button>
            <a href="{{ route('courses.show', $course->slug) }}" class="flex items-center gap-2 px-4 py-2 bg-white/10 hover:bg-white/20 rounded-xl text-sm font-bold text-white transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                <span class="hidden sm:block">Exit</span>
            </a>
        </div>
    </header>

    <!-- Body -->
    <div class="flex flex-1 overflow-hidden">

        <!-- Left: Video + Tabs -->
        <div class="flex-1 flex flex-col overflow-y-auto bg-gray-950">

            <!-- Video Player -->
            <div class="bg-black w-full" style="aspect-ratio:16/9; max-height:68vh;">
                <div class="w-full h-full flex flex-col items-center justify-center bg-gray-900 relative">
                    <!-- Play button placeholder -->
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="w-20 h-20 bg-white/10 backdrop-blur-sm border-2 border-white/30 rounded-full flex items-center justify-center cursor-pointer hover:scale-110 transition-transform shadow-2xl hover:bg-white/20">
                            <svg class="w-9 h-9 text-white ml-1.5" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4l12 6-12 6z"/></svg>
                        </div>
                    </div>
                    <!-- Controls bar -->
                    <div class="absolute bottom-0 left-0 right-0 p-3 bg-gradient-to-t from-black/80 via-black/30 to-transparent">
                        <div class="mb-2">
                            <div class="w-full bg-white/20 rounded-full h-1.5 cursor-pointer group">
                                <div class="bg-indigo-500 h-1.5 rounded-full" style="width:0%"></div>
                            </div>
                        </div>
                        <div class="flex items-center justify-between px-1">
                            <div class="flex items-center gap-4">
                                <button class="text-white/80 hover:text-white transition">
                                    <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"/></svg>
                                </button>
                                <span class="text-white/70 text-xs font-semibold tabular-nums">0:00 / 0:00</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="text-white/70 hover:text-white text-xs font-bold cursor-pointer transition">1x</span>
                                <button class="text-white/80 hover:text-white transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path></svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabs -->
            <div class="bg-gray-900 flex-1">
                <div class="border-b border-white/10 px-6">
                    <div class="flex gap-1">
                        @foreach(['overview' => 'Overview', 'qa' => 'Q&A', 'resources' => 'Resources'] as $key => $label)
                        <button @click="activeTab = '{{ $key }}'"
                                :class="activeTab === '{{ $key }}' ? 'border-indigo-500 text-white' : 'border-transparent text-gray-400 hover:text-gray-200'"
                                class="px-5 py-4 text-sm font-bold border-b-2 transition-all -mb-px">
                            {{ $label }}
                        </button>
                        @endforeach
                    </div>
                </div>
                <div class="p-6 max-w-3xl">
                    <!-- Overview Tab -->
                    <div x-show="activeTab === 'overview'">
                        <h3 class="text-xl font-extrabold text-white mb-3">{{ $course->title }}</h3>
                        @if($course->description)
                            <p class="text-gray-400 leading-relaxed mb-6">{{ $course->description }}</p>
                        @endif

                        <!-- Course Stats -->
                        <div class="grid grid-cols-3 gap-4 mb-6">
                            <div class="bg-white/5 rounded-2xl p-4 text-center border border-white/10">
                                <div class="text-2xl font-black text-white">{{ $totalLessons }}</div>
                                <div class="text-xs text-gray-400 mt-1 font-medium">Total Lessons</div>
                            </div>
                            <div class="bg-white/5 rounded-2xl p-4 text-center border border-white/10">
                                <div class="text-2xl font-black text-emerald-400">{{ $completedCount }}</div>
                                <div class="text-xs text-gray-400 mt-1 font-medium">Completed</div>
                            </div>
                            <div class="bg-white/5 rounded-2xl p-4 text-center border border-white/10">
                                <div class="text-2xl font-black text-indigo-400">{{ $progressPercent }}%</div>
                                <div class="text-xs text-gray-400 mt-1 font-medium">Progress</div>
                            </div>
                        </div>

                        @if($course->instructor)
                        <div class="flex items-center gap-4 p-5 bg-white/5 rounded-2xl border border-white/10">
                            <div class="w-12 h-12 rounded-xl bg-gradient-to-tr from-indigo-500 to-purple-600 text-white font-black text-lg flex items-center justify-center shadow-lg">
                                {{ strtoupper(substr($course->instructor->name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 font-semibold uppercase tracking-wider mb-0.5">Your Instructor</p>
                                <p class="text-white font-bold text-lg">{{ $course->instructor->name }}</p>
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Q&A Tab -->
                    <div x-show="activeTab === 'qa'" style="display:none;">
                        <div class="text-center py-12 text-gray-400">
                            <svg class="w-12 h-12 mx-auto mb-4 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                            <p class="font-semibold text-lg">No questions yet</p>
                            <p class="text-sm mt-1">Be the first to ask a question about this lesson!</p>
                        </div>
                    </div>

                    <!-- Resources Tab -->
                    <div x-show="activeTab === 'resources'" style="display:none;">
                        <div class="text-center py-12 text-gray-400">
                            <svg class="w-12 h-12 mx-auto mb-4 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                            <p class="font-semibold text-lg">No resources yet</p>
                            <p class="text-sm mt-1">The instructor hasn't added downloadable resources.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Dynamic Curriculum Sidebar -->
        <div x-show="sidebarOpen" x-transition class="w-80 shrink-0 bg-white flex flex-col border-l border-gray-100 overflow-hidden shadow-xl">
            <!-- Header -->
            <div class="p-5 border-b border-gray-100 bg-gray-50">
                <h3 class="font-extrabold text-gray-900 text-base">Course Content</h3>
                <p class="text-xs text-gray-400 mt-1">{{ $completedCount }} / {{ $totalLessons }} lessons completed</p>
                <div class="w-full bg-gray-200 rounded-full h-2 mt-3">
                    <div class="bg-indigo-600 h-2 rounded-full transition-all duration-500" style="width:{{ $progressPercent }}%"></div>
                </div>
            </div>

            <!-- Module Accordion -->
            <div class="flex-1 overflow-y-auto sidebar-scroll" x-data="{ openModule: {{ $course->modules->first()->id ?? 'null' }} }">

                @forelse($course->modules->sortBy('order') as $module)
                @php
                    $moduleLessons = $module->lessons->sortBy('order');
                    $moduleTotal = $moduleLessons->count();
                    $moduleCompleted = $moduleLessons->filter(fn($l) => in_array($l->id, $completedLessonIds))->count();
                    $isModuleDone = $moduleTotal > 0 && $moduleCompleted === $moduleTotal;
                @endphp

                <div class="border-b border-gray-100">
                    <button @click="openModule = openModule === {{ $module->id }} ? null : {{ $module->id }}"
                            class="w-full flex items-center justify-between px-5 py-4 bg-gray-50 hover:bg-gray-100 transition-colors text-left">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-wider {{ $isModuleDone ? 'text-emerald-500' : 'text-indigo-400' }} mb-0.5">
                                Module {{ $loop->iteration }}
                            </p>
                            <p class="font-bold text-sm text-gray-900">{{ $module->title }}</p>
                        </div>
                        <div class="flex items-center gap-2 shrink-0 ml-2">
                            @if($isModuleDone)
                                <span class="text-xs text-emerald-600 font-bold bg-emerald-50 px-2 py-0.5 rounded-md">Done</span>
                            @else
                                <span class="text-xs text-gray-500 font-bold bg-gray-100 px-2 py-0.5 rounded-md">{{ $moduleCompleted }}/{{ $moduleTotal }}</span>
                            @endif
                            <svg class="w-4 h-4 text-gray-400 transition-transform duration-200"
                                 :class="{ 'rotate-180': openModule === {{ $module->id }} }"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </button>

                    <div x-show="openModule === {{ $module->id }}" class="divide-y divide-gray-50">
                        @forelse($moduleLessons as $lesson)
                        @php $isDone = in_array($lesson->id, $completedLessonIds); @endphp
                        <div class="flex items-center gap-3 px-5 py-3 {{ $isDone ? 'bg-white' : 'bg-white hover:bg-gray-50' }} transition-colors cursor-pointer group">
                            <!-- Status icon -->
                            @if($isDone)
                                <div class="w-5 h-5 rounded-full bg-emerald-100 flex items-center justify-center shrink-0">
                                    <svg class="w-3 h-3 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                            @else
                                <div class="w-5 h-5 rounded-full border-2 border-gray-200 bg-gray-50 flex items-center justify-center shrink-0 group-hover:border-indigo-300 transition-colors">
                                    <svg class="w-3 h-3 text-gray-300 group-hover:text-indigo-400 transition-colors" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4l12 6-12 6z"/></svg>
                                </div>
                            @endif

                            <span class="text-sm flex-1 font-medium {{ $isDone ? 'text-gray-400 line-through' : 'text-gray-700' }} leading-snug">
                                {{ $lesson->title }}
                            </span>

                            @if($lesson->duration_seconds)
                                <span class="text-xs text-gray-400 font-semibold tabular-nums shrink-0">
                                    {{ gmdate('i:s', $lesson->duration_seconds) }}
                                </span>
                            @endif
                        </div>
                        @empty
                        <div class="px-5 py-4 text-sm text-gray-400 italic">No lessons in this module yet.</div>
                        @endforelse
                    </div>
                </div>
                @empty
                <div class="flex flex-col items-center justify-center h-full p-8 text-center text-gray-400">
                    <svg class="w-12 h-12 mb-4 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    <p class="font-semibold">No curriculum yet</p>
                    <p class="text-xs mt-1">The instructor is still building the curriculum.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</body>
</html>
