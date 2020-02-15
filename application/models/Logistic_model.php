<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Logistic_model extends CI_Model
{

    //Kelompok edc
    public function getEDCById($id)
    {
        //memanggil query menampilkan semua data menggunalan query builder CI
        return $this->db->get_where('edc', ['nobox' => $id])->row_array();
    }

    public function deleteEDC($id)
    {
        //hapus data ke tabel service point
        $this->db->where('nobox', $id);
        $this->db->delete('edc');
    }

    public function updateBox($id)
    {
        //hapus data ke tabel service point
        $this->db->set('isi', 0);
        $this->db->where('nobox', $id);
        $this->db->update('box');
    }

    public function addHistoriEDCKeluar($id)
    {
        //tampil data edc base on nobox
        $row = $this->db->where('nobox', $id);
        $row = $this->db->get('edc');
        return $row->row_array();

        //ambil data email dari sesion
        $email = $this->session->userdata('email');
        //insert tabel histori edc
        $histori = [
            'snedc' => $row['snedc'],
            'tanggal' => time(),
            'servicepoint' => $row['servicepoint'],
            'action' => "KELUAR",
            'keterangan' => "KELUAR GUDANG",
            'email' => $email

        ];
        $this->db->insert('historiedc', $histori);
    }

    //kelompok histori edc
    public function getHistoriEDC($limit, $start, $keyword = null)
    {
        //menu seching berdasarkan keywoord
        if ($keyword) {
            $this->db->like('snedc', $keyword);
            //$this->db->or_like('email', $keyword);

        }
        return $this->db->get('historiedc', $limit, $start)->result_array();
    }

    public function countAllSP()
    {
        //hitung jumlah all data 
        return $this->db->get('historiedc')->num_rows();
    }

    public function getExcel()
    {
        //query builder tampil service point base on email user
        $email = $this->session->userdata('email'); //ambil data email dari sesion
        $sp = $this->db->get_where('user', ['email' => $email])->row_array(); //ambil data dari tabel user base on email

        //query builder join tabel edc dan box
        $data['edc']  = $this->db->select('*');
        $data['edc']  = $this->db->from('edc');
        $data['edc']  = $this->db->join('box', 'edc.nobox = box.nobox');
        $data['edc']  = $this->db->where('edc.servicepoint', $sp['servicepoint']);
        $data['edc']  = $this->db->get()->result_array();
    }

    //Kelompok dsn
    public function getDSNById($id)
    {
        //memanggil query menampilkan semua data menggunalan query builder CI
        return $this->db->get_where('device', ['id_device' => $id])->row_array();
    }

    //kelompok histori edc
    public function getHistoriDSN($limit, $start, $keyword = null)
    {
        //menu seching berdasarkan keywoord
        if ($keyword) {
            $this->db->like('sndevice', $keyword);
        }
        return $this->db->get('historidevice', $limit, $start)->result_array();
    }

    public function countAllSPDSN()
    {
        //hitung jumlah all data 
        return $this->db->get('historidevice')->num_rows();
    }
}
