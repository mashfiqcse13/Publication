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


            <li class="header">SALE CRUD s</li>

            <li><?php echo anchor('sales/new_sale', '<i class="fa fa-plus-circle"></i>  <span>New Sale</span>'); ?></li>
            <!--<li><?php echo anchor('sales/sales', '<i class="fa fa-plus-circle"></i>  <span>Sales</span>'); ?></li>-->
            <li><?php echo anchor('sales/tolal_sales', '<i class="fa fa-plus-circle"></i>  <span>Sale Dashboard</span>'); ?></li>
             <li><?php echo anchor('sales/slip', '<i class="fa fa-plus-circle"></i>  <span>Slip</span>'); ?></li>

            
            <?php $this->load->view($this->config->item('ADMIN_THEME') . 'sidebar_common'); ?>


        </ul>

    </section>
    <!-- /.sidebar -->
</aside>
