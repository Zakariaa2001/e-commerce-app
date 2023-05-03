<?php
$products = $pdo->query("SELECT * FROM products ");
$products->execute();
$products = $products->fetchAll(PDO::FETCH_ASSOC);

if (isset($_POST["q"])) {
    $q = $_POST['q'];
    $products = $pdo->prepare("SELECT * from products Where name like ? OR price = ?");
    $products->bindValue(1, "%$q%");
    $products->bindValue(2, $q, PDO::PARAM_INT);
    $products->execute();
    $products = $products->fetchAll(PDO::FETCH_ASSOC);

}
if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    echo $id;
    $req = $pdo->prepare('DELETE from products Where id=?');
    $req->bindValue(1, $id, PDO::PARAM_INT);

    $req->execute();
    header('location:myproduct.php');
}

?>

<link rel="stylesheet" href="style/myproduct.css">
<div class="container">
    <div class="row">
        <div class="col-md-6 offset-md-3 mt-5">
            <p class="h3">Search </p>
            <form action="" method="post" style="display: flex;">

                <input class="form-control me-2" type="text" name="q">
                <button class="btn btn-danger">Search</button><br>
            </form>

            <table class="table">
                <thead class="thead-dark">
                    <tr>

                        <th scope="col">image</th>
                        <th scope="col">name</th>
                        <th scope="col">price</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    foreach ($products as $product) {
                        ?>

                    <tr>
                        <td>
                            <img src="img/<?= $product['image'] ?>" alt="">
                        </td>
                        <td>
                            <?= $product['name'] ?>
                        </td>
                        <td>
                            <?= $product['price'] ?>
                        </td>
                        <td>
                            <button class=" btn btn-secondary btn-edit"><a href="update.php?id=<?= $product['id'] ?>"
                                    class=" text-decortion-none text-white"><i class="fas fa-edit"></i></a></button>

                            <button class="btn btn-danger btn-confirm" data-bs-toggle="modal"
                                data-bs-target="#exampleModal">
                                <a href="delete.php?id=<?= $product['id'] ?>" onclick="return confirm('are you sure')">
                                    <i class=" fa fa-trash text-white"></i>
                                </a>
                            </button>

                            <!-- Modal -->
                            <!-- <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                                                                                                        aria-hidden="true">
                                                                                                        <div class="modal-dialog">
                                                                                                            <div class="modal-content">
                                                                                                                <div class="modal-header">
                                                                                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                                                                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                                                                        aria-label="Close"></button>
                                                                                                                </div>
                                                                                                                <div class="modal-body">
                                                                                                                    ...
                                                                                                                </div>
                                                                                                                <div class="modal-footer">
                                                                                                                    <button type="button" class="btn btn-secondary"
                                                                                                                        data-bs-dismiss="modal">Close</button>
                                                                                                                    <a href="delete.php?id=<?= $product['price'] ?>"
                                                                                                                        class="btn btn-secondary">yes</a>
                                                                                                                    <form action="delete.php" method="get">
                                                                                                                                <input type="text" value="<?= $product['id'] ?>">
                                                                                                                                <input type="submit" class="btn btn-secondary">
                                                                                                                            </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            </div> -->
                        </td>
                    </tr>
                    <?php
                    }

                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>