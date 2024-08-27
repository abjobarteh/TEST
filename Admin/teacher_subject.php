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
$t_id = 0;
$s_code = 0;
$school =  $_SESSION['school'];
$sid = $_SESSION['sid'];
$emp_id = $_SESSION['emp_id'];
?>
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
?>

<body>
    <form class="container" enctype="multipart/form-data" action="teacher_subject.php" method="post">
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
        <header>Teacher/Subject Management</header>
        <?php
        include 'connect.php';

        if ($conn) {

            $sql = "select * from employee where status = 'ACTIVE' and s_id = $sid and emp_id = $emp_id ";

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
                <tr style="  background-color: #04716f;
    color: #ffffff;
    text-align: left;
    font-weight: bold;">

                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Teacher</th>
                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Employee ID</th>
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
                            <?php echo $row['FIRSTNAME'] . " " . $row['MIDDLENAME'] . " " . $row['LASTNAME']; ?>

                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['EMP_ID']; ?>

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
            $sql = "select distinct(c.subject),CLASS_NAME from teacher_subject a join employee b on (a.emp_id=b.emp_id) join waec_subject c on (a.sub_code=c.sub_code) join sub_class f on (a.s_code=f.sub_code) where a.s_id = $sid and a.emp_id = $emp_id order by c.subject ";
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

<table class="table-content" style="font-size: 14px; border-collapse: collapse; margin: 10px 0; font: 0.9em; min-width: 400px; border-radius: 5px 5px; overflow: hidden; box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);">
    <thead>
        <tr style="background-color: #04716f; color: #ffffff; text-align: left; font-weight: bold;">
            <th style="padding: 5px 8px; font-size: 10px; margin: 5px;">Subject</th>
            <th style="padding: 5px 8px; font-size: 10px; margin: 5px;">Class</th>
        </tr>
    </thead>
</table>
<div style="max-height: 200px; overflow-y: auto;">
    <table class="table-content" style="font-size: 14px; border-collapse: collapse; margin: 10px 0; font: 0.9em; min-width: 400px; border-radius: 5px 5px;">
        <tbody>
            <?php
            while ($row = oci_fetch_array($stid)) {
            ?>
                <tr style="border-bottom: 1px solid #dddddd;">
                    <td style="padding: 5px 8px; font-size: 10px; margin: 5px;"><?php echo $row['SUBJECT']; ?></td>
                    <td style="padding: 5px 8px; font-size: 10px; margin: 5px;"><?php echo $row['CLASS_NAME']; ?></td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
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
                GENERATE EXCEL REPORT OF SUBJECT TEACHER
                <i class="uil uil-file-export"></i>
            </button>
        </div>
        <Label style="font-size: 18px; font-family: righteous;
         font-weight: bold; color: #04716f;">Assign Subject To Teacher</Label>
        <div class="input-field">
            <label for="subjectCode">Subject</label>
            <select required name="class">
                <option disabled selected>Select Subject</option>
                <?php
                $get_hos = "SELECT DISTINCT(SUBJECT),SUB_CODE FROM SUBJECT WHERE S_ID = $sid ORDER BY SUBJECT";
                $get = oci_parse(oci_connect($username, $password, $connection), $get_hos);
                oci_execute($get);
                while ($row = oci_fetch_array($get)) {
                ?><option value="<?php echo $row['SUB_CODE'] ?>">
                        <?php echo $row["SUBJECT"]; ?>
                    </option> <?php
                            }
                                ?>
            </select>
            <button style=" display: inline-block;
  padding: 6px 12px;
  background-color: #04716f;
  color: white;
  border: none;
  margin-left: 10px;
  border-radius: 4px;
  text-decoration: none;" name="filter_sub" type="submit">
                FILTER CLASS BY SUBJECT
                <i class="uil uil-filter"></i>
            </button>
            <?php
            if (isset($_POST["filter_sub"])) {
                if (isset($_POST['class'])) {
                    $sub_code  = $_POST['class'];
                    //      echo $sub_code;
                    $_SESSION['sub_code'] = $sub_code;
                    /*    $sql = oci_parse($conn, "select * from sub_class where class_name = '$class' ");
                    oci_execute($sql);
                    while ($r = oci_fetch_array($sql)) {
                        $s_code = $r["SUB_CODE"];
                        $_SESSION['sub_code'] = $s_code;
                    } */
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
                            ?>
            <?php
            if ($conn) {
                ob_start();
                //  $sub_code  = $_POST['class'];

                $getsub = "SELECT * FROM SUBJECT A JOIN SUB_CLASS B ON (A.SUBS=B.SUB_CODE) WHERE A.SUB_CODE = $sub_code ORDER BY b.CLASS_NAME";
                //       echo $getsub;
                $subjs = oci_parse($conn, $getsub);
                oci_execute($subjs);
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
            <div style="display:flex; margin-top:20px;">

            </div>
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
                            Class Name</th>
                        <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            Assign</th>
                    </tr>
                </thead>
                <tbody>
                    <tr style=" border-bottom: 1px solid #dddddd;">
                        <?php
                        while ($row = oci_fetch_array($subjs)) {
                        ?>
                            <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                                <?php echo $row['CLASS_NAME']; ?>

                            </td>
                            <td><input type="checkbox" name="un[]" value="<?php echo $row['SUB_CODE']; ?>"></td>
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
  background-color: #04716f;
  color: white;
  border: none;
  border-radius: 4px;
  margin-top:10px;
  margin-bottom:10px;
  text-decoration: none;" name="assign" type="submit">
                    ASSIGN SUBJECT
                    <i class="uil uil-create-dashboard"></i>
                </button>
            </div>
            <?php
            if (isset($_POST['assign'])) {
                $subject = $_POST['subject'];
                $s_code = $_SESSION['sub_code'];
                if (isset($_POST['un']) && !empty($_POST['un'])) {
                    $selected_subcode = $_POST['un'];
                    foreach ($selected_subcode as $sub_code) {
                        //   echo $sub_code;
                        $sql = oci_parse($conn, "select * from teacher_subject where emp_id = $emp_id and s_code = $s_code and sub_code = $sub_code and s_id = $sid ");
                        oci_execute($sql);
                        if (oci_fetch_all($sql, $a) > 0) {
                            echo 0;
                            continue;
                        }
                        $sql = oci_parse($conn, "select * from teacher_subject where s_code = $s_code and sub_code = $sub_code and s_id = $sid ");
                        oci_execute($sql);
                        if (oci_fetch_all($sql, $a) > 0) {
                            echo 1;
                            continue;
                        }
                 //       echo "INSERT INTO TEACHER_SUBJECT (EMP_ID,S_ID,S_CODE,SUB_CODE) VALUES ($emp_id,$sid,$sub_code,$s_code)";
                        $sql = oci_parse($conn, "INSERT INTO TEACHER_SUBJECT (EMP_ID,S_ID,S_CODE,SUB_CODE) VALUES ($emp_id,$sid,$sub_code,$s_code)");
                       if (oci_execute($sql)) {
            ?><div style="font-size:15px;
                                            color: green;
                                            position: relative;
                                             display:flex;
                                            animation:button .3s linear;text-align: center;">
                                <?php echo "$subject ASSIGNED SUCCESSFULLY";
                                header("refresh:2;");
                                ?>
                            </div> <?php
                                } 
                            }
                        } else {
                                    ?><div style="font-size:15px;
                    color: red;
                    position: relative;
                     display:flex;
                    animation:button .3s linear;text-align: center;">
                        <?php echo "SELECT SUBJECT";
                            header("refresh:2;");
                        ?>
                    </div> <?php
                        }
                    }
                            ?>
            <Label style="font-size: 18px; font-family: righteous;
         font-weight: bold; color: #04716f;">Unassign Subject From Teacher</Label>
            <div class="input-field">
                <label for="subjectCode">Subject</label>
                <select required name="un_subject">
                    <option disabled selected>Select Subject</option>
                    <?php
                    $get_hos = "select a.subject,c.sub_code,c.class_name from waec_subject a join teacher_subject b on (a.sub_code=b.sub_code) join sub_class c on (b.s_code=c.sub_code) where b.emp_id = $emp_id ";
                    $get = oci_parse(oci_connect($username, $password, $connection), $get_hos);
                    oci_execute($get);
                    while ($row = oci_fetch_array($get)) {
                    ?><option >
                         <?php echo $row["SUBJECT"] . " (" . $row['CLASS_NAME'] . ")"; ?>
                        </option> <?php
                                }
                                    ?>
                </select>
                <div style="display: flex;">
                    <button style=" display: inline-block;
  padding: 6px 12px;
  background-color: #04716f;
  color: white;
  border: none;
  border-radius: 4px;
  margin-top:10px;
  margin-bottom:10px;
  text-decoration: none;" name="unassign" type="submit">
                        UNASSIGN SUBJECT
                        <i class="uil uil-create-dashboard"></i>
                    </button>
                </div>
                <?php
                if (isset($_POST["unassign"])) {
                    if (isset($_POST['un_subject'])) {
                    //    $sub = $_POST['un_subject'];
                        $classValue = $_POST['un_subject'];

                        // If $row['CLASS_NAME'] is in the format "ClassName (AdditionalInfo)"
                        // You can use the following code to extract the value within parentheses
                        // If $classValue is in the format "Subject (ClassName)"
                        if (strpos($classValue, '(') !== false && strpos($classValue, ')') !== false) {
                          $startPos = strpos($classValue, '(') + 1;
                          $endPos = strpos($classValue, ')', $startPos);
                          $className = substr($classValue, $startPos, $endPos - $startPos);
                          $subject = rtrim(substr($classValue, 0, $startPos - 1)); 
                      //    echo $subject;
                        //  echo $className;
                          $sql = oci_parse($conn,"SELECT * FROM WAEC_SUBJECT WHERE SUBJECT = '$subject' AND EXAM ='WASSCE' ");
                       //   echo "SELECT * FROM WAEC_SUBJECT WHERE SUBJECT = '$subject' AND EXAM ='WASSCE'  ";
                          oci_execute($sql);
                          while($r=oci_fetch_array($sql)){
                            $sub_code = $r['SUB_CODE'];
                          //  echo $sub_code;
                          }
                          $sql = oci_parse($conn,"SELECT * FROM SUB_CLASS WHERE CLASS_NAME = '$className' and s_id = $sid");
                          oci_execute($sql);
                          while($r=oci_fetch_array($sql)){
                            $s_code = $r['SUB_CODE'];
                       //  echo $s_code;
                          }

                        } else {
                          // If there are no parentheses, use the entire value as subject
                          $subject = $classValue;
                          $className = ''; // No class name
                        }
                      

                        $sql = oci_parse($conn, "select * from teacher_subject where emp_id = $emp_id and sub_code = $sub_code and s_id = $sid AND S_CODE = $s_code  ");
                        oci_execute($sql);

                        if (oci_fetch_all($sql, $a) > 0) {
                            $sql = oci_parse($conn, "DELETE FROM TEACHER_SUBJECT WHERE emp_id= $emp_id and sub_code=$sub_code and s_id = $sid AND S_CODE = $s_code ");
                            if (oci_execute($sql)) {
                ?><div style="font-size:15px;
                        color: green;
                        position: relative;
                         display:flex;
                        animation:button .3s linear;text-align: center;">
                                    <?php echo "SUBJECT UNASSIGNED SUCESSFULLY";
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
                                <?php echo "SUBJECT NOT ASSIGNED TO TEACHER";
                                    header("refresh:2;"); ?>
                            </div> <?php
                                } 
                            } else {
                                    ?><div style="font-size:15px;
                    color: red;
                    position: relative;
                     display:flex;
                    animation:button .3s linear;text-align: center;">
                            <?php echo "SELECT SUBJECT";
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

                        <a class="btnText" href="select_teacher.php">
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