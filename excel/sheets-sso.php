<?php 

$time_ = time();
ob_start(); 

?>
<title>Sheets</title>
<style type="text/css">
    html, body {
        font-family: consolas, monospace;
    }
    pre {
        font-family: consolas, monospace;
    }
</style>
<?php 

function get_age($bithdayDate, $format = "YY-MM-DD"){
    if($format == "YY-MM-DD"){
        $explode_dash = explode("-", $bithdayDate);
        if(sizeof($explode_dash) == 3){
            $day = $explode_dash[2];
            $month = $explode_dash[1];
            $year = $explode_dash[0];
            $bithdayDate = $month . "/" . $day . "/" . $year;
        } else {
            return 0;
        }
    }
    $birthDate_ = $bithdayDate;
    $birthDate = explode("/", $birthDate_);
    $age = (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md")
    ? ((date("Y") - $birthDate[2]) - 1)
    : (date("Y") - $birthDate[2]));
    return $age;
}
// echo get_age("1998-04-20");
// exit();

function mime2ext($mime) {
    $mime_map = [
        'video/3gpp2'                                                               => '3g2',
        'video/3gp'                                                                 => '3gp',
        'video/3gpp'                                                                => '3gp',
        'application/x-compressed'                                                  => '7zip',
        'audio/x-acc'                                                               => 'aac',
        'audio/ac3'                                                                 => 'ac3',
        'application/postscript'                                                    => 'ai',
        'audio/x-aiff'                                                              => 'aif',
        'audio/aiff'                                                                => 'aif',
        'audio/x-au'                                                                => 'au',
        'video/x-msvideo'                                                           => 'avi',
        'video/msvideo'                                                             => 'avi',
        'video/avi'                                                                 => 'avi',
        'application/x-troff-msvideo'                                               => 'avi',
        'application/macbinary'                                                     => 'bin',
        'application/mac-binary'                                                    => 'bin',
        'application/x-binary'                                                      => 'bin',
        'application/x-macbinary'                                                   => 'bin',
        'image/bmp'                                                                 => 'bmp',
        'image/x-bmp'                                                               => 'bmp',
        'image/x-bitmap'                                                            => 'bmp',
        'image/x-xbitmap'                                                           => 'bmp',
        'image/x-win-bitmap'                                                        => 'bmp',
        'image/x-windows-bmp'                                                       => 'bmp',
        'image/ms-bmp'                                                              => 'bmp',
        'image/x-ms-bmp'                                                            => 'bmp',
        'application/bmp'                                                           => 'bmp',
        'application/x-bmp'                                                         => 'bmp',
        'application/x-win-bitmap'                                                  => 'bmp',
        'application/cdr'                                                           => 'cdr',
        'application/coreldraw'                                                     => 'cdr',
        'application/x-cdr'                                                         => 'cdr',
        'application/x-coreldraw'                                                   => 'cdr',
        'image/cdr'                                                                 => 'cdr',
        'image/x-cdr'                                                               => 'cdr',
        'zz-application/zz-winassoc-cdr'                                            => 'cdr',
        'application/mac-compactpro'                                                => 'cpt',
        'application/pkix-crl'                                                      => 'crl',
        'application/pkcs-crl'                                                      => 'crl',
        'application/x-x509-ca-cert'                                                => 'crt',
        'application/pkix-cert'                                                     => 'crt',
        'text/css'                                                                  => 'css',
        'text/x-comma-separated-values'                                             => 'csv',
        'text/comma-separated-values'                                               => 'csv',
        'application/vnd.msexcel'                                                   => 'csv',
        'application/x-director'                                                    => 'dcr',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document'   => 'docx',
        'application/x-dvi'                                                         => 'dvi',
        'message/rfc822'                                                            => 'eml',
        'application/x-msdownload'                                                  => 'exe',
        'video/x-f4v'                                                               => 'f4v',
        'audio/x-flac'                                                              => 'flac',
        'video/x-flv'                                                               => 'flv',
        'image/gif'                                                                 => 'gif',
        'application/gpg-keys'                                                      => 'gpg',
        'application/x-gtar'                                                        => 'gtar',
        'application/x-gzip'                                                        => 'gzip',
        'application/mac-binhex40'                                                  => 'hqx',
        'application/mac-binhex'                                                    => 'hqx',
        'application/x-binhex40'                                                    => 'hqx',
        'application/x-mac-binhex40'                                                => 'hqx',
        'text/html'                                                                 => 'html',
        'image/x-icon'                                                              => 'ico',
        'image/x-ico'                                                               => 'ico',
        'image/vnd.microsoft.icon'                                                  => 'ico',
        'text/calendar'                                                             => 'ics',
        'application/java-archive'                                                  => 'jar',
        'application/x-java-application'                                            => 'jar',
        'application/x-jar'                                                         => 'jar',
        'image/jp2'                                                                 => 'jp2',
        'video/mj2'                                                                 => 'jp2',
        'image/jpx'                                                                 => 'jp2',
        'image/jpm'                                                                 => 'jp2',
        'image/jpeg'                                                                => 'jpeg',
        'image/pjpeg'                                                               => 'jpeg',
        'application/x-javascript'                                                  => 'js',
        'application/json'                                                          => 'json',
        'text/json'                                                                 => 'json',
        'application/vnd.google-earth.kml+xml'                                      => 'kml',
        'application/vnd.google-earth.kmz'                                          => 'kmz',
        'text/x-log'                                                                => 'log',
        'audio/x-m4a'                                                               => 'm4a',
        'audio/mp4'                                                                 => 'm4a',
        'application/vnd.mpegurl'                                                   => 'm4u',
        'audio/midi'                                                                => 'mid',
        'application/vnd.mif'                                                       => 'mif',
        'video/quicktime'                                                           => 'mov',
        'video/x-sgi-movie'                                                         => 'movie',
        'audio/mpeg'                                                                => 'mp3',
        'audio/mpg'                                                                 => 'mp3',
        'audio/mpeg3'                                                               => 'mp3',
        'audio/mp3'                                                                 => 'mp3',
        'video/mp4'                                                                 => 'mp4',
        'video/mpeg'                                                                => 'mpeg',
        'application/oda'                                                           => 'oda',
        'audio/ogg'                                                                 => 'ogg',
        'video/ogg'                                                                 => 'ogg',
        'application/ogg'                                                           => 'ogg',
        'font/otf'                                                                  => 'otf',
        'application/x-pkcs10'                                                      => 'p10',
        'application/pkcs10'                                                        => 'p10',
        'application/x-pkcs12'                                                      => 'p12',
        'application/x-pkcs7-signature'                                             => 'p7a',
        'application/pkcs7-mime'                                                    => 'p7c',
        'application/x-pkcs7-mime'                                                  => 'p7c',
        'application/x-pkcs7-certreqresp'                                           => 'p7r',
        'application/pkcs7-signature'                                               => 'p7s',
        'application/pdf'                                                           => 'pdf',
        'application/octet-stream'                                                  => 'pdf',
        'application/x-x509-user-cert'                                              => 'pem',
        'application/x-pem-file'                                                    => 'pem',
        'application/pgp'                                                           => 'pgp',
        'application/x-httpd-php'                                                   => 'php',
        'application/php'                                                           => 'php',
        'application/x-php'                                                         => 'php',
        'text/php'                                                                  => 'php',
        'text/x-php'                                                                => 'php',
        'application/x-httpd-php-source'                                            => 'php',
        'image/png'                                                                 => 'png',
        'image/x-png'                                                               => 'png',
        'application/powerpoint'                                                    => 'ppt',
        'application/vnd.ms-powerpoint'                                             => 'ppt',
        'application/vnd.ms-office'                                                 => 'ppt',
        'application/msword'                                                        => 'doc',
        'application/vnd.openxmlformats-officedocument.presentationml.presentation' => 'pptx',
        'application/x-photoshop'                                                   => 'psd',
        'image/vnd.adobe.photoshop'                                                 => 'psd',
        'audio/x-realaudio'                                                         => 'ra',
        'audio/x-pn-realaudio'                                                      => 'ram',
        'application/x-rar'                                                         => 'rar',
        'application/rar'                                                           => 'rar',
        'application/x-rar-compressed'                                              => 'rar',
        'audio/x-pn-realaudio-plugin'                                               => 'rpm',
        'application/x-pkcs7'                                                       => 'rsa',
        'text/rtf'                                                                  => 'rtf',
        'text/richtext'                                                             => 'rtx',
        'video/vnd.rn-realvideo'                                                    => 'rv',
        'application/x-stuffit'                                                     => 'sit',
        'application/smil'                                                          => 'smil',
        'text/srt'                                                                  => 'srt',
        'image/svg+xml'                                                             => 'svg',
        'application/x-shockwave-flash'                                             => 'swf',
        'application/x-tar'                                                         => 'tar',
        'application/x-gzip-compressed'                                             => 'tgz',
        'image/tiff'                                                                => 'tiff',
        'font/ttf'                                                                  => 'ttf',
        'text/plain'                                                                => 'txt',
        'text/x-vcard'                                                              => 'vcf',
        'application/videolan'                                                      => 'vlc',
        'text/vtt'                                                                  => 'vtt',
        'audio/x-wav'                                                               => 'wav',
        'audio/wave'                                                                => 'wav',
        'audio/wav'                                                                 => 'wav',
        'application/wbxml'                                                         => 'wbxml',
        'video/webm'                                                                => 'webm',
        'image/webp'                                                                => 'webp',
        'audio/x-ms-wma'                                                            => 'wma',
        'application/wmlc'                                                          => 'wmlc',
        'video/x-ms-wmv'                                                            => 'wmv',
        'video/x-ms-asf'                                                            => 'wmv',
        'font/woff'                                                                 => 'woff',
        'font/woff2'                                                                => 'woff2',
        'application/xhtml+xml'                                                     => 'xhtml',
        'application/excel'                                                         => 'xl',
        'application/msexcel'                                                       => 'xls',
        'application/x-msexcel'                                                     => 'xls',
        'application/x-ms-excel'                                                    => 'xls',
        'application/x-excel'                                                       => 'xls',
        'application/x-dos_ms_excel'                                                => 'xls',
        'application/xls'                                                           => 'xls',
        'application/x-xls'                                                         => 'xls',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'         => 'xlsx',
        'application/vnd.ms-excel'                                                  => 'xlsx',
        'application/xml'                                                           => 'xml',
        'text/xml'                                                                  => 'xml',
        'text/xsl'                                                                  => 'xsl',
        'application/xspf+xml'                                                      => 'xspf',
        'application/x-compress'                                                    => 'z',
        'application/x-zip'                                                         => 'zip',
        'application/zip'                                                           => 'zip',
        'application/x-zip-compressed'                                              => 'zip',
        'application/s-compressed'                                                  => 'zip',
        'multipart/x-zip'                                                           => 'zip',
        'text/x-scriptzsh'                                                          => 'zsh',
    ];

    return isset($mime_map[$mime]) ? $mime_map[$mime] : false;
}

