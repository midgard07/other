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
                	<h1>Edit User</h1>
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
								<label class="col-lg-4 text-left">Username *</label>
								<div class="col-lg-8">
									<input type="text" class="form-control" name="username" placeholder="" maxlength="20" value="<?php echo $user->USER_NAME; ?>" />
									<?php echo form_error('username', '<div class="error">', '</div><br/>'); ?>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-lg-4 text-left">Nama *</label>
								<div class="col-lg-8">
									<input type="text" class="form-control" name="name" placeholder="" value="<?php echo $user->REAL_NAME; ?>" />
									<?php echo form_error('name', '<div class="error">', '</div><br/>'); ?>
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
								<span class="glyphicon glyphicon-floppy-saved"></span> Reset
							</button>
						</div>
					</div>
				</div>
			</form>

		</div><!-- /.container -->
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