<?php

if(isset($_GET['id']) && $_GET['id'] != "" && is_numeric($_GET['id'])){
    $id = mysqli_real_escape_string($connect, $_GET['id']);
    $perusahaan = mysqli_query($connect, "select nama_perusahaan from tbl_perusahaan where id = '".$id."'");
    if(mysqli_num_rows($perusahaan) > 0){
        mysqli_query($connect, "
            delete from tbl_perusahaan where id = '".$id."'
        ");
        if(mysqli_affected_rows($connect) > 0){
            $_SESSION['count'] = 1;
            $_SESSION['keterangan'] = "Berhasil Hapus Perusahaan.";
            header("location: index.php?page=perusahaan");
        } else {
            $_SESSION['count'] = 1;
            $_SESSION['keterangan'] = "Gagal Hapus Perusahaan.";
            header("location: index.php?page=perusahaan");
        }
    } else {
        $_SESSION['count'] = 1;
        $_SESSION['keterangan'] = "Data Perusahaan Tidak Ada.";
        header("location: index.php?page=perusahaan");
    }
}

?>

Hapus Perusahaan.