<div class="col-xs-12 col-sm-offset-3 col-sm-8 col-lg-6">
	<div class="box box-primary">
         <div class="box-header with-border">
              <h3 class="box-title">Identifikasi Parameter</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
	    <div class="box-body">
<?= form_open('','role = "form" id = "form"')?>
            <div class="form-group">
	          	<label class="control-label">Maksimum Iterasi</label>
                <div><input type="text" autocomplete="off" name="iterasi" onkeypress="return Angka(this)" class="form-control"  placeholder="Maximum Iterasi"></div>
	        </div>
            <div class="form-group">
	            <label  class="control-label">Error Terkecil</label>
	            <div><input type="text" autocomplete="off" onkeypress="return err(this)" class="form-control" name="error" placeholder="Error Terkecil"></div>
	        </div>
            <div class="box-footer">
                <button type="submit" id="simpan" class="btn btn-info btn-block">Hitung</button>
            </div>
<?=form_close()?>
	    </div>
         <div class="tambah">
            <i class="loading fa"></i>
        </div>
    </div>
</div>

<!-- <?php $a = $this->db->query("SELECT id FROM mpu WHERE c = 'C1' ")->num_rows();
      $b = $this->db->query("SELECT id FROM mpu WHERE c = 'C2' ")->num_rows();
      $c = $this->db->query("SELECT id FROM mpu WHERE c = 'C3' ")->num_rows();
 ?>
Cluster 1 <?=$a?> <br>
Cluster 2 <?=$b?> <br>
Cluster 3 <?=$c?> -->

<?php 

$quer = $this->db->query("SELECT id FROM hpc")->row_array();

$cek = (empty($quer) ? 'hidden' : '');

?>

