<?php

/*
 * To change this license header]=choose License Headers in Project Properties.
 * To change this template file]=choose Tools | Templates
 * and open the template in the editor.
 */
$config['SITE'] = array(
    "name" => "Advanced Publications",
    'website' => "http://advancedpublication.com/",
    'logo'=>'advanced Pub logo.png');

$config['main_sidebar_title'] = "Advanced Publications <br> MGMT";

$config['DEVELOPER'] = array(
    "name" => "Friends IT",
    'website' => "http://friendsitltd.com/");

//(coma separated integer) Jodi kono shoujonno shonkha thake contact e 
 //ekta speciment contact add kore tar id ekhe add kore dite hobe .
//if nothing found add a negetive integer
$config['speciment_contact_id'] = '3';
$config['new_stock_ordering_contact_id'] = '';
$config['ADTOADVANCED'] = '<div class="row" style="margin: 13mm 5mm 5mm 5mm;padding-top:0px">';
$config['ASSET_FOLDER'] = "asset/";
$config['ADMIN_THEME'] = 'Admin_theme/AdminLTE/'; //Theme location on view folder
$config['THEME_ASSET'] = $config['ASSET_FOLDER'] . $config['ADMIN_THEME'];
$config['book_categories'] = array('Bangla', 'English', 'Math', 'ICT');
$config['LOGIN_THEME'] = 'Login_theme/facebook-login/'; //Theme location on view folder
$config['book_categories'] = array(
    'উচ্চমাধ্যমিক',
    'স্নাতক(পাস)',
    'স্নাতক(অনার্স)',
    'স্নাতকোত্তর'
);
$config['storing_place'] = array(
    'Printing Press' => 'Printing Press',
    'Binding Store' => 'Binding Store',
    'Sales Store' => 'Sales Store');
$config['contact_type'] = array(
    'Buyer' => 'Buyer',
    'Printing Press' => 'Printing Press',
    'Binding Store' => 'Binding Store',
    'Sales Store' => 'Sales Store',
    'Other' => 'Other');
$config['division'] = array('', 'Barisal', 'Chittagong', 'Dhaka', 'Khulna', 'Mymensingh', 'Rajshahi', 'Rangpur', 'Sylhet');
//DB tables
$config['db_tables'] = array(
    'ci_sessionsHide' => 'ci_sessionsHide',
    'login_attempts' => 'login_attempts',
    'pub_books' => 'pub_books',
    'pub_contacts' => 'pub_contacts',
    'pub_contacts_teacher' => 'pub_contacts_teacher',
    'pub_books_return' => 'pub_books_return',
    'pub_memos' => 'pub_memos',
    'pub_memos_selected_books' => 'pub_memos_selected_books',
    'pub_send_to_rebind' => 'pub_send_to_rebind',
    'pub_stock' => 'pub_stock',
    'users' => 'users',
    'pub_cost' => 'pub_cost',
    'user_autologin' => 'user_autologin',
    'user_profiles' => 'user_profiles',
    'pub_due_log' => 'pub_due_log',
    'pub_due_payment_ledger' => 'pub_due_payment_ledger',
    'pub_stock_transfer_log' => 'pub_stock_transfer_log');


