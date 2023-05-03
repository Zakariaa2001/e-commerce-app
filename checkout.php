<?php
include 'componets/connecte.php';
include 'componets/header.php';
if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    setcookie('user_id', create_unique_id(), time() + 60 * 60 * 24 * 30);
}
if (isset($_GET['product_id'])) {
    $get_id = $_GET['product_id'];
    $qty = $_GET['qty'];
} else {
    $get_id = '';
}

if (isset($_POST['place_order'])) {
    $verify_cart = $pdo->prepare('SELECT * FROM cart WHERE user_id = ?');
    $verify_cart->bindParam(1, $user_id);
    $verify_cart->execute();
    if (isset($_GET['product_id'])) {
        $product_id = $_GET['product_id'];
        $get_product = $pdo->prepare('SELECT * FROM products WHERE id = ? LIMIT 1');
        $get_product->bindParam(1, $product_id);
        $get_product->execute();
        if ($get_product->rowCount() > 0) {
            while ($fetch_p = $get_product->fetch(PDO::FETCH_ASSOC)) {
                $adress = $_POST['address'] . ', ' . $_POST['street'] . ', ' . $_POST['city'] . ', ' . $_POST['country'] . ', ' . $_POST['pin_code'];
                $get_order = $pdo->prepare('INSERT INTO orders(id,user_id,name,number,email,address,address_type,method,product_id,price,qty) VALUES (?,?,?,?,?,?,?,?,?,?,?)');
                $get_order->execute([
                    create_unique_id(),
                    $user_id, $_POST['name'],
                    $_POST['number'], $_POST['email'],
                    $adress, $_POST['address_type']
                    , $_POST['method'],
                    $product_id,
                    $fetch_p['price'],
                    $_GET['qty'],
                ]);
                header("location:orders.php");
            }
        } else {
            echo "somthing is wrong!!";
        }
    } elseif ($verify_cart->rowCount() > 0) {
        while ($get_cart = $verify_cart->fetch(PDO::FETCH_ASSOC)) {
            $adress = $_POST['address'] . ', ' . $_POST['street'] . ', ' . $_POST['city'] . ', ' . $_POST['country'] . ', ' . $_POST['pin_code'];
            $insert_order = $pdo->prepare('INSERT INTO orders(id,user_id,name,number,email,address,address_type,method,product_id,price,qty) VALUES (?,?,?,?,?,?,?,?,?,?,?)');
            $insert_order->execute([
                create_unique_id(),
                $user_id, $_POST['name'],
                $_POST['number'], $_POST['email'],
                $adress, $_POST['address_type']
                , $_POST['method'],
                $get_cart['product_id'],
                $get_cart['price'],
                $get_cart['qty'],
            ]);
            header("location:orders.php");
        }
        if ($insert_order) {
            $empty_cart = $pdo->prepare('DELETE FROM cart WHERE user_id = ?');
            $empty_cart->execute([$user_id]);
        } else {
            $warring_msg[] = "something went wrong ";

        }

    } else {
        $warring_msg[] = "you cart is empty";
    }
}

?>

<link rel="stylesheet" href="./style/checkout.css">
<div class="summary pt-5 pb-5">
    <h2 class="text-center mb-3">checkout summary</h2>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <form method="post" action="" class="border p-4">
                    <h3 class="text-center">Billing Details</h3>
                    <div class="d-flex justify-content-between gap-3">
                        <div class="w-50 ">
                            <label for="" class="form-label">enter your name</label>
                            <input type="text" name="name" class="form-control">
                            <label for="" class="form-label">enter your email</label>
                            <input type="text" name="email" class="form-control">
                            <label for="" class="form-label">enter your number</label>
                            <input type="number" maxlength="10" min="0" name="number" class="form-control">
                            <label for="" class="form-label">payment method</label>
                            <select class="form-select" name="method" class="input" required>
                                <option value="cash on delivery">cash on delivery</option>
                                <option value="credit or debit card">credit or debit card</option>
                                <option value="net banking">net banking</option>
                                <option value="UPI or wallets">UPI or RuPay</option>
                            </select>
                            <label for="" class="form-label">enter adress type</label>
                            <select class="form-select" name="address_type" class="input" required>
                                <option value="home">home</option>
                                <option value="office">office</option>
                            </select>
                        </div>
                        <div class="w-50">
                            <label for="" class="form-label">address line 01</label>
                            <input type="text" name="address" class="form-control">
                            <label for="" class="form-label">address line 02</label>
                            <input type="text" name="street" class="form-control">
                            <label for="" class="form-label">city name </label>
                            <input type="text" name="city" class="form-control">
                            <label for="" class="form-label">country name </label>
                            <input type="text" name="country" class="form-control">
                            <label for="" class="form-label">pin code</label>
                            <input type="text" name="pin_code" class="form-control">
                        </div>
                    </div>
                    <input type="submit" value="place order" name="place_order" class="btn text-light bg-primary">
                </form>
            </div>
            <div class="col-md-4">
                <div class="price border p-3">
                    <h3>Total items</h3>
                    <?php
                    $grand_total = 0;
                    if ($get_id != '') {
                        $req = $pdo->prepare('SELECT * FROM products WHERE id = ?');
                        $req->execute([$get_id]);
                        if ($req->rowCount() > 0) {
                            while ($fetch_product = $req->fetch(PDO::FETCH_ASSOC)) {
                                $grand_total = $fetch_product['price'] * $qty;
                                ?>
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <td class="w-25">
                                    <img src="img/<?= $fetch_product['image'] ?>" class="img-fluid" alt="">
                                </td>
                                <td>
                                    <?= $fetch_product['name'] ?> <br>
                                    <span class="text-danger">
                                        <?= $fetch_product['price'] ?> dh x
                                        <?= $qty ?>
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <?php } ?>
                    <?php
                        } else {
                            echo '<p class="empty">no product found</p>';
                        }
                    } else {
                        $select_cart = $pdo->prepare('SELECT * FROM cart WHERE user_id = ?');
                        $select_cart->bindParam(1, $user_id);
                        $select_cart->execute();
                        if ($select_cart->rowCount() > 0) {

                            while ($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)) {
                                $select_pro = $pdo->prepare('SELECT * FROM products WHERE id = ?');
                                $select_pro->bindParam(1, $fetch_cart['product_id']);
                                $select_pro->execute();
                                if ($select_pro->rowCount() > 0) {
                                    while ($fetch_pro = $select_pro->fetch(PDO::FETCH_ASSOC)) {
                                        $sub_total = ($fetch_pro['price'] * $fetch_cart['qty']);
                                        $grand_total += $sub_total;
                                        ?>
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <td class="w-25">
                                    <img src="img/<?= $fetch_pro['image'] ?>" class="img-fluid" alt="">
                                </td>
                                <td>
                                    <?= $fetch_pro['name'] ?> <br>
                                    <span class="text-danger">
                                        <?= $fetch_pro['price'] ?> dh x
                                        <?= $fetch_cart['qty'] ?>
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <?php
                                    }
                                } else {

                                }
                            }
                        } else {

                        }
                    }
                    ?>
                    <div class="grand_total d-flex justify-content-between align-items-center">
                        <p>total :</p>
                        <p>
                            <?= $grand_total; ?> dh
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>