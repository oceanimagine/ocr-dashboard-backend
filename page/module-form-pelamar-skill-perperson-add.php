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
$button_label = "Input Ketrampilan Lainnya";

$query_nama_pelamar = mysqli_query($connect, "select nama_pelamar from tbl_pelamar_master where id = '".$id_pelamar."'");
if(mysqli_num_rows($query_nama_pelamar) > 0){
    $hasil_nama_pelamar = mysqli_fetch_array($query_nama_pelamar);
    $nama_pelamar = $hasil_nama_pelamar['nama_pelamar'];
}

$nama_ketrampilan = "";
$tingkat_ketrampilan = "";
if(isset($_GET['id_ketrampilan']) && $_GET['id_ketrampilan'] != "" && is_numeric($_GET['id_ketrampilan'])){
    $id_ketrampilan = mysqli_real_escape_string($connect, $_GET['id_ketrampilan']);
    $query_tampil = mysqli_query($connect, "
        SELECT 
            id,
            nama_ketrampilan, 
            tingkat_ketrampilan
        FROM `tbl_ketrampilan_lainnya` where id_pelamar = '".$id_pelamar."' and id = '".$id_ketrampilan."'
    ");
    if(mysqli_num_rows($query_tampil) > 0){
        $button_label = "Update Ketrampilan Lainnya";
        $hasil_tampil = mysqli_fetch_array($query_tampil);
        $nama_ketrampilan = $hasil_tampil['nama_ketrampilan'];
        $tingkat_ketrampilan = $hasil_tampil['tingkat_ketrampilan'];
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
            <label for="nama_ketrampilan" class="control-label" style="margin-bottom: 0px; margin-top: 6px;">Nama Ketrampilan</label>
        </div>
        <div class="col-lg-10">
            <input placeholder="Nama Ketrampilan" type="text" id="nama_ketrampilan" name="nama_ketrampilan" class="form-control" value="<?php echo $nama_ketrampilan; ?>" />
        </div>
    </div>
    <div class="row" style="margin-bottom: 10px;">
        <div class="col-lg-2">
            <label for="tingkat_ketrampilan" class="control-label" style="margin-bottom: 0px; margin-top: 6px;">Tingkat Lisan</label>
        </div>
        <div class="col-lg-10">
            <select name="tingkat_ketrampilan" id="tingkat_ketrampilan" class="form-control">
                <option value="">-- PILIH --</option>
                <option value="Junior"<?php echo $tingkat_ketrampilan == "Junior" ? " selected" : ""; ?>>Junior</option>
                <option value="Middle"<?php echo $tingkat_ketrampilan == "Middle" ? " selected" : ""; ?>>Middle</option>
                <option value="Senior"<?php echo $tingkat_ketrampilan == "Senior" ? " selected" : ""; ?>>Senior</option>
            </select>
        </div>
    </div>
    
    <div class="row" style="margin-top: 25px;">
        <div class="col-lg-6" style="height: 34px;">
            <button style="width: 100%; margin-bottom: 10px;" type="submit" class="btn btn-info pull-right bg-green-gradient" name="daftar_ketrampilan_lainnya" value="<?php echo $button_label; ?>"><?php echo $button_label; ?></button>
        </div>
        <div class="col-lg-6">
            <button style="width: 100%; margin-bottom: 10px;" type="button" class="btn btn-default bg-aqua-gradient" onclick="document.location='index.php?page=form-pelamar-skill-perperson&id=<?php echo $id_pelamar; ?>';">Show Data</button>
        </div>
    </div>
</form>