<script type="text/javascript">
    $(document).ready(function() {

        var wfnum = $('#txtWfnum').val();
        if(wfnum != ''){
            loaddatadscr();
            loadItemLaporan(wfnum);
        }

        $('#BTN_ADDITEMLaporan').on('click', function() {
            addItemLaporan('txtDescFilesLaporan','filePersyaratanLaporan');
        });

        function addItemLaporan(title, fileid) {

            var data = new FormData();

            data.append('wfnum', $('#txtWfnum').val());
            data.append('title', $('#' + title).val());
            data.append('filenm', fileid);
            data.append('fileid', $('#' + fileid)[0].files[0]);

            if ($('#' + title).val() == '') {
                $('#' + title).focus();
                return;
            }


            $.ajax({
                url: baseurl + "laporan/addlaporan",
                type: 'POST',
                data: data,
                processData: false,
                contentType: false,
                dataType: "json",
                beforeSend: function(e) {
                    $('.page-loader').show();
                },
                success: function(data) {
                    $('.page-loader').hide();

                    $('#filePersyaratanLaporan, #txtDescFilesLaporan').val('');
                    if (data.status == 0) {
                        loadItemLaporan($('#txtWfnum').val());
                        document.getElementById('ztxtAppsMsg').innerHTML = '';
                    } else {
                        document.getElementById('ztxtAppsMsg').innerHTML = data.notif;
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.responseText);
                    $('body').css('cursor', 'default');
                }
            });
        }

        function loadItemLaporan(wfnum) {

            var data = new FormData();

            data.append('wfnum', wfnum);

            $.ajax({
                url: baseurl + "laporan/loadtable",
                type: 'POST',
                data: data,
                processData: false,
                contentType: false,
                dataType: "json",
                beforeSend: function(e) {
                    $('.page-loader').show();
                    if (e && e.overrideMimeType) {
                        e.overrideMimeType("application/json;charset=UTF-8");
                    }
                },
                success: function(data) {
                    $('.page-loader').hide();
                    $('#tblItemDataLaporan').html(data.html);
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.responseText);
                    $('body').css('cursor', 'default');
                }
            });
        }

        // function delItemLaporan(item_id, wfnum, persyaratan_id) {

        //     var data = new FormData();

        //     data.append('item_id', item_id);

        //     if (confirm("Apakah anda yakin ingin menghapus file ini!")) {
        //         $.ajax({
        //             url: baseurl + "pinjaman/delitem",
        //             type: 'POST',
        //             data: data,
        //             processData: false,
        //             contentType: false,
        //             dataType: "json",
        //             beforeSend: function(e) {
        //                 $('.page-loader').show();
        //             },
        //             success: function(data) {
        //                 $('.page-loader').hide();
        //                 formPersyaratanDataTable();
        //                 loadItem(persyaratan_id, wfnum);
        //             }
        //         });
        //     } else {
        //         return false;
        //     }
        // }

    });
</script>
<h3 class="heading"><strong>FORM LAPORAN KUMULATIF</strong>
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
<br>
<div class="row" id="tabBody">
    <div class="col-sm-12 col-md-12">
        <div style="border-radius: 15px; border: 1px solid grey;padding: 10px; width: 100%;height: 100%;">  
            <h4><u>Dokumen Laporan per Semester memuat:</u></h4>
            <ul>
                <li>Laporan Kumulatif dan Lampiran berupa gambar dan informasi perkembangan dari masing-masing kegiatan sesuai dengan KAK</li>
                <li>Dokumen Laporan Semesteran dapat digabung dalam satu file pdf atau dipisah (Laporan Utama dan Lampiran))</li>
            </ul>
        </div>    
        <br>
        
        <h4 class="heading">Unggah laporan komulatif</h4>

        <div class="form-horizontal" role="form">

            <div id="divtxtDescFilesLaporan" class="form-group">
                <label for="txtDescFilesLaporan" class="col-lg-2 control-label">Judul Laporan </label>
                <div class="col-lg-4">
                    <input type="text" class="input-sm form-control" placeholder="Semester ... Tahun ..." id="txtDescFilesLaporan" >
                </div>
            </div>

            <div id="divfilePersyaratanLaporan" class="form-group">
                <label for="filePersyaratan" class="col-lg-2 control-label">Upload File </label>
                <div class="col-lg-4">
                    <input type="file" class="input-sm form-control" name="filePersyaratanLaporan" id="filePersyaratanLaporan">
                    <span class="help-block"><i style="color:red;">* wajib disini, file yang hanya perbolehkan .pdf</i></span>
                </div>
                <div class="col-lg-3">
                    <button class="btn btn-sm btn-default" id="BTN_ADDITEMLaporan"><i class="splashy-add_small"></i> Tambah Data</button>
                </div>
            </div>

            <div id="tblItemDataLaporan"></div>

        </div>
    </div>    
</div>
