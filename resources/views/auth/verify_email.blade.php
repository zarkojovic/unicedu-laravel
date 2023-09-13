<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Verify Account</title>
</head>
<body>
    <h1>Email Verification</h1>
    <h2>Hello, {{ $userName }}! Here you can verify your email:</h2>
    <a href="{{ $verificationLink }}" target="_blank">{{ $verificationLink }}</a>
</body>
</html>
