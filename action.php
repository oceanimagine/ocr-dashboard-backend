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


// Add Universitas
if(isset($_POST['daftar_universitas']) && $_POST['daftar_universitas'] == "Input Universitas"){
    $universitas = mysqli_real_escape_string($connect, $_POST['nama_universitas']);
    
    $query_hapus = mysqli_query($connect, "select universitas from tbl_universitas where universitas = '".$universitas."'");
    if(mysqli_num_rows($query_hapus) == 0){
        $nama_file_ktp = "";

        mysqli_query($connect, "
            insert into tbl_universitas (
                universitas
            ) values (
                '".$universitas."'
            )
        ");
        if(mysqli_affected_rows($connect) > 0){
            $_SESSION['count'] = 1;
            $_SESSION['keterangan'] = "Berhasil Insert Data Universitas.";
            header("location: index.php?page=form-universitas");
        }
    } else {
        $_SESSION['count'] = 1;
        $_SESSION['keterangan'] = "Data Universitas Telah ada.";
        header("location: index.php?page=form-universitas");
    }
}

// update universitas
if(isset($_POST['daftar_universitas']) && $_POST['daftar_universitas'] == "Update Universitas"){
    $universitas = mysqli_real_escape_string($connect, $_POST['nama_universitas']);
    mysqli_query($connect, "
        update tbl_universitas set
            universitas = '".$universitas."'
        where id = '".mysqli_real_escape_string($connect, $_GET['id'])."'
    ");
    if(mysqli_affected_rows($connect) > 0){
        $_SESSION['count'] = 1;
        $_SESSION['keterangan'] = "Berhasil Update Data Universitas.";
        header("location: index.php?page=form-universitas");
    } else {
        $_SESSION['count'] = 1;
        $_SESSION['keterangan'] = "Gagal Update Data Universitas.";
        header("location: index.php?page=form-universitas");
    }
}

// Add Jurusan
if(isset($_POST['daftar_jurusan']) && $_POST['daftar_jurusan'] == "Input Jurusan"){
    $jurusan = mysqli_real_escape_string($connect, $_POST['nama_jurusan']);
    
    $query_hapus = mysqli_query($connect, "select universitas from tbl_jurusan where jurusan = '".$jurusan."'");
    if(mysqli_num_rows($query_hapus) == 0){
        $nama_file_ktp = "";

        mysqli_query($connect, "
            insert into tbl_jurusan (
                jurusan
            ) values (
                '".$jurusan."'
            )
        ");
        if(mysqli_affected_rows($connect) > 0){
            $_SESSION['count'] = 1;
            $_SESSION['keterangan'] = "Berhasil Insert Data Jurusan.";
            header("location: index.php?page=form-jurusan");
        }
    } else {
        $_SESSION['count'] = 1;
        $_SESSION['keterangan'] = "Data Jurusan Telah ada.";
        header("location: index.php?page=form-jurusan");
    }
}

// update jurusan
if(isset($_POST['daftar_jurusan']) && $_POST['daftar_jurusan'] == "Update Jurusan"){
    $jurusan = mysqli_real_escape_string($connect, $_POST['nama_jurusan']);
    mysqli_query($connect, "
        update tbl_jurusan set
            jurusan = '".$jurusan."'
        where id = '".mysqli_real_escape_string($connect, $_GET['id'])."'
    ");
    if(mysqli_affected_rows($connect) > 0){
        $_SESSION['count'] = 1;
        $_SESSION['keterangan'] = "Berhasil Update Data Jurusan.";
        header("location: index.php?page=form-jurusan");
    } else {
        $_SESSION['count'] = 1;
        $_SESSION['keterangan'] = "Gagal Update Data Jurusan.";
        header("location: index.php?page=form-jurusan");
    }
}

// Add Pelamar
if(isset($_POST['daftar_pelamar']) && $_POST['daftar_pelamar'] == "Input Pelamar"){
    $id_position = mysqli_real_escape_string($connect, $_POST['id_position']);
    $nama_pelamar = mysqli_real_escape_string($connect, $_POST['nama_pelamar']);
    $nik = mysqli_real_escape_string($connect, $_POST['nik']);
    $umur = mysqli_real_escape_string($connect, $_POST['umur']);
    $tempat_lahir = mysqli_real_escape_string($connect, $_POST['tempat_lahir']);
    $tanggal_lahir = mysqli_real_escape_string($connect, $_POST['tanggal_lahir']);
    $universitas = mysqli_real_escape_string($connect, $_POST['universitas']);
    $jurusan = mysqli_real_escape_string($connect, $_POST['jurusan']);
    $ipk = mysqli_real_escape_string($connect, $_POST['ipk']);
    $jenis_kelamin = mysqli_real_escape_string($connect, $_POST['jenis_kelamin']);
    
    $query_hapus = mysqli_query($connect, "select nik from tbl_pelamar where nik = '".$nik."'");
    if(mysqli_num_rows($query_hapus) == 0){
        $nama_file_ktp = "";
        if(isset($_FILES['file_ktp']) && is_array($_FILES['file_ktp'])){
            $file_ktp = $_FILES['file_ktp'];
            $temp = $file_ktp['tmp_name'];
            $name = $file_ktp['name'];
            $expl = explode(".", $name);
            $type = $expl[sizeof($expl) - 1];
            $nama_file_ktp = "KTP" . date("Ymd") . date("His") . "." . $type;
            move_uploaded_file($temp, "../ocrapi/upload/ktp/" . $nama_file_ktp);
        }

        $nama_file_ijazah = "";
        if(isset($_FILES['file_ijazah']) && is_array($_FILES['file_ijazah'])){
            $file_ijazah = $_FILES['file_ijazah'];
            $temp = $file_ijazah['tmp_name'];
            $name = $file_ijazah['name'];
            $expl = explode(".", $name);
            $type = $expl[sizeof($expl) - 1];
            $nama_file_ijazah = "IJAZAH" . date("Ymd") . date("His") . "." . $type;
            move_uploaded_file($temp, "../ocrapi/upload/ijazah/" . $nama_file_ijazah);
        }

        mysqli_query($connect, "
            insert into tbl_pelamar (
                id_position,
                nama_pelamar,
                nik,
                umur,
                tempat_lahir,
                tanggal_lahir,
                universitas,
                jurusan,
                ipk,
                file_ktp,
                file_ijazah,
                jenis_kelamin
            ) values (
                '".$id_position."',
                '".$nama_pelamar."',
                '".$nik."',
                '".$umur."',
                '".$tempat_lahir."',
                '".$tanggal_lahir."',
                '".$universitas."',
                '".$jurusan."',
                '".$ipk."',
                '".$nama_file_ktp."',
                '".$nama_file_ijazah."',
                '".$jenis_kelamin."'
            )
        ");
        if(mysqli_affected_rows($connect) > 0){
            $_SESSION['count'] = 1;
            $_SESSION['keterangan'] = "Berhasil Insert Data Pelamar.";
            header("location: index.php?page=form-pelamar");
        }
    } else {
        $_SESSION['count'] = 1;
        $_SESSION['keterangan'] = "Data KTP Telah ada.";
        header("location: index.php?page=form-pelamar");
    }
}

// Update Pelamar
if(isset($_POST['daftar_pelamar']) && $_POST['daftar_pelamar'] == "Update Pelamar"){
    $id_position = mysqli_real_escape_string($connect, $_POST['id_position']);
    $nama_pelamar = mysqli_real_escape_string($connect, $_POST['nama_pelamar']);
    $nik = mysqli_real_escape_string($connect, $_POST['nik']);
    $umur = mysqli_real_escape_string($connect, $_POST['umur']);
    $tempat_lahir = mysqli_real_escape_string($connect, $_POST['tempat_lahir']);
    $tanggal_lahir = mysqli_real_escape_string($connect, $_POST['tanggal_lahir']);
    $universitas = mysqli_real_escape_string($connect, $_POST['universitas']);
    $jurusan = mysqli_real_escape_string($connect, $_POST['jurusan']);
    $ipk = mysqli_real_escape_string($connect, $_POST['ipk']);
    $jenis_kelamin = mysqli_real_escape_string($connect, $_POST['jenis_kelamin']);
    $nama_file_ktp_temp = mysqli_real_escape_string($connect, $_POST['file_ktp_hidden']);
    $nama_file_ktp = "";
    if(isset($_FILES['file_ktp']) && is_array($_FILES['file_ktp']) && (isset($_FILES['file_ktp']['name']) && $_FILES['file_ktp']['name'] != "")){
        $file_ktp = $_FILES['file_ktp'];
        $temp = $file_ktp['tmp_name'];
        $name = $file_ktp['name'];
        $expl = explode(".", $name);
        $type = $expl[sizeof($expl) - 1];
        $nama_file_ktp = "KTP" . date("Ymd") . date("His") . "." . $type;
        if(move_uploaded_file($temp, "../ocrapi/upload/ktp/" . $nama_file_ktp)){
            if($nama_file_ktp_temp != "" && file_exists("../ocrapi/upload/ktp/" . $nama_file_ktp_temp)){
                unlink("../ocrapi/upload/ktp/" . $nama_file_ktp_temp);
            }
        }
    } else {
        $nama_file_ktp = $nama_file_ktp_temp;
    }
    
    $nama_file_ijazah_temp = mysqli_real_escape_string($connect, $_POST['file_ijazah_hidden']);
    $nama_file_ijazah = "";
    if(isset($_FILES['file_ijazah']) && is_array($_FILES['file_ijazah']) && (isset($_FILES['file_ijazah']['name']) && $_FILES['file_ijazah']['name'] != "")){
        $file_ijazah = $_FILES['file_ijazah'];
        $temp = $file_ijazah['tmp_name'];
        $name = $file_ijazah['name'];
        $expl = explode(".", $name);
        $type = $expl[sizeof($expl) - 1];
        $nama_file_ijazah = "IJAZAH" . date("Ymd") . date("His") . "." . $type;
        if(move_uploaded_file($temp, "../ocrapi/upload/ijazah/" . $nama_file_ijazah)){
            if($nama_file_ijazah_temp != "" && file_exists("../ocrapi/upload/ijazah/" . $nama_file_ijazah_temp)){
                unlink("../ocrapi/upload/ijazah/" . $nama_file_ijazah_temp);
            }
        }
    } else {
        $nama_file_ijazah = $nama_file_ijazah_temp;
    }
    
    mysqli_query($connect, "
        update tbl_pelamar set
            id_position = '".$id_position."',
            nama_pelamar = '".$nama_pelamar."',
            nik = '".$nik."',
            umur = '".$umur."',
            tempat_lahir = '".$tempat_lahir."',
            tanggal_lahir = '".$tanggal_lahir."',
            universitas = '".$universitas."',
            jurusan = '".$jurusan."',
            ipk = '".$ipk."',
            file_ktp = '".$nama_file_ktp."',
            file_ijazah = '".$nama_file_ijazah."',
            jenis_kelamin = '".$jenis_kelamin."'
        where id = '".$_GET['id']."'
    ");
    if(mysqli_affected_rows($connect) > 0){
        $_SESSION['count'] = 1;
        $_SESSION['keterangan'] = "Berhasil Update Data Pelamar.";
        header("location: index.php?page=form-pelamar-add&id=" . $_GET['id']);
    }
    
}