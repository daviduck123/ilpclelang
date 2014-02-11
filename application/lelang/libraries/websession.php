<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class websession {

    public function getSession() {
        $CI = & get_instance();
        $CI->load->library('session');
        $CI->load->model('M_login');
        $data = array();
        if ($CI->session->userdata('jenis_login') == 1):
            $database = $CI->M_login->getDataPeserta($CI->session->userdata('peserta_id'));
            if (empty($database)):
                $CI->session->sess_destroy();
                redirect("login");
            else:
                $data['nama'] = $database['nama'];
                $data['uang'] = $database['jumlahuang'];
            endif;
        elseif ($CI->session->userdata('jenis_login') == 2):
            $database = $CI->M_login->getDataPanitia($CI->session->userdata('panitia_id'));
            $data['nama'] = $database['nama'];
            $data['status'] = $database['status'];
        endif;
        return $data;
    }

}

/* End of file Someclass.php */
?>
