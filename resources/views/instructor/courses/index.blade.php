<x-admin-layout>
    <x-slot name="header">
        Courses
    </x-slot>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">My Courses</h3>
                    <div class="card-tools">
                        <a href="{{ route('instructor.courses.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Create Course
                        </a>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>Thumbnail</th>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($courses as $course)
                                <tr>
                                    <td>
                                        @if($course->thumbnail)
                                            <img src="{{ asset('storage/' . $course->thumbnail) }}" alt="Thumbnail" width="50" class="img-thumbnail">
                                        @else
                                            <span class="text-muted">No Image</span>
                                        @endif
                                    </td>
                                    <td>{{ $course->title }}</td>
                                    <td>{{ $course->category->name ?? 'N/A' }}</td>
                                    <td>${{ number_format($course->price, 2) }}</td>
                                    <td>
                                        @if($course->status === 'published')
                                            <span class="badge badge-success">Published</span>
                                        @elseif($course->status === 'draft')
                                            <span class="badge badge-secondary">Draft</span>
                                        @else
                                            <span class="badge badge-warning">{{ ucfirst($course->status) }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('instructor.courses.edit', $course) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('instructor.courses.destroy', $course) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure you want to delete this course? All modules and lessons will be deleted too.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">You haven't created any courses yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                    {{ $courses->links('pagination::bootstrap-4') }}
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
</x-admin-layout>
