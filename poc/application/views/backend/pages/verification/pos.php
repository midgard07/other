<!DOCTYPE html>
<html lang="id">
<head>
	<?php $this->load->view('backend/elements/basic_head') ?>
</head>

<body>
	<div id="wrap">
		<div class="container">
			<div class="row">
            	<div class="col-md-8">
                	<h1>VERIFICATION RECON USER</h1>
                </div>
				<div class="col-md-4">
					<div class="pull-right back_list">
					</div>
				</div>
			</div>
			<hr />
			<?php if($is_error == 'true') { ?>
				<h3><?php echo $message ?></h3>
			<?php } else { ?>
			<?php $this->load->view('backend/components/message_handler') ?>

			<form role="form" class="form-horizontal" action="" method="post">
				<div class="row">
					<div class="col-lg-6">		
						<fieldset>
							<legend>User Recon</legend>
							<div class="form-group">
								<label class="col-lg-4 text-left">Username</label>
								<div class="col-lg-8">
									<input type="text" class="form-control" disabled name="username" placeholder="" value="<?php echo $user->USERNAME; ?>" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-4 text-left">Password Default</label>
								<div class="col-lg-8">
									<input type="text" class="form-control" disabled name="def_pass" placeholder="" value="<?php echo $pass; ?>" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-4 text-left">Password *</label>
								<div class="col-lg-8">
									<input type="password" class="form-control" id="password" name="password" placeholder="" value="<?php echo $pass; ?>"/>
									<div>
										<label>
											<input type="checkbox" id="show_password" value="1"> Tunjukkan Password
										</label>
									</div>
									<?php echo form_error('password', '<div class="error">', '</div><br/>'); ?>
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
							<button class="btn btn-primary fr" type="submit">
								<span class="glyphicon glyphicon-floppy-saved"></span> 	Simpan
							</button>
						</div>
					</div>
				</div>
			</form>
			<?php } ?>
		</div>
	</div>
    <?php $this->load->view('backend/elements/footer') ?>
    <script type="text/javascript">
	$(document).ready(function(){
		$('#show_password').click(function(){
			if($(this).is(':checked')){
				$('#password').attr('type', 'text');
			}else{
				$('#password').attr('type', 'password');
			}
		});
	});
	</script>
</body>
</html>