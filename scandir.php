<title>Scan Directory</title>
<style type="text/css">
    html, body {
        font-family: consolas, monospace;
    }
</style>
<?php
include_once "koneksi.php";
function is_contain($source_string, $find_string){
    $address = 0;
    while(isset($source_string{$address})){
        if(substr($source_string, $address, strlen($find_string)) == $find_string){
            return true;
        }
        $address++;
    }
    return false;
}

$dir = scandir("C:/Users/user/Downloads/Data 100/");

for($i = 2; $i < sizeof($dir); $i++){
    if(is_dir("C:/Users/user/Downloads/Data 100/" . $dir[$i] . "/")){
        // echo $dir[$i] . "<br />\n";
        $dir_dalam = scandir("C:/Users/user/Downloads/Data 100/" . $dir[$i] . "/");
        $dapat_dir = 0;
        for($j = 2; $j < sizeof($dir_dalam); $j++){
            if(!is_dir("C:/Users/user/Downloads/Data 100/" . $dir[$i] . "/" . $dir_dalam[$j] . "/")){
                
                if(is_contain(strtoupper($dir_dalam[$j]), "KTP")){
                    $nama_ktp = "KTP".$dir[$i]."-".date("YmdHis");
                    $explode_type = explode(".",$dir_dalam[$j]);
                    $results_type = $explode_type[sizeof($explode_type) - 1];
                    $ktp_full_name = $nama_ktp . "." . $results_type;
                    $contents_ktp = file_get_contents("C:/Users/user/Downloads/Data 100/" . $dir[$i] . "/" . $dir_dalam[$j]);
                    $select_file = mysqli_query($connect, "select nama_file_asli from tbl_document_filter where nama_file_asli = '".$dir_dalam[$j]."'");
                    if(mysqli_num_rows($select_file) == 0){
                        if(file_put_contents("C:/xampp/htdocs/ocrdashboard/file-filter/KTP/" . $ktp_full_name, $contents_ktp)){
                            mysqli_query($connect, "
                                insert into tbl_document_filter set
                                    nama_folder = '".$dir[$i]."',
                                    nama_file_asli = '".$dir_dalam[$j]."',
                                    nama_file = '".$ktp_full_name."',
                                    tipe_document = 'KTP'
                            ");
                        }
                    }
                    echo $dir[$i] . " : " . $dir_dalam[$j] . " : " . $ktp_full_name . "<br />\n";
                    $dapat_dir = 1;
                }
                if(is_contain(strtoupper($dir_dalam[$j]), "TRANSKRIP")){
                    $nama_ijazah = "IJAZAH".$dir[$i]."-".date("YmdHis");
                    $explode_type = explode(".",$dir_dalam[$j]);
                    $results_type = $explode_type[sizeof($explode_type) - 1];
                    $ijazah_full_name = $nama_ijazah . "." . $results_type;
                    $contents_ijazah = file_get_contents("C:/Users/user/Downloads/Data 100/" . $dir[$i] . "/" . $dir_dalam[$j]);
                    $select_file = mysqli_query($connect, "select nama_file_asli from tbl_document_filter where nama_file_asli = '".$dir_dalam[$j]."'");
                    if(mysqli_num_rows($select_file) == 0){
                        if(file_put_contents("C:/xampp/htdocs/ocrdashboard/file-filter/IJAZAH/" . $ijazah_full_name, $contents_ijazah)){
                            mysqli_query($connect, "
                                insert into tbl_document_filter set
                                    nama_folder = '".$dir[$i]."',
                                    nama_file_asli = '".$dir_dalam[$j]."',
                                    nama_file = '".$ijazah_full_name."',
                                    tipe_document = 'IJAZAH'
                            ");
                        }
                    }
                    echo $dir[$i] . " : " . $dir_dalam[$j] . " : " . $ijazah_full_name . "<br />\n";
                    $dapat_dir = 1;
                }
                
            }
        }
        if($dapat_dir){
            echo "<br />\n";
        }
    }
}
