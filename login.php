<?php
include_once "includes/header.php";

?>

<header class="bg-primary text-white text-center py-5 bg-gradient">
        <div class="container">
            <h1>Login</h1>
            <p class="lead">Login Page</p>
        </div>
</header>

    <section class="py-5">
        <div class="container">
            <div class="row text-center">
          
            <div class="row justify-content-md-center">
                <div class="col-md-10">
                    <div class="card">
                        <div class="card-body">

<form method="POST" action="login_proses.php"> 
<div class="mb-3">
<label for="username" class="form-label fw-medium">NRIC</label>
<input type="text" class="form-control" name="nric" placeholder="Please enter your ic number">
</div>
<div class="mb-3">
<label for="password" class="form-label fw-medium">Password</label>
<input type="password" class="form-control" name="password" placeholder="Please enter your password">
</div>
<button type="submit" class="btn btn-primary">Login</button>
</form>
                        </div>
                    </div>
                </div>
            </div>
   
               
            </div>
        </div>
    </section>


    <?php 
    include_once "includes/footer.php";
    ?>
