<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<?php $this->load->view('frontend/components/basic_head'); ?>
</head>
<body>
<header class="main-header">
	<?php $this->load->view('frontend/components/header'); ?>
</header>
<div class="container main">
	<div class="row-fluid content">
		<div class="span7 welcome-container">
			<div class="span0">
				<h1>EBPP User Management</h1>
				<h3></h3>
				<!--<img src="<?php echo base_url()?>assets/img/siab_logo.png" alt="Logo SIAB" style="width:204px;height:128px" />-->
			</div>
		</div>
		<!-- end of span 7 -->
		<aside class="span5">
			<div class="login">
				<form id="login_form" action="" method="post">
					<div class="form-inline">
						<span class="fl loginlogin">Silakan Masuk</span>
					</div><br />
					<hr />
					<?php
					if(isset($error_msg)){
					?>
					<div class="alert alert-error" id="information_bar" style=""><?php echo $error_msg ?></div>
					<?php
					}
					?>
					<div class="row-fluid">
						<div class="span12">
							<fieldset class="username">
								<input type="text" id="username" name="username" placeholder="Email" value="<?php secho(post('username')) ?>">
							</fieldset>						
						</div>
					</div>
					<!-- end of row fluid -->

					<div class="row-fluid">
						<div class="span12">
							<fieldset class="password">
								<input type="password" id="password" name="password" placeholder="Password">
							</fieldset>
							
						</div>
					</div>

					<div class="row-fluid">
						<div class="span12">
							<input type="checkbox" id="c1" name="cc" /></br>
							<!--<label for="c1"><span></span>Remember Password</label>-->

							<p><strong>Ketik ulang huruf berikut:</strong></p>
							<img src="<?php echo site_url('front/show_captcha/'.microtime(true))?>" id="captcha" /><br/>

							<!-- CHANGE TEXT LINK -->
							<a href="#" onClick="
							    document.getElementById('captcha').src='<?php echo site_url('front/show_captcha') ?>?'+Math.random();
							    document.getElementById('captcha-form').focus();
								return false;
							">Tidak terbaca? Klik untuk menggantinya.</a>
							<br/><br/>
							<input type="text" name="captcha" id="captcha-form" autocomplete="off" /><br/>
						</div>
					</div>
					<div class="row-fluid">
						<div class="pull-left">
							<!--<a href="<?php echo site_url('front/fpass') ?>">Lupa Password?</a>-->
						</div>
						<div class="pull-right">
							<button id="login_button" class="btn btn-primary fr" type="submit">Masuk</button>
						</div>
					</div>
					<!-- end of row fluid -->
					<div class="row-fluid">
						<div class="form-inline">
							
						</div>
					</div>
				</form>
			</div>
		</aside>
	</div>
	<!-- end row 2 --> 
</div>
<!-- end of container  --> 
<footer>
	<?php $this->load->view('frontend/components/footer'); ?>
</footer>

<!-- Menu dropown
	Back to top
	Search javascript --> 

<script src="<?php echo base_url(); ?>assets/js/jquery-2.0.3.min.js"></script> 
<script src="<?php echo base_url(); ?>assets/landing/js/bootstrap.js"></script> 
<script src="<?php echo base_url(); ?>assets/landing/js/bootstrap.min.js"></script> 

<script type="text/javascript">
	$(function(){
	    $('[rel=popover]').popover({ 
	    html : true, 
	    content: function() {
	      return $('#popover_content_wrapper').html();
	    }

    });
});
</script>
<!-- add the backstretch plugin --> 
<script src="<?php echo base_url(); ?>assets/landing/js/backstretch.js"></script> 
<script type='text/javascript'>
	var bs = {
		baseURL : '<?php echo base_url(); ?>',
		siteURL : '<?php echo base_url(); ?>'	
	}

    $(document).ready(function() {
		var d = new Date();
		var hour = d.getHours();
		
		var waktu = '';
		
		if(hour < 5){
			waktu = 'night';
		}else if(hour < 9){
			waktu = 'morning';
		}else if(hour < 15){
			waktu = 'afternoon';
		}else if(hour < 19){
			waktu = 'evening';
		}else{
			waktu = 'night';
		}
		
        $.backstretch(bs.baseURL + "assets/landing/img/bg/port_" + waktu + ".jpg");
        // $.backstretch(bs.baseURL + "assets/landing/img/bg/port_afternoon.jpg");
    });
</script>
</body>
</html>