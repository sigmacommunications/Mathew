@extends('layouts.app')
    @section('content')
    <section class="transcript-main">
        <div class="transcript-1">
            <h3 class="transcript1-a">Subscribe</h3>
            <h3 class="transcript1-b">Transcripts</h3>
        </div>
        <div class="transcript-2">
            <div class="container">
                <div class="row">
                @if(isset($transcripts) && count($transcripts) > 0)
                    @foreach($transcripts as $file)
                        <div class="col-md-4">
                            <div class="img-box">
                                <img src="{{ asset('storage/' . $file->cover_image) }}" class="transcript-img" />
                                <h4 class="transcript1-c">{{ isset($file->title) ? $file->title : '' }}</h4>
                                <p class="transcript1-d">{{ isset($file->description) ? $file->description : '' }}</p>
                                @if(auth()->check()) 
                                    @if($file->purchases->where('user_id', auth()->id())->count() > 0)
                                      <a href="{{ asset('storage/' . $file->path) }}" class="transcript1-btn" style="background-color: green; color: white;">Fill Now</a>   
                                    @else
                                        <a href="{{ route('checkPurchaseStatus', $file->id) }}" class="transcript1-btn">Buy</a>
                                    @endif
                                @else
                                    <a href="{{ route('login') }}" class="transcript1-btn">Login to Read</a>
                                @endif
                            </div>
                        </div>
                    @endforeach    
                @endif    
                </div>
            </div>
        </div>
    </section>
    @endsection