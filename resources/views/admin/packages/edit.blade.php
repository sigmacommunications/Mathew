@extends('admin.layouts.app')


@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold float-left">Package Edit</h6>
                                <a class="btn btn-primary btn-sm float-right" href="{{ route('package.index') }}">
                                    <i class="fa fa-arrow-left"></i> Back
                                </a>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="{{ route('package.update', $package->id) }}">
                                    @csrf
                                    @method('PATCH')
                                    <div class="form-group">
                                        <label for="name">Name:</label>
                                        <input type="text" name="name" class="form-control"
                                            value="{{ $package->name }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="amount">Amount:</label>
                                        <input type="text" name="amount" class="form-control"
                                            value="{{ $package->amount }}" readonly>
                                    </div>

                                    <div class="form-group">
                                        <label for="description">Description:</label>
                                        <textarea name="description" class="form-control" required>{{ $package->description }}</textarea>
                                    </div>
                                    {{-- <div class="form-group">
                                        <label for="period_unit">Unit:</label>
                                        <select name="period" class="form-control" required>
                                            <option value="months" {{ $package->period === 'months' ? 'selected' : '' }}>
                                                Months</option>
                                            <option value="weeks" {{ $package->period === 'weeks' ? 'selected' : '' }}>
                                                Weeks</option>
                                            <option value="years" {{ $package->period === 'years' ? 'selected' : '' }}>
                                                Years</option>
                                        </select>
                                    </div> --}}
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </form>
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
