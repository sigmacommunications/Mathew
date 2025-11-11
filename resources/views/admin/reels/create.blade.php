@extends('admin.layouts.app')
@section('content')
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

    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold float-left">New Reels Upload</h6>
                                <a class="btn btn-primary btn-sm float-right" href="{{ route('reels.index') }}"><i
                                        class="fa fa-arrow-left"></i> Back</a>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('reels.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="title" class="form-label">Title</label>
                                        <input type="text" name="title" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="description" class="form-label">Description</label>
                                        <textarea name="description" class="form-control" rows="4"></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="video" class="form-label">Reels File</label>
                                        <input type="file" name="video" class="form-control" accept="video/*" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="thumbnail" class="form-label">Thumbnail</label>
                                        <input type="file" name="thumbnail" class="form-control" accept="image/*"
                                            required>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Upload</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
