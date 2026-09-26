<x-admin-layout>
    <x-slot name="header">
        Edit Course
    </x-slot>

    <div class="row">
        <div class="col-md-10">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Update Course Details</h3>
                </div>
                <!-- form start -->
                <form action="{{ route('instructor.courses.update', $course) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="title">Course Title</label>
                                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" id="title" placeholder="Enter course title" value="{{ old('title', $course->title) }}" required>
                                    @error('title')<span class="error invalid-feedback">{{ $message }}</span>@enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="price">Price ($)</label>
                                    <input type="number" step="0.01" min="0" name="price" class="form-control @error('price') is-invalid @enderror" id="price" placeholder="0.00" value="{{ old('price', $course->price) }}" required>
                                    @error('price')<span class="error invalid-feedback">{{ $message }}</span>@enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description" rows="5" placeholder="Enter course description" required>{{ old('description', $course->description) }}</textarea>
                            @error('description')<span class="error invalid-feedback">{{ $message }}</span>@enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Category</label>
                                    <select name="category_id" class="form-control @error('category_id') is-invalid @enderror" required>
                                        <option value="">-- Select Category --</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id', $course->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id')<span class="error invalid-feedback">{{ $message }}</span>@enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tags</label>
                                    <select name="tags[]" class="form-control" multiple>
                                        @foreach($tags as $tag)
                                            <option value="{{ $tag->id }}" {{ in_array($tag->id, old('tags', $course->tags->pluck('id')->toArray())) ? 'selected' : '' }}>{{ $tag->name }}</option>
                                        @endforeach
                                    </select>
                                    <small class="form-text text-muted">Hold CTRL (or CMD) to select multiple tags.</small>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="thumbnail">Course Thumbnail</label>
                            @if($course->thumbnail)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $course->thumbnail) }}" alt="Thumbnail" class="img-thumbnail" width="150">
                                </div>
                            @endif
                            <div class="custom-file">
                                <input type="file" name="thumbnail" class="custom-file-input @error('thumbnail') is-invalid @enderror" id="thumbnail" accept="image/*">
                                <label class="custom-file-label" for="thumbnail">Choose new image (optional)...</label>
                            </div>
                            @error('thumbnail')<span class="text-danger small">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Update Course</button>
                        <a href="{{ route('instructor.courses.index') }}" class="btn btn-default float-right">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>
