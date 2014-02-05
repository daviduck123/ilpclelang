<div class="col-md-12">
    <ol class="breadcrumb">                      
        <li class="active">Wewenang</li>                            
    </ol>    
    <div class="panel panel-default">
        <div class="panel-body">    
            <?php if (!empty($notif)): ?>
                <div class="alert alert-<?php echo $notif["status"]; ?>"><strong><?php echo $notif["pesan"]; ?></strong></div>
            <?php endif; ?> 
            <?php if (empty($panitia)): ?>
                <h3>Tidak ada Panitia saat ini</h3>
            <?php else: ?>
                <div class="panel panel-default">
                    <div class="panel-heading"><strong>Data Semua Panitia</strong></div>
                    <div class="panel-body">
                        <table class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($panitia as $index => $single): ?>
                                    <tr>
                                        <td><?php echo $index + 1; ?></td>
                                        <td><?php echo $single['nama']; ?></td>
                                        <td><a class="btn btn-warning btnX" href="<?php echo base_url(); ?>panitia/wewenang/edit/<?php echo $this->encrypt->encode($single['id']) ?>"><span class="glyphicon glyphicon-edit"></span> Ubah Wewenang</a></td>
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