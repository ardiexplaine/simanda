<script type="text/javascript" class="init">
    $(document).ready(function() {

        $('#BTN_BACK_SELECT').on('click', function() {
            location.href = baseurl+'persyaratan';
        });

        $('#BTN_SAVE').on('click', function() {
            var data = new FormData();

            data.append('persyaratan_id', $('#txtPersyaratanID').val());
            data.append('persyaratan_name', $('#txtNamaPersyaratan').val());
            data.append('isactive', $("#slcIsActive").val());
                  
            $.ajax({
                url: baseurl+"persyaratan/store",
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
                        $('#form-persyaratan input').val("");
                    }
                    document.getElementById('ztxtAppsMsg').innerHTML = data.notif;		
                },
                error: function(xhr, ajaxOptions, thrownError){
                    alert(xhr.responseText);
                    $('body').css('cursor','default');			
                }
            });
        });


    });
</script>
<h3 class="heading">Master Persyaratan</h3>


    <div class="row">
        <div class="col-sm-7 col-md-7">
            <div id="zbtnAction" class="form-actions">
                <button class="btn btn-sm btn-default" id="BTN_BACK_SELECT"><i class="splashy-arrow_medium_left"></i> Back To List</button>
                <button class="btn btn-sm btn-default" id="BTN_SAVE"><i class="splashy-download"></i> Save Data</button>
            </div>
        </div>
        <div class="col-sm-5 col-md-5">
            <div id="ztxtAppsMsg"></div>
        </div>
    </div>
    <br/>

    <form id="form-persyaratan">
        <input type="hidden" id="txtPersyaratanID" value="<?php echo isset($rowdata->persyaratan_id) ? $rowdata->persyaratan_id : ''; ?>">
        <div class="row formSep">
            <div class="col-sm-10 col-md-10">
                <div id="divtxtNamaPersyaratan" class="form-group">
                    <label for="txtNamaPersyaratan" class="col-lg-2 control-label">Nama Persyaratan *</label>
                    <div class="col-lg-10">
                        <input type="text" class="input-sm form-control" id="txtNamaPersyaratan" value="<?php echo isset($rowdata->persyaratan_name) ? $rowdata->persyaratan_name : ''; ?>">
                    </div>
                </div>
            </div>	
        </div>

        <div class="row formSep">
            <div class="col-sm-10 col-md-10">
                <div id="divslcIsActive" class="form-group">
                    <label for="slcIsActive" class="col-lg-2 control-label">Is Active</label>
                    <div class="col-lg-3">
                        <select class="input-sm form-control" id="slcIsActive">
                            <option value="Y" selected>Aktif</option>
                            <option value="N">Tidak Aktif</option>
                        </select>
                    </div>
                </div>
            </div>	
        </div>
    </form>
