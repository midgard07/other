<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button class="navbar-toggle" data-target=".navbar-collapse" data-toggle="collapse" type="button">
                <span class="icon-bar"></span> 
                <span class="icon-bar"></span> 
                <span class="icon-bar"></span>
            </button> 

            <!--<a class="navbar-brand" href="<?php echo site_url('dashboard') ?>" style="padding:10px 20px 8px 10px"><img src="<?php echo base_url('assets/img/aptrindo2.png') ?>" width="30" height="30" alt="APTRINDO" /></a>-->
            <a class="navbar-brand" href="<?php echo site_url('dashboard') ?>" style="padding:10px 20px 8px 10px"><img src="<?php echo base_url('assets/img/LOGO_SIAB2.png') ?>" alt="Logo EBPP" width="70" height="30" /></a>
        </div>

        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">User <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo site_url('user/listview_recon') ?>">List User RECON</a></li>
                        <li><a href="<?php echo site_url('user/listview_pos') ?>">List User POS</a></li>
                        <li><a href="<?php echo site_url('user/listview_force') ?>">List User FORCE Flagging</a></li>
                        <li><a href="<?php echo site_url('user/add') ?>">Add User</a></li>
                    </ul>
                </li>
            </ul>
            <!-- User Panel -->
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Bantuan <b class="caret"></b></a>
                    <ul class="dropdown-menu" style="right:auto">
                        <li><a href="#"><span class="glyphicon glyphicon-earphone"></span> Call Cust Care: +62-21-500950</a></li>
                        <li><a href="#"><span class="glyphicon glyphicon-envelope"></span> Email: customercare@ilcs.co.id</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $auth->REAL_NAME ?> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <!-- <li><a href="<?php echo site_url('dashboard/passwordUpdate') ?>">Ganti Password</a></li> -->
                        <li><a href="<?php echo site_url('front/logout') ?>">Keluar</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>