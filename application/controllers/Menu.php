<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends CI_Controller
{

    // construct untuk mengamankan user yang tidak login
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Menu_model');
        is_logged_in();
    }

    //kelompok menu
    public function index()
    {
        $data['title'] = 'Menu Management';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->form_validation->set_rules('menu', 'Menu', 'required');

        if ($this->form_validation->run() == false) {
            //memanggil all halaman home
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('menu/index', $data);
            $this->load->view('templates/footer');
        } else {
            $this->db->insert('user_menu', ['menu' => $this->input->post('menu')]);
            //pesan alert berhasil input
            $this->session->set_flashdata('message', 'Add Menu Success');
            //$this->session->set_flashdata('message', '<div class="alert alert-succees" role="alert">
            //New Menu Added!
            //</div>');
            redirect('menu');
        }
    }


    public function hapus($id)
    {
        $this->Menu_model->deleteMenu($id);
        $this->session->set_flashdata('message', 'Delete Menu Success');
        redirect('menu');
    }

    public function getUbah()
    {
        echo json_encode($this->Menu_model->getMenuById($_POST['id']));
    }

    public function ubah()
    {

        $menu = $this->input->post('menu');
        $id = $this->input->post('id');

        $this->db->set('menu', $menu);
        $this->db->where('id', $id);
        $this->db->update('user_menu');

        //pesan alert berhasil input
        $this->session->set_flashdata('message', 'Update Menu Success');
        //$this->session->set_flashdata('message', '<div class="alert alert-succees" role="alert">
        //Update Data Succes!
        //</div>');

        // $this->session->set_flashdata('pesan', 'Di Berhasil di update');
        redirect('menu');
    }


    //kelompok submenu
    public function submenu()
    {
        $data['title'] = 'SubMenu Management';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->model('Menu_model', 'menu');

        $data['subMenu'] = $this->menu->getSubMenu();
        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('menu_id', 'Menu', 'required');
        $this->form_validation->set_rules('url', 'Url', 'required');
        $this->form_validation->set_rules('icon', 'icon', 'required');

        if ($this->form_validation->run() == false) {

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('menu/submenu', $data);
            $this->load->view('templates/footer');
        } else {
            $data = [
                'title' => $this->input->post('title'),
                'menu_id' => $this->input->post('menu_id'),
                'url' => $this->input->post('url'),
                'icon' => $this->input->post('icon'),
                'is_active' => $this->input->post('is_active')
            ];

            $this->db->insert('user_sub_menu', $data);

            //pesan alert berhasil input
            $this->session->set_flashdata('message', 'Add SubMenu Success');

            //$this->session->set_flashdata('message', '<div class="alert alert-succees" role="alert">
            //New sub menu added!
            //</div>');
            redirect('menu/submenu');
        }
    }

    public function submenuhapus($id)
    {
        $this->Menu_model->deleteSubMenu($id);
        $this->session->set_flashdata('message', 'Delete SubMenu Success');
        //$this->session->set_flashdata('pesan', 'Di Hapus');
        redirect('menu/submenu');
    }

    public function getSubMenuUbah()
    {
        echo json_encode($this->Menu_model->getSubMenuById($_POST['id']));
    }

    public function submenuubah()
    {

        $menuid = $this->input->post('menu_id');
        $title = $this->input->post('title');
        $url = $this->input->post('url');
        $icon = $this->input->post('icon');
        $id = $this->input->post('id');


        $this->db->set('menu_id', $menuid);
        $this->db->set('title', $title);
        $this->db->set('url', $url);
        $this->db->set('icon', $icon);
        $this->db->where('id', $id);
        $this->db->update('user_sub_menu');

        //pesan alert berhasil input
        $this->session->set_flashdata('message', 'Update SubMenu Success');
        //$this->session->set_flashdata('message', '<div class="alert alert-succees" role="alert">
        //Update Data Succes!
        //</div>');

        // $this->session->set_flashdata('pesan', 'Di Berhasil di update');
        redirect('menu/submenu');
    }
}