$config['upazila_english'] = array("",
    "Abhaynagar ",
    "Adamdighi ",
    "Aditmari ",
    "Agailjhara ",
    "Ajmiriganj ",
    "Akhaura ",
    "Akkelpur ",
    "Alamdanga ",
    "Alfadanga ",
    "Ali Kadam ",
    "Amtali ",
    "Anwara ",
    "Araihazar ",
    "Ashuganj ",
    "Assasuni ",
    "Astagram ",
    "Ataikula ",
    "Atgharia ",
    "Atpara ",
    "Atrai ",
    "Atwari ",
    "Babuganj ",
    "Badalgachhi ",
    "Badarganj ",
    "Bagaichhari ",
    "Bagatipara ",
    "Bagerhat Sadar ",
    "Bagha ",
    "Bagherpara ",
    "Bagmara ",
    "Bahubal ",
    "Bajitpur ",
    "Bakerganj ",
    "Baksiganj ",
    "Balaganj ",
    "Baliadangi ",
    "Baliakandi ",
    "Bamna ",
    "Banaripara ",
    "Bancharampur ",
    "Bandar ",
    "Bandarban Sadar ",
    "Bandor (Chittagong Port) Thana",
    "Baniyachong ",
    "Banshkhali ",
    "Baraigram ",
    "Barguna Sadar ",
    "Barhatta ",
    "Barisal Sadar ",
    "Barkal ",
    "Barlekha ",
    "Barura ",
    "Basail ",
    "Batiaghata ",
    "Bauphal ",
    "Beanibazar ",
    "Begumganj ",
    "Belabo ",
    "Belaichhari ",
    "Belkuchi ",
    "Bera ",
    "Betagi ",
    "Bhairab ",
    "Bhaluka ",
    "Bhandaria ",
    "Bhanga ",
    "Bhangura ",
    "Bhedarganj ",
    "Bheramara ",
    "Bhola Sadar ",
    "Bholahat ",
    "Bhuapur ",
    "Bhurungamari ",
    "Bijoynagar ",
    "Biral ",
    "Birampur ",
    "Birganj ",
    "Bishwamvarpur ",
    "Bishwanath ",
    "Boalia Thana",
    "Boalkhali ",
    "Boalmari ",
    "Bochaganj ",
    "Boda ",
    "Bogra Sadar ",
    "Brahmanbaria Sadar ",
    "Brahmanpara ",
    "Burhanuddin ",
    "Burichang ",
    "Chakaria ",
    "Chandanaish ",
    "Chandgaon Thana",
    "Chandina ",
    "Chandpur Sadar ",
    "Char Fasson ",
    "Char Rajibpur ",
    "Charbhadrasan ",
    "Charghat ",
    "Chatkhil ",
    "Chatmohar ",
    "Chauddagram ",
    "Chaugachha ",
    "Chauhali ",
    "Chhagalnaiya ",
    "Chhatak ",
    "Chilmari ",
    "Chirirbandar ",
    "Chitalmari ",
    "Chuadanga Sadar ",
    "Chunarughat ",
    "Comilla Adarsha Sadar ",
    "Comilla Sadar Dakshin ",
    "Companiganj ",
    "Companigonj ",
    "Cox's Bazar Sadar ",
    "Dacope ",
    "Daganbhuiyan ",
    "Damudya ",
    "Damurhuda ",
    "Dashmina ",
    "Daudkandi ",
    "Daulatkhan ",
    "Daulatpur Thana",
    "Daulatpur ",
    "Daulatpur ",
    "Debhata ",
    "Debidwar ",
    "Debiganj ",
    "Delduar ",
    "Derai ",
    "Dewanganj ",
    "Dhamoirhat ",
    "Dhamrai ",
    "Dhanbari ",
    "Dharampasha ",
    "Dhobaura ",
    "Dhunat ",
    "Dhupchanchia ",
    "Dighalia ",
    "Dighinala ",
    "Dimla ",
    "Dinajpur Sadar ",
    "Dohar ",
    "Domar ",
    "Double Mooring Thana",
    "Dowarabazar ",
    "Dumki ",
    "Dumuria ",
    "Durgapur ",
    "Durgapur ",
    "Fakirhat ",
    "Faridganj ",
    "Faridpur Sadar ",
    "Faridpur ",
    "Fatikchhari ",
    "Fenchuganj ",
    "Feni Sadar ",
    "Fulbaria ",
    "Fulgazi ",
    "Gabtali ",
    "Gaffargaon ",
    "Gaibandha Sadar ",
    "Galachipa ",
    "Gangachhara ",
    "Gangni ",
    "Gauripur ",
    "Gaurnadi ",
    "Gazaria ",
    "Gazipur Sadar ",
    "Ghatail ",
    "Ghior ",
    "Ghoraghat ",
    "Goalandaghat ",
    "Gobindaganj ",
    "Godagari ",
    "Golapganj ",
    "Gomastapur ",
    "Gopalganj Sadar ",
    "Gopalpur ",
    "Gosairhat ",
    "Gowainghat ",
    "Gurudaspur ",
    "Habiganj Sadar ",
    "Haimchar ",
    "Hakimpur ",
    "Haluaghat ",
    "Harinakunda ",
    "Harintana Thana",
    "Haripur ",
    "Harirampur ",
    "Hathazari ",
    "Hatibandha ",
    "Hatiya ",
    "Haziganj ",
    "Hizla ",
    "Homna ",
    "Hossainpur ",
    "Ishwardi ",
    "Ishwarganj ",
    "Islampur ",
    "Itna ",
    "Jagannathpur ",
    "Jaintiapur ",
    "Jaldhaka ",
    "Jamalganj ",
    "Jamalpur Sadar ",
    "Jessore Sadar ",
    "Jhalokati Sadar ",
    "Jhenaidah Sadar ",
    "Jhenaigati ",
    "Jhikargachha ",
    "Jibannagar ",
    "Joypurhat Sadar ",
    "Juraichhari ",
    "Juri ",
    "Kabirhat ",
    "Kachua ",
    "Kachua ",
    "Kahaloo ",
    "Kaharole ",
    "Kalai ",
    "Kalapara ",
    "Kalaroa ",
    "Kalia ",
    "Kaliakair ",
    "Kaliganj ",
    "Kaliganj ",
    "Kaliganj ",
    "Kaliganj ",
    "Kalihati ",
    "Kalkini ",
    "Kalmakanda ",
    "Kalukhali ",
    "Kamalganj ",
    "Kamalnagar ",
    "Kamarkhanda ",
    "Kanaighat ",
    "Kapasia ",
    "Kaptai ",
    "Karimganj ",
    "Kasba ",
    "Kashiani ",
    "Kathalia ",
    "Katiadi ",
    "Kaunia ",
    "Kawkhali (Betbunia) ",
    "Kawkhali ",
    "Kazipur ",
    "Kendua ",
    "Keraniganj ",
    "Keshabpur ",
    "Khagrachhari ",
    "Khaliajuri ",
    "Khalishpur Thana",
    "Khan Jahan Ali Thana",
    "Khansama ",
    "Khetlal ",
    "Khoksa ",
    "Kishoreganj Sadar ",
    "Kishoreganj ",
    "Kotalipara ",
    "Kotchandpur ",
    "Kotwali Thana",
    "Kotwali Thana",
    "Koyra ",
    "Kulaura ",
    "Kuliarchar ",
    "Kumarkhali ",
    "Kurigram Sadar ",
    "Kushtia Sadar ",
    "Kutubdia ",
    "Lakhai ",
    "Laksam ",
    "Lakshmichhari ",
    "Lakshmipur Sadar ",
    "Lalmohan ",
    "Lalmonirhat Sadar ",
    "Lalpur ",
    "Lama ",
    "Langadu ",
    "Lohagara ",
    "Lohagara ",
    "Lohajang ",
    "Madan ",
    "Madarganj ",
    "Madaripur Sadar ",
    "Madhabpur ",
    "Madhukhali ",
    "Madhupur ",
    "Magura Sadar ",
    "Mahalchhari ",
    "Maheshkhali ",
    "Maheshpur ",
    "Manda ",
    "Manikchhari ",
    "Manikgonj Sadar ",
    "Manirampur ",
    "Manpura ",
    "Mathbaria ",
    "Matihar Thana",
    "Matiranga ",
    "Matlab Dakshin ",
    "Matlab Uttar ",
    "Meghna ",
    "Mehendiganj ",
    "Meherpur Sadar ",
    "Melandaha ",
    "Mirpur ",
    "Mirsharai ",
    "Mirzaganj ",
    "Mirzapur ",
    "Mithamain ",
    "Mithapukur ",
    "Mohadevpur ",
    "Mohammadpur ",
    "Mohanganj ",
    "Mohanpur ",
    "Mollahat ",
    "Mongla ",
    "Monohardi ",
    "Monohargonj ",
    "Morrelganj ",
    "Moulvibazar Sadar ",
    "Mujibnagar ",
    "Muksudpur ",
    "Muktagachha ",
    "Muladi ",
    "Munshiganj Sadar ",
    "Muradnagar ",
    "Mymensingh Sadar ",
    "Nabiganj ",
    "Nabinagar ",
    "Nachole ",
    "Nagarkanda ",
    "Nagarpur ",
    "Nageshwari ",
    "Naikhongchhari ",
    "Nakla ",
    "Nalchity ",
    "Naldanga ",
    "Nalitabari ",
    "Nandail ",
    "Nandigram ",
    "Nangalkot ",
    "Naniyachar ",
    "Naogaon Sadar ",
    "Naragati Thana",
    "Narail Sadar ",
    "Narayanganj Sadar ",
    "Naria ",
    "Narsingdi Sadar ",
    "Nasirnagar ",
    "Natore Sadar ",
    "Nawabganj Sadar ",
    "Nawabganj ",
    "Nawabganj ",
    "Nazirpur ",
    "Nesarabad (Swarupkati) ",
    "Netrokona Sadar ",
    "Niamatpur ",
    "Nikli ",
    "Nilphamari Sadar ",
    "Noakhali Sadar ",
    "Paba ",
    "Pabna Sadar ",
    "Pahartali Thana",
    "Paikgachha ",
    "Pakundia ",
    "Palash ",
    "Palashbari ",
    "Panchagarh Sadar ",
    "Panchbibi ",
    "Panchhari ",
    "Panchlaish Thana",
    "Pangsha ",
    "Parbatipur ",
    "Parshuram ",
    "Patgram ",
    "Patharghata ",
    "Patiya ",
    "Patnitala ",
    "Patuakhali Sadar ",
    "Pekua ",
    "Phulbari ",
    "Phulbari ",
    "Phulchhari ",
    "Phulpur ",
    "Phultala ",
    "Pirgachha ",
    "Pirganj ",
    "Pirganj ",
    "Pirojpur Sadar ",
    "Porsha ",
    "Purbadhala ",
    "Puthia ",
    "Raiganj ",
    "Raipur ",
    "Raipura ",
    "Rajapur ",
    "Rajarhat ",
    "Rajasthali ",
    "Rajbari Sadar ",
    "Rajnagar ",
    "Rajoir ",
    "Rajpara Thana",
    "Ramganj ",
    "Ramgarh ",
    "Ramgati ",
    "Rampal ",
    "Ramu ",
    "Rangabali ",
    "Rangamati Sadar ",
    "Rangpur Sadar ",
    "Rangunia ",
    "Raninagar ",
    "Ranisankail ",
    "Raomari ",
    "Raozan ",
    "Rowangchhari ",
    "Ruma ",
    "Rupganj ",
    "Rupsha ",
    "Sadarpur ",
    "Sadullapur ",
    "Saidpur ",
    "Sakhipur ",
    "Saltha ",
    "Sandwip ",
    "Santhia ",
    "Sapahar ",
    "Sarail ",
    "Sarankhola ",
    "Sariakandi ",
    "Sarishabari ",
    "Satkania ",
    "Satkhira Sadar ",
    "Saturia ",
    "Savar ",
    "Senbagh ",
    "Shah Mokdum Thana",
    "Shahjadpur ",
    "Shahrasti ",
    "Shailkupa ",
    "Shajahanpur ",
    "Shakhipur ",
    "Shalikha ",
    "Shariatpur Sadar ",
    "Sharsha ",
    "Shekhpara ",
    "Sherpur Sadar ",
    "Sherpur ",
    "Shibchar ",
    "Shibganj ",
    "Shibganj ",
    "Shibpur ",
    "Shivalaya ",
    "Shyamnagar ",
    "Singair ",
    "Singra ",
    "Sirajdikhan ",
    "Sirajganj Sadar ",
    "Sitakunda ",
    "Sonadanga Thana",
    "Sonagazi ",
    "Sonaimuri ",
    "Sonargaon ",
    "Sonatola ",
    "South Shurma ",
    "South Sunamganj ",
    "Sreebardi ",
    "Sreemangal ",
    "Sreenagar ",
    "Sreepur ",
    "Sreepur ",
    "Subarnachar ",
    "Sughatta ",
    "Sujanagar ",
    "Sullah ",
    "Sunamganj Sadar ",
    "Sundarganj ",
    "Sylhet Sadar ",
    "Tahirpur ",
    "Tala ",
    "Taltoli ",
    "Tangail Sadar ",
    "Tanore ",
    "Tara Khanda ",
    "Taraganj ",
    "Tarail ",
    "Tarash ",
    "Tazumuddin ",
    "Teknaf ",
    "Terokhada ",
    "Tetulia ",
    "Thakurgaon Sadar ",
    "Thanchi ",
    "Titas ",
    "Tongibari ",
    "Trishal ",
    "Tungipara ",
    "Ukhia ",
    "Ulipur ",
    "Ullahpara ",
    "Wazirpur ",
    "Zakiganj ",
    "Zanjira ",
    "Zianagor ");

