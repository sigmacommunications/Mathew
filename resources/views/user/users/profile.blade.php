@extends('user.layouts.app')

@section('title', 'User Profile')

@section('content')
    <div class="container">
        <h4 class="bg3-b">User Profile</h4>
        <div class="card shadow mb-4">

            <div class="card-body">
                <form class="border px-4 pt-2 pb-3" method="POST" action="{{ route('user-profile-update', $profile->id) }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body mt-4 ml-2">
                                    @if ($profile->profile_image)
                                        <img src="{{ asset('storage/' . $profile->profile_image) }}" alt="Profile Image"
                                            class="img-fluid rounded-circle profile-image" width="100px" height="100px">
                                    @else
                                        <p class="no-profile-image">No profile image available</p>
                                    @endif
                                    </br></br>
                                    <h5 class="card-title text-left"><small><i class="fas fa-user"></i>
                                            {{ $profile->name }}</small></h5>
                                    <p class="card-text text-left"><small><i class="fas fa-envelope"></i>
                                            {{ $profile->email }}</small></p>
                                    <p class="card-text text-left"><small class="text-muted"><i class="fas fa-hammer"></i>
                                            {{ $profile->role }}</small></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">

                            <div class="form-group">
                                <label for="inputTitle" class="col-form-label">Name</label>
                                <input id="inputTitle" type="text" name="name" placeholder="Enter name"
                                    value="{{ $profile->name }}" class="form-control">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="inputEmail" class="col-form-label">Email</label>
                                <input id="inputEmail" disabled type="email" name="email" placeholder="Enter email"
                                    value="{{ $profile->email }}" class="form-control">
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <input type="file" id="inputProfileImage" name="profile_image"
                                    class="form-control profile-image-input">
                                @error('profile_image')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>


                            <button type="submit" class="btn btn-success btn-sm">Update</button>
                </form>
            </div>
        </div>
        </form>
    </div>
    </div>
    </div>
@endsection


<style>
    .breadcrumbs {
        list-style: none;
    }

    .breadcrumbs li {
        float: left;
        margin-right: 10px;
    }

    .breadcrumbs li a:hover {
        text-decoration: none;
    }

    .breadcrumbs li .active {
        color: red;
    }

    .breadcrumbs li+li:before {
        content: "/\00a0";
    }

    .image {
        background: url('{{ asset('backend/img/background.jpg') }}');
        height: 150px;
        background-position: center;
        background-attachment: cover;
        position: relative;
    }

    .image img {
        position: absolute;
        top: 55%;
        left: 35%;
        margin-top: 30%;
    }

    i {
        font-size: 14px;
        padding-right: 8px;
    }

    .profile-image {
        width: 100px;
        height: 100px;
    }

    .no-profile-image {
        font-size: 14px;
        color: #999;
    }

    /* Adjustments for the form input */
    .form-group {
        margin-bottom: 20px;
    }

    .profile-image-input {
        padding-top: 10px;
    }

    /* Adjust card layout */
    .card {
        margin-bottom: 20px;
    }

    .card-title {
        margin-bottom: 0;
    }

    /* Customize form control appearance */
    .form-control {
        border: 1px solid #ced4da;
        border-radius: .25rem;
        padding: .375rem .75rem;
    }

    .form-control:focus {
        border-color: #80bdff;
        outline: 0;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }

    /* Button style */
    .btn {
        padding: .375rem .75rem;
        font-size: 1rem;
        line-height: 1.5;
        border-radius: .25rem;
        cursor: pointer;
    }

    .btn-success {
        color: #fff;
        background-color: #28a745;
        border-color: #28a745;
    }

    .btn-success:hover {
        background-color: #218838;
        border-color: #1e7e34;
    }

    /* Overall container padding */
    .card-body {
        padding: 20px;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {

        .col-md-4,
        .col-md-8 {
            flex: 0 0 100%;
            max-width: 100%;
        }
    }
</style>

@push('scripts')
    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
    <script>
        $('#lfm').filemanager('image');
    </script>
@endpush
