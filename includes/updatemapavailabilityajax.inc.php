<?php
if (isset($_GET['location']) && !empty($_GET['location'])) {
    ?>
    <script>
        L.mapbox.accessToken = 'pk.eyJ1IjoiZ2FyeWphY2tzb253ZWJkZXYiLCJhIjoiY2psMmZ3OTAzMWw0ZTN2b2RtOGY3c3ljNyJ9.OAtbcB_fxo1HY0nit_-PZw';
        var map = L.mapbox.map('search-for-map', 'mapbox.streets')
            .setView([<?php echo $latitude?>, <?php echo $longitude?>], <?php if (!isset($_GET['a'])) {echo 13;} else { echo 14.5;}?>);



        var myLayer = L.mapbox.featureLayer().addTo(map);


        <?php

        $userid = $_SESSION['u_id'];
        //Used to show every property - Testing environment
        //$sql = "SELECT cities.cityname, properties.* FROM cities, properties WHERE properties.city_id = cities.id";

        $sql = "SELECT properties.*, properties.id, COUNT(*) FROM properties INNER JOIN bookings ON properties.id = bookings.property_id 
            WHERE (bookings.check_in_date BETWEEN '$arrdate'AND '$depdate') OR (bookings.check_out_date BETWEEN '$arrdate' AND '$depdate') 
            GROUP BY id";


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
                    title: "<?php echo $row['name'] ?>",
                    description: "<?php echo $row['description']?><br>Price: £<?php echo $row['price']?>",
                    'marker-color': '#f86767',
                    'marker-size': 'large',
                    'marker-symbol': 'car',
                    url: "viewproperty?id=<?php echo $row['slug']?>&city=<?php echo $row['city_name'] ?>"
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
        } ?>


        // Pass features and a custom factory function to the map
        myLayer.setGeoJSON(geojson);


        myLayer.on('click', function(e) {
            window.open(e.layer.feature.properties.url);
        });


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