<?php 
$begin = new DateTime("2021-03-05");
$end = new DateTime(date("Y-m-d"));
?>
<div style="overflow-x: auto; overflow-y: hidden;">
<table class="table table-bordered" id="table_universitas" style="margin-bottom: 0px;">
    <thead>                  
        <tr>
            <th style="vertical-align: middle;">Tanggal</th>
            <th style="text-align: center; vertical-align: middle;">Akumulasi Hit KTP</th>
            <th style="text-align: center; vertical-align: middle;">Akumulasi Hit Ijazah</th>
            <th style="text-align: center; vertical-align: middle;">Akumulasi Semua</th>
        </tr>
    </thead>
    <tbody>
    <?php 
    
    $jumlah_akumulasi_ktp = 0;
    $jumlah_akumulasi_ijazah = 0;
    $jumlah_akumulasi_all = 0;
    for($i = $begin; $i <= $end; $i->modify('+1 day')){
        $query_jumlah_ktp = mysqli_query($connect, "select count(id_document) jumlah_hit_ktp from tbl_id_document_collection_log where tipe_document = 'KTP' and DATE_FORMAT(timestamp, '%Y-%m-%d') = '".$i->format("Y-m-d")."'");
        $hasil_jumlah_ktp = mysqli_fetch_array($query_jumlah_ktp);
        $query_jumlah_ijazah = mysqli_query($connect, "select count(id_document) jumlah_hit_ijazah from tbl_id_document_collection_log where tipe_document = 'IJAZAH' and DATE_FORMAT(timestamp, '%Y-%m-%d') = '".$i->format("Y-m-d")."'");
        $hasil_jumlah_ijazah = mysqli_fetch_array($query_jumlah_ijazah);
        $query_jumlah_all = mysqli_query($connect, "select count(id_document) jumlah_hit_all from tbl_id_document_collection_log where DATE_FORMAT(timestamp, '%Y-%m-%d') = '".$i->format("Y-m-d")."'");
        $hasil_jumlah_all = mysqli_fetch_array($query_jumlah_all);
        $jumlah_akumulasi_ktp = $jumlah_akumulasi_ktp + (int) $hasil_jumlah_ktp['jumlah_hit_ktp'];
        $jumlah_akumulasi_ijazah = $jumlah_akumulasi_ijazah + (int) $hasil_jumlah_ijazah['jumlah_hit_ijazah'];
        $jumlah_akumulasi_all = $jumlah_akumulasi_all + (int) $hasil_jumlah_all['jumlah_hit_all'];
        echo "<tr>\n";
        echo "<td>" . $i->format("Y-m-d") . "</td>\n";
        echo "<td style='text-align: right;'>".$jumlah_akumulasi_ktp."</td>\n";
        echo "<td style='text-align: right;'>".$jumlah_akumulasi_ijazah."</td>\n";
        echo "<td style='text-align: right;'>".$jumlah_akumulasi_all."</td>\n";
        echo "</tr>\n";
    }
    
    ?>
    </tbody>
</table>
</div>