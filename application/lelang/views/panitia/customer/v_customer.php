<div class="col-md-12">
    <ol class="breadcrumb">
        <li class="active">Customer</li>                            
    </ol>    
    <div class="panel panel-default">
        <div class="panel-body">
            <?php if (!empty($notif)): ?>
                <div class="alert alert-<?php echo $notif["status"]; ?>"><strong><?php echo $notif["pesan"]; ?></strong></div>
            <?php endif; ?>
            <div class="panel panel-default">
                <div class="panel-heading"><strong>Data Customer</strong></div>
                <div class="panel-body">
                    <table class="table table-hover table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($customer as $index => $single): ?>
                                <tr>
                                    <td><?php echo $index + 1; ?></td>
                                    <td><?php echo $single['nama_customer']; ?></td>
                                    <td><a class="btn btn-info" href="<?php echo site_url() ?>panitia/customer/edit/<?php echo $this->encrypt->encode($single['id']); ?>"><span class="glyphicon glyphicon-edit"></span> Ubah</a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <div class="col-md-2 col-md-offset-8 text-right">
                        <a class="btn btn-success" href="<?php echo site_url() ?>panitia/customer/tambah"><span class="glyphicon glyphicon-plus"></span> Tambah</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>