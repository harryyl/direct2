<?php
mysqli_report(MYSQLI_REPORT_ALL ^ MYSQLI_REPORT_INDEX);


function myHandler(int $errno, string $error) {
    var_dump($errno);
    echo $error;
}
set_error_handler('myHandler');

function OpenCon(string $db) {
    $dbhost = "theHost";
    $dbuser = "theUser";
    $dbpass = "thePassword";
    $conn = new mysqli($dbhost, $dbuser, $dbpass,$db);
    if ($conn->connect_errno) {
        return false;
    } else {
        return $conn;
    }
}

function addUser($connection, $consulID) {
        if ($_POST['name'] == null) {
            return false;
        } else {
            $stmt = $connection->prepare("INSERT INTO users (name, gender, consulID, email, mailing) VALUES(?, ?, ?, ?, ?)");
            

            $stmt->bind_param('ssiss', $_POST['name'], $_POST['gender'], $consulID, $_POST['email'], $_POST['mailing']);
            
            $success = $stmt->execute();
            
        if ($success = true) {
            
            return true;
        }
        }
        
}

function refreshNumbers($connection) {
    $connection -> query('UPDATE users SET `itemspurchased`=(SELECT COUNT(uiUser) FROM useritems WHERE uiUser=userID)');
}

function custSignUps($connection, $consulID) {
    $result = $connection -> query("SELECT COUNT(*) AS numberOf FROM users WHERE `consulID`=".$consulID );
    return ($result->fetch_object())->numberOf;
}

function getConsulRev($connection, $consulID) {
    $runningtotal = 0;
    $result = $connection -> query("SELECT `uiItem` FROM useritems WHERE `uiConsul`=".$consulID);
    $items[] = [];
    while ($obj = $result -> fetch_object()) { 
        $items[] = $obj->uiItem;
    }

    foreach ($items as $item) {
        $result = $connection -> query("SELECT `itemprice` FROM items WHERE `itemid`=".intval($item));
        while ($obj = $result -> fetch_object()) { 
            $runningtotal = $runningtotal + intval($obj->itemprice);
        }
    }

    return $runningtotal;
    

    
}

function addItemToUser($connection, $itemno, $userno, $consulNo) {
    $query = 'INSERT INTO `useritems` (uiItem, uiUser, uiConsul) VALUES (?, ?, ?)';
    $stmt = $connection->prepare($query);
    $stmt->bind_param('iii', $itemno, $userno, $consulNo);
    $stmt->execute();
}

function getStoreTotal($connection, $storeID) {
    $consulIDs = [];
    $query = 'SELECT id FROM accounts WHERE storeID='.$storeID;
    $result = $connection->query($query);
    $resultExists = false;
    while($consulID = $result->fetch_object()) {
        $resultExists = true;
        $consulIDs[] = intval($consulID->id);
    };
    if ($resultExists) {
        foreach($consulIDs as $current) {
        $query = 'SELECT uiItem FROM useritems WHERE uiConsul='.$current;
        $result = $connection->query($query);
        while($item = $result->fetch_object()) {
            $items[] = intval($item->uiItem);
        };
    }
    $total = 0;
    foreach($items as $oneItem) {
        $query = 'SELECT itemprice FROM items WHERE itemid='.$oneItem;
        $result = $connection->query($query);
        while($price = $result->fetch_object()) {
            $total = $total + $price->itemprice;
        };
    }
    } else {
        $total = 0;
    }
    

    return $total;

}

function noConsulItems($connection, $consulID) {
    $result = $connection -> query("SELECT `uiItem` FROM useritems WHERE `uiConsul`=".$consulID);
    $items[] = [];
    while ($obj = $result -> fetch_object()) { 
        $items[] = $obj->uiItem;
    }

    return count($items);
}

function deleteUser($connection, $userid) {
    
    $query = "DELETE FROM users WHERE userID=?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param('i', $userid);
    if ($success = $stmt -> execute()) {
        return true;
    }
}

function getItems($connection) : array{
    $query = "SELECT `itemname`, `itemsize`, `itemid`, `itemshade` FROM items";
    $results = [];
    $result = $connection -> query($query);
    while ($obj = $result -> fetch_object()) {
        $results[] = array($obj->itemname, $obj->itemsize, $obj->itemid, $obj->itemshade);
    }
    return $results;
}

function authorizeMe($connection, $compKey) {
    $result = $connection -> query("SELECT * FROM compKeys");
    $results = [];
    while ($obj = $result -> fetch_object()) { 
        if(password_verify($compKey, $obj->compKey)) {
            return true;
        }
    }
}

