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
check_page("form-pelamar-add");

$id_position = "";
$nama_pelamar = "";
$nik = "";
$umur = "";
$tempat_lahir = "";
$tanggal_lahir = "";
$universitas = "";
$jurusan = "";
$ipk = "";
$nama_file_ktp = "";
$nama_file_ijazah = "";
$button_label = "Input Pelamar";
if(isset($_GET['id']) && $_GET['id'] != "" && is_numeric($_GET['id'])){
    $id = mysqli_real_escape_string($connect, $_GET['id']);
    $query_tampil = mysqli_query($connect, "select * from tbl_pelamar where id = '".$id."'");
    if(mysqli_num_rows($query_tampil) > 0){
        $button_label = "Update Pelamar";
        $hasil_tampil = mysqli_fetch_array($query_tampil);
        $id_position = $hasil_tampil['id_position'];
        $nama_pelamar = $hasil_tampil['nama_pelamar'];
        $nik = $hasil_tampil['nik'];
        $umur = $hasil_tampil['umur'];
        $tempat_lahir = $hasil_tampil['tempat_lahir'];
        $tanggal_lahir = $hasil_tampil['tanggal_lahir'];
        $universitas = $hasil_tampil['universitas'];
        $jurusan = $hasil_tampil['jurusan'];
        $ipk = $hasil_tampil['ipk'];
        if($hasil_tampil['file_ktp'] != "" && file_exists("../ocrapi/upload/ktp/" . $hasil_tampil['file_ktp'])){
            $nama_file_ktp = "
                <div id=\"create_div\" style=\"border-radius: .25rem; width: 100%; margin-top: 4px; border-top: 1px solid rgb(208, 208, 208); border-right: 1px solid rgb(208, 208, 208); border-left: 1px solid rgb(208, 208, 208); padding: 5px;\" align=\"center\">
                    <img style=\"width: 250px;\" src=\"../ocrapi/upload/ktp/".$hasil_tampil['file_ktp']."\">
                    <input type='hidden' name='file_ktp_hidden' value='".$hasil_tampil['file_ktp']."' />
                </div>
            "; 
        }
        if($hasil_tampil['file_ijazah'] != "" && file_exists("../ocrapi/upload/ijazah/" . $hasil_tampil['file_ijazah'])){
            $nama_file_ijazah = "
                <div id=\"create_div\" style=\"border-radius: .25rem; width: 100%; margin-top: 4px; border-top: 1px solid rgb(208, 208, 208); border-right: 1px solid rgb(208, 208, 208); border-left: 1px solid rgb(208, 208, 208); padding: 5px;\" align=\"center\">
                    <a href='../ocrapi/upload/ijazah/".$hasil_tampil['file_ijazah']."' target='_blank'>Download</a>
                    <input type='hidden' name='file_ijazah_hidden' value='".$hasil_tampil['file_ijazah']."' />
                </div>
            "; 
        }
        
    }
}


?>

