<?php

/* Perusahaan */
// add 

$GLOBALS['token'] = "33539c6c0927fef9634ea705ca9526c8eb96e982d77672ab97920210506090431";
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
    $nama_pelamar = mysqli_real_escape_string($connect, $_POST['nama_pelamar']);
    $nik = mysqli_real_escape_string($connect, $_POST['nik']);
    $umur = mysqli_real_escape_string($connect, $_POST['umur']);
    $tempat_lahir = mysqli_real_escape_string($connect, $_POST['tempat_lahir']);
    $tanggal_lahir = mysqli_real_escape_string($connect, $_POST['tanggal_lahir']);
    $universitas = mysqli_real_escape_string($connect, $_POST['universitas']);
    $jurusan = mysqli_real_escape_string($connect, $_POST['jurusan']);
    $ipk = mysqli_real_escape_string($connect, $_POST['ipk']);
    $universitas_s2 = mysqli_real_escape_string($connect, $_POST['universitas_s2']);
    $jurusan_s2 = mysqli_real_escape_string($connect, $_POST['jurusan_s2']);
    $ipk_s2 = mysqli_real_escape_string($connect, $_POST['ipk_s2']);
    $username = mysqli_real_escape_string($connect, $_POST['username']);
    $password = mysqli_real_escape_string($connect, $_POST['password']);
    $jenis_kelamin = mysqli_real_escape_string($connect, $_POST['jenis_kelamin']);
    
    $query_hapus = mysqli_query($connect, "select nik from tbl_pelamar_master where nik = '".$nik."'");
    if(mysqli_num_rows($query_hapus) == 0){
        $nama_file_ktp = "";
        if(isset($_FILES['file_ktp']) && is_array($_FILES['file_ktp']) && (isset($_FILES['file_ktp']['name']) && $_FILES['file_ktp']['name'] != "")){
            $file_ktp = $_FILES['file_ktp'];
            $temp = $file_ktp['tmp_name'];
            $name = $file_ktp['name'];
            $expl = explode(".", $name);
            $type = $expl[sizeof($expl) - 1];
            $nama_file_ktp = "KTP" . date("Ymd") . date("His") . "." . $type;
            move_uploaded_file($temp, "../ocrapi/upload/ktp/" . $nama_file_ktp);
        }

        $nama_file_ijazah = "";
        if(isset($_FILES['file_ijazah']) && is_array($_FILES['file_ijazah']) && (isset($_FILES['file_ijazah']['name']) && $_FILES['file_ijazah']['name'] != "")){
            $file_ijazah = $_FILES['file_ijazah'];
            $temp = $file_ijazah['tmp_name'];
            $name = $file_ijazah['name'];
            $expl = explode(".", $name);
            $type = $expl[sizeof($expl) - 1];
            $nama_file_ijazah = "IJAZAH" . date("Ymd") . date("His") . "." . $type;
            move_uploaded_file($temp, "../ocrapi/upload/ijazah/" . $nama_file_ijazah);
            shell_exec("php /var/www/html/ocrapi/SERVICECONVERTPERFILE.php " . $nama_file_ijazah . " > /dev/null 2>/dev/null &");
        }
        
        $nama_file_ijazah_sertifikat = "";
        if(isset($_FILES['file_ijazah_sertifikat']) && is_array($_FILES['file_ijazah_sertifikat']) && (isset($_FILES['file_ijazah_sertifikat']['name']) && $_FILES['file_ijazah_sertifikat']['name'] != "")){
            $file_ijazah_sertifikat = $_FILES['file_ijazah_sertifikat'];
            $temp = $file_ijazah_sertifikat['tmp_name'];
            $name = $file_ijazah_sertifikat['name'];
            $expl = explode(".", $name);
            $type = $expl[sizeof($expl) - 1];
            $nama_file_ijazah_sertifikat = "IJAZAHSERTIFIKAT" . date("Ymd") . date("His") . "." . $type;
            move_uploaded_file($temp, "../ocrapi/upload/ijazah_sertifikat/" . $nama_file_ijazah_sertifikat);
            shell_exec("php /var/www/html/ocrapi/SERVICECONVERTPERFILENEW.php " . $nama_file_ijazah_sertifikat . " ijazah_sertifikat > /dev/null 2>/dev/null &");
        }
        
        $nama_file_ijazah_s2 = "";
        if(isset($_FILES['file_ijazah_s2']) && is_array($_FILES['file_ijazah_s2']) && (isset($_FILES['file_ijazah_s2']['name']) && $_FILES['file_ijazah_s2']['name'] != "")){
            $file_ijazah_s2 = $_FILES['file_ijazah_s2'];
            $temp = $file_ijazah_s2['tmp_name'];
            $name = $file_ijazah_s2['name'];
            $expl = explode(".", $name);
            $type = $expl[sizeof($expl) - 1];
            $nama_file_ijazah_s2 = "IJAZAHS2" . date("Ymd") . date("His") . "." . $type;
            move_uploaded_file($temp, "../ocrapi/upload/ijazah_s2/" . $nama_file_ijazah_s2);
            shell_exec("php /var/www/html/ocrapi/SERVICECONVERTPERFILENEW.php " . $nama_file_ijazah_s2 . " ijazah_s2 > /dev/null 2>/dev/null &");
        }
        
        $nama_file_ijazah_sertifikat_s2 = "";
        if(isset($_FILES['file_ijazah_sertifikat_s2']) && is_array($_FILES['file_ijazah_sertifikat_s2']) && (isset($_FILES['file_ijazah_sertifikat_s2']['name']) && $_FILES['file_ijazah_sertifikat_s2']['name'] != "")){
            $file_ijazah_sertifikat_s2 = $_FILES['file_ijazah_sertifikat_s2'];
            $temp = $file_ijazah_sertifikat_s2['tmp_name'];
            $name = $file_ijazah_sertifikat_s2['name'];
            $expl = explode(".", $name);
            $type = $expl[sizeof($expl) - 1];
            $nama_file_ijazah_sertifikat_s2 = "IJAZAHSERTIFIKATS2" . date("Ymd") . date("His") . "." . $type;
            move_uploaded_file($temp, "../ocrapi/upload/ijazah_s2_sertifikat/" . $nama_file_ijazah_sertifikat_s2);
            shell_exec("php /var/www/html/ocrapi/SERVICECONVERTPERFILENEW.php " . $nama_file_ijazah_sertifikat_s2 . " ijazah_s2_sertifikat > /dev/null 2>/dev/null &");
        }

        mysqli_query($connect, "
            insert into tbl_pelamar_master (
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
                jenis_kelamin,
                username,
                password,
                file_ijazah_sertifikat,
                universitas_s2,
                jurusan_s2,
                ipk_s2,
                file_ijazah_s2,
                file_ijazah_sertifikat_s2
            ) values (
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
                '".$jenis_kelamin."',
                '".$username."',
                '".md5($password)."',
                '".$nama_file_ijazah_sertifikat."',
                '".$universitas_s2."',
                '".$jurusan_s2."',
                '".$ipk_s2."',
                '".$nama_file_ijazah_s2."',
                '".$nama_file_ijazah_sertifikat_s2."'
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
    $nama_pelamar = mysqli_real_escape_string($connect, $_POST['nama_pelamar']);
    $nik = mysqli_real_escape_string($connect, $_POST['nik']);
    $umur = mysqli_real_escape_string($connect, $_POST['umur']);
    $tempat_lahir = mysqli_real_escape_string($connect, $_POST['tempat_lahir']);
    $tanggal_lahir = mysqli_real_escape_string($connect, $_POST['tanggal_lahir']);
    $universitas = mysqli_real_escape_string($connect, $_POST['universitas']);
    $jurusan = mysqli_real_escape_string($connect, $_POST['jurusan']);
    $ipk = mysqli_real_escape_string($connect, $_POST['ipk']);
    $universitas_s2 = mysqli_real_escape_string($connect, $_POST['universitas_s2']);
    $jurusan_s2 = mysqli_real_escape_string($connect, $_POST['jurusan_s2']);
    $ipk_s2 = mysqli_real_escape_string($connect, $_POST['ipk_s2']);
    $jenis_kelamin = mysqli_real_escape_string($connect, $_POST['jenis_kelamin']);
    $username = mysqli_real_escape_string($connect, $_POST['username']);
    $password = mysqli_real_escape_string($connect, $_POST['password']);
    
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
            shell_exec("php /var/www/html/ocrapi/SERVICECONVERTPERFILE.php " . $nama_file_ijazah . " > /dev/null 2>/dev/null &");
        }
    } else {
        $nama_file_ijazah = $nama_file_ijazah_temp;
    }
    
    $nama_file_ijazah_sertifikat = "";
    $nama_file_ijazah_sertifikat_temp = mysqli_real_escape_string($connect, $_POST['file_ijazah_sertifikat_hidden']);
    if(isset($_FILES['file_ijazah_sertifikat']) && is_array($_FILES['file_ijazah_sertifikat']) && (isset($_FILES['file_ijazah_sertifikat']['name']) && $_FILES['file_ijazah_sertifikat']['name'] != "")){
        $file_ijazah_sertifikat = $_FILES['file_ijazah_sertifikat'];
        $temp = $file_ijazah_sertifikat['tmp_name'];
        $name = $file_ijazah_sertifikat['name'];
        $expl = explode(".", $name);
        $type = $expl[sizeof($expl) - 1];
        $nama_file_ijazah_sertifikat = "IJAZAHSERTIFIKAT" . date("Ymd") . date("His") . "." . $type;
        if(move_uploaded_file($temp, "../ocrapi/upload/ijazah_sertifikat/" . $nama_file_ijazah_sertifikat)){
            if($nama_file_ijazah_temp != "" && file_exists("../ocrapi/upload/ijazah_sertifikat/" . $nama_file_ijazah_sertifikat_temp)){
                unlink("../ocrapi/upload/ijazah_sertifikat/" . $nama_file_ijazah_sertifikat_temp);
            }
            shell_exec("php /var/www/html/ocrapi/SERVICECONVERTPERFILENEW.php " . $nama_file_ijazah_sertifikat . " ijazah_sertifikat > /dev/null 2>/dev/null &");
        }
    } else {
        $nama_file_ijazah_sertifikat = $nama_file_ijazah_sertifikat_temp;
    }
    
    $nama_file_ijazah_s2 = "";
    $nama_file_ijazah_s2_temp = mysqli_real_escape_string($connect, $_POST['file_ijazah_s2_hidden']);
    if(isset($_FILES['file_ijazah_s2']) && is_array($_FILES['file_ijazah_s2']) && (isset($_FILES['file_ijazah_s2']['name']) && $_FILES['file_ijazah_s2']['name'] != "")){
        $file_ijazah_s2 = $_FILES['file_ijazah_s2'];
        $temp = $file_ijazah_s2['tmp_name'];
        $name = $file_ijazah_s2['name'];
        $expl = explode(".", $name);
        $type = $expl[sizeof($expl) - 1];
        $nama_file_ijazah_s2 = "IJAZAHS2" . date("Ymd") . date("His") . "." . $type;
        if(move_uploaded_file($temp, "../ocrapi/upload/ijazah_s2/" . $nama_file_ijazah_s2)){
            if($nama_file_ijazah_s2_temp != "" && file_exists("../ocrapi/upload/ijazah_s2/" . $nama_file_ijazah_s2)){
                unlink("../ocrapi/upload/ijazah_s2/" . $nama_file_ijazah_s2_temp);
            }
            shell_exec("php /var/www/html/ocrapi/SERVICECONVERTPERFILENEW.php " . $nama_file_ijazah_s2 . " ijazah_s2 > /dev/null 2>/dev/null &");
        }
    } else {
        $nama_file_ijazah_s2 = $nama_file_ijazah_s2_temp;
    }

    $nama_file_ijazah_sertifikat_s2 = "";
    $nama_file_ijazah_sertifikat_s2_temp = mysqli_real_escape_string($connect, $_POST['file_ijazah_sertifikat_s2_hidden']);
    if(isset($_FILES['file_ijazah_sertifikat_s2']) && is_array($_FILES['file_ijazah_sertifikat_s2']) && (isset($_FILES['file_ijazah_sertifikat_s2']['name']) && $_FILES['file_ijazah_sertifikat_s2']['name'] != "")){
        $file_ijazah_sertifikat_s2 = $_FILES['file_ijazah_sertifikat_s2'];
        $temp = $file_ijazah_sertifikat_s2['tmp_name'];
        $name = $file_ijazah_sertifikat_s2['name'];
        $expl = explode(".", $name);
        $type = $expl[sizeof($expl) - 1];
        $nama_file_ijazah_sertifikat_s2 = "IJAZAHSERTIFIKATS2" . date("Ymd") . date("His") . "." . $type;
        if(move_uploaded_file($temp, "../ocrapi/upload/ijazah_s2_sertifikat/" . $nama_file_ijazah_sertifikat_s2)){
            if($nama_file_ijazah_sertifikat_s2_temp != "" && file_exists("../ocrapi/upload/ijazah_s2_sertifikat/" . $nama_file_ijazah_sertifikat_s2)){
                unlink("../ocrapi/upload/ijazah_s2_sertifikat/" . $nama_file_ijazah_sertifikat_s2_temp);
            }
            shell_exec("php /var/www/html/ocrapi/SERVICECONVERTPERFILENEW.php " . $nama_file_ijazah_sertifikat_s2 . " ijazah_s2_sertifikat > /dev/null 2>/dev/null &");
        }
    } else {
        $nama_file_ijazah_sertifikat_s2 = $nama_file_ijazah_sertifikat_s2_temp;
    }
    mysqli_query($connect, "
        update tbl_pelamar_master set
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
            jenis_kelamin = '".$jenis_kelamin."',
            username = '".$username."',
            password = '".$password."',
            file_ijazah_sertifikat = '".$nama_file_ijazah_sertifikat."',
            universitas_s2 = '".$universitas_s2."',
            jurusan_s2 = '".$jurusan_s2."',
            ipk_s2 = '".$ipk_s2."',
            file_ijazah_s2 = '".$nama_file_ijazah_s2."',
            file_ijazah_sertifikat_s2 = '".$nama_file_ijazah_sertifikat_s2."'
        where id = '".$_GET['id']."'
    ");
    if(mysqli_affected_rows($connect) > 0){
        // Update Info Lamaran
        mysqli_query($connect, "
            update tbl_pelamar set
                nama_pelamar = '".$nama_pelamar."',
                nik = '".$nik."',
                umur = '".$umur."',
                tempat_lahir = '".$tempat_lahir."',
                tanggal_lahir = '".$tanggal_lahir."',
                jenis_kelamin = '".$jenis_kelamin."',
                file_ktp = '".$nama_file_ktp."',
                universitas = '".$universitas."',
                jurusan = '".$jurusan."',
                ipk = '".$ipk."',
                file_ijazah = '".$nama_file_ijazah."',
                file_ijazah_sertifikat = '".$nama_file_ijazah_sertifikat."',
                universitas_s2 = '".$universitas_s2."',
                jurusan_s2 = '".$jurusan_s2."',
                ipk_s2 = '".$ipk_s2."',
                file_ijazah_s2 = '".$nama_file_ijazah_s2."',
                file_ijazah_sertifikat_s2 = '".$nama_file_ijazah_sertifikat_s2."'
            where nik = '".$nik."'
        ");
        $_SESSION['count'] = 1;
        $_SESSION['keterangan'] = "Berhasil Update Data Pelamar.";
        header("location: index.php?page=form-pelamar-add&id=" . $_GET['id']);
    } else {
        $_SESSION['count'] = 1;
        $_SESSION['keterangan'] = "Tidak Ada Perubahan Data.";
        header("location: index.php?page=form-pelamar-add&id=" . $_GET['id']);
    }
    
}

if(isset($_POST['daftar_open_position_per_person']) && $_POST['daftar_open_position_per_person'] == "Input Open Position"){
    $id_pelamar = isset($_GET['id']) && $_GET['id'] != "" && is_numeric($_GET['id']) ? mysqli_real_escape_string($connect, $_GET['id']) : ""; 
    $query_nama_pelamar = mysqli_query($connect, "select nama_pelamar,nik from tbl_pelamar_master where id = '".$id_pelamar."'");
    $nik_pelamar = "";
    if(mysqli_num_rows($query_nama_pelamar) > 0){
        $hasil_nama_pelamar = mysqli_fetch_array($query_nama_pelamar);
        $nama_pelamar = $hasil_nama_pelamar['nama_pelamar'];
        $nik_pelamar = $hasil_nama_pelamar['nik'];
    }
    $id_position = mysqli_real_escape_string($connect, $_POST['id_position']);
    $bidang_pekerjaan = mysqli_real_escape_string($connect, $_POST['bidang_pekerjaan']);
    if($bidang_pekerjaan == ""){
        $_SESSION['count'] = 2;
        $_SESSION['keterangan'] = "Bidang Pekerjaan Tidak Boleh Kosong.";
        header("location: index.php?page=form-pelamar-open-position-perperson-add&id=" . $id_pelamar);
        exit();
    }
    $query_check = mysqli_query($connect, "select id from tbl_pelamar where nik = '".$nik_pelamar."' and id_position = '".$id_position."' and bidang_pekerjaan = '".$bidang_pekerjaan."'");
    if(mysqli_num_rows($query_check) == 0){
        $query_all = mysqli_query($connect, "select * from tbl_pelamar_master where id = '".$id_pelamar."'");
        if(mysqli_num_rows($query_all) > 0){
            $hasil_all = mysqli_fetch_array($query_all);
            mysqli_query($connect, "
                insert into tbl_pelamar set
                    id_position = '".$id_position."',
                    nama_pelamar = '".$hasil_all['nama_pelamar']."',
                    bidang_pekerjaan = '".$bidang_pekerjaan."',
                    
                    -- KTP
                    file_ktp = '".$hasil_all['file_ktp']."',
                    nik = '".$hasil_all['nik']."',
                    umur = '".$hasil_all['umur']."',
                    tempat_lahir = '".$hasil_all['tempat_lahir']."',
                    tanggal_lahir = '".$hasil_all['tanggal_lahir']."',
                    jenis_kelamin = '".$hasil_all['jenis_kelamin']."',
                    
                    ktp_confidence_nik = '0',
                    ktp_confidence_nama = '0',
                    ktp_confidence_tanggal_lahir = '0',
                    ktp_confidence_tempat_lahir = '0',
                    ktp_confidence_jenis_kelamin = '0',
                    
                    ktp_result_nik = '',
                    ktp_result_nama = '',
                    ktp_result_tanggal_lahir = '',
                    ktp_result_tempat_lahir = '',
                    ktp_result_jenis_kelamin = '',
                    
                    -- IJAZAH DAN TRANSKRIP S1
                    file_ijazah = '".$hasil_all['file_ijazah']."',
                    file_ijazah_sertifikat = '".$hasil_all['file_ijazah_sertifikat']."',
                    universitas = '".$hasil_all['universitas']."',
                    jurusan = '".$hasil_all['jurusan']."',
                    ipk = '".$hasil_all['ipk']."',
                    
                    -- TRANSKRIP S1 OCR
                    ijazah_confidence_nama = '0',
                    ijazah_confidence_universitas = '0',
                    ijazah_confidence_jurusan = '0',
                    ijazah_confidence_ipk = '0',
                    
                    ijazah_result_nama = '',
                    ijazah_result_universitas = '',
                    ijazah_result_jurusan = '',
                    ijazah_result_ipk = '',
                    
                    -- IJAZAH S1 OCR
                    ijazah_sertifikat_confidence_nama = '0',
                    ijazah_sertifikat_confidence_universitas = '0',
                    ijazah_sertifikat_confidence_jurusan = '0',
                    
                    ijazah_sertifikat_result_nama = '',
                    ijazah_sertifikat_result_universitas = '',
                    ijazah_sertifikat_result_jurusan = '',
                    
                    -- IJAZAH DAN TRANSKRIP S2
                    file_ijazah_s2 = '".$hasil_all['file_ijazah_s2']."',
                    file_ijazah_sertifikat_s2 = '".$hasil_all['file_ijazah_sertifikat_s2']."',
                    universitas_s2 = '".$hasil_all['universitas_s2']."',
                    jurusan_s2 = '".$hasil_all['jurusan_s2']."',
                    ipk_s2 = '".$hasil_all['ipk_s2']."',
                    
                    -- TRANSKRIP S2 OCR
                    ijazah_s2_confidence_nama = '0',
                    ijazah_s2_confidence_universitas = '0',
                    ijazah_s2_confidence_jurusan = '0',
                    ijazah_s2_confidence_ipk = '0',
                    
                    ijazah_s2_result_nama = '',
                    ijazah_s2_result_universitas = '',
                    ijazah_s2_result_jurusan = '',
                    ijazah_s2_result_ipk = '',
                    
                    -- IJAZAH S2 OCR
                    ijazah_s2_sertifikat_confidence_nama = '0',
                    ijazah_s2_sertifikat_confidence_universitas = '0',
                    ijazah_s2_sertifikat_confidence_jurusan = '0',
                    
                    ijazah_s2_sertifikat_result_nama = '',
                    ijazah_s2_sertifikat_result_universitas = '',
                    ijazah_s2_sertifikat_result_jurusan = ''
                    
            ");
            if(mysqli_affected_rows($connect) > 0){
                $_SESSION['count'] = 1;
                $_SESSION['keterangan'] = "Berhasil Insert Open Position.";
                header("location: index.php?page=form-pelamar-open-position-perperson&id=" . $id_pelamar);
            }
        } else {
            $_SESSION['count'] = 1;
            $_SESSION['keterangan'] = "Data Pelamar Tidak Tersedia.";
            header("location: index.php?page=form-pelamar-open-position-perperson&id=" . $id_pelamar);
        }
    } else {
        $_SESSION['count'] = 1;
        $_SESSION['keterangan'] = "Open Position Sudah Dilamar.";
        header("location: index.php?page=form-pelamar-open-position-perperson&id=" . $id_pelamar);
    }
}


if(isset($_POST['daftar_open_position_per_person']) && $_POST['daftar_open_position_per_person'] == "Update Open Position"){
    $id_pelamar = mysqli_real_escape_string($connect, $_POST['id_hidden']); 
    $id_pelamar_master = isset($_GET['id']) && $_GET['id'] != "" && is_numeric($_GET['id']) ? mysqli_real_escape_string($connect, $_GET['id']) : "";
    $query_nama_pelamar = mysqli_query($connect, "select nama_pelamar,nik from tbl_pelamar_master where id = '".$id_pelamar_master."'");
    $nik_pelamar = "";
    if(mysqli_num_rows($query_nama_pelamar) > 0){
        $hasil_nama_pelamar = mysqli_fetch_array($query_nama_pelamar);
        $nama_pelamar = $hasil_nama_pelamar['nama_pelamar'];
        $nik_pelamar = $hasil_nama_pelamar['nik'];
    }
    $id_open_position = isset($_GET['id_open_position']) && $_GET['id_open_position'] != "" && is_numeric($_GET['id_open_position']) ? mysqli_real_escape_string($connect, $_GET['id_open_position']) : "";
    $id_position = mysqli_real_escape_string($connect, $_POST['id_position']);
    $bidang_pekerjaan = mysqli_real_escape_string($connect, $_POST['bidang_pekerjaan']);
    if($bidang_pekerjaan == ""){
        $_SESSION['count'] = 2;
        $_SESSION['keterangan'] = "Bidang Pekerjaan Tidak Boleh Kosong.";
        header("location: index.php?page=pelamar-open-position-perperson-add&id=" . $id_pelamar);
        exit();
    }
    if($nik_pelamar == ""){
        $_SESSION['count'] = 2;
        $_SESSION['keterangan'] = "NIK Kosong.";
        header("location: index.php?page=form-pelamar-open-position-perperson&id=" . $id_pelamar_master);
        exit();
    }
    $query_check = mysqli_query($connect, "select id from tbl_pelamar where nik = '".$nik_pelamar."' and id_position = '".$id_position."' and bidang_pekerjaan = '".$bidang_pekerjaan."'");
    if(mysqli_num_rows($query_check) > 0){
        $_SESSION['count'] = 2;
        $_SESSION['keterangan'] = "Pilih Open Position yang Berbeda atau Open Position yang sama dengan Bidang berbeda.";
        header("location: index.php?page=form-pelamar-open-position-perperson&id=" . $id_pelamar_master);
        exit();
    }
    else if(mysqli_num_rows($query_check) == 0){
        $query_all = mysqli_query($connect, "select * from tbl_pelamar where id = '".$id_pelamar."'");
        if(mysqli_num_rows($query_all) > 0){
            $hasil_all = mysqli_fetch_array($query_all);
            
            mysqli_query($connect, "
                update tbl_pelamar set
                    id_position = '".$id_position."',
                    bidang_pekerjaan = '".$bidang_pekerjaan."'
                where id = '".$id_pelamar."' and id_position = '".$id_open_position."'
            ");
            if(mysqli_affected_rows($connect) > 0){
                $_SESSION['count'] = 1;
                $_SESSION['keterangan'] = "Berhasil Update Open Position.";
                header("location: index.php?page=form-pelamar-open-position-perperson&id=" . $id_pelamar_master);
            }
        } else {
            $_SESSION['count'] = 1;
            $_SESSION['keterangan'] = "Data Pelamar Tidak Tersedia.";
            header("location: index.php?page=form-pelamar-open-position-perperson&id=" . $id_pelamar_master);
        }
    } else {
        $_SESSION['count'] = 1;
        $_SESSION['keterangan'] = "Open Position Sudah Dilamar.";
        header("location: index.php?page=form-pelamar-open-position-perperson&id=" . $id_pelamar_master);
    }
}

// Upload Sertifikasi Lainnya
if(isset($_POST['daftar_sertifikasi_lainnya']) && $_POST['daftar_sertifikasi_lainnya'] == "Input Sertifikasi Lainnya"){
    $id_pelamar_hidden = mysqli_real_escape_string($connect, $_POST['id_pelamar_hidden']);
    $judul_sertifikasi = mysqli_real_escape_string($connect, $_POST['judul_sertifikasi']);
    $nama_file_sertifikasi = "";
    if(isset($_FILES['file_sertifikasi']) && is_array($_FILES['file_sertifikasi']) && (isset($_FILES['file_sertifikasi']['name']) && $_FILES['file_sertifikasi']['name'] != "")){
        $file_sertifikasi = $_FILES['file_sertifikasi'];
        $temp = $file_sertifikasi['tmp_name'];
        $name = $file_sertifikasi['name'];
        $expl = explode(".", $name);
        $type = $expl[sizeof($expl) - 1];
        $nama_file_sertifikasi = "SERTIFIKASIPELAMAR" . date("Ymd") . date("His") . "." . $type;
        move_uploaded_file($temp, "../ocrapi/upload/sertifikasi_lainnya/" . $nama_file_sertifikasi);
    }
    mysqli_query($connect, "
        insert into tbl_serifikasi_tambahan set
        id_pelamar = '".$id_pelamar_hidden."',
        judul_sertifikasi = '".$judul_sertifikasi."',
        file_sertifikasi = '".$nama_file_sertifikasi."'
    ");
    if(mysqli_affected_rows($connect) > 0){
        $_SESSION['count'] = 1;
        $_SESSION['keterangan'] = "Berhasil Insert Sertifikasi Lainnya.";
        header("location: index.php?page=form-pelamar-other-cert&id=" . $id_pelamar_hidden);
    } else {
        $_SESSION['count'] = 1;
        $_SESSION['keterangan'] = "Gagal Insert Sertifikasi Lainnya.";
        header("location: index.php?page=form-pelamar-other-cert&id=" . $id_pelamar_hidden);
    }
    
}

if(isset($_POST['daftar_sertifikasi_lainnya']) && $_POST['daftar_sertifikasi_lainnya'] == "Update Sertifikasi Lainnya"){
    $id_sertifikasi_tambahan = isset($_GET['id_sertifikasi_tambahan']) ? mysqli_real_escape_string($connect, $_GET['id_sertifikasi_tambahan']) : "";
    $id_pelamar_hidden = mysqli_real_escape_string($connect, $_POST['id_pelamar_hidden']);
    $judul_sertifikasi = mysqli_real_escape_string($connect, $_POST['judul_sertifikasi']);
    $nama_file_sertifikasi = "";
    $nama_file_sertifikasi_temp = mysqli_real_escape_string($connect, $_POST['file_sertifikasi_hidden']);
    if(isset($_FILES['file_sertifikasi']) && is_array($_FILES['file_sertifikasi']) && (isset($_FILES['file_sertifikasi']['name']) && $_FILES['file_sertifikasi']['name'] != "")){
        $file_sertifikasi = $_FILES['file_sertifikasi'];
        $temp = $file_sertifikasi['tmp_name'];
        $name = $file_sertifikasi['name'];
        $expl = explode(".", $name);
        $type = $expl[sizeof($expl) - 1];
        $nama_file_sertifikasi = "SERTIFIKASIPELAMAR" . date("Ymd") . date("His") . "." . $type;
        if(move_uploaded_file($temp, "../ocrapi/upload/sertifikasi_lainnya/" . $nama_file_sertifikasi)){
            if($nama_file_sertifikasi_temp != "" && file_exists("../ocrapi/upload/sertifikasi_lainnya/" . $nama_file_sertifikasi_temp)){
                unlink("../ocrapi/upload/sertifikasi_lainnya/" . $nama_file_sertifikasi_temp);
            }
        }
    } else {
        $nama_file_sertifikasi = $nama_file_sertifikasi_temp;
    }
    mysqli_query($connect, "
        update tbl_serifikasi_tambahan set
        id_pelamar = '".$id_pelamar_hidden."',
        judul_sertifikasi = '".$judul_sertifikasi."',
        file_sertifikasi = '".$nama_file_sertifikasi."'
        where id = '".$id_sertifikasi_tambahan."'
    ");
    if(mysqli_affected_rows($connect) > 0){
        $_SESSION['count'] = 1;
        $_SESSION['keterangan'] = "Berhasil Update Sertifikasi Lainnya.";
        header("location: index.php?page=form-pelamar-other-cert&id=" . $id_pelamar_hidden);
    } else {
        $_SESSION['count'] = 1;
        $_SESSION['keterangan'] = "Gagal Update Sertifikasi Lainnya.";
        header("location: index.php?page=form-pelamar-other-cert&id=" . $id_pelamar_hidden);
    }
    
}

// Add Bahasa
if(isset($_POST['daftar_ketrampilan_bahasa']) && $_POST['daftar_ketrampilan_bahasa'] == "Input Ketrampilan Bahasa"){
    $id_pelamar_master = isset($_GET['id']) && $_GET['id'] != "" && is_numeric($_GET['id']) ? mysqli_real_escape_string($connect, $_GET['id']) : "";
    $nama_bahasa = mysqli_real_escape_string($connect, $_POST['nama_bahasa']);
    $tingkat_lisan = mysqli_real_escape_string($connect, $_POST['tingkat_lisan']);
    $tingkat_tulisan = mysqli_real_escape_string($connect, $_POST['tingkat_tulisan']);
    $urutan_bahasa = mysqli_real_escape_string($connect, $_POST['urutan_bahasa']);
    mysqli_query($connect, "
        insert into tbl_ketrampilan_bahasa set
        nama_bahasa = '".$nama_bahasa."',
        tingkat_lisan = '".$tingkat_lisan."',
        tingkat_tulisan = '".$tingkat_tulisan."',
        urutan_bahasa = '".$urutan_bahasa."',
        id_pelamar = '".$id_pelamar_master."'
    ");
    if(mysqli_affected_rows($connect) > 0){
        $_SESSION['count'] = 1;
        $_SESSION['keterangan'] = "Berhasil Insert Ketrampilan Bahasa.";
        header("location: index.php?page=form-pelamar-languague-perperson&id=" . $id_pelamar_master);
    } else {
        $_SESSION['count'] = 1;
        $_SESSION['keterangan'] = "Gagal Insert Ketrampilan Bahasa.";
        header("location: index.php?page=form-pelamar-languague-perperson&id=" . $id_pelamar_master);
    }
}

if(isset($_POST['daftar_ketrampilan_bahasa']) && $_POST['daftar_ketrampilan_bahasa'] == "Update Ketrampilan Bahasa"){
    $id_pelamar_master = isset($_GET['id']) && $_GET['id'] != "" && is_numeric($_GET['id']) ? mysqli_real_escape_string($connect, $_GET['id']) : "";
    $id_bahasa = isset($_GET['id_bahasa']) && $_GET['id_bahasa'] != "" && is_numeric($_GET['id_bahasa']) ? mysqli_real_escape_string($connect, $_GET['id_bahasa']) : "";
    $nama_bahasa = mysqli_real_escape_string($connect, $_POST['nama_bahasa']);
    $tingkat_lisan = mysqli_real_escape_string($connect, $_POST['tingkat_lisan']);
    $tingkat_tulisan = mysqli_real_escape_string($connect, $_POST['tingkat_tulisan']);
    $urutan_bahasa = mysqli_real_escape_string($connect, $_POST['urutan_bahasa']);
    mysqli_query($connect, "
        update tbl_ketrampilan_bahasa set
        nama_bahasa = '".$nama_bahasa."',
        tingkat_lisan = '".$tingkat_lisan."',
        tingkat_tulisan = '".$tingkat_tulisan."',
        urutan_bahasa = '".$urutan_bahasa."'
        where id_pelamar = '".$id_pelamar_master."' and
        id = '".$id_bahasa."'
    ");
    if(mysqli_affected_rows($connect) > 0){
        $_SESSION['count'] = 1;
        $_SESSION['keterangan'] = "Berhasil Update Ketrampilan Bahasa.";
        header("location: index.php?page=form-pelamar-languague-perperson&id=" . $id_pelamar_master);
    } else {
        $_SESSION['count'] = 1;
        $_SESSION['keterangan'] = "Gagal Update Ketrampilan Bahasa.";
        header("location: index.php?page=form-pelamar-languague-perperson&id=" . $id_pelamar_master);
    }
}

// Add Ketrampilan
if(isset($_POST['daftar_ketrampilan_lainnya']) && $_POST['daftar_ketrampilan_lainnya'] == "Input Ketrampilan Lainnya"){
    $id_pelamar_master = isset($_GET['id']) && $_GET['id'] != "" && is_numeric($_GET['id']) ? mysqli_real_escape_string($connect, $_GET['id']) : "";
    $nama_ketrampilan = mysqli_real_escape_string($connect, $_POST['nama_ketrampilan']);
    $tingkat_ketrampilan = mysqli_real_escape_string($connect, $_POST['tingkat_ketrampilan']);
    mysqli_query($connect, "
        insert into tbl_ketrampilan_lainnya set
        nama_ketrampilan = '".$nama_ketrampilan."',
        tingkat_ketrampilan = '".$tingkat_ketrampilan."',
        id_pelamar = '".$id_pelamar_master."'
    ");
    if(mysqli_affected_rows($connect) > 0){
        $_SESSION['count'] = 1;
        $_SESSION['keterangan'] = "Berhasil Insert Ketrampilan Lainnya.";
        header("location: index.php?page=form-pelamar-skill-perperson&id=" . $id_pelamar_master);
    } else {
        $_SESSION['count'] = 1;
        $_SESSION['keterangan'] = "Gagal Insert Ketrampilan Lainnya.";
        header("location: index.php?page=form-pelamar-skill-perperson&id=" . $id_pelamar_master);
    }
}

if(isset($_POST['daftar_ketrampilan_lainnya']) && $_POST['daftar_ketrampilan_lainnya'] == "Update Ketrampilan Lainnya"){
    $id_pelamar_master = isset($_GET['id']) && $_GET['id'] != "" && is_numeric($_GET['id']) ? mysqli_real_escape_string($connect, $_GET['id']) : "";
    $id_ketrampilan = isset($_GET['id_ketrampilan']) && $_GET['id_ketrampilan'] != "" && is_numeric($_GET['id_ketrampilan']) ? mysqli_real_escape_string($connect, $_GET['id_ketrampilan']) : "";
    $nama_ketrampilan = mysqli_real_escape_string($connect, $_POST['nama_ketrampilan']);
    $tingkat_ketrampilan = mysqli_real_escape_string($connect, $_POST['tingkat_ketrampilan']);
    mysqli_query($connect, "
        update tbl_ketrampilan_lainnya set
        nama_ketrampilan = '".$nama_ketrampilan."',
        tingkat_ketrampilan = '".$tingkat_ketrampilan."' where
        id_pelamar = '".$id_pelamar_master."' and
        id = '".$id_ketrampilan."'
    ");
    if(mysqli_affected_rows($connect) > 0){
        $_SESSION['count'] = 1;
        $_SESSION['keterangan'] = "Berhasil Update Ketrampilan Lainnya.";
        header("location: index.php?page=form-pelamar-skill-perperson&id=" . $id_pelamar_master);
    } else {
        $_SESSION['count'] = 1;
        $_SESSION['keterangan'] = "Gagal Update Ketrampilan Lainnya.";
        header("location: index.php?page=form-pelamar-skill-perperson&id=" . $id_pelamar_master);
    }
}

// Upload Excel
if(isset($_POST['upload_excel']) && $_POST['upload_excel'] == "Upload Excel"){
    if(isset($_FILES['file_excel']) && is_array($_FILES['file_excel'])){
        $name = $_FILES['file_excel']['name'];
        $temp = $_FILES['file_excel']['tmp_name'];
        $explode_titik = explode(".", $name);
        $type = $explode_titik[sizeof($explode_titik) - 1];
        $namefile = "EXCELIMPORT" . date("YmdHis") . "." . $type;
        if($name != "" && file_exists("excel/file/" . $namefile)){
            $_SESSION['count'] = 2;
            $_SESSION['keterangan'] = "File Excel dengan nama yang sama sudah pernah diupload.";
            header("location: index.php?page=upload-sso");
            exit();
        } else {
            if(move_uploaded_file($temp, "excel/file/" . $namefile)){
                $_SESSION['count'] = 2;
                $_SESSION['keterangan'] = "File Excel berhasil diupload.";
                mysqli_query($connect, "
                    insert into tbl_proses_excel_log 
                    set nama_file = '".$namefile."'
                ");
                shell_exec("php /var/www/html/ocr-dashboard-backend/excel/sheets-sso.php " . $namefile . " > /dev/null 2>/dev/null &");
                header("location: index.php?page=upload-sso-view");
                exit();
            } else {
                $_SESSION['count'] = 2;
                $_SESSION['keterangan'] = "File Excel gagal diupload.";
                header("location: index.php?page=upload-sso-view");
                exit();
            }
        }
    }
}