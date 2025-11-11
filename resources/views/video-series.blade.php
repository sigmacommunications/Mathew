@extends('layouts.app')
<style>
.playlist-item:hover {
    background-color: #e6e6e6;
    border-color: #bbb;
}

.playlist-item:active {
    background-color: #d9d9d9;
    border-color: #aaa;
}
a {
    text-decoration: none;
}

.pricingTable {
    text-align: center;
    background: #8b3f7d;
        margin: -8px -3px 15px -7px;
    box-shadow: 0 0 10px #ababab;
    padding-bottom: 40px;
    border-radius: 10px;
    color: #b12a2a;
    transform: scale(1);
    transition: all .5s ease 0s
}

.pricingTable:hover {
    transform: scale(1.05);
    z-index: 1
}

.pricingTable .pricingTable-header {
    padding: 40px 0;
    background: #fff;
    border-radius: 10px 10px 50% 50%;
    transition: all .5s ease 0s
}

.pricingTable:hover .pricingTable-header {
    background: #f6ffed
}

.pricingTable .pricingTable-header i {
    font-size: 50px;
    color: #ffd140;
    margin-bottom: 10px;
    transition: all .5s ease 0s
}

.pricingTable .price-value {
    font-size: 35px;
    color: #003087;
    font-weight: bold;
    transition: all .5s ease 0s;
}

.pricingTable .month {
    display: block;
    font-size: 14px;
    color: #cad0de
}

.pricingTable:hover .month,
.pricingTable:hover .price-value,
.pricingTable:hover .pricingTable-header i {
    color: #e9c02a
}

.pricingTable .heading {
    font-size: 24px;
    color: #fdfeff;
    margin-bottom: 20px;
    text-transform: uppercase
}

.pricingTable .heading1 {
    font-size: 12px;
    font-weight: bold;
    margin-bottom: 20px;
    text-transform: uppercase;
}



.pricingTable .pricing-content ul {
    list-style: none;
    padding: 0;
    margin-bottom: 30px
}

.pricingTable .pricing-content ul li {
    line-height: 30px;
    color: #a7a8aa
}

.pricingTable .pricingTable-signup a {
    display: inline-block;
    font-size: 15px;
    color: #fff;
    padding: 10px 35px;
    border-radius: 20px;
    background: #ffa442;
    text-transform: uppercase;
    transition: all .3s ease 0s
}

.pricingTable .pricingTable-signup a:hover {
    box-shadow: 0 0 10px #ffa442
}

.pricingTable.blue .heading,
.pricingTable.blue .price-value {
    color: #4b64ff
}

.pricingTable.blue .pricingTable-signup a,
.pricingTable.blue:hover .pricingTable-header {
    background: #4b64ff
}

.pricingTable.blue .pricingTable-signup a:hover {
    box-shadow: 0 0 10px #4b64ff
}

.pricingTable.red .heading,
.pricingTable.red .price-value {
    color: #ff4b4b
}

.pricingTable.red .pricingTable-signup a,
.pricingTable.red:hover .pricingTable-header {
    background: #ff4b4b
}

.pricingTable.red .pricingTable-signup a:hover {
    box-shadow: 0 0 10px #ff4b4b
}

.pricingTable.green .heading,
.pricingTable.green .price-value {
    color: #40c952
}

.pricingTable.green .pricingTable-signup a,
.pricingTable.green:hover .pricingTable-header {
    background: #40c952
}

.pricingTable.green .pricingTable-signup a:hover {
    box-shadow: 0 0 10px #40c952
}

.pricingTable.blue:hover .price-value,
.pricingTable.green:hover .price-value,
.pricingTable.red:hover .price-value {
    color: #fff
}

.pricing-content p {
    font-size: 16px;
    line-height: 1.6;
    margin-bottom: 20px;
    padding: 10px;
    background-color: #f5f5f5;
    border: 1px solid #ddd;
}
.video-title {
    font-size: 25px;
    font-weight: bold;
    color: #333;
    margin: 2px 0;
}
.video-duration {
    font-size: 18px;
    color: #888;
    margin-top: 1px;
}
@media screen and (max-width:990px) {
    .pricingTable {
        margin: 0 0 20px
    }
}

