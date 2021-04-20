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
check_page("form-jurusan-add");

$jurusan = "";
$button_label = "Input Jurusan";
if(isset($_GET['id']) && $_GET['id'] != "" && is_numeric($_GET['id'])){
    $id = mysqli_real_escape_string($connect, $_GET['id']);
    $query_tampil = mysqli_query($connect, "select * from tbl_jurusan where id = '".$id."'");
    if(mysqli_num_rows($query_tampil) > 0){
        $button_label = "Update Jurusan";
        $hasil_tampil = mysqli_fetch_array($query_tampil);
        $jurusan = $hasil_tampil['jurusan'];
        
    }
}


?>

<form method="POST" enctype="multipart/form-data">
    <div class="row" style="margin-bottom: 10px;">
        <div class="col-lg-2">
            <label for="nama_jurusan" class="control-label" style="margin-bottom: 0px; margin-top: 6px;">Nama Jurusan</label>
        </div>
        <div class="col-lg-10">
            <input placeholder="Nama Jurusan" type="text" id="nama_jurusan" name="nama_jurusan" class="form-control" value="<?php echo $jurusan; ?>" />
        </div>
    </div>
    
    <div class="row" style="margin-top: 25px;">
        <div class="col-lg-6" style="height: 34px;">
            <button style="width: 100%; margin-bottom: 10px;" type="submit" class="btn btn-info pull-right bg-green-gradient" name="daftar_jurusan" value="<?php echo $button_label; ?>"><?php echo $button_label; ?></button>
        </div>
        <div class="col-lg-6">
            <button style="width: 100%; margin-bottom: 10px;" type="button" class="btn btn-default bg-aqua-gradient" onclick="document.location='index.php?page=form-universitas';">Show Data</button>
        </div>
    </div>
</form>