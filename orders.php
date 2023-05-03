<?php
include 'componets/connecte.php';
include 'componets/header.php';
if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    setcookie('user_id', create_unique_id(), time() + 60 * 60 * 24 * 30);
}
if (isset($user_id)) {
    $slect_order = $pdo->prepare('SELECT * FROM orders where user_id = ?');
    $slect_order->bindParam(1, $user_id);
    $slect_order->execute();

}
?>
<link rel="stylesheet" href="style/orders.css">
<div class="my_orders">
    <div class="container">
        <p class="text-center h1 mt-5">my orders</p>
        <div class="row pb-5 pt-5">
            <?php
            if ($slect_order->rowCount() > 0) {
                while ($fetch_order = $slect_order->fetch(PDO::FETCH_ASSOC)) {
                    $slect_product = $pdo->prepare('SELECT * FROM products where id = ?');
                    $slect_product->bindParam(1, $fetch_order['product_id']);
                    $slect_product->execute();
                    while ($fetch_product = $slect_product->fetch(PDO::FETCH_ASSOC)) {
                        $d = date_create($fetch_order['date']);
                        ?>

            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="box p-3 mb-3 border">
                    <a href="order_details?id=<?= $fetch_order['id'] ?>" class="text-decoration-none">
                        <p class="time">
                            <?= date_format($d, "Y:m:d") ?>
                        </p>
                        <div class="image">
                            <img src="./img/<?= $fetch_product['image'] ?>" class="img-fluid mt-2" alt="">
                        </div>
                        <div class="box-info">
                            <p class="mt-2 text-capitalize text-dark">
                                <?= $fetch_product['name'] ?>
                            </p>
                            <p class="price text-danger">
                                <?= $fetch_product['price'] ?> x
                                <?= $fetch_order['qty'] ?> dh
                            </p>
                            <p class="price text-dark">
                                <?= $fetch_order['status'] ?>
                            </p>
                        </div>
                    </a>
                </div>
            </div>
            <?php
                    }

                }
            } else {
                echo "no order found";
            }
            ?>
        </div>
    </div>
</div>