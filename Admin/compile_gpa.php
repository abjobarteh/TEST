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
$school =  $_SESSION['school'];
$emp_id = $_SESSION['emp_id'];
$sid = $_SESSION['sid']; ?>
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
    <form class="container" enctype="multipart/form-data" action="compile_gpa.php" method="post">
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
        <header>Class Standings</header>
        <?php

        $sql = oci_parse($conn, "select * from employee where emp_id = '$emp_id' ");
        oci_execute($sql);
        if ($rowS = oci_fetch_array($sql)) {
            $name = $rowS["NAME"];
        }
        $sql = oci_parse($conn, "SELECT * FROM CLASS_TEACHER B JOIN SUB_CLASS A ON (A.SUB_CODE=B.SUB_CODE) WHERE B.EMP_ID = '$emp_id' and B.s_id = $sid ");
        oci_execute($sql);
        if ($rowS = oci_fetch_array($sql)) {
            $s_code = $rowS["SUB_CODE"];
            $class_name = $rowS["CLASS_NAME"];
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
            <button style=" display: inline-block;
  padding: 6px 12px;
  background-color: #04716f;
  color: white;
  border: none;
  border-radius: 4px;
  margin-top:10px;
  margin-bottom:10px;
  text-decoration: none;" name="compile" type="submit">
                COMPILE CLASS STANDINGS
                <i class="uil uil-exposure-increase"></i>
            </button>
            <?php
            $sql = "SELECT DISTINCT(A.STUD_ID),A.NAME
                  FROM STUDENT A
                   JOIN STUDENT_CUMULATIVE D ON (A.STUD_ID=D.STUD_ID) 
                  WHERE
                   D.ACADEMIC_YEAR = '$a_y' AND D.TERM='$t' AND D.S_ID = $sid AND 
                      NOT EXISTS (
                          SELECT 1
      FROM STUDENT_STANDINGS S
      WHERE A.STUD_ID = S.STUD_ID
        AND S.ACADEMIC_YEAR = D.ACADEMIC_YEAR
        AND S.TERM = D.TERM
        AND S.S_ID = D.S_ID
        AND S.CLASS_CODE = $s_code
       
                  ) and D.SUB_CODE= $s_code ORDER BY A.NAME
                  ";
            //echo $sql;
            if (isset($_POST['compile'])) {

                $getstu = oci_parse($conn, $sql);
                oci_execute($getstu);
                //   echo $sql;
                if (oci_fetch_all($getstu, $z) > 0) {
                    $getstu = oci_parse($conn, $sql);
                    oci_execute($getstu);
                    while ($row = oci_fetch_array($getstu)) {
                        $stud_id = $row["STUD_ID"];
                        // echo $stud_id;
                         $sql = oci_parse($conn,"SELECT * FROM STUDENT_CUMULATIVE WHERE STUD_ID = '$stud_id' AND SUB_CODE = $s_code  AND ACADEMIC_YEAR = '$a_y' AND TERM='$t'");
                         oci_execute($sql);
                         $cnt = oci_fetch_all($sql,$a);
                         if($cnt<8){
                            continue;
                         }
                        $SQL = oci_parse($conn, "SELECT ROUND(SUM(TOTAL_GPA_CREDIT) / SUM(CREDIT_HRS), 2) AS GPA FROM STUDENT_CUMULATIVE WHERE STUD_ID = '$stud_id' AND TERM = '$t' AND SUB_CODE = $s_code");
                        oci_execute($SQL);
                        while ($row = oci_fetch_array($SQL)) {
                            $gpa = $row["GPA"];
                            //  echo $gpa;
                        }
                        $sql = oci_parse($conn, "INSERT INTO STUDENT_STANDINGS (S_ID,GPA,CLASS_CODE,ACADEMIC_YEAR,TERM,STUD_ID,STATUS) VALUES ($sid,$gpa,$s_code,'$a_y','$t','$stud_id','COMPILED')
                        ");
                        //     echo "INSERT INTO STDUENT_STANDINGS (S_ID,GPA,CLASS_CODE,ACADEMIC_YEAR,TERM,STUD_ID) VALUES ($sid,$gpa,$s_code,'$a_y','$t','$stud_id')";
                        oci_execute($sql);
                    }
            ?><div style="font-size:15px;
                    color: green;
                    position: relative;
                     display:flex;
                    animation:button .3s linear;text-align: center;">
                        <?php echo "STUDENT GPA COMPILED";
                        header("refresh:2;");
                        ?>
                    </div> <?php
                        } else {
                            ?><div style="font-size:15px;
                        color: red;
                        position: relative;
                         display:flex;
                        animation:button .3s linear;text-align: center;">
                        <?php echo "NO STUDENT GPA TO COMPILE OR STUDENT GPA ALREADY COMPILED";
                            header("refresh:2;"); ?>
                    </div> <?php
                        }
                    }
                    //  echo "SELECT A.STUD_ID,A.NAME,B.GPA FROM STUDENT A JOIN  STUDENT_STANDINGS B ON (A.STUD_ID=B.STUD_ID) WHERE b.S_ID = $sid and b.class_code = $s_code ";
                    $showgpa =  oci_parse($conn, "SELECT A.STUD_ID,A.NAME,ROUND(B.GPA/1.00,2) AS GPA FROM STUDENT A JOIN  STUDENT_STANDINGS B ON (A.STUD_ID=B.STUD_ID) WHERE b.S_ID = $sid and b.class_code = $s_code ");
                    oci_execute($showgpa);
                            ?>

            <div style="max-height: 200px; overflow-y: auto;">
                <table class="table-content" style="font-size: 14px; border-collapse: collapse; margin: 10px 0; font: 0.9em; min-width: 400px; border-radius: 5px 5px;">
                    <thead>
                        <tr style="background-color: #04716f; color: #ffffff; text-align: left; font-weight: bold;">
                            <th style="padding: 5px 8px; font-size: 10px; margin: 5px;">Student ID</th>
                            <th style="padding: 5px 8px; font-size: 10px; margin: 5px;">Name</th>
                            <th style="padding: 5px 8px; font-size: 10px; margin: 5px;">GPA</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = oci_fetch_array($showgpa)) {
                        ?>
                            <tr style="border-bottom: 1px solid #dddddd;">
                                <td style="padding: 5px 8px; font-size: 10px; margin: 5px;"><?php echo $row['STUD_ID']; ?></td>
                                <td style="padding: 5px 8px; font-size: 10px; margin: 5px;"><?php echo $row['NAME']; ?></td>
                                <td style="padding: 5px 8px; font-size: 10px; margin: 5px;"><?php echo $row['GPA'] / 1.00; ?></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>


            <label>Generate Class Standings Report</label>
            <div class="input-field" style="margin-right: 10px;">
                <label>Report Type</label>
                <select required name="report_type">
                    <option disabled selected>Select Report Type</option>
                    <option>PDF</option>
                    <option>EXCEL</option>
                </select>

                <button style=" display: inline-block;
  padding: 6px 12px;
  background-color: #04716f;
  color: white;
  border: none;
  border-radius: 4px;
  margin-top:10px;
  margin-bottom:10px;
  text-decoration: none;" name="standings" type="submit">
                    GENERATE REPORT OF CLASS STANDINGS
                    <i class="uil uil-file-export"></i>
                </button>
                <?php
                require('tcpdf/tcpdf.php');
                require '../vendor/autoload.php';

                use PhpOffice\PhpSpreadsheet\Spreadsheet;
                use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

                if (isset($_POST['standings'])) {
                    if (isset($_POST['report_type'])) {
                        $rpt_type = $_POST['report_type'];
                        if ($rpt_type == 'EXCEL') {
                            $query = "SELECT A.STUD_ID,A.NAME,B.GPA FROM STUDENT A JOIN  STUDENT_STANDINGS B ON (A.STUD_ID=B.STUD_ID) WHERE b.S_ID = $sid ";
                            // Prepare and execute the query
                            $statement = oci_parse($conn, $query);
                            oci_execute($statement);
                            $spreadsheet = new Spreadsheet();
                            $sheet = $spreadsheet->getActiveSheet();
                            $sheet->setCellValue('A1', 'STUDENT ID');
                            $sheet->setCellValue('B1', 'STUDENT NAME');
                            $sheet->setCellValue('C1', 'GPA');

                            $directoryPath = 'C:\ACADEMIX\\' . $school . '\generated_reports\teacher_class_standings\\';
                            if (!is_dir($directoryPath)) {
                                if (!mkdir($directoryPath, 0777, true)) {
                                    die('Failed to create directories.');
                                }
                            }
                            $filePath = $directoryPath . $class_name . '.xlsx';
                            $row = 2;
                            while ($row_data = oci_fetch_assoc($statement)) {
                                $sheet->setCellValue('A' . $row, $row_data['STUD_ID']);
                                $sheet->setCellValue('B' . $row, $row_data['NAME']);
                                $sheet->setCellValue('C' . $row, $row_data['GPA']);
                                $row++;
                            }
                            $writer = new Xlsx($spreadsheet);
                            // Output the Excel file
                            $writer->save($filePath);
                            /*  $file_path = 'C:\ACADEMIX\KOTU SENIOR SECONDARY SCHOOL\generated_reports\teacher_class_standings\\' . $class_name . '.xlsx';

                            // Ensure the file exists before proceeding
                            if (file_exists($file_path)) {
                                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                                header("Content-Transfer-Encoding: Binary");
                                header("Content-disposition: attachment; filename=\"" . basename($file_path) . "\"");
                            
                                readfile($file_path);
                            } else {
                                echo "File not found: $file_path";
                            }
                            
*/
                ?><div style="font-size:15px;
    color: green;
    position: relative;
     display:flex;
    animation:button .3s linear;text-align: center;">
                                <?php echo "FILE GENERATED";
                                header("refresh:2;"); ?>
                            </div> <?php
                                    // Close the Oracle connection
                                    oci_free_statement($statement);
                                    oci_close($conn);
                                }
                            } else {
                                    ?><div style="font-size:15px;
    color: red;
    position: relative;
     display:flex;
    animation:button .3s linear;text-align: center;">
                            <?php echo "SELECT REPORT TYPE";
                                header("refresh:2;"); ?>
                        </div> <?php
                            }
                        }

                                ?>
            </div>


            <?php


            if (isset($_POST['generate'])) {
                /*   $query = "select * from class a join sub_class b on (a.class=b.class) where b.s_id = $sid ";
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
                                                oci_close($conn); */
            }
            ?>
            <div class="buttons">

                <button class="backBtn" type="submit">

                    <a class="btnText" href="admin.php">
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