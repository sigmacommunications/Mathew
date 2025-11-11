@extends('admin.layouts.app')


@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold float-left">Package List</h6>
                                <a class="btn btn-primary btn-sm float-right" href="{{ route('package.create') }}"><i
                                        class="fa fa-plus"></i> Create New
                                    Package</a>
                            </div>
                            <div class="card-body">
                                <table id="example" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Amount</th>
                                            <th>Description</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 0; ?>
                                        @if ($packages)
                                            @foreach ($packages as $package)
                                                <?php $i++; ?>
                                                <tr>
                                                    <td>{{ $i }}</td>
                                                    <td>{{ $package->name }}</td>
                                                    <td>{{ $package->amount }}</td>
                                                    <td>{{ $package->description }}</td>
                                                    <td>
                                                        <a href="{{ route('package.show', $package->id) }}"
                                                            class="btn btn-warning btn-sm float-left mr-1"
                                                            style="height:30px; width:30px;border-radius:50%"
                                                            data-toggle="tooltip" title="edit" data-placement="bottom"><i
                                                                class="fa fa-eye"></i></a>
                                                        <a href="{{ route('package.edit', $package->id) }}"
                                                            class="btn btn-primary btn-sm float-left mr-1"
                                                            style="height:30px; width:30px;border-radius:50%"
                                                            data-toggle="tooltip" title="edit" data-placement="bottom"><i
                                                                class="fa fa-edit"></i></a>
                                                        <form action="{{ route('package.destroy', $package->id) }}"
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
