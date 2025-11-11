@extends('admin.layouts.app')
@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold float-left">Package Create</h6>
                                <a class="btn btn-primary btn-sm float-right" href="{{ route('package.index') }}">
                                    <i class="fa fa-arrow-left"></i> Back
                                </a>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="{{ route('package.store') }}">
                                    @csrf
                                    <div class="form-group">
                                        <label for="name">Name:</label>
                                        <input type="text" name="name" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="amount">Amount:</label>
                                        <input type="text" name="amount" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Description:</label>
                                        <textarea name="description" class="form-control" required></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="period_unit">Unit:</label>
                                        <select name="period" class="form-control" required>
                                            <option value="">Select Period For Package</option>
                                            <option value="month">Months</option>
                                            <option value="week">Weeks</option>
                                            <option value="year">Years</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Create</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
