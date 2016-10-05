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


            <li class="header">CONTACTS NAVIGATION</li>



            <?php
            $super_user_id = $this->config->item('super_user_id');
            if ($super_user_id == $_SESSION['user_id']) {
                echo "<li>" . anchor('contacts', '<i class="fa fa-plus-circle"></i>  <span>Customers</span>') . "</li>";
                echo "<li>" . anchor('contacts/teacher', '<i class="fa fa-plus-circle"></i>  <span>Teachers</span>') . "</li>";
                echo "<li>" . anchor('contacts/agents', '<i class="fa fa-plus-circle"></i>  <span>Agents</span>') . "</li>";
                echo "<li>" . anchor('contacts/marketing_officer', '<i class="fa fa-plus-circle"></i>  <span>Marketing Officer</span>') . "</li>";
            } else {
                if ($this->User_access_model->if_user_has_permission(29)) {
                    echo "<li>" . anchor('contacts', '<i class="fa fa-plus-circle"></i>  <span>Customers</span>') . "</li>";
                }
                if ($this->User_access_model->if_user_has_permission(28)) {
                    echo "<li>" . anchor('contacts/teacher', '<i class="fa fa-plus-circle"></i>  <span>Teachers</span>') . "</li>";
                    echo "<li>" . anchor('contacts/teacher_sucject', '<i class="fa fa-plus-circle"></i>  <span>Teacher Subject</span>') . "</li>";
                }
                if ($this->User_access_model->if_user_has_permission(30)) {
                    echo "<li>" . anchor('contacts/agents', '<i class="fa fa-plus-circle"></i>  <span>Agents</span>') . "</li>";
                }
                if ($this->User_access_model->if_user_has_permission(31)) {
                    echo "<li>" . anchor('contacts/marketing_officer', '<i class="fa fa-plus-circle"></i>  <span>Marketing Officer</span>') . "</li>";
                }
            }
            ?>


            <?php $this->load->view($this->config->item('ADMIN_THEME') . 'sidebar_common'); ?>


        </ul>

    </section>
    <!-- /.sidebar -->
</aside>