<script type="text/javascript">
	const initTable = obj => {
		if (obj.filter) $('.table-pesanan').DataTable().destroy()
		const date = '25-02-2019'
		let tablePesanan = $(".table-pesanan").DataTable({
			processing : true,
			serverSide : true,
			ajax : obj.filter ? 'http://localhost/kasir/admin/load_handle/touch/filter_pesanan?date=' + date : '<?php echo base_url("admin/load_handle/touch/pesanan") ?>',	
			columnDefs : [
				{targets : [0], visible : false},
				{targets : "_all", visible : true}
			]
		})


		tablePesanan.on("click", "a", function() {
			let action = $(this).attr("data-action");
			let id = $(this).attr("id");

			console.log(id)

			let hapusData = () => {
				let confirm = window.confirm("Hapus pesanan ini ?");
				if(confirm) {
					$.ajax({
						url : '<?php echo base_url("admin/delete_handle/touch/pesanan") ?>',
						data : {idpesanan : id},
						type : "POST",
						beforeSend : function() {
							notif("Mohon tunggu sebentar...");
						},
						success : function(data) {
							data = JSON.parse(data);

							tablePesanan.ajax.reload();

							if(data.status == "ok") notif(data.msg);
							else alert(data);
						}
					})
				}
			}

			switch(action) {
				case "hapusData" :
					return hapusData();
					break;
			}
		})

	}

	initTable({filter: false})

	const printPdf = async () => {
	    const borderLess = [false, false, false, false]
	    const list = await $.ajax({
			url : "<?php echo base_url("admin/load_handle/touch/pesanan") ?>",
			type : "POST",
			dataType: 'JSON'
		})
		console.log(list.data)
	    const content = [
	      {text: 'DATA PESANAN RESTORAN', style: {alignment: 'center', bold: true, fontSize: 20}, margin: [0,0,0,8]}
	    ]
	    const body = [
	    [/*{text: 'No', style: {bold:true} },*/
	      {text: 'Nama Pelanggan', style: {bold:true} },
	      {text: 'Nama Menu', style: {bold:true} },
	      {text: 'Qty', style: {bold:true} },
	      {text: 'Total (Rp)', style: {bold:true} }]
	    ]
	    for (const idx in list.data) body.push([ 
	      {text:list.data[idx][2]},
	      {text:list.data[idx][3]},
	      {text:list.data[idx][4]},
	      {text:list.data[idx][5]},
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
	    pdfMake.createPdf(docDefinition).download('laporan-data-pesanan' + '.pdf');
	}
</script>