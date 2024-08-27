<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/showsss.css">
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
        border: 2px solid #1D5B79;
        background-color: #ffffff;
    }

    .field select:focus~i {
        color: #1D5B79;
    }
</style>
<?php
include('auto_logout.php');
?>
<body>
<?php
// Include the auto_logout.php file
include('auto_logout.php');

// Your page content goes here
// ...
?>

    <form class="container" enctype="multipart/form-data" action="add_student.php" method="post">
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
        <header>Student Management</header>
        </div>

        <Label style="font-size: 18px; font-family: sans-serif;
    font-weight: bold; color: #1D5B79;">Add Student</Label>

        <div style="display:flex; margin-top:20px;">
            <Label style="font-size: 18px; font-family: righteous;
         font-weight: bold; color: #1D5B79;">Personal Information</Label>
        </div>

        <div class="input-container" style="display: flex;">

            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">Firstname</label>
                <label for="subjectCode" style="font-weight: 900;">(Required) </label>
                <input type="text" placeholder="Enter Firstname" title="Only Letters" pattern="[A-z]+" name="stu_first" required>
            </div>

            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">Middlename</label>
                <input type="text" placeholder="Enter Middlename" title="Only Letters" pattern="[A-z]+" name="stu_middle">
            </div>

            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">Lastname</label>
                <label for="subjectCode" style="font-weight: 900;">(Required) </label>
                <input type="text" placeholder="Enter Lastname" title="Only Letters" pattern="[A-z]+" name="stu_last" required>
            </div>

            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">Date Of Birth</label>
                <label for="subjectCode" style="font-weight: 900;">(Required) </label>
                <input type="date" placeholder="Enter Date Of Birth" title="Only Letters" pattern="[A-z]+" name="stu_dob" required max="<?php echo date('Y-m-d'); ?>" title="SELECTED DATE NOT ALLOWED">
            </div>

            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">Gender</label>
                <label for="subjectCode" style="font-weight: 900;">(Required) </label>
                <select name="stu_gender" required>
                    <option disabled selected>Select Gender</option>
                    <option>MALE</option>
                    <option>FEMALE</option>
                    <option>OTHER</option>
                </select>
            </div>
            <div class="input-field" style="margin-right: 10px; ">
                <label>Nationality</label>
                <label for="subjectCode" style="font-weight: 900;">(Required) </label>
                <select name="stu_nation" required>
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
        </div>
        <div class="input-container" style="display: flex;">
            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">Tribe/Ethnicity</label>
                <select name="stu_tribe" required>
                    <option disabled selected>Select Tribe/Ethnicity</option>
                    <option>Mandinka</option>
                    <option>Wolof</option>
                    <option>Fula</option>
                    <option>Jola</option>
                    <option>Serer</option>
                    <option>Aku</option>
                    <option>Manjago</option>
                    <option>Bambara</option>
                </select>
            </div>
        </div>
        <div style="display:flex; margin-top:20px;">
            <Label style="font-size: 18px; font-family: righteous;
         font-weight: bold; color: #1D5B79;">Contact Information</Label>
        </div>

        <div class="input-container" style="display: flex;">

            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">Home Address</label>
                <label for="subjectCode" style="font-weight: 900;">(Required) </label>
                <input type="text" placeholder="Enter Home Address" title="Only Letters" pattern="[A-z0-9 ]+" name="stu_add" required>
            </div>

            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">Email Address</label>
                <input type="email" placeholder="Enter Email Address" name="stu_email">
            </div>

            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">Phone Number</label>
                <input type="number" placeholder="Enter Phone Number" title="Only Numbers" name="stu_phone" maxlength="7" title="ONLY 7 CHARACTERS ALLOWED">
            </div>

            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">Emergency Contact</label>
                <label for="subjectCode" style="font-weight: 900;">(Required) </label>
                <input type="number" placeholder="Enter Emergency Contact" title="Only Numbers" name="stu_eme" required maxlength="7" title="ONLY 7 CHARACTERS ALLOWED">
            </div>

        </div>

        <div style="display:flex; margin-top:20px;">
            <Label style="font-size: 18px; font-family: righteous;
         font-weight: bold; color: #1D5B79;">Parent/Guardian Information</Label>
        </div>

        <div class="input-container" style="display: flex;">

            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">Parent/Guardian Firstname</label>
                <label for="subjectCode" style="font-weight: 900;">(Required) </label>
                <input type="text" placeholder="Enter Firstname" title="Only Letters" pattern="[A-z]+" name="pg_first" required>
            </div>

            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">Parent/Guardian Middlename</label>
                <input type="text" placeholder="Enter Middlename" title="Only Letters" pattern="[A-z]+" name="pg_middle">
            </div>

            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">Parent/Guardian Lastname</label>
                <label for="subjectCode" style="font-weight: 900;">(Required) </label>
                <input type="text" placeholder="Enter Lastname" title="Only Letters" pattern="[A-z]+" name="pg_last" required>
            </div>

            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">Parent/Guardian Address</label>
                <label for="subjectCode" style="font-weight: 900;">(Required) </label>
                <input type="text" placeholder="Enter Address" title="Only Letters" pattern="[A-z0-9 ]+" name="pg_add" required>
            </div>

            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">Parent/Guardian Phone</label>
                <label for="subjectCode" style="font-weight: 900;">(Required) </label>
                <input type="number" placeholder="Enter Phone Number" title="Only Numbers" name="pg_phone" maxlength="7" title="ONLY 7 CHARACTERS ALLOWED" required>
            </div>

        </div>
        <div class="input-container" style="display: flex;">

            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">Parent/Guardian Email</label>
                <input type="email" placeholder="Enter Email" title="Only Numbers" name="pg_email">
            </div>

            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">Parent/Guardian Occupation</label>
                <label for="subjectCode" style="font-weight: 900;">(Required) </label>
                <input type="text" placeholder="Enter Occupation" title="Only Numbers" name="pg_occu" pattern="[A-z ]+" required>
            </div>

            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">Parent/Guardian Passport Size Photo</label>
                <label for="subjectCode" style="font-weight: 900;">(Required) </label>
                <input type="file"   name="pg_photo"  required>
            </div>

            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">Relationship</label>
                <label for="subjectCode" style="font-weight: 900;">(Required) </label>
                <select name="pg_relation" required>
                    <option disabled selected>Select Relationship Type</option>
                    <option>PARENT</option>
                    <option>GUARDIAN</option>
                </select>
            </div>
        </div>
        <div style="display:flex; margin-top:20px;">
            <Label style="font-size: 18px; font-family: righteous;
         font-weight: bold; color: #1D5B79;">Medical Information</Label>
        </div>

        <div class="input-container" style="display: flex;">

            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">Allergies (If No type None)</label>
                <label for="subjectCode" style="font-weight: 900;">(Required) </label>
                <input type="text" placeholder="Enter Allergies" title="Only Letters" pattern="[A-z ]+" name="stu_aller" required>
            </div>

            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">Medical Conditions (If No type None)</label>
                <label for="subjectCode" style="font-weight: 900;">(Required) </label>
                <input type="text" placeholder="Enter Medical Conditions" name="stu_cond" required>
            </div>

            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">Medications (If No type None)</label>
                <label for="subjectCode" style="font-weight: 900;">(Required) </label>
                <input type="text" placeholder="Enter Medications" title="Only Letters" pattern="[A-z0-9 ]+" name="stu_med" required>
            </div>
        </div>
        <div style="display:flex; margin-top:20px;">
            <Label style="font-size: 18px; font-family: righteous;
         font-weight: bold; color: #1D5B79;">Academic Information</Label>
        </div>

        <div class="input-container" style="display: flex;">

            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">Previous School</label>
                <label for="subjectCode" style="font-weight: 900;">(Required) </label>
                <input type="text" placeholder="Enter Previous School" title="Only Letters" pattern="[A-z ]+" name="stu_prev" required>
            </div>

            <div class="input-field" style="margin-right: 10px;">
                <label>Enrolling Grade</label>
                <label for="subjectCode" style="font-weight: 900;">(Required) </label>
                <select required name="stu_class">
                    <option disabled selected>Select Class</option>
                    <?php
                    $get_hos = "select * from CLASS WHERE S_ID= $sid order by class";
                    $get = oci_parse(oci_connect($username, $password, $connection), $get_hos);
                    oci_execute($get);
                    while ($row = oci_fetch_array($get)) {
                    ?><option>
                            <?php echo $row["CLASS_TITLE"]; ?>
                        </option> <?php
                                }
                                    ?>
                </select>
            </div>
        </div>
        <div style="display:flex; margin-top:20px;">
            <Label style="font-size: 18px; font-family: righteous;
         font-weight: bold; color: #1D5B79;">Student Documentation</Label>
        </div>

        <div class="input-container" style="display: flex;">

            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">Upload Birth Certificate</label>
                <label for="subjectCode" style="font-weight: 900;">(Required) </label>
                <input type="file" name="stu_birth" required>
            </div>

            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">Upload Passport/National ID</label>
                  <label for="subjectCode" style="font-weight: 900;">(Required) </label>
                <input type="file" name="stu_natid" required>
            </div>

            <div class="input-field" style="margin-right: 10px; ">
            <label for="subjectCode" style="font-weight: 900;">(Required) </label>
                <label for="subjectCode">Upload Passport Photo</label>
                <input type="file" name="stu_pass" required>
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
                ADD STUDENT
                <i class="uil uil-plus"></i>
            </button>
        </div>

        <?php
        if (isset($_POST['establish'])) {
            $currentDate = date("ymd");
            $sql = oci_parse($conn, "insert into SGEN_ID (GEN) values (1)");
            oci_execute($sql);
            $sql = oci_parse($conn, "select * from SGEN_ID order by id");
            oci_execute($sql);
            if ($r = oci_fetch_array($sql)) {
                $id = $r['ID'];
            }
            $sql = oci_parse($conn, "delete from Sgen_id where id = $id");
            oci_execute($sql);

            $stuid = "LBS" . $currentDate . "0" . $id;
            //STUDENT PERSONAL 
            $first = strtoupper($_POST['stu_first']);
            $middle = strtoupper($_POST['stu_middle']);
            $last = strtoupper($_POST['stu_last']);
            $dob = $_POST['stu_dob'];
            $gender = $_POST['stu_gender'];
            $nation = strtoupper($_POST['stu_nation']);
            $tribe = strtoupper($_POST['stu_tribe']);

            $name = $first . " " . $middle . " " . $last;

            //STUDENT CONTACT 
            $stu_add = strtoupper($_POST['stu_add']);
            $stu_email = strtoupper($_POST['stu_email']);
            $stu_phone = $_POST['stu_phone'];

            $stu_eme = $_POST['stu_eme'];

            //STUDENT AUTHOURITY
            $pg_first = strtoupper($_POST['pg_first']);
            $pg_middle = strtoupper($_POST['pg_middle']);
            $pg_last = strtoupper($_POST['pg_last']);
            $pg_add = strtoupper($_POST['pg_add']);
            $pg_phone = $_POST['pg_phone'];
            $pg_email = strtoupper($_POST['pg_email']);
            $pg_occu = strtoupper($_POST['pg_occu']);
            $pg_relation = $_POST['pg_relation'];

            //STUDENT MEDICAL
            $stu_aller = $_POST['stu_aller'];
            $stu_cond = $_POST['stu_cond'];
            $stu_med = $_POST['stu_med'];

            //STUDENT ACADEMIC 
            $stu_prev = $_POST['stu_prev'];
            $stu_class = $_POST['stu_class'];

            //STUDENT DOCUMENT
            $stu_birth = $_FILES['stu_birth']['tmp_name'];
            $stu_natid = $_FILES['stu_natid']['tmp_name'];
            $stu_pass = $_FILES['stu_pass']['tmp_name'];
             $pg_photo = $_FILES['pg_photo']['tmp_name'];
            if (isjpeg_png($stu_birth) || ispdf_word($stu_birth)) {
                if (isjpeg_png($stu_natid) || ispdf_word($stu_natid)) {
                    if (isjpeg_png($stu_pass)) {
                             if(isjpeg_png($pg_photo)){
                                $sql = oci_parse($conn, "SELECT * FROM STUDENT WHERE STUD_ID = '$stuid' and s_id = $sid");
                                oci_execute($sql);
                                if (oci_fetch_all($sql, $a) == 0) {
        
                                    $sql = oci_parse($conn, "INSERT INTO STUDENT (S_ID,STUD_ID,NAME,STATUS,CREATE_DT) VALUES ('$sid','$stuid','$name','REGISTERED',SYSDATE)");
                                    oci_execute($sql);
        
                                    $sql = oci_parse($conn, "SELECT * FROM STUDENT_PERSONAL WHERE STUD_ID='$stuid'");
                                    oci_execute($sql);
        
                                    if (oci_fetch_all($sql, $a) == 0) {
        
                                        $sql = oci_parse($conn, "INSERT INTO STUDENT_PERSONAL (STUD_ID,S_ID,FIRSTNAME,MIDDLENAME,LASTNAME,DOB,GENDER,NATION,TRIBE) VALUES ('$stuid',$sid,'$first','$middle','$last','$dob','$gender','$nation','$tribe')");
                                        oci_execute($sql);
        
                                        $sql = oci_parse($conn, "SELECT * FROM STUDENT_CONTACT WHERE STUD_ID='$stuid'");
                                        oci_execute($sql);
        
                                        if (oci_fetch_all($sql, $a) == 0) {
        
                                            $sql = oci_parse($conn, "INSERT INTO STUDENT_CONTACT (STUD_ID,S_ID,HOME_ADD,EMAIL,PHONE,EMERGENCY) VALUES ('$stuid',$sid,'$stu_add','$stu_email','$stu_phone','$stu_eme')");
                                            oci_execute($sql);
        
                                            

                                            $sql = oci_parse($conn, "SELECT * FROM STUDENT_AUTHOURITY WHERE STUD_ID='$stuid'");
                                            oci_execute($sql);
        
                                            if (oci_fetch_all($sql, $a) == 0) {
        
                                                $sql = oci_parse($conn, "INSERT INTO STUDENT_AUTHOURITY (STUD_ID,S_ID,FIRSTNAME,MIDDLENAME,LASTNAME,ADDRESS,PHONE,EMAIL,OCCUPATION,RELATION) VALUES ('$stuid',$sid,'$pg_first','$pg_middle','$pg_last','$pg_add',$pg_phone,'$pg_email','$pg_occu','$pg_relation')");
                                                oci_execute($sql);

                                                $query = "UPDATE STUDENT_AUTHOURITY SET PHOTO = :photo where stud_id = :stuid and s_id=:sid  ";
                                                $statement = oci_parse($conn, $query);
                                                oci_bind_by_name($statement, ':sid', $sid);
                                                oci_bind_by_name($statement, ':stuid', $stuid);

                                                $id_doc = file_get_contents($pg_photo);
                                                $lob = oci_new_descriptor($conn, OCI_D_LOB);
                                                oci_bind_by_name($statement, ':photo', $lob, -1, OCI_B_BLOB);
                                                $lob->writeTemporary($id_doc, OCI_TEMP_BLOB);
                                                oci_execute($statement, OCI_DEFAULT);

                                                $sql = oci_parse($conn, "SELECT * FROM STUDENT_MEDICAL WHERE STUD_ID='$stuid'");
                                                oci_execute($sql);
        
                                                if (oci_fetch_all($sql, $a) == 0) {
                                                    $sql = oci_parse($conn, "INSERT INTO STUDENT_MEDICAL (STUD_ID,S_ID,ALLERGY,CONDITION,MEDICATIONS) VALUES ('$stuid','$sid','$stu_aller','$stu_cond','$stu_med')");
                                                    oci_execute($sql);
        
                                                    $sql = oci_parse($conn, "SELECT * FROM STUDENT_ACADEMIC WHERE STUD_ID='$stuid'");
                                                    oci_execute($sql);
        
                                                    if (oci_fetch_all($sql, $a) == 0) {
        
                                                        $sql = oci_parse($conn, "select * from class where class_title='$stu_class'");
                                                        oci_execute($sql);
        
                                                        while ($r = oci_fetch_array($sql)) {
                                                            $stuclass = $r['CLASS'];
                                                        }
        
                                                        $sql = oci_parse($conn, "INSERT INTO STUDENT_ACADEMIC (STUD_ID,S_ID,CLASS,PREV_SCHOOL) VALUES ('$stuid','$sid','$stuclass','$stu_prev')");
                                                        oci_execute($sql);
        
                                                        $sql = oci_parse($conn, "SELECT * FROM STUDENT_DOCUMENT WHERE STUD_ID='$stuid'");
                                                        oci_execute($sql);
        
                                                        if (oci_fetch_all($sql, $a) == 0) {
                                                            $query = "insert into STUDENT_DOCUMENT (STUD_ID,S_ID,BIRTH,PASSPORT,PASS_PHOTO) VALUES (:stuid,:sid,:birth,:pass,:p_photo) ";
                                                            $statement = oci_parse($conn, $query);
                                                            oci_bind_by_name($statement, ':sid', $sid);
                                                            oci_bind_by_name($statement, ':stuid', $stuid);
        
                                                            $id_doc = file_get_contents($stu_birth);
                                                            $lob = oci_new_descriptor($conn, OCI_D_LOB);
                                                            oci_bind_by_name($statement, ':birth', $lob, -1, OCI_B_BLOB);
                                                            $lob->writeTemporary($id_doc, OCI_TEMP_BLOB);
        
                                                            $edu_doc = file_get_contents($stu_natid);
        
                                                            $lob1 = oci_new_descriptor($conn, OCI_D_LOB);
                                                            oci_bind_by_name($statement, ':pass', $lob1, -1, OCI_B_BLOB);
                                                            $lob1->writeTemporary($edu_doc, OCI_TEMP_BLOB);
        
        
                                                            $pass_photo = file_get_contents($stu_pass);
                                                            $lob2 = oci_new_descriptor($conn, OCI_D_LOB);
                                                            oci_bind_by_name($statement, ':p_photo', $lob2, -1, OCI_B_BLOB);
                                                            $lob2->writeTemporary($pass_photo, OCI_TEMP_BLOB);
        
                                                            oci_execute($statement, OCI_DEFAULT);
        
                                                            $student = oci_parse($conn, "SELECT * FROM STUDENT WHERE S_ID=$sid and stud_id= '$stuid' and status = 'REGISTERED' AND NAME = '$name' ");
                                                            oci_execute($student);
        
                                                            $personal = oci_parse($conn, "SELECT * FROM STUDENT_PERSONAL WHERE S_ID=$sid and stud_id= '$stuid'");
                                                            oci_execute($personal);
        
                                                            $contact = oci_parse($conn, "SELECT * FROM STUDENT_CONTACT WHERE S_ID=$sid and stud_id= '$stuid'");
                                                            oci_execute($contact);
        
                                                            $AUTHOURITY = oci_parse($conn, "SELECT * FROM STUDENT_AUTHOURITY WHERE S_ID=$sid and stud_id= '$stuid'");
                                                            oci_execute($AUTHOURITY);
        
                                                            $MEDICAL = oci_parse($conn, "SELECT * FROM STUDENT_MEDICAL WHERE S_ID=$sid and stud_id= '$stuid'");
                                                            oci_execute($MEDICAL);
        
                                                            $ACADEMIC = oci_parse($conn, "SELECT * FROM STUDENT_ACADEMIC WHERE S_ID=$sid and stud_id= '$stuid'");
                                                            oci_execute($ACADEMIC);
        
                                                            $DOCUMENT = oci_parse($conn, "SELECT * FROM STUDENT_DOCUMENT WHERE S_ID=$sid and stud_id= '$stuid'");
                                                            oci_execute($DOCUMENT);
        
                                                            if ((oci_fetch_all($student, $a) > 0) && (oci_fetch_all($personal, $a) > 0) && (oci_fetch_all($contact, $a) > 0) && (oci_fetch_all($AUTHOURITY, $a) > 0) && (oci_fetch_all($MEDICAL, $a) > 0) && (oci_fetch_all($ACADEMIC, $a) > 0) && (oci_fetch_all($DOCUMENT, $a) > 0)) {
                ?><div style="font-size:15px;
                                                                color: green;
                                                                position: relative;
                                                                 display:flex;
                                                                 margin-left:10px;
                                                                animation:button .3s linear;text-align: center;">
                                                                    <?php echo "STUDENT ADDED SUCCESSFULLY";
                                                                    header("refresh:2;");
                                                                    ?></div><?php
                                                                        } else {
                                                                            ?><div style="font-size:15px;
                                                                color: red;
                                                                position: relative;
                                                                 display:flex;
                                                                 margin-left:10px;
                                                                animation:button .3s linear;text-align: center;">
                                                                    <?php echo "ERROR ADDING STUDENT";
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
                                                                <?php echo "DOCUMENTATION ALREADY UPLOADED";
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
                                                            <?php echo "ACADEMIC INFORMATION ALREADY SAVED";
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
                                                        <?php echo "MEDICAL INFORMATION ALREADY SAVED";
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
                                                    <?php echo "PARENT/GUARDIAN INFORMATION ALREADY SAVED";
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
                                                <?php echo "CONTACT INFORMATION ALREADY SAVED";
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
                                            <?php echo "PERSONAL INFORMATION ALREADY SAVED";
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
                                        <?php echo "STUDENT ID ALREADY EXISTS ";
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
                                    <?php echo "ALLOWED FILE TYPES FOR PARENT/GUARDIAN PASSPORT SIZE PHOTO UPLOAD ARE PNG OR JPEG";
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
                            <?php echo "ALLOWED FILE TYPES FOR PASSPORT SIZE PHOTO UPLOAD ARE PNG OR JPEG";
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
                        <?php echo "ALLOWED FILE TYPES FOR NATIONAL ID/PASSPORT UPLOAD ARE PDF OR WORD OR PNG OR JPEG";
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
                    <?php echo "ALLOWED FILE TYPES FOR BIRTH CERTIFICATE UPLOAD ARE PDF OR WORD OR PNG OR JPEG";
                            header("refresh:2;");
                    ?></div><?php
                        }
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