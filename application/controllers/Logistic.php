<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Logistic extends CI_Controller
{

    // construct untuk mengamankan user yang tidak login
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Logistic_model');
        is_logged_in();
    }

    //kelompok EDC
    public function edc()
    {
        $data['title'] = 'EDC';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        //query builder tampil service point base on email user
        $email = $this->session->userdata('email'); //ambil data email dari sesion
        $sp = $this->db->get_where('user', ['email' => $email])->row_array(); //ambil data dari tabel user base on email

        //query builder join tabel edc dan box
        $data['edc']  = $this->db->select('*');
        $data['edc']  = $this->db->from('edc');
        $data['edc']  = $this->db->join('box', 'edc.nobox = box.nobox');
        $data['edc']  = $this->db->where('edc.servicepoint', $sp['servicepoint']);
        $data['edc']  = $this->db->get()->result_array();

        //query builder tampil all tabel product
        $data['product'] = $this->db->get_where('product', ['kategori' => 'EDC'])->result_array();


        //query builder tampil all tabel customer / setting for
        $data['customer'] = $this->db->get('customer')->result_array();

        //query builder tampil all tabel owner
        $data['owner'] = $this->db->get('owner')->result_array();

        //query builder tampilkan box kosong berdasarkan SP
        $data['box'] = $this->db->where('isi', 0);
        $data['box'] = $this->db->where('servicepoint', $sp['servicepoint']);
        $data['box'] = $this->db->order_by('nobox', 'ASC');
        $data['box'] = $this->db->get('box')->row_array();

        //set form validation untuk tiap textbox
        $this->form_validation->set_rules('snedc', 'SnEdc', 'required|is_unique[edc.snedc]');

        if ($this->form_validation->run() == false) {
            //memanggil all halaman home jika validasi gagal
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('logistic/edc', $data);
            $this->load->view('templates/footer');
        } else {

            //query builder tampilkan box kosong berdasarkan SP 
            $boxkosong = $this->db->where('isi', 0);
            $boxkosong = $this->db->where('servicepoint', $sp['servicepoint']);
            $boxkosong = $this->db->order_by('nobox', 'ASC');
            $boxkosong = $this->db->get('box')->row_array();

            //insert tabel edc 
            $data = [
                //'nobox' => $this->input->post('nobox'),
                'nobox' => $boxkosong['nobox'],
                'snedc' => htmlspecialchars(strtoupper(($this->input->post('snedc', true)))),
                'snsimcard' => htmlspecialchars(strtoupper($this->input->post('snsimcard', true))),
                'snsamcard' => htmlspecialchars(strtoupper($this->input->post('snsamcard', true))),
                'product' => $this->input->post('product', true),
                'merchant' => $this->input->post('merchant', true),
                'customer' => $this->input->post('customer', true),
                'owner' => $this->input->post('owner'),
                'servicepoint' => $this->input->post('servicepoint'),
                'status' => $this->input->post('status'),
                'keterangan' => htmlspecialchars($this->input->post('keterangan', true))
            ];
            $this->db->insert('edc', $data);

            //insert tabel histori edc
            $histori = [
                'snedc' => htmlspecialchars(strtoupper($this->input->post('snedc', true))),
                'tanggal' => time(),
                'servicepoint' => $this->input->post('servicepoint'),
                'action' => $this->input->post('action', true),
                'keterangan' => htmlspecialchars($this->input->post('keterangan', true)),
                'email' => $email
            ];
            $this->db->insert('historiedc', $histori);

            //update nobox menjadi 1  di tabel box
            //$nobox = $this->input->post('nobox');

            $this->db->set('isi', 1);
            $this->db->where('nobox', $boxkosong['nobox']);
            $this->db->update('box');

            //pesan alert berhasil input
            $this->session->set_flashdata('message1', $boxkosong['pesan']);
            redirect('logistic/edc');
        }
    }

    //take out edc 
    public function edchapus($id)
    {
        //tampil data edc base on nobox
        $row = $this->db->get_where('edc', ['nobox' => $id])->row_array();

        //ambil data email dari sesion
        $email = $this->session->userdata('email');

        //insert tabel histori edc
        $histori = [
            'snedc' => $row['snedc'],
            'tanggal' => time(),
            'servicepoint' => $row['servicepoint'],
            'action' => "Keluar",
            'keterangan' => "Keluar Gudang SP",
            'email' => $email

        ];
        $this->db->insert('historiedc', $histori);

        $this->Logistic_model->deleteEDC($id);
        $this->Logistic_model->updateBox($id);
        //$this->Logistic_model->addHistoriEDCKeluar($id);

        $this->session->set_flashdata('message1', 'Take Out EDC Success');
        redirect('logistic/edc');
    }

    public function getEDCUbah()
    {
        echo json_encode($this->Logistic_model->getEDCById($_POST['id']));
    }

    public function EDCubah()
    {
        $id = $this->input->post('nobox');
        $snedc = htmlspecialchars(strtoupper($this->input->post('snedc')));
        $snsimcard = htmlspecialchars(strtoupper($this->input->post('snsimcard')));
        $snsamcard = htmlspecialchars(strtoupper($this->input->post('snsamcard')));
        $product = $this->input->post('product');
        $merchant = $this->input->post('merchant');
        $customer = $this->input->post('customer');
        $owner = $this->input->post('owner');
        $servicepoint = $this->input->post('servicepoint');
        $status = $this->input->post('status');
        $keterangan = htmlspecialchars($this->input->post('keterangan'));

        //update tabel edc
        $this->db->set('snedc', $snedc);
        $this->db->set('snsimcard', $snsimcard);
        $this->db->set('snsamcard', $snsamcard);
        $this->db->set('product', $product);
        $this->db->set('merchant', $merchant);
        $this->db->set('customer', $customer);
        $this->db->set('owner', $owner);
        $this->db->set('servicepoint', $servicepoint);
        $this->db->set('status', $status);
        $this->db->set('keterangan', $keterangan);
        $this->db->where('nobox', $id);
        $this->db->update('edc');

        //update tabel histori edc
        $snedc1 = htmlspecialchars(strtoupper($this->input->post('snedc1')));
        $this->db->set('snedc', $snedc);
        $this->db->set('keterangan', $keterangan);
        $this->db->where('snedc', $snedc1);
        $this->db->update('historiedc');


        //pesan alert berhasil input
        $this->session->set_flashdata('message1', 'Update EDC Success');

        // $this->session->set_flashdata('pesan', 'Di Berhasil di update');
        redirect('logistic/edc');
    }

    //kelompok Histori EDC
    public function historiedc()
    {
        $data['title'] = 'Histori EDC';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['edc'] = $this->db->get('historiedc')->result_array();

        //$this->form_validation->set_rules('edc', 'Edc', 'required');

        //if ($this->form_validation->run() == false) {
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
        //$this->db->where('snedc', $data['keyword']);
        $this->db->like('snedc', $data['keyword']);
        //$this->db->or_like('email', $data['keyword']);
        $this->db->from('historiedc');

        //config pagination
        $config['base_url'] = 'http://localhost/logbook/logistic/historiedc';
        $config['num_links'] = 5; //jumlah hal yang tampil setelah dan sebelum hal active
        $config['total_rows'] = $this->db->count_all_results();
        //mengirim total data
        $data['total_rows'] = $config['total_rows'];
        $config['per_page'] = 6; //jumlah hal yang tampil

        //initialize pagination
        $this->pagination->initialize($config);

        //ambil data dari tabel
        $data['start'] = $this->uri->segment(3);
        $data['edc'] = $this->Logistic_model->getHistoriEdc($config['per_page'], $data['start'], $data['keyword']);

        //panggil tampilan home
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('logistic/historiedc', $data);
        $this->load->view('templates/footer');
        //} else {
        //    $this->db->insert('service_point', ['servicepoint' => $this->input->post('sp')]);
        //pesan alert berhasil input
        //$this->session->set_flashdata('message', 'Add Service Point Success');
        //$this->session->set_flashdata('message', '<div class="alert alert-succees" role="alert">
        //New Menu Added!
        //</div>');
        //    redirect('master/servicepoint');
        //}
    }

    function export_excel()
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

        //ambil part dari folder PHPExcel 
        require(APPPATH . 'PHPExcel-1.8/Classes/PHPExcel.php');
        require(APPPATH . 'PHPExcel-1.8/Classes/PHPExcel/Writer/Excel2007.php');

        // seting propersties file yang nanti di export
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("Logbook Web");
        $objPHPExcel->getProperties()->setLastModifiedBy("Logbook Web");
        $objPHPExcel->getProperties()->setTitle("");
        $objPHPExcel->getProperties()->setDescription("");

        //set tampilan tatap muka file excel
        $objPHPExcel->setActiveSheetIndex(0);
        //set header excel
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'No');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', 'SN EDC');
        $objPHPExcel->getActiveSheet()->setCellValue('C1', 'SN Simcard');
        $objPHPExcel->getActiveSheet()->setCellValue('D1', 'SN Samcard');
        $objPHPExcel->getActiveSheet()->setCellValue('E1', 'Product');
        $objPHPExcel->getActiveSheet()->setCellValue('F1', 'Merchant');
        $objPHPExcel->getActiveSheet()->setCellValue('G1', 'Setting for');
        $objPHPExcel->getActiveSheet()->setCellValue('H1', 'Owner');
        $objPHPExcel->getActiveSheet()->setCellValue('I1', 'Service Point');
        $objPHPExcel->getActiveSheet()->setCellValue('J1', 'Location');
        $objPHPExcel->getActiveSheet()->setCellValue('K1', 'Status');
        $objPHPExcel->getActiveSheet()->setCellValue('L1', 'Remark');

        //set isi database di kolom excel
        $baris = 2;
        $i = 1;

        foreach ($data['edc'] as $sm) {

            $objPHPExcel->getActiveSheet()->setCellValue('A' . $baris, $i++);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $baris, $sm['snedc']);
            $objPHPExcel->getActiveSheet()->setCellValue('C' . $baris, $sm['snsimcard']);
            $objPHPExcel->getActiveSheet()->setCellValue('D' . $baris, $sm['snsamcard']);
            $objPHPExcel->getActiveSheet()->setCellValue('E' . $baris, $sm['product']);
            $objPHPExcel->getActiveSheet()->setCellValue('F' . $baris, $sm['merchant']);
            $objPHPExcel->getActiveSheet()->setCellValue('G' . $baris, $sm['customer']);
            $objPHPExcel->getActiveSheet()->setCellValue('H' . $baris, $sm['owner']);
            $objPHPExcel->getActiveSheet()->setCellValue('I' . $baris, $sm['servicepoint']);
            $objPHPExcel->getActiveSheet()->setCellValue('J' . $baris, $sm['pesan']);
            $objPHPExcel->getActiveSheet()->setCellValue('K' . $baris, $sm['status']);
            $objPHPExcel->getActiveSheet()->setCellValue('L' . $baris, $sm['keterangan']);

            $baris++;
        }

        //set file name excel
        $filename = "EDC-Digudang" . date("d-m-Y") . '.xlsx';
        //$filename = "EDC_Digudang" . '.xlsx';
        $objPHPExcel->getActiveSheet()->setTitle("Data EDC");

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attacment;filename="' . $filename . '"');
        header('Cache-Control: max-age-0');

        $writer = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $writer->save('php://output');

        exit;
    }

    //kelompok visual
    public function visual()
    {
        $data['title'] = 'Warehouse Visual';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['box'] = $this->db->get('box')->result_array();

        //panggil tampilan home
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('logistic/visual', $data);
        $this->load->view('templates/footer');
    }

    //kelompok dsn
    public function dsn()
    {

        $data['title'] = 'DSN';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        //query builder tampil service point base on email user
        $email = $this->session->userdata('email'); //ambil data email dari sesion
        $sp = $this->db->get_where('user', ['email' => $email])->row_array(); //ambil data dari tabel user base on email

        //query builder tampil all tabel device base on service point login
        $data['device'] = $this->db->get_where('device', ['servicepoint' => $sp['servicepoint']])->result_array();


        //query builder tampil all tabel product
        $data['product'] = $this->db->get_where('product', ['kategori' => 'DSN'])->result_array();


        //query builder tampil all tabel customer / setting for
        $data['customer'] = $this->db->get('customer')->result_array();

        //query builder tampil all tabel owner
        $data['owner'] = $this->db->get('owner')->result_array();

        //set form validation untuk tiap textbox
        $this->form_validation->set_rules('sndevice', 'SnDevice', 'required|is_unique[device.sndevice]');

        if ($this->form_validation->run() == false) {
            //memanggil all halaman home jika validasi gagal
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('logistic/dsn', $data);
            $this->load->view('templates/footer');
        } else {

            //insert tabel dsn
            $data = [
                //'nobox' => $this->input->post('nobox'),
                //'id_device' => $boxkosong['nobox'],
                'customer' => $this->input->post('customer', true),
                'sndevice' => htmlspecialchars(strtoupper($this->input->post('sndevice', true))),
                'nama_device' => htmlspecialchars(strtoupper($this->input->post('nama_device', true))),
                'product' => $this->input->post('product', true),
                'customer' => $this->input->post('customer', true),
                'servicepoint' => $this->input->post('sp', true),
                'kondisi' => $this->input->post('kondisi'),
                'status' => $this->input->post('status'),
                'keterangan' => htmlspecialchars($this->input->post('keterangan', true))
            ];
            //var_dump($data);
            $this->db->insert('device', $data);


            //insert tabel histori edc
            $histori = [
                'sndevice' => htmlspecialchars(strtoupper($this->input->post('sndevice', true))),
                'tanggal' => time(),
                'servicepoint' => $this->input->post('sp', true),
                'action' => $this->input->post('action', true),
                'keterangan' => htmlspecialchars($this->input->post('keterangan', true)),
                'email' => $email
            ];
            //var_dump($histori);
            $this->db->insert('historidevice', $histori);

            //pesan alert berhasil input
            $this->session->set_flashdata('message', 'Add Device Success');
            redirect('logistic/dsn');
        }
    }

    //take out dsn
    public function dsnhapus()
    {
        //ambil post id device dari form submit modal keluar
        $id = $this->input->post('id_device1');

        //tampil data device di tabel device
        $row = $this->db->get_where('device', ['id_device' => $id])->row_array();

        //ambil data email dari sesion
        $email = $this->session->userdata('email');

        //insert tabel histori dsn
        $histori = [
            'sndevice' => $row['sndevice'],
            'tanggal' => time(),
            'servicepoint' => $row['servicepoint'],
            'action' => "Keluar",
            'keterangan' => htmlspecialchars(strtoupper($this->input->post('remark', true))),
            'email' => $email

        ];
        $this->db->insert('historidevice', $histori);

        //hapus data tabel device berdarakan id
        $this->db->where('id_device', $id);
        $this->db->delete('device');

        $this->session->set_flashdata('message', 'Take Out DSN Success');
        redirect('logistic/dsn');
    }

    public function getDSNUbah()
    {
        echo json_encode($this->Logistic_model->getDSNById($_POST['id']));
    }

    public function DSNubah()
    {

        $id = $this->input->post('id_device');
        $sndevice = htmlspecialchars(strtoupper($this->input->post('sndevice', true)));
        $nama_device = htmlspecialchars(strtoupper($this->input->post('nama_device', true)));
        $product = $this->input->post('product');
        $customer = $this->input->post('customer');
        $servicepoint = $this->input->post('sp');
        $kondisi = $this->input->post('kondisi');
        $status = $this->input->post('status');
        $keterangan = htmlspecialchars($this->input->post('keterangan', true));

        $this->db->set('sndevice', $sndevice);
        $this->db->set('nama_device', $nama_device);
        $this->db->set('product', $product);
        $this->db->set('customer', $customer);
        $this->db->set('servicepoint', $servicepoint);
        $this->db->set('kondisi', $kondisi);
        $this->db->set('status', $status);
        $this->db->set('keterangan', $keterangan);
        $this->db->where('id_device', $id);
        $this->db->update('device');

        //update tabel histori device
        $sndevice1 = htmlspecialchars(strtoupper($this->input->post('sndevice1')));
        $this->db->set('sndevice', $sndevice);
        $this->db->set('keterangan', $keterangan);
        $this->db->where('sndevice', $sndevice1);
        $this->db->update('historidevice');

        //pesan alert berhasil input
        $this->session->set_flashdata('message', 'Update Device Success');

        // $this->session->set_flashdata('pesan', 'Di Berhasil di update');
        redirect('logistic/dsn');
    }

    function exportdsn_excel()
    {

        //query builder tampil service point base on email user
        $email = $this->session->userdata('email'); //ambil data email dari sesion
        $sp = $this->db->get_where('user', ['email' => $email])->row_array(); //ambil data dari tabel user base on email

        //query builder tampil all tabel device base on service point login
        $data['device'] = $this->db->get_where('device', ['servicepoint' => $sp['servicepoint']])->result_array();

        //ambil part dari folder PHPExcel 
        require(APPPATH . 'PHPExcel-1.8/Classes/PHPExcel.php');
        require(APPPATH . 'PHPExcel-1.8/Classes/PHPExcel/Writer/Excel2007.php');

        // seting propersties file yang nanti di export
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("Logbook Web");
        $objPHPExcel->getProperties()->setLastModifiedBy("Logbook Web");
        $objPHPExcel->getProperties()->setTitle("");
        $objPHPExcel->getProperties()->setDescription("");

        //set tampilan tatap muka file excel
        $objPHPExcel->setActiveSheetIndex(0);
        //set header excel
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'No');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', 'SN Device');
        $objPHPExcel->getActiveSheet()->setCellValue('C1', 'Device Name');
        $objPHPExcel->getActiveSheet()->setCellValue('D1', 'Product');
        $objPHPExcel->getActiveSheet()->setCellValue('E1', 'Customer');
        $objPHPExcel->getActiveSheet()->setCellValue('F1', 'Service Point');
        $objPHPExcel->getActiveSheet()->setCellValue('G1', 'Condition');
        $objPHPExcel->getActiveSheet()->setCellValue('H1', 'Status');
        $objPHPExcel->getActiveSheet()->setCellValue('I1', 'Remark');

        //set isi database di kolom excel
        $baris = 2;
        $i = 1;

        foreach ($data['device'] as $sm) {

            $objPHPExcel->getActiveSheet()->setCellValue('A' . $baris, $i++);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $baris, $sm['sndevice']);
            $objPHPExcel->getActiveSheet()->setCellValue('C' . $baris, $sm['nama_device']);
            $objPHPExcel->getActiveSheet()->setCellValue('D' . $baris, $sm['product']);
            $objPHPExcel->getActiveSheet()->setCellValue('E' . $baris, $sm['customer']);
            $objPHPExcel->getActiveSheet()->setCellValue('F' . $baris, $sm['servicepoint']);
            $objPHPExcel->getActiveSheet()->setCellValue('G' . $baris, $sm['kondisi']);
            $objPHPExcel->getActiveSheet()->setCellValue('H' . $baris, $sm['status']);
            $objPHPExcel->getActiveSheet()->setCellValue('I' . $baris, $sm['keterangan']);
            $baris++;
        }

        //set file name excel
        $filename = "DSN-Digudang" . date("d-m-Y") . '.xlsx';
        //$filename = "EDC_Digudang" . '.xlsx';
        $objPHPExcel->getActiveSheet()->setTitle("Data DSN");

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attacment;filename="' . $filename . '"');
        header('Cache-Control: max-age-0');

        $writer = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $writer->save('php://output');

        exit;
    }

    //kelompok Histori EDC
    public function historidsn()
    {
        $data['title'] = 'Histori Device DSN';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['edc'] = $this->db->get('historiedc')->result_array();

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
        $this->db->like('sndevice', $data['keyword']);
        //$this->db->or_like('email', $data['keyword']);
        $this->db->from('historidevice');

        //config pagination
        $config['base_url'] = 'http://localhost/logbook/logistic/historidsn';
        $config['num_links'] = 5; //jumlah hal yang tampil setelah dan sebelum hal active
        $config['total_rows'] = $this->db->count_all_results();
        //mengirim total data
        $data['total_rows'] = $config['total_rows'];
        $config['per_page'] = 6; //jumlah hal yang tampil

        //initialize pagination
        $this->pagination->initialize($config);

        //ambil data dari tabel
        $data['start'] = $this->uri->segment(3);
        $data['device'] = $this->Logistic_model->getHistoriDSN($config['per_page'], $data['start'], $data['keyword']);

        //panggil tampilan home
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('logistic/historidsn', $data);
        $this->load->view('templates/footer');
    }
}
