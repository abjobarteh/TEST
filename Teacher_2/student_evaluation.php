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
$class_name =  $_SESSION['class_name'] ;
$subject = $_SESSION['subject'] ;
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
    <form class="container" enctype="multipart/form-data" action="student_evaluation.php" method="post">
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

                <a class="btnText" href="teacher.php" style="font-size: 15px;">
                    HOME
                    <i class="uil uil-estate" style="width: 50px;"></i>
                </a>

            </button>
        </div>
        <header>Mark Entry</header>
        <div class="input-field">
            <?php

$sql = oci_parse($conn, "select * from academic_calendar a join term_calendar b on (a.academic_year=b.academic_year) where b.start_dt is not null order by b.term desc");
oci_execute($sql);
if ($row = oci_fetch_array($sql)) {
    $a_y = $row['ACADEMIC_YEAR'];
    $t = $row['TERM'];
}
   
            $get_hos = "SELECT distinct(a.stud_id),a.name FROM student a JOIN student_subject b ON a.stud_id = b.stud_id JOIN class_student c ON a.stud_id = c.stud_id WHERE b.sub_code = $sub_code  AND c.sub_code = $s_code AND a.status != 'GRADUATED' and 
             NOT EXISTS (
              SELECT 1
              FROM student_evaluation se
              WHERE se.stud_id = a.stud_id and se.sub_code = b.sub_code
              and se.class_code = c.sub_code
              and se.academic_year = '$a_y' and se.term = '$t'
            ) order by a.name
          ";
       // echo $get_hos;
          $get = oci_parse(oci_connect($username, $password, $connection), $get_hos);
          oci_execute($get);
          if($row =  oci_fetch_array($get)){
            $stud_id = $row["STUD_ID"];
          }

                $sql = oci_parse($conn, "select * from student where STUD_ID = '$stud_id' ");
                oci_execute($sql);
                while ($row = oci_fetch_array($sql)) {
                    $student = $row['NAME'];
                }
            ?>
                    <label>Student ID</label>
                    <input type="text" placeholder="<?php echo $stud_id ?>" style="width:100px;" readonly>

        </div>


        <?php
                 ?>
        <div>
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
                    <label>Grade</label>
                    <input type="text" placeholder="<?php echo $class_name ?>" style="width:300px;" readonly>
                </div>
            </div>

            <div class="input-container" style="display: flex;">
                <div class="input-field" style="margin-right: 10px;">
                    <label>Subject</label>
                    <input type="text" placeholder="<?php echo $subject ?>" style="width:300px;" readonly>
                </div>
            </div>
            <Label style="font-size: 18px; font-family: sans-serif;
    font-weight: bold; color: #1D5B79;">Student Continuous Assessment And Examination</Label>
        </div>
        <div class="input-container" style="display: flex;">
            <div class="input-field" style="margin-right: 10px;">
                <label>Student</label>
                <input type="text" placeholder="<?php echo $student ?>" style="width:250px;" readonly>
            </div>
            <div class="input-field">
                <label>Continuous Assessment(Mark To Converted To 30%)</label>
                <input type="number" placeholder="Enter Continuous Assessment Mark" title="Only Numbers" name="cas" style="width:300px;" min=0.0 max=100 pattern="[0-9.]+" step="any">
            </div>
            <div class="input-field">
                <label>Examination(Mark To Converted To 70%)</label>
                <input type="number" placeholder="Enter Exam Mark" title="Only Numbers" name="exam" style="width:200px;" min=0.0 max=100 pattern="[0-9.]+" step="any">
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
                ENTER MARK
                <i class="uil uil-create-dashboard"></i>
            </button>
        </div>
        <?php
        if (isset($_POST['establish'])) {
            $cas_mark = $_POST['cas'];
            if ($cas_mark != '') {
                $exam_mark = $_POST['exam'];
                if ($exam_mark != '') {
                    $st =  $stud_id;
                    $sql = oci_parse($conn, "select * from student_evaluation where emp_id = '$emp_id' and sub_code = $sub_code and class_code = $s_code and stud_id = '$st' AND term = '$t' ");
                    oci_execute($sql);
                    if (oci_fetch_all($sql, $a) == 0) {
                        $cas_mark = 0.3*$cas_mark;
                        $exam_mark = 0.7*$exam_mark;
                        $sql = oci_parse($conn, "INSERT INTO STUDENT_EVALUATION (S_ID,SUB_CODE,STUD_ID,EMP_ID,ACADEMIC_YEAR,TERM,CONST_ASS,EXAM,ENTRY_DT,CLASS_CODE,MARK_STATUS)
                       VALUES  ($sid,$sub_code,'$st','$emp_id','$a_y','$t',$cas_mark,$exam_mark,sysdate,$s_code,'PENDING')");
                        if (oci_execute($sql)) {
        ?><div style="font-size:15px;
                        color: green;
                        position: relative;
                         display:flex;
                        animation:button .3s linear;text-align: center;">
                                <?php
                                echo "CONTINUOUS ASSESSMENT MARK AND EXAM MARK ENTERED FOR $student ";
                                header("refresh:2;"); ?>
                            </div> <?php
                                }
                            } else {
                                    ?><div style="font-size:15px;
                        color: red;
                        position: relative;
                         display:flex;
                        animation:button .3s linear;text-align: center;">
                            <?php echo "CONTINUOUS ASSESSMENT MARK AND EXAM MARK ALREADY ENTERED FOR $student ";
                                header("refresh:2;"); ?>
                        </div> <?php 
                            } 
                        } else {
                                ?><div style="font-size:15px;
                    color: red;
                    position: relative;
                     display:flex;
                    animation:button .3s linear;text-align: center;">
                        <?php echo "ENTER EXAM MARK";
                            header("refresh:2;"); ?>
                    </div> <?php
                        }
                    } else {
                            ?><div style="font-size:15px;
                color: red;
                position: relative;
                 display:flex;
                animation:button .3s linear;text-align: center;">
                    <?php echo "ENTER CONTINUOUS ASSESSMENT MARK";
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

                <a class="btnText" href="select_subject.php">
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
