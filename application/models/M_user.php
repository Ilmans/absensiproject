<?php

class M_user extends CI_Model
{
    public function datauser()
    {
        return $this->db->get('tabel_user')
            ->result_array();
    }
    public function getUserById($id_user)
    {
        return $this->db->where('id', $id_user)
            ->get('tabel_user')->result_array();
    }

    public function deleteuser($iduser)
    {
        $this->db
            ->delete('tabel_user', ['id' => $iduser]);
    }

    public function edituser($foto)
    {
        $data = [
            'name' => $this->input->post('nama', true),
            'email' => $this->input->post('email', true),
            'image' => $foto,
            'is_active' => $this->input->post('is_active', true)
        ];
        $iduser = $this->input->post('id_user');
        $this->db->where('id', $iduser)
            ->update('tabel_user', $data);
    }

    // verifi email
    public function cekkodeunik($kodeunik, $email)
    {
        return $this->db->where(['email' => $email, 'kode_unik' => $kodeunik])
            ->get('tabel_user')->num_rows();
    }
    public function aktifkanuser($email)
    {
        $data = [
            'is_active' => 1
        ];
        $this->db->where('email', $email)->update('tabel_user', $data);
    }

    public function resetkodeunik($email)
    {
        $data = [
            'kode_unik' => null
        ];
        $this->db->where('email', $email)->update('tabel_user', $data);
    }
    //
}
