<?php
include 'componets/connecte.php';
include 'componets/header.php';
if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    setcookie('user_id', create_unique_id(), time() + 60 * 60 * 24 * 30);
}

if (isset($_GET['id'])) {
    $get_id = $_GET['id'];
} else {
    $get_id = '';
    header('location:orders.php');
}

if (isset($user_id)) {
    $slect_pro = $pdo->prepare("SELECT *,o.id as 'id_order',o.name as 'name_order' FROM db_shop.orders o inner join db_shop.products p 
    on o.product_id = p.id where o.user_id = ? && o.id = ? LIMIT 1");
    $slect_pro->bindParam(1, $user_id);
    $slect_pro->bindParam(2, $get_id);
    $slect_pro->execute();
    $fetch_pro = $slect_pro->fetch(PDO::FETCH_ASSOC);
    $d = date_create($fetch_pro['date']);
    $grand_total = $fetch_pro['price'] * $fetch_pro['qty'];

}
if (isset($_POST['cancel'])) {
    $req = $pdo->prepare('UPDATE orders set  status =? WHERE id=?');
    $req->bindValue(1, 'cancelled');
    $req->bindParam(2, $_GET['id']);
    $req->execute();
    header('location:order_details.php');
}
if (isset($_POST['order_again'])) {
    $req = $pdo->prepare('UPDATE orders set  status =? WHERE id=?');
    $req->bindValue(1, 'in progress');
    $req->bindParam(2, $_GET['id']);
    $req->execute();
    header('location:orders.php');
}
?>

<link rel="stylesheet" href="style/order_details.css">
<div class="order_details">

    <div class="container">
        <p class="h1 text-center text-capitalize mt-5">order details</p>
        <div class="row m-5 p-3 order_details_content">
            <div class="col-12 col-sm-6">
                <p class="time">
                    <?= date_format($d, "Y:m:d") ?>
                </p>
                <div class="image">
                    <img src="./img/<?= $fetch_pro['image'] ?>" class="img-fluid mt-2" alt="">
                    <p class="mt-2 text-capitalize">
                        <?= $fetch_pro['name'] ?>
                    </p>
                </div>
                <div>
                    <p class="price text-danger">
                        <?= $fetch_pro['price'] ?> x
                        <?= $fetch_pro['qty'] ?> dh
                    </p>
                    <div class="grand_total d-flex justify-content-between align-items-center">
                        <p>grand total :</p>
                        <p>
                            <?= $grand_total; ?> dh
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-6  adress">
                <p class="text-center text-capitalize fw-bold">customer information :</p>
                <p>
                    <?= $fetch_pro['name_order'] ?>
                </p>
                <p>
                    <i class="fa-solid fa-phone"></i>
                    <?= $fetch_pro['number'] ?>
                </p>
                <p>
                    <?= $fetch_pro['email'] ?>
                </p>
                <p>
                    <i class="fa-solid fa-address-card"></i>
                    <?= $fetch_pro['address'] ?>
                </p>
                <p class="">
                    <?= $fetch_pro['status'] ?>
                </p>
                <?php if ($fetch_pro['status'] == 'cancelled'): ?>
                <button class="btn btn-warning text-white w-100 p-2" data-bs-toggle="modal"
                    data-bs-target="#exampleModal2">order
                    again</button>
                <?php elseif ($fetch_pro['status'] == 'delivered'): ?>
                <button class="btn btn-secondary text-white w-100 p-2"
                    onclick='swal(" this product is already delivered", "" ,"info");'>cancel
                    order</button>
                <?php else: ?>
                <button class="btn btn-danger w-100 p-2" data-bs-toggle="modal" data-bs-target="#exampleModal">cancel
                    order</button>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
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
                    <input type="submit" value="Yes" name="cancel" class="btn btn-se w-100 p-2 bg-danger text-white ">
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal2 order again -->
<div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">order again</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                are you sure ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">cancel</button>
                <form action="" method="POST">
                    <input type="submit" value="Yes" name="order_again"
                        class="btn btn-se w-100 p-2 bg-danger text-white ">
                </form>
            </div>
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/componets/footer.php'; ?>