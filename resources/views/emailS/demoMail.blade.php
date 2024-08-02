<!DOCTYPE html>
<html>
<head>
    <title>Web-tuts.com</title>
</head>
<body>
    <h1><strong>{{ $mailData['title'] }}</strong></h1>
    <p>Hola {{ $mailData['body'] }}</p>
  
    <p>La nueva contrase para acceder al sitio es: {{ $mailData['pass'] }}</p>
     
    <p>Thank you</p>
</body>
</html>