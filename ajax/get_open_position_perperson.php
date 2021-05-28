<?php

include_once "../koneksi.php";

$base_url_action_edit = "form-pelamar-open-position-perperson-add";
$base_url_action_hapus = "form-pelamar-open-position-perperson-hapus";

$id_pelamar = isset($_GET['id']) && $_GET['id'] != "" && is_numeric($_GET['id']) ? mysqli_real_escape_string($connect, $_GET['id']) : ""; 
$search = isset($_GET['q']) && $_GET['q'] != "" ? "
    and 
        b.open_position like '%".mysqli_real_escape_string($connect, urldecode($_GET['q']))."%'
    " : "";
$q = isset($_GET['q']) && $_GET['q'] != "" ? "&q=" . urlencode($_GET['q']) : "";
$s = isset($_GET['q']) && $_GET['q'] != "" ? urlencode($_GET['q']) : "";

?>


<div style="overflow-x: auto; overflow-y: hidden;">
<table class="table table-bordered" id="table_open_position" style="margin-bottom: 0px;">
    <thead>                  
        <tr>
            <th style="width: 10px; vertical-align: middle;">No</th>
            <th style="text-align: center; vertical-align: middle;">Action</th>
            <th style="text-align: center; vertical-align: middle;">Nama Pelamar</th>
            <th style="text-align: center; vertical-align: middle;">Open Position</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        
        $halaman = isset($_GET['halaman']) && $_GET['halaman'] != "" && is_numeric($_GET['halaman']) ? (int) $_GET['halaman'] : 1;
        $query_jumlah_open_position = mysqli_query($connect, "
            SELECT a.`id_position`, a.`nama_pelamar`, b.open_position FROM `tbl_pelamar` a, `tbl_event` b where a.`id_position` = b.id and a.id = '".$id_pelamar."'
        " . $search);
        $jumlah_open_position = mysqli_num_rows($query_jumlah_open_position);
        $batas_data = 10;
        
        $jumlah_halaman = ceil($jumlah_open_position / $batas_data);
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
        
        $query_open_position = mysqli_query($connect, "
            SELECT a.`id`, a.`id_position`, a.`nama_pelamar`, b.open_position FROM `tbl_pelamar` a, `tbl_event` b where a.`id_position` = b.id and a.id = '".$id_pelamar."'" . $search . " order by b.open_position asc limit $start, $batas_data");
        if(mysqli_num_rows($query_open_position) > 0){
            $no = $start + 1;
            while($hasil_open_position = mysqli_fetch_array($query_open_position)){
                
                ?>
                <tr>
                    <td><?php echo $no; ?></td>
                    <td style="white-space: nowrap;">
                        <a href="index.php?page=<?php echo $base_url_action_edit; ?>&id=<?php echo $hasil_open_position['id']; ?>&id_open_position=<?php echo $hasil_open_position['id_position']; ?>" style="text-decoration: none;">Edit</a> - 
                        <a href="javascript: hapus_data('index.php?page=<?php echo $base_url_action_hapus; ?>&idhapus=<?php echo $hasil_open_position['id']; ?>&id_open_position=<?php echo $hasil_open_position['id_position']; ?>');" style="text-decoration: none;">Hapus</a>
                    </td>
                    <td><?php echo $hasil_open_position['nama_pelamar']; ?></td>
                    <td><?php echo $hasil_open_position['open_position']; ?></td>
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
                <td colspan="4">Belum ada Open Position untuk <b><?php echo $nama_pelamar; ?></b>.</td>
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
        <li class="page-item"><a class="page-link" href="index.php?page=form-universitas&halaman=<?php echo ($i + $tambah) . $q; ?>"<?php echo ($i + $tambah) == $halaman ? " style='background-color: rgba(0,0,0,0.2);'" : ""; ?>><?php echo ($i + $tambah); ?></a></li>
        <?php } ?>
    </ul>
</div>