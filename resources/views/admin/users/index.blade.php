@extends('admin.layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold float-left">Users List</h6>
                                <a class="btn btn-primary btn-sm float-right" href="{{ route('users.create') }}">
                                    <i class="fa fa-plus"></i> Create New User
                                </a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example" class="table table-bordered table-striped">

                                        <thead>
                                            <tr>
                                                <th>S.N.</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Photo</th>
                                                <th>Join Date</th>
                                                <th>Role</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>S.N.</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Photo</th>
                                                <th>Join Date</th>
                                                <th>Role</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            @foreach ($users as $key => $user)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $user->name }}</td>
                                                    <td>{{ $user->email }}</td>
                                                    <td>
                                                        @if ($user->photo)
                                                            <img src="{{ $user->photo }}" class="img-fluid rounded-circle"
                                                                style="max-width:50px" alt="{{ $user->photo }}">
                                                        @else
                                                            <img src="{{ asset('images/avatar/64-1.jpg') }}"
                                                                class="img-fluid rounded-circle" style="max-width:50px"
                                                                alt="avatar.png">
                                                        @endif
                                                    </td>
                                                    <td>{{ $user->created_at ? $user->created_at->diffForHumans() : '' }}
                                                    </td>
                                                    <td>
                                                        @if (!empty($user))
                                                            <?php $roles = $user->getRoleNames(); ?>
                                                            @if (isset($roles[0]))
                                                                <label
                                                                    class="badge badge-primary">{{ Str::ucfirst($roles[0]) }}</label>
                                                            @endif
                                                        @endif
                                                    </td>


                                                    <td>
                                                        @if ($user->status == 'active')
                                                            <span class="badge badge-success">Active</span>
                                                        @else
                                                            <span class="badge badge-warning">In Active</span>
                                                        @endif
                                                    </td>

                                                    {{-- <td>
                                    @if ($user->payment_status == '1')
                                        <span class="badge badge-success">Active</span>
                                    @else
                                        <span class="badge badge-warning">In Active</span>
                                    @endif
                                </td> --}}
                                                    <td>

                                                        <a href="{{ route('users.edit', $user->id) }}"
                                                            class="btn btn-primary btn-sm float-left mr-1"
                                                            style="height:30px; width:30px;border-radius:50%"
                                                            data-toggle="tooltip" title="edit" data-placement="bottom"><i
                                                                class="fa fa-edit"></i></a>
                                                        <form method="POST"
                                                            action="{{ route('users.destroy', [$user->id]) }}">
                                                            @csrf
                                                            @method('delete')
                                                            <button class="btn btn-danger btn-sm dltBtn"
                                                                data-id={{ $user->id }}
                                                                style="height:30px; width:30px;border-radius:50%"
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Delete"><i class="fa fa-trash"></i></button>
                                                        </form>
                                                    </td>

                                                </tr>

                                                <!-- Modal Start -->
                                                <div class="modal fade" id="myModal{{ $user->id }}" tabindex="-1"
                                                    role="dialog" aria-labelledby="selectPackageModalLabel"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="selectPackageModalLabel">Select
                                                                    Package</h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form method="post" action="/">
                                                                    {{ csrf_field() }}

                                                                    <label for="package">Payment Method</label>
                                                                    <input type="hidden" value="{{ $user->id }}"
                                                                        id="userIdInput" name="userId">
                                                                    <input type="text" class="form-control"
                                                                        value="cash">
                                                                    <div class="form-group">
                                                                        <label for="package">Select a Package:</label>

                                                                        <select class="form-control" id="package"
                                                                            name="package">
                                                                            @foreach ($package as $ind)
                                                                                <option value="{{ $ind->id }}">
                                                                                    {{ $ind->name }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <button type="submit"
                                                                        class="btn btn-primary ">Subscription</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!--Modal End -->
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
@endsection

@push('styles')
    <link href="{{ asset('backend/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
    <style>
        div.dataTables_wrapper div.dataTables_paginate {
            display: none;
        }
    </style>
@endpush

@push('scripts')
    <!-- Page level plugins -->
    <script src="{{ asset('backend/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('backend/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('backend/js/demo/datatables-demo.js') }}"></script>

    <script>
        $(document).ready(function() {

            $('#abc').on('click', function() {
                alert('abc');
                // Get userId from data attribute
                var userId = $(this).data('user-id');

                // Set the value of the hidden input field for the specific modal
                $('#selectPackageModal').find('.userIdInput').val(userId);
            })
        });
    </script>

    <script>
        $('#user-dataTable').DataTable({
            "columnDefs": [{
                "orderable": false,
                "targets": [6, 7]
            }]
        });

        // Sweet alert

        function deleteData(id) {

        }
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
                                    confirmButtonText: 'OK'
                                }).then(() => {
                                    // Remove the row from the table dynamically
                                    form.closest('tr').remove();
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
