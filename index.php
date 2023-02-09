

<?php

require('bootstrap.php');
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] == false) {
    header('Location: login.html');
	exit;
}


?>

<!DOCTYPE HTML>
<html>
<head><link rel="icon" href="pics/Untitled-1 Asset 1.png"><title>direct2</title></head>
<div class="nav">
    <label>Welcome, <?php echo $_SESSION['name'];?>!</label>
    <?php 
    if($_SESSION['transCount'] == 0) {
        ?> <label>You haven't processed any products today. Persevere!</label><?php
    } elseif ($_SESSION['transCount'] == 1) {
        ?> <label>You've processed <?php echo $_SESSION['transCount']?> product today. What a good start!</label><?php
    }
    else {
        ?> <label>You've processed <?php echo $_SESSION['transCount']?> products today. What a momentum!</label><?php
    }
    ?>
    <a href="logout.php">Logout</a>
    <a href="profile.php">View Your Profile</a>
</div>

<?php

if ($connection = OpenCon('databaseName')) {
    
    if (array_key_exists('view', $_POST)) {
        echo draw('pages/viewuser.php', $connection);
    }
    elseif (array_key_exists('viewUsers', $_POST) || array_key_exists('gottenusers', $_POST) || array_key_exists('purchases', $_POST)) {
        echo draw('pages/users.php', $connection);
    } elseif (array_key_exists('addUser', $_POST) || array_key_exists('gender', $_POST)) {
        echo draw('pages/adduser.php', $connection);
    } else {
        echo draw('pages/homepage.html', $connection);
    }

} else {
 
    echo draw('pages/errorpage.html', $connection);
}
?>



<div class="nav">
    <label>2023 © Direct2</label>
    <a href="about.php">About</a>

</div>
