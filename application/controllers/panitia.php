<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Panitia extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model("panitia/m_panitia");
        if ($this->session->userdata('jenis_login') == 1) {
            redirect('home');
        } else if (!$this->session->userdata('jenis_login')) {
            redirect('login/panitia');
        }
        $this->load->library('encrypt');
        $this->load->library("websession");
    }

    public function index() {
        $header['title'] = 'Home Panitia';
        $menu = $this->websession->getSession();
        $content = array();
        $content['chat'] = $this->m_panitia->getAllChat();
        $content['news'] = $this->m_panitia->getAllNews();
        $this->load->view('v_header', $header);
        $this->load->view('panitia/v_menu_panitia', $menu);
        $this->load->view('panitia/v_home', $content);
        $this->load->view('v_footer');
    }

    // <editor-fold defaultstate="collapsed" desc="Pos">
    public function pos() {
        $id = str_replace("panitia/pos/", "", $this->uri->uri_string());
        if ($id != "panitia/pos"):
            redirect("error/error404");
        endif;
        $header['title'] = 'Pilih Pos';
        $menu = $this->websession->getSession();
        $content = array();
        $content['pos'] = $this->m_panitia->getPosILPC($this->session->userdata("panitia_id"));
        $content['status_panitia'] = $menu['status'];
        $content['notif'] = $this->session->flashdata("notif");
        $this->load->view('v_header', $header);
        $this->load->view("panitia/v_menu_panitia", $menu);
        $this->load->view('panitia/pos/v_pos', $content);
        $this->load->view('v_footer');
    }

    public function inputpos() {
        $id = str_replace("panitia/pos/inputpos/", "", $this->uri->uri_string());
        if ($id == "panitia/pos/inputpos"):
            redirect("error/error404");
        endif;
        $id = $this->encrypt->decode($id);
        $header['title'] = 'Input Pos';
        $menu = $this->websession->getSession();
        $content = array();
        $content['idpos'] = $id;
        if ($this->input->server('REQUEST_METHOD') == "POST") :
            $tim_id = $this->encrypt->decode($this->input->post("idtim"));
            $tabel_harga = $this->m_panitia->getDetailPos($id);
            $reward = array();
            $status = 3;
            if ($this->input->post("menang")):
                $reward['uang'] = $tabel_harga['uang_menang'];
                $reward['sertifikat'] = $tabel_harga['sertifikat_menang'];
                $status = 1;
            elseif ($this->input->post("seri")):
                $reward['uang'] = $tabel_harga['uang_kalah'];
                $reward['sertifikat'] = $tabel_harga['sertifikat_kalah'];
                $status = 2;
            elseif ($this->input->post("kalah")):
                $reward['uang'] = 0;
                $reward['sertifikat'] = 0;
                $status = 3;
            endif;
            $status = $this->m_panitia->insertHistoryModal($id, $tim_id, $status, $reward);
            $notif = array();
            if ($status):
                $notif['status'] = "success";
                $notif['pesan'] = "Input nilai pos berhasil dilakukan";
            else:
                $notif['status'] = "danger";
                $notif['pesan'] = "Input nilai pos gagal dilakukan";
            endif;
            $content['notif'] = $notif;
        endif;
        $content['status_panitia'] = $menu['status'];
        $content['tim'] = $this->m_panitia->getTimList($this->session->userdata("panitia_id"), $id);
        $this->load->view('v_header', $header);
        $this->load->view("panitia/v_menu_panitia", $menu);
        $this->load->view('panitia/pos/v_input', $content);
        $this->load->view('v_footer');
    }

    // </editor-fold>    
    // <editor-fold defaultstate="collapsed" desc="Season">   
    private function checkSeason($tujuan, $id) {
        $hasil['status'] = "success";
        $hasil['pesan'] = "Perubahan Season berhasil";
        $cek = $this->m_panitia->getStatusSeason($id);
        $dis = $this->m_panitia->disabledStatus($id);

        if (empty($cek)):
            $hasil['status'] = "danger";
            $hasil['pesan'] = "Season yang anda rubah tidak ada";
        elseif (($tujuan - $cek['aktif']) > 1):
            $hasil['status'] = "danger";
            if ($cek['aktif'] == '0'):
                $hasil['pesan'] = "Season $id harus dipersiapkan terlebih dahulu";
            elseif ($cek['aktif'] == '1'):
                $hasil['pesan'] = "Season $id harus dimulai terlebih dahulu";
            endif;
        elseif (($tujuan - $cek['aktif']) < 1):
            $hasil['status'] = "danger";
            $hasil['pesan'] = "Season $id tidak bisa diatur ulang";
        elseif ($tujuan == $cek['aktif']):
            $hasil['status'] = "warning";
            $hasil['pesan'] = "Season sudah berada distatus yang anda inginkan";
        elseif (!empty($dis)):
            $hasil['status'] = "danger";
            $hasil['pesan'] = "Season lain sedang berjalan";
        else:
            $masuk = $this->m_panitia->setStatusSeason($id, $tujuan);
            if (!$masuk):
                $hasil['status'] = "danger";
                $hasil['pesan'] = "Season $id gagal diubah";
            endif;
        endif;
        return $hasil;
    }

    public function season() {
        $header['title'] = 'Season Lelang';
        $menu = $this->websession->getSession();
        $content = array();
        $content['notif'] = $this->session->flashdata("notif");
        if ($this->input->server('REQUEST_METHOD') == "POST") :
            $id = str_replace("panitia/season/", "", $this->input->post('season_id'));
            if ($id == "panitia/season"):
                redirect("error/error404");
            endif;
            $id = $this->encrypt->decode($id);
            $rubahStatus = '0';
            if ($this->input->post("persiapan")):
                $rubahStatus = '1';
            elseif ($this->input->post("mulai")):
                $rubahStatus = '2';
            elseif ($this->input->post("stop")):
                $rubahStatus = '3';
            endif;
            $content['notif'] = $this->checkSeason($rubahStatus, $id);
        endif;
        $database = $this->m_panitia->getAllSeason();
        $content['season'] = $database['season'];
        $content['jalan'] = $database['jalan'];
        $content['status_panitia'] = $menu['status'];
        $this->load->view('v_header', $header);
        $this->load->view("panitia/v_menu_panitia", $menu);
        $this->load->view('panitia/season/v_set_season', $content);
        $this->load->view('v_footer');
    }

    // </editor-fold>    
    // <editor-fold defaultstate="collapsed" desc="Customer">
    public function customer() {
        $id = str_replace("panitia/customer/", "", $this->uri->uri_string());
        if ($id != "panitia/customer"):
            redirect("error/error404");
        endif;
        $header['title'] = 'Customer';
        $menu = $this->websession->getSession();
        $content = array();
        $content['customer'] = $this->m_panitia->getSemuaCustomer();
        $content['notif'] = $this->session->flashdata("notif");
        $this->load->view('v_header', $header);
        $this->load->view('panitia/v_menu_panitia', $menu);
        $this->load->view('panitia/customer/v_customer', $content);
        $this->load->view('v_footer');
    }

    public function editCustomer() {
        $id = str_replace("panitia/customer/edit/", "", $this->uri->uri_string());
        if ($id == "panitia/customer/edit"):
            redirect("error/error404");
        endif;
        $id = $this->encrypt->decode($id);
        $header['title'] = 'Customer Edit';
        $menu = $this->websession->getSession();
        $content = array();
        $content['customer'] = $this->m_panitia->getSingleCustomer($id);
        if ($this->input->server('REQUEST_METHOD') == "POST") :
            //load library
            $this->load->library("form_validation");
            //setting rule
            $this->form_validation->set_rules("nama_baru", "Nama Baru Customer", "required|max_length[50]");
            //setting message
            $this->form_validation->set_message("required", "%s Harus diisi");
            $this->form_validation->set_message("max_length", "%s Tidak boleh lebih dari 50 huruf");
            if ($this->form_validation->run() == TRUE):
                $status = $this->m_panitia->setEditCustomer($id, $this->input->post("nama_baru"));
                $notif = array();
                if ($status):
                    $notif['status'] = "success";
                    $notif['pesan'] = "Ubah Customer pos berhasil dilakukan";
                else:
                    $notif['status'] = "danger";
                    $notif['pesan'] = "Ubah Customer pos gagal dilakukan";
                endif;
                $this->session->set_flashdata("notif", $notif);
                redirect("panitia/customer");
            endif;
        endif;
        $this->load->view('v_header', $header);
        $this->load->view('panitia/v_menu_panitia', $menu);
        $this->load->view('panitia/customer/v_customer_edit', $content);
        $this->load->view('v_footer');
    }

    public function addCustomer() {
        $id = str_replace("panitia/customer/tambah/", "", $this->uri->uri_string());
        if ($id != "panitia/customer/tambah"):
            redirect("error/error404");
        endif;
        $header['title'] = 'Customer Tambah';
        $menu = $this->websession->getSession();
        $content = array();
        $content['new'] = $this->m_panitia->getNewIdCustomer();
        if ($this->input->server('REQUEST_METHOD') == "POST") :
            //load library
            $this->load->library("form_validation");
            //setting rule
            $this->form_validation->set_rules("nama", "Nama Customer", "required|max_length[50]");
            //setting message
            $this->form_validation->set_message("required", "%s Harus diisi");
            $this->form_validation->set_message("max_length", "%s Tidak boleh lebih dari 50 huruf");
            if ($this->form_validation->run() == TRUE):
                $status = $this->m_panitia->setAddCustomer($this->input->post("nama"));
                $notif = array();
                if ($status):
                    $notif['status'] = "success";
                    $notif['pesan'] = "Tambah Customer pos berhasil dilakukan";
                else:
                    $notif['status'] = "danger";
                    $notif['pesan'] = "Tambah Customer pos gagal dilakukan";
                endif;
                $this->session->set_flashdata("notif", $notif);
                redirect("panitia/customer");
            endif;
        endif;
        $this->load->view('v_header', $header);
        $this->load->view('panitia/v_menu_panitia', $menu);
        $this->load->view('panitia/customer/v_customer_add', $content);
        $this->load->view('v_footer');
    }

    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="Lelang">
    private function sortCustomerForSelectTag($data) {
        $hasil = array();
        foreach ($data as $index => $single):
            $hasil[$single['id']] = $single['nama_customer'];
        endforeach;
        return $hasil;
    }

    private function sortSeasonForSelectTag($data) {
        $data = $data['season'];
        $hasil = array();
        foreach ($data as $index => $single):
            $hasil[$single['id']] = $single['id'];
        endforeach;
        return $hasil;
    }

    private function sortBarangForSelectTag($data) {
        $hasil = array();
        foreach ($data as $index => $single):
            $hasil[$single['id']] = $single['nama_barang'];
        endforeach;
        return $hasil;
    }

    public function _numeric_wcomma($str) {
        $this->form_validation->set_message('_numeric_wcomma', "%s hanya bisa menerima angka saja");
        return preg_match('/^[0-9,]+$/', $str) ? TRUE : FALSE;
    }

    public function _greater_than_wcomma($value, $bts) {
        $this->form_validation->set_message('_greater_than_wcomma', "%s tidak boleh negatif");
        $input = str_replace(",", "", $value);
        return ($input > $bts) ? TRUE : FALSE;
    }

    public function lelang() {
        $header['title'] = 'Lelang';
        $menu = $this->websession->getSession();
        $content = array();
        $dataLelang = $this->m_panitia->getSemuaLelang();
        $allLelang = array();
        foreach ($dataLelang as $index => $single):
            $allLelang[$single['season_id']][] = $single;
        endforeach;
        $content['alllelang'] = $allLelang;
        $content['notif'] = $this->session->flashdata("notif");
        $this->load->view('v_header', $header);
        $this->load->view('panitia/v_menu_panitia', $menu);
        $this->load->view('panitia/lelang/v_liat_lelang', $content);
        $this->load->view('v_footer');
    }

    public function seeLelang() {
        $id = str_replace("panitia/lelang/lihat/", "", $this->uri->uri_string());
        if ($id == "panitia/lelang/lihat"):
            redirect("error/error404");
        endif;
        $id = $this->encrypt->decode($id);
        $header['title'] = 'Lihat Lelang';
        $menu = $this->websession->getSession();
        $content = array();
        $content = $this->m_panitia->getSingleLelang($id);
        $this->load->view('v_header', $header);
        $this->load->view('panitia/v_menu_panitia', $menu);
        $this->load->view('panitia/lelang/v_detail_lelang', $content);
        $this->load->view('v_footer');
    }

    public function editLelang() {
        $id = str_replace("panitia/lelang/edit/", "", $this->uri->uri_string());
        if ($id == "panitia/lelang/edit"):
            redirect("error/error404");
        endif;
        $id = $this->encrypt->decode($id);
        $header['title'] = 'Edit Lelang';
        $menu = $this->websession->getSession();
        $content = array();
        $content = $this->m_panitia->getSingleLelang($id);
        if ($this->input->server('REQUEST_METHOD') == "POST") :
            $this->load->library("form_validation");
            //setting rules
            $this->form_validation->set_rules("customer", "Pemilik (Customer) Lelang", "required");
            $this->form_validation->set_rules("season", "Season Lelang", "required");
            $this->form_validation->set_rules("no_lelang", "No Identitas Lelang", "required|max_length[50]");
            $this->form_validation->set_rules("judul_lelang", "Judul Lelang", "required");
            $this->form_validation->set_rules("deskripsi", "Deskripsi Lelang", "required");
            $this->form_validation->set_rules("budget", "Budget Lelang", "required|callback__numeric_wcomma|callback__greater_than_wcomma[0]");
            $this->form_validation->set_rules("jumlah", "Jumlah Barang Lelang", "required|callback__numeric_wcomma|callback__greater_than_wcomma[0]");
            $this->form_validation->set_rules("nama_barang", "Nama Barang Lelang", "required");
            $this->form_validation->set_rules("barang", "Komposisi Barang", "required");
            //setting message
            $this->form_validation->set_message("required", "%s Harus diisi");
            $this->form_validation->set_message("max_length", "%s tidak boleh melebihi 50 karakter");
            if ($this->form_validation->run() == TRUE):
                if ($content['lelang']['status_lelang'] == '0'):
                    $lelang = array();
                    $lelang['no_lelang'] = $this->input->post("no_lelang");
                    $lelang['judul_lelang'] = $this->input->post("judul_lelang");
                    $lelang['budget'] = str_replace(",", "", $this->input->post("budget"));
                    $lelang['deskripsi'] = $this->input->post("deskripsi");
                    $lelang['jumlah'] = str_replace(",", "", $this->input->post("jumlah"));
                    $lelang['customer_id'] = $this->input->post("customer");
                    $lelang['season_id'] = $this->input->post("season");
                    $lelang['nama_barang'] = $this->input->post("nama_barang");
                    $lelang['detailbarang'] = $this->input->post("barang");
                    $status = $this->m_panitia->setEditLelang($lelang, $id);
                    if ($status):
                        $notif['status'] = "success";
                        $notif['pesan'] = "Edit Lelang berhasil dilakukan";
                    else:
                        $notif['status'] = "danger";
                        $notif['pesan'] = "Edit Lelang pos gagal dilakukan";
                    endif;
                else:
                    $notif['status'] = "danger";
                    $notif['pesan'] = "Jangan Merubah Id Form yang telah ditentukan";
                endif;
                $this->session->set_flashdata("notif", $notif);
                redirect("panitia/lelang");
            endif;
        endif;
        $content['dataCustomer'] = $this->sortCustomerForSelectTag($this->m_panitia->getSemuaCustomer());
        $content['dataSeason'] = $this->sortSeasonForSelectTag($this->m_panitia->getAllSeason());
        $content['dataBarang'] = $this->m_panitia->getSemuaBarang();
        $content['barang'] = $this->sortBarangForSelectTag($content["detailLelang"]);
        $content['id'] = $id;
        $this->load->view('v_header', $header);
        $this->load->view('panitia/v_menu_panitia', $menu);
        $this->load->view('panitia/lelang/v_edit_lelang', $content);
        $this->load->view('v_footer');
    }

    public function addLelang() {
        $id = str_replace("panitia/lelang/tambah/", "", $this->uri->uri_string());
        if ($id != "panitia/lelang/tambah"):
            redirect("error/error404");
        endif;
        $header['title'] = 'Tambah Lelang';
        $menu = $this->websession->getSession();
        $content = array();
        if ($this->input->server('REQUEST_METHOD') == "POST") :
            $this->load->library("form_validation");
            //setting rules
            $this->form_validation->set_rules("customer", "Pemilik (Customer) Lelang", "required");
            $this->form_validation->set_rules("season", "Season Lelang", "required");
            $this->form_validation->set_rules("no_lelang", "No Identitas Lelang", "required|max_length[50]");
            $this->form_validation->set_rules("judul_lelang", "Judul Lelang", "required");
            $this->form_validation->set_rules("deskripsi", "Deskripsi Lelang", "required");
            $this->form_validation->set_rules("budget", "Budget Lelang", "required|callback__numeric_wcomma|callback__greater_than_wcomma[0]");
            $this->form_validation->set_rules("jumlah", "Jumlah Barang Lelang", "required|callback__numeric_wcomma|callback__greater_than_wcomma[0]");
            $this->form_validation->set_rules("nama_barang", "Nama Barang Lelang", "required");
            $this->form_validation->set_rules("barang", "Komposisi Barang", "required");
            //setting message
            $this->form_validation->set_message("required", "%s Harus diisi");
            $this->form_validation->set_message("max_length", "%s tidak boleh melebihi 50 karakter");
            if ($this->form_validation->run() == TRUE):
                $lelang = array();
                $lelang['no_lelang'] = $this->input->post("no_lelang");
                $lelang['judul_lelang'] = $this->input->post("judul_lelang");
                $lelang['budget'] = str_replace(",", "", $this->input->post("budget"));
                $lelang['deskripsi'] = $this->input->post("deskripsi");
                $lelang['jumlah'] = str_replace(",", "", $this->input->post("jumlah"));
                $lelang['customer_id'] = $this->input->post("customer");
                $lelang['season_id'] = $this->input->post("season");
                $lelang['nama_barang'] = $this->input->post("nama_barang");
                $lelang['detailbarang'] = $this->input->post("barang");
                $status = $this->m_panitia->setAddLelang($lelang);
                if ($status):
                    $notif['status'] = "success";
                    $notif['pesan'] = "Tambah Lelang berhasil dilakukan";
                else:
                    $notif['status'] = "danger";
                    $notif['pesan'] = "Tambah Lelang pos gagal dilakukan";
                endif;

                $this->session->set_flashdata("notif", $notif);
                redirect("panitia/lelang");
            endif;
        endif;
        $content['dataCustomer'] = $this->sortCustomerForSelectTag($this->m_panitia->getSemuaCustomer());
        $content['dataSeason'] = $this->sortSeasonForSelectTag($this->m_panitia->getAllSeason());
        $content['dataBarang'] = $this->m_panitia->getSemuaBarang();
        $this->load->view('v_header', $header);
        $this->load->view('panitia/v_menu_panitia', $menu);
        $this->load->view('panitia/lelang/v_tambah_lelang', $content);
        $this->load->view('v_footer');
    }

    public function pesertaLelang() {
        $id = str_replace("panitia/lelang/peserta/", "", $this->uri->uri_string());
        if ($id == "panitia/lelang/peserta"):
            redirect("error/error404");
        endif;
        $id = $this->encrypt->decode($id);
        $header['title'] = 'Peserta Lelang';
        $menu = $this->websession->getSession();
        $content = array();
        $content['peserta'] = $this->m_panitia->getPesertaLelang($id);
        $content['id'] = $id;
        $this->load->view('v_header', $header);
        $this->load->view('panitia/v_menu_panitia', $menu);
        $this->load->view('panitia/lelang/v_peserta_lelang', $content);
        $this->load->view('v_footer');
    }

    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="News">
    public function news() {
        $header['title'] = 'News';
        $menu = $this->websession->getSession();
        $content = array();
        if ($this->input->server('REQUEST_METHOD') == "POST") :
            $this->load->library("form_validation");
            $this->form_validation->set_rules("news", "Berita News", "required");
            $this->form_validation->set_message("required", "%s harus diisi");
            if ($this->form_validation->run() == TRUE):
                $status = $this->m_panitia->setAddNews($this->session->userdata("panitia_id"), $this->input->post("news"));
                $notif = array();
                if ($status):
                    $notif['status'] = "success";
                    $notif['pesan'] = "Tambah News berhasil dilakukan";
                else:
                    $notif['status'] = "danger";
                    $notif['pesan'] = "Tambah News gagal dilakukan";
                endif;
                $content['notif'] = $notif;
            endif;
        endif;
        $content['news'] = $this->m_panitia->getAllNews();
        $this->load->view('v_header', $header);
        $this->load->view("panitia/v_menu_panitia", $menu);
        $this->load->view('panitia/news/v_input_news', $content);
        $this->load->view('v_footer');
    }

    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="Login Peserta">
    public function peserta() {
        $header['title'] = 'Login Peserta';
        $menu = $this->websession->getSession();
        $content = array();
        $id = str_replace("panitia/peserta/", "", $this->uri->uri_string());
        if ($id != "panitia/peserta"):
            $id = $this->encrypt->decode($id);
            echo $id;
            $status = $this->m_panitia->setEditLoginPeserta($id);
            $notif = array();
            if ($status):
                $notif['status'] = "success";
                $notif['pesan'] = "Ubah Login Peserta berhasil dilakukan";
            else:
                $notif['status'] = "danger";
                $notif['pesan'] = "Ubah Login Peserta dilakukan";
            endif;
            $content['notif'] = $notif;
        endif;
        $content['peserta'] = $this->m_panitia->getAllLoginPeserta();
        $this->load->view('v_header', $header);
        $this->load->view("panitia/v_menu_panitia", $menu);
        $this->load->view('panitia/login_peserta/v_login_peserta', $content);
        $this->load->view('v_footer');
    }

    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="Chat">
    public function chat() {
        $header['title'] = 'Chat';
        $menu = $this->websession->getSession();
        $content = array();
        if ($this->input->server('REQUEST_METHOD') == "POST") :
            $this->load->library("form_validation");
            $this->form_validation->set_rules("chat", "Isi Chat", "required");
            $this->form_validation->set_message("required", "%s harus diisi");
            if ($this->form_validation->run() == TRUE):
                $status = $this->m_panitia->setAddChat($this->session->userdata("panitia_id"), $this->input->post("chat"));
                $notif = array();
                if ($status):
                    $notif['status'] = "success";
                    $notif['pesan'] = "Tambah Chat berhasil dilakukan";
                else:
                    $notif['status'] = "danger";
                    $notif['pesan'] = "Tambah Chat gagal dilakukan";
                endif;
                $content['notif'] = $notif;
            endif;
        endif;
        $content['chat'] = $this->m_panitia->getAllChat();
        $this->load->view('v_header', $header);
        $this->load->view("panitia/v_menu_panitia", $menu);
        $this->load->view('panitia/chat/v_input_chat', $content);
        $this->load->view('v_footer');
    }

    // </editor-fold>    
    // <editor-fold defaultstate="collapsed" desc="Change Password">
    public function _checkOldPassword($value) {
        $this->form_validation->set_message('_checkOldPassword', "%s is wrong");
        $return = $this->m_panitia->getOldPassword($this->session->userdata("panitia_id"), md5($value));
        return (empty($return)) ? FALSE : TRUE;
    }

    public function _checkNewPassword($value, $bts) {
        $this->form_validation->set_message('_checkNewPassword', "%s didn't match with new password");
        return ($value == $bts) ? TRUE : FALSE;
    }

    public function change() {
        $header['title'] = 'Change Password';
        $menu = $this->websession->getSession();
        $content = array();
        if ($this->input->server('REQUEST_METHOD') == "POST") :
            //masukan variabel
            $old = $this->input->post("old");
            $new = $this->input->post("new");
            $confirm = $this->input->post("confirm");
            //load library
            $this->load->library("form_validation");
            //set rules
            $this->form_validation->set_rules("old", "Old Password", "required|max_length[40]|callback__checkOldPassword");
            $this->form_validation->set_rules("new", "New Password", "required|max_length[40]");
            $this->form_validation->set_rules("confirm", "Confirm Password", "required|max_length[40]|callback__checkNewPassword[$new]");
            //set message
            $this->form_validation->set_message("required", "%s is required");
            $this->form_validation->set_message("max_length", "%s maximum 40 character");
            //execute form_validation
            if ($this->form_validation->run() == TRUE):
                $status = $this->m_panitia->setNewPassword($this->session->userdata("panitia_id"), md5($new));
                $notif = array();
                if ($status):
                    $notif['status'] = "success";
                    $notif['pesan'] = "Password is succeced change";
                else:
                    $notif['status'] = "danger";
                    $notif['pesan'] = "Password is failed change";
                endif;
                $content['notif'] = $notif;
            endif;
        endif;
        $this->load->view('v_header', $header);
        $this->load->view("panitia/v_menu_panitia", $menu);
        $this->load->view('panitia/password/v_change_password', $content);
        $this->load->view('v_footer');
    }

    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="Super Admin">
    private function checkAdmin($data) {
        if ($data['status'] != '1'):
            redirect("error/error404");
        endif;
    }

    // <editor-fold defaultstate="collapsed" desc="Login Panitia">   
    public function Username() {
        $header['title'] = 'Username Panitia';
        $menu = $this->websession->getSession();
        $this->checkAdmin($menu);
        $content = array();
        $content['notif'] = $this->session->flashdata("notif");
        $content['panitia'] = $this->m_panitia->getAllPanitia($this->session->userdata("panitia_id"));
        $this->load->view('v_header', $header);
        $this->load->view("panitia/v_menu_panitia", $menu);
        $this->load->view('panitia/admin/login_panitia/v_all_panitia', $content);
        $this->load->view('v_footer');
    }

    public function _checkUsernameExist($username) {
        $this->form_validation->set_message("_checkUsernameExist", "Username $username Sudah ada didatabase");
        $ada = $this->m_panitia->checkUsername($username);
        if (empty($ada)):
            return TRUE;
        else:
            return FALSE;
        endif;
    }

    public function addUsername() {
        $id = str_replace("panitia/username/tambah/", "", $this->uri->uri_string());
        if ($id != "panitia/username/tambah"):
            redirect("error/error404");
        endif;
        $header['title'] = 'Tambah Panitia';
        $menu = $this->websession->getSession();
        $this->checkAdmin($menu);
        $content = array();
        if ($this->input->server('REQUEST_METHOD') == "POST") :
            $this->load->library("form_validation");
            //setting rules
            $this->form_validation->set_rules("nama", "Nama Panitia", "required|max_length[45]");
            $this->form_validation->set_rules("username", "Nama Panitia", "required|max_length[45]|callback__checkUsernameExist");
            $this->form_validation->set_rules("jabatan", "Jabatan Panitia", "required");
            //setting message
            $this->form_validation->set_message("required", "%s Harus Diisi");
            $this->form_validation->set_message("max_length", "%s Tidak boleh lebih dari 45 Character");
            //jalankan form_validation
            if ($this->form_validation->run() == TRUE):
                $nama = $this->input->post("nama");
                $username = $this->input->post("username");
                $jabatan = $this->input->post("jabatan");
                $this->load->helper('string');
                $password = random_string('alnum', 6);
                $status = $this->m_panitia->setAddDataPanitia($username, md5($password), $jabatan, $nama);
                $notif = array();
                if ($status):
                    $notif['status'] = "success";
                    $notif['pesan'] = "Tambah Data Panitia berhasil dilakukan dengan username '$username' dan password '$password'";
                else:
                    $notif['status'] = "danger";
                    $notif['pesan'] = "Tambah Data Panitia Panitia gagal dilakukan";
                endif;
                $this->session->set_flashdata("notif", $notif);
                redirect("panitia/username");
            endif;
        endif;
        $this->load->view('v_header', $header);
        $this->load->view("panitia/v_menu_panitia", $menu);
        $this->load->view('panitia/admin/login_panitia/v_add_panitia', $content);
        $this->load->view('v_footer');
    }

    public function editUsername() {
        $id = str_replace("panitia/username/edit/", "", $this->uri->uri_string());
        if ($id == "panitia/username/edit"):
            redirect("error/error404");
        endif;
        $id = $this->encrypt->decode($id);
        $header['title'] = 'Edit Panitia';
        $menu = $this->websession->getSession();
        $this->checkAdmin($menu);
        $content = array();
        if ($this->input->server('REQUEST_METHOD') == "POST") :
            $this->load->library("form_validation");
            //setting rules
            $this->form_validation->set_rules("nama", "Nama Panitia", "required|max_length[45]");
            $this->form_validation->set_rules("jabatan", "Jabatan Panitia", "required");
            //setting message
            $this->form_validation->set_message("required", "%s Harus Diisi");
            $this->form_validation->set_message("max_length", "%s Tidak boleh lebih dari 45 Character");
            //jalankan form_validation
            if ($this->form_validation->run() == TRUE):
                $status = $this->m_panitia->setEditDataPanitia($id, $this->input->post("nama"), $this->input->post("jabatan"));
                $notif = array();
                if ($status):
                    $notif['status'] = "success";
                    $notif['pesan'] = "Ubah Data Panitia berhasil dilakukan";
                else:
                    $notif['status'] = "danger";
                    $notif['pesan'] = "Ubah Data Panitia Panitia gagal dilakukan";
                endif;
                $this->session->set_flashdata("notif", $notif);
                redirect("panitia/username");
            endif;
        endif;
        $content['panitia'] = $this->m_panitia->getSinglePanitia($id);
        $this->load->view('v_header', $header);
        $this->load->view("panitia/v_menu_panitia", $menu);
        $this->load->view('panitia/admin/login_panitia/v_edit_panitia', $content);
        $this->load->view('v_footer');
    }

    public function resetUsername() {
        $id = str_replace("panitia/username/reset/", "", $this->uri->uri_string());
        if ($id == "panitia/username/reset"):
            redirect("error/error404");
        endif;
        $id = $this->encrypt->decode($id);
        $menu = $this->websession->getSession();
        $this->checkAdmin($menu);
        $this->load->helper('string');
        $password = random_string('alnum', 6);
        $status = $this->m_panitia->setResetPanitia($id, md5($password));
        $notif = array();
        if ($status):
            $notif['status'] = "success";
            $notif['pesan'] = "Reset Password Panitia berhasil dilakukan dengan password '$password'";
        else:
            $notif['status'] = "danger";
            $notif['pesan'] = "Reset Password Panitia gagal dilakukan";
        endif;
        $this->session->set_flashdata("notif", $notif);
        redirect("panitia/username");
    }

    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="Jenis Pos">
    public function jenis_pos() {
        $header['title'] = 'Jenis Pos';
        $menu = $this->websession->getSession();
        $this->checkAdmin($menu);
        $content = array();
        $content['notif'] = $this->session->flashdata("notif");
        $content['jenis'] = $this->m_panitia->getAllJenisPos();
        $this->load->view('v_header', $header);
        $this->load->view("panitia/v_menu_panitia", $menu);
        $this->load->view('panitia/admin/jenis_pos/v_all_pos', $content);
        $this->load->view('v_footer');
    }

    public function addJenisPos() {
        $header['title'] = 'Tambah Jenis';
        $menu = $this->websession->getSession();
        $this->checkAdmin($menu);
        $content = array();
        if ($this->input->server('REQUEST_METHOD') == "POST") :
            $this->load->library("form_validation");
            //setting rules
            $this->form_validation->set_rules("nama", "Nama Jenis", "required");
            $this->form_validation->set_rules("sertifikat_menang", "Sertifikat Menang", "required|callback__numeric_wcomma|callback__greater_than_wcomma[0]");
            $this->form_validation->set_rules("sertifikat_kalah", "Sertifikat Kalah", "required|callback__numeric_wcomma|callback__greater_than_wcomma[0]");
            $this->form_validation->set_rules("uang_menang", "Uang Menang", "required|callback__numeric_wcomma|callback__greater_than_wcomma[0]");
            $this->form_validation->set_rules("uang_kalah", "Uang Kalah", "required|callback__numeric_wcomma|callback__greater_than_wcomma[0]");
            //setting message
            $this->form_validation->set_message("required", "%s harus diisi");
            if ($this->form_validation->run() == TRUE):
                $data['nama'] = $this->input->post("nama");
                $data['sertifikat_menang'] = str_replace(",", "", $this->input->post("sertifikat_menang"));
                $data['sertifikat_kalah'] = str_replace(",", "", $this->input->post("sertifikat_kalah"));
                $data['uang_menang'] = str_replace(",", "", $this->input->post("uang_menang"));
                $data['uang_kalah'] = str_replace(",", "", $this->input->post("uang_kalah"));
                $status = $this->m_panitia->setAddJenisPos($data);
                $notif = array();
                if ($status):
                    $notif['status'] = "success";
                    $notif['pesan'] = "Tambah Jenis Pos berhasil dilakukan";
                else:
                    $notif['status'] = "danger";
                    $notif['pesan'] = "Tambah Jenis Pos Panitia gagal dilakukan";
                endif;
                $this->session->set_flashdata("notif", $notif);
                redirect("panitia/jenis_pos");
            endif;
        endif;
        $content['notif'] = $this->session->flashdata("notif");
        $this->load->view('v_header', $header);
        $this->load->view("panitia/v_menu_panitia", $menu);
        $this->load->view('panitia/admin/jenis_pos/v_add_pos', $content);
        $this->load->view('v_footer');
    }

    public function editJenisPos() {
        $id = str_replace("panitia/jenis_pos/edit/", "", $this->uri->uri_string());
        if ($id == "panitia/jenis_pos/edit"):
            redirect("error/error404");
        endif;
        $id = $this->encrypt->decode($id);
        $header['title'] = 'Edit Jenis';
        $menu = $this->websession->getSession();
        $this->checkAdmin($menu);
        $content = array();
        if ($this->input->server('REQUEST_METHOD') == "POST") :
            $this->load->library("form_validation");
            //setting rules
            $this->form_validation->set_rules("nama", "Nama Jenis", "required");
            $this->form_validation->set_rules("sertifikat_menang", "Sertifikat Menang", "required|callback__numeric_wcomma|callback__greater_than_wcomma[0]");
            $this->form_validation->set_rules("sertifikat_kalah", "Sertifikat Kalah", "required|callback__numeric_wcomma|callback__greater_than_wcomma[0]");
            $this->form_validation->set_rules("uang_menang", "Uang Menang", "required|callback__numeric_wcomma|callback__greater_than_wcomma[0]");
            $this->form_validation->set_rules("uang_kalah", "Uang Kalah", "required|callback__numeric_wcomma|callback__greater_than_wcomma[0]");
            //setting message
            $this->form_validation->set_message("required", "%s harus diisi");
            if ($this->form_validation->run() == TRUE):
                $data['nama'] = $this->input->post("nama");
                $data['sertifikat_menang'] = str_replace(",", "", $this->input->post("sertifikat_menang"));
                $data['sertifikat_kalah'] = str_replace(",", "", $this->input->post("sertifikat_kalah"));
                $data['uang_menang'] = str_replace(",", "", $this->input->post("uang_menang"));
                $data['uang_kalah'] = str_replace(",", "", $this->input->post("uang_kalah"));
                $status = $this->m_panitia->setEditJenisPos($id, $data);
                $notif = array();
                if ($status):
                    $notif['status'] = "success";
                    $notif['pesan'] = "Tambah Jenis Pos berhasil dilakukan";
                else:
                    $notif['status'] = "danger";
                    $notif['pesan'] = "Tambah Jenis Pos Panitia gagal dilakukan";
                endif;
                $this->session->set_flashdata("notif", $notif);
                redirect("panitia/jenis_pos");
            endif;
        endif;
        $content['notif'] = $this->session->flashdata("notif");
        $content['jenis'] = $this->m_panitia->getSingleJenisPos($id);
        $this->load->view('v_header', $header);
        $this->load->view("panitia/v_menu_panitia", $menu);
        $this->load->view('panitia/admin/jenis_pos/v_edit_pos', $content);
        $this->load->view('v_footer');
    }

    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="Season">
    public function setWinnerSeason() {
        $id = str_replace("panitia/setWinnerSeason/", "", $this->uri->uri_string());
        if ($id == "panitia/setWinnerSeason"):
            redirect("error/error404");
        endif;
        $id = $this->encrypt->decode($id);
        $menu = $this->websession->getSession();
        $this->checkAdmin($menu);
        $notif = array();
        $cekStatus = $this->m_panitia->getStatusSessionMenang($id);
        if ($cekStatus):
            $status = $this->m_panitia->setPemenang($id);
            if ($status):
                $notif['status'] = "success";
                $notif['pesan'] = "Pemenang Season $id berhasil ditentukan";
            else:
                $notif['status'] = "danger";
                $notif['pesan'] = "Pemenang Season  $id gagal ditentukan";
            endif;
        else:
            $notif['status'] = "danger";
            $notif['pesan'] = "Season  $id Belum selesai";
        endif;
        $this->session->set_flashdata("notif", $notif);
        redirect("panitia/season");
    }

    public function setAddSeason() {
        $id = str_replace("panitia/setAddSeason/", "", $this->uri->uri_string());
        if ($id != "panitia/setAddSeason"):
            redirect("error/error404");
        endif;
        $menu = $this->websession->getSession();
        $this->checkAdmin($menu);
        $notif = array();
        $status = $this->m_panitia->setAddSeason();
        if ($status):
            $notif['status'] = "success";
            $notif['pesan'] = "Pemenang Season $id berhasil ditentukan";
        else:
            $notif['status'] = "danger";
            $notif['pesan'] = "Pemenang Season  $id gagal ditentukan";
        endif;
        $this->session->set_flashdata("notif", $notif);
        redirect("panitia/season");
    }

    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="Pos">
    private function sortJenisPosForSelectTag($data) {
        $hasil = array();
        foreach ($data as $index => $single):
            $hasil[$single['id']] = $single['nama_jenis'];
        endforeach;
        return $hasil;
    }

    public function tambahPos() {
        $id = str_replace("panitia/pos/tambah/", "", $this->uri->uri_string());
        if ($id != "panitia/pos/tambah"):
            redirect("error/error404");
        endif;
        $header['title'] = 'Tambah Pos';
        $menu = $this->websession->getSession();
        $this->checkAdmin($menu);
        if ($this->input->server('REQUEST_METHOD') == "POST") :
            $this->load->library("form_validation");
            //setting rules
            $this->form_validation->set_rules("nama", "Nama Pos", "required|max_length[45]");
            $this->form_validation->set_rules("jenis", "Jabatan Pos", "required");
            //setting message
            $this->form_validation->set_message("required", "%s Harus Diisi");
            $this->form_validation->set_message("max_length", "%s Tidak boleh lebih dari 45 Character");
            //jalankan form_validation
            if ($this->form_validation->run() == TRUE):
                $status = $this->m_panitia->setNewPos($this->input->post("nama"), $this->input->post("jenis"));
                $notif = array();
                if ($status):
                    $notif['status'] = "success";
                    $notif['pesan'] = "Tambah Pos berhasil dilakukan";
                else:
                    $notif['status'] = "danger";
                    $notif['pesan'] = "Tambah Pos gagal dilakukan";
                endif;
                $this->session->set_flashdata("notif", $notif);
                redirect("panitia/pos");
            endif;
        endif;
        $content = array();
        $content['jenis'] = $this->sortJenisPosForSelectTag($this->m_panitia->getAllJenisPos());
        $this->load->view('v_header', $header);
        $this->load->view("panitia/v_menu_panitia", $menu);
        $this->load->view('panitia/admin/pos/v_add_new_pos', $content);
        $this->load->view('v_footer');
    }

    public function editPos() {
        $id = str_replace("panitia/pos/tambah/", "", $this->uri->uri_string());
        if ($id != "panitia/pos/tambah"):
            redirect("error/error404");
        endif;
        $id = $this->encrypt->decode($id);
        $header['title'] = 'Tambah Pos';
        $menu = $this->websession->getSession();
        $this->checkAdmin($menu);
        $cekStatus = $this->m_panitia->getAvaiablePos($id);
        if ($cekStatus):
            if ($this->input->server('REQUEST_METHOD') == "POST") :
                $this->load->library("form_validation");
                //setting rules
                $this->form_validation->set_rules("nama", "Nama Pos", "required|max_length[45]");
                $this->form_validation->set_rules("jenis", "Jabatan Pos", "required");
                //setting message
                $this->form_validation->set_message("required", "%s Harus Diisi");
                $this->form_validation->set_message("max_length", "%s Tidak boleh lebih dari 45 Character");
                //jalankan form_validation
                if ($this->form_validation->run() == TRUE):
                    $status = $this->m_panitia->setEditPos($id, $this->input->post("nama"), $this->input->post("jenis"));
                    $notif = array();
                    if ($status):
                        $notif['status'] = "success";
                        $notif['pesan'] = "Edit Pos berhasil dilakukan";
                    else:
                        $notif['status'] = "danger";
                        $notif['pesan'] = "Edit Pos gagal dilakukan";
                    endif;
                    $this->session->set_flashdata("notif", $notif);
                    redirect("panitia/pos");
                endif;
            endif;
            $content = array();
            $content['pos'] = $this->m_panitia->getSinglePos($id);
            $content['jenis'] = $this->sortJenisPosForSelectTag($this->m_panitia->getAllJenisPos());
            $this->load->view('v_header', $header);
            $this->load->view("panitia/v_menu_panitia", $menu);
            $this->load->view('panitia/admin/pos/v_edit_new_pos', $content);
            $this->load->view('v_footer');
        else:
            $notif['status'] = "danger";
            $notif['pesan'] = "Pos Tidak dapat diedit karena sudah terikat dengan user";
        endif;
        $this->session->set_flashdata("notif", $notif);
        redirect("panitia/pos");
    }

    public function ubahstatus() {
        $id = str_replace("panitia/pos/ubahstatus/", "", $this->uri->uri_string());
        if ($id == "panitia/pos/ubahstatus"):
            redirect("error/error404");
        endif;
        $id = explode("|", $id);
        $idpeserta = $this->encrypt->decode($id[0]);
        $idpos = $this->encrypt->decode($id[1]);
        $menu = $this->websession->getSession();
        $this->checkAdmin($menu);
        $status = $this->m_panitia->setChangePeserta($idpeserta, $idpos);
        if ($status):
            $notif['status'] = "success";
            $notif['pesan'] = "Ubah Status Peserta berhasil ditentukan";
        else:
            $notif['status'] = "danger";
            $notif['pesan'] = "Ubah Status Peserta gagal ditentukan";
        endif;
        $this->session->set_flashdata("notif", $notif);
        redirect("panitia/pos/inputpos/" . $this->encrypt->encode($idpos));
    }

    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="Wewenang Pos">
    public function wewenang() {
        $header['title'] = 'Wewenang Pos';
        $menu = $this->websession->getSession();
        $this->checkAdmin($menu);
        $content = array();
        $content['notif'] = $this->session->flashdata("notif");
        $content['panitia'] = $this->m_panitia->getAllPanitiaPos();
        $this->load->view('v_header', $header);
        $this->load->view("panitia/v_menu_panitia", $menu);
        $this->load->view('panitia/admin/wewenang/v_all_wewenang', $content);
        $this->load->view('v_footer');
    }

    private function sortPosPanitiaForSelectTag($data) {
        $hasil = array();
        foreach ($data as $index => $single):
            if (empty($hasil[$single['nama_jenis']])):
                $hasil[$single['nama_jenis']] = array();
            endif;
            $hasil[$single['nama_jenis']][] = array("id" => $single['id'], "nama" => $single['nama_pos'], "panitia" => $single['panitia_id']);
        endforeach;
        return $hasil;
    }

    public function editWewenang() {
        $id = str_replace("panitia/wewenang/edit/", "", $this->uri->uri_string());
        if ($id == "panitia/wewenang/edit"):
            redirect("error/error404");
        endif;
        $id = $this->encrypt->decode($id);
        $header['title'] = 'Edit Wewenang';
        $menu = $this->websession->getSession();
        $this->checkAdmin($menu);
        $content = array();
        if ($this->input->server('REQUEST_METHOD') == "POST") :
            $this->load->library("form_validation");
            $this->form_validation->set_rules("wewenang", "Pos Wewenang", "required");
            $this->form_validation->set_message("required", "%s Harus diisi");
            if ($this->form_validation->run() == TRUE):
                $pos = $this->input->post("wewenang");
                $status = $this->m_panitia->setWewenangPanitia($id, $pos);
                if ($status):
                    $notif['status'] = "success";
                    $notif['pesan'] = "Tambah Wewenang berhasil dilakukan";
                else:
                    $notif['status'] = "danger";
                    $notif['pesan'] = "Tambah Wewenang pos gagal dilakukan";
                endif;

                $this->session->set_flashdata("notif", $notif);
                redirect("panitia/wewenang");
            endif;
        endif;
        $content['panitia'] = $this->m_panitia->getSinglePanitiaPos($id);
        $content['pos'] = $this->sortPosPanitiaForSelectTag($this->m_panitia->getStatusPanitiaPos($id));
        $this->load->view('v_header', $header);
        $this->load->view("panitia/v_menu_panitia", $menu);
        $this->load->view('panitia/admin/wewenang/v_edit_wewenang', $content);
        $this->load->view('v_footer');
    }

    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="Barang">
    public function barang() {
        $header['title'] = 'Barang Pos';
        $menu = $this->websession->getSession();
        $this->checkAdmin($menu);
        $content = array();
        $content['notif'] = $this->session->flashdata("notif");
        $content['barang'] = $this->m_panitia->getAllBarang();
        $this->load->view('v_header', $header);
        $this->load->view("panitia/v_menu_panitia", $menu);
        $this->load->view('panitia/admin/barang/v_all_barang', $content);
        $this->load->view('v_footer');
    }

    public function editBarang() {
        $id = str_replace("panitia/barang/edit/", "", $this->uri->uri_string());
        if ($id == "panitia/barang/edit"):
            redirect("error/error404");
        endif;
        $id = $this->encrypt->decode($id);
        $header['title'] = 'Edit Data Barang';
        $menu = $this->websession->getSession();
        $this->checkAdmin($menu);
        $content = array();
        if ($this->input->server('REQUEST_METHOD') == "POST") :
            $this->load->library("form_validation");
            $this->form_validation->set_rules("nama_barang", "Pos Barang", "required");
            $this->form_validation->set_message("required", "%s Harus diisi");
            if ($this->form_validation->run() == TRUE):
                $nama_barang = $this->input->post("nama_barang");
                $status = $this->m_panitia->setNamaBarang($id, $nama_barang);
                if ($status):
                    $notif['status'] = "success";
                    $notif['pesan'] = "Ubah Nama Barang berhasil dilakukan";
                else:
                    $notif['status'] = "danger";
                    $notif['pesan'] = "Ubah Nama Barang gagal dilakukan";
                endif;

                $this->session->set_flashdata("notif", $notif);
                redirect("panitia/barang");
            endif;
        endif;
        $content['barang'] = $this->m_panitia->getSingleBarang($id);
        $this->load->view('v_header', $header);
        $this->load->view("panitia/v_menu_panitia", $menu);
        $this->load->view('panitia/admin/barang/v_edit_nama_barang', $content);
        $this->load->view('v_footer');
    }

    public function tambahBarang() {
        $id = str_replace("panitia/barang/tambah/", "", $this->uri->uri_string());
        if ($id != "panitia/barang/tambah"):
            redirect("error/error404");
        endif;
        $id = $this->encrypt->decode($id);
        $header['title'] = 'Tambah Barang';
        $menu = $this->websession->getSession();
        $this->checkAdmin($menu);
        $content = array();
        if ($this->input->server('REQUEST_METHOD') == "POST") :
            $this->load->library("form_validation");
            $this->form_validation->set_rules("nama_barang", "Nama Barang", "required");
            $this->form_validation->set_rules("harga", "Harga Barang", "required|callback__numeric_wcomma|callback__greater_than_wcomma[0]");
            $this->form_validation->set_message("required", "%s Harus diisi");
            if ($this->form_validation->run() == TRUE):
                $nama_barang = $this->input->post("nama_barang");
                $harga_barang = str_replace(",", "", $this->input->post("harga"));
                $status = $this->m_panitia->setNewBarang($nama_barang, $harga_barang);
                if ($status):
                    $notif['status'] = "success";
                    $notif['pesan'] = "Tambah Barang berhasil dilakukan.";
                else:
                    $notif['status'] = "danger";
                    $notif['pesan'] = "Tambah Barang gagal dilakukan.";
                endif;

                $this->session->set_flashdata("notif", $notif);
                redirect("panitia/barang");
            endif;
        endif;
        $this->load->view('v_header', $header);
        $this->load->view("panitia/v_menu_panitia", $menu);
        $this->load->view('panitia/admin/barang/v_add_barang', $content);
        $this->load->view('v_footer');
    }

    // </editor-fold>
    // </editor-fold>
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
