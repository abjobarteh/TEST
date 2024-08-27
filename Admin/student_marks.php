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
    $subject = $_SESSION['subject'] ; ?>
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
    <form class="container" enctype="multipart/form-data" action="student_marks.php" method="post">
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
        <header>Student Marks</header>
        <?php
        include 'connect.php';

        if ($conn) {
         
            $sql = "select * from waec_subject a join student_evaluation b on (a.sub_code=b.sub_code) join sub_class c on (b.class_code=c.sub_code) join student d on (d.stud_id=b.stud_id) where b.class_code = $s_code and b.sub_code = $sub_code and b.emp_id = $emp_id ";
            $stidd = oci_parse($conn, $sql);
            oci_execute($stidd);
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
                        Student</th>
                        <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Student ID</th>
                        <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Continuous Assessment Mark</th>
                        <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Exam Mark</th>
                        <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Entry Date</th>
                        <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Mark Status</th>
                </tr>
            </thead>
            <tbody>
                <tr style=" border-bottom: 1px solid #dddddd;">
                    <?php
                    while ($row = oci_fetch_array($stidd)) {
                    ?>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['NAME']; ?>

                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['EMP_ID']; ?>

                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['CONST_ASS']; ?>

                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['EXAM']; ?>

                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['ENTRY_DT']; ?>

                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['MARK_STATUS']; ?>

                        </td>
                </tr>
            <?php
                    }
            ?>
            </tr>
            </tbody>
        </table>
       
        <div style="display: flex;">
            <button style=" display: inline-block;
  padding: 6px 12px;
  background-color: #04716f;
  color: white;
  border: none;
  border-radius: 4px;
  margin-top:10px;
  margin-bottom:10px;
  text-decoration: none;" name="generates" type="submit">
                GENERATE EXCEL REPORT OF STUDENT MARK
                <i class="uil uil-file-export"></i>
            </button>
        </div>
        <?php
          require '../vendor/autoload.php';

          use PhpOffice\PhpSpreadsheet\Spreadsheet;
          use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
        if(isset($_POST['generate'])){
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
            $filePath = $directoryPath .'class.xlsx';
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

                <a class="btnText" href="select_subject_marks.php">
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