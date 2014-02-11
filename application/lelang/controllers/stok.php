<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Stok extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('peserta/m_peserta');
        if ($this->session->userdata('jenis_login') == 2) {
            redirect('panitia');
        } else if (!$this->session->userdata('jenis_login')) {
            redirect('login');
        }
        $this->load->library('websession');
    }

    public function index() {
        $header['title'] = 'Stok Peserta';
        $menu = $this->websession->getSession();
        $content = array();
        $content['daftarStok'] = $this->m_peserta->getStokUser($this->session->userdata('peserta_id'));
        $content['notif'] = $this->session->flashdata('notif');
        $this->load->view('v_header', $header);
        $this->load->view('v_menu', $menu);
        $this->load->view('peserta/stok/v_stok', $content);
        $this->load->view('v_footer');
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

    public function _less_than_wcomma($value, $bts) {
        $this->form_validation->set_message('_less_than_wcomma', "%s tidak boleh melebihi stok");
        $input = str_replace(",", "", $value);
        return ($input < $bts) ? TRUE : FALSE;
    }

    // <editor-fold defaultstate="collapsed" desc="Buy">
    public function _checkIsi($nilai) {
        $nilai = str_replace(",", "", $nilai);
        return ($nilai != 0) ? TRUE : FALSE;
    }

    public function _checkTotal($nilai, $total) {
        $nilai = str_replace(",", "", $nilai);
        return ($nilai == $total) ? TRUE : FALSE;
    }

    public function _checkUang($nilai, $uang) {
        $nilai = str_replace(",", "", $nilai);
        echo $nilai . "  " . $uang;
        return ($nilai <= $uang) ? TRUE : FALSE;
    }

    public function buy() {
        $header['title'] = 'Beli Stok';
        $menu = $this->websession->getSession();
        $content = array();
        $content['daftarStok'] = $this->m_peserta->getStokUser($this->session->userdata('peserta_id'));
        if ($this->input->server('REQUEST_METHOD') == "POST"):
            $this->load->library('form_validation');
            //hitung data pembeliannya
            $dataHarga = $this->m_peserta->getHargaSekarang();
            $total = 0;
            $dataInput = $this->input->post("jumlah");
            foreach ($dataInput as $index => $single):
                $total += preg_replace("/([^0-9\\.])/i", "", $single) * $dataHarga[$index - 1]['harga_sekarang'];
            endforeach;
            //setting rules
            $this->form_validation->set_rules('jumlah[]', 'Angka Barang', 'required|callback__greater_than_wcomma[-1]|callback__numeric_wcomma');
            $this->form_validation->set_rules('grandTotal', 'Total Beli', "callback__checkIsi|callback__checkTotal[$total]|callback__checkUang[" . $menu['uang'] . "]|callback__numeric_wcomma");
            //setting pesan
            $this->form_validation->set_message('required', "%s harus diisi");
            $this->form_validation->set_message('_checkIsi', "pembelian minimal 1 barang");
            $this->form_validation->set_message('_checkTotal', "Tolong jangan merubah data secara Manual");
            $this->form_validation->set_message('_checkUang', "Uang anda tidak mencukupi");
            //jalankan validasi
            if ($this->form_validation->run() == TRUE) :
                $status = $this->m_peserta->beliBahanBaku($dataInput, $dataHarga, $this->session->userdata('peserta_id'), $total);
                if ($status):
                    $this->session->set_flashdata('notif', array("jenis" => "success", "pesan" => "Pembelian Berhasil dilakukan"));
                else:
                    $this->session->set_flashdata('notif', array("jenis" => "danger", "pesan" => "Pembelian Gagal dilakukan"));
                endif;
                redirect('stok');
            endif;
        endif;
        $this->load->view('v_header', $header);
        $this->load->view('v_menu', $menu);
        $this->load->view('peserta/stok/v_buy', $content);
        $this->load->view('v_footer');
    }

    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="Sell">

    public function sell() {
        $header['title'] = 'Jual Stok';
        $menu = $this->websession->getSession();
        $content = array();
        $content['daftarStok'] = $this->m_peserta->getStokUser($this->session->userdata('peserta_id'));
        if ($this->input->server('REQUEST_METHOD') == "POST"):
            $this->load->library('form_validation');
            //hitung data penjualannya
            $dataHarga = $this->m_peserta->getHargaSekarang();
            $datastok = $content['daftarStok'];
            $total = 0;
            $dataInput = $this->input->post("jumlah");
            //setting rules
            foreach ($dataInput as $index => $single):
                $stokSekarang = ($datastok[$index - 1]['stok_bebas']) ? $datastok[$index - 1]['stok_bebas'] : 0;
                $total += preg_replace("/([^0-9\\.])/i", "", $single) * intval($dataHarga[$index - 1]['harga_sekarang'] * 0.5);
                $this->form_validation->set_rules("jumlah[$index]", "Angka Barang no $index", "required|callback__greater_than_wcomma[-1]|callback__less_than_wcomma[" . ($stokSekarang + 1) . "]|callback__numeric_wcomma");
            endforeach;
            //$this->form_validation->set_rules('grandTotal', 'Total Jual', "callback__checkIsi|callback__checkTotal[$total]|callback__numeric_wcomma");
            //setting pesan
            $this->form_validation->set_message('required', "%s harus diisi");
            $this->form_validation->set_message('_checkIsi', "penjualan minimal 1 barang");
            $this->form_validation->set_message('_checkTotal', "Tolong jangan merubah data secara Manual");
            //jalankan validasi
            if ($this->form_validation->run() == TRUE) :
                $status = $this->m_peserta->jualBahanBaku($dataInput, $dataHarga, $this->session->userdata('peserta_id'), $total);
                if ($status):
                    $this->session->set_flashdata('notif', array("jenis" => "success", "pesan" => "Penjualan Berhasil dilakukan"));
                else:
                    $this->session->set_flashdata('notif', array("jenis" => "danger", "pesan" => "Penjualan Gagal dilakukan"));
                endif;
                redirect('stok');
            endif;
        endif;
        $this->load->view('v_header', $header);
        $this->load->view('v_menu', $menu);
        $this->load->view('peserta/stok/v_sell', $content);
        $this->load->view('v_footer');
    }

    // </editor-fold>
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */