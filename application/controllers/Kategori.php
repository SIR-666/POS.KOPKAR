<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kategori extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		cek_login();
		$this->load->model('Kategori_m');
	}
	public function index()
	{
		$data = array(
			'title'    	=> 'Kategori',
			'user'     	=> infoLogin(),
			'toko'     	=> $this->db->get('profil_perusahaan')->row(),
			'content'  	=> 'barang/kategori/list_kategori',
			'kategori'	=> $this->Kategori_m->data_kategori()->result(),
			'coa'	    => $this->Kategori_m->data_coa()->result()
		

		);
		$this->load->view('templates/main', $data);
	}

	public function inputkategori()
	{
		$this->Kategori_m->Save();
		$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><aria-hidden="true">×</span> </button><b>Success!</b> Data Kategori berhasil disimpan.</div>');
		redirect('kategori');
	}

	public function detilkategori($id = '')
	{
		$data = $this->Kategori_m->Detail($id);
		echo json_encode($data);
	}

	public function editkategori()
	{
		$this->Kategori_m->Edit();
		$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><aria-hidden="true">×</span> </button><b>Success!</b> Data Kategori berhasil diubah.</div>');
		redirect('kategori');
	}

	public function hapuskategori($id = '')
	{
		$this->Kategori_m->Delete($id);
		$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><aria-hidden="true">×</span> </button><b>Success!</b> Data Kategori berhasil dihapus.</div>');
		redirect('kategori');
	}

	public function cek_delete($id = '')
	{
		$data = $this->Kategori_m->cekDelete($id);
		echo json_encode($data);
	}
}
