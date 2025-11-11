{{-- @extends('layouts.app')
@section('content')
    <section class="transcript-main">
        <div class="transcript-1">
            <h3 class="transcript1-b">Blogs</h3>
        </div>

        <div class="bg4 blog-page">
            <div class="container">
                <h4 class="bg3-b">Latest Articles</h4>
                <div class="blog-div-about">
                    @foreach ($blogs as $bg)
                        <div class="blog-inner">
                            <a href="{{ route('inner.blogs', $bg->id) }}"><img src="{{ asset('storage/' . $bg->image) }}"
                                    class="blog-img" /></a>
                            <a href="{{ route('inner.blogs', $bg->id) }}" class="blog-a">{!! Str::limit($bg->title, 70) !!}</a>
                            <h3 class="blog-b"><i style="color:#fad37f;margin-right: 5px;" class="fa-solid fa-calendar"></i>
                                {{ \Carbon\Carbon::parse($bg->created_at)->format('F j, Y') }}</h3>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </section>
@endsection --}}
@extends('layouts.master')

@section('title', 'Blogs')

@section('content')
    <section class="inner-pg-sec1">
        <div class="owl-carousel owl-theme banner">
            <div class="item">
                <div class="main-div">
                    <h4 class="blue-head">BLOGS</h4>
                    <h1>Blogs</h1>
                    <p>Stay updated with insights and tips on personalized financial guidance for every stage of life, from clearing debt to planning retirement, so that you can build lasting stability and success.</p>
                    <a class="gs" href="#">Read All</a>
                </div>
            </div>
        </div>
    </section>
    <section class="blog-sec-sec2">
        <div class="container">
            <div class="row align-items-center">
                @foreach ($blogs as $bg)
                    <div class="col-md-4">
                        <div class="blog1">

                            <h4> <a href="{{ route('inner.blogs', $bg->id) }}" class="blog-a">{!! Str::limit($bg->title, 70) !!}</a>
                            </h4>
                            <h5 class="blog-b"><i style="color:#fad37f;margin-right: 5px;" class="fa-solid fa-calendar"></i>
                                {{ \Carbon\Carbon::parse($bg->created_at)->format('F j, Y') }}</h5>

                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <section class="sec6">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-1"></div>
                <div class="col-md-6 col-lg-5">
                    <div class="cntntofsec6">
                        <h5>Ready to Take Control of Your Finances with Compass Solutions?</h5>
                        <p>We help you whether you are drowning in debt, planning for retirement, or just trying to stretch that paycheck. Take the first step today and see what a difference it can make in your life.
