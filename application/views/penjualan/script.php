<script>
    function tampildata() {

        $('#daftarbarang').DataTable({
            "bProcessing": true,
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "sAjaxSource": '<?= site_url() ?>' + 'barang/LoadData',
            "sAjaxDataProp": "aaData",
            "fnRender": function(oObj) {
                uss = oObj.aData["Username"];
            },
            "aoColumns": [{
                    "mDataProp": function(data, type, val) {
                        var gambar = `<img src="<?php echo site_url('assets/img/produk/') ?>${data.gambar}" class=" mx-auto d-block" width="80px" height="80px" alt="...">`

                        return (gambar).toString();
                    },

                    bSearchable: true
                },
                {
                    "mDataProp": "barcode",
                    bSearchable: true
                },
                {
                    "mDataProp": "nama_barang",
                    bSearchable: true
                },
                {
                    "mDataProp": "satuan",
                    bSearchable: true
                },
                {
                    "mDataProp": "stok",
                    bSearchable: true
                },
                {
                    "mDataProp": "harga_jual",
                    bSearchable: true
                },
                {
                    "mDataProp": function(data, type, val) {
                        // Define the item code
                        var pKode = data.id_barang;

                        // Check the stock condition
                        if (data.stok < 1) {
                            // Return an empty string if stock is less than 1
                            return ''; // or return 'Out of stock' if you want to show a message
                        } else {
                            // Create the button markup if stock is sufficient
                            var btn = '<a href="#" id="pilihitem" class="btn btn-primary btn-xs" data-dismiss="modal" title="Pilih Data" onclick="pilihbarang(' + pKode + ')">' +
                                    '<i class="fa fa-check-square-o"></i> Select</a>';
                            return btn; // Return the button markup
                        }
                    },
                    bSortable: false,
                    bSearchable: false
                }

            ],
            "bDestroy": true,
        });

        $('#showDataModal').modal('show');
    }

    function pilihbarang(e) {
        var customer = $('#customer').val();
        $.ajax({
            url: '<?= site_url() ?>' + "barang/detilbarang/" + e,
            type: "post",
            success: function(data) {
                var obj = JSON.parse(data);
                if (customer == 0) {
                    $('#harga').val(obj.harga_jual);
                    $('#hpp').val(obj.hpp);
                    $('#namaitem').val(obj.nama_barang);
                    $('#idbarangitem').val(obj.id_barang);
                } else {
                    $.ajax({
                        url: '<?= site_url() ?>' + "customer/detilcustomer/" + customer,
                        type: "post",
                        success: function(result) {
                            var res = JSON.parse(result);
                            if (res.jenis_cs == "Umum") {

                                $('#harga').val(obj.harga_jual);

                            } else if (res.jenis_cs == "Toko") {

                                $('#harga').val(obj.harga_toko);

                            } else if (res.jenis_cs == "Pelanggan" || res.jenis_cs == "Anggota") {

                                if (obj.harga_pelanggan == 0) {
                                    $('#harga').val(obj.harga_jual);
                                } else {
                                    $('#harga').val(obj.harga_pelanggan);
                                }
                                
                            } else if (res.jenis_cs == "Sales") {

                                $('#harga').val(obj.harga_sales);
                            }
                            $('#namaitem').val(obj.nama_barang);
                            $('#idbarangitem').val(obj.id_barang);
                            $('#hpp').val(obj.hpp);
                        }
                    })
                }
            }
        })
    }

    function addItemByClick() {
        SetBolehKredit();
        var jenis = $('#jenis').val();
        var harga = $('#harga').val();
        var pegawai = $('#pegawai').val();
        var operator = $('#idoperator').val();
        var hpp = $('#hpp').val();
        var id, qty, subtotal;
        if (jenis == "Produk") {
            qty = $('#qty').val();
            subtotal = qty * harga;
            id = $('#idbarangitem').val();
        } else if (jenis == "Servis") {
            id = $('#idservis').val();
            subtotal = harga;
            qty = 1;
            if (pegawai == null) {
                alert('Field Tidak Boleh Kosong!');
            }
        }

        var barcode = document.getElementById('barcode');

        if (qty == "") {
            alert('Field Tidak Boleh Kosong!')
        } else {

            $.ajax({
                url: '<?= site_url() ?>' + "penjualan/tambahbarang/" + id + '/' + qty + '/' + subtotal + '/' + harga + '/' + jenis + '/' + pegawai + '/' + operator + '/' + hpp,
                type: "post",
                success: function(data) {
                    var obj = JSON.parse(data);
                    LoadItemBarang();
                    LoadService();
                    barcode.value = "";
                    barcode.focus();
                    document.getElementById('qty').value = "1";
                    var ppn = obj.subtotal * 11 / 100;
                    var hargaAkhir = Number(obj.subtotal) + ppn;
                    $('#subtot').html(obj.subtotal);
                    $('#subtotal').val(obj.subtotal);
                    $('#grandtotal').val(obj.subtotal);
                    // $('#nominal_ppn').val(ppn);
                    $('#nominal').val(obj.subtotal);
                }
            });
        }
    }

    function addItemByScan() {
        var id = $('#idbarangitem').val();
        pilihbarang(id);
        SetBolehKredit();
        var customer = $('#customer').val();
        var pegawai = null;
        var jenis = "Produk";
        var qty = 1;
        var harga = $('#harga').val();
        var subtotal = qty * harga;
        var operator = $('#idoperator').val();
        
        var hpp = $('#hpp').val();
        var barcode = document.getElementById('barcode');
        $.ajax({
            url: '<?= site_url() ?>' + "penjualan/tambahbarangbyscan/" + id + '/' + qty + '/' + subtotal + '/' + harga + '/' + jenis + '/' + pegawai + '/' + operator + '/' + customer ,
            type: "post",
            success: function(data) {
                var obj = JSON.parse(data);
                LoadItemBarang();
                barcode.value = "";
                barcode.focus();
                document.getElementById('qty').value = "";
                var ppn = obj.subtotal * 11 / 100;
                var hargaAkhir = ppn + Number(obj.subtotal);
                $('#subtot').html(obj.subtotal);
                $('#subtotal').val(obj.subtotal);
                $('#grandtotal').val(obj.subtotal);
                // $('#nominal_ppn').val(ppn);
                $('#nominal').val(obj.subtotal);
            }
        });
    }

    function LoadItemBarang() {
        $('#detilitem').DataTable({
            "bProcessing": true,
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "sAjaxSource": '<?= site_url() ?>' + 'penjualan/LoadData',
            "sAjaxDataProp": "aaData",
            "fnRender": function(oObj) {
                uss = oObj.aData["Username"];
            },
            "aoColumns": [{
                    "mDataProp": "barcode",
                    bSearchable: true
                },
                {
                    "mDataProp": "nama_barang",
                    bSearchable: true
                },
                {
                    "mDataProp": "harga_jual",
                    bSearchable: true
                },
                {
                    "mDataProp": "qty_jual",
                    bSearchable: true
                },
                {
                    "mDataProp": "diskon",
                    bSearchable: true
                },
                {
                    "mDataProp": "subtotal",
                    bSearchable: true
                },
                {
                    "mDataProp": function(data, type, val) {
                        pKode = data.id_detil_jual;
                        var btn = '<a href="#" class="btn btn-primary btn-xs" title="Edit Data" onclick="editDetilItem(' + pKode + ')"><i class="fa fa-edit"></i></a> \n\ <a href="#" class="btn btn-danger btn-xs" title="Hapus Data" onclick="hapusDetilItem(' + pKode + ')"><i class="fa fa-trash "></i></a>';

                        return (btn).toString();
                    },
                    bSortable: false,
                    bSearchable: false
                }
            ],
            "bDestroy": true,
        });
    }

    function LoadService() {
        $('#detilservis').DataTable({
            "bProcessing": true,
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "sAjaxSource": '<?= site_url() ?>' + 'penjualan/LoadDataService',
            "sAjaxDataProp": "aaData",
            "fnRender": function(oObj) {
                uss = oObj.aData["Username"];
            },
            "aoColumns": [{
                    "mDataProp": "kode",
                    bSearchable: true
                },
                {
                    "mDataProp": "nama_servis",
                    bSearchable: true
                },
                {
                    "mDataProp": "nama_karyawan",
                    bSearchable: true
                },
                {
                    "mDataProp": "harga_item",
                    bSearchable: true
                },
                {
                    "mDataProp": "subtotal",
                    bSearchable: true
                },
                {
                    "mDataProp": function(data, type, val) {
                        pKode = data.id_detil_jual;
                        var btn = '<a href="#" class="btn btn-primary btn-xs" title="Edit Data" onclick="editDetilServis(' + pKode + ')"><i class="fa fa-edit"></i></a> \n\ <a href="#" class="btn btn-danger btn-xs" title="Hapus Data" onclick="hapusDetilService(' + pKode + ')"><i class="fa fa-trash "></i></a>';

                        return (btn).toString();
                    },
                    bSortable: false,
                    bSearchable: false
                }
            ],
            "bDestroy": true,
        });
    }

    function OnLoadForm() {
        LoadItemBarang();
        LoadService();
    }

    function editDetilServis(e) {
        var qty = $('#detilqty');
        var diskon = $('#detildiskonitem');
        var subtotal = $('#detiltotalitem');
        $.ajax({
            url: '<?= site_url() ?>' + "penjualan/detilservisjual/" + e,
            type: "post",
            success: function(data) {
                var obj = JSON.parse(data);
                $('#id_detil_jual').val(obj.id_detil_jual);
                $('#edit_kode_servis').val(obj.kode);
                $('#nama_detil_servis').val(obj.nama_servis);
                $('#harga_detil_servis').val(obj.harga_item);
                $('#detil_qty').val(obj.qty_jual);
                $('#detil_total_servis').val(obj.subtotal);

            }
        });
        $('#editDetilServisModal').modal('show');
    }

    function editDetilItem(e) {
        var qty = $('#detilqty');
        var diskon = $('#detildiskonitem');
        var subtotal = $('#detiltotalitem');
        $.ajax({
            url: '<?= site_url() ?>' + "penjualan/detilitemjual/" + e,
            type: "post",
            success: function(data) {
                var obj = JSON.parse(data);
                $('#iddetiljual').val(obj.id_detil_jual);
                $('#iddetilbarang').val(obj.id_barang);
                $('#editdetilbarcode').val(obj.barcode);
                $('#namadetilitem').val(obj.nama_barang);
                $('#hargadetilitem').val(obj.harga_jual);
                $('#detilqty').val(obj.qty_jual);
                $('#hideqty').val(obj.qty_jual);
                $('#detildiskonitem').val(obj.diskon);
                $('#detiltotalitem').val(obj.subtotal);
                $('#detilhpp').val(obj.hpp);
            }
        });
        $('#editDetilModal').modal('show');
    }

    function hapusDetilItem(e) {
        Swal.fire({
            title: "Are you sure ?",
            text: "Deleted data can not be restored!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: '<?= site_url() ?>' + "penjualan/hapusdetil/" + e,
                    type: "post",
                    success: function(data) {
                        LoadItemBarang();
                        SetBolehKredit();
                        var obj = JSON.parse(data);
                        var ppn = obj.subtotal * 10 / 100;
                        var hargaAkhir = ppn + Number(obj.subtotal);
                        if (obj.subtotal != null) {
                            $('#subtot').text(obj.subtotal);
                        } else {
                            $('#subtot').text(0);
                        }
                    }
                })
            }
        })
    }

    function hapusDetilService(e) {
        Swal.fire({
            title: "Are you sure ?",
            text: "Deleted data can not be restored!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: '<?= site_url() ?>' + "penjualan/hapusdetil/" + e,
                    type: "post",
                    success: function(data) {
                        LoadService();
                        var obj = JSON.parse(data);
                        var ppn = obj.subtotal * 10 / 100;
                        var hargaAkhir = ppn + Number(obj.subtotal);
                        if (obj.subtotal != null) {
                            $('#subtot').text(obj.subtotal);
                        } else {
                            $('#subtot').text(0);
                        }
                    }
                })
            }
        })
    }

    function editDetilJual() {
        var id = $('#iddetiljual').val();
        var qty = $('#detilqty').val();
        var qty1 = $('#hideqty').val();
        var diskon = $('#detildiskonitem').val();
        var subtotal = $('#detiltotalitem').val();
        var idBrg = $('#iddetilbarang').val();
        var hpp = $('#detilhpp').val();
        $.ajax({
            url: '<?= site_url() ?>' + "penjualan/editdetiljual/" + id + '/' + diskon + '/' + qty + '/' + subtotal + '/' + hpp,
            type: "post",
            success: function(data) {
                var stok = qty1 - qty;
                updateStok(stok, idBrg);
                LoadItemBarang();
                $.ajax({
                    url: '<?= site_url() ?>' + "penjualan/hargatotal",
                    type: "post",
                    success: function(data) {
                        var obj = JSON.parse(data);
                        var ppn = obj.subtotal * 10 / 100;
                        var hargaAkhir = ppn + Number(obj.subtotal);
                        $('#subtot').html(obj.subtotal);
                        $('#subtotal').val(obj.subtotal);
                        $('#grandtotal').val(obj.subtotal);
                        $('#diskon1').val(obj.diskon);
                        SetBolehKredit();
                    }
                });
            }
        });
    }

    function editServisJual() {
        const id = $('#id_detil_jual').val();
        const qty = $('#detil_qty').val();
        const harga = $('#harga_detil_servis').val();
        const subtotal = $('#detil_total_servis').val();
        $.ajax({
            url: '<?= site_url() ?>' + "penjualan/editservisjual/" + id + '/' + harga + '/' + subtotal,
            type: "post",
            success: function(data) {
                LoadService();
                $.ajax({
                    url: '<?= site_url() ?>' + "penjualan/hargatotal",
                    type: "post",
                    success: function(data) {
                        var obj = JSON.parse(data);
                        // var ppn = obj.subtotal * 10 / 100;
                        // var hargaAkhir = ppn + Number(obj.subtotal);
                        $('#subtot').html(obj.subtotal);
                        $('#subtotal').val(obj.subtotal);
                        $('#grandtotal').val(obj.subtotal);
                        $('#diskon1').val(obj.diskon);

                    }
                });
            }
        });
    }

    function updateStok(stok, id) {
        $.ajax({
            url: '<?= site_url() ?>' + "barang/updateStok/" + stok + '/' + id,
            type: "post",
            success: function(data) {

            }
        });
    }

    function simpanPenjualan() {
        SetBolehKredit();
        var cs = $('#customer').val();
        var user = $('#idoperator').val();
        $('#cus').val(cs);
        $('#kasir').val(user);
        $.ajax({
            url: '<?= site_url() ?>' + "penjualan/hargatotal",
            type: "post",
            success: function(data) {
                var obj = JSON.parse(data);
                var ppn = obj.subtotal * 10 / 100;
                var hargaAkhir = ppn + Number(obj.subtotal);
                const ck = document.getElementById('cash');
                $('#diskon1').val(obj.diskon);
                $('#subtot').html(obj.subtotal);
                $('#subtotal').val(obj.subtotal);
                $('#grandtotal').val(obj.subtotal);
                // $('#nominal_ppn').val(ppn);
                $('#nominal').val(obj.subtotal);
                ck.checked=true;
                //console.log(ck);
            }
        });
        $('#pembayaranModal').modal('show');
    }

    function editPenjualan() {
        $('#editPembayaranModal').modal('show');
    }

    function detilJual(e) {
        $('#detilPenjualanModal').modal('show');
    }

    function scanBarcode() {
        var key = $('#barcode');
        var customer = $('#customer').val();
        $.ajax({
            url: '<?= site_url() ?>' + "barang/caribarang/" + key.val(),
            type: "post",
            success: function(data) {
                var obj = JSON.parse(data);
                if (customer == 0) {
                    $('#harga').val(obj.harga_jual);
                    $('#namaitem').val(obj.nama_barang);
                    $('#idbarangitem').val(obj.id_barang);
                    $('#kodebrg').val(obj.kode_barang);
                    addItemByScan();
                } else {
                    $.ajax({
                        url: site_url() + "customer/detilcustomer/" + customer,
                        type: "post",
                        success: function(result) {
                            var res = JSON.parse(result);
                            if (res.jenis_cs == "Umum") {

                                $('#harga').val(obj.harga_jual);

                            } else if (res.jenis_cs == "Toko") {

                                $('#harga').val(obj.harga_toko);

                            } else if (res.jenis_cs == "Pelanggan") {

                                $('#harga').val(obj.harga_pelanggan);

                            } else if (res.jenis_cs == "Sales") {

                                $('#harga').val(obj.harga_sales);
                            }
                            $('#namaitem').val(obj.nama_barang);
                            $('#idbarangitem').val(obj.id_barang);
                            $('#kodebrg').val(obj.kode_barang);
                            addItemByScan();
                        }
                    })
                }
            }
        })
    }

    function selectJenis() {
        let jenis = $('#jenis').val();
        if (jenis == "Servis") {
            $('.barcode-produk').hide();
            $('.kode-servis').show();
            $('#qty').attr('disabled', 'disabled');
        } else if (jenis == "Produk") {
            $('.barcode-produk').show();
            $('.kode-servis').hide();
            $('#qty').removeAttr('disabled');
        }
    }

    function tampilservis() {
        $('#daftarservis').DataTable({
            "bProcessing": true,
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "sAjaxSource": '<?= site_url() ?>' + 'servis/LoadData',
            "sAjaxDataProp": "aaData",
            "fnRender": function(oObj) {
                uss = oObj.aData["Username"];
            },
            "aoColumns": [{
                    "mDataProp": "kode",
                    bSearchable: true
                },
                {
                    "mDataProp": "nama_servis",
                    bSearchable: true
                },
                {
                    "mDataProp": "keterangan",
                    bSearchable: true
                },
                {
                    "mDataProp": "harga",
                    bSearchable: true
                },
                {
                    "mDataProp": function(data, type, val) {
                        pKode = data.id_servis;

                        var btn = '<a href="#" id="pilihservis" class="btn btn-primary btn-xs" data-dismiss="modal" title="Pilih Data" onclick="pilihservis(' + pKode + ')"><i class="fa fa-check-square-o"></i> Select</a>';

                        return (btn).toString();
                    },
                    bSortable: false,
                    bSearchable: false
                }
            ],
            "bDestroy": true,
        });

        $('#showModalServis').modal('show');
    }

    function pilihservis(e) {
        $.ajax({
            url: '<?= site_url() ?>' + "servis/detail/" + e,
            type: "post",
            success: function(data) {
                var obj = JSON.parse(data);
                $('#harga').val(obj.harga);
                $('#namaitem').val(obj.nama_servis);
                $('#idservis').val(obj.id_servis);
            }
        })
    }

    function SetBolehKredit() {
        cust = document.getElementById('customer');
        kr = document.getElementById('kredit');
        warning = document.getElementById('warning');


        const rupiah = (number) => {
            return new Intl.NumberFormat("id-ID", {
                style: "currency",
                currency: "IDR"
            }).format(number);
        }

        idcust = cust.options[cust.selectedIndex].value;
        if (idcust == 0) {
            console.log(cust.options[cust.selectedIndex].value);
            kr.disabled = true;
            warning.classList.remove("alert");
        } else {
            kr.disabled = false;
            $.ajax({
                url: '<?= site_url() ?>' + "penjualan/cek_piutang/" + idcust,
                type: "post",
                success: function(data) {
                    var obj = JSON.parse(data);
                    var tot = Number(obj.total) + Number(obj.belanja);
                    warning.innerHTML = rupiah(tot);
                    if (tot > 82500000) {
                        warning.classList.add("alert");
                        warning.classList.add("alert-danger");
                        warning.innerHTML = "Total belanja atau piutang telah melebihi batas, pembelian secara kredit tidak diijinkan. total : " + rupiah(tot);
                        kr.disabled = true;
                    } else {
                        if (tot > 750000) {
                            warning.classList.add("alert");
                            warning.classList.add("alert-warning");
                            warning.innerHTML = "Total piutang plus belanja hari ini telah mencapai " + rupiah(tot);
                        } else {
                            warning.classList.remove("alert")
                            warning.innerHTML = "";
                        }
                    }
                }
            });
        }

    }
</script>