<div class="tampil <?=$cek?>">
    <div class="col-xs-6">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Hasil Cluster</h3>
                <div class="box-tools pull-right">
                    <a href="<?=base_url().'Excel_export/export'?>" class="btn btn-info btn-sm">Export Excel</a>
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                </div>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table id="list-cluster" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Kode Nama</th>
                                <th>Hasil Cluster</th>
                            </tr>
                        </thead>
                        <tbody>
                              
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-6">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Fungsi Objektif dan Nilai Error</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                </div>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table id="list-error" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Iterasi</th>
                                <th>Fungsi Objektif</th>
                                <th>Error</th>
                            </tr>
                        </thead>
                        <tbody>
                              
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="tampil <?=$cek?>">
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Rincian Hasil Akhir Perhitungan FCM</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                </div>
            </div>
            <div class="box-body">
    <?php for($t=1;$t<4;$t++) { ?>
              	<div class="table-responsive">    	
    		        <table id="list-satu<?=$t?>" class="table table-bordered table-hover">
    		            <thead>
    			            <tr><th bgcolor="green" style="color:white;text-align: center;" colspan="13">Perhitungan Pusat Cluster <?=$t?></th></tr>
    			            <tr>
    			            	<th style="text-align: center; font-size: 12px; width: 100px; " rowspan="2">Derajat Keanggotaan C ke-<?=$t?></th>
    			                <th style="text-align: center;font-size: 12px;" colspan="6">Data yang di Cluster</th>
    			               	<th rowspan="2">(U<sub>i<?=$t?></sub>)<sup>2</sup></th>
                                <th rowspan="2" >(U<sub>i<?=$t?></sub>)<sup>2</sup> * X<sub>1</sub></th>
                                <th rowspan="2" >(U<sub>i<?=$t?></sub>)<sup>2</sup> * X<sub>2</sub></th>
    			                <th rowspan="2" >(U<sub>i<?=$t?></sub>)<sup>2</sup> * X<sub>3</sub></th>
    			                <th rowspan="2" >(U<sub>i<?=$t?></sub>)<sup>2</sup> * X<sub>4</sub></th>
    			                <th rowspan="2" >(U<sub>i<?=$t?></sub>)<sup>2</sup> * X<sub>5</sub></th>
    			            </tr>
    			            <tr>
                                <th>Kode Nama</th>
     							<th>X<sub>1</sub></th>
    			                <th>X<sub>2</sub></th>
    			                <th>X<sub>3</sub></th>
    			                <th>X<sub>4</sub></th>
    			                <th>X<sub>5</sub></th>
    			                <!-- <th class="hidden" style="border-style: 2px;">X<sub>i5</sub></th> -->
    			            </tr>
    		            </thead>
    		            <tbody>
    		              
    		            </tbody>
    		        </table>
    	     	</div>
                <hr>
    <?php } ?>
                <!-- Hasil Pusat Cluster -->
                <div class="table-responsive">
                    <table id="list-tiga" class="table table-bordered table-hover">
                        <thead>
                            <tr><th bgcolor="green" style="color:white;text-align: center;" colspan="6">Hasil Pusat Cluster</th></tr>
                            <th>Cluster</th>
                            <th>V<sub>1</sub></th>
                            <th>V<sub>2</sub></th>
                            <th>V<sub>3</sub></th>
                            <th>V<sub>4</sub></th>
                            <th>V<sub>5</sub></th>
                        </thead>
                        <tbody>
                              
                        </tbody>
                    </table>
                </div>

                <hr>

                <div class="table-responsive">
                    <table id="list-dua" class="table table-bordered table-hover">
                        <thead>
                            <tr><th bgcolor="green" style="color:white;text-align: center;" colspan="5">Perhitungan Fungsi Objektif</th></tr>
                            <tr>
                                <th>Kode Nama</th>
                                <th>L<sub>1</sub></th>
                                <th>L<sub>2</sub></th>
                                <th>L<sub>3</sub></th>
                                <th>L<sub>T</sub></th>
                            </tr>
                        </thead>
                        <tbody>
                              
                        </tbody>
                    </table>
                </div>

                <hr>

                <div class="table-responsive">
                    <table id="list-empat" class="table table-bordered table-hover">
                        <thead>
                            <tr><th bgcolor="green" style="color:white;text-align: center;" colspan="8">Perhitungan Matriks Partisi U</th></tr>
                            <tr>
                                <th>Kode Nama</th>
                                <th>L<sub>1</sub></th>
                                <th>L<sub>2</sub></th>
                                <th>L<sub>3</sub></th>
                                <th>L<sub>T</sub></th>
                                <th>U<sub>i1</sub></th>
                                <th>U<sub>i2</sub></th>
                                <th>U<sub>i3</sub></th>
                            </tr>
                        </thead>
                        <tbody>
                              
                        </tbody>
                    </table>
                </div>

            </div>	
  	    </div>
    </div>
</div>


