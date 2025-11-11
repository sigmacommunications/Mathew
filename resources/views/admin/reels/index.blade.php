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
                                <h6 class="m-0 font-weight-bold float-left">Reels List</h6>
                                <a class="btn btn-primary btn-sm float-right" href="{{ route('reels.create') }}"><i
                                        class="fa fa-plus"></i> Upload a New Reel</a>
                            </div>
                            <div class="card-body">
                                <table id="example" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Title</th>
                                            <th>description</th>
                                            <th>Video</th>
                                            <th>Thumbnail</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($reels)
                                            @foreach ($reels as $key => $reel)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $reel->title }}</td>
                                                    <td>{{ $reel->description }}</td>
                                                    <td>
                                                        <video width="220" height="90" controls>
                                                            <source src="{{ asset('storage/' . $reel->path) }}"
                                                                type="video/mp4">
                                                            Your browser does not support the video tag.
                                                        </video>
                                                    </td>
                                                    <td>
                                                        @if ($reel->thumbnail)
                                                            <!-- Check if thumbnail exists -->
                                                            <img src="{{ asset('storage/' . $reel->thumbnail) }}"
                                                                width="100" height="60" alt="Thumbnail">
                                                        @else
                                                            No Thumbnail
                                                            <!-- Optional: Display a message if there's no thumbnail -->
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('reels.edit', $reel->id) }}"
                                                            class="btn btn-primary btn-sm float-left mr-1"
                                                            style="height:30px; width:30px;border-radius:50%"
                                                            data-toggle="tooltip" title="edit" data-placement="bottom"><i
                                                                class="fa fa-edit"></i></a>
                                                        <form action="{{ route('reels.destroy', $reel->id) }}"
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
                        </div>
                    </div>
                </div>
            </div>
        </section>
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
