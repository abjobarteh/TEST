<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/show.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a81368914c.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" type="text/css" href="https://common.olemiss.edu/_js/sweet-alert/sweet-alert.css" />
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
$subject = $_SESSION['subject']; ?>
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
    <form class="container" enctype="multipart/form-data" action="verify_grade.php" method="post" style="width: 1500px;">
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
        <header>Verify Student Mark</header>
        <?php
        include 'connect.php';
        ?>
        <?php

        $sql = oci_parse($conn, "select * from employee where emp_id = '$emp_id' ");
        oci_execute($sql);
        if ($rowS = oci_fetch_array($sql)) {
            $name = $rowS["NAME"];
        }
        $sql = oci_parse($conn, "SELECT * FROM SUB_CLASS WHERE SUB_CODE =  $s_code ");
        oci_execute($sql);
        if ($rowS = oci_fetch_array($sql)) {
            $s_code = $rowS["SUB_CODE"];
            $class_name = $rowS["CLASS_NAME"];
        }

        $sql = oci_parse($conn, "select * from waec_subject where sub_code = $sub_code ");
        oci_execute($sql);
        if ($rowS = oci_fetch_array($sql)) {
            $subj = $rowS["SUBJECT"];
        }
        ?>
        <div class="input-field">
            <?php



            $sql = oci_parse($conn, "select * from academic_calendar a join term_calendar b on (a.academic_year=b.academic_year) where b.start_dt is not null");
            oci_execute($sql);
            if ($row = oci_fetch_array($sql)) {
                $a_y = $row['ACADEMIC_YEAR'];
                $t = $row['TERM'];
            }
            ?>
        </div>

        <div class="input-container" style="display: flex;">
            <div class="input-field" style="margin-right: 10px;">
                <label>Academic Year</label>
                <input type="text" placeholder="<?php echo $a_y ?>" style="width:300px;" readonly>
            </div>
            <div class="input-field" style="margin-right: 10px;">
                <label>Term</label>
                <input type="text" placeholder="<?php echo $t ?>" style="width:300px;" readonly>
            </div>
            <div class="input-field" style="margin-right: 10px;">
             
            </div>
        </div>

        <div class="input-container" style="display: flex;">
            <div class="input-field" style="margin-right: 10px;">
            <label>Grade</label>
                <input type="text" placeholder="<?php echo $class_name ?>" style="width:300px;" readonly>
                <label>Subject</label>
                <input type="text" placeholder="<?php echo  $subj ?>" style="width:300px;" readonly>
            </div>
        </div>
        </div>
        <div>
        </div>
        <?php
        include 'connect.php';

        $sql = "SELECT * FROM STUDENT A JOIN STUDENT_EVALUATION B ON (A.STUD_ID=B.STUD_ID) WHERE B.S_ID = $sid AND MARK_STATUS = 'PENDING' and B.CLASS_CODE = $s_code AND B.SUB_CODE = $sub_code AND B.EMP_ID = '$emp_id' ORDER BY A.NAME ";
        // echo $sql ;
        $stid = oci_parse($conn, $sql);
        oci_execute($stid);
        ?>
        <div style="display:flex; margin-top:20px;">
            <Label style="font-size: 18px; font-family: righteous;
         font-weight: bold; color: #04716f;">Student Marks</Label>
        </div>
        <div style="max-height: 200px; overflow-y: auto;">
            <table class="table-content" style="font-size: 14px; border-collapse: collapse; margin: 10px 0; font: 0.9em; min-width: 400px; border-radius: 5px 5px; overflow: hidden; box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);">
                <thead>
                    <tr style="background-color: #04716f; color: #ffffff; text-align: left; font-weight: bold;">
                        <th style="padding: 5px 8px; font-size: 10px; margin: 5px;">Student</th>
                        <th style="padding: 5px 8px; font-size: 10px; margin: 5px;">Name</th>
                        <th style="padding: 5px 8px; font-size: 10px; margin: 5px;">Continuous Assessment</th>
                        <th style="padding: 5px 8px; font-size: 10px; margin: 5px;">EXAM</th>
                        <th style="padding: 5px 8px; font-size: 10px; margin: 5px;">Registration Date</th>
                        <th style="padding: 5px 8px; font-size: 10px; margin: 5px;">SELECT STUDENT</th>
                    </tr>
                </thead>
            </table>
        </div>

        <div style="max-height: 200px; overflow-y: auto;">
            <table class="table-content" style="font-size: 14px; border-collapse: collapse; margin: 10px 0; font: 0.9em; min-width: 400px; border-radius: 5px 5px; overflow: hidden; box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);">
                <tbody>
                    <?php
                    while ($row = oci_fetch_array($stid)) {
                    ?>
                        <tr style="border-bottom: 1px solid #dddddd;">
                            <td><?php echo $row['STUD_ID']; ?></td>
                            <td><?php echo $row['NAME']; ?></td>
                            <td><?php echo $row['CONST_ASS']; ?></td>
                            <td><?php echo $row['EXAM']; ?></td>
                            <td><?php echo $row['ENTRY_DT']; ?></td>
                            <td><input type="checkbox" name="enroll[]" value="<?php echo $row['STUD_ID']; ?>"></td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>


        <div style="display: flex;">
            <button style=" display: inline-block;
  padding: 6px 12px;
  background-color: #04716f;
  color: white;
  border: none;
  border-radius: 4px;
  margin-top:10px;
  margin-right: 10px;
  margin-bottom:10px;
  text-decoration: none;" name="accept" type="submit">
                ACCEPT
                <i class="uil uil-check-circle"></i>
            </button>
            <button style=" display: inline-block;
  padding: 6px 12px;
  background-color: #04716f;
  color: white;
  border: none;
  border-radius: 4px;
  margin-top:10px;
  margin-right: 10px;
  margin-bottom:10px;
  text-decoration: none;" name="reject" type="submit">
                REJECT
                <i class="uil uil-multiply"></i>
            </button>
        </div>
        <?php

        require('tcpdf/tcpdf.php');
        require '../vendor/autoload.php';

        use PhpOffice\PhpSpreadsheet\Spreadsheet;
        use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

        if (isset($_POST['accept'])) {
            if (isset($_POST['enroll']) && !empty($_POST['enroll'])) {
                $selectedStudentIds = $_POST['enroll'];
                foreach ($selectedStudentIds as $studentId) {
                    $sql = oci_parse($conn, "UPDATE STUDENT_EVALUATION SET MARK_STATUS = 'ACCEPTED' WHERE S_ID = $sid AND MARK_STATUS = 'PENDING' and CLASS_CODE = $s_code AND SUB_CODE = $sub_code AND EMP_ID = '$emp_id' AND STUD_ID = '$studentId' ");

                    if (oci_execute($sql)) {
                        $stud_id = $studentId;
                        // Fetch total marks for the student
                        $gettotal = "SELECT * FROM STUDENT A JOIN STUDENT_EVALUATION B ON (A.STUD_ID=B.STUD_ID) WHERE B.S_ID = $sid AND MARK_STATUS = 'ACCEPTED' and B.CLASS_CODE = $s_code AND B.SUB_CODE = $sub_code AND B.EMP_ID = '$emp_id' AND B.STUD_ID = '$stud_id'";
                        $s = oci_parse($conn, $gettotal);
                        oci_execute($s);

                        while ($a = oci_fetch_array($s)) {
                            $total = $a["CONST_ASS"] + $a["EXAM"];
                        }

                        // Fetch grade information based on total marks
                        $getgrade = oci_parse($conn, "SELECT * FROM GRADE A JOIN GRADE_SETTING B ON A.G_CODE = B.G_CODE WHERE B.START_GRADE_RANGE <= CAST($total AS INT) AND CAST($total AS INT) <= B.END_GRADE_RANGE AND B.S_ID  = $sid ORDER BY A.GRADE");
                        oci_execute($getgrade);

                        while ($b = oci_fetch_array($getgrade)) {
                            $g_code = $b["G_CODE"];
                            $grade = $b["GRADE"];
                        }

                        // Fetch GPA based on grade
                        $getgpa = oci_parse($conn, "SELECT * FROM GPA WHERE g_code = $g_code");
                        oci_execute($getgpa);

                        while ($c = oci_fetch_array($getgpa)) {
                            $gpa = $c['GPA'];
                        }

                        // Fetch subject credit hours
                        $getgpa = oci_parse($conn, "SELECT * FROM SUBJECT WHERE SUB_CODE = $sub_code AND subs = $s_code AND s_id = $sid");
                        oci_execute($getgpa);

                        while ($d = oci_fetch_array($getgpa)) {
                            $hrs = $d['SUBJECT_CREDIT_HRS'];
                        }

                        $currentDate = date('Y-m-d');
                        $pro_gpa_hrs = $gpa * $hrs;

                        // Check if a record already exists
                        $check_cum = oci_parse($conn, "SELECT COUNT(*) AS RECORD_COUNT FROM STUDENT_CUMULATIVE WHERE S_ID = $sid AND sub_code = $sub_code AND subj_code = $s_code AND stud_id = '$stud_id'");
                        oci_execute($check_cum);
                        oci_fetch_all($check_cum, $result);

                        if ($result['RECORD_COUNT'][0] > 0) {
                            // Record exists, continue to the next iteration
                            continue;
                        } else {
                            // Record doesn't exist, insert a new record
                            $check_cum = oci_parse($conn, "SELECT COUNT(*) AS RECORD_COUNT FROM STUDENT_CUMULATIVE WHERE S_ID = $sid AND subj_code = $s_code AND stud_id = '$stud_id'");
                            oci_execute($check_cum);
                            oci_fetch_all($check_cum, $result);

                            if ($result['RECORD_COUNT'][0] <= 9) {
                                $cumulative = oci_parse($conn, "INSERT INTO STUDENT_CUMULATIVE (S_ID, STUD_ID, ACADEMIC_YEAR, TERM, ENTRY_DT, SUB_CODE, SUBJ_CODE, MARK, G_CODE, GPA, CREDIT_HRS, TOTAL_GPA_CREDIT) 
                          VALUES ($sid, '$stud_id', '$a_y', '$t', '$currentDate', $s_code, $sub_code, $total, $g_code, $gpa, $hrs, $pro_gpa_hrs)");
                                oci_execute($cumulative);
                            }
                        }
        ?><div style="font-size:15px;
                            color: green;
                            position: relative;
                             display:flex;
                            animation:button .3s linear;text-align: center;">
                            <?php 
                             echo '<script>
                             Swal.fire({
                                 position: "center",
                                 icon: "success",
                                 title: "STUDENT MARK ACCEPTED",
                                 showConfirmButton: false,
                                 timer: 1500
                               });
                             </script>';
                        //    echo "STUDENT MARK ACCEPTED";
                            header("refresh:2;");
                            ?>
                        </div> <?php
                            } else {
                                ?><div style="font-size:15px;
                            color: green;
                            position: relative;
                             display:flex;
                            animation:button .3s linear;text-align: center;">
                            <?php 
                             echo '<script>
                             Swal.fire({
                                 position: "center",
                                 icon: "error",
                                 title: "ERROR ACCEPTING STUDENT MARK",
                                 showConfirmButton: false,
                                 timer: 1500
                               });
                             </script>';
                            
                           // echo "ERROR ACCEPTING STUDENT MARK";
                                header("refresh:2;");
                            ?>
                        </div> <?php
                            }
                        }
                    } else {
                                ?><div style="font-size:15px;
                    color: red;
                    position: relative;
                     display:flex;
                    animation:button .3s linear;text-align: center;">
                    <?php  echo '<script>
                     Swal.fire({
                         position: "center",
                         icon: "warning",
                         title: "NO STUDENT SELECTED",
                         showConfirmButton: false,
                         timer: 1500
                       });
                     </script>';
                        header("refresh:2;");
                    ?>
                </div> <?php
                    }
                }
                if (isset($_POST['reject'])) {
                    if (isset($_POST['enroll']) && !empty($_POST['enroll'])) {
                        $selectedStudentIds = $_POST['enroll'];
                        foreach ($selectedStudentIds as $studentId) {
                            $sql = oci_parse($conn, "DELETE FROM STUDENT_EVALUATION WHERE S_ID = $sid AND MARK_STATUS = 'PENDING' and CLASS_CODE = $s_code AND SUB_CODE = $sub_code AND EMP_ID = '$emp_id' AND STUD_ID = '$studentId' ");
                            if (oci_execute($sql)) {
                        ?><div style="font-size:15px;
                                    color: green;
                                    position: relative;
                                     display:flex;
                                    animation:button .3s linear;text-align: center;">
                            <?php  echo '<script>
                             Swal.fire({
                                 position: "center",
                                 icon: "success",
                                 title: "STUDENT MARK REJECTED",
                                 showConfirmButton: false,
                                 timer: 1500
                               });
                             </script>';
                                header("refresh:2;");
                            ?>
                        </div> <?php
                            } else {
                                ?><div style="font-size:15px;
                                    color: green;
                                    position: relative;
                                     display:flex;
                                    animation:button .3s linear;text-align: center;">
                            <?php  echo '<script>
                             Swal.fire({
                                 position: "center",
                                 icon: "error",
                                 title: "ERROR REJECTING STUDENT MARK",
                                 showConfirmButton: false,
                                 timer: 1500
                               });
                             </script>';
                                header("refresh:2;");
                            ?>
                        </div> <?php
                            }
                        }
                    } else {
                                ?><div style="font-size:15px;
                            color: red;
                            position: relative;
                             display:flex;
                            animation:button .3s linear;text-align: center;">
                    <?php 
                     echo '<script>
                     Swal.fire({
                         position: "center",
                         icon: "warning",
                         title: "NO STUDENT SELECTED",
                         showConfirmButton: false,
                         timer: 1500
                       });
                     </script>';
                    
                    
                    
                  //  echo "NO STUDENT SELECTED";
                        header("refresh:2;");
                    ?>
                </div> <?php
                    }
                }
                        ?>
        <div class="buttons">

            <button class="backBtn" type="submit">

                <a class="btnText" href="select_verify.php">
                    BACK
                </a>
            </button>
        </div>
        <?php
        require 'C:\wamp64\www\Academix\KOTU SENIOR SECONDARY SCHOOL\Sec_Registra\PHPMailer.php';
        require 'C:\wamp64\www\Academix\KOTU SENIOR SECONDARY SCHOOL\Sec_Registra\Exception.php';
        require 'C:\wamp64\www\Academix\KOTU SENIOR SECONDARY SCHOOL\Sec_Registra\SMTP.php';



        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\Exception;


        ?>

    </form>
    <script>
        $(document).ready(function() {
            $('#example').DataTable();
        });
    </script>
</body>
</body><script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</html>