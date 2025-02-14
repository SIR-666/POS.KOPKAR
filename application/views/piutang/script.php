<script>
    function hapusPembayaran(e) {
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
                    url: "<?= site_url() ?>" + "/piutang/hapus_pembayaran/" + e,
                    type: "post",
                    success: function(data) {
                        window.location.reload();
                    }
                })
            }
        })
    }

    function detailPay(e) {
        var html = '';
        $.ajax({
            url: "<?= site_url() ?>" + "/piutang/detail_payment/" + e,
            type: "post",
            success: function(data) {
                var obj = JSON.parse(data);
                for (var i = 0; i < obj.length; i++) {
                    html += '<tr><td>' + obj[i].nama_lengkap + '</td>' +
                        '<td>' + obj[i].tgl_bayar + '</td>' +
                        '<td> Rp. ' + obj[i].nominal + '</td></tr>';
                }
                $('#detailPiutang').modal('show');
                $('#detail_piutang').html(html);
            }
        })
    }
</script>