$config['districts_english'] = array("",
    'Bagerhat',
    'Bandarban',
    'Barguna',
    'Barisal',
    'Bogra',
    'Bhola',
    'Brahmanbaria',
    'Comilla',
    'Cox\'s Bazar',
    'Chandpur',
    'Chapainawabganj',
    'Chittagong',
    'Chuadanga',
    'Dinajpur',
    'Dhaka',
    'Faridpur',
    'Feni',
    'Gaibandha',
    'Gazipur',
    'Gopalganj',
    'Habiganj',
    'Jamalpur',
    'Jessore',
    'Joypurhat',
    'Jhalokati',
    'Jhenaidah',
    'Kishoreganj',
    'Khagrachhari',
    'Khulna',
    'Kurigram',
    'Kushtia',
    'Lakshmipur',
    'Lalmonirhat',
    'Madaripur',
    'Magura',
    'Manikganj',
    'Meherpur',
    'Moulvibazar',
    'Munshiganj',
    'Mymensingh',
    'Naogaon',
    'Narail',
    'Narayanganj',
    'Narsingdi',
    'Natore',
    'Nilphamari',
    'Netrakona',
    'Noakhali',
    'Pabna',
    'Panchagarh',
    'Patuakhali',
    'Pirojpur',
    'Rajbari',
    'Rajshahi',
    'Rangamati',
    'Rangpur',
    'Satkhira',
    'Sirajganj',
    'Shariatpur',
    'Sherpur',
    'Sunamganj',
    'Sylhet',
    'Tangail',
    'Thakurgaon');

