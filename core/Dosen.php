<?php
require_once "User.php";

class Dosen extends User {
    public function getRole() {
        return "Dosen";
    }
}