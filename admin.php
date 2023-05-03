<?php
include 'componets/connecte.php';
// include 'componets/header.php';
$section = "";
if (isset($_GET['section'])) {
    $section = $_GET['section'];
}
?>
<link rel="stylesheet" href="./bootstrap-5.0.2-dist/css/bootstrap.min.css">
<!-- font font-awesome -->
<link rel="stylesheet" href="fontawesome-free-6.2.0-web/css/all.min.css">
<!-- css file-->
<link rel="stylesheet" href="style/style.css">
<!-- font google -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link
    href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;800&family=Montserrat:ital,wght@0,100;0,400;0,500;0,800;1,400&display=swap"
    rel="stylesheet">
<style>
body {
    background-color: #eee;
}

.sidebar {
    background-color: white;
    min-width: 250px;
    max-width: 250px;
    position: fixed !important;
    top: 0 !important;
    height: 100% !important;
}

.content {
    height: 100vh;
    width: 100%;
}

hr.h-color {
    background-color: #eee;
}

ul li.active {
    background-color: rgba(105, 108, 255, .16) !important;
    border-radius: 5px;
}

.sidebar li.active a {
    color: #696cff;
}

.sidebar li a {
    color: #697a8d;
}
</style>
<div class="main-container d-flex">
    <div class="sidebar">
        <div class="header-box px-2 pt-3 pb-4">
            <a class=" h1 text-decoration-none text-dark" href="viewproduct">shopping store</a>
            <button class="btn d-md-none d-block px-1 text-white"><i class="fa-solid fa-bars-staggered"></i></button>
        </div>
        <ul class="list-unstyled px-2">
            <li class="<?= $section == "dasborad" ? 'active' : '' ?> p-2"><i class="fa-solid fa-house-user"></i>
                <a class="text-decoration-none" href="?section=dasborad">dasborad</a>
            </li>
            <li class="p-2 <?= $section == "add_product" ? 'active' : '' ?>"><i class="fa-solid fa-user"></i> <a
                    class="text-decoration-none" href="?section=add_product">add
                    product</a></li>
            <li class="<?= $section == "view_product" ? 'active' : '' ?> p-2"><i class="fa-solid fa-user"></i> <a
                    class="text-decoration-none" href="?section=view_product">view
                    products</a></li>
            <li class="p-2"> <i class="fa-solid fa-user"></i> <a class="text-decoration-none" href="">orders</a>
            </li>
            <li class="p-2"><i class="fa-solid fa-user"></i> <a class="text-decoration-none" href="">customers</a>
            </li>
        </ul>
        <hr class="h-color mx-2">
        <ul class="list-unstyled px-2">
            <li class="p-2"><i class="fa-solid fa-check"></i> <a class="text-decoration-none" href="">notifications</a>
            </li>
            <li class="p-2"><i class="fa-solid fa-gear"></i> <a class="text-decoration-none" href="">setting</a>
            </li>

        </ul>
    </div>
    <div class="content">
        <?php if ($section == "dasborad") {
            include 'dasborad.php';
            ?>
        <h1>ok</h1>

        <?php } elseif ($section == "add_product") {
            include 'addproduct.php';
            ?>

        <?php } elseif ($section == "view_product") {
            include 'view_product.php';
        }
        ?>
    </div>

</div>
<!-- <script>
    let getLi = document.querySelectorAll(".sidebar ul li");

    for (let i = 0; i < getLi.length; i++) {
        getLi[i].onclick = () => {
            let getLiActive = document.querySelector(".sidebar ul li.active");
            console.log("ok")
            getLiActive.classList.remove('active');
            getLi[i].classList.add("active");
        }

    }
</script> -->