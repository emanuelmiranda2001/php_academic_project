<?php

	
	$db = mysqli_connect('localhost', 'eva', 'cm', 'cart');
	
	$id = $_GET['id'];
	
	$query = "DELETE FROM products WHERE $id=id";
	
	mysqli_query($db, $query);
	
	header("Location: upload.php");
	die();
?>