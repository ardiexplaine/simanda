<script type="text/javascript" class="init">
    $(document).ready(function() {
        
        userprofile('KAB');
        $('#listSelection').hide();

        $('#ADD_NEW').on('click', function() {
            
            location.href = '/simanda/ranperda/provin';
            
        });

        $('#BTN_BACK_SELECT').on('click', function() {
            $('#listSelection').hide();
            $('#formSelection').show();
        });

    });
</script>
<h3 class="heading">HALAMAN PENGGUNA</h3>

<table id="tblListUsers" class="display" style="width:100%">
    <thead>
        <tr>
            <th>User ID</th>
            <th>Daerah</th>
            <th>Nama Lengkap</th>
            <th>Username</th>
            <th>Jabatan</th>
            <th>Email</th>
            <th>Tlp No.</th>
            <th>Status</th>
        </tr>
    </thead>
</table>