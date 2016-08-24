
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
            <li class="active">Customer section</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">

                <div class="box">
                    <?php
                    if ($this->uri->segment(3) !== 'read' && $this->uri->segment(3) !== 'add' && $this->uri->segment(3) !== 'edit') {
                        ?>
    <!--                        <input class="only_print pull-right btn btn-primary" type="button"  onClick="window.print()"   value="Print Report"/>
                        -->
<?php
}

echo $glosary->output;
?>

                </div>

            </div>
        </div>




    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<!-- insert book -->



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
            ,"Narail|Narail","Satkhira |Satkhira " ];
         }else if(value == 'Mymensingh'){
            var district = ["|", "Mymensingh|Mymensingh","Netrakona |Netrakona ", "Sherpur |Sherpur"];
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