include_once "../koneksi.php";

ini_set('error_reporting', E_ALL);
ini_set('display_errors', true);
require_once __DIR__.'/XLSX.php';
if(isset($argv) && is_array($argv) && isset($argv[1])){
    $file_name_excel = $argv[1];
} else {
    $file_name_excel = "FORMAT-NEW.xlsx";
}
echo $file_name_excel . "<br />\n";
$query_check_file = mysqli_query($connect, "
    select nama_file from tbl_proses_excel_log 
    where nama_file = '".$file_name_excel."'
");
if(mysqli_num_rows($query_check_file) == 0){
    mysqli_query($connect, "
        insert into tbl_proses_excel_log 
        set nama_file = '".$file_name_excel."'
    ");
} else {
    mysqli_query($connect, "
        update tbl_proses_excel_log set
        insert_pelamar_master = '0',
        upadate_pelamar_master = '0',
        insert_lamaran = '0',
        update_lamaran = '0',
        insert_lamaran_bidang_baru = '0',
        total_detik = '0'
        where nama_file = '".$file_name_excel."'
    ");
}


$xlsx = SimpleXLSX::parse(__DIR__.'/file/' . $file_name_excel);
if ($xlsx) {
    $array_huruf = array(
        "A" =>  0,
        "B" =>  1,
        "C" =>  2,
        "D" =>  3,
        "E" =>  4,
        "F" =>  5,
        "G" =>  6,
        "H" =>  7,
        "I" =>  8,
        "J" =>  9,
        "K" => 10,
        "L" => 11,
        "M" => 12,
        "N" => 13,
        "O" => 14,
        "P" => 15,
        "Q" => 16,
        "R" => 17,
        "S" => 18,
        "T" => 19,
        "U" => 20,
        "V" => 21,
        "W" => 22,
        "X" => 23,
        "Y" => 24,
        "Z" => 25
    );

    // echo '<pre>'.print_r( $xlsx->sheetNames(), true).'</pre>';
    for($i = 0; $i < sizeof($xlsx->sheetNames()); $i++){
        $dim=$xlsx->dimension();
        $num_cols = $dim[0];
        $num_rows = $dim[1];
        $k = 0;
        
        $comma_ = "";
        $count_insert = 0;
        $count_update = 0;
        $count_insert_lamaran = 0;
        $count_update_lamaran = 0;
        $count_insert_lamaran_bidang_baru = 0;
        foreach($xlsx->rows($i) as $r) {
            if($k > 0){ 
                $tanggal_apply = $r[$array_huruf['D']];
                $explode_space = explode(" ", $tanggal_apply);
                $tanggal_maks = $explode_space[0];
                $tanggal_active = str_replace("-", "", $explode_space[0]);
                $nama_event = mysqli_real_escape_string($connect, "GPTP14/" . $tanggal_active);
                // Insert Event Per Tanggal
                $query_cek_event = mysqli_query($connect, "select id from tbl_event where open_position = '".$nama_event."'");
                if(mysqli_num_rows($query_cek_event) == 0){
                    
                    mysqli_query($connect, "
                        insert into tbl_event set
                        open_position = '".$nama_event."',
                        universitas = '99999',
                        jurusan = '99999',
                        ipk = '1.0',
                        ipk_2 = '4.0',
                        status_requirement = 'SET',
                        status_recruitment = 'SET',
                        umur = '24',
                        umur_s1_pengalaman = '27',
                        tanggal_maks = '".$tanggal_maks."',
                        umur_s2 = '27',
                        umur_s2_pengalaman = '30',
                        tanggal_maks_s2 = '".$tanggal_maks."',
                        jenis_kelamin = '',
                        threshold_ijazah = '50',
                        threshold_ktp = '50',
                        tempat_negara = 'Indonesia',
                        tempat_wilayah = 'DKI Jakarta'
                    ");
                    $last_id = mysqli_insert_id($connect);
                } else {
                    $hasil_cek_event = mysqli_fetch_array($query_cek_event);
                    $last_id = $hasil_cek_event['id'];
                }
                // echo '<pre>'.print_r( $r, true).'</pre>';
                // Insert Pelamar Master
                $query_cek_universitas = mysqli_query($connect, "
                    select id from tbl_universitas where
                    universitas = '".$r[$array_huruf['K']]."'
                ");
                if(mysqli_num_rows($query_cek_universitas) == 0){
                    mysqli_query($connect, "
                        insert into tbl_universitas set
                        universitas = '".$r[$array_huruf['K']]."',
                        negara_universitas = '88',
                        posisi = 'DALAM NEGRI'
                    ");
                    $last_id_universitas = mysqli_insert_id($connect);
                } else {
                    $hasil_cek_universitas = mysqli_fetch_array($query_cek_universitas);
                    $last_id_universitas = $hasil_cek_universitas['id'];
                }
                
                $kualifikasi_aktif = $r[$array_huruf['J']];
                if($kualifikasi_aktif == "D4"){
                    $kualifikasi_aktif = "S1";
                }
                $query_id_kualifikasi_tingkat = mysqli_query($connect, "
                    select id from `tbl_tingkat` where nama_tingkat = '".$kualifikasi_aktif."'
                ");
                $last_id_kualifikasi_tingkat = 0;
                if(mysqli_num_rows($query_id_kualifikasi_tingkat) > 0){
                    $hasil_id_kualifikasi_tingkat = mysqli_fetch_array($query_id_kualifikasi_tingkat);
                    $last_id_kualifikasi_tingkat = $hasil_id_kualifikasi_tingkat['id'];
                }
                
                $file_ktp = $r[$array_huruf['O']];
                $file_ijazah = $r[$array_huruf['P']];
                $file_ijazah_s2 = $r[$array_huruf['S']];
                $file_ijazah_sertifikat = $r[$array_huruf['Q']];
                $file_ijazah_sertifikat_s2 = $r[$array_huruf['T']];
                
                $nama_file_ktp = "";
                $nama_file_ijazah = "";
                $nama_file_ijazah_s2 = "";
                $nama_file_ijazah_sertifikat = "";
                $nama_file_ijazah_sertifikat_s2 = "";
                
                $exists_file_ktp = false;
                $exists_file_ijazah = false;
                $exists_file_ijazah_s2 = false;
                $exists_file_ijazah_sertifikat = false;
                $exists_file_ijazah_sertifikat_s2 = false;
                
                if($file_ktp != ""){
                    $response = file_get_contents($file_ktp);
                    $status_line = $http_response_header[0];
                    preg_match('{HTTP\/\S*\s(\d{3})}', $status_line, $match);
                    $status = $match[1];
                    if ($status == "200") {
                        $file_info = new finfo(FILEINFO_MIME_TYPE);
                        $mime_type = $file_info->buffer($response);
                        $file_ext = mime2ext($mime_type);
                        $nama_file_ktp = "KTP" . date("Ymd") . date("His") . "." . $file_ext;
                        file_put_contents("../../ocrapi/upload/ktp/".$nama_file_ktp, $response);
                        $exists_file_ktp = true;
                    }
                }
                
                if($file_ijazah != ""){
                    $response = file_get_contents($file_ijazah);
                    $status_line = $http_response_header[0];
                    preg_match('{HTTP\/\S*\s(\d{3})}', $status_line, $match);
                    $status = $match[1];
                    if ($status == "200") {
                        $file_info = new finfo(FILEINFO_MIME_TYPE);
                        $mime_type = $file_info->buffer($response);
                        $file_ext = mime2ext($mime_type);
                        $nama_file_ijazah = "IJAZAH" . date("Ymd") . date("His") . "." . $file_ext;
                        file_put_contents("../../ocrapi/upload/ijazah/".$nama_file_ijazah, $response);
                        shell_exec("php /var/www/html/ocrapi/SERVICECONVERTPERFILE.php " . $nama_file_ijazah);
                        $exists_file_ijazah = true;
                    }
                }
                
                if($file_ijazah_sertifikat != ""){
                    $response = file_get_contents($file_ijazah_sertifikat);
                    $status_line = $http_response_header[0];
                    preg_match('{HTTP\/\S*\s(\d{3})}', $status_line, $match);
                    $status = $match[1];
                    if ($status == "200") {
                        $file_info = new finfo(FILEINFO_MIME_TYPE);
                        $mime_type = $file_info->buffer($response);
                        $file_ext = mime2ext($mime_type);
                        $nama_file_ijazah_sertifikat = "IJAZAHSERTIFIKAT" . date("Ymd") . date("His") . "." . $file_ext;
                        file_put_contents("../../ocrapi/upload/ijazah_sertifikat/".$nama_file_ijazah_sertifikat, $response);
                        shell_exec("php /var/www/html/ocrapi/SERVICECONVERTPERFILENEW.php " . $nama_file_ijazah_sertifikat . " ijazah_sertifikat");
                        $exists_file_ijazah_sertifikat = true;
                    }
                }
                
                if($file_ijazah_s2 != ""){
                    $response = file_get_contents($file_ijazah_s2);
                    $status_line = $http_response_header[0];
                    preg_match('{HTTP\/\S*\s(\d{3})}', $status_line, $match);
                    $status = $match[1];
                    if ($status == "200") {
                        $file_info = new finfo(FILEINFO_MIME_TYPE);
                        $mime_type = $file_info->buffer($response);
                        $file_ext = mime2ext($mime_type);
                        $nama_file_ijazah_s2 = "IJAZAHS2" . date("Ymd") . date("His") . "." . $file_ext;
                        file_put_contents("../../ocrapi/upload/ijazah_s2/".$nama_file_ijazah_s2, $response);
                        shell_exec("php /var/www/html/ocrapi/SERVICECONVERTPERFILE.php " . $nama_file_ijazah_s2 . " ijazah_s2");
                        $exists_file_ijazah_s2 = true;
                    }
                }
                
                if($file_ijazah_sertifikat_s2 != ""){
                    $response = file_get_contents($file_ijazah_sertifikat_s2);
                    $status_line = $http_response_header[0];
                    preg_match('{HTTP\/\S*\s(\d{3})}', $status_line, $match);
                    $status = $match[1];
                    if ($status == "200") {
                        $file_info = new finfo(FILEINFO_MIME_TYPE);
                        $mime_type = $file_info->buffer($response);
                        $file_ext = mime2ext($mime_type);
                        $nama_file_ijazah_sertifikat_s2 = "IJAZAHSERTIFIKATS2" . date("Ymd") . date("His") . "." . $file_ext;
                        file_put_contents("../../ocrapi/upload/ijazah_s2_sertifikat/".$nama_file_ijazah_sertifikat_s2, $response);
                        shell_exec("php /var/www/html/ocrapi/SERVICECONVERTPERFILE.php " . $nama_file_ijazah_sertifikat_s2 . " ijazah_s2_sertifikat");
                        $exists_file_ijazah_sertifikat_s2 = true;
                    }
                }
                
                $query_cek_pelamar_master = mysqli_query($connect, "
                    select 
                        id, 
                        file_ktp, 
                        file_ijazah, 
                        file_ijazah_sertifikat,
                        file_ijazah_s2,
                        file_ijazah_sertifikat_s2
                    from 
                        tbl_pelamar_master where nik = '".$r[$array_huruf['E']]."'
                ");
                if(mysqli_num_rows($query_cek_pelamar_master) == 0){
                    
                    $explode_tanggal_lahir = explode(" ", $r[$array_huruf['F']]);
                    $tanggal_lahir_active = $explode_tanggal_lahir[0];
                    mysqli_query($connect, "
                        insert into tbl_pelamar_master set 
                        username = '". strtolower(str_replace(" ", "_", $r[$array_huruf['B']]))."-".$r[$array_huruf['E']]."',
                        password = '".md5('admin')."',
                        active_status = 'NOACTIVE',
                        jenis_kelamin = '".strtolower($r[$array_huruf['H']])."',
                        nama_pelamar = '".$r[$array_huruf['B']]."',
                        alamat_sesuai_ktp = '".$r[$array_huruf['M']]."',
                        nik = '".$r[$array_huruf['E']]."',
                        tanggal_lahir = '".$tanggal_lahir_active."',
                        tempat_lahir = '".$r[$array_huruf['G']]."',
                        universitas = '".$last_id_universitas."',
                        bulan_lulus = '',
                        file_ktp = '".$nama_file_ktp."',
                        file_ijazah = '".$nama_file_ijazah."',
                        file_ijazah_sertifikat = '".$nama_file_ijazah_sertifikat."',
                        file_ijazah_s2 = '".$nama_file_ijazah_s2."',
                        file_ijazah_sertifikat_s2 = '".$nama_file_ijazah_sertifikat_s2."',
                        kualifikasi_tingkat = '".$last_id_kualifikasi_tingkat."',
                        ipk = '".$r[$array_huruf['R']]."'
                    ");
                    if(mysqli_affected_rows($connect) > 0){
                        $count_insert = $count_insert + 1;
                        mysqli_query($connect, "
                            update tbl_proses_excel_log 
                            set insert_pelamar_master = '".$count_insert."'
                            where nama_file = '".$file_name_excel."'
                        ");
                    }
                    
                } else {
                    
                    $hasil_cek_pelamar_master = mysqli_fetch_array($query_cek_pelamar_master);
                    $file_ktp_db = $hasil_cek_pelamar_master['file_ktp'];
                    $file_ijazah_db = $hasil_cek_pelamar_master['file_ijazah'];
                    $file_ijazah_s2_db = $hasil_cek_pelamar_master['file_ijazah_s2'];
                    $file_ijazah_sertifikat_db = $hasil_cek_pelamar_master['file_ijazah_sertifikat'];
                    $file_ijazah_sertifikat_s2_db = $hasil_cek_pelamar_master['file_ijazah_sertifikat_s2'];
                    
                    if($file_ktp_db != "" && file_exists("../../ocrapi/upload/ktp/".$file_ktp_db)){
                        unlink("../../ocrapi/upload/ktp/".$file_ktp_db);
                    }
                    if($file_ijazah_db != "" && file_exists("../../ocrapi/upload/ijazah/".$file_ijazah_db)){
                        unlink("../../ocrapi/upload/ijazah/".$file_ijazah_db);
                    }
                    if($file_ijazah_s2_db != "" && file_exists("../../ocrapi/upload/ijazah_s2/".$file_ijazah_s2_db)){
                        unlink("../../ocrapi/upload/ijazah_s2/".$file_ijazah_s2_db);
                    }
                    if($file_ijazah_sertifikat_db != "" && file_exists("../../ocrapi/upload/ijazah_sertifikat/".$file_ijazah_sertifikat_db)){
                        unlink("../../ocrapi/upload/ijazah_sertifikat/".$file_ijazah_sertifikat_db);
                    }
                    if($file_ijazah_sertifikat_s2_db != "" && file_exists("../../ocrapi/upload/ijazah_s2_sertifikat/".$file_ijazah_sertifikat_s2_db)){
                        unlink("../../ocrapi/upload/ijazah_s2_sertifikat/".$file_ijazah_sertifikat_s2_db);
                    }
                    
                    
                    $explode_tanggal_lahir = explode(" ", $r[$array_huruf['F']]);
                    $tanggal_lahir_active = $explode_tanggal_lahir[0];
                    mysqli_query($connect, "
                        update tbl_pelamar_master set 
                        username = '". strtolower(str_replace(" ", "_", $r[$array_huruf['B']]))."-".$r[$array_huruf['E']]."',
                        password = '".md5('admin')."',
                        active_status = 'NOACTIVE',
                        jenis_kelamin = '".strtolower($r[$array_huruf['H']])."',
                        nama_pelamar = '".$r[$array_huruf['B']]."',
                        alamat_sesuai_ktp = '".$r[$array_huruf['M']]."',
                        nik = '".$r[$array_huruf['E']]."',
                        tanggal_lahir = '".$tanggal_lahir_active."',
                        tempat_lahir = '".$r[$array_huruf['G']]."',
                        universitas = '".$last_id_universitas."',
                        bulan_lulus = '',
                        file_ktp = '".$nama_file_ktp."',
                        file_ijazah = '".$nama_file_ijazah."',
                        file_ijazah_sertifikat = '".$nama_file_ijazah_sertifikat."',
                        file_ijazah_s2 = '".$nama_file_ijazah_s2."',
                        file_ijazah_sertifikat_s2 = '".$nama_file_ijazah_sertifikat_s2."',
                        kualifikasi_tingkat = '".$last_id_kualifikasi_tingkat."',
                        ipk = '".$r[$array_huruf['R']]."'
                        where nik = '".$r[$array_huruf['E']]."'
                    ");
                    if(mysqli_affected_rows($connect) > 0){
                        $count_update = $count_update + 1;
                        mysqli_query($connect, "
                            update tbl_proses_excel_log 
                            set upadate_pelamar_master = '".$count_update."'
                            where nama_file = '".$file_name_excel."'
                        ");
                    }
                }
                
                // insert lamaran
                if($exists_file_ktp && 
                  ($exists_file_ijazah && $exists_file_ijazah_sertifikat) || 
                  ($exists_file_ijazah_s2 && $exists_file_ijazah_sertifikat_s2)){
                    $query_cek_pelamar = mysqli_query($connect, "
                        select id from tbl_pelamar where nik = '".$r[$array_huruf['E']]."'
                    ");
                    if(mysqli_num_rows($query_cek_pelamar) == 0){
                        $explode_tanggal_lahir = explode(" ", $r[$array_huruf['F']]);
                        $tanggal_lahir_active = $explode_tanggal_lahir[0];
                        mysqli_query($connect, "
                            insert into tbl_pelamar set 
                            id_position = '".$last_id."',
                            jenis_kelamin = '".strtolower($r[$array_huruf['H']])."',
                            nama_pelamar = '".$r[$array_huruf['B']]."',
                            nik = '".$r[$array_huruf['E']]."',
                            umur = '". get_age($tanggal_lahir_active)."',
                            tempat_lahir = '".$r[$array_huruf['G']]."',
                            tanggal_lahir = '".$tanggal_lahir_active."',
                            bidang_pekerjaan = '".$r[$array_huruf['L']]."',
                            universitas = '".$last_id_universitas."',
                            file_ktp = '".$nama_file_ktp."',
                            file_ijazah = '".$nama_file_ijazah."',
                            file_ijazah_sertifikat = '".$nama_file_ijazah_sertifikat."',
                            file_ijazah_s2 = '".$nama_file_ijazah_s2."',
                            file_ijazah_sertifikat_s2 = '".$nama_file_ijazah_sertifikat_s2."',
                            ipk = '".$r[$array_huruf['R']]."'
                        ");
                        if(mysqli_affected_rows($connect) > 0){
                            $count_insert_lamaran = $count_insert_lamaran + 1;
                            mysqli_query($connect, "
                                update tbl_proses_excel_log 
                                set insert_lamaran = '".$count_insert_lamaran."'
                                where nama_file = '".$file_name_excel."'
                            ");
                        }
                    } else {
                        $query_cek_pelamar_bidang_pekerjaan = mysqli_query($connect, "
                            select id from tbl_pelamar where 
                            nik = '".$r[$array_huruf['E']]."' and
                            bidang_pekerjaan = '".$r[$array_huruf['L']]."'
                        ");
                        if(mysqli_num_rows($query_cek_pelamar_bidang_pekerjaan) == 0){
                            $explode_tanggal_lahir = explode(" ", $r[$array_huruf['F']]);
                            $tanggal_lahir_active = $explode_tanggal_lahir[0];
                            mysqli_query($connect, "
                                insert into tbl_pelamar set 
                                id_position = '".$last_id."',
                                jenis_kelamin = '".strtolower($r[$array_huruf['H']])."',
                                nama_pelamar = '".$r[$array_huruf['B']]."',
                                nik = '".$r[$array_huruf['E']]."',
                                umur = '". get_age($tanggal_lahir_active)."',
                                tempat_lahir = '".$r[$array_huruf['G']]."',
                                tanggal_lahir = '".$tanggal_lahir_active."',
                                bidang_pekerjaan = '".$r[$array_huruf['L']]."',
                                universitas = '".$last_id_universitas."',
                                file_ktp = '".$nama_file_ktp."',
                                file_ijazah = '".$nama_file_ijazah."',
                                file_ijazah_sertifikat = '".$nama_file_ijazah_sertifikat."',
                                file_ijazah_s2 = '".$nama_file_ijazah_s2."',
                                file_ijazah_sertifikat_s2 = '".$nama_file_ijazah_sertifikat_s2."',
                                ipk = '".$r[$array_huruf['R']]."'
                            ");
                            if(mysqli_affected_rows($connect) > 0){
                                $count_insert_lamaran_bidang_baru = $count_insert_lamaran_bidang_baru + 1;
                                mysqli_query($connect, "
                                    update tbl_proses_excel_log 
                                    set insert_lamaran_bidang_baru = '".$count_insert_lamaran_bidang_baru."'
                                    where nama_file = '".$file_name_excel."'
                                ");
                            }
                        } else {
                            $explode_tanggal_lahir = explode(" ", $r[$array_huruf['F']]);
                            $tanggal_lahir_active = $explode_tanggal_lahir[0];
                            mysqli_query($connect, "
                                update tbl_pelamar set 
                                id_position = '".$last_id."',
                                jenis_kelamin = '".strtolower($r[$array_huruf['H']])."',
                                nama_pelamar = '".$r[$array_huruf['B']]."',
                                nik = '".$r[$array_huruf['E']]."',
                                umur = '". get_age($tanggal_lahir_active)."',
                                tempat_lahir = '".$r[$array_huruf['G']]."',
                                tanggal_lahir = '".$tanggal_lahir_active."',
                                bidang_pekerjaan = '".$r[$array_huruf['L']]."',
                                universitas = '".$last_id_universitas."',
                                file_ktp = '".$nama_file_ktp."',
                                file_ijazah = '".$nama_file_ijazah."',
                                file_ijazah_sertifikat = '".$nama_file_ijazah_sertifikat."',
                                file_ijazah_s2 = '".$nama_file_ijazah_s2."',
                                file_ijazah_sertifikat_s2 = '".$nama_file_ijazah_sertifikat_s2."',
                                ipk = '".$r[$array_huruf['R']]."'
                                where nik = '".$r[$array_huruf['E']]."'
                            ");
                            if(mysqli_affected_rows($connect) > 0){
                                $count_update_lamaran = $count_update_lamaran + 1;
                                mysqli_query($connect, "
                                    update tbl_proses_excel_log 
                                    set update_lamaran = '".$count_update_lamaran."'
                                    where nama_file = '".$file_name_excel."'
                                ");
                            }
                        }
                    }
                }
            }
            $k++;
        }
        echo "<pre>\n";
        echo "Berhasil Insert Data Pelamar Master sebanyak " . $count_insert . "\n";
        echo "Berhasil Update Data Pelamar Master sebanyak " . $count_update. "\n";
        echo "Berhasil Insert Data Lamaran sebanyak " . $count_insert_lamaran . "\n";
        echo "Berhasil Update Data Lamaran sebanyak " . $count_update_lamaran. "\n";
        echo "Berhasil Insert Data Lamaran Bidang Baru sebanyak " . $count_insert_lamaran_bidang_baru . "\n";
        echo "</pre>\n";
    }
}

else {
    echo SimpleXLSX::parseError();
}

$total_detik = (time() - $time_);
echo "DETIK PROSES : <br />\n";
echo $total_detik . "<br />\n";
mysqli_query($connect, "
    update tbl_proses_excel_log 
    set total_detik = '".$total_detik."'
    where nama_file = '".$file_name_excel."'
");

ob_flush();