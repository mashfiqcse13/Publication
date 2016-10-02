
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
    $('.district').change(function () {
        var district = $('.district').val();
        var upaName = $('.upazila').html('');
        $('#upazila_field_box').show();
        if(district == ''){
            $('#upazila_field_box').hide();
        }
//        distName.innerHTML = "";
        if (district == 'Pirojpur') {
            var upazila = ["|", "Bhandaria Upazila|Bhandaria Upazila", "Kawkhali Upazila|Kawkhali Upazila", "Mathbaria Upazila|Mathbaria Upazila", "Nazirpur Upazila|Nazirpur Upazila", "Pirojpur Sadar Upazila|Pirojpur Sadar Upazila", "Nesarabad (Swarupkati) Upazila|Nesarabad (Swarupkati) Upazila", "Zianagor Upazila|Zianagor Upazila"];
        }else if (district == 'Patuakhali') {
            var upazila = ["|", "Bauphal Upazila|Bauphal Upazila", "Dashmina Upazila|Dashmina Upazila", "Galachipa Upazila|Galachipa Upazila", "Kalapara Upazila|Kalapara Upazila", "Mirzaganj Upazila|Mirzaganj Upazila", "Patuakhali Sadar Upazila|Patuakhali Sadar Upazila", "Rangabali Upazila|Rangabali Upazila","Dumki Upazila|Dumki Upazila"];
        }else if (district == 'Jhalokati') {
            var upazila = ["|", "Rajapur Upazila|Rajapur Upazila", "Nalchity Upazila|Nalchity Upazila", "Kathalia Upazila|Kathalia Upazila", "Jhalokati Sadar Upazila|Jhalokati Sadar Upazila"];
        }else if (district == 'Bhola') {
            var upazila = ["|", "Bhola Sadar Upazila|Bhola Sadar Upazila", "Burhanuddin Upazila|Burhanuddin Upazila", "Tazumuddin Upazila|Tazumuddin Upazila", "Manpura Upazila|Manpura Upazila","Lalmohan Upazila|Lalmohan Upazila","Daulatkhan Upazila|Daulatkhan Upazila","Char Fasson Upazila|Char Fasson Upazila"];
        }else if (district == 'Barisal') {
            var upazila = ["|", "Wazirpur Upazila|Wazirpur Upazila", "Muladi Upazila|Muladi Upazila", "Mehendiganj Upazila|Mehendianj Upazila", "Barisal Sadar Upazila|Barisal Sadar Upazila","Hizla Upazila|Hizla Upazila","Gaurnadi Upazila|Gaurnadi Upazila","Banaripara Upazila|Banaripara Upazila","Bakerganj Upazila|Bakerganj Upazila","Babuganj Upazila|Babuganj Upazila","Agailjhara Upazila|Agailjhara Upazila"];
        }else if (district == 'Barguna') {
            var upazila = ["|", "Taltoli Upazila|Taltoli Upazila", "Patharghata Upazila|Patharghata Upazila", "Betagi Upazila|Betagi Upazila", "Barguna Sadar Upazila|Barguna Sadar Upazila","Bamna Upazila|Bamna Upazila","Amtali Upazila|Amtali Upazila"];
        }else if (district == 'Chandpur') {
            var upazila = ["|", "Shahrasti Upazila|Shahrasti Upazila", "Matlab Uttar Upazila|Matlab Uttar Upazila", "Matlab Dakshin Upazila|Matlab Dakshin Upazila", "Kachua Upazila|Kachua Upazila","Haziganj Upazila|Haziganj Upazila","Haimchar Upazila|Haimchar Upazila","Faridganj Upazila|Faridganj Upazila","Chandpur Sadar Upazila|Chandpur Sadar Upazila"];
        }else if (district == 'Brahmanbaria') {
            var upazila = ["|", "Bijoynagar Upazila|Bijoynagar Upazila", "Ashuganj Upazila|Ashuganj Upazila", "Sarail Upazila|Sarail Upazila","Kasba Upazila|Kasba Upazila", "Brahmanbaria  Sadar Upazila|Brahmanbaria Sadar Upazila","Bancharampur Upazila|Bancharampur Upazila","Akhaura Upazila|Akhaura Upazila"];
        }else if (district == 'Comilla') {
            var upazila = ["|", "Chakaria  Upazila|Barura Upazila", "Brahmanpara Upazila|Brahmanpara Upazila", "Burichang Upazila|Burichang Upazila","Chandina Upazila|Chandina Upazila","Chauddagram Upazila|Chauddagram Upazila","Daudkandi Upazila|Daudkandi Upazila","Debidwar Upazila|Debidwar Upazila","Homna Upazila|Homna Upazila","Laksam Upazila|Laksam Upazila","Muradnagar Upazila|Muradnagar Upazila","Nangalkot Upazila|Nangalkot Upazila","Comilla Adarsha Sadar Upazila|Comilla Adarsha Sadar Upazila","Meghna Upazila|Meghna Upazila","Titas Upazila|Titas Upazila","Monohargonj Upazila|Monohargonj Upazila","Comilla Sadar Dakshin Upazila|Comilla Sadar Dakshin Upazila"];
        }else if (district == 'Cox"s Bazar') {
            var upazila = ["|", "Rajapur Upazila|Rajapur Upazila", "Cox's Bazar Upazila|Cox's Bazar Upazila", "Kutubdia  Upazila|Kutubdia  Upazila", "Maheshkhali Upazila|Maheshkhali Upazila","Ramu Upazila |Ramu Upazila","Teknaf Upazila|Teknaf Upazila","Ukhia Upazila|Ukhia Upazila","Pekua Upazila|Pekua Upazila"];
        }else if (district == 'Feni') {
            var upazila = ["|", "Chhagalnaiya Upazila|Chhagalnaiya Upazila", "Daganbhuiyan Upazila|Daganbhuiyan Upazila", "Parshuram  Upazila|Parshuram Upazila", "Feni Sadar Upazila|Feni Sadar Upazila","Sonagazi Upazila|Sonagazi Upazila","Fulgazi|Fulgazi"];
        }else if (district == 'Khagrachhari') {
            var upazila = ["|", "Dighinala Upazila|Dighinala Upazila", "Khagrachhari Upazila|Khagrachhari Upazila", "Lakshmichhari Upazila|Lakshmichhari Upazila", "Mahalchhari  Upazila|Mahalchhari Upazila"," Manikchhari Upazila| Manikchhari Upazila","Matiranga Upazila|Matiranga Upazila","Panchhari Upazila|Panchhari Upazila","Ramgarh Upazila|Ramgarh Upazila"];
        }else if (district == 'Lakshmipur') {
            var upazila = ["|", "Raipur  Upazila|Raipur Upazila", "Ramganj  Upazila|Ramganj Upazila", "Ramgati Upazila|Ramgati  Upazila", "Lakshmipur Sadar Upazila|Lakshmipur Sadar Upazila","Kamalnagar Upazila|Kamalnagar Upazila"];
        }else if (district == 'Noakhali') {
            var upazila = ["|", "Begumganj Upazila|Begumganj Upazila", "Chatkhil Upazila|Chatkhil Upazila", "Companiganj Upazila|Companiganj Upazila", "Noakhali Sadar Upazila|Noakhali Sadar Upazila","Hatiya Upazila|Hatiya Upazila","Senbagh Upazila|Senbagh Upazila","Sonaimuri Upazila|Sonaimuri Upazila","Subarnachar Upazila|Subarnachar Upazila","Kabirhat Upazila|Kabirhat Upazila"];
        }else if (district == 'Rangamati') {
            var upazila = ["|", "Bagaichhari Upazila|Bagaichhari Upazila", "Barkal Upazila|Barkal Upazila", "Kawkhali (Betbunia) Upazila|Kawkhali (Betbunia) Upazila", "Belaichhari Upazila|Belaichhari Upazila","Kaptai Upazila|Kaptai Upazila","Juraichhari Upazila|Juraichhari Upazila","Langadu Upazila|Langadu Upazila","Naniyachar Upazila|Naniyachar Upazila","Rajasthali Upazila|Rajasthali Upazila"];
        }else if (district == 'Bandarban') {
            var upazila = ["|", "Ali Kadam Upazila|Ali Kadam Upazila", "Lama Upazila|Lama Upazila", "Kathalia Upazila|Kathalia Upazila", "Jhalokati Sadar Upazila|Jhalokati Sadar Upazila"];
        }else if (district == 'Brahmanbaria') {
            var upazila = ["|", "Akhaura Upazila|Akhaura Upazila", "Bancharampur Upazila|Bancharampur Upazila", "Kathalia Upazila|Kathalia Upazila","Brahmanbaria Sadar Upazila|Brahmanbaria Sadar Upazila", "Naikhongchhari Upazila|Naikhongchhari Upazila", "Kasba Upazila|Kasba Upazila","Bandarban Sadar Upazila|Bandarban Sadar Upazila","Nabinagar Upazila|Nabinagar  Upazila","Thanchi Upazila|Thanchi Upazila","Nasirnagar Upazila|Nasirnagar Upazila","Sarail Upazila|Sarail Upazila","Ashuganj Upazila|Ashuganj Upazila","Bijoynagar Upazila|Bijoynagar Upazila"];        
        } else if(district == 'Chittagong'){
            var upazila = ["|", "Bhujpur Thana |Bhujpur Thana", "Panchlaish Thana|Panchlaish Thana", "Pahartali Thana|Pahartali Thana", "Kotwali Thana|Kotwali Thana", "Double Mooring Thana|Double Mooring Thana", "Chandgaon Thana|Chandgaon Thana"
            ,"Bandar Thana|Bandar Thana","Sitakunda Upazila|Sitakunda Upazila","Satkania Upazila|Satkania Upazila","Sandwip Upazila|Sandwip Upazila","Raozan Upazila|Raozan Upazila","Rangunia Upazila|Rangunia Upazila","Fatikchhari Upazila|Fatikchhari Upazila","Patiya Upazila|Patiya Upazila","Mirsharai Upazila|Mirsharai Upazila","Lohagara Upazila|Lohagara Upazila","Karnaphuli Upazila|Karnaphuli Upazila","Hathazari Upazila|Hathazari Upazila","Chandanaish Upazila|Chandanaish Upazila","Boalkhali Upazila|Boalkhali Upazila","Banshkhali Upazila|Banshkhali Upazila","Anwara Upazila|Anwara Upazila"];        
        }else if(district == 'Dhaka'){
            var upazila = ["|", "Dhamrai Upazila|Dhamrai Upazila", "Dohar Upazila|Dohar Upazila", "Keraniganj Upazila|Keraniganj Upazila", "Nawabganj Upazila|Nawabganj Upazila", "Savar Upazila|Savar Upazila"];
        }else if(district == 'Gopalganj'){
            var upazila = ["|", "Gopalganj Sadar Upazila|Gopalganj Sadar Upazila" ,"Kashiani Upazila|Kashiani Upazila","Kotalipara Upazila|Kotalipara Upazila","Tungipara  Upazila|Tungipara  Upazila","Muksudpur Upazila|Muksudpur Upazila"];
        }else if(district == 'Gazipur'){
            var upazila = ["|", "Gazipur Sadar Upazila|Gazipur Sadar Upazila", "Kaliakair Upazila|Kaliakair Upazila", "Kaliganj Upazila|Kaliganj Upazila", "Kapasia Upazila|Kapasia Upazila", "Sreepur Upazila|Sreepur Upazila"];
        }else if(district == 'Kishoreganj'){
            var upazila = ["|", "Austagram  Upazila|Austagram  Upazila", "Bajitpur  Upazila|Bajitpur Upazila", "Bhairab Upazila|Bhairab Upazila", "Hossainpur Upazila|Hossainpur Upazila", "Itna Upazila|Itna Upazila", "Karimganj Upazila|Karimganj Upazila"
            ,"Katiadi Upazila|Katiadi Upazila"," Kishoreganj Sadar Upazila|Kishoreganj Sadar Upazila","Kuliarchar  Upazila|Kuliarchar  Upazila","Mithamain  Upazila|Mithamain Upazila","Nikli Upazila|Nikli Upazila","Pakundia Upazila|Pakundia Upazila","Tarail Upazila|Tarail Upazila",
            ];
        }else if(district == 'Madaripur'){
            var upazila = ["Rajoir Upazila|Rajoir Upazila", "Madaripur Sadar Upazila|Madaripur Sadar Upazila","Kalkini Upazila |Kalkini Upazila ", "Shibchar Upazila |Shibchar Upazila"];
        }else if(district == 'Manikganj'){
            var upazila = ["|", "Daulatpur Upazila |Daulatpur Upazila ", "Ghior Upazila|Ghior Upazila", "Harirampur Upazila |Harirampur Upazila ", "Manikgonj Sadar Upazila |Manikgonj Sadar Upazila ", "Saturia Upazila |Saturia Upazila ",  "Shivalaya Upazila |Shivalaya Upazila "
            ,"Singair Upazila|Singair Upazila"];
        }else if(district == 'Munshiganj'){
            var upazila = ["|", "Gazaria Upazila |Gazaria Upazila ", "Lohajang Upazila|Lohajang Upazila", " Munshiganj Sadar Upazila | Munshiganj Sadar Upazila ", "Sirajdikhan Upazila |Sirajdikhan Upazila ", "Sreenagar Upazila |Sreenagar Upazila ",  "Tongibari Upazila |Tongibari Upazila "];
        }else if(district == 'Narayanganj '){
            var upazila = ["|", "Araihazar Upazila |Araihazar Upazila ", "Bandar Upazila|Bandar Upazila", " Rupganj Upazila | Rupganj Upazila ", "Narayanganj Sadar Upazila |Narayanganj Sadar Upazila ", "Sonargaon Upazila |Sonargaon Upazila "];
        }else if(district == 'Rajbari '){
            var upazila = ["|", "Baliakandi Upazila |Baliakandi Upazila ", "Goalandaghat Upazila|Goalandaghat Upazila", "Pangsha Upazila |Pangsha Upazila ", "Rajbari Sadar Upazila |Rajbari Sadar Upazila ", "Kalukhali Upazila |Kalukhali Upazila ",  "Pabna |Pabna "];
        }else if(district == 'Shariatpur'){
            var upazila = ["|", "Bhedarganj Upazila |Bhedarganj Upazila ", "Damudya Upazila|Damudya Upazila", "Gosairhat Upazila |Gosairhat Upazila ", "Naria Upazila |Naria Upazila ", "Shariatpur Sadar Upazila |Shariatpur Sadar Upazila ",  "Zajira Upazila |Zajira Upazila "
            ,"Shakhipur Upazila|Shakhipur Upazila"];
        }else if(district == 'Faridpur'){
            var upazila = ["|", "Alfadanga Upazila |Alfadanga Upazila ", "Bhanga Upazila|Bhanga Upazila", "Boalmari Upazila |Boalmari Upazila ", "Charbhadrasan Upazila |Charbhadrasan Upazila ", "Faridpur Sadar Upazila |Faridpur Sadar Upazila ",  "Madhukhali Upazila |Madhukhali Upazila "
            ,"Nagarkanda Upazila|Nagarkanda Upazila","Sadarpur Upazila |Sadarpur Upazila","Saltha Upazila|Saltha Upazila"];
        }else if(district == 'Tangail'){
            var upazila = ["|", "Gopalpur Upazila |Gopalpur Upazila ", "Basail Upazila|Basail Upazila", "Bhuapur Upazila |Bhuapur Upazila ", "Delduar Upazila |Delduar Upazila ", "Ghatail Upazila |Ghatail Upazila ",  "Kalihati Upazila |Kalihati Upazila ",  "Madhupur Upazila |Madhupur Upazila ",  "Mirzapur Upazila |Mirzapur Upazila ",  "Nagarpur Upazila |Nagarpur Upazila ",  "Sakhipur Upazila |Sakhipur Upazila "
            ,"Dhanbari Upazila|Dhanbari Upazila","Tangail Sadar Upazila |Tangail Sadar Upazila"];
        }else if(district == 'Narsingdi'){
            var upazila = ["|", "Narsingdi Sadar Upazila |Narsingdi Sadar Upazila ", "Belabo Upazila|Belabo Upazila", "Monohardi Upazila |Monohardi Upazila ", "Palash Upazila |Palash Upazila ", "Raipura Upazila |Raipura Upazila ",  "Shibpur Upazila |Shibpur Upazila "];
        }else if(district == 'Habiganj'){
            var upazila = ["|", "Ajmiriganj Upazila |Ajmiriganj Upazila ", "Bahubal Upazila|Bahubal Upazila", "Baniyachong Upazila |Baniyachong Upazila ", "Chunarughat Upazila |Chunarughat Upazila ", "Habiganj Sadar Upazila |Habiganj Sadar Upazila ",  "Lakhai Upazila |Lakhai Upazila "
            ,"Madhabpur Upazila|Madhabpur Upazila","Nabiganj Upazila |Nabiganj Upazila"];
        }else if(district == 'Moulvibazar'){
            var upazila = ["|", "Barlekha Upazila |Barlekha Upazila ", "Kamalganj Upazila|Kamalganj Upazila", "Kulaura Upazila |Kulaura Upazila ", "Moulvibazar Sadar Upazila |Moulvibazar Sadar Upazila ", "Rajnagar Upazila |Rajnagar Upazila ",  "Sreemangal Upazila |Sreemangal Upazila "
            ,"Juri Upazila|Juri Upazila"];
        }else if(district == 'Sylhet'){
            var upazila = ["|", "Balaganj Upazila  |Balaganj Upazila  ", "Beanibazar Upazila |Beanibazar Upazila ", "Bishwanath Upazila |Bishwanath Upazila ", "Companigonj Upazila |Companigonj Upazila","Fenchuganj Upazila|Fenchuganj Upazila","Golapganj Upazila|Golapganj Upazila","Gowainghat Upazila|Gowainghat Upazila","Jaintiapur Upazila|Jaintiapur Upazila","Kanaighat Upazila|Kanaighat Upazila","Sylhet Sadar Upazila|Sylhet Sadar Upazila","Zakiganj Upazila|Zakiganj Upazila","South Surma Upazila|South Surma Upazila"];
        }else if(district == 'Sunamganj'){
            var upazila = ["|", "Bishwamvarpur Upazila |Bishwamvarpur Upazila ", "Chhatak Upazila|Chhatak Upazila", "Derai Upazila |Derai Upazila ", "Dharamapasha Upazila |Dharamapasha Upazila ", "Dowarabazar Upazila |Dowarabazar Upazila ",  "Jagannathpur Upazila |Jagannathpur Upazila "
            ,"Jamalganj Upazila|Jamalganj Upazila","Sullah Upazila |Sullah Upazila","Sunamganj Sadar Upazila|Sunamganj Sadar Upazila","Tahirpur Upazila|Tahirpur Upazila","Dakshin Sunamganj Upazila|Dakshin Sunamganj Upazila"];
        }else if(district == 'Netrokona'){
            var upazila = ["|", "Atpara Upazila |Atpara Upazila ", "Barhatta Upazila|Barhatta Upazila", "Durgapur Upazila |Durgapur Upazila ", "Khaliajuri Upazila |Khaliajuri Upazila ", "Kalmakanda Upazila |Kalmakanda Upazila ",  "Kendua Upazila |Kendua Upazila","Madan Upazila|Madan Upazila","Mohanganj Upazila|Mohanganj Upazila"
            ,"Netrokona Sadar Upazila|Netrokona Sadar Upazila","Purbadhala Upazila |Purbadhala Upazila"];
        }else if(district == 'Sherpur'){
            var upazila = ["|", "Jhenaigati Upazila |Jhenaigati Upazila ", "Nakla Upazila|Nakla Upazila", "Nalitabari Upazila |Nalitabari Upazila ", "Sherpur Sadar Upazila |Sherpur Sadar Upazila ", "Sreebardi Upazila |Sreebardi Upazila "];
        }else if(district == 'Jamalpur'){
            var upazila = ["|", "Baksiganj Upazila |Baksiganj Upazila ", "Dewanganj Upazila |Dewanganj Upazila ", "Islampur Upazila |Islampur Upazila ", "Jamalpur Sadar Upazila |Jamalpur Sadar Upazila ", "Madarganj Upazila |Madarganj Upazila ", "Melandaha Upazila |Melandaha Upazila "
            ,"Sarishabari Upazila |Sarishabari Upazila "];
        }else if(district == 'Mymensingh'){
            var upazila = ["|", "Bhaluka Upazila  |Bhaluka Upazila  ", "Dhobaura Upazila |Dhobaura Upazila ", "Fulbaria Upazila |Fulbaria Upazila ", "Gaffargaon Upazila |Gaffargaon Upazila","Gauripur Upazila|Gauripur Upazila","Haluaghat Upazila|Haluaghat Upazila","Ishwarganj Upazila|Ishwarganj Upazila","Mymensingh Sadar Upazila|Mymensingh Sadar Upazila","Muktagachha Upazila|Muktagachha Upazila","Nandail Upazila|Nandail Upazila"," Phulpur Upazila| Phulpur Upazila","Trishal Upazila|Trishal Upazila","Tara Khanda Upazila|Tara Khanda Upazila"];
        }else if(district == 'Joypurhat'){
            var upazila = ["|", "Akkelpur Upazila |Akkelpur Upazila ", "Joypurhat Sadar Upazila|Joypurhat Sadar Upazila", "Kalai Upazila |Kalai Upazila ", "Khetlal Upazila |Khetlal Upazila ", "Panchbibi Upazila |Panchbibi Upazila "];
        }else if(district == 'Bogra'){
            var upazila = ["|", "Adamdighi Upazila |Adamdighi Upazila ", "Bogra Sadar Upazila|Bogra Sadar Upazila", "Dhunat Upazila |Dhunat Upazila ", "Dhupchanchia Upazila |Dhupchanchia Upazila ", "Gabtali Upazila |Gabtali Upazila ",  "Kahaloo Upazila |Kahaloo Upazila "
            ,"Nandigram Upazila|Nandigram Upazila","Sariakandi Upazila |Sariakandi Upazila","Shajahanpur Upazila|Shajahanpur Upazila","Sherpur Upazila|Sherpur Upazila","Shibganj Upazila|Shibganj Upazila","Sonatola Upazila|Sonatola Upazila"];
        }else if(district == 'Naogaon'){
            var upazila = ["|", "Atrai Upazila |Atrai Upazila ", "Badalgachhi Upazila|Badalgachhi Upazila", "Manda Upazila |Manda Upazila ", "Dhamoirhat Upazila |Dhamoirhat Upazila ", "Mohadevpur Upazila |Mohadevpur Upazila ",  "Naogaon Sadar Upazila |Naogaon Sadar Upazila","Niamatpur Upazila|Niamatpur Upazila"
            ,"Patnitala Upazila|Patnitala Upazila","Porsha Upazila |Porsha Upazila","Porsha Upazila|Porsha Upazila","Raninagar Upazila|Raninagar Upazila","Sapahar Upazila|Sapahar Upazila"];
        }else if(district == 'Natore'){
            var upazila = ["|", "Bagatipara Upazila |Bagatipara Upazila ", "Baraigram Upazila |Baraigram Upazila ", "Gurudaspur Upazila |Gurudaspur Upazila ", "Lalpur Upazila |Lalpur Upazila ", "Natore Sadar Upazila |Natore Sadar Upazila ", "Singra Upazila |Singra Upazila "
            ,"Naldanga Upazila |Naldanga Upazila "];
        }else if(district == 'Nawabganj'){
            var upazila = ["|", "Bholahat Upazila  |Bholahat Upazila  ", "Gomastapur Upazila |Gomastapur Upazila ", "Nachole Upazila |Nachole Upazila", "Nawabganj Sadar Upazila |Nawabganj Sadar Upazila","Shibganj Upazila|Shibganj Upazila"];
        }else if(district == 'Pabna'){
            var upazila = ["|", "Ataikula Upazila |Ataikula Upazila ", "Atgharia Upazila|Atgharia Upazila", "Bera Upazila |Bera Upazila ", "Bhangura Upazila |Bhangura Upazila ", "Chatmohar Upazila |Chatmohar Upazila ",  "Faridpur Upazila |Faridpur Upazila "
            ,"Ishwardi Upazila|Ishwardi Upazila","Pabna Sadar Upazila |Pabna Sadar Upazila","Santhia Upazila|Santhia Upazila","Sujanagar Upazila|Sujanagar Upazila"];
        }else if(district == 'Sirajganj '){
            var upazila = ["|", "Belkuchi Upazila |Belkuchi Upazila ", "Chauhali Upazila|Chauhali Upazila", "Kamarkhanda Upazila |Kamarkhanda Upazila ", "Kazipur Upazila |Kazipur Upazila ", "Raiganj Upazila |Raiganj Upazila ",  "Shahjadpur Upazila |Shahjadpur Upazila "
            ," Sirajganj Sadar Upazila| Sirajganj Sadar Upazila","Tarash Upazila |Tarash Upazila","Ullahpara Upazila|Ullahpara Upazila"];
        }else if(district == 'Rajshahi'){
            var upazila = ["|", "Bagha Upazila |Bagha Upazila ", "Bagmara Upazila|Bagmara Upazila", "Charghat Upazila |Charghat Upazila ", "Durgapur Upazila |Durgapur Upazila ", "Godagari Upazila |Godagari Upazila ",  "Mohanpur Upazila |Mohanpur Upazila ","Paba Upazila|Paba Upazila"
            ,"Puthia Upazila|Puthia Upazila","Tanore Upazila |Tanore Upazila"];
        }else if(district == 'Bagerhat '){
            var upazila = ["|", "Bagerhat Sadar Upazila |Bagerhat Sadar Upazila ", "Chitalmari Upazila |Chitalmari Upazila ", "Fakirhat Upazila |Fakirhat Upazila ", "Kachua Upazila |Kachua Upazila ", "Mollahat Upazila |Mollahat Upazila ", "Mongla Upazila |Mongla Upazila "
            ,"Morrelganj Upazila |Morrelganj Upazila ","Rampal Upazila |Rampal Upazila","Sarankhola Upazila|Sarankhola Upazila"];
        }else if(district == 'Chuadanga'){
            var upazila = ["|", "Alamdanga Upazila  |Alamdanga Upazila  ", "Chuadanga Sadar Upazila |Chuadanga Sadar Upazila ", "Damurhuda Upazila |Damurhuda Upazila ", "Jibannagar Upazila |Jibannagar Upazila"];
        }else if(district == 'Jessore'){
            var upazila = ["|", "Abhaynagar Upazila |Abhaynagar Upazila ", "Bagherpara Upazila|Bagherpara Upazila", "Chaugachha Upazila |Chaugachha Upazila ", "Jhikargachha Upazila |Jhikargachha Upazila ", "Keshabpur Upazila |Keshabpur Upazila ",  "Jessore Sadar Upazila |Jessore Sadar Upazila "
            ,"Manirampur Upazila|Manirampur Upazila","Sharsha Upazila |Sharsha Upazila"];
        }else if(district == 'Jhenaida'){
            var upazila = ["|", "Harinakunda Upazila |Harinakunda Upazila ", "Jhenaidah Sadar Upazila|Jhenaidah Sadar Upazila", "Kaliganj Upazila |Kaliganj Upazila ", "Kotchandpur Upazila |Kotchandpur Upazila ", "Maheshpur Upazila |Maheshpur Upazila ",  "Shailkupa Upazila |Shailkupa Upazila "];
        }else if(district == 'Khulna'){
            var upazila = ["|", "Batiaghata Upazila |Batiaghata Upazila ", "Dacope Upazila |Dacope Upazila ", "Kurigram |Kurigram ", "Dumuria Upazila |Dumuria Upazila ", "Dighalia Upazila |Dighalia Upazila ", "Koyra Upazila |Koyra Upazila ","Paikgachha Upazila|Paikgachha Upazila","Phultala Upazila|","Rupsha Upazila|Rupsha Upazila","Terokhada Upazila|Terokhada Upazila","Daulatpur Thana|Daulatpur Thana","Khalishpur Thana|Khalishpur Thana","Khan Jahan Ali Thana|Khan Jahan Ali Thana","Kotwali Thana|Kotwali Thana"
            ,"Sonadanga Thana |Sonadanga Thana ","Harintana Thana |Harintana Thana"];
        }else if(district == 'Kushtia'){
            var upazila = ["|", "Bheramara Upazila  |Bheramara Upazila  ", "Daulatpur Upazila |Daulatpur Upazila ", "Khoksa Upazila |Khoksa Upazila ", "Kumarkhali Upazila |Kumarkhali Upazila"," Kushtia Sadar Upazila| Kushtia Sadar Upazila","Mirpur Upazila|Mirpur Upazila"];
        }else if(district == 'Magura'){
            var upazila = ["|", "Magura Sadar Upazila |Magura Sadar Upazila ", "Mohammadpur Upazila|Mohammadpur Upazila", "Shalikha Upazila |Shalikha Upazila ", "Sreepur Upazila |Sreepur Upazila "];
        }else if(district == 'Meherpur'){
            var upazila = ["|", "Gangni Upazila |Gangni Upazila ", "Meherpur Sadar Upazila|Meherpur Sadar Upazila", "Mujibnagar Upazila |Mujibnagar Upazila "];
        }else if(district == 'Narail'){
            var upazila = ["|", "Kalia Upazila |Kalia Upazila", "Lohagara Upazila |Lohagara Upazila ", "Narail Sadar Upazila |Narail Sadar Upazila ", "Naragati Thana |Naragati Thana "];
        }else if(district == 'Satkhira'){
            var upazila = ["|", "Assasuni Upazila  |Assasuni Upazila  ", "Debhata Upazila |Kalaroa Upazila ", "Kalaroa Upazila |Kalaroa Upazila ", "Kaliganj Upazila |Kaliganj Upazila"," Satkhira Sadar Upazila| Satkhira Sadar Upazila","Shyamnagar Upazila|Shyamnagar Upazila","Tala Upazila|Tala Upazila"];
        }else if(district == 'Dinajpur'){
            var upazila = ["|", "Birampur Upazila |Birampur Upazila ", "Birganj Upazila|Birganj Upazila", "Biral Upazila |Biral Upazila ", "Bochaganj Upazila |Bochaganj Upazila ", "Chirirbandar Upazila |Chirirbandar Upazila ",  "Phulbari Upazila |Phulbari Upazila ","Ghoraghat Upazila|Ghoraghat Upazila","Hakimpur Upazila|Hakimpur Upazila","Kaharole Upazila|Kaharole Upazila","Khansama Upazila|Khansama Upazila","Dinajpur Sadar Upazila|Dinajpur Sadar Upazila"
            ,"Nawabganj Upazila|Nawabganj Upazila","Parbatipur Upazila |Parbatipur Upazila"];
        }else if(district == 'Gaibandha'){
            var upazila = ["|", "Phulchhari Upazila |Phulchhari Upazila ", "Gaibandha Sadar Upazila|Gaibandha Sadar Upazila", "Gobindaganj Upazila |Gobindaganj Upazila", "Palashbari Upazila |Palashbari Upazila ", "Sadullapur Upazila |Sadullapur Upazila ",  "Sughatta Upazila |Sughatta Upazila "
            ,"Sundarganj Upazila|Sundarganj Upazila"];
        }else if(district == 'Kurigram'){
            var upazila = ["|", "Bhurungamari Upazila |Bhurungamari Upazila ", "Char Rajibpur Upazila |Char Rajibpur Upazila ", "Chilmari Upazila |Chilmari Upazila ", "Phulbari Upazila |Phulbari Upazila ", "Kurigram Sadar Upazila |Kurigram Sadar Upazila ", " Nageshwari Upazila | Nageshwari Upazila "
            ,"Rajarhat Upazila|Rajarhat Upazila","Raomari Upazila |Raomari Upazila","Ulipur Upazila"];
        }else if(district == 'Lalmonirhat'){
            var upazila = ["|", "Aditmari Upazila|Aditmari Upazila", "Hatibandha Upazila |Hatibandha Upazila ", "Kaliganj Upazila |Kaliganj Upazila ", "Lalmonirhat Sadar Upazila |Lalmonirhat Sadar Upazila","Patgram Upazila|Patgram Upazila"];
        }else if(district == 'Nilphamari'){
            var upazila = ["|", "Dimla Upazila |Dimla Upazila ", "Domar Upazila|Domar Upazila", "Jaldhaka Upazila |Jaldhaka Upazila ", "Kishoreganj Upazila |Kishoreganj Upazila ", "Nilphamari Sadar Upazila |Nilphamari Sadar Upazila ",  "Saidpur Upazila |Saidpur Upazila "];
        }else if(district == 'Panchagarh'){
            var upazila = ["|", "Atwari Upazila|Atwari Upazila ", "Boda Upazila|Boda Upazila", "Debiganj Upazila|Debiganj Upazila ", "Panchagarh Sadar Upazila |Panchagarh Sadar Upazila ", "Tetulia Upazila |Tetulia Upazila"];
        }else if(district == 'Rangpur'){
            var upazila = ["|", "Badarganj Upazila |Badarganj Upazila ", "Gangachhara Upazila |Gangachhara Upazila ", "Kaunia Upazila |Kaunia Upazila ", " Rangpur Sadar Upazila | Rangpur Sadar Upazila ", "Mithapukur Upazila |Mithapukur Upazila ", "Pirgachha Upazila |Pirgachha Upazila "
            ,"Pirganj Upazila |Pirganj Upazila ","Taraganj Upazila |Taraganj Upazila"];
        }else if(district == 'Thakurgaon'){
            var upazila = ["|", "Baliadangi Upazila|Baliadangi Upazila  ", "Haripur Upazila |Haripur Upazila ", "Pirganj Upazila |Pirganj Upazila ", "Ranisankail Upazila |Ranisankail Upazila","Thakurgaon Sadar Upazila|Thakurgaon Sadar Upazila"];
        }
        for (var option in upazila) {
            var pair = upazila[option].split("|");
//            var newDistrict = document.createElement("option");
//            newDistrict.value = pair[0];
//            newDistrict.innerHTML = pair[1];
//            distName.options.add(newDistrict);
            $('.upazila').prepend('<option value="'+pair[0]+'">'+pair[1]+'</option>');
        }
    });



</script>