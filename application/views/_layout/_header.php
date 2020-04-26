<?php $masuk = $this->db->get_where('users',['id'=> $this->session->userdata('id')])->row_array();?>
<a href="../../index2.html" class="logo">
    <span class="logo-mini"><b>F</b>CM</span>
    <span class="logo-lg"><b>Fuzzy</b> C-Means</span>
</a>
<nav class="navbar navbar-static-top">
    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
    <span class="sr-only">Toggle navigation</span>
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
    </a>
    <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
            <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <img src="<?php echo base_url('assets/dist/img/').$masuk['gambar']?>" class="user-image" alt="User Image">
                    <span class="hidden-xs"> <?php echo $masuk['name']?></span>
                </a>
                <ul class="dropdown-menu">
                    <li class="user-header">
                        <img src="<?php echo base_url('assets/dist/img/').$masuk['gambar']?>" class="img-circle" alt="User Image">
                        <p> <?php echo $masuk['name']?></p>
                    </li>
                    <li class="user-footer">
                        <div class="pull-left">
                            
                        </div>
                        <div class="pull-right">
                            <a href="<?php echo base_url('Auth/logout')?>" class="btn btn-default btn-flat">Sign out</a>
                        </div>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
