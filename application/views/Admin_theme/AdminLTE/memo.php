<!--add header -->
<?php include_once 'header.php'; ?>

<!-- Left side column. contains the logo and sidebar -->

<!-- Content Wrapper. Contains page content -->





<div class="container memo_print_option" style="background:#fff;width:595px;padding:25px 40px;margin-top:30px;font-size:12px;" >


    <div class="row">
        <div class="text-center">
            <h1>দি যমুনা পাবলিশার্স</h1>
            <p>৩৮,বাংলাবাজার(১ম তলা) ঢাকা-১১০০ । ফোন- ৭১১৬০৬৯  </p>
            <p style="font-size:10px">সাধারন তথ্য :- ০১৭১১-৮৯৮৮৮৭ । ব্যবসায়িক তথ্য :- ০১৭১৯-৭০৫৫৬৮ । বিক্রয় কেন্দ্র :- ০১৭২৮-৮৪৮৫২৩</p>
        </div><hr>
        <div class="row">
            <div class="col-md-4">
                <div class="pull-left">
                    <p><strong>Name:</strong> <?= $Book_selection_table['party_name'] ?></p>
                    
                    <p>Mobile:</strong> <?= $Book_selection_table['phone'] ?></p>
                    
                </div>
            </div>
            <div class="col-md-4">
                <div class="pull-left">
                    <p><strong>Address:</strong> <?= $Book_selection_table['address'] ?></p>
                    <p><strong>District:</strong> <?= $Book_selection_table['district'] ?></p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="pull-right">
                    <p><strong>Memo No:</strong> <?= $Book_selection_table['memoid']?></p>
                    <p><strong>Date:</strong> <?php echo " " . date("Y-m-d") ?></p>
                </div>
            </div>
        </div>

        
    </div>
    <br>
    <div class="row" style="font-size:11px;">

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