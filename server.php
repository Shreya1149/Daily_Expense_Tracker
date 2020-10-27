<?php 
	
	session_start();
	$username = '';
	$email = "";
	$mobile_number = "";
	$errors = array(); 


	//connect the database
	define("DB_SERVER", "localhost");
	define("DB_USER", "root");
	define("DB_PASSWORD", "QIOqDZ4w6CzYRQlE");
	define("DB_DATABASE", "registration");

	$db = mysqli_connect(DB_SERVER , DB_USER, DB_PASSWORD, DB_DATABASE); 
	// $db = mysqli_connect('127.0.0.1', 'root', '', 'registration');

	// if the registration button is clicked
	if(isset($_POST['registration'])){
		$username = mysql_real_escape_string($_POST['username']);
		$email = mysql_real_escape_string($_POST['email']);
		$mobile_number = mysql_real_escape_string($_POST['mobilenumber']);
		$password_1 = mysql_real_escape_string($_POST['password_1']);
		$password_2 = mysql_real_escape_string($_POST['password_2']);

		// ensure that form fields are filled properly
		if(empty($username)){
			array_push($errors,"Username is required");
		}
		if(empty($email)){
			array_push($errors,"Email is required");
		}
		if(empty($mobile_number)){
			array_push($errors,"Mobile Number is required");
		}
		if(empty($password_1)){
			array_push($errors,"Password_1 is required");
		}
		if(empty($password_2 != $password_1)){
			array_push($errors,"The two passwords do not match");
		}

		//if there are no errors save user to database
		if(count($errors) == 0){
			$password = md5($password_1);
			$sql = "INSERT INTO users(username, email, password) VALUES ('$username', '$email', '$password')";
			mysqli_query($db, $sql);
			$_SESSION['username'] = $username;
			$_SESSION['success'] = "You are now logged in";
			header('location: index.php');

		}
	}
	if (isset($_POST['login'])) {
		$email = mysql_real_escape_string($_POST['email']);
		$password = mysql_real_escape_string($_POST['password']);

		if(empty($email)){
			array_push($errors,"Email id is required");
		}
		if(empty($password)){
			array_push($errors,"Password is required");
		}

		if(count($errors) == 0){
			$password = md5($password_1);
			$query = "SELECT * FROM users WHERE username='$username' AND password = '$password";
			$result = mysqli_query($db, $query);
			if (mysql_num_rows($result) == 1) {
				$_SESSION['username'] = $username;
				$_SESSION['success'] = "You are now logged in";
				header('location: index.php');
			}
			else{
				array_push($errors,"wrong username/password combination");
			}
		}
	}
	if (isset($_GET['logout'])) {
		session_destroy();
		unset($_SESSION['username']);
		header('location: login.php');
	}
 ?>