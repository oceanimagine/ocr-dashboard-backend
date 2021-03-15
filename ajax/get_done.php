<?php

$id_position = isset($_GET['id_position']) && $_GET['id_position'] != "" && is_numeric($_GET['id_position']) ? $_GET['id_position'] : "";

if($id_position != ""){
    $query_done_ = mysqli_query($connect, "select id_position from tbl_document_track where id_position = '".$id_position."' and status_ocr = 'Done'");
    $jumlah_done = mysqli_num_rows($query_done_);
    echo $jumlah_done;
    exit();
}
echo "0";