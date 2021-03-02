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
check_page("perusahaan");

$base_url_action_edit = "?page=perusahaan-add";
$base_url_action_hapus = "?page=perusahaan-hapus";

?>
<table class="table table-bordered">
    <thead>                  
        <tr>
            <th style="width: 10px">No</th>
            <th>Nama Perusahaan</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        
        $query_perusahaan = mysqli_query($connect, "select * from tbl_perusahaan");
        if(mysqli_num_rows($query_perusahaan) > 0){
            $no = 1;
            while($hasil_perusahaan = mysqli_fetch_array($query_perusahaan)){
                ?>
                <tr>
                    <td><?php echo $no; ?></td>
                    <td><?php echo $hasil_perusahaan['nama_perusahaan']; ?></td>
                    <td><a href="index.php<?php echo $base_url_action_edit; ?>&id=<?php echo $hasil_perusahaan['id']; ?>">Edit</a> - <a href="javascript: konfirmasi('index.php<?php echo $base_url_action_hapus; ?>&id=<?php echo $hasil_perusahaan['id']; ?>');">Hapus</a></td>
                </tr>
                <?php
                $no++;
            }
        } else {
            ?>
            <tr>
                <td colspan="3">Belum ada data Perusahaan.</td>
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