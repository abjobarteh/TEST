<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/showss.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
</head>

<?php
ob_start();
session_start();
$school =  $_SESSION['school'];
$sid = $_SESSION['sid'];
include 'connect.php'; ?>
<style>
    .field select:focus {
        padding-left: 47px;
        border: 2px solid #04716f;
        background-color: #ffffff;
    }

    .field select:focus~i {
        color: #04716f;
    }
</style>
<?php
// Include the auto_logout.php file
include('auto_logout.php');

// Your page content goes here
// ...
?>

<body>
    <form class="container" enctype="multipart/form-data" action="edit_teacher.php" method="post">
        <div class="com">
            <h3 style="color:#04716f;">Academix: School Management System</h3>
            <h3 class="title" style="justify-content:center; text-align:center; color:#04716f; 	font-size: 18px;"><?php echo $school ?>
                </h2>
                <?php
                $stmt = oci_parse($conn, "select * from school where school = :name");
                oci_bind_by_name($stmt, ':name', $school);
                oci_execute($stmt);
                if ($rowS = oci_fetch_array($stmt)) {
                    $imageData = $rowS['LOGO']->load(); // Load OCILob data

                    // Encode the image data as base64
                    $base64Image = base64_encode($imageData);
                ?> <td style=" padding: 5px 8px; font-size: 10px; margin: 5px;"><?php

                                                                                echo '<img src="data:image/png;base64,' . $base64Image . '" alt="Image" style="width: 100px; height: 100px;">'; ?></td> <?php
                                                                                                                                                                                                    }
                                                                                                                                                                                                        ?>
        </div>
        <div class="buttons">
            <button class="backBtn" type="submit" style="width: 150px;">

                <a class="btnText" href="admin.php" style="font-size: 15px;">
                    HOME
                    <i class="uil uil-estate" style="width: 50px;"></i>
                </a>
                
            </button>
        </div>
        <header>Edit Teacher</header>

        <?php
        include 'connect.php';

        include 'connect.php';
        $region = " ";
        ?>
        </div>
 
        <div class="input-container" style="display: flex;">

            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">Field</label>
                <select name="field" required>
                    <option disabled selected>Select Field To Update</option>
                    <option>FIRSTNAME</option>
                    <option>MIDDLENAME</option>
                    <option>LASTNAME</option>
                    <option>DATE OF BIRTH</option>
                    <option>GENDER</option>
                    <option>ADDRESS</option>
                    <option>NATIONALITY</option>
                    <option>ID</option>
                    <option>ID ISSUE DATE</option>
                    <option>ID EXPIRY DATE</option>
                    <option>MOBILE</option>
                    <option>WORK</option>
                    <option>EMAIL</option>
                    <option>MARITAL STATUS</option>
                    <option>APPOINTMENT DATE</option>
                    <option>STATUS</option>
                    <option>QUALIFICATION</option>
                    <option>DEPARTMENT</option>
                    <option>PASSPORT SIZE PHOTO</option>
                    <option>ID DOCUMENT</option>
                    <option>EDUCATION DOCUMENT</option>
                </select>
            </div>
            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">Teacher</label>
                <select name="user" required>
                    <option disabled selected>Select Teacher</option>
                    <?php
                    $get_hos = "select distinct(e.name) from school s join school_users u on (s.s_id=u.s_id) join employee e on (s.s_id=e.s_id) where e.s_id = $sid and u.rights = 'TEACHER'  and e.status = 'ACTIVE' ";
                    $get = oci_parse(oci_connect($username, $password, $connection), $get_hos);
                    oci_execute($get);
                    while ($row = oci_fetch_array($get)) {
                    ?><option>
                            <?php echo $row["NAME"]; ?>
                        </option> <?php
                                }
                                    ?>
                </select>
            </div>
        </div>
        <div class="input-container" style="display: flex;">

            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">Firstname</label>
                <input type="text" placeholder="Enter Firstname" title="Only Letters" pattern="[A-z]+" name="first">
            </div>

            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">Middlename</label>
                <input type="text" placeholder="Enter Middlename" title="Only Letters" pattern="[A-z ]+" name="middle">
            </div>

            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">Lastname</label>
                <input type="text" placeholder="Enter Lastname" title="Only Letters" pattern="[A-z0-9]+" name="last">
            </div>

            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">Date Of Birth</label>
                <input type="date" placeholder="Enter Date Of Birth" title="Only Letters" pattern="[A-z]+" name="dob" max="<?php echo date('Y-m-d', strtotime('-18 years')); ?>" title="ONLY 18 AND ABOVE">
            </div>

            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">Gender</label>
                <select name="gender">
                    <option disabled selected>Select Gender</option>
                    <option>MALE</option>
                    <option>FEMALE</option>
                    <option>OTHER</option>
                </select>
            </div>
        </div>

        <div class="input-container" style="display: flex;">

            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">Address</label>
                <input type="text" placeholder="Enter Address" title="Only Letters" pattern="[A-z0-9 ]+" name="address">
            </div>

            <div class="input-field" style="margin-right: 10px; ">
                <label>Nationality</label>
                <select name="nationality" required>
                    <option disabled selected>Select Nationality</option>
                    <option value="afghan">Afghan</option>
                    <option value="albanian">Albanian</option>
                    <option value="algerian">Algerian</option>
                    <option value="american">American</option>
                    <option value="andorran">Andorran</option>
                    <option value="angolan">Angolan</option>
                    <option value="antiguans">Antiguans</option>
                    <option value="argentinean">Argentinean</option>
                    <option value="armenian">Armenian</option>
                    <option value="australian">Australian</option>
                    <option value="austrian">Austrian</option>
                    <option value="azerbaijani">Azerbaijani</option>
                    <option value="bahamian">Bahamian</option>
                    <option value="bahraini">Bahraini</option>
                    <option value="bangladeshi">Bangladeshi</option>
                    <option value="barbadian">Barbadian</option>
                    <option value="barbudans">Barbudans</option>
                    <option value="batswana">Batswana</option>
                    <option value="belarusian">Belarusian</option>
                    <option value="belgian">Belgian</option>
                    <option value="belizean">Belizean</option>
                    <option value="beninese">Beninese</option>
                    <option value="bhutanese">Bhutanese</option>
                    <option value="bolivian">Bolivian</option>
                    <option value="bosnian">Bosnian</option>
                    <option value="brazilian">Brazilian</option>
                    <option value="british">British</option>
                    <option value="bruneian">Bruneian</option>
                    <option value="bulgarian">Bulgarian</option>
                    <option value="burkinabe">Burkinabe</option>
                    <option value="burmese">Burmese</option>
                    <option value="burundian">Burundian</option>
                    <option value="cambodian">Cambodian</option>
                    <option value="cameroonian">Cameroonian</option>
                    <option value="canadian">Canadian</option>
                    <option value="cape verdean">Cape Verdean</option>
                    <option value="central african">Central African</option>
                    <option value="chadian">Chadian</option>
                    <option value="chilean">Chilean</option>
                    <option value="chinese">Chinese</option>
                    <option value="colombian">Colombian</option>
                    <option value="comoran">Comoran</option>
                    <option value="congolese">Congolese</option>
                    <option value="costa rican">Costa Rican</option>
                    <option value="croatian">Croatian</option>
                    <option value="cuban">Cuban</option>
                    <option value="cypriot">Cypriot</option>
                    <option value="czech">Czech</option>
                    <option value="danish">Danish</option>
                    <option value="djibouti">Djibouti</option>
                    <option value="dominican">Dominican</option>
                    <option value="dutch">Dutch</option>
                    <option value="east timorese">East Timorese</option>
                    <option value="ecuadorean">Ecuadorean</option>
                    <option value="egyptian">Egyptian</option>
                    <option value="emirian">Emirian</option>
                    <option value="equatorial guinean">Equatorial Guinean</option>
                    <option value="eritrean">Eritrean</option>
                    <option value="estonian">Estonian</option>
                    <option value="ethiopian">Ethiopian</option>
                    <option value="fijian">Fijian</option>
                    <option value="filipino">Filipino</option>
                    <option value="finnish">Finnish</option>
                    <option value="french">French</option>
                    <option value="gabonese">Gabonese</option>
                    <option value="gambian">Gambian</option>
                    <option value="georgian">Georgian</option>
                    <option value="german">German</option>
                    <option value="ghanaian">Ghanaian</option>
                    <option value="greek">Greek</option>
                    <option value="grenadian">Grenadian</option>
                    <option value="guatemalan">Guatemalan</option>
                    <option value="guinea-bissauan">Guinea-Bissauan</option>
                    <option value="guinean">Guinean</option>
                    <option value="guyanese">Guyanese</option>
                    <option value="haitian">Haitian</option>
                    <option value="herzegovinian">Herzegovinian</option>
                    <option value="honduran">Honduran</option>
                    <option value="hungarian">Hungarian</option>
                    <option value="icelander">Icelander</option>
                    <option value="indian">Indian</option>
                    <option value="indonesian">Indonesian</option>
                    <option value="iranian">Iranian</option>
                    <option value="iraqi">Iraqi</option>
                    <option value="irish">Irish</option>
                    <option value="israeli">Israeli</option>
                    <option value="italian">Italian</option>
                    <option value="ivorian">Ivorian</option>
                    <option value="jamaican">Jamaican</option>
                    <option value="japanese">Japanese</option>
                    <option value="jordanian">Jordanian</option>
                    <option value="kazakhstani">Kazakhstani</option>
                    <option value="kenyan">Kenyan</option>
                    <option value="kittian and nevisian">Kittian and Nevisian</option>
                    <option value="kuwaiti">Kuwaiti</option>
                    <option value="kyrgyz">Kyrgyz</option>
                    <option value="laotian">Laotian</option>
                    <option value="latvian">Latvian</option>
                    <option value="lebanese">Lebanese</option>
                    <option value="liberian">Liberian</option>
                    <option value="libyan">Libyan</option>
                    <option value="liechtensteiner">Liechtensteiner</option>
                    <option value="lithuanian">Lithuanian</option>
                    <option value="luxembourger">Luxembourger</option>
                    <option value="macedonian">Macedonian</option>
                    <option value="malagasy">Malagasy</option>
                    <option value="malawian">Malawian</option>
                    <option value="malaysian">Malaysian</option>
                    <option value="maldivan">Maldivan</option>
                    <option value="malian">Malian</option>
                    <option value="maltese">Maltese</option>
                    <option value="marshallese">Marshallese</option>
                    <option value="mauritanian">Mauritanian</option>
                    <option value="mauritian">Mauritian</option>
                    <option value="mexican">Mexican</option>
                    <option value="micronesian">Micronesian</option>
                    <option value="moldovan">Moldovan</option>
                    <option value="monacan">Monacan</option>
                    <option value="mongolian">Mongolian</option>
                    <option value="moroccan">Moroccan</option>
                    <option value="mosotho">Mosotho</option>
                    <option value="motswana">Motswana</option>
                    <option value="mozambican">Mozambican</option>
                    <option value="namibian">Namibian</option>
                    <option value="nauruan">Nauruan</option>
                    <option value="nepalese">Nepalese</option>
                    <option value="new zealander">New Zealander</option>
                    <option value="ni-vanuatu">Ni-Vanuatu</option>
                    <option value="nicaraguan">Nicaraguan</option>
                    <option value="nigerien">Nigerien</option>
                    <option value="north korean">North Korean</option>
                    <option value="northern irish">Northern Irish</option>
                    <option value="norwegian">Norwegian</option>
                    <option value="omani">Omani</option>
                    <option value="pakistani">Pakistani</option>
                    <option value="palauan">Palauan</option>
                    <option value="panamanian">Panamanian</option>
                    <option value="papua new guinean">Papua New Guinean</option>
                    <option value="paraguayan">Paraguayan</option>
                    <option value="peruvian">Peruvian</option>
                    <option value="polish">Polish</option>
                    <option value="portuguese">Portuguese</option>
                    <option value="qatari">Qatari</option>
                    <option value="romanian">Romanian</option>
                    <option value="russian">Russian</option>
                    <option value="rwandan">Rwandan</option>
                    <option value="saint lucian">Saint Lucian</option>
                    <option value="salvadoran">Salvadoran</option>
                    <option value="samoan">Samoan</option>
                    <option value="san marinese">San Marinese</option>
                    <option value="sao tomean">Sao Tomean</option>
                    <option value="saudi">Saudi</option>
                    <option value="scottish">Scottish</option>
                    <option value="senegalese">Senegalese</option>
                    <option value="serbian">Serbian</option>
                    <option value="seychellois">Seychellois</option>
                    <option value="sierra leonean">Sierra Leonean</option>
                    <option value="singaporean">Singaporean</option>
                    <option value="slovakian">Slovakian</option>
                    <option value="slovenian">Slovenian</option>
                    <option value="solomon islander">Solomon Islander</option>
                    <option value="somali">Somali</option>
                    <option value="south african">South African</option>
                    <option value="south korean">South Korean</option>
                    <option value="spanish">Spanish</option>
                    <option value="sri lankan">Sri Lankan</option>
                    <option value="sudanese">Sudanese</option>
                    <option value="surinamer">Surinamer</option>
                    <option value="swazi">Swazi</option>
                    <option value="swedish">Swedish</option>
                    <option value="swiss">Swiss</option>
                    <option value="syrian">Syrian</option>
                    <option value="taiwanese">Taiwanese</option>
                    <option value="tajik">Tajik</option>
                    <option value="tanzanian">Tanzanian</option>
                    <option value="thai">Thai</option>
                    <option value="togolese">Togolese</option>
                    <option value="tongan">Tongan</option>
                    <option value="trinidadian or tobagonian">Trinidadian or Tobagonian</option>
                    <option value="tunisian">Tunisian</option>
                    <option value="turkish">Turkish</option>
                    <option value="tuvaluan">Tuvaluan</option>
                    <option value="ugandan">Ugandan</option>
                    <option value="ukrainian">Ukrainian</option>
                    <option value="uruguayan">Uruguayan</option>
                    <option value="uzbekistani">Uzbekistani</option>
                    <option value="venezuelan">Venezuelan</option>
                    <option value="vietnamese">Vietnamese</option>
                    <option value="welsh">Welsh</option>
                    <option value="yemenite">Yemenite</option>
                    <option value="zambian">Zambian</option>
                    <option value="zimbabwean">Zimbabwean</option>
                </select>
            </div>


            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">ID</label>
                <input type="text" placeholder="Enter ID Number" title="Only Letters" pattern="[A-z0-9]+" name="idno">
            </div>

            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">ID Issue Date</label>
                <input type="date" placeholder="Enter Date Of Birth" title="Only Letters" name="id_iss">
            </div>

            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">ID Expiry Date</label>
                <input type="date" placeholder="Enter Date Of Birth" title="Only Letters" name="id_exp">
            </div>

        </div>

        <div class="input-container" style="display: flex;">

            <div class="input-field" style="margin-right: 5px; ">
                <label for="subjectCode">Mobile</label>
                <input type="number" placeholder="Enter Mobile Line" title="Only Letters" name="mobile">
            </div>

            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">Work</label>
                <input type="number" placeholder="Enter Work Line" title="Only Letters" name="work">
            </div>

            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">Email</label>
                <input type="email" placeholder="Enter Email" title="Only Letters" name="email">
            </div>

            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">Marital Status</label>
                <select name="mari">
                    <option disabled selected>Select Marital Status</option>
                    <option>SINGLE</option>
                    <option>MARRIED</option>
                    <option>DIVORCED</option>
                    <option>WIDOW</option>
                    <option>WIDOWER</option>
                </select>
            </div>

            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">Qualification</label>
                <select name="qualif">
                    <option disabled selected>Select Qualification</option>
                    <option value="No formal education">No formal education</option>
                    <option value="Primary education">Primary education</option>
                    <option value="Secondary education">High school</option>
                    <option value="GED">GED</option>
                    <option value="Vocational qualification">Vocational qualification</option>
                    <option value="Bachelor degree">Bachelor  degree</option>
                    <option value="Master degree">Master degree</option>
                    <option value="Doctorate or higher">Doctorate or higher</option>
                </select>
            </div>
        </div>
        <div class="input-container" style="display: flex;">

            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">Appointment Date</label>
                <input type="date" placeholder="Enter Appointment Date" name="app_dt" max="<?php echo date('Y-m-d'); ?>">
            </div>

            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">DEPARTMENT</label>
                <select name="dept">
                    <option disabled selected>Select Department</option>
                    <?php
                    $get_hos = "select * from department where  s_id = $sid order by dept_id ";
                    $get = oci_parse(oci_connect($username, $password, $connection), $get_hos);
                    oci_execute($get);
                    while ($row = oci_fetch_array($get)) {
                    ?><option>
                            <?php echo $row["DEPT"]; ?>
                        </option> <?php
                                }
                                    ?>
                </select>
            </div>
            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">Status</label>
                <select name="status">
                    <option disabled selected>Select Status</option>
                    <option>ACTIVE</option>
                    <option>INACTIVE</option>
                </select>
            </div>
        </div>
        <div class="input-container" style="display: flex;">
            <div class="input-field" style="margin-right: 10px; ">
                <label>Upload Passport Size Photo</label>
                <input type="file" name="pass_file">
            </div>

            <div class="input-field" style="margin-right: 10px; ">
                <label>Upload ID Document</label>
                <input type="file" name="id_file">
            </div>
            <div class="input-field" style="margin-right: 10px; ">
                <label>Upload Educational Document</label>
                <input type="file" name="edu_file">
            </div>

        </div>
        <div style="display: flex;">
            <button style=" display: inline-block;
  padding: 6px 12px;
  background-color: #04716f;
  color: white;
  border: none;
  border-radius: 4px;
  margin-top:10px;
  margin-bottom:10px;
  text-decoration: none;" name="edit" type="submit">
                EDIT TEACHER
                <i class="uil uil-edit"></i>
            </button>
        </div>
        <?php
        if (isset($_POST['edit'])) {
            if (isset($_POST['field'])) {
                if (isset($_POST['user'])) {
                   $field = $_POST['field'];
                   $name=$_POST['user'];
                   $sql = oci_parse($conn,"select * from employee where name = '$name' ");
                   oci_execute($sql);
                   while ($row = oci_fetch_array($sql)) {
                    $empid = $row['EMP_ID'];
                   }
                   if($field == 'FIRSTNAME'){
                       $first=strtoupper($_POST['first']);
                       if(!($first=='')){
                        $sql = oci_parse($conn,"update employee set firstname = '$first' where s_id = $sid and emp_id=$empid ");
                        oci_execute($sql);
                        $sql = oci_parse($conn,"select * from employee where firstname = '$first' and s_id = '$sid' and emp_id = $empid ");
                        oci_execute($sql);
                        if(oci_fetch_all($sql,$a)>0){
                            ?><div style="font-size:15px;
                            color: green;
                            position: relative;
                             display:flex;
                             margin-left:10px;
                            animation:button .3s linear;text-align: center;">
                                <?php echo "FIRSTNAME UPDATED SUCCESSFULLY";
                                        header("refresh:2;");
                                ?></div><?php 
                        }else {
                            ?><div style="font-size:15px;
                            color: red;
                            position: relative;
                             display:flex;
                             margin-left:10px;
                            animation:button .3s linear;text-align: center;">
                                <?php echo "ERROR UPDATING FIRSTNAME ";
                                        header("refresh:2;");
                                ?></div><?php 
                        }
                       }else { 
                        ?><div style="font-size:15px;
                        color: red;
                        position: relative;
                         display:flex;
                         margin-left:10px;
                        animation:button .3s linear;text-align: center;">
                            <?php echo "ENTER FIRSTNAME";
                                    header("refresh:2;");
                            ?></div><?php
                       }
                   }else if($field == 'MIDDLENAME'){
                    $first=strtoupper($_POST['middle']);
                    if(!($first=='')){
                     $sql = oci_parse($conn,"update employee set middlename = '$first' where s_id = $sid and emp_id=$empid ");
                     oci_execute($sql);
                     $sql = oci_parse($conn,"select * from employee where middlename = '$first' and s_id = '$sid' and emp_id = $empid ");
                     oci_execute($sql);
                     if(oci_fetch_all($sql,$a)>0){
                         ?><div style="font-size:15px;
                         color: green;
                         position: relative;
                          display:flex;
                          margin-left:10px;
                         animation:button .3s linear;text-align: center;">
                             <?php echo "MIDDLENAME UPDATED SUCCESSFULLY";
                                     header("refresh:2;");
                             ?></div><?php 
                     }else {
                         ?><div style="font-size:15px;
                         color: red;
                         position: relative;
                          display:flex;
                          margin-left:10px;
                         animation:button .3s linear;text-align: center;">
                             <?php echo "ERROR UPDATING MIDDLENAME ";
                                     header("refresh:2;");
                             ?></div><?php 
                     }
                    }else { 
                     ?><div style="font-size:15px;
                     color: red;
                     position: relative;
                      display:flex;
                      margin-left:10px;
                     animation:button .3s linear;text-align: center;">
                         <?php echo "ENTER MIDDLENAME";
                                 header("refresh:2;");
                         ?></div><?php
                    }
                }else if($field == 'LASTNAME'){
                    $first=strtoupper($_POST['last']);
                    if(!($first=='')){
                     $sql = oci_parse($conn,"update employee set lastname = '$first' where s_id = $sid and emp_id=$empid ");
                     oci_execute($sql);
                     $sql = oci_parse($conn,"select * from employee where lastname = '$first' and s_id = '$sid' and emp_id = $empid ");
                     oci_execute($sql);
                     if(oci_fetch_all($sql,$a)>0){
                         ?><div style="font-size:15px;
                         color: green;
                         position: relative;
                          display:flex;
                          margin-left:10px;
                         animation:button .3s linear;text-align: center;">
                             <?php echo "LASTNAME UPDATED SUCCESSFULLY";
                                     header("refresh:2;");
                             ?></div><?php 
                     }else {
                         ?><div style="font-size:15px;
                         color: red;
                         position: relative;
                          display:flex;
                          margin-left:10px;
                         animation:button .3s linear;text-align: center;">
                             <?php echo "ERROR UPDATING LASTNAME ";
                                     header("refresh:2;");
                             ?></div><?php 
                     }
                    }else { 
                     ?><div style="font-size:15px;
                     color: red;
                     position: relative;
                      display:flex;
                      margin-left:10px;
                     animation:button .3s linear;text-align: center;">
                         <?php echo "ENTER LASTNAME";
                                 header("refresh:2;");
                         ?></div><?php
                    }
                }else if($field == 'DATE OF BIRTH'){
                    $first=$_POST['dob'];
                    if(!($first=='')){
                     $sql = oci_parse($conn,"update employee set DOB = '$first' where s_id = $sid and emp_id=$empid ");
                     oci_execute($sql);
                     $sql = oci_parse($conn,"select * from employee where DOB = '$first' and s_id = '$sid' and emp_id = $empid ");
                     oci_execute($sql);
                     if(oci_fetch_all($sql,$a)>0){
                         ?><div style="font-size:15px;
                         color: green;
                         position: relative;
                          display:flex;
                          margin-left:10px;
                         animation:button .3s linear;text-align: center;">
                             <?php echo "DATE OF BIRTH UPDATED SUCCESSFULLY";
                                     header("refresh:2;");
                             ?></div><?php 
                     }else {
                         ?><div style="font-size:15px;
                         color: red;
                         position: relative;
                          display:flex;
                          margin-left:10px;
                         animation:button .3s linear;text-align: center;">
                             <?php echo "ERROR UPDATING DATE OF BIRTH ";
                                     header("refresh:2;");
                             ?></div><?php 
                     }
                    }else { 
                     ?><div style="font-size:15px;
                     color: red;
                     position: relative;
                      display:flex;
                      margin-left:10px;
                     animation:button .3s linear;text-align: center;">
                         <?php echo "ENTER DATE OF BIRTH";
                                 header("refresh:2;");
                         ?></div><?php
                    }
                } else if($field == 'GENDER'){
                    $first=$_POST['gender'];
                    if(!($first=='')){
                     $sql = oci_parse($conn,"update employee set gender = '$first' where s_id = $sid and emp_id=$empid ");
                     oci_execute($sql);
                     $sql = oci_parse($conn,"select * from employee where gender = '$first' and s_id = '$sid' and emp_id = $empid ");
                     oci_execute($sql);
                     if(oci_fetch_all($sql,$a)>0){
                         ?><div style="font-size:15px;
                         color: green;
                         position: relative;
                          display:flex;
                          margin-left:10px;
                         animation:button .3s linear;text-align: center;">
                             <?php echo "GENDER UPDATED SUCCESSFULLY";
                                     header("refresh:2;");
                             ?></div><?php 
                     }else {
                         ?><div style="font-size:15px;
                         color: red;
                         position: relative;
                          display:flex;
                          margin-left:10px;
                         animation:button .3s linear;text-align: center;">
                             <?php echo "ERROR UPDATING GENDER ";
                                     header("refresh:2;");
                             ?></div><?php 
                     }
                    }else { 
                     ?><div style="font-size:15px;
                     color: red;
                     position: relative;
                      display:flex;
                      margin-left:10px;
                     animation:button .3s linear;text-align: center;">
                         <?php echo "ENTER GENDER";
                                 header("refresh:2;");
                         ?></div><?php
                    }
                }
                else if($field == 'ADDRESS'){
                    $first=strtoupper($_POST['address']);
                    if(!($first=='')){
                     $sql = oci_parse($conn,"update employee set ADDRESS = '$first' where s_id = $sid and emp_id=$empid ");
                     oci_execute($sql);
                     $sql = oci_parse($conn,"select * from employee where ADDRESS= '$first' and s_id = '$sid' and emp_id = $empid ");
                     oci_execute($sql);
                     if(oci_fetch_all($sql,$a)>0){
                         ?><div style="font-size:15px;
                         color: green;
                         position: relative;
                          display:flex;
                          margin-left:10px;
                         animation:button .3s linear;text-align: center;">
                             <?php echo "ADDRESS UPDATED SUCCESSFULLY";
                                     header("refresh:2;");
                             ?></div><?php 
                     }else {
                         ?><div style="font-size:15px;
                         color: red;
                         position: relative;
                          display:flex;
                          margin-left:10px;
                         animation:button .3s linear;text-align: center;">
                             <?php echo "ERROR UPDATING ADDRESS ";
                                     header("refresh:2;");
                             ?></div><?php 
                     }
                    }else { 
                     ?><div style="font-size:15px;
                     color: red;
                     position: relative;
                      display:flex;
                      margin-left:10px;
                     animation:button .3s linear;text-align: center;">
                         <?php echo "ENTER ADDRESS";
                                 header("refresh:2;");
                         ?></div><?php
                    }
                }
                else if($field == 'NATIONALITY'){
                   
                    if(isset($_POST['nationality'])){
                        $first=strtoupper($_POST['nationality']);
                     $sql = oci_parse($conn,"update employee set NATIONALITY = '$first' where s_id = $sid and emp_id=$empid ");
                     oci_execute($sql);
                     $sql = oci_parse($conn,"select * from employee where NATIONALITY = '$first' and s_id = '$sid' and emp_id = $empid ");
                     oci_execute($sql);
                     if(oci_fetch_all($sql,$a)>0){
                         ?><div style="font-size:15px;
                         color: green;
                         position: relative;
                          display:flex;
                          margin-left:10px;
                         animation:button .3s linear;text-align: center;">
                             <?php echo "NATIONALITY UPDATED SUCCESSFULLY";
                                     header("refresh:2;");
                             ?></div><?php 
                     }else {
                         ?><div style="font-size:15px;
                         color: red;
                         position: relative;
                          display:flex;
                          margin-left:10px;
                         animation:button .3s linear;text-align: center;">
                             <?php echo "ERROR UPDATING NATIONALITY ";
                                     header("refresh:2;");
                             ?></div><?php 
                     }
                    }else { 
                     ?><div style="font-size:15px;
                     color: red;
                     position: relative;
                      display:flex;
                      margin-left:10px;
                     animation:button .3s linear;text-align: center;">
                         <?php echo "ENTER NATIONALITY";
                                 header("refresh:2;");
                         ?></div><?php
                    }
                } else if($field == 'ID'){
                    $first=strtoupper($_POST['idno']);
                    if(!($first=='')){
                     $sql = oci_parse($conn,"update employee set ID = '$first' where s_id = $sid and emp_id=$empid ");
                     oci_execute($sql);
                     $sql = oci_parse($conn,"select * from employee where ID = '$first' and s_id = '$sid' and emp_id = $empid ");
                     oci_execute($sql);
                     if(oci_fetch_all($sql,$a)>0){
                         ?><div style="font-size:15px;
                         color: green;
                         position: relative;
                          display:flex;
                          margin-left:10px;
                         animation:button .3s linear;text-align: center;">
                             <?php echo "ID UPDATED SUCCESSFULLY";
                                     header("refresh:2;");
                             ?></div><?php 
                     }else {
                         ?><div style="font-size:15px;
                         color: red;
                         position: relative;
                          display:flex;
                          margin-left:10px;
                         animation:button .3s linear;text-align: center;">
                             <?php echo "ERROR UPDATING ID ";
                                     header("refresh:2;");
                             ?></div><?php 
                     }
                    }else { 
                     ?><div style="font-size:15px;
                     color: red;
                     position: relative;
                      display:flex;
                      margin-left:10px;
                     animation:button .3s linear;text-align: center;">
                         <?php echo "ENTER ID ";
                                 header("refresh:2;");
                         ?></div><?php
                    }
                }else if($field == 'ID ISSUE DATE'){
                    $first=strtoupper($_POST['id_iss']);
                    if(!($first=='')){
                     $sql = oci_parse($conn,"update employee set ID_ISSUE = '$first' where s_id = $sid and emp_id=$empid ");
                     oci_execute($sql);
                     $sql = oci_parse($conn,"select * from employee where ID_ISSUE = '$first' and s_id = '$sid' and emp_id = $empid ");
                     oci_execute($sql);
                     if(oci_fetch_all($sql,$a)>0){
                         ?><div style="font-size:15px;
                         color: green;
                         position: relative;
                          display:flex;
                          margin-left:10px;
                         animation:button .3s linear;text-align: center;">
                             <?php echo "ID ISSUE DATE UPDATED SUCCESSFULLY";
                                     header("refresh:2;");
                             ?></div><?php 
                     }else {
                         ?><div style="font-size:15px;
                         color: red;
                         position: relative;
                          display:flex;
                          margin-left:10px;
                         animation:button .3s linear;text-align: center;">
                             <?php echo "ERROR UPDATING ID ISSUE DATE ";
                                     header("refresh:2;");
                             ?></div><?php 
                     }
                    }else { 
                     ?><div style="font-size:15px;
                     color: red;
                     position: relative;
                      display:flex;
                      margin-left:10px;
                     animation:button .3s linear;text-align: center;">
                         <?php echo "ENTER ID ISSUE DATE";
                                 header("refresh:2;");
                         ?></div><?php
                    }
                }
                else if($field == 'ID EXPIRY DATE'){
                    $first=strtoupper($_POST['id_exp']);
                    if(!($first=='')){
                     $sql = oci_parse($conn,"update employee set ID_EXPIRY = '$first' where s_id = $sid and emp_id=$empid ");
                     oci_execute($sql);
                     $sql = oci_parse($conn,"select * from employee where ID_EXPIRY = '$first' and s_id = '$sid' and emp_id = $empid ");
                     oci_execute($sql);
                     if(oci_fetch_all($sql,$a)>0){
                         ?><div style="font-size:15px;
                         color: green;
                         position: relative;
                          display:flex;
                          margin-left:10px;
                         animation:button .3s linear;text-align: center;">
                             <?php echo "ID EXPIRY DATE UPDATED SUCCESSFULLY";
                                     header("refresh:2;");
                             ?></div><?php 
                     }else {
                         ?><div style="font-size:15px;
                         color: red;
                         position: relative;
                          display:flex;
                          margin-left:10px;
                         animation:button .3s linear;text-align: center;">
                             <?php echo "ERROR UPDATING ID EXPIRY DATE ";
                                     header("refresh:2;");
                             ?></div><?php 
                     }
                    }else { 
                     ?><div style="font-size:15px;
                     color: red;
                     position: relative;
                      display:flex;
                      margin-left:10px;
                     animation:button .3s linear;text-align: center;">
                         <?php echo "ENTER ID EXPIRY DATE";
                                 header("refresh:2;");
                         ?></div><?php
                    }
                }
                else if($field == 'MOBILE'){
                    $first=strtoupper($_POST['mobile']);
                    if(!($first=='')){
                     $sql = oci_parse($conn,"update employee set MOBILE = $first where s_id = $sid and emp_id=$empid ");
                     oci_execute($sql);
                     $sql = oci_parse($conn,"select * from employee where MOBILE = $first and s_id = '$sid' and emp_id = $empid ");
                     oci_execute($sql);
                     if(oci_fetch_all($sql,$a)>0){
                         ?><div style="font-size:15px;
                         color: green;
                         position: relative;
                          display:flex;
                          margin-left:10px;
                         animation:button .3s linear;text-align: center;">
                             <?php echo "MOBILE UPDATED SUCCESSFULLY";
                                     header("refresh:2;");
                             ?></div><?php 
                     }else {
                         ?><div style="font-size:15px;
                         color: red;
                         position: relative;
                          display:flex;
                          margin-left:10px;
                         animation:button .3s linear;text-align: center;">
                             <?php echo "ERROR UPDATING MOBILE ";
                                     header("refresh:2;");
                             ?></div><?php 
                     }
                    }else { 
                     ?><div style="font-size:15px;
                     color: red;
                     position: relative;
                      display:flex;
                      margin-left:10px;
                     animation:button .3s linear;text-align: center;">
                         <?php echo "ENTER MOBILE";
                                 header("refresh:2;");
                         ?></div><?php
                    }
                }
                else if($field == 'WORK'){
                    $first=strtoupper($_POST['work']);
                    if(!($first=='')){
                     $sql = oci_parse($conn,"update employee set WORK = $first where s_id = $sid and emp_id=$empid ");
                     oci_execute($sql);
                     $sql = oci_parse($conn,"select * from employee where WORK = $first and s_id = '$sid' and emp_id = $empid ");
                     oci_execute($sql);
                     if(oci_fetch_all($sql,$a)>0){
                         ?><div style="font-size:15px;
                         color: green;
                         position: relative;
                          display:flex;
                          margin-left:10px;
                         animation:button .3s linear;text-align: center;">
                             <?php echo "WORK NUMBER UPDATED SUCCESSFULLY";
                                     header("refresh:2;");
                             ?></div><?php 
                     }else {
                         ?><div style="font-size:15px;
                         color: red;
                         position: relative;
                          display:flex;
                          margin-left:10px;
                         animation:button .3s linear;text-align: center;">
                             <?php echo "ERROR UPDATING WORK NUMBER ";
                                     header("refresh:2;");
                             ?></div><?php 
                     }
                    }else { 
                     ?><div style="font-size:15px;
                     color: red;
                     position: relative;
                      display:flex;
                      margin-left:10px;
                     animation:button .3s linear;text-align: center;">
                         <?php echo "ENTER WORK NUMBER";
                                 header("refresh:2;");
                         ?></div><?php
                    }
                }
                else if($field == 'EMAIL'){
                    $first=strtoupper($_POST['email']);
                    if(!($first=='')){
                     $sql = oci_parse($conn,"update employee set EMAIL = '$first' where s_id = $sid and emp_id=$empid ");
                     oci_execute($sql);
                     $sql = oci_parse($conn,"select * from employee where EMAIL = '$first' and s_id = '$sid' and emp_id = $empid ");
                     oci_execute($sql);
                     if(oci_fetch_all($sql,$a)>0){
                         ?><div style="font-size:15px;
                         color: green;
                         position: relative;
                          display:flex;
                          margin-left:10px;
                         animation:button .3s linear;text-align: center;">
                             <?php echo "EMAIL UPDATED SUCCESSFULLY";
                                     header("refresh:2;");
                             ?></div><?php 
                     }else {
                         ?><div style="font-size:15px;
                         color: red;
                         position: relative;
                          display:flex;
                          margin-left:10px;
                         animation:button .3s linear;text-align: center;">
                             <?php echo "ERROR UPDATING EMAIL ";
                                     header("refresh:2;");
                             ?></div><?php 
                     }
                    }else { 
                     ?><div style="font-size:15px;
                     color: red;
                     position: relative;
                      display:flex;
                      margin-left:10px;
                     animation:button .3s linear;text-align: center;">
                         <?php echo "ENTER EMAIL";
                                 header("refresh:2;");
                         ?></div><?php
                    }
                } else if($field == 'MARITAL STATUS'){
                   
                    if(isset($_POST['mari'])){
                        $first=strtoupper($_POST['mari']);
                     $sql = oci_parse($conn,"update employee set MARITAL_STATUS = '$first' where s_id = $sid and emp_id=$empid ");
                     oci_execute($sql);
                     $sql = oci_parse($conn,"select * from employee where MARITAL_STATUS = '$first' and s_id = '$sid' and emp_id = $empid ");
                     oci_execute($sql);
                     if(oci_fetch_all($sql,$a)>0){
                         ?><div style="font-size:15px;
                         color: green;
                         position: relative;
                          display:flex;
                          margin-left:10px;
                         animation:button .3s linear;text-align: center;">
                             <?php echo "MARITAL STATUS UPDATED SUCCESSFULLY";
                                     header("refresh:2;");
                             ?></div><?php 
                     }else {
                         ?><div style="font-size:15px;
                         color: red;
                         position: relative;
                          display:flex;
                          margin-left:10px;
                         animation:button .3s linear;text-align: center;">
                             <?php echo "ERROR UPDATING MARITAL STATUS ";
                                     header("refresh:2;");
                             ?></div><?php 
                     }
                    }else { 
                     ?><div style="font-size:15px;
                     color: red;
                     position: relative;
                      display:flex;
                      margin-left:10px;
                     animation:button .3s linear;text-align: center;">
                         <?php echo "ENTER MARITAL STATUS";
                                 header("refresh:2;");
                         ?></div><?php
                    }
                }
                else if($field == 'QUALIFICATION'){
                    $first=strtoupper($_POST['qualif']);
                 
                    if(isset($_POST['qualif'])){
                   
                     $sql = oci_parse($conn,"update employee set qualif = '$first' where s_id = $sid and emp_id=$empid ");
                     oci_execute($sql);
                     $sql = oci_parse($conn,"select * from employee where qualif = '$first' and s_id = '$sid' and emp_id = $empid ");
                     oci_execute($sql);
                     if(oci_fetch_all($sql,$a)>0){
                         ?><div style="font-size:15px;
                         color: green;
                         position: relative;
                          display:flex;
                          margin-left:10px;
                         animation:button .3s linear;text-align: center;">
                             <?php echo "QUALIFICATION UPDATED SUCCESSFULLY";
                                     header("refresh:2;");
                             ?></div><?php 
                     }else {
                         ?><div style="font-size:15px;
                         color: red;
                         position: relative;
                          display:flex;
                          margin-left:10px;
                         animation:button .3s linear;text-align: center;">
                             <?php echo "ERROR UPDATING QUALIFICATION ";
                                     header("refresh:2;");
                             ?></div><?php 
                     }
                    }else { 
                     ?><div style="font-size:15px;
                     color: red;
                     position: relative;
                      display:flex;
                      margin-left:10px;
                     animation:button .3s linear;text-align: center;">
                         <?php echo "ENTER QUALIFICATION";
                                 header("refresh:2;");
                         ?></div><?php
                    }
                }
                else if($field == 'APPOINTMENT DATE'){
                    $first= $_POST['app_dt'];
                    if(!($first=='')){
                     $sql = oci_parse($conn,"update employee set APPOINT_DT = '$first' where s_id = $sid and emp_id=$empid ");
                     oci_execute($sql);
                     $sql = oci_parse($conn,"select * from employee where APPOINT_DT = '$first' and s_id = '$sid' and emp_id = $empid ");
                     oci_execute($sql);
                     if(oci_fetch_all($sql,$a)>0){
                         ?><div style="font-size:15px;
                         color: green;
                         position: relative;
                          display:flex;
                          margin-left:10px;
                         animation:button .3s linear;text-align: center;">
                             <?php echo "APPOINTMENT DATE UPDATED SUCCESSFULLY";
                                     header("refresh:2;");
                             ?></div><?php 
                     }else {
                         ?><div style="font-size:15px;
                         color: red;
                         position: relative;
                          display:flex;
                          margin-left:10px;
                         animation:button .3s linear;text-align: center;">
                             <?php echo "ERROR UPDATING APPOINTMENT DATE ";
                                     header("refresh:2;");
                             ?></div><?php 
                     }
                    }else { 
                     ?><div style="font-size:15px;
                     color: red;
                     position: relative;
                      display:flex;
                      margin-left:10px;
                     animation:button .3s linear;text-align: center;">
                         <?php echo "ENTER APPOINTMENT DATE";
                                 header("refresh:2;");
                         ?></div><?php
                    }
                }
                else if($field == 'DEPARTMENT'){
                    if(isset($_POST['dept'])){
                      $first= $_POST['dept'];
                      $sql = oci_parse($conn,"select * from department where dept = '$first' and s_id=$sid ");
                      oci_execute($sql);
                      while($r=oci_fetch_array($sql)){
                        $dept_id=$r['DEPT_ID'];
                      }
                     $sql = oci_parse($conn,"update employee set DEPT_ID = $dept_id where s_id = $sid and emp_id=$empid ");
                     oci_execute($sql);
                     $sql = oci_parse($conn,"select * from employee where DEPT_ID = $dept_id and s_id = '$sid' and emp_id = $empid ");
                     oci_execute($sql);
                     if(oci_fetch_all($sql,$a)>0){
                         ?><div style="font-size:15px;
                         color: green;
                         position: relative;
                          display:flex;
                          margin-left:10px;
                         animation:button .3s linear;text-align: center;">
                             <?php echo "DEPARTMENT UPDATED SUCCESSFULLY";
                                     header("refresh:2;");
                             ?></div><?php 
                     }else {
                         ?><div style="font-size:15px;
                         color: red;
                         position: relative;
                          display:flex;
                          margin-left:10px;
                         animation:button .3s linear;text-align: center;">
                             <?php echo "ERROR UPDATING DEPARTMENT ";
                                     header("refresh:2;");
                             ?></div><?php 
                     }
                    }else { 
                     ?><div style="font-size:15px;
                     color: red;
                     position: relative;
                      display:flex;
                      margin-left:10px;
                     animation:button .3s linear;text-align: center;">
                         <?php echo "SELECT DEPARTMENT";
                                 header("refresh:2;");
                         ?></div><?php
                    }
                }
                else if($field == 'STATUS'){
                    if(isset($_POST['status'])){
                     $first= strtoupper($_POST['status']);
                     $sql = oci_parse($conn,"update employee set status = '$first' where s_id = $sid and emp_id = $empid ");
                     oci_execute($sql);
                     $sql = oci_parse($conn,"select * from employee where status = '$first' and s_id = '$sid' and emp_id = $empid ");
                     oci_execute($sql);
                     if(oci_fetch_all($sql,$a)>0){
                         ?><div style="font-size:15px;
                         color: green;
                         position: relative;
                          display:flex;
                          margin-left:10px;
                         animation:button .3s linear;text-align: center;">
                             <?php echo "STATUS UPDATED SUCCESSFULLY";
                                     header("refresh:2;");
                             ?></div><?php 
                     }else {
                         ?><div style="font-size:15px;
                         color: red;
                         position: relative;
                          display:flex;
                          margin-left:10px;
                         animation:button .3s linear;text-align: center;">
                             <?php echo "ERROR UPDATING STATUS";
                                     header("refresh:2;");
                             ?></div><?php 
                     }
                    }else { 
                     ?><div style="font-size:15px;
                     color: red;
                     position: relative;
                      display:flex;
                      margin-left:10px;
                     animation:button .3s linear;text-align: center;">
                         <?php echo "SELECT STATUS";
                                 header("refresh:2;");
                         ?></div><?php
                    }
                }
                else if($field == 'PASSPORT SIZE PHOTO'){
                    $pass_file = $_FILES['pass_file']['tmp_name'];
                    if(isjpeg_png($pass_file) && isset($_FILES['pass_file'])){
                        
                        $query = "UPDATE employee SET pass_photo = :photo WHERE s_id = :sid AND emp_id = :empid";
                        
    
                        $statement = oci_parse($conn, $query);
                        
                        oci_bind_by_name($statement, ':sid', $sid);
                        oci_bind_by_name($statement, ':empid', $empid);
                        $file = $_FILES['pass_file']['tmp_name'];
                        $blobData = file_get_contents($file);
                        
                        $lob = oci_new_descriptor($conn, OCI_D_LOB);
                        
                        oci_bind_by_name($statement, ':photo', $lob, -1, OCI_B_BLOB);
                        

                        $lob->writeTemporary($blobData, OCI_TEMP_BLOB);

                        oci_execute($statement);
                        
                        oci_commit($conn);
                        
                        $lob->free();
                        oci_free_statement($statement);
                           
                         ?><div style="font-size:15px;
                         color: green;
                         position: relative;
                          display:flex;
                          margin-left:10px;
                         animation:button .3s linear;text-align: center;">
                             <?php echo "PASSPHOTO UPDATED SUCCESSFULLY";
                                     header("refresh:2;");
                             ?></div><?php 
                    }else { 
                        ?><div style="font-size:15px;
                        color: red;
                        position: relative;
                         display:flex;
                         margin-left:10px;
                        animation:button .3s linear;text-align: center;">
                                <?php echo "PASSPHOTO NOT UPLOADED OR WRONG FILE TYPE";
                                          header("refresh:2;");
                                ?></div><?php
                    }
                }
                else if($field == 'ID DOCUMENT'){
                    $id_file = $_FILES['id_file']['tmp_name'];
                    if(isjpeg_png($id_file) && isset($_FILES['id_file'])){
                       
                        $query = "UPDATE employee SET id_doc = :photo WHERE s_id = :sid AND emp_id = :empid";
                        
                        $statement = oci_parse($conn, $query);
                        
                        oci_bind_by_name($statement, ':sid', $sid);
                        oci_bind_by_name($statement, ':empid', $empid);
                        $file = $_FILES['id_file']['tmp_name'];
                        $blobData = file_get_contents($file);
                        
                        $lob = oci_new_descriptor($conn, OCI_D_LOB);
                        
                        oci_bind_by_name($statement, ':photo', $lob, -1, OCI_B_BLOB);
                        

                        $lob->writeTemporary($blobData, OCI_TEMP_BLOB);

                        oci_execute($statement);
                        
                        oci_commit($conn);
                        
                        $lob->free();
                        oci_free_statement($statement);
                         ?><div style="font-size:15px;
                         color: green;
                         position: relative;
                          display:flex;
                          margin-left:10px;
                         animation:button .3s linear;text-align: center;">
                             <?php echo "ID DOCUMENT UPDATED SUCCESSFULLY";
                                     header("refresh:2;");
                             ?></div><?php 
                    }else { 
                        ?><div style="font-size:15px;
                        color: red;
                        position: relative;
                         display:flex;
                         margin-left:10px;
                        animation:button .3s linear;text-align: center;">
                                <?php echo "ID DOCUMENT NOT UPLOADED OR WRONG FILE TYPE";
                                          header("refresh:2;");
                                ?></div><?php
                    }
                }
                else if($field == 'EDUCATION DOCUMENT'){
                    $pass_file = $_FILES['edu_file']['tmp_name'];
                    if(isjpeg_png($pass_file) && isset($_FILES['edu_file'])){
                       
                        $query = "UPDATE employee SET edu_doc = :photo WHERE s_id = :sid AND emp_id = :empid";
                        
                        $statement = oci_parse($conn, $query);
                        
                        oci_bind_by_name($statement, ':sid', $sid);
                        oci_bind_by_name($statement, ':empid', $empid);
                        $file = $_FILES['edu_file']['tmp_name'];
                        $blobData = file_get_contents($file);
                        
                        $lob = oci_new_descriptor($conn, OCI_D_LOB);
                        
                        oci_bind_by_name($statement, ':photo', $lob, -1, OCI_B_BLOB);
                        

                        $lob->writeTemporary($blobData, OCI_TEMP_BLOB);

                        oci_execute($statement);
                        
                        oci_commit($conn);
                        
                        $lob->free();
                        oci_free_statement($statement);
                         ?><div style="font-size:15px;
                         color: green;
                         position: relative;
                          display:flex;
                          margin-left:10px;
                         animation:button .3s linear;text-align: center;">
                             <?php echo "EDUCATION DOCUMENT UPDATED SUCCESSFULLY";
                                     header("refresh:2;");
                             ?></div><?php 
                    }else { 
                        ?><div style="font-size:15px;
                        color: red;
                        position: relative;
                         display:flex;
                         margin-left:10px;
                        animation:button .3s linear;text-align: center;">
                                <?php echo "EDUCATION DOCUMENT NOT UPLOADED OR WRONG FILE TYPE";
                                          header("refresh:2;");
                                ?></div><?php
                    }
                }
                } else {
        ?><div style="font-size:15px;
                    color: red;
                    position: relative;
                     display:flex;
                     margin-left:10px;
                    animation:button .3s linear;text-align: center;">
                        <?php echo "SELECT USER";
                        header("refresh:2;");
                        ?></div><?php
                            }
                        } else {
                                ?><div style="font-size:15px;
                color: red;
                position: relative;
                 display:flex;
                 margin-left:10px;
                animation:button .3s linear;text-align: center;">
                    <?php echo "SELECT FIELD TO EDIT";
                            header("refresh:2;");
                    ?></div><?php
                        }
                    }
                            ?>
        <div class="buttons">

            <button class="backBtn" type="submit">

                <a class="btnText" href="admin.php">
                    BACK
                </a>
            </button>
        </div>
    </form>
    <?php
function ispdf_word($file)
{
    $ext = pathinfo($file, PATHINFO_EXTENSION);
    if (in_array(strtolower($ext), ['pdf', 'doc', 'docx'])) {
        return true;
    }
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimetype = finfo_file($finfo, $file);
    finfo_close($finfo);
    if (in_array($mimetype, ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'])) {
        return true;
    }

    return false;
}

function isjpeg_png($file)
{
    $type = [IMAGETYPE_JPEG, IMAGETYPE_PNG];
    $detect = exif_imagetype($file);
    if (in_array($detect, $type)) {
        return true;
    } else {
        return false;
    }
}
?>
    <script>
        $(document).ready(function() {
            $('#example').DataTable();
        });
    </script>
</body>

</html>