<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Poscoa extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		cek_login();
		$this->load->model('Poscoa_m');
	}

	public function index()
	{
		$data = array(
			'title'    => 'Setup Transaksi COA (Chart of Account)',
			'user'     => infoLogin(),
			'toko'     => $this->db->get_where('profil_perusahaan',['id_toko' => $this->session->cabang])->row(),
			'content'  => 'poscoa/frm_setting',
			'coa'	   => $this->Poscoa_m->coa()->result()	
		);
		$this->load->view('templates/main', $data);
	}

	public function LoadData()
	{
		$json = array(
			"aaData"  => $this->Poscoa_m->GetCoa()->result_array()
		);
		echo json_encode($json);
	}

	function Simpan() {
		//simpan
		if ($this->session->id == 0) {
			$this->session->set_flashdata('message','Maaf, Login Holding company tidak dapat menyimpan transaksi ini!');
			redirect(site_url('Poscoa'));
		} else {
			$data['coa_cash'] = $this->input->post('coa_cash');
			$data['coa_transfer'] = $this->input->post('coa_transfer');
			$data['coa_kredit'] = $this->input->post('coa_kredit');
			$this->Poscoa_m->Save($data);
			$this->session->set_flashdata('message','Perubahan Data Telah Berhasil disimpan');
			redirect(site_url('Poscoa'));
		}
	}

}
