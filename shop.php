<!DOCTYPE html>
		<html>
		<head>
		<title>Cart</title>

		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">



		<link rel="stylesheet" href="cart.css">

		</head>
		<body >
		
		<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
		
		
		<?php
		//carrinho
  		require_once('cookies/header.php');
		

		
		?>

		
	<div class="table-responsive">
		<table class="table">
			<tr><th colspan="6"> <h3>Order Details</h3></th></tr>
			
			<tr>
				<th width="35%">Product Name</th>
				<th width="10%">ID</th>
				<th width="10%">Quantity</th>
				<th width="20%">Price</th>
				<th width="15%">Total</th>
				<th width="5%">Action</th>
			</tr>
			
	<?php
		if(!empty($_SESSION['shopping_cart'])){
		
			$total = 0;
			
			foreach($_SESSION['shopping_cart'] as $key => $product){
	?>
			<tr>
				<td><?php echo $product['name'] ?></td>
				<td><?php echo $product['id'] ?></td>
				<td><?php echo $product['quantity'] ?></td>
				<td><?php echo $product['price'] ?></td>
				<td><?php echo number_format ($product['quantity'] * $product['price'] , 2); ?></td>
				<td>
					<a href="shop.php?action=delete&id=<?php echo $product['id']; ?>">
						<div class="btn btn-danger float-right">Remove</div>
					</a>
					
				</td>
			</tr>
			
		<?php
			$total = $total + ($product['quantity']*$product['price']);
			
			}
		?>
			
			<tr>
				<td colspan="4" align="right">Total:</td>
				<td align="right">€ <?php echo number_format($total, 2) ?></td>
				<td></td>
			</tr>
			
			<tr>
				<!-- Show checkout buttom only if the shopping cart is not empty -->
				<td colspan="6">
				<?php
					if (isset($_SESSION['shopping_cart'])){
					if (count($_SESSION['shopping_cart']) > 0){
					
				?>
					
					<a class="btn btn-info float-right" href="atualizarstock.php" name="checkout" onclick="alerta()" >Checkout</a>

					<script>
					function alerta() {
					  alert("Purchase made!");
					}
					</script>

				<?php 
					}
					}
				?>
				</td>
				</tr>
			<?php
		}
				
			?>
			
			
	</div>
			
</body>
</html>