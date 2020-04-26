<div class="col-xs-12">
	<div class="box box-primary">
        <div class="box-header">
         	<div class="pull-right">
         		<div class="btn-group">
	                <a href="<?=base_url('excel/format.xlsx')?>" class="btn btn-primary"><i class="fa fa-file-excel-o"></i> Format Tabel</a>
	                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
	                    <span class="caret"></span>
	                    <span class="sr-only">Toggle Dropdown</span>
	                </button>
	                <ul class="dropdown-menu" role="menu">
	                    <li><a href="#" onclick="Import()" >Import Data</a></li>
	                    <li><a href="#" onclick="Tambah()" >Tambah Data</a></li>
	                    <li class="divider"></li>
	                    <li><a href="#" onclick="Truncate()">Hapus Semua Data</a></li>
	                </ul>
            	</div>
         	</div>
        </div>
	    <div class="box-body">
	    	<div class="table-responsive">    	
		        <table id="list-satu" class="table table-bordered table-hover">
		            <thead>
			            <tr>
			                <th>No</th>
			                <th>Kode Nama</th>
			                <th>X<sub>1</sub></th>
			                <th>X<sub>2</sub></th>
			                <th>X<sub>3</sub></th>
			                <th>X<sub>4</sub></th>
			                <th>X<sub>5</sub></th>
			               <!--  <th width="100">Aksi</th> -->
			            </tr>
		            </thead>
		            <tbody>
		              
		            </tbody>
		            <tfoot>
			            <tr>
			                <th>No</th>
			                <th>Kode Nama</th>
			                <th>X<sub>1</sub></th>
			                <th>X<sub>2</sub></th>
			                <th>X<sub>3</sub></th>
			                <th>X<sub>4</sub></th>
			                <th>X<sub>5</sub></th>
			              <!--   <th width="100">Aksi</th> -->
			            </tr>
		            </tfoot>
		        </table>
	       	</div>
	    </div>
    </div>
</div>

<div class="modal fade" id="modal-import">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title"></h4>
            </div>
<?= form_open('','role = "form" id = "form-import"')?>
            <div class="modal-body">
            	<div class="form-group">
            		<label class="control-label"> File</label>
            		<input type="file" required="" accept=".xlsx" name="file">
            	</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                <button type="submit" id="import" class="btn btn-primary">Import</button>
            </div>
<?= form_close()?>
        </div>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modal-form">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title"></h4>
            </div>
<?= form_open('','role = "form" id = "form"')?>
            <div class="modal-body">
            	<input type="hidden" name="id" value="">
            	<div class="form-group">
            		<label class="control-label"> Kode Nama</label>
            		<div><input type="text" required="" autocomplete="off" name="nama" class="form-control"></div>
            	</div>
            	<div class="form-group">
            		<label class="control-label">Nilai X<sub>1</sub></label>
            		<div><input type="text" required="" onkeypress="return Angka(this)" placeholder="0" autocomplete="off" name="x1" class="form-control"></div>
            	</div>
				<div class="form-group">
            		<label class="control-label">Nilai X<sub>2</sub></label>
            		<div><input type="text" required="" onkeypress="return Angka(this)" placeholder="0" autocomplete="off" name="x2" class="form-control"></div>
            	</div>
            	<div class="form-group">
            		<label class="control-label">Nilai X<sub>3</sub></label>
            		<div><input type="text" required="" onkeypress="return Angka(this)" placeholder="0" autocomplete="off" name="x3" class="form-control"></div>
            	</div>
				<div class="form-group">
            		<label class="control-label">Nilai X<sub>4</sub></label>
            		<div><input type="text" required="" onkeypress="return Angka(this)" placeholder="0" autocomplete="off" name="x4" class="form-control"></div>
            	</div>
				<div class="form-group">
            		<label class="control-label">Nilai X<sub>5</sub></label>
            		<div><input type="text" required="" onkeypress="return Angka(this)" placeholder="0" autocomplete="off" name="x5" class="form-control"></div>
            	</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                <button type="submit" id="simpan"  class="btn btn-primary">Simpan</button>
            </div>
