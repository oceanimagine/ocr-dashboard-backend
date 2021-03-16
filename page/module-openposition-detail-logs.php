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
        header("location: ../login.php");
    }
}
check_page("openposition-detail-logs");

$id = isset($_GET['id_pelamar']) && $_GET['id_pelamar'] != "" && is_numeric($_GET['id_pelamar']) ? $_GET['id_pelamar'] : "";
$base_url_action_detail = "?page=openposition-detail-api-logs";
$halaman_before = isset($_GET['halaman']) && $_GET['halaman'] != "" && is_numeric($_GET['halaman']) ? "&halaman_old=" . $_GET['halaman'] : "";
$id_openposition = isset($_GET['id_openposition']) && $_GET['id_openposition'] != "" && is_numeric($_GET['id_openposition']) ? "&id_openposition=" . $_GET['id_openposition'] : "";
?>

<div id="hasil_op_logs">
<table class="table table-bordered" id="table_openposition_log_detail">
    <thead>                  
        <tr>
            <th style="vertical-align: middle;">ID API</th>
            <th style="vertical-align: middle;">Applicant Name</th>
            <th style="vertical-align: middle;">Result OCR API</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        
        $halaman = isset($_GET['halaman']) && $_GET['halaman'] != "" && is_numeric($_GET['halaman']) ? (int) $_GET['halaman'] : 1;
        $query_jumlah_perusahan = mysqli_query($connect, "
            select 
                a.id_document, 
                b.nama_pelamar
            from 
                tbl_id_document_collection_log a, 
                tbl_pelamar b 
            where 
                a.id_pelamar = '".$id."' and 
                a.id_pelamar = b.id

        ");
        $jumlah_openposition_log_detail = mysqli_num_rows($query_jumlah_perusahan);
        $batas_data = 10;
        
        $jumlah_halaman = ceil($jumlah_openposition_log_detail / $batas_data);
        if($halaman > $jumlah_halaman) {
            $halaman = $jumlah_halaman;
        }
        $start = $halaman > 0 ? $batas_data * ($halaman - 1) : 0;
        $ketetapan_batas_halaman = 5;
        $batas_halaman = $ketetapan_batas_halaman < $jumlah_halaman ? $ketetapan_batas_halaman : $jumlah_halaman;
        $tambah = 0;
        if($ketetapan_batas_halaman < $jumlah_halaman){
            $titik_tengah = ceil($batas_halaman / 2);
            if($halaman > $titik_tengah){
                $halaman_tambah = $halaman;
                if($halaman_tambah > $jumlah_halaman - $titik_tengah){
                    $halaman_tambah = $jumlah_halaman - $titik_tengah + ($ketetapan_batas_halaman % 2 == 0 ? 0 : 1);
                    
                }
                $tambah = $halaman_tambah - $titik_tengah;
            }
        }
        
        $query_openposition_log_detail = mysqli_query($connect, "   
            select 
                a.id_document, 
                b.nama_pelamar,
                a.id_pelamar
            from 
                tbl_id_document_collection_log a, 
                tbl_pelamar b 
            where 
                a.id_pelamar = '".$id."' and 
                a.id_pelamar = b.id
            limit $start, $batas_data
        ");
        if(mysqli_num_rows($query_openposition_log_detail) > 0){
            $no = $start + 1;
            while($hasil_openposition_log_detail = mysqli_fetch_array($query_openposition_log_detail)){
                ?>
                <tr>
                    <td><?php echo $hasil_openposition_log_detail['id_document']; ?></td>
                    <td><?php echo $hasil_openposition_log_detail['nama_pelamar']; ?></td>
                    <td><a href="index.php<?php echo $base_url_action_detail . "&id=" . $hasil_openposition_log_detail['id_document'] . "&id_pelamar_old=" . $hasil_openposition_log_detail['id_pelamar'] . $id_openposition . $halaman_before; ?>">Check Result</a></td>
                </tr>
                <?php
                $no++;
            }
        } else {
            ?>
            <tr>
                <td colspan="3">Belum ada data Open Position Logs Detail.</td>
            </tr>  
            <?php 
            
        }
        
        ?>
        
    </tbody>
</table>
<div class="card-footer clearfix" style="padding-right: 0px; background-color: #fff;">
    <ul class="pagination pagination-sm m-0 float-right">
        <?php for($i = 1; $i <= $batas_halaman; $i++){ ?>
        <li class="page-item"><a class="page-link" href="index.php?page=openposition-detail-logs&id_pelamar=<?php echo $id; ?>&halaman=<?php echo ($i + $tambah); ?>"<?php echo ($i + $tambah) == $halaman ? " style='background-color: rgba(0,0,0,0.2);'" : ""; ?>><?php echo ($i + $tambah); ?></a></li>
        <?php } ?>
    </ul>
</div>
</div>