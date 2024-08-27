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
    $school =  $_SESSION['school'];
    $sid = $_SESSION['sid']; ?>
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
    <form class="container" enctype="multipart/form-data" action="manage_dept.php" method="post">
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
        <header>Department Management</header>
        <?php
        include 'connect.php';

        if ($conn) {
            $sql = "select * from department where  s_id = $sid order by dept_id ";
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
                        Department</th>
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
                            <?php echo $row['DEPT']; ?>

                        </td>
                </tr>
            <?php
                    }
            ?>
            </tr>
            </tbody>
        </table>

        
        <div class="buttons">

            <button class="backBtn" type="submit">

                <a class="btnText" href="admin.php">
                    BACK

                </a>
            </button>
        </div>
        <?php
        if (isset($_POST['add'])) {
            $dept = strtoupper($_POST['dept']);

            if ($dept == '') {
        ?><div style="font-size:15px;
            color: red;
            position: relative;
             display:flex;
             margin-left:10px;
            animation:button .3s linear;text-align: center;">
                    <?php echo "ENTER DEPARTMENT";
                    header("refresh:2;");
                    ?></div><?php
                        } else {
                            $sql = oci_parse($conn, "select * from department where dept = '$dept'  and s_id = $sid");
                            oci_execute($sql);
                            if (oci_fetch_all($sql, $a) == 0) {
                                $sql = oci_parse($conn, "insert into department (dept,s_id) values ('$dept',$sid)");
                                oci_execute($sql);
                                $sql = oci_parse($conn, "select * from department where dept = '$dept' and s_id = $sid");
                                oci_execute($sql);
                                if (oci_fetch_all($sql, $a) > 0) {
                            ?><div style="font-size:15px;
                        color: green;
                        position: relative;
                         display:flex;
                         margin-left:10px;
                        animation:button .3s linear;text-align: center;">
                        <?php echo "$dept ADDED SUCCESSFULLY";
                                    header("refresh:2;");
                                    ?></div><?php
                                } else {
                        ?><div style="font-size:15px;
                        color: red;
                        position: relative;
                         display:flex;
                         margin-left:10px;
                        animation:button .3s linear;text-align: center;">
                            <?php echo "ERROR ADDING DEPARTMENT";
                                    header("refresh:2;");
                                    ?></div><?php
                                }
                            } else {
                            ?><div style="font-size:15px;
                    color: red;
                    position: relative;
                     display:flex;
                     margin-left:10px;
                    animation:button .3s linear;text-align: center;">
                    <?php echo "DEPARTMENT ALREADY EXIST";
                                header("refresh:2;");
                                ?></div><?php
                            }
                        }
                    }

                    if (isset($_POST['generate'])) {
                        if (isset($_POST['dept_name'])) {
                            $dn=$_POST['dept_name'];
                            $edit_dept = strtoupper($_POST['edit_dept']);
                            if(!($edit_dept=='')){
                            $sql =oci_parse($conn,"select * from department where dept='$edit_dept' and s_id = $sid");
                            oci_execute($sql);
                            if(oci_fetch_all($sql,$a)==0){
                                $sql =oci_parse($conn,"update department set dept = '$edit_dept' where dept='$dn' and s_id = $sid");
                                oci_execute($sql);
                                $sql =oci_parse($conn,"select * from department where dept='$edit_dept' and s_id = $sid");
                                oci_execute($sql);
                                if(oci_fetch_all($sql,$a)>0){
                                    ?><div style="font-size:15px;
                                    color: green;
                                    position: relative;
                                     display:flex;
                                     margin-left:10px;
                                    animation:button .3s linear;text-align: center;">
                                    <?php echo "UPDATE SUCCESSFUL ";
                                                header("refresh:2;");
                                                ?></div><?php 
                                }else{
                                    ?><div style="font-size:15px;
                                    color: red;
                                    position: relative;
                                     display:flex;
                                     margin-left:10px;
                                    animation:button .3s linear;text-align: center;">
                                    <?php echo "ERROR UPDATING DEPARTMENT";
                                                header("refresh:2;");
                                                ?></div><?php 
                                }
                            }else {
                                ?><div style="font-size:15px;
                                color: red;
                                position: relative;
                                 display:flex;
                                 margin-left:10px;
                                animation:button .3s linear;text-align: center;">
                                <?php echo "DEPARTMENT ALREADY EXIST";
                                            header("refresh:2;");
                                            ?></div><?php
                            }
                            }else {
                                ?><div style="font-size:15px;
                                color: red;
                                position: relative;
                                 display:flex;
                                 margin-left:10px;
                                animation:button .3s linear;text-align: center;">
                                <?php echo "ENTER NEW DEPARTMENT";
                                            header("refresh:2;");
                                            ?></div><?php
                            }
                        } else {
                            ?><div style="font-size:15px;
                            color: red;
                            position: relative;
                             display:flex;
                             margin-left:10px;
                            animation:button .3s linear;text-align: center;">
                            <?php echo "SELECT DEPARTMENT";
                                        header("refresh:2;");
                                        ?></div><?php
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

</html>