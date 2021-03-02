<?php

/* Perusahaan */
// add 

if(isset($_POST['daftar_perusahaan']) && $_POST['daftar_perusahaan'] == "Input"){
    $perusahaan = mysqli_real_escape_string($connect, $_POST['nama_perusahaan']);
    
    mysqli_query($connect, "
        insert into tbl_perusahaan (
            nama_perusahaan
        ) values (
            '".$perusahaan."'
        )
    ");
    if(mysqli_affected_rows($connect) > 0){
        $_SESSION['count'] = 1;
        $_SESSION['keterangan'] = "Berhasil Input Perusahaan.";
        header("location: index.php?page=perusahaan-add");
    }
}

// Edit

if(isset($_POST['daftar_perusahaan']) && $_POST['daftar_perusahaan'] == "Edit"){
    $id = mysqli_real_escape_string($connect, $_GET['id']);
    $perusahaan = mysqli_real_escape_string($connect, $_POST['nama_perusahaan']);
    
    mysqli_query($connect, "
        update tbl_perusahaan set
            nama_perusahaan = '".$perusahaan."'
        where id = '".$id."'
    ");
    if(mysqli_affected_rows($connect) > 0){
        $_SESSION['count'] = 1;
        $_SESSION['keterangan'] = "Berhasil Update Perusahaan.";
        header("location: index.php?page=perusahaan-add&id=" . $id);
    }
}