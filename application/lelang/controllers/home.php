<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('peserta/m_peserta');
        if ($this->session->userdata('jenis_login') == 2) {
            redirect('panitia');
        } else if (!$this->session->userdata('jenis_login')) {
            redirect('login');
        }
        $this->load->library('websession');
        $this->load->library('encrypt');
    }

    public function index() {
        $header['title'] = 'Home';
        $menu = $this->websession->getSession();
        $content = array();
        $content['news'] = $this->m_peserta->getNews();
        $content['lelang'] = $this->m_peserta->getLelangUserStatus($this->session->userdata("peserta_id"));
        $this->load->view('v_header', $header);
        $this->load->view('v_menu', $menu);
        $this->load->view('peserta/home/v_content', $content);
        $this->load->view('v_footer');
    }

    public function lelang() {
        $id = str_replace("home/lelang/", "", $this->uri->uri_string());
        if ($id == "home/lelang"):
            redirect("error/error404");
        endif;
        $id = $this->encrypt->decode($id);
        $header['title'] = 'Home';
        $menu = $this->websession->getSession();
        $content = array();
        $content = $this->m_peserta->viewDetailLelang($this->session->userdata("peserta_id"), $id);
        $content['news'] = $this->m_peserta->getNews();
        $this->load->view('v_header', $header);
        $this->load->view('v_menu', $menu);
        $this->load->view('peserta/home/v_detail_lelang', $content);
        $this->load->view('v_footer');
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */