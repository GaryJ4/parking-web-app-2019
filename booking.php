<?php
session_start();

include 'includes/bookingpageaccescheck.inc.php';

$_SESSION['url'] = 'booking';
include 'includes/accesscheck.inc.php';

$pageTitle = "Make New Booking - ";

include_once 'includes/header.php';
include 'includes/functions.inc.php';
?>

<section class="main-container">

    <div class="main-wrapper">

        <div class="property-information-container">
            <h2>Confirm These Details Are Correct?</h2>

            <p><?php echo '<span class="heading">Property Name:</span> ' . $_SESSION['propertyname']?></p>
            <p><?php echo '<span class="heading">Property Description:</span> ' . $_SESSION['propertydescription']?></p>
            <p><?php echo '<span class="heading">Address:</span> ' . $_SESSION['address']?></p>
            <p><?php echo'<span class="heading">Hosted by:</span> ' . $_SESSION['hostname']?></p>
            <p><?php echo '<span class="heading">Price per day:</span> £' . $_SESSION['priceperday']?></p>
            <p><?php echo '<span class="heading">Total Cost:</span> £' . $_SESSION['totalprice']?></p>
            <p><?php echo '<span class="heading">Arriving on:</span> ' . changedatereverse($_SESSION['arrdate']) . " at " . $_SESSION['arrtime'] ?></p>
            <p><?php echo '<span class="heading">Departing on:</span> ' . changedatereverse($_SESSION['depdate']) . " at " . $_SESSION['deptime'] ?></p>


            <!--<a class="btn btn-default" href="booking">Book</a>-->
            <?php
            if ($_SESSION['u_id'] != $_SESSION['hostid']) { ?>
                <form action="includes/submitbooking.inc.php" method="POST">
                    <button class="btn btn-default" type="submit" name="submit">Confirm Booking</button>
                </form>
            <?php } else { ?>
                <p>This is your property.</p>
            <?php } ?>


            <form action="includes/gobackurl.inc.php" method="POST">
                <button class="btn btn-default" type="submit" name="submit">Go Back</button>
            </form>

        </div>

        <!--<img src="img/icons/apple-pay-payment-mark.svg" height="50px" width="80px" style="margin:8px" />-->



    </div>

</section>



<?php
include_once 'includes/footer.php';
?>
