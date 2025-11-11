<h2>Hi {{ $registration->name }},</h2>

<p>Thank you for registering for the event: <strong>{{ $event->name }}</strong>.</p>

<p>We look forward to seeing you!</p>

<p>Event Details:</p>
<ul>
    <li><strong>Date:</strong> {{ $event->event_date }}</li>
    <li><strong>Link:</strong> {{ $event->meeting_link }}</li>
</ul>

<p>If you have any questions, feel free to contact us.</p>

<p>Thanks,<br>The Events Team</p>