<form method="POST" enctype="multipart/form-data">
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
                        $selected = $id_position == $hasil_position['id'] ? " selected='selected'" : "";
                        echo "<option value='".$hasil_position['id']."'".$selected.">".$hasil_position['open_position']."</option>";
                    }
                }
                ?>
            </select>
        </div>
    </div>
    <div class="row" style="margin-bottom: 10px;">
        <div class="col-lg-2">
            <label for="nama_pelamar" class="control-label" style="margin-bottom: 0px; margin-top: 6px;">Nama Pelamar</label>
        </div>
        <div class="col-lg-10">
            <input placeholder="Nama Pelamar" type="text" id="nama_pelamar" name="nama_pelamar" class="form-control" value="<?php echo $nama_pelamar; ?>" />
        </div>
    </div>
    <div class="row" style="margin-bottom: 10px;">
        <div class="col-lg-2">
            <label for="nik" class="control-label" style="margin-bottom: 0px; margin-top: 6px;">NIK</label>
        </div>
        <div class="col-lg-10">
            <input placeholder="NIK" type="text" name="nik" id="nik" class="form-control" value="<?php echo $nik; ?>" />
        </div>
    </div>
    <div class="row" style="margin-bottom: 10px;">
        <div class="col-lg-2">
            <label for="umur" class="control-label" style="margin-bottom: 0px; margin-top: 6px;">Umur</label>
        </div>
        <div class="col-lg-10">
            <input placeholder="Umur" type="number" name="umur" id="umur" class="form-control" value="<?php echo $umur; ?>" />
        </div>
    </div>
    <div class="row" style="margin-bottom: 10px;">
        <div class="col-lg-2">
            <label for="tempat_lahir" class="control-label" style="margin-bottom: 0px; margin-top: 6px;">Tempat Lahir</label>
        </div>
        <div class="col-lg-10">
            <input placeholder="Tempat Lahir" type="text" name="tempat_lahir" id="tempat_lahir" class="form-control" value="<?php echo $tempat_lahir; ?>" />
        </div>
    </div>
    <div class="row" style="margin-bottom: 10px;">
        <div class="col-lg-2">
            <label for="tanggal_lahir" class="control-label" style="margin-bottom: 0px; margin-top: 6px;">Tanggal Lahir</label>
        </div>
        <div class="col-lg-10">
            <input placeholder="Tanggal Lahir" autocomplete="off" type="text" name="tanggal_lahir" id="tanggal_lahir" class="form-control" value="<?php echo $tanggal_lahir; ?>" />
        </div>
    </div>
    <div class="row" style="margin-bottom: 10px;">
        <div class="col-lg-2">
            <label for="universitas" class="control-label" style="margin-bottom: 0px; margin-top: 6px;">Universitas</label>
        </div>
        <div class="col-lg-10">
            <select name="universitas" id="universitas" class="form-control">
                <option value="">PILIH</option>
                <?php 

                $query_universitas = mysqli_query($connect, "select id, universitas from tbl_universitas order by universitas asc");
                if(mysqli_num_rows($query_universitas) > 0){
                    while($hasil_universitas = mysqli_fetch_array($query_universitas)){
                        $selected = $universitas == $hasil_universitas['id'] ? " selected='selected'" : "";
                        echo "<option value='".$hasil_universitas['id']."'".$selected.">".$hasil_universitas['universitas']."</option>";
                    }
                }

                ?>
            </select>
        </div>
    </div>
    <div class="row" style="margin-bottom: 10px;">
        <div class="col-lg-2">
            <label for="jurusan" class="ontrol-label" style="margin-bottom: 0px; margin-top: 6px;">Jurusan</label>
        </div>
        <div class="col-lg-10">
            <select name="jurusan" id="jurusan" class="form-control">
                <option value="">PILIH</option>
                <?php 

                $query_jurusan = mysqli_query($connect, "select id, jurusan from tbl_jurusan order by jurusan asc");
                if(mysqli_num_rows($query_jurusan) > 0){
                    while($hasil_jurusan = mysqli_fetch_array($query_jurusan)){
                        $selected = $jurusan == $hasil_jurusan['id'] ? " selected='selected'" : "";
                        echo "<option value='".$hasil_jurusan['id']."'".$selected.">".$hasil_jurusan['jurusan']."</option>";
                    }
                }

                ?>
            </select>

        </div>
    </div>
    <div class="row" style="margin-bottom: 10px;">
        <div class="col-lg-2">
            <label for="file_ktp" class="control-label" style="margin-bottom: 0px; margin-top: 6px;">File KTP</label>
        </div>
        <div class="col-lg-10">
            <?php echo $nama_file_ktp; ?>
            <input type="file" name="file_ktp" id="file_ktp" class="form-control" />
        </div>
    </div>
    <div class="row" style="margin-bottom: 10px;">
        <div class="col-lg-2">
            <label for="file_ijazah" class="control-label" style="margin-bottom: 0px; margin-top: 6px;">File Ijazah</label>
        </div>
        <div class="col-lg-10">
            <?php echo $nama_file_ijazah; ?>
            <input type="file" name="file_ijazah" id="file_ijazah" class="form-control" />
        </div>
    </div>
    <div class="row" style="margin-top: 25px;">
        <div class="col-lg-6" style="height: 34px;">
            <button style="width: 100%; margin-bottom: 10px;" type="submit" class="btn btn-info pull-right bg-green-gradient" name="daftar_pelamar" value="<?php echo $button_label; ?>"><?php echo $button_label; ?></button>
        </div>
        <div class="col-lg-6">
            <button style="width: 100%; margin-bottom: 10px;" type="button" class="btn btn-default bg-aqua-gradient" onclick="document.location='index.php?page=form-pelamar';">Show Data</button>
        </div>
    </div>
</form>