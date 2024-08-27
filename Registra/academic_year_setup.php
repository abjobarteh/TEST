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
    <form class="container" enctype="multipart/form-data" action="academic_year_setup.php" method="post">
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
        <header>Academic Year Setup</header>
        <?php
        include 'connect.php';

        if ($conn) {
            $sql = "select * from academic_calendar where  s_id = $sid and status = 'ACCEPTED' order by academic_year ";
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
                        Academic Year</th>
                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Start Of Academic Year</th>
                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        End Of Academic Year</th>
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
                            <?php echo $row['ACADEMIC_YEAR']; ?>

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
                GENERATE EXCEL REPORT OF CLASS
                <i class="uil uil-file-export"></i>
            </button>
        </div>

        <Label style="font-size: 18px; font-family: sans-serif;
    font-weight: bold; color: #1D5B79;">Define Academic Year</Label>
        <div class="input-container" style="display: flex;">
            <div class="input-field" style="margin-right: 10px;">
                <label>Academic Year Title(Format:2023/2024)</label>

                <input type="text" placeholder="Enter Academic Title" title="Only Letters And Numbers" name="aca_title" style="width:250px;" required pattern="[0-9/- ]+">
            </div>
            <div class="input-field" style="margin-right: 10px;">
                <label>Academic Year Start Date</label>
                <input type="date" placeholder="Enter Academic Title" title="Only Letters And Numbers" name="start" style="width:250px;" required >
            </div>
            <div class="input-field" style="margin-right: 10px;">
                <label>Academic Year End Date</label>
                <input type="date" placeholder="Enter Academic Title" title="Only Letters And Numbers" name="end" style="width:250px;" required min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>">
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
  text-decoration: none;" name="establish" type="submit">
                Define Academic Year
                <i class="uil uil-create-dashboard"></i>
            </button>
        </div>
        <?php
        if (isset($_POST['establish'])) {

            $title = strtoupper($_POST['aca_title']) . " ACADEMIC YEAR";
            $start = $_POST['start'];
            $start_dt = date('Y-m-d', strtotime($start));
            $end = $_POST['end'];
            $end_dt = date('Y-m-d', strtotime($end));

            $sql = oci_parse($conn, "SELECT * FROM ACADEMIC_CALENDAR WHERE STATUS='ACCEPTED' OR STATUS = 'PENDING' and s_id = $sid");
            oci_execute($sql);

            if (oci_fetch_all($sql, $a) == 0) {

                $sql = oci_parse($conn, "select * from academic_calendar where status = 'EXPIRED' and s_id = $sid");
                oci_execute($sql);
             
                if (oci_fetch_all($sql, $a) > 0) {

                    $sql = oci_parse($conn, "INSERT INTO ACADEMIC_CALENDAR (ACADEMIC_YEAR,START_DT,END_DT,STATUS,S_ID) VALUES ('$title','$start_dt','$end_dt','PENDING',$sid)");
                    if (oci_execute($sql)) {
        ?><div style="font-size:15px;
                        color: green;
                        position: relative;
                         display:flex;
                        animation:button .3s linear;text-align: center;">
                            <?php echo "ACADEMIC YEAR $title SUCCESSFULLY DEFINIED.";
                            header("refresh:2;"); ?>
                        </div> <?php
                            } else {
                                ?><div style="font-size:15px;
                        color: red;
                        position: relative;
                         display:flex;
                        animation:button .3s linear;text-align: center;">
                            <?php echo "ERROR DEFINING ACADEMIC YEAR SETUP";
                                header("refresh:2;"); ?>
                        </div> <?php
                            }
                        }
                    } else {
                                ?><div style="font-size:15px;
                color: green;
                position: relative;
                 display:flex;
                animation:button .3s linear;text-align: center;">
                    <?php echo "ACADEMIC SETUP IS ALREADY PENDING OR ACCEPTED";
                        header("refresh:2;"); ?>
                </div> <?php
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