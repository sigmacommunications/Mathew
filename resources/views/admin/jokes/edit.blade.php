@extends('admin.layouts.app')


@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Joke</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">situational humor</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <section class="content">
    <div class="container-fluid">

        <div class="row">
          <div class="col-12">
              <div class="card">
                  <div class="card-header">
                  <form action="{{ route('jokes.update', $joke->id) }}" method="POST">
                      @csrf
                      @method('PUT')
                      <div class="form-group">
                          <label for="joke_name">Joke Name</label>
                          <input type="text" class="form-control" id="joke_name" name="joke_name" value="{{ $joke->joke_name }}" required>
                      </div>
                      <div class="form-group">
                          <label for="joke_detail">Humor Jokes</label>
                          <textarea class="form-control" id="joke_humor" name="joke_humor" rows="4" required>{{ $joke->joke_humor }}</textarea>
                      </div>
					  <div class="form-group">
                          <label for="joke_detail">Joke Detail</label>
                          <textarea class="form-control" id="joke_detail" name="joke_detail" rows="4" required>{{ $joke->joke_detail }}</textarea>
                      </div>
                      <button type="submit" class="btn btn-primary">Update Joke</button>
                  </form>
                  </div>
              </div>
          </div>
        </div>
    </div>
</section>
  </div>
 



@endsection
