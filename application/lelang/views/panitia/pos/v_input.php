<div class="col-md-12">
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url(); ?>panitia/pos">Pos</a></li>                            
        <li class="active">Input Pos</li>
    </ol>
    <div class="panel panel-default">
        <div class="panel-body">
            <?php if (empty($tim)): ?>
                <h3>Anda tidak berhak menginput pos apapun</h3>
            <?php else: ?>
                <?php if (isset($notif)): ?>
                    <div class="alert alert-<?php echo $notif['status']; ?>"><strong><?php echo $notif['pesan']; ?></strong></div>
                <?php endif; ?>
                <div class="panel panel-default">
                    <div class="panel-heading"><strong>Tabel Pos</strong></div>
                    <div class="panel-body">
                        <table class="table table-hover table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Nama Tim</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($tim as $index => $single): ?>
                                    <tr>
                                        <td><?php echo $single['nama']; ?></td>
                                        <td>
                                            <?php
                                            $disable = "";
                                            if ($single['status'] == 1) {
                                                echo 'Menang';
                                            } else if ($single['status'] == 2) {
                                                echo 'Seri';
                                            } else if ($single['status'] == 3) {
                                                echo 'Kalah';
                                            } else {
                                                echo "Belum Input";
                                            }
                                            ?>
                                        </td>                        
                                        <td>
                                            <div class="col-md-7">
                                                <?php
                                                echo form_open("panitia/pos/inputpos/" . ((empty($single['status'])) ? $this->encrypt->encode($idpos) : ""));
                                                echo form_submit(array("class" => "btn btn-success btn-lg btnX", "name" => "menang", "value" => "Menang", ((isset($single['status'])) ? "disabled" : "ada") => "true"));
                                                echo form_submit(array("class" => "btn btn-info btn-lg btnX", "name" => "seri", "value" => "Seri", ((isset($single['status'])) ? "disabled" : "ada") => "true"));
                                                echo form_submit(array("class" => "btn btn-danger btn-lg btnX", "name" => "kalah", "value" => "Kalah", ((isset($single['status'])) ? "disabled" : "ada") => "true"));
                                                if ($this->session->userdata("panitia_id") == 1) {
                                                    echo form_submit(array("class" => "btn btn-warning btn-lg btnX", "name" => "ubah", "value" => "Ubah", ((isset($single['status'])) ? "" : "disabled") => "false"));
                                                }
                                                echo form_hidden("idtim", ((empty($single['status'])) ? $this->encrypt->encode($single['id']) : ""));
                                                echo form_close();
                                                ?>
                                            </div>
                                            <?php if ($status_panitia == "1"): ?>
                                                <a class="btn btn-warning btn-lg btnX" href="<?php echo site_url(); ?>panitia/pos/ubahstatus/<?php echo $this->encrypt->encode($single['id']) . "|" . $this->encrypt->encode($idpos); ?>"><span class="glyphicon glyphicon-edit"></span> Ubah</a>                                                
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>