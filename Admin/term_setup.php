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
$school =  $_SESSION['school'];
$sid = $_SESSION['sid'];; ?>
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
    <form class="container" enctype="multipart/form-data" action="term_setup.php" method="post" style="width: 2000px;">
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
        <header>Term Setup</header>
        <?php
        include 'connect.php';

        if ($conn) {
            $sql = "select * from academic_calendar a join term_calendar b on (a.academic_year=b.academic_year) where b.s_id = $sid ";
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
                        Academic Year</th>
                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Term</th>
                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Start Of Term</th>
                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        End Of Term</th>
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
                            <?php echo $row['ACADEMIC_YEAR']; ?>

                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['TERM']; ?>

                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['START_DT']; ?>

                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['END_DT']; ?>

                        </td>
                </tr>
            <?php
                    }
            ?>
            </tr>
            </tbody>
        </table>
        <div class="input-field" style="margin-right: 10px;">
            <label>Academic Year</label>
            <select required name="filter_ay">
                <option disabled selected>Select Academic Year</option>
                <?php
                $get_hos = "SELECT DISTINCT(ACADEMIC_YEAR) FROM CALENDAR ORDER BY ACADEMIC_YEAR ";
                $get = oci_parse(oci_connect($username, $password, $connection), $get_hos);
                oci_execute($get);
                while ($row = oci_fetch_array($get)) {
                ?><option>
                        <?php echo $row["ACADEMIC_YEAR"]; ?>
                    </option> <?php
                            }
                                ?>
            </select>
        </div>
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
        <?php

        if (isset($_POST['filter'])) {
            if (isset($_POST['filter_ay'])) {
                echo '<script>
                Swal.fire({
                    position: "center",
                    icon: "info",
                    title:"FILTERING INFORMATION",
                    showConfirmButton: false,
                    timer: 1500
                  });
                </script>';
                $ay = $_POST['filter_ay'];
            } else {
                echo '<script>
                Swal.fire({
                    position: "center",
                    icon: "warning",
                    title:"SELECT ACADEMIC YEAR",
                    showConfirmButton: false,
                    timer: 1500
                  });
                </script>';
            }
        }
        ?>
        <div>
            <Label style="font-size: 18px; font-family: sans-serif;
    font-weight: bold; color: #04716f;">Schedule</Label>
            <?php
            $sql = "SELECT * FROM CALENDAR WHERE ACADEMIC_YEAR = '$ay' ORDER BY START_DT,end_dt";
            $stid = oci_parse($conn, $sql);
            oci_execute($stid);
            ?>
            <div style="overflow-x:auto;">
                <table class="table-content" style="font-size: 14px; border-collapse: collapse; margin: 10px 0; font: 0.9em; border-radius: 5px 5px; box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);">
                    <thead>
                        <tr style="background-color: #04716f; color: #ffffff; text-align: left; font-weight: bold;">
                            <th style="padding: 5px 8px; font-size: 10px; margin: 5px;">Academic Year</th>
                            <th style="padding: 5px 8px; font-size: 10px; margin: 5px;">Term</th>
                            <th style="padding: 5px 8px; font-size: 10px; margin: 5px;">Activity</th>
                            <th style="padding: 5px 8px; font-size: 10px; margin: 5px;">Start Date</th>
                            <th style="padding: 5px 8px; font-size: 10px; margin: 5px;">End Date</th>
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
                                    <td style="padding: 5px 8px; font-size: 10px; margin: 5px;"><?php echo $row['ACADEMIC_YEAR']; ?></td>
                                    <td style="padding: 5px 8px; font-size: 10px; margin: 5px;"><?php echo $row['TERM']; ?></td>
                                    <td style="padding: 5px 8px; font-size: 10px; margin: 5px;"><?php echo $row['ACT']; ?></td>
                                    <td style="padding: 5px 8px; font-size: 10px; margin: 5px;"><?php echo $row['START_DT']; ?></td>
                                    <td style="padding: 5px 8px; font-size: 10px; margin: 5px;"><?php echo $row['END_DT']; ?></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div style="display: flex;">
                <button style=" display: inline-block;
  padding: 6px 12px;
  background-color: #04716f;
  color: white;
  border: none;
  border-radius: 4px;
  margin-top:10px;
  margin-bottom:10px;
  text-decoration: none;" name="generate" type="submit">
                    GENERATE ACADEMIC CALENDAR
                    <i class="uil uil-file-export"></i>
                </button>
            </div>
            <?php

            require('tcpdf/tcpdf.php');
            require '../vendor/autoload.php';
            require 'C:\wamp64\www\Academix\NDOWS\Registra\PHPMailer.php';
            require 'C:\wamp64\www\Academix\NDOWS\Registra\Exception.php';
            require 'C:\wamp64\www\Academix\NDOWS\Registra\SMTP.php';

            if (isset($_POST['generate'])) {
                if (isset($_POST['filter_ay'])) {
                    $ay = $_POST['filter_ay'];
                    $stmt = oci_parse($conn, "select a.region,b.district,c.school,c.address,c.phone_one,c.phone_two,c.email,c.logo from region a join district b on (a.reg_code=b.reg_code) join school c on (b.dis_code=c.dis_code) where c.s_id =:sid  ");
                    oci_bind_by_name($stmt, ':sid', $sid);
                    oci_execute($stmt);
                    while ($row = oci_fetch_array($stmt)) {
                        $region = 'REGION ONE';
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
                    $pdf->SetFont('helvetica', 'B', 12);
                    $s = "SELECT * FROM CALENDAR WHERE ACADEMIC_YEAR = '$ay' ORDER BY START_DT,end_dt";
                    $stmts = oci_parse($conn, $s);
                    oci_execute($stmts);
                    while ($r = oci_fetch_array($stmts)) {
                        $t = $r['TERM'];
                    }
                    // Add a line break before the multi-cell content
                    // Adjust Y-coordinate to position the content lower on the page
                    $pdf->SetY($pdf->GetY() + 20); // Add the desired vertical offset

                    // Display the multi-cell content
                    $pdf->MultiCell(0, 10, 'SCHOOL CALENDAR FOR ' . $ay . "\nTERM: " . $t, 0, 'L');



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
                    $pdf->SetFont('dejavusans', '', 8);
                    $pdf->SetY($invoiceTitleBottomY + 5);
                    $pdf->Cell(10, 10, 'Date:', 0, 0);
                    $pdf->Cell(0, 10, date('Y-m-d'), 0, 1);

                    $s = "SELECT * FROM CALENDAR WHERE ACADEMIC_YEAR = '$ay' ORDER BY START_DT,end_dt";
                    $stmts = oci_parse($conn, $s);
                    oci_execute($stmts);
                    $pdf->SetX(($pdf->GetPageWidth() - 150) / 2);
                    $pdf->SetFont('courier', 'B', 12); // Set a larger font size for the heading
                    // Centered heading

                    $pdf->Cell(50, 10, 'Activity', 0, 0, 'C');
                    $pdf->Cell(50, 10, 'Start Date', 0, 0, 'C');
                    $pdf->Cell(50, 10, 'End Date', 0, 1, 'C');

                    // Table content without borders
                    $pdf->SetFont('times', '', 9); // Reset font style
                    while ($row = oci_fetch_assoc($stmts)) {
                        $st = trim($row['TERM']);
                        $f = trim($row['ACT']);
                        $m = trim($row['START_DT']);
                        $n = trim($row['END_DT']);

                        $pdf->SetX(($pdf->GetPageWidth() - 150) / 2);
                        $pdf->Cell(50, 10, $f, 0, 0, 'C');
                        $pdf->Cell(50, 10, $m, 0, 0, 'C');
                        $pdf->Cell(50, 10, $n, 0, 1, 'C');
                    }

                    // Set the Y-coordinate below the table for the total
                    $pdf->SetY($pdf->GetY() + 10); // You may need to adjust the value based on your layout

                    // Output the total on the far right
                    $pdf->SetFont('dejavusans', 'B', 6);
                    $disclaimer2 = "This Student Report Is Designed And Generated By NIFTY ICT SOLUTIONS";

                    //   $pdf->Cell(0, 5, $disclaimer1, 0, 1, 'C'); // Move to the next line after printing disclaimer1
                    $pdf->Cell(0, 5, $disclaimer2, 0, 1, 'C');
                    $directoryPath = 'C:\ACADEMIX\\' . $school . '\generated_reports\calendar\\';
                    if (!is_dir($directoryPath)) {
                        if (!mkdir($directoryPath, 0777, true)) {
                            die('Failed to create directories.');
                        }
                    }
                    $filePath = $directoryPath . 'CALENDAR.pdf';
                    $pdf->Output($filePath, 'F');


                    $_SESSION['path'] = $filePath;
                    $_SESSION['filename'] = 'CALENDAR.pdf';

                    $_SESSION['redirect'] = 'term_setup.php';
                    header('Location: download_pdf.php');
                    // 'F' parameter saves to a file
            ?><div style="font-size:15px;
               color: green;
               position: relative;
                display:flex;
               animation:button .3s linear;text-align: center;">
                <?php echo "CALENDAR GENERATED";
                    header("refresh:2;");
                } else {
                    echo '<script>
                Swal.fire({
                    position: "center",
                    icon: "warning",
                    title:"SELECT ACADEMIC YEAR",
                    showConfirmButton: false,
                    timer: 1500
                  });
                </script>';
                }
            }

                ?>

                <Label style="font-size: 18px; font-family: sans-serif;
    font-weight: bold; color: #04716f;">Define Term</Label>
                <div class="input-container" style="display: flex;">
                    <div class="input-field" style="margin-right: 10px;">
                        <label>Academic Year</label>
                        <select required name="acad_year">
                            <option disabled selected>Select Academic Year</option>
                            <?php
                            $get_hos = "select * from academic_calendar WHERE S_ID= $sid and status = 'ACCEPTED' ";
                            $get = oci_parse(oci_connect($username, $password, $connection), $get_hos);
                            oci_execute($get);
                            while ($row = oci_fetch_array($get)) {
                            ?><option>
                                    <?php echo $row["ACADEMIC_YEAR"]; ?>
                                </option> <?php
                                        }
                                            ?>
                        </select>
                    </div>
                    <div class="input-field" style="margin-right: 10px;">
                        <label>Term</label>
                        <input type="number" placeholder="Enter Term Title" title="Only Numbers" name="term" style="width:250px;" min=1 and max=3>
                    </div>
                    <div class="input-field" style="margin-right: 10px;">
                        <label>Term Start Date</label>
                        <input type="date" placeholder="Enter Academic Title" title="Only Letters And Numbers" name="start" style="width:150px;">
                    </div>
                    <div class="input-field" style="margin-right: 10px;">
                        <label>Term End Date</label>
                        <input type="date" placeholder="Enter Academic Title" title="Only Letters And Numbers" name="end" style="width:150px;" min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>">
                    </div>
                </div>
                <div style="display: flex;">
                    <button style=" display: inline-block;
  padding: 6px 12px;
  background-color: #04716f;
  color: white;
  border: none;
  border-radius: 4px;
  margin-top:10px;
  margin-bottom:10px;
  text-decoration: none;" name="establish" type="submit">
                        Define Term
                        <i class="uil uil-create-dashboard"></i>
                    </button>
                </div>
                <?php
                if (isset($_POST['establish'])) {
                    if (isset($_POST['acad_year'])) {
                        $acad_year = $_POST['acad_year'];
                        $term = $_POST['term'];
                        if ($term != '') {
                            if ($term == '1') {
                                $term_title = $acad_year . " FIRST TERM";
                            } else  if ($term == '2') {
                                $term_title = $acad_year . " SECOND TERM";
                            }
                            if ($term == '3') {
                                $term_title = $acad_year . " THIRD TERM";
                            }
                            $start = $_POST['start'];
                            if ($start != '') {
                                $end = $_POST['end'];
                                if ($end != '') {
                                    $sql = oci_parse($conn, "select * from academic_calendar where academic_year = '$acad_year' and status = 'ACCEPTED' and s_id = $sid ");
                                    oci_execute($sql);
                                    while ($r = oci_fetch_array($sql)) {
                                        $s_dt = $r['START_DT'];
                                        $e_dt = $r['END_DT'];
                                    }
                                    if ($start >= $s_dt && $start <= $e_dt) {
                                        if ($end > $start && $end <= $e_dt && $end >= $s_dt) {
                                            $sql = oci_parse($conn, "select * from term_calendar where s_id = $sid and term = '$term' and status != 'EXPIRED' ");
                                            oci_execute($sql);
                                            if (oci_fetch_all($sql, $a) == 0) {
                                                $sql = oci_parse($conn, "INSERT INTO TERM_CALENDAR (S_ID,TERM,ACADEMIC_YEAR,STATUS,START_DT,END_DT) VALUES ($sid,'$term_title','$acad_year','PENDING','$start','$end')");
                                                if (oci_execute($sql)) {
                ?><div style="font-size:15px;
                                            color: green;
                                            position: relative;
                                             display:flex;
                                            animation:button .3s linear;text-align: center;">
                                                        <?php echo "TERM SETUP HAS BEEN DEFINED AWAITING APPROVAL"; ?>
                                                    </div> <?php
                                                        }
                                                    } else {
                                                            ?><div style="font-size:15px;
                                    color: red;
                                    position: relative;
                                     display:flex;
                                    animation:button .3s linear;text-align: center;">
                                                    <?php echo "TERM SETUP HAS BEEN APPROVED OR WAITING APPROVAL"; ?>
                                                </div> <?php
                                                    }
                                                } else {
                                                        ?><div style="font-size:15px;
                                    color: red;
                                    position: relative;
                                     display:flex;
                                    animation:button .3s linear;text-align: center;">
                                                <?php echo "TERM END DATE EXCEEDING ACADEMIC YEAR PARAMETERS"; ?>
                                            </div> <?php
                                                }
                                            } else {
                                                    ?><div style="font-size:15px;
                                color: red;
                                position: relative;
                                 display:flex;
                                animation:button .3s linear;text-align: center;">
                                            <?php echo "TERM START DATE EXCEEDING ACADEMIC YEAR PARAMETERS"; ?>
                                        </div> <?php
                                            }
                                        } else {
                                                ?><div style="font-size:15px;
                            color: red;
                            position: relative;
                             display:flex;
                            animation:button .3s linear;text-align: center;">
                                        <?php echo "ENTER TERM END DATE"; ?>
                                    </div> <?php
                                        }
                                    } else {
                                            ?><div style="font-size:15px;
                        color: red;
                        position: relative;
                         display:flex;
                        animation:button .3s linear;text-align: center;">
                                    <?php echo "ENTER TERM START DATE"; ?>
                                </div> <?php
                                    }
                                } else {
                                        ?><div style="font-size:15px;
                    color: red;
                    position: relative;
                     display:flex;
                    animation:button .3s linear;text-align: center;">
                                <?php echo "ENTER TERM"; ?>
                            </div> <?php
                                }
                            } else {
                                    ?><div style="font-size:15px;
                color: red;
                position: relative;
                 display:flex;
                animation:button .3s linear;text-align: center;">
                            <?php echo "SELECT ACADEMIC YEAR"; ?>
                        </div> <?php
                            }
                        }

                                ?>
                <Label style="font-size: 18px; font-family: sans-serif;
    font-weight: bold; color: #04716f;">Term Schedule</Label>
                <div class="input-container" style="display: flex;">
                    <div class="input-field" style="margin-right: 10px;">
                        <label>Academic Year</label>
                        <select required name="acad_yr">
                            <option disabled selected>Select Academic Year</option>
                            <?php
                            $get_hos = "select * from academic_calendar WHERE S_ID= $sid and status = 'ACCEPTED' ";
                            $get = oci_parse(oci_connect($username, $password, $connection), $get_hos);
                            oci_execute($get);
                            while ($row = oci_fetch_array($get)) {
                            ?><option>
                                    <?php echo $row["ACADEMIC_YEAR"]; ?>
                                </option> <?php
                                        }
                                            ?>
                        </select>
                    </div>
                    <div class="input-field" style="margin-right: 10px;">
                        <label>Term</label>
                        <select required name="t">
                            <option disabled selected>Select Term</option>
                            <?php
                            $get_hos = "select * from academic_calendar a join term_calendar b on (a.academic_year=b.academic_year)  WHERE b.S_ID= $sid and a.status = 'ACCEPTED' ";
                            $get = oci_parse(oci_connect($username, $password, $connection), $get_hos);
                            oci_execute($get);
                            while ($row = oci_fetch_array($get)) {
                            ?><option>
                                    <?php echo $row["TERM"]; ?>
                                </option> <?php
                                        }
                                            ?>
                        </select>
                    </div>
                    <div class="input-field" style="margin-right: 10px;">
                        <label>Activity</label>
                        <input type="text" placeholder="Enter Activity" name="activity" style="width:250px;" pattern="[A-z0-9/ ]+">
                    </div>

                </div>
                <div class="input-field" style="margin-right: 10px;">
                    <label>Activity Start Date</label>
                    <input type="date" placeholder="Enter Academic Title" title="Only Letters And Numbers" name="act_start_dt" style="width:150px;">
                    <label>Activity End Date</label>
                    <input type="date" placeholder="Enter Academic Title" title="Only Letters And Numbers" name="act_end_dt" style="width:150px;">
                </div>
                <div class="input-field" style="margin-right: 10px;">

                </div>
                <div style="display: flex; ">
                    <button style=" display: inline-block;
  padding: 6px 12px;
  background-color: #04716f;
  color: white;
  border: none;
  border-radius: 4px;
  margin-top:10px;
  margin-bottom:10px;
  text-decoration: none;" name="add_act" type="submit">
                        Add Term Activity
                        <i class="uil uil-create-dashboard"></i>
                    </button>

                </div>
                <Label style="font-size: 18px; font-family: sans-serif;
    font-weight: bold; color: #04716f;">Remove Activity</Label>
                <div class="input-container" style="display: flex;">
                    <div class="input-field" style="margin-right: 10px;">
                        <label>Academic Year</label>
                        <select required name="remove_acad_yr">
                            <option disabled selected>Select Term</option>
                            <?php
                            $get_hos = "select DISTINCT(B.TERM) AS TERM from term_calendar a join calendar b on (a.term=b.term) order by term";
                            $get = oci_parse(oci_connect($username, $password, $connection), $get_hos);
                            oci_execute($get);
                            while ($row = oci_fetch_array($get)) {
                            ?><option>
                                    <?php echo $row["TERM"]; ?>
                                </option> <?php
                                        }
                                            ?>
                        </select>
                    </div>
                </div>
                <button style=" display: inline-block;
  padding: 6px 12px;
  background-color: #04716f;
  color: white;
  border: none;
  border-radius: 4px;
  text-decoration: none;" name="filter_byterm" type="submit">
                    FILTER ACTIVITY BY TERM
                    <i class="uil uil-filter"></i>
                </button>
                <?php
                if (isset($_POST['filter_byterm'])) {
                    if (isset($_POST['remove_acad_yr'])) {
                        $t = $_POST['remove_acad_yr'];
                        $_SESSION['t'] = $t;
                        echo '<script>
                    Swal.fire({
                        position: "center",
                        icon: "info",
                        title:"FILTERING INFORMATION",
                        showConfirmButton: false,
                        timer: 1500
                      });
                    </script>';
                    } else {
                        echo '<script>
                    Swal.fire({
                        position: "center",
                        icon: "warning",
                        title:"SELECT TERM",
                        showConfirmButton: false,
                        timer: 1500
                      });
                    </script>';
                    }
                }
                ?>
                <div class="input-container" style="display: flex;">
                    <div class="input-field" style="margin-right: 10px;">
                        <label>Activity</label>
                        <select required name="remove_act">
                            <option disabled selected>Select Activity</option>
                            <?php
                            $get_hos = "SELECT TRIM(ACT) AS ACT FROM CALENDAR WHERE TERM = '$t' ORDER BY START_DT,END_DT ";
                            $get = oci_parse(oci_connect($username, $password, $connection), $get_hos);
                            oci_execute($get);
                            while ($row = oci_fetch_array($get)) {
                            ?><option>
                                    <?php echo $row["ACT"]; ?>
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
  text-decoration: none;" name="remove" type="submit">
                            REMOVE ACTIVITY
                            <i class="uil uil-trash-alt"></i>
                        </button>
                    </div>
                </div>


                    </div>
                    <?php
                    if (isset($_POST['remove'])) {
                        if (isset($_POST['remove_act'])) {
                            $actt = $_POST['remove_act'];
                            $term = $_SESSION['t'];
                        
                            $sql = oci_parse($conn, "DELETE FROM CALENDAR WHERE TERM = '$term' AND ACT = trim('$actt') ");
                            if (oci_execute($sql)) {
                                echo '<script>
                                Swal.fire({
                                    position: "center",
                                    icon: "success",
                                    title:"ACTIVITY REMOVED SUCCESSFULLY",
                                    showConfirmButton: false,
                                    timer: 1500
                                  });
                                </script>';
                            } else {
                                echo '<script>
                                Swal.fire({
                                    position: "center",
                                    icon: "error",
                                    title:"ERROR REMOVING ACTIVITY",
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
            title:"SELECT ACTIVITY",
            showConfirmButton: false,
            timer: 1500
          });
        </script>';
                        }
                    }

                    if (isset($_POST['add_act'])) {
                        if (isset($_POST['acad_yr'])) {
                            $a_y = $_POST['acad_yr'];
                            if (isset($_POST['t'])) {
                                $t = $_POST['t'];
                                $act = $_POST['activity'];
                                if ($act != '') {
                                    $s_dt = $_POST['act_start_dt'];
                                    if ($s_dt != '') {
                                        $e_dt = $_POST['act_end_dt'];
                                        if ($e_dt != '') {
                                            if ($s_dt <= $e_dt) {
                                                echo "SELECT * FROM ACADEMIC_CALENDAR WHERE START_DT  >= '$s_dt' and END_DT <= '$s_dt' AND ACADEMIC_YEAR ='$a_y' and STATUS = 'ACCEPTED'";
                                                $sql = oci_parse($conn, "SELECT * FROM ACADEMIC_CALENDAR WHERE START_DT  >= '$s_dt' and END_DT <= '$s_dt' AND ACADEMIC_YEAR ='$a_y' and STATUS = 'ACCEPTED'");
                                                oci_execute($sql);
                                                if (oci_fetch_all($sql, $a) <= 1) {
                                                    $sql = oci_parse($conn, "SELECT * FROM ACADEMIC_CALENDAR WHERE START_DT  >= '$e_dt' and END_DT <= '$e_dt' AND ACADEMIC_YEAR ='$a_y' and STATUS = 'ACCEPTED'");
                                                    oci_execute($sql);
                                                    if (oci_fetch_all($sql, $a) <= 1) {
                                                        $sql = oci_parse($conn, "SELECT * FROM TERM_CALENDAR WHERE START_DT  >= '$s_dt' and END_DT <= '$s_dt' AND ACADEMIC_YEAR ='$a_y' AND TERM = '$t' and STATUS = 'ACCEPTED'");
                                                        oci_execute($sql);
                                                        if (oci_fetch_all($sql, $a) <= 1) {

                                                            $sql = oci_parse($conn, "SELECT * FROM TERM_CALENDAR WHERE START_DT  >= '$e_dt' and END_DT <= '$e_dt' AND ACADEMIC_YEAR ='$a_y' AND TERM = '$t' and STATUS = 'ACCEPTED'");
                                                            oci_execute($sql);
                                                            if (oci_fetch_all($sql, $a) <= 1) {

                                                                $act = strtoupper($act);
                                                                $sql = oci_parse($conn, "INSERT INTO CALENDAR (ACADEMIC_YEAR,TERM,ACT,START_DT,END_DT) VALUES ('$a_y','$t','$act','$s_dt','$e_dt')");
                                                                if (oci_execute($sql)) {
                                                                    echo '<script>
                                                            Swal.fire({
                                                                position: "center",
                                                                icon: "success",
                                                                title:"' . $act . ' ADDED SUCCESSFULLY",
                                                                showConfirmButton: false,
                                                                timer: 1500
                                                              });
                                                            </script>';
                                                                } else {
                                                                    echo '<script>
                                                Swal.fire({
                                                    position: "center",
                                                    icon: "warning",
                                                    title: "ERROR ADDING ACTIVITY",
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
                                         title: "ACTIVITY END DATE SHOULD BE WITHIN THE TERM",
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
                                        title: "ACTIVITY START DATE SHOULD BE WITHIN THE TERM",
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
                                         title: "ACTIVITY END DATE SHOULD BE WITHIN THE ACADEMIC YEAR",
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
                                        title: "ACTIVITY START DATE SHOULD BE WITHIN THE ACADEMIC YEAR",
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
                                        title: "ACTIVITY START DATE SHOULD BE LESS THAN OR EQUAL TO ACTIVITY END DATE",
                                        showConfirmButton: false,
                                        timer: 1500
                                      });
                                    </script>';
                                            }
                                        } else {
                                            //   echo "SELECT * FROM ACADEMIC_CALENDAR WHERE START_DT  >= '$s_dt' and END_DT <= '$s_dt' AND ACADEMIC_YEAR ='$a_y' and STATUS = 'ACCEPTED'";
                                            $sql = oci_parse($conn, "SELECT * FROM ACADEMIC_CALENDAR WHERE START_DT  >= '$s_dt' and END_DT <= '$s_dt' AND ACADEMIC_YEAR ='$a_y' and STATUS = 'ACCEPTED'");
                                            oci_execute($sql);
                                            if (oci_fetch_all($sql, $a) <= 1) {
                                                $sql = oci_parse($conn, "SELECT * FROM TERM_CALENDAR WHERE START_DT  >= '$s_dt' and END_DT <= '$s_dt' AND ACADEMIC_YEAR ='$a_y' AND TERM = '$t' and STATUS = 'ACCEPTED'");
                                                oci_execute($sql);
                                                if (oci_fetch_all($sql, $a) <= 1) {

                                                    $act = strtoupper($act);
                                                    $sql = oci_parse($conn, "INSERT INTO CALENDAR (ACADEMIC_YEAR,TERM,ACT,START_DT,END_DT) VALUES ('$a_y','$t','$act','$s_dt','$s_dt')");
                                                    if (oci_execute($sql)) {
                                                        echo '<script>
                                                    Swal.fire({
                                                        position: "center",
                                                        icon: "success",
                                                        title:"' . $act . ' ADDED SUCCESSFULLY",
                                                        showConfirmButton: false,
                                                        timer: 1500
                                                      });
                                                    </script>';
                                                    } else {
                                                        echo '<script>
                                                 Swal.fire({
                                                     position: "center",
                                                     icon: "warning",
                                                     title: "ERROR ADDING ACTIVITY",
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
                                         title: "ACTIVITY START DATE SHOULD BE WITHIN THE TERM",
                                         showConfirmButton: false,
                                         timer: 1500
                                       });
                                     </script>';
                                                }
                                            } else {
                                                /*  echo '<script>
                                     Swal.fire({
                                         position: "center",
                                         icon: "warning",
                                         title: "ACTIVITY START DATE SHOULD BE WITHIN THE ACADEMIC YEAR",
                                         showConfirmButton: false,
                                         timer: 1500
                                       });
                                     </script>'; */
                                            }
                                        }
                                    } else {
                                        echo '<script>
                            Swal.fire({
                                position: "center",
                                icon: "warning",
                                title: "PICK ACTIVITY START DATE",
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
                            title: "ENTER ACTIVITY",
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
                            title: "SELECT TERM",
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
                    title: "SELECT ACADEMIC YEAR",
                    showConfirmButton: false,
                    timer: 1500
                  });
                </script>';
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</html>