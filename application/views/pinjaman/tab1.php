<style>
.flex-container {
  border-radius: 5px;
  color:#FFFFFF;
  display: flex;
}

.flex-container > div {
  border-radius: 5px;
  padding: 8px;
  box-shadow: 1px 1px 2px #888888;
  margin: 4px;
  
  font-size: 12px;
  vertical-align: top;
}
</style>


<div class="row">
    <div class="col-sm-12 col-md-12">
    <h3 class="heading">PERHITUNGAN JUMLAH SISA PINJAMAN DAERAH Di Bawah 75%</h3>
        <div class="flex-container">
            <div style="width: 25%; background-color:DodgerBlue;text-align: justify;">TATACARA:</div>
            <div style="width: 25%; background-color:#3cb371;text-align: justify;">1. Input data pada form ini</div>
            <div style="width: 25%; background-color:#3cb371;text-align: justify;">2. Klik tombol Simpan Data</div>
            <div style="width: 25%; background-color:#3cb371;text-align: justify;">3. Klik tombol Hitung</div>  
            <div style="width: 25%; background-color:#3cb371;text-align: justify;">4. Klik tombol Cetak</div>
        </div><br>
        <p>
            <button id="tab1-save" class="btn btn-default btn-sm"><i class="splashy-document_small_download"></i>  Simpan Data</button> 
            <button id="tab1-calculate" class="btn btn-default btn-sm"><i class="splashy-refresh"></i>  Hitung</button> 
            <button onclick="loadDocument(11);" data-toggle="modal" data-backdrop="static" href="#templatePrint" data-placement="bottom" data-container="body" class="btn btn-default btn-sm"><i class="splashy-printer"></i>  Cetak Dokumen</button>  
        </p>
        <form class="form-horizontal" id="tab1-form" role="form">

            
            <div class="form-group">
                <label for="tab1_rencana_pinjaman" class="col-lg-2 control-label">Rencana Pinjaman</label>
                <div class="col-lg-3">
                    <input type="text" class="input-sm form-control input-align text-input-align" name="tab1_rencana_pinjaman" id="tab1_rencana_pinjaman"  >
                </div>
            </div>

            <div class="form-group">
                <label for="tab1_sisa_pinjaman" class="col-lg-2 control-label">Sisa Pinjaman</label>
                <div class="col-lg-3">
                    <input type="text" class="input-sm form-control input-align text-input-align" name="tab1_sisa_pinjaman" id="tab1_sisa_pinjaman" >
                </div>
            </div>

            <div class="formSep"></div>

            <h3 class="heading">KOMPONEN: A</h3>
            <div class="form-group">
                <label for="tab1_pendapatan_daerah" class="col-lg-2 control-label">Pendapatan Daerah</label>
                <div class="col-lg-3">
                    <input type="text" class="input-sm form-control input-align text-input-align" name="tab1_pendapatan_daerah" id="tab1_pendapatan_daerah" >
                </div>
            </div>

            <div class="formSep"></div>


            <h3 class="heading">KOMPONEN: B</h3>
            <div class="form-group">
                <label for="tab1_dak" class="col-lg-2 control-label">DAK</label>
                <div class="col-lg-3">
                    <input type="text" class="input-sm form-control input-align text-input-align" name="tab1_dak" id="tab1_dak" >
                </div>
            </div>

            <div  class="form-group">
                <label for="tab1_dana_darurat" class="col-lg-2 control-label">Dana Darurat</label>
                <div class="col-lg-3">
                    <input type="text" class="input-sm form-control input-align text-input-align" name="tab1_dana_darurat" id="tab1_dana_darurat" >
                </div>
            </div>

            <div  class="form-group">
                <label for="tab1_dana_penyesuaian" class="col-lg-2 control-label">Dana Penyesuaian</label>
                <div class="col-lg-3">
                    <input type="text" class="input-sm form-control input-align text-input-align" name="tab1_dana_penyesuaian" id="tab1_dana_penyesuaian" >
                </div>
            </div>

        </form>

    </div>
</div>

