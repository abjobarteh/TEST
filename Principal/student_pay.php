<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/showss.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
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
ob_start();
session_start();
$school =  $_SESSION['school'];
$sid = $_SESSION['sid'];
$user = $_SESSION['user'];
include 'connect.php'; ?>
<style>
    .field select:focus {
        padding-left: 47px;
        border: 2px solid #909290;
        background-color: #ffffff;
    }

    .field select:focus~i {
        color: #909290;
    }
</style>
<?php
// Include the auto_logout.php file
include('auto_logout.php');
?>

<body>
    <form class="container" enctype="multipart/form-data" action="student_pay.php" method="post" style="width: 1500px;">
        <div class="com">
            <h3 style="color:#909290;">Academix: School Management System</h3>
            <h3 class="title" style="justify-content:center; text-align:center; color:#909290; 	font-size: 18px;"><?php echo $school ?>
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
        <header>Student Finance</header>
        <?php
        include 'connect.php';
        ?>
        <div class="input-field">
            <select required name="reg">
                <option disabled selected>Select Student</option>
                <?php
                $get_hos = "SELECT DISTINCT(A.STUD_ID),A.NAME FROM STUDENT A JOIN STUDENT_BILLING B ON (A.STUD_ID=B.STUD_ID) ";
                $get = oci_parse(oci_connect($username, $password, $connection), $get_hos);
                oci_execute($get);
                while ($row = oci_fetch_array($get)) {
                ?><option value="<?php echo $row['STUD_ID'] ?>">
                        <?php echo trim($row["NAME"]); ?>
                    </option> <?php
                            }
                                ?>
            </select>
            <select required name="inv">
                <option disabled selected>Select Invoice</option>
                <?php
                $get_hos = "SELECT B.INVOICE_NO FROM STUDENT A JOIN STUDENT_BILLING B ON (A.STUD_ID=B.STUD_ID) ";
                $get = oci_parse(oci_connect($username, $password, $connection), $get_hos);
                oci_execute($get);
                while ($row = oci_fetch_array($get)) {
                ?><option value="<?php echo $row['INVOICE_NO'] ?>">
                        <?php echo trim($row["INVOICE_NO"]); ?>
                    </option> <?php
                            }
                                ?>
            </select>
        </div>
        <button style=" display: inline-block;
  padding: 6px 12px;
  background-color: #909290;
  color: white;
  border: none;
  border-radius: 4px;
  text-decoration: none;" name="filter" type="submit">
            FILTER

            <i class="uil uil-filter"></i>
        </button>
        <?php

        if (isset($_POST['filter'])) {
            if (isset($_POST['reg'])) {
                echo  '<script>
                Swal.fire({
                    position: "center",
                    icon: "info",
                    title: "FILTERING INFORMATION",
                    showConfirmButton: false,
                    timer: 1500
                  });
                </script>';

                $stuid = $_POST['reg'];
            } else if (isset($_POST['inv'])) {
                echo  '<script>
                Swal.fire({
                    position: "center",
                    icon: "info",
                    title: "FILTERING INFORMATION",
                    showConfirmButton: false,
                    timer: 1500
                  });
                </script>';

                $inv = $_POST['inv'];
            } else {
                echo  '<script>
                Swal.fire({
                    position: "center",
                    icon: "warning",
                    title: "SELECT STUDENT",
                    showConfirmButton: false,
                    timer: 1500
                  });
                </script>';
            }
        }
        ?>
        <?php
        include 'connect.php';
        /* $username = "IOB";
         $password = "Iobadmin";
         $connection = "127.0.0.1:1522/testserver";
         $conn = oci_connect($username, $password, $connection); */
        $conn = $con;

        if (isset($_POST['reg'])) {
            $sql = "SELECT D.NAME,C.CLASS_NAME,A.INVOICE_NO,A.REF_NO,A.PROOF,A.AMT,B.DESCRIPTION,A.POSTED_DT,A.POSTEE,B.STUD_ID FROM STUDENT_TRANSACT_HISTORY A JOIN STUDENT_BILLING B ON (A.INVOICE_NO=B.INVOICE_NO) JOIN SUB_CLASS C ON (B.CLASS_CODE=C.SUB_CODE) JOIN STUDENT D ON (B.STUD_ID=D.STUD_ID) WHERE B.STUD_ID='$stuid' ORDER BY A.POSTED_DT";
            $sti = oci_parse($conn, $sql);
            oci_execute($sti);
        } else if (isset($_POST['inv'])) {
            $sql = "SELECT D.NAME,C.CLASS_NAME,A.INVOICE_NO,A.REF_NO,A.PROOF,A.AMT,B.DESCRIPTION,A.POSTED_DT,A.POSTEE,B.STUD_ID FROM STUDENT_TRANSACT_HISTORY A JOIN STUDENT_BILLING B ON (A.INVOICE_NO=B.INVOICE_NO) JOIN SUB_CLASS C ON (B.CLASS_CODE=C.SUB_CODE) JOIN STUDENT D ON (B.STUD_ID=D.STUD_ID) WHERE A.INVOICE_NO = '$inv' ORDER BY A.POSTED_DT ";
            $sti = oci_parse($conn, $sql);
            oci_execute($sti);
        } else {
            $sql = "SELECT D.NAME,C.CLASS_NAME,A.INVOICE_NO,A.REF_NO,A.PROOF,A.AMT,B.DESCRIPTION,A.POSTED_DT,A.POSTEE,B.STUD_ID FROM STUDENT_TRANSACT_HISTORY A JOIN STUDENT_BILLING B ON (A.INVOICE_NO=B.INVOICE_NO) JOIN SUB_CLASS C ON (B.CLASS_CODE=C.SUB_CODE) JOIN STUDENT D ON (B.STUD_ID=D.STUD_ID) ORDER BY A.POSTED_DT ";
            $sti = oci_parse($conn, $sql);
            oci_execute($sti);
        }
        ?>
        <div style="display:flex; margin-top:20px;">
            <Label style="font-size: 18px; font-family: righteous;
         font-weight: bold; color: #909290;">Student Transaction History</Label>
        </div>

        <div style="overflow-x:auto;">
            <table class="table-content" style="font-size: 14px; border-collapse: collapse; margin: 10px 0; font: 0.9em; border-radius: 5px 5px; box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);">
                <thead>
                    <tr style="background-color: #909290; color: #ffffff; text-align: left; font-weight: bold;">
                        <th style="padding: 5px 8px; font-size: 10px; margin: 5px;">Name</th>
                        <th style="padding: 5px 8px; font-size: 10px; margin: 5px;">Class Name</th>
                        <th style="padding: 5px 8px; font-size: 10px; margin: 5px;">Invoice No</th>
                        <th style="padding: 5px 8px; font-size: 10px; margin: 5px;">Description</th>
                        <th style="padding: 5px 8px; font-size: 10px; margin: 5px;">Payment Reference No</th>
                        <th style="padding: 5px 8px; font-size: 10px; margin: 5px;">Amount</th>
                        <th style="padding: 5px 8px; font-size: 10px; margin: 5px;">Posted Date</th>
                        <th style="padding: 5px 8px; font-size: 10px; margin: 5px;">Posted By</th>
                        <th style="padding: 5px 8px; font-size: 10px; margin: 5px;">Proof Of Payment</th>
                    </tr>
                </thead>
            </table>
            <div style="max-height: 200px; overflow-y: auto;">
                <table class="table-content" style="font-size: 14px; border-collapse: collapse; margin: 0; font: 0.9em; min-width: 400px; border-radius: 5px 5px;">
                    <tbody>
                        <?php
                        while ($row = oci_fetch_array($sti)) {
                            $receiptData = $row['PROOF']->load();
                            $directory = 'C:\ACADEMIX\\' . $school . '\generated_reports\payments\\';
                            if (!is_dir($directory)) {
                                if (!mkdir($directory, 0777, true)) {
                                    die('Failed to create directories.');
                                }
                            }
                            // Generate PDF from receipt data (Assuming the receipt is already in PDF format)
                            $pdfPath = $directory . 'receipt_' . $row['INVOICE_NO'] . '.pdf';
                            file_put_contents($pdfPath, $receiptData);

                        ?>
                            <tr style="border-bottom: 1px solid #dddddd;">
                                <td style="padding: 5px 8px; font-size: 14px; margin: 5px;"><?php echo $row['NAME']; ?></td>
                                <td style="padding: 5px 8px; font-size: 14px; margin: 5px;"><?php echo $row['CLASS_NAME']; ?></td>
                                <td style="padding: 5px 8px; font-size: 14px; margin: 5px;"><?php echo $row['INVOICE_NO']; ?></td>
                                <td style="padding: 5px 8px; font-size: 14px; margin: 5px;"><?php echo $row['DESCRIPTION']; ?></td>
                                <td style="padding: 5px 8px; font-size: 14px; margin: 5px;"><?php echo $row['REF_NO']; ?></td>
                                <td style="padding: 5px 8px; font-size: 14px; margin: 5px;"><?php echo $row['AMT']; ?></td>
                                <td style="padding: 5px 8px; font-size: 14px; margin: 5px;"><?php echo $row['POSTEE']; ?></td>
                                <td style="padding: 5px 8px; font-size: 14px; margin: 5px;">
                                    <a href="download_pdf.php?filename=<?php echo urlencode($pdfPath); ?>">Download Receipt</a>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="input-container" style="display: flex;">
            <div class="input-field" style="margin-right: 10px;">
                <label for="subjectCode">Report Type</label>
                <select required name="type">
                    <option disabled selected>Select Report Type</option>
                    <option>PDF</option>
                    <option>EXCEL</option>
                </select>
            </div>
            <div class="input-field" style="margin-right: 10px;">
                <label for="subjectCode">Student</label>
                <select required name="stids">
                    <option disabled selected>Select Student</option>
                    <?php
                    $get_hos = "select * from student a join student_billing b on (a.stud_id=b.stud_id) join student_transact_history c on (b.invoice_no=c.invoice_no) where a.s_id = '$sid' and a.status != 'GRADUATED' ORDER BY a.NAME";
                    $get = oci_parse(oci_connect($username, $password, $connection), $get_hos);
                    oci_execute($get);
                    while ($row = oci_fetch_array($get)) {
                    ?><option value="<?php echo $row['STUD_ID'] ?>">
                            <?php echo trim($row["NAME"]); ?>
                        </option> <?php
                                }
                                    ?>
                </select>
            </div>
        </div>

        <button style=" display: inline-block;
  padding: 6px 12px;
  background-color: #909290;
  color: white;
  border: none;
  border-radius: 4px;
  margin-left: 10px;
  text-decoration: none;" name="generate_transact" type="submit">
            GENERATE STUDENT TRANSACTION HISTORY
            <i class="uil uil-file-export"></i>
        </button>
        <?php
        require('tcpdf/tcpdf.php');
        require '../vendor/autoload.php';


        require 'C:\wamp64\www\Academix\NDOWS\Registra\PHPMailer.php';
        require 'C:\wamp64\www\Academix\NDOWS\Registra\Exception.php';
        require 'C:\wamp64\www\Academix\NDOWS\Registra\SMTP.php';

        use PhpOffice\PhpSpreadsheet\Spreadsheet;
        use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

        if (isset($_POST['generate_transact'])) {
            if (isset($_POST['type'])) {
                $type = $_POST['type'];
                if ($type == 'EXCEL') {
                    if (isset($_POST['stids'])) {
                        $id = $_POST['stids'];
                        $query = "SELECT D.NAME,C.CLASS_NAME,A.INVOICE_NO,A.REF_NO,A.PROOF,A.AMT,B.DESCRIPTION,A.POSTED_DT,A.POSTEE,B.STUD_ID FROM STUDENT_TRANSACT_HISTORY A JOIN STUDENT_BILLING B ON (A.INVOICE_NO=B.INVOICE_NO) JOIN SUB_CLASS C ON (B.CLASS_CODE=C.SUB_CODE) JOIN STUDENT D ON (B.STUD_ID=D.STUD_ID) WHERE B.STUD_ID='$id' ORDER BY A.POSTED_DT";
//echo $query;
                        // Prepare and execute the query
                        $statement = oci_parse($conn, $query);
                        oci_execute($statement);

                        // Create a new Spreadsheet object
                        $spreadsheet = new Spreadsheet();
                        $sheet = $spreadsheet->getActiveSheet();

                        // Set headers for the Excel file
                        $sheet->setCellValue('A1', 'INVOICE NUMBER');
                        $sheet->setCellValue('B1', 'DESCRIPTION');
                        $sheet->setCellValue('C1', 'REFERENCE NUMBER');
                        $sheet->setCellValue('D1', 'AMOUNT');
                        $sheet->setCellValue('E1', 'STUDENT');
                        $sheet->setCellValue('F1', 'CLASS NAME');
                        $sheet->setCellValue('G1', 'POSTED DATE');
                        $sheet->setCellValue('H1', 'POSTED BY');

                        // Create the directory if it doesn't exist
                        $directory = 'C:\ACADEMIX\\' . $school . '\generated_reports\payments\\';
                        if (!is_dir($directory)) {
                            if (!mkdir($directory, 0777, true)) {
                                die('Failed to create directories.');
                            }
                        }

                        // Define the output file path
                        $outputFilePath = $directory . 'ARREARS.xlsx';

                        // Write data to the Excel file
                        $row = 2;
                        while ($row_data = oci_fetch_assoc($statement)) {
                            $sheet->setCellValue('A' . $row, $row_data['INVOICE_NO']);
                            $sheet->setCellValue('B' . $row, $row_data['DESCRIPTION']);
                            $sheet->setCellValue('C' . $row, $row_data['REF_NO']);
                            $sheet->setCellValue('D' . $row, $row_data['AMOUNT']);
                            $sheet->setCellValue('E' . $row, $row_data['NAME']);
                            $sheet->setCellValue('F' . $row, $row_data['CLASS_NAME']);
                            $sheet->setCellValue('G' . $row, $row_data['POSTED_DT']);
                            $sheet->setCellValue('H' . $row, $row_data['POSTEE']);
                            $row++;
                        }

                        // Save the Excel file
                        $writer = new Xlsx($spreadsheet);
                        $writer->save($outputFilePath);

                        // Set session variables
                        $_SESSION['path'] = $outputFilePath;
                        $_SESSION['filename'] = 'TRANSACTION_HISTORY.xlsx';
                        $_SESSION['redirect'] = 'student_pay.php';

                        // Redirect to download_excel.php
                        header("Location: download_excel.php");
                        header("refresh:2;"); ?>
                        </div> <?php
                                oci_free_statement($statement);
                                oci_close($conn);
                            } else {
                                $query = "SELECT D.NAME,C.CLASS_NAME,A.INVOICE_NO,A.REF_NO,A.PROOF,A.AMT,B.DESCRIPTION,A.POSTED_DT,A.POSTEE,B.STUD_ID FROM STUDENT_TRANSACT_HISTORY A JOIN STUDENT_BILLING B ON (A.INVOICE_NO=B.INVOICE_NO) JOIN SUB_CLASS C ON (B.CLASS_CODE=C.SUB_CODE) JOIN STUDENT D ON (B.STUD_ID=D.STUD_ID)  ORDER BY A.POSTED_DT";

                                // Prepare and execute the query
                                $statement = oci_parse($conn, $query);
                                oci_execute($statement);

                                // Create a new Spreadsheet object
                                $spreadsheet = new Spreadsheet();
                                $sheet = $spreadsheet->getActiveSheet();

                                // Set headers for the Excel file
                                $sheet->setCellValue('A1', 'INVOICE NUMBER');
                                $sheet->setCellValue('B1', 'DESCRIPTION');
                                $sheet->setCellValue('C1', 'REFERENCE NUMBER');
                                $sheet->setCellValue('D1', 'AMOUNT');
                                $sheet->setCellValue('E1', 'STUDENT');
                                $sheet->setCellValue('F1', 'CLASS NAME');
                                $sheet->setCellValue('G1', 'POSTED DATE');
                                $sheet->setCellValue('H1', 'POSTED BY');

                                // Create the directory if it doesn't exist
                                $directory = 'C:\ACADEMIX\\' . $school . '\generated_reports\payments\\';
                                if (!is_dir($directory)) {
                                    if (!mkdir($directory, 0777, true)) {
                                        die('Failed to create directories.');
                                    }
                                }

                                // Define the output file path
                                $outputFilePath = $directory . 'TRANSACTION_HISTORY.xlsx';

                                // Write data to the Excel file
                                $row = 2;
                                while ($row_data = oci_fetch_assoc($statement)) {
                                    $sheet->setCellValue('A' . $row, $row_data['INVOICE_NO']);
                                    $sheet->setCellValue('B' . $row, $row_data['DESCRIPTION']);
                                    $sheet->setCellValue('C' . $row, $row_data['REF_NO']);
                                    $sheet->setCellValue('D' . $row, $row_data['AMOUNT']);
                                    $sheet->setCellValue('E' . $row, $row_data['NAME']);
                                    $sheet->setCellValue('F' . $row, $row_data['CLASS_NAME']);
                                    $sheet->setCellValue('G' . $row, $row_data['POSTED_DT']);
                                    $sheet->setCellValue('H' . $row, $row_data['POSTEE']);
                                    $row++;
                                }

                                // Save the Excel file
                                $writer = new Xlsx($spreadsheet);
                                $writer->save($outputFilePath);

                                // Set session variables
                                $_SESSION['path'] = $outputFilePath;
                                $_SESSION['filename'] = 'TRANSACTION_HISTORY.xlsx';
                                $_SESSION['redirect'] = 'student_pay.php';

                                // Redirect to download_excel.php
                                header("Location: download_excel.php");
                                header("refresh:2;"); ?>
                        </div> <?php
                                oci_free_statement($statement);
                                oci_close($conn);
                            }
                        } /*else if ($type == 'PDF') {
                            if (isset($_POST['stids'])) {
                            } else {
                            } 
                        }*/
                    } else {
                        echo  '<script>
        Swal.fire({
            position: "center",
            icon: "warning",
            title: "SELECT REPORT TYPE",
            showConfirmButton: false,
            timer: 1500
          });
        </script>';
                        header("refresh:2;");
                    }
                }

                                ?>
                                
        <div class="buttons">

            <button class="backBtn" type="submit">

                <a class="btnText" href="finance.php">
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
<?php
function isPDF($file)
{
    $ext = pathinfo($file, PATHINFO_EXTENSION);
    if (in_array(strtolower($ext), ['pdf'])) {
        return true;
    }
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimetype = finfo_file($finfo, $file);
    finfo_close($finfo);
    if (in_array($mimetype, ['application/pdf'])) {
        return true;
    } else {
        return false;
    }
}




function isjpeg_png($file)
{
    $type = [IMAGETYPE_JPEG, IMAGETYPE_PNG];
    $detect = exif_imagetype($file);
    if (in_array($detect, $type)) {
        return true;
    } else {
        return false;
    }
}

?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</html>