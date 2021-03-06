<div class="col-md-12">
    <ol class="breadcrumb">
        <li class="active">Chat</li>                            
    </ol>    
    <div class="panel panel-default">
        <div class="panel-body">
            <?php if (isset($notif)): ?>
                <div class="alert alert-<?php echo $notif['status']; ?>"><strong><?php echo $notif['pesan']; ?></strong></div>
            <?php endif; ?>
            <div class="panel panel-default">
                <div class="panel-heading"><strong>Chat</strong></div>
                <div class="panel-body">
                    <div class="col-md-12 news">
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
                    <div class="col-md-12"><hr/></div>
                    <div>
                        <?php echo form_open("panitia/chat", array("class" => "form-horizontal")); ?>
                        <div class="form-group">
                            <label class="col-md-2 control-label">Tambah Chat :</label>
                            <div class="col-md-10">
                                <?php echo form_textarea(array("name" => "chat", "placeholder" => "Chat", "rows" => "2", "class" => "form-control", "required" => "true")) ?>
                            </div>
                        </div>
                        <?php echo form_submit("submit", "Post", "class='btn btn-primary form-control'") ?>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>