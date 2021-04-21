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
check_page("form-pelamar");

$base_url_action_edit = "form-pelamar-add";
$base_url_action_hapus = "form-pelamar-hapus";

$search = isset($_GET['q']) && $_GET['q'] != "" ? "
    where 
        a.position like '%".mysqli_real_escape_string($connect, urldecode($_GET['q']))."%' or
        a.nama_pelamar like '%".mysqli_real_escape_string($connect, urldecode($_GET['q']))."%' or
        a.nik like '%".mysqli_real_escape_string($connect, urldecode($_GET['q']))."%' or
        a.umur like '%".mysqli_real_escape_string($connect, urldecode($_GET['q']))."%' or
        a.tempat_lahir like '%".mysqli_real_escape_string($connect, urldecode($_GET['q']))."%' or
        a.tanggal_lahir like '%".mysqli_real_escape_string($connect, urldecode($_GET['q']))."%'
    " : "";
$q = isset($_GET['q']) && $_GET['q'] != "" ? "&q=" . urlencode($_GET['q']) : "";
$s = isset($_GET['q']) && $_GET['q'] != "" ? urlencode($_GET['q']) : "";
?>
<div class="row">
    <div class="col-sm-8"></div>
    <div class="col-sm-4">
        <input onkeyup="cari(this.value);" type="text" class="form-control" placeholder="Cari Applicant" name="cari_applicant" id="cari_open_position" value="<?php echo $s; ?>">
    </div> 
