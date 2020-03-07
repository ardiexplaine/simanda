<script type="text/javascript" class="init">
    $(document).ready(function() {
        
        var usrcd = $('#txtusrcd').val();
        if(usrcd != ''){
            loadDetailUsers();
        }

        $('#BTN_BACK_SELECT').on('click', function() {
            location.href = baseurl+'profile/pusat';
        });

        $('#BTN_SAVE').on('click', function() {
            var data = new FormData();

            data.append('usrcd', $('#txtusrcd').val());
            data.append('nama_lengkap', $('#txtNamaLengkap').val());
            data.append('username', $("#txtUsername").val()); 
            data.append('jabatan', $("#txtJabatan").val());
            data.append('email', $("#txtEmail").val());
            data.append('telepon', $("#txtTlpNo").val());
            data.append('fax', $("#txtFaxNo").val());
            data.append('aktif', $("#slcIsActive").val());
            data.append('password', $("#txtPassword").val());
            data.append('superadmin', $("#slcIsSuperAdmin").val());
                  
            $.ajax({
                url: baseurl+"profile/savedatapusat",
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
                        var rows = data.result;
                        $('#txtusrcd').val(rows.usrcd);
                        document.getElementById('ztxtAppsMsg').innerHTML = data.notif;
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
<h3 class="heading">HALAMAN PENGGUNA</h3>


    <div class="row">
        <div class="col-sm-7 col-md-7">
            <div id="zbtnAction" class="form-actions">
                <button class="btn btn-sm btn-default" id="BTN_BACK_SELECT"><i class="splashy-arrow_medium_left"></i> Back To List</button>
                <button class="btn btn-sm btn-default" id="BTN_SAVE"><i class="splashy-download"></i> Save Profile</button>
            </div>
        </div>
        <div class="col-sm-5 col-md-5">
            <div id="ztxtAppsMsg"></div>
        </div>
    </div>
    <br/>


    <div class="row formSep">
        <div class="col-sm-10 col-md-10">
            <div id="divtxtusrcd" class="form-group">
                <label for="txtusrcd" class="col-lg-2 control-label">User ID</label>
                <div class="col-lg-4">
                    <input type="text" class="input-sm form-control" id="txtusrcd" value="<?php echo isset($usrcd) ? $usrcd : ''; ?>" readonly="readonly">
                </div>
            </div>
        </div>	
    </div>

    <div class="row formSep">
        <div class="col-sm-10 col-md-10">
            <div id="divtxtNamaLengkap" class="form-group">
                <label for="txtNamaLengkap" class="col-lg-2 control-label">Nama Lengkap *</label>
                <div class="col-lg-4">
                    <input type="text" class="input-sm form-control" id="txtNamaLengkap">
                </div>
            </div>
        </div>	
    </div>

    <div class="row formSep">
        <div class="col-sm-10 col-md-10">
            <div id="divtxtUsername" class="form-group">
                <label for="txtUsername" class="col-lg-2 control-label">Username *</label>
                <div class="col-lg-4">
                    <input type="text" class="input-sm form-control" id="txtUsername">
                </div>
            </div>
        </div>	
    </div>

    <div class="row formSep">
        <div class="col-sm-10 col-md-10">
            <div id="divtxtPassword" class="form-group">
                <label for="txtPassword" class="col-lg-2 control-label">Password</label>
                <div class="col-lg-4">
                    <input type="password" class="input-sm form-control" id="txtPassword">
                    <span class="help-block">* Kosongkan Jika Password Tidak Dirubah</span>
                </div>
            </div>
        </div>	
    </div>

    <div class="row formSep">
        <div class="col-sm-10 col-md-10">
            <div id="divtxtJabatan" class="form-group">
                <label for="txtJabatan" class="col-lg-2 control-label">Jabatan *</label>
                <div class="col-lg-4">
                    <input type="text" class="input-sm form-control" id="txtJabatan">
                </div>
            </div>
        </div>	
    </div>

    <div class="row formSep">
        <div class="col-sm-10 col-md-10">
            <div id="divtxtEmail" class="form-group">
                <label for="txtEmail" class="col-lg-2 control-label">Email *</label>
                <div class="col-lg-4">
                    <input type="email" class="input-sm form-control" id="txtEmail">
                </div>
            </div>
        </div>	
    </div>

    <div class="row formSep">
        <div class="col-sm-10 col-md-10">
            <div id="divtxtTlpNo" class="form-group">
                <label for="txtTlpNo" class="col-lg-2 control-label">Telpon No. *</label>
                <div class="col-lg-4">
                    <input type="email" class="input-sm form-control" id="txtTlpNo">
                </div>
            </div>
        </div>	
    </div>

    <div class="row formSep">
        <div class="col-sm-10 col-md-10">
            <div id="divtxtFaxNo" class="form-group">
                <label for="txtFaxNo" class="col-lg-2 control-label">Fax No.</label>
                <div class="col-lg-4">
                    <input type="email" class="input-sm form-control" id="txtFaxNo">
                </div>
            </div>
        </div>	
    </div>


    <div class="row formSep">
        <div class="col-sm-10 col-md-10">
            <div id="divslcIsActive" class="form-group">
                <label for="slcIsActive" class="col-lg-2 control-label">Is Active</label>
                <div class="col-lg-4">
                    <select class="input-sm form-control" id="slcIsActive">
                        <option value="Y" selected>Aktif</option>
                        <option value="N">Tidak Aktif</option>
                    </select>
                </div>
            </div>
        </div>	
    </div>

    <div class="row formSep">
        <div class="col-sm-10 col-md-10">
            <div id="divslcIsSuperAdmin" class="form-group">
                <label for="slcIsSuperAdmin" class="col-lg-2 control-label">Is Super Administrator</label>
                <div class="col-lg-4">
                    <select class="input-sm form-control" id="slcIsSuperAdmin">
                        <option value="Y">YES</option>
                        <option value="N" selected>NO</option>
                    </select>
                </div>
            </div>
        </div>	
    </div>
