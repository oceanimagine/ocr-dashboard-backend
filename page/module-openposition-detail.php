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
check_page("openposition");

$base_url_action_edit = "?page=openposition-detail";
$base_url_action_hapus = "?page=openposition-hapus";
$id = isset($_GET['id']) && $_GET['id'] != "" && is_numeric($_GET['id']) ? $_GET['id'] : "";
$query_jumlah = mysqli_query($connect, "select id_document, id_position, id_pelamar, status_ocr, hasil_ocr, document_type from tbl_document_track where id_position = '".$id."'");
if(mysqli_num_rows($query_jumlah) > 0){
?>
<table class="table table-bordered" id="table_openposition_detail">
    <thead>                  
        <tr>
            <th>ID API</th>
            <th>Position</th>
            <th>applicant</th>
            <th>Status Send</th>
            <th>Status OCR</th>
            <th>Result OCR</th>
            <th>Document Type</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        
        $halaman = isset($_GET['halaman']) && $_GET['halaman'] != "" && is_numeric($_GET['halaman']) ? (int) $_GET['halaman'] : 1;
        $query_jumlah_perusahan = mysqli_query($connect, "select id_document, id_position, id_pelamar, status_ocr, hasil_ocr, document_type from tbl_document_track where id_position = '".$id."'");
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
        
        $query_openposition_detail = mysqli_query($connect, "select id_document, id_position, id_pelamar, status_ocr, hasil_ocr, document_type, status_send from tbl_document_track where id_position = '".$id."' limit $start, $batas_data");
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
                    <td><?php echo $hasil_openposition_detail['hasil_ocr']; ?></td>
                    <td><?php echo $hasil_openposition_detail['document_type']; ?></td>
                    <td><a href="index.php<?php echo $base_url_action_edit; ?>&id=<?php echo $hasil_openposition_detail['id']; ?>">Check API Result</a></td>
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
        <li class="page-item"><a class="page-link" href="index.php?page=openposition-detail&id=<?php echo $id; ?>&halaman=<?php echo ($i + $tambah); ?>"<?php echo ($i + $tambah) == $halaman ? " style='background-color: rgba(0,0,0,0.2);'" : ""; ?>><?php echo ($i + $tambah); ?></a></li>
        <?php } ?>
    </ul>
</div>

<?php 
} else {
    echo "Belum ada data terkait Open Position.";
}