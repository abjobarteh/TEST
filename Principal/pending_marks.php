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
$class = '';
$s_code = $_SESSION['s_code'];
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
    <form class="container" enctype="multipart/form-data" action="pending_marks.php" method="post">
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

                <a class="btnText" href="principal.php" style="font-size: 15px;">
                    HOME
                    <i class="uil uil-estate" style="width: 50px;"></i>
                </a>

            </button>
        </div>
        <header>Uncumulated Marks</header>
        <div class="input-field">
        <?php
            $sql = oci_parse($conn, "select * from academic_calendar a join term_calendar b on (a.academic_year=b.academic_year) WHERE B.STATUS ='ACTIVE'");
            oci_execute($sql);
            if ($row = oci_fetch_array($sql)) {
                $a_y = $row['ACADEMIC_YEAR'];
                $t = $row['TERM'];
            }
           ?>
            <?php
            include 'connect.php';

            if ($conn) {
                $status = 'PENDING';
                $sql = "SELECT DISTINCT(B.NAME),B.EMP_ID,C.SUBJECT,D.CLASS_NAME FROM TEACHER_SUBJECT A JOIN EMPLOYEE B ON (A.EMP_ID=B.EMP_ID) JOIN WAEC_SUBJECT C  ON (C.SUB_CODE=A.SUB_CODE) JOIN SUB_CLASS D ON (A.S_CODE=D.SUB_CODE) WHERE  B.EMP_ID NOT IN (SELECT EMP_ID FROM STUDENT_EVALUATION SE WHERE SE.EMP_ID = B.EMP_ID AND SE.CLASS_CODE=A.S_CODE AND SE.SUB_CODE=A.SUB_CODE AND SE.TERM='$t' AND se.mark_status = 'ACCEPTED') ORDER BY B.NAME
";
                //echo $sql;
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
            <div class="input-container" style="display: flex;">
                <div class="input-field" style="margin-right: 10px;">
                    <label>Academic Year</label>
                    <input type="text" placeholder="<?php echo $a_y ?>" style="width:300px;" readonly>
                </div>
                <div class="input-field" style="margin-right: 10px;">
                    <label>Term</label>
                    <input type="text" placeholder="<?php echo $t ?>" style="width:400px;" readonly>
                </div>
             
            </div>
            <div style="overflow-x:auto;">
                <table class="table-content" style="font-size: 14px; border-collapse: collapse; margin: 10px 0; font: 0.9em; border-radius: 5px 5px; box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);">
                    <thead>
                        <tr style="background-color: #1D5B79; color: #ffffff; text-align: left; font-weight: bold;">
                            <th style="padding: 5px 8px; font-size: 10px; margin: 5px;">Teacher</th>
                            <th style="padding: 5px 8px; font-size: 10px; margin: 5px;">Subject</th>
                            <th style="padding: 5px 8px; font-size: 10px; margin: 5px;">Class</th>
                        </tr>
                    </thead>
                </table>
                <div style="max-height: 200px; overflow-y: auto;">
                    <table class="table-content" style="font-size: 14px; border-collapse: collapse; margin: 0; font: 0.9em; min-width: 400px; border-radius: 5px 5px;">
                        <tbody>
                            <?php
                            while ($row = oci_fetch_array($stidd)) {
                                $class_name = $row['CLASS_NAME'];
                            ?>
                                <tr style="border-bottom: 1px solid #dddddd;">
                                    <td style="padding: 5px 8px; font-size: 10px; margin: 5px;"><?php echo $row['NAME']; ?></td>
                                    <td style="padding: 5px 8px; font-size: 10px; margin: 5px;"><?php echo $row['SUBJECT']; ?></td>
                                    <td style="padding: 5px 8px; font-size: 10px; margin: 5px;"><?php echo $row['CLASS_NAME']; ?></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <button style=" display: inline-block;
  padding: 6px 12px;
  background-color: #1D5B79;
  color: white;
  border: none;
  border-radius: 4px;
  margin-top:10px;
  margin-bottom:10px;
  text-decoration: none;" name="generate" type="submit">
                    GENERATE AND DOWNLOAD PENDING TEACHER MARKS
                    <i class="bi bi-box-arrow-down"></i>
                </button>
            </div>

            </button>
            <?php
        //    require('tcpdf/tcpdf.php');
            require '../vendor/autoload.php';

            use PhpOffice\PhpSpreadsheet\Spreadsheet;
            use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

            if (isset($_POST['generate'])) {
                $status = 'PENDING';
                $query = "SELECT DISTINCT(B.NAME),B.EMP_ID,C.SUBJECT,D.CLASS_NAME FROM TEACHER_SUBJECT A JOIN EMPLOYEE B ON (A.EMP_ID=B.EMP_ID) JOIN WAEC_SUBJECT C  ON (C.SUB_CODE=A.SUB_CODE) JOIN SUB_CLASS D ON (A.S_CODE=D.SUB_CODE) WHERE  B.EMP_ID NOT IN (SELECT EMP_ID FROM STUDENT_EVALUATION SE WHERE SE.EMP_ID = B.EMP_ID AND SE.CLASS_CODE=A.S_CODE AND SE.SUB_CODE=A.SUB_CODE AND SE.TERM='$t' AND se.mark_status = 'ACCEPTED') ORDER BY B.NAME";
                // Prepare and execute the query
                $statement = oci_parse($conn, $query);
                oci_execute($statement);
                $spreadsheet = new Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();
                $sheet->setCellValue('A1', 'NAME');
                $sheet->setCellValue('B1', 'SUBJECT');
                $sheet->setCellValue('C1', 'CLASS');
            

                $directoryPath = 'C:\ACADEMIX\\' . $school . '\generated_reports\unprocessed\\';
                if (!is_dir($directoryPath)) {
                    if (!mkdir($directoryPath, 0777, true)) {
                        die('Failed to create directories.');
                    }
                }
                $filePath = $directoryPath  . 'PENDING MARKS.xlsx';
                $row = 2;
                while ($row_data = oci_fetch_assoc($statement)) {
                    $sheet->setCellValue('A' . $row, $row_data['NAME']);
                    $sheet->setCellValue('B' . $row, $row_data['SUBJECT']);
                    $sheet->setCellValue('C' . $row, $row_data['CLASS_NAME']);
                
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
                    $_SESSION['school'] = $school;
                    $_SESSION['class_name'] = $class_name;

                    $_SESSION['path'] = $filePath;
                    $_SESSION['file'] = 'PENDING MARKS.xlsx';
                    $_SESSION['redirect'] = 'pending_marks.php';
                    header('Location: download_excel.php');
                    //  header("refresh:2;"); 
                    ?>
                </div> <?php
                        // Close the Oracle connection
                        oci_free_statement($statement);
                        oci_close($conn);
                    }
                        ?>
            <div class="buttons">

                <button class="backBtn" type="submit">

                    <a class="btnText" href="principal">
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