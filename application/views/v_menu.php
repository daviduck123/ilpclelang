
<div class="container bs-docs-container">
    <div class="row">
        <div class="col-md-3">
            <div class="well well-sm">
                <h3>Selamat Datang, <?php echo $nama; ?></h3>
                <h5>Saldo Uang anda : <span id="uangPeserta"><b><?php echo number_format($uang); ?></b></span></h5>
            </div>
            <div class="bs-sidebar hidden-print" role="complementary">
                <ul class="nav bs-sidenav">
                    <li <?php echo ($this->uri->segment(1) == "home") ? "class='active'" : '' ?>><a href="<?php echo base_url(); ?>home">Home</a></li>
                    <li <?php echo ($this->uri->segment(1) == "stok") ? "class='active'" : '' ?>><a href="<?php echo base_url(); ?>stok">Stok Saya</a></li>
                    <li <?php echo ($this->uri->segment(1) == "lelang") ? "class='active'" : '' ?>><a href="<?php echo base_url(); ?>lelang">Lelang</a></li>
                    <li><a href="<?php echo base_url(); ?>login/logout">Log Out</a></li>
                </ul>
            </div>
        </div>
        <div class="col-md-9" role="main">