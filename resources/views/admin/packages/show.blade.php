@extends('admin.layouts.app')


@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold float-left">Package Details</h6>
                            <a class="btn btn-primary btn-sm float-right" href="{{ route('package.index') }}">
                                <i class="fa fa-arrow-left"></i> Back
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="container">
                                <p><strong>Name:</strong> {{ $package->name }}</p>
                                <p><strong>Amount:</strong> {{ $package->amount }}</p>
                                <p><strong>Description:</strong> {{ $package->description }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
