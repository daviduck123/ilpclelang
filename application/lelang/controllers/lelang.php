<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Lelang extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('peserta/m_peserta');
        if ($this->session->userdata('jenis_login') == 2) {
            redirect('panitia');
        } else if (!$this->session->userdata('jenis_login')) {
            redirect('login');
        }
        $this->load->library('encrypt');
        $this->load->library('websession');
    }

    public function index() {
        $header['title'] = 'Lelang Peserta';
        $menu = $this->websession->getSession();
        $content = array();
        $statusLelang = $this->m_peserta->getStatusLelang();
        $content['notif'] = $this->session->flashdata('notif');
        $content['daftarLelang'] = $this->m_peserta->getListLelang($this->session->userdata('peserta_id'));
        $content['status']["class"] = (empty($statusLelang)) ? "red" : (($statusLelang["aktif"] == '1') ? "blue" : "green");
        $content['status']["pesan"] = (empty($statusLelang)) ? "Sedang Tutup" : (($statusLelang["aktif"] == '1') ? "Pengumuman Pengadaan" : "Pendaftaran Pengadaan");
        //$content['notif'] = $this->session->flashdata('notif');
        $this->load->view('v_header', $header);
        $this->load->view('v_menu', $menu);
        $this->load->view('peserta/lelang/v_lelang', $content);
        $this->load->view('v_footer');
    }

    public function _numeric_wcomma($str) {
        $this->form_validation->set_message('_numeric_wcomma', "%s hanya bisa menerima angka saja");
        return preg_match('/^[0-9,]+$/', $str) ? TRUE : FALSE;
    }

    public function _greater_than_wcomma($value, $bts) {
        $this->form_validation->set_message('_greater_than_wcomma', "%s harus lebih dari $bts");
        $input = str_replace(",", "", $value);
        return ($input > $bts) ? TRUE : FALSE;
    }

    public function _less_than_wcomma($value, $bts) {
        $this->form_validation->set_message('_less_than_wcomma', "%s tidak boleh melebihi stok");
        $input = str_replace(",", "", $value);
        return ($input < $bts) ? TRUE : FALSE;
    }

    public function detail() {
        $id = str_replace("lelang/detail/", "", $this->uri->uri_string());
        if ($id == "lelang/detail"):
            redirect("error/error404");
        endif;
        $id = $this->encrypt->decode($id);
        $header['title'] = 'Detail Lelang';
        $menu = $this->websession->getSession();
        $content = array();
        $statusLelang = $this->m_peserta->getStatusLelang();
        $ijinlelang = $this->m_peserta->getIjinLelang();
        $cekLelangDatabase = $this->m_peserta->getLelangDatabase($id);
        $content = $this->m_peserta->getDetailLelang($this->session->userdata('peserta_id'), $id);
        $content['statusLelang'] = $ijinlelang['statuslelang'];
        $content['status']["class"] = (empty($statusLelang)) ? "red" : (($statusLelang["aktif"] == '1') ? "blue" : "green");
        $content['status']["pesan"] = (empty($statusLelang)) ? "Sedang Tutup" : (($statusLelang["aktif"] == '1') ? "Pengumuman Pengadaan" : "Pendaftaran Pengadaan");
        if (($this->input->server('REQUEST_METHOD') == "POST") && (!empty($cekLelangDatabase))):
            if (($cekLelangDatabase['season_id'] == $statusLelang['id']) && ($statusLelang['aktif'] == "2") && ($ijinlelang['statuslelang'] == "1")):
                $this->load->library('form_validation');
                //cari nilai max lelang
                $max = PHP_INT_MAX;
                foreach ($content['detailBarang'] as $index => $single):
                    $nilai = (isset($single['stok'])) ? $single['stok'] : 0;
                    $max = ($max > $nilai) ? $nilai : $max;
                endforeach;
                $max++;
                //setting rule
                $this->form_validation->set_rules("jumlah", "Jumlah Penawaran", "required|callback__numeric_wcomma|callback__greater_than_wcomma[0]|callback__less_than_wcomma[$max]");
                $this->form_validation->set_rules("harga", "Harga Penawawan", "required|callback_numeric_wcomma|callback_greather_than_wcomma[-1]");
                //setting pesan
                $this->form_validation->set_message('required', "%s harus diisi");
                //jalankan validasi
                if ($this->form_validation->run() == TRUE) :
                    $input['jumlah'] = str_replace(",", "", $this->input->post("jumlah"));
                    $input['harga'] = str_replace(",", "", $this->input->post("harga"));
                    $status = $this->m_peserta->joinLelang($input, $content['detailBarang'], $this->session->userdata("peserta_id"), $id);
                    if ($status):
                        $this->session->set_flashdata('notif', array("jenis" => "success", "pesan" => "Pengikutan Lelang no $id Berhasil dilakukan"));
                    else:
                        $this->session->set_flashdata('notif', array("jenis" => "danger", "pesan" => "Pengikutan Lelang no $id  Gagal dilakukan"));
                    endif;
                    redirect("lelang");
                endif;
            elseif ($statusLelang == "1"):
                $this->session->set_flashdata('notif', array("jenis" => "danger", "pesan" => "Pengikutan Lelang no $id  Gagal karena season $id ditutup"));
                redirect("lelang");
            endif;
        endif;
        $this->load->view('v_header', $header);
        $this->load->view('v_menu', $menu);
        $this->load->view('peserta/lelang/v_join_lelang', $content);
        $this->load->view('v_footer');
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */