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
$base_url_action_logs = "?page=openposition-logs";
$halaman_before = isset($_GET['halaman']) && $_GET['halaman'] != "" && is_numeric($_GET['halaman']) ? "&halaman_old=" . $_GET['halaman'] : "";

$search = isset($_GET['q']) && $_GET['q'] != "" ? " where open_position like '%" . mysqli_real_escape_string($connect, urldecode($_GET['q'])) . "%'" : "";
$q = isset($_GET['q']) && $_GET['q'] != "" ? "&q=" . urlencode($_GET['q']) : "";
$s = isset($_GET['q']) && $_GET['q'] != "" ? urlencode($_GET['q']) : "";
?>
<div class="row">
    <div class="col-sm-8"></div>
    <div class="col-sm-4">
        <input onkeyup="cari(this.value);" type="text" class="form-control" placeholder="Cari Open Position" name="cari_open_position" id="cari_open_position" value="<?php echo $s; ?>">
    </div> 
</div>
<br />
<div id="hasil_op">
<table class="table table-bordered" id="table_openposition">
    <thead>                  
        <tr>
            <th style="width: 10px">No</th>
            <th>Open Position</th>
            <th>Sent Amount</th>
            <th>Done Amount</th>
            <th>Applicant Amount</th>
            <th>Callback</th>
            <th>Reset</th>
            <th>Action</th>
            <th>Logs</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        
        $halaman = isset($_GET['halaman']) && $_GET['halaman'] != "" && is_numeric($_GET['halaman']) ? (int) $_GET['halaman'] : 1;
        $query_jumlah_perusahan = mysqli_query($connect, "select id, open_position from tbl_event" . $search);
        $jumlah_openposition = mysqli_num_rows($query_jumlah_perusahan);
        $batas_data = 10;
        
        $jumlah_halaman = ceil($jumlah_openposition / $batas_data);
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
        
        $query_openposition = mysqli_query($connect, "select id, open_position from tbl_event " . $search . " order by open_position asc limit $start, $batas_data");
        if(mysqli_num_rows($query_openposition) > 0){
            $no = $start + 1;
            while($hasil_openposition = mysqli_fetch_array($query_openposition)){
                $query_done_ = mysqli_query($connect, "select id_position from tbl_document_track where id_position = '".$hasil_openposition['id']."' and status_ocr = 'Done'");
                $jumlah_done = mysqli_num_rows($query_done_);
                $query_sent_ = mysqli_query($connect, "select id_position from tbl_document_track where id_position = '".$hasil_openposition['id']."'");
                $jumlah_sent = mysqli_num_rows($query_sent_);
                $query_applicant_ = mysqli_query($connect, "select count(id_position) jumlah_pelamar from tbl_pelamar where id_position = '".$hasil_openposition['id']."'");
                $jumlah_applicant = mysqli_fetch_array($query_applicant_);
                ?>
                <tr>
                    <td><?php echo $no; ?></td>
                    <td><?php echo $hasil_openposition['open_position']; ?></td>
                    <td class="row_sent" id_data="<?php echo $hasil_openposition['id']; ?>" style="text-align: right;"><?php echo $jumlah_sent; ?></td>
                    <td class="row_done" id_data="<?php echo $hasil_openposition['id']; ?>" style="text-align: right;"><?php echo $jumlah_done; ?></td>
                    <td style="text-align: right;"><?php echo $jumlah_applicant['jumlah_pelamar']; ?></td>
                    <td><a href="https://ocr-solution.id:7000/ocrapi/callback-tambahan.php?id_op=<?php echo $hasil_openposition['id']; ?>" target="_blank">Hit Callback</a></td>
                    <td><a href="javascript: reset('<?php echo $hasil_openposition['id']; ?>');">Reset</a></td>
                    <td><a href="index.php<?php echo $base_url_action_edit; ?>&id=<?php echo $hasil_openposition['id'] . $halaman_before; ?>">Detail</a></td>
                    <td><a href="index.php<?php echo $base_url_action_logs; ?>&id=<?php echo $hasil_openposition['id'] . $halaman_before; ?>">See Logs</a></td>
                </tr>
                <?php
                $no++;
            }
        } else {
            ?>
            <tr>
                <td colspan="7">Belum ada data Open Position.</td>
            </tr>  
            <?php 
            
        }
        
        ?>
        
    </tbody>
</table>
<div class="card-footer clearfix" style="padding-right: 0px; background-color: #fff;">
    <ul class="pagination pagination-sm m-0 float-right">
        <?php for($i = 1; $i <= $batas_halaman; $i++){ ?>
        <li class="page-item"><a class="page-link" href="index.php?page=openposition&halaman=<?php echo ($i + $tambah) . $q; ?>"<?php echo ($i + $tambah) == $halaman ? " style='background-color: rgba(0,0,0,0.2);'" : ""; ?>><?php echo ($i + $tambah); ?></a></li>
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
    var table_openposition = document.getElementById("table_openposition");
    var get_td = table_openposition.getElementsByTagName("td");
    for(var i = 0; i < get_td.length; i++){
        if(get_td[i].getAttribute("class") === "row_sent"){
            var id_data = get_td[i].getAttribute("id_data");
            ajax_sent(get_td[i], "get_sent.php?id_position=" + id_data);
        }
        if(get_td[i].getAttribute("class") === "row_done"){
            var id_data = get_td[i].getAttribute("id_data");
            ajax_sent(get_td[i], "get_done.php?id_position=" + id_data);
        }
    }
}

function reset(id_position){
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function(){
        if(this.readyState === 4 && this.status === 200){
            var json_result = JSON.parse(this.responseText);
            if(typeof json_result.message !== "undefined" && json_result.message === "Berhasil Melakukan Proses Reset."){
                var keterangan_api_reset = document.getElementById("keterangan_api_reset");
                keterangan_api_reset.innerHTML = json_result.message;
            } else {
                var keterangan_api_reset = document.getElementById("keterangan_api_reset");
                keterangan_api_reset.innerHTML = "Gagal melakukan Reset Event.";
            }
            $('#modal-api-reset').modal('show');
        }
    };
    var send_position = typeof id_position !== "undefined" ? "&id_event=" + id_position : "";
    xmlhttp.open("POST","https://ocr-solution.id:7000/ocrapi/ocr/reset_all");
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("username=Admin&password=admin&token=e3afed0047b08059d0fada10f400c1e535ce60f4312d5e5448020201213213232" + send_position);
} 

function cari(string_search){
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function(){
        if(this.readyState === 4 && this.status === 200){
            var hasil_op = document.getElementById("hasil_op");
            hasil_op.innerHTML = this.responseText;
            load_td();
        }
    };
    xmlhttp.open("GET","ajax/get_open_position.php?q=" + encodeURI(string_search));
    xmlhttp.send(null);
}

window.addEventListener("load", function(){
    load_td();
});

</script>