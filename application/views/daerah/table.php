<script type="text/javascript" class="init">
    $(document).ready(function() {
        
        daerahDataTable();

        $('#BTN_ADDNEW').on('click', function() {
            location.href = baseurl+'daerah/create';
        });

    });
</script>
<h3 class="heading">Master Daerah</h3>

<div class="row">
    <div class="col-sm-7 col-md-7">
        <div id="zbtnAction" class="form-actions">
            <button class="btn btn-sm btn-default" id="BTN_ADDNEW"><i class="splashy-contact_blue_add"></i> Tambah Data</button>
        </div>
    </div>
    <div class="col-sm-5 col-md-5">
        <div id="ztxtAppsMsg"></div>
    </div>
</div>
<br/>

<table id="tblListDaerah" class="display" style="width:100%">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama Daerah</th>
            <th>Kode Provinsi</th>
            <th>Kode Kab/Kota</th>
        </tr>
    </thead>
</table>