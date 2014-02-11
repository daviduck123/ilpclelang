<?php

/**
 * Description of login
 *
 * @author santos sabanari
 */
Class Create extends CI_Controller {

    function __construct() {
    parent::__construct();}

    function index() {
        $this->load->view("test");
    }

    function pass() {
        echo md5($_GET['pass']);
    }

    function buat() {
        for ($a = 1; $a <= 61; $a++) {
            $sql = "INSERT INTO `user`(`nama`, `username`, `password`, `jumlahuang`, status, jumlahSertifikat) VALUES ('Ubaya$a','ubaya$a','" . md5('ubaya'.$a) ."',15000,'0','0')";
            $this->db->query($sql);
            echo "Sukses ke-".$a."<br>";
        }
    }

}
?>