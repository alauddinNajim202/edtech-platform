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

            <!-- Video Player Area -->
            <div class="bg-black w-full flex-shrink-0" style="aspect-ratio:16/9; max-height:68vh;">
                @if($activeLesson)
                    @if($activeLesson->video_path)
                        <video class="w-full h-full" controls controlsList="nodownload" oncontextmenu="return false;">
                            <source src="{{ asset('storage/' . $activeLesson->video_path) }}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    @else
                        <div class="w-full h-full flex flex-col items-center justify-center bg-gray-900 border-b border-white/10">
                            <svg class="w-16 h-16 text-gray-700 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                            <p class="text-gray-400 font-semibold text-lg">Video coming soon</p>
                            <p class="text-sm text-gray-600 mt-2">The instructor hasn't uploaded a video for this lesson yet.</p>
                        </div>
                    @endif
                @else
                    <div class="w-full h-full flex flex-col items-center justify-center bg-gray-900 border-b border-white/10">
                        <svg class="w-16 h-16 text-indigo-500/50 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <p class="text-gray-300 font-bold text-xl">{{ $course->title }}</p>
                        <p class="text-gray-500 mt-2 text-sm">Select a lesson from the curriculum to start learning.</p>
                    </div>
                @endif
            </div>

            <!-- Action Bar -->
            @if($activeLesson)
            <div class="bg-gray-800 border-b border-white/10 px-6 py-4 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div>
                    <h2 class="text-xl font-bold text-white">{{ $activeLesson->title }}</h2>
                    <p class="text-sm text-gray-400 mt-0.5">Module: {{ $activeLesson->module->title }}</p>
                </div>
                
                @if(!in_array($activeLesson->id, $completedLessonIds))
                    <form action="{{ route('courses.lesson.complete', ['course' => $course->slug, 'lesson' => $activeLesson->id]) }}" method="POST">
                        @csrf
                        @if($nextLesson)
                            <input type="hidden" name="next_lesson_id" value="{{ $nextLesson->id }}">
                        @endif
                        <button type="submit" class="bg-emerald-600 hover:bg-emerald-500 text-white font-bold py-2.5 px-6 rounded-xl transition-all shadow-lg shadow-emerald-900/50 flex items-center gap-2 text-sm whitespace-nowrap">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            Mark Complete & Continue
                        </button>
                    </form>
                @else
                    <div class="flex items-center gap-3">
                        <span class="text-emerald-400 font-bold text-sm flex items-center gap-1.5 bg-emerald-400/10 px-3 py-1.5 rounded-lg">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            Completed
                        </span>
                        @if($nextLesson)
                        <a href="{{ route('courses.learn', ['course' => $course->slug, 'lesson' => $nextLesson->id]) }}" class="bg-white/10 hover:bg-white/20 text-white font-bold py-2 px-5 rounded-xl transition-all text-sm flex items-center gap-1.5">
                            Next Lesson
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </a>
                        @endif
                    </div>
                @endif
            </div>
            @endif

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
                        <h3 class="text-xl font-extrabold text-white mb-3">About this course</h3>
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
                        @if($activeLesson)
                            <div class="mb-8">
                                <h3 class="text-xl font-bold text-white mb-4">Ask a Question</h3>
                                <form action="{{ route('questions.store', $activeLesson->id) }}" method="POST">
                                    @csrf
                                    <div class="flex gap-4 items-start">
                                        <div class="w-10 h-10 rounded-full bg-indigo-600 flex items-center justify-center text-white font-bold shrink-0">
                                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                        </div>
                                        <div class="flex-1">
                                            <textarea name="body" rows="3" class="w-full bg-gray-900 border border-white/10 rounded-xl p-3 text-white placeholder-gray-500 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-colors" placeholder="What's your question about this lesson?" required></textarea>
                                            <div class="mt-2 flex justify-end">
                                                <button type="submit" class="bg-indigo-600 hover:bg-indigo-500 text-white font-semibold py-2 px-6 rounded-lg transition-colors">Post Question</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="space-y-6">
                                <h3 class="text-lg font-bold text-white border-b border-white/10 pb-3">{{ $activeLesson->questions->count() }} Questions</h3>
                                
                                @forelse($activeLesson->questions as $question)
                                    <div class="flex gap-4">
                                        <div class="w-10 h-10 rounded-full bg-gray-700 flex items-center justify-center text-gray-300 font-bold shrink-0">
                                            {{ strtoupper(substr($question->user->name, 0, 1)) }}
                                        </div>
                                        <div class="flex-1">
                                            <div class="bg-white/5 rounded-2xl rounded-tl-none p-4 border border-white/10">
                                                <div class="flex justify-between items-center mb-1">
                                                    <span class="font-bold text-white">{{ $question->user->name }}</span>
                                                    <span class="text-xs text-gray-500">{{ $question->created_at->diffForHumans() }}</span>
                                                </div>
                                                <p class="text-gray-300 whitespace-pre-wrap text-sm leading-relaxed">{{ $question->body }}</p>
                                            </div>

                                            <!-- Replies -->
                                            <div class="mt-4 space-y-4 ml-2 border-l-2 border-white/10 pl-4">
                                                @foreach($question->replies as $reply)
                                                    <div class="flex gap-3">
                                                        <div class="w-8 h-8 rounded-full bg-gray-700 flex items-center justify-center text-gray-300 font-bold text-xs shrink-0">
                                                            {{ strtoupper(substr($reply->user->name, 0, 1)) }}
                                                        </div>
                                                        <div class="flex-1">
                                                            <div class="bg-white/5 rounded-2xl rounded-tl-none p-3 border border-white/10">
                                                                <div class="flex justify-between items-center mb-1">
                                                                    <span class="font-bold text-white text-sm">
                                                                        {{ $reply->user->name }} 
                                                                        @if($reply->user_id === $course->instructor_id)
                                                                            <span class="ml-2 text-[10px] bg-indigo-500/20 text-indigo-400 px-2 py-0.5 rounded-full uppercase tracking-wider font-bold">Instructor</span>
                                                                        @endif
                                                                    </span>
                                                                    <span class="text-xs text-gray-500">{{ $reply->created_at->diffForHumans() }}</span>
                                                                </div>
                                                                <p class="text-gray-300 whitespace-pre-wrap text-sm">{{ $reply->body }}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach

                                                <!-- Reply Form -->
                                                <form action="{{ route('replies.store', $question->id) }}" method="POST" class="flex gap-3 mt-4">
                                                    @csrf
                                                    <div class="w-8 h-8 rounded-full bg-indigo-600 flex items-center justify-center text-white font-bold text-xs shrink-0">
                                                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                                    </div>
                                                    <div class="flex-1 flex gap-2">
                                                        <input type="text" name="body" class="w-full bg-gray-900 border border-white/10 rounded-lg px-3 py-1.5 text-sm text-white placeholder-gray-500 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-colors" placeholder="Write a reply..." required>
                                                        <button type="submit" class="bg-white/10 hover:bg-white/20 text-white px-4 py-1.5 rounded-lg text-sm font-semibold transition-colors shrink-0">Reply</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-8 text-gray-400">
                                        <svg class="w-12 h-12 mx-auto mb-4 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                        <p class="font-semibold text-lg">No questions yet</p>
                                        <p class="text-sm mt-1">Be the first to ask a question about this lesson!</p>
                                    </div>
                                @endforelse
                            </div>
                        @endif
                    </div>

                    <!-- Resources Tab -->
                    <div x-show="activeTab === 'resources'" style="display:none;">
                        @if($activeLesson && $activeLesson->resources->count() > 0)
                            <div class="space-y-4">
                                @foreach($activeLesson->resources as $resource)
                                    <div class="flex items-center justify-between p-4 bg-white/5 rounded-2xl border border-white/10 hover:bg-white/10 transition-colors">
                                        <div class="flex items-center gap-4">
                                            <div class="w-10 h-10 rounded-xl bg-indigo-500/20 text-indigo-400 flex items-center justify-center">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                                            </div>
                                            <div>
                                                <h4 class="text-white font-bold">{{ $resource->name }}</h4>
                                                <p class="text-xs text-gray-400 mt-0.5">{{ strtoupper($resource->file_type) }} • {{ number_format($resource->file_size / 1024, 2) }} KB</p>
                                            </div>
                                        </div>
                                        <a href="{{ route('resources.download', $resource->id) }}" class="flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-500 rounded-xl text-sm font-bold text-white transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                            Download
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-12 text-gray-400">
                                <svg class="w-12 h-12 mx-auto mb-4 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                <p class="font-semibold text-lg">No resources available</p>
                                <p class="text-sm mt-1">There are no downloadable resources for this lesson.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Dynamic Curriculum Sidebar -->
        <div x-show="sidebarOpen" x-transition class="w-80 shrink-0 bg-gray-900 flex flex-col border-l border-white/10 overflow-hidden shadow-2xl">
            <!-- Header -->
            <div class="p-5 border-b border-white/10 bg-gray-950">
                <h3 class="font-extrabold text-white text-base">Course Content</h3>
                <p class="text-xs text-gray-400 mt-1">{{ $completedCount }} / {{ $totalLessons }} lessons completed</p>
                <div class="w-full bg-gray-800 rounded-full h-2 mt-3">
                    <div class="bg-indigo-500 h-2 rounded-full transition-all duration-500" style="width:{{ $progressPercent }}%"></div>
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

                <div class="border-b border-white/5">
                    <button @click="openModule = openModule === {{ $module->id }} ? null : {{ $module->id }}"
                            class="w-full flex items-center justify-between px-5 py-4 bg-gray-900 hover:bg-gray-800 transition-colors text-left">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-wider {{ $isModuleDone ? 'text-emerald-400' : 'text-indigo-400' }} mb-0.5">
                                Module {{ $loop->iteration }}
                            </p>
                            <p class="font-bold text-sm text-gray-200">{{ $module->title }}</p>
                        </div>
                        <div class="flex items-center gap-2 shrink-0 ml-2">
                            @if($isModuleDone)
                                <span class="text-xs text-emerald-400 font-bold bg-emerald-400/10 px-2 py-0.5 rounded-md">Done</span>
                            @else
                                <span class="text-xs text-gray-400 font-bold bg-white/10 px-2 py-0.5 rounded-md">{{ $moduleCompleted }}/{{ $moduleTotal }}</span>
                            @endif
                            <svg class="w-4 h-4 text-gray-500 transition-transform duration-200"
                                 :class="{ 'rotate-180': openModule === {{ $module->id }} }"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </button>

                    <div x-show="openModule === {{ $module->id }}" class="divide-y divide-white/5">
                        @forelse($moduleLessons as $lesson)
                        @php 
                            $isDone = in_array($lesson->id, $completedLessonIds); 
                            $isActive = $activeLesson && $activeLesson->id === $lesson->id;
                        @endphp
                        <a href="{{ route('courses.learn', ['course' => $course->slug, 'lesson' => $lesson->id]) }}" class="flex items-center gap-3 px-5 py-3 {{ $isActive ? 'bg-indigo-900/30 border-l-4 border-indigo-500' : 'bg-gray-900 hover:bg-gray-800 border-l-4 border-transparent' }} transition-colors cursor-pointer group">
                            <!-- Status icon -->
                            @if($isDone)
                                <div class="w-5 h-5 rounded-full bg-emerald-500/20 flex items-center justify-center shrink-0">
                                    <svg class="w-3 h-3 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                            @elseif($isActive)
                                <div class="w-5 h-5 rounded-full bg-indigo-500/20 flex items-center justify-center shrink-0">
                                    <div class="w-2 h-2 bg-indigo-400 rounded-full"></div>
                                </div>
                            @else
                                <div class="w-5 h-5 rounded-full border-2 border-white/10 bg-white/5 flex items-center justify-center shrink-0 group-hover:border-indigo-400 transition-colors">
                                    <svg class="w-3 h-3 text-gray-500 group-hover:text-indigo-400 transition-colors" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4l12 6-12 6z"/></svg>
                                </div>
                            @endif

                            <span class="text-sm flex-1 font-medium {{ $isDone ? 'text-gray-500 line-through' : ($isActive ? 'text-white font-bold' : 'text-gray-300 group-hover:text-white') }} leading-snug transition-colors">
                                {{ $lesson->title }}
                            </span>

                            @if($lesson->duration_seconds)
                                <span class="text-xs {{ $isActive ? 'text-indigo-400' : 'text-gray-500' }} font-semibold tabular-nums shrink-0">
                                    {{ gmdate('i:s', $lesson->duration_seconds) }}
                                </span>
                            @endif
                        </a>
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
