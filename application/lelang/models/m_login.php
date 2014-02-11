<?php

class M_login extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    public function getNews() {
        $sql = "SELECT berita, time FROM news ORDER BY id DESC";
        $result = $this->db->query($sql);
        return $result->result_array();
    }

    public function checkLoginPeserta($password, $username) {
        $sql = "SELECT id, nama, status FROM user WHERE username = ? AND password = ?";
        $query = $this->db->query($sql, array($username, $password));
        return $query->row_array();
    }

    public function LoginPanitia($username, $password) {
        $sql = "SELECT id, nama FROM panitia WHERE username = ? AND password = ?";
        $query = $this->db->query($sql, array($username, $password));
        return $query->row_array();
    }

    public function setStatusPeserta($username) {
        $sql = "UPDATE user SET status = '1' WHERE username = ?";
        $this->db->query($sql, array($username));
    }

    public function unsetStatusPeserta($id) {
        $sql = "UPDATE user SET status = '0' WHERE id = ?";
        $this->db->query($sql, array($id));
    }

    public function getDataPeserta($id) {
        $sql = "SELECT nama, jumlahuang FROM user WHERE id = ? AND status = '1'";
        $result = $this->db->query($sql, array($id));
        return $result->row_array();
    }

    public function getDataPanitia($id) {
        $sql = "SELECT nama,status FROM panitia WHERE id = ?";
        $result = $this->db->query($sql, array($id));
        return $result->row_array();
    }

}

?>
