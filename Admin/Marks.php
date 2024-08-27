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
    <form class="container" enctype="multipart/form-data" action="Marks.php" method="post">
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
        <header>Marks</header>
       
        <?php
        if (isset($_POST['filter'])) {
            if (isset($_POST['filter_class'])) {
                $class = $_POST['filter_class'];
            } else {
        ?><div style="font-size:15px;
                color: red;
                position: relative;
                 display:flex;
                animation:button .3s linear;text-align: center;">
                    <?php echo "SELECT CLASS"; ?>
                </div> <?php
                    }
                }
                $sql = "select * from class c join sub_class s on (c.class=s.class) where s.s_id = $sid and c.class_title = '$class' order by c.class_title ";
                $stid = oci_parse($conn, $sql);
                oci_execute($stid);
                        ?>
     
        <label>Generate Marks Report</label>

        <div class="input-field" style="margin-right: 10px;">
            <label>Class</label>
            <select required name="filter_class">
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
            <button style=" display: inline-block;
  padding: 6px 12px;
  background-color: #04716f;
  color: white;
  border: none;
  border-radius: 4px;
  text-decoration: none;" name="filter_byclass" type="submit">
                FILTER CLASS NAME
                <i class="uil uil-filter"></i>
            </button>
        </div>
        <?php
        if (isset($_POST['filter_byclass'])) {
            if (isset($_POST['filter_class'])) {
                $class = $_POST['filter_class'];
                $_SESSION['fil_class'] = $class;
            } else {
        ?><div style="font-size:15px;
                color: red;
                position: relative;
                 display:flex;
                animation:button .3s linear;text-align: center;">
                    <?php echo "SELECT CLASS"; ?>
                </div> <?php
                    }
                }
                        ?>
        <div class="input-field" style="margin-right: 10px;">
            <label>Report Type</label>
            <select required name="report_type">
                <option disabled selected>Select Report Type</option>
                <option>EXCEL</option>
            </select>
            <label>Class Name</label>
            <select required name="class_name">
                <option disabled selected>Select Class Name</option>
                <?php
                $class = $_SESSION['fil_class'];
                $get_hos = "select DISTINCT(CLASS_NAME) AS CLASS_NAME from CLASS a join sub_class b on (a.class=b.class) JOIN SUBJECT C ON (B.SUB_CODE=C.SUBS) where a.class_title = '$class'  and  b.SUB_TITLE != 'UMAR 1' AND b.SUB_TITLE NOT LIKE 'AISHA' AND b.SUB_TITLE NOT LIKE 'AISHA 2' and b.SUB_CODE  != 286 AND b.SUB_CODE  != 290 AND  b.SUB_CODE  != 202 AND  b.SUB_CODE  != 291 AND  b.SUB_CODE  != 122 AND  b.SUB_CODE  != 242 AND  b.SUB_CODE  != 103  ORDER BY b.CLASS_NAME ";
                $get = oci_parse(oci_connect($username, $password, $connection), $get_hos);
                oci_execute($get);
                while ($row = oci_fetch_array($get)) {
                ?><option>
                        <?php echo $row["CLASS_NAME"]; ?>
                    </option> <?php
                            }
                                ?>
            </select>
            
            <button style=" display: inline-block;
  padding: 6px 12px;
  background-color: #04716f;
  color: white;
  border: none;
  border-radius: 4px;
  margin-top:10px;
  margin-bottom:10px;
  text-decoration: none;" name="pending" type="submit">
                GENERATE REPORT OF STUDENTS WITH PENDING MARKS
                <i class="uil uil-file-export"></i>
            </button>
          
            <?php
       //     require('tcpdf/tcpdf.php');
            require '../vendor/autoload.php';

            use PhpOffice\PhpSpreadsheet\Spreadsheet;
            use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

            if (isset($_POST['pending'])) {
                if (isset($_POST['report_type'])) {
                    $rpt_type = $_POST['report_type'];
                   if ($rpt_type == 'EXCEL') {
                                        if (isset($_POST['class_name'])) {
                                          
                                                $class_name = $_POST['class_name'];
                                            
                                                $sql = oci_parse($conn, "select * from sub_class where class_name = '$class_name' ");
                                                oci_execute($sql);
                                                while ($r = oci_fetch_array($sql)) {
                                                    $sub_code = $r['SUB_CODE'];
                                                }

                                                $sql = oci_parse($conn, "select DISTINCT(SUB_CODE) AS SUB_CODE from subject where SUBS = $sub_code ");
                                                oci_execute($sql);
                                                while($r=oci_fetch_array($sql)){
                                                    $subj_code[] = $r['SUB_CODE'];
                                                  
                                                }

                                                foreach ($subj_code as $s_code) {

                                                    $sql = oci_parse($conn, "select DISTINCT(SUBJECT) AS SUBJECT from subject where SUBS = $sub_code and sub_code= $s_code ");
                                                    oci_execute($sql);
                                                    while($r=oci_fetch_array($sql)){
                                                        $subject = $r['SUBJECT'];
                                                        
                                                    }

                                                    $query = "SELECT distinct(l.subject),a.stud_id,A.NAME, e.CLASS_NAME
                                                    FROM STUDENT A
                                                    JOIN class_student b ON (A.stud_id = b.stud_id)
                                                    JOIN STUDENT_SUBJECT c ON (A.stud_id = c.stud_id)
                                                    JOIN waec_subject l ON (c.sub_code = l.sub_code)
                                                    JOIN sub_class e ON (b.sub_code = e.sub_code)
                                                    LEFT JOIN STUDENT_EVALUATION m ON (A.stud_id = m.stud_id AND c.sub_code = m.sub_code AND e.SUB_CODE = m.class_code)
                                                    WHERE e.sub_code = $sub_code and l.sub_code = $s_code
                                                    and m.sub_code is null and m.stud_id is null and m.class_code is null
                                                    ORDER BY e.CLASS_NAME, A.Name";
                                               
                                                    $statement = oci_parse($conn, $query);
                                                    oci_execute($statement);
                                                    $spreadsheet = new Spreadsheet();
                                                    $sheet = $spreadsheet->getActiveSheet();
                                                    $sheet->setCellValue('A1', 'STUDENT ID');
                                                    $sheet->setCellValue('B1', 'NAME');
                                                    $sheet->setCellValue('C1', 'CLASSNAME');
                                                    $sheet->setCellValue('D1', 'SUBJECT');
                                                    $directoryPath = 'C:\ACADEMIX\\' . $school . '\generated_reports\missing_marks\\'.  $class_name . '\\';
                                                    if (!is_dir($directoryPath)) {
                                                        if (!mkdir($directoryPath, 0777, true)) {
                                                            die('Failed to create directories.');
                                                        }
                                                    }
                                                    $filePath = $directoryPath . 'LIST OF MISSING MARKS OF STUDENTS UNDER'. $class_name.' DOING ' .$subject.'.xlsx';
                               
                                                    $row = 2;
                                                    while ($row_data = oci_fetch_assoc($statement)) {
                                                        $sheet->setCellValue('A' . $row, $row_data['STUD_ID']);
                                                        $sheet->setCellValue('B' . $row, $row_data['NAME']);
                                                        $sheet->setCellValue('C' . $row, $row_data['CLASS_NAME']);
                                                        $sheet->setCellValue('D' . $row, $row_data['SUBJECT']);
                                                        
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
                                                <?php echo "LIST OF MISSING MARKS OF STUDENTS UNDER $class_name DOING $subject GENERATED";
                                                    header("refresh:2;"); ?>
                                            </div> <?php
                                                    // Close the Oracle connection
                                                    oci_free_statement($statement);
                                                    oci_close($conn);
                                                }
                                                $_SESSION['school'] = $school;
                                                $_SESSION['class_name'] = $class_name;
                                                $_SESSION['path']=$directoryPath;
                                                 $_SESSION['location']='Marks.php';
                                                 header('Location: zipfile.php');
                                        } else {
                                                ?><div style="font-size:15px;
                            color: red;
                            position: relative;
                             display:flex;
                            animation:button .3s linear;text-align: center;">
                                        <?php echo "SELECT CLASS";
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
                                <?php echo "SELECT REPORT TYPE";
                                    header("refresh:2;"); ?>
                            </div> <?php
                                }
                            }

                            if (isset($_POST['uncumulated'])) {
                                if (isset($_POST['report_type'])) {
                                    $rpt_type = $_POST['report_type'];
                                   if ($rpt_type == 'EXCEL') {
                                                        if (isset($_POST['class_name'])) {
                                                            $class_name = $_POST['class_name'];
                                                            $sql = oci_parse($conn, "select * from sub_class where class_name = '$class_name' ");
                                                            oci_execute($sql);
                                                            while ($r = oci_fetch_array($sql)) {
                                                                $sub_code = $r['SUB_CODE'];
                                                            }
                                                                $query = "SELECT distinct(l.subject),a.stud_id,A.NAME, e.CLASS_NAME
                                                                FROM STUDENT A
                                                                JOIN class_student b ON (A.stud_id = b.stud_id)
                                                                JOIN STUDENT_SUBJECT c ON (A.stud_id = c.stud_id)
                                                                JOIN waec_subject l ON (c.sub_code = l.sub_code)
                                                                JOIN sub_class e ON (b.sub_code = e.sub_code)
                                                                LEFT JOIN STUDENT_EVALUATION m ON (A.stud_id = m.stud_id AND c.sub_code = m.sub_code AND e.SUB_CODE = m.class_code)
                                                                WHERE e.sub_code = $sub_code
                                                                and m.sub_code is null and m.stud_id is null and m.class_code is null
                                                                ORDER BY e.CLASS_NAME, A.Name";
                                                           
                                                                $statement = oci_parse($conn, $query);
                                                                oci_execute($statement);
                                                                $spreadsheet = new Spreadsheet();
                                                                $sheet = $spreadsheet->getActiveSheet();
                                                                $sheet->setCellValue('A1', 'STUDENT ID');
                                                                $sheet->setCellValue('B1', 'NAME');
                                                                $sheet->setCellValue('C1', 'CLASSNAME');
                                                                $sheet->setCellValue('D1', 'SUBJECT');
                                                                $directoryPath = 'C:\Users\KOTUSSS\ACADEMIX\\' . $school . '\generated_reports\missing_marks\\';
                                                                if (!is_dir($directoryPath)) {
                                                                    if (!mkdir($directoryPath, 0777, true)) {
                                                                        die('Failed to create directories.');
                                                                    }
                                                                }
                                                                $filePath = $directoryPath . 'LIST OF MISSING MARKS OF STUDENTS UNDER'. $class_name.'.xlsx';
                                           
                                                                $row = 2;
                                                                while ($row_data = oci_fetch_assoc($statement)) {
                                                                    $sheet->setCellValue('A' . $row, $row_data['STUD_ID']);
                                                                    $sheet->setCellValue('B' . $row, $row_data['NAME']);
                                                                    $sheet->setCellValue('C' . $row, $row_data['CLASS_NAME']);
                                                                    $sheet->setCellValue('D' . $row, $row_data['SUBJECT']);
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
                                                            <?php echo "LIST OF MISSING MARKS OF STUDENTS UNDER $class_name GENERATED";
                                                                header("refresh:2;"); ?>
                                                        </div> <?php
                                                                // Close the Oracle connection
                                                                oci_free_statement($statement);
                                                                oci_close($conn);
                                                        
                                                        } else {
                                                                ?><div style="font-size:15px;
                                            color: red;
                                            position: relative;
                                             display:flex;
                                            animation:button .3s linear;text-align: center;">
                                                        <?php echo "SELECT CLASS";
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
                                                <?php echo "SELECT REPORT TYPE";
                                                    header("refresh:2;"); ?>
                                            </div> <?php
                                                }
                                            }
                                    ?>
                                    </div>
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