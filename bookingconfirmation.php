<?php
session_start();

if (!isset($_SESSION['webconfirmation'])) {
    header("Location: index");
    exit();
}

$pageTitle = "Booking Confirmed - ";

//Clear all booking variables
include 'includes/clearallbookingsessionvariables.inc.php';

include_once 'includes/header.php';
?>


<section class="main-container">

    <div class="main-wrapper">

        <h2>Thank you for your booking, <?php echo $_SESSION['u_first']?></h2><br>

        <div class="booking-confirmation">
            <p><?php echo $_SESSION['webconfirmation']; //unset($_SESSION['webconfirmation']); ?></p>
        </div>


    </div>


</section>


<?php
include_once 'includes/footer.php';
?>
