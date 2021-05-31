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
    $nama_pelamar = mysqli_real_escape_string($connect, $_POST['nama_pelamar']);
    $nik = mysqli_real_escape_string($connect, $_POST['nik']);
    $umur = mysqli_real_escape_string($connect, $_POST['umur']);
    $tempat_lahir = mysqli_real_escape_string($connect, $_POST['tempat_lahir']);
    $tanggal_lahir = mysqli_real_escape_string($connect, $_POST['tanggal_lahir']);
    $universitas = mysqli_real_escape_string($connect, $_POST['universitas']);
    $jurusan = mysqli_real_escape_string($connect, $_POST['jurusan']);
    $ipk = mysqli_real_escape_string($connect, $_POST['ipk']);
    $username = mysqli_real_escape_string($connect, $_POST['username']);
    $password = mysqli_real_escape_string($connect, $_POST['password']);
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
        
        $nama_file_ijazah_sertifikat = "";
        if(isset($_FILES['file_ijazah_sertifikat']) && is_array($_FILES['file_ijazah_sertifikat'])){
            $file_ijazah_sertifikat = $_FILES['file_ijazah_sertifikat'];
            $temp = $file_ijazah_sertifikat['tmp_name'];
            $name = $file_ijazah_sertifikat['name'];
            $expl = explode(".", $name);
            $type = $expl[sizeof($expl) - 1];
            $nama_file_ijazah_sertifikat = "IJAZAHSERTIFIKAT" . date("Ymd") . date("His") . "." . $type;
            move_uploaded_file($temp, "../ocrapi/upload/ijazah_sertifikat/" . $nama_file_ijazah_sertifikat);
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
                file_ijazah_sertifikat
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
                '".$nama_file_ijazah_sertifikat."'
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
        if(move_uploaded_file($temp, "../ocrapi/upload/ijazah_sertifikat/" . $nama_file_ijazah)){
            if($nama_file_ijazah_temp != "" && file_exists("../ocrapi/upload/ijazah_sertifikat/" . $nama_file_ijazah_sertifikat_temp)){
                unlink("../ocrapi/upload/ijazah_sertifikat/" . $nama_file_ijazah_sertifikat_temp);
            }
        }
    } else {
        $nama_file_ijazah_sertifikat = $nama_file_ijazah_sertifikat_temp;
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
            file_ijazah_sertifikat = '".$nama_file_ijazah_sertifikat."'
        where id = '".$_GET['id']."'
    ");
    if(mysqli_affected_rows($connect) > 0){
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
    $query_check = mysqli_query($connect, "select id from tbl_pelamar where nik = '".$nik_pelamar."' and id_position = '".$id_position."'");
    if(mysqli_num_rows($query_check) == 0){
        $query_all = mysqli_query($connect, "select * from tbl_pelamar_master where id = '".$id_pelamar."'");
        if(mysqli_num_rows($query_all) > 0){
            $hasil_all = mysqli_fetch_array($query_all);
            mysqli_query($connect, "
                insert into tbl_pelamar set
                    id_position = '".$id_position."',
                    nama_pelamar = '".$hasil_all['nama_pelamar']."',
                    nik = '".$hasil_all['nik']."',
                    umur = '".$hasil_all['umur']."',
                    tempat_lahir = '".$hasil_all['tempat_lahir']."',
                    tanggal_lahir = '".$hasil_all['tanggal_lahir']."',
                    universitas = '".$hasil_all['universitas']."',
                    jurusan = '".$hasil_all['jurusan']."',
                    ipk = '".$hasil_all['ipk']."',
                    file_ktp = '".$hasil_all['file_ktp']."',
                    file_ijazah = '".$hasil_all['file_ijazah']."',
                    jenis_kelamin = '".$hasil_all['jenis_kelamin']."',
                    ktp_confidence_nik = '0',
                    ktp_confidence_nama = '0',
                    ktp_confidence_tanggal_lahir = '0',
                    ktp_confidence_tempat_lahir = '0',
                    ktp_result_nik = '',
                    ktp_result_nama = '',
                    ktp_result_tanggal_lahir = '',
                    ktp_result_tempat_lahir = '',
                    ijazah_confidence_nama = '0',
                    ijazah_confidence_universitas = '0',
                    ijazah_confidence_jurusan = '0',
                    ijazah_confidence_ipk = '0',
                    ijazah_result_nama = '0',
                    ijazah_result_universitas = '',
                    ijazah_result_jurusan = '',
                    ijazah_result_ipk = ''
                    
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
    if($nik_pelamar == ""){
        $_SESSION['count'] = 2;
        $_SESSION['keterangan'] = "NIK Kosong.";
        header("location: index.php?page=form-pelamar-open-position-perperson&id=" . $id_pelamar_master);
        exit();
    }
    if($id_open_position != $id_position){
        $query_check = mysqli_query($connect, "select id from tbl_pelamar where nik = '".$nik_pelamar."' and id_position = '".$id_position."'");
    } else {
        $_SESSION['count'] = 2;
        $_SESSION['keterangan'] = "Pilih Open Position yang Berbeda.";
        header("location: index.php?page=form-pelamar-open-position-perperson&id=" . $id_pelamar_master);
        exit();
    }
    if(mysqli_num_rows($query_check) == 0){
        $query_all = mysqli_query($connect, "select * from tbl_pelamar where id = '".$id_pelamar."'");
        if(mysqli_num_rows($query_all) > 0){
            $hasil_all = mysqli_fetch_array($query_all);
            
            mysqli_query($connect, "
                update tbl_pelamar set
                    id_position = '".$id_position."'
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