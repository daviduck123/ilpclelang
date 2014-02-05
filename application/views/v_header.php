<html> 
    <head>
        <?php $this->load->helper('url'); ?>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="stylesheet" media="screen" href="<?php echo base_url(); ?>bootstrap/css/basic-color.css"/>
        <link rel="stylesheet" media="screen" href="<?php echo base_url(); ?>bootstrap/css/bootstrap.min.css"/>
        <link rel="stylesheet" media="screen" href="<?php echo base_url(); ?>bootstrap/css/bootstrap-theme.min.css"/>
        <link rel="stylesheet" media="screen" href="<?php echo base_url(); ?>bootstrap/css/theme.css"/>
        <link rel="stylesheet" media="screen" href="<?php echo base_url(); ?>bootstrap/css/custom.css"/>
        <link rel="stylesheet" media="screen" href="<?php echo base_url(); ?>bootstrap/css/david.css"/>


        <script src="<?php echo base_url(); ?>bootstrap/js/jquery-1.9.1.min.js"></script>
        <script src="<?php echo base_url(); ?>bootstrap/js/bootstrap.min.js"></script>
        <title><?php echo $title; ?> - ILPC 2014</title>
    </head>
    <body>
        <script>
            var SITE_URL = "<?php echo base_url(); ?>";
            var TIME_SERVER = <?php echo time() * 1000 ?>;
        </script>
        <script type="text/javascript" src="<?php echo base_url(); ?>bootstrap/js/v_timer.js"></script>
        <!-- Fixed navbar //selalu sama-->
        <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <img id="logo" src="<?php echo base_url(); ?>bootstrap/img/headertxt.png"/> 
                </div>
                <div class="navbar-collapse collapse">
                    <div class="navbar-nav navbar-right" id="panel_jam">
                        <h3><b><span id="jam"></span></b></h3>
                    </div>
                </div>
            </div>
        </div>