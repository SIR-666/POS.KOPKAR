<script>
    function tambahuser() {
        $('#inputUserModal').modal('show');
    }

    function edituser(e) {
        $.ajax({
            url: site_url + "user/detiluser/" + e,
            type: "post",
            success: function(data) {
                var obj = JSON.parse(data);
                $('#iduser').val(obj.id_user);
                $('#editusername').val(obj.username);
                $('#editnama').val(obj.nama_lengkap);
                $('#edittelp').val(obj.telp_user);
                $('#editemail').val(obj.email_user);
                $('#editalamat').val(obj.alamat_user);
                $('#edittipe').val(obj.tipe);
            }
        })
        $('#editUserModal').modal('show');
    }

    function hapususer(e) {
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
                    url: site_url + "user/hapususer/" + e,
                    type: "post",
                    success: function(data) {
                        window.location = site_url + "user";
                    }
                })
            }
        })
    }
</script>