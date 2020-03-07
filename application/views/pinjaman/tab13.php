<div class="row">
    <div class="col-sm-12 col-md-12">
        <p>
            <button id="tab13-save" class="btn btn-default btn-sm"><i class="splashy-document_small_download"></i>  Simpan Data</button> 
            <button onclick="loadDocument(13);" data-toggle="modal" data-backdrop="static" href="#templatePrint" data-placement="bottom" data-container="body" class="btn btn-default btn-sm"><i class="splashy-printer"></i>  Cetak Dokumen</button>  
        </p>
        <form class="form-horizontal" id="tab13-form" role="form">

            <h3 class="heading">PERHITUNGAN DEFISIT YANG DIBIAYAI DARI PINJAMAN DAERAH</h3>

            <div class="form-group">
                <label for="tab13_tahun_anggaran" class="col-lg-2 control-label">Tahun Anggaran</label>
                <div class="col-lg-1">
                    <input type="text" class="input-sm form-control input-align text-input-align" name="tab13_tahun_anggaran" id="tab13_tahun_anggaran" >
                </div>
            </div>

            <div class="form-group">
                <label for="tab13_pendapatan_daerah" class="col-lg-2 control-label">Pendapatan Daerah</label>
                <div class="col-lg-3">
                    <input type="text" class="input-sm form-control input-align text-input-align" name="tab13_pendapatan_daerah" id="tab13_pendapatan_daerah" >
                </div>
            </div>

            <div class="form-group">
                <label for="tab13_belanja" class="col-lg-2 control-label">Belanja</label>
                <div class="col-lg-3">
                    <input type="text" class="input-sm form-control input-align text-input-align" name="tab13_belanja" id="tab13_belanja" >
                </div>
            </div>

            <div class="form-group">
                <label for="tab13_rencana_pinjaman" class="col-lg-2 control-label">Rencana Pinjaman</label>
                <div class="col-lg-3">
                    <input type="text" class="input-sm form-control input-align text-input-align" name="tab13_rencana_pinjaman" id="tab13_rencana_pinjaman" >
                </div>
            </div>

            <div class="form-group">
                <label for="tab13_defisit_yang_dibiayai_dari_pinjaman" class="col-lg-2 control-label">Defisit Yang Dibiayai Dari Pinjaman</label>
                <div class="col-lg-3">
                    <input type="text" class="input-sm form-control input-align text-input-align" name="tab13_defisit_yang_dibiayai_dari_pinjaman" id="tab13_defisit_yang_dibiayai_dari_pinjaman" >
                </div>
            </div>

        </form>

    </div>
</div>


<script type="text/javascript">

        var wfnum = $('#txtWfnum').val();
        tab13_loadtable(wfnum);
        function tab13_loadtable(wfnum) {
            $.ajax({
                url     : baseurl+"doc/tab13/loaddata",
                type    : "POST",
                dataType: "json",
                data    : { "wfnum" : wfnum },
                beforeSend: function(xhr){
                }, 
                success : function(data){
                    $('#tab13_tahun_anggaran').val(data.tahun_anggaran);
                    $('#tab13_pendapatan_daerah').val(data.pendapatan_daerah);
                    $('#tab13_belanja').val(data.belanja);
                    $('#tab13_rencana_pinjaman').val(data.rencana_pinjaman);
                    $('#tab13_defisit_yang_dibiayai_dari_pinjaman').val(data.defisit_yang_dibiayai_dari_pinjaman);
                },
                error   : function(){
                    alert('Opps: Something Error!');
                }
            });
        }

        var tab13_pendapatan_daerah = document.getElementById('tab13_pendapatan_daerah');
		tab13_pendapatan_daerah.addEventListener('keyup', function(e){
			tab13_pendapatan_daerah.value = formatRupiah(this.value, '');
        });

        var tab13_belanja = document.getElementById('tab13_belanja');
		tab13_belanja.addEventListener('keyup', function(e){
			tab13_belanja.value = formatRupiah(this.value, '');
        });

        var tab13_rencana_pinjaman = document.getElementById('tab13_rencana_pinjaman');
		tab13_rencana_pinjaman.addEventListener('keyup', function(e){
			tab13_rencana_pinjaman.value = formatRupiah(this.value, '');
        });

        var tab13_dana_ptab13_defisit_yang_dibiayai_dari_pinjamannyesuaian = document.getElementById('tab13_defisit_yang_dibiayai_dari_pinjaman');
		tab13_defisit_yang_dibiayai_dari_pinjaman.addEventListener('keyup', function(e){
			tab13_defisit_yang_dibiayai_dari_pinjaman.value = formatRupiah(this.value, '');
        });

        

        $('#tab13-save').on("click", function(e) {
            $.ajax({
                url     : baseurl+"doc/tab13/savedata",
                type    : "POST",
                data    : $('#form-header, #tab13-form').serializeArray(),
                beforeSend: function(xhr){
                    $('#tab13-save').prop('disabled',true);
                }, 
                success : function(data){
                    $('#tab13-save').prop('disabled',false);
                    document.getElementById('ztxtAppsMsg').innerHTML = data.notif;	
                    tab13_loadtable($('#txtWfnum').val());
                },
                error   : function(){
                    alert('Opps: Something Error!');
                }
            });
            return false;
        });
  
</script>

