<?php

class M_absensi extends CI_Model
{

    public function dataabsensi()
    {
        return $this->db->select('*')
            ->from('tabel_detail_absen')
            ->join('tabel_siswa', 'tabel_siswa.nis = tabel_detail_absen.nis')
            ->get()->result_array();
    }



    public function getAbsenByIdKelas($idkelas, $bulan)
    {

        return $this->db->select('*')
            ->from('tabel_detail_absen')
            ->where('kode_kelas', $idkelas)->like('tanggal_absen', $bulan)->get()->result_array();
        //  return $this->db->where('kode_kelas', $idkelas)
        //     ->get('tabel_siswa')->result_array();
    }
    public function getSiswaByIdKelasCari($nis, $idkelas, $tahun, $bulan)
    {
        $tgltahun = $tahun . '-' . $bulan;
        if ($nis != false) {
            $data = [
                'nis' => $nis,
                'tanggal_absen' => $tgltahun
            ];
        } else {
            $data = [
                'tanggal_absen' => $tgltahun
            ];
        }
        return $this->db->select('*')
            ->from('tabel_detail_absen')
            ->where('kode_kelas', $idkelas)->like($data)->get()->result_array();


        //  return $this->db->where('kode_kelas', $idkelas)
        //     ->get('tabel_siswa')->result_array();
    }

    public function CariSiswa($nis, $kelas)
    {
        $where = [
            'nis' => $nis,
            'kode_kelas' => $kelas
        ];
        return $this->db->where($where)->order_by('nama_siswa', 'ASC')
            ->get('tabel_siswa')->result_array();
    }
    public function dataSiswaByKelas($kelas)
    {
        return $this->db->where('kode_kelas', $kelas)->order_by('nama_siswa', 'ASC')
            ->get('tabel_siswa')->result_array();
    }

    // absen input
    public function inputabsen($nis, $idkelas)
    {
        $jam = time();
        $data = [
            'jam_absen' => $jam,
            'tanggal_absen' => $this->input->post('tgltahun'),
            'nis' => $nis,
            'keterangan' => $this->input->post('keterangan', true),
            'kode_kelas' => $idkelas
        ];
        $this->db->insert('tabel_detail_absen', $data);
    }
    public function editabsen($nis, $idkelas)
    {
        $data = [
            'jam_absen' => time(),
            'keterangan' => $this->input->post('keterangan')
        ];

        $where = [
            'nis' => $nis,
            'tanggal_absen' => $this->input->post('tgltahun'),
            'kode_kelas' => $idkelas
        ];
        $this->db->where($where)
            ->update('tabel_detail_absen', $data);
    }
    public function hapusabsen($nis, $idkelas)
    {
        $where = [
            'nis' => $nis,
            'tanggal_absen' => $this->input->post('tgltahun'),
            'keterangan' => $this->input->post('keterangan'),
            'kode_kelas' => $idkelas
        ];
        $this->db->delete('tabel_detail_absen', $where);
    }
}
