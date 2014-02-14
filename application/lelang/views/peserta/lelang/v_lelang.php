<div class="col-md-12">
    <div class="row-justified ">
        <!-- Tab panes -->
        <div class="col-md-12">
            <?php if (!empty($notif)): ?>
                <div class="alert alert-<?php echo $notif["jenis"]; ?>"><?php echo $notif["pesan"] ?></div>
            <?php endif; ?>

            <div class="page-header">
                <h3>Status Pengadaan : <span class="<?php echo $status["class"]; ?>"><?php echo $status["pesan"]; ?></span></h3>
            </div>
            <div class="panel-group" id="accordion">
                <?php foreach ($daftarLelang as $index => $single): ?>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $index; ?>">
                                    <u><?php echo $single['judul_lelang'] . " - " . $single['nama_customer']; ?></u>
                                </a>
                            </h4>
                        </div>
                        <div id="collapse<?php echo $index; ?>" class="panel-collapse collapse">
                            <div class="panel-body">
                                <div class="form-group">
                                    <dl>
                                        <dt>Deskripsi</dt>
                                        <dd><?php echo $single['deskripsi']; ?></dd>
                                        <dt>Nama Barang</dt>
                                        <dd><?php echo $single['nama_barang']; ?></dd>
                                        <dt>Jumlah</dt>
                                        <dd><?php echo $single['jumlah']; ?></dd>
                                    </dl>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-1 col-md-offset-9">
                                        <a href="<?php echo site_url() . "lelang/detail/" . $this->encrypt->encode($single['id']); ?>" class="btn btn-primary">Lihat Pengadaan</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>