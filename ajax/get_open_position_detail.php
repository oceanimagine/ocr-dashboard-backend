<?php

include_once "../koneksi.php";

$search = isset($_GET['q']) && $_GET['q'] != "" ? " and (b.nama_pelamar like '%" . mysqli_real_escape_string($connect, urldecode($_GET['q'])) . "%' or c.open_position like '%" . mysqli_real_escape_string($connect, urldecode($_GET['q'])) . "%')" : "";
$q = isset($_GET['q']) && $_GET['q'] != "" ? "&q=" . urlencode($_GET['q']) : "";
$id = isset($_GET['id']) && $_GET['id'] != "" && is_numeric($_GET['id']) ? $_GET['id'] : "";

?>
<div id="hasil_op_detail">
<table class="table table-bordered" id="table_openposition_detail">
    <thead>                  
        <tr>
            <th style="vertical-align: middle;">ID API</th>
            <th style="vertical-align: middle;">Position</th>
            <th style="vertical-align: middle;">applicant</th>
            <th style="vertical-align: middle;">Status Send</th>
            <th style="vertical-align: middle;">Status OCR</th>
            <th style="vertical-align: middle;">Document Type</th>
            <th style="vertical-align: middle;">Result OCR Local</th>
            <th style="vertical-align: middle;">Result OCR API</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        
        $halaman = isset($_GET['halaman']) && $_GET['halaman'] != "" && is_numeric($_GET['halaman']) ? (int) $_GET['halaman'] : 1;
        $query_jumlah_perusahan = mysqli_query($connect, "
            select 
                a.id_document, 
                a.id_position, 
                a.id_pelamar, 
                a.status_ocr, 
                a.hasil_ocr, 
                a.document_type, 
                b.nama_pelamar, 
                c.open_position 
            from 
                tbl_document_track a, 
                tbl_pelamar b, 
                tbl_event c 
            where 
                a.id_position = '".$id."' and 
                a.id_pelamar = b.id and 
                a.id_position = c.id
                ".$search."
        ");
        $jumlah_openposition_detail = mysqli_num_rows($query_jumlah_perusahan);
        $batas_data = 10;
        
        $jumlah_halaman = ceil($jumlah_openposition_detail / $batas_data);
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
        
        $query_openposition_detail = mysqli_query($connect, "   
            select 
                a.id_document, 
                a.id_position, 
                a.id_pelamar, 
                a.status_ocr, 
                a.status_send,
                a.hasil_ocr, 
                a.document_type, 
                b.nama_pelamar, 
                c.open_position 
            from 
                tbl_document_track a, 
                tbl_pelamar b, 
                tbl_event c 
            where 
                a.id_position = '".$id."' and 
                a.id_pelamar = b.id and 
                a.id_position = c.id
                ".$search."
            limit $start, $batas_data
        ");
        if(mysqli_num_rows($query_openposition_detail) > 0){
            $no = $start + 1;
            while($hasil_openposition_detail = mysqli_fetch_array($query_openposition_detail)){
                $query_position = mysqli_query($connect, "select open_position from tbl_event where id = '".$hasil_openposition_detail['id_position']."'");
                $hasil_position = mysqli_num_rows($query_position) > 0 ? mysqli_fetch_array($query_position) : array("open_position" => "Undefined");
                $query_pelamar = mysqli_query($connect, "select nama_pelamar from tbl_pelamar where id = '".$hasil_openposition_detail['id_pelamar']."'");
                $hasil_pelamar = mysqli_num_rows($query_pelamar) > 0 ? mysqli_fetch_array($query_pelamar) : array("nama_pelamar" => "Undefined");
                
                ?>
                <tr>
                    <td><?php echo $hasil_openposition_detail['id_document']; ?></td>
                    <td><?php echo $hasil_position['open_position']; ?></td>
                    <td><?php echo $hasil_pelamar['nama_pelamar']; ?></td>
                    <td class="row_send" id_data="<?php echo $hasil_openposition_detail['id_document']; ?>"><?php echo $hasil_openposition_detail['status_send']; ?></td>
                    <td class="row_ocr" id_data="<?php echo $hasil_openposition_detail['id_document']; ?>"><?php echo $hasil_openposition_detail['status_ocr']; ?></td>
                    <td><?php echo $hasil_openposition_detail['document_type']; ?></td>
                    <td><a href="index.php?page=openposition-detail-local&file=<?php echo $hasil_openposition_detail['hasil_ocr']; ?>&type=<?php echo $hasil_openposition_detail['document_type']; ?>&id_openposition=<?php echo $hasil_openposition_detail['id_position'] . $halaman_before; ?>">Check Result</a></td>
                    <td><a href="index.php<?php echo $base_url_action_edit; ?>&id=<?php echo $hasil_openposition_detail['id_document']; ?>&id_openposition=<?php echo $hasil_openposition_detail['id_position'] . $halaman_before; ?>">Check Result</a></td>
                </tr>
                <?php
                $no++;
            }
        } else {
            ?>
            <tr>
                <td colspan="8">Belum ada data Open Position Detail OCR.</td>
            </tr>  
            <?php 
            
        }
        
        ?>
        
    </tbody>
</table>
<div class="card-footer clearfix" style="padding-right: 0px; background-color: #fff;">
    <ul class="pagination pagination-sm m-0 float-right">
        <?php for($i = 1; $i <= $batas_halaman; $i++){ ?>
        <li class="page-item"><a class="page-link" href="index.php?page=openposition-detail&id=<?php echo $id; ?>&halaman=<?php echo ($i + $tambah) . $q; ?>"<?php echo ($i + $tambah) == $halaman ? " style='background-color: rgba(0,0,0,0.2);'" : ""; ?>><?php echo ($i + $tambah); ?></a></li>
        <?php } ?>
    </ul>
</div>