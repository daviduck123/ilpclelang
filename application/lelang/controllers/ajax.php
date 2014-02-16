<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ajax extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('M_ajax');
    }

    public function fluktuasi() {
        if ($this->input->is_ajax_request()):
            $data = $this->M_ajax->select_fluktuasi();
            $count = -1;
            $tgl = '';
            $hasil = array();
            $hasil1 = array();
            foreach ($data as $single):
                $date = new DateTime($single["time"]);
                $hasil1[str_replace(' ', '', $single['nama_barang'])][$date->format("H:i")] = intval($single['harga_jual']);
            endforeach;
            $count = 0;
            foreach ($hasil1 as $index => $single):
                $hasil[$count]["data"] = array();
                foreach ($single as $index1 => $kecil):
                    array_push($hasil[$count]["data"], array("id" => $index1, "angka" => $kecil));
                endforeach;
                $hasil[$count]["id"] = $index;
                $count++;
            endforeach;
            echo json_encode($hasil);
        else:
            redirect('error/error404');
        endif;
    }

    public function hargaAkhir() {
        if ($this->input->is_ajax_request()):
            $data = $this->M_ajax->selectHarga();
            $hasil = array();
            foreach ($data as $index => $single):
                $hasil[str_replace(' ', '', $single['nama_barang'])] = $single["harga_sekarang"];
            endforeach;
            echo json_encode($hasil);
        else:
            redirect('error/error404');
        endif;
    }

}