$config['districts_bangla'] = array('বরগুনা', 'বরিশাল', 'ভোলা', 'ঝালকাঠি', 'পটুয়াখালী', 'পিরোজপুর', 'বান্দরবান', 'ব্রাহ্মণবাড়ীয়া', 'চাঁদপুর', 'চট্টগ্রাম', 'কুমিল্লা', 'কক্সবাজার', 'ফেনী', 'খাগড়াছড়ি', 'লক্ষীপুর', 'নোয়াখালী', 'রাঙ্গামাটি', 'ঢাকা', 'ফরিদপুর', 'গাজীপুর', 'গোপালগঞ্জ', 'কিশোরগঞ্জ', 'মাদারীপুর', 'মানিকগঞ্জ', 'মুন্সীগঞ্জ', 'নারায়ণগঞ্জ', 'নরসিংদী', 'রাজবাড়ী', 'শরীয়তপুর', 'টাঙ্গাইল', 'বাগেরহাট', 'চুয়াডাঙ্গা', 'যশোর', 'ঝিনাইদহ', 'খুলনা', 'কুষ্টিয়া', 'মাগুরা', 'মেহেরপুর', 'নড়াইল', 'সাতক্ষিরা', 'জামালপুর', 'ময়মনসিংহ', 'নেত্রকোনা', 'শেরপুর', 'বগুড়া', 'জয়পুরহাট', 'নওগাঁ', 'নাটোর', 'নওয়াবগঞ্জ', 'পাবনা', 'রাজশাহী', 'সিরাজগঞ্জ', 'দিনাজপুর', 'গাইবান্ধা', 'কুড়িগ্রাম', 'লালমনিরহাট', 'নীলফামারী', 'পঞ্চগড়', 'রংপুর', 'ঠাকুরগাঁ', 'হবিগঞ্জ', 'মৌলভীবাজার',
    'সুনামগঞ্জ', 'সিলেট');

function make_index_same_as_value($array) {
    foreach ($array as $index => $value) {
        $product_array[$value] = $value;
    }
    return $product_array;
}

$config['districts_english'] = make_index_same_as_value($config['districts_english']);
$config['upazila_english'] = make_index_same_as_value($config['upazila_english']);
$config['division'] = make_index_same_as_value($config['division']);
$config['book_categories'] = make_index_same_as_value($config['book_categories']);
//$config['districts_bangla'] = make_index_same_as_value($config['districts_bangla']);

$config['super_user_id'] ='2';
$config['custom_user_menu'] ='1';