<!DOCTYPE html>
<html lang="id">
<head>
	<?php $this->load->view('backend/elements/basic_head') ?>
</head>

<body>
	<div id="wrap">
		<?php $this->load->view('backend/components/header') ?>

		<div class="container">
			
			<div class="row">
            	<div class="col-md-8">
                	<h1>Add New User</h1>
                </div>
				<div class="col-md-4">
					<div class="pull-right back_list">
						
					</div>
				</div>
			</div>

			<hr />
			
			<?php $this->load->view('backend/components/message_handler') ?>
			
			<form role="form" class="form-horizontal" action="" method="post">
				<div class="row">
					<div class="col-lg-6">		
						<fieldset>
							<legend>Data User</legend>
							<div class="form-group">
								<label class="col-lg-4 text-left">Aplikasi *</label>
								<div class="col-lg-8">
									<select class="form-control" name="apps_id" id="apps_id" onchange="apps_check(this)">
										<option value="" selected>-- Select --</option>
										<?php if(set_value('apps_id') == 'RECON') { ?>
											<option value="RECON" selected>RECON</option>
										<?php } else {?>
											<option value="RECON">RECON</option>
										<?php } ?>
										<?php if(set_value('apps_id') == 'POS') { ?>
											<option value="POS" selected>POS</option>
										<?php } else {?>
											<option value="POS">POS</option>
										<?php } ?>
										<?php if(set_value('apps_id') == 'FORCE') { ?>
											<option value="FORCE" selected>FORCE Flagging</option>
										<?php } else {?>
											<option value="FORCE">FORCE Flagging</option>
										<?php } ?>
									</select>
									<?php echo form_error('apps_id', '<div class="error">', '</div><br/>'); ?>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-4 text-left">Email *</label>
								<div class="col-lg-8">
									<input type="text" class="form-control" name="email" placeholder="" value="<?php echo set_value('email'); ?>" />
									<?php echo form_error('email', '<div class="error">', '</div><br/>'); ?>
								</div>
							</div>

							<div class="form-group">
								<label class="col-lg-4 text-left">Username *</label>
								<div class="col-lg-8">
									<input type="text" class="form-control" name="username" placeholder="" value="<?php echo set_value('username'); ?>" />
									<?php echo form_error('username', '<div class="error">', '</div><br/>'); ?>
								</div>
							</div>
							
							<!-- <div class="form-group">
								<label class="col-lg-4 text-left">Password</label>
								<div class="col-lg-8">
									<input type="password" class="form-control" id="password" name="password" placeholder="" value="<?php echo set_value('password'); ?>" />
									<div>
										<label>
											<input type="checkbox" id="show_password" value="1"> Tunjukkan Password
										</label>
									</div>
									<?php echo form_error('password', '<div class="error">', '</div><br/>'); ?>
								</div>
							</div> -->
							
							<div class="form-group">
								<label class="col-lg-4 text-left">Nama *</label>
								<div class="col-lg-8">
									<input type="text" class="form-control" name="name" placeholder="" value="<?php echo set_value('name'); ?>" />
									<?php echo form_error('name', '<div class="error">', '</div><br/>'); ?>
								</div>
							</div>

							<div class="form-group" id="recon">
								<label class="col-lg-4 text-left">Biller *</label>
								<div class="col-lg-8">
									<select class="form-control" name="biller_code">
										<option value="">-- Select --</option>
										<?php 
										foreach($billers as $row){
										?>
										<?php if($row->BILLER_CODE == set_value('biller_code')) { ?>
											<option value="<?php echo $row->BILLER_CODE ?>" selected><?php echo $row->BILLER_NAME ?></option>
										<?php } else { ?>
											<option value="<?php echo $row->BILLER_CODE ?>"><?php echo $row->BILLER_NAME ?></option>
										<?php } ?>
										<?php
										}
										?>
									</select>
									<?php echo form_error('biller_code', '<div class="error">', '</div><br/>'); ?>
								</div>
							</div>

							<div class="form-group" id="pos">
								<label class="col-lg-4 text-left">Biller *</label>
								<div class="col-lg-8">
									<select class="form-control" name="biller_id">
										<option value="">-- Select --</option>
										<?php 
										foreach($billers as $row){
										?>
										<?php if($row->ID == set_value('biller_id')) { ?>
											<option value="<?php echo $row->ID ?>" selected><?php echo $row->BILLER_NAME ?></option>
										<?php } else { ?>
											<option value="<?php echo $row->ID ?>"><?php echo $row->BILLER_NAME ?></option>
										<?php } ?>
										<?php
										}
										?>
									</select>
									<?php echo form_error('biller_id', '<div class="error">', '</div><br/>'); ?>
								</div>
							</div>
						</fieldset>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-6">
						<p>* Wajib Diisi</p>
					</div>
					<div class="col-lg-6">
						<div class="pull-right">
							<button class="btn btn-primary fr" type="submit"><span class="glyphicon glyphicon-floppy-saved"></span> Simpan</button>
							<a href="<?php echo site_url($grid_state) ?>" class="btn btn-default">Kembali</a>
						</div>
					</div>
				</div>
			</form>

		</div>
	</div>
	
    <?php $this->load->view('backend/elements/footer') ?>
	<script type="text/javascript">
		function apps_check(temp){
			if(temp.value == 'RECON'){
				$('#recon').show();
				$('#pos').hide();
			}else if(temp.value == 'POS'){
				$('#recon').hide();
				$('#pos').show();
			}else if(temp.value == 'FORCE'){
				$('#recon').show();
				$('#pos').hide();
			}else{
				$('#recon').hide();
				$('#pos').hide();
			}
		}
	</script>
	<script type="text/javascript">
		$(document).ready(function(){
			if($('#apps_id').val() == ''){
				$('#recon').hide();
				$('#pos').hide();
			}else if($('#apps_id').val() == 'POS'){
				$('#recon').hide();
				$('#pos').show();
			}else if($('#apps_id').val() == 'RECON' || $('#apps_id').val() == 'FORCE'){
				$('#recon').show();
				$('#pos').hide();
			}
			});
	</script>
</body>
</html>