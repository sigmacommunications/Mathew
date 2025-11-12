@extends('layouts.master')

@section('title', 'Contact')

@section('content')
    <section class="inner-pg-sec1">
        <div class="owl-carousel owl-theme banner">
            <div class="item">
                <div class="main-div">
                    <!-- <h4 class="blue-head">contact us</h4> -->
                    <h1>Contact Us</h1>
                    <p>Discover effective strategies to manage loans, build savings, and plan for retirement.</p>
                    <div class="btn-div">
						<a class="gs" href="tel:3042094280">Call: (304)209-4280</a>
						<a class="gs" href="#contact">Email us</a>
					</div>
                </div>
            </div>
        </div>
    </section>
    <section class="sec9" id="contact">
        <div class="container">
            <div class="row align-items-center">

                <div class="col-md-6">
                    <div class="imgdiv9">
                        <img class="sec3img" src="../../Frontend/assets/images/sec9img.png" alt="">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-main-page">
                        <form class="form" method="post" action="{{ route('getintouch') }}">
                            @csrf
                            <h2>Get in Touch</h2>
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <label for="">Name</label>
                                    <input type="text" class="form-field" name="name" placeholder="Name" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="">Email</label>
                                    <input type="text" class="form-field" name="email" placeholder="Email" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="">Phone Number</label>
                                    <input type="text" class="form-field" name="country_code" placeholder="Area Code"
                                        required>
                                </div>
                                <div class="col-md-8">
                                    <label for=""></label>
                                    <input type="text" class="form-field" name="contact_no" placeholder="Phone Number"
                                        required>
                                </div>
                                <div class="col-md-12">
                                    <label for="">Subject</label>
                                    <select class="form-field">
                                        <option value="budgeting">Budgeting</option>
                                        <option value="debt">Debt</option>
                                        <option value="savings">Savings</option>
                                        <option value="insurance">Insurance</option>
                                        <option value="estateplanning">Estate Planning</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>
                                <div class="col-md-12">
                                    <label for="">Your Comment</label>
                                    <textarea name="comment" class="cmnt-field" placeholder="Enter Your message" id=""></textarea>
                                    <input class="sm" type="submit" value="Send Message">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
