@extends('admin.layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold float-left">Events List</h6>
                                <a class="btn btn-primary btn-sm float-right" href="{{ route('events.create') }}">
                                    <i class="fa fa-plus"></i> Create New Event
                                </a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example" class="table table-bordered table-striped">

                                        <thead>
                                            <tr>
                                                <th>S.N.</th>
                                                <th>Name</th>
                                                <th>Description</th>
                                                <th>Event Date</th>
                                                <th>Reminder Time</th>
                                                <th>Subscription Price</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>S.N.</th>
                                                <th>Name</th>
                                                <th>Description</th>
                                                <th>Event Date</th>
                                                <th>Reminder Time</th>
                                                <th>Subscription Price</th>
                                                <th>Actions</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            @foreach ($events as $event)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $event->name }}</td>
                                                    <td>{{ $event->description }}</td>
                                                    <td>{{ $event->event_date }}</td>
                                                    <td>{{ $event->reminder_time }}</td>
                                                    <td>{{ $event->event_price }}</td>
                                                    <td>
                                                        <a href="{{ route('events.edit', $event->id) }}"
                                                            class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                                                        <form action="{{ route('events.destroy', $event->id) }}"
                                                            method="POST" class="delete-form d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault(); // Stop default form submission

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
                                method: 'DELETE', // Correct method for Laravel
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector(
                                        'meta[name="csrf-token"]').getAttribute('content'),
                                    'X-Requested-With': 'XMLHttpRequest'
                                }
                            })
                            .then(response => response.json()) // Ensure JSON response
                            .then(data => {
                                if (data.success) {
                                    Swal.fire({
                                        title: 'Deleted!',
                                        text: data.message,
                                        icon: 'success',
                                        timer: 1500, // Auto close after 1.5 seconds
                                        showConfirmButton: false
                                    }).then(() => {
                                        location
                                            .reload(); // Refresh page after deletion
                                    });
                                } else {
                                    throw new Error(data.message || 'Failed to delete.');
                                }
                            })
                            .catch(error => {
                                console.error(error);
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'There was a problem deleting the event.',
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
