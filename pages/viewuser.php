<?php

echo '<h1 class="profilepic"> <img src="pics/approved-profile-icon.png">'.getUserName($connection, $_POST['userid']).' (userid '.$_POST['userid'].')</h2>';

$toPrint = getUserItems($connection, $_POST['userid']);
foreach ($toPrint as $thing) {
    echo $thing;
}

echo '<form method="POST"><input type="submit" value="back" name ="viewUsers"></form>';

