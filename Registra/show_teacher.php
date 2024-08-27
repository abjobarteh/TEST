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

// Your page content goes here
// ...
?>

<body>
    <form class="container" enctype="multipart/form-data" action="show_teacher.php" method="post">
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
        <header>Show Teacher</header>

        <?php
       

        $region = " ";
        ?>
        <div class="input-field">
            <select required name="reg">
                <option disabled selected>Select Department</option>
                <?php
                $get_hos = "select * from department where s_id = $sid";
                $get = oci_parse(oci_connect($username, $password, $connection), $get_hos);
                oci_execute($get);
                while ($row = oci_fetch_array($get)) {
                ?><option>
                        <?php echo $row["DEPT"]; ?>
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
        $id = 0;
        if (isset($_POST['filter'])) {
            if (isset($_POST['reg'])) {
                $region = $_POST['reg'];
                $get_hos = "select * from DEPARTMENT where dept = '$region' ";

                $get = oci_parse(oci_connect($username, $password, $connection), $get_hos);
                oci_execute($get);
                if ($row = oci_fetch_array($get)) {
                    $id = $row['DEPT_ID'];
                }
            }
        }
        ?>
        <?php
        if ($conn) {
            $sql = "select * from department d join employee e on (d.dept_id=e.dept_id) where e.s_id=$sid  and e.dept_id = $id";

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
                        Employee ID</th>
                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Firstname</th>
                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Middlename</th>
                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Lastname</th>
                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        DOB</th>
                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Gender</th>
                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Address</th>
                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Nationality</th>
                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        ID Number</th>
                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        ID Issue Date </th>
                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        ID Expiry Date </th>
                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Mobile Line</th>
                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Work Line </th>
                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Email</th>

            </thead>
            <tbody>
                <tr style=" border-bottom: 1px solid #dddddd;">
                    <?php
                    while ($row = oci_fetch_array($stid)) {
                    ?>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['EMP_ID']; ?>

                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['FIRSTNAME']; ?>

                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['MIDDLENAME']; ?>

                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['LASTNAME']; ?>

                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['DOB']; ?>

                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['GENDER']; ?>

                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['ADDRESS']; ?>

                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['NATIONALITY']; ?>

                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['ID']; ?>

                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['ID_ISSUE']; ?>

                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['ID_EXPIRY']; ?>

                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['MOBILE']; ?>

                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['WORK']; ?>

                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['EMAIL']; ?>

                        </td>
                </tr>
            <?php
                    }
            ?>
            </tr>
            </tbody>
        </table>
        <?php
        if ($conn) {
            $sqll = "select * from department d join employee e on (d.dept_id=e.dept_id) where e.s_id=$sid and e.dept_id = $id";

            $stidd = oci_parse($conn, $sqll);
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
                <tr style="  background-color: #1D5B79;
    color: #ffffff;
    text-align: left;
    font-weight: bold;">
                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Employee ID</th>
                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Marital Status</th>
                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Appointment Date</th>
                        <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Qualification</th>
                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Department</th>
                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Status</th>

                    
                     
            </thead>
            <tbody>
                <tr style=" border-bottom: 1px solid #dddddd;">
                    <?php
                    while ($row = oci_fetch_array($stidd)) {
                    ?>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['EMP_ID']; ?>

                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['MARITAL_STATUS']; ?>

                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['APPOINT_DT']; ?>

                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['QUALIF']; ?>

                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['DEPT']; ?>

                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['STATUS']; ?>

                        </td>
                                                                                                            
                </tr>
            <?php
                    }
            ?>
            </tr>
            </tbody>
        </table>
        <div style="display: flex;">
            <button style=" display: inline-block;
  padding: 6px 12px;
  background-color: #1D5B79;
  color: white;
  border: none;
  border-radius: 4px;
  margin-top:10px;
  margin-bottom:10px;
  text-decoration: none;" name="generate" type="submit">
                GENERATE EXCEL REPORT OF TEACHER
                <i class="uil uil-file-export"></i>
            </button>
        </div>

        <?php
        require '../vendor/autoload.php';

        use PhpOffice\PhpSpreadsheet\Spreadsheet;
        use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

        if (isset($_POST['generate'])) {
            $query = "select * from department d join employee e on (d.dept_id=e.dept_id) where e.s_id=$sid order by d.dept";
            // Prepare and execute the query
            $statement = oci_parse($conn, $query);
            oci_execute($statement);
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setCellValue('A1', 'EMPLOYEE ID ');
            $sheet->setCellValue('B1', 'DEPARTMENT');
            $sheet->setCellValue('C1', 'FIRSTNAME');
            $sheet->setCellValue('D1', 'MIDDLENAME');
            $sheet->setCellValue('E1', 'LASTNAME');
            $sheet->setCellValue('F1', 'DOB');
            $sheet->setCellValue('G1', 'GENDER');
            $sheet->setCellValue('H1', 'ADDRESS');
            $sheet->setCellValue('I1', 'NATIONALITY');
            $sheet->setCellValue('J1', 'ID');
            $sheet->setCellValue('K1', 'ID ISSUE DATE');
            $sheet->setCellValue('L1', 'ID EXPIRY DATE');
            $sheet->setCellValue('M1', 'MOBILE LINE');
            $sheet->setCellValue('N1', 'WORK LINE');
            $sheet->setCellValue('O1', 'EMAIL');
            $sheet->setCellValue('P1', 'MARITAL STATUS');
            $sheet->setCellValue('Q1', 'APPOINTMENT DATE');
            $sheet->setCellValue('R1', 'QUALIFICATION');
            $sheet->setCellValue('S1', 'STATUS');
            $sheet->setCellValue('T1', 'CREATE DATE');
            $directoryPath = 'C:\ACADEMIX\\' . $school . '\generated_reports\teacher\\';
            if (!is_dir($directoryPath)) {
                if (!mkdir($directoryPath, 0777, true)) {
                    die('Failed to create directories.');
                }
            }
            $filePath = $directoryPath . 'teacher.xlsx';
            $row = 2;
            while ($row_data = oci_fetch_assoc($statement)) {
                $sheet->setCellValue('A' . $row, $row_data['EMP_ID']);
                $sheet->setCellValue('B' . $row, $row_data['DEPT']);
                $sheet->setCellValue('C' . $row, $row_data['FIRSTNAME']);
                $sheet->setCellValue('D' . $row, $row_data['MIDDLENAME']);
                $sheet->setCellValue('E' . $row, $row_data['LASTNAME']);
                $sheet->setCellValue('F' . $row, $row_data['DOB']);
                $sheet->setCellValue('G' . $row, $row_data['GENDER']);
                $sheet->setCellValue('H' . $row, $row_data['ADDRESS']);
                $sheet->setCellValue('I' . $row, $row_data['NATIONALITY']);
                $sheet->setCellValue('J' . $row, $row_data['ID']);
                $sheet->setCellValue('K' . $row, $row_data['ID_ISSUE']);
                $sheet->setCellValue('L' . $row, $row_data['ID_EXPIRY']);
                $sheet->setCellValue('M' . $row, $row_data['MOBILE']);
                $sheet->setCellValue('N' . $row, $row_data['WORK']);
                $sheet->setCellValue('O' . $row, $row_data['EMAIL']);
                $sheet->setCellValue('P' . $row, $row_data['MARITAL_STATUS']);
                $sheet->setCellValue('Q' . $row, $row_data['APPOINT_DT']);
                $sheet->setCellValue('R' . $row, $row_data['QUALIF']);
                $sheet->setCellValue('S' . $row, $row_data['STATUS']);
                $sheet->setCellValue('T' . $row, $row_data['CREATE_DT']);

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
        </div>
       
        <?php
       
                            ?>
        <div class="buttons">

            <button class="backBtn" type="submit">

                <a class="btnText" href="registra.php">
                    BACK
                </a>
            </button>
        </div>
    </form>
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
    <script>
        $(document).ready(function() {
            $('#example').DataTable();
        });
    </script>
</body>

</html>