<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Student Questions & Answers') }}
        </h2>
    </x-slot>

    <div class="row">
        <div class="col-12">
            @if(session('success'))
                <div class="alert alert-success mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @forelse($questions as $question)
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <!-- Question Details -->
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div>
                                <strong class="text-dark" style="font-size: 1.1rem;">{{ $question->user->name }}</strong>
                                <span class="text-muted ml-2 small">asked in</span>
                                <a href="{{ route('courses.learn', ['course' => $question->lesson->module->course->slug, 'lesson' => $question->lesson->id]) }}" target="_blank" class="ml-1 text-primary font-weight-bold small">
                                    {{ $question->lesson->title }} ({{ $question->lesson->module->course->title }})
                                </a>
                            </div>
                            <span class="badge badge-light text-muted border">{{ $question->created_at->diffForHumans() }}</span>
                        </div>
                        
                        <div class="p-3 mb-4 rounded bg-light border">
                            <p class="mb-0 text-dark" style="white-space: pre-wrap;">{{ $question->body }}</p>
                        </div>

                        <!-- Replies -->
                        <div class="ml-4 pl-4 border-left border-primary">
                            @foreach($question->replies as $reply)
                                <div class="p-3 mb-3 rounded border {{ $reply->user_id === auth()->id() ? 'border-primary bg-light' : 'border-light' }}">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div>
                                            <strong class="text-dark">{{ $reply->user->name }}</strong>
                                            @if($reply->user_id === auth()->id())
                                                <span class="badge badge-primary ml-2">You</span>
                                            @endif
                                        </div>
                                        <span class="text-muted small">{{ $reply->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="mb-0 text-secondary" style="white-space: pre-wrap;">{{ $reply->body }}</p>
                                </div>
                            @endforeach

                            <!-- Reply Form -->
                            <form action="{{ route('instructor.qna.reply', $question->id) }}" method="POST" class="mt-3">
                                @csrf
                                <div class="input-group">
                                    <input type="text" name="body" class="form-control" placeholder="Write your reply..." required>
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-primary px-4">Reply</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="card shadow-sm">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-comments text-muted mb-3" style="font-size: 4rem; opacity: 0.5;"></i>
                        <h4 class="text-dark font-weight-bold">No Questions Yet</h4>
                        <p class="text-muted">When students ask questions in your lessons, they will appear here.</p>
                    </div>
                </div>
            @endforelse

            <div class="mt-4">
                {{ $questions->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</x-admin-layout>
