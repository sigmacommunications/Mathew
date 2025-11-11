@extends('user.layouts.app')

@section('content')
<div class="content-wrapper">
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Joke Detail</h3>
                        </div>
                        <div class="card-body">
                            <h2>{{ $joke->joke_name }}</h2>
                            <p>{{ $joke->joke_detail }}</p>
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('jokes') }}" class="btn btn-secondary">Back to Jokes</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection