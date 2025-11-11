@extends('admin.layouts.app')
<link href="{{ asset('backend/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />

@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold float-left">Comments List</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Comments</th>
                                                <th>URL</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Comments</th>
                                                <th>URL</th>
                                                <th>Actions</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            @php $i = 0; @endphp
                                            @foreach ($comments as $com)
                                                @php $i++; @endphp
                                                <tr>
                                                    <td>{{ $i }}</td>
                                                    <td>{{ $com->author }}</td>
                                                    <td>{{ $com->email }}</td>
                                                    <td>{{ $com->comment }}</td>
                                                    <td>{{ $com->website }}</td>
                                                    <td>
                                                        <button class="btn btn-success approve-comment"
                                                            data-comment-id="{{ $com->id }}"><i
                                                                class="fa fa-check"></i></button>
                                                        <button class="btn btn-warning cancel-comment"
                                                            data-comment-id="{{ $com->id }}"><i
                                                                class="fa fa-times"></i></button>
                                                        <form action="{{ route('comments.destroy', $com->id) }}"
                                                            method="post" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger"><i
                                                                    class="fa fa-trash"></i></button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.approve-comment').click(function() {
                var commentId = $(this).data('comment-id');
                approveComment(commentId);
            });

            $('.cancel-comment').click(function() {
                var commentId = $(this).data('comment-id');
                cancelComment(commentId);
            });

            function approveComment(commentId) {
                $.ajax({
                    url: "{{ route('comments.approve', ':id') }}".replace(':id', commentId),
                    type: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        swal('Success', response.message, 'success');
                        // You can update the UI here if needed
                    },
                    error: function(xhr) {
                        swal('Error', 'Failed to approve comment', 'error');
                    }
                });
            }

            function cancelComment(commentId) {
                $.ajax({
                    url: "{{ route('comments.cancel', ':id') }}".replace(':id', commentId),
                    type: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        swal('Success', response.message, 'success');
                        // You can update the UI here if needed
                    },
                    error: function(xhr) {
                        swal('Error', 'Failed to cancel comment', 'error');
                    }
                });
            }
        });
    </script>
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
                                    text: 'There was a problem deleting this comment.',
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            });
                    }
                });
            });
        });
    </script>
@endsection
{{-- @push('scripts')
@endpush --}}
