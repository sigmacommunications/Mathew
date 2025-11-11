@extends('user.layouts.app')

@section('content')
    <section class="page-section page-section--search-results">
        <div class="container">
            <div class="row">
                @foreach($videos as $file)
                    <div class="col-md-4">
                        <div class="card mb-4 box-shadow">
                            <div class="embed-responsive embed-responsive-16by9">
                                <video class="embed-responsive-item watch-now-btn" controls data-toggle="modal" data-target="#videoModal" data-src="{{ asset('storage/' . $file->path) }}">
                                    <source src="{{ asset('storage/' . $file->path) }}" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Include jQuery before your script -->
    <!-- Include Plyr -->
    <script src="https://cdn.plyr.io/3.6.4/plyr.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize Plyr for the main video
            const modalPlayer = new Plyr('#modalVideo', {
                controls: ['play', 'progress', 'current-time', 'fullscreen'],
            });

            // Initialize Plyr for the video cards
            const cardPlayers = Plyr.setup('.watch-now-btn', {
                controls: ['play', 'progress', 'current-time', 'fullscreen'],
            });

            // Handle click event on video card
            $('.watch-now-btn').click(function() {
                const videoSrc = $(this).data('src');
                
                // Set the source and reload the modal player
                $('#modalVideo source').attr('src', videoSrc);
                modalPlayer.source = { type: 'video', sources: [{ src: videoSrc, type: 'video/mp4' }] };
                modalPlayer.reload();

                // Show the modal
                $('#videoModal').modal('show');
            });

            // Pause the main video player when modal is closed
            $('#videoModal').on('hidden.bs.modal', function (e) {
                modalPlayer.pause();
            });
        });
    </script>
@endsection
