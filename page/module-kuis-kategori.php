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
check_page("kuis-kategori");

$base_url_action_edit = "?page=kuis-kategori-edit";
$base_url_action_hapus = "?page=kuis-kategori-hapus";

?>
<table class="table table-bordered">
    <thead>                  
        <tr>
            <th style="width: 10px">No</th>
            <th>Nama Perusahaan</th>
            <th>Nama Department</th>
            <th>Kategori Kuis</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        
        $query_kategori_kuis = mysqli_query($connect, "select * from tbl_kuis_kategori order by id_perusahaan asc, id_department asc");
        if(mysqli_num_rows($query_kategori_kuis) > 0){
            $no = 1;
            while($hasil_kategori_kuis = mysqli_fetch_array($query_kategori_kuis)){
                $query_nama_perusahaan = mysqli_query($connect, "select nama_perusahaan from tbl_perusahaan where id = '".$hasil_kategori_kuis['id_perusahaan']."'");
                $nama_perusahaan = "";
                if(mysqli_num_rows($query_nama_perusahaan) > 0){
                    $hasil_nama_perusahaan = mysqli_fetch_array($query_nama_perusahaan);
                    $nama_perusahaan = $hasil_nama_perusahaan['nama_perusahaan'];
                }
                
                $query_nama_department = mysqli_query($connect, "select nama_department from tbl_department where id = '".$hasil_kategori_kuis['id_department']."'");
                $nama_department = "";
                if(mysqli_num_rows($query_nama_department) > 0){
                    $hasil_nama_department = mysqli_fetch_array($query_nama_department);
                    $nama_department = $hasil_nama_department['nama_department'];
                }
                ?>
                <tr>
                    <td><?php echo $no; ?></td>
                    <td><?php echo $nama_perusahaan; ?></td>
                    <td><?php echo $nama_department; ?></td>
                    <td><?php echo $hasil_kategori_kuis['kategori_kuis']; ?></td>
                    <td><a href="index.php<?php echo $base_url_action_edit; ?>">Edit</a> - <a href="index.php<?php echo $base_url_action_hapus; ?>">Hapus</a></td>
                </tr>
                <?php
                $no++;
            }
        } else {
            ?>
            <tr>
                <td colspan="5">Belum ada data Kategori Kuis.</td>
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