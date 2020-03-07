<!DOCTYPE html>
<html lang="en" class="login_page">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>.:SIMANDA LOGIN</title>
    
        <!-- Bootstrap framework -->
            <link rel="stylesheet" href="<?php echo $this->config->item("theme"); ?>bootstrap/css/bootstrap.min.css" />
        <!-- main styles -->
            <link rel="stylesheet" href="<?php echo $this->config->item("theme"); ?>css/style.css" />
    
        <!-- favicon -->
            <link rel="shortcut icon" href="<?php echo $this->config->item("theme"); ?>img/icon.png" />
    
			<link href='http://fonts.googleapis.com/css?family=PT+Sans' rel='stylesheet' type='text/css'>
	</head>
    <body style="background:#1E5595">
		<?php echo $this->session->flashdata('message'); ?>
		<form method="POST" action="<?php echo base_url('login/process'); ?>" class="login_box">
			<img src="<?php echo $this->config->item("theme"); ?>img/login-logo.png" width="100%"> 	
			<div class="cnt_b">
				<div class="form-group">
					<div class="input-group">
						<span class="input-group-addon input-sm"><i class="glyphicon glyphicon-user"></i></span>
						<input class="form-control input-sm" type="text" id="username" name="username" placeholder="Username" required />
					</div>
				</div>
				<div class="form-group">
					<div class="input-group">
						<span class="input-group-addon input-sm"><i class="glyphicon glyphicon-lock"></i></span>
						<input class="form-control input-sm" type="password" id="password" name="password" placeholder="Password" required />
					</div>
				</div>

			</div>
			<div class="btm_b clearfix">
				<button class="btn btn-default btn-sm pull-right" id="submitLogin" type="submit"><i class="splashy-lock_large_unlocked"></i> Sign In</button>
			</div>  	
		</form>
	</body>	 
</html>
