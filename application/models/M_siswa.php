<?php
class M_siswa extends CI_Model
{

    public function datasiswa()
    {
        return  $this->db->select('*')
            ->from('tabel_siswa')
            ->join('tabel_kelas', 'tabel_kelas.id_kelas = tabel_siswa.kode_kelas')
            ->get()->result_array();

        // return  $this->db->get('tabel_siswa')->result_array();
    }

    public function dataspesifiksiswa($nis)
    {
        return  $this->db->select('*')
            ->from('tabel_siswa')
            ->join('tabel_kelas', 'tabel_kelas.id_kelas = tabel_siswa.kode_kelas')
            ->where('nis', $nis)->get()->result_array();
    }
    public function inputsiswa($nohp)
    {
        $datasiswa = [
            'id_siswa' => 'SISWA' . random_int(100, 999),
            'nama_siswa' => $this->input->post('nama', true),
            'nis' => $this->input->post('nis', true),
            'tgl_lahir' => $this->input->post('tgl_lahir'),
            'jenis_kelamin' => $this->input->post('jeniskelamin', true),
            'alamat' => $this->input->post('alamat', true),
            'no_telepon' => $nohp,
            'kode_jurusan' => 'default',
            'kode_kelas' => $this->input->post('kelas', true),
            'gambar' => 'default'
        ];
        $this->db->insert('tabel_siswa', $datasiswa);
    }

    public function selectnohp($nomor, $nis)
    {
        return   $this->db->select('no_telepon')
            ->where('nis', $nis)->get('tabel_siswa')->num_rows();
    }

    public function editsiswa($nomorhp)
    {
        $data = [
            'nama_siswa' => $this->input->post('nama', true),
            'nis' => $this->input->post('nis'),
            'tgl_lahir' => $this->input->post('tgl_lahir'),
            'jenis_kelamin' => $this->input->post('jeniskelamin'),
            'alamat' => $this->input->post('alamat', true),
            'no_telepon' => $nomorhp,
            'kode_kelas' => $this->input->post('kelas')

        ];
        $this->db->where('id_siswa', $this->input->post('id_siswa'))
            ->update('tabel_siswa', $data);
    }
    public function deletesiswa($idsiswa)
    {
        $this->db->delete('tabel_siswa', ['id_siswa' => $idsiswa]);
    }
}
