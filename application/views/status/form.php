<script type="text/javascript" class="init">
    $(document).ready(function() {

        $('#BTN_BACK_SELECT').on('click', function() {
            location.href = baseurl+'status';
        });

        $('#BTN_SAVE').on('click', function() {
            var data = new FormData();

            data.append('stssq', $('#txtStatusID').val());
            data.append('stsnm', $('#txtNamaStatus').val());
            
                  
            $.ajax({
                url: baseurl+"status/store",
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
                        $('#form-status input').val("");
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
<h3 class="heading">Master Jenis Status</h3>


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

    <form id="form-status">
        <input type="hidden" id="txtStatusID" value="<?php echo isset($rowdata->stssq) ? $rowdata->stssq : ''; ?>">
        <div class="row formSep">
            <div class="col-sm-10 col-md-10">
                <div id="divtxtNamaStatus" class="form-group">
                    <label for="txtNamaStatus" class="col-lg-2 control-label">Nama Status *</label>
                    <div class="col-lg-10">
                        <input type="text" class="input-sm form-control" id="txtNamaStatus" value="<?php echo isset($rowdata->stsnm) ? $rowdata->stsnm : ''; ?>">
                    </div>
                </div>
            </div>	
        </div>
    </form>
