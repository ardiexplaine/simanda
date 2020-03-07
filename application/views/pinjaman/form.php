<script type="text/javascript">
    $(document).ready(function() {

        var wfnum = $('#txtWfnum').val();
        if(wfnum != ''){
            loaddata();
        }else{
            workflow();
            getCodeNDI();
            loadStatus('RNA1');
            roleScreen('RNA1','');
        }
        formPersyaratanDataTable();

        $('#btnReason').on('click', function() {
            $('#zmdlReason').modal('hide');
            rejectData();
        });

        $('#BTN_ADDITEM').on('click', function() {
            addItem('txtDescFiles','filePersyaratan');
        });

        

        $('#tglSP1').datepicker({format: "yyyy-mm-dd"}).on('changeDate', function(ev){
            var dateText = $(this).data('date');
            $('#datetglSP1').val(dateText);
            $('#tglSP1').datepicker('hide');
        });

        var RelYear = document.getElementById('RelYear');
		RelYear.addEventListener('keyup', function(e){
			RelYear.value = numberOnly(this.value, '');
        });

    });
</script>
<h3 class="heading"><strong>FORM PENGAJUAN PERTIMBANGAN & DOKUMEN PERSYARATAN</strong>
    <div class="pull-right" id="lblStatus">
</h3>

<div class="row">
    <div class="col-sm-9 col-md-9">
        <div id="zbtnAction" class="form-actions"></div>
    </div>
    <div class="col-sm-3 col-md-3">
        <div id="ztxtAppsMsg"></div>
    </div>
</div>

<div class="row" id="tabHeader">
    <form id="form-header">
        <div class="col-sm-6 col-md-6">
            <div class="form-horizontal">
                <div id="divslcJenisPR" class="form-group">
                    <label class="col-md-4 control-label"><h4>No. Dokumen Input</h4></label>
                    <div class="col-md-7">
                        <input type="text" class="input-sm form-control" name="txtWfnum" id="txtWfnum" readonly="readonly" value="<?php echo isset($wfnum) ? $wfnum : ''; ?>">
                        <input type="hidden" id="txtStatusCd" readonly="readonly">
                    </div>
                </div>
                <div class="form-group">
                    <label  class="col-sm-4 control-label"><h4>No. Surat Permohonan</h4></label>
                    <div class="col-sm-7">
                        <input type="text" class="input-sm form-control"  name="txtDokumenNo" id="txtDokumenNo">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label"><h4>Tgl. Surat</h4></label>
                    <div class="col-lg-3">
                        <div class="input-group date" id="tglSP1" data-date-format="yyyy-mm-dd">
                            <input class="input-sm form-control" name="datetglSP1" id="datetglSP1" type="text">
                            <span class="input-group-addon"><i class="splashy-calendar_day"></i></span>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
        <div class="col-sm-6 col-md-6">
            <div class="form-horizontal">
                <div class="form-group">
                    <label class="col-md-3 control-label"><h4>Nama Daerah</h4></label>
                    <div class="col-md-6">
                        <input type="text" class="input-sm form-control" name="txtNamaDaerah" id="txtNamaDaerah" readonly="readonly">
                    </div>
                </div>

                <div class="form-group" id="divRelYear">
                    <label class="col-sm-3 control-label"><h4>Tahun Terakhir LKPD Audited BPK</h4></label>
                    <div class="col-lg-2">
                        <input class="input-sm form-control input-align text-input-align" name="RelYear" id="RelYear" type="text" maxlength="4" size="4">
                    </div>
                </div>

            </div>
        </div>
    </form>
</div>

<div class="row" id="main-screen-1">
    <div class="col-sm-12 col-md-12">
        <div class="tabbable tabbable-bordered">
            <ul class="nav nav-tabs">
                <li id="tabData" class="active"><a href="#tab1" data-toggle="tab">Dokumen Persyaratan</a></li>
                <li id="tabDetail"><a href="#tab2" data-toggle="tab">Detail</a></li>
                <li id="tabhistory"><a href="#tab4" data-toggle="tab">Riwayat</a></li>
            </ul>

            <div class="tab-content">

                <div class="tab-pane active" id="tab1">
                    <div class="row">
                        <div class="col-sm-12 col-md-12">
                            <h4><u>Catatan</u></h4>
                            <ul>
                                <li>Semua dokumen yang disampaikan/dilampirkan dalam sistem aplikasi ini adalah salinan sesuai dengan <i style="color:red;">dokumen aslinya.</i></li>
                                <li>Segera tekan tombol <b>"Ajukan ke Kemendagri"</b>, maksimal 3 hari kerja <i style="color:red;">Sebelum Expired</i></li>
                                <li>Batas penyampaian dokumen fisik ke Kemendagri paling lambat <i style="color:red;">3 Hari Kerja</i> Setelah dokumen persyaratan lengkap diupload</li>
                                <li>Apabila ukuran dokumen fisik terlalu tebal, maka yang diupload adalah <i style="color:red;">Lembar Sampul dan Lembar Pengesahaan</i></li>
                                <li>Untuk KAK, mohon upload 2 (dua) jenis format: dokumen bertanda tangan dalam <i style="color:red;">format pdf </i>dan dokumen KAK dalam <i style="color:red;">format excel </i>dengan melampirkan rincian volume kegiatan</a></li>
                            </ul>
                        </div>	
                        <div class="col-sm-12 col-md-12">
                            <table id="tblListPersyaratanFrom" class="display"></table>
                        </div>
                    </div>
                </div>

                <div class="tab-pane" id="tab2">
                    <div class="row">
                        <div class="col-sm-12 col-md-12">
                            <div class="form-horizontal" role="form">

                                <h4>Unggah Dokumen Persyaratan</h4><br/>

                                <div id="divtxtDescFiles" class="form-group">
                                    <label for="txtDescFiles" class="col-lg-2 control-label">Deskripsi File </label>
                                    <div class="col-lg-4">
                                        <input type="hidden" class="input-sm form-control" id="persyaratan_id" >
                                        <input type="text" class="input-sm form-control" id="txtDescFiles" >
                                    </div>
                                </div>

                                <div id="divfilePersyaratan" class="form-group">
                                    <label for="filePersyaratan" class="col-lg-2 control-label">Upload File </label>
                                    <div class="col-lg-4">
                                        <input type="file" class="input-sm form-control" name="filePersyaratan" id="filePersyaratan">
                                        <span class="help-block">* wajib disini, file yang hanya perbolehkan .pdf dan xls</span>
                                    </div>
                                    <div class="col-lg-3">
                                        <button class="btn btn-sm btn-default" id="BTN_ADDITEM"><i class="splashy-add_small"></i> Tambah Data</button>
                                    </div>
                                </div>
                                <div id="tblItemData"></div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="tab4">
                    <table id="tblHistory" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Waktu</th>
                                <th>Oleh</th>
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
</div>