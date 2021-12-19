<!DOCTYPE html>
<html>
<head>
<title>Upload</title>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

<link rel="stylesheet" href="css/cart.css">


</head>
<body>

<?php
	require_once('cookies/header.php');
	require_once('cookies/upload1.php');
?>

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	
	<div class="upload-form">
	
	
	<form method="post" action="upload.php" enctype="multipart/form-data">
		<div class="form-group">
			<input type="radio" name="category" required="required" value="queijo">
			<label class ="texto" for="male">Queijo</label><br>
			
			<input type="radio" name="category" required="required" value="enchidos">
			<label class ="texto" for="male">Enchidos</label><br>
			
			<input type="radio" name="category" required="required" value="azeite">
			<label class ="texto" for="male">Azeite</label><br>
		</div>
		<div class="form-group">
			<input type="text" class="form-control" placeholder="Name" required="required"  name="name">
		</div>
		<div class="form-group">
			<input type="number" step="0.01" min="0.01"  class="form-control" placeholder="Price" required="required" name="price">
		</div>
		<div class="form-group">
			<input type="number" min="1" class="form-control" placeholder="Quantity" required="required" name="stock">
		</div>
		<div class="form-group">
			<input type="file"  required="required"  name="image">
		</div>
		<div>
			<button type="submit" class="btn btn-success" name="upload">Upload</button>
		</div>
	</form>
	<?php
		echo $msg;
		
	?>
	</div>
	<?php
	
		$result = $db->query ('SELECT name, price, stock, category, id FROM products');
		
	?>
	
	<div class="table-responsive">
	<table class="table">
		<tr><th colspan="5"> <h3>Remove</h3></th></tr>
		<tr>
			<th width="20%">Product Name</th>
			<th width="20%">Price</th>
			<th width="20%">Stock</th>
			<th width="20%">Category</th>
			<th width="20%">ID</th>
			<th width="15%">Action</th>
		</tr>
		<?php while ($column = mysqli_fetch_array($result)) { ?>
		<tr>
			<td><?php echo $column['name'];?></td>
			<td><?php echo $column['price'];?>€</td>
			<td><?php echo $column['stock'];?></td>
			<td><?php echo $column['category'];?></td>
			<td><?php echo $column['id'];?></td>
			<td>
				<a class="btn btn-danger float-right" href="apagarProduto.php?id=<?php echo $column['id'];?>" >Remove</a>
			</td>
		</tr>
		<?php } ?>
	</table>
	</div>
	
	
	
	

</body>
</html>