<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Barang extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		cek_login();
		$this->load->model('Barang_m');
		$this->load->model('Penjualan_m');
		$this->load->model('Pembelian_m');
	}
	public function index()
	{
		$data = array(
			'title'    => 'Barang',
			'user'     => infoLogin(),
			'kategori' => $this->db->get('kategori')->result_array(),
			'satuan'   => $this->db->get('satuan')->result_array(),
			'supplier' => $this->db->get('supplier')->result_array(),
			'toko'     => $this->db->get('profil_perusahaan')->row(),
			'content'  => 'barang/item/index',
			'item'	   => $this->Barang_m->getAllData()
		);
		$this->load->view('templates/main', $data);
	}

	public function Kartu_barang()
	{
		$data = array(
			'title'    => 'Kartu Barang',
			'user'     => infoLogin(),
			'barang'   => $this->Barang_m->Barang()->Result(),
			'content'  => 'barang/item/filter_kartu_barang'
		);
		$this->load->view('templates/main', $data);
	}

	public function Kartu_barang_filter()
	{
		$data = array(
			'title'    => 'Kartu Barang',
			'user'     => infoLogin(),
			'content'  => 'barang/item/kartu'
		);
		$this->load->view('templates/main', $data);
	}


	public function LoadData()
	{
		$json = array(
			"aaData"  => $this->Barang_m->getAllData()
		);
		echo json_encode($json);
	}

	public function inputbarang()
	{
		$this->Barang_m->Save();
		$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span> </button><b>Success!</b> Data Barang berhasil disimpan.</div>');
		redirect('barang/index');
	}

	public function detilbarang($id = '')
	{
		$data = $this->Barang_m->Detail($id);
		$vhpp = 0;
        //----------------------------- get hpp-------------------
        $sql = "SELECT SUM(subtotal)/ SUM(qty_beli) as hpp FROM detil_pembelian WHERE id_barang=" . $id;
            $hpp = $this->db->query($sql)->row();
            if (isset($hpp->hpp)) {
                if ($hpp->hpp != '') {
                    $vhpp = $hpp->hpp;
                } else {
                    $hpp = $this->db->query('select harga_beli from barang where id_barang=' . $id)->row();
                    $vhpp = $hpp->harga_beli;
                }
            } else {
                $hpp = $this->db->query('select harga_beli from barang where id_barang=' . $id)->row();
                $vhpp = $hpp->harga_beli;
            }
			$data['hpp'] = $vhpp;
		echo json_encode($data);
	}
	public function hapusbarang($id = '')
	{
		$this->Barang_m->Delete($id);
		$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span> </button><b>Success!</b> Data Barang berhasil dihapus.</div>');
	}

	public function caribarang($key = '')
	{
		$data = $this->Barang_m->Search($key);
		echo json_encode($data);
	}

	public function edit($id)
	{
		$id = decrypt_url($id);
		$data = array(
			'title'    => 'Edit Item',
			'user'     => infoLogin(),
			'kategori' => $this->db->get('kategori')->result_array(),
			'satuan'   => $this->db->get('satuan')->result_array(),
			'item'	   => $this->Barang_m->Detail($id),
			'supplier' => $this->db->get('supplier')->result_array(),
			'toko'     => $this->db->get('profil_perusahaan')->row(),
			'content'  => 'barang/item/edititem'
		);
		$this->load->view('templates/main', $data);
	}

	public function editbarang()
	{
		$this->Barang_m->Edit();
		$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span> </button><b>Success!</b> Data Barang berhasil diubah.</div>');
		redirect('barang/index');
	}

	public function updateStok($stok, $id)
	{
		$brg = $this->db->get_where('barang', ['id_barang' => $id])->row_array();
		if ($stok < 0) {
			$qty = abs($stok);
			$stokBrg = $brg['stok'] - $qty;
		} else {

			$stokBrg = $brg['stok'] + $stok;
		}
		$this->db->set(array('stok' => $stokBrg))->where('id_barang', $id)->update('barang');
	}
}
