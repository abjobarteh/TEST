<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/show.css">
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
$subject = $_SESSION['subject']; ?>
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
    <form class="container" enctype="multipart/form-data" action="verify_grade.php" method="post" style="width: 1500px;">
        <div class="com">
            <h3>
                Academix: School Management System
            </h3>
            <h2 class="title" style="justify-content:center; text-align:center; color:#1D5B79; 	font-size: 18px;"><?php echo $school ?>
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

                <a class="btnText" href="teacher.php" style="font-size: 15px;">
                    HOME
                    <i class="uil uil-estate" style="width: 50px;"></i>
                </a>

            </button>
        </div>
        <header>Verify Student Mark</header>
        <?php
        include 'connect.php';
        ?>

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
         font-weight: bold; color: #1D5B79;">Student Marks</Label>
        </div>
        <div style="max-height: 200px; overflow-y: auto;">
            <table class="table-content" style="font-size: 14px; border-collapse: collapse; margin: 10px 0; font: 0.9em; min-width: 400px; border-radius: 5px 5px; overflow: hidden; box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);">
                <thead>
                    <tr style="background-color: #1D5B79; color: #ffffff; text-align: left; font-weight: bold;">
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
  background-color: #1D5B79;
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
  background-color: #1D5B79;
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
        ?><div style="font-size:15px;
                            color: green;
                            position: relative;
                             display:flex;
                            animation:button .3s linear;text-align: center;">
                            <?php echo "STUDENT MARK ACCEPTED";
                            header("refresh:2;");
                            ?>
                        </div> <?php
                            } else {
                                ?><div style="font-size:15px;
                            color: green;
                            position: relative;
                             display:flex;
                            animation:button .3s linear;text-align: center;">
                            <?php echo "ERROR ACCEPTING STUDENT MARK";
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
                    <?php echo "NO STUDENT SELECTED";
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
                            <?php echo "STUDENT MARK REJECTED";
                                header("refresh:2;");
                            ?>
                        </div> <?php
                            } else {
                                ?><div style="font-size:15px;
                                    color: green;
                                    position: relative;
                                     display:flex;
                                    animation:button .3s linear;text-align: center;">
                            <?php echo "ERROR REJECTING STUDENT MARK";
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
                    <?php echo "NO STUDENT SELECTED";
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

</html>