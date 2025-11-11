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
                                <h6 class="m-0 font-weight-bold float-left">Add Video</h6>
                                <a class="btn btn-primary btn-sm float-right" href="{{ route('videos.index') }}"><i
                                        class="fa fa-arrow-left"></i>
                                    Back</a>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('videos.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label for="title">Title:</label>
                                        <input type="text" name="title" id="title" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="video">Choose Video (MP4, MOV, AVI):</label>
                                        <input type="file" name="video" id="video" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="thumbnail">Choose Thumbnail (Optional, JPG, PNG, GIF):</label>
                                        <input type="file" name="thumbnail" id="thumbnail" class="form-control"
                                            accept="image/*">
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
