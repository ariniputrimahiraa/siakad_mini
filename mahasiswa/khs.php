<?php
session_start();
if ($_SESSION['role'] != 'mahasiswa') exit('Akses ditolak');

require_once '../core/Mahasiswa.php';

// ambil data
$nilaiData = json_decode(file_get_contents("../data/nilai.json"), true);
$matkul = json_decode(file_get_contents("../data/matkul.json"), true);

$nilai = [];
$nim = $_SESSION['nim'];

// ambil nilai milik mahasiswa
foreach ($nilaiData as $n) {
    if ($n['nim'] == $nim) {
        $nilai[] = $n['nilai'];
    }
}

// buat object mahasiswa
$mhs = new Mahasiswa($_SESSION['nama'], $nim);
$mhs->setNilai($nilai);

// POLYMORPHISM
function cetakLaporan(CetakLaporan $obj) {
    echo $obj->cetak();
}
?>

<h2>Kartu Hasil Studi (KHS)</h2>

<table border="1" cellpadding="10">
<tr>
<th>Mata Kuliah</th>
<th>Nilai</th>
</tr>

<?php
foreach ($nilaiData as $n) {
    if ($n['nim'] == $nim) {
        foreach ($matkul as $m) {
            if ($m['kode'] == $n['kode_matkul']) {
                echo "<tr>
                        <td>{$m['nama']}</td>
                        <td>{$n['nilai']}</td>
                      </tr>";
            }
        }
    }
}
?>
</table>

<br>

<?php
// tampilkan hasil dari OOP
cetakLaporan($mhs);
?>

<br><br>
<button onclick="window.print()">Cetak KHS</button>