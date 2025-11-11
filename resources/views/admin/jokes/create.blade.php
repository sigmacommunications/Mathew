@extends('admin.layouts.app')
@section('content')

<style>
  
  .form-check-input{
    border-radius: 0 !important;
    height: 20px;
    width: 20px;
    margin:0;
  }

  .form-group strong{
    margin: 0 0 10px;
    width: fit-content;
    display: block;
  }

  .my-txt-box{
    padding: 0 0 10px;
  }

  .my-label{
    padding-left: 30px;
    text-transform:capitalize;
  }
  
</style>

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Jokes</h1>
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
                      <form action="{{ route('jokes.store') }}" method="POST" enctype="multipart/form-data">
                          @csrf
                          <div class="form-group">
                              <label for="joke_name">Joke Name</label>
                              <input type="text" class="form-control" id="joke_name" name="joke_name" required>
                          </div>
                          <div class="form-group">
                              <label for="joke_detail">Humor Jokes</label>
                              <textarea class="form-control" id="joke_humor" name="joke_humor" rows="4" required></textarea>
                          </div>
                          <div class="form-group">
                              <label for="joke_detail">Joke Detail</label>
                              <textarea class="form-control" id="joke_detail" name="joke_detail" rows="4" required></textarea>
                          </div>
                          
                          <button type="submit" class="btn btn-primary">Create Joke</button>
                      </form>
                    </div>
                </div>
            </div>
          </div>
      </div>
  </section>
</div>

<script>
  $('.select2').select2()

  //Initialize Select2 Elements
  $('.select2bs4').select2({
    theme: 'bootstrap4'
  })

    $(function () {
      $("#example1").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": []
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
      $('#example2').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
      });
    });
</script>

<script type="text/javascript">
  var APP_URL = {!! json_encode(url('/')) !!}
</script>

@endsection
