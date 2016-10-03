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
    $('#upazila_field_box').hide();
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
            var district = ["|", "Bandarban|Bandarban", "Brahmanbaria|Brahmanbaria", "Chandpur|Chandpur", "Chittagong|Chittagong", "Comilla|Comilla", "Cox's Bazar|Cox's Bazar"
            ,"Feni|Feni","Khagrachhari|Khagrachhari","Lakshmipur|Lakshmipur","Noakhali|Noakhali","Rangamati|Rangamati"];        
        }else if(value == 'Dhaka'){
            var district = ["|", "Dhaka|Dhaka", "Faridpur|Faridpur", "Gazipur|Gazipur", "Gopalganj|Gopalganj", "Kishoreganj|Kishoreganj", "Madaripur|Madaripur"
            ,"Manikganj|Manikganj","Munshiganj|Munshiganj","Narayanganj|Narayanganj","Narsingdi|Narsingdi","Rajbari|Rajbari","Shariatpur|Shariatpur","Tangail|Tangail",
            ];
        }else if(value == 'Khulna'){
            var district = ["|","Bagerhat|Bagerhat","Chuadanga|Chuadanga", "Jessore|Jessore", "Jhenaidah|Jhenaidah", "Khulna|Khulna ", "Kushtia|Kushtia ", "Magura|Magura", "Meherpur|Meherpur"
            ,"Narail|Narail","Satkhira|Satkhira " ];
         }else if(value == 'Mymensingh'){
            var district = ["|", "Mymensingh|Mymensingh","Netrakona|Netrakona", "Sherpur|Sherpur"];
        }else if(value == 'Rajshahi'){
            var district = ["|", "Bogra|Bogra", "Chapainawabganj|Chapainawabganj", "Joypurhat|Joypurhat", "Naogaon|Naogaon", "Natore|Natore",  "Pabna|Pabna"
            ,"Rajshahi|Rajshahi","Sirajgonj|Sirajgonj"];
        }else if(value == 'Rangpur'){
            var district = ["|", "Dinajpur|Dinajpur", "Gaibandha|Gaibandha", "Kurigram|Kurigram", "Lalmonirhat|Lalmonirhat", "Nilphamari|Nilphamari", "Panchagarh|Panchagarh"
            ,"Rangpur|Rangpur","Thakurgaon|Thakurgaon"];
        }else if(value == 'Sylhet'){
            var district = ["|", "Habiganj|Habiganj", "Moulvibazar|Moulvibazar", "Sunamganj|Sunamganj", "Sylhet|Sylhet"];
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
    
    $('.district').change(function () {
        var district = $('.district').val();
        var upaName = $('.upazila').html('');
        $('#upazila_field_box').show();
        if(district == ''){
            $('#upazila_field_box').hide();
        }
//        distName.innerHTML = "";
        if (district == 'Pirojpur') {
            var upazila = ["|", "Bhandaria |Bhandaria ", "Kawkhali |Kawkhali ", "Mathbaria |Mathbaria ", "Nazirpur |Nazirpur ", "Pirojpur Sadar |Pirojpur Sadar ", "Nesarabad (Swarupkati) |Nesarabad (Swarupkati) ", "Zianagor |Zianagor "];
        }else if (district == 'Patuakhali') {
            var upazila = ["|", "Bauphal |Bauphal ", "Dashmina |Dashmina ", "Galachipa |Galachipa ", "Kalapara |Kalapara ", "Mirzaganj |Mirzaganj ", "Patuakhali Sadar |Patuakhali Sadar ", "Rangabali |Rangabali ","Dumki |Dumki "];
        }else if (district == 'Jhalokati') {
            var upazila = ["|", "Rajapur |Rajapur ", "Nalchity |Nalchity ", "Kathalia |Kathalia ", "Jhalokati Sadar |Jhalokati Sadar "];
        }else if (district == 'Bhola') {
            var upazila = ["|", "Bhola Sadar |Bhola Sadar ", "Burhanuddin |Burhanuddin ", "Tazumuddin |Tazumuddin ", "Manpura |Manpura ","Lalmohan |Lalmohan ","Daulatkhan |Daulatkhan ","Char Fasson |Char Fasson "];
        }else if (district == 'Barisal') {
            var upazila = ["|", "Wazirpur |Wazirpur ", "Muladi |Muladi ", "Mehendiganj |Mehendianj ", "Barisal Sadar |Barisal Sadar ","Hizla |Hizla ","Gaurnadi |Gaurnadi ","Banaripara |Banaripara ","Bakerganj |Bakerganj ","Babuganj |Babuganj ","Agailjhara |Agailjhara "];
        }else if (district == 'Barguna') {
            var upazila = ["|", "Taltoli |Taltoli ", "Patharghata |Patharghata ", "Betagi |Betagi ", "Barguna Sadar |Barguna Sadar ","Bamna |Bamna ","Amtali |Amtali "];
        }else if (district == 'Chandpur') {
            var upazila = ["|", "Shahrasti |Shahrasti ", "Matlab Uttar |Matlab Uttar ", "Matlab Dakshin |Matlab Dakshin ", "Kachua |Kachua ","Haziganj |Haziganj ","Haimchar |Haimchar ","Faridganj |Faridganj ","Chandpur Sadar |Chandpur Sadar "];
        }else if (district == 'Brahmanbaria') {
            var upazila = ["|", "Bijoynagar |Bijoynagar ", "Ashuganj |Ashuganj ", "Sarail |Sarail ","Kasba |Kasba ", "Brahmanbaria  Sadar |Brahmanbaria Sadar ","Bancharampur |Bancharampur ","Akhaura |Akhaura "];
        }else if (district == 'Comilla') {
            var upazila = ["|", "Chakaria  |Barura ", "Brahmanpara |Brahmanpara ", "Burichang |Burichang ","Chandina |Chandina ","Chauddagram |Chauddagram ","Daudkandi |Daudkandi ","Debidwar |Debidwar ","Homna |Homna ","Laksam |Laksam ","Muradnagar |Muradnagar ","Nangalkot |Nangalkot ","Comilla Adarsha Sadar |Comilla Adarsha Sadar ","Meghna |Meghna ","Titas |Titas ","Monohargonj |Monohargonj ","Comilla Sadar Dakshin |Comilla Sadar Dakshin "];
        }else if (district == "Cox's Bazar") {
            var upazila = ["|", "Rajapur |Rajapur ", "Cox's Bazar |Cox's Bazar ", "Kutubdia  |Kutubdia  ", "Maheshkhali |Maheshkhali ","Ramu  |Ramu ","Teknaf |Teknaf ","Ukhia |Ukhia ","Pekua |Pekua "];
        }else if (district == 'Feni') {
            var upazila = ["|", "Chhagalnaiya |Chhagalnaiya ", "Daganbhuiyan |Daganbhuiyan ", "Parshuram  |Parshuram ", "Feni Sadar |Feni Sadar ","Sonagazi |Sonagazi ","Fulgazi|Fulgazi"];
        }else if (district == 'Khagrachhari') {
            var upazila = ["|", "Dighinala |Dighinala ", "Khagrachhari |Khagrachhari ", "Lakshmichhari |Lakshmichhari ", "Mahalchhari  |Mahalchhari "," Manikchhari | Manikchhari ","Matiranga |Matiranga ","Panchhari |Panchhari ","Ramgarh |Ramgarh "];
        }else if (district == 'Lakshmipur') {
            var upazila = ["|", "Raipur  |Raipur ", "Ramganj  |Ramganj ", "Ramgati |Ramgati  ", "Lakshmipur Sadar |Lakshmipur Sadar ","Kamalnagar |Kamalnagar "];
        }else if (district == 'Noakhali') {
            var upazila = ["|", "Begumganj |Begumganj ", "Chatkhil |Chatkhil ", "Companiganj |Companiganj ", "Noakhali Sadar |Noakhali Sadar ","Hatiya |Hatiya ","Senbagh |Senbagh ","Sonaimuri |Sonaimuri ","Subarnachar |Subarnachar ","Kabirhat |Kabirhat "];
        }else if (district == 'Rangamati') {
            var upazila = ["|", "Bagaichhari |Bagaichhari ", "Barkal |Barkal ", "Kawkhali (Betbunia) |Kawkhali (Betbunia) ", "Belaichhari |Belaichhari ","Kaptai |Kaptai ","Juraichhari |Juraichhari ","Langadu |Langadu ","Naniyachar |Naniyachar ","Rajasthali |Rajasthali "];
        }else if (district == 'Bandarban') {
            var upazila = ["|", "Ali Kadam |Ali Kadam ", "Lama |Lama ", "Kathalia |Kathalia ", "Jhalokati Sadar |Jhalokati Sadar "];
        }else if (district == 'Brahmanbaria') {
            var upazila = ["|", "Akhaura |Akhaura ", "Bancharampur |Bancharampur ", "Kathalia |Kathalia ","Brahmanbaria Sadar |Brahmanbaria Sadar ", "Naikhongchhari |Naikhongchhari ", "Kasba |Kasba ","Bandarban Sadar |Bandarban Sadar ","Nabinagar |Nabinagar  ","Thanchi |Thanchi ","Nasirnagar |Nasirnagar ","Sarail |Sarail ","Ashuganj |Ashuganj ","Bijoynagar |Bijoynagar "];        
        } else if(district == 'Chittagong'){
            var upazila = ["|", "Bhujpur Thana |Bhujpur Thana", "Panchlaish Thana|Panchlaish Thana", "Pahartali Thana|Pahartali Thana", "Kotwali Thana|Kotwali Thana", "Double Mooring Thana|Double Mooring Thana", "Chandgaon Thana|Chandgaon Thana"
            ,"Bandar Thana|Bandar Thana","Sitakunda |Sitakunda ","Satkania |Satkania ","Sandwip |Sandwip ","Raozan |Raozan ","Rangunia |Rangunia ","Fatikchhari |Fatikchhari ","Patiya |Patiya ","Mirsharai |Mirsharai ","Lohagara |Lohagara ","Karnaphuli |Karnaphuli ","Hathazari |Hathazari ","Chandanaish |Chandanaish ","Boalkhali |Boalkhali ","Banshkhali |Banshkhali ","Anwara |Anwara "];        
        }else if(district == 'Dhaka'){
            var upazila = ["|", "Dhamrai |Dhamrai ", "Dohar |Dohar ", "Keraniganj |Keraniganj ", "Nawabganj |Nawabganj ", "Savar |Savar "];
        }else if(district == 'Gopalganj'){
            var upazila = ["|", "Gopalganj Sadar |Gopalganj Sadar " ,"Kashiani |Kashiani ","Kotalipara |Kotalipara ","Tungipara  |Tungipara  ","Muksudpur |Muksudpur "];
        }else if(district == 'Gazipur'){
            var upazila = ["|", "Gazipur Sadar |Gazipur Sadar ", "Kaliakair |Kaliakair ", "Kaliganj |Kaliganj ", "Kapasia |Kapasia ", "Sreepur |Sreepur "];
        }else if(district == 'Kishoreganj'){
            var upazila = ["|", "Austagram  |Austagram  ", "Bajitpur  |Bajitpur ", "Bhairab |Bhairab ", "Hossainpur |Hossainpur ", "Itna |Itna ", "Karimganj |Karimganj "
            ,"Katiadi |Katiadi "," Kishoreganj Sadar |Kishoreganj Sadar ","Kuliarchar  |Kuliarchar  ","Mithamain  |Mithamain ","Nikli |Nikli ","Pakundia |Pakundia ","Tarail |Tarail ",
            ];
        }else if(district == 'Madaripur'){
            var upazila = ["Rajoir |Rajoir ", "Madaripur Sadar |Madaripur Sadar ","Kalkini  |Kalkini  ", "Shibchar  |Shibchar "];
        }else if(district == 'Manikganj'){
            var upazila = ["|", "Daulatpur  |Daulatpur  ", "Ghior |Ghior ", "Harirampur  |Harirampur  ", "Manikgonj Sadar  |Manikgonj Sadar  ", "Saturia  |Saturia  ",  "Shivalaya  |Shivalaya  "
            ,"Singair |Singair "];
        }else if(district == 'Munshiganj'){
            var upazila = ["|", "Gazaria  |Gazaria  ", "Lohajang |Lohajang ", " Munshiganj Sadar  | Munshiganj Sadar  ", "Sirajdikhan  |Sirajdikhan  ", "Sreenagar  |Sreenagar  ",  "Tongibari  |Tongibari  "];
        }else if(district == 'Narayanganj'){
            var upazila = ["|", "Araihazar  |Araihazar  ", "Bandar |Bandar ", " Rupganj  | Rupganj  ", "Narayanganj Sadar  |Narayanganj Sadar  ", "Sonargaon  |Sonargaon  "];
        }else if(district == 'Rajbari'){
            var upazila = ["|", "Baliakandi  |Baliakandi  ", "Goalandaghat |Goalandaghat ", "Pangsha  |Pangsha  ", "Rajbari Sadar  |Rajbari Sadar  ", "Kalukhali  |Kalukhali  "];
        }else if(district == 'Shariatpur'){
            var upazila = ["|", "Bhedarganj  |Bhedarganj  ", "Damudya |Damudya ", "Gosairhat  |Gosairhat  ", "Naria  |Naria  ", "Shariatpur Sadar  |Shariatpur Sadar  ",  "Zajira  |Zajira  "
            ,"Shakhipur |Shakhipur "];
        }else if(district == 'Faridpur'){
            var upazila = ["|", "Alfadanga  |Alfadanga  ", "Bhanga |Bhanga ", "Boalmari  |Boalmari  ", "Charbhadrasan  |Charbhadrasan  ", "Faridpur Sadar  |Faridpur Sadar  ",  "Madhukhali  |Madhukhali  "
            ,"Nagarkanda |Nagarkanda ","Sadarpur  |Sadarpur ","Saltha |Saltha "];
        }else if(district == 'Tangail'){
            var upazila = ["|", "Gopalpur  |Gopalpur  ", "Basail |Basail ", "Bhuapur  |Bhuapur  ", "Delduar  |Delduar  ", "Ghatail  |Ghatail  ",  "Kalihati  |Kalihati  ",  "Madhupur  |Madhupur  ",  "Mirzapur  |Mirzapur  ",  "Nagarpur  |Nagarpur  ",  "Sakhipur  |Sakhipur  "
            ,"Dhanbari |Dhanbari ","Tangail Sadar  |Tangail Sadar "];
        }else if(district == 'Narsingdi'){
            var upazila = ["|", "Narsingdi Sadar  |Narsingdi Sadar  ", "Belabo |Belabo ", "Monohardi  |Monohardi  ", "Palash  |Palash  ", "Raipura  |Raipura  ",  "Shibpur  |Shibpur  "];
        }else if(district == 'Habiganj'){
            var upazila = ["|", "Ajmiriganj  |Ajmiriganj  ", "Bahubal |Bahubal ", "Baniyachong  |Baniyachong  ", "Chunarughat  |Chunarughat  ", "Habiganj Sadar  |Habiganj Sadar  ",  "Lakhai  |Lakhai  "
            ,"Madhabpur |Madhabpur ","Nabiganj  |Nabiganj "];
        }else if(district == 'Moulvibazar'){
            var upazila = ["|", "Barlekha  |Barlekha  ", "Kamalganj |Kamalganj ", "Kulaura  |Kulaura  ", "Moulvibazar Sadar  |Moulvibazar Sadar  ", "Rajnagar  |Rajnagar  ",  "Sreemangal  |Sreemangal  "
            ,"Juri |Juri "];
        }else if(district == 'Sylhet'){
            var upazila = ["|", "Balaganj   |Balaganj   ", "Beanibazar  |Beanibazar  ", "Bishwanath  |Bishwanath  ", "Companigonj  |Companigonj ","Fenchuganj |Fenchuganj ","Golapganj |Golapganj ","Gowainghat |Gowainghat ","Jaintiapur |Jaintiapur ","Kanaighat |Kanaighat ","Sylhet Sadar |Sylhet Sadar ","Zakiganj |Zakiganj ","South Surma |South Surma "];
        }else if(district == 'Sunamganj'){
            var upazila = ["|", "Bishwamvarpur  |Bishwamvarpur  ", "Chhatak |Chhatak ", "Derai  |Derai  ", "Dharamapasha  |Dharamapasha  ", "Dowarabazar  |Dowarabazar  ",  "Jagannathpur  |Jagannathpur  "
            ,"Jamalganj |Jamalganj ","Sullah  |Sullah ","Sunamganj Sadar |Sunamganj Sadar ","Tahirpur |Tahirpur ","Dakshin Sunamganj |Dakshin Sunamganj "];
        }else if(district == 'Netrakona'){
            var upazila = ["|", "Atpara  |Atpara  ", "Barhatta |Barhatta ", "Durgapur  |Durgapur  ", "Khaliajuri  |Khaliajuri  ", "Kalmakanda  |Kalmakanda  ",  "Kendua  |Kendua ","Madan |Madan ","Mohanganj |Mohanganj "
            ,"Netrokona Sadar|Netrokona Sadar","Purbadhala  |Purbadhala "];
        }else if(district == 'Sherpur'){
            var upazila = ["|", "Jhenaigati  |Jhenaigati  ", "Nakla |Nakla ", "Nalitabari  |Nalitabari  ", "Sherpur Sadar  |Sherpur Sadar  ", "Sreebardi  |Sreebardi  "];
        }else if(district == 'Jamalpur'){
            var upazila = ["|", "Baksiganj  |Baksiganj  ", "Dewanganj  |Dewanganj  ", "Islampur  |Islampur  ", "Jamalpur Sadar  |Jamalpur Sadar  ", "Madarganj  |Madarganj  ", "Melandaha  |Melandaha  "
            ,"Sarishabari  |Sarishabari  "];
        }else if(district == 'Mymensingh'){
            var upazila = ["|", "Bhaluka   |Bhaluka   ", "Dhobaura  |Dhobaura  ", "Fulbaria  |Fulbaria  ", "Gaffargaon  |Gaffargaon ","Gauripur |Gauripur ","Haluaghat |Haluaghat ","Ishwarganj |Ishwarganj ","Mymensingh Sadar |Mymensingh Sadar ","Muktagachha |Muktagachha ","Nandail |Nandail "," Phulpur | Phulpur ","Trishal |Trishal ","Tara Khanda |Tara Khanda "];
        }else if(district == 'Joypurhat'){
            var upazila = ["|", "Akkelpur  |Akkelpur  ", "Joypurhat Sadar |Joypurhat Sadar ", "Kalai  |Kalai  ", "Khetlal  |Khetlal  ", "Panchbibi  |Panchbibi  "];
        }else if(district == 'Bogra'){
            var upazila = ["|", "Adamdighi  |Adamdighi  ", "Bogra Sadar |Bogra Sadar ", "Dhunat  |Dhunat  ", "Dhupchanchia  |Dhupchanchia  ", "Gabtali  |Gabtali  ",  "Kahaloo  |Kahaloo  "
            ,"Nandigram |Nandigram ","Sariakandi  |Sariakandi ","Shajahanpur |Shajahanpur ","Sherpur |Sherpur ","Shibganj |Shibganj ","Sonatola |Sonatola "];
        }else if(district == 'Naogaon'){
            var upazila = ["|", "Atrai  |Atrai  ", "Badalgachhi |Badalgachhi ", "Manda  |Manda  ", "Dhamoirhat  |Dhamoirhat  ", "Mohadevpur  |Mohadevpur  ",  "Naogaon Sadar  |Naogaon Sadar ","Niamatpur |Niamatpur "
            ,"Patnitala |Patnitala ","Porsha  |Porsha ","Porsha |Porsha ","Raninagar |Raninagar ","Sapahar |Sapahar "];
        }else if(district == 'Natore'){
            var upazila = ["|", "Bagatipara  |Bagatipara  ", "Baraigram  |Baraigram  ", "Gurudaspur  |Gurudaspur  ", "Lalpur  |Lalpur  ", "Natore Sadar  |Natore Sadar  ", "Singra  |Singra  "
            ,"Naldanga  |Naldanga  "];
        }else if(district == 'Nawabganj'){
            var upazila = ["|", "Bholahat   |Bholahat   ", "Gomastapur  |Gomastapur  ", "Nachole  |Nachole ", "Nawabganj Sadar  |Nawabganj Sadar ","Shibganj |Shibganj "];
        }else if(district == 'Pabna'){
            var upazila = ["|", "Ataikula  |Ataikula  ", "Atgharia |Atgharia ", "Bera  |Bera  ", "Bhangura  |Bhangura  ", "Chatmohar  |Chatmohar  ",  "Faridpur  |Faridpur  "
            ,"Ishwardi |Ishwardi ","Pabna Sadar  |Pabna Sadar ","Santhia |Santhia ","Sujanagar |Sujanagar "];
        }else if(district == 'Sirajganj '){
            var upazila = ["|", "Belkuchi  |Belkuchi  ", "Chauhali |Chauhali ", "Kamarkhanda  |Kamarkhanda  ", "Kazipur  |Kazipur  ", "Raiganj  |Raiganj  ",  "Shahjadpur  |Shahjadpur  "
            ," Sirajganj Sadar | Sirajganj Sadar ","Tarash  |Tarash ","Ullahpara |Ullahpara "];
        }else if(district == 'Rajshahi'){
            var upazila = ["|", "Bagha  |Bagha  ", "Bagmara |Bagmara ", "Charghat  |Charghat  ", "Durgapur  |Durgapur  ", "Godagari  |Godagari  ",  "Mohanpur  |Mohanpur  ","Paba |Paba "
            ,"Puthia |Puthia ","Tanore  |Tanore "];
        }else if(district == 'Bagerhat'){
            var upazila = ["|", "Bagerhat Sadar  |Bagerhat Sadar  ", "Chitalmari  |Chitalmari  ", "Fakirhat  |Fakirhat  ", "Kachua  |Kachua  ", "Mollahat  |Mollahat  ", "Mongla  |Mongla  "
            ,"Morrelganj  |Morrelganj  ","Rampal  |Rampal ","Sarankhola |Sarankhola "];
        }else if(district == 'Chuadanga'){
            var upazila = ["|", "Alamdanga   |Alamdanga   ", "Chuadanga Sadar  |Chuadanga Sadar  ", "Damurhuda  |Damurhuda  ", "Jibannagar  |Jibannagar "];
        }else if(district == 'Jessore'){
            var upazila = ["|", "Abhaynagar  |Abhaynagar  ", "Bagherpara |Bagherpara ", "Chaugachha  |Chaugachha  ", "Jhikargachha  |Jhikargachha  ", "Keshabpur  |Keshabpur  ",  "Jessore Sadar  |Jessore Sadar  "
            ,"Manirampur |Manirampur ","Sharsha  |Sharsha "];
        }else if(district == 'Jhenaidah'){
            var upazila = ["|", "Harinakunda  |Harinakunda  ", "Jhenaidah Sadar |Jhenaidah Sadar ", "Kaliganj  |Kaliganj  ", "Kotchandpur  |Kotchandpur  ", "Maheshpur  |Maheshpur  ",  "Shailkupa  |Shailkupa  "];
        }else if(district == 'Khulna'){
            var upazila = ["|", "Batiaghata  |Batiaghata  ", "Dacope  |Dacope  ", "Kurigram |Kurigram ", "Dumuria  |Dumuria  ", "Dighalia  |Dighalia  ", "Koyra  |Koyra  ","Paikgachha |Paikgachha ","Phultala |","Rupsha |Rupsha ","Terokhada |Terokhada ","Daulatpur Thana|Daulatpur Thana","Khalishpur Thana|Khalishpur Thana","Khan Jahan Ali Thana|Khan Jahan Ali Thana","Kotwali Thana|Kotwali Thana"
            ,"Sonadanga Thana |Sonadanga Thana ","Harintana Thana |Harintana Thana"];
        }else if(district == 'Kushtia'){
            var upazila = ["|", "Bheramara   |Bheramara   ", "Daulatpur  |Daulatpur  ", "Khoksa  |Khoksa  ", "Kumarkhali  |Kumarkhali "," Kushtia Sadar | Kushtia Sadar ","Mirpur |Mirpur "];
        }else if(district == 'Magura'){
            var upazila = ["|", "Magura Sadar  |Magura Sadar  ", "Mohammadpur |Mohammadpur ", "Shalikha  |Shalikha  ", "Sreepur  |Sreepur  "];
        }else if(district == 'Meherpur'){
            var upazila = ["|", "Gangni  |Gangni  ", "Meherpur Sadar |Meherpur Sadar ", "Mujibnagar  |Mujibnagar  "];
        }else if(district == 'Narail'){
            var upazila = ["|", "Kalia  |Kalia ", "Lohagara  |Lohagara  ", "Narail Sadar  |Narail Sadar  ", "Naragati Thana |Naragati Thana "];
        }else if(district == 'Satkhira'){
            var upazila = ["|", "Assasuni   |Assasuni   ", "Debhata  |Kalaroa  ", "Kalaroa  |Kalaroa  ", "Kaliganj  |Kaliganj "," Satkhira Sadar | Satkhira Sadar ","Shyamnagar |Shyamnagar ","Tala |Tala "];
        }else if(district == 'Dinajpur'){
            var upazila = ["|", "Birampur  |Birampur  ", "Birganj |Birganj ", "Biral  |Biral  ", "Bochaganj  |Bochaganj  ", "Chirirbandar  |Chirirbandar  ",  "Phulbari  |Phulbari  ","Ghoraghat |Ghoraghat ","Hakimpur |Hakimpur ","Kaharole |Kaharole ","Khansama |Khansama ","Dinajpur Sadar |Dinajpur Sadar "
            ,"Nawabganj |Nawabganj ","Parbatipur  |Parbatipur "];
        }else if(district == 'Gaibandha'){
            var upazila = ["|", "Phulchhari  |Phulchhari  ", "Gaibandha Sadar |Gaibandha Sadar ", "Gobindaganj  |Gobindaganj ", "Palashbari  |Palashbari  ", "Sadullapur  |Sadullapur  ",  "Sughatta  |Sughatta  "
            ,"Sundarganj |Sundarganj "];
        }else if(district == 'Kurigram'){
            var upazila = ["|", "Bhurungamari  |Bhurungamari  ", "Char Rajibpur  |Char Rajibpur  ", "Chilmari  |Chilmari  ", "Phulbari  |Phulbari  ", "Kurigram Sadar  |Kurigram Sadar  ", " Nageshwari  | Nageshwari  "
            ,"Rajarhat |Rajarhat ","Raomari  |Raomari ","Ulipur|Ulipur"];
        }else if(district == 'Lalmonirhat'){
            var upazila = ["|", "Aditmari |Aditmari ", "Hatibandha  |Hatibandha  ", "Kaliganj  |Kaliganj  ", "Lalmonirhat Sadar  |Lalmonirhat Sadar ","Patgram |Patgram "];
        }else if(district == 'Nilphamari'){
            var upazila = ["|", "Dimla  |Dimla  ", "Domar |Domar ", "Jaldhaka  |Jaldhaka  ", "Kishoreganj  |Kishoreganj  ", "Nilphamari Sadar  |Nilphamari Sadar  ",  "Saidpur  |Saidpur  "];
        }else if(district == 'Panchagarh'){
            var upazila = ["|", "Atwari |Atwari  ", "Boda |Boda ", "Debiganj |Debiganj  ", "Panchagarh Sadar  |Panchagarh Sadar  ", "Tetulia  |Tetulia "];
        }else if(district == 'Rangpur'){
            var upazila = ["|", "Badarganj  |Badarganj  ", "Gangachhara  |Gangachhara  ", "Kaunia  |Kaunia  ", " Rangpur Sadar  | Rangpur Sadar  ", "Mithapukur  |Mithapukur  ", "Pirgachha  |Pirgachha  "
            ,"Pirganj  |Pirganj  ","Taraganj  |Taraganj "];
        }else if(district == 'Thakurgaon'){
            var upazila = ["|", "Baliadangi |Baliadangi   ", "Haripur  |Haripur  ", "Pirganj  |Pirganj  ", "Ranisankail  |Ranisankail ","Thakurgaon Sadar |Thakurgaon Sadar "];
        }else if(district == 'Sirajgonj'){
            var upazila = ["|", "Belkuchi|Belkuchi", "Chauhali|Chauhali", "Kamarkhanda|Kamarkhanda", "Kazipur|Kazipur","Raiganj |Raiganj","Shahjadpur|Shahjadpur","Sirajganj Sadar|Sirajganj Sadar","Tarash|Tarash","Ullahpara|Ullahpara"];
        }else if(district == 'Chapainawabganj'){
            var upazila = ["|", "Bholahat|Bholahat", "Gomastapur |Gomastapur ", "Nachole |Nachole ", "Nawabganj Sadar|Nawabganj Sadar","Shibganj|Shibganj"];
        }
        for (var option in upazila) {
            var pair = upazila[option].split("|");
            $('.upazila').prepend('<option value="'+pair[0]+'">'+pair[1]+'</option>');
        }
    });
    
    

</script>
