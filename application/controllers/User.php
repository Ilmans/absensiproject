<?php

class User extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_user');
        $this->load->library('form_validation');
    }
    public function index()
    {
        $data = [
            'title' => WEBNAME . 'Data User',
            'webname' => WEBNAME,
            'user' => $this->M_user->datauser()
        ];
        $this->load->view('templates/header', $data);
        $this->load->view('user/index');
        $this->load->view('templates/footer');
    }

    public function edit()
    {
        if ($this->input->post('id_user') != FALSE) {
            $id_user = $this->input->post('id_user');
            $data_user = $this->M_user->getUserById($id_user)[0];
            $data = [
                'title' => WEBNAME . 'Edit User',
                'webname' => WEBNAME,
                'user' => $data_user
            ];
            $this->load->view('templates/header', $data);
            $this->load->view('user/formedituser');
            $this->load->view('templates/footer');
        } else {
            redirect(base_url() . 'user');
        }
    }

    public function delete()
    {
        if ($this->input->post('id_user') != FALSE) {
            $this->M_user->deleteuser($this->input->post('id_user'));
            $this->session->set_flashdata('flash', ['alert' => 'success', 'message' => 'User berhasil dihapus']);
        }
        redirect(base_url() . 'user');
    }

    public function edituser()
    {
        $config['upload_path']          = './assets/images/user';
        $config['allowed_types']        = 'jpg|png|jpeg';
        $config['file_name']        = $this->input->post('id_user');
        $config['max_size']             = 2000;
        $this->load->library('upload', $config);
        $this->form_validation->set_rules('nama', 'Name', 'required|min_length[6]|trim|alpha', [
            'min_length' => 'Nama minimal 6 karakter',
        ]);
        $old_email = $this->M_user->getUserByid($this->input->post('id_user'))[0]['image'];
        if ($this->input->post('email') == $old_email) {
            $rules_email = '';
        } else {
            $rules_email = '|is_unique[tabel_user.email]';
        }
        $this->form_validation->set_rules('email', 'email', 'required|valid_email' . $rules_email, [
            'valid_email' => 'Harap masukan email yang valid'
        ]);
        if (!isset($_FILES['image']['name'])) {
            $foto = $this->input->post('fotodefault');
        } else {
            if (!$this->upload->do_upload('foto')) {
                $this->session->set_flashdata('flash', ['alert' => 'danger', 'message' => $this->upload->display_errors()]);
                redirect(base_url() . 'user');
                exit;
            }
            $foto = $this->input->post('id_user') . '.' . $this->upload->data('image_type');
        }
        $this->M_user->edituser($foto);
        $this->session->set_flashdata('flash', ['alert' => 'success', 'message' => 'Berhasil edit user']);
        redirect(base_url() . 'user');
    }
}
