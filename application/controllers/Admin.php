<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    // construct untuk mengamankan user yang tidak login
    public function __construct()
    {
        parent::__construct();
        //$this->load->model('Admin_model');
        $this->load->model('Admin_model');
        is_logged_in(); //memanggil helper cek login
    }


    public function index()
    {
        $data['title'] = 'Dasboard';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        //memanggil all halaman home
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/index', $data);
        $this->load->view('templates/footer');
    }

    public function role()
    {
        $data['title'] = 'Role';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['role'] = $this->db->get('user_role')->result_array();

        $this->form_validation->set_rules('role', 'Role', 'required');

        if ($this->form_validation->run() == false) {
            //memanggil all halaman home
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/role', $data);
            $this->load->view('templates/footer');
        } else {
            $this->db->insert('user_role', ['role' => $this->input->post('role')]);
            //pesan alert berhasil input
            // $this->session->set_flashdata('message', '<div class="alert alert-succees" role="alert">
            //New Role Added!
            //</div>');
            $this->session->set_flashdata('message', 'Add Role Success');
            redirect('admin/role');
        }
    }

    public function roleaccess($role_id)
    {
        $data['title'] = 'Role Access';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['role'] = $this->db->get_where('user_role', ['id' => $role_id])->row_array();

        $this->db->where('id !=', 1); // set supaya role admin tidak tampil

        $data['menu'] = $this->db->get('user_menu')->result_array();

        //memanggil all halaman home
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/role-access', $data);
        $this->load->view('templates/footer');
    }

    public function chargeAccess()
    {
        $menu_id = $this->input->post('menuId');
        $role_id = $this->input->post('roleId');

        $data = [
            'role_id' => $role_id,
            'menu_id' => $menu_id
        ];

        $result = $this->db->get_where('user_access_menu', $data);

        if ($result->num_rows() < 1) {
            $this->db->insert('user_access_menu', $data);
        } else {
            $this->db->delete('user_access_menu', $data);
        }

        //pesan error / berhasil
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Access Charged!
          </div>');
    }

    public function rolehapus($id)
    {
        $this->Admin_model->deleteRole($id);
        $this->session->set_flashdata('message', 'Delete Role Success');
        //$this->session->set_flashdata('message', 'Di Hapus');
        redirect('admin/role');
    }

    public function getRoleUbah()
    {
        echo json_encode($this->Admin_model->getRoleById($_POST['id']));
    }

    public function roleUbah()
    {

        $role = $this->input->post('role');
        $id = $this->input->post('id');

        $this->db->set('role', $role);
        $this->db->where('id', $id);
        $this->db->update('user_role');

        //pesan alert berhasil input
        $this->session->set_flashdata('message', 'Update Role Success');
        //$this->session->set_flashdata('message', '<div class="alert alert-succees" role="alert">
        //Update Data Succes!

        //</div>');

        // $this->session->set_flashdata('pesan', 'Di Berhasil di update');
        redirect('admin/role');
    }
}
