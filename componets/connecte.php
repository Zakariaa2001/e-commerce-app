<?php
$db_name = 'mysql:host=localhost;dbname=db_shop';
$db_user_name = 'root';
$db_user_password = '';
session_start();
try {
    $pdo = new PDO($db_name, $db_user_name, $db_user_password);
} catch (PDOException $e) {
    echo $e->getMessage();
}
function create_unique_id()
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < 20; $i++) {
        $randomString .= $characters[mt_rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

?>