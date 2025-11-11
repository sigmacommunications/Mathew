<footer>
        <div class="container" style="width: auto !important;">
            <div class="row align-items-start">
                <div class="col-md-12">
                    <div class="footlogo">
                        @if ($settings && $settings->footer_logo)
                            <img class="navlogo" src="{{ asset('storage/logos/' . $settings->footer_logo) }}"
                                alt="">
                        @else
                            <img class="navlogo" src="../../Frontend/assets/images/logo.png" alt="">
                        @endif
                        <p>{{ $settings->description }}</p>
                    </div>
                </div>
                <div class="col-md-2 col-lg-3">
                    <ul class="footul">
                        <h6>Helpful Links</h6>
                        <li><a href="{{ route('about-us') }}">About Us</a></li>
                        <li><a href="{{ route('blog') }}">Blog</a></li>
                        <li><a href="{{ route('event') }}">Event</a></li>
						<li><a href="{{ route('studymaterial') }}">Study Material</a></li>
                    </ul>
                </div>
                <div class="col-md-3 col-lg-3">
                    <ul class="footul">
                        <h6>Support</h6>
                        <li><a href="{{ route('contact-us') }}">Contact Us</a></li>
                        <li><a href="{{ route('privacypolicy') }}">Privacy Policy</a></li>
                        <li><a href="{{ route('termandcondition') }}">Terms & Conditions</a></li>
                    </ul>
                </div>
                <div class="col-md-5 col-lg-3">
                    <ul class="footul">
                        <h6>Get in Touch</h6>
                        <li>Our Email<a class="blutxt" href="#">{{ $settings->email ?? null }}</a></li>
                        <li>Phone Number<a class="blutxt" href="#">{{ $settings->contact_no ?? null }}</a></li>
                        <li>Office Address<a class="blutxt" href="#">734 Eli Locust Rd.
							Washington, WV 26181</a></li>
                    </ul>
                </div>
                <div class="col-md-2 col-lg-3">
                    <ul class="footul">
                        <h6>follow us</h6>
                        <div class="foot-icon">
                            <a href="#"><img src="../../Frontend/assets/images/facebook.png"
                                    alt=""></a>
                            <a href="#"><img src="../../Frontend/assets/images/instagram.png"
                                    alt=""></a>
                            <a href="#"><img src="../../Frontend/assets/images/x.com.png" alt=""></a>
                        </div>
                    </ul>
                </div>
            </div>
            <div class="cr">
                <div class="cr-div d-none d-md-block d-lg-block">
                    <a href="./privacy-policy">Privacy Policy</a>
                    <a href="./terms-and-conditions">Terms and Conditions</a>
                </div>
                <p>{{ $settings->copyright ?? null }} © 2024. All Rights Reserved</p>
            </div>
        </div>
    </footer>