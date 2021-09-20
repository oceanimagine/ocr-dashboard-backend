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
check_page("form-pelamar-other-cert-add");

$id_pelamar = isset($_GET['id']) ? mysqli_real_escape_string($connect, $_GET['id']) : "";
$nama_pelamar = "";
$judul_sertifikasi = "";
$file_sertifikasi_lainnya = "";
$nama_file_sertifikasi = "";
$button_label = "Input Sertifikasi Lainnya";

$query_nama_pelamar = mysqli_query($connect, "select nama_pelamar from tbl_pelamar_master where id = '".$id_pelamar."'");
if(mysqli_num_rows($query_nama_pelamar) > 0){
    $hasil_nama_pelamar = mysqli_fetch_array($query_nama_pelamar);
    $nama_pelamar = $hasil_nama_pelamar['nama_pelamar'];
}

if(isset($_GET['id_sertifikasi_tambahan']) && $_GET['id_sertifikasi_tambahan'] != "" && is_numeric($_GET['id_sertifikasi_tambahan'])){
    $id_sertifikasi_tambahan = mysqli_real_escape_string($connect, $_GET['id_sertifikasi_tambahan']);
    $query_tampil = mysqli_query($connect, "SELECT a.`id`, a.`nama_pelamar`, b.file_sertifikasi, b.judul_sertifikasi FROM `tbl_pelamar_master` a, `tbl_serifikasi_tambahan` b where a.`id` = b.id_pelamar and b.id_pelamar = '".$id_pelamar."' and b.id = '".$id_sertifikasi_tambahan."'");
    if(mysqli_num_rows($query_tampil) > 0){
        $button_label = "Update Sertifikasi Lainnya";
        $hasil_tampil = mysqli_fetch_array($query_tampil);
        $nama_pelamar = $hasil_tampil['nama_pelamar'];
        $judul_sertifikasi = $hasil_tampil['judul_sertifikasi'];
        $nama_file_sertifikasi = "<input type='hidden' name='file_sertifikasi_hidden' />";
        if($hasil_tampil['file_sertifikasi'] != "" && file_exists("../ocrapi/upload/sertifikasi_lainnya/" . $hasil_tampil['file_sertifikasi'])){
            $nama_file_sertifikasi = "
                <div id=\"create_div\" style=\"border-radius: .25rem; width: 100%; margin-top: 4px; border-top: 1px solid rgb(208, 208, 208); border-right: 1px solid rgb(208, 208, 208); border-left: 1px solid rgb(208, 208, 208); padding: 5px;\" align=\"center\">
                    <a href='../ocrapi/".$folder."/TOKENACCESS--".$GLOBALS['token']."--sertifikasi_lainnya--" . $hasil_tampil['file_sertifikasi']."' target='_blank'>Download</a>
                    <input type='hidden' name='file_sertifikasi_hidden' value='".$hasil_tampil['file_sertifikasi']."' />
                </div>
            "; 
        }
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
            <label for="judul_sertifikasi" class="control-label" style="margin-bottom: 0px; margin-top: 6px;">Judul Sertifikasi</label>
        </div>
        <div class="col-lg-10">
            <input placeholder="Judul Sertifikasi" type="text" id="judul_sertifikasi" name="judul_sertifikasi" class="form-control" value="<?php echo $judul_sertifikasi; ?>" />
        </div>
    </div>
    <div class="row" style="margin-bottom: 10px;">
        <div class="col-lg-2">
            <label for="file_sertifikasi" class="control-label" style="margin-bottom: 0px; margin-top: 6px;">File Transkrip Nilai S1</label>
        </div>
        <div class="col-lg-10">
            <?php echo $nama_file_sertifikasi; ?>
            <input type="file" name="file_sertifikasi" id="file_sertifikasi" class="form-control" />
        </div>
    </div>
    <div class="row" style="margin-top: 25px;">
        <div class="col-lg-6" style="height: 34px;">
            <button style="width: 100%; margin-bottom: 10px;" type="submit" class="btn btn-info pull-right bg-green-gradient" name="daftar_sertifikasi_lainnya" value="<?php echo $button_label; ?>"><?php echo $button_label; ?></button>
        </div>
        <div class="col-lg-6">
            <button style="width: 100%; margin-bottom: 10px;" type="button" class="btn btn-default bg-aqua-gradient" onclick="document.location='index.php?page=form-pelamar-other-cert&id=<?php echo $id_pelamar; ?>';">Show Data</button>
        </div>
    </div>
</form>