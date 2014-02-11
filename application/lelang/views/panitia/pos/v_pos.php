<div class="col-md-12">
    <ol class="breadcrumb">
        <li class="active">Pos</li>                            
    </ol>
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash() ?>" />
    <?php if (!empty($notif)): ?>
        <div class="alert alert-<?php echo $notif['status']; ?>"><strong><?php echo $notif['pesan']; ?></strong></div>
    <?php endif; ?>
    <div class="panel panel-default">
        <div class="panel-body">
            <?php if (empty($pos)): ?>
                <h3>Anda tidak berhak menginput pos manapun <?php echo ($status_panitia == '1') ? "atau setting hak input pos di menu Wewenang" : ""; ?></h3>
            <?php else: ?>
                <div class="panel panel-default">
                    <div class="panel-heading"><strong>Tabel Pos</strong></div>
                    <div class="panel-body">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Pos</th>
                                    <th>Jenis Pos</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($pos as $index => $single): ?>
                                    <tr>
                                        <td><?php echo $index + 1; ?></td>
                                        <td><?php echo $single['nama_pos']; ?></td>
                                        <td><?php echo $single['nama_jenis']; ?></td>
                                        <td>
                                            <a class="btn btn-info" href="<?php echo site_url(); ?>panitia/pos/inputpos/<?php echo $this->encrypt->encode($single['id']); ?>"><span class="glyphicon glyphicon-edit"></span> Input Pos</a>
                                        </td>                                
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>                        
                    </div>
                </div>
            <?php endif; ?>
            <!--Content Panel-->            
            <?php if ($status_panitia == "1"): ?>
                <div class="col-md-12 text-right">
                    <a class="btn btn-success btn-lg btnX" href="<?php echo site_url(); ?>panitia/pos/tambah"><span class="glyphicon glyphicon-plus"></span> Tambah Pos</a>                                                
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
