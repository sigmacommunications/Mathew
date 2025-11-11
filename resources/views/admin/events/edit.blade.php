@extends('admin.layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold float-left">Edit Event</h6>
                                <a class="btn btn-primary btn-sm float-right" href="{{ route('events.index') }}">
                                    <i class="fa fa-arrow-left"></i> Back
                                </a>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('events.update', $event->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="form-group">
                                        <label for="name">Event Name</label>
                                        <input type="text" name="name" class="form-control"
                                            value="{{ old('name', $event->name) }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="description">Event Description</label>
                                        <textarea name="description" class="form-control">{{ old('description', $event->description) }}</textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="event_date">Event Date & Time</label>
                                        <input type="datetime-local" name="event_date" class="form-control"
                                            value="{{ old('event_date', $event->event_date) }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="reminder_time">Reminder Time (minutes before event)</label>
                                        <input type="number" name="reminder_time" class="form-control"
                                            value="{{ old('reminder_time', $event->reminder_time) }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="event_price">Subscription Price</label>
                                        <input type="number" name="event_price" class="form-control"
                                            value="{{ old('reminder_time', $event->event_price) }}"required>
                                    </div>

                                    <div class="form-group">
                                        <label for="meeting_link">Meeting Link</label>
                                        <input type="text" name="meeting_link" class="form-control"
                                            value="{{ old('meeting_link', $event->meeting_link) }}"
                                            placeholder="Meeting Code">
                                    </div>

                                    <button type="submit" class="btn btn-primary">Update Event</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
