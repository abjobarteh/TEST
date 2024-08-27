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
$sub_cd =  $_SESSION['s_code'];
$a_y = $_SESSION['year'];
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
    <form class="container" enctype="multipart/form-data" action="active_student.php" method="post" style ="width: 1300px;">
        <div class="com">
            <h3>
                Academix: School Management System
            </h3>
            <h2 class="title" style="justify-content:center; text-align:center; color:#04716f; 	font-size: 18px;"><?php echo $school ?>
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
        <header>Show Student</header>
        <?php
        include 'connect.php';
        $region = " ";
        $stuid = 'stuid';
   //  echo  "select * from student a  join class_student c on (a.stud_id=c.stud_id) where a.s_id = $sid and c.sub_code = $sub_cd and a.status != 'GRADUATED' ORDER BY NAME";
        ?>
        
        <div class="input-field">
            <select required name="reg">
                <option disabled selected>Select Student ID</option>
                <?php

                $get_hos = "select DISTINCT(A.STUD_ID),A.NAME from student a  join class_student c on (a.stud_id=c.stud_id) where a.s_id = $sid and c.sub_code = $sub_cd and a.status != 'GRADUATED' ORDER BY NAME";

                $get = oci_parse(oci_connect($username, $password, $connection), $get_hos);
                oci_execute($get);
                while ($row = oci_fetch_array($get)) {
                ?><option value="<?php echo $row["STUD_ID"]; ?> ">
                        <?php echo $row["NAME"] . " (" . $row["STUD_ID"] . ")"; ?>
                    </option> <?php
                            }
                                ?>
            </select>
        </div>
        <?php // echo $get_hos; 
        ?>
        <button style=" display: inline-block;
  padding: 6px 12px;
  background-color: #04716f;
  color: white;
  border: none;
  border-radius: 4px;
  text-decoration: none;" name="filter" type="submit">
            FILTER
            <i class="uil uil-filter"></i>
        </button>
        <?php
        $rcode = 0;
        if (isset($_POST['filter'])) {
            if (isset($_POST['reg'])) {
                $stuid = trim($_POST['reg']);
                $_SESSION['stud_id'] = $stuid;
            } else {
        ?><div style="font-size:15px;
                color: red;
                position: relative;
                 display:flex;
                 margin-left:10px;
                animation:button .3s linear;text-align: center;">
                    <?php echo "SELECT STUDENT ID";
                    header("refresh:2;");
                    ?></div><?php
                        }
                    }
                            ?>
        <div>
            <?php
            $stmt = oci_parse($conn, "select * from student_document where stud_id = '$stuid' ");
            oci_execute($stmt);

            while ($rowS = oci_fetch_array($stmt, OCI_ASSOC + OCI_RETURN_NULLS)) {
                // Check if $rowS['PASS_PHOTO'] is not null before calling load()
                if (!empty($rowS['PASS_PHOTO'])) {
                    $imageData = $rowS['PASS_PHOTO']->load(); // Load OCILob data

                    // Encode the image data as base64
                    $base64Image = base64_encode($imageData);

                    // Display the image
                    echo '<img src="data:image/png;base64,' . $base64Image . '" alt="Image" style="width: 100px; height: 100px;">';
                } else {
                    // Handle the case where $rowS['PASS_PHOTO'] is null or empty
                    //echo 'No image available';
                }
            }
            ?>
        </div>
        <?php

        include 'connect.php';

        if ($conn) {
            ob_start();
            $sql = "select * from student where stud_id = '$stuid' ";
            $stid = oci_parse($conn, $sql);
            oci_execute($stid);
        } else {
        ?><div style="font-size:15px;
                    color: red;
                    position: relative;
                     display:flex;
                    animation:button .3s linear;text-align: center;">
                <?php echo "ERROR CONNECTING TO DATABASE"; ?>
            </div> <?php
                }
                    ?>
        <div style="display:flex; margin-top:20px;">
            <Label style="font-size: 18px; font-family: righteous;
         font-weight: bold; color: #04716f;">Student Information</Label>
        </div>
        <table class="table-content" style="  font-size: 14px;
    border-collapse: collapse;
    margin: 10px 0;
    font: 0.9em;
    min-width: 400px;
    border-radius: 5px 5px;
    overflow: hidden;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);">
            <thead>
                <tr style="  background-color: #04716f;
    color: #ffffff;
    text-align: left;
    font-weight: bold;">

                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Student ID</th>
                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Name</th>
                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Status</th>
                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Registration Date</th>
                </tr>
            </thead>
            <tbody>
                <tr style=" border-bottom: 1px solid #dddddd;">
                    <?php
                    while ($row = oci_fetch_array($stid)) {
                    ?>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['STUD_ID']; ?>

                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['NAME']; ?>

                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['STATUS']; ?>

                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['CREATE_DT']; ?>

                        </td>
                </tr>
            <?php
                    }
            ?>
            </tr>
            </tbody>
        </table>
        <?php
        if ($conn) {
            ob_start();
            $p = "select * from student_personal where stud_id = '$stuid' ";

            $per = oci_parse($conn, $p);
            oci_execute($per);
        } else {
        ?><div style="font-size:15px;
                    color: red;
                    position: relative;
                     display:flex;
                    animation:button .3s linear;text-align: center;">
                <?php echo "ERROR CONNECTING TO DATABASE"; ?>
            </div> <?php
                }
                    ?>
        <div style="display:flex; margin-top:20px;">
            <Label style="font-size: 18px; font-family: righteous;
         font-weight: bold; color: #04716f;">Personal Information</Label>
        </div>
        <table class="table-content" style="  font-size: 14px;
    border-collapse: collapse;
    margin: 10px 0;
    font: 0.9em;
    min-width: 400px;
    border-radius: 5px 5px;
    overflow: hidden;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);">
            <thead>
                <tr style="  background-color: #04716f;
    color: #ffffff;
    text-align: left;
    font-weight: bold;">

                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Firstname</th>
                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Middlename</th>
                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Lastname</th>
                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Date Of Birth</th>
                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Gender</th>
                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Tribe</th>
                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Nationality</th>
                </tr>
            </thead>
            <tbody>
                <tr style=" border-bottom: 1px solid #dddddd;">
                    <?php
                    while ($row = oci_fetch_array($per)) {
                    ?>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['FIRSTNAME']; ?>

                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['MIDDLENAME']; ?>

                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['LASTNAME']; ?>

                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['DOB']; ?>

                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['GENDER']; ?>

                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['TRIBE']; ?>

                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['NATION']; ?>

                        </td>
                </tr>
            <?php
                    }
            ?>
            </tr>
            </tbody>
        </table>
        <?php
        if ($conn) {
            ob_start();
            $p = "select * from student_contact where stud_id = '$stuid' ";
            $per = oci_parse($conn, $p);
            oci_execute($per);
        } else {
        ?><div style="font-size:15px;
                    color: red;
                    position: relative;
                     display:flex;
                    animation:button .3s linear;text-align: center;">
                <?php echo "ERROR CONNECTING TO DATABASE"; ?>
            </div> <?php
                }
                    ?>
        <div style="display:flex; margin-top:20px;">
            <Label style="font-size: 18px; font-family: righteous;
         font-weight: bold; color: #04716f;">Contact Information</Label>
        </div>
        <table class="table-content" style="  font-size: 14px;
    border-collapse: collapse;
    margin: 10px 0;
    font: 0.9em;
    min-width: 400px;
    border-radius: 5px 5px;
    overflow: hidden;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);">
            <thead>
                <tr style="  background-color: #04716f;
    color: #ffffff;
    text-align: left;
    font-weight: bold;">

                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Home Address</th>
                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Email</th>
                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Phone Contact</th>
                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Emergency Contact</th>
                </tr>
            </thead>
            <tbody>
                <tr style=" border-bottom: 1px solid #dddddd;">
                    <?php
                    while ($row = oci_fetch_array($per)) {
                    ?>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['HOME_ADD']; ?>

                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['EMAIL']; ?>

                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['PHONE']; ?>

                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['EMERGENCY']; ?>

                        </td>
                </tr>
            <?php
                    }
            ?>
            </tr>
            </tbody>
        </table>
        <?php
        if ($conn) {
            ob_start();
            $p = "select * from student_authourity where stud_id = '$stuid' ";
            $per = oci_parse($conn, $p);
            oci_execute($per);
        } else {
        ?><div style="font-size:15px;
                    color: red;
                    position: relative;
                     display:flex;
                    animation:button .3s linear;text-align: center;">
                <?php echo "ERROR CONNECTING TO DATABASE"; ?>
            </div> <?php
                }
                    ?>
        <div style="display:flex; margin-top:20px;">
            <Label style="font-size: 18px; font-family: righteous;
         font-weight: bold; color: #04716f;">Parent/Guardian Information</Label>
        </div>
        <table class="table-content" style="  font-size: 14px;
    border-collapse: collapse;
    margin: 10px 0;
    font: 0.9em;
    min-width: 400px;
    border-radius: 5px 5px;
    overflow: hidden;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);">
            <thead>
                <tr style="  background-color: #04716f;
    color: #ffffff;
    text-align: left;
    font-weight: bold;">

                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Firstname</th>
                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Middlename</th>
                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Lastname</th>
                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Address</th>
                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Father Name</th>
                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Mother Name</th>
                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Phone</th>
                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Email</th>
                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Occupation</th>
                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Father's Occupation</th>
                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Mother's Occupation</th>

                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Relationship</th>
                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        ID Photo</th>
                </tr>
            </thead>
            <tbody>
                <tr style=" border-bottom: 1px solid #dddddd;">
                    <?php
                    while ($row = oci_fetch_array($per)) {
                    ?>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['FIRSTNAME']; ?>

                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['MIDDLENAME']; ?>

                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['LASTNAME']; ?>

                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['ADDRESS']; ?>

                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['FATHER']; ?>

                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['MOTHER']; ?>

                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['PHONE']; ?>

                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['EMAIL']; ?>

                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['OCCUPATION']; ?>

                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['FATHER_OCCUP']; ?>

                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['MOTHER_OCCUP']; ?>

                        </td>

                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['RELATION']; ?>

                        </td>
                        <?php
                        // Check if $row['PHOTO'] is not null before calling load()
                        if (!empty($row['PHOTO'])) {
                            $imageData = $row['PHOTO']->load();
                            $base64Image = base64_encode($imageData);
                        ?>
                            <td style="padding: 5px 8px; font-size: 10px; margin: 5px;">
                                <?php echo '<img src="data:image/png;base64,' . $base64Image . '" alt="Image" style="width: 50px; height: 50px;">'; ?>
                            </td>
                        <?php
                        } else {
                            // Handle the case where $row['PHOTO'] is null or empty
                        ?>
                            <td style="padding: 5px 8px; font-size: 10px; margin: 5px;">
                                <?php //echo 'No image available'; 
                                ?>
                            </td>
                        <?php
                        }
                        ?>

                </tr>
            <?php
                    }
            ?>
            </tr>
            </tbody>
        </table>
        <?php
        if ($conn) {
            ob_start();
            $p = "select * from student_medical where stud_id = '$stuid' ";

            $per = oci_parse($conn, $p);
            oci_execute($per);
        } else {
        ?><div style="font-size:15px;
                    color: red;
                    position: relative;
                     display:flex;
                    animation:button .3s linear;text-align: center;">
                <?php echo "ERROR CONNECTING TO DATABASE"; ?>
            </div> <?php
                }
                    ?>
        <div style="display:flex; margin-top:20px;">
            <Label style="font-size: 18px; font-family: righteous;
         font-weight: bold; color: #04716f;">Medical Information</Label>
        </div>
        <table class="table-content" style="  font-size: 14px;
    border-collapse: collapse;
    margin: 10px 0;
    font: 0.9em;
    min-width: 400px;
    border-radius: 5px 5px;
    overflow: hidden;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);">
            <thead>
                <tr style="  background-color: #04716f;
    color: #ffffff;
    text-align: left;
    font-weight: bold;">

                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Allergy</th>
                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Medical Conditions</th>
                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Medications</th>
                </tr>
            </thead>
            <tbody>
                <tr style=" border-bottom: 1px solid #dddddd;">
                    <?php
                    while ($row = oci_fetch_array($per)) {
                    ?>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['ALLERGY']; ?>

                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['CONDITION']; ?>

                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['MEDICATIONS']; ?>

                        </td>
                </tr>
            <?php
                    }
            ?>
            </tr>
            </tbody>
        </table>

        <?php
        if ($conn) {
            ob_start();
            $p = "select * from student_academic a join sub_class b on (a.sub_code=b.sub_code) where a.stud_id = '$stuid' ";

            $per = oci_parse($conn, $p);
            oci_execute($per);
        } else {
        ?><div style="font-size:15px;
                    color: red;
                    position: relative;
                     display:flex;
                    animation:button .3s linear;text-align: center;">
                <?php echo "ERROR CONNECTING TO DATABASE"; ?>
            </div> <?php
                }
                    ?>
        <div style="display:flex; margin-top:20px;">
            <Label style="font-size: 18px; font-family: righteous;
         font-weight: bold; color: #04716f;">Academic Information</Label>
        </div>
        <table class="table-content" style="  font-size: 14px;
    border-collapse: collapse;
    margin: 10px 0;
    font: 0.9em;
    min-width: 400px;
    border-radius: 5px 5px;
    overflow: hidden;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);">
            <thead>
                <tr style="  background-color: #04716f;
    color: #ffffff;
    text-align: left;
    font-weight: bold;">

                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Previous School</th>
                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Enrolling Grade</th>
                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Previous Aggregate/GPA</th>
                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Enrolling Year</th>
                </tr>
            </thead>
            <tbody>
                <tr style=" border-bottom: 1px solid #dddddd;">
                    <?php
                    while ($row = oci_fetch_array($per)) {
                    ?>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['PREV_SCHOOL']; ?>

                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['CLASS_NAME']; ?>

                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['SCORE']; ?>

                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['ACADEMIC_YEAR']; ?>

                        </td>
                </tr>
            <?php
                    }
            ?>
            </tr>
            </tbody>
        </table>

        <?php
        if ($conn) {
            ob_start();
            $cl = "select * from class_student a join sub_class c on (a.sub_code=c.sub_code) where a.stud_id = '$stuid' ";
            $ab = oci_parse($conn, $cl);
            oci_execute($ab);
        } else {
        ?><div style="font-size:15px;
                    color: red;
                    position: relative;
                     display:flex;
                    animation:button .3s linear;text-align: center;">
                <?php echo "ERROR CONNECTING TO DATABASE"; ?>
            </div> <?php
                }
                    ?>
        <div style="display:flex; margin-top:20px;">
            <Label style="font-size: 18px; font-family: righteous;
         font-weight: bold; color: #04716f;">Class Information</Label>
        </div>
        <table class="table-content" style="  font-size: 14px;
    border-collapse: collapse;
    margin: 10px 0;
    font: 0.9em;
    min-width: 400px;
    border-radius: 5px 5px;
    overflow: hidden;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);">
            <thead>
                <tr style="  background-color: #04716f;
    color: #ffffff;
    text-align: left;
    font-weight: bold;">

                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Class</th>
                </tr>
            </thead>
            <tbody>
                <tr style=" border-bottom: 1px solid #dddddd;">
                    <?php
                    while ($row = oci_fetch_array($ab)) {
                    ?>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['CLASS_NAME']; ?>

                        </td>

                </tr>
            <?php
                    }
            ?>
            </tr>
            </tbody>
        </table>
        <?php
        if ($conn) {

            ob_start();
            $s = "select distinct(a.subject),c.sub_type from waec_subject a join student_subject b on (a.sub_code=b.sub_code) join subject c on (a.sub_code = c.sub_code)  where b.stud_id = '$stuid' and c.subs=$sub_cd order by c.sub_type,a.subject ";
//echo $s;
            $subj = oci_parse($conn, $s);
            oci_execute($subj);
        } else {
        ?><div style="font-size:15px;
                    color: red;
                    position: relative;
                     display:flex;
                    animation:button .3s linear;text-align: center;">
                <?php echo "ERROR CONNECTING TO DATABASE"; ?>
            </div> <?php
                }
                    ?>
        <div style="display:flex; margin-top:20px;">
            <Label style="font-size: 18px; font-family: righteous;
         font-weight: bold; color: #04716f;">Subject Information</Label>
        </div>
        <table class="table-content" style="  font-size: 14px;
    border-collapse: collapse;
    margin: 10px 0;
    font: 0.9em;
    min-width: 400px;
    border-radius: 5px 5px;
    overflow: hidden;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);">
            <thead>
                <tr style="  background-color: #04716f;
    color: #ffffff;
    text-align: left;
    font-weight: bold;">

                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Subject</th>
                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Subject Type</th>
                </tr>
            </thead>
            <tbody>
                <tr style=" border-bottom: 1px solid #dddddd;">
                    <?php
                    while ($row = oci_fetch_array($subj)) {
                    ?>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['SUBJECT']; ?>

                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['SUB_TYPE']; ?>

                        </td>

                </tr>
            <?php
                    }
            ?>
            </tr>
            </tbody>
        </table>

        <?php
        if ($conn) {

            ob_start();
            $getsub = "select distinct(subject),sub_code from subject  where subs = $sub_cd and s_id = $sid  ";
            //   echo $getsub;
            $subjs = oci_parse($conn, $getsub);
            oci_execute($subjs);
        } else {
        ?><div style="font-size:15px;
                    color: red;
                    position: relative;
                     display:flex;
                    animation:button .3s linear;text-align: center;">
                <?php echo "ERROR CONNECTING TO DATABASE"; ?>
            </div> <?php
                }
                    ?>
        <div style="display:flex; margin-top:20px;">
            <Label style="font-size: 18px; font-family: righteous;
         font-weight: bold; color: #04716f;">Subject</Label>
        </div>
        <table class="table-content" style="  font-size: 14px;
    border-collapse: collapse;
    margin: 10px 0;
    font: 0.9em;
    min-width: 400px;
    border-radius: 5px 5px;
    overflow: hidden;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);">
            <thead>
                <tr style="  background-color: #04716f;
    color: #ffffff;
    text-align: left;
    font-weight: bold;">

                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Subject</th>
                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Assign/Unassign</th>
                </tr>
            </thead>
            <tbody>
                <tr style=" border-bottom: 1px solid #dddddd;">
                    <?php
                    while ($row = oci_fetch_array($subjs)) {
                    ?>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['SUBJECT']; ?>
                        <td><input type="checkbox" name="un[]" value="<?php echo $row['SUB_CODE']; ?>"></td>
                        </td>

                </tr>
            <?php
                    }
            ?>
            </tr>
            </tbody>
        </table>
        <button style=" display: inline-block;
  padding: 6px 12px;
  background-color: #04716f;
  color: white;
  border: none;
  border-radius: 4px;
  margin-top:10px;
  margin-bottom:10px;
  text-decoration: none;" name="assign_sub" type="submit">
            ASSIGN
            <i class="uil uil-plus"></i>
        </button>
        <button style=" display: inline-block;
  padding: 6px 12px;
  background-color: #04716f;
  color: white;
  border: none;
  border-radius: 4px;
  margin-top:10px;
  margin-bottom:10px;
  text-decoration: none;" name="unassign_sub" type="submit">
            UNASSIGN
            <i class="uil uil-trash-alt"></i>
        </button>
      
        <?php
        if (isset($_POST['unassign_sub'])) {
            if (isset($_POST['un']) && !empty($_POST['un'])) {
                $selected_subcode = $_POST['un'];
                foreach ($selected_subcode as $subs_code) {
                    $stuid =  $_SESSION['stud_id'];
                    $check = oci_parse($conn, "select * from student_subject where sub_code = $subs_code and stud_id = '$stuid' ");
                    oci_execute($check);
                    if (oci_fetch_all($check, $s) == 0) {
                        continue;
                    }
                    $stuid =  $_SESSION['stud_id'];
                    $sql = oci_parse($conn, "DELETE FROM STUDENT_SUBJECT WHERE STUD_ID = '$stuid' and sub_code =  $subs_code and s_id = $sid");
                    oci_execute($sql);
                    //    echo "DELETE FROM STUDENT_SUBJECT WHERE STUD_ID = '$stuid' and sub_code =  $subs_code and s_id = $sid ";
                }
        ?><div style="font-size:15px;
                color: green;
                position: relative;
                 display:flex;
                animation:button .3s linear;text-align: center;">
                    <?php echo "SUBJECT UNASSIGNED";
                    header("refresh:2;");
                    ?>
                </div> <?php
                    } else {
                        ?><div style="font-size:15px;
                                    color: red;
                                    position: relative;
                                     display:flex;
                                    animation:button .3s linear;text-align: center;">
                    <?php echo "SELECT SUBJECT";
                        header("refresh:2;");
                    ?>
                </div> <?php
                    }
                }
                if (isset($_POST['assign_sub'])) {
                    if (isset($_POST['un']) && !empty($_POST['un'])) {
                      
                        $selected_subcode = $_POST['un'];
                        foreach ($selected_subcode as $subs_code) {
                            $stuid =  $_SESSION['stud_id'];
                            $check = oci_parse($conn, "select * from student_subject where sub_code = $subs_code and stud_id = '$stuid' ");
                        //  echo "select * from student_subject where sub_code = $subs_code and stud_id = '$stuid' ";
                           oci_execute($check);

                            if (oci_fetch_all($check, $s) > 0) {
                                continue;
                            }
                           
                            $sql = oci_parse($conn, "INSERT INTO STUDENT_SUBJECT (S_ID,SUB_CODE,STUD_ID) VALUES ($sid,$subs_code,'$stuid')");
                          //  echo "INSERT INTO STUDENT_SUBJECT (S_ID,SUB_CODE,STUD_ID) VALUES ($sid,$subs_code,'$stuid')";
                            oci_execute($sql);
                            ?><div style="font-size:15px;
                            color: green;
                            position: relative;
                             display:flex;
                            animation:button .3s linear;text-align: center;">
                                <?php echo "SUBJECT ASSIGNED";
                                header("refresh:2;");
                                ?>
                            </div> <?php
                        
                           //    echo "DELETE FROM STUDENT_SUBJECT WHERE STUD_ID = '$stuid' and sub_code =  $subs_code and s_id = $sid ";
                        }

                            } else {
                                ?><div style="font-size:15px;
                                            color: red;
                                            position: relative;
                                             display:flex;
                                            animation:button .3s linear;text-align: center;">
                            <?php echo "SELECT SUBJECT";
                                header("refresh:2;");
                            ?>
                        </div> <?php
                            }
                        }
                        ?>
        <div style="display: flex;">

            <div class="input-field" style="margin-right: 10px;">
                <label>Class</label>
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
            <div class="input-field" style="margin-right: 10px;">
                <label>Sub Class</label>
                <select required name="stu_subclass">
                    <option disabled selected>Select Sub Class</option>
                    <?php
                    $get_hos = "select * from SUB_CLASS WHERE S_ID= $sid order by class";
                    $get = oci_parse(oci_connect($username, $password, $connection), $get_hos);
                    oci_execute($get);
                    while ($row = oci_fetch_array($get)) {
                    ?><option>
                            <?php echo $row["SUB_TITLE"]; ?>
                        </option> <?php
                                }
                                    ?>
                </select>
            </div>
            <button style=" display: inline-block;
  padding: 6px 12px;
  background-color: #04716f;
  color: white;
  border: none;
  border-radius: 4px;
  margin-top:10px;
  margin-bottom:10px;
  text-decoration: none;" name="generate" type="submit">
                GENERATE EXCEL REPORT OF STUDENT
                <i class="uil uil-file-export"></i>
            </button>

        </div>
        <?php
        require '../vendor/autoload.php';

        use PhpOffice\PhpSpreadsheet\Spreadsheet;
        use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

        if (isset($_POST['generate'])) {

            if (isset($_POST['stu_class'])) {
                $class = $_POST['stu_class'];
                $query = "select a.stud_id,a.create_dt,a.status,b.firstname,b.middlename,b.lastname,b.dob,b.gender,b.nation,b.tribe,c.home_add,c.email,c.phone,c.emergency,d.firstname as pg_first,d.middlename as pg_middle,d.lastname as pg_last,d.address as pg_add,d.phone as pg_phone,d.email as pg_email,d.occupation,d.relation , e.prev_school,f.class_title,g.allergy,g.condition,g.medications from 
                student a join student_personal b on (a.stud_id=b.stud_id) join student_contact c on (a.stud_id=c.stud_id) join student_authourity d on (a.stud_id=d.stud_id) join student_academic e on (a.stud_id=e.stud_id) join class f on (e.class=f.class) join student_medical g on (a.stud_id=g.stud_id) where f.class_title = '$class' ";
                // Prepare and execute the query
                $statement = oci_parse($conn, $query);
                oci_execute($statement);
                $spreadsheet = new Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();
                $sheet->setCellValue('A1', 'STUDENT ID');
                $sheet->setCellValue('B1', 'REGISTRATION DATE');
                $sheet->setCellValue('C1', 'STUDENT STATUS');
                $sheet->setCellValue('D1', 'FIRSTNAME');
                $sheet->setCellValue('E1', 'MIDDLENAME');
                $sheet->setCellValue('F1', 'LASTNAME');
                $sheet->setCellValue('G1', 'DATE OF BIRTH');
                $sheet->setCellValue('H1', 'GENDER');
                $sheet->setCellValue('I1', 'NATIONALITY');
                $sheet->setCellValue('J1', 'TRIBE');
                $sheet->setCellValue('K1', 'HOME ADDRESS');
                $sheet->setCellValue('L1', 'EMAIL');
                $sheet->setCellValue('M1', 'PHONE');
                $sheet->setCellValue('N1', 'EMERGENCY CONTACT');
                $sheet->setCellValue('O1', 'PARENT/GUARDIAN FIRSTNAME');
                $sheet->setCellValue('P1', 'PARENT/GUARDIAN MIDDLENAME');
                $sheet->setCellValue('Q1', 'PARENT/GUARDIAN LASTNAME');
                $sheet->setCellValue('R1', 'PARENT/GUARDIAN ADDRESS');
                $sheet->setCellValue('S1', 'PARENT/GUARDIAN CONTACT');
                $sheet->setCellValue('T1', 'PARENT/GUARDIAN EMAIL');
                $sheet->setCellValue('U1', 'PARENT/GUARDIAN OCCUPATION');
                $sheet->setCellValue('V1', 'PARENT/GUARDIAN RELATIONSHIP');
                $sheet->setCellValue('W1', 'PREVIOUS SCHOOL');
                $sheet->setCellValue('X1', 'CLASS TO BE ENROLLED');
                $sheet->setCellValue('Y1', 'ALLERGY');
                $sheet->setCellValue('Z1', 'CONDITION');
                $sheet->setCellValue('AA1', 'MEDICATIONS');

                $directoryPath = 'C:/ACADEMIX/' . $school . '/generated_reports/student/';
                $filePath = $directoryPath . 'Byclass_students.xlsx';
                if (!is_dir($directoryPath)) {
                    if (!mkdir($directoryPath, 0777, true)) {
                        die('Failed to create directories.');
                    }
                }

                $row = 2;
                while ($row_data = oci_fetch_assoc($statement)) {
                    $sheet->setCellValue('A' . $row, $row_data['STUD_ID']);
                    $sheet->setCellValue('B' . $row, $row_data['CREATE_DT']);
                    $sheet->setCellValue('C' . $row, $row_data['STATUS']);
                    $sheet->setCellValue('D' . $row, $row_data['FIRSTNAME']);
                    $sheet->setCellValue('E' . $row, $row_data['MIDDLENAME']);
                    $sheet->setCellValue('F' . $row, $row_data['LASTNAME']);
                    $sheet->setCellValue('G' . $row, $row_data['DOB']);
                    $sheet->setCellValue('H' . $row, $row_data['GENDER']);
                    $sheet->setCellValue('I' . $row, $row_data['NATION']);
                    $sheet->setCellValue('J' . $row, $row_data['TRIBE']);
                    $sheet->setCellValue('K' . $row, $row_data['HOME_ADD']);
                    $sheet->setCellValue('L' . $row, $row_data['EMAIL']);
                    $sheet->setCellValue('M' . $row, $row_data['PHONE']);
                    $sheet->setCellValue('N' . $row, $row_data['EMERGENCY']);
                    $sheet->setCellValue('O' . $row, $row_data['PG_FIRST']);
                    $sheet->setCellValue('P' . $row, $row_data['PG_MIDDLE']);
                    $sheet->setCellValue('Q' . $row, $row_data['PG_LAST']);
                    $sheet->setCellValue('R' . $row, $row_data['PG_ADD']);
                    $sheet->setCellValue('S' . $row, $row_data['PG_PHONE']);
                    $sheet->setCellValue('T' . $row, $row_data['PG_EMAIL']);
                    $sheet->setCellValue('U' . $row, $row_data['OCCUPATION']);
                    $sheet->setCellValue('V' . $row, $row_data['RELATION']);
                    $sheet->setCellValue('W' . $row, $row_data['PREV_SCHOOL']);
                    $sheet->setCellValue('X' . $row, $row_data['CLASS_TITLE']);
                    $sheet->setCellValue('Y' . $row, $row_data['ALLERGY']);
                    $sheet->setCellValue('Z' . $row, $row_data['CONDITION']);
                    $sheet->setCellValue('AA' . $row, $row_data['MEDICATIONS']);

                    $row++;
                }
                $writer = new Xlsx($spreadsheet);
                // Output the Excel file
                $writer->save($filePath)
        ?><div style="font-size:15px;
                    color: green;
                    position: relative;
                     display:flex;
                    animation:button .3s linear;text-align: center;">
                    <?php echo "FILE GENERATED TO $filePath";

                    header("refresh:2;");
                    ?>
                </div> <?php
                        // Close the Oracle connection
                        oci_free_statement($statement);
                        oci_close($conn);
                    } else if (isset($_POST['stu_subclass'])) {
                        /*      $class = $_POST['stu_subclass'];
                        $query = "select a.stud_id,a.create_dt,a.status,b.firstname,b.middlename,b.lastname,b.dob,b.gender,b.nation,b.tribe,c.home_add,c.email,c.phone,c.emergency,d.firstname as pg_first,d.middlename as pg_middle,d.lastname as pg_last,d.address as pg_add,d.phone as pg_phone,d.email as pg_email,d.occupation,d.relation , e.prev_school,f.class_title,g.allergy,g.condition,g.medications from 
                        student a join student_personal b on (a.stud_id=b.stud_id) join student_contact c on (a.stud_id=c.stud_id) join student_authourity d on (a.stud_id=d.stud_id) join student_academic e on (a.stud_id=e.stud_id) join class f on (e.class=f.class) join student_medical g on (a.stud_id=g.stud_id)  ";
                            // Prepare and execute the query
                            $statement = oci_parse($conn, $query);
                            oci_execute($statement);
                            $spreadsheet = new Spreadsheet();
                            $sheet = $spreadsheet->getActiveSheet();
                            $sheet->setCellValue('A1', 'STUDENT ID');
                            $sheet->setCellValue('B1', 'REGISTRATION DATE');
                            $sheet->setCellValue('C1', 'STUDENT STATUS');
                            $sheet->setCellValue('D1', 'FIRSTNAME');
                            $sheet->setCellValue('E1', 'MIDDLENAME');
                            $sheet->setCellValue('F1', 'LASTNAME');
                            $sheet->setCellValue('G1', 'DATE OF BIRTH');
                            $sheet->setCellValue('H1', 'GENDER');
                            $sheet->setCellValue('I1', 'NATIONALITY');
                            $sheet->setCellValue('J1', 'TRIBE');
                            $sheet->setCellValue('K1', 'HOME ADDRESS');
                            $sheet->setCellValue('L1', 'EMAIL');
                            $sheet->setCellValue('M1', 'PHONE');
                            $sheet->setCellValue('N1', 'EMERGENCY CONTACT');
                            $sheet->setCellValue('O1', 'PARENT/GUARDIAN FIRSTNAME');
                            $sheet->setCellValue('P1', 'PARENT/GUARDIAN MIDDLENAME');
                            $sheet->setCellValue('Q1', 'PARENT/GUARDIAN LASTNAME');
                            $sheet->setCellValue('R1', 'PARENT/GUARDIAN ADDRESS');
                            $sheet->setCellValue('S1', 'PARENT/GUARDIAN CONTACT');
                            $sheet->setCellValue('T1', 'PARENT/GUARDIAN EMAIL');
                            $sheet->setCellValue('U1', 'PARENT/GUARDIAN OCCUPATION');
                            $sheet->setCellValue('V1', 'PARENT/GUARDIAN RELATIONSHIP');
                            $sheet->setCellValue('W1', 'PREVIOUS SCHOOL');
                            $sheet->setCellValue('X1', 'CLASS TO BE ENROLLED');
                            $sheet->setCellValue('Y1', 'ALLERGY');
                            $sheet->setCellValue('Z1', 'CONDITION');
                            $sheet->setCellValue('AA1', 'MEDICATIONS');
        
                            $directoryPath = 'C:/ACADEMIX/' . $school . '/generated_reports/student/';
                            $filePath = $directoryPath . 'Byclass_students.xlsx';
                            if (!is_dir($directoryPath)) {
                                if (!mkdir($directoryPath, 0777, true)) {
                                    die('Failed to create directories.');
                                }
                            }
                           
                            $row = 2;
                            while ($row_data = oci_fetch_assoc($statement)) {
                                $sheet->setCellValue('A' . $row, $row_data['STUD_ID']);
                                $sheet->setCellValue('B' . $row, $row_data['CREATE_DT']);
                                $sheet->setCellValue('C' . $row, $row_data['STATUS']);
                                $sheet->setCellValue('D' . $row, $row_data['FIRSTNAME']);
                                $sheet->setCellValue('E' . $row, $row_data['MIDDLENAME']);
                                $sheet->setCellValue('F' . $row, $row_data['LASTNAME']);
                                $sheet->setCellValue('G' . $row, $row_data['DOB']);
                                $sheet->setCellValue('H' . $row, $row_data['GENDER']);
                                $sheet->setCellValue('I' . $row, $row_data['NATION']);
                                $sheet->setCellValue('J' . $row, $row_data['TRIBE']);
                                $sheet->setCellValue('K' . $row, $row_data['HOME_ADD']);
                                $sheet->setCellValue('L' . $row, $row_data['EMAIL']);
                                $sheet->setCellValue('M' . $row, $row_data['PHONE']);
                                $sheet->setCellValue('N' . $row, $row_data['EMERGENCY']);
                                $sheet->setCellValue('O' . $row, $row_data['PG_FIRST']);
                                $sheet->setCellValue('P' . $row, $row_data['PG_MIDDLE']);
                                $sheet->setCellValue('Q' . $row, $row_data['PG_LAST']);
                                $sheet->setCellValue('R' . $row, $row_data['PG_ADD']);
                                $sheet->setCellValue('S' . $row, $row_data['PG_PHONE']);
                                $sheet->setCellValue('T' . $row, $row_data['PG_EMAIL']);
                                $sheet->setCellValue('U' . $row, $row_data['OCCUPATION']);
                                $sheet->setCellValue('V' . $row, $row_data['RELATION']);
                                $sheet->setCellValue('W' . $row, $row_data['PREV_SCHOOL']);
                                $sheet->setCellValue('X' . $row, $row_data['CLASS_TITLE']);
                                $sheet->setCellValue('Y' . $row, $row_data['ALLERGY']);
                                $sheet->setCellValue('Z' . $row, $row_data['CONDITION']);
                                $sheet->setCellValue('AA' . $row, $row_data['MEDICATIONS']);
        
                                $row++;
                            }
                            $writer = new Xlsx($spreadsheet);
                            // Output the Excel file
                            $writer->save($filePath)
                                ?><div style="font-size:15px;
                            color: green;
                            position: relative;
                             display:flex;
                            animation:button .3s linear;text-align: center;">
                        <?php echo "FILE GENERATED TO $filePath";
                        
                            header("refresh:2;"); 
                                  ?>
                    </div> <?php
                            // Close the Oracle connection
                            oci_free_statement($statement);
                            oci_close($conn); */
                    } else {
                        $query = "select a.stud_id,a.create_dt,a.status,b.firstname,b.middlename,b.lastname,b.dob,b.gender,b.nation,b.tribe,c.home_add,c.email,c.phone,c.emergency,d.firstname as pg_first,d.middlename as pg_middle,d.lastname as pg_last,d.address as pg_add,d.phone as pg_phone,d.email as pg_email,d.occupation,d.relation , e.prev_school,f.class_title,g.allergy,g.condition,g.medications from 
                    student a join student_personal b on (a.stud_id=b.stud_id) join student_contact c on (a.stud_id=c.stud_id) join student_authourity d on (a.stud_id=d.stud_id) join student_academic e on (a.stud_id=e.stud_id) join class f on (e.class=f.class) join student_medical g on (a.stud_id=g.stud_id)";
                        // Prepare and execute the query
                        $statement = oci_parse($conn, $query);
                        oci_execute($statement);
                        $spreadsheet = new Spreadsheet();
                        $sheet = $spreadsheet->getActiveSheet();
                        $sheet->setCellValue('A1', 'STUDENT ID');
                        $sheet->setCellValue('B1', 'REGISTRATION DATE');
                        $sheet->setCellValue('C1', 'STUDENT STATUS');
                        $sheet->setCellValue('D1', 'FIRSTNAME');
                        $sheet->setCellValue('E1', 'MIDDLENAME');
                        $sheet->setCellValue('F1', 'LASTNAME');
                        $sheet->setCellValue('G1', 'DATE OF BIRTH');
                        $sheet->setCellValue('H1', 'GENDER');
                        $sheet->setCellValue('I1', 'NATIONALITY');
                        $sheet->setCellValue('J1', 'TRIBE');
                        $sheet->setCellValue('K1', 'HOME ADDRESS');
                        $sheet->setCellValue('L1', 'EMAIL');
                        $sheet->setCellValue('M1', 'PHONE');
                        $sheet->setCellValue('N1', 'EMERGENCY CONTACT');
                        $sheet->setCellValue('O1', 'PARENT/GUARDIAN FIRSTNAME');
                        $sheet->setCellValue('P1', 'PARENT/GUARDIAN MIDDLENAME');
                        $sheet->setCellValue('Q1', 'PARENT/GUARDIAN LASTNAME');
                        $sheet->setCellValue('R1', 'PARENT/GUARDIAN ADDRESS');
                        $sheet->setCellValue('S1', 'PARENT/GUARDIAN CONTACT');
                        $sheet->setCellValue('T1', 'PARENT/GUARDIAN EMAIL');
                        $sheet->setCellValue('U1', 'PARENT/GUARDIAN OCCUPATION');
                        $sheet->setCellValue('V1', 'PARENT/GUARDIAN RELATIONSHIP');
                        $sheet->setCellValue('W1', 'PREVIOUS SCHOOL');
                        $sheet->setCellValue('X1', 'CLASS TO BE ENROLLED');
                        $sheet->setCellValue('Y1', 'ALLERGY');
                        $sheet->setCellValue('Z1', 'CONDITION');
                        $sheet->setCellValue('AA1', 'MEDICATIONS');

                        $directoryPath = 'C:/ACADEMIX/' . $school . '/generated_reports/student/';
                        $filePath = $directoryPath . 'all_students.xlsx';
                        if (!is_dir($directoryPath)) {
                            if (!mkdir($directoryPath, 0777, true)) {
                                die('Failed to create directories.');
                            }
                        }

                        $row = 2;
                        while ($row_data = oci_fetch_assoc($statement)) {
                            $sheet->setCellValue('A' . $row, $row_data['STUD_ID']);
                            $sheet->setCellValue('B' . $row, $row_data['CREATE_DT']);
                            $sheet->setCellValue('C' . $row, $row_data['STATUS']);
                            $sheet->setCellValue('D' . $row, $row_data['FIRSTNAME']);
                            $sheet->setCellValue('E' . $row, $row_data['MIDDLENAME']);
                            $sheet->setCellValue('F' . $row, $row_data['LASTNAME']);
                            $sheet->setCellValue('G' . $row, $row_data['DOB']);
                            $sheet->setCellValue('H' . $row, $row_data['GENDER']);
                            $sheet->setCellValue('I' . $row, $row_data['NATION']);
                            $sheet->setCellValue('J' . $row, $row_data['TRIBE']);
                            $sheet->setCellValue('K' . $row, $row_data['HOME_ADD']);
                            $sheet->setCellValue('L' . $row, $row_data['EMAIL']);
                            $sheet->setCellValue('M' . $row, $row_data['PHONE']);
                            $sheet->setCellValue('N' . $row, $row_data['EMERGENCY']);
                            $sheet->setCellValue('O' . $row, $row_data['PG_FIRST']);
                            $sheet->setCellValue('P' . $row, $row_data['PG_MIDDLE']);
                            $sheet->setCellValue('Q' . $row, $row_data['PG_LAST']);
                            $sheet->setCellValue('R' . $row, $row_data['PG_ADD']);
                            $sheet->setCellValue('S' . $row, $row_data['PG_PHONE']);
                            $sheet->setCellValue('T' . $row, $row_data['PG_EMAIL']);
                            $sheet->setCellValue('U' . $row, $row_data['OCCUPATION']);
                            $sheet->setCellValue('V' . $row, $row_data['RELATION']);
                            $sheet->setCellValue('W' . $row, $row_data['PREV_SCHOOL']);
                            $sheet->setCellValue('X' . $row, $row_data['CLASS_TITLE']);
                            $sheet->setCellValue('Y' . $row, $row_data['ALLERGY']);
                            $sheet->setCellValue('Z' . $row, $row_data['CONDITION']);
                            $sheet->setCellValue('AA' . $row, $row_data['MEDICATIONS']);

                            $row++;
                        }
                        $writer = new Xlsx($spreadsheet);
                        // Output the Excel file
                        $writer->save($filePath);
                        // ... your existing code to generate the Excel file ...

                        // Check if the file was successfully generated
                        if (file_exists($filePath)) {
                            // Construct the URL to the file
                            $fileUrl = 'http://' . $_SERVER['HTTP_HOST'] . '/' . $directoryPath . 'all_students.xlsx';
                            // Replace with the actual URL

                            // Redirect the user to the file URL
                            header('Location: ' . $fileUrl);
                            exit; // Terminate the script
                        } else {
                            echo "File not found or could not be generated.";
                        }

                        ?><div style="font-size:15px;
                        color: green;
                        position: relative;
                         display:flex;
                        animation:button .3s linear;text-align: center;">
                    <?php echo "FILE GENERATED TO $filePath";
                        // ... your existing code to generate the Excel file ...



                        header("refresh:2;");
                    ?>
                </div> <?php
                        // Close the Oracle connection
                        oci_free_statement($statement);
                        oci_close($conn);
                    }
                }
                        ?>
        <div class="buttons">

            <button class="backBtn" type="submit">

                <a class="btnText" href="Active_By_class.php">
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

</html>