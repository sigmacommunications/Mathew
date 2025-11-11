@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h2>Video Details</h2>
    <div>
        <strong>Video Title:</strong> {{ $video->title }}
    </div>
    <div>
        <strong>Video:</strong>
        <video width="320" height="240" controls>
            <source src="{{ asset('storage/' . $video->path) }}" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </div>
    <div>
        @if($video->thumbnail)
            <strong>Thumbnail:</strong>
            <img src="{{ asset('storage/' . $video->thumbnail) }}" width="100" height="60" alt="Thumbnail">
        @else
            <strong>No Thumbnail Available</strong>
        @endif
    </div>
    <a href="{{ route('videos.index') }}" class="btn btn-primary">Back to List</a>
</div>
@endsection
