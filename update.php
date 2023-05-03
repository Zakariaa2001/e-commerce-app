<?php
include 'componets/connecte.php';
include 'componets/header.php';

$id = $_GET['id'];
$post = $pdo->prepare('SELECT * FROM products WHERE id=:id');
$post->bindParam('id', $id);
$post->execute();
$post = $post->fetch(PDO::FETCH_ASSOC);
if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    // var_dump($_FILES['image']);
    $filename = $_FILES['image']['name']; // basename($_FILES['img']['name'])
    if (move_uploaded_file($_FILES['image']['tmp_name'], 'img/' . $filename)) {
        echo "ok";
    } else {
        $filename = $post['image'];
    }
} else {
    $filename = $post['image'];

}
if (isset($_POST['name'])) {
    $req = $pdo->prepare('UPDATE products SET name=:name , price=:price , image=:image WHERE id=:id');
    $req->bindParam(':id', $id);
    $req->bindParam(':image', $filename);
    $req->bindParam(':name', $_POST['name']);
    $req->bindParam(':price', $_POST['price']);
    $req->execute();
    if ($req->rowCount() > 0) {
        header('location:admin.php?section=view_product');
    } else {
        $error_msg[] = "something is wrong";

    }

}
?>

<div class="container">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <form action="" method="post" enctype="multipart/form-data">
                <label class="form-label" for="name">name</label>
                <input type="text" name="name" class="form-control" value="<?= $post['name'] ?>" id="title" required>

                <label class="form-label" for="body">price</label>
                <input type="text" name="price" class="form-control" value="<?= $post['price'] ?>" id="body" required>

                <label class="form-label" for="img">image</label>
                <input type="file" name="image" class="form-control" value="<?= $post['image'] ?>" id="img">

                <button type="submit" class="bg-primary p-2 border-0 text-light mt-3 mb-5 px-3">update</button>
            </form>
        </div>
    </div>
</div>
<?php

include_once __DIR__ . '/componets/footer.php';

?>