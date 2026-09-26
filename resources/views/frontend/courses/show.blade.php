<x-frontend-layout>
    <x-slot name="title">{{ $course->title }}</x-slot>

    <!-- Course Hero -->
    <div class="bg-gray-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14 flex flex-col lg:flex-row gap-10">
            <!-- Left: Info -->
            <div class="flex-1">
                @if($course->category)
                <span class="inline-block bg-indigo-500/20 border border-indigo-400/30 text-indigo-300 text-xs font-bold px-3 py-1.5 rounded-lg mb-4">{{ $course->category->name }}</span>
                @endif
                <h1 class="text-3xl md:text-4xl font-black leading-tight mb-4">{{ $course->title }}</h1>
                <p class="text-gray-300 text-lg mb-6 leading-relaxed max-w-2xl">{{ Str::limit($course->description, 180) }}</p>

                <!-- Instructor -->
                @if($course->instructor)
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-indigo-500 to-purple-600 text-white font-black flex items-center justify-center shadow-lg">
                        {{ strtoupper(substr($course->instructor->name, 0, 1)) }}
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 font-semibold">Instructor</p>
                        <p class="text-white font-bold">{{ $course->instructor->name }}</p>
                    </div>
                </div>
                @endif

                <!-- Tags -->
                @if($course->tags->count())
                <div class="flex flex-wrap gap-2">
                    @foreach($course->tags as $tag)
                    <span class="bg-white/10 border border-white/20 text-gray-300 text-xs font-semibold px-3 py-1 rounded-full"># {{ $tag->name }}</span>
                    @endforeach
                </div>
                @endif
            </div>

            <!-- Right: Purchase Card -->
            <div class="lg:w-80 shrink-0">
                <div class="bg-white text-gray-900 rounded-3xl shadow-2xl overflow-hidden sticky top-24">
                    @if($course->thumbnail)
                    <img src="{{ asset('storage/' . $course->thumbnail) }}" class="w-full h-48 object-cover" alt="{{ $course->title }}">
                    @else
                    <img src="https://images.unsplash.com/photo-1516321497487-e288fb19713f?q=80&w=2070&auto=format&fit=crop" class="w-full h-48 object-cover" alt="course">
                    @endif
                    <div class="p-6">
                        <div class="text-4xl font-black text-gray-900 mb-1">
                            {{ $course->price > 0 ? '$'.number_format($course->price, 2) : 'Free' }}
                        </div>
                        <p class="text-gray-400 text-sm mb-5">One-time purchase, lifetime access</p>
                        <a href="{{ route('courses.learn', $course->slug) }}" class="block w-full text-center bg-indigo-600 hover:bg-indigo-700 text-white font-black py-4 rounded-2xl shadow-xl shadow-indigo-200 transition-all hover:-translate-y-0.5 text-lg mb-3">
                            Enroll Now
                        </a>
                        <button class="block w-full text-center bg-gray-50 hover:bg-gray-100 text-gray-700 font-bold py-3 rounded-2xl transition-all text-sm border border-gray-200">
                            Try Free Preview
                        </button>
                        <div class="mt-5 space-y-2.5 text-sm text-gray-500">
                            <div class="flex items-center gap-2.5">
                                <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Lifetime access
                            </div>
                            <div class="flex items-center gap-2.5">
                                <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Certificate of completion
                            </div>
                            <div class="flex items-center gap-2.5">
                                <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Mobile & desktop access
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Course Details -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
        <div class="max-w-3xl">
            <h2 class="text-2xl font-extrabold text-gray-900 mb-6">About this course</h2>
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8">
                <p class="text-gray-600 leading-relaxed whitespace-pre-line">{{ $course->description }}</p>
            </div>
        </div>
    </div>
</x-frontend-layout>
