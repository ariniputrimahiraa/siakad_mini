<?php
require_once 'User.php';
require_once 'CetakLaporan.php';

class Mahasiswa extends User implements CetakLaporan {
    private $nim;
    private $nilai = [];

    public function __construct($nama, $nim) {
        parent::__construct($nama);
        $this->nim = $nim;
    }

    public function getRole() {
        return "mahasiswa";
    }

    public function getNim() {
        return $this->nim;
    }

    public function setNilai($nilaiArray) {
        $this->nilai = $nilaiArray;
    }

    public function getNilai() {
        return $this->nilai;
    }

    public function hitungIPK() {
        if (count($this->nilai) == 0) return 0;
        return array_sum($this->nilai) / count($this->nilai);
    }

    public function cetak() {
        return "KHS: " . $this->nama . 
               " | NIM: " . $this->nim . 
               " | IPK: " . number_format($this->hitungIPK(), 2);
    }
}