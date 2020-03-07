<script type="text/javascript" class="init">
    $(document).ready(function() {
        
        $('#listSelection').hide();
        jenisStatus();
        $('#slcDaerahProv').on('change', function() {
            slckabkot('');
        });


        $('#ADD_NEW').on('click', function() {
            location.href = '/simanda/pinjaman/create';
        });

        $('#BTN_BACK_SELECT').on('click', function() {
            $('#listSelection').hide();
            $('#formSelection').show();
        });

        $('#tglDocFrom').datepicker({format: "yyyy-mm-dd"}).on('changeDate', function(ev){
            var dateText = $(this).data('date');
            $('#datetglDocFrom').val(dateText);
            $('#tglDocFrom').datepicker('hide');
        });

        $('#tglDocTo').datepicker({format: "yyyy-mm-dd"}).on('changeDate', function(ev){
            var dateText = $(this).data('date');
            $('#datetglDocTo').val(dateText);
            $('#tglDocTo').datepicker('hide');
        });
        

        $('#BTN_SEARCH').on('click', function() {
            var data = new FormData();


            data.append('wfnum', $('#slcWfnum').val());
            data.append('slcSuPeng', $("#slcSuPeng").val());
            data.append('datetglDocFrom', $("#datetglDocFrom").val());
            data.append('datetglDocTo', $("#datetglDocTo").val());
            data.append('slcDaerahProv', $("#slcDaerahProv").val());
            data.append('slcJenisStatus', $("#slcJenisStatus").val());
        
            $.ajax({
                url: baseurl+"pinjaman/searchData",
                type: 'POST', 
                data: data, 
                processData: false,
                contentType: false,
                dataType: "json",
                beforeSend: function(e) {
                    $('.page-loader').show();
                    if(e && e.overrideMimeType) {
                        e.overrideMimeType("application/json;charset=UTF-8");
                    }
                },
                success: function(data){
                    $('.page-loader').hide();
                    
                    if(data.status==0){
                        $('#listSelection').show();
                        $('#formSelection').hide();

                        var table = $('#tblListpinjaman').DataTable();
                        table.destroy();
                        var oTblReport = $("#tblListpinjaman")
                        oTblReport.DataTable ({
                            "data" : data.result,
                            "columns" : [
                                { "data" : "wfnum", "width": "10%" },
                                { "data" : "zuser", "width": "20%" },                         
                                { "data" : "docnumber", "width": "20%" },
                                { "data" : "doctgl", "width": "15%" },
                                { "data" : "zdate", "width": "15%" },
                                { "data" : "stsnm", "width": "20%" },

                            ]
                        });


                        $('#tblListpinjaman tbody').on('click', 'tr', function () {
                            var table = $('#tblListpinjaman').DataTable();
                            var data = table.row( this ).data();
                            //alert( 'You clicked on '+data["wfcat"]+'\'s row' );
                            location.href = 'pinjaman/view/'+data["wfnum"];
                        });

                        document.getElementById('ztxtAppsMsg').innerHTML = '';
                    }else{

                        document.getElementById('ztxtAppsMsg').innerHTML = data.notif;
                    }
                    
                    //document.getElementById('ztxtAppsMsg').innerHTML = data.message;			
                },
                error: function(xhr, ajaxOptions, thrownError){
                    alert(xhr.responseText);
                    $('body').css('cursor','default');			
                }
            });
        });

    });
