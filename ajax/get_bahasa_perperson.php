<?php

include_once "../koneksi.php";

$base_url_action_edit = "form-pelamar-languague-perperson-add";
$base_url_action_hapus = "form-pelamar-languague-perperson-hapus";

$id_pelamar = isset($_GET['id']) && $_GET['id'] != "" && is_numeric($_GET['id']) ? mysqli_real_escape_string($connect, $_GET['id']) : ""; 
$search = isset($_GET['q']) && $_GET['q'] != "" ? "
    and 
        nama_bahasa like '%".mysqli_real_escape_string($connect, urldecode($_GET['q']))."%'
    " : "";
$q = isset($_GET['q']) && $_GET['q'] != "" ? "&q=" . urlencode($_GET['q']) : "";
$s = isset($_GET['q']) && $_GET['q'] != "" ? urlencode($_GET['q']) : "";
$nama_pelamar = "";
$query_nama_pelamar = mysqli_query($connect, "select nama_pelamar from tbl_pelamar_master where id = '".$id_pelamar."'");
if(mysqli_num_rows($query_nama_pelamar) > 0){
    $hasil_nama = mysqli_fetch_array($query_nama_pelamar);
    $nama_pelamar = $hasil_nama['nama_pelamar'];
}

?>
<div style="overflow-x: auto; overflow-y: hidden;">
<table class="table table-bordered" id="table_bahasa" style="margin-bottom: 0px;">
    <thead>                  
        <tr>
            <th style="width: 10px; vertical-align: middle;">No</th>
            <th style="text-align: center; vertical-align: middle;">Action</th>
            <th style="text-align: center; vertical-align: middle;">Nama Pelamar</th>
            <th style="text-align: center; vertical-align: middle;">Bahasa</th>
            <th style="text-align: center; vertical-align: middle;">Tingkat Lisan</th>
            <th style="text-align: center; vertical-align: middle;">Tingkat Tulisan</th>
            <th style="text-align: center; vertical-align: middle;">Urutan Bahasa</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        
        $halaman = isset($_GET['halaman']) && $_GET['halaman'] != "" && is_numeric($_GET['halaman']) ? (int) $_GET['halaman'] : 1;
        $query_jumlah_bahasa = mysqli_query($connect, "
            SELECT 
                id,
                nama_bahasa, 
                tingkat_lisan, 
                tingkat_tulisan, 
                urutan_bahasa 
            FROM `tbl_ketrampilan_bahasa` where id_pelamar = '".$id_pelamar."'
        " . $search);
        $jumlah_bahasa = mysqli_num_rows($query_jumlah_bahasa);
        $batas_data = 10;
        
        $jumlah_halaman = ceil($jumlah_bahasa / $batas_data);
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
        
        $query_bahasa = mysqli_query($connect, "
            SELECT 
                id,
                nama_bahasa, 
                tingkat_lisan, 
                tingkat_tulisan, 
                urutan_bahasa 
            FROM `tbl_ketrampilan_bahasa` where id_pelamar = '".$id_pelamar."'
        " . $search . " order by nama_bahasa asc limit $start, $batas_data");
        if(mysqli_num_rows($query_bahasa) > 0){
            $no = $start + 1;
            while($hasil_bahasa = mysqli_fetch_array($query_bahasa)){
                
                ?>
                <tr>
                    <td style="white-space: nowrap;"><?php echo $no; ?></td>
                    <td style="white-space: nowrap;">
                        <a href="index.php?page=<?php echo $base_url_action_edit; ?>&id=<?php echo $id_pelamar; ?>&id_bahasa=<?php echo $hasil_bahasa['id']; ?>" style="text-decoration: none;">Edit</a> - 
                        <a href="javascript: hapus_data('index.php?page=<?php echo $base_url_action_hapus; ?>&idhapus=<?php echo $hasil_bahasa['id']; ?>&id_bahasa=<?php echo $id_pelamar; ?>');" style="text-decoration: none;">Hapus</a>
                    </td>
                    <td style="white-space: nowrap;"><?php echo $nama_pelamar; ?></td>
                    <td style="white-space: nowrap;"><?php echo $hasil_bahasa['nama_bahasa']; ?></td>
                    <td style="white-space: nowrap;"><?php echo $hasil_bahasa['tingkat_lisan']; ?></td>
                    <td style="white-space: nowrap;"><?php echo $hasil_bahasa['tingkat_tulisan']; ?></td>
                    <td style="white-space: nowrap;"><?php echo $hasil_bahasa['urutan_bahasa']; ?></td>
                </tr>
                <?php
                $no++;
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
                <td colspan="7">Belum ada Info Ketrampilan Bahasa untuk <b><?php echo $nama_pelamar; ?></b>.</td>
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
        <li class="page-item"><a class="page-link" href="index.php?page=form-pelamar-languague-perperson&id=<?php echo $id_pelamar; ?>&halaman=<?php echo ($i + $tambah) . $q; ?>"<?php echo ($i + $tambah) == $halaman ? " style='background-color: rgba(0,0,0,0.2);'" : ""; ?>><?php echo ($i + $tambah); ?></a></li>
        <?php } ?>
    </ul>
</div>