<?php
$auth = $this->userauth->getLoginData();
?>
	<meta charset="utf-8">
	<meta content="width=device-width, initial-scale=1.0" name="viewport">
	<meta content="" name="description">
	<meta content="" name="author">
	
	<link rel="shortcut icon" href="<?php echo base_url('favicon.ico') ?>" type="image/x-icon">
	<link rel="icon" href="<?php echo base_url('favicon.ico') ?>" type="image/x-icon">
	
	<title>
	<?php echo isset($page_title) ? $page_title . ' | ' : '' ?><?php echo $this->config->item('website_name') ?></title>
    <!-- Bootstrap core CSS -->
	<link href="<?php echo base_url('assets/css/bootstrap.css') ?>" rel="stylesheet">
	<link href="<?php echo base_url('assets/css/datepicker.css') ?>" rel="stylesheet">
	<link href="<?php echo base_url('assets/css/smartcargo.css') ?>" rel="stylesheet">
	<!-- Custom styles for this template -->
	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	  <script src="<?php echo base_url('assets/js/html5shiv.js') ?>"></script>
	  <script src="<?php echo base_url('assets/js/respond.min.js') ?>"></script>
	<![endif]-->
    
    <script type="text/javascript">
	var bs = {
		token : '<?php echo $auth->token ?>',
		siteURL : '<?php echo site_url() ?>',
		baseURL : '<?php echo base_url() ?>'
	};
	
	</script>