<div class="col-md-12">
    <ol class="breadcrumb">
        <li class="active">Home</li>                            
    </ol>
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash() ?>" />
    <div class="panel panel-default">
        <div class="panel-body">
            <!--Content Panel-->
            <div class="panel-group" id="accordion">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseChat"><u>Chat Intern</u></a>
                        </h4>
                    </div>
                    <div id="collapseChat" class="panel-collapse collapse">
                        <div class="panel-body">    
                            <div class="news">
                                <dl class="dl-horizontal">
                                    <?php foreach ($chat as $index => $single): ?>
                                        <dt>
                                        <?php
                                        $tgl = new DateTime($single['time']);
                                        echo $single['nama'] . " -> " . $tgl->format("H:i:s");
                                        ?>                            
                                        </dt>
                                        <dd><?php echo $single['chat'] ?></dd>
                                    <?php endforeach; ?>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseNews"><u>News</u></a>
                        </h4>
                    </div>
                    <div id="collapseNews" class="panel-collapse collapse">
                        <div class="panel-body">
                            <div class="news">
                                <dl class="dl-horizontal">
                                    <?php foreach ($news as $index => $single): ?>
                                        <dt>
                                        <?php
                                        $tgl = new DateTime($single['time']);
                                        echo $single['nama'] . " -> " . $tgl->format("H:i:s");
                                        ?>                            
                                        </dt>
                                        <dd><?php echo $single['berita'] ?></dd>
                                    <?php endforeach; ?>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseGrafik"><u>Grafik</u></a>
                        </h4>
                    </div>
                    <div id="collapseGrafik" class="panel-collapse collapse in">
                        <div class="panel-body">
                            <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                                <!-- Indicators -->
                                <ol class="carousel-indicators bg-carousel">                        
                                    <?php for ($i = 0; $i < 9; $i++): ?>
                                        <li id="point-<?php echo $i; ?>" data-toggle="tooltip" data-placement="bottom" title="" data-target="#carousel-example-generic" data-slide-to="<?php echo $i; ?>" class="<?php echo ($i == 0) ? "active" : ""; ?>"></li>
                                    <?php endfor; ?>
                                </ol>

                                <!-- Wrapper for slides -->
                                <div class="carousel-inner">
                                    <?php for ($i = 0; $i < 9; $i++): ?>
                                        <div class="item <?php echo ($i == 0) ? "active" : ""; ?>">
                                            <div class="test">  
                                                <h3 id="titlegraph-<?php echo $i; ?>" class="text-center black"></h3>

                                                <div id="graph-<?php echo $i; ?>" class="graph">
                                                </div>
                                            </div>                                
                                        </div>
                                    <?php endfor; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--SCRIPT UNTUK FLUKTUASI-->
<link rel="stylesheet" media="screen" href="<?php echo base_url(); ?>bootstrap/css/morris.css"/>
<link rel="stylesheet" media="screen" href="<?php echo base_url(); ?>bootstrap/css/david.css"/>
<script>var DATA;</script>
<script src="<?php echo base_url(); ?>bootstrap/js/numeral.min.js"></script>
<script src="<?php echo base_url(); ?>bootstrap/js/raphael.js"></script>
<script src="<?php echo base_url(); ?>bootstrap/js/morris.js"></script>
<script src="<?php echo base_url(); ?>bootstrap/js/fluktuasi_bt.js"></script>
<script src="<?php echo base_url(); ?>bootstrap/js/v_fluktuasi.js"></script>
<script>update_graph();</script>