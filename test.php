<?php
if (isset($_GET['name'])) {
    $get_name = $_GET['name'];
    if ($get_name == 'add') { ?>
        <div>loraem</div>
        <?php header("location:admin.php");
    }
}

?>