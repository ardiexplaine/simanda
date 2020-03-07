$('#zbtnModalNotification').click(function() {
    loadModal('NOTIF');
});
$('#menuChangePassword').click(function() {
    loadModal('CHANGEPASS');
});


function loadModal(mode) {
    $.ajax({
        url: baseurl + "api/getmodal",
        type: "POST",
        dataType: "json",
        data: { mode: mode },
        success: function(data) {
            if (data.status == 0) {
                $('#dataModal').html(data.htmlmodal);
                $("#dataModal").find("#dataModalTable").addClass("table table-hover");
            } else {

            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.responseText);
            $('body').css('cursor', 'default');
        }
    });
}

function loadStatus(stscd) {
    $.ajax({
        url: baseurl + "pinjaman/loadstatus",
        type: "POST",
        dataType: "json",
        data: { stscd: stscd },
        success: function(data) {
            $('#txtStatusCd').val(data.stscd);
            $('#txtStatusNm').val(data.stsnm);
            $('#lblStatus').text(data.stsnm);
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.responseText);
            $('body').css('cursor', 'default');
        }
    });
}

function authButton(butmo, curst, nexst, iscls, isrea) {
    var wfnum = $('#txtWfnum').val();
    if (isrea == "X") {
        $('#zmdlReason').modal('show');
        $("#txtReasonCurrst").val(curst);
        $("#txtReasonNextst").val(nexst);
    }
    switch (butmo) {
        case 'BTN_BACK_SELECT':
            location.href = '/simanda/pinjaman';
            break;

        case 'BTN_SAVE_DATA':
        case 'BTN_UPDATE_DATA':
        case 'BTN_LUNAS':
            saveData(butmo, curst, nexst, iscls, isrea);
            break;


        case 'BTN_UPLOAD_DATA':
            uploadData(butmo, curst, nexst, iscls, isrea);
            break;

        case 'BTN_REQ_APPV':
            saveData(butmo, curst, nexst, iscls, isrea);
            break;

        case 'BTN_APPROVED':
            var ask = confirm("Anda Yakin Menerima pinjaman Ini?");
            if (ask == true) {
                var yr = $('#RelYear').val();
                if(yr == 0000 || yr == 0000 || yr < 2000){
                    alert('Tahun Terakhir LKPD Audited BPK Tidak boleh kosong');
                    $('#RelYear').focus();
                }else{
                    saveData(butmo, curst, nexst, iscls, isrea);
                }
            }
            break;

        case 'BTN_TERIMA_DATA':
            var ask = confirm("Anda Yakin Menerima?");
            if (ask == true) {
                saveData(butmo, curst, nexst, iscls, isrea);
            }
            break;

        case 'BTN_DELETE_DATA':
            var ask = confirm("Anda Yakin Menghapus pinjaman Ini?");
            if (ask == true) {
                saveData(butmo, curst, nexst, iscls, isrea);
            }
            break;

        case 'BTN_DOC_SYARAT':
            location.href = '/simanda/pinjaman/view/' + wfnum;
            break;

        case 'BTN_DSCR':
            initDscr(wfnum);
            break;

        case 'BTN_PERTIMBANGAN':
            location.href = '/simanda/pinjaman/pertimbangan/' + wfnum;
            break;

        case 'BTN_LAPORAN':
            location.href = '/simanda/pinjaman/laporan/' + wfnum;
            break;



        default:
            break;
    }
}

function loaddata() {
    var wfnum = $('#txtWfnum').val();

    var formData = {
        'wfnum': wfnum,
    };
    $.ajax({
        url: baseurl + "pinjaman/loaddata",
        type: "POST",
        dataType: "json",
        data: formData,
        success: function(data) {

            var head = data.header;
            $('#txtDokumenNo').val(head.docnumber);
            $('#datetglSP1').val(head.doctgl);
            $('#txtNamaDaerah').val(head.namakab);
            $('#RelYear').val(head.realisasi_ta);
            loadStatus(head.curst);
            loadHistory();
            roleScreen(head.curst, ''),
                workflow();
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.responseText);
            $('body').css('cursor', 'default');
        }
    });
}