</style>
<meta name="csrf-token" content="{{ csrf_token() }}">
    @section('content')
        <section class="transcript-main">
            <div class="transcript-1">
                <h3 class="transcript1-b">Video Series</h3>
            </div>
            <div class="video-main1">
                <div class="container">
                    <h4 class="videomain1-a">VIDEO SERIES OUTLINE</h4>
                    <h4 class="videomain1-b">The latest innovation in online legal education, this video series aims to educate the New York civil practitioner on both sides of the courtroom - as well as law students aspiring to become civil litigators -- on proven, effective methods of applying the Rules of the Civil Practice Law and Rules (CPLR) to avoid procedural pitfalls and common but potentially costly errors. The knowledge shared in these videos will ensure success in the preparation of pleadings, in pretrial discovery, motion practice, trial preparation, and at trial. The topics covered in the series include:</h4>
					<!--Subscriptoin Package Start-->
<div class="demo">
            <div class="container">
				<h4 class="videomain1-c">SUBSCRIPTION PACKAGE</h4><br>
                <div class="row">
                    @foreach ($package as $pck)
                        <div class="col-md-4 col-sm-4">
                            <div class="pricingTable">
                                <div class="pricingTable-header">
                                    <div class="price-value">${{ isset($pck->amount) ? $pck->amount : 0 }} </div>
                                    <h5 class="price-value" style="font-size: 13px;">{{ $pck->period }}</h5>
                                </div>
                                <h3 class="heading">{{ $pck->name }}</h3><br />
								@if(auth()->check())
								<div style="display: flex; justify-content: center; align-items: center;">
                                   	<a href="{{ route('pay.now', $pck->id) }}"
                                        style="display: flex; align-items: center; margin-right: 10px;margin-top: -15px;">
                                        <img src="{{ asset('assets/images/stripe.png') }}" alt="Stripe"
                                            style="width: 94px; height: auto;">
                                    </a>
									<form action="{{ route('paypal.payment') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="package_id" value="{{ $pck->id }}">
                                        <input type="hidden" name="amount" value="{{ $pck->amount }}">
                                        <button type="submit" style="border: none; background: none; padding: 0;">
                                            <img src="{{ asset('assets/images/paypal.png') }}" alt="PayPal"
                                                style="width: 100px; height: auto;">
                                        </button>
                                    </form>
								</div>
								@else
									<center><a href="{{ route('login') }}"
									   class="btn btn-warning">
										Login
									</a></center>
								@endif
                            </div>
                        </div>
                        @if ($loop->iteration % 4 == 0)
                </div>
                <div class="row">
                    @endif
                    @endforeach
                </div>
            </div>
        </div>
					<!--Subscription Pacakge End -->	
					<!--intrroduction video-->
