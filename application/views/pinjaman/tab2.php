<div class="row">
    <div class="col-sm-12 col-md-12">
        
        <p>
            <button id="tab2-save" class="btn btn-default btn-sm"><i class="splashy-document_small_download"></i>  Simpan Data</button> 
            <button id="tab2-calculate" class="btn btn-default btn-sm"><i class="splashy-refresh"></i>  Calculate</button> 
            <button onclick="loadDocument(10);" data-toggle="modal" data-backdrop="static" href="#templatePrint" data-placement="bottom" data-container="body" class="btn btn-default btn-sm"><i class="splashy-printer"></i>  Cetak Dokumen</button>  
        </p>
        <form class="form-horizontal" id="tab2-form" role="form">

            <h3 class="heading">PERHITUNGAN DSCR (SESUAI PP 56 TH 2018)</h3>
            <div class="form-group">
                <label for="tab2_rencana_usulan_pinjaman" class="col-lg-2 control-label">Rencana usulan pinjaman</label>
                <div class="col-lg-3">
                    <input type="text" class="input-sm form-control input-align text-input-align" name="tab2_rencana_usulan_pinjaman" id="tab2_rencana_usulan_pinjaman" >
                </div>
            </div>

            <div  class="form-group">
                <label for="tab2_bunga_tahun" class="col-lg-2 control-label">Bunga/tahun (%)</label>
                <div class="col-lg-2">
                    <input type="text" class="input-sm form-control input-align text-input-align" name="tab2_bunga_tahun" id="tab2_bunga_tahun" >
                </div>
            </div>

            <div  class="form-group">
                <label for="tab2_jangka_waktu_pinjam" class="col-lg-2 control-label">Jangka waktu pinjam (tahun)</label>
                <div class="col-lg-2">
                    <input type="text" class="input-sm form-control input-align text-input-align" name="tab2_jangka_waktu_pinjam" id="tab2_jangka_waktu_pinjam" >
                </div>
            </div>

            <div  class="form-group">
                <label for="tab2_tenggang_waktu" class="col-lg-2 control-label">Tenggang waktu (tahun)</label>
                <div class="col-lg-2">
                    <input type="text" class="input-sm form-control input-align text-input-align" name="tab2_tenggang_waktu" id="tab2_tenggang_waktu" >
                </div>
            </div>
            <div class="formSep"></div>


            <h3 class="heading">KOMPONEN: A</h3>
            <div class="form-group">
                <label for="tab2_pad" class="col-lg-2 control-label">PAD</label>
                <div class="col-lg-3">
                    <input type="text" class="input-sm form-control input-align text-input-align" name="tab2_pad" id="tab2_pad" readonly="readonly" >
                </div>
            </div>

            <div  class="form-group">
                <label for="tab2_dbh" class="col-lg-2 control-label">DBH</label>
                <div class="col-lg-3">
                    <input type="text" class="input-sm form-control input-align text-input-align" name="tab2_dbh" id="tab2_dbh" readonly="readonly" >
                </div>
            </div>

            <div  class="form-group">
                <label for="tab2_dau" class="col-lg-2 control-label">DAU</label>
                <div class="col-lg-3">
                    <input type="text" class="input-sm form-control input-align text-input-align" name="tab2_dau" id="tab2_dau" readonly="readonly" >
                </div>
            </div>

            <div class="formSep"></div>


            <h3 class="heading">KOMPONEN: B</h3>
            <div class="form-group">
                <label for="tab2_belanja_pegawai" class="col-lg-2 control-label">Belanja Pegawai</label>
                <div class="col-lg-3">
                    <input type="text" class="input-sm form-control input-align text-input-align" name="tab2_belanja_pegawai" id="tab2_belanja_pegawai" readonly="readonly" >
                </div>
            </div>

            <div  class="form-group">
                <label for="tab2_dbh_dr" class="col-lg-2 control-label">DBH-DR</label>
                <div class="col-lg-3">
                    <input type="text" class="input-sm form-control input-align text-input-align" name="tab2_dbh_dr" id="tab2_dbh_dr" readonly="readonly" >
                </div>
            </div>

            <div class="formSep"></div>

            <h3 class="heading">KOMPONEN: C</h3>

            <div class="form-group">
                <label for="tab2_angsuran_bunga" class="col-lg-3 control-label">Angsuran bunga</label>
                <div class="col-lg-3">
                    <input type="text" class="input-sm form-control input-align text-input-align" name="tab2_angsuran_bunga" id="tab2_angsuran_bunga" readonly="readonly" >
                </div>
            </div>

            <div  class="form-group">
                <label for="tab2_angsuran_pokok" class="col-lg-3 control-label">Angsuran pokok (jumlah pinjaman/jangka waktu)</label>
                <div class="col-lg-3">
                    <input type="text" class="input-sm form-control input-align text-input-align" name="tab2_angsuran_pokok" id="tab2_angsuran_pokok" readonly="readonly" >
                </div>
            </div>

            <div  class="form-group">
                <label for="tab2_biaya_lain" class="col-lg-3 control-label">Biaya lain (diprediksi 1%)</label>
                <div class="col-lg-3">
                    <input type="text" class="input-sm form-control input-align text-input-align" name="tab2_biaya_lain" id="tab2_biaya_lain" readonly="readonly" >
                </div>
            </div>

            <div  class="form-group">
                <label for="tab2_pembayaran_pokok" class="col-lg-3 control-label">Pembayaran pokok pinjaman lama</label>
                <div class="col-lg-3">
                    <input type="text" class="input-sm form-control input-align text-input-align" name="tab2_pembayaran_pokok" id="tab2_pembayaran_pokok" readonly="readonly" >
                </div>
            </div>

            <div  class="form-group">
                <label for="tab2_sisa_pembayaran_pokok_pinjaman" class="col-lg-3 control-label">Sisa pembayaran pokok pinjaman</label>
                <div class="col-lg-3">
                    <input type="text" class="input-sm form-control input-align text-input-align" name="tab2_sisa_pembayaran_pokok_pinjaman" id="tab2_sisa_pembayaran_pokok_pinjaman" readonly="readonly" >
                </div>
            </div>

            <div  class="form-group">
                <label for="tab2_bunga_pinjaman_lama" class="col-lg-3 control-label">Bunga pinjaman lama</label>
                <div class="col-lg-3">
                    <input type="text" class="input-sm form-control input-align text-input-align" name="tab2_bunga_pinjaman_lama" id="tab2_bunga_pinjaman_lama" readonly="readonly" >
                </div>
            </div>

            <div  class="form-group">
                <label for="tab2_sisa_pembayaran_bunga_pinjaman" class="col-lg-3 control-label">Sisa pembayaran bunga pinjaman</label>
                <div class="col-lg-3">
                    <input type="text" class="input-sm form-control input-align text-input-align" name="tab2_sisa_pembayaran_bunga_pinjaman" id="tab2_sisa_pembayaran_bunga_pinjaman" readonly="readonly" >
                </div>
            </div>

            <div class="formSep"></div>

        </form>

    </div>
