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
    <form class="container" enctype="multipart/form-data" action="duplicate.php" method="post">
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
        <header>Remove Duplicate Student Records</header>
        <?php
        $sql = "SELECT NAME,STATUS, COUNT(*)
        FROM STUDENT WHERE STATUS != 'GRADUATED' and s_id = $sid
        GROUP BY NAME,STATUS
        HAVING COUNT(*) > 1  ORDER BY NAME ";
        $stidd = oci_parse($conn, $sql);
        oci_execute($stidd);
        ?>
        <div class="input-field" style="margin-right: 10px;">
            <button style=" display: inline-block;
  padding: 6px 12px;
  background-color: #1D5B79;
  color: white;
  border: none;
  border-radius: 4px;
  margin-top:10px;
  margin-bottom:10px;
  text-decoration: none;" name="remove_dup" type="submit">
                REMOVE DUPLICATE
                <i class="uil uil-trash-alt"></i>
            </button>
            <?php
            require('tcpdf/tcpdf.php');
            require '../vendor/autoload.php';

            use PhpOffice\PhpSpreadsheet\Spreadsheet;
            use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

            ?>
        </div>
        <?php
        if (isset($_POST['remove_dup'])) {
        //    oci_rollback($conn);
         /*   $sql = oci_parse($conn, "SELECT NAME,STATUS, COUNT(*)
                    FROM STUDENT WHERE STATUS ='REGISTERED' OR STATUS = 'SEMI-ENROLLED'
                    GROUP BY NAME,STATUS
                    HAVING COUNT(*) > 1  ORDER BY NAME");
            oci_execute($sql);
            while ($row = oci_fetch_array($sql)) {
                $name = $row["NAME"];
                $sql = oci_parse($conn, "SELECT sum(ROWNUM) FROM STUDENT WHERE name = '$name' AND STATUS ='REGISTERED' OR STATUS = 'SEMI-ENROLLED' ");

                oci_execute($sql);
                while ($row = oci_fetch_array($sql)) {
                    $rownum = $row["SUM(ROWNUM)"];
                }
                for ($i = 1; $i < $rownum; $i++) {
                    $sql = oci_parse($conn, "SELECT STUD_ID FROM STUDENT WHERE name = '$name' and rownum = $i AND STATUS ='REGISTERED' OR STATUS = 'SEMI-ENROLLED' ");
                  oci_execute($sql);
                   while ($row = oci_fetch_array($sql)) {
                        $stud_id = $row['STUD_ID'];

                        $sql = oci_parse($conn, "DELETE FROM CLASS_STUDENT WHERE STUD_ID ='$stud_id' ");
                        oci_execute($sql);

                        $sql = oci_parse($conn, "DELETE FROM STUDENT_MEDICAL WHERE STUD_ID ='$stud_id' ");
                        oci_execute($sql);

                        $sql = oci_parse($conn, "DELETE FROM STUDENT_ACADEMIC WHERE STUD_ID ='$stud_id' ");
                        oci_execute($sql);

                        $sql = oci_parse($conn, "DELETE FROM STUDENT_AUTHOURITY WHERE STUD_ID ='$stud_id' ");
                        oci_execute($sql);

                        $sql = oci_parse($conn, "DELETE FROM STUDENT_CONTACT WHERE STUD_ID ='$stud_id' ");
                        oci_execute($sql);

                        $sql = oci_parse($conn, "DELETE FROM STUDENT_PERSONAL WHERE STUD_ID ='$stud_id' ");
                        oci_execute($sql);

                        $sql = oci_parse($conn, "DELETE FROM STUDENT_DOCUMENT WHERE STUD_ID ='$stud_id' ");
                        oci_execute($sql);

                        $sql = oci_parse($conn, "DELETE FROM STUDENT_PERSONAL WHERE STUD_ID ='$stud_id' ");
                        oci_execute($sql);

                        $sql = oci_parse($conn, "DELETE FROM STUDENT_EVALUATION WHERE STUD_ID ='$stud_id' ");
                        oci_execute($sql);

                        $sql = oci_parse($conn, "DELETE FROM STUDENT_FINANCE WHERE STUD_ID ='$stud_id' ");
                        oci_execute($sql);

                        $sql = oci_parse($conn, "DELETE FROM STUDENT_SUBJECT WHERE STUD_ID ='$stud_id' ");
                        oci_execute($sql);

                        $sql = oci_parse($conn, "DELETE FROM STUDENT WHERE STUD_ID ='$stud_id' ");
                        oci_execute($sql);
                    } 
                }
            }
        ?><div style="font-size:15px;
            color: green;
            position: relative;
             display:flex;
             margin-left:10px;
            animation:button .3s linear;text-align: center;">
                <?php echo "STUDENT RECORD DUPLICATES REMOVED";
                  header("refresh:2;");
                ?></div><?php */
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
                <tr style="  background-color: #1D5B79;
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
                        Occurences </th>
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
                            <?php echo $row['COUNT(*)']; ?>

                        </td>
                </tr>
            <?php
                    }
            ?>
            </tr>
            </tbody>
        </table>




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