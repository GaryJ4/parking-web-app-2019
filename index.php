<?php
    include_once 'includes/header.php';
?>


<section class="main-container">

    <div class="main-wrapper">

        <h2>Home</h2>

        <?php
            if (isset($_SESSION['u_id'])) {
                echo "Welcome " . $_SESSION['u_first'] . ".<br><br>";
            }
        //print_r($_SESSION);
        ?>

        <div class="search-for-location">
            <form action="search" method="GET">
                <label>Where do you want to park?</label>
                <input type="text" name="location" placeholder="Enter a place name">

                <button type="submit" class="search-for-location-submit">Search</button>
            </form>
        </div>
ss

    </div>


    <div class="suggested-location-wrapper">

        <div class="suggested-locations">

            <div class="football-search">
                <p>Football</p>
                <a href="search?a=1&location=anfield">Anfield, Liverpool</a><br>
                <a href="search?a=1&location=goodison+park">Goodison Park, Liverpool</a><br>
                <a href="search?a=1&location=old+trafford">Old Trafford, Manchester</a><br>
                <a href="search?a=1&location=emirates+stadium">The Emirates, London</a>
            </div>


            <div class="sports-search">
                <p>Sports</p>
                <a href="search?a=1&location=wimbledon+tennis">Wimbledon, London</a><br>
                <a href="search?a=1&location=twickenham+stadium">Twickenham, London</a>
            </div>


            <div class="entertainment-search">
                <p>Entertainment</p>
                <a href="search?a=1&location=The+O2">The O2 Arena, London</a>
            </div>

        </div>
    </div>






</section>


<?php
    include_once 'includes/footer.php';
?>
