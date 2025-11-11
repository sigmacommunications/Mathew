@extends('admin.layouts.app')


@section('content')
    <style>
        form {
            align-items: baseline;
            display: flex;
        }
    </style>
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold float-left">File Uploads</h6>
                                <a class="btn btn-primary btn-sm float-right"href="{{ route('files.create') }}"><i
                                        class="fa fa-plus"></i> Files
                                    Upload</a>
                            </div>
                            <div class="card-body">
                                <table id="example" class="table table-bordered table-striped">
                                    <!-- <table id="example" class="table table-striped nowrap" style="width:100%"> -->
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Title</th>
                                            <th>Cover Image</th>
                                            <th>Created_at</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($files)
                                            @foreach ($files as $file)
                                                <tr>
                                                    <td>{{ $file->id }}</td>
                                                    <td>{{ $file->title }}</td>

                                                    <td>
                                                        @if ($file->cover_image)
                                                            <img src="{{ asset('storage/' . $file->cover_image) }}"
                                                                alt="{{ $file->title }}"
                                                                style="max-width: 100px; max-height: 100px;">
                                                        @else
                                                            <span>No Cover Image</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $file->created_at->format('Y-m-d') }}</td>
                                                    <td>
                                                        <!-- <a href="{{ route('files.show', $file->id) }}" class="btn btn-warning btn-sm float-left mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="edit" data-placement="bottom"><i class="fa fa-eye"></i></a> -->
                                                        <a href="{{ route('files.edit', $file->id) }}"
                                                            class="btn btn-primary btn-sm float-left mr-1"
                                                            style="height:30px; width:30px;border-radius:50%"
                                                            data-toggle="tooltip" title="edit" data-placement="bottom"><i
                                                                class="fa fa-edit"></i></a>
                                                        <form action="{{ route('files.destroy', $file->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="btn btn-danger btn-sm float-left mr-1"
                                                                style="height:30px; width:30px;border-radius:50%"
                                                                data-toggle="tooltip" title="edit"
                                                                data-placement="bottom"><i class="fa fa-trash"></i></button>
                                                        </form>
                                                    </td>

                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>

                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(form.action, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector(
                                        'meta[name="csrf-token"]').getAttribute('content'),
                                    'X-Requested-With': 'XMLHttpRequest'
                                },
                                body: new FormData(form)
                            })
                            .then(response => {
                                if (response.ok) {
                                    return response.json();
                                } else {
                                    throw new Error('Failed to delete');
                                }
                            })
                            .then(data => {
                                Swal.fire({
                                    title: 'Deleted!',
                                    text: data.message,
                                    icon: 'success',
                                    timer: 1500, // Auto close after 1.5 seconds
                                    showConfirmButton: false,
                                    willClose: () => {
                                        location.reload(); // Refresh the page
                                    }
                                });
                            })
                            .catch(error => {
                                console.error(error);
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'There was a problem deleting the role.',
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            });
                    }
                });
            });
        });
    </script>
@endpush