function loaddatadscr() {
    var wfnum = $('#txtWfnum').val();

    var formData = {
        'wfnum': wfnum,
    };
    $.ajax({
        url: baseurl + "pinjaman/loaddata",
        type: "POST",
        dataType: "json",
        data: formData,
        success: function(data) {

            var head = data.header;
            $('#txtDokumenNo').val(head.docnumber);
            $('#datetglSP1').val(head.doctgl);
            $('#txtNamaDaerah').val(head.namakab);
            $('#RelYear').val(head.realisasi_ta);
            $('#txtNoSuratKemendagri').val(head.surat_mendagri);
            $('#datetglSP2').val(head.tgl_surat);
            loadStatus(head.curst);
            loadHistory();
            roleScreen(head.curst, ''),
                workflow();

            if (head.file_mendagri_original != '') {
                $('#file_mendagri').show();
                document.getElementById('btnSuratDownload').innerHTML = '<a onclick="fdownload(' + "'" + head.file_mendagri_encrypt + "'" + ',' + "'" + head.file_mendagri_original + "'" + ');" class="btn btn-success btn-lg"><i class="icon-adt_atach"></i> ' + head.file_mendagri_original + '</a>';
            } else {
                $('#file_mendagri').hide();
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.responseText);
            $('body').css('cursor', 'default');
        }
    });
}

function fdownload(encrypt, original) {
    //alert(encrypt)
    location.href = baseurl + 'pinjaman/push_file/' + encrypt + '/' + original;
}

function saveData(butmo, curst, nexst, iscls, isrea) {

    var data = new FormData();

    data.append('butmo', butmo);
    data.append('curst', curst);
    data.append('nexst', nexst);
    data.append('iscls', iscls);
    data.append('isrea', isrea);


    data.append('wfnum', $('#txtWfnum').val());
    data.append('curst', $('#txtStatusCd').val());
    data.append('doctgl', $("#datetglSP1").val());
    data.append('docnumber', $("#txtDokumenNo").val());
    data.append('realisasi_ta', $("#RelYear").val());
    data.append('surat_mendagri', $("#txtNoSuratKemendagri").val());
    data.append('tgl_surat', $("#datetglSP2").val());

    $("#txtTentang").prop('required', true);

    $.ajax({
        url: baseurl + "pinjaman/saveData",
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

            if (butmo == 'BTN_SAVE_DATA') {
                loaddata();
            } else {
                loaddatadscr();
            }

            document.getElementById('ztxtAppsMsg').innerHTML = data.notif;
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.responseText);
            $('body').css('cursor', 'default');
        }
    });
}


function uploadData(butmo, curst, nexst, iscls, isrea) {

    var data = new FormData();

    data.append('butmo', butmo);
    data.append('curst', curst);
    data.append('nexst', nexst);
    data.append('iscls', iscls);
    data.append('isrea', isrea);


    data.append('wfnum', $('#txtWfnum').val());
    data.append('curst', $('#txtStatusCd').val());
    data.append('doctgl', $("#datetglSP1").val());
    data.append('docnumber', $("#txtDokumenNo").val());
    data.append('realisasi_ta', $("#RelYear").val());

    data.append('surat_mendagri', $("#txtNoSuratKemendagri").val());
    data.append('tgl_surat', $("#datetglSP2").val());
    data.append('fileSurat', $('#fileSurat')[0].files[0]);

    $("#txtTentang").prop('required', true);

    $.ajax({
        url: baseurl + "pinjaman/uploadData",
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
            loaddatadscr();
            document.getElementById('ztxtAppsMsg').innerHTML = data.notif;
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.responseText);
            $('body').css('cursor', 'default');
        }
    });
}

function rejectData() {

    var data = new FormData();

    data.append('wfnum', $('#txtWfnum').val());
    data.append('curre', $('#txtReasonCurrst').val());
    data.append('nexst', $('#txtReasonNextst').val());
    data.append('reasn', $('#txtReason').val());

    $.ajax({
        url: baseurl + "pinjaman/rejectData",
        type: 'POST',
        data: data,
        processData: false,
        contentType: false,
        dataType: "json",
        beforeSend: function(e) {
            // $('#zdivOverlay').show();
            if (e && e.overrideMimeType) {
                e.overrideMimeType("application/json;charset=UTF-8");
            }
        },
        success: function(data) {
            // $('#zdivOverlay').hide();
            $("#txtWfnum").val(data.wfnum);
            $('#fileSuratPengantar').val(null);
            $('#fileKesepakatanDPRD').val(null);
            $('#fileRancanganPerda').val(null);
            loaddata();
            //document.getElementById('ztxtAppsMsg').innerHTML = data.message;			
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.responseText);
            $('body').css('cursor', 'default');
        }
    });
}


