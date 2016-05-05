
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
            <li class="active">Stock section</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">

                    <?php
                    //if ($this->uri->segment(3) === 'add') {
                        ?>
                    <?php
                    $message = $this->session->userdata('message');
                        if (isset($message)) {
                            echo $message;
                        }
                        $this->session->unset_userdata('message');
                    ?>

                        <!-- begin panel -->
                        <div class="panel panel-inverse" data-sortable-id="form-stuff-1">
                            <div class="panel-heading">
                                <h4 class="panel-title">Customer </h4>
                            </div>
                            <div class="panel-body">
                                <form action="<?php echo base_url(); ?>index.php/Customer/save_customer_payment" method="post" class="form-horizontal">
                                    
                                                                       
                                    <div class="form-group ">
                                        <label class="col-md-3">Employee id</label>
                                        <div class="col-md-9">
                                            <select class="form-control select2"style="width:100%;" name="id_customer">
                                                <option>Select Employee id</option>
                                                <?php
                                                foreach ($contacts as $contact) {
                                                    ?>
                                                    <option value="<?php echo $contact->contact_ID; ?>"><?php echo $contact->contact_ID; ?></option>
                                                <?php }
                                                ?>
                                            </select>
                                        </div>

                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Paid Amount</label>
                                        <div class="col-md-9">
                                            <input class="form-control"  placeholder="Paid Amount" name="paid_amount" type="text">
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label class="col-md-3">Select Id Total Sales</label>
                                        <div class="col-md-9">
                                            <select class="form-control select2"style="width:100%;" name="id_total_sales">
                                                <option>Select Id Total Sales</option>
                                                <?php
                                                foreach ($sales as $sale) {
                                                    ?>
                                                    <option value="<?php echo $sale->memo_ID; ?>"><?php echo $sale->memo_ID; ?></option>
                                                <?php }
                                                ?>
                                            </select>
                                        </div>

                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label"></label>
                                        <div class="col-md-9">
                                            <button type="submit" class="btn btn-sm btn-success">Save</button>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>
                        <!-- end panel -->
                        <?php
                   // } else {
                    //    print_r($glosary);exit();
                    //    echo $glosary->output;
                   // }
                    ?>

                </div>

            </div>


        </div>




    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<!-- insert book -->

<?php include_once __DIR__ . '/../footer.php'; ?>
