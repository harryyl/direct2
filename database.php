<?php
mysqli_report(MYSQLI_REPORT_ALL ^ MYSQLI_REPORT_INDEX);


function myHandler(int $errno, string $error) {
    var_dump($errno);
    echo $error;
}
set_error_handler('myHandler');

function OpenCon(string $db) {
    $dbhost = "localhost";
    $dbuser = "root";
    $dbpass = "root";
    $conn = new mysqli($dbhost, $dbuser, $dbpass,$db);
    if ($conn->connect_errno) {
        return false;
    } else {
        return $conn;
    }
}

function addUser($connection) {

        if ($_POST['name'] == null) {

        } else {
            $sucess = $connection -> query("INSERT INTO USERS (name, gender) VALUES('".$_POST['name']."', '".$_POST['gender']."')");
        if ($success = true) {
            echo '<h4>user added successfully</h4>';
        }
        }
        
}

function refreshNumbers($connection) {
    $connection -> query('UPDATE USERS SET `itemspurchased`=(SELECT COUNT(uiUser) FROM useritems WHERE uiUser=userID)');
}

function addItemToUser($connection, $itemno, $userno) {
    $connection -> query('INSERT INTO `useritems` (uiItem, uiUser) VALUES ('.$itemno.', ('.$userno.'))');
}

function deleteUser($connection, $userid) {
    $query = "DELETE FROM USERS WHERE userID='".$userid."'";
    if ($success = $connection -> query($query)) {
        return true;
    }
}

function getItems($connection) : array{
    $query = "SELECT `itemname`, `itemsize`, `itemid`, `itemshade` FROM ITEMS";
    $results = [];
    $result = $connection -> query($query);
    while ($obj = $result -> fetch_object()) {
        $results[] = array($obj->itemname, $obj->itemsize, $obj->itemid, $obj->itemshade);
    }
    return $results;
}

function getUsers($connection) {
    $result = $connection -> query('SELECT * FROM USERS');
    while ($obj = $result -> fetch_object()) {
        echo '<h3> (user id: '.$obj->userID.') name is '.$obj->name.' and gender is '.$obj->gender.'. they\'ve purchased '.$obj->itemspurchased.' items  <form method="post"><input type="submit" name="delete" id="delete" value="delete user" /><input type="submit" name="purchase" id="purchase" value="add new purchase" /><input type="submit" name="view" id="view" value="view past purchases" /><input type="submit" name="insights" id="insights" value="view user insights" /><br/><input type="hidden" id="userid" name="userid" value="'.$obj->userID.'"></form>';
      }
}

function getUserItems($connection, $userid) {
    $query = 'SELECT `uiItem` FROM useritems WHERE `uiUser`='.$userid;
        $result1 = $connection -> query($query);
        $completeresult = [];
        while($current = $result1->fetch_object()) {
            $itemid = $current->uiItem;
            $query = 'SELECT `itemname`, `itemprice`, `itemsize`, `itemshade` FROM items WHERE itemid='.$itemid;
            $result2 = ($connection -> query($query))-> fetch_object();
            $query2 = 'SELECT COUNT(uiId) as quantity FROM useritems WHERE uiItem='.$itemid.' AND uiUser='.$userid;
            $quantity = ($connection -> query($query2)) -> fetch_object();
            $completeresult[] = array($result2->itemname, $result2->itemprice, $result2->itemsize, $result2->itemshade, $quantity->quantity);
        };
        $completeresult = array_unique($completeresult, SORT_REGULAR);
        echo '<table><tr><th>product name</th><th>product price</th><th> product size</th><th> product shade</th><th>quantity</th></tr>';
        foreach($completeresult as $product) {
            echo '<tr> <td>'.$product[0].'</td><td>£'.$product[1].'</td><td>'.$product[2].'ml</td><td>'.$product[3].'</td><td>'.$product[4].'</tr>';
        }
}
 
function CloseCon($conn)
 {
 $conn -> close();
 }