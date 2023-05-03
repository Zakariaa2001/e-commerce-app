<?php
include 'componets/connecte.php';

if (isset($_POST['fullname'])) {
    $error_msg = "";
    $check = $pdo->prepare('SELECT * FROM users WHERE email=?');
    $check->bindParam(1, $_POST['email']);
    $check->execute();
    if ($check->rowcount() > 0) {
        $error_msg = "Email existe déja";
    } else {
        if ($_POST['password'] != $_POST['repeat_password']) {
            $error_msg = "password invalid";
        } else {
            $password = password_hash($_POST['password'], PASSWORD_ARGON2I);
            $req = $pdo->prepare('INSERT INTO users (fullname,email,password) values (?,?,?)');
            $req->bindParam(1, $_POST['fullname']);
            $req->bindParam(2, $_POST['email']);
            $req->bindParam(3, $password);
            $req->execute();
            header('location:login.php');
        }
    }

}
?>
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
<section class="vh-100" style="background-color: #eee;">
    <div class="container h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-lg-12 col-xl-11">
                <div class="card text-black" style="border-radius: 25px;">
                    <div class="card-body p-md-5">
                        <div class="row justify-content-center">
                            <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">

                                <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Sign up</p>

                                <form class="mx-1 mx-md-4" method="post">

                                    <div class="d-flex flex-row align-items-center mb-4">
                                        <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                                        <div class="form-outline flex-fill mb-0">
                                            <label class="form-label" for="name">Your full Name</label>
                                            <input type="text" id="name" name="fullname" class="form-control" />
                                        </div>
                                    </div>

                                    <div class="d-flex flex-row align-items-center mb-4">
                                        <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                                        <div class="form-outline flex-fill mb-0">
                                            <label class="form-label" for="email">Your Email</label>
                                            <input type="email" id="email" name="email" class="form-control" />
                                        </div>
                                    </div>

                                    <div class="d-flex flex-row align-items-center mb-4">
                                        <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                                        <div class="form-outline flex-fill mb-0">
                                            <label class="form-label" for="password">Password</label>
                                            <input type="password" id="password" name="password" class="form-control" />
                                        </div>
                                    </div>

                                    <div class="d-flex flex-row align-items-center mb-4">
                                        <i class="fas fa-key fa-lg me-3 fa-fw"></i>
                                        <div class="form-outline flex-fill mb-0">
                                            <label class="form-label" for="repeat_password">Repeat your password</label>
                                            <input type="password" id="repeat_password" name="repeat_password"
                                                class="form-control" />
                                            <?php if (isset($error_msg)): ?>
                                            <p style="background-color: #db9f9f6b;" class="text-danger mt-1 p-3">
                                                <?= $error_msg; ?>
                                            </p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                                        <button type="submit" class="btn btn-primary btn-lg">Sign up</button>
                                    </div>

                                </form>

                            </div>
                            <div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-2">

                                <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.webp"
                                    class="img-fluid" alt="Sample image">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>