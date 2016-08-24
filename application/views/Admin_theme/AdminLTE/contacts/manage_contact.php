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
            <small>Manage <?= $Title ?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= $base_url ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active"><?= $Title ?></li>
        </ol>
         <?php if (isset($return_book_page)) { ?>
                 <div class="box only_print">
                            <div class="box-body">
                                <?php
                
                    $attributes = array(
                        'clase' => 'form-inline',
                        'method' => 'post');
                    echo form_open('', $attributes)
                    ?>
                    <div class="form-group col-md-4 text-left">
                        
                        <label>Search Report With Date Range:</label>
                    </div>
                    <div class="form-group col-md-6">
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" name="date_range" value="<?= isset($date_range) ? $date_range : ''; ?>" class="form-control pull-right" id="reservation"  title="This is not a date"/>
                            <br>
                        </div><!-- /.input group -->
                    </div><!-- /.form group -->
                    
                    <button type="submit" name="btn_submit" value="true" class="btn btn-primary"><i class="fa fa-search"></i></button>
                    <?= anchor(current_url() . '/reset_date_range', '<i class="fa fa-refresh"></i>', ' class="btn btn-success"') ?>
                    <?= form_close(); ?>
                <?php  ?>
                            </div>
                        </div>
        
        
                        <div class="box-header">
                            <?php if(isset($date_range) && !empty($date_range)){ ?>
                            <p class="text-center"><strong>Return book Information</strong></p>
                                <p class="pull-left" style="margin-left:20px"> <strong>Search Range: (From - To) </strong> <?php echo $date_range; ?></p>
                                
<!--                             <input class="only_print pull-right btn btn-primary" type="button"  onClick="window.print()"  value="Print Report"/>
                              -->
                                                      
                                <?= $main_content; ?>
                            
                            <h3 class="box-title">Declared Returned Book Value:TK <?=$total_return_book_price; ?></h3>
                  
                            <?php } ?>
                           
                        </div><!-- /.box-header -->
                        
         <?php } ?>
    
    </scetion>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <?php
            if (empty($this->uri->segment(3))) {  
                include 'section-contact_filter.php';
            }
            ?>
            <div class="col-md-12">
                <div class="box">
                    <?php
                   if(!isset($date_range)){
                    echo $glosary->output;
              
                    
                     }      ?>
                     
                    
                </div>
            </div>

            <?php
            if(!isset($date_range)){
                
           
            if (isset($total_book_return_section)) { ?>
                
            
                <div class="col-md-3">
                    <label>Select Book Name :</label>
                </div>
                <div class="col-md-6">
                    <?= $book_returned_dropdown ?>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-3">
                    <label>Number of Returned Book :</label>
                </div>
                <div class="col-md-9" id="total_book_return">
                </div>
                <div class="clearfix"></div>
                <div class="col-md-3">
                    <label>Total Number of Returned Book :</label>
                </div>
                <div class="col-md-9">
                    <?= $total_book_returned ?>
                </div>
                
            <?php } }?>

        </div>












    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

     <div class="box-body report-logo-for-print" style="background:#fff">
         <h3 class="text-center"><?=$this->config->item('SITE')['name'] ?></h3>
          <p class="text-center"> <?=$Title ?> Report</p>
          <p>Report Generated by: <?php echo $_SESSION['username'] ?></p>
           <?php
                   if(!isset($date_range)){
                       if ($this->uri->segment(3) !== 'read' && $this->uri->segment(3) !== 'add' && $this->uri->segment(3) !== 'edit' )   {
                            echo $glosary->output;
                       }
                    
                   }
                    ?>
          
        </div>
<style>
    .report-logo-for-print .tDiv {
    display: none;
    }

    .report-logo-for-print  form#filtering_form {
        display: none;
    }

    .report-logo-for-print  th:nth-child(11) {
        display: none;
    }

    .report-logo-for-print  td:nth-child(11) {
        display: none;
    }

    .report-logo-for-print  td {
        border: 1px solid #ddd!important;
    }

 

    .report-logo-for-print  .flexigrid div.mDiv {
        display: none;
    }

    .report-logo-for-print  .flexigrid div.bDiv {
        border: 0px!important;
    }
</style>


<?php include_once __DIR__ . '/../footer.php'; ?>
<script type="text/javascript">
    $('#district_field_box').hide();
    $('#division').change(function () {
        var value = $('#division').val();
        var distName = $('.district').html('');
        $('#district_field_box').show();
        if(value == ''){
            $('#district_field_box').hide();
        }
//        distName.innerHTML = "";
        if (value == 'Barisal') {
            var district = ["|", "Barguna|Barguna", "Barisal|Barisal", "Bhola|Bhola", "Jhalokati|Jhalokati", "Patuakhali|Patuakhali", "Pirojpur|Pirojpur"];
        }else if(value == 'Chittagong'){
            var district = ["|", "Bandarban |Bandarban", "Brahmanbaria|Brahmanbaria", "Chandpur|Chandpur", "Chittagong|Chittagong", "Comilla|Comilla", "Cox's Bazar|Cox's Bazar"
            ,"Feni|Feni","Khagrachhari|Khagrachhari","Lakshmipur|Lakshmipur","Noakhali|Noakhali","Rangamati|Rangamati"];        
        }else if(value == 'Dhaka'){
            var district = ["|", "Dhaka |Dhaka", "Faridpur|Faridpur", "Gazipur|Gazipur", "Gopalganj|Gopalganj", "Kishoreganj|Kishoreganj", "Madaripur|Madaripur"
            ,"Manikganj|Manikganj","Munshiganj|Munshiganj","Narayanganj|Narayanganj","Narsingdi|Narsingdi","Rajbari|Rajbari","Shariatpur|Shariatpur","Tangail|Tangail",
            ];
        }else if(value == 'Khulna'){
            var district = ["|","Bagerhat|Bagerhat","Chuadanga|Chuadanga", "Jessore|Jessore", "Jhenaidah|Jhenaidah", "Khulna |Khulna ", "Kushtia |Kushtia ", "Magura|Magura", "Meherpur|Meherpur"
            ,"Narail|Narail","Satkhira |Satkhira "];
         }else if(value == 'Mymensingh'){
            var district = ["|", "Mymensingh|Mymensingh", "Netrakona |Netrakona ", "Sherpur |Sherpur"];
        }else if(value == 'Rajshahi'){
            var district = ["|", "Bogra |Bogra ", "Chapainawabganj|Chapainawabganj", "Joypurhat |Joypurhat ", "Naogaon |Naogaon ", "Natore |Natore ",  "Pabna |Pabna "
            ,"Rajshahi|Rajshahi","Sirajgonj |Sirajgonj"];
        }else if(value == 'Rangpur'){
            var district = ["|", "Dinajpur |Dinajpur ", "Gaibandha |Gaibandha ", "Kurigram |Kurigram ", "Lalmonirhat |Lalmonirhat ", "Nilphamari |Nilphamari ", "Panchagarh |Panchagarh "
            ,"Rangpur |Rangpur ","Thakurgaon |Thakurgaon"];
        }else if(value == 'Sylhet'){
            var district = ["|", "Habiganj  |Habiganj  ", "Moulvibazar |Moulvibazar ", "Sunamganj |Kurigram ", "Sylhet |Sylhet"];
        }
        for (var option in district) {
            var pair = district[option].split("|");
//            var newDistrict = document.createElement("option");
//            newDistrict.value = pair[0];
//            newDistrict.innerHTML = pair[1];
//            distName.options.add(newDistrict);
            $('.district').prepend('<option value="'+pair[0]+'">'+pair[1]+'</option>');
        }
    });

</script>
