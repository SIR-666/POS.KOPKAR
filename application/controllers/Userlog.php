<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Userlog extends CI_Controller
{
  public function __construct()
  {

    parent::__construct();
    cek_login();
    cek_user();
    $this->load->model('User_m');
  }
  public function index()
  {
    $data = array(
      'title'    => 'User Log',
      'user'     => infoLogin(),
      'toko'     => $this->db->get('profil_perusahaan')->row(),
      'content'  => 'userlog/index',
      'logs'     => $this->User_m->getUserLogs()
    );
    $this->load->view('templates/main', $data);
  }
}
