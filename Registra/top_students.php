<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/show_users.css">
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
    <form class="container" enctype="multipart/form-data" action="top_students.php" method="post">
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
        <header>Top Students</header>
        <?php
        include 'connect.php'; ?>


        <div class="input-field" style="margin-right: 10px;">
            <label>Programme</label>
            <select required name="filter_prog">
                <option disabled selected>Select Programme</option>
                <?php
                $get_hos = "SELECT * FROM PROGRAMME WHERE S_ID = $sid ORDER BY PROG";
                $get = oci_parse(oci_connect($username, $password, $connection), $get_hos);
                oci_execute($get);
                while ($row = oci_fetch_array($get)) {
                ?><option value="<?php echo $row['PROG_ID']; ?>">
                        <?php echo $row["PROG"]; ?>
                    </option> <?php
                            }
                                ?>
            </select>
            <label>Class</label>
            <select required name="filter_class">
                <option disabled selected>Select Class</option>
                <?php
                $get_hos = "SELECT * FROM CLASS WHERE S_ID = $sid ORDER BY CLASS_TITLE";
                $get = oci_parse(oci_connect($username, $password, $connection), $get_hos);
                oci_execute($get);
                while ($row = oci_fetch_array($get)) {
                ?><option value="<?php echo $row['CLASS']; ?>">
                        <?php echo $row["CLASS_TITLE"]; ?>
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
  text-decoration: none;" name="filter" type="submit">
                FILTER PER PROGRAMME
                <i class="uil uil-filter"></i>
            </button>
            <button style=" display: inline-block;
  padding: 6px 12px;
  background-color: #1D5B79;
  color: white;
  border: none;
  border-radius: 4px;
  text-decoration: none;" name="filter_per_class" type="submit">
                FILTER PER CLASS
                <i class="uil uil-filter"></i>
            </button>
        </div>

        </div>
        <div class="input-field" style="margin-right: 10px;">
        <button style=" display: inline-block;
  padding: 6px 12px;
  background-color: #1D5B79;
  color: white;
  border: none;
  border-radius: 4px;
  text-decoration: none;" name="generate_perprog" type="submit">
                 GENERATE REPORT TOP STUDENT PER PROGRAMME
                 <i class="uil uil-file-export"></i>
            </button>
            <button style=" display: inline-block;
  padding: 6px 12px;
  background-color: #1D5B79;
  color: white;
  border: none;
  border-radius: 4px;
  text-decoration: none;" name="generate_perclass" type="submit">
                GENERATE REPORT TOP STUDENT PER CLASS
                <i class="uil uil-file-export"></i>
            </button>
        </div>
        <?php
        if (isset($_POST['filter'])) {
            if (isset($_POST['filter_prog'])) {
                $pid = $_POST['filter_prog'];
                if (isset($_POST['filter_class'])) {
                    $cid = $_POST['filter_class'];

                    echo '<script>
                    Swal.fire({
                        position: "center",
                        icon: "info",
                        title: "FILTERING INFORMATION",
                        showConfirmButton: false,
                        timer: 1500
                      });
                    </script>';

                } else {
                    echo '<script>
                    Swal.fire({
                        position: "center",
                        icon: "warning",
                        title: "SELECT CLASS",
                        showConfirmButton: false,
                        timer: 1500
                      });
                    </script>';
                }
            } else {
                echo '<script>
                Swal.fire({
                    position: "center",
                    icon: "warning",
                    title: "SELECT PROGRAMME",
                    showConfirmButton: false,
                    timer: 1500
                  });
                </script>';
            }
        }
        if (isset($_POST['filter_per_class'])) {
         
                if (isset($_POST['filter_class'])) {
                    $cidd = $_POST['filter_class'];

                    echo '<script>
                    Swal.fire({
                        position: "center",
                        icon: "info",
                        title: "FILTERING INFORMATION",
                        showConfirmButton: false,
                        timer: 1500
                      });
                    </script>';

                } else {
                    echo '<script>
                    Swal.fire({
                        position: "center",
                        icon: "warning",
                        title: "SELECT CLASS",
                        showConfirmButton: false,
                        timer: 1500
                      });
                    </script>';
                }
           
        }
        $sql = "SELECT D.NAME,ROUND(AVG(GPA),2) AS GPA,F.CLASS_TITLE,E.PROG FROM STUDENT_STANDINGS A JOIN SUB_CLASS B ON (A.CLASS_CODE=B.SUB_CODE) JOIN PROG_CLASS C ON (B.SUB_CODE=C.SUB_CODE) JOIN STUDENT D ON (A.STUD_ID=D.STUD_ID) JOIN PROGRAMME E ON (C.PROG_ID=E.PROG_ID) JOIN CLASS F ON (B.CLASS=F.CLASS) WHERE C.PROG_ID = $pid and B.CLASS=$cid  GROUP BY D.NAME,A.GPA,F.CLASS_TITLE,E.PROG ORDER BY A.GPA DESC";
     //   echo $sql;
        $stid = oci_parse($conn, $sql);
        oci_execute($stid);
        ?>
         <Label style="font-size: 18px; font-family: sans-serif;
    font-weight: bold; color: #1D5B79;">Top Student Per Programme Per Class</Label>
             <div style="overflow-x:auto;">
            <table class="table-content" style="font-size: 14px; border-collapse: collapse; margin: 10px 0; font: 0.9em; border-radius: 5px 5px; box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);">
                <thead>
                    <tr style="background-color: #1D5B79; color: #ffffff; text-align: left; font-weight: bold;">
                        <th style="padding: 5px 8px; font-size: 10px; margin: 5px;">Name</th>
                        <th style="padding: 5px 8px; font-size: 10px; margin: 5px;">GPA</th>
                        <th style="padding: 5px 8px; font-size: 10px; margin: 5px;">GRADE</th>
                        <th style="padding: 5px 8px; font-size: 10px; margin: 5px;">PROGRAMME</th>
                    </tr>
                </thead>
            </table>
            <div style="max-height: 200px; overflow-y: auto;">
                <table class="table-content" style="font-size: 14px; border-collapse: collapse; margin: 0; font: 0.9em; min-width: 400px; border-radius: 5px 5px;">
                    <tbody>
                        <?php
                        while ($row = oci_fetch_array($stid)) {
                        ?>
                            <tr style="border-bottom: 1px solid #dddddd;">
                                <td style="padding: 5px 8px; font-size: 10px; margin: 5px;"><?php echo $row['NAME']; ?></td>
                                <td style="padding: 5px 8px; font-size: 10px; margin: 5px;"><?php echo $row['GPA']; ?></td>
                                <td style="padding: 5px 8px; font-size: 10px; margin: 5px;"><?php echo $row['CLASS_TITLE']; ?></td>
                                <td style="padding: 5px 8px; font-size: 10px; margin: 5px;"><?php echo $row['PROG']; ?></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
<?php
        $sql = "SELECT D.NAME,ROUND(AVG(GPA),2) AS GPA,F.CLASS_TITLE FROM STUDENT_STANDINGS A JOIN SUB_CLASS B ON (A.CLASS_CODE=B.SUB_CODE)  JOIN STUDENT D ON (A.STUD_ID=D.STUD_ID) JOIN CLASS F ON (B.CLASS=F.CLASS) WHERE  B.CLASS=$cidd  GROUP BY D.NAME,A.GPA,F.CLASS_TITLE ORDER BY A.GPA DESC";
     //   echo $sql;
        $stidd = oci_parse($conn, $sql);
        oci_execute($stidd);
        ?>
         <Label style="font-size: 18px; font-family: sans-serif;
    font-weight: bold; color: #1D5B79;">Top Student Per Class</Label>
             <div style="overflow-x:auto;">
            <table class="table-content" style="font-size: 14px; border-collapse: collapse; margin: 10px 0; font: 0.9em; border-radius: 5px 5px; box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);">
                <thead>
                    <tr style="background-color: #1D5B79; color: #ffffff; text-align: left; font-weight: bold;">
                        <th style="padding: 5px 8px; font-size: 10px; margin: 5px;">Name</th>
                        <th style="padding: 5px 8px; font-size: 10px; margin: 5px;">GPA</th>
                        <th style="padding: 5px 8px; font-size: 10px; margin: 5px;">GRADE</th>
                       
                    </tr>
                </thead>
            </table>
            <div style="max-height: 200px; overflow-y: auto;">
                <table class="table-content" style="font-size: 14px; border-collapse: collapse; margin: 0; font: 0.9em; min-width: 400px; border-radius: 5px 5px;">
                    <tbody>
                        <?php
                        while ($row = oci_fetch_array($stidd)) {
                        ?>
                            <tr style="border-bottom: 1px solid #dddddd;">
                                <td style="padding: 5px 8px; font-size: 10px; margin: 5px;"><?php echo $row['NAME']; ?></td>
                                <td style="padding: 5px 8px; font-size: 10px; margin: 5px;"><?php echo $row['GPA']; ?></td>
                                <td style="padding: 5px 8px; font-size: 10px; margin: 5px;"><?php echo $row['CLASS_TITLE']; ?></td>
                               
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

            <?php
          //  require('tcpdf/tcpdf.php');
            require '../vendor/autoload.php';

            use PhpOffice\PhpSpreadsheet\Spreadsheet;
            use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
if(isset($_POST['generate_perprog'])){
    if (isset($_POST['filter_prog'])) {
        $pid = $_POST['filter_prog'];
        if (isset($_POST['filter_class'])) {
            $cid = $_POST['filter_class'];
            $query = "SELECT D.NAME,ROUND(AVG(GPA),2) AS GPA,F.CLASS_TITLE,E.PROG FROM STUDENT_STANDINGS A JOIN SUB_CLASS B ON (A.CLASS_CODE=B.SUB_CODE) JOIN PROG_CLASS C ON (B.SUB_CODE=C.SUB_CODE) JOIN STUDENT D ON (A.STUD_ID=D.STUD_ID) JOIN PROGRAMME E ON (C.PROG_ID=E.PROG_ID) JOIN CLASS F ON (B.CLASS=F.CLASS) WHERE C.PROG_ID = $pid and B.CLASS=$cid  GROUP BY D.NAME,A.GPA,F.CLASS_TITLE,E.PROG ORDER BY A.GPA DESC";
            // Prepare and execute the query
            $statement = oci_parse($conn, $query);
            oci_execute($statement);
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setCellValue('A1', 'NAME');
            $sheet->setCellValue('B1', 'STUDENT GPA');
            $sheet->setCellValue('C1', 'CLASS');
            $sheet->setCellValue('D1', 'STREAM');
            $directoryPath = 'C:\ACADEMIX\\' . $school . '\generated_reports\class_list\\';
            if (!is_dir($directoryPath)) {
                if (!mkdir($directoryPath, 0777, true)) {
                    die('Failed to create directories.');
                }
            }
            $filePath = $directoryPath . 'class.xlsx';

            $row = 2;
            while ($row_data = oci_fetch_assoc($statement)) {
                $sheet->setCellValue('A' . $row, $row_data['NAME']);
                $sheet->setCellValue('B' . $row, $row_data['GPA']);
                $sheet->setCellValue('C' . $row, $row_data['CLASS_TITLE']);
                $sheet->setCellValue('D' . $row, $row_data['PROG']);
                $row++;
            }
            $writer = new Xlsx($spreadsheet);
            // Output the Excel file
            $writer->save($filePath);
            $_SESSION['path'] = $filePath;
            $_SESSION['file'] = 'TOP STUDENTS PER PROGRAMME.xlsx';
            $_SESSION['redirect'] = 'top_students.php';
            header('Location: download_excel.php');
            ?><div style="font-size:15px;
color: green;
position: relative;
display:flex;
animation:button .3s linear;text-align: center;">
        <?php echo "CLASS LIST FOR $class_name GENERATED";
            header("refresh:2;"); ?>
    </div> <?php
            // Close the Oracle connection
            oci_free_statement($statement);
            oci_close($conn);
          

        } else {
            echo '<script>
            Swal.fire({
                position: "center",
                icon: "warning",
                title: "SELECT CLASS",
                showConfirmButton: false,
                timer: 1500
              });
            </script>';
        }
    } else {
        echo '<script>
        Swal.fire({
            position: "center",
            icon: "warning",
            title: "SELECT PROGRAMME",
            showConfirmButton: false,
            timer: 1500
          });
        </script>';
    }
    /* 
    
    */
}
if(isset($_POST['generate_perclass'])){
    if (isset($_POST['filter_class'])) {
        $cidd = $_POST['filter_class'];
        $query = "SELECT D.NAME,ROUND(AVG(GPA),2) AS GPA,F.CLASS_TITLE FROM STUDENT_STANDINGS A JOIN SUB_CLASS B ON (A.CLASS_CODE=B.SUB_CODE)  JOIN STUDENT D ON (A.STUD_ID=D.STUD_ID) JOIN CLASS F ON (B.CLASS=F.CLASS) WHERE  B.CLASS=$cidd  GROUP BY D.NAME,A.GPA,F.CLASS_TITLE ORDER BY A.GPA DESC";
        // Prepare and execute the query
        $statement = oci_parse($conn, $query);
        oci_execute($statement);
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'NAME');
        $sheet->setCellValue('B1', 'STUDENT GPA');
        $sheet->setCellValue('C1', 'CLASS');
    
        $directoryPath = 'C:\ACADEMIX\\' . $school . '\generated_reports\class_list\\';
        if (!is_dir($directoryPath)) {
            if (!mkdir($directoryPath, 0777, true)) {
                die('Failed to create directories.');
            }
        }
        $filePath = $directoryPath . 'class.xlsx';

        $row = 2;
        while ($row_data = oci_fetch_assoc($statement)) {
            $sheet->setCellValue('A' . $row, $row_data['NAME']);
            $sheet->setCellValue('B' . $row, $row_data['GPA']);
            $sheet->setCellValue('C' . $row, $row_data['CLASS_TITLE']);
         
            $row++;
        }
        $writer = new Xlsx($spreadsheet);
        // Output the Excel file
        $writer->save($filePath);
        $_SESSION['path'] = $filePath;
        $_SESSION['file'] = 'TOP STUDENTS PER CLASS.xlsx';
        $_SESSION['redirect'] = 'top_students.php';
        header('Location: download_excel.php');
        ?><div style="font-size:15px;
color: green;
position: relative;
display:flex;
animation:button .3s linear;text-align: center;">
    <?php echo "CLASS LIST FOR $class_name GENERATED";
        header("refresh:2;"); ?>
</div> <?php
        // Close the Oracle connection
        oci_free_statement($statement);
        oci_close($conn);
       

    } else {
        echo '<script>
        Swal.fire({
            position: "center",
            icon: "warning",
            title: "SELECT CLASS",
            showConfirmButton: false,
            timer: 1500
          });
        </script>';
    }
}
                                    ?>


                    <?php


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