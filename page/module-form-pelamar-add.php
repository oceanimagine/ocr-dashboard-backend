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
$universitas_s2 = "";
$jurusan_s2 = "";
$ipk_s2 = "";
$nama_file_ktp = "";
$nama_file_ijazah = "";
$nama_file_ijazah_s2 = "";
$jenis_kelamin = "";
$username = "";
$password = "";
$nama_file_ijazah_sertifikat = "";
$nama_file_ijazah_sertifikat_s2 = "";
$button_label = "Input Pelamar";
if(isset($_GET['id']) && $_GET['id'] != "" && is_numeric($_GET['id'])){
    $id = mysqli_real_escape_string($connect, $_GET['id']);
    $query_tampil = mysqli_query($connect, "select * from tbl_pelamar_master where id = '".$id."'");
    if(mysqli_num_rows($query_tampil) > 0){
        $button_label = "Update Pelamar";
        $hasil_tampil = mysqli_fetch_array($query_tampil);
        $nama_pelamar = $hasil_tampil['nama_pelamar'];
        $nik = $hasil_tampil['nik'];
        $umur = $hasil_tampil['umur'];
        $tempat_lahir = $hasil_tampil['tempat_lahir'];
        $tanggal_lahir = $hasil_tampil['tanggal_lahir'];
        $universitas = $hasil_tampil['universitas'];
        $jurusan = $hasil_tampil['jurusan'];
        $ipk = $hasil_tampil['ipk'];
        $universitas_s2 = $hasil_tampil['universitas_s2'];
        $jurusan_s2 = $hasil_tampil['jurusan_s2'];
        $ipk_s2 = $hasil_tampil['ipk_s2'];
        $jenis_kelamin = $hasil_tampil['jenis_kelamin'];
        $nama_file_ktp = "<input type='hidden' name='file_ktp_hidden' />";
        if($hasil_tampil['file_ktp'] != "" && file_exists("../ocrapi/upload/ktp/" . $hasil_tampil['file_ktp'])){
            $nama_file_ktp = "
                <div id=\"create_div\" style=\"border-radius: .25rem; width: 100%; margin-top: 4px; border-top: 1px solid rgb(208, 208, 208); border-right: 1px solid rgb(208, 208, 208); border-left: 1px solid rgb(208, 208, 208); padding: 5px;\" align=\"center\">
                    <img style=\"width: 250px;\" src=\"../ocrapi/upload/ktp/".$hasil_tampil['file_ktp']."\">
                    <input type='hidden' name='file_ktp_hidden' value='".$hasil_tampil['file_ktp']."' />
                </div>
            "; 
        }
        $nama_file_ijazah = "<input type='hidden' name='file_ijazah_hidden' />";
        if($hasil_tampil['file_ijazah'] != "" && file_exists("../ocrapi/upload/ijazah/" . $hasil_tampil['file_ijazah'])){
            $nama_file_ijazah = "
                <div id=\"create_div\" style=\"border-radius: .25rem; width: 100%; margin-top: 4px; border-top: 1px solid rgb(208, 208, 208); border-right: 1px solid rgb(208, 208, 208); border-left: 1px solid rgb(208, 208, 208); padding: 5px;\" align=\"center\">
                    <a href='../ocrapi/upload/ijazah/".$hasil_tampil['file_ijazah']."' target='_blank'>Download</a>
                    <input type='hidden' name='file_ijazah_hidden' value='".$hasil_tampil['file_ijazah']."' />
                </div>
            "; 
        }
        $nama_file_ijazah_sertifikat = " <input type='hidden' name='file_ijazah_sertifikat_hidden' />";
        if($hasil_tampil['file_ijazah_sertifikat'] != "" && file_exists("../ocrapi/upload/ijazah_sertifikat/" . $hasil_tampil['file_ijazah_sertifikat'])){
            $nama_file_ijazah_sertifikat = "
                <div id=\"create_div\" style=\"border-radius: .25rem; width: 100%; margin-top: 4px; border-top: 1px solid rgb(208, 208, 208); border-right: 1px solid rgb(208, 208, 208); border-left: 1px solid rgb(208, 208, 208); padding: 5px;\" align=\"center\">
                    <a href='../ocrapi/upload/ijazah_sertifikat/".$hasil_tampil['file_ijazah_sertifikat']."' target='_blank'>Download</a>
                    <input type='hidden' name='file_ijazah_sertifikat_hidden' value='".$hasil_tampil['file_ijazah_sertifikat']."' />
                </div>
            "; 
        }  
        $nama_file_ijazah_s2 = "<input type='hidden' name='file_ijazah_s2_hidden' />";
        if($hasil_tampil['file_ijazah_s2'] != "" && file_exists("../ocrapi/upload/ijazah_s2/" . $hasil_tampil['file_ijazah_s2'])){
            $nama_file_ijazah_s2 = "
                <div id=\"create_div\" style=\"border-radius: .25rem; width: 100%; margin-top: 4px; border-top: 1px solid rgb(208, 208, 208); border-right: 1px solid rgb(208, 208, 208); border-left: 1px solid rgb(208, 208, 208); padding: 5px;\" align=\"center\">
                    <a href='../ocrapi/upload/ijazah_s2/".$hasil_tampil['file_ijazah_s2']."' target='_blank'>Download</a>
                    <input type='hidden' name='file_ijazah_s2_hidden' value='".$hasil_tampil['file_ijazah_s2']."' />
                </div>
            "; 
        }
        $nama_file_ijazah_sertifikat_s2 = "<input type='hidden' name='file_ijazah_sertifikat_s2_hidden' />";
        if($hasil_tampil['file_ijazah_sertifikat_s2'] != "" && file_exists("../ocrapi/upload/ijazah_sertifikat_s2/" . $hasil_tampil['file_ijazah_sertifikat_s2'])){
            $nama_file_ijazah_sertifikat_s2 = "
                <div id=\"create_div\" style=\"border-radius: .25rem; width: 100%; margin-top: 4px; border-top: 1px solid rgb(208, 208, 208); border-right: 1px solid rgb(208, 208, 208); border-left: 1px solid rgb(208, 208, 208); padding: 5px;\" align=\"center\">
                    <a href='../ocrapi/upload/ijazah_sertifikat_s2/".$hasil_tampil['file_ijazah_sertifikat_s2']."' target='_blank'>Download</a>
                    <input type='hidden' name='file_ijazah_sertifikat_s2_hidden' value='".$hasil_tampil['file_ijazah_sertifikat_s2']."' />
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
            <input placeholder="Nama Pelamar" type="text" id="nama_pelamar" name="nama_pelamar" class="form-control" value="<?php echo $nama_pelamar; ?>" />
        </div>
    </div>
    <div class="row" style="margin-bottom: 10px;">
        <div class="col-lg-2">
            <label for="jenis_kelamin" class="control-label" style="margin-bottom: 0px; margin-top: 6px;">Jenis Kelamin</label>
        </div>
        <div class="col-lg-10">
            <select name="jenis_kelamin" id="jenis_kelamin" class="form-control">
                <option value="">PILIH</option>
                <option value="laki-laki" <?php echo $jenis_kelamin == 'laki-laki' ? " selected='selected'" : ""; ?>>Laki Laki</option>
                <option value="perempuan" <?php echo $jenis_kelamin == 'perempuan' ? " selected='selected'" : ""; ?>>Perempuan</option>
            </select>
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
            <label for="universitas" class="control-label" style="margin-bottom: 0px; margin-top: 6px;">Universitas S1</label>
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
            <label for="jurusan" class="ontrol-label" style="margin-bottom: 0px; margin-top: 6px;">Jurusan S1</label>
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
            <label for="ipk" class="control-label" style="margin-bottom: 0px; margin-top: 6px;">IPK S1</label>
        </div>
        <div class="col-lg-10">
            <input placeholder="IPK S1" autocomplete="off" type="text" name="ipk" id="ipk" class="form-control" value="<?php echo $ipk; ?>" />
        </div>
    </div>
    <div class="row" style="margin-bottom: 10px;">
        <div class="col-lg-2">
            <label for="universitas_s2" class="control-label" style="margin-bottom: 0px; margin-top: 6px;">Universitas S2</label>
        </div>
        <div class="col-lg-10">
            <select name="universitas_s2" id="universitas_s2" class="form-control">
                <option value="">PILIH</option>
                <?php 

                $query_universitas_s2 = mysqli_query($connect, "select id, universitas from tbl_universitas order by universitas asc");
                if(mysqli_num_rows($query_universitas_s2) > 0){
                    while($hasil_universitas = mysqli_fetch_array($query_universitas_s2)){
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
            <label for="jurusan_s2" class="ontrol-label" style="margin-bottom: 0px; margin-top: 6px;">Jurusan S2</label>
        </div>
        <div class="col-lg-10">
            <select name="jurusan_s2" id="jurusan_s2" class="form-control">
                <option value="">PILIH</option>
                <?php 

                $query_jurusan_s2 = mysqli_query($connect, "select id, jurusan from tbl_jurusan order by jurusan asc");
                if(mysqli_num_rows($query_jurusan_s2) > 0){
                    while($hasil_jurusan = mysqli_fetch_array($query_jurusan_s2)){
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
            <label for="ipk_s2" class="control-label" style="margin-bottom: 0px; margin-top: 6px;">IPK S2</label>
        </div>
        <div class="col-lg-10">
            <input placeholder="IPK S2" autocomplete="off" type="text" name="ipk_s2" id="ipk_s2" class="form-control" value="<?php echo $ipk_s2; ?>" />
        </div>
    </div>
    <div class="row" style="margin-bottom: 10px;">
        <div class="col-lg-2">
            <label for="username" class="control-label" style="margin-bottom: 0px; margin-top: 6px;">Username</label>
        </div>
        <div class="col-lg-10">
            <input placeholder="Username" autocomplete="off" type="text" name="username" id="username" class="form-control" value="<?php echo $username; ?>" />
        </div>
    </div>
    <div class="row" style="margin-bottom: 10px;">
        <div class="col-lg-2">
            <label for="password" class="control-label" style="margin-bottom: 0px; margin-top: 6px;">Password</label>
        </div>
        <div class="col-lg-10">
            <input placeholder="Password" autocomplete="off" type="password" name="password" id="password" class="form-control" value="<?php echo $password; ?>" />
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
            <label for="file_ijazah" class="control-label" style="margin-bottom: 0px; margin-top: 6px;">File Transkrip Nilai S1</label>
        </div>
        <div class="col-lg-10">
            <?php echo $nama_file_ijazah; ?>
            <input type="file" name="file_ijazah" id="file_ijazah" class="form-control" />
        </div>
    </div>
    <div class="row" style="margin-bottom: 10px;">
        <div class="col-lg-2">
            <label for="file_ijazah_sertifikat" class="control-label" style="margin-bottom: 0px; margin-top: 6px;">File Ijazah S1</label>
        </div>
        <div class="col-lg-10">
            <?php echo $nama_file_ijazah_sertifikat; ?>
            <input type="file" name="file_ijazah_sertifikat" id="file_ijazah_sertifikat" class="form-control" />
        </div>
    </div>
    <div class="row" style="margin-bottom: 10px;">
        <div class="col-lg-2">
            <label for="file_ijazah_s2" class="control-label" style="margin-bottom: 0px; margin-top: 6px;">File Transkrip Nilai S2</label>
        </div>
        <div class="col-lg-10">
            <?php echo $nama_file_ijazah_s2; ?>
            <input type="file" name="file_ijazah_s2" id="file_ijazah_s2" class="form-control" />
        </div>
    </div>
    <div class="row" style="margin-bottom: 10px;">
        <div class="col-lg-2">
            <label for="file_ijazah_sertifikat_s2" class="control-label" style="margin-bottom: 0px; margin-top: 6px;">File Ijazah S2</label>
        </div>
        <div class="col-lg-10">
            <?php echo $nama_file_ijazah_sertifikat_s2; ?>
            <input type="file" name="file_ijazah_sertifikat_s2" id="file_ijazah_sertifikat_s2" class="form-control" />
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