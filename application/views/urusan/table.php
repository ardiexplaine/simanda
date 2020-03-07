<script type="text/javascript" class="init">
    $(document).ready(function() {
        
        urusanDataTable();

        $('#BTN_ADDNEW').on('click', function() {
            location.href = baseurl+'urusan/create';
        });

    });
</script>
<h3 class="heading">Master Urusan</h3>

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

<table id="tblListUrusan" class="display" style="width:100%">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama Urusan</th>
        </tr>
    </thead>
</table>