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
    foreach ($all_menu_items as $menu_item) {
        echo "<li>" . anchor($menu_item->ci_url, $menu_item->main_menu_item_content) . "</li>";
    }
    ?>
<li><?php echo anchor('login/logout', '<i class="fa fa-sign-out"></i>     <span>Log Out</span>'); ?></li>