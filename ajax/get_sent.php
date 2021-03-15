<?php

include_once "../koneksi.php";

$id_position = isset($_GET['id_position']) && $_GET['id_position'] != "" && is_numeric($_GET['id_position']) ? $_GET['id_position'] : "";

if($id_position != ""){
    $query_sent_ = mysqli_query($connect, "select id_position from tbl_document_track where id_position = '".$id_position."'");
    $jumlah_sent = mysqli_num_rows($query_sent_);
    echo $jumlah_sent;
    exit();
}
echo "0";