</div>
<br />
<div id="hasil_pelamar">
<div style="overflow-x: auto; overflow-y: hidden;">
<table class="table table-bordered" id="table_pelamar" style="margin-bottom: 0px;">
    <thead>                  
        <tr>
            <th style="width: 10px; vertical-align: middle;">No</th>
            <th style="text-align: center; vertical-align: middle;">Action</th>
            <th style="text-align: center; vertical-align: middle;">Position</th>
            <th style="text-align: center; vertical-align: middle;">Jenis Kelamin</th>
            <th style="text-align: center; vertical-align: middle;">Nama Pelamar</th>
            <th style="text-align: center; vertical-align: middle;">NIK</th>
            <th style="text-align: center; vertical-align: middle;">Umur</th>
            <th style="text-align: center; vertical-align: middle;">Tempat Lahir</th>
            <th style="text-align: center; vertical-align: middle;">Tanggal Lahir</th>
            <th style="text-align: center; vertical-align: middle;">Universitas</th>
            <th style="text-align: center; vertical-align: middle;">Jurusan</th>
            <th style="text-align: center; vertical-align: middle;">IPK</th>
            <th style="text-align: center; vertical-align: middle;">File KTP</th>
            <th style="text-align: center; vertical-align: middle;">File Ijazah</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        
        $halaman = isset($_GET['halaman']) && $_GET['halaman'] != "" && is_numeric($_GET['halaman']) ? (int) $_GET['halaman'] : 1;
        $query_jumlah_pelamar = mysqli_query($connect, "
            select * from (
            select 
                id,
                (select open_position from tbl_event where id = id_position) position,
                id_position,
                universitas,
                jurusan,
                nama_pelamar,
                nik,
                umur,
                tempat_lahir,
                tanggal_lahir, 
                ipk,
                file_ktp,
                file_ijazah,
                jenis_kelamin
            from tbl_pelamar
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
                    (select open_position from tbl_event where id = id_position) position,
                    id_position,
                    universitas,
                    jurusan,
                    nama_pelamar,
                    nik,
                    umur,
                    tempat_lahir,
                    tanggal_lahir, 
                    ipk,
                    file_ktp,
                    file_ijazah,
                    jenis_kelamin
                from tbl_pelamar
            ) a " . $search . " order by id_position asc, nama_pelamar asc limit $start, $batas_data");
        if(mysqli_num_rows($query_pelamar) > 0){
            $no = $start + 1;
            while($hasil_pelamar = mysqli_fetch_array($query_pelamar)){
                
                $query_position = mysqli_query($connect, "select open_position from tbl_event where id = '".$hasil_pelamar['id_position']."'");
                $hasil_position = mysqli_num_rows($query_position) > 0 ? mysqli_fetch_array($query_position) : array('open_position' => '<font style="font-family: consolas, monospace;">Undefined</font>');
                
                $query_universitas = mysqli_query($connect, "select universitas from tbl_universitas where id = '".$hasil_pelamar['universitas']."'");
                $hasil_universitas = mysqli_num_rows($query_universitas) > 0 ? mysqli_fetch_array($query_universitas) : array('universitas' => '<font style="font-family: consolas, monospace;">Undefined</font>');
                
                $query_jurusan = mysqli_query($connect, "select jurusan from tbl_jurusan where id = '".$hasil_pelamar['jurusan']."'");
                $hasil_jurusan = mysqli_num_rows($query_jurusan) > 0 ? mysqli_fetch_array($query_jurusan) : array('jurusan' => '<font style="font-family: consolas, monospace;">Undefined</font>');
                
                $file_ktp = "";
                if($hasil_pelamar['file_ktp'] != "" && file_exists("../ocrapi/upload/ktp/" . $hasil_pelamar['file_ktp'])){
                    $file_ktp = "<img src='../ocrapi/upload/ktp/".$hasil_pelamar['file_ktp']."' style='width: 200px;' />"; 
                } else {
                    $file_ktp = "File KTP not found.";
                }
                
                $file_ijazah = "";
                if($hasil_pelamar['file_ijazah'] != "" && file_exists("../ocrapi/upload/ijazah/" . $hasil_pelamar['file_ijazah'])){
                    $file_ijazah = "<a href='../ocrapi/upload/ijazah/".$hasil_pelamar['file_ijazah']."' target='_blank'>Download</a>"; 
                } else {
                    $file_ijazah = "File Ijazah not found.";
                }
                
                ?>
                <tr>
                    <td><?php echo $no; ?></td>
                    <td style="white-space: nowrap;">
                        <a href="index.php?page=<?php echo $base_url_action_edit; ?>&id=<?php echo $hasil_pelamar['id']; ?>" style="text-decoration: none;">Edit</a> - 
                        <a href="javascript: hapus_data('index.php?page=<?php echo $base_url_action_hapus; ?>&idhapus=<?php echo $hasil_pelamar['id']; ?>');" style="text-decoration: none;">Hapus</a>
                    </td>
                    <td><?php echo $hasil_position['open_position']; ?></td>
                    <td><?php echo $hasil_pelamar['jenis_kelamin']; ?></td>
                    <td><?php echo $hasil_pelamar['nama_pelamar']; ?></td>
                    <td><?php echo $hasil_pelamar['nik']; ?></td>
                    <td><?php echo $hasil_pelamar['umur']; ?></td>
                    <td><?php echo $hasil_pelamar['tempat_lahir']; ?></td>
                    <td><?php echo $hasil_pelamar['tanggal_lahir']; ?></td>
                    <td><?php echo $hasil_universitas['universitas']; ?></td>
                    <td><?php echo $hasil_jurusan['jurusan']; ?></td>
                    <td><?php echo $hasil_pelamar['ipk']; ?></td>
                    <td><?php echo $file_ktp; ?></td>
                    <td><?php echo $file_ijazah; ?></td>
                </tr>
                <?php
                $no++;
            }
        } else {
            ?>
            <tr>
                <td colspan="14">Belum ada data Open Position.</td>
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
</div>

<script type="text/javascript">

function hapus_data(url){
    if(confirm("Menghapus data akan menghapus file KTP dan Ijazah.\n\nApakah anda yakin ?")){
        document.location = url;
    }
}


function cari(string_search){
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function(){
        if(this.readyState === 4 && this.status === 200){
            var hasil_pelamar = document.getElementById("hasil_pelamar");
            hasil_pelamar.innerHTML = this.responseText;
            load_td();
        }
    };
    xmlhttp.open("GET","ajax/get_pelamar.php?q=" + encodeURI(string_search));
    xmlhttp.send(null);
}


</script>