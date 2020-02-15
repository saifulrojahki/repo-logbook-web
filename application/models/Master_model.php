<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Master_model extends CI_Model
{
    //Kelompok service point
    public function getSPById($id)
    {
        //memanggil query menampilkan semua data menggunalan query builder CI
        return $this->db->get_where('service_point', ['id' => $id])->row_array();
    }

    public function deleteSP($id)
    {
        //hapus data ke tabel service point
        $this->db->where('id', $id);
        $this->db->delete('service_point');
    }

    public function getSP($limit, $start, $keyword = null)
    {
        //menu seching berdasarkan keywoord
        if ($keyword) {
            $this->db->like('servicepoint', $keyword);
            //$this->db->or_like('email', $keyword);

        }
        return $this->db->get('service_point', $limit, $start)->result_array();
    }

    public function countAllSP()
    {
        //hitung jumlah all data 
        return $this->db->get('service_point')->num_rows();
    }


    //Kelompok product
    public function getProductById($id)
    {
        //memanggil query menampilkan semua data menggunalan query builder CI
        return $this->db->get_where('product', ['id' => $id])->row_array();
    }

    public function deleteProduct($id)
    {
        //hapus data ke tabel product
        $this->db->where('id', $id);
        $this->db->delete('product');
    }

    public function getProduct($limit, $start, $keyword = null)
    {
        //menu seching berdasarkan keywoord
        if ($keyword) {
            $this->db->like('product', $keyword);
            //$this->db->or_like('email', $keyword);

        }
        return $this->db->get('product', $limit, $start)->result_array();
    }

    public function countAllProduct()
    {
        //hitung jumlah all data 
        return $this->db->get('product')->num_rows();
    }

    //Kelompok owner
    public function getOwnerById($id)
    {
        //memanggil query menampilkan semua data menggunalan query builder CI
        return $this->db->get_where('owner', ['id' => $id])->row_array();
    }

    public function deleteOwner($id)
    {
        //hapus data ke tabel product
        $this->db->where('id', $id);
        $this->db->delete('owner');
    }

    public function getOwner($limit, $start, $keyword = null)
    {
        //menu seching berdasarkan keywoord
        if ($keyword) {
            $this->db->like('owner', $keyword);
            //$this->db->or_like('email', $keyword);

        }
        return $this->db->get('owner', $limit, $start)->result_array();
    }

    public function countAllOwner()
    {
        //hitung jumlah all data 
        return $this->db->get('owner')->num_rows();
    }

    //Kelompok Customer
    public function getCustomerById($id)
    {
        //memanggil query menampilkan semua data menggunalan query builder CI
        return $this->db->get_where('customer', ['id' => $id])->row_array();
    }

    public function deleteCustomer($id)
    {
        //hapus data ke tabel product
        $this->db->where('id', $id);
        $this->db->delete('customer');
    }

    public function getCustomer($limit, $start, $keyword = null)
    {
        //menu seching berdasarkan keywoord
        if ($keyword) {
            $this->db->like('customer', $keyword);
            //$this->db->or_like('email', $keyword);

        }
        return $this->db->get('customer', $limit, $start)->result_array();
    }

    public function countAllCustomer()
    {
        //hitung jumlah all data 
        return $this->db->get('customer')->num_rows();
    }

    //kelompok member
    public function getMemberById($id)
    {
        //memanggil query menampilkan semua data menggunalan query builder CI
        return $this->db->get_where('member', ['id_sae' => $id])->row_array();
    }

    public function deleteMember($id)
    {
        //hapus data ke tabel product
        $this->db->where('id_sae', $id);
        $this->db->delete('member');
    }
}
