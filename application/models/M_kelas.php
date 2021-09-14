<?php

class M_kelas extends CI_Model
{

    public function tampilkelas()
    {
        return $this->db->get('tabel_kelas')->result_array();
    }

    public function ambilkelas($idkelas)
    {
        return $this->db->where('id_kelas', $idkelas)->get('tabel_kelas')->result();
    }
    public function inputkelas()
    {
        $data = [
            'id_kelas' => '',
            'nama_kelas' => $this->input->post('nama_kelas', true),
            'kelas' => $this->input->post('kelas', true)
        ];

        $this->db->insert('tabel_kelas', $data);
    }
}
