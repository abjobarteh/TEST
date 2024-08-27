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
include 'connect.php';
ob_start();
session_start();
$school =  $_SESSION['school'];
$sid = $_SESSION['sid']; ?>
<style>
    .field select:focus {
        padding-left: 47px;
        border: 2px solid #1D5B79;
        background-color: #ffffff;
    }

    .field select:focus~i {
        color: #1D5B79;
    }
</style>
<?php
// Include the auto_logout.php file
include('auto_logout.php');

// Your page content goes here
// ...
?>

<body>
    <form class="container" enctype="multipart/form-data" action="manage_teacher.php" method="post">
        <div class="com">
            <h3 style="color:#1D5B79;">Academix: School Management System</h3>
            <h3 class="title" style="justify-content:center; text-align:center; color:#1D5B79; 	font-size: 18px;"><?php echo $school ?>
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

                <a class="btnText" href="registra.php" style="font-size: 15px;">
                    HOME
                    <i class="uil uil-estate" style="width: 50px;"></i>
                </a>

            </button>
        </div>
        <header>Teacher Management</header>
        </div>
        <Label style="font-size: 18px; font-family: sans-serif;
    font-weight: bold; color: #1D5B79;">Add Teacher</Label>
        <div class="input-container" style="display: flex;">

            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">Firstname</label>
                <label for="subjectCode" style="font-weight: 900;">(Required) </label>
                <input type="text" placeholder="Enter Firstname" title="Only Letters" pattern="[A-z]+" name="first" required>
            </div>

            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">Middlename</label>
                <input type="text" placeholder="Enter Middlename" title="Only Letters" pattern="[A-z]+" name="middle">
            </div>

            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">Lastname</label>
                <label for="subjectCode" style="font-weight: 900;">(Required) </label>
                <input type="text" placeholder="Enter Lastname" title="Only Letters" pattern="[A-z]+" name="last" required>
            </div>

            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">Date Of Birth</label>
                <label for="subjectCode" style="font-weight: 900;">(Required) </label>
                <input type="date" placeholder="Enter Date Of Birth" title="Only Letters" pattern="[A-z]+" name="dob" required max="<?php echo date('Y-m-d', strtotime('-18 years')); ?>" title="ONLY 18 AND ABOVE">
            </div>

            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">Gender</label>
                <label for="subjectCode" style="font-weight: 900;">(Required) </label>
                <select name="gender" required>
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
                <label for="subjectCode" style="font-weight: 900;">(Required) </label>
                <input type="text" placeholder="Enter Address" title="Only Letters" pattern="[A-z0-9 ]+" name="address" required>
            </div>

            <div class="input-field" style="margin-right: 10px; ">
                <label>Nationality</label>
                <label for="subjectCode" style="font-weight: 900;">(Required) </label>
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
                <label for="subjectCode" style="font-weight: 900;">(Required) </label>
                <input type="text" placeholder="Enter ID Number" title="Only Letters" pattern="[A-z0-9]+" name="idno" required>
            </div>

            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">ID Issue Date</label>
                <label for="subjectCode" style="font-weight: 900;">(Required) </label>
                <input type="date" placeholder="Enter Date Of Birth" title="Only Letters" name="id_iss" required>
            </div>

            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">ID Expiry Date</label>
                <label for="subjectCode" style="font-weight: 900;">(Required) </label>
                <input type="date" placeholder="Enter Date Of Birth" title="Only Letters" name="id_exp" required>
            </div>



        </div>

        <div class="input-container" style="display: flex;">

            <div class="input-field" style="margin-right: 5px; ">
                <label for="subjectCode">Mobile</label>
                <label for="subjectCode" style="font-weight: 900;">(Required) </label>
                <input type="number" placeholder="Enter Mobile Line" title="Only Numbers" name="mobile" required maxlength="7">
            </div>

            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">Work</label>
                <label for="subjectCode" style="font-weight: 900;">(Required) </label>
                <input type="number" placeholder="Enter Work Line" title="Only Numbers" name="work" required maxlength="7">
            </div>

            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">Email</label>
                <label for="subjectCode" style="font-weight: 900;">(Required) </label>
                <input type="email" placeholder="Enter Email" title="Only Letters" name="email" required>
            </div>

            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">Marital Status</label>
                <label for="subjectCode" style="font-weight: 900;">(Required) </label>
                <select name="mari" required>
                    <option disabled selected>Select Marital Status</option>
                    <option>SINGLE</option>
                    <option>MARRIED</option>
                    <option>DIVORCED</option>
                    <option>WIDOW</option>
                    <option>WIDOWER</option>
                </select>
            </div>

            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">Next Of Kin</label>
                <label for="subjectCode" style="font-weight: 900;">(Required) </label>
                <input type="text" placeholder="Enter Next Of Kin" title="Only Letters" name="kin" required pattern="[A-z ]+">
            </div>

        </div>
        <div class="input-container" style="display: flex;">

            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">Next Of Kin Contact</label>
                <label for="subjectCode" style="font-weight: 900;">(Required) </label>
                <input type="number" placeholder="Enter Next Of Kin Contact" title="Only Letters" name="kin_contact" required style="width: 250px;">
            </div>

            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">Qualification</label>
                <label for="subjectCode" style="font-weight: 900;">(Required) </label>
                <select name="qualif" required>
                    <option disabled selected>Select Qualification</option>
                    <option value="No formal education">No formal education</option>
                    <option value="Primary education">Primary education</option>
                    <option value="Secondary education">High school</option>
                    <option value="GED">GED</option>
                    <option value="Vocational qualification">Vocational qualification</option>
                    <option value="Bachelor degree">Bachelor degree</option>
                    <option value="Master degree">Master degree</option>
                    <option value="Doctorate or higher">Doctorate or higher</option>
                </select>
            </div>

            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">Appointment Date</label>
                <label for="subjectCode" style="font-weight: 900;"> </label>
                <input type="date" placeholder="Enter Appointment Date" name="app_dt" max="<?php echo date('Y-m-d'); ?>">
            </div>
            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">Username</label>
                <label for="subjectCode" style="font-weight: 900;">(Required) </label>
                <input type="text" placeholder="Enter Teacher Username" title="Only Letters" pattern="[A-z0-9]+" name="username" required>
            </div>

        </div>
        <div class="input-container" style="display: flex;">

        </div>
        <div class="input-container" style="display: flex;">
            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">DEPARTMENT</label>
                <label for="subjectCode" style="font-weight: 900;">(Required) </label>
                <select name="dept" required>
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
        </div>
        <div style="display: flex;">
            <button style=" display: inline-block;
  padding: 6px 12px;
  background-color: #1D5B79;
  color: white;
  border: none;
  border-radius: 4px;
  margin-top:10px;
  margin-bottom:10px;
  text-decoration: none;" name="establish" type="submit">
                ADD TEACHER
                <i class="uil uil-plus"></i>
            </button>
        </div>
        <?php
        if (isset($_POST['establish'])) {

            /*  if (isjpeg_png($pass_file)) { */
            /* if (ispdf_word($id_file) || isjpeg_png($id_file)) { */
            /*     if (ispdf_word($edu_file) || isjpeg_png($edu_file)) { */

            $status = "ACTIVE";
            $pass = "ChangePassword";
            $rights = "TEACHER";

            $first = strtoupper($_POST['first']);
            $middle = strtoupper($_POST['middle']);
            $last = strtoupper($_POST['last']);
            if ($middle != '') {
                $name = $first . '' . $middle . '' . $last;
            } else {
                $name = $first . '' . $last;
            }
            $dob = $_POST['dob'];
            $gender = $_POST['gender'];
            $add = strtoupper($_POST['address']);

            if ($_POST['nationality'] != '') {
                $nation = strtoupper($_POST['nationality']);
            } else {
                $nation = 'NULL';
            }

            $idno = $_POST['idno'];
            $id_iss = $_POST['id_iss'];
            $id_exp = $_POST['id_exp'];
            $mob = $_POST['mobile'];
            $work = $_POST['work'];
            $email = $_POST['email'];
            if ($_POST['nationality'] != '') {
                $marital = strtoupper($_POST['mari']);
            } else {
                $marital = 'NULL';
            }

            if ($_POST['nationality'] != '') {
                $qualif = strtoupper($_POST['qualif']);
            } else {
                $qualif = 'NULL';
            }
            $app_dt = $_POST['app_dt'];
            $user = $_POST['username'];
            $dept = $_POST['dept'];
            $next_kin = strtoupper($_POST['kin']);
            $kin_contact = $_POST['kin_contact'];

            $sql = oci_parse($conn, "insert into GEN_ID (GEN) values (1)");
            oci_execute($sql);
            $sql = oci_parse($conn, "select * from GEN_ID order by id");
            oci_execute($sql);

            if ($r = oci_fetch_array($sql)) {
                $id = $r['ID'];
            }
            $sql = oci_parse($conn, "delete from gen_id where id = $id");
            oci_execute($sql);
            $currentDate = date("Ymd"); // Returns the date in the format YYYY-MM-DD

            $empid = $currentDate . $id;

            $sql = oci_parse($conn, "select * from department where dept = '$dept' ");
            oci_execute($sql);
            if ($r = oci_fetch_array($sql)) {
                $dept_id = $r['DEPT_ID'];
                //  echo $dept_id;
            }
            $sql = oci_parse($conn, "select * from employee where emp_id ='$empid' ");
            oci_execute($sql);
            if (oci_fetch_all($sql, $a) == 0) {
                $query = "INSERT INTO EMPLOYEE (S_ID,FIRSTNAME,MIDDLENAME,LASTNAME,DOB,GENDER,ADDRESS,NATIONALITY,ID,ID_ISSUE,ID_EXPIRY,MOBILE,WORK,EMAIL,MARITAL_STATUS,APPOINT_DT,EMP_ID,STATUS,DEPT_ID,next_kin,kin_contact,qualif,create_dt,username,name) 
                VALUES ('$sid','$first','$middle','$last','$dob','$gender','$add','$nation','$idno','$id_iss','$id_exp','$mob','$work','$email','$marital','$app_dt','$empid','$status','$dept_id','$next_kin','$kin_contact','$qualif',sysdate,'$user','$name')";

                $insert =
                    oci_parse($conn, "insert into school_users (S_ID,firstname,middlename,lastname,dob,gender,address,mobile,work,email,username,password,rights,status,create_dt)  values
                        ($sid,'$first','$middle','$last','$dob','$gender','$add',$mob,$work,'$email','$user','$pass','$rights','$status',sysdate)");

                $check_emp = oci_parse($conn, "select * from school_users where username = '$user'");
                oci_execute($check_emp);

                if ((oci_fetch_all($check_emp, $a) == 0)) {
                    oci_execute($insert);
                    $statement =    oci_parse($conn, $query);
                    // echo $query;
                    oci_execute($statement);
        ?><div style="font-size:15px;
                                color: green;
                                position: relative;
                                 display:flex;
                                 margin-left:10px;
                                animation:button .3s linear;text-align: center;">
                        <?php echo "USER CREATED SUCCESSFULLY";
                        header("refresh:2;");
                        ?></div><?php
                            } else {
                                ?><div style="font-size:15px;
                                color: red;
                                position: relative;
                                 display:flex;
                                 margin-left:10px;
                                animation:button .3s linear;text-align: center;">
                        <?php echo "ERROR CREATING TEACHER ";
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
                    <?php echo "USER ALREADY EXIST";
                            header("refresh:2;");
                    ?></div><?php
                        }
                        /*       } else {
                                        ?><div style="font-size:15px;
                    color: red;
                    position: relative;
                     display:flex;
                     margin-left:10px;
                    animation:button .3s linear;text-align: center;">
                            <?php echo "ALLOWED FILE TYPES FOR EDUCATIONAL DOCUMENT UPLOAD ARE PDF OR WORD OR PNG OR JPEG";
                                    header("refresh:2;");
                            ?></div><?php
                                }
                     /*       } else {
                                    ?><div style="font-size:15px;
                    color: red;
                    position: relative;
                     display:flex;
                     margin-left:10px;
                    animation:button .3s linear;text-align: center;">
                        <?php echo "ALLOWED FILE TYPES FOR ID DOCUMENT UPLOAD ARE PDF OR WORD OR PNG OR JPEG";
                                header("refresh:2;");
                        ?></div><?php
                            } */
                        /*   }  else {
                                ?><div style="font-size:15px;
            color: red;
            position: relative;
             display:flex;
             margin-left:10px;
            animation:button .3s linear;text-align: center;">
                    <?php echo "ALLOWED FILE TYPES FOR PASSPORT SIZE PHOTO UPLOAD ARE PDF OR WORD OR PNG OR JPEG";
                            header("refresh:2;");
                    ?></div><?php
                        } */
                    }

                            ?>
        <div class="buttons">

            <button class="backBtn" type="submit">

                <a class="btnText" href="registra.php">
                    BACK
                </a>
            </button>
        </div>
    </form>
    <script>
        $(document).ready(function() {
            $('#example').DataTable();
        });
    </script>
</body>
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

</html>