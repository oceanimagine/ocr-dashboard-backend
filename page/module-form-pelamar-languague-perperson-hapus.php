<?php

if(isset($_GET['idhapus']) && $_GET['idhapus'] != "" && is_numeric($_GET['idhapus'])){
    $idhapus = mysqli_real_escape_string($connect, $_GET['idhapus']);
    $id_bahasa = isset($_GET['id_bahasa']) ? mysqli_real_escape_string($connect, $_GET['id_bahasa']) : "";
    mysqli_query($connect, "delete from tbl_ketrampilan_bahasa where id = '".$idhapus."'");
    if(mysqli_affected_rows($connect) > 0){
        $_SESSION['count'] = 2;
        $_SESSION['keterangan'] = "Berhasil Delete Ketrampilan Bahasa.";
        header("location: index.php?page=form-pelamar-languague-perperson&id=" . $id_bahasa);
    } else {
        $_SESSION['count'] = 2;
        $_SESSION['keterangan'] = "Gagal Delete Ketrampilan Bahasa.";
        header("location: index.php?page=form-pelamar-languague-perperson&id=" . $id_bahasa);
    }
} else {
    $_SESSION['count'] = 2;
    $_SESSION['keterangan'] = "Tidak ada ID Data.";
    header("location: index.php?page=form-pelamar");
}