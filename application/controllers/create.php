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
        for ($a = 1; $a <= 40; $a++) {
            $sql = "INSERT INTO `user`(`nama`, `username`, `password`, `jumlahuang`) VALUES ('Player$a','player$a','player$a',100000)";
            $this->db->query($sql);
        }
    }

}
?>