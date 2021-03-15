<?php

$hasil_id = isset($_GET['id']) && $_GET['id'] != "" ? $_GET['id'] : "abcde";

define('MULTIPART_BOUNDARY', '--------------------------'.microtime(true));
$header = 
    "Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJjb21wYW55IjoiUGljYXNzbyIsImV4cCI6MTAwMDAwMDAwMDAsInV1aWQiOiJhYmY5MDRjMS0zZjVlLTRkZDEtOWMzOC1kNWY2YTY5NTgwN2YifQ.Egt_Go-SudEiI2LkRheBG0em_vZ3ooiyIKZoQiaraCOOFGZyXlWqjREFi4nRo9BFOI3n1icu0a6QaMpZSNKg-tBv3uPShmIQbyx2UQoqQKTR7d5IW3890YY64jiVswvVtJq4HPM_ObrnNkyM9nAXNjY11yXfjPhGGJ8tIFn_vyWlw-sfcn6lb6D3FvzbceM6SjlLX13N8oeOkorC24ve76KuZDeHB4swEKXZNQji4gxrO6NMiHMCwNtR1jn1vYSrUzjbvJGzyvVDrk0MO46ekbInq16WZljWcZW1nsy9GBAbG9-NF3qkxFAFylVjX2ipKOWoaFn7Wg8Z6G02p6B7IA\r\n" .
    "Content-Type: multipart/form-data; boundary=".MULTIPART_BOUNDARY;

$context_2 = stream_context_create(array(
    'http' => array(
        'method' => 'GET',
        'header' => $header
    )
));
$request_result = file_get_contents('http://dsc-ocr.udata.id/api/result/' . $hasil_id, false, $context_2);

$hasil = json_decode($request_result);
$hasil_ocr = json_decode($hasil->result);
if(is_object($hasil_ocr)){
    if(isset($hasil_ocr->{1})){
        $hasil_ocr = $hasil_ocr->{1};
    }
}


?>
<textarea class="form-control" style="height: 400px; resize: none;" readonly><?php echo str_replace('\n', "\n", $hasil_ocr); ?></textarea>