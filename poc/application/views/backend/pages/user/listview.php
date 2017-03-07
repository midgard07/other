<!DOCTYPE html>
<html lang="id">
<head>
	<?php $this->load->view('backend/elements/basic_head') ?>
</head>

<body>
	<div id="wrap">
		<?php $this->load->view('backend/components/header') ?>

		<div class="container">
			
			<h1>User</h1>
			
			<div class="row ct-listview-toolbar">
				<div class="col-md-6">
					<?php $this->load->view('backend/components/searchform') ?>
				</div>
				<div class="col-md-6">
					<div class="pull-right">
						<a href="<?php echo site_url('user/add') ?>" class="btn btn-primary">User Baru</a>
					</div>
				</div>
			</div>
			
			<?php $this->load->view('backend/components/message_handler') ?>
			
			<div class="table-responsive">
				<table class="table table-striped table-condensed">
					<thead>
						<tr>
							<th><?php echo gridHeader('username', 'Username', $cfg) ?></th>
							<th><?php echo gridHeader('nama', 'Nama Lengkap', $cfg) ?></th>
						</tr>
					</thead>
					<tbody>
						<?php
						$grid_state = $cfg->pagingURL.'/p:'.$cfg->currPage;
						
						if($datasource){
							foreach($datasource as $row){
						?>
						<tr>
							<td><?php echo $row->username ?></td>
							<td><?php echo $row->nama ?></td>
							<td>
								<a href="<?php echo site_url('user/view/'.$row->id.'/'.$grid_state) ?>" class="edit_link">Lihat / Edit</a>
							</td>
						</tr>
						<?php
							}
						}else{
						?>
						<tr><td colspan="6"><em>Tidak ada data</em></td></tr>
						<?php	
						}
						?>
					</tbody>
				</table>
			</div>
			
			<?php $this->load->view('backend/components/paging') ?>
		</div><!-- /.container -->
	</div>

    <?php $this->load->view('backend/elements/footer') ?>
</body>
</html>