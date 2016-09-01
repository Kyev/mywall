
<?php

require_once './php/db_connect.php';
session_start();

if (isset($_POST['submit'])){

    $ifavailable = mysqli_query($db,"SELECT * FROM users WHERE username ='$_POST[username]'");

    if($ifavailable->num_rows > 0) {
        echo "<h1><center>Username" . ' ' . $_POST['username'] . ' ' . "not available. Please choose another one.</center></h1>";
    } else {
        $required = array('username', 'password');

        $error = false;

        foreach($required as $field) {
            if (empty($_POST[$field])){
                $error = true;
            }
        }

        if ($error){
            echo "<h1><center>Create a username and password.</center></h1>";
        } else {
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

            $hash = password_hash($password, PASSWORD_BCRYPT);

            $insert = mysqli_query($db, "INSERT INTO users (username, password)
            VALUES ('$_POST[username]', '$hash')");

            if ($insert) {
                $sql = "SELECT * FROM users WHERE username = '$username' LIMIT 1";
                $query = mysqli_query($db, $sql);
                $row = mysqli_fetch_array($query);
                $id = $row['id'];
                $_SESSION['username'] = $username;
                $_SESSION['id'] = $id;
                header('Location: wall.php');
            } else {
                echo "<h1><center>Something went wrong! Try again!</center></h1>";
            }
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title>Registration</title>
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
    <!-- REGISTRATION FORM -->
    <div class="text-center" style="padding:50px 0">
    	<div class="logo">register</div>
    	<!-- Main Form -->
    	<div class="login-form-1">
    		<form method="post" action="signup.php" id="register-form" class="text-left">
    			<div class="login-form-main-message"></div>
    			<div class="main-login-form">
    				<div class="login-group">
    					<div class="form-group">
    						<label for="reg_username" class="sr-only">Usernam</label>
    						<input type="text" name="username" class="form-control" placeholder="username">
    					</div>
    					<div class="form-group">
    						<label for="reg_password_confirm" class="sr-only">Password Confirm</label>
    						<input type="password" name="password" class="form-control" placeholder="password">
    					</div>
    				</div>
    				<button type="submit" name="submit" class="login-button"><i class="fa fa-chevron-right"></i></button>
    			</div>
    			<div class="etc-login-form">
    				<p>already have an account? <a href="login.php">login here</a></p>
    			</div>
    		</form>
    	</div>
    	<!-- end:Main Form -->
    </div>
</div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.13.1/jquery.validate.min.js"></script>
  </body>
</html>
