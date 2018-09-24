<?php
include('includes/database.php');
include('includes/header.php');
include('includes/footer.php');

$db = new pdoDB;
$showAllTrans = $db->showHistory();
?>

<div class ="col-md-8 history">

<?php
    if(!empty($showAllTrans)){
        header('Content-Type: application/json');
        print json_encode($showAllTrans,JSON_UNESCAPED_SLASHES);
    }
?>

</div>
