<?php 
	
	session_start();
	$username = '';
	$email = "";
	$mobile_number = "";
	$errors = array(); 


	//connect the database
	$db = mysqli_connect("localhost" , "root", '', 'registration'); 

	// if the registration button is clicked
	if(isset($_POST['register'])){
		$username = mysqli_real_escape_string($db, $_POST['username']);
		$email = mysqli_real_escape_string($db, $_POST['email']);
		$mobile_number = mysqli_real_escape_string($db, $_POST['mobile_number']);
		$password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
		$password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

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
		if($password_1 != $password_2){
			array_push($errors,"The two passwords do not match");
		}


		// first check the database to make sure 
  		// a user does not already exist with the same username and/or email

  		$user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";
  		$result = mysqli_query($db, $user_check_query);
  		$user = mysqli_fetch_assoc($result);
  
  		if ($user) { // if user exists
    		if ($user['username'] === $username) {
      		array_push($errors, "Username already exists");
    		}

    		if ($user['email'] === $email) {
      		array_push($errors, "email already exists");
    		}
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
		$username = mysqli_real_escape_string($db, $_POST['username']);
		$password = mysqli_real_escape_string($db, $_POST['password']);

		if(empty($username)){
			array_push($errors,"User name is required");
		}
		if(empty($password)){
			array_push($errors,"Password is required");
		}

		if(count($errors) == 0){
			$password = md5($password);
			$query = "SELECT * FROM users WHERE username='$username' AND password = '$password'";
			$result = mysqli_query($db, $query);
			if (mysqli_num_rows($result) == 1) {
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
