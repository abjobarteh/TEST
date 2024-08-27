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
    <form class="container" enctype="multipart/form-data" action="show_class.php" method="post">
        <div class="com">
            <h3 style="color: #04716f;">Academix: School Management System</h3>
            <h3 class="title" style="justify-content:center; text-align:center; color: #04716f; 	font-size: 18px;"><?php echo $school ?>
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
        <header>Class</header>
        <?php
        include 'connect.php';

        if ($conn) {
            $sql = "select * from sub_class WHERE S_ID= $sid 
            AND SUB_TITLE NOT LIKE 'AISHA' and SUB_CODE  != 286 AND SUB_CODE  != 290 AND  SUB_CODE  != 202 AND  SUB_CODE  != 291 AND  SUB_CODE  != 122 AND  SUB_CODE  != 242 AND  SUB_CODE  != 103  ORDER BY CLASS_NAME";
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
        <div style="overflow-x:auto;">
            <table class="table-content" style="font-size: 14px; border-collapse: collapse; margin: 10px 0; font: 0.9em; border-radius: 5px 5px; box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);">
                <thead>
                    <tr style="background-color: #04716f; color: #ffffff; text-align: left; font-weight: bold;">
                        <th style="padding: 5px 8px; font-size: 10px; margin: 5px;">Class</th>
                        <th style="padding: 5px 8px; font-size: 10px; margin: 5px;">Class Title</th>
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
                                <td style="padding: 5px 8px; font-size: 10px; margin: 5px;"><?php echo $row['CLASS']; ?></td>
                                <td style="padding: 5px 8px; font-size: 10px; margin: 5px;"><?php echo $row['CLASS_NAME']; ?></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

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
  text-decoration: none;" name="filter" type="submit">
                FILTER
                <i class="uil uil-filter"></i>
            </button>
        </div>

        </div>
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
                        Class Title</th>
                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Sub Class Title</th>
                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Class Name</th>
                </tr>
            </thead>
            <tbody>
                <tr style=" border-bottom: 1px solid #dddddd;">
                    <?php
                    while ($row = oci_fetch_array($stid)) {
                    ?>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['CLASS_TITLE']; ?>

                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['SUB_TITLE']; ?>

                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['CLASS_NAME']; ?>

                        </td>
                </tr>
            <?php
                    }
            ?>
            </tr>
            </tbody>
        </table>
        <label>Generate Class Report</label>

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
                <option>PDF</option>
            
            </select>
            <label>Class Name</label>
            <select required name="class_name">
                <option disabled selected>Select Class Name</option>
                <?php
                $class = $_SESSION['fil_class'];
                $get_hos = "select * from CLASS a join sub_class b on (a.class=b.class) where a.class_title = '$class'  and  b.SUB_TITLE != 'UMAR 1' AND b.SUB_TITLE NOT LIKE 'AISHA' and b.SUB_CODE  != 286 AND b.SUB_CODE  != 290 AND  b.SUB_CODE  != 202 AND  b.SUB_CODE  != 291 AND  b.SUB_CODE  != 122 AND  b.SUB_CODE  != 242 AND  b.SUB_CODE  != 103  ORDER BY b.CLASS_NAME ";
                $get = oci_parse(oci_connect($username, $password, $connection), $get_hos);
                oci_execute($get);
                while ($row = oci_fetch_array($get)) {
                ?><option>
                        <?php echo $row["CLASS_NAME"]; ?>
                    </option> <?php
                            }
                                ?>
            </select>


            <label>Generate By Gender</label>
            <select required name="gender">
                <option disabled selected>Select Gender</option>
                <option>MALE</option>
                <option>FEMALE</option>
            </select>

            <button style=" display: inline-block;
  padding: 6px 12px;
  background-color: #04716f;
  color: white;
  border: none;
  border-radius: 4px;
  margin-top:10px;
  margin-bottom:10px;
  text-decoration: none;" name="generate_classlist" type="submit">
                GENERATE REPORT OF CLASS LIST
                <i class="uil uil-file-export"></i>
            </button>
            <?php
            require('tcpdf/tcpdf.php');
            require '../vendor/autoload.php';

            use PhpOffice\PhpSpreadsheet\Spreadsheet;
            use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

            if (isset($_POST['generate_classlist'])) {
                if (isset($_POST['report_type'])) {
                    $rpt_type = $_POST['report_type'];
                    if ($rpt_type == 'PDF') {
                        if (isset($_POST['class_name'])) {
                            $class_name = $_POST['class_name'];
                            $sql = oci_parse($conn, "select * from sub_class where class_name = '$class_name' ");
                            oci_execute($sql);
                            while ($r = oci_fetch_array($sql)) {
                                $sub_code = $r['SUB_CODE'];
                            }
                            if (isset($_POST['gender'])) {
                                $gender = $_POST['gender'];
                                /*         $get_hos = "select * from sub_class where class_name = '$reg' and s_id = $sid ";
                                $get = oci_parse(oci_connect($username, $password, $connection), $get_hos);
                                oci_execute($get);
                                if ($row = oci_fetch_array($get)) {
                                    $class = $row['CLASS'];
                                    $cc = $row['SUB_CODE'];
                                } */
                                $stmt = oci_parse($conn, "select a.region,b.district,c.school,c.address,c.phone_one,c.phone_two,c.email,c.logo from region a join district b on (a.reg_code=b.reg_code) join school c on (b.dis_code=c.dis_code) where c.s_id =:sid  ");
                                oci_bind_by_name($stmt, ':sid', $sid);
                                oci_execute($stmt);
                                while ($row = oci_fetch_array($stmt)) {
                                    $region = $row['REGION'];
                                    $district = $row['DISTRICT'];
                                    $school = $row['SCHOOL'];
                                    $address = $row['ADDRESS'];
                                    $phone_one = $row['PHONE_ONE'];
                                    $phone_two = $row['PHONE_TWO'];
                                    $email = $row['EMAIL'];
                                    $imageData = $row['LOGO']->load(); // Load OCILob data
                                    $decodedContent = base64_decode($imageData);
                                    $saveDirectory = 'C:/wamp64/www/Academix/Sec_Registra/img/';
                                    $fileName = "school logo.png";
                                    if (!is_dir($saveDirectory)) {
                                        mkdir($saveDirectory, 0777, true); // Specify the appropriate permissions
                                    }
                                    $filePath = $saveDirectory . $fileName;
                                    file_put_contents($filePath, $imageData);
                                }
                                $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
                                $pdf->AddPage();
                                $pdf->SetHeaderMargin(0); // Set the header margin to zero
                                $pdf->setPrintHeader(false);
                                $pdf->setPrintFooter(false);
                                $pdf->SetFont('helvetica', '', 10);
                                $pdf->SetTextColor(29, 91, 121);
                                $pdf->SetFont('helvetica', 'B', 15);
                                $pdf->Cell(0, 130, 'CLASS LIST FOR ' . $class_name, 0, 1, 'L');
                                $pdf->Ln();
                                $logoPath  = 'img/school logo.png';
                                $pdf->Image($logoPath, 170, 15, 30, 35);
                                $pdf->Image($logoPath, 170, 15, 30, 35);
                                $pdf->SetTextColor(29, 91, 121);
                                $pdf->SetFont('dejavusans', '', 6.5);
                                $companyInfo = "$school\n$address\n$district\n$region\nThe Gambia\n$email\nTel: $phone_one/ $phone_two";
                                $pdf->SetXY(140, 60);
                                $pdf->MultiCell(0, 9, $companyInfo, 0, 'R');

                                $invoiceTitleBottomY = $pdf->GetY();

                                $pdf->SetY($invoiceTitleBottomY + 5);
                                $pdf->Cell(10, 10, 'Date:', 0, 0);
                                $pdf->Cell(0, 10, date('Y-m-d'), 0, 1);

                                $s = "SELECT DISTINCT(A.STUD_ID),B.FIRSTNAME,B.MIDDLENAME,B.LASTNAME FROM academix.STUDENT A JOIN academix.STUDENT_PERSONAL B ON(A.STUD_ID=B.STUD_ID) JOIN academix.CLASS_STUDENT C ON (A.STUD_ID=C.STUD_ID) WHERE C.SUB_CODE = $sub_code and c.s_id = $sid and b.gender ='$gender' ORDER  BY  A.STUD_ID";
                                $stmts = oci_parse($conn, $s);
                                oci_execute($stmts);

                                $pdf->SetFont('courier', 'B', 14); // Set a larger font size for the heading
                                $pdf->Cell(0, 10, 'Class List', 0, 1, 'C'); // Centered heading

                                $pdf->Cell(40, 10, 'Student ID', 0, 0, 'C');
                                $pdf->Cell(50, 10, 'First Name', 0, 0, 'C');
                                $pdf->Cell(50, 10, 'Middle Name', 0, 0, 'C');
                                $pdf->Cell(50, 10, 'Last Name', 0, 1, 'C');

                                // Table content without borders
                                $pdf->SetFont('courier', '', 10); // Reset font style
                                while ($row = oci_fetch_assoc($stmts)) {
                                    $st = trim($row['STUD_ID']);
                                    $f = trim($row['FIRSTNAME']);
                                    $m = trim($row['MIDDLENAME']);
                                    $n = trim($row['LASTNAME']);

                                    $pdf->Cell(40, 10, $st, 0, 0, 'C');
                                    $pdf->Cell(50, 10, $f, 0, 0, 'C');
                                    $pdf->Cell(50, 10, $m, 0, 0, 'C');
                                    $pdf->Cell(50, 10, $n, 0, 1, 'C');
                                }
                                /*    $pdf->SetFont('courier', 'B', 10);
                                /*      $pdf->Cell(30, 10, 'Student ID:', 0, 0, 'C');
                                $pdf->Cell(30, 10, 'First Name:', 0, 0, 'C');
                                $pdf->Cell(30, 10, 'Middle Name:', 0, 0, 'C');
                                $pdf->Cell(30, 10, 'Last Name:', 0, 0, 'C'); 

                                while ($row = oci_fetch_array($stmts)) {
                                    $studId = $row['STUD_ID'];
                                    $firstName = $row['FIRSTNAME'];
                                    $middleName = $row['MIDDLENAME'];
                                    $lastName = $row['LASTNAME'];
                                    $pdf->Cell(0, 10, $studId, 0, 1, 'C');


                                    $pdf->Cell(0, 10, $firstName, 0, 1, 'C');


                                    $pdf->Cell(0, 10, $middleName, 0, 1, 'C');


                                    $pdf->Cell(0, 10, $lastName, 0, 1, 'C');
                                }

*/
                                // Set the Y-coordinate below the table for the total
                                $pdf->SetY($pdf->GetY() + 10); // You may need to adjust the value based on your layout

                                // Output the total on the far right
                                $disclaimer = "owered By NIFTY ICT SOLUTIONS LIMITED";
                                $pdf->SetFont('dejavusans', 'I', 8);
                                $pdf->Cell(0, 5, $disclaimer, 0, 0, 'C');
                                $directoryPath = 'C:\ACADEMIX\\' . $school . '\generated_reports\class_list\\';
                                if (!is_dir($directoryPath)) {
                                    if (!mkdir($directoryPath, 0777, true)) {
                                        die('Failed to create directories.');
                                    }
                                }
                                $filePath = $directoryPath . 'CLASS.pdf';
                                $pdf->Output($filePath, 'F'); // 'F' parameter saves to a file
            ?><div style="font-size:15px;
                                color: green;
                                position: relative;
                                 display:flex;
                                animation:button .3s linear;text-align: center;">
                                <?php echo "CLASS LIST FOR $class_name GENERATED";
                                header("refresh:2;");
                            } else {
                                /*         $get_hos = "select * from sub_class where class_name = '$reg' and s_id = $sid ";
                                $get = oci_parse(oci_connect($username, $password, $connection), $get_hos);
                                oci_execute($get);
                                if ($row = oci_fetch_array($get)) {
                                    $class = $row['CLASS'];
                                    $cc = $row['SUB_CODE'];
                                } */
                                $stmt = oci_parse($conn, "select a.region,b.district,c.school,c.address,c.phone_one,c.phone_two,c.email,c.logo from region a join district b on (a.reg_code=b.reg_code) join school c on (b.dis_code=c.dis_code) where c.s_id =:sid  ");
                                oci_bind_by_name($stmt, ':sid', $sid);
                                oci_execute($stmt);
                                while ($row = oci_fetch_array($stmt)) {
                                    $region = $row['REGION'];
                                    $district = $row['DISTRICT'];
                                    $school = $row['SCHOOL'];
                                    $address = $row['ADDRESS'];
                                    $phone_one = $row['PHONE_ONE'];
                                    $phone_two = $row['PHONE_TWO'];
                                    $email = $row['EMAIL'];
                                    $imageData = $row['LOGO']->load(); // Load OCILob data
                                    $decodedContent = base64_decode($imageData);
                                    $saveDirectory = 'C:/wamp64/www/Academix/Sec_Registra/img/';
                                    $fileName = "school logo.png";
                                    if (!is_dir($saveDirectory)) {
                                        mkdir($saveDirectory, 0777, true); // Specify the appropriate permissions
                                    }
                                    $filePath = $saveDirectory . $fileName;
                                    file_put_contents($filePath, $imageData);
                                }
                                $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
                                $pdf->AddPage();
                                $pdf->SetHeaderMargin(0); // Set the header margin to zero
                                $pdf->setPrintHeader(false);
                                $pdf->setPrintFooter(false);
                                $pdf->SetFont('helvetica', '', 10);
                                $pdf->SetTextColor(29, 91, 121);
                                $pdf->SetFont('helvetica', 'B', 15);
                                $pdf->Cell(0, 130, 'CLASS LIST FOR ' . $class_name, 0, 1, 'L');
                                $pdf->Ln();
                                $logoPath  = 'img/school logo.png';
                                $pdf->Image($logoPath, 170, 15, 30, 35);
                                $pdf->Image($logoPath, 170, 15, 30, 35);
                                $pdf->SetTextColor(29, 91, 121);
                                $pdf->SetFont('dejavusans', '', 6.5);
                                $companyInfo = "$school\n$address\n$district\n$region\nThe Gambia\n$email\nTel: $phone_one/ $phone_two";
                                $pdf->SetXY(140, 60);
                                $pdf->MultiCell(0, 9, $companyInfo, 0, 'R');

                                $invoiceTitleBottomY = $pdf->GetY();

                                $pdf->SetY($invoiceTitleBottomY + 5);
                                $pdf->Cell(10, 10, 'Date:', 0, 0);
                                $pdf->Cell(0, 10, date('Y-m-d'), 0, 1);

                                $s = "SELECT DISTINCT(A.STUD_ID),B.FIRSTNAME,B.MIDDLENAME,B.LASTNAME FROM academix.STUDENT A JOIN academix.STUDENT_PERSONAL B ON(A.STUD_ID=B.STUD_ID) JOIN academix.CLASS_STUDENT C ON (A.STUD_ID=C.STUD_ID) WHERE C.SUB_CODE = $sub_code and c.s_id = $sid ORDER  BY  A.STUD_ID";
                                $stmts = oci_parse($conn, $s);
                                oci_execute($stmts);

                                $pdf->SetFont('courier', 'B', 14); // Set a larger font size for the heading
                                $pdf->Cell(0, 10, 'Class List', 0, 1, 'C'); // Centered heading

                                $pdf->Cell(40, 10, 'Student ID', 0, 0, 'C');
                                $pdf->Cell(50, 10, 'First Name', 0, 0, 'C');
                                $pdf->Cell(50, 10, 'Middle Name', 0, 0, 'C');
                                $pdf->Cell(50, 10, 'Last Name', 0, 1, 'C');

                                // Table content without borders
                                $pdf->SetFont('courier', '', 10); // Reset font style
                                while ($row = oci_fetch_assoc($stmts)) {
                                    $st = trim($row['STUD_ID']);
                                    $f = trim($row['FIRSTNAME']);
                                    $m = trim($row['MIDDLENAME']);
                                    $n = trim($row['LASTNAME']);

                                    $pdf->Cell(40, 10, $st, 0, 0, 'C');
                                    $pdf->Cell(50, 10, $f, 0, 0, 'C');
                                    $pdf->Cell(50, 10, $m, 0, 0, 'C');
                                    $pdf->Cell(50, 10, $n, 0, 1, 'C');
                                }
                                /*    $pdf->SetFont('courier', 'B', 10);
                                /*      $pdf->Cell(30, 10, 'Student ID:', 0, 0, 'C');
                                $pdf->Cell(30, 10, 'First Name:', 0, 0, 'C');
                                $pdf->Cell(30, 10, 'Middle Name:', 0, 0, 'C');
                                $pdf->Cell(30, 10, 'Last Name:', 0, 0, 'C'); 

                                while ($row = oci_fetch_array($stmts)) {
                                    $studId = $row['STUD_ID'];
                                    $firstName = $row['FIRSTNAME'];
                                    $middleName = $row['MIDDLENAME'];
                                    $lastName = $row['LASTNAME'];
                                    $pdf->Cell(0, 10, $studId, 0, 1, 'C');


                                    $pdf->Cell(0, 10, $firstName, 0, 1, 'C');


                                    $pdf->Cell(0, 10, $middleName, 0, 1, 'C');


                                    $pdf->Cell(0, 10, $lastName, 0, 1, 'C');
                                }

*/
                                // Set the Y-coordinate below the table for the total
                                $pdf->SetY($pdf->GetY() + 10); // You may need to adjust the value based on your layout

                                // Output the total on the far right
                                $disclaimer = "This class list was generated by $school";
                                $pdf->SetFont('dejavusans', 'I', 8);
                                $pdf->Cell(0, 5, $disclaimer, 0, 0, 'C');
                                $directoryPath = 'C:\ACADEMIX\\' . $school . '\generated_reports\class_list\\';
                                if (!is_dir($directoryPath)) {
                                    if (!mkdir($directoryPath, 0777, true)) {
                                        die('Failed to create directories.');
                                    }
                                }
                                $filePath = $directoryPath . 'CLASS.pdf';
                                $pdf->Output($filePath, 'F'); // 'F' parameter saves to a file
                                ?><div style="font-size:15px;
                                color: green;
                                position: relative;
                                 display:flex;
                                animation:button .3s linear;text-align: center;">
                                    <?php echo "CLASS LIST FOR $class_name GENERATED";
                                    header("refresh:2;");
                                }
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
                                    } else if ($rpt_type == 'EXCEL') {
                                        if (isset($_POST['class_name'])) {
                                            $class_name = $_POST['class_name'];
                                            $sql = oci_parse($conn, "select * from sub_class where class_name = '$class_name' ");
                                            oci_execute($sql);
                                            while ($r = oci_fetch_array($sql)) {
                                                $sub_code = $r['SUB_CODE'];
                                            }
                                            if (isset($_POST['gender'])) {
                                                $gender = $_POST['gender'];
                                                $query = "SELECT DISTINCT(A.STUD_ID),B.FIRSTNAME,B.MIDDLENAME,B.LASTNAME FROM STUDENT A JOIN STUDENT_PERSONAL B ON(A.STUD_ID=B.STUD_ID) JOIN CLASS_STUDENT C ON (A.STUD_ID=C.STUD_ID) WHERE C.SUB_CODE = $sub_code and c.s_id = $sid and b.gender ='$gender' ORDER  BY  A.STUD_ID";
                                                // Prepare and execute the query
                                                $statement = oci_parse($conn, $query);
                                                oci_execute($statement);
                                                $spreadsheet = new Spreadsheet();
                                                $sheet = $spreadsheet->getActiveSheet();
                                                $sheet->setCellValue('A1', 'STUDENT ID');
                                                $sheet->setCellValue('B1', 'FIRSTNAME');
                                                $sheet->setCellValue('C1', 'MIDDLENAME');
                                                $sheet->setCellValue('D1', 'LASTNAME');
                                                $directoryPath = 'C:\ACADEMIX\\' . $school . '\generated_reports\class_list\\';
                                                if (!is_dir($directoryPath)) {
                                                    if (!mkdir($directoryPath, 0777, true)) {
                                                        die('Failed to create directories.');
                                                    }
                                                }
                                                $filePath = $directoryPath . 'class.xlsx';


                                                $row = 2;
                                                while ($row_data = oci_fetch_assoc($statement)) {
                                                    $sheet->setCellValue('A' . $row, $row_data['STUD_ID']);
                                                    $sheet->setCellValue('B' . $row, $row_data['FIRSTNAME']);
                                                    $sheet->setCellValue('C' . $row, $row_data['MIDDLENAME']);
                                                    $sheet->setCellValue('D' . $row, $row_data['LASTNAME']);
                                                    $row++;
                                                }


                                                $writer = new Xlsx($spreadsheet);
                                                // Output the Excel file
                                                $writer->save($filePath);
                                                $_SESSION['path'] = $filePath;
                                                $_SESSION['file'] = 'class.xlsx';
                                                $_SESSION['redirect']='show_class.php';
                                                header('Location: download_excels.php');
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
                                                $query = "SELECT DISTINCT(A.STUD_ID),B.FIRSTNAME,B.MIDDLENAME,B.LASTNAME FROM STUDENT A JOIN STUDENT_PERSONAL B ON(A.STUD_ID=B.STUD_ID) JOIN CLASS_STUDENT C ON (A.STUD_ID=C.STUD_ID) WHERE C.SUB_CODE = $sub_code and c.s_id = $sid ORDER  BY  A.STUD_ID";
                                              
                                                $statement = oci_parse($conn, $query);
                                                oci_execute($statement);
                                                $spreadsheet = new Spreadsheet();
                                                $sheet = $spreadsheet->getActiveSheet();
                                                $sheet->setCellValue('A1', 'STUDENT ID');
                                                $sheet->setCellValue('B1', 'FIRSTNAME');
                                                $sheet->setCellValue('C1', 'MIDDLENAME');
                                                $sheet->setCellValue('D1', 'LASTNAME');
                                                $directoryPath = 'C:\ACADEMIX\\' . $school . '\generated_reports\class_list\\';
                                                if (!is_dir($directoryPath)) {
                                                    if (!mkdir($directoryPath, 0777, true)) {
                                                        die('Failed to create directories.');
                                                    }
                                                }
                                                $filePath = $directoryPath . 'class.xlsx';

                                                $row = 2;
                                                while ($row_data = oci_fetch_assoc($statement)) {
                                                    $sheet->setCellValue('A' . $row, $row_data['STUD_ID']);
                                                    $sheet->setCellValue('B' . $row, $row_data['FIRSTNAME']);
                                                    $sheet->setCellValue('C' . $row, $row_data['MIDDLENAME']);
                                                    $sheet->setCellValue('D' . $row, $row_data['LASTNAME']);
                                                    $row++;
                                                }
                                                $writer = new Xlsx($spreadsheet);
                                                // Output the Excel file
                                                $writer->save($filePath);
                                                $_SESSION['path'] = $filePath;
                                                $_SESSION['filename'] = 'class.xlsx';
                                                $_SESSION['redirect']='show_class.php';
                                                header('Location: download_excels.php');
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
                                            }
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
                                    <div style="display: flex;">
                         
                                    </div>

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