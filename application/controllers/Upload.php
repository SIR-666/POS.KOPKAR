<?php
class Upload extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('excel');
        $this->load->model('Barang_m');
    }

    public function index()
    {
        $data = array();

        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $config['upload_path'] = './excel/';
            $config['allowed_types'] = 'xlsx|xls';
            $config['max_size'] = 1024 * 5;
            $tanggal = $_POST['tanggal'];
            $this->load->library('upload', $config);

            if ($this->upload->do_upload('excel_file')) {
                $fileData = $this->upload->data();
                $filename = $fileData['full_path'];
                $data['success'] = 'File berhasil di-upload';

                // Baca data dari file Excel
                $sheet = read_sheet($filename, 0);
                $highestRow = $sheet->getHighestRow();
                $dt = array();
                $tempNik = '';
                $tempId = 0;
                $i = 0;
                for ($row = 2; $row <= $highestRow; $row++) {
                    $rowdata = array();
                    $cekProduk = 0;
                    $rowdata['method'] = $sheet->getCell('A' . $row)->getValue();
                    $rowdata['nama'] = $sheet->getCell('B' . $row)->getValue();
                    $rowdata['nik'] = $sheet->getCell('C' . $row)->getValue();
                    $rowdata['item'] = $sheet->getCell('D' . $row)->getValue();
                    $rowdata['barcode'] = $sheet->getCell('E' . $row)->getValue();
                    $rowdata['qty'] = $sheet->getCell('F' . $row)->getValue();
                    $rowdata['harga'] = $sheet->getCell('G' . $row)->getValue();
                    $rowdata['ket'] = '';
                    $cekAnggota = $this->db->get_where('tbl_anggota', array('nik' => $rowdata['nik']))->row();
                    $cekProduk = $this->db->get_where('barang', array('barcode' => $rowdata['barcode']))->row();
                    if ($rowdata['nik'] == '' || isset($cekAnggota->id)) {
                        if (isset($cekProduk->id_barang)) {
                            if ($rowdata['nik'] != $tempNik) {
                                //simpan ke jurnal,piutang,kas untuk transaksi by nik sebelumnya
                                if ($tempId != 0) {
                                    $this->simpanPenjualan($tempId);
                                }

                                //input header penjualan baru
                                $i++;
                                date_default_timezone_set('Asia/Jakarta');
                                $kodeinvoice = "POS" . date('YmdHis') . $i;
                                $this->db->select("RIGHT (penjualan.kode_jual, 7) as kode_jual", false);
                                $this->db->order_by("kode_jual", "DESC");
                                $this->db->limit(1);
                                $query = $this->db->get('penjualan');

                                if ($query->num_rows() <> 0) {
                                    $data = $query->row();
                                    $kode = intval($data->kode_jual) + 1;
                                } else {
                                    $kode = 1;
                                }

                                $kodejual = str_pad($kode, 7, "0", STR_PAD_LEFT);

                                $kodepenjualan = "KJ-" . $kodejual;
                                //                
                                $data = array(
                                    'id_user'     => '1',
                                    'id_cs'       => $rowdata['nik'] == '' ? '0' : $cekAnggota->id,
                                    'kode_jual'   => $kodepenjualan,
                                    'invoice'     => $kodeinvoice,
                                    'method'      => $rowdata['method'],
                                    'bayar'       => $rowdata['method'] == 'Kredit' ? '0' : '99999',
                                    'kembali'     => 0,
                                    'ppn'         => 0,
                                    'tgl'         => $tanggal,
                                    'is_active'   => 1,
                                    'cabang'      => 1
                                );
                                $this->db->insert('penjualan', $data);
                                $tempId = $this->db->insert_id();
                                //set variable
                                $tempNik = $rowdata['nik'];
                            }
                            //add item
                            $this->addItem($cekProduk->id_barang, $rowdata['qty'], $rowdata['harga'], 1, $tempId);
                            $rowdata['ket'] = $tempId;
                        } else {
                            $rowdata['ket'] = 'data barang tidak ditemukan';
                        }
                    } else {
                        $rowdata['ket'] = 'data anggota tidak ditemukan';
                    }
                    $dt[] = $rowdata;
                }
                //simpan ke jurnal,piutang,kas untuk transaksi by nik sebelumnya
                if ($tempId != 0) {
                    $this->simpanPenjualan($tempId);
                }
                $data['excel_data'] = $dt;
            } else {
                $data['error'] = $this->upload->display_errors();
            }
        }

        $this->load->view('upload_form', $data);
    }

    public function simpanPenjualan($id)
    {
        //load penjualan
        $dt = $this->db->get_where('penjualan', array('id_jual' => $id))->row();
        $sql = "select detil_penjualan.id_detil_jual,detil_penjualan.subtotal,detil_penjualan.qty_jual,detil_penjualan.id_barang, kategori.coa_persediaan, kategori.coa_penjualan, kategori.coa_hpp, detil_penjualan.hpp from detil_penjualan inner join barang on barang.id_barang=detil_penjualan.id_barang inner join kategori on kategori.id_kategori=barang.id_kategori where detil_penjualan.id_jual='$id'";
        $dtDetil = $this->db->query($sql)->result();
        $nominal = 0;
        foreach ($dtDetil as $det) {
            $nominal = $nominal + $det->subtotal;
        }
        //

        $coaCash = '11110-000';
        $coaKredit = '11210-000';
        $coaTransfer = '11111-000';
        if ($dt->method == 'Cash') {
            $coaD = $coaCash;
            //insert ke table kas
            $this->db->select("RIGHT (kas.kode_kas, 7) as kode_kas", false);
            $this->db->order_by("kode_kas", "DESC");
            $this->db->limit(1);
            $query = $this->db->get('kas');

            if ($query->num_rows() <> 0) {
                $data = $query->row();
                $kode = intval($data->kode_kas) + 1;
            } else {
                $kode = 1;
            }
            $kodeks = str_pad($kode, 7, "0", STR_PAD_LEFT);
            $kodekas = "KS-" . $kodeks;
            $kas = array(
                'id_user'     => $this->input->post('kasir'),
                'kode_kas'    => $kodekas,
                'tanggal'     => $dt->tgl,
                'jenis'       => 'Pemasukan',
                'keterangan'  => 'Penjualan',
                'nominal'     => $nominal,
                'cabang'      => '1',
                'kode_trans'  =>   $dt->kode_jual,
            );
            $this->db->insert('kas', $kas);
            //uupdate bayar penjualan
            $this->db->update('penjualan', array('bayar' => $nominal), array('id_jual' => $id));
        } elseif ($dt->method == 'Transfer') {
            $coaD = $coaTransfer;
        } else {
            $coaD = $coaKredit;
            $jml_piutang = $nominal;
            $date = date_create($dt->tgl);
            date_add($date, date_interval_create_from_date_string("1 months"));
            $jttempo = date_format($date, "Y-m-d");
            $piutang = array(
                'id_jual'        => $id,
                'tgl_piutang'    => $dt->tgl,
                'jml_piutang'    => $jml_piutang,
                'bayar'          => 0,
                'sisa'           => $jml_piutang,
                'status'         => 'Belum Lunas',
                'jatuh_tempo'    => $jttempo,
                'cabang'         => 1
            );
            $this->db->insert('piutang', $piutang);
        }




        //---------------- insert ke jurnal umum debet-----------------------
        $journal = array(
            'vcIDJournal'       => $dt->kode_jual,
            'dtJournal'         => $dt->tgl,
            'vcCOAJournal'      => $coaD,
            'cuJournalDebet'    => $nominal,
            'cuJournalCredit'   => '0',
            'vcJournalDesc'     => 'Transaksi Penjualan',
            'itPostJournal'     =>  '1',
            'vcUserID'          => 'admin',
        );
        $this->db->insert('tbl_journal', $journal);

        //-------------------------------------------------------------

        //--------------------jurnal kredit-----------

        foreach ($dtDetil as $b) {
            $journal = array(
                'vcIDJournal'       => $dt->kode_jual,
                'dtJournal'         => $dt->tgl,
                'vcCOAJournal'      => $b->coa_penjualan,
                'cuJournalDebet'    => '0',
                'cuJournalCredit'   => $b->subtotal,
                'vcJournalDesc'     => 'Transaksi Penjualan',
                'itPostJournal'     =>  '1',
                'vcUserID'          => 'admin',
            );
            $this->db->insert('tbl_journal', $journal);
            //----------------------------- get hpp-------------------
            $vhpp = $b->hpp;

            $journal = array(
                'vcIDJournal'       => $dt->kode_jual,
                'dtJournal'         => $dt->tgl,
                'vcCOAJournal'      => $b->coa_hpp,
                'cuJournalDebet'    => $vhpp * $b->qty_jual,
                'cuJournalCredit'   => '0',
                'vcJournalDesc'     => 'Transaksi Penjualan',
                'itPostJournal'     =>  '1',
                'vcUserID'          => 'admin',
            );
            $this->db->insert('tbl_journal', $journal);
            $journal = array(
                'vcIDJournal'       => $dt->kode_jual,
                'dtJournal'         => $dt->tgl,
                'vcCOAJournal'      => $b->coa_persediaan,
                'cuJournalDebet'    => '0',
                'cuJournalCredit'   => $vhpp * $b->qty_jual,
                'vcJournalDesc'     => 'Transaksi Penjualan',
                'itPostJournal'     =>  '1',
                'vcUserID'          => 'admin',
            );
            $this->db->insert('tbl_journal', $journal);
        }
    }

    public function addItem($id, $qty, $harga, $operator, $idjual)
    {
        //get subtotal
        $subtotal = $qty * $harga;

        //get hpp
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
        //      


        $this->db->select("RIGHT (detil_penjualan.kode_detil_jual, 7) as kode_detil_jual", false);
        $this->db->order_by("kode_detil_jual", "DESC");
        $this->db->limit(1);
        $query = $this->db->get('detil_penjualan');

        if ($query->num_rows() <> 0) {
            $data = $query->row();
            $kode = intval($data->kode_detil_jual) + 1;
        } else {
            $kode = 1;
        }
        $kodedetil = str_pad($kode, 7, "0", STR_PAD_LEFT);
        $detiljual = "DJ-" . $kodedetil;
        $data = array(
            'id_jual'             => $idjual,
            'id_barang'           => $id,
            'id_servis'           => null,
            'id_karyawan'         => null,
            'kode_detil_jual'     => $detiljual,
            'diskon'              => 0,
            'harga_item'          => $harga,
            'qty_jual'            => $qty,
            'subtotal'            => $subtotal,
            'id_user'             => $operator,
            'hpp'                 => $vhpp

        );
        $this->db->insert('detil_penjualan', $data);
    }

    public function PiutangToko1()
    {
        $data = array();

        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $config['upload_path'] = './excel/';
            $config['allowed_types'] = 'xlsx|xls';
            $config['max_size'] = 1024 * 5;
            $tanggal = $_POST['tanggal'];
            $this->load->library('upload', $config);

            if ($this->upload->do_upload('excel_file')) {
                $fileData = $this->upload->data();
                $filename = $fileData['full_path'];
                $data['success'] = 'File berhasil di-upload';

                // Baca data dari file Excel
                $sheet = read_sheet($filename, 0);
                $highestRow = $sheet->getHighestRow();
                $dt = array();
                $tempNik = '';
                $tempId = 0;
                $i = 0;
                $idAnggota = 0;
                for ($row = 2; $row <= $highestRow; $row++) {
                    $rowdata = array();
                    $cekProduk = 0;
                    $rowdata['tgl'] = $sheet->getCell('A' . $row)->getValue();
                    $rowdata['nama'] = $sheet->getCell('B' . $row)->getValue();
                    $rowdata['nik'] = $sheet->getCell('C' . $row)->getValue();
                    $rowdata['item'] = $sheet->getCell('D' . $row)->getValue();
                    $rowdata['barcode'] = $sheet->getCell('E' . $row)->getValue();
                    $rowdata['qty'] = $sheet->getCell('F' . $row)->getValue();
                    $rowdata['harga'] = $sheet->getCell('G' . $row)->getValue();
                    $rowdata['total'] = $sheet->getCell('H' . $row)->getValue();
                    $rowdata['tgl2'] = $sheet->getCell('I' . $row)->getValue();
                    $rowdata['ket'] = '';
                    //jika value nya NIK maka proses menghapus/lemparTgl transaksi penjualan pada nik ini dibulan januari 2023
                    if ($rowdata['tgl'] == 'NIK') {
                        $idAnggota = 0;
                        $tempNik = $rowdata['nama'];
                        $cekAnggota = $this->db->get_where('tbl_anggota', array('nik' => $tempNik))->row();
                        if (isset($cekAnggota)) {
                            $idAnggota = $cekAnggota->id;
                            $trans = $this->db->query('select id_jual,kode_jual from penjualan where id_cs=' . $idAnggota . " and method='Kredit' and tgl like '2023-01-%'")->result();
                            foreach ($trans as $t) {
                                $this->db->update('tbl_journal', array('tdJournal'=>'2100-01-01'), array('vcIDJournal'=>$t->kode_jual));
                                $this->db->update('penjualan', array('tgl'=>'2100-01-01'), array('id_jual'=>$t->id_jual));
                                $this->db->update('piutang', array('tgl_piutang'=>'2100-01-01','jatuh_tempo'=>'2100-02-01'), array('id_jual'=>$t->id_jual));
                            }
                        } else {
                            echo "NIK : " . $tempNik . " Tidak Ditemukan";
                            die;
                        }
                    } else {
                        //proses jika data anggota sudah diketahui
                        if ($idAnggota != 0) {
                            $idbrg = 0;
                            $cekProduk = $this->db->get_where('barang', array('barcode' => $rowdata['barcode']))->row();
                            if (isset($cekProduk->id_barang)) {
                                $idbrg = $cekProduk->id_barang;
                            } else {
                                $cekProduk = $this->db->get_where('barang', array('id_barang' => $rowdata['barcode']))->row();
                                if (isset($cekProduk->id_barang)) {
                                    $idbrg = $rowdata['barcode'];
                                } else {
                                    echo "NIK  : " . $tempNik . "=>id Barang : " . $rowdata['barcode'] . " tidak ditemukan";
                                    die;
                                }
                            }
                            if ($idbrg != 0) {
                                //input header penjualan baru
                                $i++;
                                date_default_timezone_set('Asia/Jakarta');
                                $kodeinvoice = "POS" . date('YmdHis') . $i;
                                $this->db->select("RIGHT (penjualan.kode_jual, 7) as kode_jual", false);
                                $this->db->order_by("kode_jual", "DESC");
                                $this->db->limit(1);
                                $query = $this->db->get('penjualan');

                                if ($query->num_rows() <> 0) {
                                    $data = $query->row();
                                    $kode = intval($data->kode_jual) + 1;
                                } else {
                                    $kode = 1;
                                }

                                $kodejual = str_pad($kode, 7, "0", STR_PAD_LEFT);

                                $kodepenjualan = "KJ-" . $kodejual;
                                                    //
                                $data = array(
                                    'id_user'     => '1',
                                    'id_cs'       => $idAnggota,
                                    'kode_jual'   => $kodepenjualan,
                                    'invoice'     => $kodeinvoice,
                                    'method'      => 'Kredit',
                                    'bayar'       => '0',
                                    'kembali'     => 0,
                                    'ppn'         => 0,
                                    'tgl'         => $rowdata['tgl2'],
                                    'is_active'   => 1,
                                    'cabang'      => 1
                                );
                                $this->db->insert('penjualan', $data);
                                $tempId = $this->db->insert_id();
                                //add item penjualan
                                $this->addItem($idbrg, $rowdata['qty'], $rowdata['harga'], 1, $tempId);

                                //add item piutang
                                $this->db->insert('piutang',array('id_jual'=>$tempId,'tgl_piutang'=>$rowdata['tgl2'],'jml_piutang'=>$rowdata['total'],'bayar'=>0,'sisa'=>$rowdata['total'],'status'=>'Belum Lunas','jatuh_tempo'=>'2023-02-01','cabang'=>1));
                                $rowdata['ket'] = $tempId;
                            }
                        }
                    }
                    $dt[] = $rowdata;
                }
                $data['excel_data'] = $dt;
            } else {
                $data['error'] = $this->upload->display_errors();
            }
        }

        $this->load->view('upload_form2', $data);
    }    

    public function PiutangToko2()
    {
        $data = array();

        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $config['upload_path'] = './excel/';
            $config['allowed_types'] = 'xlsx|xls';
            $config['max_size'] = 1024 * 5;
            $tanggal = $_POST['tanggal'];
            $this->load->library('upload', $config);

            if ($this->upload->do_upload('excel_file')) {
                $fileData = $this->upload->data();
                $filename = $fileData['full_path'];
                $data['success'] = 'File berhasil di-upload';

                // Baca data dari file Excel
                $sheet = read_sheet($filename, 0);
                $highestRow = $sheet->getHighestRow();
                $dt = array();
                $tempNik = '';
                $tempId = 0;
                $i = 0;
                $idAnggota = 0;
                for ($row = 2; $row <= $highestRow; $row++) {
                    $rowdata = array();
                    $cekProduk = 0;
                    $rowdata['tgl'] = $sheet->getCell('A' . $row)->getValue();
                    $rowdata['nama'] = $sheet->getCell('B' . $row)->getValue();
                    $rowdata['nik'] = $sheet->getCell('C' . $row)->getValue();
                    $rowdata['item'] = $sheet->getCell('D' . $row)->getValue();
                    $rowdata['barcode'] = $sheet->getCell('E' . $row)->getValue();
                    $rowdata['qty'] = $sheet->getCell('F' . $row)->getValue();
                    $rowdata['harga'] = $sheet->getCell('G' . $row)->getValue();
                    $rowdata['total'] = $sheet->getCell('H' . $row)->getValue();
                    $rowdata['tgl2'] = $sheet->getCell('I' . $row)->getValue();
                    $rowdata['ket'] = '';
                    //jika value nya NIK maka proses menghapus/lemparTgl transaksi penjualan pada nik ini dibulan januari 2023
                    if ($rowdata['tgl'] == 'NIK') {
                        $idAnggota = 0;
                        $tempNik = $rowdata['nama'];
                        $cekAnggota = $this->db->get_where('tbl_anggota', array('nik' => $tempNik))->row();
                        if (isset($cekAnggota)) {
                            $idAnggota = $cekAnggota->id;
                            $trans = $this->db->query('select id_jual,kode_jual from penjualan where id_cs=' . $idAnggota . " and method='Kredit' and tgl like '2023-02-%'")->result();
                            foreach ($trans as $t) {
                                $this->db->update('tbl_journal', array('tdJournal'=>'2100-02-01'), array('vcIDJournal'=>$t->kode_jual));
                                $this->db->update('penjualan', array('tgl'=>'2100-02-01'), array('id_jual'=>$t->id_jual));
                                $this->db->update('piutang', array('tgl_piutang'=>'2100-02-01','jatuh_tempo'=>'2100-03-01'), array('id_jual'=>$t->id_jual));
                            }
                        } else {
                            echo "NIK : " . $tempNik . " Tidak Ditemukan";
                            die;
                        }
                    } else {
                        //proses jika data anggota sudah diketahui
                        if ($idAnggota != 0) {
                            $idbrg = 0;
                            $cekProduk = $this->db->get_where('barang', array('barcode' => $rowdata['barcode']))->row();
                            if (isset($cekProduk->id_barang)) {
                                $idbrg = $cekProduk->id_barang;
                            } else {
                                $cekProduk = $this->db->get_where('barang', array('id_barang' => $rowdata['barcode']))->row();
                                if (isset($cekProduk->id_barang)) {
                                    $idbrg = $rowdata['barcode'];
                                } else {
                                    echo "NIK  : " . $tempNik . "=>id Barang : " . $rowdata['barcode'] . " tidak ditemukan";
                                    die;
                                }
                            }
                            if ($idbrg != 0) {
                                //input header penjualan baru
                                $i++;
                                date_default_timezone_set('Asia/Jakarta');
                                $kodeinvoice = "POS" . date('YmdHis') . $i;
                                $this->db->select("RIGHT (penjualan.kode_jual, 7) as kode_jual", false);
                                $this->db->order_by("kode_jual", "DESC");
                                $this->db->limit(1);
                                $query = $this->db->get('penjualan');

                                if ($query->num_rows() <> 0) {
                                    $data = $query->row();
                                    $kode = intval($data->kode_jual) + 1;
                                } else {
                                    $kode = 1;
                                }

                                $kodejual = str_pad($kode, 7, "0", STR_PAD_LEFT);

                                $kodepenjualan = "KJ-" . $kodejual;
                                                    //
                                $data = array(
                                    'id_user'     => '1',
                                    'id_cs'       => $idAnggota,
                                    'kode_jual'   => $kodepenjualan,
                                    'invoice'     => $kodeinvoice,
                                    'method'      => 'Kredit',
                                    'bayar'       => '0',
                                    'kembali'     => 0,
                                    'ppn'         => 0,
                                    'tgl'         => $rowdata['tgl2'],
                                    'is_active'   => 1,
                                    'cabang'      => 1
                                );
                                $this->db->insert('penjualan', $data);
                                $tempId = $this->db->insert_id();
                                //add item penjualan
                                $this->addItem($idbrg, $rowdata['qty'], $rowdata['harga'], 1, $tempId);

                                //add item piutang
                                $this->db->insert('piutang',array('id_jual'=>$tempId,'tgl_piutang'=>$rowdata['tgl2'],'jml_piutang'=>$rowdata['total'],'bayar'=>0,'sisa'=>$rowdata['total'],'status'=>'Belum Lunas','jatuh_tempo'=>'2023-03-01','cabang'=>1));
                                $rowdata['ket'] = $tempId;
                            }
                        }
                    }
                    $dt[] = $rowdata;
                }
                $data['excel_data'] = $dt;
            } else {
                $data['error'] = $this->upload->display_errors();
            }
        }

        $this->load->view('upload_form3', $data);
    }    
}
