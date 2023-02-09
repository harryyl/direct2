<?php require('bootstrap.php'); session_start(); ?>
<html><head><link rel="icon" href="pics/Untitled-1 Asset 1.png"><title>store view</title></head> <div class="nav">
    <label>Welcome, <?php echo $_SESSION['name'];?>!</label>
    <?php 
    if($_SESSION['transCount'] == 0) {
        ?> <label>You haven't processed any products today. Persevere!</label><?php
    } elseif ($_SESSION['transCount'] == 1) {
        ?> <label>You've processed <?php echo $_SESSION['transCount']?> product today. What a good start!</label><?php
    }
    else {
        ?> <label>You've processed <?php echo $_SESSION['transCount']?> products today. What a momentum!</label><?php
    }
    ?>
    
    <a href="index.php">Home</a>
    <a href="logout.php">Logout</a>  
    <a href="profile.php">View Your Profile</a>
</div>

<?php

if ($connection = OpenCon('theDatabase')) {

$query = 'SELECT * FROM stores ORDER BY band';
    $result = $connection->query($query);
    ?><table class="storesTable"><tr><th>Store Name</th><th>Store Number</th><th>Store Band</th><th>Store Address</th><th>Store Brand</th><th>Store Revenue</th></tr> <?php
    while($store = $result->fetch_object()) {
        ?> <tr> <th> <?php echo $store->retailer;?></th>
        <th> <?php echo $store->storeNumber;?></th>
        <th> <?php echo $store->band;?></th>
        <th> <?php echo $store->address;?></th>
        <th> <?php echo $store->brand;?></th>
        <th>£<?php echo getStoreTotal($connection, $store->storeNumber); ?></th>
    </tr> <?php
    };
    
    
} else {
    ?> <h1>fatal connection error</h1><?php
}?> </table>
<div class="nav">
    <label>2023 © Direct2</label>
    <a href="about.php">About</a>

</div>
    </html>
