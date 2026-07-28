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
            <form method="post" action="login.php">
            <div class="row justify-content-md-center">
                <div class="col-md-10">
                    <div class="card">
                        <div class="card-body">

                           
                            <div class="mb-3">
                                <label for="username" class="form-label fw-medium">Username</label>
                                <input type="text" class="form-control" name="username" placeholder="Please enter your username">
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label fw-medium">Password</label>
                                <input type="password" class="form-control" name="password" placeholder="Please enter your password">
                            </div>

                            <button type="submit" class="btn btn-primary">Login</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
               
            </div>
        </div>
    </section>


    <?php 
    include_once "includes/footer.php";
    ?>
