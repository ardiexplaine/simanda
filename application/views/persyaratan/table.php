<script type="text/javascript" class="init">
    $(document).ready(function() {
        
        persyaratanDataTable();

        $('#BTN_ADDNEW').on('click', function() {
            location.href = baseurl+'persyaratan/create';
        });

    });
</script>
<h3 class="heading">Master Data Jenis Persyaratan</h3>

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

<table id="tblListPersyaratan" class="display" style="width:100%">
    <thead>
        <tr>
            <th>ID</th>
            <th>Persyaratan Nama</th>
            <th>Status</th>
        </tr>
    </thead>
</table>