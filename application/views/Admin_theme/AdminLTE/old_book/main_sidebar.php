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


            <li class="header">Old Book Section</li>
            <li><?php echo anchor('old_book/old_book_dashboard', '<i class="fa fa-plus-circle"></i>  <span>Old Book Dashboard</span>'); ?></li>
            
            <li><?php echo anchor('old_book/return_book', '<i class="fa fa-plus-circle"></i>  <span>Old Book Return</span>'); ?></li>
            <!--<li><?php echo anchor('old_book/old_book_sales', '<i class="fa fa-plus-circle"></i>  <span>Old Book Sales</span>'); ?></li>-->
            <li><?php echo anchor('old_book/old_book_rebind', '<i class="fa fa-plus-circle"></i>  <span>Old Book Rebind</span>'); ?></li>

            
            <?php $this->load->view($this->config->item('ADMIN_THEME') . 'sidebar_common'); ?>


        </ul>

    </section>
    <!-- /.sidebar -->
</aside>
