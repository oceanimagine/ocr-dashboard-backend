<?php

if(isset($_GET['idhapus']) && $_GET['idhapus'] != "" && is_numeric($_GET['idhapus'])){
    $idhapus = mysqli_real_escape_string($connect, mysqli_real_escape_string($connect, $_GET['idhapus']));
    $id_open_position = isset($_GET['id_open_position']) && $_GET['id_open_position'] != "" && is_numeric($_GET['id_open_position']) ? mysqli_real_escape_string($connect, $_GET['id_open_position']) : "";
    $query_nik = mysqli_query($connect, "select nik from tbl_pelamar where id = '".$idhapus."'");
    $nik = "";
    if(mysqli_num_rows($query_nik) > 0){
        $hasil_nik = mysqli_fetch_array($query_nik);
        $nik = $hasil_nik['nik'];
    }
    mysqli_query($connect, "
        delete from tbl_pelamar where 
        id = '".$idhapus."' and id_position = '".$id_open_position."'
    ");
    $query_id = mysqli_query($connect, "select id from tbl_pelamar_master where nik = '".$nik."'");
    if(mysqli_num_rows($query_id) > 0){
        $hasil_id = mysqli_fetch_array($query_id);
        $idhapus = $hasil_id['id'];
    }
    if(mysqli_affected_rows($connect) > 0){
        $_SESSION['count'] = 2;
        $_SESSION['keterangan'] = "Berhasil Delete Open Position Pelamar.";
        header("location: index.php?page=form-pelamar-open-position-perperson&id=" . $idhapus);
    } else {
        $_SESSION['count'] = 2;
        $_SESSION['keterangan'] = "Gagal Delete Open Position Pelamar.";
        header("location: index.php?page=form-pelamar-open-position-perperson&id=" . $idhapus);
    }
} else {
    $_SESSION['count'] = 2;
    $_SESSION['keterangan'] = "Tidak ada ID Data.";
    header("location: index.php?page=form-pelamar-open-position-perperson&id=" . $idhapus);
}