<x-frontend-layout>
    <div class="bg-gray-50 min-h-screen py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Page Header -->
            <div class="mb-10 flex flex-col sm:flex-row sm:items-end justify-between gap-4">
                <div>
                    <p class="text-sm font-semibold text-indigo-600 uppercase tracking-widest mb-1">Your Learning Hub</p>
                    <h1 class="text-4xl font-black text-gray-900 tracking-tight">Welcome back, <span class="text-indigo-600">{{ explode(' ', auth()->user()->name)[0] }}</span>! 👋</h1>
                    <p class="mt-2 text-gray-500 text-lg">Let's pick up right where you left off.</p>
                </div>
                <a href="{{ route('courses.index') }}" class="inline-flex items-center gap-2 bg-indigo-600 text-white px-5 py-2.5 rounded-xl shadow-lg shadow-indigo-200 font-bold hover:bg-indigo-700 transition-all hover:-translate-y-0.5 text-sm shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    Browse Courses
                </a>
            </div>

            @role('Admin')
            <div class="mb-8 bg-gradient-to-r from-blue-600 to-indigo-700 text-white rounded-2xl p-6 flex justify-between items-center shadow-xl shadow-indigo-200">
                <div><h3 class="font-bold text-lg">Admin Dashboard</h3><p class="text-blue-200 text-sm mt-1">Manage categories, tags, users, and courses.</p></div>
                <a href="{{ route('admin.categories.index') }}" class="bg-white text-indigo-700 px-5 py-2.5 rounded-xl font-bold shadow hover:bg-gray-50 transition text-sm">Enter Admin Panel →</a>
            </div>
            @endrole

            @role('Instructor')
            <div class="mb-8 bg-gradient-to-r from-emerald-500 to-teal-600 text-white rounded-2xl p-6 flex justify-between items-center shadow-xl shadow-emerald-200">
                <div><h3 class="font-bold text-lg">Instructor Studio</h3><p class="text-emerald-100 text-sm mt-1">Create courses, build curriculums, track students.</p></div>
                <a href="{{ route('instructor.courses.index') }}" class="bg-white text-emerald-700 px-5 py-2.5 rounded-xl font-bold shadow hover:bg-gray-50 transition text-sm">Manage Courses →</a>
            </div>
            @endrole

            <!-- BENTO GRID -->
            <div class="grid grid-cols-1 md:grid-cols-12 gap-5">

                <!-- BLOCK 1: Continue Learning or Empty State (8 cols) -->
                <div class="md:col-span-8">
                    @if($continueLearning)
                    <div class="bg-gray-900 rounded-3xl overflow-hidden shadow-xl flex flex-col sm:flex-row group cursor-pointer hover:shadow-2xl hover:shadow-gray-900/20 transition-all duration-500 h-full">
                        <div class="sm:w-2/5 h-52 sm:h-auto relative overflow-hidden">
                            @if($continueLearning->thumbnail)
                                <img src="{{ asset('storage/' . $continueLearning->thumbnail) }}" class="absolute inset-0 w-full h-full object-cover opacity-60 group-hover:opacity-80 group-hover:scale-105 transition-all duration-700" alt="course">
                            @else
                                <img src="https://images.unsplash.com/photo-1555066931-4365d14bab8c?q=80&w=2070&auto=format&fit=crop" class="absolute inset-0 w-full h-full object-cover opacity-60 group-hover:opacity-80 group-hover:scale-105 transition-all duration-700" alt="course">
                            @endif
                            <div class="absolute inset-0 flex items-center justify-center">
                                <a href="{{ route('courses.learn', $continueLearning->slug) }}" class="w-14 h-14 bg-white/20 backdrop-blur-sm border-2 border-white/40 rounded-full flex items-center justify-center shadow-2xl group-hover:scale-110 transition duration-300">
                                    <svg class="w-6 h-6 text-white ml-1" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4l12 6-12 6z"/></svg>
                                </a>
                            </div>
                        </div>
                        <div class="sm:w-3/5 p-8 flex flex-col justify-between">
                            <div>
                                <div class="flex items-center gap-2 mb-3">
                                    <span class="bg-indigo-500/20 border border-indigo-400/30 text-indigo-300 text-xs font-bold px-2.5 py-1 rounded-lg">In Progress</span>
                                    @if($continueLearning->category)
                                    <span class="text-gray-500 text-xs">{{ $continueLearning->category->name }}</span>
                                    @endif
                                </div>
                                <h2 class="text-white text-2xl font-extrabold leading-tight mb-2 group-hover:text-indigo-300 transition-colors">{{ $continueLearning->title }}</h2>
                                <p class="text-gray-400 text-sm">{{ $continueLearning->instructor->name ?? 'Instructor' }}</p>
                            </div>
                            <div class="mt-6">
                                <div class="flex justify-between text-sm font-semibold mb-2">
                                    <span class="text-gray-400">{{ $continueLearning->completed_lessons }} / {{ $continueLearning->total_lessons }} lessons</span>
                                    <span class="text-indigo-400 font-black text-lg">{{ $continueLearning->progress_percent }}%</span>
                                </div>
                                <div class="w-full bg-white/10 rounded-full h-2.5 overflow-hidden">
                                    <div class="h-full bg-gradient-to-r from-indigo-500 to-purple-500 rounded-full" style="width:{{ $continueLearning->progress_percent }}%"></div>
                                </div>
                                <a href="{{ route('courses.learn', $continueLearning->slug) }}" class="mt-5 block w-full text-center bg-indigo-600 hover:bg-indigo-500 text-white font-bold py-3 rounded-xl transition-colors shadow-lg shadow-indigo-900/40">
                                    Resume Learning →
                                </a>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="bg-gradient-to-br from-gray-900 to-indigo-950 rounded-3xl overflow-hidden shadow-xl flex flex-col items-center justify-center p-12 h-full text-center border border-white/5 hover:shadow-2xl transition-all duration-500">
                        <div class="w-20 h-20 bg-indigo-500/10 border border-indigo-400/20 rounded-3xl flex items-center justify-center mb-6">
                            <svg class="w-10 h-10 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        </div>
                        <h2 class="text-2xl font-extrabold text-white mb-3">Start Your Learning Journey</h2>
                        <p class="text-gray-400 mb-8 max-w-sm">You are not enrolled in any courses yet. Browse our catalog and enroll in your first course!</p>
                        <a href="{{ route('courses.index') }}" class="inline-flex items-center gap-2 bg-indigo-600 text-white px-8 py-3.5 rounded-2xl font-bold shadow-lg shadow-indigo-900/40 hover:bg-indigo-500 transition-all hover:-translate-y-0.5">
                            Browse Courses →
                        </a>
                    </div>
                    @endif
                </div>

                <!-- BLOCK 2: Weekly Streak (4 cols) -->
                <div class="md:col-span-4 bg-white rounded-3xl p-7 shadow-sm border border-gray-100 flex flex-col justify-between hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                    <div class="flex items-center justify-between mb-5">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-1">This Week</p>
                            <h3 class="text-xl font-extrabold text-gray-900">Learning Streak 🔥</h3>
                        </div>
                        @if($streakCount > 0)
                        <span class="bg-emerald-50 text-emerald-700 text-xs font-bold px-2.5 py-1.5 rounded-xl border border-emerald-100">{{ $streakCount }} Day{{ $streakCount > 1 ? 's' : '' }}</span>
                        @else
                        <span class="bg-gray-50 text-gray-500 text-xs font-bold px-2.5 py-1.5 rounded-xl border border-gray-100">No Streak</span>
                        @endif
                    </div>

                    <div class="flex justify-between items-center gap-2">
                        @foreach($weekDays as $day)
                        <div class="flex flex-col items-center gap-2">
                            @if($day['studied'])
                                <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-amber-400 to-orange-500 shadow-lg shadow-orange-200 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                            @elseif($day['date'] === now()->toDateString())
                                <div class="w-11 h-11 rounded-2xl bg-indigo-100 border-2 border-indigo-300 flex items-center justify-center">
                                    <div class="w-2.5 h-2.5 rounded-full bg-indigo-500"></div>
                                </div>
                            @else
                                <div class="w-11 h-11 rounded-2xl bg-gray-100 border-2 border-dashed border-gray-200 flex items-center justify-center">
                                    <div class="w-2 h-2 rounded-full bg-gray-300"></div>
                                </div>
                            @endif
                            <span class="text-xs font-bold {{ $day['studied'] ? 'text-orange-500' : 'text-gray-400' }}">{{ $day['label'] }}</span>
                        </div>
                        @endforeach
                    </div>

                    <div class="mt-6 bg-amber-50 border border-amber-100 rounded-2xl p-4">
                        <div class="flex items-center gap-2">
                            <span class="text-2xl">⚡</span>
                            <div>
                                @if($streakCount > 0)
                                    <p class="text-sm font-bold text-amber-900">{{ $streakCount }}-day streak!</p>
                                    <p class="text-xs text-amber-600 mt-0.5">Keep it up — consistency is key!</p>
                                @else
                                    <p class="text-sm font-bold text-amber-900">No streak yet</p>
                                    <p class="text-xs text-amber-600 mt-0.5">Study today to start your streak!</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- BLOCK 3: Courses Enrolled -->
                <div class="md:col-span-4 bg-gradient-to-br from-indigo-900 to-purple-900 rounded-3xl p-8 relative overflow-hidden shadow-xl hover:shadow-2xl hover:shadow-indigo-500/30 hover:-translate-y-1 transition-all duration-300">
                    <div class="absolute -right-6 -top-6 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
                    <div class="relative">
                        <div class="w-12 h-12 bg-white/10 rounded-2xl flex items-center justify-center mb-5 border border-white/10">
                            <svg class="w-6 h-6 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        </div>
                        <div class="text-6xl font-black text-white mb-1">{{ $enrolledCount }}</div>
                        <div class="text-indigo-200 font-semibold">Courses Enrolled</div>
                    </div>
                </div>

                <!-- BLOCK 4: Certificates -->
                <div class="md:col-span-4 bg-white rounded-3xl p-8 shadow-sm border border-gray-100 hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                    <div class="w-12 h-12 bg-teal-50 text-teal-600 rounded-2xl flex items-center justify-center mb-5 border border-teal-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
                    </div>
                    <div class="text-6xl font-black text-gray-900 mb-1">{{ $certificateCount }}</div>
                    <div class="text-gray-500 font-semibold">Certificates Earned</div>
                </div>

                <!-- BLOCK 5: Total Hours -->
                <div class="md:col-span-4 bg-white rounded-3xl p-8 shadow-sm border border-gray-100 hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                    <div class="w-12 h-12 bg-rose-50 text-rose-500 rounded-2xl flex items-center justify-center mb-5 border border-rose-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div class="text-6xl font-black text-gray-900 mb-1">{{ $totalHours > 0 ? $totalHours : 0 }}<span class="text-3xl text-gray-300 font-bold">h</span></div>
                    <div class="text-gray-500 font-semibold">Total Learning Time</div>
                </div>

                <!-- My Enrolled Courses (if any) -->
                @if($coursesWithProgress->count() > 0)
                <div class="md:col-span-12 mt-2">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-extrabold text-gray-900">My Courses</h2>
                        <a href="{{ route('courses.index') }}" class="text-sm font-bold text-indigo-600 hover:text-indigo-800 flex items-center gap-1 group">
                            Browse more <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                        @foreach($coursesWithProgress as $course)
                        <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 flex flex-col">
                            <div class="h-36 relative overflow-hidden bg-gray-100">
                                @if($course->thumbnail)
                                    <img src="{{ asset('storage/' . $course->thumbnail) }}" class="w-full h-full object-cover" alt="{{ $course->title }}">
                                @else
                                    <img src="https://images.unsplash.com/photo-1516321497487-e288fb19713f?q=80&w=2070" class="w-full h-full object-cover" alt="course">
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent flex items-end p-3">
                                    <span class="text-white font-black text-lg">{{ $course->progress_percent }}%</span>
                                </div>
                            </div>
                            <div class="p-4 flex-1 flex flex-col">
                                <h4 class="font-bold text-gray-900 text-sm mb-2 line-clamp-2">{{ $course->title }}</h4>
                                <div class="mt-auto">
                                    <div class="w-full bg-gray-100 rounded-full h-1.5 mb-3">
                                        <div class="bg-indigo-600 h-1.5 rounded-full" style="width:{{ $course->progress_percent }}%"></div>
                                    </div>
                                    <a href="{{ route('courses.learn', $course->slug) }}" class="block w-full text-center bg-indigo-50 hover:bg-indigo-600 text-indigo-700 hover:text-white font-bold py-2 rounded-xl transition-all duration-200 text-xs">
                                        {{ $course->progress_percent > 0 ? 'Continue' : 'Start Learning' }}
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <!-- Recommended Courses -->
            @if($recommendedCourses->count() > 0)
            <div class="mt-12">
                <div class="flex items-center justify-between mb-7">
                    <div>
                        <h2 class="text-2xl font-extrabold text-gray-900">Recommended for you</h2>
                        <p class="text-gray-500 text-sm mt-1">Courses you haven't enrolled in yet</p>
                    </div>
                    <a href="{{ route('courses.index') }}" class="inline-flex items-center gap-1 text-sm font-bold text-indigo-600 hover:text-indigo-800 group">
                        View all <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                    @foreach($recommendedCourses as $course)
                    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 flex flex-col">
                        <div class="h-40 relative overflow-hidden">
                            @if($course->thumbnail)
                                <img src="{{ asset('storage/' . $course->thumbnail) }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500" alt="{{ $course->title }}">
                            @else
                                <img src="https://images.unsplash.com/photo-1516321497487-e288fb19713f?q=80&w=2070&auto=format&fit=crop" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500" alt="course">
                            @endif
                            <div class="absolute top-2.5 right-2.5 bg-indigo-600 text-white text-xs font-extrabold px-2.5 py-1 rounded-lg shadow">
                                {{ $course->price > 0 ? '$'.number_format($course->price, 2) : 'Free' }}
                            </div>
                        </div>
                        <div class="p-5 flex-1 flex flex-col">
                            <h4 class="font-bold text-gray-900 mb-3 leading-snug text-sm line-clamp-2">{{ $course->title }}</h4>
                            <div class="mt-auto flex items-center justify-between">
                                <span class="text-xs text-gray-400 font-semibold">{{ $course->instructor->name ?? 'Instructor' }}</span>
                                <a href="{{ route('courses.show', $course->slug) }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 transition-colors">View →</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

        </div>
    </div>
</x-frontend-layout>