</div>

<script type="text/javascript">

        var wfnum = $('#txtWfnum').val();
        tab2_loadtable(wfnum);
        function tab2_loadtable(wfnum){
            $.ajax({
                url     : baseurl+"doc/tab2/loaddata",
                type    : "POST",
                dataType: "json",
                data    : { "wfnum" : wfnum },
                beforeSend: function(xhr){
                }, 
                success : function(data){
                    $('#tab2_rencana_usulan_pinjaman').val(data.rencana_usulan_pinjaman);
                    $('#tab2_bunga_tahun').val(data.bunga_tahun);
                    $('#tab2_jangka_waktu_pinjam').val(data.jangka_waktu_pinjam);
                    $('#tab2_tenggang_waktu').val(data.tenggang_waktu);
                    $('#tab2_pad').val(data.pad);
                    $('#tab2_dbh').val(data.dbh);
                    $('#tab2_dau').val(data.dau);
                    $('#tab2_belanja_pegawai').val(data.belanja_pegawai);
                    $('#tab2_dbh_dr').val(data.dbh_dr);
                    $('#tab2_angsuran_bunga').val(data.angsuran_bunga);
                    $('#tab2_angsuran_pokok').val(data.angsuran_pokok);
                    $('#tab2_biaya_lain').val(data.biaya_lain);
                    $('#tab2_pembayaran_pokok').val(data.pembayaran_pokok);
                    $('#tab2_sisa_pembayaran_pokok_pinjaman').val(data.sisa_pembayaran_pokok_pinjaman);
                    $('#tab2_bunga_pinjaman_lama').val(data.bunga_pinjaman_lama);
                    $('#tab2_sisa_pembayaran_bunga_pinjaman').val(data.sisa_pembayaran_bunga_pinjaman);
                },
                error   : function(){
                    alert('Opps: Something Error!');
                }
            });
        }

        var tab2_rencana_usulan_pinjaman = document.getElementById('tab2_rencana_usulan_pinjaman');
		tab2_rencana_usulan_pinjaman.addEventListener('keyup', function(e){
			tab2_rencana_usulan_pinjaman.value = formatRupiah(this.value, '');
        });

        var tab2_bunga_tahun = document.getElementById('tab2_bunga_tahun');
		tab2_bunga_tahun.addEventListener('keyup', function(e){
			tab2_bunga_tahun.value = formatRupiah(this.value, '');
        });

        var tab2_jangka_waktu_pinjam = document.getElementById('tab2_jangka_waktu_pinjam');
		tab2_jangka_waktu_pinjam.addEventListener('keyup', function(e){
			tab2_jangka_waktu_pinjam.value = formatRupiah(this.value, '');
        });

        var tab2_tenggang_waktu = document.getElementById('tab2_tenggang_waktu');
		tab2_tenggang_waktu.addEventListener('keyup', function(e){
			tab2_tenggang_waktu.value = formatRupiah(this.value, '');
        });

        var tab2_pad = document.getElementById('tab2_pad');
		tab2_pad.addEventListener('keyup', function(e){
			tab2_pad.value = formatRupiah(this.value, '');
        });

        var tab2_dbh = document.getElementById('tab2_dbh');
		tab2_dbh.addEventListener('keyup', function(e){
			tab2_dbh.value = formatRupiah(this.value, '');
        });

        var tab2_dau = document.getElementById('tab2_dau');
		tab2_dau.addEventListener('keyup', function(e){
			tab2_dau.value = formatRupiah(this.value, '');
        });

        var tab2_belanja_pegawai = document.getElementById('tab2_belanja_pegawai');
		tab2_belanja_pegawai.addEventListener('keyup', function(e){
			tab2_belanja_pegawai.value = formatRupiah(this.value, '');
        });
        var tab2_dbh_dr = document.getElementById('tab2_dbh_dr');
		tab2_dbh_dr.addEventListener('keyup', function(e){
			tab2_dbh_dr.value = formatRupiah(this.value, '');
        });
        var tab2_angsuran_bunga = document.getElementById('tab2_angsuran_bunga');
		tab2_angsuran_bunga.addEventListener('keyup', function(e){
			tab2_angsuran_bunga.value = formatRupiah(this.value, '');
        });
        var tab2_angsuran_pokok = document.getElementById('tab2_angsuran_pokok');
		tab2_angsuran_pokok.addEventListener('keyup', function(e){
			tab2_angsuran_pokok.value = formatRupiah(this.value, '');
        });
        var tab2_biaya_lain = document.getElementById('tab2_biaya_lain');
		tab2_biaya_lain.addEventListener('keyup', function(e){
			tab2_biaya_lain.value = formatRupiah(this.value, '');
        });
        var tab2_pembayaran_pokok = document.getElementById('tab2_pembayaran_pokok');
		tab2_pembayaran_pokok.addEventListener('keyup', function(e){
			tab2_pembayaran_pokok.value = formatRupiah(this.value, '');
        });
        var tab2_sisa_pembayaran_pokok_pinjaman = document.getElementById('tab2_sisa_pembayaran_pokok_pinjaman');
		tab2_sisa_pembayaran_pokok_pinjaman.addEventListener('keyup', function(e){
			tab2_sisa_pembayaran_pokok_pinjaman.value = formatRupiah(this.value, '');
        });
        var tab2_bunga_pinjaman_lama = document.getElementById('tab2_bunga_pinjaman_lama');
		tab2_bunga_pinjaman_lama.addEventListener('keyup', function(e){
			tab2_bunga_pinjaman_lama.value = formatRupiah(this.value, '');
        });
        var tab2_sisa_pembayaran_bunga_pinjaman = document.getElementById('tab2_sisa_pembayaran_bunga_pinjaman');
		tab2_sisa_pembayaran_bunga_pinjaman.addEventListener('keyup', function(e){
			tab2_sisa_pembayaran_bunga_pinjaman.value = formatRupiah(this.value, '');
        });
        

        

        $('#tab2-save').on("click", function(e) {
            $.ajax({
                url     : baseurl+"doc/tab2/savedata",
                type    : "POST",
                data    : $('#form-header, #tab2-form').serializeArray(),
                beforeSend: function(xhr){
                    $('#tab2-save').prop('disabled',true);
                }, 
                success : function(data){
                    $('#tab2-save').prop('disabled',false);
                    document.getElementById('ztxtAppsMsg').innerHTML = data.notif;	
                    tab2_loadtable($('#txtWfnum').val());
                },
                error   : function(){
                    alert('Opps: Something Error!');
                }
            });
            return false;
        });

        $('#tab2-calculate').on("click", function(e) {
            $.ajax({
                url     : baseurl+"doc/tab2/calculate",
                type    : "POST",
                data    : $('#form-header, #tab2-form').serializeArray(),
                beforeSend: function(xhr){
                    $('#tab2-calculate').prop('disabled',true);
                }, 
                success : function(data){
                    $('#tab2-calculate').prop('disabled',false);
                    $('#tab2_rencana_usulan_pinjaman').val(data.rencana_usulan_pinjaman);
                    $('#tab2_bunga_tahun').val(data.bunga_tahun);
                    $('#tab2_jangka_waktu_pinjam').val(data.jangka_waktu_pinjam);
                    $('#tab2_tenggang_waktu').val(data.tenggang_waktu);
                    $('#tab2_pad').val(data.pad);
                    $('#tab2_dbh').val(data.dbh);
                    $('#tab2_dau').val(data.dau);
                    $('#tab2_belanja_pegawai').val(data.belanja_pegawai);
                    $('#tab2_dbh_dr').val(data.dbh_dr);
                    $('#tab2_angsuran_bunga').val(data.angsuran_bunga);
                    $('#tab2_angsuran_pokok').val(data.angsuran_pokok);
                    $('#tab2_biaya_lain').val(data.biaya_lain);
                    $('#tab2_pembayaran_pokok').val(data.pembayaran_pokok);
                    $('#tab2_sisa_pembayaran_pokok_pinjaman').val(data.sisa_pembayaran_pokok_pinjaman);
                    $('#tab2_bunga_pinjaman_lama').val(data.bunga_pinjaman_lama);
                    $('#tab2_sisa_pembayaran_bunga_pinjaman').val(data.sisa_pembayaran_bunga_pinjaman);
                },
                error   : function(){
                    alert('Opps: Something Error!');
                }
            });
            return false;
        });
  
</script>

