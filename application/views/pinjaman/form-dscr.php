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

    });
</script>
<h3 class="heading"><strong>FORM LEMBAR KERJA</strong>
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
                        <input type="text" class="input-sm form-control"  name="txtDokumenNo" id="txtDokumenNo" readonly="readonly">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label"><h4>Tgl. Surat</h4></label>
                    <div class="col-lg-3">
                        <div class="input-group date" id="tglSP1" data-date-format="yyyy-mm-dd">
                            <input class="input-sm form-control" name="datetglSP1" id="datetglSP1" type="text" readonly="readonly">
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
                <div class="form-group">
                    <label class="col-sm-3 control-label"><h4>Tahun Terakhir LKPD Audited BPK</h4></label>
                    <div class="col-lg-2">
                        <input class="input-sm form-control input-align text-input-align" name="RelYear" id="RelYear" readonly="readonly" type="text" maxlength="4" size="4">
                    </div>
                </div>
                
            </div>
        </div>
    </form>
</div>

<div class="row" id="tabBody">
    <div class="col-sm-12 col-md-12 dd_column">

            <div class="w-box" id="w_sort07">
                <div class="w-box-header">
                </div>
                <div class="w-box-content">
                    <div class="tabbable clearfix">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tabinfo" data-toggle="tab">Mapping Lembar Kerja</a></li>
                            <li><a href="#tab11" data-toggle="tab">Kegiatan Pada KAK</a></li>
                            <li><a href="#tab9" data-toggle="tab">Kegiatan Sesuai RKPD</a></li>
                            <li><a href="#tab8" data-toggle="tab">Total Belanja</a></li>
                            <li><a href="#tab7" data-toggle="tab">Rata2 Honor PNS</a></li>
                            <li><a href="#tab12" data-toggle="tab">Honor PNS Pengurang</a></li>
                            <li><a href="#tab6" data-toggle="tab">Rata2 TTP</a></li>
                            <li><a href="#tab5" data-toggle="tab">Silpa Rata2</a></li>
                            <li><a href="#tab10" data-toggle="tab">Kegiatan Disetujui</a></li>
                            <li><a href="#tab4" data-toggle="tab">Rata2 DSCR</a></li>
                            <li><a href="#tab3" data-toggle="tab">DSCR PP 56 > 2,7</a></li>
                            <li><a href="#tab2" data-toggle="tab">DSCR PP 56 < 2,7</a></li>
                            <li><a href="#tab1" data-toggle="tab">Perhitungan 75%</a></li>
                            <li><a href="#tab13" data-toggle="tab">Pelampauan Defisit</a></li> 
                        </ul>
                        <div class="tab-content">

                            <div class="tab-pane" id="tab1">
                                <div class="row">
                                    <div class="col-sm-12 col-md-12">
                                        <?php include('tab1.php');?>
                                    </div>
                                </div>      
                            </div>
                            <div class="tab-pane" id="tab2">
                                <div class="row">
                                    <div class="col-sm-12 col-md-12">
                                        <?php include('tab2.php');?>
                                    </div>
                                </div>   
                            </div>

                            <div class="tab-pane" id="tab3">
                                <div class="row">
                                    <div class="col-sm-12 col-md-12">
                                        <?php include('tab3.php');?>
                                    </div>
                                </div>   
                            </div>

                            <div class="tab-pane" id="tab4">
                                <div class="row">
                                    <div class="col-sm-12 col-md-12">
                                        <?php include('tab4.php');?>
                                    </div>
                                </div>   
                            </div>

                            <div class="tab-pane" id="tab5">
                                <div class="row">
                                    <div class="col-sm-12 col-md-12">
                                        <?php include('tab5.php');?>
                                    </div>
                                </div>   
                            </div>

                            <div class="tab-pane" id="tab6">
                                <div class="row">
                                    <div class="col-sm-12 col-md-12">
                                        <?php include('tab6.php');?>
                                    </div>
                                </div>   
                            </div>

                            <div class="tab-pane" id="tab7">
                                <div class="row">
                                    <div class="col-sm-12 col-md-12">
                                        <?php include('tab7.php');?>
                                    </div>
                                </div>   
                            </div>

                            <div class="tab-pane" id="tab8">
                                <div class="row">
                                    <div class="col-sm-12 col-md-12">
                                        <?php include('tab8.php');?>
                                    </div>
                                </div>   
                            </div>

                            <div class="tab-pane" id="tab9">
                                <div class="row">
                                    <div class="col-sm-12 col-md-12">
                                        <?php include('tab9.php');?>
                                    </div>
                                </div>   
                            </div>

                            <div class="tab-pane" id="tab10">
                                <div class="row">
                                    <div class="col-sm-12 col-md-12">
                                        <?php include('tab10.php');?>
                                    </div>
                                </div>   
                            </div>

                            <div class="tab-pane" id="tab11">
                                <div class="row">
                                    <div class="col-sm-12 col-md-12">
                                        <?php include('tab11.php');?>
                                    </div>
                                </div>   
                            </div>

                            <div class="tab-pane" id="tab12">
                                <div class="row">
                                    <div class="col-sm-12 col-md-12">
                                        <?php include('tab12.php');?>
                                    </div>
                                </div>   
                            </div>

                            <div class="tab-pane" id="tab13">
                                <div class="row">
                                    <div class="col-sm-12 col-md-12">
                                        <?php include('tab13.php');?>
                                    </div>
                                </div>   
                            </div>

                            <div class="tab-pane active" id="tabinfo">
                                <div class="row">
                                    <div class="col-sm-12 col-md-12">
                                        <?php include('tabinfo.php');?>
                                    </div>
                                </div>   
                            </div>


                        </div>
                    </div>
                </div>
            </div>


    </div>
</div>

