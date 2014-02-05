<div class="col-md-12">
    <ol class="breadcrumb">
        <li class="active">Panitia</li>                            
    </ol>    
    <div class="panel panel-default">
        <div class="panel-body">
            <?php if (!empty($notif)): ?>
                <div class="alert alert-<?php echo $notif['status']; ?>"><strong><?php echo $notif['pesan']; ?></strong></div>
            <?php endif; ?>
            <div class="panel panel-default">
                <div class="panel-heading"><strong>Data Username Panitia</strong></div>
                <div class="panel-body">
                    <?php if (empty($panitia)): ?>
                        <h3>Tidak ada data panitia saat ini</h3>
                    <?php else: ?>
                        <table class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Username</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($panitia as $index => $single): ?>
                                    <tr>
                                        <td><?php echo $index + 1; ?></td>
                                        <td><?php echo $single['nama']; ?></td>
                                        <td><?php echo $single['username']; ?></td>
                                        <td><?php echo ($single['status'] == '1') ? "Admin" : "Anggota"; ?></td>
                                        <td>
                                            <a class="btn btn-primary btnX" href="<?php echo base_url(); ?>panitia/username/edit/<?php echo $this->encrypt->encode($single['id']) ?>"><span class="glyphicon glyphicon-edit"></span> Ubah</a>
                                            <a class="btn btn-danger btnX" href="<?php echo base_url(); ?>panitia/username/reset/<?php echo $this->encrypt->encode($single['id']) ?>"><span class="glyphicon glyphicon-trash"></span> Reset Password</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                    <div class="col-md-2 col-md-offset-10">
                        <a href="<?php echo base_url(); ?>panitia/username/tambah" class="btn btn-success btn-lg btnX"><span class="glyphicon glyphicon-plus"></span> Tambah</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>