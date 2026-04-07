<?php
require_once 'User.php';

class Dosen extends User {

    public function getRole() {
        return "dosen";
    }

    public function inputNilai($file, $dataBaru) {
        $data = json_decode(file_get_contents($file), true);

        $data[] = $dataBaru;

        file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));
    }
}