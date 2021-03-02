<?php
if (session_status() != PHP_SESSION_ACTIVE) {
    session_start();
}

function check_page($redirect) {
    if (isset($_SESSION['username']) && isset($_SESSION['password'])) {
        if (!isset($_GET['page'])) {
            header("location: ../index.php?page=" . $redirect);
        }
    } else {
        header("location: ../login.php");
    }
}

check_page("perusahaan-add");

$id = isset($_GET['id']) && $_GET['id'] != "" && is_numeric($_GET['id']) ? $_GET['id'] : "";
$nama_perushaan = "";
$input_tombol = "Input";
if($id != ""){
    $perusahaan = mysqli_query($connect, "select nama_perusahaan from tbl_perusahaan where id = '".$id."'");
    if(mysqli_num_rows($perusahaan) > 0){
        $hasil_perusahaan = mysqli_fetch_array($perusahaan);
        $nama_perushaan = $hasil_perusahaan['nama_perusahaan'];
        $input_tombol = "Edit";
    }
}
?>
<form class="form-horizontal" method="POST">
    <div class="card-body">
        <div class="form-group row">
            <label for="nama_perusahaan" class="col-sm-2 col-form-label">Nama Perusahaan</label>
            <div class="col-sm-10">
                <input type="text" value="<?php echo $nama_perushaan; ?>" class="form-control" id="perusahaan" placeholder="Perusahaan" name="nama_perusahaan">
            </div>
        </div>
        
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
        <button type="submit" class="btn btn-info" style="width: 100px;" name="daftar_perusahaan" value="<?php echo $input_tombol; ?>"><?php echo $input_tombol; ?></button>
        <button type="button" class="btn btn-default float-right" style="width: 100px;" onclick="document.location='index.php?page=perusahaan';">Cancel</button>
    </div>
    <!-- /.card-footer -->
</form>