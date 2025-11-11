@extends('layouts.master')

@section('title', 'About Us')

@section('content')

    <section class="inner-pg-sec1">
        <div class="card mt-5 mx-auto" style="max-width: 600px; background-color:white; color:black;">
            <div class="card-body">
                <div id='calendar'></div>
            </div>
        </div>

        <!-- Login Modal -->
        <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form id="loginForm">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Login Required</h5>
                        </div>
                        <div class="modal-body">
                            <input type="email" name="email" class="form-control mb-2" placeholder="Email" required>
                            <input type="password" name="password" class="form-control mb-2" placeholder="Password"
                                required>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Login</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!--Event Modal -->
        <div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="eventModalLabel">Event Detials</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="eventId" name="event_id">
                        <p><strong>Title:</strong> <span id="modalEventTitle"></span></p>
                        <p><strong>Description:</strong> <span id="modalEventDescription"></span></p>
                        <p><strong>Date:</strong> <span id="modalEventDate"></span></p>
                        <button class="btn btn-primary" id="openApplyModal">Apply</button>
                    </div>
                </div>
            </div>
        </div>

        <form id="eventForm" method="POST" action="{{ route('event.registration') }}">
            @csrf
            <!-- Second Modal for the Application Form -->
            <div class="modal fade" id="applyModal" tabindex="-1" aria-labelledby="applyModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Join Event Form</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" id="applyEventId" name="event_id">
                            <div class="mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" class="form-control" name="name" placeholder="Enter Name" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" placeholder="Enter email"
                                    id="email" value="{{ Auth::check() ? Auth::user()->email : '' }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" name="description" rows="3" placeholder="Enter Description"></textarea>
                            </div>
                            <button type="button" class="btn btn-success" id="goToCardModal">Next</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Card Modal -->
            <div class="modal fade" id="cardModal" tabindex="-1" aria-labelledby="cardModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Enter Card Details</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="cardForm">
                                <div class="mb-3">
                                    <label class="form-label">Card Information</label>
                                    <div id="card-element" class="form-control"></div> <!-- Stripe injects here -->
                                </div>
                                <div id="card-errors" class="text-danger mt-2" role="alert"></div>
                                <button type="button" id="submitEventForm" class="btn btn-primary mt-3">$5 / Pay
                                    Now
                                    <span id="submitSpinner" class="spinner-border spinner-border-sm d-none"
                                        role="status" aria-hidden="true"></span>
                                </button>
                                <span id="processingText" class="text-muted ml-2 d-none">Processing...</span>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>

    <script>
        const calendarEvents = {!! $eventsJson !!}; // Laravel -> JS

        $(document).ready(function() {
            $('#calendar').fullCalendar({
                editable: false, // Disable editing of events
                events: calendarEvents, // Backend se fetched events ko display karo
                displayEventTime: false, // Event time ko display mat karo
                eventRender: function(event, element) {
                    if (event.title && event.description) {
                        element.prop('title', event.title + ': ' + event
                            .description); // ✅ prop instead of attr
                    } else if (event.title) {
                        element.prop('title', event.title);
                    }

                    if (event.color) {
                        element.css('background-color', event.color);
                    }
                    if (event.textColor) {
                        element.css('color', event.textColor);
                    }
                },
                selectable: false, // Disable selecting a date to create events
                selectHelper: false, // Disable helper for creating events by selecting a range
                eventClick: function(event) {
                    const now = moment(); // Local current time
                    const eventStart = moment.utc(event.start).local(); // Convert to local time

                    if (!isLoggedIn) {
                        $('#loginModal').modal('show');
                        return;
                    }

                    if (now.isSameOrAfter(eventStart)) {
                        toastr.warning('This event has already passed.');
                        return;
                    }

                    // Populate modal with event details
                    $('#applyEventId').val(event.id);
                    $('#modalEventTitle').text(event.title || 'N/A');
                    $('#modalEventDescription').text(event.description || 'No description');
                    $('#modalEventDate').text(eventStart.format('MMMM Do YYYY, h:mm A'));

                    // Show modal
                    $('#eventModal').modal('show');
                }
            });
        });

        $(document).on('click', '#openApplyModal', function() {
            $('#eventModal').modal('hide');
            setTimeout(function() {
                $('#applyModal').modal('show');
            }, 300);
        });

        $(document).on('click', '#goToCardModal', function() {
            $('#applyModal').modal('hide');
            setTimeout(() => {
                $('#cardModal').modal('show');
            }, 300);
        });
    </script>

    <script>
        const isLoggedIn = {{ $isLoggedIn ? 'true' : 'false' }};
    </script>

    <script src="https://js.stripe.com/v3/"></script>
    <script>
        const stripe = Stripe("{{ env('STRIPE_KEY') }}");
        const elements = stripe.elements();
        const card = elements.create('card');
        card.mount('#card-element');

        // Handle form submit
        $('#submitEventForm').on('click', function() {

            $('#submitSpinner').removeClass('d-none');
            $('#processingText').removeClass('d-none');
            $(this).prop('disabled', true);

            stripe.createToken(card).then(function(result) {
                if (result.error) {
                    $('#card-errors').text(result.error.message);
                } else {
                    const formData = {
                        _token: '{{ csrf_token() }}',
                        event_id: $('#applyEventId').val(),
                        name: $('input[name="name"]').val(),
                        email: $('#email').val(),
                        description: $('textarea[name="description"]').val(),
                        stripe_token_id: result.token.id
                    };

                    $.ajax({
                        url: '{{ route('event.registration') }}',
                        method: 'POST',
                        data: formData,
                        success: function(response) {
                            toastr.success('Event registered successfully!');
                            $('#cardModal').modal('hide');
                        },
                        error: function(xhr) {
                            toastr.error('Failed to register. Check console.');
                            console.error(xhr.responseText);
                        }
                    });
                }
            });
        });

        function resetSubmitButton() {
            $('#submitSpinner').addClass('d-none');
            $('#processingText').addClass('d-none');
            $('#submitEventForm').prop('disabled', false);
        }
    </script>

    <script>
        $('#loginForm').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                url: '{{ route('login') }}',
                method: 'POST',
                data: $(this).serialize(),
                success: function() {
                    toastr.success('Login successful! Reloading...');
                    location.reload(); // Reload to update auth state
                },
                error: function(xhr) {
                    toastr.error('Invalid credentials');
                }
            });
        });
    </script>
@endsection
