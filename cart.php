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
		$query_cat1 = "SELECT * FROM products WHERE category = 'queijo'";
		$query_cat2 = "SELECT * FROM products WHERE category = 'enchidos'";
		$query_cat3 = "SELECT * FROM products WHERE category = 'azeite'";
		if (!empty($_POST['search'])){
			$search = $_POST["search"];
			$search_modifier = " AND name Like '%$search%'";
			$query_cat1 .= $search_modifier;
			$query_cat2 .= $search_modifier;
			$query_cat3 .= $search_modifier;
		}
		$result_cat1 = mysqli_query($db , $query_cat1);
		$result_cat2 = mysqli_query($db , $query_cat2);
		$result_cat3 = mysqli_query($db , $query_cat3);
		
	?>

	<?php
	
	if($result_cat1){
		if(mysqli_num_rows($result_cat1)>0){
	?>
			<div class="container-fluid">
	
			<h1><a name="queijo">Queijos</a></h1>
			<?php
			while($product = mysqli_fetch_assoc($result_cat1)){
			?>
				
			<div class="col-sm-4 col-md-3">
			
				<form method="post" action="cart.php?action=add&id=<?php echo $product['id']; ?>">
					<div class="products">
					<?php echo "<img src='images/".$product['image']."'class='img-responsive'/>"?>
					<h4 class="text-info"><?php echo $product['name']; ?></h4>
					<h4><?php echo $product['price']; ?>€</h4>
					<?php
						if($product['stock'] > 0){
							?>
							<input type="number" name="quantity" min="1" class="form-control" value="1"/>
							<input type="hidden" name="name" value="<?php echo $product['name']; ?>"/>
							<input type="hidden" name="price" value="<?php echo $product['price']; ?>"/>
							<input type="submit" name="add_to_cart" style="margin-top:5px;" class="btn btn-info" value="Add to Cart"/>
							<?php
							
						}
						else{
							echo 'Product out of stock';
						}
					?>
												
					</div>
				</form>	
				
			</div>
				
	<?php

			}
		echo "</div>";
		}
	}
			
	?>
			
				
	<?php
			if($result_cat2){
				if(mysqli_num_rows($result_cat2)>0){
	?>
					<div class="container-fluid">
					<h1><a name="enchidos">Enchidos</a></h1>
					<?php
					while($product = mysqli_fetch_assoc($result_cat2)){
					?>

					<div class="col-sm-4 col-md-3">
						
						<form method="post" action="cart.php?action=add&id=<?php echo $product['id']; ?>">
							<div class="products">
							<?php echo "<img src='images/".$product['image']."'class='img-responsive'/>"?>
							<h4 class="text-info"><?php echo $product['name']; ?></h4>
							<h4><?php echo $product['price']; ?>€</h4>
							<?php
								if($product['stock'] > 0){
									?>
									<input type="number" name="quantity" min="1" class="form-control" value="1"/>
									<input type="hidden" name="name" value="<?php echo $product['name']; ?>"/>
									<input type="hidden" name="price" value="<?php echo $product['price']; ?>"/>
									<input type="submit" name="add_to_cart" style="margin-top:5px;" class="btn btn-info" value="Add to Cart"/>
									<?php
								}
								else{
									echo 'Product out of stock';
								}
							?>
														
							</div>
						</form>	
					</div>
					<?php
					}
					echo "</div>";
				}
			}
		
	
	?>
	
	<?php
	
	if($result_cat3){
		if(mysqli_num_rows($result_cat3)>0){
	?>
			<div class="container-fluid">
	
			<h1><a name="azeite">Azeite</a></h1>
			<?php
			while($product = mysqli_fetch_assoc($result_cat3)){
			?>
				
			<div class="col-sm-4 col-md-3">
			
				<form method="post" action="cart.php?action=add&id=<?php echo $product['id']; ?>">
					<div class="products">
					<?php echo "<img src='images/".$product['image']."'class='img-responsive'/>"?>
					<h4 class="text-info"><?php echo $product['name']; ?></h4>
					<?php
						if($product['stock'] > 0){
							?>
							<input type="number" name="quantity" min="1" class="form-control" value="1"/>
							<input type="hidden" name="name" value="<?php echo $product['name']; ?>"/>
							<input type="hidden" name="price" value="<?php echo $product['price']; ?>"/>
							<input type="submit" name="add_to_cart" style="margin-top:5px;" class="btn btn-info" value="Add to Cart"/>
							<?php
							
						}
						else{
							echo 'Product out of stock';
						}
					?>
												
					</div>
					
				</form>	
				
			</div>
				
	<?php

			}
		echo "</div>";
		}
	}
	


			
	?>
			

	
</body>
</html>