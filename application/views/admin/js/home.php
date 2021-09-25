<script type="text/javascript">
	var dataPelanggan = $(".loadPelangganData").DataTable({
		"language" : {
			emptyTable : "Data saat ini tidak tersedia !",
			zeroRecords : "Data yang ada cari tidak tersedia !"
		},
		"processing" : true,
		"serverside" : true,
		"order" : [],
		"ajax" : {
			"url" : "<?php echo base_url($this->uri->segment(1)."/init/touch/load_data_pelanggan") ?>",
			"type" : "POST"
		},
		"columnDefs" : [
			{ targets: [1, 2, 3, 4, 5], visible: true},
	        { targets: '_all', visible: false }
		]
	})

	dataPelanggan.on("click", "a", function() {
		let action = $(this).attr("data-action");
		let loadingContainer = $(action).find($(".loading-container"));
		let postData = {
			id : $(this).attr("id"),
			type : "get_where",
			start : 0,
			per_page  : 1
		}

		switch(action) {
			case "#edit-pelanggan" :
					// load data pelanggan yang akan di update
					$.ajax({
						url : "<?php echo base_url($this->uri->segment(1).'/init/touch/get_pelanggan') ?>",
						type : "POST",
						data : postData,
						beforeSend : function() {
							loadingContainer.html(loading());
							$(action).modal("show");
						},
						success : function(data) {
							let dataset = JSON.parse(data);

							let elIdPelanggan = $(action).find($("form")).find($("input[name='idpelanggan']"));
							let elNamaPelanggan = $(action).find($("form")).find($("input[name='namapelanggan']"));
							let elNoHp = $(action).find($("form")).find($("input[name='nohp']"));
							let elAlamat = $(action).find($("form")).find($("textarea[name='alamat']")); 

							elIdPelanggan.val(dataset[0].idpelanggan);
							elNamaPelanggan.val(dataset[0].namapelanggan);
							elNoHp.val(Number(dataset[0].nohp));
							elAlamat.val(dataset[0].alamat);

							// set indicator value for alamat
							let elAlamatParents = elAlamat.closest($(".form-line"));
							let alamatMaxLength = elAlamatParents.attr("data-limit");
							let indicator = elAlamatParents.find($(".limit-indicator"));

							indicator.text(dataset[0].alamat.length+" / "+alamatMaxLength);

						},
						complete : function() {
							loadingContainer.html("");
						}
					})

					// ketika form di submit
					$(action).find($("form")).submit(function(e) {
						e.preventDefault();

						$.ajax({
							url : "<?php echo base_url($this->uri->segment(1).'/init/touch/update_pelanggan') ?>",
							type : "POST",
							data : $(this).serialize(),
							beforeSend :  function() {
								loadingContainer.html(loading());
							},
							success : function(data) {
								dataPelanggan.ajax.reload(null, false);
								(JSON.parse(data).status != "ok") ? alert(data) : true;
							},
							complete : function() {
								if($(action).modal("hide")) {
									notif("Data pelanggan berhasil di update");
								}
							}
						})
					})
				break;
			case "#hapus-pelanggan" :
					let msg = window.confirm("Hapus pelanggan ini ?");
					if(msg) {
						$.ajax({
							url : "<?php echo base_url($this->uri->segment(1)."/init/touch/hapus_pelanggan") ?>",
							data : {idpelanggan : $(this).attr("id")},
							type : "POST",
							success : function(data) {
								dataPelanggan.ajax.reload(null, false);
								(JSON.parse(data).status != "ok") ? alert(data) : notif("Pelanggan telah di hapus");
							}
						})
					}
				break;
		}
	})

	const printPdf = async () => {
	    const borderLess = [false, false, false, false]
	    const list = await $.ajax({
			url : "<?php echo base_url($this->uri->segment(1)."/init/touch/load_data_pelanggan") ?>",
			type : "POST",
			dataType: 'JSON'
		})
		console.log(list.data)
	    const content = [
	      {text: 'DATA PELANGGAN RESTORAN', style: {alignment: 'center', bold: true, fontSize: 20}, margin: [0,0,0,8]}
	    ]
	    const body = [
	    [/*{text: 'No', style: {bold:true} },*/
	      {text: 'Nama', style: {bold:true} },
	      {text: 'Jenis Kelamin', style: {bold:true} },
	      {text: 'Handphone', style: {bold:true} }]
	    ]
	    for (const idx in list.data) body.push([ 
	      {text:list.data[idx][1]},
	      {text:list.data[idx][2]},
	      {text:list.data[idx][3]}
	    ])
	    content.push({
	      table: {
	        widths: ['*', '*', '*'],
	        body: body
	      },
	      // margin: [50,0,0,8]
	      // style: {alignment: 'center'}
	    })
	    const docDefinition = {
	      pageSize: 'A4',
	      pageOrientation: 'potrait',
	      content: content
	    };
	    pdfMake.createPdf(docDefinition).download('laporan-data-pelanggan' + '.pdf');
	}
</script>