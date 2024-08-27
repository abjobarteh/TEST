<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/showss.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
</head>
<?php
ob_start();
session_start();
$school =  $_SESSION['school'];
$sid = $_SESSION['sid'];
include 'connect.php'; ?>
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
    <form class="container" enctype="multipart/form-data" action="student_pay.php" method="post">
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
        <header>Student Finance</header>
        <?php
        include 'connect.php';
        ?>
        <div class="input-field">
            <select required name="reg">
                <option disabled selected>Select Student</option>
                <?php
                $get_hos = "select * from student where s_id = '$sid'";
                $get = oci_parse(oci_connect($username, $password, $connection), $get_hos);
                oci_execute($get);
                while ($row = oci_fetch_array($get)) {
                ?><option>
                        <?php echo trim($row["STUD_ID"]); ?>
                    </option> <?php
                            }
                                ?>
            </select>
        </div>
        <button style=" display: inline-block;
  padding: 6px 12px;
  background-color: #1D5B79;
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
                $stuid = $_POST['reg'];
            } else {
        ?><div style="font-size:15px;
                        color: red;
                        position: relative;
                         display:flex;
                        animation:button .3s linear;text-align: center;">
                    <?php echo "SELECT STUDENT"; ?>
                </div> <?php
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
        if ($conn) {
            if (isset($_POST['reg'])) {
                $sql = "select a.name,a.stud_id,b.DESCRIPTION,b.fee,b.balance,b.post_dt,c.class_title,b.amt from student a join student_finance b on (a.stud_id=b.stud_id) join class c on (b.class=c.class) where b.stud_id = '$stuid' and b.s_id = $sid ";

                $get = oci_parse($conn, "select a.name,a.stud_id,b.DESCRIPTION,b.fee,b.balance,b.post_dt,c.class_title,b.amt from student a join student_finance b on (a.stud_id=b.stud_id) join class c on (b.class=c.class) where b.stud_id = '$stuid' and b.s_id = $sid ");
                oci_execute($get);
                while ($r = oci_fetch_array($get)) {
                    $c = $r['CLASS_TITLE'];
                }
            } else {
                $sql = "select a.name,a.stud_id,b.DESCRIPTION,b.fee,b.balance,b.post_dt,c.class_title,b.amt from student a join student_finance b on (a.stud_id=b.stud_id) join class c on (b.class=c.class) where b.s_id = $sid ";
            }

            $stid = oci_parse($conn, $sql);
            oci_execute($stid);
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
                <tr style="  background-color: #1D5B79;
    color: #ffffff;
    text-align: left;
    font-weight: bold;">
                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Student ID</th>
                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Name</th>
                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Class</th>

                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;"> Tuition Fee
                    </th>
                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;"> Amount Paid
                    </th>
                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;"> Balance
                    </th>
                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;"> Description
                    </th>
                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;"> Posting Date
                    </th>
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
                            <?php echo $row['STUD_ID']; ?>
                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['NAME']; ?>
                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['CLASS_TITLE']; ?>
                        </td>

                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['FEE']; ?>
                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['AMT']; ?>
                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php
                            echo $row['BALANCE']; ?>
                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['DESCRIPTION']; ?>
                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['POST_DT']; ?>
                        </td>
                </tr>
            <?php
                    }
            ?>
            </tr>
            </tbody>
        </table>
        <div class="input-container" style="display: flex;">

            <div class="input-field" style="margin-right: 10px;">
                <label for="subjectCode">Student</label>
                <select required name="id">
                    <option disabled selected>Select Student</option>
                    <?php
                    $get_hos = "select * from student where s_id = '$sid'";
                    $get = oci_parse(oci_connect($username, $password, $connection), $get_hos);
                    oci_execute($get);
                    while ($row = oci_fetch_array($get)) {
                    ?><option>
                            <?php echo trim($row["STUD_ID"]); ?>
                        </option> <?php
                                }
                                    ?>
                </select>
            </div>
            <div class="input-field" style="margin-right: 10px;">
                <label for="subjectCode">Description</label>
                <input type="text" placeholder="Enter Description" title="Only Letters and Numbers" name="des" pattern="[A-z0-9/ ]+">
            </div>
            <div class="input-field" style="margin-right: 10px;">
                <label for="subjectCode">Amount</label>
                <input type="number" placeholder="Enter Amount" title="Only Numbers" name="amt">
            </div>
            <div class="input-field" style="margin-right: 10px;">
                <label for="subjectCode">Proof Of Payment</label>
                <input type="file" name="file">
            </div>
        </div>

        <div style="display: flex;">
            <button style=" display: inline-block;
  padding: 6px 12px;
  background-color: #1D5B79;
  color: white;
  border: none;
  border-radius: 4px;
  margin-top:10px;
  margin-bottom:10px;
  text-decoration: none;" name="update" type="submit">
                UPDATE STUDENT PAYMENT
                <i class="uil uil-bill"></i>
            </button>
        </div>
        <?php
        if (isset($_POST['update'])) {
            if (isset($_POST['id'])) {
                $stuid = $_POST['id'];
                $get = oci_parse($conn, "select a.name,a.stud_id,b.DESCRIPTION,b.fee,b.balance,b.post_dt,c.class_title,c.class,b.balance from student a join student_finance b on (a.stud_id=b.stud_id) join class c on (b.class=c.class) where b.stud_id = '$stuid' and b.s_id = $sid ");
                oci_execute($get);
                while ($r = oci_fetch_array($get)) {
                    $c = $r['CLASS'];
                    $name = $r['NAME'];
                    $fee = $r['FEE'];
                    $bal = $r['BALANCE'];
                }
                $des = strtoupper($_POST['des']);
                if ($des != '') {
                    $amt = $_POST['amt'];
                    if ($amt != '') {
                        $balance = $bal - $amt;
                        echo $balance;
                        if (isset($_FILES['file'])) {
                            $proof = $_FILES['file']['tmp_name'];
                            if (isjpeg_png($proof) || ispdf_word($proof)) {

                                $checks = oci_parse($conn, "select * from student_finance where stud_id = '$stuid' AND  balance <= $amt");
                                oci_execute($checks);
                                if (oci_fetch_all($checks, $a) == 0) {

                                    $query = "INSERT INTO STUDENT_FINANCE (STUD_ID,S_ID,CLASS,PROOF,DESCRIPTION) values (:stuid,:sid,:class,:proof,:des)";
                                    $statement = oci_parse($conn, $query);
                                    oci_bind_by_name($statement, ':sid', $sid);
                                    oci_bind_by_name($statement, ':stuid', $stuid);
                                    oci_bind_by_name($statement, ':class', $c);
                                    oci_bind_by_name($statement, ':des', $des);
                                    $id_doc = file_get_contents($proof);
                                    $lob = oci_new_descriptor($conn, OCI_D_LOB);
                                    oci_bind_by_name($statement, ':proof', $lob, -1, OCI_B_BLOB);
                                    $lob->writeTemporary($id_doc, OCI_TEMP_BLOB);
                                    $sql = oci_parse($conn, "update student_finance set balance = $balance ,post_dt = sysdate, fee = $fee,amt=$amt  where stud_id = '$stuid' and s_id = $sid and description = '$des' and  class = $c AND POST_DT IS NULL AND BALANCE IS NULL ");
                                    if (oci_execute($statement) && oci_execute($sql)) {
        ?><div style="font-size:15px;
                                        color: green;
                                        position: relative;
                                         display:flex;
                                        animation:button .3s linear;text-align: center;">
                                            <?php echo "$name TUITION PAYMENT UPDATED";
                                            header("refresh:2;");
                                            ?>
                                        </div> <?php
                                            } else {
                                                ?><div style="font-size:15px;
                                        color: red;
                                        position: relative;
                                         display:flex;
                                        animation:button .3s linear;text-align: center;">
                                            <?php echo "ERROR UPDATING TUITION PAYEMNT";
                                                header("refresh:2;");
                                            ?>
                                        </div> <?php
                                            }
                                        } else {
                                                ?><div style="font-size:15px;
                                        color: red;
                                        position: relative;
                                         display:flex;
                                        animation:button .3s linear;text-align: center;">
                                        <?php echo "AMOUNT PAID MORE THAN THE BALANCE";
                                            header("refresh:2;"); ?>
                                    </div> <?php
                                        }
                                    } else {
                                            ?><div style="font-size:15px;
                            color: red;
                            position: relative;
                             display:flex;
                            animation:button .3s linear;text-align: center;">
                                    <?php echo "ALLOWED FILE TYPE FOR PROOF OF PAYMENT ARE PDF OR WORD OR JPEG OR PNG";
                                        header("refresh:2;"); ?>
                                </div> <?php
                                    }
                                } else {
                                        ?><div style="font-size:15px;
                        color: red;
                        position: relative;
                         display:flex;
                        animation:button .3s linear;text-align: center;">
                                <?php echo "UPLOAD PROOF OF PAYMENT";
                                    header("refresh:2;"); ?>
                            </div> <?php
                                }
                            } else {
                                    ?><div style="font-size:15px;
                        color: red;
                        position: relative;
                         display:flex;
                        animation:button .3s linear;text-align: center;">
                            <?php echo "ENTER AMOUNT";
                                header("refresh:2;"); ?>
                        </div> <?php
                            }
                        } else {
                                ?><div style="font-size:15px;
                    color: red;
                    position: relative;
                     display:flex;
                    animation:button .3s linear;text-align: center;">
                        <?php echo "ENTER DESCRIPTION";
                            header("refresh:2;"); ?>
                    </div> <?php
                        }
                    } else {
                            ?><div style="font-size:15px;
                color: red;
                position: relative;
                 display:flex;
                animation:button .3s linear;text-align: center;">
                    <?php echo "SELECT STUDENT";
                        header("refresh:2;"); ?>
                </div> <?php
                    }
                }
                        ?>
        <div style="display: flex;">
            <button style=" display: inline-block;
  padding: 6px 12px;
  background-color: #1D5B79;
  color: white;
  border: none;
  border-radius: 4px;
  margin-left: 10px;
  text-decoration: none;" name="generate" type="submit">
                GENERATE EXCEL REPORT OF STUDENT PAYMENT
                <i class="uil uil-file-export"></i>
            </button>
        </div>
        <?php
        require '../vendor/autoload.php';

        use PhpOffice\PhpSpreadsheet\Spreadsheet;
        use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

        if (isset($_POST['generates'])) {
            if (isset($_POST['reg'])) {
                $stuid = $_POST['reg'];
                if ($stuid == '') {
        ?><div style="font-size:15px;
        color: red;
        position: relative;
         display:flex;
        animation:button .3s linear;text-align: center;">
                        <?php echo "SELECT STUDENT";
                        header("refresh:2;"); ?>
                    </div> <?php
                        } else {
                            $query = "select * from student s join finance_records f on (s.stuid=f.stuid) where f.stuid = '$stuid'";
                            // Prepare and execute the query
                            $statement = oci_parse($conn, $query);
                            oci_execute($statement);
                            $spreadsheet = new Spreadsheet();
                            $sheet = $spreadsheet->getActiveSheet();
                            $sheet->setCellValue('A1', 'STUDENT ID');
                            $sheet->setCellValue('B1', 'STUDENT NAME');
                            $sheet->setCellValue('C1', 'POSTING DATE');
                            $sheet->setCellValue('D1', 'POSTED AMOUNT');
                            $sheet->setCellValue('E1', 'DESCRIPTION');
                            $sheet->setCellValue('F1', 'POSTED BY');
                            $outputFilePath = 'C:\IOB\generated_reports\_' . $stuid . '.xlsx';
                            $row = 2;
                            while ($row_data = oci_fetch_assoc($statement)) {
                                $sheet->setCellValue('A' . $row, $row_data['STUID']);
                                $sheet->setCellValue('B' . $row, $row_data['NAME']);
                                $sheet->setCellValue('C' . $row, $row_data['POSTING_DT']);
                                $sheet->setCellValue('D' . $row, $row_data['POSTED_AMOUNT']);
                                $sheet->setCellValue('E' . $row, $row_data['DESCRIPTION']);
                                $sheet->setCellValue('F' . $row, $row_data['USERNAME']);
                                $row++;
                            }
                            $writer = new Xlsx($spreadsheet);

                            // Set appropriate headers for Excel download
                            /* header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                        header('Content-Disposition: attachment;filename="data.xlsx"');
                        header('Cache-Control: max-age=0'); */

                            // Output the Excel file
                            $writer->save($outputFilePath)
                            ?><div style="font-size:15px;
                            color: green;
                            position: relative;
                             display:flex;
                            animation:button .3s linear;text-align: center;">
                        <?php
                            $filename = $outputFilePath;
                            // Header content type
                            header("Content-type: application/pdf");

                            header("Content-Length: " . filesize($filename));

                            // Send the file to the browser.
                            readfile($filename);

                            header("refresh:2;"); ?>

                    </div> <?php

                            // Close the Oracle connection
                            oci_free_statement($statement);
                            oci_close($conn);
                        }
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
function ispdf_word($file)
{
    $ext = pathinfo($file, PATHINFO_EXTENSION);
    if (in_array(strtolower($ext), ['pdf', 'doc', 'docx'])) {
        return true;
    }
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimetype = finfo_file($finfo, $file);
    finfo_close($finfo);
    if (in_array($mimetype, ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'])) {
        return true;
    }

    return false;
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

</html>