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


    public function CariSiswa($nis, $kelas, $jurusan)
    {
        $where = [
            'nis' => $nis,
            'kode_kelas' => $kelas,
            'kode_jurusan' => $jurusan
        ];
        return $this->db->where($where)->order_by('nama_siswa', 'ASC')
            ->get('tabel_siswa')->result_array();
    }
    public function dataSiswaByKelas($kelas, $jurusan)
    {
        $where = [
            'kode_kelas' => $kelas,
            'kode_jurusan' => $jurusan
        ];
        return $this->db->where($where)->order_by('nama_siswa', 'ASC')
            ->get('tabel_siswa')->result_array();
    }
    public function cekliburnasional($tanggal)
    {
        $where = [
            'tanggal' => $tanggal,
            'status' => 'Aktif'
        ];
        return $this->db->select('*')->where($where)->get('tabel_libur')->num_rows();
    }
    public function cekstatusweekend($day)
    {
        return $this->db->where(['keterangan' => $day])->get('tabel_libur')
            ->result_array();
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
            'kode_kelas' => $idkelas,
            'tipe' => $this->input->post('tipe', true),
        ];
        $this->db->insert('tabel_detail_absen', $data);
    }
    // edit absen
    public function editabsen($nis, $idkelas)
    {
        $data = [
            'jam_absen' => time(),
            'keterangan' => $this->input->post('keterangan')
        ];

        $where = [
            'nis' => $nis,
            'tanggal_absen' => $this->input->post('tgltahun'),
            'kode_kelas' => $idkelas,
            'tipe' => 'Masuk',
        ];
        $this->db->where($where)
            ->update('tabel_detail_absen', $data);
    }
    public function hapusabsen($nis, $idkelas)
    {
        $where = [
            'nis' => $nis,
            'tanggal_absen' => $this->input->post('tgltahun'),
            // 'keterangan' => $this->input->post('keterangan'),
            'kode_kelas' => $idkelas
        ];
        $this->db->delete('tabel_detail_absen', $where);
    }
    public function hapusabsenById($id)
    {
        $this->db->delete('tabel_detail_absen', ['id_detail' => $id]);
    }

    public function inputAbsenBySiswa($datasiswa, $absen, $type)
    {
        $data = [
            'jam_absen' => date('H:i:s'),
            'tanggal_absen' => date('Y-m-d'),
            'nis' => $datasiswa['nis'],
            'keterangan' => $absen,
            'kode_kelas' => $datasiswa['kode_kelas'],
            'tipe' => $type
        ];
        $this->db->insert('tabel_detail_absen', $data);
    }

    // setting jam asen
    public function tampiljamabsen()
    {
        return $this->db->get('tabel_jam_absen')->result_array();
    }
    public function editjamabsen($id)
    {
        $id = $this->input->post('id', true);
        $data = [
            'mulai' => $this->input->post('jammulai', true),
            'selesai' => $this->input->post('jamselesai', true)
        ];
        $this->db->where(['id' => $id]);
        $this->db->update('tabel_jam_absen', $data);
    }
    //
    //settinglibur
    public function tampillibur()
    {
        return $this->db->where(['type' => 'other'])
            ->get('tabel_libur')->result_array();
    }
    public function tampilliburweekend()
    {
        return $this->db->where(['type' => 'weekend'])
            ->get('tabel_libur')->result_array();
    }
    public function tambahlibur()
    {
        $data = [
            'id' => '',
            'type' => $this->input->post('type', true),
            'tanggal' => $this->input->post('tanggal', true),
            'keterangan' => $this->input->post('keterangan', true),
            'status' => $this->input->post('status')
        ];
        $this->db->insert('tabel_libur', $data);
    }
    public function editlibur()
    {
        $id = $this->input->post('id');
        $data = [
            'tanggal' => $this->input->post('tanggal', true),
            'keterangan' => $this->input->post('keterangan', true)
        ];
        $this->db->where(['id' => $id])
            ->update('tabel_libur', $data);
    }
    public function hapuslibur($id)
    {
        $this->db->where(['id' => $id])
            ->delete('tabel_libur');
    }
    public function editliburweekend($id, $status, $hari)
    {
        $this->db->where(['id' => $id, 'keterangan' => $hari])
            ->update('tabel_libur', ['status' => $status]);
    }
    //
}
