
<?php

session_start();

require_once './php/db_connect.php';

if (isset($_POST['login'])){

    // Strip all tags to prevent injection
    $username = strip_tags($_POST['username']);
    $password = strip_tags($_POST['password']);

    $username = htmlentities($username);
    $password = htmlentities($password);
    // Strip all slashes to prevent injection
    $username = stripslashes($username);
    $password = stripslashes($password);

    $username = mysqli_real_escape_string($db,$username);
    $password = mysqli_real_escape_string($db,$password);

    $sql = "SELECT * FROM users WHERE username = '$username' LIMIT 1";
    $query = mysqli_query($db, $sql);

    // Shows query errors
    if (!$query) {
        printf("Error: %s\n", mysqli_error($db));
        exit();
    }

    $row = mysqli_fetch_array($query);
    $id = $row['id'];
    // Retrieving stored password
    $hashed_password = $row['password'];

    if(password_verify($password, $hashed_password)) {
        $_SESSION['username'] = $username;
        $_SESSION['id'] = $id;
        header('Location: wall.php');
            // If the password inputs matched the hashed password in the database
            // Do something, you know... log them in.
        } else {
            echo "<h1><center>Wrong log in information! Try again!</center></h1>";
        }

}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title>Login</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="./css/formstyle.css"/>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="./js/formscript.js"></script>

    <!-- All the files that are required -->
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link href='http://fonts.googleapis.com/css?family=Varela+Round' rel='stylesheet' type='text/css'>

    </head>
<body>
<div class="container">
    <!-- LOGIN FORM -->
    <div class="text-center" style="padding:50px 0">
    	<div class="logo">login</div>
    	<!-- Main Form -->
    	<div class="login-form-1">
            <form method="post" action="login.php" id="register-form" class="text-left">
    			<div class="login-form-main-message"></div>
    			<div class="main-login-form">
    				<div class="login-group">
    					<div class="form-group">
    						<label for="lg_username" class="sr-only">Username</label>
    						<input type="text" class="form-control" name="username" placeholder="username">
    					</div>
    					<div class="form-group">
    						<label for="lg_password" class="sr-only">Password</label>
    						<input type="password" class="form-control" name="password" placeholder="password">
    					</div>
    				</div>
    				<button type="submit" name="login" class="login-button"><i class="fa fa-chevron-right"></i></button>
    			</div>
    			<div class="etc-login-form">
    				<p>new user? <a href="signup.php">create new account</a></p>
    			</div>
    		</form>
    	</div>
    	<!-- end:Main Form -->
    </div>
</div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.13.1/jquery.validate.min.js"></script>
  </body>
</html>
