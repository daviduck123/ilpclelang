<div class="col-md-12">
    <ol class="breadcrumb">                      
        <li class="active">Barang</li>                            
    </ol>    
    <div class="panel panel-default">
        <div class="panel-body">    
            <?php if (!empty($notif)): ?>
                <div class="alert alert-<?php echo $notif["status"]; ?>"><strong><?php echo $notif["pesan"]; ?></strong></div>
            <?php endif; ?> 
            <?php if (empty($barang)): ?>
                <h3>Tidak ada barang saat ini</h3>
            <?php else: ?>
                <div class="panel panel-default">
                    <div class="panel-heading"><strong>Data Semua Barang</strong></div>
                    <div class="panel-body">
                        <table class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Barang</th>
                                    <th>Harga Awal</th>
                                    <th>Harga Sekarang</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($barang as $index => $single): ?>
                                    <tr>
                                        <td><?php echo $index + 1; ?></td>
                                        <td><?php echo $single['nama_barang']; ?></td>
                                        <td><?php echo $single['harga_awal']; ?></td>
                                        <td><?php echo $single['harga_sekarang']; ?></td>
                                        <td><a class="btn btn-warning btnX" href="<?php echo base_url(); ?>panitia/barang/edit/<?php echo $this->encrypt->encode($single['id']) ?>"><span class="glyphicon glyphicon-edit"></span> Ubah Data Barang</a></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-12 text-right">
                <a class="btn btn-success btnX" href="<?php echo base_url(); ?>panitia/barang/tambah"><span class="glyphicon glyphicon-plus"></span> Tambah Barang</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>