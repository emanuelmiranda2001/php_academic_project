<?php
include 'ticketsystem/functions.php';
require_once('cookies/header.php');
// Connect to MySQL using the below function
$pdo = pdo_connect_mysql();
// MySQL query that retrieves the tickets from the databse
if($_SESSION['user_type'] == "admin"){
	$stmt = $pdo->prepare('SELECT * FROM tickets ORDER BY created DESC');
}
elseif($_SESSION['user_type'] == "user"){
	$stmt = $pdo->prepare("SELECT * FROM tickets WHERE user_id Like '%$_SESSION[id]%' ORDER BY created DESC");
}
$stmt->execute();
$tickets = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<?=template_header('Tickets')?>

<div class="content home">

	<h2>Tickets</h2>

	<p>Welcome to the tickets page, you can view the list of tickets below.</p>

	<div class="btns">
		<a href="create.php" class="btn btn-success">Create Ticket</a>
	</div>

	<div class="tickets-list">
		<?php foreach ($tickets as $ticket): ?>
		<a href="view.php?id=<?=$ticket['id']?>" class="ticket">
			<span class="con">
				<?php if ($ticket['status'] == 'open'): ?>
				<i class="far fa-clock fa-2x"></i>
				<?php elseif ($ticket['status'] == 'resolved'): ?>
				<i class="fas fa-check fa-2x"></i>
				<?php elseif ($ticket['status'] == 'closed'): ?>
				<i class="fas fa-times fa-2x"></i>
				<?php endif; ?>
			</span>
			<span class="con">
				<span class="title"><?=htmlspecialchars($ticket['title'], ENT_QUOTES)?></span>
				<span class="msg"><?=htmlspecialchars($ticket['msg'], ENT_QUOTES)?></span>
			</span>
			<span class="con created "><?=date('F dS, G:ia', strtotime($ticket['created']))?></span>
		</a>
		<?php endforeach; ?>


</div>

<?=template_footer()?>