<?php

class Izin extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();
        $this->load->model('student/M_auth');
        $this->load->model('student/M_izin');
        $this->load->library('form_validation');
        if (!$this->session->userdata('id_siswa')) {
            redirect(base_url() . 'student/auth');
        }
        if ($this->session->userdata('role_id') != 'siswa') {
            echo 'Anda tidak diizinkan untuk akses halaman ini';
            exit;
        }
    }
    public function index()
    {
        $datauser = array_merge($this->M_auth->getUserByNis($this->session->userdata('nis'))[0], ['role_id' => $this->session->userdata('role_id')]);

        $data = [
            'title' => WEBNAME . 'Siswa Dashboard',
            'user' => $datauser,
            'webname' => WEBNAME,
        ];
        $this->load->view('student/templates/header', $data);
        $this->load->view('student/izin/buatizin');
        $this->load->view('student/templates/footer');
    }

    public function kirimpermintaan()
    {
        $datauser = array_merge($this->M_auth->getUserByNis($this->session->userdata('nis'))[0], ['role_id' =>
        $this->session->userdata('role_id')]);
        $config['upload_path'] = './assets/images/izinsiswa';
        $config['allowed_types'] = 'jpg|jpeg|png|pdf|docx';
        $config['file_name'] = 'izin-' . $datauser['nama_siswa'] . '-' . date('Y-m-d');
        $config['max_size'] = 2000;
        $this->load->library('upload', $config);

        $this->form_validation->set_rules(
            'tanggal',
            'Tanggal',
            'is_unique[tabel_izin.tanggal_izin]',
            [
                'is_unique' => 'Kamu sudah izin hari ini, hanya bisa satu kali izin dalam satu hari'
            ]
        );
        $this->form_validation->set_rules('keterangan', 'keterangan', 'min_length[50]|trim', [
            'min_length' => 'Keterangan minimal 50 karakter!'
        ]);
        if ($this->form_validation->run() != FALSE) {
            if (!$this->upload->do_upload('bukti')) {
                $this->session->set_flashdata('flash', ['alert' => 'danger', 'message' => $this->upload->display_errors()]);
            } else {
                $this->upload->data('is_image') == false ? $bukti =  $config['file_name'] . '.' . $this->upload->data('file_ext') : $bukti =  $config['file_name'] . '.' . $this->upload->data('image_type');

                $this->M_izin->inputizin($bukti, $datauser['nis_siswa']);
                $this->session->set_flashdata('flash', ['alert' => 'success', 'message' => 'Izin berhasil di kirim,silahkan menunggu di cek oleh guru/ kordinator sekolah']);
            }
        } else {
            $this->session->set_flashdata('flash', ['alert' => 'danger', 'message' => validation_errors()]);
        }
        redirect(base_url('student/izin'));
    }

    // halaman data izin
    public function data()
    {
        $datauser = array_merge($this->M_auth->getUserByNis($this->session->userdata('nis'))[0], ['role_id' =>
        $this->session->userdata('role_id')]);

        $this->load->helper('sf_helper');
        $data = [
            'title' => WEBNAME . ' Data Izin',
            'user' => $datauser,
            'webname' => WEBNAME,
            'dataizin' => $this->M_izin->tampildata($datauser['nis_siswa'])
        ];
        $this->load->view('student/templates/header', $data);
        $this->load->view('student/izin/dataizin');
        $this->load->view('student/templates/footer');
    }
}
