<!DOCTYPE html>
<html>
<head>
<title>Store</title>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">



<link rel="stylesheet" href="css/cart.css">

</head>
<body >

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

<?php
		
  	require_once('cookies/header.php');
	$db = mysqli_connect('localhost', 'eva', 'cm', 'cart');
	$search = $_POST['search'];
	$query = "SELECT * From products WHERE name Like '%$search%'";	
	$result = mysqli_query($db , $query);
	

?>
<?php
if($search == ""){
	echo "	<br>
			<br>
			<h1 class='text-center'>Nada Pesquisado</h1>";
}

elseif($result){
		if(mysqli_num_rows($result)>0){
			while($product = mysqli_fetch_assoc($result)){
	?>
				
			<div class="col-sm-4 col-md-3">
			
				<form method="post" action="cart.php?action=add&id=<?php echo $product['id']; ?>">
					<div class="products">
					<?php echo "<img src='images/".$product['image']."'class='img-responsive'/>"?>
					<h4 class="text-info"><?php echo $product['name']; ?></h4>
					<h4>€<?php echo $product['price']; ?></h4>
					<input type="text" name="quantity" class="form-control" value="1"/>
					<input type="hidden" name="name" value="<?php echo $product['name']; ?>"/>
					<input type="hidden" name="price" value="<?php echo $product['price']; ?>"/>
					<input type="submit" name="add_to_cart" style="margin-top:5px;" class="btn btn-info" value="Add to Cart"/>							
					</div>
				</form>	
				
			</div>
				
	<?php		
			}
	
	?>
			</div>
			
	<?php
			}
			else{
				echo "	
				<br>
				<br>
				<h1 class='text-center'>Nada Encontrado</h1>";
				
			}
			}
	?>


</body>
</html>