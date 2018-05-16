<html>
<body>
<h3>Welcome to HOLR</h3>
<p>Hi, {{ $user->name }}<br /><br />You have successfully set up your account</p>
<br />
Please log in using the following credentials:<br />
http://holr.help/login<br />
email: {{ $user->email }}<br />
password: {{ $password }}
</body>
</html>
