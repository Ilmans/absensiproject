<?php

class Absen extends CI_Controller
{

    private $bulan = [
        '01' => 'JANUARI',
        '02' => 'FEBRUARI',
        '03' => 'MARET',
        '04' => 'APRIL',
        '05' => 'MEI',
        '06' => 'JUNI',
        '07' => 'JULI',
        '08' => 'AGUSTUS',
        '09' => 'SEPTEMBER',
        '10' => 'OKTOBER',
        '11' => 'NOVEMBER',
        '12' => 'DESEMBER',
    ];

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_absensi');
        $this->load->model('M_kelas');
        $this->load->model('M_siswa');
    }
    public function index()
    {

        $namabulan = $this->bulan;
        // untuk pencarian 
        if ($this->input->get('cariabsen') != FALSE) {
            // deklarasi yang di cari
            $idkelas = $this->input->get('kelas');
            $bulan = $this->input->get('bulan');
            $tahun = $this->input->get('tahun');
            // pencarian dengan nis
            if ($this->input->get('nis') != FALSE) {

                $nis = $this->input->get('nis');
                $datasiswa = $this->M_absensi->CariSiswa($nis, $idkelas);
                $datasiswabykelas = $this->M_absensi->getSiswaByIdKelasCari($nis, $idkelas, $tahun, $bulan);
                // deskripsi pencarian dengan nis
                $desc = 'NIS ' . $nis . ' ( ' . $namabulan[$bulan] . ' ' . $tahun . ' )';
            } else {
                // pencarian tanpa nis
                $datasiswa = $this->M_absensi->dataSiswaByKelas($idkelas);
                $datasiswabykelas = $this->M_absensi->getSiswaByIdKelasCari(false, $idkelas, $tahun, $bulan);
                // deskripsi pencarian tanpa nis
                $desc = 'Kelas ' . $this->M_kelas->ambilkelas($idkelas)[0]['kelas'] . ' ( ' . $namabulan[$bulan] . ' ' . $tahun . ' )';
            }
        } else {
            // deskripsi
            $desc = 'Kelas ' . $this->M_kelas->ambilkelas(1)[0]['kelas'] . ' ( ' . $namabulan[date('m')] . ' ' . date('Y') . ' )';
            // defaul bulan dan kelas yang ditampilkan
            $bulansekarang = date('Y-m');
            $datasiswa = $this->M_absensi->dataSiswaByKelas(1);
            $datasiswabykelas = $this->M_absensi->getAbsenByIdKelas(1, $bulansekarang);
            // $dataabsen = $this->M_absensi->dataabsensi();
        }
        //
        $data = [
            'title' => WEBNAME . ' Absensi',
            'webname' => WEBNAME,
            'dataabsen' => $datasiswabykelas,
            'kelas' => $this->M_kelas->tampilkelas(),
            'siswa' => $datasiswa,
            'desc' => $desc
        ];
        $this->load->view('templates/header', $data);
        $this->load->view('absen/index');
        $this->load->view('templates/footer');
    }

    public function input()
    {

        foreach ($this->input->post('nis') as $n) {
            $siswa = $this->M_siswa->dataspesifiksiswa($n)[0];
            if ($this->input->post('aksi') == 'baru') {
                $this->M_absensi->inputabsen($siswa['nis'], $siswa['kode_kelas']);
                $message = 'Berhasil Absen';
            } else if ($this->input->post('aksi') == 'edit') {
                // edit asen
                $this->M_absensi->editabsen($siswa['nis'], $siswa['kode_kelas']);
                $message = 'Berhasil edit absen';
            } else {
                $this->M_absensi->hapusabsen($siswa['nis'], $siswa['kode_kelas']);
                $message = 'Berhasil hapus absen';
                // hapus absen
            }
        }
        $this->session->set_flashdata('flash', ['alert' => 'success', 'message' => $message]);
        redirect(base_url() . 'absen');
    }
}