Learn to manage loans, savings, and retirement effectively. We will always point you in the right direction.
                        </p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-5">
                    <div class="btns">
                        <a href="{{ route('login') }}" class="comp">Register Now</a>
                    </div>
                </div>
                <div class="col-lg-1"></div>
            </div>
        </div>
    </section>
    <section class="sec8">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="cntntofsec3">
                        <h4 class="blue-head">Testimonial</h4>
                        <h2 class="blck-head">What Our Happy Clients Say</h2>
                        <p>We are proud to share how our financial coaching services have transformed the lives of our clients. Here’s what they have to say about their experience working with us:</p>
						<div class="owl-carousel owl-theme testimonial">
							<div class="item">
							   <div class="cmnts">
									<p>“Before I found Matthew, I was drowning in credit card debt and student loans. His personalized coaching helped me take control of my finances, pay off my debt faster, and start saving for the future. I’m now on a clear path to financial freedom, and I couldn’t be more grateful.”</p>
									<div class="quoteimg">
										<img src="../../Frontend/assets/images/quote.png" alt="">
									</div>
									<div class="profile2">
										<h5>Emily W</h5>
										<h5 class="man">Young Professional</h5>
									</div>
                        	</div>
						</div>
							<div class="item">
							   <div class="cmnts">
									<p>“I had been struggling with my mortgage payments for years and didn't know where to turn. Matthew’s guidance on managing debt and planning for emergencies gave me the tools I needed to create a solid financial plan. Today, I’m finally at peace with my financial situation.”</p>
									<div class="quoteimg">
										<img src="../../Frontend/assets/images/quote.png" alt="">
									</div>
									<div class="profile2">
										<h5>James L</h5>
										<h5 class="man">Homeowner</h5>
									</div>
                        	</div>
						</div>
							<div class="item">
							   <div class="cmnts">
									<p>“As a couple, we were overwhelmed by our finances and couldn’t agree on the best approach to handle our money. Matthew’s coaching helped us create a joint financial plan, aligning our goals and putting us on track for a secure future. We’ve paid off debt and started saving for retirement!”</p>
									<div class="quoteimg">
										<img src="../../Frontend/assets/images/quote.png" alt="">
									</div>
									<div class="profile2">
										<h5>Sarah & Tom R</h5>
										<h5 class="man">Married Couple</h5>
									</div>
                        	</div>
						</div>
							<div class="item">
							   <div class="cmnts">
									<p>“I lost my way after bankruptcy. He not only guided me on how to rebuild my credit but  taught me how to build an emergency fund and plan for retirement. Now, I am empowered to control my finances as well as have better choices for the future.”</p>
									<div class="quoteimg">
										<img src="../../Frontend/assets/images/quote.png" alt="">
									</div>
									<div class="profile2">
										<h5>Amanda G</h5>
										<h5 class="man">Single Parent</h5>
									</div>									
                        	</div>
						</div>
							<div class="item">
							   <div class="cmnts">
									<p>“I had no idea where to start with my financial planning. Matthew made it so easy to understand budgeting, saving, and investing. I’m now confident about my financial future, with a clear plan for paying off student loans and saving for retirement.”</p>
									<div class="quoteimg">
										<img src="../../Frontend/assets/images/quote.png" alt="">
									</div>
									<div class="profile2">
										<h5>Daniel S</h5>
										<h5 class="man">College Graduate</h5>
									</div>
                        	</div>
						</div>
					</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <img class="sec3img" src="../../Frontend/assets/images/sec8img.png" alt="">
                </div>
            </div>
        </div>

    </section>
    <!--<section class="sec7">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="headsec5">
                        <h4 class="blue-head">Meet Our Team</h4>
                        <h2 class="blck-head">Our Leadership Team</h2>
                        <p>Our team at Compass Solutions is dedicated to coaching individuals and families toward financial freedom.</p>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="owl-carousel owl-theme testi">
                        <div class="item">
                            <div class="card">
                                <img src="../../Frontend/assets/images/prof1.png" alt="">
                                <h5>Henry</h5>
                                <h5 class="man">Manager</h5>
                                <div class="card-icons">
                                    <i class="fa-solid fa-envelope"></i>
                                    <i class="fa-brands fa-facebook-f"></i>
                                    <i class="fa-brands fa-x-twitter"></i>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="card">
                                <img src="../../Frontend/assets/images/prof2.png" alt="">
                                <h5>Jenny</h5>
                                <h5 class="man">Manager</h5>
                                <div class="card-icons">
                                    <i class="fa-solid fa-envelope"></i>
                                    <i class="fa-brands fa-facebook-f"></i>
                                    <i class="fa-brands fa-x-twitter"></i>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="card">
                                <img src="../../Frontend/assets/images/prof3.png" alt="">
                                <h5>Arthur</h5>
                                <h5 class="man">Manager</h5>
                                <div class="card-icons">
                                    <i class="fa-solid fa-envelope"></i>
                                    <i class="fa-brands fa-facebook-f"></i>
                                    <i class="fa-brands fa-x-twitter"></i>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="card">
                                <img src="../../Frontend/assets/images/prof4.png" alt="">
                                <h5>Arthur</h5>
                                <h5 class="man">Manager</h5>
                                <div class="card-icons">
                                    <i class="fa-solid fa-envelope"></i>
                                    <i class="fa-brands fa-facebook-f"></i>
                                    <i class="fa-brands fa-x-twitter"></i>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="card">
                                <img src="../../Frontend/assets/images/prof2.png" alt="">
                                <h5>Jenny</h5>
                                <h5 class="man">Manager</h5>
                                <div class="card-icons">
                                    <i class="fa-solid fa-envelope"></i>
                                    <i class="fa-brands fa-facebook-f"></i>
                                    <i class="fa-brands fa-x-twitter"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>-->
@endsection
