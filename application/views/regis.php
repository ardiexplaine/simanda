<!DOCTYPE html>
<html lang="en" class="login_page">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>.:SIMANDA LOGIN</title>
    
        <!-- Bootstrap framework -->
            <link rel="stylesheet" href="<?php echo $this->config->item("theme"); ?>bootstrap/css/bootstrap.min.css" />
        <!-- theme color-->
            <link rel="stylesheet" href="<?php echo $this->config->item("theme"); ?>css/blue.css" />
        <!-- tooltip -->    
			<link rel="stylesheet" href="<?php echo $this->config->item("theme"); ?>lib/qtip2/jquery.qtip.min.css" />
        <!-- main styles -->
            <link rel="stylesheet" href="<?php echo $this->config->item("theme"); ?>css/style.css" />
    
        <!-- favicon -->
            <link rel="shortcut icon" href="<?php echo $this->config->item("theme"); ?>img/icon.png" />
    
			<link href='http://fonts.googleapis.com/css?family=PT+Sans' rel='stylesheet' type='text/css'>
			<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
			<script type="text/javascript" class="init">
				$(document).ready(function() {

					var baseurl = '<?php echo base_url(); ?>';
					
					$('#submitRegis').on('click', function() {
						processRegis();
					});

					function processRegis(){
						var data = new FormData();
							data.append('usrcd', $('#txtUsrcd').val());
							data.append('nama_lengkap', $('#txtNamaLengkap').val());
							data.append('jabatan', $('#txtJabatan').val());
							data.append('email', $('#txtEmail').val());
							data.append('telepon', $('#txtTlpNo').val());
							data.append('fax', $('#txtFaxNo').val());
						$.ajax({
							url: baseurl+"login/savereg",
							type: 'POST', 
							data: data, 
							processData: false,
							contentType: false,
							dataType: "json",
							success: function(data){
								if(data.status==0){
									window.setTimeout(function(){
									window.location.href = baseurl+"dashboard";
									}, 3000);
								}
								document.getElementById('ztxtAppsMsg').innerHTML = data.notif;				
							},
							error: function(xhr, ajaxOptions, thrownError){
								alert(xhr.responseText);
								$('body').css('cursor','default');			
							}
						});
					}
				});
        	</script>
    </head>
    <body>
		<div id="ztxtAppsMsg"></div>
		<div class="login_box">
		<div class="alert alert-info" role="alert">
			<a href="#" class="alert-link"><strong>INFO!</strong> <br> Mohon isi Formulir <br>	BIODATA Pejabat Penghubung Kepala BPKAD</a>
		</div>	
			<div class="cnt_c">
				<input type="hidden" id="txtUsrcd" value="<?php echo $this->session->userdata('usrcd'); ?>">
					
				<div class="form-group">
					<div class="input-group">
						<span class="input-group-addon input-sm"><i class="splashy-contact_blue"></i></span>
						<input class="form-control input-sm" type="text" id="txtNamaLengkap" placeholder="Nama Lengkap" />
					</div>
				</div>

				<div class="form-group">
					<div class="input-group">
						<span class="input-group-addon input-sm"><i class="splashy-star_full"></i></span>
						<input class="form-control input-sm" type="text" id="txtJabatan"  placeholder="Jabatan" />
					</div>
				</div>

				<div class="form-group">
					<div class="input-group">
						<span class="input-group-addon input-sm"><i class="splashy-folder_modernist"></i></span>
						<input class="form-control input-sm" type="text" id="txtEmail" placeholder="Email" />
					</div>
				</div>

				<div class="form-group">
					<div class="input-group">
						<span class="input-group-addon input-sm"><i class="splashy-view_table"></i></span>
						<input class="form-control input-sm" type="text" id="txtTlpNo" placeholder="Telp No." />
					</div>
				</div>

				<div class="form-group">
					<div class="input-group">
						<span class="input-group-addon input-sm"><i class="splashy-tag"></i></span>
						<input class="form-control input-sm" type="text" id="txtFaxNo" placeholder="Fax No." />
					</div>
				</div>


			</div>
			<div class="btm_b clearfix">
				<button class="btn btn-default btn-sm pull-right" id="submitRegis"><i class="splashy-lock_large_unlocked"></i> Next</button>
			</div>  	
		</div>
	</body>	 
        <script src="<?php echo $this->config->item("theme"); ?>js/jquery.min.js"></script>
        <script src="<?php echo $this->config->item("theme"); ?>js/jquery.actual.min.js"></script>
		<script src="<?php echo $this->config->item("theme"); ?>lib/validation/jquery.validate.js"></script>
		<script src="<?php echo $this->config->item("theme"); ?>bootstrap/js/bootstrap.min.js"></script>
	
</html>
