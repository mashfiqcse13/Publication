<aside class="main-sidebar only_print">
    <section class="sidebar">
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= base_url() ?>/asset/img/<?= $this->config->item('SITE')['logo'] ?>" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p><?= $this->config->item('main_sidebar_title') ?></p>
            </div>
        </div>
        <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            <li><?php echo anchor('admin/memo_management/add', '<i class="fa fa-plus-circle"></i>  <span>New Memo</span>'); ?></li>
            <li><?php echo anchor('admin/memo_management', '<i class="fa fa-cog"></i>          <span>Memo Management</span>'); ?></li>
            <li><?php echo anchor('admin/add_stock', '<i class="fa fa-plus-circle"></i>         <span>New Stock Order</span>'); ?></li>
            <li><?php echo anchor('admin/manage_stocks', '<i class="fa fa-file"></i>         <span>Stock Management</span>'); ?></li>
            <li><?php echo anchor('admin/stock_transfer_log', '<i class="fa fa-file"></i>         <span>Stock Transfer Log</span>'); ?></li>
            <li><?php echo anchor('admin/manage_book', '<i class="fa fa-book"></i>         <span>Book Management</span>'); ?></li>
            <li><?php echo anchor('admin/return_book_dashboard', '<i class="fa fa-cog"></i>          <span>Book Return</span>'); ?></li>
            <li><?php echo anchor('admin/manage_contact', '<i class="fa fa-group"></i>        <span>Contact Management</span>'); ?></li>
            <li><?php echo anchor('admin/cost', '<i class="fa fa-cog"></i>          <span>Office Cost Management</span>'); ?></li>
            <li><?php echo anchor('admin/due_management', '<i class="fa fa-cog"></i>          <span>Dues Management</span>'); ?></li>
            <li><?php echo anchor('admin/account', '<i class="fa fa-calculator"></i>   <span>Account Information</span>'); ?></li>
            <li><?php echo anchor('admin/report_sold_book_today', '<i class="fa fa-calculator"></i>   <span>Sold Book Information</span>'); ?></li>
            
            <?php $this->load->view($this->config->item('ADMIN_THEME') . 'sidebar_common'); ?>
        </ul>
    </section>
</aside>
