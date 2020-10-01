<?php
session_start();


$url= explode('/', $_SERVER['REQUEST_URI']);
$gobackurl = $url[2];

$_SESSION['url'] = $gobackurl;

include 'includes/editpropertyaccesscheck.inc.php';


$pageTitle =  "Edit Property - ";
include_once 'includes/header.php';

include 'includes/populateviewproperty.inc.php';
?>

<section class="main-container">

    <div class="main-wrapper">

        <h2>Edit Property</h2>



        <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
        <script type="text/javascript">


            $(document).ready(function() {
                $('#propertyname').val("<?php echo $propertyname ?>");
                $('#propertydescription').val("<?php echo $description ?>");
                $('#car-count').val("<?php echo $car_space_count ?>");
                $('#price').val("<?php echo $priceperday ?>");
                $('#address').val("<?php echo $address ?>");
                $('#city').val("<?php echo $city ?>");
                $('#county').val("<?php echo $county?>");
                $('#country').val("<?php echo $country ?>");
                $('#postcode').val("<?php echo $postcode ?>");




            });
        </script>



        <script type="text/javascript">


            //Search by Country
            $(document).ready(function(){
                $('.search-country input[type="text"]').on("keyup input", function(){
                    /* Get input value on change */
                    var inputVal = $(this).val();
                    var resultDropdown = $(this).siblings(".result-country");
                    if(inputVal.length){
                        $.get("includes/findCountryByName.inc.php", {term: inputVal}).done(function(data){
                            // Display the returned data in browser
                            resultDropdown.html(data);
                        });
                    } else{
                        resultDropdown.empty();
                    }
                });

                // Set search input value on click of result item
                $(document).on("click", ".result-country p", function(){
                    $(this).parents(".search-country").find('input[type="text"]').val($(this).text());
                    $(this).parent(".result-country").empty();

                });
            });
        </script>


        <script type="text/javascript">

            //Search by County
            $(document).ready(function(){
                $('.search-county input[type="text"]').on("keyup input", function(){
                    /* Get input value on change */
                    var inputVal = $(this).val();
                    var resultDropdown = $(this).siblings(".result-county");
                    if(inputVal.length){
                        $.get("includes/findCountyByName.inc.php", {term1: inputVal}).done(function(data){
                            // Display the returned data in browser
                            resultDropdown.html(data);
                        });
                    } else{
                        resultDropdown.empty();
                    }
                });

                // Set search input value on click of result item
                $(document).on("click", ".result-county p", function(){
                    $(this).parents(".search-county").find('input[type="text"]').val($(this).text());
                    $(this).parent(".result-county").empty();
                });
            });


        </script>


        <script type="text/javascript">

            //Search by City
            $(document).ready(function(){
                $('.search-city input[type="text"]').on("keyup input", function(){
                    /* Get input value on change */
                    var inputVal = $(this).val();
                    var resultDropdown = $(this).siblings(".result-city");
                    if(inputVal.length){
                        $.get("includes/findCityByName.inc.php", {term2: inputVal}).done(function(data){
                            // Display the returned data in browser
                            resultDropdown.html(data);
                        });
                    } else{
                        resultDropdown.empty();
                    }
                });

                // Set search input value on click of result item
                $(document).on("click", ".result-city p", function(){
                    $(this).parents(".search-city").find('input[type="text"]').val($(this).text());
                    $(this).parent(".result-city").empty();
                });
            });


        </script>



        <form action="includes/updateproperty.inc.php" class="edit-property-form" method="POST" autocomplete="off">

            <div class="edit-property-group-1">

                <div class="edit-property-input">
                    <label>Property Name</label>
                    <input type="text" name="name" id="propertyname" placeholder="Property Name" required/>
                </div>

                <div class="edit-property-input">
                    <label>Property Description</label>
                    <textarea type="text" id="propertydescription" name="description" rows="4"  placeholder="Description" required></textarea>
                </div>

                <div class="edit-property-input">
                    <label>Car Space</label>
                    <input type="number" min="0" name="car-count" id="car-count" placeholder="Car Space" required/>
                </div>

                <div class="edit-property-input">
                    <label>Price Per Day</label>
                    <input type="number" min="0.00" max="10000.00" step="0.01" name="price" id="price" placeholder="Price per day" required/>
                </div>
            </div>

            <div class="edit-property-group-2">

                <div class="edit-property-input">
                    <label>Address</label>
                    <input type="text" name="address" id="address" placeholder="Address" required/>
                </div>
                <div class="search-city">
                    <label>City</label>
                    <input type="text" name="city" id="city" autocomplete="off" placeholder="Town/City" required/>
                    <div class="result-city"></div>
                </div>

                <div class="search-county">
                    <label>County</label>
                    <input type="text" name="county" id="county" autocomplete="off" placeholder="County" required/>
                    <div class="result-county"></div>
                </div>

                <div class="search-country">
                    <label>Country</label>
                    <input type="text" name="country" id="country" autocomplete="off" placeholder="Country" required/>
                    <div class="result-country"></div>
                </div>

                <div class="edit-property-input">
                    <label>Postcode</label>
                    <input type="text" name="postcode" id="postcode" placeholder="Postcode" required/>
                </div>
            </div>

            <div class="edit-property-group-3">

                <div class="edit-property-radio">
                    <p>Have property visible in searches?</p>
                    <label for="availability">Yes</label>
                    <input type="radio" name="availability" value="2"
                           <?php if ($availability == 1) {
                           echo ' checked >';
                    } else {
                    echo '>';
                    }?>

                    <label for="availability">No</label>
                    <input type="radio" name="availability" value="1"
                           <?php if ($availability == 0) {
                           echo ' checked >';
                    } else {
                    echo '>';
                    }?>
                </div>


            </div>


            <div class="edit-property-button-container">
                <button type="submit" class="btn btn-default" id="edit-property-submit-button" name="submit">Submit Property Changes</button>
            </div>
        </form>



    </div>


</section>















<?php

$_SESSION['propertyid'] = $propertyid;


?>






<?php
include_once 'includes/footer.php';
?>
