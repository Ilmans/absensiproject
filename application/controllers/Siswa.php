<?php

class Siswa extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_kelas');
        $this->load->model('M_siswa');
        $this->load->model('M_bantuan');
        $this->load->library('form_validation');
    }
    public function index()
    {
        $data = [
            'title' => WEBNAME . 'Data Siswa',
            'webname' => WEBNAME,
            'siswa' => $this->M_siswa->datasiswa()
        ];
        $this->load->view('templates/header', $data);
        $this->load->view('siswa/index');
        $this->load->view('templates/footer');
    }

    // halaman formulir tambahsiswa
    public function add()
    {
        $data = [
            'title' => WEBNAME . 'Menu access',
            'webname' => WEBNAME,
            'kelas' => $this->M_kelas->tampilkelas()
        ];
        $this->load->view('templates/header', $data);
        $this->load->view('siswa/formtambahsiswa');
        $this->load->view('templates/footer');
    }
    // proses input tambah siswa
    public function tambahsiswa()
    {
        $this->form_validation->set_rules('nama', 'nama', 'required|min_length[5]|trim');
        $this->form_validation->set_rules('nis', 'nis', 'required|min_length[10]|max_length[10]|is_unique[tabel_siswa.nis]', [
            'is_unique' => 'Nomor induk siswa ' . $this->input->post('nis') . ' sudah ada di database'
        ]);
        if ($this->form_validation->run() != FALSE) {
            if ($this->input->post('jeniskelamin')) {
                $nomorhp = $this->M_bantuan->formatnomor($this->input->post('nomor_hp'));
                $this->M_siswa->inputsiswa($nomorhp);
                $this->session->set_flashdata('flash', ['alert' => 'success', 'message' => 'Siswa Berhasil di tambah']);
            } else {
                $this->session->set_flashdata('flash', ['alert' => 'danger', 'message' => 'Jenis kelamin wajib diisi']);
            }
        } else {
            $this->session->set_flashdata('flash', ['alert' => 'danger', 'message' => validation_errors()]);
        }
        redirect(base_url() . 'siswa');
    }

    // form edit siswa
    public function edit()
    {
        if ($this->input->post('nis') != FALSE) {
            $nis = $this->input->post('nis');
            $datasiswa = $this->M_siswa->dataspesifiksiswa($nis)[0];
            $data = [
                'title' => WEBNAME . 'Edit Siswa',
                'webname' => WEBNAME,
                'siswa' => $datasiswa,
                'kelas' => $this->M_kelas->tampilkelas()
            ];
            $this->load->view('templates/header', $data);
            $this->load->view('siswa/formeditsiswa');
            $this->load->view('templates/footer');
        } else {
            redirect(base_url() . 'siswa');
        }
    }

    public function editsiswa()
    {
        $idsiswa = $this->input->post('id_siswa');
        $nisawal = $this->M_bantuan->cekValue('nis', 'tabel_siswa', 'id_siswa', $idsiswa);
        // validasi Nis
        if ($this->input->post('nis') == $nisawal) {
            $is_unique_nis = '';
        } else {
            $is_unique_nis = '|is_unique[tabel_siswa.nis]';
        }
        $this->form_validation->set_rules('nis', 'nis', 'required|trim' . $is_unique_nis, [
            'is_unique' => 'Nomor induk sudah ada di database'
        ]);
        $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
        $this->form_validation->set_rules('alamat', 'alamat', 'required|trim');

        if ($this->form_validation->run() != FALSE) {
            $nomorhp = $this->M_bantuan->formatnomor($this->input->post('nomor_hp'));
            $this->M_siswa->editsiswa($nomorhp);
            $this->session->set_flashdata('flash', ['alert' => 'success', 'message' => 'Siswa Berhasil di ubah']);
        } else {
            $this->session->set_flashdata('flash', ['alert' => 'danger', 'message' => validation_errors()]);
        }
        redirect(base_url() . 'siswa');
    }

    public function delete()
    {
        if ($this->input->post('id_siswa') != FALSE) {
            $this->M_siswa->deletesiswa($this->input->post('id_siswa'));
            $this->session->set_flashdata('flash', ['alert' => 'success', 'message' => 'Siswa berhasil dihapus']);
        }
        redirect(base_url() . 'siswa');
    }
}
