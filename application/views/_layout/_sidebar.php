<?php $aktif = $this->uri->segment(1); ?>
<ul class="sidebar-menu" data-widget="tree">
    <li class="header">MENU UTAMA</li>
    <li class = "<?php echo activate_menu('Beranda')?>"><a href="<?= base_url()?>Beranda"><i class="fa fa-dashboard"></i> <span>Beranda</span><span class="pull-right-container"></span></a></li>
    <li class="treeview <?php if ($aktif == 'Perhitungan' || $aktif == 'Dataset') echo 'active' ?>">
        <a href="#"><i class="fa fa-database"></i> <span>Master Data</span>
            <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
        </a>
        <ul class="treeview-menu">
            <li class = "<?php echo activate_menu('Dataset')?>"><a href="<?= base_url()?>Dataset"><i class="fa fa-circle-o"></i>Dataset</a></li>
            <li class = "<?php echo activate_menu('Perhitungan')?>"><a href="<?= base_url()?>Perhitungan"><i class="fa fa-circle-o"></i>Perhitungan</a></li>
        </ul>
    </li>
</ul>