<script type="text/javascript" class="init">
    $(document).ready(function() {

        var ndi = '<?php echo $wfnum ?>';
        loaddashboard2(ndi);

        $('#BTN_BACK_SELECT').on('click', function() {
            location.href = baseurl+'dashboard';
        });

        $.ajax({
            url: baseurl + "dashboard/timeline/"+ndi ,
            type: "get",
            dataType: "json",
            success: function(data) {
                //alert(JSON.stringify(data.tline));
                $('#animasiProgress').stepbar({
                    items: data.tline,
                    color: '#84B1FA',
                    fontColor: '#000',
                    selectedColor: '#223D8F',
                    selectedFontColor: '#fff',
                    current: data.curid
                });
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.responseText);
                $('body').css('cursor', 'default');
            }
        });


	
        function loaddashboard2(ndi) {
            // hapus datatable
            var table = $('#tblDashboard').DataTable();
            table.destroy();

            var formData = {
                'wfnum': ndi,
            };

            var cols = [
                { "data": "zdate","width": "12%" }, 
                { "data": "zuser" },
                { "data": "from_status" },
                { "data": "to_status" },
                { "data": "reason","width": "30%" }
            ];   

            $('#tblDashboardDetail').DataTable({
                "ajax": {
                    "url": baseurl+"dashboard/loadDashboardDetail",
                    "type": "POST",
                    "data": formData,
                    "deferLoading": 57,
                    "scrollY": "200px",
                    "scrollCollapse": true,
                    "paging": false,
                    "dataSrc": ""
                },
                "columns": cols
            });

            
        }
    });
</script>



<div id="zbtnAction" >
    <button class="btn btn-sm btn-default" id="BTN_BACK_SELECT"><i class="splashy-arrow_medium_left"></i> Back To List</button>
    <button class="btn btn-sm btn-success" title="Klik Detail" onclick="location.href='../../pinjaman/view/<?php echo $wfnum ?>'" type="button">NDI Detail:<strong> <?php echo $wfnum ?></strong></button>
</div>
<br>

<div style="border-radius: 15px; background: hsl(0, 0%, 94%); border: 1px solid grey;padding: 10px; width: 100%;height: 100%;">
    <h3>Status Pengajuan Dokumen</h3> <br>
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <div id="animasiProgress"></div>
        </div>
    </div>
</div>
<br>

    <div style="border-radius: 15px; border: 1px solid grey;padding: 10px; width: 100%;height: 100%;">
    <h3>Rincian Riwayat</h3> <br>

        <div class="row">
            <div class="col-sm-12 col-md-12">
                <div class="tabbable tabbable-bordered">
                    <table id="tblDashboardDetail" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Akun Daerah</th>
                                <th>Dari Status</th>
                                <th>Ke Status</th>
                                <th>Alasan</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
    </div>
</div>