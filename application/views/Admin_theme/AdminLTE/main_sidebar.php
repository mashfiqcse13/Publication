<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="http://friendsitltd.com/wp-content/uploads/2015/09/small-3512-7607823.png" class="img-circle" alt="User Image" />
            </div>
            <div class="pull-left info">
                <p>The Jamuna <br>Publishers MGMT</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            <li class="treeview active">
                <a href="#">
                    <i class="fa fa-envelope"></i> <span>Memo Management</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?= site_url('admin/memo_management/add') ?>"><i class="fa fa-plus-circle"></i>Add memo</a></li>
                    <li><a href="<?= site_url('admin/memo_management') ?>"><i class="fa fa-cog"></i>Memo Management</a></li>
                    <li><a href="<?= site_url('admin/memo') ?>"><i class="fa fa-print"></i>memo</a></li>
                </ul>
            </li>


            <li><a href="<?= site_url('admin/manage_stock') ?>"><i class="fa fa-file"></i> Stock Management</a></li>
            <li class="treeview active">
                <a href="#">
                    <i class="fa fa-book"></i> <span>Book Management</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?= site_url('admin/manage_book/add') ?>"><i class="fa fa-plus-circle"></i>Add New Book</a></li>
                    <li><a href="<?= site_url('admin/manage_book') ?>"><i class="fa fa-cogs"></i>Book Management</a></li>
                </ul>
            </li>
            <li class="treeview active">
                <a href="#">
                    <i class="fa fa-phone-square"></i> <span>Contact Management</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?= site_url('admin/manage_contact/add') ?>"><i class="fa fa-plus-circle"></i>Add New Contact</a></li>
                    <li><a href="<?= site_url('admin/manage_contact') ?>"><i class="fa fa-group"></i> Contact Management</a></li>
                </ul>
            </li>
            <li><a href="<?= site_url('admin/account') ?>"><i class="fa fa-cog"></i>Account Information</a></li>
            <li><?php echo anchor('login/logout', '<i class="fa fa-sign-out"></i><span>Log Out</span>'); ?></li>

        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
