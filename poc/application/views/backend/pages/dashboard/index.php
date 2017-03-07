<!DOCTYPE html>
<html lang="id">
<head>
	<?php $this->load->view('backend/elements/basic_head') ?>
</head>

<body>
	<div id="wrap">
		<?php $this->load->view('backend/components/header') ?>

		<div class="container">
			
			<h1>Selamat Datang EBPP User Management</h1>
			<table class="table table-bordered table-striped">
				<thead>
					
				</thead>
				<tbody>
					<tr>
						<td style="width:40%">Username</td>
						<td><?php echo $auth->USER_NAME ?></td>
					</tr>
					<tr>
						<td style="width:40%">Nama</td>
						<td><?php echo $auth->REAL_NAME ?></td>
					</tr>
				</tbody>
			</table>
		</div><!-- /.container -->
	</div>
	
    <?php $this->load->view('backend/elements/footer') ?>
</body>
</html>