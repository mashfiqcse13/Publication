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
            
            
            <li class="header">SALARY CRUD s</li>
            
            <li><?php echo anchor('salary/salary_bonus_type', '<i class="fa fa-plus-circle"></i>  <span>Bonus Type</span>'); ?></li>
            
            <li><?php echo anchor('salary/salary_bonus_announcement', '<i class="fa fa-plus-circle"></i>  <span>Bonus Announcement</span>'); ?></li>
                                   
            <li><?php echo anchor('salary/salary_announced', '<i class="fa fa-plus-circle"></i>  <span>Salary Announcement</span>'); ?></li>
            
            <li><?php echo anchor('salary/salary_advanced', '<i class="fa fa-plus-circle"></i>  <span>Salary Advance</span>'); ?></li>
            
            <li><?php echo anchor('salary/salary_payment', '<i class="fa fa-plus-circle"></i>  <span>Salary Payment</span>'); ?></li>
            
            <li><?php // echo anchor('salary/salary_bonus', '<i class="fa fa-plus-circle"></i>  <span>Salary Bonus</span>'); ?></li>
       
            <li><?php echo anchor('salary/current_salary_payment', '<i class="fa fa-plus-circle"></i>  <span>Salary Payslip</span>'); ?></li>
            
            <li><?php echo anchor('salary/total_salary_paid', '<i class="fa fa-plus-circle"></i>  <span>Salary Payment Report</span>'); ?></li>
            
            <li><?php echo anchor('salary/total_employee_paid', '<i class="fa fa-plus-circle"></i>  <span>Total Salary Paid</span>'); ?></li>
            
            
            
            
            <?php $this->load->view($this->config->item('ADMIN_THEME') . 'sidebar_common'); ?>
            
            
        </ul>
            
    </section>
    <!-- /.sidebar -->
</aside>
