<?php include('server.php'); ?>		
<!DOCTYPE html>
<html>
<head>
	<title>Login Form</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<div class = 'header'>
		<h2>Login</h2>
	</div>

	<form method="post" action="login.php">
		<?php include('errors.php'); ?>
		<div class="input-group">
			<label>Email</label>
			<input type = 'text' name="email">
		</div>
		<div class="input-group">
			<label>Password</label>
			<input type = 'password' name="password">
		</div>
		<span class="psw"><a href="#">Forgot password?</a></span>
		<div class="input-group">
			<button type="submit" name="login" class="btn">Login</button>
		</div>
		<p>
			Not yet a member? <a href="register.php">Sign Up</a>
		</p>
	</form>
</body>
</html>