<?php
if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    setcookie('user_id', create_unique_id(), time() + 60 * 60 * 24 * 30);
}


if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    // var_dump($_FILES['image']);
    $filename = $_FILES['image']['name']; // basename($_FILES['img']['name'])
    if (move_uploaded_file($_FILES['image']['tmp_name'], 'img/' . $filename)) {
        $unique_id = create_unique_id();
        $req = $pdo->prepare("INSERT INTO products(id,name , price,image) VALUES (?,?,?,?)");
        $req->execute([$unique_id, $_POST['name'], $_POST['price'], $filename]);
        if ($req->rowCount() > 0) {
            header('location:admin.php?section=view_product');
        } else {
            $error_msg[] = 'something is wrong';
        }
    }
}

?>
<div class="container">
    <p class="h1 text-center">Add Product</p>
    <div class="row mt-5">
        <div class="col-md-6 offset-md-3">
            <form action="" method="post" enctype="multipart/form-data">
                <label class="form-label" for="name">name</label>
                <input type="text" name="name" class="form-control" id="name" required>

                <label class="form-label" for="price">price</label>
                <input type="text" name="price" class="form-control" id="price" required>

                <label class="form-label" for="image">image</label>
                <input type="file" name="image" class="form-control" id="image" required>
                <button type="submit" class="btn btn-primary text-light mt-3 px-3">add</button>
            </form>
        </div>
    </div>
</div>