<?php
include 'componets/connecte.php';


$id = $_GET['id'];
// echo $id;
$req = $pdo->prepare('DELETE FROM products WHERE id=?');
$req->bindParam(1, $_GET['id']);
$req->execute();

header('location:admin.php?section=view_product');