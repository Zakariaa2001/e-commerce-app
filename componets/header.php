<?php
if (isset($_SESSION['user_id'])) {
    $req = $pdo->prepare("SELECT * FROM users WHERE id =?");
    $req->bindValue(1, $_SESSION['user_id']);
    $req->execute();
    $user = $req->fetch(PDO::FETCH_ASSOC);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <!-- font font-awesome -->
    <link rel="stylesheet" href="fontawesome-free-6.2.0-web/css/all.min.css">
    <!-- bootstarp icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <!-- css file-->
    <link rel="stylesheet" href="style/style.css">
    <!-- font google -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;800&family=Montserrat:ital,wght@0,100;0,400;0,500;0,800;1,400&display=swap"
        rel="stylesheet">

</head>

<body>
    <!--  -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container">
            <a class="navbar-brand text-dark" href="viewmyproduct.php">shooping store</a>
            <button class="navbar-toggler text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fa-solid fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <?php if (isset($user) && $user['role'] >= 1): ?>
                            <a class="nav-link fs-5 text-capitalize active" href="admin.php">dasborad</a>
                        <?php endif; ?>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fs-5 text-capitalize active" href="viewproduct.php">view products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fs-5 text-capitalize active" href="orders.php">my orders</a>
                    </li>
                    <li class="nav-item">
                        <?php
                        $count_cart_items = $pdo->prepare("SELECT * FROM cart WHERE user_id = ?");
                        $count_cart_items->bindParam(1, $user_id);
                        $count_cart_items->execute();
                        $total_cart_items = $count_cart_items->rowCount();

                        ?>
                        <button type="submit" class="btn btn-outline-dark me-2 cart mt-1 d-flex" type="submit">
                            <i class="fa-solid fa-cart-shopping me-1 mt-1"></i>
                            <!-- Cart
                            <span class="badge bg-dark text-white ms-1 rounded-pill">0</span> -->
                            <a class="text-decoration-none text-capitalize" aria-current="page"
                                href="shopping_cart.php">Cart<span
                                    class="badge bg-dark text-white ms-1 rounded-pill"><?= $total_cart_items; ?></span></a>
                        </button>
                    </li>
                    <li class="nav-item">
                        <?php if (isset($user)): ?>
                            <button class="btn btn-outline-dark mt-1 d-flex inscription" type="submit">
                                <a class="text-decoration-none text-capitalize" href="logout.php">log out</a>
                            </button>
                </div>
            <?php else: ?>
                <button class="btn btn-outline-dark mt-1 d-flex inscription" type="submit">
                    <a class="text-decoration-none text-capitalize" href="login.php">log in</a>
                </button>
            <?php endif; ?>

            </li>
            </ul>
            <!-- <div id="menu-btn" class="fas fa-bars"></div> -->

        </div>
        </div>
    </nav>
</body>

</html>