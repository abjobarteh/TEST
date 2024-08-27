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
$term = $_SESSION['term'];
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
    <form class="container" enctype="multipart/form-data" action="cumulate_mark.php" method="post" style="width: 2100px;">
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
        <header>Cumulate Student Marks</header>
        <div class="input-field">
            <?php
            $get_hos = "SELECT a.stud_id,a.name FROM student a JOIN student_subject b ON a.stud_id = b.stud_id JOIN class_student c ON a.stud_id = c.stud_id JOIN STUDENT_EVALUATION D on (d.stud_id=d.stud_id) WHERE b.sub_code = $sub_code  AND c.sub_code = $s_code AND a.status != 'GRADUATED' and a.stud_id = '04462023' and d.mark_status = 'ACCEPTED'
            order by a.name
          ";

            $sql = oci_parse($conn, "select * from academic_calendar a join term_calendar b on (a.academic_year=b.academic_year) where b.term = '$term' ");
            oci_execute($sql);
            if ($row = oci_fetch_array($sql)) {
                $a_y = $row['ACADEMIC_YEAR'];
                $t =$term;
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
                    <input type="text" placeholder="<?php echo $t ?>" style="width:400px;" readonly>
                </div>

            </div>

            <div class="input-container" style="display: flex;">
                <div class="input-field" style="margin-right: 10px;">
                    <label>Grade</label>
                    <input type="text" placeholder="<?php echo $class_name ?>" style="width:300px;" readonly>
                </div>
                <div class="input-field" style="margin-right: 10px;">
                    <label>Subject</label>
                    <input type="text" placeholder="<?php echo $subject ?>" style="width:300px;" readonly>
                </div>

            </div>
        </div>
        <?php
        $sql = "SELECT *
        FROM STUDENT A
        JOIN STUDENT_EVALUATION B ON A.STUD_ID = B.STUD_ID 
        WHERE B.S_ID = $sid
        and term = '$t'
         and academic_year = '$a_y'
          AND MARK_STATUS = 'ACCEPTED'
          AND B.CLASS_CODE = $s_code
          AND B.SUB_CODE = $sub_code
          AND B.EMP_ID = '$emp_id'  ORDER BY A.NAME
        ";
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
                        <th style="padding: 5px 8px; font-size: 10px; margin: 5px;">Total Mark</th>
                    </tr>
                </thead>
            </table>
        </div>

        <div style="max-height: 200px; overflow-y: auto;">
            <table class="table-content" style="font-size: 14px; border-collapse: collapse; margin: 10px 0; font: 0.9em; min-width: 400px; border-radius: 5px 5px; overflow: hidden; box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);">
                <tbody>
                    <?php
                    while ($row = oci_fetch_array($stid)) {
                        $total_mark = $row['CONST_ASS'] + $row['EXAM'];
                    ?>
                        <tr style="border-bottom: 1px solid #dddddd;">
                            <td><?php echo $row['STUD_ID']; ?></td>
                            <td><?php echo $row['NAME']; ?></td>
                            <td><?php echo $row['CONST_ASS']; ?></td>
                            <td><?php echo $row['EXAM']; ?></td>
                            <td><?php echo $total_mark; ?></td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <?php
        if (isset($_POST['establish'])) {

            $sql =
                "SELECT *
                FROM STUDENT A
                JOIN STUDENT_EVALUATION B ON A.STUD_ID = B.STUD_ID
                WHERE B.S_ID = $sid
                  AND MARK_STATUS = 'ACCEPTED'
                  AND B.CLASS_CODE = $s_code
                  AND B.SUB_CODE = $sub_code
                  AND B.EMP_ID = '$emp_id'
                  and  b.term = '$t'
             and b.academic_year = '$a_y'
                  AND NOT EXISTS (
                    SELECT 1 FROM STUDENT_CUMULATIVE SC WHERE SC.stud_id = A.stud_id AND SC.sub_code = B.CLASS_code AND SC.SUBJ_CODE = B.SUB_CODE and sc.academic_year ='$a_y' and sc.term = '$t'
                  )ELECT *
                  FROM STUDENT A
                  JOIN STUDENT_EVALUATION B ON A.STUD_ID = B.STUD_ID
                  WHERE B.S_ID = $sid
                    AND MARK_STATUS = 'ACCEPTED'
                    AND B.CLASS_CODE = $s_code
                    AND B.SUB_CODE = $sub_code
                    AND B.EMP_ID = '$emp_id'
                    and  b.term = '$t'
               and b.academic_year = '$a_y'
                    AND NOT EXISTS (
                      SELECT 1 FROM STUDENT_CUMULATIVE SC WHERE SC.stud_id = A.stud_id AND SC.sub_code = B.CLASS_code AND SC.SUBJ_CODE = B.SUB_CODE and sc.academic_year ='$a_y' and sc.term = '$t'
                    )ELECT *
                    FROM STUDENT A
                    JOIN STUDENT_EVALUATION B ON A.STUD_ID = B.STUD_ID
                    WHERE B.S_ID = $sid
                      AND MARK_STATUS = 'ACCEPTED'
                      AND B.CLASS_CODE = $s_code
                      AND B.SUB_CODE = $sub_code
                      AND B.EMP_ID = '$emp_id'
                      and  b.term = '$t'
                 and b.academic_year = '$a_y'
                      AND NOT EXISTS (
                        SELECT 1 FROM STUDENT_CUMULATIVE SC WHERE SC.stud_id = A.stud_id AND SC.sub_code = B.CLASS_code AND SC.SUBJ_CODE = B.SUB_CODE and sc.academic_year ='$a_y' and sc.term = '$t'
                      )
            ";
            $stid = oci_parse($conn, $sql);
            oci_execute($stid);

            if (oci_fetch_all($stid, $ef) > 0) {

                $stid = oci_parse($conn, $sql);
                oci_execute($stid);
                $sql = oci_parse($conn, "SELECT * FROM SUBJECT WHERE SUB_CODE = $sub_code  and subs = $s_code");
                oci_execute($sql);
                if (oci_fetch_all($sql, $a) > 0) {
                    while ($row = oci_fetch_array($stid)) {
                        $stud_id = $row['STUD_ID'];
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
                            <?php echo "STUDENT MARK CUMULATED";
                            header("refresh:2;"); ?>
                        </div> <?php
                            }
                        } else {
                                ?><div style="font-size:15px;
            color: red;
            position: relative;
             display:flex;
            animation:button .3s linear;text-align: center;">
                        <?php echo "SUBJECT NOT ASSIGNED TO CLASS";
                            header("refresh:5;"); ?>
                    </div> <?php
                        }
                    } else {
                            ?><div style="font-size:15px;
                color: red;
                position: relative;
                 display:flex;
                animation:button .3s linear;text-align: center;">
                    <?php echo "NO STUDENT MARK TO CUMULATE";
                        header("refresh:2;"); ?>
                </div> <?php
                    }
                }
                        ?>

        <?php
        $sqll = "SELECT * FROM STUDENT A JOIN STUDENT_CUMULATIVE B ON (A.STUD_ID=B.STUD_ID) JOIN GRADE C ON (B.G_CODE=C.G_CODE) WHERE B.S_ID = $sid and B.sub_code = $s_code and B.subj_code = $sub_code and  B.term = '$t'
        and B.academic_year = '$a_y' order by a.name ";
        //     echo $sqll ;
        $stidD = oci_parse($conn, $sqll);
        oci_execute($stidD);
        ?>
        <div style="display:flex; margin-top:20px;">
            <Label style="font-size: 18px; font-family: righteous;
         font-weight: bold; color: #1D5B79;">Student Cumulated Marks</Label>
        </div>
        <div style="max-height: 200px; overflow-y: auto;">
            <table class="table-content" style="font-size: 14px; border-collapse: collapse; margin: 10px 0; font: 0.9em; min-width: 400px; border-radius: 5px 5px; overflow: hidden; box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);">
                <thead>
                    <tr style="background-color: #1D5B79; color: #ffffff; text-align: left; font-weight: bold;">
                        <th style="padding: 5px 8px; font-size: 10px; margin: 5px;">Student</th>
                        <th style="padding: 5px 8px; font-size: 10px; margin: 5px;">Name</th>
                        <th style="padding: 5px 8px; font-size: 10px; margin: 5px;">Total Mark</th>
                        <th style="padding: 5px 8px; font-size: 10px; margin: 5px;">Grade</th>
                    </tr>
                </thead>
            </table>
        </div>

        <div style="max-height: 200px; overflow-y: auto;">
            <table class="table-content" style="font-size: 14px; border-collapse: collapse; margin: 10px 0; font: 0.9em; min-width: 400px; border-radius: 5px 5px; overflow: hidden; box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);">
                <tbody>
                    <?php
                    while ($row = oci_fetch_array($stidD)) {
                    ?>
                        <tr style="border-bottom: 1px solid #dddddd;">
                            <td><?php echo $row['STUD_ID']; ?></td>
                            <td><?php echo $row['NAME']; ?></td>
                            <td><?php echo $row['MARK']; ?></td>
                            <td><?php echo $row['GRADE']; ?></td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <?php
        require '../vendor/autoload.php';

        use PhpOffice\PhpSpreadsheet\Spreadsheet;
        use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

        if (isset($_POST['generate'])) {
            /*  $query = "select * from class a join sub_class b on (a.class=b.class) where b.s_id = $sid ";
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

                <a class="btnText" href="select_cumulate.php">
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