<?php
session_start();

$_SESSION['url'] = 'profile';
include 'includes/accesscheck.inc.php';


$pageTitle =  "Profile - ";
include_once 'includes/header.php';
include 'includes/functions.inc.php';


?>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>

        screenWidth = window.screen.width;
        $( function() {
            $( ".bookings" ).accordion({
                collapsible: true,
                active: 1,
                heightStyle: "fill"
            });
        } );

    </script>

    <section class="main-container">

        <div class="profile-main-wrapper">

            <div class="profile-info">

                <div class="profile-container">
                    <h2>Your Bookings</h2>

                    <div class="bookings-container">
                        <div class="bookings">
                        <h2>Past Bookings</h2>

                        <div class="inactive-bookings">
                            <?php
                            include 'includes/populateprofileinfobookingsinactive.inc.php';
                            ?>
                        </div>
                        <h2>Future Bookings</h2>

                        <div class="active-bookings">
                            <?php
                            include 'includes/populateprofileinfobookings.inc.php';
                            ?>
                        </div>
                        </div>


                    </div>
                </div>


                <div class="profile-container">
                    <h2>Your Properties</h2>

                    <a class="btn btn-default" href="addproperty">Add New Property</a>
                    <!--<a class="btn btn-default" href="editproperty">Edit Property</a>-->


                    <div class="properties-container">

                        <?php
                        include 'includes/populateprofileinfoproperties.inc.php';
                        ?>
                    </div>
                </div>

            </div>

        </div>


    </section>




<?php
include_once 'includes/footer.php';
?>