<h4 class="videomain1-c">OTHER TOPICS ON DECK TO BE UPLOADED:</h4>
<!-- Featured Video Section -->
					
					<video id="videoPlayer" controls class="video-class" poster="https://newyorkcasewinningstrategies.com/storage/images/Thumb.IntroductionToSeries.Pt1.jpeg">
						<source id="videoSource" src="{{ asset('storage/videos/Vid.IntroductionToSeries.Pt1_1.mp4') }}" type="video/mp4">
					</video>

					<div style="margin-top: 10px; display: flex; justify-content: space-between; align-items: center;">
						<!-- Previous Icon -->
						<span onclick="previousVideo()" style="cursor: pointer; font-size: 32px; color: #555;">
							&#9664; <!-- Left arrow -->
						</span>

						<!-- Video Title -->
						<span id="videoTitle" style="font-size: 18px; font-weight: bold; color: #333;">
							Introduction 1
						</span>

						<!-- Next Icon -->
						<span onclick="nextVideo()" style="cursor: pointer; font-size: 32px; color: #555;">
							&#9654; <!-- Right arrow -->
						</span>
					</div>
					<!--youtube linker -->
					<div class="video-div">
                        @foreach($videos as $file)
							<div class="video-container">
								<div class="video-wrapper">
									@if(auth()->check() && auth()->user()->subscriptions->isNotEmpty() && auth()->user()->subscriptions->first()->stripe_status == 'active')
										<video id="videoPlayer{{ $file->id }}" controls class="video-class1" data-video-id="{{ $file->id }}" poster="{{ asset('storage/' . $file->thumbnail) }}" style="height: 234px; aspect-ratio: 4 / 2;">
											<source id="videoSource" src="{{ asset('storage/' . $file->path) }}" type="video/mp4">
										</video>
									@else
										<a href="{{ route('user.purchase.package.create') }}">
											<video controls class="video-class" poster="{{ asset('storage/' . $file->thumbnail) }}" style="height: 234px; aspect-ratio: 4 / 2;">
												<source src="{{ asset('storage/main-video.mp4') }}" type="video/mp4">
											</video>
										</a>
									@endif
								</div>

								<!-- Title Section -->
								<div class="video-details">
									<h5 class="video-title">{{ $file->title }}</h5>

									<!-- Duration Section (based on created_at, displaying in a friendly format like "X minutes ago") -->
									<p class="video-info" style="display: flex; justify-content: space-between; align-items: center; margin: 0;">
		<span>{{ \Carbon\Carbon::parse($file->created_at)->diffForHumans() }}</span>
		<span id="videoViews{{ $file->id }}">{{ $file->views }} views</span>
</p>
									
								</div>
							</div>
						@endforeach
                    </div>
					<!--End--->
                    <h4 class="videomain1-c">PERSONAL JURISDICTION AND SERVICE OF PROCESS</h4>
                    <h4 class="videomain1-d">SERVICE ON INDIVIDUALS (CPLR 308)</h4>

                    <ol class="videomain-ol">
                        <li>Personal Service in State (CPLR 308(1)) — “Personal Service” and “Personal Delivery” Differentiated
                        </li>
                        <li>Personal Service Out-of-State (CPLR 313) — Comparative Analysis of CPLR 308 in- state service and CPLR 313 out-of-state service</li>
                        <li>Substituted Service Defined — Deliver and Mail a/k/a Service Upon Person of Suitable Age/Discretion (CPLR 308(2))</li>
                        <li>Substituted Service — Defendant’s “Actual Place of Business” Defined (CPLR 308(2), 308(6))</li>
                        <li>Substituted Service — Defendant’s “Dwelling Place” Defined</li>
                        <li>Substituted Service — Defendant’s “Usual Place of Abode” Defined</li>
                        <li>Substituted Service — Person of “Suitable Age and Discretion” at Defendant’s Dwelling Place Defined</li>
                        <li>Substituted Service — Person of “Suitable Age and Discretion” at Defendant’s Usual Place of Abode Defined</li>
                        <li>Substituted Service — Person of “Suitable Age and Discretion” at Defendant’s Actual Place of Business Defined (CPLR 308(2), 308(6))</li>
                        <li>Substituted Service — CPLR 308(2) Mailing: Permitted to Either One of Two Places</li>
                        <li>Substituted Service — Mailing to “Last Known Residence” Defined (308(2)).</li>
                        <li>Mailing to “Actual Place of Business” Defined (CPLR 308(2), 308(6))</li>
                        <li>Substituted Service — “Nail and Mail” (“Affix-and-Mail”) Service Defined (CPLR 308(4))</li>
                        <li>Substituted Service -- Nail and Mail (Affix-and-Mail) Service — “Due Diligence”
Defined (CPLR 308(4))</li>
                        <li>Substituted Service -- “Nailing” a/k/a “Affixation” Permitted in Any One of Three
