<?php

include_once "../koneksi.php";

$halaman = isset($_GET['halaman']) && $_GET['halaman'] != "" && is_numeric($_GET['halaman']) ? (int) $_GET['halaman'] : 1;
$batas_data = isset($_GET['batas_data']) && $_GET['batas_data'] != "" && is_numeric($_GET['batas_data']) ? (int) $_GET['batas_data'] : 10;
$search = isset($_GET['search']) && $_GET['search'] != "" ? urldecode($_GET['search']) : "";

$start = $halaman > 0 ? $batas_data * ($halaman - 1) : 0;

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
    ) a " . $search . " order by nama_file asc limit $start, $batas_data
");

$array_hasil = array();
if(mysqli_num_rows($query_file_excel) > 0){
    while($hasil_file_excel = mysqli_fetch_array($query_file_excel, MYSQLI_ASSOC)){
        $array_hasil[] = $hasil_file_excel;
    }
}
echo json_encode($array_hasil);