<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Error extends CI_Controller {

    public function __construct() {
        parent::__construct();
        //$this->load->model('peserta/M_harga');
    }
    
    public function error404(){        
        $header['title'] = 'Halaman tidak ada';
        $data['tujuan'] = ($this->uri->segment(1) == "panitia") ? "panitia" : "";
        $this->load->view('v_header',$header);
        $this->load->view('v_error',$data);
        $this->load->view('v_footer');
    }
}
?>