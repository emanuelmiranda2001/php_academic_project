<?php

	session_start();

	//there are different actions for the login and register users scripts only
	$currentScript = basename($_SERVER['PHP_SELF'], '.php');

	//is this the login script?
	if ( $currentScript == "login" || $currentScript == "registerUsers"){

		//present the navbar with different options for either login or register
		if( $currentScript == 'login'){
			echo '<div class="p">
					<a class="active text-secondary" href="registerUsers.php">Register</a>
				</div>';
		}
		else{
			echo '<div class="p">
					<a class="active text-secondary" href="login.php">Login</a>
				</div>';
		}	
		
		//is the user authenticated?
		if ( !empty ($_SESSION) && array_key_exists("username", $_SESSION) ){
			
			//clear any existing status codes
			unset ($_SESSION['code']);			
					
			//it must be redirect to the welcome page			
			header('Location:cart.php');
			die();			
		}
		elseif(!empty($_SESSION) && array_key_exists("code", $_SESSION)){
			
			//it is not, but there is an error message to show
			require_once('errorCodes.php');
			echo getErrorMessage($_SESSION['code']) . "<br>";
			
			//clear any existing status codes
			unset ($_SESSION['code']); 	
		}
			
	}
	else{
		//it is any other script

		//is the user authenticated?	
		if( empty($_SESSION) || !array_key_exists("username", $_SESSION) ){
					
			//It is not! Set up the proper error message and send the user to the login page
			$_SESSION['code'] = 1;
			
			//login.php must be able to deal with errors to present the user with the appropriated error message
			header('Location:login.php');
			die();
		}
		else{
			
//----------------------------------------------------------------------------------------------
			
			//it is! Present the navigation bar	
			
			// NAVIGATION BAR
			
			echo '
				<nav class="navbar fixed-top navbar-expand-md navbar-light bg-light">
				<a class="navbar-brand" href="cart.php">Home</a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
				</button>		
				<div class="collapse navbar-collapse" id="navbarNavDropdown">
				<ul class="navbar-nav mr-auto">';
									  
				if($currentScript == "cart"){
					
				echo '
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					Categorias 
					</a>
				<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
					<a class="dropdown-item" href="#queijo">Queijo</a>
					<a class="dropdown-item" href="#enchidos">Enchidos</a>
					<a class="dropdown-item" href="#azeite">Azeite</a>
				</div>
				</li>';
				}
				
				if($currentScript != "shop"){
				echo '<li class="nav-item">';
				echo '<a class="nav-link" href="shop.php">Cart <span class="sr-only">(current)</span></a>';
				echo '</li>';
				}
				
				
				if($_SESSION['user_type'] == "admin"){
					if($currentScript != "upload"){
					echo '
						<li class="nav-item">
						<a class="nav-link" href="upload.php">Upload</a>
						</li>';
				}
				}
				
				if($currentScript != "contact"){
				echo '
				<li class="nav-item">
				<a class="nav-link" href="contact.php">Contact</a>
				</li>';
				}
				
				if($_SESSION['user_type'] == "admin"){
				if($currentScript != "welcome"){
				echo '<li class="nav-item">';
				echo '<a class="nav-link" href="welcome.php">Users</a>';
				echo '</li>';
				}
				}
				
				if($_SESSION['user_type'] == "user"){
				if($currentScript != "perfilUser"){
				echo '<li class="nav-item">';
				echo '<a class="nav-link" href="perfilUser.php">Perfil</a>';
				echo '</li>';
				}
				}
				
				if($currentScript != "index"){
				echo '
				<li class="nav-item">
				<a class="nav-link" href="index.php">Tickets</a>
				</li>';
				}
				
				if($currentScript == "cart"){
					echo '<form class="form-inline my-2 my-lg-0" method="POST" action="cart.php">';
					echo '<input class="form-control mr-sm-2" type="search" placeholder="Search" name="search" aria-label="Search">';
					echo '<button class="btn btn-secondary" type="submit">Search</button>';
					echo '</form>';
				}
				
				echo '
				</ul>';
				
				echo'
				
				<li class="btn btn-dark float-right">
					<a class="btn btn-dark" href="logout.php">Logout</a>
				</li>';
				
				echo'
				
			</div>
	</nav>';

//----------------------------------------------------------------------------------------------
			
			
		if( !empty($_SESSION) && array_key_exists("code", $_SESSION) ) {
				
			//if it is code 1 it must be cleared as the user is authenticated
			if ($_SESSION['code'] == 1){
				unset($_SESSION['code']);			
			}
			else{	 		
				//the user was sent here with an error code. Show the proper error message
				require_once('errorCodes.php');
				echo getErrorMessage($_SESSION['code']) . "<br>";

				//clear all error codes before proceeding	 			
				unset($_SESSION['code']);
				}
			}	 
		}
	}
	
//----------------------------------------------------------------------------------------------
	
	// ADMIN VERIFICATION
	
	if($currentScript == "upload"){
		if($_SESSION['user_type'] == "user"){
			header('Location:cart.php');
			die();
		}
	}

//----------------------------------------------------------------------------------------------

	// SHOPPING CART

	$product_ids = array();
	
	//check is Add to Cart has been submitted
	if(filter_input(INPUT_POST, 'add_to_cart')){
		if(isset($_SESSION['shopping_cart'])){
			//keep track of how many products are in the shopping cart
			$count = count($_SESSION['shopping_cart']);
			
			//create sequencial array for matching array keys to products id's
			$product_ids = array_column($_SESSION['shopping_cart'],'id');
			
			
			
			if(!in_array(filter_input(INPUT_GET , 'id'), $product_ids)){
				$_SESSION['shopping_cart'][$count] = array
			(
				'id' => filter_input(INPUT_GET, 'id'),
				'name' => filter_input(INPUT_POST, 'name'),
				'price' => filter_input(INPUT_POST, 'price'),
				'quantity' => filter_input(INPUT_POST, 'quantity')			
			);
			
			}
			else{//product already exists, increase quantity
				//match array key to id of the product being added to the cart
				for ($i = 0; $i < count($product_ids); $i++){
					if($product_ids[$i] == filter_input(INPUT_GET, 'id')){
						//add item quantity to the existing product inthe array
						$_SESSION['shopping_cart'][$i]['quantity'] += filter_input(INPUT_POST, 'quantity');
						
					
					}
				}
			}
			
		}
		else{//if shopping cart does't exist, create first product with array key 0
			//create array using submitted form data, start from key o and fill it with values
			$_SESSION['shopping_cart'][0] = array
			(
				'id' => filter_input(INPUT_GET, 'id'),
				'name' => filter_input(INPUT_POST, 'name'),
				'price' => filter_input(INPUT_POST, 'price'),
				'quantity' => filter_input(INPUT_POST, 'quantity')
				
			);
		}
	}

	if(filter_input(INPUT_GET, 'action') == 'delete'){
		//loop through all products in the shopping cart until it matches whith GET id variable
		foreach($_SESSION['shopping_cart'] as $key => $product){
			if ($product['id'] == filter_input(INPUT_GET , 'id')){
				//remove product from the shopping cart when it matches with the GET id
				unset($_SESSION['shopping_cart'][$key]);
			}
		}
		
		//reset session array keys so they match with $product_ids numeric array
		$_SESSION['shopping_cart'] = array_values($_SESSION['shopping_cart']);
		
	}
	
?>