<?php

require('bootstrap.php');
session_start();
if(!isset($_SESSION['id'])) {   
    header('Location: login.html');
	exit;
} else {
    if ($connection = OpenCon('theDatabase')) {
        if ($stm = $connection->prepare('SELECT `storeID`, `username`, `fullname`, `dob`, `mailing`, `email` FROM accounts WHERE id = ?')) {
            $stm->bind_param('i', $_SESSION['id']);
            $stm->execute();
            $stm->store_result();
        }
        $stm->bind_result($storeID, $username, $fullname, $dob, $mailing, $email);
        $stm->fetch();

        if ($stm = $connection->prepare('SELECT `brand`, `retailer`, `band`, `address` FROM stores WHERE storeNumber = ?')) {
            $stm->bind_param('i', $storeID);
            $stm->execute();
            $stm->store_result();
        }
        $stm->bind_result($brand, $retailer, $band, $storeAddress);
        $stm->fetch();

    }
}
?>

<div class="nav">
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

<title>Consultant Profile</title>
<body>
    <section class="aboutYou">
        <h2><?php echo $fullname;?></h2>
        <div class="aboutYou">Date of Birth - <?php echo $dob; ?></div>       
        <div>Brand - <?php echo $brand; ?></div>
        <div>Address - <?php echo $mailing; ?></div>
        <div>Email - <?php echo $email; ?></div>
    </section>
    <section class="moreinfo">
        <section class="yourStore">
            <div class="title"><h2>Your Store: <?php echo $retailer;?></h2></div>
            <div>Store Band - <?php echo $band; ?></div>
            <div>Store ID - <?php echo $storeID; ?></div>
            <div>Store Address - <?php echo $storeAddress; ?></div>
            <div>Store Revenue (FY to date) - £<?php echo getStoreTotal($connection, $storeID);?></div>
            <div><a href=stores.php>View All Stores</a></div>
        </section>

        <section class="yourStore">
            <div class="titleProfile"><h2>Your Performance: <?php echo $fullname;?></h2></div>
            <div>Revenue - £<?php  echo getConsulRev($connection, $_SESSION['id'])?></div>
            <div>Number of Products Sold - <?php echo noConsulItems($connection, $_SESSION['id']); ?></div>
            <div>Number of Customers' Data Captured - <?php echo custSignUps($connection, $_SESSION['id']);?></div>
            <div>Customer Satisfaction Rate: 100%</div>
            <div>Your Area Manager: Melissa Faith</div>
        </section>

        <section class="yourStore">
            <div class="titleProfile"><h2>Your Brand: <?php echo $brand;?></h2></div>
            <div>Year of Inception: 1968</div>
            <div>Category: Cosmetics, Fragrance</div>
            <div>Est Yearly Sales: £4 billion</div>
        </section>
    </section>

    <div class="nav">
    <label>2023 © Direct2</label>
    <a href="about.php">About</a>

</div>
</body>
