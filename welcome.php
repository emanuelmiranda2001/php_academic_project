<!DOCTYPE HTML>
<html>
  <head>
    <title>Users</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">



	<link rel="stylesheet" href="cart.css">
	
	<style>
		.upload-form {
			width: 400px;
			margin: 50px auto;
			font-size: 15px;
		}
		.upload-form form {
			margin-bottom: 15px;
			background: #f7f7f7;
			box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
			padding: 30px;
		}
		.upload-form h2 {
			margin: 0 0 15px;
		}
		.form-control{
			min-height: 38px;
			border-radius: 2px;
		}
		
	</style>
	

	</head>
	<body >

	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

  <?php
		//include the header div, where authentication is checked and the navigation menu is placed.
  		require_once('cookies/header.php');
  ?>
  
 
  
  <?php	

	
  		require_once('cookies/configDb.php');
			
		//connected to the database
		$db = connectDB();
				
		//success?				
		if ( is_string($db) ){
			//error connecting to the database
			echo ("Fatal error! Please return later.");
			die();
		}
		
		//select all columns from all users in the table
		
		
		$query = "SELECT id_users,username,email,gender,user_type FROM users ";
  		
  		//prepare the statement				
		$statement = mysqli_prepare($db, $query);
				
		if (!$statement ){
			//error preparing the statement. This should be regarded as a fatal error.
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
  		
		echo '<div class="upload-form">';
		
		//there a users list available.
		
		while( $row = mysqli_fetch_assoc($result) ){
			//each row has a user
			echo  
			'<form action="modificarUtilizador.php" method="POST" name="formModifica"> <h4> Name:  '
				. $row['username'] . "  <br> E-mail:  " . $row['email'] . "  <br> Gender:  " . $row['gender'] . "  <br> User Type:  " . $row['user_type'] . " </h4>  <br> ".
				'<a class="btn btn-danger " href="apagarUtilizador.php?id=' . $row['id_users'] . '">Apagar</a>
				<input type="hidden" value="' . $row['id_users'] . '" name="id">
				<input class="btn btn-primary " type="submit" name="modificar" value="Modificar">
			</form>' . 
			'<br>' ; 			
		}

		echo '</div>';
  ?>
  
  </body>
</html>