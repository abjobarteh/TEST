<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/show_users.css">
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
    $pr_id=0;
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
    <form class="container" enctype="multipart/form-data" action="manage_prog.php" method="post">
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
        <header>Programme Management</header>
        <?php  $get_hos = "select * from programme where s_id = $sid order by prog  ";
              //  echo $get_hos; ?>
        <div class="input-field">
            <select required name="reg">
                <option disabled selected>Select Programme</option>
                <?php

               
                $get = oci_parse(oci_connect($username, $password, $connection), $get_hos);
                oci_execute($get);
                while ($row = oci_fetch_array($get)) {
                ?><option>
                        <?php echo $row["PROG"]; ?>
                    </option> <?php
                            }
                                ?>
            </select>
        </div>
        <button style=" display: inline-block;
  padding: 6px 12px;
  background-color: #04716f;
  color: white;
  border: none;
  border-radius: 4px;
  text-decoration: none;" name="filter" type="submit">
            FILTER
            <i class="uil uil-filter"></i>
        </button>
        <?php 
           if(isset($_POST['filter'])){
               if(isset($_POST['reg'])){
                echo '<script>
                Swal.fire({
                    position: "center",
                    icon: "info",
                    title: "FILTERING INFORMATION",
                    showConfirmButton: false,
                    timer: 1500
                  });
                </script>'; 
                $prog = $_POST['reg'];
                $sql = oci_parse($conn,"select * from programme where prog= '$prog' and s_id = $sid  ");
                oci_execute($sql);
                while($r=oci_fetch_array($sql)) {
                    $pr_id = $r['PROG_ID'];
                }
               }else {
                ?><div style="font-size:15px;
                color: red;
                position: relative;
                 display:flex;
                animation:button .3s linear;text-align: center;">
            <?php echo '<script>
															Swal.fire({
																position: "center",
																icon: "warning",
																title: "SELECT PROGRAME",
																showConfirmButton: false,
																timer: 1500
															  });
															</script>'; ?>
        </div> <?php
               }
           }
        ?>
        <?php
        include 'connect.php';

        if ($conn) {
            $sql = "SELECT * FROM PROGRAMME WHERE S_ID = $sid ORDER BY PROG";
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
                        Programme</th>
                        
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
                            <?php echo $row['PROG']; ?>

                        </td>
                       
                </tr>
            <?php
                    }
            ?>
            </tr>
            </tbody>
        </table>

        <Label style="font-size: 18px; font-family: sans-serif;
    font-weight: bold; color: #04716f;">Create Programme</Label>

        <div class="input-container" style="display: flex;">
            <div class="input-field" style="margin-right: 10px; ">
                <input name="dept" placeholder="Add Programme" pattern="[A-z ]+">
            </div>
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
  text-decoration: none;" name="add" type="submit">
                CREATE PROGRAMME
                <i class="uil uil-plus"></i>
            </button>
        </div>


        <Label style="font-size: 18px; font-family: sans-serif;
    font-weight: bold; color: #04716f;">Edit Programme</Label>
        <div class="input-container" style="display: flex;">

            <div class="input-field" style="margin-right: 10px; ">
                <select id="class" name="dept_name">
                    <option disabled selected>Select Programme</option>
                    <?php
                    $get_hos = "select * from programme where s_id = $sid order by prog";
                    $get = oci_parse(oci_connect($username, $password, $connection), $get_hos);
                    oci_execute($get);
                    while ($row = oci_fetch_array($get)) {
                    ?><option>
                            <?php echo $row["PROG"]; ?>
                        </option> <?php
                                }
                                    ?>
                </select>
            </div>


            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">New Programme Name</label>
                <input name="edit_dept" placeholder="Enter Programme" pattern="[A-z ]+">
            </div>

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
                EDIT DEPARTMENT
                <i class="uil uil-edit"></i>
            </button>
        </div>
        <?php

       

        ?>
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
                            $sql = oci_parse($conn, "select * from programme where prog = '$dept' and s_id = $sid ");
                            oci_execute($sql);
                            if (oci_fetch_all($sql, $a) == 0) {
                                $sql = oci_parse($conn, "insert into programme (prog,s_id) values ('$dept',$sid)");
                                oci_execute($sql);
                                $sql = oci_parse($conn, "select * from programme where prog = '$dept' and s_id = $sid ");
                                oci_execute($sql);
                                if (oci_fetch_all($sql, $a) > 0) {
                            ?><div style="font-size:15px;
                        color: green;
                        position: relative;
                         display:flex;
                         margin-left:10px;
                        animation:button .3s linear;text-align: center;">
                        <?php 
                            echo '<script>
                            Swal.fire({
                                position: "center",
                                icon: "success",
                                title: "'.$dept.' PROGRAMME ADDED SUCESSFULLY",
                                showConfirmButton: false,
                                timer: 1500
                              });
                            </script>';
                        
                    //    echo "$dept ADDED SUCCESSFULLY";
                                    header("refresh:2;");
                                    ?></div><?php
                                } else {
                        ?><div style="font-size:15px;
                        color: red;
                        position: relative;
                         display:flex;
                         margin-left:10px;
                        animation:button .3s linear;text-align: center;">
                            <?php echo '<script>
                            Swal.fire({
                                position: "center",
                                icon: "error",
                                title: ERROR ADDING PTOGRAMME",
                                showConfirmButton: false,
                                timer: 1500
                              });
                            </script>';
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
                            $sql =oci_parse($conn,"select * from programme where prog='$edit_dept' and s_id = $sid ");
                            oci_execute($sql);
                            if(oci_fetch_all($sql,$a)==0){
                                $sql =oci_parse($conn,"update PROGramme set prog = '$edit_dept' where prog='$dn' and s_id = $sid");
                                oci_execute($sql);
                                $sql =oci_parse($conn,"select * from programme where prog='$edit_dept' and s_id = $sid ");
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</html>