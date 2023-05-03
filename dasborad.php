<!-- <?php

$get_orders = $pdo->query('SELECT sum(price) as "price", count(id) as "nubOrder" from orders');
$get_orders = $get_orders->fetch(PDO::FETCH_ASSOC);

?>
<style>
    .container .card .card-text span {
        color: #566a7f;
    }
</style>
<div class="row mt-5">
    <div class="col-sm-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Orders</h5>
                <p class="card-text fs-3">Sales :
                    <span class="fs-3 ms-2">
                        <?= $get_orders["nubOrder"] ?>
                    </span>
                </p>
                <p class="card-text fs-3">Price Total :
                    <span class="fs-3">
                        <?= $get_orders["price"] ?> dh
                    </span>

                </p>
            </div>
        </div>
    </div>
</div> -->