Places (CPLR 308(4))</li>
                        <li>Mailing Requirement Under CPLR 308(4) — Mailing Permitted to Any One of Two Places</li>
                        <li>Affixing Followed by Mailing to “Last Known Residence” Defined (CPLR 308(4))</li>
                        <li>Affixing Followed by Mailing to “Actual Place of Business” Defined (CPLR 308(4))</li>
                        <li>Mailing After Affixation Under CPLR 308(4) — Are Envelope Indicia Always Required?</li>
                        <li>Service Under CPLR 308(1) — When Does Defendant’s Time to Respond Expire?</li>
                        <li>Service Under CPLR 308(2) — When Does Defendant’s Time to Respond Expire?</li>
                        <li>Service Under CPLR 308(4) — When Does Defendant’s Time to Respond Expire?</li>
                        <li>Service on Designated Agent under Rule 318 (with divorce exception) -- Who Exactly is a Designated Agent?</li>
                        <li>Substituted Service - Publication with Leave of Court (CPLR 308(5))</li>
                        <li>Substituted Service “Catch-all” provision</li>
                        <li>Service in Divorce Cases — CPLR 318’s Divorce Exception</li>
                        <li>Service in Landlord Tenant Cases — Residential</li>
                        <li>Service in Landlord Tenant Cases -- Commercial</li>
                    </ol>
                    <h4 class="videomain1-d">SERVICE ON A NEW YORK CORPORATION (CPLR 311) </h4>
                    <h4 class="videomain1-d">SERVICE ON A NEW YORK PARTNERSHIP (CPLR 310) </h4>
                    <h4 class="videomain1-d mb-5">SERVICE OUTSIDE OF NEW YORK STATE (CPLR 313) </h4>
					<h4 class="videomain1-c">PLEADINGS</h4>
                    <h4 class="videomain1-d">REQUIRED CONTENTS OF PLEADINGS (CPLR 3013-3015)</h4>
                    <ol class="videomain-ol">
                        <li>Required Contents of the Summons</li>
                        <li>Required Contents of the Complaint</li>
                        <li>Summons with Notice and Endorsed Summons Differentiated</li>
                        <li>Numbering and Stating of Allegations and Causes of Action (CPLR 3014)</li>
                        <li>Requirement of Particularity of Pleadings in Certain Actions (CPLR 3015, 3016)</li>
                        <li>No requirement to Plead Subject Matter Jurisdiction or Personal Jurisdiction</li>
                        <li>Pleading Requirements in Actions against Municipalities (G.M.L. Section 50-e)</li>
                        <li>Demand for Relief: The “Wherefore” clause</li>
                    </ol>

                    <h4 class="videomain1-d">THE ANSWER (CPLR 318(a))</h4>
                    <ol class="videomain-ol">
                        <li>Deadline for service of the Answer (CPLR Section 3012(a), (c) and CPLR Rule 320(a))</li>
                        <li>Numbering and Stating of Allegations and Causes of Action (CPLR 3014)</li>
                        <li>“Marked Pleadings” Explained</li>
                    </ol>

                    <h4 class="videomain1-d mb-5">COUNTERCLAIMS (CPLR 3019(a))</h4>
                    <!--<ol class="videomain-ol">
                        <li>To be uploaded.</li>
                    </ol>-->
                    
                      <h4 class="videomain1-c">OTHER TOPICS THAT WILL BE COVERED IN THE SERIES INCLUDE:</h4>
                <div class="flipbox-main">
                        <div>
                            <div class="flip-box">
                                <div class="flip-box-inner">
                                    <div class="flip-box-front">
                                        <h2>THE STATUTES OF LIMITATIONS</h2>
                                    </div>
                                    <div class="flip-box-back">
                                        <h2>THE STATUTES OF LIMITATIONS</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="flip-box">
                                <div class="flip-box-inner">
                                    <div class="flip-box-front">
                                        <h2>VENUE</h2>
                                    </div>
                                    <div class="flip-box-back">
                                        <h2>VENUE</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="flip-box">
                                <div class="flip-box-inner">
                                    <div class="flip-box-front">
                                        <h2>PRETRIAL DISCOVERY</h2>
                                    </div>
                                    <div class="flip-box-back">
                                        <h2>PRETRIAL DISCOVERY</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="flip-box">
                                <div class="flip-box-inner">
                                    <div class="flip-box-front">
                                        <h2>MOTION PRACTICE</h2>
                                    </div>
                                    <div class="flip-box-back">
                                        <h2>MOTION PRACTICE</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
						<div>
                            <div class="flip-box">
                                <div class="flip-box-inner">
                                    <div class="flip-box-front">
                                        <h2>...and much more!</h2>
                                    </div>
                                    <div class="flip-box-back">
                                        <h2>...and much more!</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>

                <h4 class="videomain1-warning">WARNING: </h4>
                <h4 class="videomain1-warning-p">All literary work on this website belongs to and is the sole property of New York Case-Winning Strategies LLC. Reproduction, copying or any other form of use of videos, or any portion thereof, on this website, including text and images, is strictly prohibited without the express permission of New York Case- Winning Strategies LLC. If plagiarism is detected or discovered, all offenders will be prosecuted to the full extent of the law.
                </h4>
                </div>
            </div>
        </section>
    
