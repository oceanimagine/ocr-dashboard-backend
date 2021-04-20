<?php

if(isset($_GET['idhapus']) && $_GET['idhapus'] != "" && is_numeric($_GET['idhapus'])){
    $idhapus = mysqli_real_escape_string($connect, $_GET['idhapus']);
    mysqli_query($connect, "delete from tbl_jurusan where id = '".$idhapus."'");
    if(mysqli_affected_rows($connect) > 0){
        $_SESSION['count'] = 2;
        $_SESSION['keterangan'] = "Berhasil Delete Data Jurusan.";
        header("location: index.php?page=form-jurusan");
    } else {
        $_SESSION['count'] = 2;
        $_SESSION['keterangan'] = "Gagal Delete Data Jurusan.";
        header("location: index.php?page=form-jurusan");
    }
} else {
    $_SESSION['count'] = 2;
    $_SESSION['keterangan'] = "Tidak ada ID Data.";
    header("location: index.php?page=form-jurusan");
}