</script>
<div id="formSelection">
<h3 class="heading"><strong>PENCARIAN PERTIMBANGAN PINJAMAN DAERAH</strong></h3>

    <div style="border-radius: 15px; border: 1px solid grey;padding: 10px; width: 100%;height: 100%;">
        <div class="row">
            <div class="col-sm-7 col-md-7">
                <div id="zbtnAction" class="form-actions">
                    <?php if($this->session->userdata('user_type') != 'KEM') { ?>
                    <button class="btn btn-sm btn-default" id="ADD_NEW" value="<?php echo $this->session->userdata('user_type'); ?>"><i class="splashy-add_small"></i> Buat Permohonan Baru</button>
                    <?php } ?>
                    <button class="btn btn-sm btn-default" id="BTN_SEARCH"><i class="splashy-zoom"></i> Cari</button>
                    
                </div>
            </div>
            <div class="col-sm-5 col-md-5"><div id="ztxtAppsMsg"></div></div>
        </div>
        <br/>

        <div class="row">
            <div class="col-sm-12 col-md-12">
                <div class="form-horizontal" role="form">

                    <div class="col-sm-10 col-md-10">
                        <div id="divslcJenisPR" class="form-group">
                            <label for="inputEmail1" class="col-lg-2 control-label">No. Dokumen Input</label>
                            <div class="col-lg-4">
                                <input type="text" class="input-sm form-control" id="slcWfnum">
                            </div>
                        </div>
                    </div>	

                    <div class="col-sm-10 col-md-10">
                        <div id="divslcslcSuPeng" class="form-group">
                            <label for="inputEmail1" class="col-lg-2 control-label">No. Surat Permohonan</label>
                            <div class="col-lg-4">
                                <input type="text" class="input-sm form-control" id="slcSuPeng">
                            </div>
                        </div>
                    </div>	

                    <div class="col-sm-10 col-md-10">
                        <div id="divslcslcSuPeng" class="form-group">
                            <label for="inputEmail1" class="col-lg-2 control-label">Tanggal Surat dari</label>
                            <div class="col-lg-2">
                                <div class="input-group date" id="tglDocFrom" data-date-format="yyyy-mm-dd">
                                    <input class="input-sm form-control" id="datetglDocFrom" type="text">
                                    <span class="input-group-addon"><i class="splashy-calendar_day"></i></span>
                                </div>
                            </div>
                            <label for="inputEmail1" class="col-lg-1 control-label">Sampai</label>
                            <div class="col-lg-2">
                                <div class="input-group date" id="tglDocTo" data-date-format="yyyy-mm-dd">
                                    <input class="input-sm form-control" id="datetglDocTo" type="text">
                                    <span class="input-group-addon"><i class="splashy-calendar_day"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>	

                    <?php if($this->session->userdata('user_type') == 'KEM') { ?>
                    <div class="col-sm-10 col-md-10">
                        <div id="divslcDaerahProv" class="form-group">
                            <label for="inputEmail1" class="col-lg-2 control-label">Daerah</label>
                            <div class="col-lg-3">
                                <?php
                                    $query = $this->db->query("SELECT id,namakab FROM m_daerah");
                                    $option = array();
                                    $option[] = '- Semua Data';
                                    foreach($query->result() as $row) :
                                    $option[$row->id] = $row->namakab;
                                    endforeach;
                                    $js = 'id="slcDaerahProv" class="input-sm form-control"';
                                    echo form_dropdown('slcDaerahProv', $option, '',$js); 
                                ?>
                            </div>
                        </div>
                    </div>
                    <?php } ?>	

                    <div class="col-sm-10 col-md-10">
                        <div id="divslcJenisStatus" class="form-group">
                            <label for="slcJenisStatus" class="col-lg-2 control-label">Status pinjaman</label>
                            <div class="col-lg-4">
                                <select class="input-sm form-control" id="slcJenisStatus"></select>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div> 
    </div>    	

</div>

<div id="listSelection">
<h3 class="heading"><strong>DAFTAR PERTIMBANGAN PINJAMAN DAERAH </strong></h3>                            
    <div class="row">
        <div class="col-sm-7 col-md-7">
            <div id="zbtnAction" class="form-actions">
                <button class="btn btn-sm btn-default" id="BTN_BACK_SELECT"><i class="splashy-arrow_medium_left"></i> Back To Selection</button>
            </div>
        </div>
        <div class="col-sm-5 col-md-5">
            <div id="ztxtAppsMsg"></div>
        </div>
    </div>
    <br/>
    
    <table id="tblListpinjaman" class="display" style="width:100%">
        <thead>
            <tr>
                <th>NDI.</th>
                <th>Diajukan</th>
                <th>No. Dokumen</th>
                <th>Tgl Dokumen</th>
                <th>Tgl Input</th>
                <th>Status</th>
            </tr>
        </thead>
    </table>
</div>