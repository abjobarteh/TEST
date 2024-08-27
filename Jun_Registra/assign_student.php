<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/show.css">
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
include('auto_logout.php');
?>

<body>
    <form class="container" enctype="multipart/form-data" action="assign_student.php" method="post">
        <div class="com">
            <h3>
                Academix: School Management System
            </h3>
            <h2 class="title" style="justify-content:center; text-align:center; color:#1D5B79; 	font-size: 18px;"><?php echo $school ?>
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
        <header>Enroll Student</header>
        <?php
        include 'connect.php';
        $region = " ";
        $stuid = 'stuid';
        $sc = '0';
        $cc = '0';
        ?>
        <div class="input-field">
            <select required name="reg">
                <option disabled selected>Select Grade To Enroll</option>
                <?php

                $get_hos = "select * from SUB_CLASS WHERE S_ID= $sid order by class";
                $get = oci_parse(oci_connect($username, $password, $connection), $get_hos);
                oci_execute($get);
                while ($row = oci_fetch_array($get)) {
                ?><option>
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
  text-decoration: none;" name="filter" type="submit">
                FILTER
                <i class="uil uil-filter"></i>
            </button>
        </div>
        <?php
        if (isset($_POST['filter'])) {
            if (isset($_POST['reg'])) {
                $c_n = $_POST['reg'];
                $sql = oci_parse($conn, "select * from sub_class where class_name = '$c_n' and s_id = $sid  ");
                oci_execute($sql);
                while ($r = oci_fetch_array($sql)) {
                    $class_code  = $r['CLASS'];
                    $sub_code = $r['SUB_CODE'];
                    $cc = $class_code;
                    $sc = $sub_code;
                }
            } else {
        ?><div style="font-size:15px;
                color: red;
                position: relative;
                 display:flex;
                animation:button .3s linear;text-align: center;">
                    <?php echo "SELECT GRADE";
                    header("refresh:2;");
                    ?>
                </div> <?php
                    }
                }
                        ?>
        <div>
        </div>
        <?php

        include 'connect.php';
        if ($conn) {
            $sql = "select * from student A JOIN student_document B ON (A.STUD_ID=B.STUD_ID) JOIN STUDENT_ACADEMIC C ON (A.STUD_ID=C.STUD_ID) WHERE A.STATUS = 'REGISTERED' AND C.CLASS= $cc";
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
        <div style="display:flex; margin-top:20px;">
            <Label style="font-size: 18px; font-family: righteous;
         font-weight: bold; color: #1D5B79;">Student Information</Label>
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
                <tr style="  background-color: #1D5B79;
    color: #ffffff;
    text-align: left;
    font-weight: bold;">
                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Photo ID</th>
                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Name</th>
                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Status</th>
                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Registration Date</th>
                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        ACCEPT</th>
                </tr>
            </thead>
            <tbody>
                <tr style=" border-bottom: 1px solid #dddddd;">
                    <?php
                    while ($row = oci_fetch_array($stid)) {
                    ?>
                        <?php
                        $imageData = $row['PASS_PHOTO']->load();
                        $base64Image = base64_encode($imageData);
                        ?> <td style=" padding: 5px 8px; font-size: 10px; margin: 5px;"><?php
                                                                                        echo '<img src="data:image/png;base64,' . $base64Image . '" alt="Image" style="width: 50px; height: 50px;">'; ?></td> <?php
                                                                                                                                                                                                                ?>
                        <td><?php echo $row['NAME']; ?></td>
                        <td><?php echo $row['STATUS']; ?></td>
                        <td><?php echo $row['CREATE_DT']; ?></td>
                        <td><input type="checkbox" name="enroll[]" value="<?php echo $row['STUD_ID']; ?>"></td>
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
  text-decoration: none;" name="enroll_student" type="submit">
                ENROLL
                <i class="uil uil-user-check"></i>
            </button>

        </div>
        <?php
        require '../vendor/autoload.php';

        use PhpOffice\PhpSpreadsheet\Spreadsheet;
        use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

        if (isset($_POST['enroll_student'])) {
            if (isset($_POST['reg'])) {
                $c_n = $_POST['reg'];
                $sql = oci_parse($conn, "select * from sub_class where class_name = '$c_n' ");
                oci_execute($sql);
                while ($r = oci_fetch_array($sql)) {
                    $cc  = $r['CLASS'];
                    $sc = $r['SUB_CODE'];
                }
                if (isset($_POST['enroll']) && !empty($_POST['enroll'])) {
                    $selectedStudentIds = $_POST['enroll'];
                    foreach ($selectedStudentIds as $studentId) {
                        $sql = oci_parse($conn, "select * from CLASS_STUDENT WHERE STUD_ID = '$studentId' ");
                        oci_execute($sql);
                        if (oci_fetch_all($sql, $a) == 0) {
                            $sql = oci_parse($conn, "insert into class_student (S_ID,SUB_CODE,CLASS,STUD_ID) VALUES ($sid,$sc,$cc,'$studentId') ");
                            $get_subj = oci_parse($conn, "select * from subject where class = $cc");
                            oci_execute($get_subj);
                            oci_execute($sql);
                            while ($r = oci_fetch_array($get_subj)) {
                                $s_code = $r['SUB_CODE'];
                                $insert_subj = oci_parse($conn, "insert into student_subject (S_ID,SUB_CODE,CLASS,STUD_ID) values ($sid,$s_code,$cc,'$studentId')");
                                oci_execute($insert_subj);
                            }

                            $get_fee = oci_parse($conn, "select sum(cost) from tuition where s_id= $sid and class = $cc ");
                            oci_execute($get_fee);
                            while ($r = oci_fetch_array($get_fee)) {
                                $fee = $r['SUM(COST)'];
                            }
                            $check = oci_parse($conn, "select * from student_finance where stud_id = '$studentId' ");
                            oci_execute($check);
                            
                            if (oci_fetch_all($check, $a) == 0) {
                                $sql = oci_parse($conn, "insert into student_finance (s_id,class,stud_id,fee,balance)  values ($sid,$class,'$studentId',$fee,$fee");
                                oci_execute($sql);
                            }

                            $upd =  oci_parse($conn, "update student set status = 'ENROLLED' WHERE  STUD_ID = '$studentId' ");
                            oci_execute($upd);
        ?><div style="font-size:15px;
                            color: green;
                            position: relative;
                             display:flex;
                            animation:button .3s linear;text-align: center;">
                                <?php echo "SELECTED STUDENT ENROLLED AND ASSIGNED SUBJECTS";
                                header("refresh:2;");
                                ?>
                            </div> <?php
                                } else {
                                    ?><div style="font-size:15px;
                            color: red;
                            position: relative;
                             display:flex;
                            animation:button .3s linear;text-align: center;">
                                <?php echo "STUDENT ALREADY ENROLLED";
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
                        <?php echo "NO STUDENT SELECTED";
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
                    <?php echo "SELECT GRADE";
                        header("refresh:2;");
                    ?>
                </div> <?php
                    }
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