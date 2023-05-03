<?php
include 'componets/connecte.php';
include 'componets/header.php';

if (isset($_POST['username'])) {
    $message = "";
    $check = $pdo->prepare('SELECT * FROM users WHERE email=?');
    $check->bindParam(1, $_POST['username']);
    $check->execute();
    $user = $check->fetch(PDO::FETCH_ASSOC);
    if ($user) {
        if (password_verify($_POST['password'], $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            header('location:viewproduct.php');
            exit();
        } else {
            $error_msg[] = 'password incorrect';
        }
    } else {
        $error_msg[] = 'email incorrect';
    }
}
?>
<link rel="stylesheet" href="style/login.css">
<!-- bootstrap -->
<link rel="stylesheet" href="./bootstrap-5.0.2-dist/css/bootstrap.min.css">
<!-- font font-awesome -->
<link rel="stylesheet" href="fontawesome-free-6.2.0-web/css/all.min.css">
<!-- font google -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link
    href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;800&family=Montserrat:ital,wght@0,100;0,400;0,500;0,800;1,400&display=swap"
    rel="stylesheet">
<section class="vh-100">
    <div class="container-fluid h-custom">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-md-9 col-lg-6 col-xl-5">
                <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.webp"
                    class="img-fluid" alt="Sample image">
            </div>
            <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                <form method="post">
                    <!-- Email input -->
                    <label class="form-label" for="form3Example3">Email address</label>
                    <div class="form-outline mb-4">
                        <input type="email" id="form3Example3" class="form-control form-control-lg"
                            placeholder="Enter a valid email address" name="username" />
                    </div>

                    <!-- Password input -->
                    <div class="form-outline mb-3">
                        <label class="form-label" for="form3Example4">Password</label>
                        <input type="password" id="form3Example4" name="password" class="form-control form-control-lg"
                            placeholder="Enter password" />
                    </div>
                    <div class="text-center text-lg-start mt-4 pt-2">
                        <button type="submit" class="btn btn-primary btn-lg"
                            style="padding-left: 2.5rem; padding-right: 2.5rem;">Login</button>
                        <p class="small fw-bold mt-2 pt-1 mb-0">Don't have an account? <a href="signup.php"
                                class="link-danger">Register</a></p>
                    </div>

                </form>
            </div>
        </div>
    </div>
    <!-- <div
        class="d-flex flex-column flex-md-row text-center text-md-start justify-content-between py-4 px-4 px-xl-5 bg-primary">
        <!-- Copyright -->
    <div class="text-white mb-3 mb-md-0">
        Copyright © 2020. All rights reserved.
    </div>
    <!-- Copyright -->

    <!-- Right -->
    <div>
        <a href="#!" class="text-white me-4">
            <i class="fab fa-facebook-f"></i>
        </a>
        <a href="#!" class="text-white me-4">
            <i class="fab fa-twitter"></i>
        </a>
        <a href="#!" class="text-white me-4">
            <i class="fab fa-google"></i>
        </a>
        <a href="#!" class="text-white">
            <i class="fab fa-linkedin-in"></i>
        </a>
    </div>
    <!-- Right -->
    </div> -->
</section>
<?php include 'componets/footer.php' ?>