<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('M_login');
    }

    private function check() {
        if ($this->session->userdata('jenis_login') == 1) :
            redirect('home');
        elseif ($this->session->userdata('jenis_login') == 2):
            redirect('panitia');
        endif;
    }

    public function index() {
        $this->check();
        $header['title'] = "Login Peserta";
        $data = array();
        //check apakah halaman dipanggil untuk mengecheck halaman atay tidak
        if ($this->input->server('REQUEST_METHOD') == "POST"):
            //load library yang dibutuhkan
            $this->load->helper('security');
            $this->load->helper('string');
            //load data
            $uname = $this->input->post('username');
            $passw = do_hash($this->input->post('password'), 'md5');
            $check = $this->M_login->checkLoginPeserta($passw, $uname);
            $data['error'] = NULL;
            if (empty($check)):
                $data['error'] = "Username / Password anda salah";
            elseif ($check['status'] == 1):
                $data['error'] = "Username sedang log in silahkan log out terlebih dahulu";
            else:
                $this->M_login->setStatusPeserta($uname);
                $this->session->set_userdata('peserta_id', $check['id']);
                $this->session->set_userdata('peserta_nama', $check['nama']);
                $this->session->set_userdata('jenis_login', 1);
                redirect('home');
            endif;
        endif;
        $data['news'] = $this->M_login->getNews();
        $this->load->view('v_header', $header);
        $this->load->view('v_frontend', $data);
        $this->load->view('v_footer');
    }

    public function panitia() {
        $this->check();
        $header['title'] = "Login Panitia";
        $data = array();
        if ($this->input->server('REQUEST_METHOD') == "POST"):
            $this->load->helper('security');
            $this->load->helper('string');
            $username = $this->input->post("username");
            $password = do_hash($this->input->post('password'), 'md5');
            $panitia_id = $this->M_login->LoginPanitia($username, $password);
            $data['error'] = NULL;
            if (empty($panitia_id)):
                $data['error'] = "Username / Password anda salah";
            else:
                $this->session->set_userdata('panitia_id', $panitia_id['id']);
                $this->session->set_userdata('panitia_nama', $panitia_id['nama']);
                $this->session->set_userdata('jenis_login', 2);
                redirect('panitia');
            endif;
        endif;
        $this->load->view('v_header', $header);
        $this->load->view('v_backend', $data);
        $this->load->view('v_footer');
    }

    public function logout() {
        $this->M_login->unsetStatusPeserta($this->session->userdata('peserta_id'));
        $this->session->sess_destroy();
        redirect('login');
    }

    public function logoutPanitia() {
        $this->session->sess_destroy();
        redirect('login/panitia');
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
