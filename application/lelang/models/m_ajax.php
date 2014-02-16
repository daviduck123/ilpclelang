<?php

class M_ajax extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    public function select_fluktuasi() {
        $sql = "select * 
                from (select hf.id, ba.nama_barang, hf.harga_jual, hf.time
                from barang ba, history_fluktuasi hf
                where ba.id=hf.barang_id order by hf.id desc limit 45) tabel
                order by tabel.id asc";
        $result = $this->db->query($sql);
        return $result->result_array();
    }
    
    public function selectHarga(){
        $sql = "SELECT nama_barang, harga_sekarang FROM barang";
        $result = $this->db->query($sql);
        return $result->result_array();
    }

}

?>