function workflow() {
    var formData = {
        'wfnum': $('#txtWfnum').val(),
    };
    $.ajax({
        url: baseurl + "pinjaman/workflow",
        type: "POST",
        dataType: "json",
        data: formData,
        success: function(data) {
            $("#zbtnAction").html('');
            $("#zbtnAction").html(data.button);
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.responseText);
            $('body').css('cursor', 'default');
        }
    });
}


function loadHistory() {

    // hapus datatable
    var table = $('#tblHistory').DataTable();
    table.destroy();

    var formData = {
        'wfnum': $('#txtWfnum').val(),
    };

    $('#tblHistory').DataTable({
        "ajax": {
            "url": baseurl + "pinjaman/loadHistory",
            "type": "POST",
            "deferLoading": 57,
            "data": formData,
            "dataSrc": ""
        },
        "columns": [
            { "data": "zdate" },
            { "data": "ztime" },
            { "data": "zuser" },
            { "data": "from_status" },
            { "data": "to_status" },
            { "data": "reason" }
        ]
    });
}

function jenisStatus() {
    var formData = {
        'mode': "JENISSTATUS",
    };
    $.ajax({
        url: baseurl + "pinjaman/loadDropdown",
        type: "POST",
        dataType: "json",
        data: formData,
        beforeSend: function(e) {},
        success: function(data) {
            $('#slcJenisStatus option').remove();
            $('#slcJenisStatus').append(data.option);
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.responseText);
            $('body').css('cursor', 'default');
        }
    });
}

function roleScreen(curst, nexst) {

    if (curst == 'RNA1') {
        $('#divRelYear').hide();
        $('#main-screen-1').hide();
    } 
    
    if (curst == 'RNB1' || curst == 'RNBX') {
        $('#divRelYear').hide();
        $('#main-screen-1').show();
    }

    if (curst == 'RNC1') {
        $('#tabHeader *').attr('readonly', true);
        $('#RelYear').attr('readonly', false);
    }

    if (curst == 'RND1' || curst == 'RNE1') {
        $('#tabHeader *').attr('readonly', true);
        // $('#tab1 *').attr('readonly', true);
        // $('#tab2 *').attr('readonly', true);
    }

    if (curst == 'RNF1') {
        $('#tabHeader *').attr('readonly', true);
        $('#tab1 *').attr('readonly', true);
        $('#tab2 *').attr('readonly', true);
    }

}

function userprofile(mode) {

    // hapus datatable
    var table = $('#tblListUsers').DataTable();
    table.destroy();

    var formData = {
        'mode': mode,
    };

    if (mode == 'KAB') {
        var cols = [
            { "data": "usrcd" },
            { "data": "daerah" },
            { "data": "nama_lengkap" },
            { "data": "username" },
            { "data": "jabatan" },
            { "data": "email" },
            { "data": "telepon" },
            { "data": "status" }
        ];
    }

    if (mode == 'PUSAT') {
        var cols = [
            { "data": "usrcd" },
            { "data": "nama_lengkap" },
            { "data": "username" },
            { "data": "jabatan" },
            { "data": "email" },
            { "data": "telepon" },
            { "data": "status" }
        ];
    }

    $('#tblListUsers').DataTable({
        "ajax": {
            "url": baseurl + "profile/loadAllUsers",
            "type": "POST",
            "deferLoading": 57,
            "data": formData,
            "scrollY": "200px",
            "scrollCollapse": true,
            "paging": false,
            "dataSrc": ""
        },
        "columns": cols
    });

    $('#tblListUsers tbody').on('click', 'tr', function() {
        var table = $('#tblListUsers').DataTable();
        var data = table.row(this).data();
        //alert( 'You clicked on '+data["wfcat"]+'\'s row' );
        if (data["group_user"] == 0) {
            location.href = baseurl + 'profile/detail/pusat/' + data["usrcd"];
        } else {
            location.href = baseurl + 'profile/detail/kabkot/' + data["usrcd"];
        }

    });
}

function loadDetailUsers() {
    var formData = {
        'txtusrcd': $('#txtusrcd').val(),
    };
    $.ajax({
        url: baseurl + "profile/getDataUsers",
        type: "POST",
        dataType: "json",
        data: formData,
        success: function(data) {

            $('#txtDaerah').val(data.daerah);
            $("#txtNamaLengkap").val(data.nama_lengkap);
            $("#txtUsername").val(data.username);
            $("#txtJabatan").val(data.jabatan);
            $("#txtEmail").val(data.email);
            $("#txtTlpNo").val(data.telepon);
            $("#txtFaxNo").val(data.fax);
            $("#slcIsActive").val(data.status);
            $("#slcIsSuperAdmin").val(data.superadmin);

        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.responseText);
            $('body').css('cursor', 'default');
        }
    });
}

