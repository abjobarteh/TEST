<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/shows.css">
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
    <form class="container" enctype="multipart/form-data" action="search.php" method="post" style="width: 1900px;">
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

                <a class="btnText" href="registra.php" style="font-size: 15px;">
                    HOME
                    <i class="uil uil-estate" style="width: 50px;"></i>
                </a>

            </button>
        </div>
        <header>Search Student</header>
        
        <?php
        include 'connect.php';
        $region = " ";
        $stuid = 'stuid';
        $search = 'search student';
        ?>
        <div class="input-field">
        <input type="text" name="bar" placeholder="Search Student ">  
        <button style=" display: inline-block;
  padding: 6px 12px;
  background-color: #04716f;
  color: white;
  border: none;
  border-radius: 4px;
  text-decoration: none;" name="search" type="submit">
                SEARCH
                <i class="uil uil-search"></i>
            </button>
             
            <?php
            if (isset($_POST['search'])) {
                $search= $_POST['bar'];
                if($search != ''){
                    $search= $_POST['bar'];
                }else {
                    ?><div style="font-size:15px;
                color: red;
                position: relative;
                 display:flex;
                 margin-left:10px;
                animation:button .3s linear;text-align: center;">
                    <?php echo "ENTER STUDENT NAME TO SEARCH";
                    header("refresh:2;");
                    ?></div><?php
                }
            }

            ?>
        </div>
        <div class="input-field">
          
            <select required name="reg">
                <option disabled selected>Select Student ID</option>

                <?php

                $get_hos = "select * from student a join student_academic b on (a.stud_id=b.stud_id) join class_student c on (a.stud_id=c.stud_id) where a.s_id = $sid and a.name like '%$search%' ORDER BY NAME";

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
            $getsub = "select * from subject  where subs = $sub_cd and s_id = $sid  ";
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
                    $check = oci_parse($conn, "select * from student_subject where sub_code = $subs_code and stud_id '$stuid' ");
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
                    <?php echo "SUBJECT ASSIGNED";
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

</html>