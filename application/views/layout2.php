<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>SIMANDA - Sistem Informasi Pinjaman Daerah</title>

        <!-- Bootstrap framework -->
            <link rel="stylesheet" href="<?php echo $this->config->item("theme"); ?>bootstrap/css/bootstrap.min.css" />
        <!-- jQuery UI theme -->
            <link rel="stylesheet" href="<?php echo $this->config->item("theme"); ?>lib/jquery-ui/css/Aristo/Aristo.css" />
			<!-- <link rel="stylesheet" href="<?php echo $this->config->item("theme"); ?>lib/uniform/Aristo/uniform.aristo.css" /> -->
        <!-- breadcrumbs -->
            <link rel="stylesheet" href="<?php echo $this->config->item("theme"); ?>lib/jBreadcrumbs/css/BreadCrumb.css" />
        <!-- tooltips-->
            <link rel="stylesheet" href="<?php echo $this->config->item("theme"); ?>lib/qtip2/jquery.qtip.min.css" />
		<!-- colorbox -->
            <link rel="stylesheet" href="<?php echo $this->config->item("theme"); ?>lib/colorbox/colorbox.css" />
        <!-- code prettify -->
            <link rel="stylesheet" href="<?php echo $this->config->item("theme"); ?>lib/google-code-prettify/prettify.css" />
		<!-- datepicker -->
			<link rel="stylesheet" href="<?php echo $this->config->item("theme"); ?>lib/datepicker/datepicker.css" />
        <!-- sticky notifications -->
            <link rel="stylesheet" href="<?php echo $this->config->item("theme"); ?>lib/sticky/sticky.css" />
        <!-- aditional icons -->
            <link rel="stylesheet" href="<?php echo $this->config->item("theme"); ?>img/splashy/splashy.css" />
		<!-- flags -->
            <link rel="stylesheet" href="<?php echo $this->config->item("theme"); ?>img/flags/flags.css" />
        <!-- datatables -->
            <link rel="stylesheet" href="<?php echo $this->config->item("theme"); ?>css/datatables.min.css">

        <!-- main styles -->
			<link rel="stylesheet" href="<?php echo $this->config->item("theme"); ?>css/style.css" />

        <!-- icon calendar -->
		<link rel="stylesheet" href="<?php echo $this->config->item("theme"); ?>css/font-awesome.min.css" />

	
		
		<!-- custom styles -->
            <link rel="stylesheet" href="<?php echo $this->config->item("theme"); ?>css/custom.css" />
		<!-- theme color-->
            <link rel="stylesheet" href="<?php echo $this->config->item("theme"); ?>css/tamarillo.css" id="link_theme" />

            <link href='http://fonts.googleapis.com/css?family=PT+Sans' rel='stylesheet' type='text/css'>

			<link href="<?php echo $this->config->item("theme"); ?>css/select2.min.css" rel="stylesheet" />

        <!-- favicon -->
            <link rel="shortcut icon" href="<?php echo $this->config->item("theme"); ?>img/icon.png" />

		 <!-- datatable libs -->
	<script src="<?php echo $this->config->item("theme"); ?>js/jquery-3.3.1.js"></script>
	<script src="<?php echo $this->config->item("theme"); ?>js/datatables.min.js"></script> 

			<style type="text/css">
				.no-js #loader { display: none;  }
				.js #loader { display: block; position: absolute; left: 100px; top: 0; }
				.page-loader {
					position: fixed;
					left: 0px;
					top: 0px;
					width: 100%;
					height: 100%;
					z-index: 9999;
					background: url(http://keuda.kemendagri.go.id/asset/themes/pemda/img/Preloader_3.gif) center no-repeat #fff;
				}
			</style>

			<script>
				$(document).ready(function(){
					$(".page-loader").fadeOut("slow");

					$('.urusan_select2').select2();
				});

				var baseurl = '<?php echo base_url(); ?>';

				function setDetailData(wfcat,wfnum){
					if(wfcat == 'WF01'){
						location.href = baseurl+'ranperda/kabkot/'+wfnum;
					}
					if(wfcat == 'WF02'){
						location.href = baseurl+'ranperda/provin/'+wfnum;
					}
				}
			</script>
    </head>
    <body class="full_width sidebar_hidden">	
        <div id="maincontainer" class="clearfix">

            <header>

				<?php $this->load->view('navigation'); ?>

				<div class="modal fade" id="zmdlReason">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h3 class="modal-title"><strong>Kembalikan Dokumen</strong></h3>
							</div>
							<div class="modal-body">
								<div class="form-group">
									<input type="hidden" id="txtReasonCurrst" >
									<input type="hidden" id="txtReasonNextst" >
									<label for="email">Alasan mengapa dokumen dikembalikan!</label>
									<textarea id="txtReason" class="input-sm form-control"></textarea>
								</div>
							</div>
							<div class="modal-footer">
								<button type="button" id="btnReason" class="btn btn-default">Kirim</button>
							</div>
						</div>
					</div>
				</div>

				<div class="modal fade" id="templatePrint">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h3 class="modal-title">Cetak Dokumen</h3>
							</div>
							<div class="modal-body">

								<form id="frmModalPrint">
									<input type="hidden" id="ktg_doc" name="ktg_doc">
									<div class="formSep">
										<label>Judul Dokumen <span class="f_req">*</span></label>
										<textarea name="title_doc" id="title_doc" cols="10" rows="3" class="form-control"></textarea>
									</div>
									<div class="formSep">
										<label>Notes</label>
										<textarea name="notes_doc" id="notes_doc" cols="10" rows="3" class="form-control"></textarea>
									</div>
									<div class="formSep">
										<div class="form-group">
											<label>Nama Tanda Tangan <span class="f_req">*</span></label>
											<input name="ttd_tangan" id="ttd_tangan" class="form-control" type="text">
										</div>
									</div>
								</form>


							</div>
							<div class="modal-footer">
								<button type="button" onclick="saveDocument();" class="btn btn-default"><i class="splashy-document_letter_okay"></i> Simpan & Cetak</button>
							</div>
						</div>
					</div>
				</div>

				<div class="modal fade" id="uploadExcel">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h3 class="modal-title">Import Dokumen Dari Excel</h3>
							</div>
							<div class="modal-body">

								<form id="frmImportExcel">
									<input type="hidden" id="ktg_doc" name="ktg_doc">
									<div class="formSep">
										<label>Import Dari File Excel <span class="f_req">*</span></label>
										<input type="file" id="fileupload" name="fileupload" />
									</div>
								</form>


							</div>
							<div class="modal-footer">
								<button type="button" onclick="uploadDataExcel();" class="btn btn-default"><i class="splashy-document_letter_okay"></i> Execute</button>
							</div>
						</div>
					</div>
				</div>

			</header>
            <div id="contentwrapper">
                <div class="main_content">
					<div class="page-loader"></div>
					<?php $this->load->view($content);?>            
                </div>
            </div>
        </div>

	<div class="modal fade" id="myNotification">
		<div class="modal-dialog">
			<div class="modal-content">
				<div id="dataModal"></div>
			</div>
		</div>
	</div>

    <!-- touch events for jquery ui-->
	<script src="<?php echo $this->config->item("theme"); ?>js/forms/jquery.ui.touch-punch.min.js"></script>
    <!-- easing plugin -->
	<script src="<?php echo $this->config->item("theme"); ?>js/jquery.easing.1.3.min.js"></script>
    <!-- smart resize event -->
	<script src="<?php echo $this->config->item("theme"); ?>js/jquery.debouncedresize.min.js"></script>
    <!-- js cookie plugin -->
	<script src="<?php echo $this->config->item("theme"); ?>js/jquery_cookie_min.js"></script>
    <!-- main bootstrap js -->
	<script src="<?php echo $this->config->item("theme"); ?>bootstrap/js/bootstrap.min.js"></script>
    <!-- bootstrap plugins -->
	<script src="<?php echo $this->config->item("theme"); ?>js/bootstrap.plugins.min.js"></script>
	<!-- typeahead -->
	<script src="<?php echo $this->config->item("theme"); ?>lib/typeahead/typeahead.min.js"></script>
	<!-- datepicker -->
	<script src="<?php echo $this->config->item("theme"); ?>lib/datepicker/bootstrap-datepicker.min.js"></script>
	
	<script src="<?php echo $this->config->item("theme"); ?>js/apps.js"></script>
	<script src="<?php echo $this->config->item("theme"); ?>js/stepbar.js"></script>

	
	<script src="<?php echo $this->config->item("theme"); ?>js/select2.min.js"></script>

    </body>
</html>


