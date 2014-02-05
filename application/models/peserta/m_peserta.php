<?php

class m_peserta extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    // <editor-fold defaultstate="collapsed" desc="Home">    
    public function getNews() {
        $sql = "SELECT berita, time FROM news ORDER BY id DESC";
        $result = $this->db->query($sql);
        return $result->result_array();
    }

    public function getLelangUserStatus($user) {
        $hasil = array();
        $sql = "SELECT id FROM season WHERE aktif > 0";
        $result = $this->db->query($sql);
        $sementara = $result->result_array();
        if (!empty($sementara)):
            foreach ($sementara as $index => $single):
                $hasil[$single['id']]['id'] = $single['id'];
                $hasil[$single['id']]['lelang'] = array();
            endforeach;
            $sql = "SELECT s.id as 'lelangId', lj.id, lj.judul_lelang, uj.status, uj.harga, uj.jumlah, uj.jumlah_terima FROM user_lelang_jual uj INNER JOIN lelang_jual_customer lj ON uj.lelang_jual_customer_id = lj.id INNER JOIN season s ON lj.season_id = s.id WHERE uj.user_id = ? AND s.aktif > 0 ";
            $result = $this->db->query($sql, array($user));
            $sementara = $result->result_array();
            foreach ($sementara as $index => $single):
                $hasil[$single['lelangId']]['lelang'][count($hasil[$single['lelangId']]['lelang'])] = $single;
            endforeach;
        endif;
        return $hasil;
    }

    public function viewDetailLelang($user, $id) {
        $hasil = array();
        $sql = "SELECT lj.id, lj.no_lelang, lj.judul_lelang, lj.budget, lj.deskripsi, lj.jumlah as 'jumlah_kebutuhan', uj.jumlah, uj.jumlah_terima, uj.harga, uj.status, c.nama_customer
                FROM user_lelang_jual uj
                INNER JOIN lelang_jual_customer lj ON uj.lelang_jual_customer_id = lj.id
                INNER JOIN customer c ON lj.customer_id = c.id
                WHERE uj.user_id = ? AND uj.lelang_jual_customer_id = ?;";
        $result = $this->db->query($sql, array($user, $id));
        $hasil['deskripsi'] = $result->row_array();
        $sql = "SELECT b.id, b.nama_barang FROM detail_lelang_jual dj INNER JOIN barang b ON dj.barang_id = b.id WHERE dj.lelang_jual_id = ?";
        $result = $this->db->query($sql, $id);
        $hasil['barang'] = $result->result_array();
        return $hasil;
    }

    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="Stok">  
    public function getStokUser($id) {
        $sql = "SELECT b.id, b.nama_barang, temp.stok_user, temp.lock_user, (temp.stok_user - temp.lock_user) as 'stok_bebas', temp.harga_sekarang as 'harga_user', b.harga_sekarang FROM barang b LEFT JOIN (SELECT * FROM user_barang ub WHERE ub.user_id = ?) temp ON b.id = temp.barang_id;";
        $result = $this->db->query($sql, array($id));
        return $result->result_array();
    }

    public function getHargaSekarang() {
        $sql = "SELECT id, harga_sekarang FROM barang";
        $result = $this->db->query($sql);
        return $result->result_array();
    }

    public function beliBahanBaku($barang, $harga, $user, $grandTotal) {
        $sql = "UPDATE user_barang SET harga_sekarang = ((harga_sekarang * stok_user)+(?*?))/(stok_user + ?), stok_user = (stok_user + ?) WHERE barang_id = ? AND user_id = ?;";
        $sqlhistory = "INSERT INTO history_beli (jam, jumlah, barang_id, user_id, harga, status_beli) VALUES(NOW(),?,?,?,?,'0');";
        $this->db->trans_start();
        foreach ($barang as $index => $single):
            if ($single > 0):
                $single = preg_replace("/([^0-9\\.])/i", "", $single);
                $result = $this->db->query($sql, array($single, $harga[$index - 1]['harga_sekarang'], $single, $single, $index, $user));
                $this->db->query($sqlhistory, array($single, $index, $user, $harga[$index - 1]['harga_sekarang']));
                $this->setHistoryActivity($user, "Membeli Bahan Baku id $index dengan jumlah = $single dan harga = " . $harga[$index - 1]['harga_sekarang']);
            endif;
        endforeach;
        $sql = "UPDATE user SET jumlahuang = (jumlahuang-?) WHERE id = ?";
        $result = $this->db->query($sql, array($grandTotal, $user));
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE):
            return FALSE;
        else:
            return TRUE;
        endif;
    }

    public function jualBahanBaku($barang, $harga, $user, $grandTotal) {
        $sql = "UPDATE user_barang SET stok_user = (stok_user - ?) WHERE barang_id = ? AND user_id = ? ";
        $sqlhistory = "INSERT INTO history_beli (jam, jumlah, barang_id, user_id, harga, status_beli) VALUES(NOW(),?,?,?,?,'1');";
        $this->db->trans_start();
        foreach ($barang as $index => $single):
            if ($single > 0):
                $single = preg_replace("/([^0-9\\.])/i", "", $single);
                $result = $this->db->query($sql, array($single, $index, $user));
                $this->db->query($sqlhistory, array($single, $index, $user, intval($harga[$index - 1]['harga_sekarang'] * 0.5)));
                $this->setHistoryActivity($user, "Menjual Bahan Baku id $index dengan jumlah = $single dan harga = " . $harga[$index - 1]['harga_sekarang']);
            endif;
        endforeach;
        $sql = "UPDATE user SET jumlahuang = (jumlahuang + ?) WHERE id = ?";
        $result = $this->db->query($sql, array($grandTotal, $user));
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE):
            return FALSE;
        else:
            return TRUE;
        endif;
    }

    // </editor-fold>
    // <editor-fold defaultstate="collapsed" desc="Lelang">  
    public function getStatusLelang() {
        $sql = "SELECT aktif FROM season WHERE aktif = '1' OR aktif = '2'";
        $result = $this->db->query($sql);
        return $result->row_array();
    }

    public function getListLelang($user) {
        $sql = "SELECT lj.id, lj.no_lelang, lj.nama_barang, lj.judul_lelang, lj.deskripsi, lj.jumlah, c.nama_customer, temp.time, s.aktif
                FROM lelang_jual_customer lj
                INNER JOIN season s ON lj.season_id = s.id
                INNER JOIN customer c ON lj.customer_id = c.id
                LEFT JOIN (SELECT uj.lelang_jual_customer_id, uj.time FROM user_lelang_jual uj WHERE uj.user_id = ?) temp ON lj.id = temp.lelang_jual_customer_id
                WHERE s.aktif = '1' OR s.aktif = '2';";
        $result = $this->db->query($sql, array($user));
        return $result->result_array();
    }

    public function getDetailLelang($user, $id) {
        $hasil = array();
        $sql = "SELECT lj.id, lj.no_lelang, lj.nama_barang, lj.judul_lelang, lj.deskripsi, lj.jumlah, c.nama_customer, temp.time, s.aktif, lj.budget
                FROM lelang_jual_customer lj
                INNER JOIN season s ON lj.season_id = s.id
                INNER JOIN customer c ON lj.customer_id = c.id
                LEFT JOIN (SELECT uj.lelang_jual_customer_id, uj.time FROM user_lelang_jual uj WHERE uj.user_id = ?) temp ON lj.id = temp.lelang_jual_customer_id
                WHERE s.aktif = '1' OR s.aktif = '2' AND lj.id = ?;";
        $result = $this->db->query($sql, array($user, $id));
        $hasil['deskripsi'] = $result->row_array();
        $sql = "SELECT b.id, b.nama_barang, (ub.stok_user-ub.lock_user) as 'stok', ub.harga_sekarang 
                FROM detail_lelang_jual dj
                INNER JOIN barang b ON dj.barang_id = b.id
                LEFT JOIN (SELECT a.barang_id, a.stok_user, a.lock_user, a.harga_sekarang  from user_barang a WHERE a.user_id = ?) ub ON ub.barang_id = b.id
                WHERE dj.lelang_jual_id = ?; ";
        $result = $this->db->query($sql, array($user, $id));
        $hasil['detailBarang'] = $result->result_array();
        return $hasil;
    }

    public function getLelangDatabase($idLelang) {
        $sql = "SELECT id FROM lelang_jual_customer WHERE id = ?";
        $result = $this->db->query($sql, array($idLelang));
        return $result->row_array();
    }

    public function joinLelang($input, $dataBarang, $user, $idLelang) {
        $sql = "INSERT INTO user_lelang_jual VALUES(?,?,?,0,?,3,NOW())";
        $this->db->trans_start();
        $this->db->query($sql, array($user, $idLelang, $input['jumlah'], $input['harga']));
        $sql = "UPDATE lelang_jual_customer SET status_lelang = '1' WHERE id = ? AND status_lelang = '0'";
        $this->db->query($sql, array($idLelang));
        $sql = "UPDATE user_barang SET lock_user = (lock_user + ?) WHERE user_id = ? AND barang_id = ?";
        foreach ($dataBarang as $index => $single):
            $this->db->query($sql, array($input['jumlah'], $user, $single['id']));
        endforeach;
        $this->setHistoryActivity($user, "Mengikuti Lelang id $idLelang dengan jumlah = " . $input['jumlah'] . " dan harga penawaran = " . $input['harga']);
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE):
            return FALSE;
        else:
            return TRUE;
        endif;
    }

    // </editor-fold>    
    // <editor-fold defaultstate="collapsed" desc="History Activity Peserta">
    private function setHistoryActivity($user, $activity) {
        $this->db->trans_start();
        $sql = "INSERT INTO history_activity_peserta (time,activity,user_id) VALUES(NOW(),?,?);";
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
