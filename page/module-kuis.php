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
check_page("kuis");

$base_url_action_edit = "?page=kuis-edit";
$base_url_action_hapus = "?page=kuis-hapus";

?>
<table class="table table-bordered">
    <thead>                  
        <tr>
            <th style="width: 10px">No</th>
            <th>Nama Perusahaan</th>
            <th>Nama Department</th>
            <th>Kategori Kuis</th>
            <th>Pengguna Perusahaan</th> 
            <th>Soal</th> 
            <th>Pilihan A</th> 
            <th>Pilihan B</th> 
            <th>Pilihan C</th> 
            <th>Pilihan D</th> 
            <th>Pilihan Benar</th>
            <th>Nilai</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        
        $query_kuis = mysqli_query($connect, "select * from tbl_kuis order by id_perusahaan asc, id_department asc");
        if(mysqli_num_rows($query_kuis) > 0){
            $no = 1;
            while($hasil_kuis = mysqli_fetch_array($query_kuis)){
                $query_nama_perusahaan = mysqli_query($connect, "select nama_perusahaan from tbl_perusahaan where id = '".$hasil_kuis['id_perusahaan']."'");
                $nama_perusahaan = "";
                if(mysqli_num_rows($query_nama_perusahaan) > 0){
                    $hasil_nama_perusahaan = mysqli_fetch_array($query_nama_perusahaan);
                    $nama_perusahaan = $hasil_nama_perusahaan['nama_perusahaan'];
                }
                
                $query_nama_department = mysqli_query($connect, "select nama_department from tbl_department where id = '".$hasil_kuis['id_department']."'");
                $nama_department = "";
                if(mysqli_num_rows($query_nama_department) > 0){
                    $hasil_nama_department = mysqli_fetch_array($query_nama_department);
                    $nama_department = $hasil_nama_department['nama_department'];
                }
                
                $query_karyawan = mysqli_query($connect, "select nama_lengkap from tbl_karyawan where id = '".$hasil_kuis['id_pengguna_perusahaan']."'");
                $nama_karyawan = "";
                if(mysqli_num_rows($query_karyawan) > 0){
                    $hasil_nama_karyawan = mysqli_fetch_array($query_karyawan);
                    $nama_karyawan = $hasil_nama_karyawan['nama_lengkap'];
                }
                
                $query_kategori_kuis = mysqli_query($connect, "select kategori_kuis from tbl_kuis_kategori where id = '".$hasil_kuis['id_kuis_kategori']."'");
                $nama_kategori_kuis = "";
                if(mysqli_num_rows($query_kategori_kuis) > 0){
                    $hasil_kategori_kuis = mysqli_fetch_array($query_kategori_kuis);
                    $kategori_kuis = $hasil_kategori_kuis['kategori_kuis'];
                }
                ?>
                <tr>
                    <td><?php echo $no; ?></td>
                    <td><?php echo $nama_perusahaan; ?></td>
                    <td><?php echo $nama_department; ?></td>
                    <td><?php echo $kategori_kuis; ?></td>
                    <td><?php echo $nama_karyawan; ?></td>
                    <td><?php echo $hasil_kuis['soal']; ?></td>
                    <td><?php echo $hasil_kuis['pilihan_a']; ?></td>
                    <td><?php echo $hasil_kuis['pilihan_b']; ?></td>
                    <td><?php echo $hasil_kuis['pilihan_c']; ?></td>
                    <td><?php echo $hasil_kuis['pilihan_d']; ?></td>
                    <td><?php echo $hasil_kuis['pilihan_benar']; ?></td>
                    <td><?php echo $hasil_kuis['nilai']; ?></td>
                    <td><a href="index.php<?php echo $base_url_action_edit; ?>">Edit</a> - <a href="index.php<?php echo $base_url_action_hapus; ?>">Hapus</a></td>
                </tr>
                <?php
                $no++;
            }
        } else {
            ?>
            <tr>
                <td colspan="13">Belum ada data Kategori Kuis.</td>
            </tr>  
            <?php 
            
        }
        
        ?>
        
    </tbody>
</table>
<div class="card-footer clearfix" style="padding-right: 0px; background-color: #fff;">
    <ul class="pagination pagination-sm m-0 float-right">
        <li class="page-item"><a class="page-link" href="#">«</a></li>
        <li class="page-item"><a class="page-link" href="#">1</a></li>
        <li class="page-item"><a class="page-link" href="#">2</a></li>
        <li class="page-item"><a class="page-link" href="#">3</a></li>
        <li class="page-item"><a class="page-link" href="#">»</a></li>
    </ul>
</div>