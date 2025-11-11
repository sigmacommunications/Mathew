@extends('admin.layouts.app')


@section('content')
<style>
  form {
    align-items: baseline;
    display: flex;
}
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>situational humors</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">situational humors</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif -->
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">situational humors</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-header">
                <div class="row">
                  <div class="col-md-4">
                     <a href="{{ route('jokes.create') }}" class="btn btn-success">Create New Joke</a>
                  </div>
                  <div class="col-md-8">
                  <form action="{{ route('jokes.csv.upload') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                  <!-- <label for="csv_file">Upload CSV</label> -->
                  <input type="file" class="form-control-file" id="csv_file" name="csv_file" accept=".csv , .xlsx">
                </div>
                <button type="submit" class="btn btn-primary">Create Joke</button>
              </form>
                  </div>
                </div>
              </div>
              <div class="card-body">
                <table id="example" class="table table-bordered table-striped">
                <!-- <table id="example" class="table table-striped nowrap" style="width:100%"> -->
                  <thead>
                  <tr>
                      <th>ID</th>
                      <th>Joke Name</th>
				      <th>Details</th>
                      <th>Actions</th>
                  </tr>
                  </thead>
                  <tbody>
                  @if($jokes)
                 
                    @foreach($jokes as $joke)
                      <tr>
                          <td>{{ $joke->id }}</td>
                          <td>{{ $joke->joke_name }}</td>
						  <td>{{ $joke->joke_detail }}</td>
                          <td>
                                <a href="{{ route('jokes.show', $joke->id) }}" class="btn btn-warning btn-sm float-left mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="edit" data-placement="bottom"><i class="fa fa-eye"></i></a>
                                <a href="{{ route('jokes.edit', $joke->id) }}" class="btn btn-primary btn-sm float-left mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="edit" data-placement="bottom"><i class="fa fa-edit"></i></a>
                                <form action="{{ route('jokes.destroy', $joke->id) }}" method="POST">
                                  @csrf
                                  @method('DELETE')
                                  <button type="submit" class="btn btn-danger btn-sm float-left mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="edit" data-placement="bottom"><i class="fa fa-trash"></i></button>
                                </form>
                            </td>
                          <!-- <td>
                              <a href="{{ route('jokes.show', $joke->id) }}" class="btn btn-primary">View</a>
                              <a href="{{ route('jokes.edit', $joke->id) }}" class="btn btn-warning">Edit</a>
                              <form action="{{ route('jokes.destroy', $joke->id) }}" method="POST" style="display:inline">
                                  @csrf
                                  @method('DELETE')
                                  <button type="submit" class="btn btn-danger">Delete</button>
                              </form>
                          </td> -->
                      </tr>
                    @endforeach
                  @endif
                  </tbody>
                 
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>

@endsection
