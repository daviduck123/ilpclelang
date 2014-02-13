<div class="col-md-12">
    <ol class="breadcrumb">
        <li class="active">Season</li>                            
    </ol>    
    <div class="panel panel-default">
        <div class="panel-body">
            <?php if (!empty($notif)): ?>
                <div class="alert alert-<?php echo $notif['status']; ?>"><strong><?php echo $notif['pesan']; ?></strong></div>
            <?php endif; ?>
            <?php if (empty($season)): ?>
                <h3>Tidak Ada Season di Program ini</h3>
            <?php else: ?>
                <div class="panel panel-default">
                    <div class="panel-heading"><strong>Season</strong></div>
                    <div class="panel-body">
                        <table class="table table-hover table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Nama Season</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($season as $index => $single):
                                    ?>
                                    <tr>
                                        <td><?php echo "Season " . $single['id']; ?></td>
                                        <td>
                                            <?php
                                            switch ($single['aktif']):
                                                case '0':
                                                    echo "Season Belum Mulai";
                                                    break;
                                                case '1':
                                                    echo "Season Dipersiapkan";
                                                    break;
                                                case '2':
                                                    echo "Season Dimulai";
                                                    break;
                                                case '3':
                                                    echo "Season Sudah Selesai";
                                                    break;
                                            endswitch;
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            if (empty($jalan) || $single['id'] == $jalan['id']):
                                                echo form_open("panitia/season/");
                                                echo form_submit(array("class" => "btn btn-info btn-lg btnX", "name" => "persiapan", "value" => "Persiapan", (($single['aktif'] != '0') ? "disabled" : "ada") => "true"));
                                                echo form_submit(array("class" => "btn btn-success btn-lg btnX", "name" => "mulai", "value" => "Mulai", (($single['aktif'] != '1') ? "disabled" : "ada") => "true"));
                                                echo form_submit(array("class" => "btn btn-danger btn-lg btnX", "name" => "stop", "value" => "Berhenti", (($single['aktif'] != '2') ? "disabled" : "ada") => "true"));
                                                echo form_hidden("season_id", (($single['aktif'] != '3') ? $this->encrypt->encode($single['id']) : ""));
                                                ?>
                                                <?php if ($status_panitia == "1"): ?>
                                                    <?php if ($single['aktif'] == '3'): ?>
                                                        <a class="btn btn-warning btn-lg btnX" href="<?php echo site_url(); ?>panitia/setWinnerSeason/<?php echo $this->encrypt->encode($single['id']); ?>"><span class="glyphicon glyphicon-edit"></span> Set Pemenang</a>
                                                    <?php else: ?>
                                                        <a class="btn btn-warning btn-lg btnX" disabled><span class="glyphicon glyphicon-edit"></span> Set Pemenang</a>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                                <?php
                                                echo form_close();
                                            else:
                                                ?>
                                                <a class="btn btn-info btn-lg btnX" disabled>Persiapan</a>
                                                <a class="btn btn-success btn-lg btnX" disabled>Mulai</a>
                                                <a class="btn btn-danger btn-lg btnX" disabled>Berhenti</a>
                                                <?php if ($status_panitia == "1"): ?>
                                                    <?php if ($single['aktif'] == '3'): ?>
                                                        <a class="btn btn-warning btn-lg btnX" href="<?php echo base_url(); ?>panitia/setWinnerSeason/<?php echo $this->encrypt->encode($single['id']); ?>"><span class="glyphicon glyphicon-edit"></span> Set Pemenang</a>
                                                    <?php else: ?>
                                                        <a class="btn btn-warning btn-lg btnX" disabled><span class="glyphicon glyphicon-edit"></span> Set Pemenang</a>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endif; ?>
            <?php if ($status_panitia == "1"): ?>
                <div class="col-md-12 text-right">
                    <a class="btn btn-success btn-lg btnX" href="<?php echo base_url(); ?>panitia/setAddSeason/"><span class="glyphicon glyphicon-plus"></span> Tambah Season</a>                                      
                    <?php
                    if ($status_semua_lelang == "1"): ?>
                        <a class="btn btn-warning btn-lg btnX" href="<?php echo base_url(); ?>panitia/jualSemuaBarang"><span class="glyphicon glyphicon-share"></span> Jual Barang Peserta</a>                                      
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
