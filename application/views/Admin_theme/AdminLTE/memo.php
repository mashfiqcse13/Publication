<!--add header -->
<?php include_once 'header.php'; ?>

<!-- Left side column. contains the logo and sidebar -->
<?php include_once 'main_sidebar.php'; ?> <!-- main sidebar area -->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <?= $Title ?>
            <small><?= $Title ?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= $base_url ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Memo Management</li>
        </ol>
    </section>



    <div class="container" style="background:#fff;width:900px;padding:25px 50px;margin-top:30px;">
        <div class="row">
            <h1 class="page-header">দি যমুনা পাবলিশার্স</h1>
        </div>
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
                <h3>Name</h3>
                <p>Company name <br>
                    street <br>
                    city <br>
                </p>
            </div>
        </div>
        <div class="row">

            <?= $Book_selection_table ?>

        </div>
        <div class="row">
            <br><br><br>
            <p>-----------------</p>
            <p>&nbsp;&nbsp;Signature</p>

        </div>

    </div>

</div>

<?php include_once 'footer.php'; ?>