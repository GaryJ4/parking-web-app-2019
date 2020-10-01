<?php
session_start();

//Check that Departure date is later than or equal to Arrival date
$arrdatecheck = new DateTime($_GET['arrdate']);
$depdatecheck = new DateTime($_GET['depdate']);
$arrtimecheck = $_GET['arrtime'];
$deptimecheck = $_GET['deptime'];
$templocation = $_GET['location'];
if ($depdatecheck < $arrdatecheck) {
    header("Location: search?location=$templocation&date=incorrect");
    exit();
} else if ($depdatecheck == $arrdatecheck && $arrtimecheck >= $deptimecheck) {
    header("Location: search?location=$templocation&time=incorrect");
    exit();
}

$url= explode('/', $_SERVER['REQUEST_URI']);
$gobackurl = $url[2];

$_SESSION['url'] = $gobackurl;

$pageTitle = "Search - ";
include_once 'includes/headerwithmapjs.inc.php';
?>


<script>
    $(function(){
        var dtToday = new Date();

        var month = dtToday.getMonth() + 1;
        var day = dtToday.getDate();
        var year = dtToday.getFullYear();
        if(month < 10)
            month = '0' + month.toString();
        if(day < 10)
            day = '0' + day.toString();

        var minDate = year + '-' + month + '-' + day;

        $('#arrdate').attr('min', minDate);

    });


    function setMinDepDate() {

        var minDepDate = document.getElementById("arrdate");
        console.log(minDepDate);
        $('#depdate').attr('min', minDepDate);
    }



</script>

    <section class="main-container">

        <div class="main-wrapper">

            <h2>Search</h2>

            <?php
            //If Location is set in URL then run script to get Location lat and lon
            if (isset($_GET['location']) && !empty($_GET['location'])) {
            include 'includes/searchbylocation.inc.php';
            ?>

            <p>Location: <?php echo $name ?></p>

            <div id='search-for-map'></div>


            <div class="search-date-time-container">
                <form method="GET" action="search">
                    <input type="hidden" name="location" value="<?php echo $_GET['location']?>">

                    <div class="date-time-details">
                        <label>Arrival Date/Time</label>
                        <input type="date" class="selectdate" id="arrdate" name="arrdate" <?php if (isset($_GET['arrdate'])) { echo 'value="'.$_GET['arrdate'].'"';} ?> required>

                        <input type="time" class="selecttime" min="00:00" max="23:59" name="arrtime" <?php if (isset($_GET['arrtime'])) { echo 'value="'.$_GET['arrtime'].'"';} ?> required onblur="setMinDepDate();">
                    </div>

                    <div class="date-time-details">
                        <label>Departure Date/Time</label>
                        <input type="date" class="selectdate" name="depdate" id="depdate" <?php if (isset($_GET['depdate'])) { echo 'value="'.$_GET['depdate'].'"';} ?> required>

                        <input type="time" class="selecttime" min="00:00" max="23:59" name="deptime" <?php if (isset($_GET['deptime'])) { echo 'value="'.$_GET['deptime'].'"';} ?> required>
                    </div>

                    <button class="btn btn-default" type="submit">Check Availability</button>
                </form>

            </div>

        </div>


        <?php }
        // Else display Form for user to enter Location and Date/Time
        else { ?>
            <div class="search-for-location">
                <form action="search" method="GET">
                    <label>Where do you want to park?</label>
                    <input type="text" name="location" placeholder="Enter a place name" required>

                    <button type="submit" class="search-for-location-submit">Search</button>
                </form>

            </div>

        <?php }
        ?>


        </div>

    </section>



