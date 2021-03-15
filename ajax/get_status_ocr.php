<?php

include_once "../koneksi.php";

$id_document = isset($_GET['id']) && $_GET['id'] != "" ? $_GET['id'] : "";

if($id_document != ""){
    $query_status_ocr_ = mysqli_query($connect, "select status_ocr from tbl_document_track where id_document = '".$id_document."'");
    $jumlah_status_ocr = mysqli_num_rows($query_status_ocr_);
    if($jumlah_status_ocr > 0){
        $hasil_status_ocr_ = mysqli_fetch_array($query_status_ocr_);
        echo $hasil_status_ocr_['status_ocr'];
    }
    exit();
}
echo "0";