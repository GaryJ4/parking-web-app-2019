<?php
session_start();

include 'includes/populateviewproperty.inc.php';

//Check that Departure date is later than or equal to Arrival date
$arrdatecheck = new DateTime($_GET['arrdate']);
$depdatecheck = new DateTime($_GET['depdate']);
$arrtimecheck = $_GET['arrtime'];
$deptimecheck = $_GET['deptime'];
$tempid = $slug;
if ($depdatecheck < $arrdatecheck) {
    header("Location: viewproperty?id=$tempid&date=incorrect");
    exit();
} else if ($depdatecheck == $arrdatecheck && $arrtimecheck >= $deptimecheck) {
    header("Location: viewproperty?id=$tempid&time=incorrect");
    exit();
}


//Set Page Title to property name
if (isset($propertyname)) {
    $pageTitle = $propertyname ." - ";
} else {
    $pageTitle = $error;
}

//include_once 'includes/header-absolute-links-with-maps.inc.php';
include_once 'includes/headerwithmapjs.inc.php';
include 'includes/functions.inc.php';
?>

<script>
    function checkAvailability() {
        var arrdate = document.getElementById('arrdate');
        var depdate = document.getElementById('depdate');
        jQuery.ajax({
            type: 'POST',
            url: "includes/checkavailabilityajax.inc.php",
            data: {
                arrdate: $('#arrdate').val(),
                depdate: $('#depdate').val()
            },
            success: function (data) {
                $("#check-availability-status").html(data);
            },
            error: function () {
                alert("Fail");
            }
        });
    }

</script>


<section class="main-container">

    <div class="main-wrapper">

        <?php
        $slug = strip_tags(mysqli_real_escape_string($conn, $_GET['id']));

        $sql = "SELECT * FROM properties WHERE slug='$slug'";
        $result = mysqli_query($conn, $sql);

        $resultCheck = mysqli_num_rows($result);
        if ($resultCheck == 1) {
            $slugFound = true;

        ?>



        <div class="view-date-time-container" style="border: 4px solid #C6ECAE">
            <form method="GET"  style="padding:10px;">


                <div class="date-time-details">
                    <label>Arrival Date/Time</label>

                    <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">

                    <input type="date" class="selectdate" min="0" id="arrdate" name="arrdate" <?php if (isset($_GET['arrdate'])) { echo 'value="'.$_GET['arrdate'].'"';} ?> required>

                    <input type="time" class="selecttime" min="00:00" max="23:59" name="arrtime" <?php if (isset($_GET['arrtime'])) { echo 'value="'.$_GET['arrtime'].'"';} ?> required>
                </div>

                <div class="date-time-details">
                    <label>Departure Date/Time</label>
                    <input type="date" class="selectdate" name="depdate" id="depdate" <?php if (isset($_GET['depdate'])) { echo 'value="'.$_GET['depdate'].'"';} ?> required>

                    <input type="time" class="selecttime" min="00:00" max="23:59" name="deptime" <?php if (isset($_GET['deptime'])) { echo 'value="'.$_GET['deptime'].'"';} ?>  required>
                </div>

                <button class="btn btn-default" type="submit">Check Availability</button>
                <div id="check-availability-status"></div>

            </form>

        </div>


        <div class="property-information-container">
            <h2><?php echo $propertyname?></h2>
            <p><?php echo '<span class="heading">Property Description:</span> ' . $description?></p>
            <p><?php echo '<span class="heading">Address:</span> ' .$address.', '.$city.', '.$county.', '.$country?></p>
            <p><?php echo'<span class="heading">Hosted by:</span> ' . $hostname?></p>
            <p><?php echo '<span class="heading">Price per day:</span> £' . $priceperday?></p>

            <?php if (isset($_GET['arrdate']) && isset($_GET['depdate'])) {
                echo '<p><span class="heading">Arriving on:</span> '. changedatereverse($_GET['arrdate']).' at '.$_GET['arrtime'].'</p>';
                echo '<p><span class="heading">Departing on:</span> '. changedatereverse($_GET['depdate']).' at '.$_GET['deptime'].'</p>';

                if ($_SESSION['u_id'] != $hostid) {
                    echo '<a class="btn btn-default" href="booking">Go To Booking Page</a>';
                }
            } else {
                echo '<p style="background-color: #C6ECAE; display: inline-block">Enter your required Arrival and Departure Date and Time.</p>';
            }
            if ($_SESSION['u_id'] == $hostid) {
                echo "<p>This is your property.</p>";
            }
            ?>

        </div>

        <div id="view-property-map"></div>

        <?php } else { ?>

            <div class="property-not-found">
                <p>Property Not Found.</p>
                <a class="btn btn-default" href="index">Return Home</a>
            </div>



        <?php } ?>



    </div>

</section>




<?php
    if ($slugFound) {

?>

<script>


    L.mapbox.accessToken = 'pk.eyJ1IjoiZ2FyeWphY2tzb253ZWJkZXYiLCJhIjoiY2psMmZ3OTAzMWw0ZTN2b2RtOGY3c3ljNyJ9.OAtbcB_fxo1HY0nit_-PZw';
    var map = L.mapbox.map('view-property-map', 'mapbox.streets')
        .setView([<?php echo $latitude?>, <?php echo $longitude?>], 15);

    var myLayer = L.mapbox.featureLayer().addTo(map);



    // The GeoJSON representing the two point features
    var geojson = {
        type: 'FeatureCollection',
        features: [{
                type: 'Feature',
                properties: {
                    title: "<?php echo $propertyname ?>",
                    description: "<?php echo $description?><br>Price per day: £<?php echo $priceperday?>",
                    'marker-color': '#f86767',
                    'marker-size': 'large',
                    'marker-symbol': 'car'
                },
                geometry: {
                    type: 'Point',
                    coordinates: [<?php echo $longitude ?>, <?php echo $latitude ?>]
                }
            }]
    };

    myLayer.setGeoJSON(geojson);


</script>

<?php

}
?>


<?php

//Used to return to this page from booking page
$url= explode('/', $_SERVER['REQUEST_URI']);
$gobackurl = $url[2];


//Figure out total days
$arrdate = date_create($_GET['arrdate']);
$depdate = date_create($_GET['depdate']);
$diff = date_diff($arrdate, $depdate);
$totaldays = $diff->format("%a");

if ($totaldays == 0) {
    $totaldays = 1;
}


//Populate Session Variables For Order details to be used on booking page
$_SESSION['arrdate'] = $_GET['arrdate'];
$_SESSION['depdate'] = $_GET['depdate'];
$_SESSION['arrtime'] = $_GET['arrtime'];
$_SESSION['deptime'] = $_GET['deptime'];
$_SESSION['propertyid'] = $propertyid;
$_SESSION['propertyname'] = $propertyname;
$_SESSION['propertydescription'] = $description;
$_SESSION['address'] = $address . ", " . $city . ", " . $county . ", " . $country;
$_SESSION['totaldays'] = $totaldays;
$_SESSION['priceperday'] = $priceperday;
$_SESSION['totalprice'] = $priceperday * $totaldays;
$_SESSION['hostname'] = $hostname;
$_SESSION['hostid'] = $hostid;
$_SESSION['gobackurl'] = $gobackurl;



?>



<?php
include_once 'includes/footer.php';
?>
