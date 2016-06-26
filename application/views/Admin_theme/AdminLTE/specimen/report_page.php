<!--add header -->
<?php include_once __DIR__ . '/../header.php'; ?>

<!-- Left side column. contains the logo and sidebar -->
<?php include_once 'main_sidebar.php'; ?> <!-- main sidebar area -->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper only_print">
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
            <div class="col-lg-12">
                <?php if (isset($report)) { ?>
                    <div class="col-md-12">
                        <h3 class="text-center"><?= $this->config->item('SITE')['name'] ?></h3>
                        <p class="text-center"> <?= $Title ?></p>
                        <input class="only_print pull-right btn btn-primary" type="button"  onClick="window.print()"  value="Print Report"/>
                    </div>
                    <div class="col-md-3">
                        <dl>
                            <dt>Agent Name</dt>
                            <dd><?php echo $agent_name ?></dd>
                        </dl>
                    </div>
                    <div class="col-md-3">
                        <dl>
                            <dt>Item Name</dt>
                            <dd><?php echo $item_name ?></dd>
                        </dl>
                    </div>
                    <div class="col-md-3">
                        <dl>
                            <dt>Date Range (From - To)</dt>
                            <dd><?php echo $date_range ?></dd>
                        </dl>
                    </div>
                    <div class="col-md-3">
                        <dl>
                            <dt>Report Generated by:</dt>
                            <dd><?php echo $_SESSION['username'] ?></dd>
                        </dl>
                    </div>
                    <div class="col-lg-12">
                        <?php echo $report; ?> 
                    </div>
                <?php } ?> 
            </div>
        </div>
</div>


</section><!-- /.content -->
</div><!-- /.content-wrapper -->

<!-- insert book -->

<div class="report-logo-for-print">
    <div class="row">
        <div class="col-lg-12">
            <?php if (isset($report)) { ?>
                <div class="col-md-12">
                    <h3 class="text-center"><?= $this->config->item('SITE')['name'] ?></h3>
                    <p class="text-center"> <?= $Title ?></p>
                    <input class="only_print pull-right btn btn-primary" type="button"  onClick="window.print()"  value="Print Report"/>
                </div>
                <div class="col-md-3">
                    <dl>
                        <dt>Agent Name</dt>
                        <dd><?php echo $agent_name ?></dd>
                    </dl>
                </div>
                <div class="col-md-3">
                    <dl>
                        <dt>Item Name</dt>
                        <dd><?php echo $item_name ?></dd>
                    </dl>
                </div>
                <div class="col-md-3">
                    <dl>
                        <dt>Date Range (From - To)</dt>
                        <dd><?php echo $date_range ?></dd>
                    </dl>
                </div>
                <div class="col-md-3">
                    <dl>
                        <dt>Report Generated by:</dt>
                        <dd><?php echo $_SESSION['username'] ?></dd>
                    </dl>
                </div>
                <div class="col-lg-12">
                    <?php echo $report; ?> 
                </div>
            <?php } ?> 
        </div>
    </div>
</div>

<?php include_once __DIR__ . '/../footer.php'; ?>
