<html>
<head>
    <title>New Notice</title>
</head>
<body>
    <h1>{{ $notice->title }}</h1>
    <p><strong>Course:</strong> {{ $courseName }}</p>
    <p>{!! $notice->content !!}</p>
</body>
</html>