<script type="text/javascript">

	var label;
	var table;

	$(document).ready(function(){
		$.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings){
            return {
                "iStart": oSettings._iDisplayStart,
                "iEnd": oSettings.fnDisplayEnd(),
                "iLength": oSettings._iDisplayLength,
                "iTotal": oSettings.fnRecordsTotal(),
                "iFilteredTotal": oSettings.fnRecordsDisplay(),
                "iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
                "iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
            };
        }

    for($y=1;$y<4;$y++){

       table =  $("#list-satu"+$y).DataTable({
            initComplete: function() {
                var api = this.api();
                $('#baran input')
                    .off('.DT')
                    .on('keyup.DT', function(e) {
                        api.search(this.value).draw();
                    });
            },
            oLanguage: {
                sSearch       :"<i class='fa fa-search fa-fw'></i> Cari: ",
                sLengthMenu   :"Tampilkan _MENU_ data",
                sInfo         :"Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                sInfoFiltered :"(disaring dari _MAX_ total data)", 
                sZeroRecords  :"Oops..data kosong", 
                sEmptyTable   :"Data kosong.", 
                sInfoEmpty    :"Menampilkan 0 sampai 0 data",
                sProcessing   :'<p style="color:green"><i class="fa fa-cog fa-spin fa-4x fa-fw"></i></p> <span class="sr-only"></span>', 
                oPaginate: {
                    sPrevious :"Sebelumnya",
                    sNext     :"Selanjutnya",
                    sFirst    :"Pertama",
                    sLast     :"Terakhir"
                }
            },
            processing: true,
            serverSide: true,
            ajax: {
                "url": "<?= base_url().$this->uri->segment(1).'/getData/'?>"+$y,
                "type": "POST"
            },
            columns: [
                {"data": "u"+$y,render:$.fn.dataTable.render.number(',','.',6)},
                {"data": "idSet"},
                {"data": "x1"},
                {"data": "x2"},
                {"data": "x3"},
                {"data": "x4"},
				{"data": "x5"},
                {"data": "U"+$y,render:$.fn.dataTable.render.number(',','.',6)},
                {"data": "ux1",render:$.fn.dataTable.render.number(',','.',6)},
                {"data": "ux2",render:$.fn.dataTable.render.number(',','.',6)},
                {"data": "ux3",render:$.fn.dataTable.render.number(',','.',6)},
                {"data": "ux4",render:$.fn.dataTable.render.number(',','.',6)},
                {"data": "ux5",render:$.fn.dataTable.render.number(',','.',6)},
            ],
            order: [[1, 'asc']],
            rowId: function(a){
                return a;
            }
        });
    }

     table =  $("#list-dua").DataTable({
            initComplete: function() {
                var api = this.api();
                $('#baran input')
                    .off('.DT')
                    .on('keyup.DT', function(e) {
                        api.search(this.value).draw();
                    });
            },
            oLanguage: {
                sSearch       :"<i class='fa fa-search fa-fw'></i> Cari: ",
                sLengthMenu   :"Tampilkan _MENU_ data",
                sInfo         :"Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                sInfoFiltered :"(disaring dari _MAX_ total data)", 
                sZeroRecords  :"Oops..data kosong", 
                sEmptyTable   :"Data kosong.", 
                sInfoEmpty    :"Menampilkan 0 sampai 0 data",
                sProcessing   :"Sedang memproses...", 
                oPaginate: {
                    sPrevious :"Sebelumnya",
                    sNext     :"Selanjutnya",
                    sFirst    :"Pertama",
                    sLast     :"Terakhir"
                }
            },
            processing: true,
            serverSide: true,
            ajax: {
                "url": "<?= base_url().$this->uri->segment(1).'/getFungsi'?>",
                "type": "POST"
            },
            columns: [
                {"data":"idSet"},
                {"data": "L1",render:$.fn.dataTable.render.number(',','.',6)},
                {"data": "L2",render:$.fn.dataTable.render.number(',','.',6)},
                {"data": "L3",render:$.fn.dataTable.render.number(',','.',6)},
                {"data": "LT",render:$.fn.dataTable.render.number(',','.',6)},
            ],
            order: [[0, 'asc']],
            rowId: function(a){
                return a;
            }
     });


    table =  $("#list-tiga").DataTable({
            initComplete: function() {
                var api = this.api();
                $('#baran input')
                    .off('.DT')
                    .on('keyup.DT', function(e) {
                        api.search(this.value).draw();
                    });
            },
            oLanguage: {
                sSearch       :"<i class='fa fa-search fa-fw'></i> Cari: ",
                sLengthMenu   :"Tampilkan _MENU_ data",
                sInfo         :"Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                sInfoFiltered :"(disaring dari _MAX_ total data)", 
                sZeroRecords  :"Oops..data kosong", 
                sEmptyTable   :"Data kosong.", 
                sInfoEmpty    :"Menampilkan 0 sampai 0 data",
                sProcessing   :"Sedang memproses...", 
                oPaginate: {
                    sPrevious :"Sebelumnya",
                    sNext     :"Selanjutnya",
                    sFirst    :"Pertama",
                    sLast     :"Terakhir"
                }
            },
            processing: true,
            serverSide: true,
            ajax: {
                "url": "<?= base_url().$this->uri->segment(1).'/getPusatCluster'?>",
                "type": "POST"
            },
            columns: [
                {"data": "c"},
                {"data": "v1",render:$.fn.dataTable.render.number(',','.',6)},
                {"data": "v2",render:$.fn.dataTable.render.number(',','.',6)},
                {"data": "v3",render:$.fn.dataTable.render.number(',','.',6)},
                {"data": "v4",render:$.fn.dataTable.render.number(',','.',6)},
                {"data": "v5",render:$.fn.dataTable.render.number(',','.',6)},
            ],
            order: [[0, 'asc']],
            rowId: function(a){
                return a;
            }
     });

    table =  $("#list-empat").DataTable({
            initComplete: function() {
                var api = this.api();
                $('#baran input')
                    .off('.DT')
                    .on('keyup.DT', function(e) {
                        api.search(this.value).draw();
                    });
            },
            oLanguage: {
                sSearch       :"<i class='fa fa-search fa-fw'></i> Cari: ",
                sLengthMenu   :"Tampilkan _MENU_ data",
                sInfo         :"Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                sInfoFiltered :"(disaring dari _MAX_ total data)", 
                sZeroRecords  :"Oops..data kosong", 
                sEmptyTable   :"Data kosong.", 
                sInfoEmpty    :"Menampilkan 0 sampai 0 data",
                sProcessing   :"Sedang memproses...", 
                oPaginate: {
                    sPrevious :"Sebelumnya",
                    sNext     :"Selanjutnya",
                    sFirst    :"Pertama",
                    sLast     :"Terakhir"
                }
            },
            processing: true,
            serverSide: true,
            ajax: {
                "url": "<?= base_url().$this->uri->segment(1).'/getMatriks'?>",
                "type": "POST"
            },
            columns: [
                {"data":"idSet"},
                {"data": "L1",render:$.fn.dataTable.render.number(',','.',6)},
                {"data": "L2",render:$.fn.dataTable.render.number(',','.',6)},
                {"data": "L3",render:$.fn.dataTable.render.number(',','.',6)},
                {"data": "LT",render:$.fn.dataTable.render.number(',','.',6)},
                {"data": "ui1",render:$.fn.dataTable.render.number(',','.',6)},
                {"data": "ui2",render:$.fn.dataTable.render.number(',','.',6)},
                {"data": "ui3",render:$.fn.dataTable.render.number(',','.',6)},
            ],
            order: [[0, 'asc']],
            rowId: function(a){
                return a;
            }
     });

    table =  $("#list-cluster").DataTable({
            initComplete: function() {
                var api = this.api();
                $('#baran input')
                    .off('.DT')
                    .on('keyup.DT', function(e) {
                        api.search(this.value).draw();
                    });
            },
            oLanguage: {
                sSearch       :"<i class='fa fa-search fa-fw'></i> Cari: ",
                sLengthMenu   :"Tampilkan _MENU_ data",
                sInfo         :"Tampil _START_ sampai _END_ dari _TOTAL_ data",
                sInfoFiltered :"(disaring dari _MAX_ total data)", 
                sZeroRecords  :"Oops..data kosong", 
                sEmptyTable   :"Data kosong.", 
                sInfoEmpty    :"Tampil 0 sampai 0 data",
                sProcessing   :"Sedang memproses...", 
                oPaginate: {
                    sPrevious :"Sebelumnya",
                    sNext     :"Selanjutnya",
                    sFirst    :"Pertama",
                    sLast     :"Terakhir"
                }
            },
            processing: true,
            serverSide: true,
            ajax: {
                "url": "<?= base_url().$this->uri->segment(1).'/getHasil'?>",
                "type": "POST"
            },
            columns: [
                {"data":"idSet"},
                {"data": "c"},
            ],
            order: [[0, 'asc']],
            rowId: function(a){
                return a;
            }
     });

    table =  $("#list-error").DataTable({
            initComplete: function() {
                var api = this.api();
                $('#baran input')
                    .off('.DT')
                    .on('keyup.DT', function(e) {
                        api.search(this.value).draw();
                    });
            },
            oLanguage: {
                sSearch       :"<i class='fa fa-search fa-fw'></i> Cari: ",
                sLengthMenu   :"Tampilkan _MENU_ data",
                sInfo         :"Tampil _START_ sampai _END_ dari _TOTAL_ data",
                sInfoFiltered :"(disaring dari _MAX_ total data)", 
                sZeroRecords  :"Oops..data kosong", 
                sEmptyTable   :"Data kosong.", 
                sInfoEmpty    :"Tampil 0 sampai 0 data",
                sProcessing   :"Sedang memproses...", 
                oPaginate: {
                    sPrevious :"Sebelumnya",
                    sNext     :"Selanjutnya",
                    sFirst    :"Pertama",
                    sLast     :"Terakhir"
                }
            },
            processing: true,
            serverSide: true,
            ajax: {
                "url": "<?= base_url().$this->uri->segment(1).'/getRekapitulasi'?>",
                "type": "POST"
            },
            columns: [
                {"data":"id"},
                {"data": "fungsi",render:$.fn.dataTable.render.number('.',',',6)},
                {"data": "error",render:$.fn.dataTable.render.number('.',',',6)},
            ],
            order: [[0, 'asc']],
            rowId: function(a){
                return a;
            }
     });


    $('#form').validate({
            errorElement: 'div',
            errorClass: 'help-block',
            focusInvalid: false,
            ignore: "",
            rules:{
                iterasi:{
                    required:true,
                    maxlength:2
                },
                error:{
                    required:true,
                    maxlength:8
                },
            },
            messages: {
                iterasi: {
                    required:"Hatinya aja yang kosong, Maksimum iterasi jangan :D.",
                    maxlength:"Maksimum 99 iterasi ya Bang ;)."
                },
                error: {
                    required:"Minimum error nya oi jangan Lupa.",
                    maxlength:"Minimum error terlalu berat sistem gak akan kuat :("
                },
            },
            highlight: function (e) {
                $(e).closest('.form-group').removeClass('has-info').addClass('has-error');
            },
            success: function (e) {
                $(e).closest('.form-group').removeClass('has-error');//.addClass('has-info');
                $(e).remove();
            },
            errorPlacement: function (error, element) {
                if(element.is('input[type=radio]')) {
                    var controls = element.closest('div[class*="ra"]');
                    if(controls.find(':radio').length > 0) controls.append(error);
                    else error.insertAfter(element.nextAll('.lbl:eq(0)').eq(0));
                }
                else if(element.is('.select2')) {
                    error.insertAfter(element.siblings('[class*="select2-container"]:eq(0)'));
                }
                else error.insertAfter(element.parent());
            },
            submitHandler: function (form) {
                $('#simpan').text('Proses penghitungan...');
                $('.tambah').addClass('overlay');
                $('.loading').addClass('fa-refresh');
                $('.loading').addClass('fa-spin');
                $('.tampil').addClass('hidden');
                var url,method;
                var isi = $('#form').serialize();
                $.ajax({
                    url: "<?=base_url($this->uri->segment(1).'/hitung')?>",
                    type:"POST",
                    data: isi,
                    dataType:"JSON",
                    success:function(data){
                        $('#form')[0].reset();
                        window.location.href="<?=base_url($this->uri->segment(1))?>";
                        sweet('Perhitungan Selesai ','Berhasil Mengcluster Data','success');
                        $('.tampil').removeClass('hidden');
                        $('.tambah').removeClass('overlay');
                        $('.loading').removeClass('fa-refresh');
                        $('.loading').removeClass('fa-spin');
                        $('.pesan').removeClass('hidden');
                        $('#simpan').text('Hitung');
                    },
                    error: function (jqXHR, textStatus, errorThrown){
                        sweet('Oops...','Data Gagal di Cluster','error');
                        console.log(jqXHR, textStatus, errorThrown);
                    }
                });
            },
            invalidHandler: function (form) {}
        });

	});

    function sweet(judul,text,tipe){
        Swal({
            title: judul,
            text: text,
            type: tipe
        });
    }

    function reload(){
        table.ajax.reload(null,false);
    }
</script>