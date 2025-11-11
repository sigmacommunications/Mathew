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
	.reel-class {
		width: 100%;
	}
		.reel-h4 {
		font-size: 20px;
		text-decoration: none;
		color: #000;
		margin-top: 15px;
		text-align: center;
		font-weight: 700;
	}

	.reel-p {
		font-size: 13px;
		color: #000;
		text-align: center;
	}

	.video-container a {
		text-decoration: none;
	}
	.video-div {
    margin-top: 50px !important;
	}

	.reel-div {
    display: grid
;
    grid-template-columns: auto auto auto auto;
    gap: 20px;
    margin-top: 50px;
    margin-bottom: 50px;
}

</style>
    @section('content')
        <section class="transcript-main">
            <div class="transcript-1">
                <h3 class="transcript1-b">Video Reels</h3>
            </div>

					<!--Start-->
			<div class="container">
					<div class="reel-div">
                        @foreach($reels as $key => $reel)
                        <div class="reel-container">
                                <video id="videoPlayer" controls class="reel-class" poster="{{ asset('storage/' . $reel->thumbnail) }}">
                                    <source id="videoSource" src="{{ asset('storage/' . $reel->path) }}" type="video/mp4">
                                </video>
                            <h4 class="reel-h4">{{ $reel->title }}</h4>
                            <p class="reel-p">{{ $reel->description }}</p>
                        </div>
                        @endforeach

			</div>
			</div>
</section>
					<!--End--->

<script>
    // Sequential video list
    const videos = [
        {
            src: "{{ asset('storage/videos/Vid.IntroductionToSeries.Pt1_1.mp4') }}",
            title: "Introduction 1",
            poster: "https://newyorkcasewinningstrategies.com/storage/images/Thumb.IntroductionToSeries.Pt1.jpeg"
        },
        {
            src: "{{ asset('storage/videos/Vid.IntroductionToSeries.Pt2_2.mp4') }}",
            title: "Introduction 2",
            poster: "https://newyorkcasewinningstrategies.com/storage/images/Thumb.IntroductionToSeries.Pt2.jpeg"
        }
    ];

    const videoPlayer = document.getElementById('videoPlayer');
    const videoSource = document.getElementById('videoSource');
    const videoTitle = document.getElementById('videoTitle');

    let currentVideoIndex = 0;

    // Update video source, poster, and title
    function updateVideo(index) {
        videoSource.src = videos[index].src;
        videoPlayer.poster = videos[index].poster; // Set the poster dynamically
        videoTitle.textContent = videos[index].title;
        videoPlayer.load();
        videoPlayer.play();
    }
    // Play next video
    function nextVideo() {
        if (currentVideoIndex < videos.length - 1) {
            currentVideoIndex++;
            updateVideo(currentVideoIndex);
        }
    }
    // Play previous video
    function previousVideo() {
        if (currentVideoIndex > 0) {
            currentVideoIndex--;
            updateVideo(currentVideoIndex);
        }
    }
	// Auto-play next video
    videoPlayer.addEventListener('ended', function () {
        if (currentVideoIndex < videos.length - 1) {
            nextVideo();
        }
    });
	// Function to play video in the main player
    function playVideo(videoUrl) {
        var videoPlayer = document.getElementById('mainVideoPlayer');
        var videoSource = document.getElementById('mainVideoSource');

        // Change the source of the video player to the selected video
        videoSource.src = videoUrl;

        // Load and play the new video
        videoPlayer.load();
        videoPlayer.play();
	}
</script>
@endsection
