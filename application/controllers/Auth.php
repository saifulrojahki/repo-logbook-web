<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }

    public function index()
    {
        //set supaya user tidak bisa kebali ke menu login jika belum logout
        if ($this->session->userdata('email')) {
            redirect('user');
        }

        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Logbook Web';
            $this->load->view('templates/auth-header', $data);
            $this->load->view('templates/auth-header');
            $this->load->view('auth/login');
            $this->load->view('templates/auth-footer');
        } else {
            //validasi succes
            $this->_login();
        }
    }

    private function _login()
    {
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        //sintak query pada code igniter untuk select * bla bla bla 
        $user = $this->db->get_where('user', ['email' => $email])->row_array();

        //user ada
        if ($user) {
            //jika user nya sudah aktif
            if ($user['is_active'] == 1) {
                //cek password
                if (password_verify($password, $user['password'])) {
                    $data = [
                        'email' => $user['email'],
                        'role_id' => $user['role_id']

                    ];

                    $this->session->set_userdata($data);
                    //login sesuai role id nya
                    if ($user['role_id'] == 1) {
                        redirect('admin');
                    } else {
                        redirect('user');
                    }
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                    Wrong Password!
                    </div>');
                    redirect('auth');
                }
            } else { // jika user belum aktivasi tampil pesan error
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                Email has not been activeted!
                </div>');
                redirect('auth');
            }
        } else { // jika user tidak ada tampil pesan error
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            Email is not registered!
          </div>');
            redirect('auth');
        }
    }

    public function registration()
    {
        //query builder tampil all tabel service point
        $data['sp'] = $this->db->get('service_point')->result_array();

        //set supaya user tidak bisa kebali ke menu login jika belum logout
        if ($this->session->userdata('email')) {
            redirect('user');
        }

        $this->form_validation->set_rules('name', 'Name', 'required|trim'); //set text tidak boleh kosong dan tidak ada spasi
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]');
        $this->form_validation->set_rules(
            'password1',
            'Password',
            'required|trim|min_length[3]|matches[password2]',
            [
                'matches' => 'Password dont match',
                'min_lenght' => 'Password too short!'
            ]
        );
        $this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password1]');

        if ($this->form_validation->run() == false) {

            $data['title'] = 'Logbook User Registration';
            $this->load->view('templates/auth-header', $data);
            $this->load->view('templates/auth-header');
            $this->load->view('auth/registration');
            $this->load->view('templates/auth-footer');
        } else {
            $email = $this->input->post('email', true);
            $data = [
                'id' => '',
                'name' => htmlspecialchars($this->input->post('name', true)),
                'email ' => htmlspecialchars($email),
                'image' => 'default.jpg',
                'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
                'role_id' => 2,
                'is_active' => 0,
                'date_created' => time(),
                'servicepoint' => htmlspecialchars($this->input->post('servicepoint', true))
            ];

            //siapkan token untuk aktivasi nya
            $token = base64_encode(random_bytes(32));
            $user_token = [
                'email' => $email,
                'token' => $token,
                'date_created' => time()
            ];
            //inset data di tabel user
            $this->db->insert('user', $data);
            //inset data di tabel token
            $this->db->insert('user_token', $user_token);

            //kirim email ke user yang register untuk aktivasi
            $this->_sendEmail($token, 'verify');

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Congratulation! your account has been create , please activate your account.
          </div>');
            redirect('auth');
        }
    }

    private function _sendEmail($token, $type)
    {
        $config = [
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_user' => 'saiful.testapp@gmail.com',
            'smtp_pass' => 'boled**010516',
            'smtp_port' => 465,
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'newline' => "\r\n",

        ];

        //$this->load->library('email, $config');
        $this->email->initialize($config);

        $this->email->from('saiful.testapp@gmail.com', '@Logbook Development');
        $this->email->to($this->input->post('email'));

        //cek type activasi email atau forgot passwo  rd
        if ($type == 'verify') {
            $this->email->subject('Account Verification');
            $this->email->message('Click this link to verify your account : <a href="' . base_url() . 'auth/verify?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '"  >Activate</a>');
        } else if ($type == 'forgot') {
            $this->email->subject('Reset Password');
            $this->email->message('Click this link to reset your password : <a href="' . base_url() . 'auth/resetpassword?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '"  >Reset Password</a>');
        }


        if ($this->email->send()) {
            return true;
        } else {
            echo $this->email->print_debugger();
            die;
        }
    }

    public function verify()
    {
        $email = $this->input->get('email');
        $token = $this->input->get('token');

        $user = $this->db->get_where('user', ['email' => $email])->row_array();

        if ($user) {
            $user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();

            if ($user_token) {
                //set expire aktivasi hanya 1 hari setelah terima register
                if (time() - $user_token['date_created'] < (60 * 60 * 24)) {
                    //update is active di tabel user menjadi 1 (aktive)
                    $this->db->set('is_active', 1);
                    $this->db->where('email', $email);
                    $this->db->update('user');
                    //hapus user token karena sudah aktive
                    $this->db->delete('user_token', ['email' => $email]);
                    //tampil pesan email sudah aktive
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">' . $email . 'has been activated! Please login
          </div>');
                    redirect('auth');
                } else {
                    //hapus email yang expired tidak segera aktivasi
                    $this->db->deleted('user', ['email' => $email]);
                    $this->db->deleted('user_token', ['email' => $email]);

                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
        Account activation failed! Token expired.
          </div>');
                    redirect('auth');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
        Account activation failed! Wrong token.
          </div>');
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
        Account activation failed! Wrong email.
          </div>');
            redirect('auth');
        }
    }

    public function logout()
    {

        $this->session->unset_userdata('email');
        $this->session->unset_userdata('role_id');
        //pesan error / berhasil
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        You have been logout !
          </div>');
        redirect('auth');
        //$this->session->set _flashdata('message', '<div class="alert alert-success" role="alert">
        //    You have been logout !</div>');
        //redirect('auth');
    }

    public function blocked()
    {

        $data['title']  = 'Access blocked';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        //memanggil all halaman home
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('auth/blocked', $data);
        $this->load->view('templates/footer');
    }

    public function forgotPassword()
    {
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Forgot Password';
            $this->load->view('templates/auth-header', $data);
            $this->load->view('templates/auth-header');
            $this->load->view('auth/forgot-password');
            $this->load->view('templates/auth-footer');
        } else {
            $email = $this->input->post('email');
            $user = $this->db->get_where('user', ['email' => $email, 'is_active' => 1])->row_array();

            if ($user) { //email  terdaftar

                $token = base64_encode(random_bytes(32));
                $user_token = [
                    'email' => $email,
                    'token' => $token,
                    'date_created' => time()
                ];

                //inset data di tabel token
                $this->db->insert('user_token', $user_token);

                //kirim email ke user yang register untuk aktivasi
                $this->_sendEmail($token, 'forgot');

                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Please check your email to reset your password.
          </div>');
                redirect('auth');
            } else { //error jika email tidak terdaftar

                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                Email is not registered or activated !
                  </div>');
                redirect('auth/forgotpassword');
            }
        }
    }

    public function resetpassword()
    {
        $email = $this->input->get('email');
        $token = $this->input->get('token');

        $user = $this->db->get_where('user', ['email' => $email])->row_array();

        if ($user) {
            $user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();
            if ($user_token) {
                $this->session->set_userdata('reset_email', $email);
                $this->changePassword();
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
        Reset password failed! Wrong token.
          </div>');
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
        Reset password failed! Wrong email.
          </div>');
            redirect('auth');
        }
    }

    public function changePassword()
    {
        if (!$this->session->userdata('reset_email')) {
            redirect('auth');
        }

        $this->form_validation->set_rules('password1', 'Password', 'required|trim|matches[password2]');
        $this->form_validation->set_rules('password2', 'Repeat Password', 'required|trim|matches[password1]');

        if ($this->form_validation->run() == false) {

            $data['title'] = 'Change Password';
            $this->load->view('templates/auth-header', $data);
            $this->load->view('templates/auth-header');
            $this->load->view('auth/change-password');
            $this->load->view('templates/auth-footer');
        } else {
            $password = password_hash($this->input->post('password1'), PASSWORD_DEFAULT);
            $email = $this->session->userdata('reset_email');

            //query update via builder codeignater
            $this->db->set('password', $password);
            $this->db->where('email', $email);
            $this->db->update('user');

            $this->session->unset_userdata('reset_email');

            $this->session->set_flashdata('message', '<div class="alert alert-succes" role="alert">
                Password has been changee! Please login.
                  </div>');
            redirect('auth');
        }
    }
}
