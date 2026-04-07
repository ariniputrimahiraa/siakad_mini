<?php
require_once "core/InterfaceLaporan.php";

class KHS implements Laporan {

    private $mahasiswa;
    private $matkul;
    private $nilai;

    public function __construct($mahasiswa, $matkul, $nilai) {
        $this->mahasiswa = $mahasiswa;
        $this->matkul = $matkul;
        $this->nilai = $nilai;
    }

    private function konversi($huruf) {
        switch ($huruf) {
            case 'A': return 4;
            case 'B': return 3;
            case 'C': return 2;
            case 'D': return 1;
            default: return 0;
        }
    }

    public function cetak() {
        echo "<h2>Kartu Hasil Studi</h2>";

        foreach ($this->mahasiswa as $index => $mhs) {
            echo "<h3>" . $mhs->getNama() . " (" . $mhs->getNim() . ")</h3>";

            echo "<table border='1'>";
            echo "<tr><th>Matkul</th><th>SKS</th><th>Nilai</th></tr>";

            $total = 0;
            $total_sks = 0;

            foreach ($this->nilai as $n) {
                if ($n['mhs'] == $index) {
                    $mk = $this->matkul[$n['matkul']];

                    echo "<tr>";
                    echo "<td>{$mk['nama']}</td>";
                    echo "<td>{$mk['sks']}</td>";
                    echo "<td>{$n['nilai']}</td>";
                    echo "</tr>";

                    $bobot = $this->konversi($n['nilai']);
                    $total += $bobot * $mk['sks'];
                    $total_sks += $mk['sks'];
                }
            }

            $ipk = $total_sks ? round($total / $total_sks, 2) : 0;

            echo "</table>";
            echo "<b>IPK: $ipk</b><br><br>";
        }
    }
}