function getUsers($connection) {
    $result = $connection -> query("SELECT * FROM users");
    $results = [];
    while ($obj = $result -> fetch_object()) {
        $results[] = '<h3> (user id: '.$obj->userID.') name is '.$obj->name.' and gender is '.$obj->gender.'. they\'ve purchased '.$obj->itemspurchased.' items  <form method="post"><input type="hidden" id="gottenusers" name="gottenusers" value="gottenusers"><input type="submit" name="delete" id="delete" value="delete user" /><input type="submit" name="purchase" id="purchase" value="add new purchase" /><input type="submit" name="view" id="view" value="view user" /><br/><input type="hidden" id="userid" name="userid" value="'.$obj->userID.'"></form>';
       
      }
    return $results;
}

function getSearchUsers($connection, $searchTerm) {
    $result = $connection -> query("SELECT * FROM users WHERE `name` LIKE '%".$searchTerm."%'");
    $results = [];
    while ($obj = $result -> fetch_object()) {
        $results[] = '<h3> (user id: '.$obj->userID.') name is '.$obj->name.' and gender is '.$obj->gender.'. they\'ve purchased '.$obj->itemspurchased.' items  <form method="post"><input type="hidden" id="gottenusers" name="gottenusers" value="gottenusers"><input type="submit" name="delete" id="delete" value="delete user" /><input type="submit" name="purchase" id="purchase" value="add new purchase" /><input type="submit" name="view" id="view" value="view user" /><br/><input type="hidden" id="userid" name="userid" value="'.$obj->userID.'"></form>';
       
      }
    return $results;
}

function getUserName($connection, $userid) {
    $query = 'SELECT name FROM users WHERE userID= ?';
    $stmt = $connection->prepare($query);
    $stmt->bind_param('i', $userid);
    $stmt->execute();
    return (($stmt->get_result())->fetch_object())->name;
}

function getUserTransactions($connection, $userid) {
    $result = $connection -> query("SELECT `uiCreated` FROM `useritems` WHERE `uiUser`=".$userid." GROUP BY `uiCreated`, `uiUser`");
    $results = [];
    $count = 1;
    while ($obj = $result -> fetch_object()) {
        $results[] = 'Transaction '.$count.': '.$obj->uiCreated.' ';
        $count++;
        $totalspend = 0;
        
        $result2 = $connection -> query("SELECT `uiItem` FROM `useritems` WHERE `uiUser`=".$userid." and `uiCreated`='".$obj->uiCreated."'");
        $results2 = [];
        while ($obj2 = $result2 -> fetch_object()) {
            $query = 'SELECT `itemname`, `itemprice`, `itemsize`, `itemshade`, `itemprice` FROM items WHERE itemid='.$obj2->uiItem;
            $result3 = $connection -> query($query);
            $obj3 = $result3 -> fetch_object();
            $totalspend = $totalspend + $obj3->itemprice;
            $results[] = $obj3->itemname.' - '.$obj3->itemsize.' ml';
        }
        $results[] = 'Transaction spend: £'.$totalspend;

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

function amountProducts($connection, $userid) {
    $result = $connection -> query("SELECT COUNT(*) AS number FROM `useritems` WHERE `uiUser`=".$userid);
    return $result->fetch_object()->number;
}

function avgSpend($connection, $userid) {
    $result = $connection -> query("SELECT `uiItem` FROM `useritems` WHERE `uiUser`=".$userid);
    $itemresults[] = (array) null;
    while($obj = $result->fetch_object()) {
        $result2 = $connection -> query("SELECT `itemprice` FROM `items` WHERE `itemid`=".$obj->uiItem);
        $itemresults[] = $result2->fetch_object()->itemprice;
    }

    return array_sum($itemresults) / (count($itemresults) - 1);
}

function signUpDate($connection, $userid) {
    $result = $connection -> query("SELECT `dateSigned` FROM `users` WHERE `userID`=".$userid);
    return $result->fetch_object()->dateSigned;
}

function getLifetimeSpend($connection, $userid) {
    $result = $connection -> query("SELECT `uiItem` FROM `useritems` WHERE `uiUser`=".$userid);
    $spend = 0.00;
    while ($obj = $result -> fetch_object()) {
        $result2 = $connection -> query("SELECT `itemprice` FROM `items` WHERE `itemid`=".$obj->uiItem); 

        $spend += floatval($result2->fetch_object()->itemprice);
    }
    
    return $spend;
}
 
function CloseCon($conn)
 {
 $conn -> close();
 }
