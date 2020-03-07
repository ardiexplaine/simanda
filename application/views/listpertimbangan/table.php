<script type="text/javascript" class="init">
    $(document).ready(function() {
        
        listpertimbanganDataTable();

            $('#BTN_PRINT').on('click', function() {
                var tahun = $('#getTahun').val();
                window.open(baseurl+'listpertimbangan/cetak/'+tahun, '_blank');
            });

            $('#getTahun').on('change', function() {


                var table = $('#tblListPertimbangan').DataTable();
                table.destroy();

                var formData = {
                    'tahun': this.value,
                };

            $('#tblListPertimbangan').DataTable({
                "ajax": {
                    "url": baseurl + "listpertimbangan/json",
                    "type": "POST",
                    "deferLoading": 57,
                    "data": formData,
                    "dataSrc": ""
                },
                "columns": [
                    { "data": "wfnum", "width": "5%" },
                    { "data": "namakab", "width": "20%" },
                    { "data": "docnumber", "width": "20%" },
                    { "data": "doctgl", "width": "10%" },
                    { "data": "surat_mendagri", "width": "20%" },
                    { "data": "tgl_surat", "width": "10%" }
                ]
            });
        
        });

    });
</script>
<h3 class="heading">Daftar Pertimbangan</h3>

<div class="row">
    <div class="col-sm-4 col-md-4">
        <div id="zbtnAction" class="form-actions">
            
            <select id="getTahun" class="form-control">
                <option value="" selected>* Pilih Semua Tahun</option>
                <?php
                    $i=2016;
                    for($i=2016;$i<=date('Y');$i++){
                        echo '<option value="'.$i.'">'.$i.'</option>';
                    }
                ?>
            </select>
            <button class="btn btn-sm btn-default" id="BTN_PRINT"><i class="splashy-printer"></i> Print</button>
        </div>
    </div>
    <div class="col-sm-5 col-md-5">
        <div id="ztxtAppsMsg"></div>
    </div>
</div>
<br/>

<table id="tblListPertimbangan" class="display" style="width:100%">
    <thead>
        <tr>
            <th>NDI</th>
            <th>Nama Daerah</th>
            <th>No Surat Permohonan</th>
            <th>Tgl Surat Permohonan</th>
            <th>No Surat Pertimbangan</th>
            <th>Tgl Surat Pertimbangan</th>
        </tr>
    </thead>
    
</table>