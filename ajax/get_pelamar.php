<?php

include_once "../koneksi.php";

$base_url_action_edit = "form-pelamar-add";
$base_url_action_hapus = "form-pelamar-hapus";

$search = isset($_GET['q']) && $_GET['q'] != "" ? "
    where 
        a.nama_pelamar like '%".mysqli_real_escape_string($connect, urldecode($_GET['q']))."%' or
        a.nik like '%".mysqli_real_escape_string($connect, urldecode($_GET['q']))."%' or
        a.umur like '%".mysqli_real_escape_string($connect, urldecode($_GET['q']))."%' or
        a.tempat_lahir like '%".mysqli_real_escape_string($connect, urldecode($_GET['q']))."%' or
        a.tanggal_lahir like '%".mysqli_real_escape_string($connect, urldecode($_GET['q']))."%'
    " : "";
$q = isset($_GET['q']) && $_GET['q'] != "" ? "&q=" . urlencode($_GET['q']) : "";
$s = isset($_GET['q']) && $_GET['q'] != "" ? urlencode($_GET['q']) : "";

?>
<div style="overflow-x: auto; overflow-y: hidden;">
<table class="table table-bordered" id="table_pelamar" style="margin-bottom: 0px;">
    <thead>                  
        <tr>
            <th style="width: 10px; vertical-align: middle; white-space: nowrap;">No</th>
            <th style="text-align: center; vertical-align: middle; white-space: nowrap;">Action</th>
            <th style="text-align: center; vertical-align: middle; white-space: nowrap;">Open Position</th>
            <th style="text-align: center; vertical-align: middle; white-space: nowrap;">Sertifikasi Lainnya</th>
            <th style="text-align: center; vertical-align: middle; white-space: nowrap;">Ketrampilan Bahasa</th>
            <th style="text-align: center; vertical-align: middle; white-space: nowrap;">Ketrampilan Lainnya</th>
            <th style="text-align: center; vertical-align: middle; white-space: nowrap;">Jenis Kelamin</th>
            <th style="text-align: center; vertical-align: middle; white-space: nowrap;">Nama Pelamar</th>
            <th style="text-align: center; vertical-align: middle; white-space: nowrap;">NIK</th>
            <th style="text-align: center; vertical-align: middle; white-space: nowrap;">Umur</th>
            <th style="text-align: center; vertical-align: middle; white-space: nowrap;">Tempat Lahir</th>
            <th style="text-align: center; vertical-align: middle; white-space: nowrap;">Tanggal Lahir</th>
            <th style="text-align: center; vertical-align: middle; white-space: nowrap;">Universitas S1</th>
            <th style="text-align: center; vertical-align: middle; white-space: nowrap;">Jurusan S1</th>
            <th style="text-align: center; vertical-align: middle; white-space: nowrap;">IPK S1</th>
            <th style="text-align: center; vertical-align: middle; white-space: nowrap;">Universitas S2</th>
            <th style="text-align: center; vertical-align: middle; white-space: nowrap;">Jurusan S2</th>
            <th style="text-align: center; vertical-align: middle; white-space: nowrap;">IPK S2</th>
            <th style="text-align: center; vertical-align: middle; white-space: nowrap;">File KTP</th>
            <th style="text-align: center; vertical-align: middle; white-space: nowrap;">File Transkrip S1</th>
            <th style="text-align: center; vertical-align: middle; white-space: nowrap;">File Ijazah S1</th>
            <th style="text-align: center; vertical-align: middle; white-space: nowrap;">File Transkrip Image S1</th>
            <th style="text-align: center; vertical-align: middle; white-space: nowrap;">File Ijazah Image S1</th>
            <th style="text-align: center; vertical-align: middle; white-space: nowrap;">File Transkrip S2</th>
            <th style="text-align: center; vertical-align: middle; white-space: nowrap;">File Ijazah S2</th>
            <th style="text-align: center; vertical-align: middle; white-space: nowrap;">File Transkrip Image S2</th>
            <th style="text-align: center; vertical-align: middle; white-space: nowrap;">File Ijazah Image S2</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        
        $halaman = isset($_GET['halaman']) && $_GET['halaman'] != "" && is_numeric($_GET['halaman']) ? (int) $_GET['halaman'] : 1;
        $query_jumlah_pelamar = mysqli_query($connect, "
            select * from (
            select 
                id,
                universitas,
                jurusan,
                universitas_s2,
                jurusan_s2,
                nama_pelamar,
                nik,
                umur,
                tempat_lahir,
                tanggal_lahir, 
                ipk,
                ipk_s2,
                file_ktp,
                file_ijazah,
                file_ijazah_sertifikat,
                file_ijazah_s2,
                file_ijazah_sertifikat_s2,
                jenis_kelamin
            from tbl_pelamar_master
        ) a" . $search);
        $jumlah_pelamar = mysqli_num_rows($query_jumlah_pelamar);
        $batas_data = 10;
        
        $jumlah_halaman = ceil($jumlah_pelamar / $batas_data);
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
        
        $query_pelamar = mysqli_query($connect, "
            select * from (
                select 
                    id,
                    universitas,
                    jurusan,
                    universitas_s2,
                    jurusan_s2,
                    nama_pelamar,
                    nik,
                    umur,
                    tempat_lahir,
                    tanggal_lahir, 
                    ipk,
                    ipk_s2,
                    file_ktp,
                    file_ijazah,
                    file_ijazah_sertifikat,
                    file_ijazah_s2,
                    file_ijazah_sertifikat_s2,
                    jenis_kelamin
                from tbl_pelamar_master
            ) a " . $search . " order by nama_pelamar asc limit $start, $batas_data");
        if(mysqli_num_rows($query_pelamar) > 0){
            $no = $start + 1;
            while($hasil_pelamar = mysqli_fetch_array($query_pelamar)){
                $folder = "accessfile";
                $query_universitas = mysqli_query($connect, "select universitas from tbl_universitas where id = '".$hasil_pelamar['universitas']."'");
                $hasil_universitas = mysqli_num_rows($query_universitas) > 0 ? mysqli_fetch_array($query_universitas) : array('universitas' => '<font style="font-family: consolas, monospace;">Undefined</font>');
                
                $query_jurusan = mysqli_query($connect, "select jurusan from tbl_jurusan where id = '".$hasil_pelamar['jurusan']."'");
                $hasil_jurusan = mysqli_num_rows($query_jurusan) > 0 ? mysqli_fetch_array($query_jurusan) : array('jurusan' => '<font style="font-family: consolas, monospace;">Undefined</font>');
                
                $query_universitas_s2 = mysqli_query($connect, "select universitas from tbl_universitas where id = '".$hasil_pelamar['universitas_s2']."'");
                $hasil_universitas_s2 = mysqli_num_rows($query_universitas_s2) > 0 ? mysqli_fetch_array($query_universitas_s2) : array('universitas' => '<font style="font-family: consolas, monospace;">Undefined</font>');
                
                $query_jurusan_s2 = mysqli_query($connect, "select jurusan from tbl_jurusan where id = '".$hasil_pelamar['jurusan_s2']."'");
                $hasil_jurusan_s2 = mysqli_num_rows($query_jurusan_s2) > 0 ? mysqli_fetch_array($query_jurusan_s2) : array('jurusan' => '<font style="font-family: consolas, monospace;">Undefined</font>');
                
                $file_ktp = "";
                if($hasil_pelamar['file_ktp'] != "" && file_exists("../../ocrapi/upload/ktp/" . $hasil_pelamar['file_ktp'])){
                    $file_ktp = "<img src='../ocrapi/".$folder."/TOKENACCESS--".$GLOBALS['token']."--ktp--" . $hasil_pelamar['file_ktp']."' style='width: 150px;' />";
                } else {
                    $file_ktp = "File KTP not found.";
                }
                
                $file_ijazah = "";
                if($hasil_pelamar['file_ijazah'] != "" && file_exists("../../ocrapi/upload/ijazah/" . $hasil_pelamar['file_ijazah'])){
                    $file_ijazah = "<a href='../ocrapi/".$folder."/TOKENACCESS--".$GLOBALS['token']."--ijazah--" . $hasil_pelamar['file_ijazah']."' target='_blank'>Download</a>"; 
                } else {
                    $file_ijazah = "File Ijazah S1 not found.";
                }
                
                $file_ijazah_sertifikat = "";
                if($hasil_pelamar['file_ijazah_sertifikat'] != "" && file_exists("../../ocrapi/upload/ijazah_sertifikat/" . $hasil_pelamar['file_ijazah_sertifikat'])){
                    $file_ijazah_sertifikat = "<a href='../ocrapi/".$folder."/TOKENACCESS--".$GLOBALS['token']."--ijazah_sertifikat--" . $hasil_pelamar['file_ijazah_sertifikat']."' target='_blank'>Download</a>"; 
                } else {
                    $file_ijazah_sertifikat = "File Ijazah Sertifikat S1 not found.";
                }
                
                $file_ijazah_s2 = "";
                if($hasil_pelamar['file_ijazah_s2'] != "" && file_exists("../../ocrapi/upload/ijazah_s2/" . $hasil_pelamar['file_ijazah_s2'])){
                    $file_ijazah_s2 = "<a href='../ocrapi/".$folder."/TOKENACCESS--".$GLOBALS['token']."--ijazah_s2--" . $hasil_pelamar['file_ijazah_s2']."' target='_blank'>Download</a>"; 
                } else {
                    $file_ijazah_s2 = "File Ijazah S2 not found.";
                }
                
                $file_ijazah_sertifikat_s2 = "";
                if($hasil_pelamar['file_ijazah_sertifikat_s2'] != "" && file_exists("../../ocrapi/upload/ijazah_s2_sertifikat/" . $hasil_pelamar['file_ijazah_sertifikat_s2'])){
                    $file_ijazah_sertifikat_s2 = "<a href='../ocrapi/".$folder."/TOKENACCESS--".$GLOBALS['token']."--ijazah_s2_sertifikat--" . $hasil_pelamar['file_ijazah_sertifikat_s2']."' target='_blank'>Download</a>"; 
                } else {
                    $file_ijazah_sertifikat_s2 = "File Ijazah Sertifikat S2 not found.";
                }
                
                ?>
                <tr>
                    <td><?php echo $no; ?></td>
                    <td style="white-space: nowrap;">
                        <a href="index.php?page=<?php echo $base_url_action_edit; ?>&id=<?php echo $hasil_pelamar['id']; ?>" style="text-decoration: none;">Edit</a> - 
                        <a href="javascript: hapus_data('index.php?page=<?php echo $base_url_action_hapus; ?>&idhapus=<?php echo $hasil_pelamar['id']; ?>');" style="text-decoration: none;">Hapus</a>
                    </td>
                    <td style="white-space: nowrap;">
                        <a href="index.php?page=form-pelamar-open-position-perperson&id=<?php echo $hasil_pelamar['id']; ?>" style="text-decoration: none;">Detail</a>
                    </td>
                    <td style="white-space: nowrap;">
                        <a href="index.php?page=form-pelamar-other-cert&id=<?php echo $hasil_pelamar['id']; ?>" style="text-decoration: none;">Detail</a>
                    </td>
                    <td style="white-space: nowrap;">
                        <a href="index.php?page=form-pelamar-languague-perperson&id=<?php echo $hasil_pelamar['id']; ?>" style="text-decoration: none;">Detail</a>
                    </td>
                    <td style="white-space: nowrap;">
                        <a href="index.php?page=form-pelamar-skill-perperson&id=<?php echo $hasil_pelamar['id']; ?>" style="text-decoration: none;">Detail</a>
                    </td>
                    <td style=" white-space: nowrap;"><?php echo $hasil_pelamar['jenis_kelamin']; ?></td>
                    <td style=" white-space: nowrap;"><?php echo $hasil_pelamar['nama_pelamar']; ?></td>
                    <td style=" white-space: nowrap;"><?php echo $hasil_pelamar['nik']; ?></td>
                    <td style=" white-space: nowrap;"><?php echo $hasil_pelamar['umur']; ?></td>
                    <td style=" white-space: nowrap;"><?php echo $hasil_pelamar['tempat_lahir']; ?></td>
                    <td style=" white-space: nowrap;"><?php echo $hasil_pelamar['tanggal_lahir']; ?></td>
                    <td style=" white-space: nowrap;"><?php echo $hasil_universitas['universitas']; ?></td>
                    <td style=" white-space: nowrap;"><?php echo $hasil_jurusan['jurusan']; ?></td>
                    <td style=" white-space: nowrap;"><?php echo $hasil_pelamar['ipk']; ?></td>
                    <td style=" white-space: nowrap;"><?php echo $hasil_universitas_s2['universitas']; ?></td>
                    <td style=" white-space: nowrap;"><?php echo $hasil_jurusan_s2['jurusan']; ?></td>
                    <td style=" white-space: nowrap;"><?php echo $hasil_pelamar['ipk_s2']; ?></td>
                    <td style=" white-space: nowrap;"><?php echo $file_ktp; ?></td>
                    <td style=" white-space: nowrap;"><?php echo $file_ijazah; ?></td>
                    <td style=" white-space: nowrap;"><?php echo $file_ijazah_sertifikat; ?></td>
                    <td style="white-space: nowrap;">
                        <a href="index.php?page=form-pelamar-show-transkrip-image&id=<?php echo $hasil_pelamar['id']; ?>" style="text-decoration: none;">Detail</a>
                    </td>
                    <td style="white-space: nowrap;">
                        <a href="index.php?page=form-pelamar-show-ijazah-image&id=<?php echo $hasil_pelamar['id']; ?>" style="text-decoration: none;">Detail</a>
                    </td>
                    <td style=" white-space: nowrap;"><?php echo $file_ijazah_s2; ?></td>
                    <td style=" white-space: nowrap;"><?php echo $file_ijazah_sertifikat_s2; ?></td>
                    <td style="white-space: nowrap;">
                        <a href="index.php?page=form-pelamar-show-transkrip-s2-image&id=<?php echo $hasil_pelamar['id']; ?>" style="text-decoration: none;">Detail</a>
                    </td>
                    <td style="white-space: nowrap;">
                        <a href="index.php?page=form-pelamar-show-ijazah-s2-image&id=<?php echo $hasil_pelamar['id']; ?>" style="text-decoration: none;">Detail</a>
                    </td>
                </tr>
                <?php
                $no++;
            }
        } else {
            ?>
            <tr>
                <td colspan="13">Belum ada data Open Position.</td>
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
        <li class="page-item"><a class="page-link" href="index.php?page=form-pelamar&halaman=<?php echo ($i + $tambah) . $q; ?>"<?php echo ($i + $tambah) == $halaman ? " style='background-color: rgba(0,0,0,0.2);'" : ""; ?>><?php echo ($i + $tambah); ?></a></li>
        <?php } ?>
    </ul>
</div>