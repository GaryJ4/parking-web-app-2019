<?php
session_start();

$_SESSION['url'] = 'addproperty';
include 'includes/accesscheck.inc.php';

$pageTitle =  "Add New Property - ";
include_once 'includes/header.php';


?>

<section class="main-container">

    <div class="main-wrapper">

        <h2>Add New Property</h2>



        <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
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

                    var country = document.getElementById('country').value;

                    console.log(country);

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



        <form action="includes/newproperty.inc.php" class="signup-form" method="POST" autocomplete="off">

            <div class="new-property-group-1">

                <div class="new-property-input">
                    <input type="text" name="name" placeholder="Property Name" required/>
                </div>

                <div class="new-property-input">
                    <textarea type="text" name="description" rows="4"  placeholder="Description" required></textarea>
                </div>

                <div class="new-property-input">
                    <input type="number" min="0" name="car-count" placeholder="Car Space" required/>
                </div>

                <div class="new-property-input">
                    <input type="number" min="0.00" max="10000.00" step="0.01" name="price" placeholder="Price per day" required/>
                </div>
            </div>

            <div class="new-property-group-2">

                <div class="new-property-input">
                    <input type="text" name="address" id="address" placeholder="Address" required/>
                </div>
                <div class="search-city">
                    <input type="text" name="city" id="city" autocomplete="off" placeholder="Town/City" required/>
                    <div class="result-city"></div>
                </div>

                <div class="search-county">
                    <input type="text" name="county" id="county" autocomplete="off" placeholder="County" required/>
                    <div class="result-county"></div>
                </div>

                <div class="search-country">
                    <input type="text" name="country" id="country" autocomplete="off" placeholder="Country" required/>
                    <div class="result-country"></div>
                </div>

                <div class="new-property-input">
                    <input type="text" name="postcode" placeholder="Postcode" required/>
                </div>
            </div>


            <div class="new-property-button">
                <button type="submit" class="btn btn-default" id="add-new-property-button" name="submit">Add New Property</button>
            </div>
        </form>



    </div>


</section>






















<?php
include_once 'includes/footer.php';
?>
