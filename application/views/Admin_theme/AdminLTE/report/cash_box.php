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
            <!--Today Total Sales-->
            <div class="col-lg-4 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3 class="text-right faka_formate"><?php echo $today_sales; ?> TK</h3>
                        <p>Today Total Sales</p>
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
                        <p>Today Total Due againest sell</p>
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
                        <p>Today Cash Collection Against Sale</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-pricetag-outline"></i>
                    </div>
                    <a class="small-box-footer" href="#">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>





        <!-- end first row-->


            <!--Today Bank Collection Against Sale-->
            <div class="col-lg-4 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3 class="text-right faka_formate"><?php echo $today_total_bank_paid_against_sale; ?> TK</h3>
                        <p>Today Bank Collection Against Sale</p>
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
                        <p>Today Advance Deduction Against Sale</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-pricetag-outline"></i>
                    </div>
                    <a class="small-box-footer" href="#">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>


            <!--Today Due collection  Against Sale-->
            <div class="col-lg-4 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3 class="text-right faka_formate"><?php echo $today_due_collection_against_sale; ?> TK</h3>
                        <p>Today Due Collection Against Sale</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-pricetag-outline"></i>
                    </div>
                    <a class="small-box-footer" href="#">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <noscript>

            <!--Today Total Cash Collection-->
            <div class="col-lg-4 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3 class="text-right faka_formate"><?php echo $today_cash; ?> TK</h3>
                        <p>Today Total Cash Collection</p>
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
                        <p>Today Total Bank Collection</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-pricetag-outline"></i>
                    </div>
                    <a class="small-box-footer" href="#">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            </noscript>

        </div>



        <div class="row">


            <noscript>
            <!--Today Due Collection Cash-->
            <div class="col-lg-4 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3 class="text-right faka_formate"><?php echo $today_customer_due_cash; ?> TK</h3>
                        <p>Today Due Collection Cash</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-pricetag-outline"></i>
                    </div>
                    <a class="small-box-footer" href="#">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!--Today Due Collection Bank-->
            <div class="col-lg-4 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3 class="text-right faka_formate"><?php echo $today_customer_due_bank; ?> TK</h3>
                        <p>Today Due Collection Bank</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-pricetag-outline"></i>
                    </div>
                    <a class="small-box-footer" href="#">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            </noscript>

            <!--Today Total Due Collection-->
            <div class="col-lg-4 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3 class="text-right faka_formate"><?php echo $today_total_due_collection; ?> TK</h3>
                        <p>Today Total Due Collection</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-pricetag-outline"></i>
                    </div>
                    <a class="small-box-footer" href="#">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <!--Today Total Advance Collection ( Without returned book value )-->
            <div class="col-lg-4 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3 class="text-right faka_formate"><?php echo $totay_total_advance_collection_without_book_sale; ?> TK</h3>
                        <p>Today Total Advance Collection <br> ( Without returned book value )</p>
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
                        <p>Today Total Expense</p>
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
                        <p>Today Total Cash Collection</p>
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
                        <p>Today Total Bank Collection</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-pricetag-outline"></i>
                    </div>
                    <a class="small-box-footer" href="#">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <!--Today Total ( Cash + Bank ) Collection-->
            <div class="col-lg-4 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3 class="text-right faka_formate"><?php echo $today_cash + $today_bank; ?> TK</h3>
                        <p>Today Total  Collection<br> ( Cash + Bank )</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-pricetag-outline"></i>
                    </div>
                    <a class="small-box-footer" href="#">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>

        </div>

        <noscript>
        <div class="row">
            <!--Today Advance Collection Cash-->
            <div class="col-lg-4 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3 class="text-right faka_formate"><?php echo $today_customer_advance_payment__cash; ?> TK</h3>
                        <p>Today Advance Collection Cash</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-pricetag-outline"></i>
                    </div>
                    <a class="small-box-footer" href="#">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!--Today Advance Collection Bank-->
            <div class="col-lg-4 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3 class="text-right faka_formate"><?php echo $today_customer_advance_payment_bank; ?> TK</h3>
                        <p>Today Advance Collection Bank</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-pricetag-outline"></i>
                    </div>
                    <a class="small-box-footer" href="#">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!--Party Total Advance Collection-->
            <div class="col-lg-4 col-xs-6">
                <!--small box--> 
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3 class="text-right faka_formate"><?php echo $advance_payment_balance; ?> TK</h3>
                        <p>Party Total Advance Collection</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-pricetag-outline"></i>
                    </div>
                    <a class="small-box-footer" href="#">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
        </noscript>




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