@extends('admin.layouts.app')
@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <!-- row -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold float-left">Add New Permission</h6>
                                <a class="btn btn-primary btn-sm float-right" href="{{ route('permission.index') }}"><i
                                        class="fa fa-arrow-left"></i>
                                    Back</a>
                            </div>
                            <div class="card-body">
                                <form method="post" action="{{ route('permission.store') }}">
                                    @csrf
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>Name:</strong>
                                                <input name="name" placeholder="Name" class="form-control" required>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered table-striped example1">
                                    <thead>
                                        <tr>
                                            <th width="10%">No</th>
                                            <th width="10%">Name</th>
                                            <th width="10%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($list as $key => $item)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $item->name }}</td>
                                                <td>
                                                    <form action="{{ route('permission.destroy', $item->id) }}" class="delete-form"
                                                        method="post">
                                                        @csrf
                                                        @method('delete')
                                                        <button type="submit"
                                                            onclick="return confirm('Are You Sure Want to Delete This Permission?')"
                                                            class="btn btn-danger"><i class="fa fa-trash"></i></button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script>
        $('.select2').select2()

        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })

        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": []
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>

    <script type="text/javascript">
        var APP_URL = {!! json_encode(url('/')) !!}
    </script>
    <style>
        .form-check-input {
            border-radius: 0 !important;
            height: 20px;
            width: 20px;
            margin: 0;
        }

        .form-group strong {
            margin: 0 0 10px;
            width: fit-content;
            display: block;
        }

        .my-txt-box {
            padding: 0 0 10px;
        }

        .my-label {
            padding-left: 30px;
            text-transform: capitalize;
        }
    </style>
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
         document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault(); // Prevent the default form submission

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
                        // Send the form via fetch API
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
                                    // Remove the row containing the form
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
