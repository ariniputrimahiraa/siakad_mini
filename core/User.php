<?php
abstract class User {
    protected $nama;

    public function __construct($nama) {
        $this->nama = $nama;
    }

    abstract public function getRole();
}