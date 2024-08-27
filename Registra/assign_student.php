<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/show.css">
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
        <div class="buttons">
            <button class="backBtn" type="submit" style="width: 150px;">

                <a class="btnText" href="registra.php" style="font-size: 15px;">
                    HOME
                    <i class="uil uil-estate" style="width: 50px;"></i>
                </a>

            </button>
        </div>
        <header>Enroll Student</header>
        <?php
        include 'connect.php';
        $region = " ";
        $stuid = 'stuid';
        $sub_code = 0;
        $sc = '0';
        $cc = '0';

        ?>

        <div class="input-field">

            <select required name="reg">
                <option disabled selected>Select Grade To Enroll</option>
                <?php

                $get_hos = "select DISTINCT(CLASS_NAME) from SUB_CLASS A JOIN STUDENT_ACADEMIC B ON (A.SUB_CODE=B.SUB_CODE) WHERE a.S_ID= $sid order by a.class_name";
                //  echo $get_hos;
                $get = oci_parse(oci_connect($username, $password, $connection), $get_hos);
                oci_execute($get);
                while ($row = oci_fetch_array($get)) {
                ?><option>
                        <?php echo $row["CLASS_NAME"]; ?>
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
        </div>
        <?php
        if (isset($_POST['filter'])) {
            if (isset($_POST['reg'])) {
                echo '<script>
                Swal.fire({
                    position: "center",
                    icon: "info",
                    title: "FILTERING INFORMATION",
                    showConfirmButton: false,
                    timer: 1500
                  });
                </script>';
                $c_n = $_POST['reg'];
                $_SESSION['CLASS_name']  = $_POST['reg'];
                $sql = oci_parse($conn, "select * from sub_class where class_name = '$c_n'  and s_id = $sid ");
                oci_execute($sql);
                while ($r = oci_fetch_array($sql)) {
                    $class_code  = $r['CLASS'];
                    $sub_code = $r['SUB_CODE'];
                    $cc = $class_code;
                    $sc = $sub_code;
                    $_SESSION['SUB_CODE'] =   $sub_code;
                    $_SESSION['CLASS'] = $class_code;
                }
            } else {
        ?><div style="font-size:15px;
                color: red;
                position: relative;
                 display:flex;
                animation:button .3s linear;text-align: center;">
                    <?php echo '<script>
                             Swal.fire({
                                 position: "center",
                                 icon: "warning",
                                 title: "SELECT CLASS",
                                 showConfirmButton: false,
                                 timer: 1500
                               });
                             </script>';
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
        //   echo "select * from student A JOIN student_document B ON (A.STUD_ID=B.STUD_ID) JOIN STUDENT_ACADEMIC C ON (A.STUD_ID=C.STUD_ID) WHERE A.STATUS = 'REGISTERED' AND C.CLASS= $cc";
        if ($conn) {
            $sql = "select * from student A JOIN STUDENT_ACADEMIC C ON (A.STUD_ID=C.STUD_ID) WHERE A.STATUS = 'REGISTERED' AND C.SUB_CODE= $sc ORDER BY A.NAME,A.CREATE_DT DESC";
            //  echo $sql;
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
        <div style="max-height: 200px; overflow-y: auto;">
            <table class="table-content" style="font-size: 14px; border-collapse: collapse; margin: 10px 0; font: 0.9em; min-width: 400px; border-radius: 5px 5px; overflow: hidden; box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);">
                <thead>
                    <tr style="background-color: #1D5B79; color: #ffffff; text-align: left; font-weight: bold;">
                        <th style="padding: 5px 8px; font-size: 10px; margin: 5px;">Student ID</th>
                        <th style="padding: 5px 8px; font-size: 10px; margin: 5px;">Name</th>
                        <th style="padding: 5px 8px; font-size: 10px; margin: 5px;">Status</th>
                        <th style="padding: 5px 8px; font-size: 10px; margin: 5px;">Registration Date</th>
                        <th style="padding: 5px 8px; font-size: 10px; margin: 5px;">ACCEPT</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = oci_fetch_array($stid)) {
                    ?>
                        <tr style="border-bottom: 1px solid #dddddd;">
                            <td style="padding: 5px 8px; font-size: 10px; margin: 5px;"><?php echo $row['STUD_ID']; ?></td>
                            <td style="padding: 5px 8px; font-size: 10px; margin: 5px;"><?php echo $row['NAME']; ?></td>
                            <td style="padding: 5px 8px; font-size: 10px; margin: 5px;"><?php echo $row['STATUS']; ?></td>
                            <td style="padding: 5px 8px; font-size: 10px; margin: 5px;"><?php echo $row['CREATE_DT']; ?></td>
                            <td style="padding: 5px 8px; font-size: 10px; margin: 5px;"><input type="checkbox" name="enroll[]" value="<?php echo $row['STUD_ID']; ?>"></td>
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
  background-color: #1D5B79;
  color: white;
  border: none;
  border-radius: 4px;
  margin-top:10px;
  margin-right: 10px;
  margin-bottom:10px;
  text-decoration: none;" name="enroll_student" type="submit">
                ENROLL
                <i class="uil uil-user-check"></i>
            </button>
            <button style=" display: inline-block;
  padding: 6px 12px;
  background-color: #1D5B79;
  color: white;
  border: none;
  border-radius: 4px;
  margin-top:10px;
  margin-bottom:10px;
  text-decoration: none;" name="enroll_all" type="submit">
                ENROLL ALL
                <i class="uil uil-user-check"></i>
            </button>
        </div>


        <?php
        $sqll = "select * from student A  JOIN CLASS_STUDENT C ON (A.STUD_ID=C.STUD_ID) WHERE A.STATUS = 'SEMI-ENROLLED' AND C.SUB_CODE= $sc  AND NOT EXISTS (SELECT 1 FROM STUDENT_SUBJECT SS WHERE A.STUD_ID=SS.STUD_ID AND SS.SUB_CODE = C.SUB_CODE ) ORDER BY A.NAME,A.CREATE_DT";
        // echo $sqll;
        $getele = oci_parse($conn, $sqll);
        oci_execute($getele);
        ?>
        <div style="display:flex; margin-top:20px;">
            <Label style="font-size: 18px; font-family: righteous;
         font-weight: bold; color: #1D5B79;">Assign Elective</Label>
        </div>
        <div style="max-height: 200px; overflow-y: auto;">
            <table class="table-content" style="font-size: 14px; border-collapse: collapse; margin: 10px 0; font: 0.9em; min-width: 400px; border-radius: 5px 5px; overflow: hidden; box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);">
                <thead>
                    <tr style="background-color: #1D5B79; color: #ffffff; text-align: left; font-weight: bold;">
                        <th style="padding: 5px 8px; font-size: 10px; margin: 5px;">Student ID</th>
                        <th style="padding: 5px 8px; font-size: 10px; margin: 5px;">Name</th>
                        <th style="padding: 5px 8px; font-size: 10px; margin: 5px;">Status</th>
                        <th style="padding: 5px 8px; font-size: 10px; margin: 5px;">Registration Date</th>
                        <th style="padding: 5px 8px; font-size: 10px; margin: 5px;">ACCEPT</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = oci_fetch_array($getele)) {
                    ?>
                        <tr style="border-bottom: 1px solid #dddddd;">
                            <td style="padding: 5px 8px; font-size: 10px; margin: 5px;"><?php echo $row['STUD_ID']; ?></td>
                            <td style="padding: 5px 8px; font-size: 10px; margin: 5px;"><?php echo $row['NAME']; ?></td>
                            <td style="padding: 5px 8px; font-size: 10px; margin: 5px;"><?php echo $row['STATUS']; ?></td>
                            <td style="padding: 5px 8px; font-size: 10px; margin: 5px;"><?php echo $row['CREATE_DT']; ?></td>
                            <td style="padding: 5px 8px; font-size: 10px; margin: 5px;"><input type="checkbox" name="enrolls[]" value="<?php echo $row['STUD_ID']; ?>"></td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <?php
        $sq = "SELECT DISTINCT(A.SUBJECT),A.SUB_CODE FROM WAEC_SUBJECT A JOIN SUBJECT B ON (A.SUB_CODE=B.SUB_CODE) WHERE B.SUBS = $sc and B.SUB_TYPE ='ELECTIVE'";
        $gete = oci_parse($conn, $sq);
        oci_execute($gete);
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
                        Subject</th>
                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        ACCEPT</th>
                </tr>
            </thead>
            <tbody>
                <tr style=" border-bottom: 1px solid #dddddd;">
                    <?php
                    while ($row = oci_fetch_array($gete)) {
                    ?>
                        <?php
                        ?><td><?php echo $row['SUBJECT']; ?></td>
                        <td><input type="checkbox" name="enrollsub[]" value="<?php echo $row['SUB_CODE']; ?>"></td>
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
  margin-right: 10px;
  border-radius: 4px;
  margin-top:10px;
  margin-bottom:10px;
  text-decoration: none;" name="add_elective" type="submit">
                ASSIGN ELECTIVE
                <i class="uil uil-plus"></i>
            </button>
            <button style=" display: inline-block;
  padding: 6px 12px;
  background-color: #1D5B79;
  color: white;
  border: none;
  border-radius: 4px;
  margin-top:10px;
  margin-bottom:10px;
  text-decoration: none;" name="addall_elective" type="submit">
                ASSIGN ELECTIVE TO ALL STUDENTs
                <i class="uil uil-plus"></i>
            </button>
        </div>

        <?php
        if (isset($_POST['add_elective'])) {
            if (isset($_POST['enrolls']) && !empty($_POST['enrolls'])) {
                $selectedid = $_POST['enrolls'];
                if (isset($_POST['enrollsub']) && !empty($_POST['enrollsub'])) {
                    $selected_subcode = $_POST['enrollsub'];
                    foreach ($selectedid as $stud_id) {
                        foreach ($selected_subcode as $sub_code) {
                            $check_numofsub = oci_parse($conn, "select distinct(sub_code) from student_subject where stud_id = '$stud_id' ");
                            //    echo "select distinct(sub_code) from student_subject where stud_id = '$stud_id' ";
                            oci_execute($check_numofsub);
                            if (oci_fetch_all($check_numofsub, $a) >= 11) {
                                ///    echo "CONTINUE";
                                continue;
                            }

                            $check_dup = oci_parse($conn, "select * from student_subject where stud_id = '$stud_id' and sub_code = $sub_code ");
                            //     echo "select * from student_subject where stud_id = '$stud_id' and sub_code = $sub_code ";
                            oci_execute($check_dup);
                            if (oci_fetch_all($check_dup, $a) > 0) {
                                //   echo "CONTINUE 1";
                                continue;
                            }
                            $getclass = oci_parse($conn, "select * from class_student where stud_id = '$stud_id' ");
                            oci_execute($getclass);
                            while ($row = oci_fetch_array($getclass)) {
                                $class = $row["CLASS"];
                            }
                            $sql = oci_parse($conn, "insert into student_subject (stud_id,sub_code,class,s_id) values ('$stud_id','$sub_code','$class',$sid) ");
                            //  echo "insert into student_subject (stud_id,sub_code,class,s_id) values ('$stud_id','$sub_code','$class',$sid) ";
                            if (oci_execute($sql)) {
                                $sql = oci_parse($conn, "select distinct(sub_code) from student_subject where stud_id = '$stud_id' ");
                                oci_execute($sql);
                                if (oci_fetch_all($sql, $a) >= 9) {
                                    $sql = oci_parse($conn, "UPDATE STUDENT SET STATUS = 'ENROLLED' where STUD_ID = '$stud_id' ");
                                    oci_execute($sql);
                                }
        ?><div style="font-size:15px;
                                color: green;
                                position: relative;
                                 display:flex;
                                animation:button .3s linear;text-align: center;">
                                    <?php echo '<script>
                Swal.fire({
                    position: "center",
                    icon: "success",
                    title: "COURSE ASSIGNED SUCCESSFULLY",
                    showConfirmButton: false,
                    timer: 1500
                  });
                </script>';
                                    header("refresh:2;");
                                    ?>
                                </div> <?php
                                    } else {
                                        ?><div style="font-size:15px;
                                    color: red;
                                    position: relative;
                                     display:flex;
                                    animation:button .3s linear;text-align: center;">
                                    <?php echo '<script>
                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "ERROR ASSIGNING COURSE TO STUDENT",
                    showConfirmButton: false,
                    timer: 1500
                  });
                </script>';
                                        header("refresh:2;");
                                    ?>
                                </div> <?php
                                    }
                                }
                            }
                        } else {
                                        ?><div style="font-size:15px;
                    color: red;
                    position: relative;
                     display:flex;
                    animation:button .3s linear;text-align: center;">
                        <?php echo '<script>
                Swal.fire({
                    position: "center",
                    icon: "warning",
                    title: "SELECT ELECTIVE SUBJECT",
                    showConfirmButton: false,
                    timer: 1500
                  });
                </script>';
                            header("refresh:2;");
                        ?>
                    </div> <?php
                        }
                    } else {
                        echo '<script>
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

                if (isset($_POST['addall_elective'])) {

                    if (isset($_POST['enrollsub']) && !empty($_POST['enrollsub'])) {
                        $sc = $_SESSION['SUB_CODE'];
                        $sqll = "select * from student A JOIN STUDENT_ACADEMIC C ON (A.STUD_ID=C.STUD_ID) WHERE A.STATUS = 'SEMI-ENROLLED' AND C.SUB_CODE= $sc  AND NOT EXISTS (SELECT 1 FROM STUDENT_SUBJECT SS WHERE A.STUD_ID=SS.STUD_ID AND SS.SUB_CODE = C.SUB_CODE ) ORDER BY A.CREATE_DT DESC,A.NAME";
                        //  echo $sqll;
                        $getele = oci_parse($conn, $sqll);
                        oci_execute($getele);
                        while ($row = oci_fetch_array($getele)) {

                            $stud_id = $row['STUD_ID'];
                            $selected_subcode = $_POST['enrollsub'];
                            foreach ($selected_subcode as $sub_code) {
                                $check_numofsub = oci_parse($conn, "select distinct(sub_code) from student_subject where stud_id = '$stud_id' ");
                                oci_execute($check_numofsub);
                                if (oci_fetch_all($check_numofsub, $a) >= 11) {
                                    continue;
                                }

                                $check_dup = oci_parse($conn, "select * from student_subject where stud_id = '$stud_id' and sub_code = $sub_code ");
                                oci_execute($check_dup);
                                if (oci_fetch_all($check_dup, $a) > 0) {
                                    continue;
                                }
                                $getclass = oci_parse($conn, "select * from class_student where stud_id = '$stud_id' ");
                                oci_execute($getclass);
                                while ($row = oci_fetch_array($getclass)) {
                                    $class = $row["CLASS"];
                                }
                                $sql = oci_parse($conn, "insert into student_subject (stud_id,sub_code,class,s_id) values ('$stud_id','$sub_code','$class',$sid) ");
                                //  echo "insert into student_subject (stud_id,sub_code,class,s_id) values ('$stud_id','$sub_code','$class',$sid) ";
                                if (oci_execute($sql)) {
                                    $sql = oci_parse($conn, "select * from student_subject where stud_id = '$stu' ");
                                    oci_execute($sql);
                                    if (oci_fetch_all($sql, $a) == 9) {
                                        $sql = oci_parse($conn, "UPDATE STUDENT SET STATUS = 'ENROLLED' where STUD_ID = '$stu' ");
                                        oci_execute($sql);
                            ?><div style="font-size:15px;
                                                  color: green;
                                                  position: relative;
                                                   display:flex;
                                                  animation:button .3s linear;text-align: center;">
                                    <?php echo '<script>
                Swal.fire({
                    position: "center",
                    icon: "success",
                    title: "COURSE ASSIGNED SUCCESSFULLY",
                    showConfirmButton: false,
                    timer: 1500
                  });
                </script>';
                                        header("refresh:2;");
                                    ?>
                                </div> <?php
                                    } else {
                                        ?><div style="font-size:15px;
                                              color: green;
                                              position: relative;
                                               display:flex;
                                              animation:button .3s linear;text-align: center;">
                                    <?php echo '<script>
                Swal.fire({
                    position: "center",
                    icon: "success",
                    title: "COURSE ASSIGNED SUCCESSFULLY",
                    showConfirmButton: false,
                    timer: 1500
                  });
                </script>';
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
                                <?php echo '<script>
                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "ERROR ASSIGNING COURSE TO STUDENT",
                    showConfirmButton: false,
                    timer: 1500
                  });
                </script>';
                                    header("refresh:2;");
                                ?>
                            </div> <?php
                                }
                            }
                        }
                    } else {
                                    ?><div style="font-size:15px;
                            color: red;
                            position: relative;
                             display:flex;
                            animation:button .3s linear;text-align: center;">
                    <?php     echo '<script>
                        Swal.fire({
                            position: "center",
                            icon: "warning",
                            title: "SELECT ELECTIVE SUBJECT",
                            showConfirmButton: false,
                            timer: 1500
                          });
                        </script>';
                        header("refresh:2;");
                    ?>
                </div> <?php
                    }
                }
                        ?>
        <?php

        require('tcpdf/tcpdf.php');
        require '../vendor/autoload.php';

        use PhpOffice\PhpSpreadsheet\Spreadsheet;
        use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

        if (isset($_POST['enroll_student'])) {

            $c_n =  $_SESSION['CLASS_name'];
            $sql = oci_parse($conn, "select * from sub_class where class_name = '$c_n' ");
            oci_execute($sql);
            while ($r = oci_fetch_array($sql)) {
                $cc  = $r['CLASS'];
                $sub_code = $r['SUB_CODE'];
            }
            if (isset($_POST['enroll']) && !empty($_POST['enroll'])) {
                $selectedStudentIds = $_POST['enroll'];
                foreach ($selectedStudentIds as $studentId) {
                    $sql = oci_parse($conn, "select * from CLASS_STUDENT WHERE STUD_ID = '$studentId' ");
                    //     echo "select * from CLASS_STUDENT WHERE STUD_ID = '$studentId' ";
                    oci_execute($sql);
                    if (oci_fetch_all($sql, $a) == 0) {
                        $sql = oci_parse($conn, "insert into class_student (S_ID,SUB_CODE,CLASS,STUD_ID) VALUES ($sid,$sub_code,$cc,'$studentId') ");
                        $get_subj = oci_parse($conn, "select * from subject where subs = $sub_code and sub_type = 'CORE' ");
                        oci_execute($get_subj);
                        oci_execute($sql);
                        while ($r = oci_fetch_array($get_subj)) {
                            $s_code = $r['SUB_CODE'];
                            $insert_subj = oci_parse($conn, "insert into student_subject (S_ID,SUB_CODE,CLASS,STUD_ID) values ($sid,$s_code,$cc,'$studentId')");
                            oci_execute($insert_subj);
                        }


                        $get_fee = oci_parse($conn, "select sum(cost) from tuition where s_id= $sid and sub_code = $sub_code ");
                        oci_execute($get_fee);
                        while ($r = oci_fetch_array($get_fee)) {
                            $fee = $r['SUM(COST)'];
                        }


                        $check = oci_parse($conn, "select * from student_finance where stud_id = '$studentId' ");
                        oci_execute($check);

                        if (oci_fetch_all($check, $a) == 0) {
                            $sql = oci_parse($conn, "insert into student_finance (s_id,class,stud_id,fee,balance,SUB_CODE)  values ($sid,$cc,'$studentId',$fee,$fee,$sub_code)");
                            oci_execute($sql);
                        }

                        $upd =  oci_parse($conn, "update student set status = 'SEMI-ENROLLED' WHERE  STUD_ID = '$studentId' ");
                        oci_execute($upd);
        ?><div style="font-size:15px;
                            color: green;
                            position: relative;
                             display:flex;
                            animation:button .3s linear;text-align: center;">
                            <?php
                                echo '<script>
                                Swal.fire({
                                    position: "center",
                                    icon: "success",
                                    title: "SELECTED STUDENT ENROLLED AND ASSIGNED SUBJECTS",
                                    showConfirmButton: false,
                                    timer: 1500
                                  });
                                </script>';
                          //  echo "SELECTED STUDENT ENROLLED AND ASSIGNED SUBJECTS";
                            header("refresh:2;");
                            ?>
                        </div> <?php
                            } else {
                                ?><div style="font-size:15px;
                            color: red;
                            position: relative;
                             display:flex;
                            animation:button .3s linear;text-align: center;">
                            <?php     echo '<script>
                        Swal.fire({
                            position: "center",
                            icon: "error",
                            title: "STUDENT ALREADY ENROLLED",
                            showConfirmButton: false,
                            timer: 1500
                          });
                        </script>';
                                //    header("refresh:2;");
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
                    <?php     echo '<script>
                        Swal.fire({
                            position: "center",
                            icon: "warning",
                            title: "NO STUDENT SELECTED",
                            showConfirmButton: false,
                            timer: 1500
                          });
                        </script>';
                        header("refresh:2;");
                    ?>
                </div> <?php
                    }
                }

                if (isset($_POST['enroll_all'])) {
                    //   echo 1;
                    $sc = $_SESSION['SUB_CODE'];
                    $sql = "select * from student A JOIN STUDENT_ACADEMIC C ON (A.STUD_ID=C.STUD_ID) WHERE A.STATUS = 'REGISTERED' AND C.SUB_CODE= $sc ORDER BY A.CREATE_DT DESC";
                    //   echo $sql;
                    $stid = oci_parse($conn, $sql);
                    oci_execute($stid);
                    while ($r = oci_fetch_array($stid)) {
                        $studentId = $r["STUD_ID"];
                        $c_n =  $_SESSION['CLASS_name'];
                        $sql = oci_parse($conn, "select * from sub_class where class_name = '$c_n' ");
                        oci_execute($sql);
                        while ($r = oci_fetch_array($sql)) {
                            $cc  = $r['CLASS'];
                            $sub_code = $r['SUB_CODE'];
                        }

                        $sql = oci_parse($conn, "select * from CLASS_STUDENT WHERE STUD_ID = '$studentId' ");
                        oci_execute($sql);
                        if (oci_fetch_all($sql, $a) == 0) {
                            $sql = oci_parse($conn, "insert into class_student (S_ID,SUB_CODE,CLASS,STUD_ID) VALUES ($sid,$sub_code,$cc,'$studentId') ");
                            //  echo "insert into class_student (S_ID,SUB_CODE,CLASS,STUD_ID) VALUES ($sid,$sub_code,$cc,'$studentId') ";
                            $get_subj = oci_parse($conn, "select * from subject where subs = $sub_code and sub_type = 'CORE' ");
                            //    echo "select * from subject where subs = $sub_code and sub_type = 'CORE' ";
                            oci_execute($get_subj);
                            oci_execute($sql);
                            while ($r = oci_fetch_array($get_subj)) {
                                $s_code = $r['SUB_CODE'];
                                $insert_subj = oci_parse($conn, "insert into student_subject (S_ID,SUB_CODE,CLASS,STUD_ID) values ($sid,$s_code,$cc,'$studentId')");

                                oci_execute($insert_subj);
                            }


                            $get_fee = oci_parse($conn, "select sum(cost) from tuition where s_id= $sid and sub_code = $sub_code ");
                            oci_execute($get_fee);
                            while ($r = oci_fetch_array($get_fee)) {
                                $fee = $r['SUM(COST)'];
                            }


                            $check = oci_parse($conn, "select * from student_finance where stud_id = '$studentId' ");
                            oci_execute($check);

                            if (oci_fetch_all($check, $a) == 0) {
                                $sql = oci_parse($conn, "insert into student_finance (s_id,class,stud_id,fee,balance,SUB_CODE)  values ($sid,$cc,'$studentId',$fee,$fee,$sub_code)");
                                oci_execute($sql);
                            }

                            $upd =  oci_parse($conn, "update student set status = 'SEMI-ENROLLED' WHERE  STUD_ID = '$studentId' ");
                            oci_execute($upd);
                            echo '<script>
                            Swal.fire({
                                position: "center",
                                icon: "success",
                                title: "SELECTED STUDENT ENROLLED AND ASSIGNED SUBJECTS",
                                showConfirmButton: false,
                                timer: 1500
                              });
                            </script>';
                            header("refresh:2;");
                        ?>
                    </div> <?php
                        } else {
                            echo '<script>
                            Swal.fire({
                                position: "center",
                                icon: "error",
                                title: "STUDENT ALREADY ENROLLED",
                                showConfirmButton: false,
                                timer: 1500
                              });
                            </script>';
                            header("refresh:2;");
                        ?>
                    </div> <?php
                        }
                    }
                }
                            ?>
        <div class="input-field">

            <select required name="class_list">
                <option disabled selected>Select Grade To Enroll</option>
                <?php

                $get_hos = "select DISTINCT(CLASS_NAME) from SUB_CLASS A JOIN STUDENT_ACADEMIC B ON (A.SUB_CODE=B.SUB_CODE) WHERE a.S_ID= $sid order by a.class_name";
                //  echo $get_hos;
                $get = oci_parse(oci_connect($username, $password, $connection), $get_hos);
                oci_execute($get);
                while ($row = oci_fetch_array($get)) {
                ?><option>
                        <?php echo $row["CLASS_NAME"]; ?>
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
text-decoration: none;" name="generate_sub" type="submit">
            GENERATE PDF OF SUBJECT LIST FOR STUDENT
            <i class="uil uil-envelope-upload"></i>
        </button>
        </div>
        <div class="buttons">

            <button class="backBtn" type="submit">

                <a class="btnText" href="registra.php">
                    BACK
                </a>
            </button>
        </div>
        <?php
        require 'C:\wamp64\www\Academix\KOTU SENIOR SECONDARY SCHOOL\Sec_Registra\PHPMailer.php';
        require 'C:\wamp64\www\Academix\KOTU SENIOR SECONDARY SCHOOL\Sec_Registra\Exception.php';
        require 'C:\wamp64\www\Academix\KOTU SENIOR SECONDARY SCHOOL\Sec_Registra\SMTP.php';



        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\Exception;

        if (isset($_POST['generate_sub'])) {
            if (isset($_POST['class_list'])) {
                $class = $_POST['class_list'];
                $sql = oci_parse($conn, "select * from sub_class where s_id = $sid and class_name = '$class' ");
                oci_execute($sql);
                while ($row = oci_fetch_array($sql)) {
                    $code = $row["SUB_CODE"];
                }
                $sql = oci_parse($conn, "select B.STUD_ID,B.NAME,C.EMAIL AS STU_EMAIL,D.EMAIL from class_student a join student b on (a.stud_id=b.stud_id) join student_contact c on (a.stud_id=c.stud_id) join student_authourity d on (a.stud_id=d.stud_id) where a.sub_code = $code and b.status != 'GRADUATED' and c.email IS NOT NULL OR D.EMAIL IS NOT NULL and b.stud_id = '04202023' ");
                oci_execute($sql);
                if (oci_fetch_all($sql, $a) > 0) {
                    oci_execute($sql);
                    while ($row = oci_fetch_array($sql)) {

                        $stud_id = $row['STUD_ID'];
                        $name = $row['NAME'];
                        $stu_email = $row['STU_EMAIL'];
                        $emails = $row['EMAIL'];

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
                        $pdf->Cell(0, 140, 'SUBJECT LIST FOR ' . $name, 0, 1, 'L');
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

                        $s = "SELECT DISTINCT(B.SUBJECT) FROM STUDENT_SUBJECT A JOIN WAEC_SUBJECT B ON (A.SUB_CODE=B.SUB_CODE)  WHERE A.STUD_ID = '$stud_id'  ORDER BY B.SUBJECT";
                        //  echo $s;
                        $stmts = oci_parse($conn, $s);
                        oci_execute($stmts);

                        $pdf->SetFont('courier', 'B', 14); // Set a larger font size for the heading
                        $pdf->Cell(40, 10, 'Subjects', 0, 0, 'C');
                        $pdf->Ln();
                        // Table content without borders
                        $pdf->SetFont('courier', '', 10); // Reset font style
                        while ($row = oci_fetch_assoc($stmts)) {
                            $sub = $row['SUBJECT'];
                            $type = $row['SUB_TYPE'];
                            $pdf->Cell(40, 10, $sub, 0, 1, 'C');
                        }
                        $pdf->Ln();
                        $s = "SELECT COUNT(A.SUB_CODE) AS T_SUB FROM STUDENT_SUBJECT A JOIN WAEC_SUBJECT B ON (A.SUB_CODE=B.SUB_CODE) WHERE A.STUD_ID = '$stud_id' ORDER BY B.SUBJECT";
                        $stmts = oci_parse($conn, $s);
                        oci_execute($stmts);
                        while ($row = oci_fetch_assoc($stmts)) {
                            $num = $row['T_SUB'];
                        }
                        $pdf->Cell(40, 10, 'Total Number of Subjects : ' . $num, 0, 0, 'C');
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
                        $disclaimer = "Powered By NIFTY ICT SOLUTIONS LIMITED";
                        $pdf->SetFont('dejavusans', 'I', 8);
                        $pdf->Cell(0, 5, $disclaimer, 0, 0, 'C');
                        $directoryPath = 'C:\ACADEMIX\\' . $school . '\generated_reports\subject_list\\';
                        if (!is_dir($directoryPath)) {
                            if (!mkdir($directoryPath, 0777, true)) {
                                die('Failed to create directories.');
                            }
                        }
                        $filePath = $directoryPath . $name . '_' . $stud_id . '_' . 'SUBJECTS.pdf';
                        $pdf->Output($filePath, 'F');
                        $fileName = $name . '_' . $stud_id . '_' . 'SUBJECTS.pdf';
                        /* header('Content-type: application/pdf');
                        header('Content-Disposition: attachment; filename="' . $fileName . '"');
                        header('Content-Transfer-Encoding: binary');
                        header('Accept-Ranges: bytes');
                        @readfile($filePath); 

                        $path = $filePath;
                        header("Content-Length: " . filesize($path));
                        header("Content-type: application/pdf");
                        header("Content-disposition: attachment; filename=" . basename($path));
                        header('Expires: 0');
                        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
                        ob_clean();
                        flush();
                        @readfile($path); */
                        if ($stu_email != '') {

                            $mail = new PHPMailer();
                            $mail->isSMTP();
                            $mail->Host = 'smtp.gmail.com';
                            $mail->Port = 587;
                            $mail->SMTPAuth = true;
                            $mail->SMTPSecure = 'tls';
                            $mail->Username = 'jabubacarr17@gmail.com';
                            $mail->Password = 'lqxwxdlgijmhvylh';
                            $mail->setFrom('jabubacarr17@gmail.com');
                            $mail->addAddress($stu_email);
                            $mail->isHTML(true);
                            $mail->addAttachment($filePath);
                            $mail->Subject = 'Subject List';
                            $mail->Body = '<p color:#fff;font-size: 15px;>This email contains an attached pdf file of your subject list for this academic year</p><br><br><pcolor:#fff;font-size: 15px;>The staff and board of ' . $school . ' wish you all the best in this coming academic year and pass all your subjects with flying colours!!!INSHALLAH AND AMEN<p/><p color:#fff;font-size: 13px;>This is an auto generated email sent to you by ' . $school . '</p>';
                            $mail->send();
                        }
                        if ($email != '') {

                            $mail = new PHPMailer();
                            $mail->isSMTP();
                            $mail->Host = 'smtp.gmail.com';
                            $mail->Port = 587;
                            $mail->SMTPAuth = true;
                            $mail->SMTPSecure = 'tls';
                            $mail->Username = 'jabubacarr17@gmail.com';
                            $mail->Password = 'lqxwxdlgijmhvylh';
                            $mail->setFrom('jabubacarr17@gmail.com');
                            $mail->addAddress($emails);
                            $mail->isHTML(true);
                            $mail->addAttachment($filePath);
                            $mail->Subject = 'Subject List';
                            $mail->Body = '<p color:#fff;font-size: 15px;>This email contains an attached pdf file of your subject list for this academic year</p><br><br><pcolor:#fff;font-size: 15px;>The staff and board of ' . $school . ' wish you all the best in this coming academic year and pass all your subjects with flying colours!!!INSHALLAH AND AMEN<p/><p color:#fff;font-size: 13px;>This is an auto generated email sent to you by ' . $school . '</p>';
                            $mail->send();
                        }
                    }
        ?><div style="font-size:15px;
                  color: green;
                  position: relative;
                   display:flex;
                  animation:button .3s linear;text-align: center;">
                    <?php echo "SUBJECT LIST FOR GENERATED";
                    header("refresh:2;");
                } else {
                    ?><div style="font-size:15px;
                color: red;
                position: relative;
                 display:flex;
                animation:button .3s linear;text-align: center;">
                            <?php echo "NO STUDENT IN THIS CLASS OR NO EMAIL ASSIGNED TO THE STUDENT";
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
                        <?php echo "SELECT CLASS";
                            header("refresh:2;");
                        ?>
                    </div> <?php
                        }
                    }
                            ?>

    </form>
    <script>
        $(document).ready(function() {
            $('#example').DataTable();
        });
    </script>
</body>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</html>