function slckabkot() {
    var formData = {
        'kodeprov': $("#slcDaerahProv").val(),
    };
    $.ajax({
        url: baseurl + "pinjaman/slckabkot",
        type: "POST",
        dataType: "json",
        data: formData,
        beforeSend: function(e) {},
        success: function(data) {
            $('#slcDaerahKab option').remove();
            $('#slcDaerahKab').append(data.option);
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.responseText);
            $('body').css('cursor', 'default');
        }
    });
}

function getCodeNOS(type, size) {
    var text = "";
    var possible = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";

    for (var i = 0; i < size; i++)
        text += possible.charAt(Math.floor(Math.random() * possible.length));

    return type + text;
}

function getCodeNDI() {
    $.ajax({
        url: baseurl + "pinjaman/getndi",
        type: 'POST',
        processData: false,
        contentType: false,
        dataType: "json",
        success: function(data) {
            if (data.status == 0) {
                $('#txtWfnum').val(data.ndi);
            } else {
                $('#txtWfnum').val('');
            }
        }
    });
}

function addItem(title, fileid) {

    var data = new FormData();

    data.append('wfnum', $('#txtWfnum').val());
    data.append('title', $('#' + title).val());
    data.append('filenm', fileid);
    data.append('fileid', $('#' + fileid)[0].files[0]);

    data.append('persyaratan_id', $('#persyaratan_id').val());

    if ($('#' + title).val() == '') {
        $('#' + title).focus();
        return;
    }


    $.ajax({
        url: baseurl + "pinjaman/additem",
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

            $('#filePersyaratan, #txtDescFiles').val('');
            if (data.status == 0) {
                formPersyaratanDataTable();
                loadItem($('#persyaratan_id').val(), $('#txtWfnum').val());
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

function loadItem(filety, wfnum) {

    var data = new FormData();

    data.append('wfnum', wfnum);
    data.append('persyaratan_id', filety);

    $.ajax({
        url: baseurl + "pinjaman/loaditem",
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
            $('#tblItemData').html(data.html);
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.responseText);
            $('body').css('cursor', 'default');
        }
    });
}

function delItem(item_id, wfnum, persyaratan_id) {

    var data = new FormData();

    data.append('item_id', item_id);

    if (confirm("Apakah anda yakin ingin menghapus file ini!")) {
        $.ajax({
            url: baseurl + "pinjaman/delitem",
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
                formPersyaratanDataTable();
                loadItem(persyaratan_id, wfnum);
            }
        });
    } else {
        return false;
    }
}

function persyaratanDataTable() {

    // hapus datatable
    var table = $('#tblListPersyaratan').DataTable();
    table.destroy();


    var cols = [
        { "data": "persyaratan_id", "width": "5%" },
        { "data": "persyaratan_name" },
        { "data": "isactive", "width": "5%" }
    ];


    $('#tblListPersyaratan').DataTable({
        "ajax": {
            "url": baseurl + "persyaratan/loadAllPersyaratan",
            "type": "POST",
            "deferLoading": 57,
            "pageLength": 20,
            "scrollY": "200px",
            "scrollCollapse": true,
            "dataSrc": ""
        },
        "columns": cols
    });

    $('#tblListPersyaratan tbody').on('click', 'tr', function() {
        var table = $('#tblListPersyaratan').DataTable();
        var data = table.row(this).data();
        location.href = baseurl + 'persyaratan/change/' + data["persyaratan_id"];

    });
}

function formPersyaratanDataTable() {
    var wfnum = $('#txtWfnum').val();
    var formData = {
        'wfnum': wfnum,
    };

    $('#tblListPersyaratanFrom').DataTable({
        "ajax": {
            "url": baseurl + "pinjaman/loadAllPersyaratan",
            "type": "POST",
            "data": formData,
            "dataSrc": ""
        },
        "bAutoWidth": false,
        "destroy": true,
        "paging": false,
        "ordering": false,
        "info": true,
        "searching": false,
        "columnDefs": [
            { "title": "No", "data": "persyaratan_id", "width": "5%", "targets": 0 },
            { "title": "Dokumen Persyaratan", "data": "persyaratan_name", "width": "90%", "targets": 1 },
            { "title": "Uploads", "data": "checkList", "width": "5%", "targets": 2 }
        ]
    });

    $('#tblListPersyaratanFrom tbody').on('click', 'tr', function() {
        var table = $('#tblListPersyaratanFrom').DataTable();
        var data = table.row(this).data();

        if ($('#txtStatusCd').val() != 'RNA1') {
            $("#tabData, #tab1").removeClass("active");
            $('#tabDetail, #tab2').addClass("active");
            $('#persyaratan_id').val(data.persyaratan_id);
            loadItem(data.persyaratan_id, wfnum);
        }

    });
}


function formatRupiah(angka, prefix) {
    var number_string = angka.replace(/[^.\d]/g, '').toString(),
        split = number_string.split('.'),
        sisa = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    // tambahkan titik jika yang di input sudah menjadi angka ribuan
    if (ribuan) {
        separator = sisa ? ',' : '';
        rupiah += separator + ribuan.join(',');
    }

    rupiah = split[1] != undefined ? rupiah + '.' + split[1] : rupiah;
    return prefix == undefined ? rupiah : (rupiah ? rupiah : '');
}

function numberOnly(angka, prefix) {
    var number_string = angka.replace(/[^.\d]/g, '').toString();
    return number_string;
}

function initFile(id) {
    $('#ktg_doc').val(id);
}


function loadDocument(id) {

    var formData = {
        "ktg_id": id,
        "wfnum": $('#txtWfnum').val(),
    };
    $.ajax({
        url: baseurl + "api/loaddoc",
        type: "POST",
        dataType: "json",
        data: formData,
        beforeSend: function(xhr) {},
        success: function(data) {
            $('#ktg_doc').val(id);
            $('#title_doc').val(data.doc_title);
            $('#notes_doc').val(data.doc_footer);
            $('#ttd_tangan').val(data.doc_ttd);
        },
        error: function() {
            alert('Opps: Something Error!');
        }
    });
}

function saveDocument() {
    $.ajax({
        url: baseurl + "api/savedoc",
        type: "POST",
        data: $('#form-header, #frmModalPrint').serializeArray(),
        beforeSend: function(xhr) {},
        success: function(data) {
            $('#templatePrint').modal('hide');
            window.open(baseurl + "api/printdoc/" + data.ktg_id + "/" + data.wfnum, '_blank');
        },
        error: function() {
            alert('Opps: Something Error!');
        }
    });
}

function uploadDataExcel() {

    var upload = new FormData();
    upload.append('ktg_doc', $("#ktg_doc").val());
    upload.append('wfnum', $("#txtWfnum").val());
    upload.append('files', $("#fileupload")[0].files[0]);

    $.ajax({
        url: baseurl + "pinjaman/importexcel",
        type: "POST",
        dataType: "json",
        processData: false,
        contentType: false,
        data: upload,
        beforeSend: function(xhr) {
            var ask = confirm("Apakah anda ingin melanjutkan proses?");
            document.getElementById('ztxtAppsMsg').innerHTML = "";
            if (ask == true) {
                if ($("#fileupload").val() == '') {
                    $("#fileupload").focus();
                    return false;
                }
            } else {
                return false;
            }
        },
        success: function(data) {

            if (data.status == 1) {
                alert(data.message);
            } else {
                $('#uploadExcel').modal('hide');

                var ktg = $("#ktg_doc").val();
                if (ktg == 4) {
                    $.ajax({
                        url: baseurl + "doc/tab11/loadtable",
                        type: "POST",
                        dataType: "json",
                        data: { "wfnum": $("#txtWfnum").val() },
                        beforeSend: function(xhr) {},
                        success: function(data) {
                            $('#tab11_tblItemData').html(data.html);
                        },
                        error: function() {
                            alert('Opps: Something Error!');
                        }
                    });
                }

                if (ktg == 2) {
                    $.ajax({
                        url: baseurl + "doc/tab9/loadtable",
                        type: "POST",
                        dataType: "json",
                        data: { "wfnum": $("#txtWfnum").val() },
                        beforeSend: function(xhr) {},
                        success: function(data) {
                            $('#tab9_tblItemData').html(data.html);
                        },
                        error: function() {
                            alert('Opps: Something Error!');
                        }
                    });
                }

                if (ktg == 3) {
                    $.ajax({
                        url: baseurl + "doc/tab10/loadtable",
                        type: "POST",
                        dataType: "json",
                        data: { "wfnum": $("#txtWfnum").val() },
                        beforeSend: function(xhr) {},
                        success: function(data) {
                            $('#tab10_tblItemData').html(data.html);
                        },
                        error: function() {
                            alert('Opps: Something Error!');
                        }
                    });
                }

            }

        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.responseText);
            $('body').css('cursor', 'default');
        }
    });

}

