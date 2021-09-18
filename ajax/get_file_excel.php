<?php

include_once "../koneksi.php";

$search = isset($_GET['q']) && $_GET['q'] != "" ? "
    where 
        a.nama_file like '%".mysqli_real_escape_string($connect, urldecode($_GET['q']))."%'
    " : "";
$q = isset($_GET['q']) && $_GET['q'] != "" ? "&q=" . urlencode($_GET['q']) : "";
$s = isset($_GET['q']) && $_GET['q'] != "" ? urlencode($_GET['q']) : "";

?>
<div style="overflow-x: auto; overflow-y: hidden;">
<table class="table table-bordered" id="table_file_excel" style="margin-bottom: 0px;">
    <thead>                  
        <tr>
            <th style="width: 10px; vertical-align: middle;">No</th>
            <th style="text-align: center; vertical-align: middle; white-space: nowrap;">Nama File</th>
            <th style="text-align: center; vertical-align: middle; white-space: nowrap;">Jumlah Insert Pelamar Master</th>
            <th style="text-align: center; vertical-align: middle; white-space: nowrap;">Jumlah Update Pelamar Master</th>
            <th style="text-align: center; vertical-align: middle; white-space: nowrap;">Jumlah Insert Lamaran</th>
            <th style="text-align: center; vertical-align: middle; white-space: nowrap;">Jumlah Update Lamaran</th>
            <th style="text-align: center; vertical-align: middle; white-space: nowrap;">Jumlah Insert Lamaran Bidang Baru</th>
            <th style="text-align: center; vertical-align: middle; white-space: nowrap;">Total Detik</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        
        $halaman = isset($_GET['halaman']) && $_GET['halaman'] != "" && is_numeric($_GET['halaman']) ? (int) $_GET['halaman'] : 1;
        $query_jumlah_file_excel = mysqli_query($connect, "
            select * from (
            select 
                nama_file,
                insert_pelamar_master,
                upadate_pelamar_master,
                insert_lamaran,
                update_lamaran,
                insert_lamaran_bidang_baru,
                total_detik
            from tbl_proses_excel_log
        ) a" . $search);
        $jumlah_file_excel = mysqli_num_rows($query_jumlah_file_excel);
        $batas_data = 10;
        
        $jumlah_halaman = ceil($jumlah_file_excel / $batas_data);
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
        
        $query_file_excel = mysqli_query($connect, "
            select * from (
                select 
                    nama_file,
                    insert_pelamar_master,
                    upadate_pelamar_master,
                    insert_lamaran,
                    update_lamaran,
                    insert_lamaran_bidang_baru,
                    total_detik
                from tbl_proses_excel_log
            ) a " . $search . " order by nama_file asc limit $start, $batas_data");
        if(mysqli_num_rows($query_file_excel) > 0){
            $no = $start + 1;
            while($hasil_file_excel = mysqli_fetch_array($query_file_excel)){
                
                ?>
                <tr>
                    <td style="white-space: nowrap; text-align: right;"><?php echo $no; ?></td>
                    <td style="white-space: nowrap;"><?php echo $hasil_file_excel['nama_file']; ?></td>
                    <td style="white-space: nowrap;" identitas="<?php echo $hasil_file_excel['nama_file']; ?>_insert_pelamar_master"><?php echo $hasil_file_excel['insert_pelamar_master']; ?></td>
                    <td style="white-space: nowrap;" identitas="<?php echo $hasil_file_excel['nama_file']; ?>_upadate_pelamar_master"><?php echo $hasil_file_excel['upadate_pelamar_master']; ?></td>
                    <td style="white-space: nowrap;" identitas="<?php echo $hasil_file_excel['nama_file']; ?>_insert_lamaran"><?php echo $hasil_file_excel['insert_lamaran']; ?></td>
                    <td style="white-space: nowrap;" identitas="<?php echo $hasil_file_excel['nama_file']; ?>_update_lamaran"><?php echo $hasil_file_excel['update_lamaran']; ?></td>
                    <td style="white-space: nowrap;" identitas="<?php echo $hasil_file_excel['nama_file']; ?>_insert_lamaran_bidang_baru"><?php echo $hasil_file_excel['insert_lamaran_bidang_baru']; ?></td>
                    <td style="white-space: nowrap;" identitas="<?php echo $hasil_file_excel['nama_file']; ?>_total_detik"><?php echo $hasil_file_excel['total_detik']; ?></td>
                </tr>
                <?php
                $no++;
            }
        } else {
            ?>
            <tr>
                <td colspan="8">File Excel yang dicari tidak ditemukan.</td>
            </tr>  
            <?php 
            
        }
        
        ?>
        
    </tbody>
</table>
</div>
<div class="card-footer clearfix" style="padding-right: 0px; background-color: #fff;">
    <ul class="pagination pagination-sm m-0 float-right">
        <?php for($i = 1; $i <= $batas_halaman; $i++){ ?>
        <li class="page-item"><a class="page-link" href="index.php?page=view-log&halaman=<?php echo ($i + $tambah) . $q; ?>"<?php echo ($i + $tambah) == $halaman ? " style='background-color: rgba(0,0,0,0.2);'" : ""; ?>><?php echo ($i + $tambah); ?></a></li>
        <?php } ?>
    </ul>
</div>