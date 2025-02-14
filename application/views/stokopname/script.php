<script>
    function tampildata() {
        $('#daftarbarang').DataTable({
            "bProcessing": true,
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "sAjaxSource": site_url + 'barang/LoadData',
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
                        pKode = data.id_barang;
                        var btn = '<a href="#" class="btn btn-primary btn-xs" data-dismiss="modal" title="Pilih Data" onclick="pilihbarang(' + pKode + ')"><i class="fa fa-check-square-o"></i> Select</a>';

                        return (btn).toString();
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
        $.ajax({
            url: site_url + "barang/detilbarang/" + e,
            type: "post",
            success: function(data) {
                var obj = JSON.parse(data);
                $('#namabarang').val(obj.nama_barang);
                $('#iditem').val(obj.id_barang);
                $('#harga').val(obj.harga_beli);
                $('#stok').val(obj.stok);
            }
        })
    }

    function hapusOpname(e) {
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
                    url: site_url + "stokopname/delete/" + e,
                    type: "post",
                    success: function(data) {
                        window.location = site_url + "stokopname";
                    }
                })
            }
        })
    }

    function scanBarcode() {
        var key = $('#barcode');
        $.ajax({
            url: site_url + "barang/caribarang/" + key.val(),
            type: "post",
            success: function(data) {
                var obj = JSON.parse(data);
                $('#namabarang').val(obj.nama_barang);
                $('#stok').val(obj.stok);
                $('#iditem').val(obj.id_barang);
                $('#harga').val(obj.harga_beli);
            }
        })
    }
</script>