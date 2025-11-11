
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <title>Jokes</title>
</head>
<body>
      <section class="blog-posts">
        <div class="container">
          <div class="row">
            <div class="col-lg-8">
              <div class="all-blog-posts">
                <div class="row">
                  <div class="col-lg-12">
                    <div class="container mt-4">
						<a href="{{ URL::previous() }}" class="btn btn-secondary">Go Back</a>
						
                    </div></br>
                    <div class="blog-post">
                      <div class="blog-thumb">
                        <img src="{{ asset('assets/imgs/blog-post-01.jpg') }}" alt="">
                      </div>
                      <div class="down-content">
                        <a href="#"><h4 class="heading">{{ $joke->joke_name }}</h4></a>
                        <ul class="post-info">
                          <li><a href="#">{{ Auth()->user()->name }} </a></li>
                          <li><a href="#">{{ isset($joke) ? $joke->created_at : '' }}</a></li>
                          <!-- <li><a href="#">12 Comments</a></li> -->
                        </ul>
                        <p>{{ isset($joke) ? $joke->joke_detail : ''}}</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-4">
              <div class="sidebar">
                <div class="row">
                  <!-- <div class="col-lg-12">
                    <div class="sidebar-item search">
                      <form id="search_form" name="gs" method="GET" action="#">
                        <input type="text" name="q" class="searchText" placeholder="type to search..." autocomplete="on">
                      </form>
                    </div>
                  </div> -->
                  <div class="col-lg-12">
                    <div class="sidebar-item recent-posts">
                      <div class="sidebar-heading">
                        <h2>Recent Jokes</h2>
                      </div>
                      <div class="content">
                        <ul>
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
      </section>
     
</body>
</html>