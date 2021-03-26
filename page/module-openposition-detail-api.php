<?php

if (session_status() != PHP_SESSION_ACTIVE) {
    session_start();
}
function check_page($redirect){
    if(isset($_SESSION['username']) && isset($_SESSION['password'])){
        if(!isset($_GET['page'])){
            header("location: ../index.php?page=" . $redirect);
        }
    } else {
        if(isset($_GET['page'])){
            header("location: login.php");
        } else {
            header("location: ../login.php");
        }
    }
}
check_page("openposition-detail-api");

$hasil_ocr = "NORESULT.";
?>
<textarea class="form-control" style="height: 400px; resize: none;" readonly><?php echo str_replace('\n', "\n", $hasil_ocr); ?></textarea>