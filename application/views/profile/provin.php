<script type="text/javascript" class="init">
    $(document).ready(function() {

        var wfnum = $('#txtWfnum').val();
        if(wfnum != ''){
            loaddata();
        }else{
            workflow();
            $('#txtWfnum').val('%000000001');
            loadStatus('PVA1');
            roleScreen('PVA1','');
        }
    

        $('#btnReason').on('click', function() {
            $('#zmdlReason').modal('hide');
            rejectData();
        });

    });
</script>
<h3 class="heading">RANPERDA INDUK > <i>PROVINSI</i></h3>

<div class="row">
    <div class="col-sm-7 col-md-7">
        <div id="zbtnAction" class="form-actions"></div>
    </div>
    <div class="col-sm-5 col-md-5">
        <div id="ztxtAppsMsg"></div>
    </div>
</div>

<div class="row">
    <div class="col-sm-10 col-md-10">
        <div id="divslcJenisPR" class="form-group">
            <label for="inputEmail1" class="col-lg-2 control-label"><h4>Status Document</h4></label>
            <div class="col-lg-2">
                <input type="text" class="input-sm form-control" id="txtWfnum" readonly="readonly" value="<?php echo isset($wfnum) ? $wfnum : ''; ?>">
            </div>
            <div class="col-lg-4">
                <input type="hidden" id="txtStatusCd" readonly="readonly">
                <input type="text" class="input-sm form-control" id="txtStatusNm" readonly="readonly">
            </div>
        </div>
    </div>	
</div>

<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="tabbable tabbable-bordered">
            <ul class="nav nav-tabs">
                <li id="tabpro" class="active"><a href="#tab1" data-toggle="tab">Provinsi</a></li>
                <li id="tabkem"><a href="#tab2" data-toggle="tab">Kemendagri</a></li>
                <li id="tabhistory"><a href="#tab3" data-toggle="tab">History</a></li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane active" id="tab1">
                    <div class="row">
                        <div class="col-sm-12 col-md-12">
                            <div class="form-horizontal" role="form">

                                <div id="divslcJenisPR" class="form-group">
                                    <label for="inputEmail1" class="col-lg-2 control-label">Jenis Pajak / Retribusi</label>
                                    <div class="col-lg-2">
                                        <select class="input-sm form-control" id="slcJenisPR">
                                            <option value="" selected>- Pilih</option>
                                            <option value="P">Pajak</option>
                                            <option value="R">Retribusi</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-4">
                                        <select class="input-sm form-control" id="slcJenisPRnm"></select>
                                    </div>
                                </div>
                                <div id="divtxtTentang" class="form-group">
                                    <label for="txtTentang" class="col-lg-2 control-label">Tentang Ranperda</label>
                                    <div class="col-lg-6">
                                        <input type="text" class="input-sm form-control" id="txtTentang" >
                                    </div>
                                </div>
                                <div id="divfileSuratPengantar" class="form-group">
                                    <label for="fileSuratPengantar" class="col-lg-2 control-label">Surat Pengantar</label>
                                    <div class="col-lg-4">
                                        <input type="file" class="input-sm form-control" id="fileSuratPengantar">
                                        <span class="help-block">* File yang hanya perbolehkan pdf, jpg, png, rar</span>
                                    </div>
                                    <div class="col-lg-3">
                                        <div id="btnFL01"></div>
                                    </div>
                                </div>
                                <div id="divfileKesepakatanDPRD" class="form-group">
                                    <label for="fileKesepakatanDPRD" class="col-lg-2 control-label">Kesepakatan DPRD</label>
                                    <div class="col-lg-4">
                                        <input type="file" class="input-sm form-control" id="fileKesepakatanDPRD">
                                        <span class="help-block">* File yang hanya perbolehkan pdf, jpg, png, rar</span>
                                    </div>
                                    <div class="col-lg-3">
                                        <div id="btnFL02"></div>
                                    </div>
                                </div>
                                <div id="divfileRancanganPerda" class="form-group">
                                    <label for="fileRancanganPerda" class="col-lg-2 control-label">Rancangan Perda </label>
                                    <div class="col-lg-4">
                                        <input type="file" class="input-sm form-control" id="fileRancanganPerda">
                                        <span class="help-block">* Rancangan perda wajib disini, file yang hanya perbolehkan .doc dan .docx</span>
                                    </div>
                                    <div class="col-lg-3">
                                        <div id="btnFL03"></div>
                                    </div>
                                </div>
                                
                                <div class="formSep"></div>

                                <div id="divtxtRegNo" class="form-group">
                                    <label for="txtRegNo" class="col-lg-2 control-label">Registrasi No.</label>
                                    <div class="col-lg-3">
                                        <input type="text" class="input-sm form-control" id="txtRegNo" >
                                    </div>
                                </div>
                                <div id="divtxtPerdaNo" class="form-group">
                                    <label for="txtPerdaNo" class="col-lg-2 control-label">Perda No.</label>
                                    <div class="col-lg-3">
                                        <input type="text" class="input-sm form-control" id="txtPerdaNo" >
                                    </div>
                                </div>
                                <div id="divfilePerda" class="form-group">
                                    <label for="filePerda" class="col-lg-2 control-label">File Perda</label>
                                    <div class="col-lg-4">
                                        <input type="file" class="input-sm form-control" id="filePerda">
                                        <span class="help-block">* File yang hanya perbolehkan pdf, jpg, png, rar</span>
                                    </div>
                                    <div class="col-lg-3">
                                        <div id="btnFL08"></div>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="tab2">
                    <div class="row">
                        <div class="col-sm-9 col-md-9">
                            <div class="form-horizontal" role="form">
                                <div id="divfileSuratHasilKonsul" class="form-group">
                                    <label for="fileSuratHasilKonsul" class="col-lg-2 control-label">Evaluasi Ranperda</label>
                                    <div class="col-lg-4">
                                        <input type="file" class="input-sm form-control" id="fileSuratHasilKonsul">
                                        <span class="help-block">* File yang hanya perbolehkan pdf, jpg, png, rar</span>
                                    </div>
                                    <div class="col-lg-3">
                                        <div id="btnFL06"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="tab3">
                    <table id="tblHistory" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Done By</th>
                                <th>From Status</th>
                                <th>To Status</th>
                                <th>Reason</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Done By</th>
                                <th>From Status</th>
                                <th>To Status</th>
                                <th>Reason</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>