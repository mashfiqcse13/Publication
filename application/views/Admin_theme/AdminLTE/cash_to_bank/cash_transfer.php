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
            <li class="active"><?php echo $Title ?></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">

                <div class="box">
                    <?php
//                       echo $glosary->output;
                    ?>
                    <div class="box-header">
                        <h1>Cash Transfer</h1>
                    </div>
                    <div class="box-body">
                        <?php
                        $attributes = array(
                            'class' => 'form-horizontal',
                            'name' => 'form',
                            'method' => 'post');
                        echo form_open('', $attributes)
                        ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group ">
                                    <label class="col-md-3">Available Cash:</label>
                                    <div class="col-md-9" >
                                        <?php
                                        foreach ($get_all_cash_info as $cash) {
                                            ?>
                                            <p><?php echo $cash->balance; ?></p>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <label class="col-md-3">Available Bank Accounts:</label>
                                    <div class="col-md-9" >
                                        <select name="id_bank_account" id="" class="form-control select2">
                                            <option value="0">Select Bank Account</option>
                                            <?php
                                            foreach ($get_all_bank_info as $bank) {
                                                ?>
                                                <option value="<?php echo $bank->id_bank_account ?>"><?php echo $bank->name_bank;
                                            - $bank->account_number; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <label class="col-md-3">Transfer Amount:</label>
                                    <div class="col-md-9" >
                                        <input type="" id="amount" class="form-control" name="transfered_amount"  placeholder="Transfer Maximum 1000 tk"/>
                                    </div>
                                </div>
                                <input type="submit"  value="Save" name="submit" id="submit" class="btn btn-success pull-right" style="margin-right: 10px"/>
                            </div>
                        </div>
<?= form_close(); ?>
                    </div>

                </div>

            </div>
        </div>




    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<!-- insert book -->



<?php include_once __DIR__ . '/../footer.php'; ?>
<script type="text/javascript">
    
    $('#amount').keyup(function(){
        var amount = $('#amount').val();
        if(amount> 1000){
        alert('You Have Cross The Limit!!');
        $('#amount').click(function(e){
            e.preventDefault();
        });
    }
    });
    
</script>