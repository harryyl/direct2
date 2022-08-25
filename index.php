<!DOCTYPE HTML>
<html>
<head><link rel="icon" href="pics/Untitled-1 Asset 1.png"><title>direct2</title></head>

<?php
require('bootstrap.php');
if ($connection = OpenCon('direct2')) {

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
</html>