<div class="col-md-12">
    <ol class="breadcrumb">                           
        <li class="active">Change Password</li>
    </ol>
    <div class="panel panel-default">
        <div class="panel-body">
            <?php if (isset($notif)): ?>
                <div class="alert alert-<?php echo $notif['status']; ?>"><strong><?php echo $notif['pesan']; ?></strong></div>
            <?php endif; ?>
            <?php echo validation_errors("<div class='alert alert-danger'><strong>", "</strong></div>"); ?>
            <div class="panel panel-default">
                <div class="panel-heading"><strong>Change Password</strong></div>
                <div class="panel-body">
                    <?php echo form_open("panitia/change", array("class" => "form-horizontal")); ?>
                    <div class="form-group">
                        <label class='col-md-2 control-label'>Old Password :</label>
                        <div class='col-md-10'>
                            <?php echo form_password("old", "", "placeholder = 'Old Password' maxlength='40' class='form-control'"); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class='col-md-2 control-label'>New Password :</label>
                        <div class='col-md-10'>
                            <?php echo form_password("new", "", "placeholder = 'new Password' maxlength='40' class='form-control'"); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class='col-md-2 control-label'>Confirm Password :</label>
                        <div class='col-md-10'>
                            <?php echo form_password("confirm", "", "placeholder = 'confirm Password' maxlength='40' class='form-control'"); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-5 col-md-offset-7 text-right">
                            <?php
                            echo form_button(array("name" => "submit", "value" => "true", "type" => "submit", "class" => "btn btn-info btn-lg btnX", "content" => "<span class=' glyphicon glyphicon-floppy-save'></span> Save"));
                            echo form_button(array("name" => "reset", "value" => "true", "type" => "reset", "class" => "btn btn-default btn-lg btnX", "content" => "<span class='glyphicon glyphicon-refresh'></span> Reset"));
                            ?>
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>