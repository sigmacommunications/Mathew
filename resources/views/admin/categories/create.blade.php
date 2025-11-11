@extends('admin.layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold float-left">Add New Categories</h6>
                                <a href="{{ route('categories.index') }}" class="btn btn-primary btn-sm float-right"
                                    data-toggle="tooltip" data-placement="bottom" title="Add User"><i
                                        class="fa fa-arrow-left"></i> Back</a>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('categories.store') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="name">Name:</label>
                                        <input type="text" name="name" id="name" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="amount">Amount:</label>
                                        <input type="text" name="amount" id="amount" class="form-control">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Add Category</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
