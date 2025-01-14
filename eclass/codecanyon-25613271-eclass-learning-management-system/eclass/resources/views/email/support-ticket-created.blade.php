<!DOCTYPE html>
<html>
<head>
    <title>Welcome to YourApp</title>
</head>
<body>
    <p>A new support ticket has been created with the following details:</p>

<ul>
    <li>Ticket ID: {{ $ticket->ticket_id }}</li>
    <li>Category: {{ $ticket->SupportType->name }}</li>
    <li>Priority: {{ $ticket->priority }}</li>
    <li>Subject: {{ $ticket->subject }}</li>
    <li>Message: {{ $ticket->message }}</li>
</ul>
</body>
</html>