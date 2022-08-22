<!DOCTYPE HTML>
<html>
<head><link rel="icon" href="pics/Untitled-1 Asset 1.png"></head>
    <section class="indexpage">
        
        <img src="pics/IMG_0226.PNG">
        <button type="button"><a href="users.php">view all users</a></button>
        <button type="button"><a href="adduser.php">add user</a></button>
    </section>
<?php

require('bootstrap.php');

if ($connection = OpenCon('direct2')) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        addUser($connection);
    }

    //getUsers($connection);

    //echo '<h4>add user:</h4><form method="post"><label for="name">name:</label><input name="name" id="name" type="text"><label for="gender">gender:</label><input name="gender" id="gender" type="text"><button type="submit">Submit</button></form>';

} else {
    echo '<h2>connection not established</h2>';
}

?>

</html>