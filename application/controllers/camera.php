<?php

class Camera extends CI_Controller
{

    public function index()
    {
        $data = [
            'title' => WEBNAME . ' Absen',
            'webname' => WEBNAME,

        ];
        //  $this->load->view('templates/header', $data);
        $this->load->view('absen/siswa');
        // $this->load->view('templates/footer');
    }
}
