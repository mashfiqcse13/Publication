<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<!--add header -->
<?php include_once __DIR__ . '/../header.php'; ?>

<!-- Left side column. contains the logo and sidebar -->
<?php include_once 'main_sidebar.php'; ?> <!-- main sidebar area -->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?= $Title ?>
            <small> <?= $Title ?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= $base_url ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Cash Box</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">



        <div class="row">
            <h1 class="text-center">Today Report</h1>
            <!--Today Total Sales-->
            <div class="col-lg-4 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3 class="text-right faka_formate"><?php echo $today_sales; ?> TK</h3>
                        <p>Total Sale</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-pricetag-outline"></i>
                    </div>
                    <a class="small-box-footer" href="#">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!--Today Cash Collection Against Salem-->
            <div class="col-lg-4 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3 class="text-right faka_formate"><?php echo $today_total_cash_paid_against_sale; ?> TK</h3>
                        <p> Cash Collection</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-pricetag-outline"></i>
                    </div>
                    <a class="small-box-footer" href="#">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!--Today Bank Collection Against Sale-->
            <div class="col-lg-4 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3 class="text-right faka_formate"><?php echo $today_total_bank_paid_against_sale; ?> TK</h3>
                        <p> Bank Collection</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-pricetag-outline"></i>
                    </div>
                    <a class="small-box-footer" href="#">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <!--Today Advance Deduction Against Sale-->
            <div class="col-lg-4 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3 class="text-right faka_formate"><?php echo $today_total_advance_deduction_against_sale; ?> TK</h3>
                        <p> Advance Deduction </p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-pricetag-outline"></i>
                    </div>
                    <a class="small-box-footer" href="#">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!--Today Total Due payment by old book salel-->
            <div class="col-lg-4 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3 class="text-right faka_formate"><?php echo $sale_info->sale_against_due_deduction_by_old_book_sell; ?> TK</h3>
                        <p> Due Payment By Old Book Sale </p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-pricetag-outline"></i>
                    </div>
                    <a class="small-box-footer" href="#">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!--Today Total Due againest sell-->
            <div class="col-lg-4 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3 class="text-right faka_formate"><?php echo $today_due; ?> TK</h3>
                        <p> Total Due </p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-pricetag-outline"></i>
                    </div>
                    <a class="small-box-footer" href="#">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!--Today Previous Due Collection-->
            <div class="col-lg-4 col-xs-6" title="(Cash : <?php echo $previous_due_collection_by_cash; ?> TK ) ( Bank : <?php echo $previous_due_collection_by_bank; ?> TK ) ( Old Book Sell : <?php echo $previous_due_collection_by_old_book_sell; ?> TK )">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3 class="text-right faka_formate"><?php echo $previous_due_collection; ?> TK</h3>
                        <p> Previous Due Collection </p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-pricetag-outline"></i>
                    </div>
                    <a class="small-box-footer" href="#">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>


            <!--Today Total Advance Collection ( Without returned book value )-->
            <div class="col-lg-4 col-xs-6" title="(Cash : <?php echo $total_advance_collection_without_book_sale_cash; ?> TK ) ( Bank : <?php echo $total_advance_collection_without_book_sale_bank; ?> TK )">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3 class="text-right faka_formate"><?php echo $totay_total_advance_collection_without_book_sale; ?> TK</h3>
                        <p> Total Advance Collection</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-pricetag-outline"></i>
                    </div>
                    <a class="small-box-footer" href="#">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!--Today Total Cash Collection-->
            <div class="col-lg-4 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3 class="text-right faka_formate"><?php echo $today_cash; ?> TK</h3>
                        <p>Total Cash Collection</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-pricetag-outline"></i>
                    </div>
                    <a class="small-box-footer" href="#">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!--Today Total Bank Collection-->
            <div class="col-lg-4 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3 class="text-right faka_formate"><?php echo $today_bank; ?> TK</h3>
                        <p>Total Bank Collection</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-pricetag-outline"></i>
                    </div>
                    <a class="small-box-footer" href="#">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>


            <!--Today Total Expense-->
            <div class="col-lg-4 col-xs-6 ">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3 class="text-right faka_formate"><?php echo $totay_total_expense; ?> TK</h3>
                        <p>Total Expense</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-pricetag-outline"></i>
                    </div>
                    <a class="small-box-footer" href="#">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <!--Today Total Expense-->
            <div class="col-lg-4 col-xs-6 ">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3 class="text-right faka_formate"><?php echo $today_total_cash_2_bank_trasfer; ?> TK</h3>
                        <p>Cash to Bank Transfer</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-pricetag-outline"></i>
                    </div>
                    <a class="small-box-footer" href="#">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>

        </div>




    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<!-- insert book -->



<?php include_once __DIR__ . '/../footer.php'; ?>
<style>
    .inner {
        text-align: center;
        min-height: 130px;
    }
</style>