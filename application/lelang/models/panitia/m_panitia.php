<?php

/**
 * Description of login_model
 *
 * @author santos sabanari
 */
Class M_panitia extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    // <editor-fold defaultstate="collapsed" desc="Pos">
    public function getPosILPC($idPanitia) {
        $sql = "SELECT pc.id, pc.nama_pos, jp.nama_jenis FROM pos_ilpc pc INNER JOIN panitia_pos pp ON pc.id = pp.pos_ilpc_id INNER JOIN jenis_pos jp ON jp.id = pc.jenis_pos_id WHERE pp.panitia_id = ?";
        $result = $this->db->query($sql, array($idPanitia));
        return $result->result_array();
    }

    public function getTimList($idPanitia, $pos) {
        $sql = "SELECT panitia_id FROM panitia_pos WHERE pos_ilpc_id = ? AND panitia_id = ?";
        $result = $this->db->query($sql, array($pos, $idPanitia));
        $hasil = array();
        if ($result->num_rows() > 0):
            $sql = "SELECT u.id, u.nama, temp.waktu, temp.status FROM user u LEFT JOIN (SELECT hm.user_id, hm.status, hm.waktu FROM history_modal hm WHERE hm.pos_ilpc_id = ?) temp ON u.id = temp.user_id ORDER BY u.id ASC; ";
            $result = $this->db->query($sql, array($pos));
            $hasil = $result->result_array();
        endif;
        return $hasil;
    }

    public function getDetailPos($pos) {
        $sql = "SELECT jp.sertifikat_menang, jp.sertifikat_kalah, jp.uang_menang, jp.uang_kalah FROM pos_ilpc pc INNER JOIN jenis_pos jp ON pc.jenis_pos_id = jp.id WHERE pc.id = ?";
        $result = $this->db->query($sql, array($pos));
        return $result->row_array();
    }

    public function insertHistoryModal($pos_id, $user_id, $status, $reward) {
        $this->db->trans_start();
        $sql = "INSERT INTO history_modal VALUES(?,?,NOW(),?)";
        $result = $this->db->query($sql, array($pos_id, $user_id, $status));
        $sql = "UPDATE user SET jumlahuang = (jumlahuang + ?), jumlahSertifikat = (jumlahSertifikat + ?) WHERE id = ?";
        $result = $this->db->query($sql, array($reward['uang'], $reward['sertifikat'], $user_id));
        $this->setHistoryActivity($this->session->userdata("panitia_id"), "Menambahkan modal untuk peserta $user_id dengan status = $status");
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE):
            return FALSE;
        else:
            return TRUE;
        endif;
    }

    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="Season">
    public function getAllSeason() {
        $hasil = array();
        $sql = "SELECT id,aktif FROM season";
        $result = $this->db->query($sql);
        $hasil['season'] = $result->result_array();
        $sql = "SELECT id FROM season WHERE aktif = '1' OR aktif = '2'";
        $result = $this->db->query($sql);
        $hasil['jalan'] = $result->row_array();
        return $hasil;
    }

    public function getStatusSeason($id) {
        $sql = "SELECT aktif FROM season WHERE id = ?";
        $result = $this->db->query($sql, array($id));
        return $result->row_array();
    }

    public function disabledStatus($id) {
        $sql = "SELECT id FROM season WHERE id <> ? AND (aktif = '1' OR aktif = '2')";
        $result = $this->db->query($sql, array($id));
        return $result->row_array();
    }

    public function setStatusSeason($id, $status) {
        $this->db->trans_start();
        $sql = "UPDATE season SET aktif = ? WHERE id = ?";
        $this->db->query($sql, array($status, $id));
        if($status == '3'):
            $sql = "UPDATE user SET statuslelang = '0'";
            $this->db->query($sql);
        endif;
        $this->db->trans_complete();
        $this->setHistoryActivity($this->session->userdata("panitia_id"), "Mengganti season dengan id = $id, status = $status ");
        if ($this->db->trans_status() === FALSE):
            return FALSE;
        else:
            return TRUE;
        endif;
    }

    // </editor-fold>    
    // <editor-fold defaultstate="collapsed" desc="Customer">
    public function getSemuaCustomer() {
        $sql = "SELECT id, nama_customer FROM customer";
        $result = $this->db->query($sql);
        return $result->result_array();
    }

    public function getSingleCustomer($id) {
        $sql = "SELECT id, nama_customer FROM customer WHERE id = ?";
        $result = $this->db->query($sql, array($id));
        return $result->row_array();
    }

    public function setEditCustomer($id, $name) {
        $this->db->trans_start();
        $sql = "UPDATE customer SET nama_customer = ? WHERE id = ?";
        $this->db->query($sql, array($name, $id));
        $this->db->trans_complete();
        $this->setHistoryActivity($this->session->userdata("panitia_id"), "Mengganti nama customer dari id $id menjadi $name");
        if ($this->db->trans_status() === FALSE):
            return FALSE;
        else:
            return TRUE;
        endif;
    }

    public function getNewIdCustomer() {
        $sql = "SELECT AUTO_INCREMENT as 'id' FROM information_schema.TABLES WHERE table_name='customer' AND table_schema = DATABASE();";
        $result = $this->db->query($sql);
        return $result->row_array();
    }

    public function setAddCustomer($nama) {
        $this->db->trans_start();
        $sql = "INSERT INTO customer (nama_customer) VALUES(?)";
        $this->db->query($sql, array($nama));
        $this->db->trans_complete();
        $this->setHistoryActivity($this->session->userdata("panitia_id"), "Menambahkan customer dengan nama $nama");
        if ($this->db->trans_status() === FALSE):
            return FALSE;
        else:
            return TRUE;
        endif;
    }

    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="Lelang">
    public function getSemuaLelang() {
        $sql = "SELECT lj.id, c.nama_customer, lj.judul_lelang, lj.season_id, lj.status_lelang FROM lelang_jual_customer lj INNER JOIN customer c ON lj.customer_id = c.id ORDER BY lj.season_id ASC;";
        $result = $this->db->query($sql);
        return $result->result_array();
    }

    public function getSingleLelang($id) {
        $hasil = array();
        $sql = "SELECT lj.id, lj.no_lelang, lj.judul_lelang, lj.budget, lj.deskripsi, lj.jumlah, lj.season_id, lj.status_lelang, lj.customer_id, c.nama_customer, lj.nama_barang, lj.status_lelang FROM lelang_jual_customer lj INNER JOIN customer c ON lj.customer_id = c.id WHERE lj.id = ?;";
        $result = $this->db->query($sql, array($id));
        $hasil['lelang'] = $result->row_array();
        $sql = "SELECT b.id, b.nama_barang FROM detail_lelang_jual dj INNER JOIN barang b ON dj.barang_id = b.id WHERE dj.lelang_jual_id = ?;";
        $result = $this->db->query($sql, array($id));
        $hasil['detailLelang'] = $result->result_array();
        return $hasil;
    }

    public function getSemuaBarang() {
        $sql = "SELECT b.id,b.nama_barang, (
                SELECT SUM( stok_user -lock_user) 
                FROM user_barang
                WHERE barang_id = b.id
                ) AS stok
                FROM barang b";
        $result = $this->db->query($sql);
        return $result->result_array();
    }

    public function setEditLelang($data, $id) {
        $this->db->trans_start();
        $sql = "UPDATE lelang_jual_customer SET no_lelang = ?, judul_lelang = ?, budget = ?, deskripsi = ?, jumlah = ?, customer_id = ?, season_id = ?, nama_barang = ? WHERE id = ? AND status_lelang = '0'";
        $this->db->query($sql, array($data['no_lelang'], $data['judul_lelang'], $data['budget'], $data['deskripsi'], $data['jumlah'], $data['customer_id'], $data['season_id'], $data['nama_barang'], $id));
        $sql = "DELETE FROM detail_lelang_jual WHERE lelang_jual_id = ?";
        $this->db->query($sql, array($id));
        $sql = "INSERT INTO detail_lelang_jual VALUES(?,?)";
        foreach ($data['detailbarang'] as $index => $single):
            $this->db->query($sql, array($id, $single));
        endforeach;
        $this->db->trans_complete();
        $this->setHistoryActivity($this->session->userdata("panitia_id"), "Meng-set Lelang yang memiliki id = $id");
        if ($this->db->trans_status() === FALSE):
            return FALSE;
        else:
            return TRUE;
        endif;
    }

    public function setAddLelang($data) {
        $this->db->trans_start();
        $sql = "SELECT AUTO_INCREMENT as 'id' FROM information_schema.TABLES WHERE table_name='lelang_jual_customer' AND table_schema = DATABASE();";
        $result = $this->db->query($sql);
        $id = $result->row_array();
        $sql = "INSERT INTO lelang_jual_customer (no_lelang,judul_lelang,budget,deskripsi,jumlah,customer_id,season_id,nama_barang,status_lelang) VALUES(?,?,?,?,?,?,?,?,'0');";
        $this->db->query($sql, array($data['no_lelang'], $data['judul_lelang'], $data['budget'], $data['deskripsi'], $data['jumlah'], $data['customer_id'], $data['season_id'], $data['nama_barang'], $id));
        $sql = "INSERT INTO detail_lelang_jual VALUES(?,?)";
        foreach ($data['detailbarang'] as $index => $single):
            $this->db->query($sql, array($id['id'], $single));
        endforeach;
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE):
            return FALSE;
        else:
            return TRUE;
        endif;
    }

    public function getPesertaLelang($id) {
        $sql = "SELECT u.nama,  uj.jumlah, uj.status, uj.harga, uj.time, uj.jumlah_terima FROM user_lelang_jual uj INNER JOIN user u ON uj.user_id = u.id WHERE uj.lelang_jual_customer_id = ? ORDER BY uj.status, uj.time ASC";
        $result = $this->db->query($sql, array($id));
        return $result->result_array();
    }

    // </editor-fold>    
    // <editor-fold defaultstate="collapsed" desc="News">
    public function getAllNews() {
        $sql = "SELECT n.berita, n.time, p.nama FROM news n INNER JOIN panitia p ON n.panitia_id = p.id ORDER BY n.time DESC";
        $result = $this->db->query($sql);
        return $result->result_array();
    }

    public function setAddNews($panitia, $news) {
        $this->db->trans_start();
        $sql = "INSERT INTO news (berita,time,panitia_id) VALUES(?,NOW(),?)";
        $this->db->query($sql, array($news, $panitia));
        $this->db->trans_complete();
        $this->setHistoryActivity($this->session->userdata("panitia_id"), "Menambah News oleh panitia = $panitia dan isi = $news ");
        if ($this->db->trans_status() === FALSE):
            return FALSE;
        else:
            return TRUE;
        endif;
    }

    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="peserta">
    public function getAllLoginPeserta() {
        $sql = "SELECT id, nama, status FROM user";
        $result = $this->db->query($sql);
        return $result->result_array();
    }

    public function setEditLoginPeserta($peserta) {
        $this->db->trans_start();
        $sql = "UPDATE user SET status = '0' WHERE id = ? AND status = '1'";
        $this->db->query($sql, array($peserta));
        $this->db->trans_complete();
        $this->setHistoryActivity($this->session->userdata("panitia_id"), "Mengganti status login peserta = $peserta menjadi 0");
        if ($this->db->trans_status() === FALSE):
            return FALSE;
        else:
            return TRUE;
        endif;
    }

    // </editor-fold>    
    // <editor-fold defaultstate="collapsed" desc="Ijin Lelang">
    public function getAllIjinPeserta() {
        $sql = "SELECT id, nama, statuslelang as 'status' FROM user";
        $result = $this->db->query($sql);
        return $result->result_array();
    }

    public function setEditIjinPeserta($peserta) {
        $this->db->trans_start();
        $sql = "UPDATE user SET statuslelang = '1' WHERE id = ? AND statuslelang = '0'";
        $this->db->query($sql, array($peserta));
        $this->db->trans_complete();
        $this->setHistoryActivity($this->session->userdata("panitia_id"), "Mengganti status lelang peserta = $peserta menjadi 1");
        if ($this->db->trans_status() === FALSE):
            return FALSE;
        else:
            return TRUE;
        endif;
    }

    // </editor-fold>    
    // <editor-fold defaultstate="collapsed" desc="chat">
    public function getAllChat() {
        $sql = "SELECT c.chat, c.time, p.nama FROM chat c INNER JOIN panitia p ON c.panitia_id = p.id ORDER BY c.time DESC";
        $result = $this->db->query($sql);
        return $result->result_array();
    }

    public function setAddChat($panitia, $chat) {
        $this->db->trans_start();
        $sql = "INSERT INTO chat (chat,time,panitia_id) VALUES(?,NOW(),?)";
        $this->db->query($sql, array($chat, $panitia));
        $this->db->trans_complete();
        $this->setHistoryActivity($this->session->userdata("panitia_id"), "Menambah Chat baru oleh panitia = $panitia, chat = $chat");
        if ($this->db->trans_status() === FALSE):
            return FALSE;
        else:
            return TRUE;
        endif;
    }

    // </editor-fold>      
    // <editor-fold defaultstate="collapsed" desc="Change Password">
    public function getOldPassword($id, $password) {
        $sql = "SELECT id FROM panitia WHERE id = ? AND password = ?";
        $result = $this->db->query($sql, array($id, $password));
        return $result->row_array();
    }

    public function setNewPassword($id, $password) {
        $this->db->trans_start();
        $sql = "UPDATE panitia SET password = ? WHERE id = ?";
        $this->db->query($sql, array($password, $id));
        $this->db->trans_complete();
        $this->setHistoryActivity($this->session->userdata("panitia_id"), "Mengganti Password panitia = $id menjadi new password = $password");
        if ($this->db->trans_status() === FALSE):
            return FALSE;
        else:
            return TRUE;
        endif;
    }

    // </editor-fold> 
    // <editor-fold defaultstate="collapsed" desc="Super Admin">
    // <editor-fold defaultstate="collapsed" desc="Login Panitia">
    public function getAllPanitia($id) {
        $sql = "SELECT id, username, nama, status FROM panitia WHERE id <> ?";
        $result = $this->db->query($sql, array($id));
        return $result->result_array();
    }

    public function getSinglePanitia($id) {
        $sql = "SELECT id, nama, status FROM panitia WHERE id = ?";
        $result = $this->db->query($sql, array($id));
        return $result->row_array();
    }

    public function checkUsername($username) {
        $sql = "SELECT username FROM panitia WHERE username = ?";
        $result = $this->db->query($sql, array($username));
        return $result->row_array();
    }

    public function setAddDataPanitia($username, $password, $jabatan, $nama) {
        $this->db->trans_start();
        $sql = "INSERT INTO panitia (username, password, status, nama) VALUES(?,?,?,?);";
        $this->db->query($sql, array($username, $password, $jabatan, $nama));
        $this->db->trans_complete();
        $this->setHistoryActivity($this->session->userdata("panitia_id"), "Menambahkan data panitia baru yaitu user : $username, pass : $password, jabatan : $jabatan, nama : $nama");
        if ($this->db->trans_status() === FALSE):
            return FALSE;
        else:
            return TRUE;
        endif;
    }

    public function setEditDataPanitia($id, $nama, $jabatan) {
        $this->db->trans_start();
        $sql = "UPDATE panitia SET nama = ?, status = ? WHERE id = ?";
        $this->db->query($sql, array($nama, $jabatan, $id));
        $this->db->trans_complete();
        $this->setHistoryActivity($this->session->userdata("panitia_id"), "Update data panitia dengan id = $id, set nama = $nama dan jabatan = $jabatan");
        if ($this->db->trans_status() === FALSE):
            return FALSE;
        else:
            return TRUE;
        endif;
    }

    public function setResetPanitia($id, $password) {
        $this->db->trans_start();
        $sql = "UPDATE panitia SET password = ? WHERE id = ?";
        $this->db->query($sql, array($password, $id));
        $this->db->trans_complete();
        $this->setHistoryActivity($this->session->userdata("panitia_id"), "Reset password panitia id = $id, password baru = $password");
        if ($this->db->trans_status() === FALSE):
            return FALSE;
        else:
            return TRUE;
        endif;
    }

    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="Jenis Pos">
    public function getAllJenisPos() {
        $sql = "SELECT id, nama_jenis, sertifikat_menang, sertifikat_kalah, uang_menang, uang_kalah FROM jenis_pos";
        $result = $this->db->query($sql);
        return $result->result_array();
    }

    public function getSingleJenisPos($id) {
        $sql = "SELECT id, nama_jenis, sertifikat_menang, sertifikat_kalah, uang_menang, uang_kalah FROM jenis_pos WHERE id = ?";
        $result = $this->db->query($sql, array($id));
        return $result->row_array();
    }

    public function setAddJenisPos($data) {
        $this->db->trans_start();
        $sql = "INSERT INTO jenis_pos (nama_jenis, sertifikat_menang, sertifikat_kalah, uang_menang, uang_kalah) VALUES(?,?,?,?,?);";
        $this->db->query($sql, array($data['nama'], $data['sertifikat_menang'], $data['sertifikat_kalah'], $data['uang_menang'], $data['uang_kalah']));
        $this->db->trans_complete();
        $this->setHistoryActivity($this->session->userdata("panitia_id"), "Menambahkan Jenis_Pos dengan data nama = " . $data['nama'] . ", sertifikat menang = " . $data['sertifikat_menang'] . ", sertifikat kalah = " . $data['sertifikat_kalah'] . ", uang menang = " . $data['uang_menang'] . ", uang kalah = " . $data['uang_kalah']);
        if ($this->db->trans_status() === FALSE):
            return FALSE;
        else:
            return TRUE;
        endif;
    }

    public function setEditJenisPos($id, $data) {
        $this->db->trans_start();
        $sql = "UPDATE jenis_pos SET nama_jenis = ?, sertifikat_menang = ?, sertifikat_kalah = ?, uang_menang = ?, uang_kalah = ? WHERE id = ?";
        $this->db->query($sql, array($data['nama'], $data['sertifikat_menang'], $data['sertifikat_kalah'], $data['uang_menang'], $data['uang_kalah'], $id));
        $this->db->trans_complete();
        $this->setHistoryActivity($this->session->userdata("panitia_id"), "Mengedit Jenis_Pos yang memiliki id = $id dengan data nama = " . $data['nama'] . ", sertifikat menang = " . $data['sertifikat_menang'] . ", sertifikat kalah = " . $data['sertifikat_kalah'] . ", uang menang = " . $data['uang_menang'] . ", uang kalah = " . $data['uang_kalah']);
        if ($this->db->trans_status() === FALSE):
            return FALSE;
        else:
            return TRUE;
        endif;
    }

    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="Season">
    public function getStatusSessionMenang($id) {
        $sql = "SELECT id FROM season WHERE id = ? AND aktif = '3'";
        $result = $this->db->query($sql, array($id));
        if ($result->num_rows() > 0):
            return TRUE;
        else:
            return FALSE;
        endif;
    }

    public function setPemenang($id) {
        $this->db->trans_start();
        $sql = "CALL P_cari_pemenang($id)";
        $this->db->query($sql, array($id));
        $this->db->trans_complete();
        $this->setHistoryActivity($this->session->userdata("panitia_id"), "Menentukan Pemenang Season dengan id = $id");

        if ($this->db->trans_status() === FALSE):
            return FALSE;
        else:
            return TRUE;
        endif;
    }

    public function setAddSeason() {
        $this->db->trans_start();
        $sql = "INSERT INTO season (aktif) VALUES ('0');";
        $this->db->query($sql);
        $this->db->trans_complete();
        $this->setHistoryActivity($this->session->userdata("panitia_id"), "Menambahkan Season baru");
        if ($this->db->trans_status() === FALSE):
            return FALSE;
        else:
            return TRUE;
        endif;
    }

    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="Pos">
    public function setNewPos($nama, $jenis) {
        $this->db->trans_start();
        $sql = "INSERT INTO pos_ilpc (nama_pos,jenis_pos_id) VALUES(?,?);";
        $this->db->query($sql, array($nama, $jenis));
        $this->db->trans_complete();
        $this->setHistoryActivity($this->session->userdata("panitia_id"), "Menambah Pos baru dengan nama = $nama dan jenis = $jenis");
        if ($this->db->trans_status() === FALSE):
            return FALSE;
        else:
            return TRUE;
        endif;
    }

    public function getAvaiablePos($id) {
        $sql = "SELECT pos_ilpc_id FROM history_modal WHERE pos_ilpc_id = ?;";
        $result = $this->db->query($sql, array($id));
        if ($result->num_rows() == 0):
            return TRUE;
        else:
            return FALSE;
        endif;
    }

    public function getSinglePos($id) {
        $sql = "SELECT id, nama_pos, jenis_pos_id FROM pos_ilpc WHERE id = ?";
        $result = $this->db->query($sql, array($id));
        return $result->row_array();
    }

    public function setEditPos($id, $nama, $jenis) {
        $this->db->trans_start();
        $sql = "UPDATE pos_ilpc SET nama_pos = ?, jenis_pos_id = ? WHERE id = ?";
        $this->db->query($sql, array($nama, $jenis, $id));
        $this->db->trans_complete();
        $this->setHistoryActivity($this->session->userdata("panitia_id"), "Mengedit Pos dengan id = $id, nama = $nama, jenis = $jenis");
        if ($this->db->trans_status() === FALSE):
            return FALSE;
        else:
            return TRUE;
        endif;
    }

    public function setChangePeserta($idpeserta, $idpos) {
        $this->db->trans_start();
        $sql = "SELECT hm.status, jp.sertifikat_menang, jp.sertifikat_kalah, jp.uang_menang, jp.uang_kalah FROM history_modal hm INNER JOIN pos_ilpc pc ON hm.pos_ilpc_id = pc.id INNER JOIN jenis_pos jp ON pc.jenis_pos_id = jp.id WHERE hm.user_id = ? AND hm.pos_ilpc_id = ?;";
        $result = $this->db->query($sql, array($idpeserta, $idpos));
        $cek = $result->row_array();
        $ubahSertifikat = 0;
        $ubahUang = 0;
        if ($cek['status'] == "1"):
            $ubahSertifikat = $cek['sertifikat_menang'];
            $ubahUang = $cek['uang_menang'];
        elseif ($cek['status'] == "2"):
            $ubahSertifikat = $cek['sertifikat_kalah'];
            $ubahUang = $cek['uang_kalah'];
        endif;
        $sql = "UPDATE user SET jumlahuang = (jumlahuang-?), jumlahSertifikat = (jumlahSertifikat-?) WHERE id = ?";
        $this->db->query($sql, array($ubahUang, $ubahSertifikat, $idpeserta));
        $sql = "DELETE FROM history_modal WHERE user_id = ? AND pos_ilpc_id = ?;";
        $this->db->query($sql, array($idpeserta, $idpos));
        $this->db->trans_complete();
        $this->setHistoryActivity($this->session->userdata("panitia_id"), "Menghapus data modal peserta = $idpeserta dan pos = $idpos");
        if ($this->db->trans_status() === FALSE):
            return FALSE;
        else:
            return TRUE;
        endif;
    }

    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="Wewenang Pos">
    public function getAllPanitiaPos() {
        $sql = "SELECT id, nama FROM panitia";
        $result = $this->db->query($sql);
        return $result->result_array();
    }

    public function getSinglePanitiaPos($id) {
        $sql = "SELECT id, nama, status FROM panitia WHERE id = ?";
        $result = $this->db->query($sql, array($id));
        return $result->row_array();
    }

    public function getStatusPanitiaPos($id) {
        $sql = "SELECT jp.nama_jenis, pc.id, pc.nama_pos, temp.panitia_id FROM pos_ilpc pc INNER JOIN jenis_pos jp ON pc.jenis_pos_id = jp.id LEFT JOIN (SELECT pp.pos_ilpc_id, pp.panitia_id FROM panitia_pos pp WHERE pp.panitia_id = ? ) temp ON pc.id = temp.pos_ilpc_id;";
        $result = $this->db->query($sql, array($id));
        return $result->result_array();
    }

    public function setWewenangPanitia($id, $wewenang) {
        $this->db->trans_start();
        $sql = "DELETE FROM panitia_pos WHERE panitia_id = ?";
        $this->db->query($sql, array($id));
        $sql = "INSERT INTO panitia_pos VALUES(?,?)";
        foreach ($wewenang as $index => $single):
            $this->db->query($sql, array($single, $id));
        endforeach;
        $this->db->trans_complete();
        $this->setHistoryActivity($this->session->userdata("panitia_id"), "Meng-set Wewenang Panitia = $id");
        if ($this->db->trans_status() === FALSE):
            return FALSE;
        else:
            return TRUE;
        endif;
    }

    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="Barang">
    public function getAllBarang() {
        $sql = "SELECT id, nama_barang,harga_awal,harga_sekarang FROM barang";
        $result = $this->db->query($sql);
        return $result->result_array();
    }

    public function getSingleBarang($id) {
        $sql = "SELECT id,nama_barang FROM barang WHERE id = ?";
        $result = $this->db->query($sql, array($id));
        return $result->row_array();
    }

    public function setNewBarang($nama_barang, $harga_barang) {
        $this->db->trans_start();
        $sql = "INSERT INTO barang (nama_barang,harga_awal,harga_sekarang,nilai_turun) VALUES(?,?,?,0);";
        $this->db->query($sql, array($nama_barang, $harga_barang, $harga_barang));
        $this->db->trans_complete();
        $this->setHistoryActivity($this->session->userdata("panitia_id"), "Menambah Barang baru dengan nama = $nama_barang dan harga = $harga_barang");
        if ($this->db->trans_status() === FALSE):
            return FALSE;
        else:
            return TRUE;
        endif;
    }

    public function setNamaBarang($id, $nama_barang) {
        $this->db->trans_start();
        $sql = "UPDATE barang SET nama_barang = ? WHERE id = ?";
        $this->db->query($sql, array($nama_barang, $id));
        $this->db->trans_complete();
        $this->setHistoryActivity($this->session->userdata("panitia_id"), "Meng-ubah Barang id = $id Nama Barang = $nama_barang");
        if ($this->db->trans_status() === FALSE):
            return FALSE;
        else:
            return TRUE;
        endif;
    }

    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="Rekap Rally">
    public function getAllSertifikatPeserta() {
        $sql = "SELECT u.nama, u.jumlahSertifikat, (
                SELECT COUNT( * )
                FROM history_modal
                WHERE user_id = u.id
                ) AS jumlahpos, u.jumlahuang
                FROM user U
                ORDER BY u.jumlahSertifikat DESC ";
        $result = $this->db->query($sql);
        return $result->result_array();
    }
    public function getAllUangPeserta() {
        $sql = "SELECT u.nama, (
                SELECT SUM( (jumlah_terima * harga) + (0.3*(jumlah_terima * harga)) )
                FROM user_lelang_jual
                WHERE STATUS = '1'
                AND user_id = u.id
                GROUP BY user_id
                ) AS jumlahlelang, u.jumlahuang
                FROM user u
                ORDER BY jumlahlelang DESC ";
        $result = $this->db->query($sql);
        return $result->result_array();
    }
    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="History Activity Panitia">
    private function setHistoryActivity($user, $activity) {
        $this->db->trans_start();
        $sql = "INSERT INTO history_activity_panitia (time,activity,panitia_id) VALUES(NOW(),?,?);";
        $this->db->query($sql, array($activity, $user));
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE):
            return FALSE;
        else:
            return TRUE;
        endif;
    }

    // </editor-fold>
}

?>
