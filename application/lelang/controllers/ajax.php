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
            foreach ($data as $single):
                if ($tgl != $single['time']):
                    $count++;
                    $tgl = $single['time'];
                endif;
                $date = new DateTime($single['time']);
                $hasil[$count]['id'] = $date->format("H:i");
                $hasil[$count][str_replace(' ', '', $single['nama_barang'])] = intval($single['harga_jual']);
            endforeach;
            echo json_encode($hasil);
        else:
            redirect('error/error404');
        endif;
    }

}
