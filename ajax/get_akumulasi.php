<?php

include_once "../koneksi.php";

function rand_color() {
    return '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
}

$begin_awal = new DateTime("2021-03-05");
$end_awal = new DateTime(date('Y-m-d', strtotime('-11 days', strtotime(date("Y-m-d")))));

$begin = new DateTime(date('Y-m-d', strtotime('-10 days', strtotime(date("Y-m-d")))));
$end = new DateTime(date("Y-m-d"));

$jumlah_akumulasi_ktp = 0;
$jumlah_akumulasi_ijazah = 0;
$jumlah_akumulasi_all = 0;
$array_all = array();
$address = 0;
$array_color = array();

$array_ktp = array();
$array_ijazah = array();
$array_all_akumulasi = array();

$name_variable = array(
    'array_ktp',
    'array_ijazah',
    'array_all_akumulasi'
);

$name_judul = array(
    'Akumulasi KTP',
    'Akumulasi Ijazah',
    'Akumulasi Semua'
);

$nama_tabel = "tbl_id_document_collection_log_backup";

$categories = array();
for($i = $begin_awal; $i <= $end_awal; $i->modify('+1 day')){
    $query_jumlah_ktp = mysqli_query($connect, "select count(id_document) jumlah_hit_ktp from ".$nama_tabel." where tipe_document = 'KTP' and DATE_FORMAT(timestamp, '%Y-%m-%d') = '".$i->format("Y-m-d")."'");
    $hasil_jumlah_ktp = mysqli_fetch_array($query_jumlah_ktp);
    $query_jumlah_ijazah = mysqli_query($connect, "select count(id_document) jumlah_hit_ijazah from ".$nama_tabel." where tipe_document = 'IJAZAH' and DATE_FORMAT(timestamp, '%Y-%m-%d') = '".$i->format("Y-m-d")."'");
    $hasil_jumlah_ijazah = mysqli_fetch_array($query_jumlah_ijazah);
    $query_jumlah_all = mysqli_query($connect, "select count(id_document) jumlah_hit_all from ".$nama_tabel." where DATE_FORMAT(timestamp, '%Y-%m-%d') = '".$i->format("Y-m-d")."'");
    $hasil_jumlah_all = mysqli_fetch_array($query_jumlah_all);
    $jumlah_akumulasi_ktp = $jumlah_akumulasi_ktp + (int) $hasil_jumlah_ktp['jumlah_hit_ktp'];
    $jumlah_akumulasi_ijazah = $jumlah_akumulasi_ijazah + (int) $hasil_jumlah_ijazah['jumlah_hit_ijazah'];
    $jumlah_akumulasi_all = $jumlah_akumulasi_all + (int) $hasil_jumlah_all['jumlah_hit_all'];
}

for($i = $begin; $i <= $end; $i->modify('+1 day')){
    $query_jumlah_ktp = mysqli_query($connect, "select count(id_document) jumlah_hit_ktp from ".$nama_tabel." where tipe_document = 'KTP' and DATE_FORMAT(timestamp, '%Y-%m-%d') = '".$i->format("Y-m-d")."'");
    $hasil_jumlah_ktp = mysqli_fetch_array($query_jumlah_ktp);
    $query_jumlah_ijazah = mysqli_query($connect, "select count(id_document) jumlah_hit_ijazah from ".$nama_tabel." where tipe_document = 'IJAZAH' and DATE_FORMAT(timestamp, '%Y-%m-%d') = '".$i->format("Y-m-d")."'");
    $hasil_jumlah_ijazah = mysqli_fetch_array($query_jumlah_ijazah);
    $query_jumlah_all = mysqli_query($connect, "select count(id_document) jumlah_hit_all from ".$nama_tabel." where DATE_FORMAT(timestamp, '%Y-%m-%d') = '".$i->format("Y-m-d")."'");
    $hasil_jumlah_all = mysqli_fetch_array($query_jumlah_all);
    $jumlah_akumulasi_ktp = $jumlah_akumulasi_ktp + (int) $hasil_jumlah_ktp['jumlah_hit_ktp'];
    $jumlah_akumulasi_ijazah = $jumlah_akumulasi_ijazah + (int) $hasil_jumlah_ijazah['jumlah_hit_ijazah'];
    $jumlah_akumulasi_all = $jumlah_akumulasi_all + (int) $hasil_jumlah_all['jumlah_hit_all'];
    $array_ktp[$address] = $jumlah_akumulasi_ktp;
    $array_ijazah[$address] = $jumlah_akumulasi_ijazah;
    $array_all_akumulasi[$address] = $jumlah_akumulasi_all;
    $categories[$address] = $i->format("Y-m-d");
    $address++;
}

for($i = 0; $i < 3; $i++){
    $array_color[$i] = rand_color();
    $array_all[$i] = array();
    $array_all[$i]['name'] = $name_judul[$i];
    $array_all[$i]['color'] = $array_color[$i];
    $array_all[$i]['data'] = ${$name_variable[$i]};
}

$array_all_ = array();
$array_all_[0] = $categories;
$array_all_[1] = $array_all;
echo json_encode($array_all_);