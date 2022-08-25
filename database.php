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
            return false;
        } else {
            $stmt = $connection->prepare("INSERT INTO USERS (name, gender) VALUES(?, ?)");

            $stmt->bind_param('ss', $_POST['name'], $_POST['gender']);
            $success = $stmt->execute();
        if ($success = true) {
            return true;
        }
        }
        
}

function refreshNumbers($connection) {
    $connection -> query('UPDATE USERS SET `itemspurchased`=(SELECT COUNT(uiUser) FROM useritems WHERE uiUser=userID)');
}

function addItemToUser($connection, $itemno, $userno) {
    $query = 'INSERT INTO `useritems` (uiItem, uiUser) VALUES (?, ?)';
    $stmt = $connection->prepare($query);
    $stmt->bind_param('ii', $itemno, $userno);
    $stmt->execute();
}

function deleteUser($connection, $userid) {
    
    $query = "DELETE FROM USERS WHERE userID=?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param('i', $userid);
    if ($success = $stmt -> execute()) {
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
    $results = [];
    while ($obj = $result -> fetch_object()) {
        $results[] = '<h3> (user id: '.$obj->userID.') name is '.$obj->name.' and gender is '.$obj->gender.'. they\'ve purchased '.$obj->itemspurchased.' items  <form method="post"><input type="hidden" id="gottenusers" name="gottenusers" value="gottenusers"><input type="submit" name="delete" id="delete" value="delete user" /><input type="submit" name="purchase" id="purchase" value="add new purchase" /><input type="submit" name="view" id="view" value="view past purchases" /><input type="submit" name="insights" id="insights" value="view user insights" /><br/><input type="hidden" id="userid" name="userid" value="'.$obj->userID.'"></form>';
      }
    return $results;
}

function getUserItems($connection, $userid) {
    $query = 'SELECT `uiItem` FROM useritems WHERE `uiUser`= ?';
    $stmt = $connection->prepare($query);
    $stmt-> bind_param('i', $userid);
    $stmt->execute();
    $result = $stmt->get_result();
    $completeresult = [];
        while($current = $result->fetch_object()) {
            $itemid = $current->uiItem;
            $query = 'SELECT `itemname`, `itemprice`, `itemsize`, `itemshade` FROM items WHERE itemid=?';
            $stmt2 = $connection->prepare($query);
            $stmt2->bind_param('i', $itemid);
            $stmt2->execute();
            $result2 = ($stmt2->get_result())-> fetch_object();
            //$query2 = 'SELECT COUNT(uiId) as quantity FROM useritems WHERE uiItem='.$itemid.' AND uiUser='.$userid;
            $query2 = 'SELECT COUNT(uiId) as quantity FROM useritems WHERE uiItem= ? AND uiUser=?';
            $stmt3 = $connection -> prepare($query2);
            $stmt3->bind_param('ii', $itemid, $userid);
            $stmt3->execute();
            $quantity = ($stmt3->get_result()) -> fetch_object();
            $completeresult[] = array($result2->itemname, $result2->itemprice, $result2->itemsize, $result2->itemshade, $quantity->quantity);
        };
        $completeresult = array_unique($completeresult, SORT_REGULAR);
        $printableResults[] = '<table><tr><th>product name</th><th>product price</th><th> product size</th><th> product shade</th><th>quantity</th></tr>';

        foreach($completeresult as $product) {
            $printableResults[] = '<tr> <td>'.$product[0].'</td><td>£'.$product[1].'</td><td>'.$product[2].'ml</td><td>'.$product[3].'</td><td>'.$product[4].'</tr>';
        }
        return $printableResults;
}
 
function CloseCon($conn)
 {
 $conn -> close();
 }