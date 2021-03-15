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

$base_url_action_edit = "?page=openposition-edit";
$base_url_action_hapus = "?page=openposition-hapus";

?>
<table class="table table-bordered" id="table_openposition">
    <thead>                  
        <tr>
            <th style="width: 10px">No</th>
            <th>Open Position</th>
            <th>Sent Amount</th>
            <th>Done Amount</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        
        $halaman = isset($_GET['halaman']) && $_GET['halaman'] != "" && is_numeric($_GET['halaman']) ? (int) $_GET['halaman'] : 1;
        $query_jumlah_perusahan = mysqli_query($connect, "select id, open_position from tbl_event");
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
        
        $query_openposition = mysqli_query($connect, "select id, open_position from tbl_event order by open_position asc limit $start, $batas_data");
        if(mysqli_num_rows($query_openposition) > 0){
            $no = $start + 1;
            while($hasil_openposition = mysqli_fetch_array($query_openposition)){
                $query_done_ = mysqli_query($connect, "select id_position from tbl_document_track where id_position = '".$hasil_openposition['id']."' and status_ocr = 'Done'");
                $jumlah_done = mysqli_num_rows($query_done_);
                $query_sent_ = mysqli_query($connect, "select id_position from tbl_document_track where id_position = '".$hasil_openposition['id']."'");
                $jumlah_sent = mysqli_num_rows($query_sent_);
                ?>
                <tr>
                    <td><?php echo $no; ?></td>
                    <td><?php echo $hasil_openposition['open_position']; ?></td>
                    <td class="row_sent" id_data="<?php echo $hasil_openposition['id']; ?>"><?php echo $jumlah_sent; ?></td>
                    <td class="row_done" id_data="<?php echo $hasil_openposition['id']; ?>"><?php echo $jumlah_done; ?></td>
                    <td><a href="index.php<?php echo $base_url_action_edit; ?>&id=<?php echo $hasil_openposition['id']; ?>">Detail</a></td>
                </tr>
                <?php
                $no++;
            }
        } else {
            ?>
            <tr>
                <td colspan="5">Belum ada data Open Position.</td>
            </tr>  
            <?php 
            
        }
        
        ?>
        
    </tbody>
</table>
<div class="card-footer clearfix" style="padding-right: 0px; background-color: #fff;">
    <ul class="pagination pagination-sm m-0 float-right">
        <?php for($i = 1; $i <= $batas_halaman; $i++){ ?>
        <li class="page-item"><a class="page-link" href="index.php?page=openposition&halaman=<?php echo ($i + $tambah); ?>"<?php echo ($i + $tambah) == $halaman ? " style='background-color: rgba(0,0,0,0.2);'" : ""; ?>><?php echo ($i + $tambah); ?></a></li>
        <?php } ?>
    </ul>
</div>


<script type="text/javascript">

function ajax_sent(object_td, link){
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function(){
        if(this.readyState === 4 and this.status === 200){
            console.log(this.responseText);
        }
    };
    xmlhttp.open("GET","ajax/" + link);
    xmlhttp.send(null);
}

window.addEventListener("load", function(){
    console.log("masuk");
    var table_openposition = document.getElementById("table_openposition");
    var get_td = table_openposition.getElementsByTagName("td");
    for(var i = 0; i < get_td.length; i++){
        if(get_td[i].getAttribute("class") === "row_sent"){
            var id_data = get_td[i].getAttribute("id_data");
            // console.log(id_data);
        }
    }
});

</script>