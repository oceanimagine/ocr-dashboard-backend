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
check_page("openposition-detail-local");

$file = isset($_GET['file']) && $_GET['file'] != "" ? $_GET['file'] : "";
$type = isset($_GET['type']) && $_GET['type'] != "" ? $_GET['type'] : "";

ob_start();
$contents = file_get_contents("https://ocr-solution.id:7000/ocrapi/ocr-result/" . strtolower($type) . "/" . $file);
ob_get_clean();
$hasil_ocr = json_decode($contents);
if(is_object($hasil_ocr)){
    if(isset($hasil_ocr->{1})){
        $hasil_ocr = $hasil_ocr->{1};
    }
}

if($hasil_ocr == ""){
    $hasil_ocr = "NORESULT.";
}

?>
<textarea class="form-control" style="height: 400px; resize: none;" readonly><?php echo str_replace('\n', "\n", $hasil_ocr); ?></textarea>