<?php

require('bootstrap.php');

if ($connection = OpenCon('direct2')) {
    if (array_key_exists('delete', $_POST)) {
        $result = deleteUser($connection, $_POST['userid']);
        if ($result) {
            echo '<p>user successfully deleted</p>';
        }
    } else if (array_key_exists('purchase', $_POST)) {
        echo '<h3>add new purchase for user id '.$_POST['userid'].':</h3> <form method="POST">
        <select name="purchases" id="purchases">';
        $results = getItems($connection);

        foreach($results as $item) {
            echo '<option value="'.$item[2].'">'.$item[0].' - '.$item[3].' '.$item[1].'ml</option>';
        }
        echo '</select><input type="hidden" id="userid" name="userid" value="'.$_POST['userid'].'"><input type="submit" value="submit"></form>';
        echo '<form><button type="submit">cancel</button></form>';
    } else if (array_key_exists('purchases', $_POST)) {

        addItemToUser($connection, $_POST['purchases'], $_POST['userid']);       
        refreshNumbers($connection);

    } else if (array_key_exists('view', $_POST)) {
        $toPrint = getUserItems($connection, $_POST['userid']);
        foreach ($toPrint as $thing) {
            echo $thing;
        }
    }

    
    $users = getUsers($connection);
    foreach ($users as $user) {
        echo $user;
    }

    echo '<a href="index.php"><button type="button">back home</button></a>';

}



?>


        
    

