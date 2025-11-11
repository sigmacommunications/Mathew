@extends('admin.layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold float-left">Add New User</h6>
                                <a class="btn btn-primary btn-sm float-right" href="{{ route('users.index') }}">
                                    <i class="fa fa-arrow-left"></i> Back
                                </a>
                            </div>
                            <div class="card-body">
                                <form method="post" action="{{ route('users.store') }}">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <label for="inputTitle" class="col-form-label">Name</label>
                                        <input id="inputTitle" type="text" name="name" placeholder="Enter name"
                                            value="{{ old('name') }}" class="form-control">
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="inputEmail" class="col-form-label">Email</label>
                                        <input id="inputEmail" type="email" name="email" placeholder="Enter email"
                                            value="{{ old('email') }}" class="form-control">
                                        @error('email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="inputPassword" class="col-form-label">Password</label>
                                        <input id="inputPassword" type="password" name="password"
                                            placeholder="Enter password" value="{{ old('password') }}" class="form-control">
                                        @error('password')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="inputPhoto" class="col-form-label">Photo</label>
                                        <div class="input-group">
                                            <span class="input-group-btn">
                                                <a id="lfm" data-input="thumbnail" data-preview="holder"
                                                    class="btn btn-primary">
                                                    <i class="fa fa-picture-o"></i> Choose
                                                </a>
                                            </span>
                                            <input id="thumbnail" class="form-control" type="text" name="profile_image"
                                                value="{{ old('photo') }}" readonly>
                                        </div>
                                        <img id="holder" style="margin-top:15px;max-height:100px;">
                                        @error('photo')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="role" class="col-form-label">Role</label>
                                        <select name="role" class="form-control">
                                            <option value="">-----Select Role-----</option>
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('role')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="status" class="col-form-label">Status</label>
                                        <select name="status" class="form-control">
                                            <option value="">Select User Status</option>
                                            <option value="active">Active</option>
                                            <option value="inactive">In Active</option>
                                        </select>
                                        @error('status')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-3">
                                        <button type="reset" class="btn btn-warning">Reset</button>
                                        <button class="btn btn-success" type="submit">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@push('scripts')
    <!-- Load jQuery first -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- Load the Laravel File Manager standalone button script -->
    <script src="{{ asset('vendor/laravel-filemanager/js/stand-alone-button.js') }}"></script>

    <script>
        $(document).ready(function() {
            console.log("Checking filemanager function availability");
            if (typeof $.fn.filemanager === 'function') {
                console.log("filemanager function is available!");
                $('#lfm').filemanager('image');
            } else {
                console.error("filemanager function is NOT available!");
            }
        });
    </script>
@endpush
