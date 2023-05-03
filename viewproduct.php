<?php

include 'componets/connecte.php';
if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    setcookie('user_id', create_unique_id(), time() + 60 * 60 * 24 * 30);
}
$test = true;
$products = $pdo->prepare("SELECT * FROM products");
$products->execute();
if ($products->rowCount() > 0) {
    $products = $products->fetchAll(PDO::FETCH_ASSOC);
} else {
    echo "<p>no product found</p>";
}
if (isset($_POST['add_to_cart'])) {
    $id = create_unique_id();
    $product_id = $_POST['product_id'];
    $verfiy_cart = $pdo->prepare("SELECT * FROM cart where user_id = ? and product_id = ? ");
    $verfiy_cart->bindParam(1, $user_id);
    $verfiy_cart->bindParam(2, $product_id);
    $verfiy_cart->execute();
    $max_item_cart = $pdo->prepare("SELECT * FROM cart where user_id = ?");
    $max_item_cart->bindParam(1, $user_id);
    $max_item_cart->execute();

    if ($verfiy_cart->rowCount() > 0) {
        $info_msg[] = 'Already added to cart';
    } elseif ($max_item_cart->rowCount() == 10) {
        $warning_msg[] = 'Cart is full ';
    } else {
        //  $select_pro => for know price
        $select_pro = $pdo->prepare("SELECT * FROM products WHERE id = ? LIMIT 1");
        $select_pro->bindParam(1, $product_id);
        $select_pro->execute();
        $fetch_pro = $select_pro->fetch(PDO::FETCH_ASSOC);
        $insert_cart = $pdo->prepare("INSERT INTO cart(id , user_id , product_id ,price , qty) VALUES (?,?,?,?,?)");
        $insert_cart->execute([$id, $user_id, $product_id, $fetch_pro['price'], $_POST['qty']]);
        $insert_cart = $insert_cart->fetch(PDO::FETCH_ASSOC);
        $success_msg[] = 'added to cart';
    }

}
if (isset($_POST['buy_now'])) {
    header("location:checkout.php?product_id=" . $_POST['product_id'] . "&qty=" . $_POST['qty']);
}

include 'componets/header.php';
?>

<style>
/* .box {
        background-color: #e8e9d7;
    } */
.box .image img {
    height: 200px;
    width: 150;
}

.c-item {
    height: 480px;
}

.c-img {
    height: 100%;
    object-fit: cover;
    filter: brightness(0.6);
}

.slide .slider-content button {
    width: 10px;
    height: 10px;
    border-radius: 50%;
}
</style>
<!-- start slider -->
<div id="main-slider" class="carousel slide">
    <div class="carousel-indicators slider-content">
        <button type="button" data-bs-target="#main-slider" data-bs-slide-to="0" class="active" aria-current="true"
            aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#main-slider" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#main-slider" data-bs-slide-to="2" aria-label="Slide 3"></button>

    </div>
    <div class="carousel-inner">
        <div class="carousel-item active c-item">
            <img src="img/header.jpg" class="d-block w-100 c-img" alt="...">
            <h1>here</h1>
        </div>
        <div class="carousel-item c-item">
            <img src="img/header02.jpg" class="d-block w-100 c-img" alt="...">
        </div>
        <div class="carousel-item c-item">
            <img src="img/header03.jpg" class="d-block w-100 c-img" alt="image">
        </div>
    </div>
    <!-- <button class="carousel-control-prev" type="button" data-bs-target="#main-slide" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" data-bs-target="#main-slide" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
    </button> -->
</div>
<!-- end slider -->
<section class="mt-5 mb-5">
    <div class="container">
        <h1 class="text-center mb-3">All products</h1>
        <div class="row  pt-5 pb-5">
            <?php foreach ($products as $product): ?>
            <div class="box col-lg-3 col-md-4 col-sm-6 mb-4">
                <form action="" method="post">
                    <input type="hidden" name="product_id" value="<?php $product['id'] ?>">
                    <div class="image text-center">
                        <img src="./img/<?= $product['image'] ?>" class="img-fluid" alt="">
                        <h2 class="mt-2 text-start">
                            <?= $product['name'] ?>
                        </h2>
                        <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                    </div>
                    <div class="text w-100 mb-3 border-3 d-flex justify-content-between">
                        <div class="price">
                            <?= $product['price'] ?><span class="ms-1">dh</span>
                        </div>
                        <div class="qt">
                            <input type="number" class="border-1 text-center" name="qty" minlength="2" min="1" max="99"
                                value="1" required>
                        </div>
                    </div>
                    <!-- <a href="checkout.php?id=<?= $product['id']; ?>" class="buy-now w-100 mb-2 btn btn-primary">Buy
                                                                                                                                                                                                                                                                                                            now</a> -->
                    <input type="submit" name="buy_now" class="add-cart w-100 btn btn-primary mb-2"
                        value="buy now"></input>
                    <input type="submit" name="add_to_cart" class="add-cart mb-3 w-100 btn btn-danger"
                        value="add to cart"></input>
                </form>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php include 'componets/footer.php'; ?>