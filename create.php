<?php
include 'ticketsystem/functions.php';
require_once('cookies/header.php');
$pdo = pdo_connect_mysql();
// Output message variable
$msg = '';
// Check if POST data exists (user submitted the form)
if (isset($_POST['title'], $_POST['email'], $_POST['msg'])) {
    // Validation checks... make sure the POST data is not empty
    if (empty($_POST['title']) || empty($_POST['email']) || empty($_POST['msg'])) {
        $msg = 'Please complete the form!';
    } else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $msg = 'Please provide a valid email address!';
    } else {
        // Insert new record into the tickets table
        $stmt = $pdo->prepare('INSERT INTO tickets (title, email, msg,user_id) VALUES (?, ?, ?,?)');
        $stmt->execute([ $_POST['title'], $_POST['email'], $_POST['msg'], $_SESSION['id'] ]);
        // Redirect to the view ticket page, the user will see their created ticket on this page
        header('Location: view.php?id=' . $pdo->lastInsertId());
    }
}
?>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

<?=template_header('Create Ticket')?>

<div class="content create">
	<h2>Create Ticket</h2>
    <form action="create.php" method="post">
        <label for="title">Title</label>
        <input type="text" name="title" placeholder="Title" id="title" required>
        <label for="email">Email</label>
        <input type="email" name="email" placeholder="johndoe@example.com" id="email" required>
        <label for="msg">Message</label>
        <textarea name="msg" placeholder="Enter your message here..." id="msg" required></textarea>
        <input type="submit" class="btn btn-success" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>