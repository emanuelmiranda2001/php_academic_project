<?php
include 'ticketsystem/functions.php';
require_once('cookies/header.php');
//Verify if user is allowed here

// Connect to MySQL using the below function
$pdo = pdo_connect_mysql();
// Check if the ID param in the URL exists
if (!isset($_GET['id'])) {
    exit('No ID specified!');
}
// MySQL query that selects the ticket by the ID column, using the ID GET request variable
$stmt = $pdo->prepare('SELECT * FROM tickets WHERE id = ?');
$stmt->execute([ $_GET['id'] ]);
$ticket = $stmt->fetch(PDO::FETCH_ASSOC);
// Check if ticket exists
if (!$ticket) {
    exit('Invalid ticket ID!');
}

//Check if user is allowed here
if($_SESSION['id'] != $ticket['user_id'] && $_SESSION['user_type'] != "admin"){
	header('Location:index.php');
	die();
}

// Update status
if (isset($_GET['status']) && in_array($_GET['status'], array('open', 'closed', 'resolved'))) {
    $stmt = $pdo->prepare('UPDATE tickets SET status = ? WHERE id = ?');
    $stmt->execute([ $_GET['status'], $_GET['id'] ]);
    header('Location: view.php?id=' . $_GET['id']);
    exit;
}

// Check if the comment form has been submitted
if (isset($_POST['msg']) && !empty($_POST['msg'])) {
    // Insert the new comment into the "tickets_comments" table
    $stmt = $pdo->prepare('INSERT INTO tickets_comments (ticket_id, msg, user_type) VALUES (?, ?, ?)');
    $stmt->execute([ $_GET['id'], $_POST['msg'], $_SESSION['user_type'] ]);
    header('Location: view.php?id=' . $_GET['id']);
    exit;
}
$stmt = $pdo->prepare('SELECT * FROM tickets_comments WHERE ticket_id = ? ORDER BY created DESC');
$stmt->execute([ $_GET['id'] ]);
$comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

<?=template_header('Ticket')?>

<div class="content view">

	<h2><?=htmlspecialchars($ticket['title'], ENT_QUOTES)?> (FROM USER ID: <?=$ticket['user_id']?>) <span class="<?=$ticket['status']?>">(<?=$ticket['status']?>)</span></h2>

    <div class="ticket">
        <p class="created"><?=date('F dS, G:ia', strtotime($ticket['created']))?></p>
        <p class="msg"><?=nl2br(htmlspecialchars($ticket['msg'], ENT_QUOTES))?></p>
    </div>
<?php 
if($_SESSION['user_type'] == "admin"){
?>
    <div class="btns">
        <a href="view.php?id=<?=$_GET['id']?>&status=closed" class="btn btn-danger">Close</a>
        <a href="view.php?id=<?=$_GET['id']?>&status=resolved" class="btn btn-success">Resolve</a>
		<a href="view.php?id=<?=$_GET['id']?>&status=open" class="btn btn-warning">Re-Open</a>
    </div>
<?php 
}
if($ticket['status'] == 'open' || $_SESSION['user_type'] == 'admin'){
?>

    <div class="comments">
        <?php foreach($comments as $comment):?>
        <div class="<?php echo ($comment['user_type'] == "admin") ? "comment admincomment" : "comment"; ?>">
            <div>
                <i class="fas fa-comment fa-2x"></i>
            </div>
            <p>
                <span><?=date('F dS, G:ia', strtotime($comment['created']))?></span>
                <?=nl2br(htmlspecialchars($comment['msg'], ENT_QUOTES))?>
            </p>
        </div>
        <?php endforeach; ?>
        <form action="" method="post">
            <textarea name="msg" placeholder="Enter your comment..."></textarea>
            <input type="submit" class="btn btn-success" value="Post Comment">
        </form>
    </div>
<?php
}
?>

</div>

<?=template_footer()?>