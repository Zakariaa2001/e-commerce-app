<?php
include 'componets/connecte.php';
include 'componets/header.php';
if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    setcookie('user_id', create_unique_id(), time() + 60 * 60 * 24 * 30);
}
if (isset($_POST['update_cart'])) {
    $id_cart = $_POST['cart_id'];
    $req = $pdo->prepare('UPDATE cart SET qty = ? where id = ?');
    $req->bindParam(1, $_POST['qty']);
    $req->bindParam(2, $id_cart);
    $req->execute();
    $success_msg[] = "update cart with succes";
}
if (isset($_POST['delete_cart'])) {
    $id_cart = $_POST['cart_id'];
    $req = $pdo->prepare('DELETE from cart where id = ?');
    $req->bindParam(1, $id_cart);
    $req->execute();
    $success_msg[] = "delete cart with succes";
}
if (isset($_POST['empt_cart'])) {
    $req = $pdo->prepare('DELETE from cart');
    $req->execute();
    $success_msg[] = "detete with succes";
}
?>

<link rel="stylesheet" href="style/shopping_cart.css">
<section class="mt-5 mb-5">
    <div class="container">
        <h1 class="text-center mb-3">cart products</h1>
        <div class="row">
            <?php
            $grand_total = 0;
            $select_cart = $pdo->prepare("SELECT * FROM cart WHERE user_id = ?");
            $select_cart->execute([$user_id]);
            if ($select_cart->rowCount() > 0) {
                while ($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)) {
                    $select_product = $pdo->prepare("SELECT * FROM products WHERE id = ?");
                    $select_product->execute([$fetch_cart['product_id']]);
                    if ($select_product->rowCount() > 0) {
                        while ($fetch_product = $select_product->fetch(PDO::FETCH_ASSOC)) {


                            ?>
            <div class="box border mx-3 p-2  col-lg-3 col-md-3 col-sm-6 mb-4">
                <form action="" method="post">
                    <div class="image text-center">
                        <img src="./img/<?= $fetch_product['image'] ?>" class="img-fluid" alt="">
                        <h2 class="mt-2 text-start">
                            <?= $fetch_product['name'] ?>
                        </h2>
                        <input type="hidden" name="cart_id" value="<?= $fetch_cart['id'] ?>">
                    </div>
                    <div class="text w-100 mb-3 border-3 d-flex justify-content-between">
                        <div class="price">
                            <p class="text-danger mb-0">
                                <?= $fetch_product['price'] ?><span class="ms-1">dh</span>
                            </p>
                            <p class="sub-qty">
                                sub total :
                                <span class="text-danger">
                                    <?= $sub_total = ($fetch_product['price'] * $fetch_cart['qty']); ?>
                                    dh
                                </span>
                            </p>
                        </div>
                        <div class="qt">
                            <input type="number" class="border-1 text-center" name="qty" minlength="2" min="1" max="99"
                                value="<?= $fetch_cart['qty']; ?>" required>
                            <button type="submit" class="bi bi-pencil-square " name="update_cart"></button>
                        </div>
                    </div>
                    <input type="submit" name="delete_cart" value="Delete"
                        class="add-cart w-100 btn btn-danger"></input>
                </form>
            </div>
            <?php
                            $grand_total += $sub_total;
                        }
                    } else {
                        echo '<p class="empty text-center">no product found</p>';
                    }
                }
            } else {
                echo '<p class="empty text-center text-danger fs-2">no cart found</p>';
            }
            ?>

        </div>
    </div>
    <?php if ($grand_total != 0) { ?>
    <div class="grand_total text-center border w-25 p-3 mt-2">
        <p>grand total :
            <span class="danger">
                <?= $grand_total; ?> dh
            </span>
        </p>
        <a href="checkout.php" class="w-100 mb-2 btn btn-primary">proceed to check out</a>
        <button class="btn btn-danger w-100 p-2" data-bs-toggle="modal" data-bs-target="#exampleModal">empty
            cart</button>

    </div>
    <?php } ?>
</section>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Delete</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                are you sure ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">cancel</button>
                <form action="" method="POST">
                    <input type="submit" value="yes" name="empt_cart" class="btn btn-danger w-100 p-2">
                </form>
            </div>
        </div>
    </div>
</div>
<?php include 'componets/footer.php'; ?>