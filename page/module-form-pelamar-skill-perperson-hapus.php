<?php

if(isset($_GET['idhapus']) && $_GET['idhapus'] != "" && is_numeric($_GET['idhapus'])){
    $idhapus = mysqli_real_escape_string($connect, $_GET['idhapus']);
    $id_ketrampilan = isset($_GET['id_ketrampilan']) ? mysqli_real_escape_string($connect, $_GET['id_ketrampilan']) : "";
    mysqli_query($connect, "delete from tbl_ketrampilan_lainnya where id = '".$idhapus."'");
    if(mysqli_affected_rows($connect) > 0){
        $_SESSION['count'] = 2;
        $_SESSION['keterangan'] = "Berhasil Delete Ketrampilan Lainnya.";
        header("location: index.php?page=form-pelamar-skill-perperson&id=" . $id_ketrampilan);
    } else {
        $_SESSION['count'] = 2;
        $_SESSION['keterangan'] = "Gagal Delete Ketrampilan Lainnya.";
        header("location: index.php?page=form-pelamar-skill-perperson&id=" . $id_ketrampilan);
    }
} else {
    $_SESSION['count'] = 2;
    $_SESSION['keterangan'] = "Tidak ada ID Data.";
    header("location: index.php?page=form-pelamar");
}