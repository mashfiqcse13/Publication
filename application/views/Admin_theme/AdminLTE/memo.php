<!--add header -->
<?php include_once 'header.php'; ?>

<!-- Left side column. contains the logo and sidebar -->

<!-- Content Wrapper. Contains page content -->





<div class="container memo_print_option" style="background:#fff;width:750px;padding:25px 100px;margin-top:30px;" >

    <div class="row">
        <div class="pull-right">
            <p>Date:<?php echo " " . date("Y-m-d") ?></p>
            <p></p>
        </div>
    </div>
    <div class="row">
        <div class="pull-left">
            <h3>দি যমুনা পাবলিশার্স</h3>
            <p>৩৮,বাংলাবাজার(১ম তলা) <br>
                ঢাকা-১১০০ <br>
                ফোন- ৭১১৬০৬৯ <br>
                সাধারন তথ্য :- ০১৭১১-৮৯৮৮৮৭ <br>
                ব্যবসায়িক তথ্য :- ০১৭১৯-৭০৫৫৬৮ <br>
                বিক্রয় কেন্দ্র :- ০১৭২৮-৮৪৮৫২৩</p> <br>
        </div>
        <div class="pull-right">
            <h3><?= $Book_selection_table['party_name'] ?></h3>
            <p><?= $Book_selection_table['phone'] ?><br>
                <?= $Book_selection_table['address'] ?><br>
                <?= $Book_selection_table['district'] ?><br>
            </p>
        </div>
    </div>
    <div class="row">

        <?= $Book_selection_table['table'] ?>

    </div>
    <div class="row">
        <br><br><br>
        <p>-----------------</p>
        <p>&nbsp;&nbsp;Signature</p>

    </div>
    <div class="margin-top-10">
        <a href="<?= $base_url ?>" class="only_print btn btn-primary "><i class="fa fa-dashboard"></i> Go Dashboard</a>
        <input class="only_print pull-right btn btn-primary" type="button"  onClick="window.print()"  value="Print This Page"/>
        <a href="<?= $edit_btn_url ?>" class="only_print pull-right btn btn-primary margin-10">Edit</a>
    </div>



</div>



<?php include_once 'footer.php'; ?>