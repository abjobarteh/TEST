<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/shows.css">
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
    <form class="container" enctype="multipart/form-data" action="subject.php" method="post">
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
        <header>Department And Subject Management</header>
        <?php
        include 'connect.php';

        if ($conn) {
            $sql = "select * from class a join subject b on (a.class=b.class) where b.s_id = $sid  order by b.sub_code ";

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
                        Class</th>
                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Subject</th>
                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Subject Code</th>
                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Subject Type</th>
                
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
                            <?php echo $row['SUBJECT']; ?>

                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['SUB_CODE']; ?>

                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['SUB_TYPE']; ?>

                        </td>
                </tr>
            <?php
                    }
            ?>
            </tr>
            </tbody>
        </table>

        <?php
        include 'connect.php';
        if ($conn) {
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
        </div>

        <Label style="font-size: 18px; font-family: sans-serif;
    font-weight: bold; color: #1D5B79;">Add Subject</Label>
        <div class="input-container" style="display: flex;">
            <div class="input-field" style="margin-right: 10px; ">
                <label for="class">Class</label>
                <select id="class" name="class">
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
            </div>
            <div class="input-field" style="margin-right: 10px; ">
                <label for="type">Subject Type</label>
                <select id="type" name="type">
                    <option disabled selected>Select Subject Type</option>
                    <option>CORE</option>
                    <option>ELECTIVE</option>
                </select>
            </div>
           
            <div class="input-field" style="margin-right: 10px; ">
                <label for="class">Subject</label>
                <select id="class" name="waec">
                    <option disabled selected>Select Subject</option>
                    <?php
                    $get_hos = "select * from waec_subject where exam = 'GABECE' order by subject";
                    $get = oci_parse(oci_connect($username, $password, $connection), $get_hos);
                    oci_execute($get);
                    while ($row = oci_fetch_array($get)) {
                    ?><option>
                            <?php echo $row["SUBJECT"]; ?>
                        </option> <?php
                                }
                                    ?>
                </select>
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
                ADD SUBJECT
                <i class="uil uil-plus"></i>
            </button>
        </div>
        <?php
        include 'connect.php';
        if (isset($_POST['establish'])) {
            if (isset($_POST['class'])) {
                $class = $_POST['class'];
                if (isset($_POST['type'])) {
                    $type = $_POST['type'];
                        if(isset($_POST['waec'])){
                            $waec=$_POST['waec'];

                            $get = oci_parse($conn,"select * from class where class_title = '$class' and s_id = $sid ");
                            oci_execute($get);
                            while($r=oci_fetch_array(($get))){
                               $c=$r['CLASS']; 
                            }

                            $get = oci_parse($conn,"select * from waec_subject where subject = '$waec' ");
                            oci_execute($get);
                            while($r=oci_fetch_array(($get))){
                               $s=$r['SUB_CODE'];
                             
                            }

                            $sql = oci_parse($conn,"select * from subject where sub_code = $s and class = $c and s_id = $sid");
                            oci_execute($sql);

                         if(oci_fetch_all($sql,$a)==0){
                            $sql = oci_parse($conn,"INSERT INTO SUBJECT (SUB_CODE,CLASS,SUB_TYPE,S_ID,SUBJECT) VALUES ($s,$c,'$type',$sid,'$waec') ");
                            if(oci_execute($sql)){
                                ?><div style="font-size:15px;
                                color: green;
                                position: relative;
                                 display:flex;
                                animation:button .3s linear;text-align: center;">
                                    <?php echo "SUBJECT ADDED TO CLASS SUCCESSFULLY";
                                        header("refresh:3;"); ?>
                                </div> <?php
                            }else {
                                ?><div style="font-size:15px;
                                color: green;
                                position: relative;
                                 display:flex;
                                animation:button .3s linear;text-align: center;">
                                    <?php echo "ERROR ADDING SUBJECT TO CLASS";
                                        header("refresh:3;"); ?>
                                </div> <?php
                            }
                         }else {
                            ?><div style="font-size:15px;
                            color: red;
                            position: relative;
                             display:flex;
                            animation:button .3s linear;text-align: center;">
                                <?php echo "SUBJECT ALREADY ADDED TO CLASS";
                                    header("refresh:3;"); ?>
                            </div> <?php
                         }
                        }else {
                            ?><div style="font-size:15px;
                            color: red;
                            position: relative;
                             display:flex;
                            animation:button .3s linear;text-align: center;">
                                <?php echo "SELECT SUBJECT ";
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
                    <?php echo "SELECT CLASS";
                        header("refresh:3;"); ?>
                </div> <?php
                    }
                }

                        ?> 
                          <Label style="font-size: 18px; font-family: sans-serif;
    font-weight: bold; color: #1D5B79;">Edit Subject</Label>
        <div class="input-container" style="display: flex;">
            <div class="input-field" style="margin-right: 10px; ">
                <label for="class">Subject</label>
                <select id="class" name="edit_waec">
                    <option disabled selected>Select Subject</option>
                    <?php
                    $get_hos = "select * from waec_subject where exam = 'WASSCE' order by subject";
                    $get = oci_parse(oci_connect($username, $password, $connection), $get_hos);
                    oci_execute($get);
                    while ($row = oci_fetch_array($get)) {
                    ?><option>
                            <?php echo $row["SUBJECT"]; ?>
                        </option> <?php
                                }
                                    ?>
                </select>
            </div>

            <div class="input-field" style="margin-right: 10px; ">
                <label for="type">Subject Type</label>
                <select id="type" name="edit_type">
                    <option disabled selected>Select Subject Type</option>
                    <option>CORE</option>
                    <option>ELECTIVE</option>
                </select>
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
  text-decoration: none;" name="edit_sub" type="submit">
                EDIT SUBJECT
                <i class="uil uil-edit"></i>
            </button>
        </div>
        <?php
        if (isset($_POST['edit_sub'])) {
            if (isset($_POST['edit_waec'])) {
                $sub = $_POST['edit_waec'];
                $sql = oci_parse($conn, "select * from waec_subject where subject = '$sub' ");
                oci_execute($sql);
                while ($r = oci_fetch_array($sql)) {
                    $sub_code = $r['SUB_CODE'];
                }
                if (isset($_POST['edit_type'])) {
                    $type = $_POST['edit_type'];
                    $sql = oci_parse($conn, "update subject set sub_type = '$type' where sub_code = $sub_code ");
                    oci_execute($sql);
                    $sql = oci_parse($conn, "select * from subject where sub_code = $sub_code and sub_type = '$type' ");
                    oci_execute($sql);
                    if (oci_fetch_all($sql, $a) > 0) {
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
                        ?>
        <Label style="font-size: 18px; font-family: sans-serif;
    font-weight: bold; color: #1D5B79;">Remove Subject From Class</Label>
        <div class="input-container" style="display: flex;">
            <div class="input-field" style="margin-right: 10px; ">
                <label for="class">Class</label>
                <select id="class" name="rem_class">
                    <option disabled selected>Select Class</option>
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
            </div>
            <div class="input-field" style="margin-right: 10px; ">
                <label for="class">Subject</label>
                <select id="class" name="rem_waec">
                    <option disabled selected>Select Subject</option>
                    <?php
                    $get_hos = "select * from waec_subject where exam = 'WASSCE' order by subject";
                    $get = oci_parse(oci_connect($username, $password, $connection), $get_hos);
                    oci_execute($get);
                    while ($row = oci_fetch_array($get)) {
                    ?><option>
                            <?php echo $row["SUBJECT"]; ?>
                        </option> <?php
                                }
                                    ?>
                </select>
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
  text-decoration: none;" name="rem_sub" type="submit">
                REMOVE SUBJECT
                <i class="uil uil-trash-alt"></i>
            </button>
        
        </div>
        <?php 
              if(isset($_POST['rem_sub'])){
                 if(isset($_POST['rem_class'])){
                    $class =$_POST['rem_class'];
                    $sql = oci_parse($conn, "select * from sub_class where class_name = '$class' ");
                    oci_execute($sql);
                    while ($r = oci_fetch_array($sql)) {
                        $c = $r['CLASS'];
                    }
                    if(isset($_POST['rem_waec'])){
                       $sub=$_POST['rem_waec'];
                       $sql = oci_parse($conn, "select * from waec_subject where subject = '$sub' ");
                       oci_execute($sql);
                       while ($r = oci_fetch_array($sql)) {
                           $sub_code = $r['SUB_CODE'];
                       }
                       $sql = oci_parse($conn,"delete from subject where class = $c and sub_code = $sub_code ");
                       oci_execute($sql);
                       $sql = oci_parse($conn,"select * from subject where class = $c and sub_code = $sub_code");
                       oci_execute($sql);
                       if(oci_fetch_all($sql,$a)==0){
                        ?><div style="font-size:15px;
                        color: green;
                        position: relative;
                         display:flex;
                        animation:button .3s linear;text-align: center;">
                        <?php echo "$sub REMOVED SUCESSFULLY";
                            header("refresh:3;"); ?>
                    </div> <?php
                       }else {
                        ?><div style="font-size:15px;
                        color: red;
                        position: relative;
                         display:flex;
                        animation:button .3s linear;text-align: center;">
                        <?php echo "SELECT SUBJECT";
                            header("refresh:3;"); ?>
                    </div> <?php
                       }
                    }else {
                        ?><div style="font-size:15px;
                        color: red;
                        position: relative;
                         display:flex;
                        animation:button .3s linear;text-align: center;">
                        <?php echo "SELECT SUBJECT";
                            header("refresh:3;"); ?>
                    </div> <?php
                    }
                 }else {
                    ?><div style="font-size:15px;
                    color: red;
                    position: relative;
                     display:flex;
                    animation:button .3s linear;text-align: center;">
                    <?php echo "SELECT CLASS";
                        header("refresh:3;"); ?>
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