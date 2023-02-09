<?php

if ($connection = OpenCon('epiz_32615372_direct2')) {
    
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
        echo '<form method="POST"><input type="submit" value="cancel" name ="viewUsers"></form>';
    } else if (array_key_exists('purchases', $_POST)) {
        $_SESSION['transCount'] = $_SESSION['transCount'] + 1;
        addItemToUser($connection, $_POST['purchases'], $_POST['userid'], $_SESSION['id']);       
        refreshNumbers($connection);
    } else if (array_key_exists('view', $_POST)) {
        
        $toPrint = getUserItems($connection, $_POST['userid']);
        foreach ($toPrint as $thing) {
            echo $thing;
        }
    } else if (array_key_exists('search', $_POST)){
        $results = getSearchUsers($connection, $_POST["search"]);
        foreach($results as $result) {
            echo $result;
        }
    } else if (array_key_exists('viewall', $_POST) && $_SESSION['authorized'] == false) {
        echo '<h2>enter company approval keyword:</h2><form method="POST"><input type="text" id="compKey" name="compKey"><button type="submit">Authorize</button><input type="hidden" id="viewUsers" name="viewUsers"></form>';
    } else if (array_key_exists('compKey', $_POST) || $_SESSION['authorized'] == true) {
        if ($_SESSION['authorized']== true) {
            $results = getUsers($connection);
            foreach($results as $result) {
                echo $result;
            }
        } else {
            if (authorizeMe($connection, $_POST['compKey'])){
            $_SESSION['authorized'] = true;
            echo '<div class="authorized"><img src="pics/lock.png" width="100" height="100"><h1>you are viewing confidential company information</h1></div>';
            $results = getUsers($connection);
            foreach($results as $result) {
                echo $result;
            }} else {
            echo '<h1>NOT authorized. Contact your company representative.</h1>';
        };
        }
        
    }
    echo '<h1>Search:</h1>';
    echo ' <div class="searchBox"><form method="post"><label for="search">Enter name:</label>
    <input type="text" id="search" name="search"> <button type="submit">Search</button><input type="hidden" id="viewUsers" name="viewUsers"></form></div>';
    



    echo '<a href="/direct2"><button type="button">back home</button></a><form method="POST"><input type="hidden" id="viewUsers" name="viewUsers"><button type="submit">view all users</button><input type="hidden" id="viewall" name="viewall"></form>';

}



?>


        
    

