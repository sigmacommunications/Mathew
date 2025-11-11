<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Confirmation</title>
</head>

<body>
    <h1>Thank you for reaching out!</h1>
    <p>Dear {{ $contact['name'] }},</p>
    <p>We have received your message:</p>
    <blockquote>
        {{ $contact['comment'] }}
    </blockquote>
    <p>We will get back to you shortly.</p>
    <p>Best regards,<br>Your Company Team</p>
</body>

</html>
