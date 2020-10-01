<?php

session_start();

if (isset($_SESSION['u_id'])) {
    header('Location: index');
    exit();
}

$pageTitle = 'Signup to Park And Guide';
include_once 'includes/minifiedheader.php';
?>


<section class="main-container">

    <div class="main-wrapper">


        <div class="form-container">
            <form class="login-signup-form" action="includes/registration.inc.php" method="POST" autocomplete="off">
                <input type="text" name="firstName" title="First Name" placeholder="First Name">

                <input type="text" name="lastName" title="Last Name" placeholder="Last Name">

                <input type="email" name="email" title="Email" placeholder="Email">

                <input type="password" name="password" title="Password" placeholder="Password">

                <label>Date of Birth
                    <input type="date" name="dateOfBirth" title="Date of birth">
                </label>

                <button type="submit" name="submit">Register</button>
            </form>

        </div>










    </div>


</section>


<?php
include_once 'includes/footer.php';
?>