function initDscr(wfnum) {
    $.ajax({
        url: baseurl + "pinjaman/initdscr/" + wfnum,
        type: "POST",
        success: function(data) {
            location.href = '/simanda/pinjaman/dscr/' + wfnum;
        },
    });
}

function statusDataTable() {

    // hapus datatable
    var table = $('#tblListStatus').DataTable();
    table.destroy();


    var cols = [
        { "data": "stssq", "width": "5%" },
        { "data": "stsnm" }
    ];


    $('#tblListStatus').DataTable({
        "ajax": {
            "url": baseurl + "status/loadAllStatus",
            "type": "POST",
            "deferLoading": 57,
            "pageLength": 20,
            "scrollY": "200px",
            "scrollCollapse": true,
            "dataSrc": ""
        },
        "columns": cols
    });

    $('#tblListStatus tbody').on('click', 'tr', function() {
        var table = $('#tblListStatus').DataTable();
        var data = table.row(this).data();
        location.href = baseurl + 'status/change/' + data["stssq"];

    });
}

function listpertimbanganDataTable() {

    // hapus datatable
    var table = $('#tblListPertimbangan').DataTable();
    table.destroy();


    var cols = [
        { "data": "wfnum", "width": "5%" },
        { "data": "namakab", "width": "20%" },
        { "data": "docnumber", "width": "20%" },
        { "data": "doctgl", "width": "10%" },
        { "data": "surat_mendagri", "width": "20%" },
        { "data": "tgl_surat", "width": "10%" },
    ];


    $('#tblListPertimbangan').DataTable({
        "ajax": {
            "url": baseurl + "listpertimbangan/json",
            "type": "POST",
            "deferLoading": 57,
            "pageLength": 20,
            "scrollY": "200px",
            "scrollCollapse": true,
            "dataSrc": ""
        },
        "columns": cols
    });


}

