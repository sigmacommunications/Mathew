@extends('layouts.app')
@section('content')
    <section class="transcript-main">
        <div class="transcript-1">
            <h3 class="transcript1-b">All Transcripts</h3>
        </div>
        <div class="transcript-2">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h4 class="all-trans-a">Legal Education</h4>
                        <h4 class="bg3-b">Order From 22 Traverse Hearing Transcripts</h4>
                        <center><p class="trans-p">Over 2,300 pages of testimony, legal argument and colloquy on personal jurisdiction and service of process</p></center>
                    </div>
                    
                    
                                        @if(Auth::check())
                        @foreach($paid as $file)
                        
                            <div class="col-md-3">
                                <div class="img-boxa">
                                    <img src="{{ asset('storage/' . $file->cover_image) }}" class="home3-img" />
                                    <div class="imgbox-hover">
                                        <h4 class="bg3-c">{{ isset($file->title) ? $file->title : '' }}</h4>
                                        <p class="bg3-d">{{ isset($file->description) ? $file->description : '' }}</p>
                <a href="{{ route('renderPDF', ['id' => $file->id]) }}" class="transcript2-btn" style="margin:9px">View Now</a>
				<a href="{{ route('product.buy.now', $file->id) }}" class="transcript1-btn" style="margin:-48px 34px 34px 118px">Buy Now</a>
                                    </div>
                                </div>
                            </div>
                        
                        @endforeach
                        @foreach($unpaid as $file)
                            <div class="col-md-3">
                                <div class="img-boxa">
                                    <img src="{{ asset('storage/' . $file->cover_image) }}" class="home3-img" />
                                    <div class="imgbox-hover">
                                        <h4 class="bg3-c">{{ isset($file->title) ? $file->title : '' }}</h4>
                                        <p class="bg3-d">{{ isset($file->description) ? $file->description : '' }}</p>
										<a href="{{ route('product.buy.now', $file->id) }}" class="transcript1-btn" style="margin:-48px 34px 34px 118px">Buy Now</a>
                                    </div>
                                </div>
                            </div>
                            
                        @endforeach
                    @else
                        @foreach($transcripts as $file)
                             <div class="col-md-3">
                                <div class="img-boxa">
                                    <img src="{{ asset('storage/' . $file->cover_image) }}" class="home3-img" />
                                    <div class="imgbox-hover">
                                        <h4 class="bg3-c">{{ isset($file->title) ? $file->title : '' }}</h4>
                                        <p class="bg3-d">{{ isset($file->description) ? $file->description : '' }}</p>
                                         <a href="{{ route('product.buy.now', $file->id) }}" class="transcript1-btn">Buy Now</a>
                                    </div>
                                </div>
                            </div>
                           
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
