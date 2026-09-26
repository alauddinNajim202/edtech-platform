<x-frontend-layout>
    <x-slot name="title">Browse Courses</x-slot>

    <!-- Hero Banner -->
    <div class="relative bg-gray-950 overflow-hidden">
        <div class="absolute inset-0">
            <img src="https://images.unsplash.com/photo-1513258496099-48168024aec0?q=80&w=2070&auto=format&fit=crop" class="w-full h-full object-cover opacity-20">
            <div class="absolute inset-0 bg-gradient-to-r from-gray-950 via-indigo-950/80 to-gray-950/60"></div>
        </div>
        <div class="relative max-w-4xl mx-auto px-4 py-20 text-center">
            <h1 class="text-4xl md:text-6xl font-black text-white tracking-tight mb-4">
                Discover Your <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-purple-400">Next Skill</span>
            </h1>
            <p class="text-indigo-200 text-lg md:text-xl mb-10">Explore 1,000+ top-rated courses taught by industry experts.</p>
            <form action="{{ route('courses.index') }}" method="GET" class="max-w-2xl mx-auto">
                <div class="flex bg-white rounded-2xl shadow-2xl shadow-indigo-900/30 overflow-hidden p-1.5 gap-2">
                    <div class="flex-1 flex items-center px-4 gap-3">
                        <svg class="w-5 h-5 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search courses, skills, instructors..." class="flex-1 py-2.5 text-gray-900 placeholder-gray-400 bg-transparent focus:outline-none text-base font-medium">
                    </div>
                    <button type="submit" class="bg-indigo-600 text-white px-7 py-3 rounded-xl font-bold hover:bg-indigo-700 transition-colors shadow-lg shadow-indigo-500/30 whitespace-nowrap">Search</button>
                </div>
            </form>

            <!-- Quick filter pills -->
            <div class="flex flex-wrap justify-center gap-2 mt-6">
                @foreach($categories->take(5) as $cat)
                <a href="{{ route('courses.index', ['category' => $cat->slug]) }}" class="bg-white/10 hover:bg-white/20 backdrop-blur-sm border border-white/20 text-white text-sm font-semibold px-4 py-1.5 rounded-full transition-all hover:-translate-y-0.5">{{ $cat->name }}</a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="flex flex-col lg:flex-row gap-8">

            <!-- Sidebar Filters -->
            <aside class="w-full lg:w-64 shrink-0">
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 sticky top-24 space-y-8">
                    <div>
                        <h3 class="text-xs font-black uppercase tracking-widest text-gray-400 mb-4">Categories</h3>
                        <ul class="space-y-1">
                            <li>
                                <a href="{{ route('courses.index', request()->except('category')) }}" class="flex items-center justify-between px-3 py-2 rounded-xl text-sm font-semibold transition-all {{ !request('category') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-200' : 'text-gray-600 hover:bg-gray-50' }}">
                                    All Categories
                                </a>
                            </li>
                            @foreach($categories as $cat)
                            <li>
                                <a href="{{ route('courses.index', ['category' => $cat->slug]) }}" class="flex items-center justify-between px-3 py-2 rounded-xl text-sm font-semibold transition-all {{ request('category') == $cat->slug ? 'bg-indigo-600 text-white shadow-md shadow-indigo-200' : 'text-gray-600 hover:bg-gray-50' }}">
                                    {{ $cat->name }}
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="border-t border-gray-100 pt-6">
                        <h3 class="text-xs font-black uppercase tracking-widest text-gray-400 mb-4">Price</h3>
                        <div class="space-y-2">
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <input type="checkbox" class="w-4 h-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                <span class="text-sm text-gray-600 group-hover:text-gray-900 font-medium transition-colors">Free Courses</span>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <input type="checkbox" class="w-4 h-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                <span class="text-sm text-gray-600 group-hover:text-gray-900 font-medium transition-colors">Paid Courses</span>
                            </label>
                        </div>
                    </div>
                </div>
            </aside>

            <!-- Course Grid -->
            <div class="flex-1 min-w-0">
                <!-- Sorting bar -->
                <div class="flex flex-wrap items-center justify-between gap-4 mb-7">
                    <div>
                        <h2 class="text-xl font-extrabold text-gray-900">
                            @if(request('search'))
                                Results for "<span class="text-indigo-600">{{ request('search') }}</span>"
                            @elseif(request('category'))
                                {{ $categories->where('slug', request('category'))->first()->name ?? 'Courses' }}
                            @else
                                All Courses
                            @endif
                        </h2>
                        <p class="text-gray-400 text-sm mt-0.5">{{ $courses->total() }} courses found</p>
                    </div>
                    <select class="text-sm border border-gray-200 rounded-xl px-3 py-2 font-semibold text-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white">
                        <option>Newest First</option>
                        <option>Highest Rated</option>
                        <option>Price: Low to High</option>
                        <option>Price: High to Low</option>
                    </select>
                </div>

                @if($courses->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
                        @foreach($courses as $course)
                        <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 flex flex-col group">
                            <!-- Thumbnail -->
                            <div class="relative h-48 overflow-hidden bg-gray-100">
                                @if($course->thumbnail)
                                    <img src="{{ asset('storage/' . $course->thumbnail) }}" alt="{{ $course->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <img src="https://images.unsplash.com/photo-1516321497487-e288fb19713f?q=80&w=2070&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="default">
                                @endif
                                <!-- Price badge -->
                                <div class="absolute top-3 right-3 bg-white text-gray-900 text-sm font-extrabold px-2.5 py-1 rounded-xl shadow-md">
                                    {{ $course->price > 0 ? '$'.number_format($course->price, 2) : 'Free' }}
                                </div>
                                <!-- Category badge -->
                                @if($course->category)
                                <div class="absolute top-3 left-3 bg-indigo-600/90 backdrop-blur-sm text-white text-xs font-bold px-2.5 py-1 rounded-lg shadow-sm">
                                    {{ $course->category->name }}
                                </div>
                                @endif
                            </div>

                            <!-- Body -->
                            <div class="p-5 flex-1 flex flex-col">
                                <h3 class="text-base font-bold text-gray-900 leading-snug mb-2 line-clamp-2 group-hover:text-indigo-700 transition-colors">
                                    <a href="{{ route('courses.show', $course->slug) }}">{{ $course->title }}</a>
                                </h3>
                                <p class="text-sm text-gray-400 mb-4 line-clamp-2">{{ $course->description }}</p>

                                <!-- Instructor & Rating -->
                                <div class="mt-auto">
                                    <div class="flex items-center justify-between pb-4 border-b border-gray-50 mb-4">
                                        <div class="flex items-center gap-2">
                                            <div class="w-7 h-7 rounded-lg bg-gradient-to-tr from-indigo-400 to-purple-500 text-white flex items-center justify-center text-xs font-black shadow">
                                                {{ strtoupper(substr($course->instructor->name ?? 'I', 0, 1)) }}
                                            </div>
                                            <span class="text-xs font-semibold text-gray-500 truncate max-w-[110px]">{{ $course->instructor->name ?? 'Instructor' }}</span>
                                        </div>
                                        <div class="flex items-center gap-1">
                                            <svg class="w-4 h-4 text-amber-400 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                            <span class="text-sm font-bold text-gray-800">4.5</span>
                                        </div>
                                    </div>
                                    <a href="{{ route('courses.show', $course->slug) }}" class="block w-full text-center bg-gray-50 hover:bg-indigo-600 text-gray-700 hover:text-white border border-gray-100 hover:border-indigo-600 font-bold py-2.5 rounded-xl transition-all duration-200 text-sm">
                                        View Course
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-10">
                        {{ $courses->withQueryString()->links() }}
                    </div>

                @else
                    <!-- Empty State -->
                    <div class="text-center py-24 bg-white rounded-3xl border border-gray-100 shadow-sm">
                        <div class="w-20 h-20 bg-indigo-50 text-indigo-300 rounded-3xl flex items-center justify-center mx-auto mb-6 shadow-inner">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <h3 class="text-2xl font-extrabold text-gray-900 mb-3">No courses found</h3>
                        <p class="text-gray-400 max-w-md mx-auto mb-8 text-base">We couldn't find any published courses matching your criteria. Try a different search or clear your filters.</p>
                        <a href="{{ route('courses.index') }}" class="inline-flex items-center gap-2 bg-indigo-600 text-white px-6 py-3 rounded-xl font-bold shadow-lg shadow-indigo-200 hover:bg-indigo-700 transition-all hover:-translate-y-0.5">Clear Filters</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-frontend-layout>
