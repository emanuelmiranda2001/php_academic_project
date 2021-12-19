<?php

	// Create database connection
	$db = mysqli_connect('localhost', 'eva', 'cm', 'cart');
	
	// Initialize message variable
	$msg = "";

	// If upload button is clicked ...
	if (isset($_POST['upload'])) {
  	// Get image name
  	$image = $_FILES['image']['name'];
  	// Get name
  	$name = $_POST['name'];
	// Get price
	$price = $_POST['price'];
	// Get stock
	$stock = $_POST['stock'];
	// Get category
	$category = $_POST['category'];
	
	$target_dir = "images/";
	
	// image file directory
	$target_file = $target_dir . basename($_FILES["image"]["name"]);
	
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	
	$errors = array('imageType' => array(false, "Sorry, only JPG, JPEG, PNG & GIF files are allowed."),
					'stockerror' => array(false, "Sorry, invalid quantity."),
					'priceerror' => array(false, "Sorry, invalid price."),
					'sizeerror' => array(false, "Sorry, your file is too large."),
					'prodname' => array(false, "Sorry, invalid name.")
					);
	
	
	if( !validateProdname($name) ){
		$errors['prodname'][0] = true;				
	}
	
	// check if file size is smaller than 2MB
	if ($_FILES["image"]["size"] > 2097152) {

	  $errors['sizeerror'][0] = true;
	}
	
	// allow only jpeg, jpg, gif, png format
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"&& $imageFileType != "gif" ) {
	  
	  $errors['imageType'][0] = true;
	}
	
	// allow only stock above 1
	if($stock < 1){
		
		$errors['stockerror'][0] = true;
	}
	
	// allow only price above 0.01
	if($price < 0.01){
		
		$errors['priceerror'][0] = true;
	}
	
	
	
	
	
	if($errors['imageType'][0] == true){
		$msg = $errors['imageType'][1];
	}
	
	else if($errors['sizeerror'][0] == true){
		$msg = $errors['sizeerror'][1];
	}
	
	elseif($errors['stockerror'][0] == true){
		$msg = $errors['stockerror'][1];
	}
	
	elseif($errors['priceerror'][0] == true){
		$msg = $errors['priceerror'][1];
	}
	
	elseif($errors['prodname'][0] == true){
		$msg = $errors['prodname'][1];
	}
	
	// if everything is ok, try to upload file
	else{ 
		if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
			$sql = "INSERT INTO products (image, category, name, price, stock) VALUES ('$image', '$category', '$name', '$price', '$stock')";
			// execute query
			mysqli_query($db, $sql);
			$msg = "The product with the image ". htmlspecialchars( basename( $_FILES["image"]["name"])). " has been uploaded.";
	  } 
	  else {
			//$msg = "Sorry, there was an error uploading your product.";
	  }
	  }
	
	}


function validateProdname($name){
				
				$exp = '/^[A-z0-9_\ \-]{6,300}$/';			
										
				if( !preg_match($exp, $name )){
					return (false);				
				}else {
					return(true);
				}
			}


?>