<!DOCTYPE html>
<html>
<head>
 <title>Forgot Password Mail</title>
</head>
<body>
 
<h1>{{ $mailData['title'] }}</h1>
<p>{{ $mailData['body1'] }}</p>
<p>{{ $mailData['body2'] }}</p>
<p>{{!! $mailData['body3'] !!}}</p>
 
</body>
</html> 