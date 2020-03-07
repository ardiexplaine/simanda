<script type="text/javascript">
    $(document).ready(function() {

        var wfnum = $('#txtWfnum').val();
        if(wfnum != ''){
            loaddatadscr();
        }

        $('#btnReason').on('click', function() {
            $('#zmdlReason').modal('hide');
            rejectData();
        });

        $('#tglSP2').datepicker({format: "yyyy-mm-dd"}).on('changeDate', function(ev){
            var dateText = $(this).data('date');
            $('#datetglSP2').val(dateText);
            $('#tglSP2').datepicker('hide');
        });

    });
</script>
<h3 class="heading"><strong>FORM PERTIMBANGAN MENDAGRI</strong>
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
        <div class="col-sm-7 col-md-7">
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
                        <input type="text" class="input-sm form-control"  name="txtDokumenNo" id="txtDokumenNo" readonly="readonly">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label"><h4>Tanggal Surat</h4></label>
                    <div class="col-lg-3">
                        <div class="input-group date" id="tglSP1" data-date-format="yyyy-mm-dd">
                            <input class="input-sm form-control" name="datetglSP1" id="datetglSP1" type="text" readonly="readonly">
                            <span class="input-group-addon"><i class="splashy-calendar_day"></i></span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label  class="col-sm-4 control-label"><h4>No. Surat Mendagri</h4></label>
                    <div class="col-sm-7">
                        <input type="text" class="input-sm form-control"  name="txtNoSuratKemendagri" id="txtNoSuratKemendagri">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label"><h4>Tanggal</h4></label>
                    <div class="col-lg-3">
                        <div class="input-group date" id="tglSP2" data-date-format="yyyy-mm-dd">
                            <input class="input-sm form-control" name="datetglSP2" id="datetglSP2" type="text">
                            <span class="input-group-addon"><i class="splashy-calendar_day"></i></span>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-4 control-label"></label>
                    <div class="col-lg-6">
                        <div class="input-group">
                            <input class="input-sm form-control" name="fileSurat" id="fileSurat" type="file">
                        </div>
                    </div>
                </div>
                <br>
                <div style="border-radius: 15px; border: 1px solid grey;padding: 10px; width: 100%;height: 100%;">
                        <div class="form-group" id="file_mendagri">
                            <label class="col-sm-4 control-label"><h4>Unduh <br>Surat Pertimbangan <br>Menteri Dalam Negri</h4></label>
                            <div class="col-lg-6">
                                <div id="btnSuratDownload"></div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
        <div class="col-sm-5 col-md-5">
            <div class="form-horizontal">
                <div class="form-group">
                    <label class="col-md-4 control-label"><h4>Nama Daerah</h4></label>
                    <div class="col-md-6">
                        <input type="text" class="input-sm form-control" name="txtNamaDaerah" id="txtNamaDaerah" readonly="readonly">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label"><h4>Tahun Terakhir LKPD Audited BPK</h4></label>
                    <div class="col-lg-2">
                        <input class="input-sm form-control input-align text-input-align" name="RelYear" id="RelYear" readonly="readonly" type="text" maxlength="4" size="4">
                    </div>
                </div>
                
            </div>
        </div>

    </form>
</div>


