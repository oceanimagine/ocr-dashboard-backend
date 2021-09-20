<?php

if(isset($_GET['idhapus']) && $_GET['idhapus'] != "" && is_numeric($_GET['idhapus'])){
    $idhapus = mysqli_real_escape_string($connect, $_GET['idhapus']);
    $id_sertifikasi_tambahan = isset($_GET['id_sertifikasi_tambahan']) && $_GET['id_sertifikasi_tambahan'] != "" && is_numeric($_GET['id_sertifikasi_tambahan']) ? mysqli_real_escape_string($connect, $_GET['id_sertifikasi_tambahan']) : "";
    $query_hapus = mysqli_query($connect, "select file_sertifikasi from tbl_serifikasi_tambahan where id = '".$idhapus."'");
    if(mysqli_num_rows($query_hapus) > 0){
        $hasil_hapus = mysqli_fetch_array($query_hapus);
        if($hasil_hapus['file_sertifikasi'] != "" && file_exists("../ocrapi/upload/sertifikasi_lainnya/" . $hasil_hapus['file_sertifikasi'])){
            unlink("../ocrapi/upload/sertifikasi_lainnya/" . $hasil_hapus['file_sertifikasi']);
        }
        mysqli_query($connect, "delete from tbl_serifikasi_tambahan where id = '".$idhapus."'");
        if(mysqli_affected_rows($connect) > 0){
            $_SESSION['count'] = 2;
            $_SESSION['keterangan'] = "Berhasil Delete Sertifikasi Lainnya.";
            header("location: index.php?page=form-pelamar-other-cert&id=" . $id_sertifikasi_tambahan);
        } else {
            $_SESSION['count'] = 2;
            $_SESSION['keterangan'] = "Gagal Delete Sertifikasi Lainnya.";
            header("location: index.php?page=form-pelamar-other-cert&id=" . $id_sertifikasi_tambahan);
        }
    } else {
        $_SESSION['count'] = 2;
        $_SESSION['keterangan'] = "ID Data Tidak Ditemukan.";
        header("location: index.php?page=form-pelamar-other-cert&id=" . $id_sertifikasi_tambahan);
    }
} else {
    $_SESSION['count'] = 2;
    $_SESSION['keterangan'] = "Tidak ada ID Data.";
    header("location: index.php?page=form-pelamar");
}