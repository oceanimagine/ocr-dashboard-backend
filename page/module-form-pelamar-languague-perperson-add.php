<?php

if (session_status() != PHP_SESSION_ACTIVE) {
    session_start();
}
function check_page($redirect){
    if(isset($_SESSION['username']) && isset($_SESSION['password'])){
        if(!isset($_GET['page'])){
            header("location: ../index.php?page=" . $redirect);
        }
    } else {
        if(isset($_GET['page'])){
            header("location: login.php");
        } else {
            header("location: ../login.php");
        }
    }
}
check_page("form-pelamar-languague-perperson-add");

$id_pelamar = isset($_GET['id']) ? mysqli_real_escape_string($connect, $_GET['id']) : "";
$nama_pelamar = "";
$judul_sertifikasi = "";
$file_sertifikasi_lainnya = "";
$nama_file_sertifikasi = "";
$button_label = "Input Ketrampilan Bahasa";

$query_nama_pelamar = mysqli_query($connect, "select nama_pelamar from tbl_pelamar_master where id = '".$id_pelamar."'");
if(mysqli_num_rows($query_nama_pelamar) > 0){
    $hasil_nama_pelamar = mysqli_fetch_array($query_nama_pelamar);
    $nama_pelamar = $hasil_nama_pelamar['nama_pelamar'];
}

$nama_bahasa = "";
$tingkat_lisan = "";
$tingkat_tulisan = "";
$urutan_bahasa = "";
if(isset($_GET['id_bahasa']) && $_GET['id_bahasa'] != "" && is_numeric($_GET['id_bahasa'])){
    $id_bahasa = mysqli_real_escape_string($connect, $_GET['id_bahasa']);
    $query_tampil = mysqli_query($connect, "
        SELECT 
            id,
            nama_bahasa, 
            tingkat_lisan, 
            tingkat_tulisan, 
            urutan_bahasa 
        FROM `tbl_ketrampilan_bahasa` where id_pelamar = '".$id_pelamar."' and id = '".$id_bahasa."'
    ");
    if(mysqli_num_rows($query_tampil) > 0){
        $button_label = "Update Ketrampilan Bahasa";
        $hasil_tampil = mysqli_fetch_array($query_tampil);
        $nama_bahasa = $hasil_tampil['nama_bahasa'];
        $tingkat_lisan = $hasil_tampil['tingkat_lisan'];
        $tingkat_tulisan = $hasil_tampil['tingkat_tulisan'];
        $urutan_bahasa = $hasil_tampil['urutan_bahasa'];
    }
}

?>

<form method="POST" enctype="multipart/form-data">
    <div class="row" style="margin-bottom: 10px;">
        <div class="col-lg-2">
            <label for="nama_pelamar" class="control-label" style="margin-bottom: 0px; margin-top: 6px;">Nama Pelamar</label>
        </div>
        <div class="col-lg-10">
            <input type="hidden" name="id_pelamar_hidden" value="<?php echo $id_pelamar; ?>" />
            <input placeholder="Nama Pelamar" type="text" id="nama_pelamar" disabled="disabled" name="nama_pelamar" class="form-control" value="<?php echo $nama_pelamar; ?>" />
        </div>
    </div>
    <div class="row" style="margin-bottom: 10px;">
        <div class="col-lg-2">
            <label for="nama_bahasa" class="control-label" style="margin-bottom: 0px; margin-top: 6px;">Nama Bahasa</label>
        </div>
        <div class="col-lg-10">
            <input placeholder="Nama Bahasa" type="text" id="nama_bahasa" name="nama_bahasa" class="form-control" value="<?php echo $nama_bahasa; ?>" />
        </div>
    </div>
    <div class="row" style="margin-bottom: 10px;">
        <div class="col-lg-2">
            <label for="tingkat_lisan" class="control-label" style="margin-bottom: 0px; margin-top: 6px;">Tingkat Lisan</label>
        </div>
        <div class="col-lg-10">
            <select name="tingkat_lisan" id="tingkat_lisan" class="form-control">
                <option value="">-- PILIH --</option>
                <option value="Kurang"<?php echo $tingkat_lisan == "Kurang" ? " selected" : ""; ?>>Kurang</option>
                <option value="Cukup"<?php echo $tingkat_lisan == "Cukup" ? " selected" : ""; ?>>Cukup</option>
                <option value="Baik"<?php echo $tingkat_lisan == "Baik" ? " selected" : ""; ?>>Baik</option>
            </select>
        </div>
    </div>
    <div class="row" style="margin-bottom: 10px;">
        <div class="col-lg-2">
            <label for="tingkat_tulisan" class="control-label" style="margin-bottom: 0px; margin-top: 6px;">Tingkat Tulisan</label>
        </div>
        <div class="col-lg-10">
            <select name="tingkat_tulisan" id="tingkat_tulisan" class="form-control">
                <option value="">-- PILIH --</option>
                <option value="Kurang"<?php echo $tingkat_tulisan == "Kurang" ? " selected" : ""; ?>>Kurang</option>
                <option value="Cukup"<?php echo $tingkat_tulisan == "Cukup" ? " selected" : ""; ?>>Cukup</option>
                <option value="Baik"<?php echo $tingkat_tulisan == "Baik" ? " selected" : ""; ?>>Baik</option>
            </select>
        </div>
    </div>
    <div class="row" style="margin-bottom: 10px;">
        <div class="col-lg-2">
            <label for="urutan_bahasa" class="control-label" style="margin-bottom: 0px; margin-top: 6px;">Urutan Bahasa</label>
        </div>
        <div class="col-lg-10">
            <select name="urutan_bahasa" id="urutan_bahasa" class="form-control">
                <option value="">-- PILIH --</option>
                <option value="Ke 1 atau Bahasa Ibu"<?php echo $urutan_bahasa == "Ke 1 atau Bahasa Ibu" ? " selected" : ""; ?>>Ke 1 atau Bahasa Ibu</option>
                <option value="Ke 2 atau Bahasa Tambahan"<?php echo $urutan_bahasa == "Ke 2 atau Bahasa Tambahan" ? " selected" : ""; ?>>Ke 2 atau Bahasa Tambahan</option>
            </select>
        </div>
    </div>
    
    <div class="row" style="margin-top: 25px;">
        <div class="col-lg-6" style="height: 34px;">
            <button style="width: 100%; margin-bottom: 10px;" type="submit" class="btn btn-info pull-right bg-green-gradient" name="daftar_ketrampilan_bahasa" value="<?php echo $button_label; ?>"><?php echo $button_label; ?></button>
        </div>
        <div class="col-lg-6">
            <button style="width: 100%; margin-bottom: 10px;" type="button" class="btn btn-default bg-aqua-gradient" onclick="document.location='index.php?page=form-pelamar-languague-perperson&id=<?php echo $id_pelamar; ?>';">Show Data</button>
        </div>
    </div>
</form>