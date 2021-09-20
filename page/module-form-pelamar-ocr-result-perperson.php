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
check_page("form-pelamar-ocr-result-perperson");

$id_pelamar = isset($_GET['id_pelamar_active']) && $_GET['id_pelamar_active'] != "" && is_numeric($_GET['id_pelamar_active']) ? mysqli_real_escape_string($connect, $_GET['id_pelamar_active']) : ""; 

$nama_pelamar = "";
$query_nama_pelamar = mysqli_query($connect, "select nama_pelamar from tbl_pelamar_master where id = '".$id_pelamar."'");
if(mysqli_num_rows($query_nama_pelamar) > 0){
    $hasil_nama = mysqli_fetch_array($query_nama_pelamar);
    $nama_pelamar = $hasil_nama['nama_pelamar'];
}

$query_hasil_ocr_db = mysqli_query($connect, "
    select
        id_position,
        bidang_pekerjaan,

        -- KTP
        file_ktp,
        nik,
        nama_pelamar,
        tempat_lahir,
        tanggal_lahir,
        jenis_kelamin,

        ktp_confidence_nik,
        ktp_confidence_nama,
        ktp_confidence_tempat_lahir,
        ktp_confidence_tanggal_lahir,
        ktp_confidence_jenis_kelamin,

        ktp_result_nik,
        ktp_result_nama,
        ktp_result_tempat_lahir,
        ktp_result_tanggal_lahir,
        ktp_result_jenis_kelamin,
        
        match_nik,
        match_nama,
        match_tanggal_lahir,
        match_tempat_lahir,
        match_jenis_kelamin,

        -- IJAZAH DAN TRANSKRIP S1
        file_ijazah,
        file_ijazah_sertifikat,
        universitas,
        jurusan,
        ipk,

        -- TRANSKRIP S1 OCR
        ijazah_confidence_nama,
        ijazah_confidence_universitas,
        ijazah_confidence_jurusan,
        ijazah_confidence_ipk,

        ijazah_result_nama,
        ijazah_result_universitas,
        ijazah_result_jurusan,
        ijazah_result_ipk,
        
        match_nama_ijazah,
        match_universitas,
        match_jurusan,
        match_ipk,

        -- IJAZAH S1 OCR
        ijazah_sertifikat_confidence_nama,
        ijazah_sertifikat_confidence_universitas,
        ijazah_sertifikat_confidence_jurusan,

        ijazah_sertifikat_result_nama,
        ijazah_sertifikat_result_universitas,
        ijazah_sertifikat_result_jurusan,
        
        match_nama_ijazah_sertifikat,
        match_universitas_sertifikat,
        match_jurusan_sertifikat,

        -- IJAZAH DAN TRANSKRIP S2
        file_ijazah_s2,
        file_ijazah_sertifikat_s2,
        universitas_s2,
        jurusan_s2,
        ipk_s2,

        -- TRANSKRIP S2 OCR
        ijazah_s2_confidence_nama,
        ijazah_s2_confidence_universitas,
        ijazah_s2_confidence_jurusan,
        ijazah_s2_confidence_ipk,

        ijazah_s2_result_nama,
        ijazah_s2_result_universitas,
        ijazah_s2_result_jurusan,
        ijazah_s2_result_ipk,
        
        match_nama_ijazah_s2,
        match_universitas_s2,
        match_jurusan_s2,
        match_ipk_s2,

        -- IJAZAH S2 OCR
        ijazah_s2_sertifikat_confidence_nama,
        ijazah_s2_sertifikat_confidence_universitas,
        ijazah_s2_sertifikat_confidence_jurusan,

        ijazah_s2_sertifikat_result_nama,
        ijazah_s2_sertifikat_result_universitas,
        ijazah_s2_sertifikat_result_jurusan,
        
        match_nama_ijazah_sertifikat_s2,
        match_universitas_sertifikat_s2,
        match_jurusan_sertifikat_s2
        
    from tbl_pelamar where id = '".$id_pelamar."'

");

if(mysqli_num_rows($query_hasil_ocr_db) > 0){
$hasil_ocr_db = mysqli_fetch_array($query_hasil_ocr_db);

$nama_open_position = "(UNDEFINED)";
$query_open_position = mysqli_query($connect, "select open_position from tbl_event where id = '".$hasil_ocr_db['id_position']."'");
if(mysqli_num_rows($query_open_position) > 0){
    $hasil_open_position = mysqli_fetch_array($query_open_position);
    $nama_open_position = $hasil_open_position['open_position'];
}

$nama_universitas_s1 = "(UNDEFINED)";
$query_universitas_s1 = mysqli_query($connect, "select universitas from tbl_universitas where id = '".$hasil_ocr_db['universitas']."'");
if(mysqli_num_rows($query_universitas_s1) > 0){
    $hasil_universitas_s1 = mysqli_fetch_array($query_universitas_s1);
    $nama_universitas_s1 = $hasil_universitas_s1['universitas'];
}

$nama_jurusan_s1 = "(UNDEFINED)";
$query_jurusan_s1 = mysqli_query($connect, "select jurusan from tbl_jurusan where id = '".$hasil_ocr_db['jurusan']."'");
if(mysqli_num_rows($query_jurusan_s1) > 0){
    $hasil_jurusan_s1 = mysqli_fetch_array($query_jurusan_s1);
    $nama_jurusan_s1 = $hasil_jurusan_s1['jurusan'];
}

$nama_universitas_s2 = "(UNDEFINED)";
$query_universitas_s2 = mysqli_query($connect, "select universitas from tbl_universitas where id = '".$hasil_ocr_db['universitas_s2']."'");
if(mysqli_num_rows($query_universitas_s2) > 0){
    $hasil_universitas_s2 = mysqli_fetch_array($query_universitas_s2);
    $nama_universitas_s2 = $hasil_universitas_s2['universitas'];
}

$nama_jurusan_s2 = "(UNDEFINED)";
$query_jurusan_s2 = mysqli_query($connect, "select jurusan from tbl_jurusan where id = '".$hasil_ocr_db['jurusan_s2']."'");
if(mysqli_num_rows($query_jurusan_s2) > 0){
    $hasil_jurusan_s2 = mysqli_fetch_array($query_jurusan_s2);
    $nama_jurusan_s2 = $hasil_jurusan_s2['jurusan'];
}

?>

<div style="overflow-x: auto; overflow-y: hidden;">
    <table class="table table-bordered" id="table_ketrampilan" style="margin-bottom: 0px;">
        <tr>
            <td style="text-align: center; white-space: nowrap;" colspan="4">
                <h4>Hasil OCR KTP (<?php echo $nama_open_position; ?>)</h4>
                Bidang (<?php echo $hasil_ocr_db['bidang_pekerjaan']; ?>)
            </td>
        </tr>
        <tr>
            <td style="text-align: center; white-space: nowrap;" colspan="4">
                <?php if($hasil_ocr_db['file_ktp'] != "" && file_exists("../ocrapi/upload/ktp/" . $hasil_ocr_db['file_ktp'])){ ?>
                <img src='../ocrapi/<?php echo $folder; ?>/TOKENACCESS--<?php echo $GLOBALS['token']; ?>--ktp--<?php echo $hasil_ocr_db['file_ktp']; ?>' style='width: 450px;' />
                <?php } else { ?>
                <img src='images/NOTFOUND.png' style='width: 450px;' />
                <?php } ?>
            </td>
        </tr>
        <tr>
            <td style="width: 25%; white-space: nowrap; text-align: center;">Target</td>
            <td style="width: 25%; white-space: nowrap; text-align: center;">Confidence</td>
            <td style="width: 25%; white-space: nowrap; text-align: center;">Result</td>
            <td style="width: 25%; white-space: nowrap; text-align: center;">Match</td>
        </tr>
        <tr>
            <td style="width: 25%; white-space: nowrap;"><?php echo $hasil_ocr_db['nik']; ?></td>
            <td style="width: 25%; white-space: nowrap; text-align: right;"><?php echo $hasil_ocr_db['ktp_confidence_nik']; ?></td>
            <td style="width: 25%; white-space: nowrap;"><?php echo $hasil_ocr_db['ktp_result_nik'] == "" ? "(UNDEFINED)" : $hasil_ocr_db['ktp_result_nik']; ?></td>
            <td style="width: 25%; white-space: nowrap;"><?php echo $hasil_ocr_db['match_nik']; ?></td>
        </tr>
        <tr>
            <td style="width: 25%; white-space: nowrap;"><?php echo $hasil_ocr_db['nama_pelamar']; ?></td>
            <td style="width: 25%; white-space: nowrap; text-align: right;"><?php echo $hasil_ocr_db['ktp_confidence_nama']; ?></td>
            <td style="width: 25%; white-space: nowrap;"><?php echo $hasil_ocr_db['ktp_result_nama'] == "" ? "(UNDEFINED)" : $hasil_ocr_db['ktp_result_nama']; ?></td>
            <td style="width: 25%; white-space: nowrap;"><?php echo $hasil_ocr_db['match_nama']; ?></td>
        </tr>
        <tr>
            <td style="width: 25%; white-space: nowrap;"><?php echo $hasil_ocr_db['tempat_lahir']; ?></td>
            <td style="width: 25%; white-space: nowrap; text-align: right;"><?php echo $hasil_ocr_db['ktp_confidence_tempat_lahir']; ?></td>
            <td style="width: 25%; white-space: nowrap;"><?php echo $hasil_ocr_db['ktp_result_tempat_lahir'] == "" ? "(UNDEFINED)" : $hasil_ocr_db['ktp_result_tempat_lahir']; ?></td>
            <td style="width: 25%; white-space: nowrap;"><?php echo $hasil_ocr_db['match_tempat_lahir']; ?></td>
        </tr>
        <tr>
            <td style="width: 25%; white-space: nowrap;"><?php echo $hasil_ocr_db['tanggal_lahir']; ?></td>
            <td style="width: 25%; white-space: nowrap; text-align: right;"><?php echo $hasil_ocr_db['ktp_confidence_tanggal_lahir']; ?></td>
            <td style="width: 25%; white-space: nowrap;"><?php echo $hasil_ocr_db['ktp_result_tanggal_lahir'] == "" ? "(UNDEFINED)" : $hasil_ocr_db['ktp_result_tanggal_lahir']; ?></td>
            <td style="width: 25%; white-space: nowrap;"><?php echo $hasil_ocr_db['match_tanggal_lahir']; ?></td>
        </tr>
        <tr>
            <td style="width: 25%; white-space: nowrap;"><?php echo $hasil_ocr_db['jenis_kelamin']; ?></td>
            <td style="width: 25%; white-space: nowrap; text-align: right;"><?php echo $hasil_ocr_db['ktp_confidence_jenis_kelamin']; ?></td>
            <td style="width: 25%; white-space: nowrap;"><?php echo $hasil_ocr_db['ktp_result_jenis_kelamin'] == "" ? "(UNDEFINED)" : $hasil_ocr_db['ktp_result_jenis_kelamin']; ?></td>
            <td style="width: 25%; white-space: nowrap;"><?php echo $hasil_ocr_db['match_jenis_kelamin']; ?></td>
        </tr>
        <tr>
            <td style="text-align: center; white-space: nowrap;" colspan="4">
                <h4>Hasil OCR Transkrip S1 (<?php echo $nama_open_position; ?>)</h4>
                Bidang (<?php echo $hasil_ocr_db['bidang_pekerjaan']; ?>)
            </td>
        </tr>
        <tr>
            <td style="text-align: center; white-space: nowrap;" colspan="4">
                <?php if($hasil_ocr_db['file_ijazah'] != "" && file_exists("../ocrapi/upload/izajah/" . $hasil_ocr_db['file_ijazah'])){ ?>
                <iframe src='../ocrapi/<?php echo $folder; ?>/TOKENACCESS--<?php echo $GLOBALS['token']; ?>--ijazah--<?php echo $hasil_ocr_db['file_ijazah']; ?>' style='width: 450px; height: 550px' frameborder="0" framespaceing="0"></iframe>
                <?php } else { ?>
                <iframe src='images/NOTFOUND.pdf' style='width: 450px; height: 245px' frameborder="0" framespaceing="0"></iframe>
                <?php } ?>
            </td>
        </tr>
        <tr>
            <td style="width: 25%; white-space: nowrap; text-align: center;">Target</td>
            <td style="width: 25%; white-space: nowrap; text-align: center;">Confidence</td>
            <td style="width: 25%; white-space: nowrap; text-align: center;">Result</td>
            <td style="width: 25%; white-space: nowrap; text-align: center;">Match</td>
        </tr>
        <tr>
            <td style="width: 25%; white-space: nowrap;"><?php echo $hasil_ocr_db['nama_pelamar']; ?></td>
            <td style="width: 25%; white-space: nowrap; text-align: right;"><?php echo $hasil_ocr_db['ijazah_confidence_nama']; ?></td>
            <td style="width: 25%; white-space: nowrap;"><?php echo $hasil_ocr_db['ijazah_result_nama'] == "" ? "(UNDEFINED)" : $hasil_ocr_db['ijazah_result_nama']; ?></td>
            <td style="width: 25%; white-space: nowrap;"><?php echo $hasil_ocr_db['match_nama_ijazah']; ?></td>
        </tr>
        <tr>
            <td style="width: 25%; white-space: nowrap;"><?php echo $nama_universitas_s1; ?></td>
            <td style="width: 25%; white-space: nowrap; text-align: right;"><?php echo $hasil_ocr_db['ijazah_confidence_universitas']; ?></td>
            <td style="width: 25%; white-space: nowrap;"><?php echo $hasil_ocr_db['ijazah_result_universitas'] == "" ? "(UNDEFINED)" : $hasil_ocr_db['ijazah_result_universitas']; ?></td>
            <td style="width: 25%; white-space: nowrap;"><?php echo $hasil_ocr_db['match_universitas']; ?></td>
        </tr>
        <tr>
            <td style="width: 25%; white-space: nowrap;"><?php echo $nama_jurusan_s1; ?></td>
            <td style="width: 25%; white-space: nowrap; text-align: right;"><?php echo $hasil_ocr_db['ijazah_confidence_jurusan']; ?></td>
            <td style="width: 25%; white-space: nowrap;"><?php echo $hasil_ocr_db['ijazah_result_jurusan'] == "" ? "(UNDEFINED)" : $hasil_ocr_db['ijazah_result_jurusan']; ?></td>
            <td style="width: 25%; white-space: nowrap;"><?php echo $hasil_ocr_db['match_jurusan']; ?></td>
        </tr>
        <tr>
            <td style="width: 25%; white-space: nowrap;"><?php echo $hasil_ocr_db['ipk']; ?></td>
            <td style="width: 25%; white-space: nowrap; text-align: right;"><?php echo $hasil_ocr_db['ijazah_confidence_ipk']; ?></td>
            <td style="width: 25%; white-space: nowrap;"><?php echo $hasil_ocr_db['ijazah_result_ipk'] == "" ? "(UNDEFINED)" : $hasil_ocr_db['ijazah_result_ipk']; ?></td>
            <td style="width: 25%; white-space: nowrap;"><?php echo $hasil_ocr_db['match_ipk']; ?></td>
        </tr>
        <tr>
            <td style="text-align: center; white-space: nowrap;" colspan="4">
                <h4>Hasil OCR Ijazah S1 (<?php echo $nama_open_position; ?>)</h4>
                Bidang (<?php echo $hasil_ocr_db['bidang_pekerjaan']; ?>)
            </td>
        </tr>
        <tr>
            <td style="text-align: center; white-space: nowrap;" colspan="4">
                <?php if($hasil_ocr_db['file_ijazah_sertifikat'] != "" && file_exists("../ocrapi/upload/ijazah_sertifikat/" . $hasil_ocr_db['file_ijazah_sertifikat'])){ ?>
                <iframe src='../ocrapi/<?php echo $folder; ?>/TOKENACCESS--<?php echo $GLOBALS['token']; ?>--ijazah_sertifikat--<?php echo $hasil_ocr_db['file_ijazah_sertifikat']; ?>' style='width: 450px; height: 550px' frameborder="0" framespaceing="0"></iframe>
                <?php } else { ?>
                <iframe src='images/NOTFOUND.pdf' style='width: 450px; height: 245px' frameborder="0" framespaceing="0"></iframe>
                <?php } ?>
            </td>
        </tr>
        <tr>
            <td style="width: 25%; white-space: nowrap; text-align: center;">Target</td>
            <td style="width: 25%; white-space: nowrap; text-align: center;">Confidence</td>
            <td style="width: 25%; white-space: nowrap; text-align: center;">Result</td>
            <td style="width: 25%; white-space: nowrap; text-align: center;">Match</td>
        </tr>
        <tr>
            <td style="width: 25%; white-space: nowrap;"><?php echo $hasil_ocr_db['nama_pelamar']; ?></td>
            <td style="width: 25%; white-space: nowrap; text-align: right;"><?php echo $hasil_ocr_db['ijazah_sertifikat_confidence_nama']; ?></td>
            <td style="width: 25%; white-space: nowrap;"><?php echo $hasil_ocr_db['ijazah_sertifikat_result_nama'] == "" ? "(UNDEFINED)" : $hasil_ocr_db['ijazah_sertifikat_result_nama']; ?></td>
            <td style="width: 25%; white-space: nowrap;"><?php echo $hasil_ocr_db['match_nama_ijazah_sertifikat']; ?></td>
        </tr>
        <tr>
            <td style="width: 25%; white-space: nowrap;"><?php echo $nama_universitas_s1; ?></td>
            <td style="width: 25%; white-space: nowrap; text-align: right;"><?php echo $hasil_ocr_db['ijazah_sertifikat_confidence_universitas']; ?></td>
            <td style="width: 25%; white-space: nowrap;"><?php echo $hasil_ocr_db['ijazah_sertifikat_result_universitas'] == "" ? "(UNDEFINED)" : $hasil_ocr_db['ijazah_sertifikat_result_universitas']; ?></td>
            <td style="width: 25%; white-space: nowrap;"><?php echo $hasil_ocr_db['match_universitas_sertifikat']; ?></td>
        </tr>
        <tr>
            <td style="width: 25%; white-space: nowrap;"><?php echo $nama_jurusan_s1; ?></td>
            <td style="width: 25%; white-space: nowrap; text-align: right;"><?php echo $hasil_ocr_db['ijazah_sertifikat_confidence_jurusan']; ?></td>
            <td style="width: 25%; white-space: nowrap;"><?php echo $hasil_ocr_db['ijazah_sertifikat_result_jurusan'] == "" ? "(UNDEFINED)" : $hasil_ocr_db['ijazah_sertifikat_result_jurusan']; ?></td>
            <td style="width: 25%; white-space: nowrap;"><?php echo $hasil_ocr_db['match_jurusan_sertifikat']; ?></td>
        </tr>
        <tr>
            <td style="text-align: center; white-space: nowrap;" colspan="4">
                <h4>Hasil OCR Transkrip S2 (<?php echo $nama_open_position; ?>)</h4>
                Bidang (<?php echo $hasil_ocr_db['bidang_pekerjaan']; ?>)
            </td>
        </tr>
        <tr>
            <td style="text-align: center; white-space: nowrap;" colspan="4">
                <?php if($hasil_ocr_db['file_ijazah_s2'] != "" && file_exists("../ocrapi/upload/ijazah_s2/" . $hasil_ocr_db['file_ijazah_s2'])){ ?>
                <iframe src='../ocrapi/<?php echo $folder; ?>/TOKENACCESS--<?php echo $GLOBALS['token']; ?>--ijazah_s2--<?php echo $hasil_ocr_db['file_ijazah_s2']; ?>' style='width: 450px; height: 550px' frameborder="0" framespaceing="0"></iframe>
                <?php } else { ?>
                <iframe src='images/NOTFOUND.pdf' style='width: 450px; height: 245px' frameborder="0" framespaceing="0"></iframe>
                <?php } ?>
            </td>
        </tr>
        <tr>
            <td style="width: 25%; white-space: nowrap; text-align: center;">Target</td>
            <td style="width: 25%; white-space: nowrap; text-align: center;">Confidence</td>
            <td style="width: 25%; white-space: nowrap; text-align: center;">Result</td>
            <td style="width: 25%; white-space: nowrap; text-align: center;">Match</td>
        </tr>
        <tr>
            <td style="width: 25%; white-space: nowrap;"><?php echo $hasil_ocr_db['nama_pelamar']; ?></td>
            <td style="width: 25%; white-space: nowrap; text-align: right;"><?php echo $hasil_ocr_db['ijazah_s2_confidence_nama']; ?></td>
            <td style="width: 25%; white-space: nowrap;"><?php echo $hasil_ocr_db['ijazah_s2_result_nama'] == "" ? "(UNDEFINED)" : $hasil_ocr_db['ijazah_s2_result_nama']; ?></td>
            <td style="width: 25%; white-space: nowrap;"><?php echo $hasil_ocr_db['match_nama_ijazah_s2']; ?></td>
        </tr>
        <tr>
            <td style="width: 25%; white-space: nowrap;"><?php echo $nama_universitas_s2; ?></td>
            <td style="width: 25%; white-space: nowrap; text-align: right;"><?php echo $hasil_ocr_db['ijazah_s2_confidence_universitas']; ?></td>
            <td style="width: 25%; white-space: nowrap;"><?php echo $hasil_ocr_db['ijazah_s2_result_universitas'] == "" ? "(UNDEFINED)" : $hasil_ocr_db['ijazah_s2_result_universitas']; ?></td>
            <td style="width: 25%; white-space: nowrap;"><?php echo $hasil_ocr_db['match_universitas_s2']; ?></td>
        </tr>
        <tr>
            <td style="width: 25%; white-space: nowrap;"><?php echo $nama_jurusan_s2; ?></td>
            <td style="width: 25%; white-space: nowrap; text-align: right;"><?php echo $hasil_ocr_db['ijazah_s2_confidence_jurusan']; ?></td>
            <td style="width: 25%; white-space: nowrap;"><?php echo $hasil_ocr_db['ijazah_s2_result_jurusan'] == "" ? "(UNDEFINED)" : $hasil_ocr_db['ijazah_s2_result_jurusan']; ?></td>
            <td style="width: 25%; white-space: nowrap;"><?php echo $hasil_ocr_db['match_jurusan_s2']; ?></td>
        </tr>
        <tr>
            <td style="width: 25%; white-space: nowrap;"><?php echo $hasil_ocr_db['ipk_s2']; ?></td>
            <td style="width: 25%; white-space: nowrap; text-align: right;"><?php echo $hasil_ocr_db['ijazah_s2_confidence_ipk']; ?></td>
            <td style="width: 25%; white-space: nowrap;"><?php echo $hasil_ocr_db['ijazah_s2_result_ipk'] == "" ? "(UNDEFINED)" : $hasil_ocr_db['ijazah_s2_result_ipk']; ?></td>
            <td style="width: 25%; white-space: nowrap;"><?php echo $hasil_ocr_db['match_ipk_s2']; ?></td>
        </tr>
        <tr>
            <td style="text-align: center; white-space: nowrap;" colspan="4">
                <h4>Hasil OCR Ijazah S2 (<?php echo $nama_open_position; ?>)</h4>
                Bidang (<?php echo $hasil_ocr_db['bidang_pekerjaan']; ?>)
            </td>
        </tr>
        <tr>
            <td style="text-align: center; white-space: nowrap;" colspan="4">
                <?php if($hasil_ocr_db['file_ijazah_sertifikat_s2'] != "" && file_exists("../ocrapi/upload/ijazah_s2_sertifikat/" . $hasil_ocr_db['file_ijazah_sertifikat_s2'])){ ?>
                <iframe src='../ocrapi/<?php echo $folder; ?>/TOKENACCESS--<?php echo $GLOBALS['token']; ?>--ijazah_s2_sertifikat--<?php echo $hasil_ocr_db['file_ijazah_sertifikat_s2']; ?>' style='width: 450px; height: 550px' frameborder="0" framespaceing="0"></iframe>
                <?php } else { ?>
                <iframe src='images/NOTFOUND.pdf' style='width: 450px; height: 245px' frameborder="0" framespaceing="0"></iframe>
                <?php } ?>
            </td>
        </tr>
        <tr>
            <td style="width: 25%; white-space: nowrap; text-align: center;">Target</td>
            <td style="width: 25%; white-space: nowrap; text-align: center;">Confidence</td>
            <td style="width: 25%; white-space: nowrap; text-align: center;">Result</td>
            <td style="width: 25%; white-space: nowrap; text-align: center;">Match</td>
        </tr>
        <tr>
            <td style="width: 25%; white-space: nowrap;"><?php echo $hasil_ocr_db['nama_pelamar']; ?></td>
            <td style="width: 25%; white-space: nowrap; text-align: right;"><?php echo $hasil_ocr_db['ijazah_s2_sertifikat_confidence_nama']; ?></td>
            <td style="width: 25%; white-space: nowrap;"><?php echo $hasil_ocr_db['ijazah_s2_sertifikat_result_nama'] == "" ? "(UNDEFINED)" : $hasil_ocr_db['ijazah_s2_sertifikat_result_nama']; ?></td>
            <td style="width: 25%; white-space: nowrap;"><?php echo $hasil_ocr_db['match_nama_ijazah_sertifikat_s2']; ?></td>
        </tr>
        <tr>
            <td style="width: 25%; white-space: nowrap;"><?php echo $nama_universitas_s2; ?></td>
            <td style="width: 25%; white-space: nowrap; text-align: right;"><?php echo $hasil_ocr_db['ijazah_s2_sertifikat_confidence_universitas']; ?></td>
            <td style="width: 25%; white-space: nowrap;"><?php echo $hasil_ocr_db['ijazah_s2_sertifikat_result_universitas'] == "" ? "(UNDEFINED)" : $hasil_ocr_db['ijazah_s2_sertifikat_result_universitas']; ?></td>
            <td style="width: 25%; white-space: nowrap;"><?php echo $hasil_ocr_db['match_universitas_sertifikat_s2']; ?></td>
        </tr>
        <tr>
            <td style="width: 25%; white-space: nowrap;"><?php echo $nama_jurusan_s2; ?></td>
            <td style="width: 25%; white-space: nowrap; text-align: right;"><?php echo $hasil_ocr_db['ijazah_s2_sertifikat_confidence_jurusan']; ?></td>
            <td style="width: 25%; white-space: nowrap;"><?php echo $hasil_ocr_db['ijazah_s2_sertifikat_result_jurusan'] == "" ? "(UNDEFINED)" : $hasil_ocr_db['ijazah_s2_sertifikat_result_jurusan']; ?></td>
            <td style="width: 25%; white-space: nowrap;"><?php echo $hasil_ocr_db['match_jurusan_sertifikat_s2']; ?></td>
        </tr>
    </table>
</div>

<?php 

} else {
    echo "Data Pelamar Tidak Ditemukan.";
}