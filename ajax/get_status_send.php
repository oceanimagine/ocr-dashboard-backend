<?php

include_once "../koneksi.php";

$id_document = isset($_GET['id']) && $_GET['id'] != "" ? $_GET['id'] : "";

if($id_document != ""){
    $query_status_send_ = mysqli_query($connect, "select status_send from tbl_document_track where id_document = '".$id_document."'");
    $jumlah_status_send = mysqli_num_rows($query_status_send_);
    if($jumlah_status_send > 0){
        $hasil_status_send = mysqli_fetch_array($query_status_send_);
        echo $hasil_status_send['status_send'];
    }
    exit();
}
echo "0";