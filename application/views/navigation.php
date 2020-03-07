<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="navbar-inner">
        <div class="container-fluid">
            <a class="brand pull-left" href="<?php echo base_url('dashboard');?>"><img src="<?php echo base_url('assets/theme/');?>/img/gCons/bar-chart.png" alt="" />   <strong>SIMANDA</strong></a>
            <ul class="nav navbar-nav">
                <!-- PEMDA-->
                <li><a href="<?php echo base_url('dashboard');?>"><i class="splashy-home_green"></i> Beranda</a></li>
                <?php if($this->session->userdata('user_type') != 'KEM' and $this->session->userdata('level') == 'N')  { ?>
                <li><a href="<?php echo base_url('pinjaman/create');?>"><i class="splashy-document_a4_marked"></i> Pengajuan Pertimbangan</a></li>
                <?php } ?>
                <li><a href="<?php echo base_url('pinjaman');?>"><i class="splashy-view_list"></i> Pencarian</a></li>
                <li><a href="<?php echo base_url('assets/panduan/kak.xlsx');?>" target="blank"><i class="splashy-application_windows_add"></i> Unduh Form KAK</a></li>
                <li><a href="<?php echo base_url('assets/panduan/panduan.pdf');?>" target="blank"><i class="splashy-information"></i> Dasar Hukum dan Panduan</a></li>
               
               <!-- STAF PENGELOLA KEMENDAGRI-->
                <?php if($this->session->userdata('user_type') == 'KEM' and $this->session->userdata('level') == 'N')  { ?>
                <li class="dropdown">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#"><i class="splashy-view_table"></i> Data Rekap <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo base_url('listpertimbangan');?>"><i class="splashy-group_blue"></i>Rekap Hasil Pertimbangan Mendagri</a></li>
                        <li><a href="<?php echo base_url('profile/pusat');?>"><i class="splashy-contact_blue_add"></i>Rekap Kegiatan Sesuai Urusan</a></li>
                        <li class="divider"></li>
                        <li><a href="<?php echo base_url('persyaratan');?>"><i class="splashy-contact_blue_add"></i> Rekap Laporan Kumulatif</a></li>
                    </ul>
                </li>
                <?php } ?>
                <?php if($this->session->userdata('level') == 'Y') { ?>
                <!-- ADMIN-->
                <li class="dropdown">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#"><i class="splashy-sprocket_light"></i> Pengaturan <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo base_url('profile');?>"><i class="splashy-group_blue"></i> Users Daerah</a></li>
                        <li><a href="<?php echo base_url('profile/pusat');?>"><i class="splashy-contact_blue_add"></i> Admin Pusat</a></li>
                        <li class="divider"></li>
                        <li><a href="<?php echo base_url('persyaratan');?>"><i class="splashy-contact_blue_add"></i> Master Persyaratan</a></li>
                        <li><a href="<?php echo base_url('status');?>"><i class="splashy-contact_blue_add"></i> Master Status</a></li>
                        <li><a href="<?php echo base_url('urusan');?>"><i class="splashy-contact_blue_add"></i> Master Urusan</a></li>
                        <li><a href="<?php echo base_url('daerah');?>"><i class="splashy-contact_blue_add"></i> Master Daerah</a></li>
                        <li><a href="<?php echo base_url('kategori');?>"><i class="splashy-contact_blue_add"></i> Master Kategori</a></li>
                    </ul>
                </li>
                <?php } ?>
            </ul>
            <ul class="nav navbar-nav user_menu pull-right">
                <li class="dropdown">
                    <a href="#"><?php echo $this->session->userdata('whoami'); ?></a>
                </li>
                <li class="divider-vertical hidden-sm hidden-xs"></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src="<?php echo $this->config->item("theme"); ?>img/user_avatar.png" alt="" class="user_avatar"><?php echo $this->session->userdata('nama_lengkap'); ?> <b class="caret"></b></a>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <li><a href="<?php echo base_url('profile/detail/kabkot/'.$this->session->userdata('usrcd'));?>"><i class="splashy-contact_blue"></i>Profile</a></li>
                        <li><a href="<?php echo base_url('api/changepassword');?>"><i class="splashy-lock_large_unlocked"></i> Ganti Password</a></li>
                        <li class="divider"></li>
                        <li><a href="<?php echo base_url('login/logout');?>"><i class="splashy-gem_remove"></i> Log Out</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>