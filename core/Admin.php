<?php
require_once 'User.php';

class Admin extends User {

    public function getRole() {
        return "admin";
    }

    public function tambahData($file, $dataBaru) {
        $data = json_decode(file_get_contents($file), true);

        $data[] = $dataBaru;

        file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));
    }

    public function hapusData($file, $key, $value) {
        $data = json_decode(file_get_contents($file), true);

        foreach ($data as $i => $d) {
            if ($d[$key] == $value) {
                unset($data[$i]);
            }
        }

        file_put_contents($file, json_encode(array_values($data), JSON_PRETTY_PRINT));
    }
}