<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_model extends CI_Model
{

    public function getRoleById($id)
    {
        //memanggil query menampilkan semua data menggunalan query builder CI
        return $this->db->get_where('user_role', ['id' => $id])->row_array();
    }

    public function deleteRole($id)
    {
        //hapus data ke tabel user_menu
        $this->db->where('id', $id);
        $this->db->delete('user_role');
    }
}
