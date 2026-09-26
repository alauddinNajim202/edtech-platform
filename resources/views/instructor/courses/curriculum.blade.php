<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Curriculum: ') }} <span class="text-indigo-600">{{ $course->title }}</span>
            </h2>
            <a href="{{ route('instructor.courses.index') }}" class="btn btn-secondary">Back to Courses</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Add Module Card -->
            <div class="card card-primary card-outline mb-4">
                <div class="card-header">
                    <h3 class="card-title font-bold">Add New Module</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('instructor.modules.store', $course->id) }}" method="POST">
                        @csrf
                        <div class="input-group">
                            <input type="text" name="title" class="form-control" placeholder="e.g. Introduction to the Course" required>
                            <span class="input-group-append">
                                <button type="submit" class="btn btn-primary">Add Module</button>
                            </span>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Modules List -->
            @forelse($course->modules as $module)
                <div class="card card-default mb-4 shadow-sm">
                    <div class="card-header bg-light">
                        <h3 class="card-title font-bold text-lg">
                            <i class="fas fa-folder-open text-indigo-500 mr-2"></i> 
                            Module {{ $module->order }}: {{ $module->title }}
                        </h3>
                    </div>
                    
                    <!-- Lessons List -->
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                            @forelse($module->lessons as $lesson)
                                <li class="list-group-item flex-column align-items-start">
                                    <div class="d-flex justify-content-between align-items-center w-100 mb-2">
                                        <div>
                                            <i class="fas fa-play-circle text-gray-400 mr-2"></i>
                                            <span class="font-medium">{{ $lesson->order }}. {{ $lesson->title }}</span>
                                            @if($lesson->is_preview)
                                                <span class="badge badge-success ml-2">Free Preview</span>
                                            @endif
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            Video: {{ basename($lesson->video_path) }}
                                        </div>
                                    </div>
                                    
                                    <!-- Resources Section -->
                                    <div class="bg-light p-3 rounded mt-2 border w-100">
                                        <h6 class="font-weight-bold mb-2 text-muted text-sm"><i class="fas fa-paperclip mr-1"></i> Resources ({{ $lesson->resources->count() }})</h6>
                                        @if($lesson->resources->count() > 0)
                                            <ul class="list-unstyled mb-3">
                                                @foreach($lesson->resources as $resource)
                                                    <li class="text-sm text-info"><i class="fas fa-file-alt mr-2"></i> {{ $resource->name }} <span class="text-muted">({{ strtoupper($resource->file_type) }})</span></li>
                                                @endforeach
                                            </ul>
                                        @endif
                                        
                                        <form action="{{ route('instructor.resources.store', $lesson->id) }}" method="POST" enctype="multipart/form-data" class="d-flex align-items-center gap-2">
                                            @csrf
                                            <input type="text" name="name" class="form-control form-control-sm" placeholder="Resource Name (e.g. Slide Deck)" required style="max-width: 200px;">
                                            <input type="file" name="file" class="form-control-file form-control-sm w-auto" required>
                                            <button type="submit" class="btn btn-xs btn-outline-primary whitespace-nowrap">Upload Resource</button>
                                        </form>
                                    </div>
                                </li>
                            @empty
                                <li class="list-group-item text-muted italic text-center py-4">No lessons in this module yet.</li>
                            @endforelse
                        </ul>
                    </div>

                    <!-- Add Lesson Form -->
                    <div class="card-footer bg-white border-top">
                        <form action="{{ route('instructor.lessons.store', $module->id) }}" method="POST" enctype="multipart/form-data" class="d-flex align-items-center gap-3">
                            @csrf
                            <input type="text" name="title" class="form-control form-control-sm flex-grow-1" placeholder="Lesson Title" required>
                            
                            <input type="file" name="video" class="form-control-file form-control-sm w-auto" accept="video/mp4,video/x-m4v,video/*" required>
                            
                            <div class="custom-control custom-switch shrink-0 ml-2">
                                <input type="checkbox" class="custom-control-input" id="preview_{{ $module->id }}" name="is_preview" value="1">
                                <label class="custom-control-label text-sm" for="preview_{{ $module->id }}">Preview</label>
                            </div>
                            
                            <button type="submit" class="btn btn-sm btn-success shrink-0 ml-2">
                                <i class="fas fa-plus mr-1"></i> Add Lesson
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="text-center py-10 bg-white rounded shadow-sm border border-gray-200">
                    <i class="fas fa-book-open text-gray-300 text-5xl mb-3"></i>
                    <h3 class="text-xl font-bold text-gray-600">No Curriculum Yet</h3>
                    <p class="text-gray-500 mb-4">Start building your course by adding the first module above.</p>
                </div>
            @endforelse

        </div>
    </div>
</x-admin-layout>