<?php
if (isset($_GET['location']) && !empty($_GET['location'])) {
    ?>
    <script>
        L.mapbox.accessToken = 'pk.eyJ1IjoiZ2FyeWphY2tzb253ZWJkZXYiLCJhIjoiY2psMmZ3OTAzMWw0ZTN2b2RtOGY3c3ljNyJ9.OAtbcB_fxo1HY0nit_-PZw';
        var map = L.mapbox.map('search-for-map', 'mapbox.streets')
            .setView([<?php echo $latitude?>, <?php echo $longitude?>], <?php if (!isset($_GET['a'])) {echo 13;} else { echo 14.5;}?>);



        var myLayer = L.mapbox.featureLayer().addTo(map);
        var myLayer1 = L.mapbox.featureLayer().addTo(map);



        <?php

        $userid = $_SESSION['u_id'];

        // If Arrival/Departure Date parameters are not set show all properties
        if (!isset($_GET['arrdate']) && !isset($_GET['depdate'])) {
        //Used to show only properties which are 'live' which is availability_type=true
        $sql = "SELECT properties.* FROM properties WHERE properties.availability_type=true";
        $result = mysqli_query($conn, $sql);
        $i = 1;
        ?>

        // The GeoJSON representing the two point features
        var geojson = {
            type: 'FeatureCollection',
            features: [<?php while ($row = mysqli_fetch_array($result)) {
                ?>{
                type: 'Feature',
                properties: {
                    'marker-color': '#f86767',
                    'marker-size': 'large',
                    'marker-symbol': 'car',
                    url: "viewproperty?id=<?php echo $row['slug']; if (isset($_GET['arrdate']) && isset($_GET['depdate'])) { ?>&arrdate=<?php echo $_GET['arrdate']?>&arrtime=<?php echo $_GET['arrtime']?>&depdate=<?php echo $_GET['depdate']?>&deptime=<?php echo $_GET['deptime']; }?>"
                },
                geometry: {
                    type: 'Point',
                    coordinates: [<?php echo $row['longitude'] ?>, <?php echo $row['latitude'] ?>]
                }
            }<?php if (mysqli_num_rows($result) != $i) { ?>,
                <?php $i++;
                } else {
                ?>]
        };
        <?php }
        }

        //Else if Arrival/Departure Date parameters set check bookings and only show available properties
        } else {

        $arrdate = $_GET['arrdate'];
        $depdate = $_GET['depdate'];


        //Select available properties which already have at least one booking occuring between user's desired check in/out date
        $sql = "SELECT properties.*, COUNT(bookings.property_id) AS number_of_bookings 
                FROM properties LEFT JOIN bookings ON properties.id = bookings.property_id WHERE (bookings.check_in_date 
                BETWEEN '$arrdate' AND '$depdate') OR (bookings.check_out_date BETWEEN '$arrdate' AND '$depdate') 
                OR (bookings.check_in_date IS NULL AND bookings.check_out_date IS NULL)
                AND properties.availability_type=true
                GROUP BY properties.id HAVING number_of_bookings < properties.car_space_count ORDER BY number_of_bookings ";

        $result = mysqli_query($conn, $sql);


        $i = 1;
        
        if (mysqli_num_rows($result) > 0 ) { ?>

        var geojson = {
            type: 'FeatureCollection',
            features: [<?php while ($row = mysqli_fetch_array($result)) {
                if ($row['number_of_bookings'] < $row['car_space_count']) { ?>{
                type: 'Feature',
                properties: {
                    'marker-color': '#f86767',
                    'marker-size': 'large',
                    'marker-symbol': 'car',
                    url: "viewproperty?id=<?php echo $row['slug']; if (isset($_GET['arrdate']) && isset($_GET['depdate'])) { ?>&arrdate=<?php echo $_GET['arrdate']?>&arrtime=<?php echo $_GET['arrtime']?>&depdate=<?php echo $_GET['depdate']?>&deptime=<?php echo $_GET['deptime']; }?>"
                },
                geometry: {
                    type: 'Point',
                    coordinates: [<?php echo $row['longitude'] ?>, <?php echo $row['latitude'] ?>]
                }
            }<?php } if (mysqli_num_rows($result) != $i) { ?>,
                <?php $i++;
                }  else {
                ?>]
        };
        <?php }
        }


        } ?>

                <?php

                    $sql1 = "SELECT * FROM properties AS p
                            WHERE NOT EXISTS (SELECT * FROM bookings AS b WHERE p.id = b.property_id 
                            AND ('$arrdate' BETWEEN b.check_in_date and b.check_out_date
                            OR '$depdate' BETWEEN b.check_in_date and b.check_out_date))
                            AND properties.availability_type=true";

                    $result1 = mysqli_query($conn, $sql1);
                        $i = 1;

                        $resultCheck = mysqli_num_rows($result1);
                        if ($resultCheck > 0 ) {
                ?>

                var geojson1 = {
            type: 'FeatureCollection',
            features: [<?php while ($row = mysqli_fetch_array($result1)) { ?>{
                type: 'Feature',
                properties: {
                    'marker-color': '#f86767',
                    'marker-size': 'large',
                    'marker-symbol': 'car',
                    url: "viewproperty?id=<?php echo $row['slug']; if (isset($_GET['arrdate']) && isset($_GET['depdate'])) { ?>&arrdate=<?php echo $_GET['arrdate']?>&arrtime=<?php echo $_GET['arrtime']?>&depdate=<?php echo $_GET['depdate']?>&deptime=<?php echo $_GET['deptime']; }?>"
                },
                geometry: {
                    type: 'Point',
                    coordinates: [<?php echo $row['longitude'] ?>, <?php echo $row['latitude'] ?>]
                }
            }<?php  if (mysqli_num_rows($result1) != $i) { ?>,
                <?php $i++;
                }  else {
                ?>]
        };
        <?php }
        }
        }



        }
        ?>


        if (typeof geojson !== 'undefined') {
            myLayer.setGeoJSON(geojson);
            myLayer.on('click', function(e) {
                window.open(e.layer.feature.properties.url, "_self");
            });
        }

        if (typeof geojson1 !== 'undefined') {
            myLayer1.setGeoJSON(geojson1);
            myLayer1.on('click', function(e) {
                window.open(e.layer.feature.properties.url, "_self");
            });
        }




        L.marker([<?php echo $latitude?>, <?php echo $longitude?>], {
            icon: L.mapbox.marker.icon({
                'marker-size': 'large',
                'marker-symbol': 'marker',
                'marker-color': '#c171f7'
            })
        }).addTo(map);

    </script>
    <?php

}


?>

<?php
include_once 'includes/footer.php';
?>