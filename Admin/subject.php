<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/shows.css">
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
<?php
ob_start();
$school =  $_SESSION['school'];
$sid = $_SESSION['sid'];
//$sub_code = $_SESSION['s_code'];
include 'connect.php'; ?>

<body>
    <form class="container" enctype="multipart/form-data" action="subject.php" method="post">
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
        <header>Department And Subject Management</header>
        <div class="input-field">
            <select id="class" name="class" onchange="handleClassSelection(this)">
                <option disabled selected>Select Class</option>
                <?php
                $get_hos = "select * from sub_class WHERE S_ID= $sid
  ORDER BY CLASS_NAME";
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
        <?php // echo $get_hos 
        ?>
        <button style=" display: inline-block;
  padding: 6px 12px;
  background-color: #04716f;
  color: white;
  border: none;
  border-radius: 4px;
  text-decoration: none;" name="filter" type="submit">
            FILTER BY CLASS
            <i class="uil uil-filter"></i>
        </button>

        <?php
        $sub_code = 0;
        $cl = "";
        $pr_id = 0;
        $class = "";
        if (isset($_POST['filter'])) {
            if (isset($_POST['class'])) {
                //    $_SESSION['class'] = $_POST['class'];
                $class = $_POST['class'];
                $cl = $class;
                $_SESSION['CLASS_NAME'] = $_POST['class'];
                $sql = oci_parse($conn, "select * from sub_class where class_name = '$class' ");
                //    echo "select * from sub_class where class_name = '$class' ";
                oci_execute($sql);
                while ($r = oci_fetch_array($sql)) {
                    $sub_code = $r['SUB_CODE'];
                    $_SESSION['sub_code'] = $sub_code;
                    $class_name = $r['SUB_TITLE'];
                    $c = $r['CLASS'];
                }
                $sql = oci_parse($conn, "select * from prog_class where class = '$class_name' ");
                //   echo "select * from prog_class where class = '$class_name' ";
                oci_execute($sql);
                while ($a = oci_fetch_array($sql)) {

                    $pr_id = $a['PROG_ID'];
                    $_SESSION['pr_id'] = $pr_id;
                }
            } else {
        ?><div style="font-size:15px;
                color: red;
                position: relative;
                 display:flex;
                animation:button .3s linear;text-align: center;">
                    <?php echo "SELECT CLASS";
                    header("refresh:3;");
                    ?>
                </div> <?php
                    }
                }
                        ?>
        <div>
            <label>Filtered Class: <?php echo $cl ?></label>
        </div>
        <?php
        include 'connect.php';

        if ($conn) {

            $sql = "select c.class_name,b.subject,b.sub_type,b.sub_code from subject b join sub_class c on (b.subs=c.sub_code) where b.s_id = $sid and b.subs = $sub_code  order by c.class_name , b.sub_type  ";
            //    echo $sql;
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
        <div style="overflow-x:auto;">
            <table class="table-content" style="font-size: 14px; border-collapse: collapse; margin: 10px 0; font: 0.9em; border-radius: 5px 5px; box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);">
                <thead>
                    <tr style="background-color: #04716f; color: #ffffff; text-align: left; font-weight: bold;">
                        <th style="padding: 5px 8px; font-size: 10px; margin: 5px;">Class</th>
                        <th style="padding: 5px 8px; font-size: 10px; margin: 5px;">Subject</th>
                        <th style="padding: 5px 8px; font-size: 10px; margin: 5px;">Subject Code</th>
                        <th style="padding: 5px 8px; font-size: 10px; margin: 5px;">Subject Type</th>
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
                                <td style="padding: 5px 8px; font-size: 10px; margin: 5px;"><?php echo $row['CLASS_NAME']; ?></td>
                                <td style="padding: 5px 8px; font-size: 10px; margin: 5px;"><?php echo $row['SUBJECT']; ?></td>
                                <td style="padding: 5px 8px; font-size: 10px; margin: 5px;"><?php echo $row['SUB_CODE']; ?></td>
                                <td style="padding: 5px 8px; font-size: 10px; margin: 5px;"><?php echo $row['SUB_TYPE']; ?></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <?php
        include 'connect.php';
        if (isset($_POST['establish'])) {
            if (isset($_POST['prog'])) {
                $prog = $_POST['prog'];
                $sql = oci_parse($conn, "select * from programme where prog = '$prog' ");
                oci_execute($sql);
                while ($row = oci_fetch_array($sql)) {
                    $pr_id = $row["PROG_ID"];
                }
                if (isset($_POST['type'])) {
                    $type = $_POST['type'];
                    $sub = $_POST['waec'];
                    if ($sub != '') {
                        //     $class = $_SESSION['class'];
                        //    $type = $_POST['type'];
                        $waec = strtoupper($_POST['waec']);
                        //   $pr_id =  $_SESSION['pr_id'];
                        //   $sub_code = $_SESSION['sub_code'];
                        $sql = oci_parse($conn, "insert into sub_incre (sub) values ('$waec')");
                        oci_execute($sql);

                        $get_subin = oci_parse($conn, "select * from sub_incre where sub='$waec' ");
                        oci_execute($get_subin);
                        while ($r = oci_fetch_array($get_subin)) {
                            $in = $r['CODE'];
                        }

                        $sql = oci_parse($conn, "select * from waec_subject where subject = '$waec' or sub_code = $in ");
                        oci_execute($sql);


                        if (oci_fetch_all($sql, $a) == 0) {
                            $sql = oci_parse($conn, "insert into waec_subject (sub_code,subject,exam) values ($in,'$waec','WASSCE')");


                            if (oci_execute($sql)) {
                                $sql = oci_parse($conn, "insert into prog_subject (prog_id,sub_code,prog_sub_type) values ($pr_id,$in,'$type')");
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
                                title: "' . $waec . ' ADDED SUCESSFULLY",
                                showConfirmButton: false,
                                timer: 1500
                              });
                            </script>';
                                    header("refresh:3;"); ?>
                                </div> <?php
                                    } else {
                                        ?><div style="font-size:15px;
                                color: red;
                                position: relative;
                                 display:flex;
                                animation:button .3s linear;text-align: center;">
                                    <?php echo "ERROR ADDING $waec";
                                        header("refresh:3;"); ?>
                                </div> <?php
                                    }
                                    /*    $sql = oci_parse($conn,"insert into waec_subject (sub_code,subject,exam) values ($in,'$waec','WASSCE')");
                            oci_execute($sql);
    
                            $sql = oci_parse($conn,"insert into prog_subject (prog_id,sub_code,prog_sub_type) values ($pr_id,$in,'$type')");
                       //     oci_execute($sql);
                         //   $sql = oci_parse($conn,"insert into subject (sub_code,subject,sub_type,class,s_id,subs) values ($in,'$waec','$type',$c,$sid,$sub_code)");
                            if(oci_execute($sql)){
                                ?><div style="font-size:15px;
                                color: red;
                                position: relative;
                                 display:flex;
                                animation:button .3s linear;text-align: center;">
                        <?php echo "$waec ADDED SUCCESSFULLY";
                            header("refresh:3;"); ?>
                    </div> <?php
                            }else {
                                ?><div style="font-size:15px;
                                color: red;
                                position: relative;
                                 display:flex;
                                animation:button .3s linear;text-align: center;">
                        <?php echo "ERROR ADDING $waec";
                            header("refresh:3;"); ?>
                    </div> <?php
                            } */
                                } else {
                                    ///   $sql = oci_parse($conn, "insert into waec_subject (sub_code,subject,exam) values ($in,'$waec','WASSCE')");

                                    $sql = oci_parse($conn, "SELECT * FROM WAEC_SUBJECT WHERE SUBJECT = '$waec'");
                                    oci_execute($sql);
                                    while ($r=oci_fetch_array($sql)) {
                                        $in = $r['SUB_CODE'];
                                    }

                                    $sql = oci_parse($conn, "insert into prog_subject (prog_id,sub_code,prog_sub_type) values ($pr_id,$in,'$type')");
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
                                        title: "' . $waec . ' ADDED SUCESSFULLY",
                                        showConfirmButton: false,
                                        timer: 1500
                                      });
                                    </script>';
                                    header("refresh:3;"); ?>
                            </div> <?php

                                    /*    $sql = oci_parse($conn,"insert into waec_subject (sub_code,subject,exam) values ($in,'$waec','WASSCE')");
                                    oci_execute($sql);
            
                                    $sql = oci_parse($conn,"insert into prog_subject (prog_id,sub_code,prog_sub_type) values ($pr_id,$in,'$type')");
                               //     oci_execute($sql);
                                 //   $sql = oci_parse($conn,"insert into subject (sub_code,subject,sub_type,class,s_id,subs) values ($in,'$waec','$type',$c,$sid,$sub_code)");
                                    if(oci_execute($sql)){
                                        ?><div style="font-size:15px;
                                        color: red;
                                        position: relative;
                                         display:flex;
                                        animation:button .3s linear;text-align: center;">
                                <?php echo "$waec ADDED SUCCESSFULLY";
                                    header("refresh:3;"); ?>
                            </div> <?php
                                    }else {
                                        ?><div style="font-size:15px;
                                        color: red;
                                        position: relative;
                                         display:flex;
                                        animation:button .3s linear;text-align: center;">
                                <?php echo "ERROR ADDING $waec";
                                    header("refresh:3;"); ?>
                            </div> <?php
                                    } */
                                }
                            } else {
                                    ?><div style="font-size:15px;
                                    color: red;
                                    position: relative;
                                     display:flex;
                                    animation:button .3s linear;text-align: center;">
                            <?php echo "ENTER SUBJECT";
                                header("refresh:3;"); ?>
                        </div> <?php
                            }
                        } else {
                                ?><div style="font-size:15px;
                    color: red;
                    position: relative;
                     display:flex;
                    animation:button .3s linear;text-align: center;">
                        <?php echo "SELECT TYPE";
                            header("refresh:3;"); ?>
                    </div> <?php
                        }
                    } else {
                            ?><div style="font-size:15px;
                color: red;
                position: relative;
                 display:flex;
                animation:button .3s linear;text-align: center;">
                    <?php echo "SELECT PROGRAMME";
                        header("refresh:3;"); ?>
                </div> <?php
                    }
                    /*      if(isset($_POST['class'])){
                $_SESSION['class']= $_POST['class'];
               $class = $_POST['class'];
               $cl = $class;
               $sql = oci_parse($conn,"select * from sub_class where class_name = '$class' ");
               oci_execute($sql);
               while($r = oci_fetch_array($sql)){
                $sub_code = $r['SUB_CODE'];
                $_SESSION['sub_code']=$sub_code;
                $class_name = $r['SUB_TITLE'];
                $c = $r['CLASS'];
               }
               $sql = oci_parse($conn,"select * from prog_class where class = '$class_name' ");
               oci_execute($sql);
               while($a = oci_fetch_array($sql)){
                $pr_id = $a['PROG_ID'];
                $_SESSION['pr_id']=$pr_id;
               } */
                    //  if(isset($_POST['type'])){

                    /*else {
                ?><div style="font-size:15px;
                color: red;
                position: relative;
                 display:flex;
                animation:button .3s linear;text-align: center;">
        <?php echo "SELECT TYPE";
            header("refresh:3;"); ?>
    </div> <?php
            } */
                } /*else {
                ?><div style="font-size:15px;
                color: red;
                position: relative;
                 display:flex;
                animation:button .3s linear;text-align: center;">
                    <?php echo "SELECT CLASS";
                    header("refresh:3;"); 
                    ?>
                </div> <?php
            } */

                //       }

                        ?>
        <?php
        if (isset($_POST["edit_pro"])) {
            if (isset($_POST["edit_prog"])) {
                if (isset($_POST["edit_prog"])) {
                } else {
        ?><div style="font-size:15px;
                   color: red;
                   position: relative;
                    display:flex;
                   animation:button .3s linear;text-align: center;">
                        <?php echo "SELECT PROGRAMME";
                        header("refresh:3;"); ?>
                    </div> <?php
                        }
                    } else {
                            ?><div style="font-size:15px;
                color: red;
                position: relative;
                 display:flex;
                animation:button .3s linear;text-align: center;">
                    <?php echo "SELECT PROGRAMME";
                        header("refresh:3;"); ?>
                </div> <?php
                    }
                }
                        ?>
    
        <?php
        if (isset($_POST['ass_sub'])) {
            if (isset($_POST['enroll']) && !empty($_POST['enroll'])) {
                $selectedsubjects = $_POST['enroll'];
                foreach ($selectedsubjects as $sub_code) {
                    $class_name = $_SESSION['CLASS_NAME'];

                    $sql = oci_parse($conn, "select * from sub_class where class_name = '$class_name' ");
                    oci_execute($sql);
                    while ($r = oci_fetch_array($sql)) {
                        $ss = $r['SUB_CODE'];
                        $_SESSION['sub_code'] = $ss;
                        $class_name = $r['SUB_TITLE'];
                        $c = $r['CLASS'];
                    }
                    $sql = oci_parse($conn, "select * from prog_class where sub_code= $ss ");
                    //   echo "select * from prog_class where sub_code= $ss ";
                    oci_execute($sql);
                    while ($a = oci_fetch_array($sql)) {
                        $pr_id = $a['PROG_ID'];
                        $_SESSION['pr_id'] = $pr_id;
                    }
                    $sql = oci_parse($conn, "select b.sub_code,a.prog_sub_type,b.subject from prog_subject a join waec_subject b on (a.sub_code=b.sub_code) where a.sub_code = '$sub_code' and a.prog_id =$pr_id ");
                    //   echo "select b.sub_code,a.prog_sub_type,b.subject from prog_subject a join waec_subject b on (a.sub_code=b.sub_code) where a.sub_code = '$sub_code' and a.prog_id =$pr_id ";
                    oci_execute($sql);
                    while ($r = oci_fetch_array($sql)) {
                        $in = $r['SUB_CODE'];
                        $type = $r['PROG_SUB_TYPE'];
                        $sub = $r['SUBJECT'];
                    }
                    if ($type == 'CORE') {
                        $hrs = 4;
                    } else if ($type == 'ELECTIVE') {
                        $hrs = 3;
                    }
                    //  echo "select * from subject where subject = '$sub' and subs = $sub_code ";
                    $sql = oci_parse($conn, "select * from subject where subject = '$sub' and sub_code = $sub_code and subs = $in");
                    //    echo "select * from subject where subject = '$sub' and sub_code = $sub_code and subs = $in";
                    oci_execute($sql);
                    if (oci_fetch_all($sql, $a) > 0) {
                        continue;
                    }
                    $sql = oci_parse($conn, "insert into subject (sub_code,subject,sub_type,class,s_id,subs,SUBJECT_CREDIT_HRS) values ($in,'$sub','$type',$c,$sid,$ss,$hrs)");
                    //      echo "insert into subject (sub_code,subject,sub_type,class,s_id,subs) values ($in,'$sub','$type',$c,$sid,$ss)";
                    oci_execute($sql);
        ?><div style="font-size:15px;
                             color: green;
                             position: relative;
                              display:flex;
                             animation:button .3s linear;text-align: center;">
                        <?php echo "$sub ASSIGNED SUCCESSFULLY";
                        header("refresh:3;"); ?>
                    </div> <?php
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
                }
                        ?>
    
        <?php
        if (isset($_POST['edit_sub'])) {
            if ($class == '') {

                $_SESSION['class'] = $_POST['class'];
                $class_name = $_SESSION['CLASS_NAME'];
                $class = $class_name;
                $cl = $class;
                $sql = oci_parse($conn, "select * from sub_class where class_name = '$class' ");
                oci_execute($sql);
                while ($r = oci_fetch_array($sql)) {
                    $sub_code = $r['SUB_CODE'];
                    $_SESSION['sub_code'] = $sub_code;
                    $class_name = $r['SUB_TITLE'];
                    $c = $r['CLASS'];
                }
                $sql = oci_parse($conn, "select * from prog_class where class = '$class_name' ");
                oci_execute($sql);
                while ($a = oci_fetch_array($sql)) {
                    $pr_id = $a['PROG_ID'];
                    $_SESSION['pr_id'] = $pr_id;
                }
                if (isset($_POST['edit_waec'])) {

                    $sub = $_POST['edit_waec'];
                    $sql = oci_parse($conn, "select * from waec_subject a join prog_subject b on (a.sub_code=b.sub_code)  where a.subject = '$sub' ");
                    oci_execute($sql);
                    while ($r = oci_fetch_array($sql)) {
                        $sub_code = $r['SUB_CODE'];
                    }
                    if (isset($_POST['edit_type'])) {
                        $type = $_POST['edit_type'];
                        $pr_id = $_SESSION['pr_id'];
                        //   echo "update prog_subject set prog_sub_type = '$type' where prog_id = $pr_id and sub_code = $sub_code ";
                        $sql = oci_parse($conn, "update prog_subject set prog_sub_type = '$type' where prog_id = $pr_id and sub_code = $sub_code ");
                        oci_execute($sql);
                        $sql = oci_parse($conn, "update subject set sub_type = '$type' where sub_code = '$sub_code' ");
                        oci_execute($sql);
                        $sql = oci_parse($conn, "select * from prog_subject where prog_sub_type = '$type' and prog_id = $pr_id and sub_code = $sub_code ");
                        oci_execute($sql);
                        $check = oci_parse($conn, "select * from subject where sub_type = '$type' and sub_code = $sub_code");
                        oci_execute($check);
                        if ((oci_fetch_all($sql, $a) > 0) && (oci_fetch_all($check, $b) > 0)) {
        ?><div style="font-size:15px;
                            color: green;
                            position: relative;
                             display:flex;
                            animation:button .3s linear;text-align: center;">
                                <?php echo "$sub EDITED SUCESSFULLY";
                                header("refresh:3;"); ?>
                            </div> <?php
                                } else {
                                    ?><div style="font-size:15px;
                            color: red;
                            position: relative;
                             display:flex;
                            animation:button .3s linear;text-align: center;">
                                <?php echo "ERROR EDITING $sub";
                                    header("refresh:3;"); ?>
                            </div> <?php
                                }
                            } else {
                                    ?><div style="font-size:15px;
                    color: red;
                    position: relative;
                     display:flex;
                    animation:button .3s linear;text-align: center;">
                            <?php echo "SELECT SUBJECT TYPE";
                                header("refresh:3;"); ?>
                        </div> <?php
                            }
                        } else {
                                ?><div style="font-size:15px;
                        color: red;
                        position: relative;
                         display:flex;
                        animation:button .3s linear;text-align: center;">
                        <?php echo "SELECT SUBJECT";
                            header("refresh:3;"); ?>
                    </div> <?php
                        }
                    } else {
                        if (isset($_POST['edit_waec'])) {

                            $sub = $_POST['edit_waec'];
                            $sql = oci_parse($conn, "select * from waec_subject a join prog_subject b on (a.sub_code=b.sub_code)  where a.subject = '$sub' ");
                            oci_execute($sql);
                            while ($r = oci_fetch_array($sql)) {
                                $sub_code = $r['SUB_CODE'];
                            }
                            if (isset($_POST['edit_type'])) {
                                $type = $_POST['edit_type'];
                                $pr_id = $_SESSION['PR'];
                                //   echo "update prog_subject set prog_sub_type = '$type' where prog_id = $pr_id and sub_code = $sub_code ";
                                $sql = oci_parse($conn, "update prog_subject set prog_sub_type = '$type' where prog_id = $pr_id ");
                                oci_execute($sql);
                                $sql = oci_parse($conn, "update subject set sub_type = '$type' where sub_code = '$sub_code' ");
                                oci_execute($sql);
                                $sql = oci_parse($conn, "select * from prog_subject where prog_sub_type = '$type' and prog_id = $pr_id ");
                                oci_execute($sql);
                                $check = oci_parse($conn, "select * from subject where sub_type = '$type' and sub_code = $sub_code");
                                oci_execute($check);
                                if ((oci_fetch_all($sql, $a) > 0) && (oci_fetch_all($check, $b) > 0)) {
                            ?><div style="font-size:15px;
                            color: green;
                            position: relative;
                             display:flex;
                            animation:button .3s linear;text-align: center;">
                                <?php echo "$sub EDITED SUCESSFULLY";
                                    header("refresh:3;"); ?>
                            </div> <?php
                                } else {
                                    ?><div style="font-size:15px;
                            color: red;
                            position: relative;
                             display:flex;
                            animation:button .3s linear;text-align: center;">
                                <?php echo "ERROR EDITING $sub";
                                    header("refresh:3;"); ?>
                            </div> <?php
                                }
                            } else {
                                    ?><div style="font-size:15px;
                    color: red;
                    position: relative;
                     display:flex;
                    animation:button .3s linear;text-align: center;">
                            <?php echo "SELECT SUBJECT TYPE";
                                header("refresh:3;"); ?>
                        </div> <?php
                            }
                        } else {
                                ?><div style="font-size:15px;
                        color: red;
                        position: relative;
                         display:flex;
                        animation:button .3s linear;text-align: center;">
                        <?php echo "SELECT SUBJECT";
                            header("refresh:3;"); ?>
                    </div> <?php
                        }
                    }
                }
                            ?>

          
        <?php
        if (isset($_POST['rem_sub'])) {
            $class_name = $_SESSION['CLASS_NAME'];
            $class = $class_name;
            $cl = $class;
            $sql = oci_parse($conn, "select * from sub_class where class_name = '$class' ");
            oci_execute($sql);
            while ($r = oci_fetch_array($sql)) {
                $sub_code = $r['SUB_CODE'];
                $_SESSION['sub_code'] = $sub_code;
                $class_name = $r['SUB_TITLE'];
                $c = $r['CLASS'];
            }
            $sql = oci_parse($conn, "select * from prog_class where class = '$class_name' ");
            oci_execute($sql);
            while ($a = oci_fetch_array($sql)) {
                $pr_id = $a['PROG_ID'];
                $_SESSION['pr_id'] = $pr_id;
            }
            if (isset($_POST['rem_waec'])) {
                $sub = $_POST['rem_waec'];
                $sql = oci_parse($conn, "select * from waec_subject where subject = '$sub' ");
                oci_execute($sql);
                while ($r = oci_fetch_array($sql)) {
                    $sub_code = $r['SUB_CODE'];
                }
                $sql = oci_parse($conn, "delete from subject where class = $c and sub_code = $sub_code ");
                oci_execute($sql);
                $sql = oci_parse($conn, "select * from subject where class = $c and sub_code = $sub_code");
                oci_execute($sql);
                if (oci_fetch_all($sql, $a) == 0) {
        ?><div style="font-size:15px;
                        color: green;
                        position: relative;
                         display:flex;
                        animation:button .3s linear;text-align: center;">
                        <?php echo "$sub REMOVED SUCESSFULLY";
                        header("refresh:3;"); ?>
                    </div> <?php
                        } else {
                            ?><div style="font-size:15px;
                        color: red;
                        position: relative;
                         display:flex;
                        animation:button .3s linear;text-align: center;">
                        <?php echo "ERROR REMOVING SUBJECT FROM CLASS";
                            header("refresh:3;"); ?>
                    </div> <?php
                        }
                    } else {
                            ?><div style="font-size:15px;
                    color: red;
                    position: relative;
                     display:flex;
                    animation:button .3s linear;text-align: center;">
                    <?php echo "SELECT SUBJECT";
                        header("refresh:3;"); ?>
                </div> <?php
                    }
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

    </script>
</body>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</html>