<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cabang extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        cek_login();
        $this->load->model('Cabang_m');
    }

    public function LoadData()
    {
        $json = array(
            "aaData"  => $this->Cabang_m->getAllData()
        );
        echo json_encode($json);
    }
}
