<li class="header">MAIN NAVIGATION</li>
    <?php if ($_SESSION['user_id'] == 3) { ?>

    <li><?php echo anchor('sales', '<i class="fa fa-plus-circle"></i>  <span>Sale</span>'); ?></li>
    <li><?php echo anchor('sales_return', '<i class="fa fa-plus-circle"></i>  <span>Sale Return</span>'); ?></li>
    <li><?php echo anchor('specimen', '<i class="fa fa-plus-circle"></i>  <span>Specimen</span>'); ?></li>
    <li><?php echo anchor('due', '<i class="fa fa-plus-circle"></i>  <span>Customer Due</span>'); ?></li>
    <li><?php echo anchor('contacts', '<i class="fa fa-plus-circle"></i>  <span>Contacts</span>'); ?></li>
    <li><?php echo anchor('items', '<i class="fa fa-plus-circle"></i>  <span>Items</span>'); ?></li>
    <li><?php echo anchor('stock', '<i class="fa fa-plus-circle"></i>  <span>Stock</span>'); ?></li>
    <li><?php echo anchor('login/logout', '<i class="fa fa-sign-out"></i> <span>Log Out</span>'); ?></li>

<?php } else { ?>
    <li><?php echo anchor('sales', '<i class="fa fa-plus-circle"></i>  <span>Sale</span>'); ?></li>
    <li><?php echo anchor('sales_return', '<i class="fa fa-plus-circle"></i>  <span>Sale Return</span>'); ?></li>
    <li><?php echo anchor('specimen', '<i class="fa fa-plus-circle"></i>  <span>Specimen</span>'); ?></li>
    <li><?php echo anchor('due', '<i class="fa fa-plus-circle"></i>  <span>Customer Due</span>'); ?></li>
    <li><?php echo anchor('advance_payment', '<i class="fa fa-plus-circle"></i>  <span>Advance Payment</span>'); ?></li>
    <li><?php echo anchor('advance_payment/payment_log', '<i class="fa fa-plus-circle"></i>  <span>Payment Log</span>'); ?></li>
    <li><?php echo anchor('sold_book_info', '<i class="fa fa-plus-circle"></i>  <span>Sold Book Info</span>'); ?></li>
    <li><?php echo anchor('old_book', '<i class="fa fa-plus-circle"></i>  <span>Old Book Section</span>'); ?></li>
    <li><?php echo anchor('production_process', '<i class="fa fa-plus-circle"></i>  <span>Production Process</span>'); ?></li>
    <li><?php echo anchor('stock', '<i class="fa fa-plus-circle"></i>  <span>Stock</span>'); ?></li>
    <li><?php echo anchor('items', '<i class="fa fa-plus-circle"></i>  <span>Items</span>'); ?></li>
    <li><?php echo anchor('contacts', '<i class="fa fa-plus-circle"></i>  <span>Contacts</span>'); ?></li>
    <li><?php echo anchor('bank', '<i class="fa fa-plus-circle"></i>  <span>Bank</span>'); ?></li>
    <li><?php echo anchor('income', '<i class="fa fa-plus-circle"></i>  <span>Income</span>'); ?></li>
    <li><?php echo anchor('expense', '<i class="fa fa-plus-circle"></i>  <span>Expense</span>'); ?></li>
    <li><?php echo anchor('stationary_stock', '<i class="fa fa-plus-circle"></i>  <span>Stationary Stock</span>'); ?></li>
    <li><?php echo anchor('employee', '<i class="fa fa-plus-circle"></i>  <span>Employee</span>'); ?></li>
    <li><?php echo anchor('salary', '<i class="fa fa-plus-circle"></i>  <span>Salary</span>'); ?></li>
    <li><?php echo anchor('loan', '<i class="fa fa-plus-circle"></i>  <span>Loan</span>'); ?></li>
    <li><?php echo anchor('report', '<i class="fa fa-plus-circle"></i>  <span>Report</span>'); ?></li>
    <li><?php echo anchor('users_info', '<i class="fa fa-plus-circle"></i>   <span>Users</span>'); ?></li>
    <!--<li><?php echo anchor('admin', '<i class="fa fa-plus-circle"></i>  <span>Old system</span>'); ?></li>-->
    <li><?php echo anchor('login/logout', '<i class="fa fa-sign-out"></i>     <span>Log Out</span>'); ?></li>
<?php } ?>