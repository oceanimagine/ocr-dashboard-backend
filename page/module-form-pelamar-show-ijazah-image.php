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
check_page("form-pelamar-show-ijazah-image");

$id_pelamar = isset($_GET['id']) && $_GET['id'] != "" && is_numeric($_GET['id']) ? mysqli_real_escape_string($connect, $_GET['id']) : ""; 
$query_nama_file_transkrip = mysqli_query($connect, "select file_ijazah_sertifikat from tbl_pelamar_master where id = '".$id_pelamar."'");
$array_file_ijazah = array();
$array_link_ijazah = array();
if(mysqli_num_rows($query_nama_file_transkrip) > 0){
    $hasil_nama_transkrip = mysqli_fetch_array($query_nama_file_transkrip);
    $nama_file_ijazah_ = $hasil_nama_transkrip['file_ijazah_sertifikat'];
    $explode_ = explode(".", $nama_file_ijazah_);
    if(sizeof($explode_) > 0){
        $nama_file_ijazah_ = "";
        for($i = 0; $i < sizeof($explode_) - 1; $i++){
            $nama_file_ijazah_ = $nama_file_ijazah_ . $explode_[$i];
        }
    }
    if($nama_file_ijazah_ != "" && is_dir("../ocrapi/upload/ijazah_sertifikat/imageconvert/" . $nama_file_ijazah_ . "/")){
        $scandir_ = scandir("../ocrapi/upload/ijazah_sertifikat/imageconvert/" . $nama_file_ijazah_ . "/");
        for($i = 2; $i < sizeof($scandir_); $i++){
            if($scandir_[$i] != "Result-All.jpg"){
                $array_file_ijazah[] = "<img src='../ocrapi/".$folder."/TOKENACCESS--".$GLOBALS['token']."--ijazah_sertifikat/imageconvert/" . $nama_file_ijazah_ . "--" . $scandir_[$i]."' style='width: 250px;' />";
                $array_link_ijazah[] = "<a href=\"../ocrapi/".$folder."/TOKENACCESS--".$GLOBALS['token']."--ijazah_sertifikat/imageconvert/" . $nama_file_ijazah_ . "--" . $scandir_[$i]."\" target=\"_window\" style=\"text-decoration: none;\">Detail</a>";
            }
        }
    }
    
}
?>

<div style="overflow-x: auto; overflow-y: hidden;">
<table class="table table-bordered" id="table_open_position" style="margin-bottom: 0px;">
    <thead>                  
        <tr>
            <th style="width: 10px; vertical-align: middle;">No</th>
            <th style="text-align: center; vertical-align: middle;">Ijazah S1 Image</th>
            <th style="text-align: center; vertical-align: middle;">Show Image</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        if(sizeof($array_file_ijazah) > 0){
            for($i = 0; $i < sizeof($array_file_ijazah); $i++){
                ?>
                <tr>
                    <td><?php echo ($i + 1); ?></td>
                    <td><?php echo $array_file_ijazah[$i]; ?></td>
                    <td><?php echo $array_link_ijazah[$i]; ?></td>
                </tr>
                <?php
            }
        } else {
            $nama_pelamar = "";
            $query_nama_pelamar = mysqli_query($connect, "select nama_pelamar from tbl_pelamar_master where id = '".$id_pelamar."'");
            if(mysqli_num_rows($query_nama_pelamar) > 0){
                $hasil_nama_pelamar = mysqli_fetch_array($query_nama_pelamar);
                $nama_pelamar = $hasil_nama_pelamar['nama_pelamar'];
            }
            ?>
            <tr>
                <td colspan="3">Belum ada File Image Ijazah S1 Atas Nama <b><?php echo $nama_pelamar; ?></b> atau Mungkin masih Diproses.</td>
            </tr>  
            <?php 
            
        }
        
        ?>
        
    </tbody>
</table>
</div>