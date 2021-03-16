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
check_page("openposition-detail");

$base_url_action_edit = "?page=openposition-detail-api";
$base_url_action_hapus = "?page=openposition-hapus";
$id = isset($_GET['id']) && $_GET['id'] != "" && is_numeric($_GET['id']) ? $_GET['id'] : "";
$halaman_before = isset($_GET['halaman']) && $_GET['halaman'] != "" && is_numeric($_GET['halaman']) ? "&halaman_old=" . $_GET['halaman'] : "";
$query_jumlah = mysqli_query($connect, "
    
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
        
");
if(mysqli_num_rows($query_jumlah) > 0){
$search = isset($_GET['q']) && $_GET['q'] != "" ? " and (b.nama_pelamar like '%" . mysqli_real_escape_string($connect, urldecode($_GET['q'])) . "%' or c.open_position like '%" . mysqli_real_escape_string($connect, urldecode($_GET['q'])) . "%' or a.status_ocr like '%" . mysqli_real_escape_string($connect, urldecode($_GET['q'])) . "%' or a.status_send like '%" . mysqli_real_escape_string($connect, urldecode($_GET['q'])) . "%')" : "";
$q = isset($_GET['q']) && $_GET['q'] != "" ? "&q=" . urlencode($_GET['q']) : "";
$s = isset($_GET['q']) && $_GET['q'] != "" ? urlencode($_GET['q']) : "";
?>
<div class="row">
    <div class="col-sm-8"></div>
    <div class="col-sm-4">
        <input onkeyup="cari(this.value);" type="text" class="form-control" placeholder="Cari Open Position Detail" name="cari_open_position_detail" id="cari_open_position" value="<?php echo $s; ?>">
    </div> 
</div>
<br />
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
</div>

<script type="text/javascript">

function ajax_sent(object_td, link){
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function(){
        if(this.readyState === 4 && this.status === 200){
            object_td.innerHTML = this.responseText;
            setTimeout(function(){
                ajax_sent(object_td, link);
            }, 1000);
        }
    };
    xmlhttp.open("GET","ajax/" + link);
    xmlhttp.send(null);
}

function load_td(){
    var table_openposition = document.getElementById("table_openposition_detail");
    var get_td = table_openposition.getElementsByTagName("td");
    for(var i = 0; i < get_td.length; i++){
        if(get_td[i].getAttribute("class") === "row_send"){
            var id_data = get_td[i].getAttribute("id_data");
            ajax_sent(get_td[i], "get_status_send.php?id=" + id_data);
        }
        if(get_td[i].getAttribute("class") === "row_ocr"){
            var id_data = get_td[i].getAttribute("id_data");
            ajax_sent(get_td[i], "get_status_ocr.php?id=" + id_data);
        }
    }
}

function cari(string_search){
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function(){
        if(this.readyState === 4 && this.status === 200){
            var hasil_op_detail = document.getElementById("hasil_op_detail");
            hasil_op_detail.innerHTML = this.responseText;
            load_td();
        }
    };
    xmlhttp.open("GET","ajax/get_open_position_detail.php?id=<?php echo $id; ?>&q=" + encodeURI(string_search));
    xmlhttp.send(null);
}

window.addEventListener("load", function(){
    load_td();
});

</script>

<?php 
} else {
    echo "Belum ada data terkait Open Position.";
}