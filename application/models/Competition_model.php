<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Competition_model extends CI_Model
{
    //Kelompok competition
    public function getComById($id)
    {
        //memanggil query menampilkan semua data menggunalan query builder CI
        return $this->db->get_where('competition', ['id' => $id])->row_array();
    }

    public function deleteCompetition($id)
    {
        //hapus data ke tabel service point
        $this->db->where('id', $id);
        $this->db->delete('competition');
    }

    //Kelompok peserta
    public function deletePeserta($id)
    {
        //hapus data ke tabel service point
        $this->db->where('mip', $id);
        $this->db->delete('competition_detail');
    }

    //kelompok productivity
    public function getProductivityById($id)
    {
        //memanggil query menampilkan semua data menggunalan query builder CI
        return $this->db->get_where('competition_detail', ['mip' => $id])->row_array();
    }

    //kelompok pm
    public function getPMById($id)
    {
        //memanggil query menampilkan semua data menggunalan query builder CI
        return $this->db->get_where('competition_detail', ['mip' => $id])->row_array();
    }

    //kelompok absen
    public function getAbsenById($id)
    {
        //memanggil query menampilkan semua data menggunalan query builder CI
        return $this->db->get_where('absen', ['id_absen' => $id])->row_array();
    }

    public function deleteAbsen($id)
    {
        //hapus data ke tabel service point
        $this->db->where('id_absen', $id);
        $this->db->delete('absen');
    }

    //kelompok sla
    public function getSLAById($id)
    {
        //memanggil query menampilkan semua data menggunalan query builder CI
        return $this->db->get_where('sla', ['id_sla' => $id])->row_array();
    }

    public function deleteSLA($id)
    {
        //hapus data ke tabel service point
        $this->db->where('id_sla', $id);
        $this->db->delete('sla');
    }

    //kelompok reward
    public function getRewardById($id)
    {
        //memanggil query menampilkan semua data menggunalan query builder CI
        return $this->db->get_where('reward', ['id_reward' => $id])->row_array();
    }

    public function deleteReward($id)
    {
        //hapus data ke tabel service point
        $this->db->where('id_reward', $id);
        $this->db->delete('reward');
    }
}
