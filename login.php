<?php

session_start();

if (isset($_SESSION['u_id'])) {
    header('Location: index');
    exit();
}

$pageTitle = 'Login to your account';
include_once 'includes/minifiedheader.php';
?>


<section class="main-container">

    <div class="main-wrapper">


        <div class="form-container">
            <form class="login-signup-form" action="includes/login.inc.php" method="POST" autocomplete="off">
                <input type="email" name="email" placeholder="Email" />

                <input type="password" name="password" placeholder="Password" />

                <button type="submit" name="submit">Login</button>
            </form>

            <div class="login-signup-separator"><span class="text-in-separator">or</span></div>

            <a href="register">Register</a>
        </div>










    </div>


</section>


<?php
include_once 'includes/footer.php';
?>