<script>
// Sequential video list
const videos = [
    { 
        src: "{{ asset('storage/videos/Vid.IntroductionToSeries.Pt1_1.mp4') }}", 
        title: "Introduction 1", 
        poster: "https://newyorkcasewinningstrategies.com/storage/images/Thumb.IntroductionToSeries.Pt1.jpeg", 
        id: 1 // Unique video ID
    },
    { 
        src: "{{ asset('storage/videos/Vid.IntroductionToSeries.Pt2_1.mp4') }}", 
        title: "Introduction 2", 
        poster: "https://newyorkcasewinningstrategies.com/storage/images/Thumb.IntroductionToSeries.Pt2.jpeg", 
        id: 2 // Unique video ID
    }
];

let currentVideoIndex = 0; // Start with the first video

// Elements
const videoPlayer = document.getElementById('videoPlayer');
const videoTitle = document.getElementById('videoTitle');
const videoSource = document.getElementById('videoSource');

// Function to update the video player
function updateVideo(index) {
    const video = videos[index];
    videoSource.src = video.src;
    videoPlayer.poster = video.poster;
    videoTitle.textContent = video.title;
    videoPlayer.load(); // Reload the video player with the updated source

    // Update the views element if needed
    const viewsElement = document.getElementById(`videoViews${video.id}`);
    if (viewsElement) {
        viewsElement.innerText = `${video.views || 0} views`; // Update views count
    }

    // Optionally send AJAX to fetch the latest view count
    incrementView(video.id);
}

// Function to play the next video
function nextVideo() {
    if (currentVideoIndex < videos.length - 1) {
        currentVideoIndex++;
        updateVideo(currentVideoIndex);
    }
}

// Function to play the previous video
function previousVideo() {
    if (currentVideoIndex > 0) {
        currentVideoIndex--;
        updateVideo(currentVideoIndex);
    }
}



// Auto-play next video when the current video ends
videoPlayer.addEventListener('ended', function () {
    if (currentVideoIndex < videos.length - 1) {
        nextVideo();
    }
});

	function formatViews(num) {
		if (num >= 1_000_000_000) {
			return (num / 1_000_000_000).toFixed(1) + 'B'; // Billions
		} else if (num >= 1_000_000) {
			return (num / 1_000_000).toFixed(1) + 'M'; // Millions
		} else if (num >= 1_000) {
			return (num / 1000).toFixed(1) + 'K'; // Thousands
		}
		return num.toString(); // Less than 1K
	}

  // Function to send AJAX request to increment the view count
    function incrementView(videoId) {
        fetch(`/videos/${videoId}/increment-view`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({}) // Optional: Pass an empty object if necessary
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update the views count on success
               // Find the element and update it with formatted views
 				const formattedViews = formatViews(data.views);
				const viewsElement = document.getElementById(`videoViews${videoId}`);
				if (viewsElement) {
					viewsElement.innerText = `${formattedViews} views`;
				}
            } else {
                console.error('Error updating views:', data.message);
            }
        })
        .catch(error => {
            console.error('Error incrementing video view:', error);
        });
    }

    // Event listener for video play
    document.querySelectorAll('.video-class1').forEach(video => {
        video.addEventListener('play', function() {
            const videoId = video.getAttribute('data-video-id');
            incrementView(videoId);
        });
    });

</script>

@endsection