function urusanDataTable() {

    // hapus datatable
    var table = $('#tblListUrusan').DataTable();
    table.destroy();


    var cols = [
        { "data": "urusan_id", "width": "5%" },
        { "data": "urusan" }
    ];


    $('#tblListUrusan').DataTable({
        "ajax": {
            "url": baseurl + "urusan/loadAllUrusan",
            "type": "POST",
            "deferLoading": 57,
            "pageLength": 20,
            "scrollY": "200px",
            "scrollCollapse": true,
            "dataSrc": ""
        },
        "columns": cols
    });

    $('#tblListUrusan tbody').on('click', 'tr', function() {
        var table = $('#tblListUrusan').DataTable();
        var data = table.row(this).data();
        location.href = baseurl + 'urusan/change/' + data["urusan_id"];

    });
}

function daerahDataTable() {

    // hapus datatable
    var table = $('#tblListDaerah').DataTable();
    table.destroy();


    var cols = [
        { "data": "id", "width": "5%" },
        { "data": "namakab" },
        { "data": "kdprov" },
        { "data": "kdkabkota" }


    ];


    $('#tblListDaerah').DataTable({
        "ajax": {
            "url": baseurl + "daerah/loadAllDaerah",
            "type": "POST",
            "deferLoading": 57,
            "pageLength": 20,
            "scrollY": "200px",
            "scrollCollapse": true,
            "dataSrc": ""
        },
        "columns": cols
    });

    $('#tblListDaerah tbody').on('click', 'tr', function() {
        var table = $('#tblListDaerah').DataTable();
        var data = table.row(this).data();
        location.href = baseurl + 'daerah/change/' + data["id"];

    });
}

function kategoriDataTable() {

    // hapus datatable
    var table = $('#tblListKategori').DataTable();
    table.destroy();


    var cols = [
        { "data": "ktg_id", "width": "5%" },
        { "data": "kategori" }
    ];


    $('#tblListKategori').DataTable({
        "ajax": {
            "url": baseurl + "kategori/loadAllKategori",
            "type": "POST",
            "deferLoading": 57,
            "pageLength": 20,
            "scrollY": "200px",
            "scrollCollapse": true,
            "dataSrc": ""
        },
        "columns": cols
    });

    $('#tblListKategori tbody').on('click', 'tr', function() {
        var table = $('#tblListKategori').DataTable();
        var data = table.row(this).data();
        location.href = baseurl + 'kategori/change/' + data["ktg_id"];

    });
}