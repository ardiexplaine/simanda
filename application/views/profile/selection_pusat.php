<script type="text/javascript" class="init">
    $(document).ready(function() {
        
        userprofile('PUSAT');

        $('#BTN_ADDNEW').on('click', function() {
            location.href = baseurl+'profile/usersadd';
        });

    });
</script>
<h3 class="heading">HALAMAN PENGGUNA</h3>

<div class="row">
    <div class="col-sm-7 col-md-7">
        <div id="zbtnAction" class="form-actions">
            <button class="btn btn-sm btn-default" id="BTN_ADDNEW"><i class="splashy-contact_blue_add"></i> Tambah Users Pusat</button>
        </div>
    </div>
    <div class="col-sm-5 col-md-5">
        <div id="ztxtAppsMsg"></div>
    </div>
</div>
<br/>

<table id="tblListUsers" class="display" style="width:100%">
    <thead>
        <tr>
            <th>User ID</th>
            <th>Nama Lengkap</th>
            <th>Username</th>
            <th>Jabatan</th>
            <th>Email</th>
            <th>Tlp No.</th>
            <th>Status</th>
        </tr>
    </thead>
</table>