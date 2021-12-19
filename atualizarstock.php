<?php

	require_once('cookies/header.php');
	
	$db = mysqli_connect('localhost', 'eva', 'cm', 'cart');
	
	for($i=0; $i<sizeof($_SESSION['shopping_cart']);$i++){
	$id = $_SESSION['shopping_cart'][$i]['id'];
	$qt= $_SESSION['shopping_cart'][$i]['quantity'];

	$query = "UPDATE products,(SELECT stock FROM products WHERE id='$id') AS original SET products.stock=original.stock-'$qt' WHERE products.id='$id'";
	mysqli_query($db, $query);
	
	}
	header("Location: shop.php");
	die();
	
	
?>