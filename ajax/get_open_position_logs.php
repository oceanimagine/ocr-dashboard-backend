<?php

include_once "../koneksi.php";

$id = isset($_GET['id']) && $_GET['id'] != "" && is_numeric($_GET['id']) ? $_GET['id'] : "";
$search = isset($_GET['q']) && $_GET['q'] != "" ? " and (a.nama_pelamar like '%" . mysqli_real_escape_string($connect, urldecode($_GET['q'])) . "%' or b.open_position like '%" . mysqli_real_escape_string($connect, urldecode($_GET['q'])) . "%')" : "";
$base_url_action_detail = "?page=openposition-detail-logs";
$halaman_before = isset($_GET['halaman']) && $_GET['halaman'] != "" && is_numeric($_GET['halaman']) ? "&halaman_old=" . $_GET['halaman'] : "";
$q = isset($_GET['q']) && $_GET['q'] != "" ? "&q=" . urlencode($_GET['q']) : "";
$s = isset($_GET['q']) && $_GET['q'] != "" ? urlencode($_GET['q']) : "";

?>

<table class="table table-bordered" id="table_openposition_log">
    <thead>                  
        <tr>
            <th style="vertical-align: middle;">No</th>
            <th style="vertical-align: middle;">Applicant Name</th>
            <th style="vertical-align: middle;">Position</th>
            <th style="vertical-align: middle;">Total Send</th>
            <th style="vertical-align: middle;">Show KTP</th>
            <th style="vertical-align: middle;">Show Ijazah</th>
            <th style="vertical-align: middle;">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        
        $halaman = isset($_GET['halaman']) && $_GET['halaman'] != "" && is_numeric($_GET['halaman']) ? (int) $_GET['halaman'] : 1;
        $query_jumlah_perusahan = mysqli_query($connect, "
            select 
                a.nama_pelamar, 
                b.open_position, 
                a.id,
                a.file_ktp,
                a.file_ijazah
            from 
                tbl_pelamar a, 
                tbl_event b 
            where 
                a.id_position = '".$id."' and 
                a.id_position = b.id
                ".$search."

        ");
        $jumlah_openposition_log = mysqli_num_rows($query_jumlah_perusahan);
        $batas_data = 10;
        
        $jumlah_halaman = ceil($jumlah_openposition_log / $batas_data);
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
        
        $query_openposition_log = mysqli_query($connect, "   
            select 
                a.nama_pelamar, 
                b.open_position, 
                a.id,
                a.file_ktp,
                a.file_ijazah
            from 
                tbl_pelamar a, 
                tbl_event b 
            where 
                a.id_position = '".$id."' and 
                a.id_position = b.id
                ".$search."
            limit $start, $batas_data
        ");
        if(mysqli_num_rows($query_openposition_log) > 0){
            $no = $start + 1;
            while($hasil_openposition_log = mysqli_fetch_array($query_openposition_log)){
                $query_jumlah_log = mysqli_query($connect, "select COUNT(id_document) jumlah_log from tbl_id_document_collection_log where id_pelamar = '".$hasil_openposition_log['id']."'");
                $hasil_jumlah_log = mysqli_fetch_array($query_jumlah_log);
                ?>
                <tr>
                    <td style="text-align: right;"><?php echo $no; ?>.</td>
                    <td><?php echo $hasil_openposition_log['nama_pelamar']; ?></td>
                    <td><?php echo $hasil_openposition_log['open_position']; ?></td>
                    <td style="text-align: right;"><?php echo $hasil_jumlah_log['jumlah_log']; ?></td>
                    <?php 
                    // File Ijazah
                    $file_ijazah = "Not Found.";
                    if(file_exists("../../ocrapi/upload/ijazah/" . $hasil_openposition_log['file_ijazah'])){
                        $file_ijazah = "<a href='../ocrapi/upload/ijazah/".$hasil_openposition_log['file_ijazah']."' target='_blank'>Show Ijazah</a>";
                    }
                    
                    // File KTP
                    $file_ktp = "Not Found.";
                    if(file_exists("../../ocrapi/upload/ktp/" . $hasil_openposition_log['file_ktp'])){
                        $file_ktp = "<a href='../ocrapi/upload/ktp/".$hasil_openposition_log['file_ktp']."' target='_blank'>Show KTP</a>";
                    }
                    ?>
                    <td><?php echo $file_ktp; ?></td>
                    <td><?php echo $file_ijazah; ?></td>
                    <td><a href="index.php<?php echo $base_url_action_detail . "&id_pelamar=" . $hasil_openposition_log['id']. "&id_openposition=" . $id . $halaman_before; ?>">Detail Logs</a></td>
                </tr>
                <?php
                $no++;
            }
        } else {
            ?>
            <tr>
                <td colspan="5">Belum ada data Open Position Logs.</td>
            </tr>  
            <?php 
            
        }
        
        ?>
        
    </tbody>
</table>
<div class="card-footer clearfix" style="padding-right: 0px; background-color: #fff;">
    <ul class="pagination pagination-sm m-0 float-right">
        <?php for($i = 1; $i <= $batas_halaman; $i++){ ?>
        <li class="page-item"><a class="page-link" href="index.php?page=openposition-logs&id=<?php echo $id; ?>&halaman=<?php echo ($i + $tambah) . $q; ?>"<?php echo ($i + $tambah) == $halaman ? " style='background-color: rgba(0,0,0,0.2);'" : ""; ?>><?php echo ($i + $tambah); ?></a></li>
        <?php } ?>
    </ul>
</div>