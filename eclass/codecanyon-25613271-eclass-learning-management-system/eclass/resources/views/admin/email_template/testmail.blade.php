<!DOCTYPE html>
<html>
<head>
    <title>Test Email</title>
</head>
<body>
    {{ config('app.url') }}
    <br>
    This is a Test Email.
    Thanks,<br>
    {{ config('app.name') }}
</body>
</html>