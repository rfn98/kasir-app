<section class="content">
	<div class="container-fluid">
		<div class="block-header">
			<h2>TRANSAKSI</h2>
		</div>
		<div class="row clearfix">
			<div class="col-md-12">
				<div class="card">
					<div class="header">
						<div class="pull-left row">
							<div class="col-md-1">
								<i class="fa fa-fw fa-shopping-cart"></i>
							</div>
							<div class="col-md-5">
								<span>Data Transaksi</span>
							</div>
							<div class="col-md-6" style="margin-top: -2%;">
								<input class="form-control date-transaksi" type="date" onchange="initTable()">
							</div>
						</div>
						<div class="clearfix"></div>
					</div>
					<div class="body">
						<table class="table table-bordered table-hovered table-transaksi" width="100%">
							<thead>
								<tr>
									<th>idtransaksi</th>
									<th>Total</th>
									<th>Bayar</th>
									<th>Kembalian</th>
									<th>Tanggal Transaksi</th>
									<th>Status</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody></tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>