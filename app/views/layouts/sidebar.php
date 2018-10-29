<!-- sidebar menu area start -->
<div class="sidebar-menu">
    <div class="sidebar-header">
        <div class="logo">
            <a href="<?php echo base_url('?p=dashboard') ?>">
                <img style="
                    max-width: 60px;
                    max-height: 60px;
                " src="<?php echo base_url('assets/images/logo/smadara.png') ?>" alt="logo">
            </a>
            <h5 style="margin-top: 10px; color: #fff">Sistem Informasi Managemen Kuesioner</h5>
        </div>
    </div>
    <div class="main-menu">
        <div class="menu-inner">
            <nav>
                <ul class="metismenu" id="menu">
                    <li <?php if(Input::get('p') == 'dashboard') echo 'class="active"'; ?>><a href="<?php echo base_url('?p=dashboard') ?>"><i class="ti-dashboard"></i> <span>dashboard</span></a></li>
                    <li <?php if(Input::get('p') == 'kuesioner') echo 'class="active"'; ?>>
                        <a href="javascript:void(0)" aria-expanded="true"><i class="ti-book"></i><span>Kuesioner</span></a>
                        <ul class="collapse">
                            <li <?php if(Input::get('act') == 'insert') echo 'class="active"'; ?>><a href="<?php echo base_url('?p=kuesioner&act=insert') ?>">Tambah Kuesioner</a></li>
                            <li <?php if(Input::get('act') == 'archive') echo 'class="active"'; ?>><a href="<?php echo base_url('?p=kuesioner&act=archive') ?>">Arsip Kuesioner</a></li>
                        </ul>
                    </li>
                    <li <?php if(Input::get('p') == 'semester') echo 'class="active"'; ?>><a href="<?php echo base_url('?p=semester') ?>"><i class="ti-agenda"></i> <span>Semester</span></a></li>
                </ul>
            </nav>
        </div>
    </div>
</div>
<!-- sidebar menu area end -->