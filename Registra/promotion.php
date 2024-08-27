<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/show_users.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <!-- Option 1: Include in HTML -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
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
$class = '';
$school =  $_SESSION['school'];
$sid = $_SESSION['sid'];
$c = $_SESSION['class'] = $c;
$n_c = $_SESSION['next_class'];
$currennt_class = $_SESSION['C_class'];
$sub_title =  $_SESSION['sub_t'];
$s_code = $_SESSION['s_code'];
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

?>

<body>
    <form class="container" enctype="multipart/form-data" action="promotion.php" method="post">
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
        <header>Promotion</header>
        <?php
        include 'connect.php';
        $sql = oci_parse($conn, "select * from academic_calendar a join term_calendar b on (a.academic_year=b.academic_year) where b.start_dt is not null order by b.term desc");
        oci_execute($sql);
        if ($row = oci_fetch_array($sql)) {
            $a_y = $row['ACADEMIC_YEAR'];
            $t = $row['TERM'];
        }

        ?>
        <div class="input-container" style="display: flex;">
            <div class="input-field" style="margin-right: 10px;">
                <label>Academic Year</label>
                <input type="text" placeholder="<?php echo $a_y ?>" style="width:300px;" readonly>
            </div>
            <div class="input-field" style="margin-right: 10px;">
                <label>Current Class</label>
                <input type="text" placeholder="<?php echo $currennt_class ?>" style="width:300px;" readonly>
            </div>


        </div>
        <?php //echo "select * from CLASS WHERE S_ID= $sid and  class = 10 or class = 11 order by class"; 
        ?>

        <div class="input-field" style="margin-right: 10px;">


            <?php //echo "select DISTINCT(B.CLASS_NAME),B.SUB_CODE from CLASS a join sub_class b on (a.class=b.class) join class_student c on (b.sub_code=c.sub_code) join student d on (c.stud_id=d.stud_id) where a.class = '$next_class' and  b.SUB_CODE != 286 AND b.SUB_CODE != 290 AND b.SUB_CODE != 141 ORDER BY b.CLASS_NAME"; 
            ?>
            <label>Promoting Class</label>
            <select required name="class_name">
                <option disabled selected>Select Class Name</option>
                <?php
                $class = $_SESSION['fil_class'];
                $get_hos = "select DISTINCT(B.CLASS_NAME),B.SUB_CODE from CLASS a join sub_class b on (a.class=b.class) where a.class = '$n_c' and  b.SUB_CODE != 286 AND b.SUB_CODE != 290 AND b.SUB_CODE != 141 ORDER BY b.CLASS_NAME ";
                $get = oci_parse(oci_connect($username, $password, $connection), $get_hos);
                oci_execute($get);
                while ($row = oci_fetch_array($get)) {
                ?><option value="<?php echo $row["SUB_CODE"]; ?> ">
                        <?php echo $row["CLASS_NAME"]; ?>
                    </option> <?php
                            }
                                ?>
            </select>
            <button style=" display: inline-block;
  padding: 6px 12px;
  background-color: #1D5B79;
  color: white;
  border: none;
  border-radius: 4px;
  margin-top:10px;
  margin-bottom:10px;
  text-decoration: none;" name="promote" type="submit">
                PROMOTE
                <i class="bi bi-card-checklist"></i>
            </button>
            <?php
            if (isset($_POST['promote'])) {
                $sql = oci_parse($conn, "SELECT COUNT(STUD_ID) AS TOTAL FROM CLASS_STUDENT WHERE SUB_CODE = '$s_code' ");
                oci_execute($sql);

                while ($r = oci_fetch_array($sql)) {
                    $count = $r['TOTAL'];
                }
                $_SESSION['count'] = $count;
                if (isset($_POST['class_name'])) {


                    $code = $_POST['class_name'];
                    $sql = "SELECT ROUND(AVG(GPA),2) AS GPA, STUD_ID 
                FROM STUDENT_STANDINGS 
                WHERE STUD_ID IN (
                    SELECT STUD_ID 
                    FROM CLASS_STUDENT 
                    WHERE SUB_CODE = :s_code
                ) 
                AND CLASS_CODE = :s_code 
                GROUP BY STUD_ID";

                    // Parse the SELECT statement
                    $stmt = oci_parse($conn, $sql);

                    // Bind parameters
                    oci_bind_by_name($stmt, ':s_code', $s_code);
                    //   oci_bind_by_name($stmt, ':a_y', $a_y);

                    // Execute the SELECT statement
                    oci_execute($stmt);

                    // Loop through the results
                    while ($r = oci_fetch_array($stmt, OCI_ASSOC)) {
                        $gpa = $r['GPA'];
                        $st = $r['STUD_ID'];
                        $sql = oci_parse($conn, "SELECT * 
FROM STUDENT_CUMULATIVE A JOIN GRADE B ON (A.G_CODE=B.G_CODE)
WHERE A.STUD_ID = '$st' and A.SUB_CODE = $s_code 
  AND A.SUBJ_CODE IN (126) AND A.MARK >= 40  AND ACADEMIC_YEAR =  '$a_y' ");
                        oci_execute($sql);
                        // Check the GPA and update if needed
                        if ($gpa > 1.4 && oci_fetch_all($sql, $a) > 1) {
                            // Prepare the UPDATE statement
                            $update_sql = "UPDATE CLASS_STUDENT 
                               SET SUB_CODE = :code 
                               WHERE STUD_ID = :st";

                            // Parse the UPDATE statement
                            $update_stmt = oci_parse($conn, $update_sql);

                            // Bind parameters
                            oci_bind_by_name($update_stmt, ':code', $code);
                            oci_bind_by_name($update_stmt, ':st', $st);

                            // Execute the UPDATE statement
                            oci_execute($update_stmt);

                            $sql = oci_parse($conn, "INSERT INTO PROMOTION (STUD_ID,PREV_CLASS,PROMOTED_CLASS,ACADEMIC_YEAR,GPA,CURRENT_CLASS) VALUES (:ID,:PRV,:PRO,:A_Y,:GPA,:CURRENT_CLASS)");
                            oci_bind_by_name($sql, ":ID", $st);
                            oci_bind_by_name($sql, ":PRV", $s_code);
                            oci_bind_by_name($sql, ":PRO", $code);
                            oci_bind_by_name($sql, ":GPA", $gpa);
                            oci_bind_by_name($sql, ":A_Y", $a_y);
                            oci_bind_by_name($sql, ":CURRENT_CLASS", $currennt_class);
                            oci_execute($sql);
                        }
                    }
                         echo '<script>
                  Swal.fire({
                      position: "center",
                      icon: "success",
                      title: "PROMOTION COMPLETE",
                      showConfirmButton: false,
                      timer: 1500
                    });
                  </script>'; 



                    $getcount = oci_parse($conn, "SELECT COUNT(STUD_ID) AS COUNTER FROM PROMOTION WHERE ACADEMIC_YEAR = '$a_y' AND PROMOTED_CLASS =$code and prev_class = $s_code and current_class = '$currennt_class' ");
                    oci_execute($getcount);
                    while ($r = oci_fetch_array($getcount)) {
                        $_SESSION['counter'] = $r['COUNTER'];
                    }
                } else {
                    echo '<script>
															Swal.fire({
																position: "center",
																icon: "warning",
																title: "SELECT PROMOTING CLASS",
																showConfirmButton: false,
																timer: 1500
															  });
															</script>';
                }
            }
            ?>
            <button style=" display: inline-block;
  padding: 6px 12px;
  background-color: #1D5B79;
  color: white;
  border: none;
  border-radius: 4px;
  margin-top:10px;
  margin-bottom:10px;
  text-decoration: none;" name="download" type="submit">
                GENERATE AND DOWNLOAD PROMOTION REPORT
                <i class="bi bi-box-arrow-down"></i>
            </button>
            <button style=" display: inline-block;
  padding: 6px 12px;
  background-color: #1D5B79;
  color: white;
  border: none;
  border-radius: 4px;
  margin-top:10px;
  margin-bottom:10px;
  text-decoration: none;" name="refresh" type="submit">
                REFRESH
                <i class="bi bi-arrow-clockwise"></i>
            </button>
            <?php
            require '../vendor/autoload.php';

            use PhpOffice\PhpSpreadsheet\Spreadsheet;
            use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

            if (isset($_POST['download'])) {

                $query = "SELECT 
                    A.NAME,
                    B.ACADEMIC_YEAR,
                    B.GPA,
                    B.CURRENT_CLASS ,
                    C.CLASS_NAME
                FROM 
                    STUDENT A
                JOIN 
                    PROMOTION B ON A.STUD_ID = B.STUD_ID
                JOIN 
                    SUB_CLASS C ON B.PROMOTED_CLASS = C.SUB_CODE WHERE B.ACADEMIC_YEAR = '$a_y' AND B.CURRENT_CLASS = '$currennt_class'
                ORDER BY 
                    B.GPA DESC";
                $counter = $_SESSION['counter'];
                //   echo $query;
                // Prepare and execute the query
                $statement = oci_parse($conn, $query);
                oci_execute($statement);
                $spreadsheet = new Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();
                $sheet->setCellValue('A1', 'STUDENT');
                $sheet->setCellValue('B1', 'ACADEMIC YEAR');
                $sheet->setCellValue('C1', 'GPA');
                $sheet->setCellValue('D1', 'CURRENT CLASS');
                $sheet->setCellValue('E1', 'PROMOTED CLASS');
                $sheet->setCellValue('F1', 'TOTAL NUMBER OF STUDENTS IN THE CLASS BEFORE PROMOTION');
                $sheet->setCellValue('G1', 'TOTAL NUMBER OF STUDENTS PROMOTED');
                $directoryPath = 'C:\ACADEMIX\\' . $school . '\generated_reports\promotion\\';
                if (!is_dir($directoryPath)) {
                    if (!mkdir($directoryPath, 0777, true)) {
                        die('Failed to create directories.');
                    }
                }
                $filePath = $directoryPath . 'class.xlsx';

                $row = 2;

                while ($row_data = oci_fetch_assoc($statement)) {
                    $sheet->setCellValue('A' . $row, $row_data['NAME']);
                    $sheet->setCellValue('B' . $row, $row_data['ACADEMIC_YEAR']);
                    $sheet->setCellValue('C' . $row, $row_data['GPA']);
                    $sheet->setCellValue('D' . $row, $row_data['CURRENT_CLASS']);
                    $sheet->setCellValue('E' . $row, $row_data['CLASS_NAME']);
                    $row++;
                }
                $count = $_SESSION['count'];
                $sheet->setCellValue('F' . 2, $count);
                $sheet->setCellValue('G' . 2, $counter);
                $writer = new Xlsx($spreadsheet);
                // Output the Excel file
                $writer->save($filePath);

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
                      title: "REPORT GENERATION COMPLETE",
                      showConfirmButton: false,
                      timer: 1500
                    });
                  </script>';

                    $_SESSION['path'] = $filePath;
                    $_SESSION['file'] = 'PROMOTION LIST FOR ' . $currennt_class . '.xlsx';
                    $_SESSION['redirect'] = 'promotion.php';
                    header('Location: download_excel.php');
                    header("refresh:2;"); ?>
                </div> <?php
                        // Close the Oracle connection
                        oci_free_statement($statement);
                        oci_close($conn);
                    }
                    if (isset($_POST['refresh'])) {
                        header("refresh:2;");
                    }
                        ?>
        </div>
        <div class="buttons">

            <button class="backBtn" type="submit">

                <a class="btnText" href="select_promote.php">
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