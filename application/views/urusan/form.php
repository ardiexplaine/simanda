<script type="text/javascript" class="init">
    $(document).ready(function() {

        $('#BTN_BACK_SELECT').on('click', function() {
            location.href = baseurl+'urusan';
        });

        $('#BTN_SAVE').on('click', function() {
            var data = new FormData();

            data.append('urusan_id', $('#txtUrusanID').val());
            data.append('urusan', $('#txtNamaUrusan').val());
            
                  
            $.ajax({
                url: baseurl+"urusan/store",
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
                        $('#form-urusan input').val("");
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
<h3 class="heading">Master Urusan</h3>


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

    <form id="form-urusan">
        <input type="hidden" id="txtUrusanID" value="<?php echo isset($rowdata->urusan_id) ? $rowdata->urusan_id : ''; ?>">
        <div class="row formSep">
            <div class="col-sm-10 col-md-10">
                <div id="divtxtNamaUrusan" class="form-group">
                    <label for="txtNamaUrusan" class="col-lg-2 control-label">Nama Urusan *</label>
                    <div class="col-lg-10">
                        <input type="text" class="input-sm form-control" id="txtNamaUrusan" value="<?php echo isset($rowdata->urusan) ? $rowdata->urusan : ''; ?>">
                    </div>
                </div>
            </div>	
        </div>
    </form>