<?= form_close()?>
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
        };

       table =  $("#list-satu").DataTable({
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
                "url": "<?= base_url().$this->uri->segment(1).'/getData'?>",
                "type": "POST"
            },
            columns: [
                {
                    "data": "id",
                    "orderable": false,
                    "searchable": false
                },
                {"data": "name"},
                {"data": "x1"},
                {"data": "x2"},
                {"data": "x3"},
                {"data": "x4"},
				{"data": "x5"}
            ],
            order: [[1, 'asc']],
            rowId: function(a){
                return a;
            },
            rowCallback: function(row, data, iDisplayIndex) {
                var info = this.fnPagingInfo();
                var page = info.iPage;
                var length = info.iLength;
                var index = page * length + (iDisplayIndex + 1);
                $('td:eq(0)', row).html(index);
            }
        });

       	$('#form-import').on('submit',function(event){

       		event.preventDefault();
       		$('#import').text('Mengimport..');
			$('#import').attr('disabled',true);

			$.ajax({
				url: '<?=base_url($this->uri->segment(1).'/import')?>',
				method:"POST",
				data:new FormData(this),
				cache:false,
				contentType:false,
				processData:false,
				success:function(data){
					console.log(data);
					console.log(data.success);
					$('#modal-import').modal('hide');
					reload();
					sweet('Sukses','Berhasil Import Data','success');
					$('#import').text('Import');
			 		$('#import').attr('disabled',false);
				},
				error: function (jqXHR, textStatus, errorThrown){
                	sweet('Oops...','Data gagal di import','error');
                	console.log(jqXHR, textStatus, errorThrown);
				}
			});
		});

		$('#form').validate({
			errorElement: 'div',
			errorClass: 'help-block',
			focusInvalid: false,
			ignore: "",
			rules:{
				x1:{
					required:true,
					maxlength:1
				},
				x2:{
					required:true,
					maxlength:1
				},
				x3:{
					required:true,
					maxlength:1
				},
				x4:{
					required:true,
					maxlength:1
				},
				x5:{
					required:true,
					maxlength:1
				},
				nama:{
					maxlength:5
				},
			},
			messages: {
				x1: {
					required:"Data tidak boleh kosong.",
					maxlength:"Hanya 1 Karakter."
				},
				x2: {
					required:"Data tidak boleh kosong.",
					maxlength:"Hanya 1 Karakter."
				},
				x3: {
					required:"Data tidak boleh kosong.",
					maxlength:"Hanya 1 Karakter."
				},
				x4: {
					required:"Data tidak boleh kosong.",
					maxlength:"Hanya 1 Karakter."
				},
				x5: {
					required:"Data tidak boleh kosong.",
					maxlength:"Hanya 1 Karakter."
				},
				nama: {
					required:"Data tidak boleh kosong.",
					maxlength:"Maksimal 5 Karakter."
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
				$('#simpan').text('Menyimpan...');
				$('#simpan').attr('disabled',true);
				var url,method;
				if (label == 'simpan'){
				 	url = '<?=base_url($this->uri->segment(1).'/Simpan')?>';
				 	method = 'Tambah';
				}
				else {
				 	url = '<?=base_url($this->uri->segment(1).'/Ubah')?>';
				 	method = 'Ubah';
				}
				var isi = $('#form').serialize();
				$.ajax({
					url: url,
					type:"POST",
					data: isi,
					dataType:"JSON",
					success:function(data){
						console.log(data);
						console.log(data.success);
						$('#modal-form').modal('hide');
						reload();
						sweet('Di '+method,'Berhasil '+method+' Data','success');
						$('#simpan').text('Simpan');
		 				$('#simpan').attr('disabled',false);
					}
				});
			},
			invalidHandler: function (form) {}
		});

	});

	function Tambah(){
		label = 'simpan';
		$('#form')[0].reset();
		$('.form-group').removeClass('has-error');
		$('.help-block').empty(); 
		$('#modal-form').modal('show');
		$('.modal-title').text('Tambah Data');
	}


	function Ubah(id){
		label = 'ubah';
		$('#form')[0].reset();
		$('.form-group').removeClass('has-error');
		$('.help-block').empty();

		$.ajax({
			url: "<?=base_url($this->uri->segment(1).'/edit/')?>"+id,
			type:"GET",
			dataType:"JSON",
			success:function(e){
				$('[name="id"]').val(e.id);
                $('[name="nama"]').val(e.name);
                $('[name="x1"]').val(e.x1);
                $('[name="x2"]').val(e.x2);
                $('[name="x3"]').val(e.x3);
                $('[name="x4"]').val(e.x4);
                $('[name="x5"]').val(e.x5);
                $('#modal-form').modal('show');
                $('.modal-title').text('Ubah Data'); 
			},
            error: function (jqXHR, textStatus, errorThrown){
                sweet('Oops...','Data tidak dapat diambil','error');
                console.log(jqXHR, textStatus, errorThrown);
            }
		});
	}

    function reload(){
        table.ajax.reload(null,false);
    }
	function sweet(judul,text,tipe){
        Swal({
            title: judul,
            text: text,
            type: tipe
        });
    };

	function Import(){
		label = 'import';
		$('#form-import')[0].reset();
		$('#modal-import').modal('show');
		$('.modal-title').text('Import Data');
	}

	function Ubah(id){
		label = 'ubah';
		$('#form')[0].reset();
		$('.form-group').removeClass('has-error');
		$('.help-block').empty();

		$.ajax({
			url: "<?=base_url($this->uri->segment(1).'/edit/')?>"+id,
			type:"GET",
			dataType:"JSON",
			success:function(data){
				$('[name="id"]').val(data.id);
                $('[name="nama"]').val(data.nama);
                $('[name="tanggal"]').datepicker('update',data.tanggal);
                $('[name="gender"]').iCheck('update',data.gender);
                $('[name="agama"]').val(data.agama).trigger('change');
                $('#modal-form').modal('show');
                $('.modal-title').text('Ubah Data'); 
			},
            error: function (jqXHR, textStatus, errorThrown){
                sweet('Oops...','Data tidak dapat diambil','error');
                console.log(jqXHR, textStatus, errorThrown);
            }
		});
	}

	function Hapus(id){
		Swal({
            title: 'Ingin menghapus data?',
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya'
        }).then((result) => {
            if(result.value) {
                $.ajax({
                    url : "<?=base_url($this->uri->segment(1).'/Hapus')?>/"+id,
                    type: "POST",
                    dataType: "JSON",
                    success: function(data){
                        reload();
                        sweet('Dihapus !','Berhasil Hapus Data','success');
                    },
                    error: function (jqXHR, textStatus, errorThrown){
                        sweet('Oops...','Gagal Hapus Data','error');
                        console.log(jqXHR, textStatus, errorThrown);
                    }
                });
            }
        });
	}

	function Truncate(){
		Swal({
            title: 'Ingin Kosongkan data ?',
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya'
        }).then((result) => {
            if(result.value) {
                $.ajax({
                    url : "<?=base_url($this->uri->segment(1).'/Kosong')?>",
                    type: "POST",
                    dataType: "JSON",
                    success: function(data){
                        reload();
                        sweet('Dihapus !','Berhasil Hapus Data','success');
                    },
                    error: function (jqXHR, textStatus, errorThrown){
                        sweet('Oops...','Gagal Hapus Data','error');
                        console.log(jqXHR, textStatus, errorThrown);
                    }
                });
            }
        });

	}
</script>