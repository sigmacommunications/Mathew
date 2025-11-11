@extends('user.layouts.app')

@section('content')
<style>
  .disabled {
    pointer-events: none;
    opacity: 0.5;
}
</style>
<link rel="stylesheet" href="{{ asset('css/min.css') }}">

<div class="card-body">
    <table id="jokesTable" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Situation</th>
                <th>Status</th>
              
            </tr>
        </thead>
        <tbody>
            @foreach($jokes as $joke)
            <tr>
                <td>{{ $joke->jokes_id }}</td>
                <td>
                    <span class="short-text" id="s_{{ $joke->id }}">{{ $joke->joke_humor }}..</span>
                    <span class="full-text d-none" id="f_{{ $joke->id }}">{{ $joke->joke_humor }} <b>{{ $joke->joke_detail }}</b></span><br>
                    @if(strlen($joke->joke_humor) > 30)
                		@if(auth()->check() && auth()->user()->payment_status == 1)
						 	<button class="btn btn-link read-more-btn read-more-btn1" data-id="{{ $joke->id }}" data-jokes_name="{{ $joke->joke_name }}">Read More</button>
						@else
							<a href="{{ route('user.purchase.package.create') }}" class="btn btn-link">Subscription More</a>
						@endif 
				      
                    @endif
                </td>
                <td>
                    @php
                        $isReadByUser = false;
                        foreach($joke->isRead as $read) {
                            if($read->user_id == auth()->user()->id) {
								if(auth()->user()->no_of_jokes > 0){
									$isReadByUser = true;
                                	break; // Exit the loop once found
                            	}
							}
                        }
                    @endphp
                    @if($isReadByUser)
                        <span id="b_{{ $joke->id }}" class="badge badge-success">Read</span>
                    @else
                        <span id="b_{{ $joke->id }}" class="badge badge-secondary">Unread</span>
                    @endif
                </td>
              
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Bootstrap Modal -->
<div class="modal fade bd-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Situational</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
	        </div>
           <div class="container">
          <div class="row">
				<div class="col-lg-8">
				  <div class="all-blog-posts">
					 <div class="row">
						<div class="col-lg-12" style="margin-top: 48px;">
							<div class="blog-post">
							  <div class="blog-thumb">
								<img src="{{ asset('assets/imgs/blog-post-01.jpg') }}" alt="">
							  </div>
							  <div class="down-content"><br>
								<span class="heading" id="modalHeading1" style="padding: 21px;font-size: 28px; font-weight: bold;"></span>
								<p class="modal-body" style="text-align: justify;"></p>
							  </div>
							</div>
						</div>
					  </div>
				  </div>
				</div>
            <div class="col-lg-4">
                 <div class="sidebar">
                  <div class="row">
                 	  <div class="col-lg-12">
						<div class="sidebar-item recent-posts">
						  <div class="sidebar-heading">
							<h2>Recent Jokes</h2>
						  </div>
						  <div class="content">
							<ul>
							@php $jokes = \App\Models\Joke::latest()->take(4)->get(); @endphp	
							  @if(!empty($jokes))  
								@foreach($jokes as $jk)  
								<li>
							
								<a href="#">
									<h5>{{ $jk->joke_name }}</h5>
									<span>{{ $jk->created_at }}</span>
								</a>
								</li>                            
								@endforeach
							  @endif

							</ul>
						  </div>
						</div>
					  </div>
                    </div>
                 </div>
             </div>
          </div>
         </div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			  </div>
		</div>
    </div>
</div>



<!-- jQuery and Bootstrap JavaScript -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
	 $('#myModal').on('hidden.bs.modal', function () {
        window.location.reload();
    });
    $(document).ready(function() {
        $('.read-more-btn').on('click', function() {
            //var jokeId = $(this).closest('tr').find('td:first').text();
			var jokeId = $(this).attr("data-id");
			var fullText = $(this).closest('td').find('.full-text').text();
			var jokeName = $(this).data('jokes_name');
			
			
			 $("#s_"+jokeId).addClass("d-none");
			 $("#f_"+jokeId).removeClass("d-none");
			 $("#b_"+jokeId).addClass("badge-success");
			 $("#b_"+jokeId).removeClass("badge-secondary");
			 $("#b_"+jokeId).text("Read");
			 $(this).hide();
			
	    });
		
		 $('.read-more-btn1').on('click', function() {
            var id = $(this).data('id');
			  var url = "{{ route('user.jokes.details', ':id') }}".replace(':id', id);
			
            // Make an AJAX request to fetch joke details
            $.ajax({
                url: url, // Include the id parameter in the route
                type: 'GET',
                success: function(response) {
						if (response.success === true) {
							window.location.reload();
						}
			    },
                error: function(error) {
                    console.error(error);
                }
            });
        });
    });
</script>

@endsection