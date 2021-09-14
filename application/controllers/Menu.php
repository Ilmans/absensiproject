<?php


class Menu extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_kelas');
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
            'kelas' => $this->M_kelas->tampilkelas()
        ];
        $this->load->view('templates/header', $data);
        $this->load->view('menu/kelolakelasjurusan');
        $this->load->view('templates/footer');
    }



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
        $this->form_validation->set_rules('kelas', 'Kelas', 'required|is_unique[tabel_kelas.kelas]');

        if ($this->form_validation->run() == FALSE) {
            var_dump(validation_errors());
        } else {
            $this->M_kelas->inputkelas();
            $this->session->set_flashdata('flash', ['alert' => 'success', 'message' => 'Data berhasil di input']);
            redirect(base_url() . 'menu/kelasdanjurusan');
        }
    }
}
