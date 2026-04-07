<?php
require_once "data/data.php";
require_once "laporan/KHS.php";

$khs = new KHS($mahasiswa, $matkul, $nilai);
$khs->cetak();