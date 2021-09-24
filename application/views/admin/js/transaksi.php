<div class="modal fade" id="bayar-transaksi">
	<div class="modal-dialog modal-sm">
		<form>
			<div class="modal-content">
				<div class="modal-body">
					<input type="hidden" name="idtransaksi">
					<div class="form-group">
						<div class="form-line">
							<label>Jumlah bayar</label>
							<input type="text" name="bayar" class="form-control" id="numberFormat" required="" autofocus="">
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<div class="pull-left">
						<div class="loading-container"></div>
					</div>
					<div class="pull-right">
						<button class="btn btn-primary btn-sm waves-effect" type="submit">Bayar</button>
						<button class="btn btn-default btn-sm waves-effect" data-dismiss="modal">Batal</button>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
		</form>
	</div>
</div>
<script type="text/javascript">
	let tableTransaksi = $(".table-transaksi").DataTable({
		serverSide : true,
		processing : true,
		ajax : {
			"url" : "<?php echo base_url('admin/load_handle/touch/transaksi') ?>"
		},
		languange : {
			"emptyTable" : "Table tidak tersedia",
			"zeroRecords" : "Record data tidak di temukan"
		}
	})

	tableTransaksi.on("click", "a", function() {
		let action = $(this).attr("data-action");
		let id = $(this).attr("id");

		let bayarTransaksi = () => {
			let parent = $("#bayar-transaksi");
			let form = parent.find($("form"));
			
			form.find($("[name='idtransaksi']")).val(id);
			parent.modal("show");

			form.submit(function(e) {
				e.preventDefault();

				$.ajax({
					url : "<?php echo base_url('admin/update_handle/touch/transaksi') ?>",
					data : form.serialize(),
					type : "POST",
					beforeSend : function() {
						parent.find($(".loading-container")).html(loading());
					},
					success : function(data) {
						data = JSON.parse(data);

						parent.modal("hide");

						form.find(":input").val("");

						if(data.status == "ok") notif(data.msg);
						else alert("Terjadi kesalahan");

						parent.find($(".loading-container")).html("");	
					}
				})
			})

		}

		switch(action) {
			case "bayar" :
				bayarTransaksi();
				break;
			case "print-struk":
				printStruk(id)
				break
		}
	})

	var printStruk = async id_transaksi => {
		const borderLess = [false, false, false, false]
	    const data = await $.ajax({
			url: "<?php echo base_url('admin/load_handle/touch/get_pesanan_by_transaksi') ?>",
			type: "POST",
			data: {kodepesanan: id_transaksi},
			dataType: "JSON"
		})
		console.log(data)
	    const content = [
	      {text: 'STRUK BELANJA', style: {alignment: 'center', bold: true, fontSize: 20}, margin: [0,0,0,8]}
	    ]
	    const body = [
	    [/*{text: 'No', style: {bold:true} },*/
	      {text: 'Nama Menu', style: {bold:true} },
	      {text: 'Harga (Rp)', style: {bold:true} },
	      {text: 'Qty', style: {bold:true} },
	      {text: 'Total', style: {bold:true} }]
	    ]
	    for (const idx in data) body.push([ 
	      {text:data[idx].menu_idmenu},
	      {text:data[idx].menu_idmenu},
	      {text:data[idx].jumlah},
	      {text:data[idx].jumlah}
	    ])
	    content.push({
	      table: {
	        widths: ['*', '*', '*', '*'],
	        body: body
	      },
	      // margin: [100,0,0,8]
	      // style: {alignment: 'center'}
	    })
	    const docDefinition = {
	      pageSize: 'A4',
	      pageOrientation: 'potrait',
	      content: content
	    };
	    pdfMake.createPdf(docDefinition).download('laporan-data-menu' + '.pdf');
	}
</script>