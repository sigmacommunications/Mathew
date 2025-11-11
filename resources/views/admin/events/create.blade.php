@extends('admin.layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold float-left">Create New Event Message</h6>
                                <a class="btn btn-primary btn-sm float-right" href="{{ route('events.index') }}">
                                    <i class="fa fa-arrow-left"></i> Back
                                </a>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('events.store') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="name">Event Name</label>
                                        <input type="text" name="name" class="form-control" placeholder="Event Name"
                                            required>
                                    </div>

                                    <div class="form-group">
                                        <label for="description">Event Description</label>
                                        <textarea name="description" class="form-control" placeholder="Enter Description"></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="event_date">Event Date & Time</label>
                                        <input type="datetime-local" name="event_date" class="form-control" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="reminder_time">Reminder Time (minutes before event)</label>
                                        <input type="number" name="reminder_time" class="form-control"
                                            placeholder="Reminder Minutes Before Start Event" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="event_price">Subscription Price</label>
                                        <input type="number" name="event_price" class="form-control"
                                            placeholder="Event Subscription Price" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="meeting_link">Meeting Link</label>
                                        <input type="text" name="meeting_link" class="form-control"
                                            placeholder="Meeting Code">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Create Event</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.11.3/main.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                events: '/api/events', // Fetch events from Laravel API
            });
            calendar.render();
        });
    </script>
@endpush
