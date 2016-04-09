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
            
            <li><?php echo anchor('salary/salary_payment', '<i class="fa fa-plus-circle"></i>  <span>Salary Payment</span>'); ?></li>
            
            <li><?php echo anchor('salary/salary_bonus', '<i class="fa fa-plus-circle"></i>  <span>Salary Bonus</span>'); ?></li>
       
            <li><?php echo anchor('salary/salary_bonus_type', '<i class="fa fa-plus-circle"></i>  <span>Salary Bonus Type</span>'); ?></li>
            
            <li><?php echo anchor('salary/salary_advanced', '<i class="fa fa-plus-circle"></i>  <span>Salary Advance</span>'); ?></li>
            
            
            
            <li class="header">MAIN NAVIGATION</li>
            
            <li><?php echo anchor('admin/', '<i class="fa fa-plus-circle"></i>  <span>Main Dashboard</span>'); ?></li>
            <li><?php echo anchor('loan/', '<i class="fa fa-plus-circle"></i>  <span>Loan</span>'); ?></li>
            <li><?php echo anchor('expense/', '<i class="fa fa-plus-circle"></i>  <span>Expense</span>'); ?></li>
            <li><?php echo anchor('income/', '<i class="fa fa-plus-circle"></i>  <span>Income</span>'); ?></li>
            <li><?php echo anchor('bank/', '<i class="fa fa-plus-circle"></i>  <span>Bank</span>'); ?></li>
            
            
        </ul>
            
    </section>
    <!-- /.sidebar -->
</aside>
