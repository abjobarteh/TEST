<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/show_users.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
</head>
<?php
include 'connect.php';
ob_start();
session_start();
$school =  $_SESSION['school'];
$sid = $_SESSION['sid'];
$emp_id = $_SESSION['emp_id'];
$s_code = $_SESSION['s_code'];
$sub_code = $_SESSION['sub_code'];
$class_name =  $_SESSION['class_name'];
$subject = $_SESSION['subject'];
$student = " ";
?>
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
    <form class="container" enctype="multipart/form-data" action="grade_settings.php" method="post">
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
        <header>Grade Settings</header>
        <?php

        $sql = "select * from grade a join grade_setting b  on (a.g_code=b.g_code) where b.s_id = $sid order by b.start_grade_range desc ";

        $stidd = oci_parse($conn, $sql);
        oci_execute($stidd);

        ?>
        <div style="overflow-x: auto;">
            <table class="table-content" style="font-size: 14px; border-collapse: collapse; margin: 10px 0; font: 0.9em; min-width: 400px; border-radius: 5px 5px; overflow: hidden; box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);">
                <thead>
                    <tr style="background-color: #1D5B79; color: #ffffff; text-align: left; font-weight: bold;">
                        <th style="padding: 5px 8px; font-size: 10px; margin: 5px;">Grade</th>
                        <th style="padding: 5px 8px; font-size: 10px; margin: 5px;">Start Grade Range</th>
                        <th style="padding: 5px 8px; font-size: 10px; margin: 5px;">End Grade Range</th>
                    </tr>
                </thead>
            </table>
        </div>

        <div style="max-height: 200px; overflow-y: auto;">
            <table class="table-content" style="font-size: 14px; border-collapse: collapse; margin: 10px 0; font: 0.9em; min-width: 400px; border-radius: 5px 5px; overflow: hidden; box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);">
                <tbody>
                    <?php
                    while ($row = oci_fetch_array($stidd)) {
                    ?>
                        <tr style="border-bottom: 1px solid #dddddd;">
                            <td style="padding: 5px 8px; font-size: 10px; margin: 5px;"><?php echo $row['GRADE']; ?></td>
                            <td style="padding: 5px 8px; font-size: 10px; margin: 5px;"><?php echo $row['START_GRADE_RANGE']; ?></td>
                            <td style="padding: 5px 8px; font-size: 10px; margin: 5px;"><?php echo $row['END_GRADE_RANGE']; ?></td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>


        <?php
        $sql = "select * from grade a join gpa c on (a.g_code=c.g_code) where a.s_id = $sid  order by c.gpa desc";
        $stid = oci_parse($conn, $sql);
        oci_execute($stid);
        ?>
        <table class="table-content" style="font-size: 14px; border-collapse: collapse; margin: 10px 0; font: 0.9em; min-width: 400px; border-radius: 5px 5px; overflow: hidden; box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);">
            <thead>
                <tr style="background-color: #1D5B79; color: #ffffff; text-align: left; font-weight: bold;">
                    <th style="padding: 5px 8px; font-size: 10px; margin: 5px;">Grade</th>
                    <th style="padding: 5px 8px; font-size: 10px; margin: 5px;">Grade Point Average</th>
                </tr>
            </thead>
        </table>

        <div style="max-height: 200px; overflow-y: auto;">
            <table class="table-content" style="font-size: 14px; border-collapse: collapse; margin: 10px 0; font: 0.9em; min-width: 400px; border-radius: 5px 5px; overflow: hidden; box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);">
                <tbody>
                    <?php
                    while ($rows = oci_fetch_array($stid)) {
                    ?>
                        <tr style="border-bottom: 1px solid #dddddd;">
                            <td style="padding: 5px 8px; font-size: 10px; margin: 5px;"><?php echo $rows['GRADE']; ?></td>
                            <td style="padding: 5px 8px; font-size: 10px; margin: 5px;"><?php echo $rows['GPA']; ?></td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <?php
        $sql = "select * from waec_subject a join subject_credit_hrs b on (a.sub_code=b.sub_code) where b.s_id = $sid order by b.CREDIT_HRS desc,a.subject";
        $stid = oci_parse($conn, $sql);
        oci_execute($stid);
        ?>
       <table class="table-content" style="font-size: 14px; border-collapse: collapse; margin: 10px 0; font: 0.9em; min-width: 400px; border-radius: 5px 5px; overflow: hidden; box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);">
    <thead>
        <tr style="background-color: #1D5B79; color: #ffffff; text-align: left; font-weight: bold;">
            <th style="padding: 5px 8px; font-size: 10px; margin: 5px;">Subject</th>
            <th style="padding: 5px 8px; font-size: 10px; margin: 5px;">Credit Hours</th>
        </tr>
    </thead>
</table>

<div style="max-height: 200px; overflow-y: auto;">
    <table class="table-content" style="font-size: 14px; border-collapse: collapse; margin: 0; font: 0.9em; min-width: 400px; border-radius: 0 0 5px 5px; overflow: hidden; box-shadow: none;">
        <tbody>
            <?php
            while ($rows = oci_fetch_array($stid)) {
            ?>
                <tr style="border-bottom: 1px solid #dddddd;">
                    <td style="padding: 5px 8px; font-size: 10px; margin: 5px;"><?php echo $rows['SUBJECT']; ?></td>
                    <td style="padding: 5px 8px; font-size: 10px; margin: 5px;"><?php echo $rows['CREDIT_HRS']; ?></td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>

        <?php
        $sql = oci_parse($conn, "select * from academic_calendar a join term_calendar b on (a.academic_year=b.academic_year) where a.status = 'ACCEPTED' AND b.status = 'ACCEPTED' ");
        oci_execute($sql);
        while ($row = oci_fetch_array($sql)) {
            $a_y = $row['ACADEMIC_YEAR'];
            $t = $row['TERM'];
        }
        if (isset($_POST['filter'])) {
            if (isset($_POST['reg'])) {
                $st =  $_POST['reg'];
                $_SESSION['STUD_ID'] = $st;
                $sql = oci_parse($conn, "select * from student where STUD_ID = '$st' ");
                oci_execute($sql);
                while ($row = oci_fetch_array($sql)) {
                    $student = $row['NAME'];
                    $_SESSION['name'] = $student;
                }
            } else {
        ?><div style="font-size:15px;
        color: green;
        position: relative;
         display:flex;
        animation:button .3s linear;text-align: center;">
                    <?php echo "SELECT STUDENT ID ";
                    header("refresh:2;"); ?>
                </div> <?php
                    }
                }

                        ?>
        <div>
            <Label style="font-size: 18px; font-family: sans-serif;
    font-weight: bold; color: #1D5B79;"></Label>
            <div class="input-container" style="display: flex;">

                <div class="input-field" style="margin-right: 10px;">
                    <label>Academic Year</label>
                    <input type="text" placeholder="<?php echo $a_y ?>" style="width:300px;" readonly>
                </div>
                <div class="input-field" style="margin-right: 10px;">
                    <label>Term</label>
                    <input type="text" placeholder="<?php echo $t ?>" style="width:300px;" readonly>
                </div>
            </div>

            <div class="input-container" style="display: flex;">

            </div>

            <Label style="font-size: 18px; font-family: sans-serif;
    font-weight: bold; color: #1D5B79;">Set Letter Grade</Label>
        </div>
        <div class="input-container" style="display: flex;">
            <div class="input-field" style="margin-right: 10px;">
                <label>Grade</label>

                <select required name="grade_letter">
                    <option disabled selected>Select Letter Grade</option>
                    <?php
                    $get_hos = "select * from grade where  s_id = $sid order by grade";
                    $get = oci_parse(oci_connect($username, $password, $connection), $get_hos);
                    oci_execute($get);
                    while ($row = oci_fetch_array($get)) {
                    ?><option>
                            <?php echo $row["GRADE"]; ?>
                        </option> <?php
                                }
                                    ?>
                </select>
                <label>Start Mark Range</label>
                <input type="number" placeholder="Enter Mark Range" title="Only Numbers" name="s_range" style="width:200px;" min=0.0 max=100 pattern="[0-9.]+" step="any">

                <label>End Mark Range</label>
                <input type="number" placeholder="Enter Mark Range" title="Only Numbers" name="e_range" style="width:200px;" min=0.0 max=100 pattern="[0-9.]+" step="any">
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
                SET GRADE
                <i class="uil uil-create-dashboard"></i>
            </button>
        </div>
        <?php
        if (isset($_POST['establish'])) {
            if (isset($_POST['grade_letter'])) {
                $g_l = $_POST['grade_letter'];
                $sql = oci_parse($conn, "select * from grade where grade = '$g_l' and s_id = $sid ");
                oci_execute($sql);
                while ($r = oci_fetch_array($sql)) {
                    $g_code = $r['G_CODE'];
                }
                $s_range = $_POST['s_range'];
                if ($s_range != '') {
                    $e_range = $_POST['e_range'];
                    if ($e_range != '') {
                        $sql = oci_parse($conn, "select * from grade_settings where g_code = $g_code ");
                        oci_execute($sql);
                        if (oci_fetch_all($sql, $a) == 0) {
                            $sql = oci_parse($conn, "INSERT INTO GRADE_SETTING (S_ID,START_GRADE_RANGE,END_GRADE_RANGE,G_CODE) VALUES ($sid,$s_range,$e_range,$g_code)");
                            if (oci_execute($sql)) {
        ?><div style="font-size:15px;
                                            color: green;
                                            position: relative;
                                             display:flex;
                                            animation:button .3s linear;text-align: center;">
                                    <?php echo "MARK RANGE FOR GRADE SET SUCCESSFULLY";
                                    header("refresh:2;"); ?>
                                </div> <?php
                                    } else {
                                        ?><div style="font-size:15px;
                                            color: red;
                                            position: relative;
                                             display:flex;
                                            animation:button .3s linear;text-align: center;">
                                    <?php echo "ERROR SETTING MARK RANGE";
                                        header("refresh:2;"); ?>
                                </div> <?php
                                    }
                                } else {
                                        ?><div style="font-size:15px;
                                        color: red;
                                        position: relative;
                                         display:flex;
                                        animation:button .3s linear;text-align: center;">
                                <?php echo "MARK RANGE ALREADY SET";
                                    header("refresh:2;"); ?>
                            </div> <?php
                                }
                            } else {
                                    ?><div style="font-size:15px;
                                    color: red;
                                    position: relative;
                                     display:flex;
                                    animation:button .3s linear;text-align: center;">
                            <?php echo "ENTER STARTING MARK RANGE";
                                header("refresh:2;"); ?>
                        </div> <?php
                            }
                        } else {
                                ?><div style="font-size:15px;
                                color: red;
                                position: relative;
                                 display:flex;
                                animation:button .3s linear;text-align: center;">
                        <?php echo "ENTER STARTING MARK RANGE";
                            header("refresh:2;"); ?>
                    </div> <?php
                        }
                    } else {
                            ?><div style="font-size:15px;
                            color: red;
                            position: relative;
                             display:flex;
                            animation:button .3s linear;text-align: center;">
                    <?php echo "SELECT GRADE LETTER";
                        header("refresh:2;"); ?>
                </div> <?php
                    }
                }
                        ?>
        <Label style="font-size: 18px; font-family: sans-serif;
    font-weight: bold; color: #1D5B79;">Edit Letter Grade</Label>
        </div>
        <div class="input-container" style="display: flex;">
            <div class="input-field" style="margin-right: 10px;">
                <label>Range</label>
                <select required name="edit_range">
                    <option disabled selected>Select Range To Edit</option>
                    <option>Start Mark Range</option>
                    <option>End Mark Range</option>
                </select>

                <label>Grade</label>
                <select required name="edit_grade_letter">
                    <option disabled selected>Select Letter Grade</option>
                    <?php
                    $get_hos = "select * from grade a join grade_setting b on (a.g_code = b.g_code) where  b.s_id = $sid order by grade";
                    $get = oci_parse(oci_connect($username, $password, $connection), $get_hos);
                    oci_execute($get);
                    while ($row = oci_fetch_array($get)) {
                    ?><option>
                            <?php echo $row["GRADE"]; ?>
                        </option> <?php
                                }
                                    ?>
                </select>
                <label>Start Mark Range</label>
                <input type="number" placeholder="Enter Mark Range" title="Only Numbers" name="edit_s_range" style="width:200px;" min=0 max=100 pattern="[0-9.]+" step="any">

                <label>End Mark Range</label>
                <input type="number" placeholder="Enter Mark Range" title="Only Numbers" name="edit_e_range" style="width:200px;" min=0 max=100 pattern="[0-9.]+" step="any">
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
  text-decoration: none;" name="edit_grade" type="submit">
                EDIT GRADE
                <i class="uil uil-edit"></i>
            </button>
        </div>
        <?php
        if (isset($_POST['edit_grade'])) {
            if (isset($_POST['edit_range'])) {
                $range_type = $_POST['edit_range'];
                if ($range_type == 'Start Mark Range') {
                    if (isset($_POST['edit_grade_letter'])) {
                        $letter = $_POST['edit_grade_letter'];
                        $sql = oci_parse($conn, "select * from grade where grade = '$letter' ");
                        oci_execute($sql);
                        while ($r = oci_fetch_array($sql, $a)) {
                            $g_code = $r['G_CODE'];
                        }
                        $range = $_POST['edit_s_range'];
                        if ($range != '') {

                            $sql = oci_parse($conn, "select * from grade_setting where g_code = $g_code and $range < end_grade_range");
                            oci_execute($sql);
                            if (oci_fetch_all($sql, $a) > 0) {
                                $sql = oci_parse($conn, "update grade_setting set start_grade_range = $range where g_code= $g_code");
                                if (oci_execute($sql)) {
        ?><div style="font-size:15px;
                        color: green;
                        position: relative;
                         display:flex;
                        animation:button .3s linear;text-align: center;">
                                        <?php echo "START GRADE RANGE SUCCESSFULLY UPDATED";
                                        header("refresh:2;"); ?>
                                    </div> <?php
                                        } else {
                                            ?><div style="font-size:15px;
                        color: red;
                        position: relative;
                         display:flex;
                        animation:button .3s linear;text-align: center;">
                                        <?php echo "ERROR UPDATING START GRADE RANGE";
                                            header("refresh:2;"); ?>
                                    </div> <?php
                                        }
                                    } else {
                                            ?><div style="font-size:15px;
                        color: red;
                        position: relative;
                         display:flex;
                        animation:button .3s linear;text-align: center;">
                                    <?php echo "START GRADE RANGE SHOULD NOT BE MORE END GRADE RANGE";
                                        header("refresh:2;"); ?>
                                </div> <?php
                                    }
                                } else {
                                        ?><div style="font-size:15px;
                    color: red;
                    position: relative;
                     display:flex;
                    animation:button .3s linear;text-align: center;">
                                <?php echo "ENTER START MARK RANGE";
                                    header("refresh:2;"); ?>
                            </div> <?php
                                }
                            } else {
                                    ?><div style="font-size:15px;
                color: red;
                position: relative;
                 display:flex;
                animation:button .3s linear;text-align: center;">
                            <?php echo "SELECT LETTER GRADE";
                                header("refresh:2;"); ?>
                        </div> <?php
                            }
                        } else if ($range_type == 'End Mark Range') {
                            if (isset($_POST['edit_grade_letter'])) {
                                $letter = $_POST['edit_grade_letter'];
                                $sql = oci_parse($conn, "select * from grade where grade = '$letter' ");
                                oci_execute($sql);
                                while ($r = oci_fetch_array($sql, $a)) {
                                    $g_code = $r['G_CODE'];
                                }
                                $range = $_POST['edit_e_range'];
                                $sql = oci_parse($conn, "select * from grade_setting where g_code = $g_code and $range > start_grade_range ");
                                oci_execute($sql);
                                if (oci_fetch_all($sql, $a) > 0) {
                                    $sql = oci_parse($conn, "update grade_setting set end_grade_range = $range where g_code= $g_code");
                                    if (oci_execute($sql)) {
                                ?><div style="font-size:15px;
                    color: green;
                    position: relative;
                     display:flex;
                    animation:button .3s linear;text-align: center;">
                                    <?php echo "START GRADE RANGE SUCCESSFULLY UPDATED";
                                        header("refresh:2;"); ?>
                                </div> <?php
                                    } else {
                                        ?><div style="font-size:15px;
                    color: red;
                    position: relative;
                     display:flex;
                    animation:button .3s linear;text-align: center;">
                                    <?php echo "ERROR UPDATING START GRADE RANGE";
                                        header("refresh:2;"); ?>
                                </div> <?php
                                    }
                                } else {
                                        ?><div style="font-size:15px;
                    color: red;
                    position: relative;
                     display:flex;
                    animation:button .3s linear;text-align: center;">
                                <?php echo "END GRADE RANGE SHOULD BE MORE THAN START GRADE RANGE";
                                    header("refresh:2;"); ?>
                            </div> <?php
                                }
                            } else {
                                    ?><div style="font-size:15px;
                color: red;
                position: relative;
                 display:flex;
                animation:button .3s linear;text-align: center;">
                            <?php echo "SELECT LETTER GRADE";
                                header("refresh:2;"); ?>
                        </div> <?php
                            }
                        }
                    } else {
                                ?><div style="font-size:15px;
    color: red;
    position: relative;
     display:flex;
    animation:button .3s linear;text-align: center;">
                    <?php echo "SELECT RANGE TO EDIT";
                        header("refresh:2;"); ?>
                </div> <?php
                    }
                }

                        ?>
        <Label style="font-size: 18px; font-family: sans-serif;
    font-weight: bold; color: #1D5B79;">Set Grade Point Average</Label>
        <div class="input-field" style="margin-right: 10px;">
            <label>Grade</label>
            <select required name="gpa_letter">
                <option disabled selected>Select Letter Grade</option>
                <?php
                $get_hos = "select * from grade a join gpa b on(a.g_code=b.g_code) where a.s_id = $sid order by b.g_code ";
                $get = oci_parse(oci_connect($username, $password, $connection), $get_hos);
                oci_execute($get);
                while ($row = oci_fetch_array($get)) {
                ?><option>
                        <?php echo $row["GRADE"]; ?>
                    </option> <?php
                            }
                                ?>
            </select>
            <label>Grade Point Average Equivalent</label>
            <input type="number" placeholder="Enter Grade Point Average Equivalent" title="Only Numbers" name="gpa" style="width:310px;" pattern="[0-9.]+" step="any">
            <div style="display: flex;">
                <button style=" display: inline-block;
  padding: 6px 12px;
  background-color: #1D5B79;
  color: white;
  border: none;
  border-radius: 4px;
  margin-top:10px;
  margin-bottom:10px;
  text-decoration: none;" name="set_gpa" type="submit">
                    SET GPA
                    <i class="uil uil-create-dashboard"></i>
                </button>
            </div>
        </div>
        <?php
        if (isset($_POST['set_gpa'])) {
            if (isset($_POST['gpa_letter'])) {
                $grade = $_POST['gpa_letter'];
                $sql = oci_parse($conn, "select * from grade where grade = '$grade' and s_id = $sid ");
                oci_execute($sql);
                while ($r = oci_fetch_array($sql)) {
                    $g_code = $r["G_CODE"];
                }
                if (isset($_POST['gpa'])) {
                    $gpa = $_POST['gpa'];
                    $sql = oci_parse($conn, "select * from GPA where g_code = $g_code and s_id = $sid ");
                    oci_execute($sql);
                    if (oci_fetch_all($sql, $a) == 0) {
                        $sql = oci_parse($conn, "INSERT INTO GPA (G_CODE,GPA) VALUES ($g_code,$gpa)");
                        if (oci_execute($sql)) {
        ?><div style="font-size:15px;
                            color: green;
                            position: relative;
                             display:flex;
                            animation:button .3s linear;text-align: center;">
                                <?php echo "GPA SCORE SET SUCCESSFULYY FOR GRADE ";
                                header("refresh:2;"); ?>
                            </div> <?php
                                } else {
                                    ?><div style="font-size:15px;
                            color: red;
                            position: relative;
                             display:flex;
                            animation:button .3s linear;text-align: center;">
                                <?php echo "ERROR SETTING GPA SCORE FOR GRADE ";
                                    header("refresh:2;"); ?>
                            </div> <?php
                                }
                            } else {
                                    ?><div style="font-size:15px;
                        color: red;
                        position: relative;
                         display:flex;
                        animation:button .3s linear;text-align: center;">
                            <?php echo "GPA SCORE FOR THIS GRADE HAS BEEN SET ALREADY";
                                header("refresh:2;"); ?>
                        </div> <?php
                            }
                        } else {
                                ?><div style="font-size:15px;
                        color: red;
                        position: relative;
                         display:flex;
                        animation:button .3s linear;text-align: center;">
                        <?php echo "ENTER GPA EQUIVALENT";
                            header("refresh:2;"); ?>
                    </div> <?php
                        }
                    } else {
                            ?><div style="font-size:15px;
                    color: red;
                    position: relative;
                     display:flex;
                    animation:button .3s linear;text-align: center;">
                    <?php echo "SELECT LETTER GRADE";
                        header("refresh:2;"); ?>
                </div> <?php
                    }
                }
                        ?>
        <Label style="font-size: 18px; font-family: sans-serif;
    font-weight: bold; color: #1D5B79;">Edit Grade Point Average</Label>
        <div class="input-field" style="margin-right: 10px;">
            <label>Grade</label>
            <select required name="edit_gpa_letter">
                <option disabled selected>Select Letter Grade</option>
                <?php
                $get_hos = "select * from grade a join grade_setting b on (a.g_code = b.g_code) where  b.s_id = $sid order by grade";
                $get = oci_parse(oci_connect($username, $password, $connection), $get_hos);
                oci_execute($get);
                while ($row = oci_fetch_array($get)) {
                ?><option>
                        <?php echo $row["GRADE"]; ?>
                    </option> <?php
                            }
                                ?>
            </select>
            <label>Grade Point Average Equivalent</label>
            <input type="number" placeholder="Enter Grade Point Average Equivalent" title="Only Numbers" name="edit_gpa_equ" style="width:310px;" pattern="[0-9.]+" step="any">
            <div style="display: flex;">
                <button style=" display: inline-block;
  padding: 6px 12px;
  background-color: #1D5B79;
  color: white;
  border: none;
  border-radius: 4px;
  margin-top:10px;
  margin-bottom:10px;
  text-decoration: none;" name="edit_gpa" type="submit">
                    EDIT GPA
                    <i class="uil uil-edit"></i>
                </button>
            </div>
        </div>
        <?php
        if (isset($_POST["edit_gpa"])) {
            if (isset($_POST["edit_gpa_letter"])) {

                $grade = $_POST['edit_gpa_letter'];
                $sql = oci_parse($conn, "select * from grade where grade = '$grade' and s_id = $sid ");
                oci_execute($sql);
                while ($r = oci_fetch_array($sql)) {
                    $g_code = $r["G_CODE"];
                }
                $gpa = $_POST["edit_gpa_equ"];
                if ($gpa != '') {
                    $sql = oci_parse($conn, "update gpa set gpa = $gpa where g_code = $g_code  ");
                    if (oci_execute($sql)) {
        ?><div style="font-size:15px;
                    color: green;
                    position: relative;
                     display:flex;
                    animation:button .3s linear;text-align: center;">
                            <?php echo "GRADE POINT EQUIVALENT UPDATED SUCCESSFULLY";
                            header("refresh:2;"); ?>
                        </div> <?php
                            } else {
                                ?><div style="font-size:15px;
                    color: red;
                    position: relative;
                     display:flex;
                    animation:button .3s linear;text-align: center;">
                            <?php echo "ERROR UPDATING GRADE POINT EQUIVALENT";
                                header("refresh:2;"); ?>
                        </div> <?php
                            }
                        } else {
                                ?><div style="font-size:15px;
                    color: red;
                    position: relative;
                     display:flex;
                    animation:button .3s linear;text-align: center;">
                        <?php echo "ENTER GRADE POINT EQUIVALENT";
                            header("refresh:2;"); ?>
                    </div> <?php
                        }
                    } else {
                            ?><div style="font-size:15px;
                color: red;
                position: relative;
                 display:flex;
                animation:button .3s linear;text-align: center;">
                    <?php echo "SELECT LETTER GRADE";
                        header("refresh:2;"); ?>
                </div> <?php
                    }
                }
                        ?>
        <Label style="font-size: 18px; font-family: sans-serif;
    font-weight: bold; color: #1D5B79;">Set Subject Credit Hours</Label>
        <div class="input-field" style="margin-right: 10px;">
            <label>Subject</label>
            <select required name="subject_crdt">
                <option disabled selected>Select Subject</option>
                <?php
                $get_hos = "select DISTINCT(SUBJECT) from waec_subject WHERE EXAM = 'WASSCE' ORDER BY SUBJECT";
                $get = oci_parse(oci_connect($username, $password, $connection), $get_hos);
                oci_execute($get);
                while ($row = oci_fetch_array($get)) {
                ?><option>
                        <?php echo $row["SUBJECT"]; ?>
                    </option> <?php
                            }
                                ?>
            </select>
            <label>Credit Hours</label>
            <input type="number" placeholder="Enter Credit Hours" title="Only Numbers" name="hours" style="width:310px;" pattern="[0-9]+" step="any">
            <div style="display: flex;">
                <button style=" display: inline-block;
  padding: 6px 12px;
  background-color: #1D5B79;
  color: white;
  border: none;
  border-radius: 4px;
  margin-top:10px;
  margin-bottom:10px;
  text-decoration: none;" name="set_credit" type="submit">
                    SET CREDIT HOURS
                    <i class="uil uil-edit"></i>
                </button>
            </div>
        </div>
        <?php
        if (isset($_POST['set_credit'])) {
            if (isset($_POST['subject_crdt'])) {
                $subject = $_POST['subject_crdt'];
                $sql = oci_parse($conn, "select * from waec_subject where subject = '$subject' ");
                oci_execute($sql);
                while ($r = oci_fetch_array($sql)) {
                    $sub_code = $r['SUB_CODE'];
                }
                $hrs = $_POST['hours'];
                if ($hrs != '') {
                    $sql = oci_parse($conn, "select * from SUBJECT_CREDIT_HRS where sub_code = $sub_code and s_id = $sid ");
                    oci_execute($sql);
                    if (oci_fetch_all($sql, $a) == 0) {
                        $sql = oci_parse($conn, "INSERT INTO SUBJECT_CREDIT_HRS (S_ID,SUB_CODE,CREDIT_HRS) VALUES ($sid,$sub_code,$hrs)");
                        if (oci_execute($sql)) {
        ?><div style="font-size:15px;
                            color: green;
                            position: relative;
                             display:flex;
                            animation:button .3s linear;text-align: center;">
                                <?php echo "CREDIT HOURS HAS BEEN SET SUCCESSFULLY";
                                header("refresh:2;"); ?>
                            </div> <?php
                                } else {
                                    ?><div style="font-size:15px;
                            color: red;
                            position: relative;
                             display:flex;
                            animation:button .3s linear;text-align: center;">
                                <?php echo "ERROR SETTING CREDIT HOURS";
                                    header("refresh:2;"); ?>
                            </div> <?php
                                }
                            } else {
                                    ?><div style="font-size:15px;
                        color: red;
                        position: relative;
                         display:flex;
                        animation:button .3s linear;text-align: center;">
                            <?php echo "CREDIT HOURS ALREADY SET";
                                header("refresh:2;"); ?>
                        </div> <?php
                            }
                        } else {
                                ?><div style="font-size:15px;
                    color: red;
                    position: relative;
                     display:flex;
                    animation:button .3s linear;text-align: center;">
                        <?php echo "ENTER SUBJECT CREDIT HOURS";
                            header("refresh:2;"); ?>
                    </div> <?php
                        }
                    } else {
                            ?><div style="font-size:15px;
                color: red;
                position: relative;
                 display:flex;
                animation:button .3s linear;text-align: center;">
                    <?php echo "SELECT SUBJECT 1";
                        header("refresh:2;"); ?>
                </div> <?php
                    }
                }
                        ?>
        <Label style="font-size: 18px; font-family: sans-serif;
    font-weight: bold; color: #1D5B79;">Edit Subject Credit Hours</Label>
        <div class="input-field" style="margin-right: 10px;">
            <label>Subject</label>
            <select required name="edit_subject_crdt">
                <option disabled selected>Select Subject</option>
                <?php
                $get_hos = "select DISTINCT(a.SUBJECT) from waec_subject a join SUBJECT_CREDIT_HRS b on (a.sub_code=b.sub_code) where b.s_id = $sid ";
                $get = oci_parse(oci_connect($username, $password, $connection), $get_hos);
                oci_execute($get);
                while ($row = oci_fetch_array($get)) {
                ?><option>
                        <?php echo $row["SUBJECT"]; ?>
                    </option> <?php
                            }
                                ?>
            </select>
            <label>Credit Hours</label>
            <input type="number" placeholder="Enter Credit Hours" title="Only Numbers" name="edit_hours" style="width:310px;" pattern="[0-9]+" step="any">
            <div style="display: flex;">
                <button style=" display: inline-block;
  padding: 6px 12px;
  background-color: #1D5B79;
  color: white;
  border: none;
  border-radius: 4px;
  margin-top:10px;
  margin-bottom:10px;
  text-decoration: none;" name="edit_credit" type="submit">
                    EDIT CREDIT HOURS
                    <i class="uil uil-hourglass"></i>
                </button>
            </div>
        </div>
        <?php
        if (isset($_POST["edit_credit"])) {
            if (isset($_POST["edit_subject_crdt"])) {
                $subject = $_POST['edit_subject_crdt'];
                $sql = oci_parse($conn, "select * from waec_subject a join subject_credit_hrs b on (a.sub_code=b.sub_code) where a.subject = '$subject' and b.s_id = $sid  ");
                oci_execute($sql);
                while ($r = oci_fetch_array($sql)) {
                    $sub_code = $r['SUB_CODE'];
                }
                $hrs = $_POST['edit_hours'];
                if ($hrs != '') {
                    // echo "update subject_credit_hrs set credit_hrs = $hrs where sub_code = $sub_code and s_id = $sid ";
                    $sql = oci_parse($conn, "update subject_credit_hrs set credit_hrs = $hrs where sub_code = $sub_code and s_id = $sid ");
                    if (oci_execute($sql)) {
        ?><div style="font-size:15px;
                    color: green;
                    position: relative;
                     display:flex;
                    animation:button .3s linear;text-align: center;">
                            <?php echo "CREDIT HOURS UPDATED SUCCESSFULLY";
                            header("refresh:2;"); ?>
                        </div> <?php
                            } else {
                                ?><div style="font-size:15px;
                    color: red;
                    position: relative;
                     display:flex;
                    animation:button .3s linear;text-align: center;">
                            <?php echo "ERROR UPDATING CREDIT HOURS ";
                                header("refresh:2;"); ?>
                        </div> <?php
                            }
                        } else {
                                ?><div style="font-size:15px;
                    color: red;
                    position: relative;
                     display:flex;
                    animation:button .3s linear;text-align: center;">
                        <?php echo "ENTER SUBJECT CREDIT HOURS";
                            header("refresh:2;"); ?>
                    </div> <?php
                        }
                    } else {
                            ?><div style="font-size:15px;
                color: red;
                position: relative;
                 display:flex;
                animation:button .3s linear;text-align: center;">
                    <?php echo "SELECT SUBJECT";
                        header("refresh:2;"); ?>
                </div> <?php
                    }
                }
                        ?>
        <?php
        require '../vendor/autoload.php';

        use PhpOffice\PhpSpreadsheet\Spreadsheet;
        use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

        if (isset($_POST['generate'])) {
            $query = "select * from class a join sub_class b on (a.class=b.class) where b.s_id = $sid ";
            // Prepare and execute the query
            $statement = oci_parse($conn, $query);
            oci_execute($statement);
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setCellValue('A1', 'CLASS');
            $sheet->setCellValue('B1', 'CLASS NAME');

            $directoryPath = 'C:\ACADEMIX\\' . $school . '\generated_reports\class\\';
            if (!is_dir($directoryPath)) {
                if (!mkdir($directoryPath, 0777, true)) {
                    die('Failed to create directories.');
                }
            }
            $filePath = $directoryPath . 'class.xlsx';
            $row = 2;
            while ($row_data = oci_fetch_assoc($statement)) {
                $sheet->setCellValue('A' . $row, $row_data['CLASS_TITLE']);
                $sheet->setCellValue('B' . $row, $row_data['CLASS_NAME']);
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
                header("refresh:2;"); ?>
            </div> <?php
                    // Close the Oracle connection
                    oci_free_statement($statement);
                    oci_close($conn);
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