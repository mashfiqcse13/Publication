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





<div id="table_custom" style="background:#ddd">



    <div class="container memo_print_option" style="background:#fff;width:585px;min-height:793px;padding:25px 40px;margin-top:30px;font-size:15px;margin:10px auto;box-shadow:0px -1px 8px #000;" >





        <div class="row" style="padding-top:50px">

<!--            <div class="text-center" style="display:none">

                <h6>বিসমিল্লাহির রহমানির রহিম</h6>

                <h1>দি যমুনা পাবলিশার্স</h1>

                <p>৩৮,বাংলাবাজার(১ম তলা) ঢাকা-১১০০ । ফোন- ৭১১৬০৬৯  </p>

                <p style="font-size:10px">সাধারন তথ্য :- ০১৭১১-৮৯৮৮৮৭ । ব্যবসায়িক তথ্য :- ০১৭১৯-৭০৫৫৬৮ । বিক্রয় কেন্দ্র :- ০১৭২৮-৮৪৮৫২৩</p>

            </div>-->

        </div>



        <div class="row" style="font-size:16px;">


            <?php echo $old_book_rebind_table; ?>



        </div>



        <div class="margin-top-10">

            <a href="<?= site_url('old_book/return_book_sale_list') ?>" class="only_print btn btn-primary "><i class="fa fa-dashboard"></i> Dashboard</a>

            <a href="<?php echo site_url('old_book/return_book_sale') ?>" class="only_print btn btn-primary "><i class="fa fa-pencil"></i> New Entry</a>

            <input class="only_print pull-right btn btn-primary" type="button"  onClick="window.print()"  value="Print This Page"/>

        </div>







    </div>

</div>



