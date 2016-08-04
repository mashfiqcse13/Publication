<aside class="main-sidebar only_print">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= base_url() ?>/asset/img/<?= $this->config->item('SITE')['logo'] ?>" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p><?= $this->config->item('main_sidebar_title') ?></p>
                <!--<a href="#"><i class="fa fa-circle text-success"></i> Online</a>-->
            </div>
        </div>
        <ul class="sidebar-menu">
            
            
            <li class="header">STOCK CRUD s</li>
            
           
            
            <li><?php echo anchor('users_info/user_list', '<i class="fa fa-plus-circle"></i>  <span>Users List</span>'); ?></li>
           <li><?php echo anchor('users_info/user_access_area', '<i class="fa fa-plus-circle"></i>  <span>Users Access Area</span>'); ?></li>
           <li><?php echo anchor('users_info/user_access_group', '<i class="fa fa-plus-circle"></i>  <span>Users Access Group Add</span>'); ?></li>
           <li><?php echo anchor('users_info/user_access_group_list', '<i class="fa fa-plus-circle"></i>  <span>Users Access Group List</span>'); ?></li>
           <li><?php echo anchor('users_info/user_group_element', '<i class="fa fa-plus-circle"></i>  <span>Users Group Element</span>'); ?></li>
           
           
            <?php $this->load->view($this->config->item('ADMIN_THEME') . 'sidebar_common'); ?>
           
            
        </ul>
            
    </section>
    <!-- /.sidebar -->
</aside>