<aside class="main-sidebar only_print">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= base_url() ?>/asset/img/jamuna logo.gif" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p>The Jamuna <br>Publishers MGMT</p>
                <!--<a href="#"><i class="fa fa-circle text-success"></i> Online</a>-->
            </div>
        </div>
        <!--        <ul class="sidebar-menu">
                    <li class="header">MAIN NAVIGATION</li>
                    <li class="treeview active">
                        <a href="#">
                            <i class="fa fa-envelope"></i> <span>Memo Management</span> <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="<?= site_url('admin/memo_management/add') ?>"><i class="fa fa-plus-circle"></i>Add memo</a></li>
                            <li><a href="<?= site_url('admin/memo_management') ?>"><i class="fa fa-cog"></i>Memo Management</a></li>
                        </ul>
                    </li>
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
                </ul>-->
        <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            <li><?php echo anchor('admin/memo_management/add', '<i class="fa fa-plus-circle"></i>  <span>New Memo</span>'); ?></li>
            <li><?php echo anchor('admin/memo_management', '<i class="fa fa-cog"></i>          <span>Memo Management</span>'); ?></li>
            <li><?php echo anchor('admin/add_stock', '<i class="fa fa-plus-circle"></i>         <span>New Stock Order</span>'); ?></li>
            <li><?php echo anchor('admin/manage_stocks', '<i class="fa fa-file"></i>         <span>Stock Management</span>'); ?></li>
            <li><?php echo anchor('admin/manage_book', '<i class="fa fa-book"></i>         <span>Book Management</span>'); ?></li>
            <li><?php echo anchor('admin/return_book_dashboard', '<i class="fa fa-cog"></i>          <span>Book Return</span>'); ?></li>
<!--            <li><?php //echo anchor('admin/send_book_rebind', '<i class="fa fa-cog"></i>          <span>Send Book to Rebind</span>'); ?></li>-->
            <li><?php echo anchor('admin/manage_contact', '<i class="fa fa-group"></i>        <span>Contact Management</span>'); ?></li>
            <li><?php echo anchor('admin/due_management', '<i class="fa fa-cog"></i>          <span>Dues Management</span>'); ?></li>
            <li><?php echo anchor('admin/account', '<i class="fa fa-calculator"></i>   <span>Account Information</span>'); ?></li>
            <li><?php echo anchor('admin/report_sold_book_today', '<i class="fa fa-calculator"></i>   <span>Sold Book Information</span>'); ?></li>
            <li><?php echo anchor('login/logout', '<i class="fa fa-sign-out"></i>     <span>Log Out</span>'); ?></li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
