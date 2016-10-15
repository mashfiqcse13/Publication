<!--add header -->

<?php include_once __DIR__ . '/../header.php'; ?>



<!-- Left side column. contains the logo and sidebar -->



<!-- Content Wrapper. Contains page content -->



<style>
    #table_custom .table td.separator {
        background: black none repeat scroll 0 0;
        height: 3px;
        padding: 0;
    }
    #table_custom .table td.left_separator {
        border-left: 2px solid;
        font-weight: bold;
        text-align: right;
    }
</style>




    <div class="container memo_print_option custom_memo" >

     <div class="only_print padding10"></div>

        <div class="row" style="font-size:14px;">
            <?php echo $old_book_rebind_table; ?>
        </div>

        <div class="margin-top-10">

            <a href="<?= site_url('old_book/return_book_sale_list') ?>" class="only_print btn btn-primary "><i class="fa fa-dashboard"></i> Dashboard</a>

            <a href="<?php echo site_url('old_book/return_book_sale') ?>" class="only_print btn btn-primary "><i class="fa fa-pencil"></i> New Entry</a>

            <input class="only_print pull-right btn btn-primary" type="button"  onClick="window.print()"  value="Print This Page"/>

        </div>
     <div class="only_print padding10"></div>

    </div>

</div>



