<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Competition extends CI_Controller
{

    // construct untuk mengamankan user yang tidak login
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Competition_model');
        is_logged_in();
    }

    //kelompok create competition
    public function create()
    {
        $data['title'] = 'Create SAE Competition';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        //query builder tampil service point base on email user
        $email = $this->session->userdata('email'); //ambil data email dari sesion
        $sp = $this->db->get_where('user', ['email' => $email])->row_array(); //ambil data dari tabel user base on email

        //query builder tampil all tabel bulan
        $data['bulan'] = $this->db->get('bulan')->result_array();

        //query builder tampil all tabel tahun
        $data['tahun'] = $this->db->get('tahun')->result_array();


        //set form validation untuk tiap textbox
        $this->form_validation->set_rules('bulan', 'Bulan', 'required');
        $this->form_validation->set_rules('tahun', 'Tahun', 'required');
        $this->form_validation->set_rules('code', 'Code', 'required|is_unique[competition.code_competition]');

        if ($this->form_validation->run() == false) {

            //memanggil all halaman home jika validasi gagal
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('competition/create', $data);
            $this->load->view('templates/footer');
        } else {

            //insert tabel edc 
            $data = [
                'code_competition' => $this->input->post('code', true),
                'bulan' => $this->input->post('bulan', true),
                'tahun' => $this->input->post('tahun', true),
                'servicepoint' => $sp['servicepoint'],
                'status' => 'SCHEDULED'
            ];
            $this->db->insert('competition', $data);

            //pesan alert berhasil input
            $this->session->set_flashdata('message', 'Add Competition Success');
            redirect('competition/create');
        }
    }

    public function scheduled()
    {
        $data['title'] = 'SAE Competition Sheduled ';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        //query builder tampil service point base on email user
        $email = $this->session->userdata('email'); //ambil data email dari sesion
        $sp = $this->db->get_where('user', ['email' => $email])->row_array(); //ambil data dari tabel user base on email

        //query builder tampil competition sheduled
        $data['competition']  = $this->db->select('*');
        $data['competition']  = $this->db->from('competition');
        $data['competition']  = $this->db->where('servicepoint', $sp['servicepoint']);
        $data['competition']  = $this->db->where('status', 'SCHEDULED');
        $data['competition']  = $this->db->get()->result_array();

        //memanggil all halaman home jika validasi gagal
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('competition/scheduled', $data);
        $this->load->view('templates/footer');
    }

    public function competitionhapus($id)
    {

        $this->Competition_model->deleteCompetition($id);

        $this->session->set_flashdata('message', 'Delete Competition Success');
        redirect('competition/scheduled');
    }

    //kelompok peserta
    public function peserta()
    {
        $data['title'] = 'Participant List';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        //query builder tampil service point base on email user
        $email = $this->session->userdata('email'); //ambil data email dari sesion
        //ambil data dari tabel user base on email
        $sp = $this->db->get_where('user', ['email' => $email])->row_array();

        //query builder join tabel competition dan competition detail
        $data['participant']  = $this->db->select('*');
        $data['participant']  = $this->db->from('competition_detail');
        $data['participant']  = $this->db->join('competition', 'competition_detail.id = competition.id');
        $data['participant']  = $this->db->join('member', 'competition_detail.mip = member.mip');
        $data['participant']  = $this->db->where('competition.id', $this->session->userdata('id'));
        $data['participant']  = $this->db->where('competition.servicepoint', $sp['servicepoint']);
        $data['participant']  = $this->db->where('competition.status', 'SCHEDULED');
        $data['participant']  = $this->db->get()->result_array();

        //query builder tampil member saja
        $data['sae'] = $this->db->get_where('member', ['servicepoint' => $sp['servicepoint']])->result_array();

        //set form validation untuk tiap textbox
        $this->form_validation->set_rules('nama', 'nama', 'required');

        if ($this->form_validation->run() == false) {

            //memanggil all halaman home jika validasi gagal
            $this->load->view('templates/header', $data);
            //$this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('competition/peserta', $data);
            $this->load->view('templates/footer');
        } else {

            //insert tabel edc 
            $data = [
                'id' => $this->session->userdata('id'),
                'mip' => $this->input->post('nama', true),
                'productivity' => 0,
                'pm' => 0,
                'bobot_productivity' => 0,
                'bobot_absen' => 30,
                'bobot_pm' => 30,
                'mis_sla' => 0,
                'reward' => 0,
                'pinalty' => 0,

            ];
            $this->db->insert('competition_detail', $data);

            //pesan alert berhasil input
            $this->session->set_flashdata('message', 'Add Competition Success');
            redirect('competition/peserta');
        }
    }

    //buat session id dan code competition 
    public function bukapesertacode($id)
    {
        //tampilkan tabel competition base on id
        $code = $this->db->get_where('competition', ['id' => $id])->row_array();

        $data = [
            'id' => $code['id'],
            'code_competition' => $code['code_competition']
        ];

        $this->session->set_userdata($data);
        redirect('competition/peserta');
    }

    //hapus session id dan code competition
    public function tutuppersertacode()
    {

        $this->session->unset_userdata('id');
        $this->session->unset_userdata('code_competition');

        redirect('competition/scheduled');
    }


    public function pesertahapus($id)
    {

        $this->Competition_model->deletePeserta($id);

        $this->session->set_flashdata('message', 'Delete Participant Success');
        redirect('competition/peserta');
    }

    //kelompok productivity
    public function productivity()
    {
        $data['title'] = 'SAE Productivity';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        //query builder tampil service point base on email user
        $email = $this->session->userdata('email'); //ambil data email dari sesion
        //ambil data dari tabel user base on email
        $sp = $this->db->get_where('user', ['email' => $email])->row_array();

        //query builder join tabel competition dan competition detail
        $data['participant']  = $this->db->select('*');
        $data['participant']  = $this->db->from('competition_detail');
        $data['participant']  = $this->db->join('competition', 'competition_detail.id = competition.id');
        $data['participant']  = $this->db->join('member', 'competition_detail.mip = member.mip');
        $data['participant']  = $this->db->where('competition.id', $this->session->userdata('id'));
        $data['participant']  = $this->db->where('competition.servicepoint', $sp['servicepoint']);
        $data['participant']  = $this->db->where('competition.status', 'SCHEDULED');
        $data['participant']  = $this->db->get()->result_array();

        //query builder tampil member saja
        $data['sae'] = $this->db->get_where('member', ['servicepoint' => $sp['servicepoint']])->result_array();

        //memanggil all halaman home jika validasi gagal
        $this->load->view('templates/header', $data);
        //$this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('competition/productivity', $data);
        $this->load->view('templates/footer');
    }

    //buat session id dan code competition 
    public function bukaproductivitycode($id)
    {
        //tampilkan tabel competition base on id
        $code = $this->db->get_where('competition', ['id' => $id])->row_array();

        $data = [
            'id' => $code['id'],
            'code_competition' => $code['code_competition']
        ];

        $this->session->set_userdata($data);
        redirect('competition/productivity');
    }

    //hapus session id dan code competition
    public function tutupproductivitycode()
    {

        $this->session->unset_userdata('id');
        $this->session->unset_userdata('code_competition');

        redirect('competition/scheduled');
    }

    public function getProductivityUbah()
    {
        echo json_encode($this->Competition_model->getProductivityById($_POST['id']));
    }

    public function productivityubah()
    {

        //update productivity
        $mip = $this->input->post('mip');
        $productivity = $this->input->post('productivity');

        //hitung bobot
        if ($productivity >= 4900) {
            $bobot = 40;
        } elseif ($productivity >= 4600) {
            $bobot = 30;
        } else {
            $bobot = 20;
        }

        //set update productivity tabel competition_detail
        $this->db->set('productivity', $productivity);
        $this->db->set('bobot_productivity', $bobot);
        $this->db->where('id', $this->session->userdata('id'));
        $this->db->where('mip', $mip);
        $this->db->update('competition_detail');

        //pesan alert berhasil input
        $this->session->set_flashdata('message', 'Update Productivity Success');

        // $this->session->set_flashdata('pesan', 'Di Berhasil di update');
        redirect('competition/productivity');
    }

    //kelompok PM
    public function pm()
    {
        $data['title'] = 'PM Completion Date';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        //query builder tampil service point base on email user
        $email = $this->session->userdata('email'); //ambil data email dari sesion
        //ambil data dari tabel user base on email
        $sp = $this->db->get_where('user', ['email' => $email])->row_array();

        //query builder join tabel competition dan competition detail
        $data['participant']  = $this->db->select('*');
        $data['participant']  = $this->db->from('competition_detail');
        $data['participant']  = $this->db->join('competition', 'competition_detail.id = competition.id');
        $data['participant']  = $this->db->join('member', 'competition_detail.mip = member.mip');
        $data['participant']  = $this->db->where('competition.id', $this->session->userdata('id'));
        $data['participant']  = $this->db->where('competition.servicepoint', $sp['servicepoint']);
        $data['participant']  = $this->db->where('competition.status', 'SCHEDULED');
        $data['participant']  = $this->db->get()->result_array();

        //query builder tampil member saja
        $data['sae'] = $this->db->get_where('member', ['servicepoint' => $sp['servicepoint']])->result_array();

        //memanggil all halaman home jika validasi gagal
        $this->load->view('templates/header', $data);
        //$this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('competition/pm', $data);
        $this->load->view('templates/footer');
    }

    //buat session id dan code competition 
    public function bukapmcode($id)
    {
        //tampilkan tabel competition base on id
        $code = $this->db->get_where('competition', ['id' => $id])->row_array();

        $data = [
            'id' => $code['id'],
            'code_competition' => $code['code_competition']
        ];

        $this->session->set_userdata($data);
        redirect('competition/pm');
    }

    //hapus session id dan code competition
    public function tutupmcode()
    {

        $this->session->unset_userdata('id');
        $this->session->unset_userdata('code_competition');

        redirect('competition/scheduled');
    }

    public function getPMUbah()
    {
        echo json_encode($this->Competition_model->getPMById($_POST['id']));
    }

    public function pmubah()
    {

        //update pm
        $mip = $this->input->post('mip');
        $pm = $this->input->post('pm');

        //hitung bobot pm
        if ($pm >= 31) {
            $bobot = 24;
        } elseif ($pm == 30) {
            $bobot = 25;
        } elseif ($pm == 29) {
            $bobot = 26;
        } elseif ($pm == 28) {
            $bobot = 27;
        } elseif ($pm == 27) {
            $bobot = 28;
        } elseif ($pm == 26) {
            $bobot = 29;
        } else {
            $bobot = 30;
        }

        //set update pm tabel competition_detail
        $this->db->set('pm', $pm);
        $this->db->set('bobot_pm', $bobot);
        $this->db->where('id', $this->session->userdata('id'));
        $this->db->where('mip', $mip);
        $this->db->update('competition_detail');

        //pesan alert berhasil input
        $this->session->set_flashdata('message', 'Update PM Completion Date Success');

        // $this->session->set_flashdata('pesan', 'Di Berhasil di update');
        redirect('competition/pm');
    }

    //kelompok absen
    public function absen()
    {
        $data['title'] = 'Miss SLA Absent';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        //query builder tampil service point base on email user
        $email = $this->session->userdata('email'); //ambil data email dari sesion

        //ambil data dari tabel user base on email
        $sp = $this->db->get_where('user', ['email' => $email])->row_array();

        //query builder join tabel competition dan competition detail
        $data['participant']  = $this->db->select('*');
        $data['participant']  = $this->db->from('competition_detail');
        $data['participant']  = $this->db->join('competition', 'competition_detail.id = competition.id');
        $data['participant']  = $this->db->join('member', 'competition_detail.mip = member.mip');
        $data['participant']  = $this->db->join('absen', 'competition_detail.mip = absen.mip');
        $data['participant']  = $this->db->where('competition.id', $this->session->userdata('id'));
        $data['participant']  = $this->db->where('competition.servicepoint', $sp['servicepoint']);
        $data['participant']  = $this->db->where('competition.status', 'SCHEDULED');
        $data['participant']  = $this->db->where('absen.id', $this->session->userdata('id'));
        $data['participant']  = $this->db->get()->result_array();

        //query builder tampil member saja
        //$data['sae'] = $this->db->get_where('member', ['servicepoint' => $sp['servicepoint']])->result_array();
        $data['sae']  = $this->db->select('*');
        $data['sae']  = $this->db->from('competition_detail');
        $data['sae']  = $this->db->join('member', 'competition_detail.mip = member.mip');
        $data['sae']  = $this->db->where('competition_detail.id', $this->session->userdata('id'));
        $data['sae']  = $this->db->get()->result_array();

        //set form validation untuk tiap textbox
        $this->form_validation->set_rules('nama', 'nama', 'required');
        $this->form_validation->set_rules('remark', 'Remark', 'required');

        if ($this->form_validation->run() == false) {

            //memanggil all halaman home jika validasi gagal
            $this->load->view('templates/header', $data);
            //$this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('competition/absen', $data);
            $this->load->view('templates/footer');
        } else {

            //insert tabel edc 
            $data = [
                'id' => $this->session->userdata('id'),
                'mip' => $this->input->post('nama', true),
                'keterangan' => htmlspecialchars($this->input->post('remark', true))

            ];
            $this->db->insert('absen', $data);

            //kurangi nilai di bobot absen di tabel competition_detail
            $mip = $this->input->post('nama');
            // join tabel competition detail dan absen
            $nilai  = $this->db->select('*');
            $nilai  = $this->db->from('competition_detail');
            $nilai  = $this->db->join('absen', 'competition_detail.mip = absen.mip');
            $nilai  = $this->db->where('competition_detail.id', $this->session->userdata('id'));
            $nilai  = $this->db->where('competition_detail.mip', $mip);
            $nilai  = $this->db->get()->row_array();
            // hitung bobot absen di kurangi 1
            $bobot_absen = $nilai['bobot_absen'];
            $i = 1;
            $hasil = $bobot_absen - $i;

            $this->db->set('bobot_absen', $hasil);
            $this->db->where('id', $nilai['id']);
            $this->db->where('mip', $mip);
            $this->db->update('competition_detail');

            //pesan alert berhasil input
            $this->session->set_flashdata('message', 'Add Mis SLA Absent Success');
            redirect('competition/absen');
        }
    }

    //buat session id dan code competition 
    public function bukaabsencode($id)
    {
        //tampilkan tabel competition base on id
        $code = $this->db->get_where('competition', ['id' => $id])->row_array();

        $data = [
            'id' => $code['id'],
            'code_competition' => $code['code_competition']
        ];

        $this->session->set_userdata($data);
        redirect('competition/absen');
    }

    //hapus session id dan code competition
    public function tutupabsencode()
    {

        $this->session->unset_userdata('id');
        $this->session->unset_userdata('code_competition');

        redirect('competition/scheduled');
    }

    public function getAbsenUbah()
    {
        echo json_encode($this->Competition_model->getAbsenById($_POST['id']));
    }

    public function absenubah()
    {

        $id = $this->input->post('id_absen');
        $nama = $this->input->post('nama');
        $remark = htmlspecialchars(($this->input->post('remark', true)));

        $this->db->set('mip', $nama);
        $this->db->set('keterangan', $remark);
        $this->db->where('id_absen', $id);
        $this->db->update('absen');

        //pesan alert berhasil input
        $this->session->set_flashdata('message', 'Update Mis SLA  Success');

        // $this->session->set_flashdata('pesan', 'Di Berhasil di update');
        redirect('competition/absen');
    }

    public function absenhapus($id)
    {
        //tampilkan mip dari tabel absen
        $absen = $this->db->get_where('absen', ['id_absen' => $id])->row_array();
        $mip = $absen['mip'];

        // join tabel competition detail dan absen
        $nilai  = $this->db->select('*');
        $nilai  = $this->db->from('competition_detail');
        $nilai  = $this->db->join('absen', 'competition_detail.mip = absen.mip');
        $nilai  = $this->db->where('competition_detail.id', $this->session->userdata('id'));
        $nilai  = $this->db->where('competition_detail.mip', $mip);
        $nilai  = $this->db->get()->row_array();

        // hitung bobot absen di tambah 1
        $bobot_absen = $nilai['bobot_absen'];
        $i = 1;
        $hasil = $bobot_absen + $i;

        $this->db->set('bobot_absen', $hasil);
        $this->db->where('id', $nilai['id']);
        $this->db->where('mip', $mip);
        $this->db->update('competition_detail');

        //hapus data dari tabel absen
        $this->Competition_model->deleteAbsen($id);

        $this->session->set_flashdata('message', 'Delete Mis SLA Absent Success');
        redirect('competition/absen');
    }

    //kelompok SLA
    public function sla()
    {
        $data['title'] = 'Miss SLA WO / JO';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        //query builder tampil service point base on email user
        $email = $this->session->userdata('email'); //ambil data email dari sesion

        //ambil data dari tabel user base on email
        $sp = $this->db->get_where('user', ['email' => $email])->row_array();

        //query builder join tabel competition dan competition detail
        $data['participant']  = $this->db->select('*');
        $data['participant']  = $this->db->from('competition_detail');
        $data['participant']  = $this->db->join('competition', 'competition_detail.id = competition.id');
        $data['participant']  = $this->db->join('member', 'competition_detail.mip = member.mip');
        $data['participant']  = $this->db->join('sla', 'competition_detail.mip = sla.mip');
        $data['participant']  = $this->db->where('competition.id', $this->session->userdata('id'));
        $data['participant']  = $this->db->where('competition.servicepoint', $sp['servicepoint']);
        $data['participant']  = $this->db->where('competition.status', 'SCHEDULED');
        $data['participant']  = $this->db->where('sla.id', $this->session->userdata('id'));
        $data['participant']  = $this->db->get()->result_array();

        //query builder tampil member saja
        //$data['sae'] = $this->db->get_where('member', ['servicepoint' => $sp['servicepoint']])->result_array();
        $data['sae']  = $this->db->select('*');
        $data['sae']  = $this->db->from('competition_detail');
        $data['sae']  = $this->db->join('member', 'competition_detail.mip = member.mip');
        $data['sae']  = $this->db->where('competition_detail.id', $this->session->userdata('id'));
        $data['sae']  = $this->db->get()->result_array();

        //set form validation untuk tiap textbox
        $this->form_validation->set_rules('nama', 'nama', 'required');
        $this->form_validation->set_rules('remark', 'Remark', 'required');

        if ($this->form_validation->run() == false) {

            //memanggil all halaman home jika validasi gagal
            $this->load->view('templates/header', $data);
            //$this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('competition/sla', $data);
            $this->load->view('templates/footer');
        } else {

            //insert tabel edc 
            $data = [
                'id' => $this->session->userdata('id'),
                'mip' => $this->input->post('nama', true),
                'keterangan' => htmlspecialchars($this->input->post('remark', true))

            ];
            $this->db->insert('sla', $data);

            //kurangi nilai di bobot sla di tabel competition_detail
            $mip = $this->input->post('nama');
            // join tabel competition detail dan absen
            $nilai  = $this->db->select('*');
            $nilai  = $this->db->from('competition_detail');
            $nilai  = $this->db->join('sla', 'competition_detail.mip = sla.mip');
            $nilai  = $this->db->where('competition_detail.id', $this->session->userdata('id'));
            $nilai  = $this->db->where('competition_detail.mip', $mip);
            $nilai  = $this->db->get()->row_array();
            // hitung bobot absen di kurangi 1
            $bobot_absen = $nilai['mis_sla'];
            $i = 1;
            $hasil = $bobot_absen + $i;

            $this->db->set('mis_sla', $hasil);
            $this->db->where('id', $nilai['id']);
            $this->db->where('mip', $mip);
            $this->db->update('competition_detail');

            //pesan alert berhasil input
            $this->session->set_flashdata('message', 'Add Mis SLA Success');
            redirect('competition/sla');
        }
    }

    //buat session id dan code competition 
    public function bukaslacode($id)
    {
        //tampilkan tabel competition base on id
        $code = $this->db->get_where('competition', ['id' => $id])->row_array();

        $data = [
            'id' => $code['id'],
            'code_competition' => $code['code_competition']
        ];

        $this->session->set_userdata($data);
        redirect('competition/sla');
    }

    //hapus session id dan code competition
    public function tutupslacode()
    {

        $this->session->unset_userdata('id');
        $this->session->unset_userdata('code_competition');

        redirect('competition/scheduled');
    }

    public function slahapus($id)
    {
        //tampilkan mip dari tabel absen
        $sla = $this->db->get_where('sla', ['id_sla' => $id])->row_array();
        $mip = $sla['mip'];

        // join tabel competition detail dan absen
        $nilai  = $this->db->select('*');
        $nilai  = $this->db->from('competition_detail');
        $nilai  = $this->db->join('sla', 'competition_detail.mip = sla.mip');
        $nilai  = $this->db->where('competition_detail.id', $this->session->userdata('id'));
        $nilai  = $this->db->where('competition_detail.mip', $mip);
        $nilai  = $this->db->get()->row_array();

        // hitung bobot absen di tambah 1
        $bobot_absen = $nilai['mis_sla'];
        $i = 1;
        $hasil = $bobot_absen - $i;

        $this->db->set('mis_sla', $hasil);
        $this->db->where('id', $nilai['id']);
        $this->db->where('mip', $mip);
        $this->db->update('competition_detail');

        //hapus data dari tabel absen
        $this->Competition_model->deleteSLA($id);

        $this->session->set_flashdata('message', 'Delete Mis SLA Success');
        redirect('competition/sla');
    }

    public function getSLAUbah()
    {
        echo json_encode($this->Competition_model->getSLAById($_POST['id']));
    }

    public function slaubah()
    {

        $id = $this->input->post('id_sla');
        $nama = $this->input->post('nama');
        $remark = htmlspecialchars(($this->input->post('remark', true)));

        $this->db->set('mip', $nama);
        $this->db->set('keterangan', $remark);
        $this->db->where('id_sla', $id);
        $this->db->update('sla');

        //pesan alert berhasil input
        $this->session->set_flashdata('message', 'Update Mis SLA Success');

        // $this->session->set_flashdata('pesan', 'Di Berhasil di update');
        redirect('competition/sla');
    }

    //kelompok reward
    public function reward()
    {
        $data['title'] = 'Reward or Pinalty';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        //query builder tampil service point base on email user
        $email = $this->session->userdata('email'); //ambil data email dari sesion

        //ambil data dari tabel user base on email
        $sp = $this->db->get_where('user', ['email' => $email])->row_array();

        //query builder join tabel competition dan competition detail
        $data['participant']  = $this->db->select('*');
        $data['participant']  = $this->db->from('competition_detail');
        $data['participant']  = $this->db->join('competition', 'competition_detail.id = competition.id');
        $data['participant']  = $this->db->join('member', 'competition_detail.mip = member.mip');
        $data['participant']  = $this->db->join('reward', 'competition_detail.mip = reward.mip');
        $data['participant']  = $this->db->where('competition.id', $this->session->userdata('id'));
        $data['participant']  = $this->db->where('competition.servicepoint', $sp['servicepoint']);
        $data['participant']  = $this->db->where('competition.status', 'SCHEDULED');
        $data['participant']  = $this->db->where('reward.id', $this->session->userdata('id'));
        $data['participant']  = $this->db->get()->result_array();

        //query builder tampil member saja
        //$data['sae'] = $this->db->get_where('member', ['servicepoint' => $sp['servicepoint']])->result_array();
        $data['sae']  = $this->db->select('*');
        $data['sae']  = $this->db->from('competition_detail');
        $data['sae']  = $this->db->join('member', 'competition_detail.mip = member.mip');
        $data['sae']  = $this->db->where('competition_detail.id', $this->session->userdata('id'));
        $data['sae']  = $this->db->get()->result_array();

        //set form validation untuk tiap textbox
        $this->form_validation->set_rules('nama', 'nama', 'required');
        $this->form_validation->set_rules('remark', 'Remark', 'required');

        if ($this->form_validation->run() == false) {

            //memanggil all halaman home jika validasi gagal
            $this->load->view('templates/header', $data);
            //$this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('competition/reward', $data);
            $this->load->view('templates/footer');
        } else {

            //insert tabel edc 
            $data = [
                'id' => $this->session->userdata('id'),
                'mip' => $this->input->post('nama', true),
                'kategori' => $this->input->post('kategori', true),
                'keterangan' => htmlspecialchars($this->input->post('remark', true))

            ];
            $this->db->insert('reward', $data);

            //kurangi nilai di bobot sla di tabel competition_detail
            $mip = $this->input->post('nama');
            $kategori = $this->input->post('kategori');

            // join tabel competition detail dan absen
            $nilai  = $this->db->select('*');
            $nilai  = $this->db->from('competition_detail');
            $nilai  = $this->db->join('reward', 'competition_detail.mip = reward.mip');
            $nilai  = $this->db->where('competition_detail.id', $this->session->userdata('id'));
            $nilai  = $this->db->where('competition_detail.mip', $mip);
            $nilai  = $this->db->get()->row_array();

            // hitung bobot reward atau pinlaty
            $bobot_reward = $nilai['reward'];
            $bobot_pinalty = $nilai['pinalty'];
            $i = 1;

            if ($kategori == "REWARD") {

                $hasil = $bobot_reward + $i;
                $this->db->set('reward', $hasil);
                $this->db->where('id', $nilai['id']);
                $this->db->where('mip', $mip);
                $this->db->update('competition_detail');
            } else {

                $hasil = $bobot_pinalty + $i;
                $this->db->set('pinalty', $hasil);
                $this->db->where('id', $nilai['id']);
                $this->db->where('mip', $mip);
                $this->db->update('competition_detail');
            }

            //pesan alert berhasil input
            $this->session->set_flashdata('message', 'Add Reward or Pinalty Success');
            redirect('competition/reward');
        }
    }

    //buat session id dan code competition 
    public function bukarewardcode($id)
    {
        //tampilkan tabel competition base on id
        $code = $this->db->get_where('competition', ['id' => $id])->row_array();

        $data = [
            'id' => $code['id'],
            'code_competition' => $code['code_competition']
        ];

        $this->session->set_userdata($data);
        redirect('competition/reward');
    }

    //hapus session id dan code competition
    public function tutupRewardcode()
    {

        $this->session->unset_userdata('id');
        $this->session->unset_userdata('code_competition');

        redirect('competition/scheduled');
    }

    public function rewardhapus($id)
    {
        //tampilkan mip dari tabel reward
        $reward = $this->db->get_where('reward', ['id_reward' => $id])->row_array();
        $mip = $reward['mip'];

        // join tabel competition detail dan absen
        $nilai  = $this->db->select('*');
        $nilai  = $this->db->from('competition_detail');
        $nilai  = $this->db->join('reward', 'competition_detail.mip = reward.mip');
        $nilai  = $this->db->where('competition_detail.id', $this->session->userdata('id'));
        $nilai  = $this->db->where('competition_detail.mip', $mip);
        $nilai  = $this->db->get()->row_array();

        // kurangi bobot reward atau pinlaty
        $kategori = $nilai['kategori'];
        $bobot_reward = $nilai['reward'];
        $bobot_pinalty = $nilai['pinalty'];
        $i = 1;

        if ($kategori == "REWARD") {

            $hasil = $bobot_reward - $i;
            $this->db->set('reward', $hasil);
            $this->db->where('id', $nilai['id']);
            $this->db->where('mip', $mip);
            $this->db->update('competition_detail');
        } else {

            $hasil = $bobot_pinalty - $i;
            $this->db->set('pinalty', $hasil);
            $this->db->where('id', $nilai['id']);
            $this->db->where('mip', $mip);
            $this->db->update('competition_detail');
        }

        //hapus data dari tabel absen
        $this->Competition_model->deleteReward($id);

        $this->session->set_flashdata('message', 'Delete Reward or Pinalty Success');
        redirect('competition/reward');
    }

    //darboard peringkat
    public function dashboard()
    {
        $data['title'] = 'Dashboard SAE Competition ';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        //query builder tampil service point base on email user
        $email = $this->session->userdata('email'); //ambil data email dari sesion
        $sp = $this->db->get_where('user', ['email' => $email])->row_array(); //ambil data dari tabel user base on email

        //query builder tampil competition sheduled
        $data['competition']  = $this->db->select('*');
        $data['competition']  = $this->db->from('competition');
        $data['competition']  = $this->db->where('servicepoint', $sp['servicepoint']);
        //$data['competition']  = $this->db->where('status', 'SCHEDULED');
        $data['competition']  = $this->db->get()->result_array();

        //memanggil all halaman home jika validasi gagal
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('competition/dashboard', $data);
        $this->load->view('templates/footer');
    }

    //buat session id dan code competition 
    public function bukarankingcode()
    {
        $id = $this->input->post('competition');
        //tampilkan tabel competition base on id
        $code = $this->db->get_where('competition', ['id' => $id])->row_array();

        $data = [
            'id' => $code['id'],
            'code_competition' => $code['code_competition']
        ];

        $this->session->set_userdata($data);
        redirect('competition/ranking');
    }

    //hapus session id dan code competition
    public function tutuprankingcode()
    {

        $this->session->unset_userdata('id');
        $this->session->unset_userdata('code_competition');

        redirect('competition/dashboard');
    }

    public function ranking()
    {
        $data['title'] = 'Ranking SAE Competition ';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        //query builder tampil service point base on email user
        $email = $this->session->userdata('email'); //ambil data email dari sesion
        $sp = $this->db->get_where('user', ['email' => $email])->row_array(); //ambil data dari tabel user base on email

        //query builder join tabel competition dan competition detail
        $data['competition']  = $this->db->select('*');
        $data['competition']  = $this->db->select('(competition_detail.bobot_productivity + competition_detail.bobot_absen + competition_detail.bobot_pm) - mis_sla + reward - pinalty as total');
        $data['competition']  = $this->db->from('competition_detail');
        $data['competition']  = $this->db->join('competition', 'competition_detail.id = competition.id');
        $data['competition']  = $this->db->join('member', 'competition_detail.mip = member.mip');
        $data['competition']  = $this->db->where('competition.id', $this->session->userdata('id'));
        $data['competition']  = $this->db->where('competition.servicepoint', $sp['servicepoint']);
        $data['competition']  = $this->db->order_by('total', 'DESC');
        $data['competition']  = $this->db->order_by('competition_detail.productivity', 'DESC');
        $data['competition']  = $this->db->get()->result_array();

        //query builder tampil gambar member nilai total tertinggi
        $data['gambar']   = $this->db->select('*');
        $data['gambar']   = $this->db->select('(competition_detail.bobot_productivity + competition_detail.bobot_absen + competition_detail.bobot_pm) - mis_sla + reward - pinalty as total');
        $data['gambar']   = $this->db->from('competition_detail');
        $data['gambar']   = $this->db->join('competition', 'competition_detail.id = competition.id');
        $data['gambar']   = $this->db->join('member', 'competition_detail.mip = member.mip');
        $data['gambar']  = $this->db->where('competition.id', $this->session->userdata('id'));
        $data['gambar']   = $this->db->where('competition.servicepoint', $sp['servicepoint']);
        $data['gambar']   = $this->db->order_by('total', 'DESC');
        $data['gambar']   = $this->db->order_by('competition_detail.productivity', 'DESC');
        $data['gambar']   = $this->db->get()->row_array();
        //var_dump($image);
        //die;

        //hitung grand total
        $nilai = $this->db->select('*');
        $nilai = $this->db->from('competition_detail');
        $nilai = $this->db->join('competition', 'competition_detail.id = competition.id');
        $nilai = $this->db->join('member', 'competition_detail.mip = member.mip');
        $nilai = $this->db->where('competition.id', $this->session->userdata('id'));
        $nilai = $this->db->where('competition.servicepoint', $sp['servicepoint']);
        $nilai = $this->db->get()->row_array();

        //var_dump($nilai);
        //die;
        $productivity = $nilai['bobot_productivity'];
        $absen = $nilai['bobot_absen'];
        $pm = $nilai['bobot_pm'];
        $sla = $nilai['mis_sla'];
        $reward = $nilai['reward'];
        $pinalty = $nilai['pinalty'];

        $data['total'] = ($productivity + $absen + $pm) - $sla + $reward - $pinalty;


        //memanggil all halaman home jika validasi gagal
        $this->load->view('templates/header', $data);
        //$this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('competition/ranking', $data);
        $this->load->view('templates/footer');
    }

    //update closed competition
    public function closed($id)
    {

        //update status closed tabel competition
        $this->db->set('status', 'CLOSED');
        $this->db->where('id', $id);
        $this->db->update('competition');

        //pesan alert berhasil input
        $this->session->set_flashdata('message', 'Closed Competition Success');
        redirect('competition/scheduled');
    }
}
