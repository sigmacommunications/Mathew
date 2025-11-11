@extends('admin.layouts.app')

@section('title','Admin Profile')

@section('content')

<div class="card shadow mb-4">
   
   <div class="card-header py-3">
     <h4 class=" font-weight-bold">Profile</h4>
     <ul class="breadcrumbs">
         <li><a href="{{route((auth()->user()->role == 'admin') ? 'admin.dashboard' : 'admin.dashboard' ) }}" style="color:#999">Dashboard</a></li>
         <li><a href="" class="active text-primary">Profile Page</a></li>
     </ul>
   </div>
   <div class="card-body">
       <form class="border px-4 pt-2 pb-3" method="POST" action="{{route('admin-profile-update',$profile->id)}}" enctype="multipart/form-data">
            <div class="row">
                    @csrf
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body mt-4 ml-2">
                            @if($profile->profile_image)
                                <img src="{{ asset('storage/' . $profile->profile_image) }}" alt="Profile Image" class="img-fluid rounded-circle" width="100px" height="100px">
                            @else
                                <p>No profile image available</p>
                            @endif 
                            </br></br>
                        <h5 class="card-title text-left"><small><i class="fas fa-user"></i> {{$profile->name}}</small></h5>
                        <p class="card-text text-left"><small><i class="fas fa-envelope"></i> {{$profile->email}}</small></p>
                        <p class="card-text text-left"><small class="text-muted"><i class="fas fa-hammer"></i> {{$profile->role}}</small></p>
                        
                    </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="inputTitle" class="col-form-label">Name</label>
                        <input id="inputTitle" type="text" name="name" placeholder="Enter name"  value="{{$profile->name}}" class="form-control">
                        @error('name')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                        
                    </div>

                      <div class="form-group">
                          <label for="inputEmail" class="col-form-label">Email</label>
                        <input id="inputEmail" disabled type="email" name="email" placeholder="Enter email"  value="{{$profile->email}}" class="form-control">
                        @error('email')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                      </div>
                    <div class="form-group">
						 <label for="inputProfileImage" class="col-form-label">Profile Picture</label>
                        <input type="file" id="inputProfileImage" name="profile_image" class="form-control" >
                        @error('profile_image')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                     
                       

                        <button type="submit" class="btn btn-success btn-sm">Update</button>
                    </div>
                </div>
            </div>
            </form>
</div>

@endsection

<style>
    .breadcrumbs{
        list-style: none;
    }
    .breadcrumbs li{
        float:left;
        margin-right:10px;
    }
    .breadcrumbs li a:hover{
        text-decoration: none;
    }
    .breadcrumbs li .active{
        color:red;
    }
    .breadcrumbs li+li:before{
      content:"/\00a0";
    }
    .image{
        background:url('{{asset('backend/img/background.jpg')}}');
        height:150px;
        background-position:center;
        background-attachment:cover;
        position: relative;
    }
    .image img{
        position: absolute;
        top:55%;
        left:35%;
        margin-top:30%;
    }
    i{
        font-size: 14px;
        padding-right:8px;
    }
  </style>

@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script>
    $('#lfm').filemanager('image');
</script>
@endpush