<script type="text/javascript">

        var wfnum = $('#txtWfnum').val();
        tab1_loadtable(wfnum);
        function tab1_loadtable(wfnum){
            $.ajax({
                url     : baseurl+"doc/tab1/loaddata",
                type    : "POST",
                dataType: "json",
                data    : { "wfnum" : wfnum },
                beforeSend: function(xhr){
                }, 
                success : function(data){
                    $('#tab1_rencana_pinjaman').val(data.rencana_pinjaman);
                    $('#tab1_sisa_pinjaman').val(data.sisa_pinjaman);
                    $('#tab1_pendapatan_daerah').val(data.pendapatan_daerah);
                    $('#tab1_dak').val(data.dak);
                    $('#tab1_dana_darurat').val(data.dana_darurat);
                    $('#tab1_dana_penyesuaian').val(data.dana_penyesuaian);
                },
                error   : function(){
                    alert('Opps: Something Error!');
                }
            });
        }

        var tab1_rencana_pinjaman = document.getElementById('tab1_rencana_pinjaman');
		tab1_rencana_pinjaman.addEventListener('keyup', function(e){
			tab1_rencana_pinjaman.value = formatRupiah(this.value, '');
        });

        var tab1_sisa_pinjaman = document.getElementById('tab1_sisa_pinjaman');
		tab1_sisa_pinjaman.addEventListener('keyup', function(e){
			tab1_sisa_pinjaman.value = formatRupiah(this.value, '');
        });

        var tab1_pendapatan_daerah = document.getElementById('tab1_pendapatan_daerah');
		tab1_pendapatan_daerah.addEventListener('keyup', function(e){
			tab1_pendapatan_daerah.value = formatRupiah(this.value, '');
        });

        var tab1_dak = document.getElementById('tab1_dak');
		tab1_dak.addEventListener('keyup', function(e){
			tab1_dak.value = formatRupiah(this.value, '');
        });

        var tab1_dana_darurat = document.getElementById('tab1_dana_darurat');
		tab1_dana_darurat.addEventListener('keyup', function(e){
			tab1_dana_darurat.value = formatRupiah(this.value, '');
        });

        var tab1_dana_penyesuaian = document.getElementById('tab1_dana_penyesuaian');
		tab1_dana_penyesuaian.addEventListener('keyup', function(e){
			tab1_dana_penyesuaian.value = formatRupiah(this.value, '');
        });

        

        $('#tab1-save').on("click", function(e) {
            $.ajax({
                url     : baseurl+"doc/tab1/savedata",
                type    : "POST",
                data    : $('#form-header, #tab1-form').serializeArray(),
                beforeSend: function(xhr){
                    $('#tab1-save').prop('disabled',true);
                }, 
                success : function(data){
                    $('#tab1-save').prop('disabled',false);
                    document.getElementById('ztxtAppsMsg').innerHTML = data.notif;	
                    tab1_loadtable($('#txtWfnum').val());
                },
                error   : function(){
                    alert('Opps: Something Error!');
                }
            });
            return false;
        });

        $('#tab1-calculate').on("click", function(e) {
            $.ajax({
                url     : baseurl+"doc/tab1/calculate",
                type    : "POST",
                data    : $('#form-header, #tab1-form').serializeArray(),
                beforeSend: function(xhr){
                    $('#tab1-calculate').prop('disabled',true);
                }, 
                success : function(data){
                    $('#tab1-calculate').prop('disabled',false);
                    $('#tab1_rencana_pinjaman').val(data.rencana_pinjaman);
                    $('#tab1_sisa_pinjaman').val(data.sisa_pinjaman);
                    $('#tab1_pendapatan_daerah').val(data.pendapatan_daerah);
                    $('#tab1_dak').val(data.dak);
                    $('#tab1_dana_darurat').val(data.dana_darurat);
                    $('#tab1_dana_penyesuaian').val(data.dana_penyesuaian);       
                },
                error   : function(){
                    alert('Opps: Something Error!');
                }
            });
            return false;
        });


  
</script>

