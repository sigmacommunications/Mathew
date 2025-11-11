@extends('admin.layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold float-left">Settings</h6>
                                {{-- <a class="btn btn-primary btn-sm float-right" href="{{ route('users.create') }}">
                                    <i class="fa fa-plus"></i> Create New User
                                </a> --}}
                            </div>
                            <div class="card-body">
                                <form action="" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    {{-- {{ route('settings.update') }} --}}
                                    <div class="form-group">
                                        <label for="title">Site Title</label>
                                        <input type="text" class="form-control" name="title" id="title"
                                            value="{{ old('title', $setting->title ?? null) }}">
                                    </div>

                                    <div class="form-group">
                                        <label for="header_logo">Header Logo</label>
                                        <input type="file" class="form-control" name="header_logo" id="header_logo">
                                        @if ($setting->header_logo ?? null)
                                            <img src="{{ asset('storage/logos/' . $setting->header_logo ?? null) }}"
                                                width="100" height="100">
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="footer_logo">Footer Logo</label>
                                        <input type="file" class="form-control" name="footer_logo" id="footer_logo">
                                        @if ($setting->footer_logo ?? null)
                                            <img src="{{ asset('storage/logos/' . $setting->footer_logo) ?? null }}"
                                                width="100" height="100">
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="contact_no">Contact Number</label>
                                        <input type="text" class="form-control" name="contact_no" id="contact_no"
                                            value="{{ old('contact_no', $setting->contact_no ?? null) }}">
                                    </div>

                                    <div class="form-group">
                                        <label for="email">Email Address</label>
                                        <input type="email" class="form-control" name="email" id="email"
                                            value="{{ old('email', $setting->email ?? null) }}">
                                    </div>

                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea class="form-control" name="description" id="description">{{ old('description', $setting->description ?? null) }}</textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="copyright">Copyright Text</label>
                                        <input type="text" class="form-control" name="copyright" id="copyright"
                                            value="{{ old('copyright', $setting->copyright ?? null) }}">
                                    </div>

                                    <br>
                                    <button type="submit" class="btn btn-primary">Update Settings</button>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
