<div class="col-md-12">
    <ol class="breadcrumb">
        <li class="active">Lelang</li>                            
    </ol>    
    <div class="panel panel-default">
        <div class="panel-body">
            <?php if (!empty($notif)): ?>
                <div class="alert alert-<?php echo $notif["status"]; ?>"><strong><?php echo $notif["pesan"]; ?></strong></div>
            <?php endif; ?> 
            <?php if (empty($alllelang)): ?>
                <h3>Tidak ada data Lelang di database</h3>
            <?php else: ?>       
                <div class="panel-group" id="accordion">
                    <?php foreach ($alllelang as $index => $lelang): ?>
                        <div class="panel panel-default">
                            <div class="panel-heading"><a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $index; ?>"><strong>Data Lelang Season <?php echo $index; ?></strong></a></div>
                            <div id="collapse<?php echo $index; ?>" class="panel-collapse collapse">
                                <div class="panel-body">   
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Customer</th>
                                                <th>Judul Lelang</th>
                                                <th>Season</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($lelang as $index => $single): ?>
                                                <tr>
                                                    <td><?php echo $index + 1; ?></td>
                                                    <td><?php echo $single['nama_customer']; ?></td>
                                                    <td><?php echo $single['judul_lelang']; ?></td>
                                                    <td><?php echo $single['season_id']; ?></td>
                                                    <td>
                                                        <?php
                                                        switch ($single['status_lelang']):
                                                            case 0:
                                                                echo "Belum Diikuti";
                                                                break;
                                                            case 1:
                                                                echo "Sedang Diikuti";
                                                                break;
                                                            case 2:
                                                                echo "Sudah Selesai";
                                                                break;
                                                        endswitch;
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <a class="btn btn-primary" href="<?php echo site_url() . "panitia/lelang/lihat/" . $this->encrypt->encode($single['id']); ?>"><span class="glyphicon glyphicon-edit"></span> Lihat</a>
                                                        <a class="btn btn-info" <?php echo ($single['status_lelang'] != 0) ? "disabled" : ""; ?> href="<?php echo (($single['status_lelang'] == 0) ? site_url() . "panitia/lelang/edit/" . $this->encrypt->encode($single['id']) : ""); ?>"><span class="glyphicon glyphicon-edit"></span> Ubah</a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <br/>
            <div class="col-md-2 col-md-offset-10">
                <a href="<?php echo site_url(); ?>panitia/lelang/tambah" class="btn btn-success btn-lg btnX"><span class="glyphicon glyphicon-plus"></span> Tambah</a>
            </div>               
        </div>
    </div>
</div>
