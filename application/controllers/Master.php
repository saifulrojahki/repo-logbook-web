<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Master extends CI_Controller
{

    // construct untuk mengamankan user yang tidak login
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Master_model');
        is_logged_in();
    }

    //kelompok service point
    public function servicepoint()
    {
        $data['title'] = 'Service Point';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['sp'] = $this->db->get('service_point')->result_array();

        $this->form_validation->set_rules('sp', 'SP', 'required');

        if ($this->form_validation->run() == false) {
            //memanggil all halaman home
            // auload library pagination
            $this->load->library('pagination');

            //ambil data keyword dari searching
            if ($this->input->post('submit')) {
                $data['keyword'] = $this->input->post('keyword');
                //simpan keyword ke dalam session 
                $this->session->set_userdata('keyword', $data['keyword']);
            } else {
                //hal pag tampil sesuai session berdasarkat keyword 
                $data['keyword'] = $this->session->userdata('keyword');
            }

            //seaching data 
            $this->db->like('servicepoint', $data['keyword']);
            //$this->db->or_like('email', $data['keyword']);
            $this->db->from('service_point');

            //config pagination
            $config['base_url'] = 'http://localhost/logbook/master/servicepoint';
            $config['num_links'] = 5; //jumlah hal yang tampil setelah dan sebelum hal active
            $config['total_rows'] = $this->db->count_all_results();
            //mengirim total data
            $data['total_rows'] = $config['total_rows'];
            $config['per_page'] = 6; //jumlah hal yang tampil

            //initialize pagination
            $this->pagination->initialize($config);


            //ambil data dari tabel
            $data['start'] = $this->uri->segment(3);
            $data['sp'] = $this->Master_model->getSP($config['per_page'], $data['start'], $data['keyword']);

            //panggil tampilan home
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('master/servicepoint', $data);
            $this->load->view('templates/footer');
        } else {

            //insert tabel dsn
            $data = [
                'kelas' => $this->input->post('kelas', true),
                'servicepoint' => htmlspecialchars(strtoupper($this->input->post('sp', true)))
            ];
            //var_dump($data);
            $this->db->insert('service_point', $data);

            //$this->db->insert('service_point', ['servicepoint' => htmlspecialchars(strtoupper($this->input->post('sp')))]);
            //pesan alert berhasil input
            $this->session->set_flashdata('message', 'Add Service Point Success');
            //$this->session->set_flashdata('message', '<div class="alert alert-succees" role="alert">
            //New Menu Added!
            //</div>');
            redirect('master/servicepoint');
        }
    }

    public function sphapus($id)
    {
        $this->Master_model->deleteSP($id);
        $this->session->set_flashdata('message', 'Delete Service Point Success');
        redirect('master/servicepoint');
    }

    public function getSPUbah()
    {
        echo json_encode($this->Master_model->getSPById($_POST['id']));
    }

    public function SPubah()
    {
        $kelas = htmlspecialchars(strtoupper($this->input->post('kelas')));
        $sp = htmlspecialchars(strtoupper($this->input->post('sp')));
        $id = $this->input->post('id');

        $this->db->set('kelas', $kelas);
        $this->db->set('servicepoint', $sp);
        $this->db->where('id', $id);
        $this->db->update('service_point');

        //pesan alert berhasil input
        $this->session->set_flashdata('message', 'Update Service Point Success');
        //$this->session->set_flashdata('message', '<div class="alert alert-succees" role="alert">
        //Update Data Succes!
        //</div>');

        // $this->session->set_flashdata('pesan', 'Di Berhasil di update');
        redirect('master/servicepoint');
    }

    //kelompok product
    public function product()
    {
        $data['title'] = 'Product';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['product'] = $this->db->get('product')->result_array();

        $this->form_validation->set_rules('product', 'Product', 'required');

        if ($this->form_validation->run() == false) {
            //memanggil all halaman home

            // auload library pagination
            $this->load->library('pagination');

            //ambil data keyword dari searching
            if ($this->input->post('submit')) {
                $data['keyword'] = $this->input->post('keyword');
                //simpan keyword ke dalam session 
                $this->session->set_userdata('keyword', $data['keyword']);
            } else {
                //hal pag tampil sesuai session berdasarkat keyword 
                $data['keyword'] = $this->session->userdata('keyword');
            }

            //seaching data 
            $this->db->like('product', $data['keyword']);
            //$this->db->or_like('email', $data['keyword']);
            $this->db->from('product');

            //config pagination
            $config['base_url'] = 'http://localhost/logbook/master/product';
            $config['num_links'] = 5; //jumlah hal yang tampil setelah dan sebelum hal active
            $config['total_rows'] = $this->db->count_all_results();
            //mengirim total data
            $data['total_rows'] = $config['total_rows'];
            $config['per_page'] = 6; //jumlah hal yang tampil

            //initialize pagination
            $this->pagination->initialize($config);


            //ambil data dari tabel
            $data['start'] = $this->uri->segment(3);
            $data['product'] = $this->Master_model->getProduct($config['per_page'], $data['start'], $data['keyword']);


            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('master/product', $data);
            $this->load->view('templates/footer');
        } else {
            //$this->db->insert('product', ['product' => $this->input->post('product')]);
            //insert tabel edc 
            $data = [
                'product' => htmlspecialchars(strtoupper($this->input->post('product', true))),
                'kategori' => $this->input->post('kategori', true)
            ];
            $this->db->insert('product', $data);
            //pesan alert berhasil input
            $this->session->set_flashdata('message', 'Add Product Success');
            //$this->session->set_flashdata('message', '<div class="alert alert-succees" role="alert">
            //New Menu Added!
            //</div>');
            redirect('master/product');
        }
    }

    public function productHapus($id)
    {
        $this->Master_model->deleteProduct($id);
        $this->session->set_flashdata('message', 'Delete Product Success');
        redirect('master/product');
    }

    public function getProductUbah()
    {
        echo json_encode($this->Master_model->getProductById($_POST['id']));
    }

    public function productUbah()
    {

        $product = htmlspecialchars(strtoupper($this->input->post('product')));
        $id = $this->input->post('id');
        $kategori = $this->input->post('kategori');

        $this->db->set('product', $product);
        $this->db->set('kategori', $kategori);
        $this->db->where('id', $id);
        $this->db->update('product');

        //pesan alert berhasil input
        $this->session->set_flashdata('message', 'Update Product Success');
        //$this->session->set_flashdata('message', '<div class="alert alert-succees" role="alert">
        //Update Data Succes!
        //</div>');

        // $this->session->set_flashdata('pesan', 'Di Berhasil di update');
        redirect('master/product');
    }

    //kelompok Owner
    public function owner()
    {
        $data['title'] = 'Owner';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['owner'] = $this->db->get('owner')->result_array();

        $this->form_validation->set_rules('owner', 'Owner', 'required');

        if ($this->form_validation->run() == false) {

            // auload library pagination
            $this->load->library('pagination');

            //ambil data keyword dari searching
            if ($this->input->post('submit')) {
                $data['keyword'] = $this->input->post('keyword');
                //simpan keyword ke dalam session 
                $this->session->set_userdata('keyword', $data['keyword']);
            } else {
                //hal pag tampil sesuai session berdasarkat keyword 
                $data['keyword'] = $this->session->userdata('keyword');
            }

            //seaching data 
            $this->db->like('owner', $data['keyword']);
            //$this->db->or_like('email', $data['keyword']);
            $this->db->from('owner');

            //config pagination
            $config['base_url'] = 'http://localhost/logbook/master/owner';
            $config['num_links'] = 5; //jumlah hal yang tampil setelah dan sebelum hal active
            $config['total_rows'] = $this->db->count_all_results();
            //mengirim total data
            $data['total_rows'] = $config['total_rows'];
            $config['per_page'] = 6; //jumlah hal yang tampil

            //initialize pagination
            $this->pagination->initialize($config);


            //ambil data dari tabel
            $data['start'] = $this->uri->segment(3);
            $data['owner'] = $this->Master_model->getOwner($config['per_page'], $data['start'], $data['keyword']);

            //memanggil all halaman home
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('master/owner', $data);
            $this->load->view('templates/footer');
        } else {
            $this->db->insert('owner', ['owner' => htmlspecialchars(strtoupper($this->input->post('owner')))]);
            //pesan alert berhasil input
            $this->session->set_flashdata('message', 'Add Owner Success');
            //$this->session->set_flashdata('message', '<div class="alert alert-succees" role="alert">
            //New Menu Added!
            //</div>');
            redirect('master/owner');
        }
    }

    public function ownerHapus($id)
    {
        $this->Master_model->deleteOwner($id);
        $this->session->set_flashdata('message', 'Delete Owner Success');
        redirect('master/owner');
    }

    public function getOwnerUbah()
    {
        echo json_encode($this->Master_model->getOwnerById($_POST['id']));
    }

    public function OwnerUbah()
    {

        $owner = htmlspecialchars(strtoupper($this->input->post('owner')));
        $id = $this->input->post('id');

        $this->db->set('owner', $owner);
        $this->db->where('id', $id);
        $this->db->update('owner');

        //pesan alert berhasil input
        $this->session->set_flashdata('message', 'Update Owner Success');
        //$this->session->set_flashdata('message', '<div class="alert alert-succees" role="alert">
        //Update Data Succes!
        //</div>');

        // $this->session->set_flashdata('pesan', 'Di Berhasil di update');
        redirect('master/owner');
    }

    //kelompok Customer
    public function customer()
    {
        $data['title'] = 'Customer';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['customer'] = $this->db->get('customer')->result_array();

        $this->form_validation->set_rules('customer', 'Customer', 'required');

        if ($this->form_validation->run() == false) {

            // auload library pagination
            $this->load->library('pagination');

            //ambil data keyword dari searching
            if ($this->input->post('submit')) {
                $data['keyword'] = $this->input->post('keyword');
                //simpan keyword ke dalam session 
                $this->session->set_userdata('keyword', $data['keyword']);
            } else {
                //hal pag tampil sesuai session berdasarkat keyword 
                $data['keyword'] = $this->session->userdata('keyword');
            }

            //seaching data 
            $this->db->like('customer', $data['keyword']);
            //$this->db->or_like('email', $data['keyword']);
            $this->db->from('customer');

            //config pagination
            $config['base_url'] = 'http://localhost/logbook/master/customer';
            $config['num_links'] = 5; //jumlah hal yang tampil setelah dan sebelum hal active
            $config['total_rows'] = $this->db->count_all_results();
            //mengirim total data
            $data['total_rows'] = $config['total_rows'];
            $config['per_page'] = 6; //jumlah hal yang tampil

            //initialize pagination
            $this->pagination->initialize($config);


            //ambil data dari tabel
            $data['start'] = $this->uri->segment(3);
            $data['customer'] = $this->Master_model->getCustomer($config['per_page'], $data['start'], $data['keyword']);

            //memanggil all halaman home
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('master/customer', $data);
            $this->load->view('templates/footer');
        } else {
            $this->db->insert('customer', ['customer' => htmlspecialchars(strtoupper($this->input->post('customer')))]);
            //pesan alert berhasil input
            $this->session->set_flashdata('message', 'Add Customer Success');
            //$this->session->set_flashdata('message', '<div class="alert alert-succees" role="alert">
            //New Menu Added!
            //</div>');
            redirect('master/customer');
        }
    }

    public function customerHapus($id)
    {
        $this->Master_model->deleteCustomer($id);
        $this->session->set_flashdata('message', 'Delete Customer Success');
        redirect('master/customer');
    }

    public function getCustomerUbah()
    {
        echo json_encode($this->Master_model->getCustomerById($_POST['id']));
    }

    public function CustomerUbah()
    {

        $customer = htmlspecialchars(strtoupper($this->input->post('customer')));
        $id = $this->input->post('id');

        $this->db->set('customer', $customer);
        $this->db->where('id', $id);
        $this->db->update('customer');

        //pesan alert berhasil input
        $this->session->set_flashdata('message', 'Update Customer Success');
        //$this->session->set_flashdata('message', '<div class="alert alert-succees" role="alert">
        //Update Data Succes!
        //</div>');

        // $this->session->set_flashdata('pesan', 'Di Berhasil di update');
        redirect('master/customer');
    }

    //kelompok member
    public function member()
    {

        $data['title'] = 'Member';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        //query builder tampil tabel member
        $data['member'] = $this->db->get('member')->result_array();

        //query builder tampil all tabel product
        $data['sp'] = $this->db->get('service_point')->result_array();

        //set form validation untuk tiap textbox
        $this->form_validation->set_rules('mip', 'Mip', 'required|is_unique[member.mip]');

        if ($this->form_validation->run() == false) {
            //memanggil all halaman home jika validasi gagal
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('master/member', $data);
            $this->load->view('templates/footer');
        } else {

            //insert tabel dsn
            $data = [
                'mip' => $this->input->post('mip', true),
                'nama' => htmlspecialchars(strtoupper($this->input->post('nama', true))),
                'servicepoint' => $this->input->post('servicepoint', true),
                'image' => 'default.jpg'
            ];
            //var_dump($data);
            $this->db->insert('member', $data);

            //pesan alert berhasil input
            $this->session->set_flashdata('message', 'Add Member Success');
            redirect('master/member');
        }
    }

    public function memberHapus($id)
    {
        $this->Master_model->deleteMember($id);
        $this->session->set_flashdata('message', 'Delete Member Success');
        redirect('master/member');
    }

    public function getMemberUbah()
    {
        echo json_encode($this->Master_model->getMemberById($_POST['id']));
    }

    public function memberUbah()
    {

        $mip = $this->input->post('mip');
        $nama = htmlspecialchars(strtoupper($this->input->post('nama')));
        $sp = htmlspecialchars(strtoupper($this->input->post('servicepoint')));
        $id = $this->input->post('id_sae');

        $this->db->set('mip', $mip);
        $this->db->set('nama', $nama);
        $this->db->set('servicepoint', $sp);
        $this->db->where('id_sae', $id);
        $this->db->update('member');

        //pesan alert berhasil input
        $this->session->set_flashdata('message', 'Update Member Success');

        redirect('master/member');
    }
}
