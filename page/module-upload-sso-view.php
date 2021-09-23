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
        if(isset($_GET['page'])){
            header("location: login.php");
        } else {
            header("location: ../login.php");
        }
    }
}
check_page("view-log");

$search = isset($_GET['q']) && $_GET['q'] != "" ? "
    where 
        a.nama_file like '%".mysqli_real_escape_string($connect, urldecode($_GET['q']))."%'
    " : "";
$q = isset($_GET['q']) && $_GET['q'] != "" ? "&q=" . urlencode($_GET['q']) : "";
$s = isset($_GET['q']) && $_GET['q'] != "" ? urlencode($_GET['q']) : "";
?>
<div class="row">
    <div class="col-sm-8"></div>
    <div class="col-sm-4">
        <input onkeyup="cari(this.value);" type="text" class="form-control" placeholder="Cari File" name="cari_file" id="cari_file" value="<?php echo $s; ?>">
    </div> 
</div>
<br />
<div id="hasil_file_excel">
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
            <th style="text-align: center; vertical-align: middle; white-space: nowrap;">Action</th>
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
                    <td style="white-space: nowrap;"><a href="excel/file/<?php echo $hasil_file_excel['nama_file']; ?>" style="text-decoration: none;">Download</a></td>
                </tr>
                <?php
                $no++;
            }
        } else {
            ?>
            <tr>
                <td colspan="8">Belum ada file Excel yang di Upload.</td>
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
        <li class="page-item"><a class="page-link" href="index.php?page=upload-sso-view&halaman=<?php echo ($i + $tambah) . $q; ?>"<?php echo ($i + $tambah) == $halaman ? " style='background-color: rgba(0,0,0,0.2);'" : ""; ?>><?php echo ($i + $tambah); ?></a></li>
        <?php } ?>
    </ul>
</div>
</div>

<script type="text/javascript">

var array_search = [];
var addrs_search = 0;
var addrs_ajax = 0;
var procs_ajax = 0;
function cari(string_search){
    array_search[addrs_search] = string_search;
    get_hasil();
    addrs_search++;
}

function get_hasil(){
    if(typeof array_search[addrs_ajax] !== "undefined" && !procs_ajax){
        procs_ajax = 1;
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function(){
            if(this.readyState === 4 && this.status === 200){
                var hasil_file_excel = document.getElementById("hasil_file_excel");
                hasil_file_excel.innerHTML = this.responseText;
                load_td();
                setTimeout(function(){
                    procs_ajax = 0;
                    get_hasil();
                    addrs_ajax++;
                }, 200);
            }
        };
        xmlhttp.open("GET","ajax/get_file_excel.php?q=" + encodeURI(array_search[addrs_ajax]));
        xmlhttp.send(null);
    }
}

var halaman = "<?php echo $halaman; ?>";
var batas_data = "<?php echo $batas_data; ?>";
var search = "<?php echo urlencode($search); ?>";

function get_logs_view(){
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function(){
        if(this.readyState === 4 && this.status === 200){
            var hasil = JSON.parse(this.responseText);
            for(var i = 0; i < hasil.length; i++){
                var get_td = document.getElementsByTagName("td");
                for(var j = 0; j < get_td.length; j++){
                    if(get_td[j].getAttribute("identitas") === hasil[i].nama_file + "_insert_pelamar_master"){
                        get_td[j].innerHTML = hasil[i].insert_pelamar_master;
                    }
                    if(get_td[j].getAttribute("identitas") === hasil[i].nama_file + "_upadate_pelamar_master"){
                        get_td[j].innerHTML = hasil[i].upadate_pelamar_master;
                    }
                    if(get_td[j].getAttribute("identitas") === hasil[i].nama_file + "_insert_lamaran"){
                        get_td[j].innerHTML = hasil[i].insert_lamaran;
                    }
                    if(get_td[j].getAttribute("identitas") === hasil[i].nama_file + "_update_lamaran"){
                        get_td[j].innerHTML = hasil[i].update_lamaran;
                    }
                    if(get_td[j].getAttribute("identitas") === hasil[i].nama_file + "_insert_lamaran_bidang_baru"){
                        get_td[j].innerHTML = hasil[i].insert_lamaran_bidang_baru;
                    }
                    if(get_td[j].getAttribute("identitas") === hasil[i].nama_file + "_total_detik"){
                        get_td[j].innerHTML = hasil[i].total_detik;
                    }
                }
            }
            setTimeout(function(){
                get_logs_view();
            }, 1000);
        }
    };
    xmlhttp.open("GET","ajax/get_logs_view.php?halaman=" + halaman + "&batas_data=" + batas_data + "&search=" + search);
    xmlhttp.send(null);
}

setTimeout(function(){
    get_logs_view();
}, 2000);

</script>