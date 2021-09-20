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
check_page("form-pelamar-open-position-perperson-add");
$id_pelamar = isset($_GET['id']) && $_GET['id'] != "" && is_numeric($_GET['id']) ? mysqli_real_escape_string($connect, $_GET['id']) : ""; 
$id_open_position = isset($_GET['id_open_position']) && $_GET['id_open_position'] != "" && is_numeric($_GET['id_open_position']) ? mysqli_real_escape_string($connect, $_GET['id_open_position']) : ""; 
$id_position = "";
$button_label = "Input Open Position";

$nama_pelamar = "";
$bidang_pekerjaan = "";
$nik_pelamar = "";
$query_nama_pelamar = mysqli_query($connect, "select nama_pelamar,nik from tbl_pelamar_master where id = '".$id_pelamar."'");
if(mysqli_num_rows($query_nama_pelamar) > 0){
    $hasil_nama_pelamar = mysqli_fetch_array($query_nama_pelamar);
    $nama_pelamar = $hasil_nama_pelamar['nama_pelamar'];
    $nik_pelamar = $hasil_nama_pelamar['nik'];
}

$id_active = "";
if(isset($_GET['id_open_position']) && $_GET['id_open_position'] != "" && is_numeric($_GET['id_open_position'])){
    $button_label = "Update Open Position";
    $query_active = mysqli_query($connect, "select id, bidang_pekerjaan from tbl_pelamar where nik = '".$nik_pelamar."' and id_position = '".$id_open_position."'");
    if(mysqli_num_rows($query_active) > 0){
        $hasil_active = mysqli_fetch_array($query_active);
        $id_active = $hasil_active['id'];
        $bidang_pekerjaan = $hasil_active['bidang_pekerjaan'];
    }
}





?>

<form method="POST" enctype="multipart/form-data">
    <div class="row" style="margin-bottom: 10px;">
        <div class="col-lg-2">
            <label for="nama_pelamar" class="control-label" style="margin-bottom: 0px; margin-top: 6px;">Nama Pelamar</label>
        </div>
        <div class="col-lg-10">
            <input type="hidden" name="id_hidden" value="<?php echo $id_active; ?>" />
            <input placeholder="Nama Pelamar" disabled="disabled" type="text" id="nama_pelamar" name="nama_pelamar" class="form-control" value="<?php echo $nama_pelamar; ?>" />
        </div>
    </div>
    <div class="row" style="margin-bottom: 10px;">
        <div class="col-lg-2">
            <label for="bidang_pekerjaan" class="control-label" style="margin-bottom: 0px; margin-top: 6px;">Bidang Pekerjaan</label>
        </div>
        <div class="col-lg-10">
            <input placeholder="Bidang Pekerjaan" type="text" id="bidang_pekerjaan" name="bidang_pekerjaan" class="form-control" value="<?php echo $bidang_pekerjaan; ?>" />
        </div>
    </div>
    <div class="row" style="margin-bottom: 10px;">
        <div class="col-lg-2">
            <label for="id_position" class="control-label" style="margin-bottom: 0px; margin-top: 6px;">Posisi Lamaran</label>
        </div>
        <div class="col-lg-10">
            <select name="id_position" id="id_position" class="form-control">
                <option value="">PILIH</option>
                <?php 

                $query_position = mysqli_query($connect, "select id, open_position from tbl_event");
                if(mysqli_num_rows($query_position) > 0){
                    while($hasil_position = mysqli_fetch_array($query_position)){
                        $selected = $id_open_position == $hasil_position['id'] ? " selected='selected'" : "";
                        echo "<option value='".$hasil_position['id']."'".$selected.">".$hasil_position['open_position']."</option>";
                    }
                }
                ?>
            </select>
        </div>
    </div>
    
    <div class="row" style="margin-top: 25px;">
        <div class="col-lg-6" style="height: 34px;">
            <button style="width: 100%; margin-bottom: 10px;" type="submit" class="btn btn-info pull-right bg-green-gradient" name="daftar_open_position_per_person" value="<?php echo $button_label; ?>"><?php echo $button_label; ?></button>
        </div>
        <div class="col-lg-6">
            <button style="width: 100%; margin-bottom: 10px;" type="button" class="btn btn-default bg-aqua-gradient" onclick="document.location='index.php?page=form-pelamar-open-position-perperson&id=<?php echo $id_pelamar; ?>';">Show Data</button>
        </div>
    </div>
</form>