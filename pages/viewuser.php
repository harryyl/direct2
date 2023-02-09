<?php
echo '<div class="profView"><img width=100 height=100 src="pics/approved-profile-icon.png"><h1>'.getUserName($connection, $_POST['userid']).' (userid '.$_POST['userid'].')</h1></div>';

if (array_key_exists('viewInsights', $_POST)) {
    echo "<div class=\"transactions\">";
    echo "Lifetime Spend: £".getLifetimeSpend($connection, $_POST['userid']);
    echo "<br>Amount of items purchased: ".amountProducts($connection, $_POST['userid']);
    echo "<br>Average Amount Spent: £".avgSpend($connection, $_POST['userid']);
    echo "<br>Customer since: ".signUpDate($connection, $_POST['userid']);
    echo "</div>";
} else {
    if (array_key_exists('viewTransactions', $_POST)) {

    $toPrint2 = getUserTransactions($connection, $_POST['userid']);
    $popup = '<div class="transactions">';
    foreach ($toPrint2 as $thing) {
        if(strpos($thing, 'Transaction') !== false) {
            $popup .= '<b>'.$thing.'</b><br>';
        } else {
            $popup .= $thing.'<br>';
        }
        
        }
    $popup .= "</div>";
    echo $popup;
    
}

$toPrint = getUserItems($connection, $_POST['userid']);
    foreach ($toPrint as $thing) {
    echo $thing;
}

echo '<form method="POST"><input type="hidden" id="userid" name="userid" value="'.$_POST['userid'].'"><input type="hidden" id="view" name="view" value="view"><input type="submit" value="view transactions" name ="viewTransactions"><input type="submit" value="view insights" name ="viewInsights"></form>';
}








echo '<form method="POST"><input type="hidden" id="userid" name="userid" value="'.$_POST['userid'].'"><input type="submit" value="back" name ="viewUsers"></form>';

/*$lifetimespend = (string) getLifetimeSpend($connection, $_POST['userid']);

if (strpos($lifetimespend, '.') !== false) {
    $lifetimespend .= '0';
}
echo 'Lifetime spend: £'.$lifetimespend;*/
