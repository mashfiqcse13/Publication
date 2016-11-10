<li class="header">MAIN NAVIGATION</li>
    <?php
    $super_user_id = $this->config->item('super_user_id');
    if ($super_user_id == $_SESSION['user_id']) {
        $sql = "SELECT * FROM  `user_access_area` WHERE  `serial_id` !=0 ORDER BY  `serial_id` ASC ";
    } else {
        $this->load->model('User_access_model');
        $all_allowed_access_area_coma_separated = implode(",", $this->User_access_model->get_all_access_area_by_user_id());
        $sql = "SELECT * FROM  `user_access_area` WHERE  `serial_id` != 0 and `id_user_access_area` in ($all_allowed_access_area_coma_separated) ORDER BY  `serial_id` ASC ";
    }
    $all_menu_items = $this->db->query($sql)->result();
    $access_group = $this->db->get_where('user_access_area_permission', array('user_id'=> $_SESSION['user_id']))->row();
    if ($access_group->id_user_access_group == '3' && $this->config->item('custom_user_menu') == 1) {
        $this->load->view($this->config->item('ADMIN_THEME') . 'speciman_menu');
    } else {
        foreach ($all_menu_items as $menu_item) {
            echo "<li>" . anchor($menu_item->ci_url, $menu_item->main_menu_item_content) . "</li>";
        }
    }
    ?>
<li><?php echo anchor('login/logout', '<i class="fa fa-sign-out"></i>     <span>Log Out</span>'); ?></li>