<?php
require('database.php');
session_start();

if ($connection = OpenCon('theDatabase')) {

    if ($_POST['username'] == "" || $_POST['password'] == "") {
        exit('Please provide both a username and password. <form action="https://henrylightfootlabs.com/direct2/login.html"><input type="submit" value="back"></form>');
    } else {
        if ($stm = $connection->prepare('SELECT `id`, `password` FROM accounts WHERE username = ?')) {
            $stm->bind_param('s', $_POST['username']);
            $stm->execute();
            $stm->store_result();
        }

        if ($stm->num_rows > 0) {
            $stm->bind_result($id,$password);
            $stm->fetch();

            if(password_verify($_POST['password'], $password)) {
                session_regenerate_id();
                $_SESSION['loggedin'] = TRUE;
		        $_SESSION['name'] = $_POST['username'];
		        $_SESSION['id'] = $id;
                $_SESSION['transCount'] = 0;
                $_SESSION['authorized'] = false;
                header("Location: index.php");
                exit();
            } else {
                exit('Password is incorrect. <form action="https://henrylightfootlabs.com/direct2/login.html"><input type="submit" value="back"></form>');
            }
        } else {
            exit('The account does not exist. <form action="https://henrylightfootlabs.com/direct2/login.html"><input type="submit" value="back"></form>');
        }
    }

}
