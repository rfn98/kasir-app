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
	const initTable = () => {
		$('.table-transaksi').DataTable().destroy()
		const date = moment($('.date-transaksi').val()).format('DD-MM-YYYY')
		let tableTransaksi = $(".table-transaksi").DataTable({
			serverSide : true,
			processing : true,
			ajax : {
				"url" : 'http://localhost/kasir/admin/load_handle/touch/filter_transaksi?date=' + date
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
							location.reload()
							/*tableTransaksi.destroy()
							$(".table-transaksi").DataTable({
								serverSide : true,
								processing : true,
								ajax : {
									"url" : "<?php echo base_url('admin/load_handle/touch/transaksi') ?>"
								},
								languange : {
									"emptyTable" : "Table tidak tersedia",
									"zeroRecords" : "Record data tidak di temukan"
								}
							})*/
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
	}
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
						location.reload()
						/*tableTransaksi.destroy()
						$(".table-transaksi").DataTable({
							serverSide : true,
							processing : true,
							ajax : {
								"url" : "<?php echo base_url('admin/load_handle/touch/transaksi') ?>"
							},
							languange : {
								"emptyTable" : "Table tidak tersedia",
								"zeroRecords" : "Record data tidak di temukan"
							}
						})*/
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
		let total_bayar = 0
	    const data = await $.ajax({
			url: "<?php echo base_url('admin/load_handle/touch/get_pesanan_by_transaksi') ?>",
			type: "POST",
			data: {kodepesanan: id_transaksi},
			dataType: "JSON"
		})
		console.log(data)
	    const content = [
	      {text: 'STRUK BELANJA', style: {alignment: 'center', bold: true, fontSize: 20}, margin: [0,0,0,20]}
	    ]
	    const body = [
	    [/*{text: 'No', style: {bold:true} },*/
	      {text: 'Nama Menu', style: {bold:true}, border: [false, false, false, true]},
	      {text: 'Harga (Rp)', style: {bold:true}, border: [false, false, false, true] },
	      {text: 'Qty', style: {bold:true}, border: [false, false, false, true] },
	      {text: 'Total', style: {bold:true}, border: [false, false, false, true] }]
	    ]
	    for (const idx in data) {
	    	body.push([ 
		      {text:data[idx].namamenu, border: borderLess},
		      {text:data[idx].harga, border: borderLess},
		      {text:data[idx].jumlah, border: borderLess},
		      {text:eval(data[idx].harga)*eval(data[idx].jumlah), border: borderLess}
		    ])
		    total_bayar = total_bayar + (eval(data[idx].harga)*eval(data[idx].jumlah))
	    }
	    body.push([
	    	{text:'Total Bayar', style: {alignment:'right', bold: true}, colSpan:3, border: [false, true, false, false]},
	    	{},
	    	{},
	    	{text:total_bayar, border: [false, true, false, false]}
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
	      pageSize: {
		    width: 400,
		    height: 'auto'
		  },
	      pageOrientation: 'potrait',
	      content: content
	    };
	    pdfMake.createPdf(docDefinition).open();
	    // pdfMake.createPdf(docDefinition).download('laporan-data-menu' + '.pdf');
	}
</script>