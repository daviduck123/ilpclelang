<div> 
    <div class="col-md-2">
        <div class="panel panel-default">
            <div class="panel-body">
                <p>Hello, <span class="<?php echo ($status == "1") ? "red" : ""; ?>"><strong><?php echo $nama; ?></strong></span></p>
                <ul class="nav nav-pills nav-stacked">
                    <li <?php echo ($this->uri->segment(2) == NULL) ? "class='active'" : '' ?>><a href="<?php echo site_url() ?>panitia"><span class="glyphicon glyphicon-home"></span> Home</a></li>
                    <li <?php echo ($this->uri->segment(2) == "pos") ? "class='active'" : '' ?>><a href="<?php echo site_url() ?>panitia/pos"><span class="glyphicon glyphicon-list-alt"></span> Pos</a></li>
                    <li <?php echo ($this->uri->segment(2) == "ijin") ? "class='active'" : '' ?>><a href="<?php echo site_url() ?>panitia/ijin"><span class="glyphicon glyphicon-cog"></span> Ijin Peserta</a></li>
                    <li <?php echo ($this->uri->segment(2) == "season") ? "class='active'" : '' ?>><a href="<?php echo site_url() ?>panitia/season"><span class="glyphicon glyphicon-cloud"></span> Season</a></li>
                    <li <?php echo ($this->uri->segment(2) == "customer") ? "class='active'" : '' ?>><a href="<?php echo site_url() ?>panitia/customer"><span class="glyphicon glyphicon-usd"></span> Customer</a></li>
                    <li <?php echo ($this->uri->segment(2) == "lelang") ? "class='active'" : '' ?>><a href="<?php echo site_url() ?>panitia/lelang"><span class="glyphicon glyphicon-file"></span> Lelang</a></li>
                    <li <?php echo ($this->uri->segment(2) == "news") ? "class='active'" : '' ?>><a href="<?php echo site_url() ?>panitia/news"><span class="glyphicon glyphicon-share"></span> News</a></li>
                    <li <?php echo ($this->uri->segment(2) == "peserta") ? "class='active'" : '' ?>><a href="<?php echo site_url() ?>panitia/peserta"><span class="glyphicon glyphicon-cog"></span> Login Peserta</a></li>
                    <li <?php echo ($this->uri->segment(2) == "chat") ? "class='active'" : '' ?>><a href="<?php echo site_url() ?>panitia/chat"><span class="glyphicon glyphicon-comment"></span> Chat Intern</a></li>
                    <li <?php echo ($this->uri->segment(2) == "change") ? "class='active'" : '' ?>><a href="<?php echo site_url() ?>panitia/change"><span class="glyphicon glyphicon-edit"></span> Password</a></li>
                    <?php if ($status == "1"): ?>
                        <li class="dropdown <?php echo ($this->uri->segment(2) == "username") ? "active" : '' ?>"><a href="<?php echo site_url() ?>panitia/username"><span class="glyphicon glyphicon-star"></span> Login Panitia</a></li>
                        <li class="dropdown <?php echo ($this->uri->segment(2) == "jenis_pos") ? "active" : '' ?>"><a href="<?php echo site_url() ?>panitia/jenis_pos"><span class="glyphicon glyphicon-star"></span> Jenis Pos</a></li>
                        <li class="dropdown <?php echo ($this->uri->segment(2) == "wewenang") ? "active" : '' ?>"><a href="<?php echo site_url() ?>panitia/wewenang"><span class="glyphicon glyphicon-star"></span> Wewenang Pos</a></li>
                        <li class="dropdown <?php echo ($this->uri->segment(2) == "barang") ? "active" : '' ?>"><a href="<?php echo site_url() ?>panitia/barang"><span class="glyphicon glyphicon-star"></span> Barang</a></li>
                        <li class="dropdown <?php echo ($this->uri->segment(2) == "rekap") ? "active" : '' ?>"><a href="<?php echo site_url() ?>panitia/rekap"><span class="glyphicon glyphicon-star"></span> Rekap</a></li>
                    <?php endif; ?>
                    <li><a href="<?php echo site_url() ?>login/logoutPanitia"><span class="glyphicon glyphicon-log-out"></span> Log out</a></li>
                </ul>
                <script>$('.dropdown-toggle').dropdown()</script>
            </div>
        </div>
    </div>
    <div class="col-md-10">
