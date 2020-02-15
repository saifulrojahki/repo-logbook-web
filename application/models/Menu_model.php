<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu_model extends CI_Model
{
    //Kelompok Menu
    public function getMenuById($id)
    {
        //memanggil query menampilkan semua data menggunalan query builder CI
        return $this->db->get_where('user_menu', ['id' => $id])->row_array();
    }


    public function deleteMenu($id)
    {
        //hapus data ke tabel user_menu
        $this->db->where('id', $id);
        $this->db->delete('user_menu');
    }

    //Kelompok Submenu
    public function getSubMenu()
    {

        $query = "SELECT user_sub_menu.*, user_menu.menu
                    FROM user_sub_menu JOIN user_menu
                        ON user_sub_menu.menu_id = user_menu.id
                    ";

        return $this->db->query($query)->result_array();
    }

    public function deleteSubMenu($id)
    {
        //hapus data ke tabel user_sub_menu
        $this->db->where('id', $id);
        $this->db->delete('user_sub_menu');
    }

    public function getSubMenuById($id)
    {
        //memanggil query menampilkan semua data menggunalan query builder CI
        return $this->db->get_where('user_sub_menu', ['id' => $id])->row_array();
    }
}
