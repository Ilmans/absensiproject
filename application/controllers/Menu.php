<?php


class Menu extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_kelas');
        $this->load->model('M_jurusan');
        $this->load->library('form_validation');
    }

    public function index()
    {

        $data = [
            'title' => WEBNAME . 'Menu access',
            'webname' => WEBNAME
        ];
        $this->load->view('templates/header', $data);
        $this->load->view('templates/footer');
    }

    public function kelasdanjurusan()
    {
        $data = [
            'title' => WEBNAME . 'Kelola Kelas & Jurusan',
            'webname' => WEBNAME,
            'kelas' => $this->M_kelas->tampilkelas(),
            'jurusan' => $this->M_jurusan->tampiljurusan()
        ];
        $this->load->view('templates/header', $data);
        $this->load->view('menu/kelolakelasjurusan');
        $this->load->view('templates/footer');
    }


    // kelola kelas
    // digunakan untuk ajax
    public function ambilkelas()
    {
        $idkelas = $this->input->post('idkelas');
        echo json_encode($this->M_kelas->ambilkelas($idkelas));
    }

    public function tambahkelas()
    {
        $this->form_validation->set_rules(
            'nama_kelas',
            'Nama_kelas',
            'required|is_unique[tabel_kelas.nama_kelas]',
            [
                'is_unique' => 'nama kelas ' . $this->input->post('nama_kelas') . ' sudah ada di database'
            ]
        );
        $this->form_validation->set_rules('kelas', 'Kelas', 'required|is_unique[tabel_kelas.kelas]', [
            'is_unique' => 'Kelas ' . $this->input->post('kelas') . ' sudah ada di database'
        ]);

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('flash', ['alert' => 'danger', 'message' => validation_errors()]);
        } else {
            $this->M_kelas->inputkelas();
            $this->session->set_flashdata('flash', ['alert' => 'success', 'message' => 'Data berhasil di input']);
        }
        redirect(base_url() . 'menu/kelasdanjurusan');
    }

    public function hapuskelas()
    {
        $this->M_kelas->hapuskelas(base64_decode($this->uri->segment(3)));
        $this->session->set_flashdata('flash', ['alert' => 'success', 'message' => 'Kelas berhasil di hapus']);
        redirect(base_url() . 'menu/kelasdanjurusan');
    }

    public function editkelas()
    {
        $this->form_validation->set_rules(
            'nama_kelas',
            'Nama_kelas',
            'required'
        );
        $this->form_validation->set_rules('kelas', 'Kelas', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('flash', ['alert' => 'danger', 'message' => validation_errors()]);
        } else {
            $this->M_kelas->editkelas();
            $this->session->set_flashdata('flash', ['alert' => 'success', 'message' => 'Data berhasil di edit']);
        }
        redirect(base_url() . 'menu/kelasdanjurusan');
    }

    // kelola jurusan 
    public function tambahjurusan()
    {
        $this->form_validation->set_rules('namajurusan', 'Namajurusan', 'required|min_length[3]|is_unique[tabel_jurusan.jurusan]', [
            'min_length' => 'Nama jurusan minimal 3 karakter',
            'is_unique' => 'Jurusan ' . $this->input->post('namajurusan') . ' sudah terdaftar'
        ]);
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('flash', ['alert' => 'danger', 'message' => validation_errors()]);
        } else {
            $this->M_jurusan->tambahjurusan();
            $this->session->set_flashdata('flash', ['alert' => 'success', 'message' => 'Jurusan' . $this->input->post('namajurusan') . ' berhasil di tambahkan']);
        }
        redirect(base_url() . 'menu/kelasdanjurusan');
    }

    public function hapusjurusan()
    {
        $this->M_jurusan->hapusjurusan(base64_decode($this->uri->segment(3)));
        $this->session->set_flashdata('flash', ['alert' => 'success', 'message' => 'Jurusan berhasil di hapus']);
        redirect(base_url() . 'menu/kelasdanjurusan');
    }

    public function ambiljurusan()
    {
        $idjurusan = $this->input->post('idjurusan');
        echo json_encode($this->M_jurusan->ambiljurusan($idjurusan));
    }

    public function editjurusan()
    {
        $this->form_validation->set_rules(
            'namajurusan',
            'namajurusan',
            'required|min_length[3]',
            [
                'min_length' => 'Nama jurusan minimal 3 karakter'
            ]
        );
        // $this->form_validation->set_rules('kelas', 'Kelas', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('flash', ['alert' => 'danger', 'message' => validation_errors()]);
        } else {
            $this->M_jurusan->editjurusan();
            $this->session->set_flashdata('flash', ['alert' => 'success', 'message' => 'Data berhasil di edit']);
        }
        redirect(base_url() . 'menu/kelasdanjurusan');
    }
}
