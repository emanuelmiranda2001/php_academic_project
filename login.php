<!DOCTYPE HTML>
<html>
  <head>
    <title>Login</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	
	
    <link rel="stylesheet" href="css/login.css">
	
	<!-- Bootstrap core CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
	

  
  
  <body class="back , text-center"> 
    	  
  <?php

  		
  		if ( !empty($_POST)){
  			
  			//include validation tools
  			require_once('cookies/valida.php');
  		
  			//call general form validation function
  			$errors = validaFormLogin($_POST);
  		
  			//check validation result and act upon it
  			if ( !is_array( $errors) && !is_string( $errors) ){
				
				require_once('cookies/configDb.php');
				
				//connected to the database
				$db = connectDB();
				
				//success?				
				if ( is_string($db) ){
					//error connecting to the database
					echo ("Fatal error! Please return later.");
					die();
				}
				
				//building query string
				$username = trim($_POST['username']);		
				$password = md5(trim($_POST['password']));

				//construct the intend query
				$query = "SELECT * FROM users WHERE username=? AND password=?";
				
				//prepare the statement				
				$statement = mysqli_prepare($db,$query);
				
				if (!$statement ){
					//error preparing the statement. This should be regarded as a fatal error.
					echo "Something went wrong. Please try again later.";
					die();				
				}				
								
				//now bind the parameters by order of appearance
				$result = mysqli_stmt_bind_param($statement,'ss',$username,$password); # 'ss' means that both parameters are expected to be strings.
								
				if ( !$result ){
					//error binding the parameters to the prepared statement. This is also a fatal error.
					echo "Something went wrong. Please try again later.";
					die();
				}
				
				//execute the prepared statement
				$result = mysqli_stmt_execute($statement);
							
				if( !$result ) {
					//again a fatal error when executing the prepared statement
					echo "Something went very wrong. Please try again later.";
					die();
				}
				
				//get the result set to further deal with it
				$result = mysqli_stmt_get_result($statement);
				
				
				if (!$result){
					//again a fatal error: if the result cannot be stored there is no going forward
					echo "Something went wrong. Please try again later.";	
					die();
				}	
				
				elseif( mysqli_num_rows($result) == 1){
					//there is one user only with these credentials
										
					//open session
					session_start();
					
					//get user data
					$user = mysqli_fetch_assoc($result);
					
					//save username and id in session					
					$_SESSION['username'] = $user['username'];
					$_SESSION['id'] = $user['id_users'];
					$_SESSION['user_type'] = $user['user_type'];
				
					//user registered - close db connection
					$result = closeDb($db);
					//send the user to another page
					header('Location:cart.php');		
				}
				else{
					echo "Invalid Username/Password";
					$result = closeDb($db);
				}	
  			}
  			elseif( is_string($errors) ){
				  	//the function has received an invalid argument - this is a programmer error and must be corrected
				  	echo $errors;
				  	
				  	//so that there is no problem when displaying the form
				  	unset($errors);
  			}
  		}
  ?>	  
		
		
		<div class="login-form">
			<form action="" method="POST">
				<h2 class="text-center">Log in</h2>       
				<div class="form-group " >
					<input type="text" id="username"  name="username" class="form-control" <?php
					
						if ( !empty($errors) && !$errors['username'][0] ){ #this is done to keep the value inputted by the user if this field is valid but others are not
							echo 'value="'. $_POST['username'].'"';
						}
						else {
							echo 'placeholder="Username"';
						}			
						
					
					?>>
					<br>
					
					<?php
						if ( !empty($errors) && $errors['username'][0] ){ # Equal to "if ( !empty($errors) && $errors['username'][0] == true ){" #presents an error message if this field has invalid content
							echo $errors['username'][1] . "<br>";
						}  		
					?>
					
				</div>
				<div class="form-group">
					<input type="password" id="password" name="password" class="form-control" placeholder="Password" >
					<?php
						if ( !empty($errors) && $errors['password'][0] ){
							echo $errors['password'][1] . "<br>";
						}  		
					?>
				</div>
				<br>
				<div class="form-group">
					<button type="submit" value="Submit" class="btn btn-secondary btn-block">Log in</button>
				</div>
				
				<?php
				//include the header div, where authentication is checked and the navigation menu is placed.
				require_once('cookies/header.php');
				?>
				       
			</form>
			
					
			</div>
		
	
  </body>
</html>