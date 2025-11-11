@extends('layouts.master')

@section('title', 'Study Material')

@push('styles')
    <style>
        .img-wrapper {
            position: relative;
            overflow: hidden;
            margin-bottom: 20px;
        }

        .img-wrapper img {
            width: 100%;
            display: block;
            transition: transform 0.3s ease;
            border-radius: 8px;
            /* Optional for visual appeal */
        }

        .img-boxa {
            padding: 10px;
        }

        .img-wrapper:hover img {
            transform: scale(1.05);
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.7);
            /* dark overlay */
            color: white;
            opacity: 0;
            visibility: hidden;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 20px;
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }

        .img-wrapper:hover .overlay {
            opacity: 1;
            visibility: visible;
        }

        .transcript1-btn {
            margin-top: 15px;
            background-color: #ffcc00;
            padding: 10px 20px;
            color: #000;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }
    </style>
@endpush

@section('content')
    <section class="inner-pg-sec1">
        <div class="main-div">
            {{-- <h4 class="blue-head">Study Material</h4> --}}
            <h1>Study Material</h1>
            <p>Explore the latest updates, tips, and resources designed to make study material simpler, smarter, and more effective, helping you learn better at every stage of your financial journey.
</p>
        </div>
    </section>


    <section class="transcript-main py-4">
        <div class="container">
            <div class="row justify-content-center">
                @foreach ($files as $file)
                    <div class="col-md-4">
                        <div class="img-wrapper">
                            {{-- <img src="{{ asset($file->cover_image) }}" alt="Transcript"> --}}
                            <img src="{{ asset('storage/' . $file->cover_image) }}" alt="Transcript">
                            <div class="overlay">
                                <h4>{{ $file->name }}</h4>
                                <p>{{ $file->description }}</p>
                                <a href="{{ url('studymaterial/view/' . $file->id) }}" class="transcript1-btn">View</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
