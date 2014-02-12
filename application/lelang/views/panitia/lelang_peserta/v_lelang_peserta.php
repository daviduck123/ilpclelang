<div class="col-md-12">
    <ol class="breadcrumb">
        <li class="active">Lelang Peserta</li>                            
    </ol>    
    <div class="panel panel-default">
        <div class="panel-body">
            <?php if (isset($notif)): ?>
                <div class="alert alert-<?php echo $notif['status']; ?>"><strong><?php echo $notif['pesan']; ?></strong></div>
            <?php endif; ?>
            <div class="panel panel-default">
                <div class="panel-heading"><strong>Data Ijin Lelang Peserta</strong></div>
                <div class="panel-body">
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Nama Tim</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($peserta as $index => $single): ?>
                                <tr>
                                    <td><?php echo $single['nama']; ?></td>
                                    <td><?php echo ($single['status'] == "0") ? "Tidak Boleh" : "Boleh"; ?></td>
                                    <td><a <?php echo ($single['status'] == "1") ? "disabled" : ""; ?> class="btn btn-lg btn-warning btnX" href="<?php echo ($single['status'] == "1") ? "" : site_url()."panitia/ijin/".$this->encrypt->encode($single['id']); ?>"><span class="glyphicon glyphicon-edit"></span> Ganti Ijin</a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


