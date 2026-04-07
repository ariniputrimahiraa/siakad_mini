<?php
require_once "../../core/Mahasiswa.php";

// DATA MAHASISWA
$mahasiswa = [
    new Mahasiswa("Andi", "123"),
    new Mahasiswa("Budi", "456")
];

// DATA MATKUL
$matkul = [
    ["nama" => "Pemrograman", "sks" => 3],
    ["nama" => "Basis Data", "sks" => 2]
];

// DATA NILAI
$nilai = [
    ["mhs" => 0, "matkul" => 0, "nilai" => "A"],
    ["mhs" => 0, "matkul" => 1, "nilai" => "B"],
    ["mhs" => 1, "matkul" => 0, "nilai" => "C"]
];