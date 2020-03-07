<script type="text/javascript" class="init">
    $(document).ready(function() {

        $('#BTN_SEARCH').on('click', function() {
            var data = new FormData();

            data.append('oldpass', $('#oldpass').val());
            data.append('newpass', $('#newpass').val());
            data.append('ulapass', $("#ulapass").val()); 
                  
            $.ajax({
                url: baseurl+"api/proseschangepassword",
                type: 'POST', 
                data: data, 
                processData: false,
                contentType: false,
                dataType: "json",
                beforeSend: function(e) {
                    if($('#oldpass').val() == ""){
                        $('#oldpass').focus();
                    }
                    if($('#newpass').val() == ""){
                        $('#newpass').focus();
                    }
                    if($('#ulapass').val() == ""){
                        $('#ulapass').focus();
                    }
                },
                success: function(data){
                    // $('#zdivOverlay').hide();
                    $('.form-horizontal *').val('');
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
<h3 class="heading">Ganti Password</h3>

<div class="row">
    <div class="col-sm-7 col-md-7">
        <div id="zbtnAction" class="form-actions">
            <button class="btn btn-sm btn-default" id="BTN_SEARCH"><i class="splashy-lock_large_locked"></i> Submit Change Password</button>
        </div>
    </div>
    <div class="col-sm-5 col-md-5">
        <div id="ztxtAppsMsg"></div>
    </div>
</div>
<br/>

<div class='form-horizontal'>

    <div class='form-group'>
        <label for='inputEmail3' class='col-sm-2 control-label'>Password Lama</label>
        <div class='col-sm-4'>
            <input type='password' class='input-sm form-control' id='oldpass'>
        </div>
    </div>

    <div class='form-group'>
        <label for='inputPassword3' class='col-sm-2 control-label'>Password Baru</label>
        <div class='col-sm-4'>
            <input type='password' class='input-sm form-control' id='newpass'>
        </div>
    </div>

    <div class='form-group'>
        <label for='inputPassword3' class='col-sm-2 control-label'>Konfirmasi Password</label>
        <div class='col-sm-4'>
            <input type='password' class='input-sm form-control' id='ulapass'>
        </div>
    </div>

</div>