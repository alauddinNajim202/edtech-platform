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
                <div class="flex items-center gap-3 shrink-0">
                    <a href="{{ route('courses.index') }}" class="inline-flex items-center gap-2 bg-indigo-600 text-white px-5 py-2.5 rounded-xl shadow-lg shadow-indigo-200 font-bold hover:bg-indigo-700 transition-all hover:-translate-y-0.5 text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        Browse Courses
                    </a>
                </div>
            </div>

            <!-- Admin / Instructor Shortcuts -->
            @role('Admin')
            <div class="mb-8 bg-gradient-to-r from-blue-600 to-indigo-700 text-white rounded-2xl p-6 flex justify-between items-center shadow-xl shadow-indigo-200">
                <div>
                    <h3 class="font-bold text-lg">Admin Dashboard</h3>
                    <p class="text-blue-200 text-sm mt-1">Manage categories, tags, users, and courses.</p>
                </div>
                <a href="{{ route('admin.categories.index') }}" class="bg-white text-indigo-700 px-5 py-2.5 rounded-xl font-bold shadow hover:bg-gray-50 transition text-sm">Enter Admin Panel →</a>
            </div>
            @endrole

            @role('Instructor')
            <div class="mb-8 bg-gradient-to-r from-emerald-500 to-teal-600 text-white rounded-2xl p-6 flex justify-between items-center shadow-xl shadow-emerald-200">
                <div>
                    <h3 class="font-bold text-lg">Instructor Studio</h3>
                    <p class="text-emerald-100 text-sm mt-1">Create courses, build curriculums, track students.</p>
                </div>
                <a href="{{ route('instructor.courses.index') }}" class="bg-white text-emerald-700 px-5 py-2.5 rounded-xl font-bold shadow hover:bg-gray-50 transition text-sm">Manage Courses →</a>
            </div>
            @endrole

            <!-- BENTO GRID -->
            <div class="grid grid-cols-1 md:grid-cols-12 gap-5">

                <!-- BLOCK 1: Continue Learning (8 cols) -->
                <div class="md:col-span-8 bg-gray-900 rounded-3xl overflow-hidden shadow-xl flex flex-col sm:flex-row group cursor-pointer hover:shadow-2xl hover:shadow-gray-900/20 transition-all duration-500">
                    <!-- Thumbnail Side -->
                    <div class="sm:w-2/5 h-52 sm:h-auto relative overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1555066931-4365d14bab8c?q=80&w=2070&auto=format&fit=crop" class="absolute inset-0 w-full h-full object-cover opacity-60 group-hover:opacity-80 group-hover:scale-105 transition-all duration-700" alt="course">
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="w-14 h-14 bg-white/20 backdrop-blur-sm border-2 border-white/40 rounded-full flex items-center justify-center shadow-2xl group-hover:scale-110 transition duration-300">
                                <svg class="w-6 h-6 text-white ml-1" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4l12 6-12 6z"/></svg>
                            </div>
                        </div>
                    </div>
                    <!-- Info Side -->
                    <div class="sm:w-3/5 p-8 flex flex-col justify-between">
                        <div>
                            <div class="flex items-center gap-2 mb-3">
                                <span class="bg-indigo-500/20 border border-indigo-400/30 text-indigo-300 text-xs font-bold px-2.5 py-1 rounded-lg backdrop-blur-sm">In Progress</span>
                                <span class="text-gray-500 text-xs">Module 4 • Lesson 3</span>
                            </div>
                            <h2 class="text-white text-2xl font-extrabold leading-tight mb-2 group-hover:text-indigo-300 transition-colors">Advanced React Native Masterclass</h2>
                            <p class="text-gray-400 text-sm">Navigation and Routing — pick up exactly where you stopped.</p>
                        </div>
                        <div class="mt-6">
                            <div class="flex justify-between text-sm font-semibold mb-2">
                                <span class="text-gray-400">Progress</span>
                                <span class="text-indigo-400 font-black text-lg">64%</span>
                            </div>
                            <div class="w-full bg-white/10 rounded-full h-2.5 overflow-hidden">
                                <div class="h-full bg-gradient-to-r from-indigo-500 to-purple-500 rounded-full" style="width:64%"></div>
                            </div>
                            <button class="mt-5 w-full bg-indigo-600 hover:bg-indigo-500 text-white font-bold py-3 rounded-xl transition-colors shadow-lg shadow-indigo-900/40">
                                Resume Learning →
                            </button>
                        </div>
                    </div>
                </div>

                <!-- BLOCK 2: Weekly Streak (4 cols) -->
                <div class="md:col-span-4 bg-white rounded-3xl p-7 shadow-sm border border-gray-100 flex flex-col justify-between hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                    <div class="flex items-center justify-between mb-5">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-1">This Week</p>
                            <h3 class="text-xl font-extrabold text-gray-900">Learning Streak 🔥</h3>
                        </div>
                        <span class="bg-emerald-50 text-emerald-700 text-xs font-bold px-2.5 py-1.5 rounded-xl border border-emerald-100">On Track</span>
                    </div>

                    <div class="flex justify-between items-center gap-2">
                        @foreach([['M', true], ['T', true], ['W', true], ['T', false], ['F', false]] as $day)
                        <div class="flex flex-col items-center gap-2">
                            @if($day[1])
                                <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-amber-400 to-orange-500 shadow-lg shadow-orange-200 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                            @else
                                <div class="w-11 h-11 rounded-2xl bg-gray-100 border-2 border-dashed border-gray-200 flex items-center justify-center">
                                    <div class="w-2 h-2 rounded-full bg-gray-300"></div>
                                </div>
                            @endif
                            <span class="text-xs font-bold {{ $day[1] ? 'text-orange-500' : 'text-gray-400' }}">{{ $day[0] }}</span>
                        </div>
                        @endforeach
                    </div>

                    <div class="mt-6 bg-amber-50 border border-amber-100 rounded-2xl p-4">
                        <div class="flex items-center gap-2">
                            <span class="text-2xl">⚡</span>
                            <div>
                                <p class="text-sm font-bold text-amber-900">3-day streak!</p>
                                <p class="text-xs text-amber-600 mt-0.5">Study 2 more days to earn your weekly badge.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- BLOCK 3: Courses Enrolled (4 cols) -->
                <div class="md:col-span-4 bg-gradient-to-br from-indigo-900 to-purple-900 rounded-3xl p-8 relative overflow-hidden shadow-xl hover:shadow-2xl hover:shadow-indigo-500/30 hover:-translate-y-1 transition-all duration-300">
                    <div class="absolute -right-6 -top-6 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
                    <div class="absolute -left-4 -bottom-4 w-24 h-24 bg-purple-500/20 rounded-full blur-xl"></div>
                    <div class="relative">
                        <div class="w-12 h-12 bg-white/10 rounded-2xl flex items-center justify-center mb-5 border border-white/10">
                            <svg class="w-6 h-6 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        </div>
                        <div class="text-6xl font-black text-white mb-1">12</div>
                        <div class="text-indigo-200 font-semibold">Courses Enrolled</div>
                    </div>
                </div>

                <!-- BLOCK 4: Certificates (4 cols) -->
                <div class="md:col-span-4 bg-white rounded-3xl p-8 shadow-sm border border-gray-100 hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                    <div class="w-12 h-12 bg-teal-50 text-teal-600 rounded-2xl flex items-center justify-center mb-5 border border-teal-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
                    </div>
                    <div class="text-6xl font-black text-gray-900 mb-1">4</div>
                    <div class="text-gray-500 font-semibold">Certificates Earned</div>
                </div>

                <!-- BLOCK 5: Total Hours (4 cols) -->
                <div class="md:col-span-4 bg-white rounded-3xl p-8 shadow-sm border border-gray-100 hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                    <div class="w-12 h-12 bg-rose-50 text-rose-500 rounded-2xl flex items-center justify-center mb-5 border border-rose-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div class="text-6xl font-black text-gray-900 mb-1">42<span class="text-3xl text-gray-300 font-bold">h</span></div>
                    <div class="text-gray-500 font-semibold">Total Learning Time</div>
                </div>

            </div>

            <!-- Recommended Courses -->
            <div class="mt-12">
                <div class="flex items-center justify-between mb-7">
                    <div>
                        <h2 class="text-2xl font-extrabold text-gray-900">Recommended for you</h2>
                        <p class="text-gray-500 text-sm mt-1">Based on your learning history</p>
                    </div>
                    <a href="{{ route('courses.index') }}" class="inline-flex items-center gap-1 text-sm font-bold text-indigo-600 hover:text-indigo-800 group">
                        View all courses
                        <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                    @foreach([
                        ['Data Science & Python Bootcamp', 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?q=80&w=2070&auto=format&fit=crop', '$29.99', '4.9', 'Data Science'],
                        ['UI/UX Masterclass: Figma Pro', 'https://images.unsplash.com/photo-1618477388954-7852f32655ec?q=80&w=1964&auto=format&fit=crop', '$19.99', '4.8', 'Design'],
                        ['Flutter Mobile Development', 'https://images.unsplash.com/photo-1512941937669-90a1b58e7e9c?q=80&w=2070&auto=format&fit=crop', '$39.99', '4.7', 'Mobile'],
                        ['Node.js & Express Backend', 'https://images.unsplash.com/photo-1627398242454-45a1465c2479?q=80&w=1974&auto=format&fit=crop', '$24.99', '4.9', 'Backend'],
                    ] as $rec)
                    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 flex flex-col">
                        <div class="h-40 relative overflow-hidden">
                            <img src="{{ $rec[1] }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500" alt="{{ $rec[0] }}">
                            <div class="absolute top-2.5 left-2.5 bg-white/90 backdrop-blur-sm text-gray-700 text-xs font-bold px-2 py-1 rounded-lg shadow-sm">{{ $rec[4] }}</div>
                            <div class="absolute top-2.5 right-2.5 bg-indigo-600 text-white text-sm font-extrabold px-2.5 py-1 rounded-lg shadow">{{ $rec[2] }}</div>
                        </div>
                        <div class="p-5 flex-1 flex flex-col">
                            <h4 class="font-bold text-gray-900 mb-3 leading-snug text-sm">{{ $rec[0] }}</h4>
                            <div class="mt-auto flex items-center justify-between">
                                <div class="flex items-center gap-1">
                                    <svg class="w-4 h-4 text-amber-400 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    <span class="text-sm font-bold text-gray-800">{{ $rec[3] }}</span>
                                </div>
                                <a href="{{ route('courses.index') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 transition-colors">View →</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</x-frontend-layout>
