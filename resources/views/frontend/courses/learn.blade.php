<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $course->title }} — EdTech Pro</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .sidebar-scroll::-webkit-scrollbar { width: 4px; }
        .sidebar-scroll::-webkit-scrollbar-track { background: #f3f4f6; }
        .sidebar-scroll::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 10px; }
    </style>
</head>
<body class="bg-gray-950 text-white flex flex-col h-screen overflow-hidden" x-data="{ sidebarOpen: true, activeTab: 'overview' }">

    <!-- Minimal Top Nav -->
    <header class="flex-shrink-0 flex items-center justify-between px-6 py-3 bg-gray-900/80 backdrop-blur-md border-b border-white/10 z-10">
        <div class="flex items-center gap-6">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                <div class="w-7 h-7 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
                <span class="font-black text-white">EdTech <span class="text-indigo-400">Pro</span></span>
            </a>
            <div class="hidden sm:flex flex-col leading-tight">
                <span class="text-white font-bold text-sm truncate max-w-xs">{{ Str::limit($course->title, 45) }}</span>
                <div class="flex items-center gap-2 mt-0.5">
                    <div class="w-full bg-gray-700 rounded-full h-1.5 w-32">
                        <div class="bg-indigo-500 h-1.5 rounded-full" style="width: 64%"></div>
                    </div>
                    <span class="text-gray-400 text-xs font-semibold">64%</span>
                </div>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <button @click="sidebarOpen = !sidebarOpen" class="hidden sm:flex items-center gap-2 px-3 py-1.5 bg-white/10 hover:bg-white/20 rounded-lg text-sm font-semibold text-gray-300 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path></svg>
                <span x-text="sidebarOpen ? 'Hide Curriculum' : 'Show Curriculum'"></span>
            </button>
            <a href="{{ route('courses.show', $course->slug) }}" class="flex items-center gap-2 px-4 py-2 bg-white/10 hover:bg-white/20 rounded-xl text-sm font-bold text-white transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Exit
            </a>
        </div>
    </header>

    <!-- Main Body: Video + Sidebar -->
    <div class="flex flex-1 overflow-hidden">

        <!-- Left: Video Player Area -->
        <div class="flex-1 flex flex-col overflow-y-auto bg-gray-950">
            <!-- Video Player -->
            <div class="relative bg-black w-full" style="aspect-ratio: 16/9; max-height: 70vh;">
                <div class="absolute inset-0 flex flex-col items-center justify-center bg-gray-900">
                    <!-- Placeholder video thumbnail -->
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="w-20 h-20 bg-white/10 backdrop-blur-sm border-2 border-white/30 rounded-full flex items-center justify-center cursor-pointer hover:scale-110 transition-transform shadow-2xl">
                            <svg class="w-9 h-9 text-white ml-1.5" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4l12 6-12 6z"/></svg>
                        </div>
                    </div>
                    <div class="absolute bottom-0 left-0 right-0 p-2 bg-gradient-to-t from-black/80 via-black/30 to-transparent">
                        <!-- Video Controls -->
                        <div class="mb-2">
                            <div class="w-full bg-white/20 rounded-full h-1.5 cursor-pointer group">
                                <div class="bg-indigo-500 h-1.5 rounded-full relative" style="width: 25%">
                                    <div class="absolute right-0 top-1/2 -translate-y-1/2 w-3 h-3 bg-white rounded-full shadow-lg opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center justify-between px-1">
                            <div class="flex items-center gap-4">
                                <button class="text-white/80 hover:text-white transition">
                                    <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"/></svg>
                                </button>
                                <button class="text-white/80 hover:text-white transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072M12 6v12M8.464 8.464a5 5 0 000 7.072"></path></svg>
                                </button>
                                <span class="text-white/70 text-xs font-semibold tabular-nums">4:32 / 18:45</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <button class="text-white/70 hover:text-white text-xs font-bold transition">1x</button>
                                <button class="text-white/70 hover:text-white text-xs font-bold transition">HD</button>
                                <button class="text-white/80 hover:text-white transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path></svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabs Below Video -->
            <div class="bg-gray-900 flex-1">
                <div class="border-b border-white/10 px-6">
                    <div class="flex gap-1">
                        <button @click="activeTab = 'overview'" :class="activeTab === 'overview' ? 'border-indigo-500 text-white' : 'border-transparent text-gray-400 hover:text-gray-200'" class="px-5 py-4 text-sm font-bold border-b-2 transition-all -mb-px">Overview</button>
                        <button @click="activeTab = 'qa'" :class="activeTab === 'qa' ? 'border-indigo-500 text-white' : 'border-transparent text-gray-400 hover:text-gray-200'" class="px-5 py-4 text-sm font-bold border-b-2 transition-all -mb-px">Q&A</button>
                        <button @click="activeTab = 'resources'" :class="activeTab === 'resources' ? 'border-indigo-500 text-white' : 'border-transparent text-gray-400 hover:text-gray-200'" class="px-5 py-4 text-sm font-bold border-b-2 transition-all -mb-px">Resources</button>
                    </div>
                </div>
                <div class="p-6">
                    <div x-show="activeTab === 'overview'">
                        <h3 class="text-xl font-extrabold text-white mb-3">{{ $course->title }}</h3>
                        <p class="text-gray-400 leading-relaxed">{{ $course->description }}</p>
                        @if($course->instructor)
                        <div class="flex items-center gap-4 mt-6 p-4 bg-white/5 rounded-2xl border border-white/10">
                            <div class="w-12 h-12 rounded-xl bg-gradient-to-tr from-indigo-500 to-purple-600 text-white font-black text-lg flex items-center justify-center shadow-lg">
                                {{ strtoupper(substr($course->instructor->name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 font-semibold uppercase tracking-wider">Instructor</p>
                                <p class="text-white font-bold text-lg">{{ $course->instructor->name }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div x-show="activeTab === 'qa'" style="display:none;">
                        <div class="text-center py-12 text-gray-400">
                            <svg class="w-12 h-12 mx-auto mb-4 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                            <p class="font-semibold">No questions yet. Be the first to ask!</p>
                        </div>
                    </div>
                    <div x-show="activeTab === 'resources'" style="display:none;">
                        <div class="text-center py-12 text-gray-400">
                            <svg class="w-12 h-12 mx-auto mb-4 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                            <p class="font-semibold">No downloadable resources for this lesson.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Curriculum Sidebar -->
        <div x-show="sidebarOpen" x-transition class="w-80 shrink-0 bg-white flex flex-col border-l border-gray-100 overflow-hidden shadow-xl">
            <!-- Sidebar Header -->
            <div class="p-5 border-b border-gray-100">
                <h3 class="font-extrabold text-gray-900 text-base leading-snug">Course Content</h3>
                <p class="text-xs text-gray-400 mt-1">3/12 lessons completed</p>
                <div class="w-full bg-gray-100 rounded-full h-2 mt-3">
                    <div class="bg-indigo-600 h-2 rounded-full" style="width:25%"></div>
                </div>
            </div>

            <!-- Module List -->
            <div class="flex-1 overflow-y-auto sidebar-scroll" x-data="{ openModule: 1 }">
                
                <!-- Module 1 (Completed) -->
                <div class="border-b border-gray-50">
                    <button @click="openModule = openModule === 1 ? null : 1" class="w-full flex items-center justify-between px-5 py-4 bg-gray-50 hover:bg-gray-100 transition-colors">
                        <div class="text-left">
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Module 1</p>
                            <p class="font-bold text-sm text-gray-900 mt-0.5">Introduction</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-xs text-emerald-600 font-bold bg-emerald-50 px-2 py-0.5 rounded-md">Done</span>
                            <svg class="w-4 h-4 text-gray-400 transition-transform duration-200" :class="{ 'rotate-180': openModule === 1 }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </button>
                    <div x-show="openModule === 1" class="divide-y divide-gray-50">
                        @foreach(['Welcome & Overview', 'Setting Up Environment', 'Your First Component'] as $lesson)
                        <div class="flex items-center gap-3 px-5 py-3 bg-white hover:bg-gray-50 transition-colors cursor-pointer">
                            <div class="w-5 h-5 rounded-full bg-emerald-100 flex items-center justify-center shrink-0">
                                <svg class="w-3 h-3 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <span class="text-sm text-gray-500 flex-1 font-medium">{{ $lesson }}</span>
                            <span class="text-xs text-gray-400 font-semibold tabular-nums">8:24</span>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Module 2 (Active) -->
                <div class="border-b border-gray-50">
                    <button @click="openModule = openModule === 2 ? null : 2" class="w-full flex items-center justify-between px-5 py-4 bg-gray-50 hover:bg-gray-100 transition-colors">
                        <div class="text-left">
                            <p class="text-xs font-bold text-indigo-400 uppercase tracking-wider">Module 2</p>
                            <p class="font-bold text-sm text-gray-900 mt-0.5">Core Concepts</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-xs text-indigo-600 font-bold bg-indigo-50 px-2 py-0.5 rounded-md">2/5</span>
                            <svg class="w-4 h-4 text-gray-400 transition-transform duration-200" :class="{ 'rotate-180': openModule === 2 }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </button>
                    <div x-show="openModule === 2" class="divide-y divide-gray-50">
                        @foreach([
                            ['Props & State', true, false, '12:10'],
                            ['Event Handling', true, false, '10:32'],
                            ['Navigation & Routing', false, true, '18:45'],
                            ['Async & API Calls', false, false, '14:20'],
                            ['Custom Hooks', false, false, '11:05'],
                        ] as $lesson)
                        <div class="flex items-center gap-3 px-5 py-3 {{ $lesson[2] ? 'bg-indigo-50 border-l-2 border-indigo-500' : 'bg-white hover:bg-gray-50' }} transition-colors cursor-pointer">
                            @if($lesson[1])
                                <div class="w-5 h-5 rounded-full bg-emerald-100 flex items-center justify-center shrink-0">
                                    <svg class="w-3 h-3 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                            @elseif($lesson[2])
                                <div class="w-5 h-5 rounded-full bg-indigo-600 flex items-center justify-center shrink-0">
                                    <svg class="w-3 h-3 text-white ml-0.5" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4l12 6-12 6z"/></svg>
                                </div>
                            @else
                                <div class="w-5 h-5 rounded-full border-2 border-gray-200 flex items-center justify-center shrink-0">
                                    <svg class="w-3 h-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                </div>
                            @endif
                            <span class="text-sm flex-1 font-{{ $lesson[2] ? 'bold text-indigo-700' : ($lesson[1] ? 'medium text-gray-400' : 'medium text-gray-600') }}">{{ $lesson[0] }}</span>
                            <span class="text-xs text-gray-400 font-semibold tabular-nums">{{ $lesson[3] }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Module 3 (Locked) -->
                <div>
                    <button @click="openModule = openModule === 3 ? null : 3" class="w-full flex items-center justify-between px-5 py-4 bg-gray-50 hover:bg-gray-100 transition-colors">
                        <div class="text-left">
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Module 3</p>
                            <p class="font-bold text-sm text-gray-900 mt-0.5">Advanced Topics</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-xs text-gray-400 font-bold bg-gray-100 px-2 py-0.5 rounded-md">4 lessons</span>
                            <svg class="w-4 h-4 text-gray-400 transition-transform duration-200" :class="{ 'rotate-180': openModule === 3 }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </button>
                    <div x-show="openModule === 3" style="display:none;" class="divide-y divide-gray-50">
                        @foreach(['Animations', 'Performance Optimization', 'Testing', 'Deployment & Publishing'] as $lesson)
                        <div class="flex items-center gap-3 px-5 py-3 bg-white opacity-60 cursor-not-allowed">
                            <div class="w-5 h-5 rounded-full border-2 border-gray-200 flex items-center justify-center shrink-0">
                                <svg class="w-3 h-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </div>
                            <span class="text-sm text-gray-400 flex-1 font-medium">{{ $lesson }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
