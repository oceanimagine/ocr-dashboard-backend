<?php

if(isset($_GET['idhapus']) && $_GET['idhapus'] != "" && is_numeric($_GET['idhapus'])){
    $idhapus = mysqli_real_escape_string($connect, $_GET['idhapus']);
    $query_hapus = mysqli_query($connect, "select * from tbl_pelamar where id = '".$idhapus."'");
    if(mysqli_num_rows($query_hapus) > 0){
        $hasil_hapus = mysqli_fetch_array($query_hapus);
        if($hasil_hapus['file_ktp'] != "" && file_exists("../ocrapi/upload/ktp/" . $hasil_hapus['file_ktp'])){
            unlink("../ocrapi/upload/ktp/" . $hasil_hapus['file_ktp']);
        }
        if($hasil_hapus['file_ijazah'] != "" && file_exists("../ocrapi/upload/ijazah/" . $hasil_hapus['file_ijazah'])){
            unlink("../ocrapi/upload/ijazah/" . $hasil_hapus['file_ijazah']);
        }
        mysqli_query($connect, "delete from tbl_pelamar where id = '".$idhapus."'");
        if(mysqli_affected_rows($connect) > 0){
            $_SESSION['count'] = 2;
            $_SESSION['keterangan'] = "Berhasil Delete Data Pelamar.";
            header("location: index.php?page=form-pelamar");
        } else {
            $_SESSION['count'] = 2;
            $_SESSION['keterangan'] = "Gagal Delete Data Pelamar.";
            header("location: index.php?page=form-pelamar");
        }
    } else {
        $_SESSION['count'] = 2;
        $_SESSION['keterangan'] = "ID Data Tidak Ditemukan.";
        header("location: index.php?page=form-pelamar");
    }
} else {
    $_SESSION['count'] = 2;
    $_SESSION['keterangan'] = "Tidak ada ID Data.";
    header("location: index.php?page=form-pelamar");
}