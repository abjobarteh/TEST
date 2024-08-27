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
    $pr_id=0;
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
    <form class="container" enctype="multipart/form-data" action="manage_prog.php" method="post">
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
        <header>Programme Management</header>
        <div class="input-field">
            <select required name="reg">
                <option disabled selected>Select Programme</option>
                <?php

                $get_hos = "select * from programme order by prog where s_id = $sid  ";
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
  background-color: #1D5B79;
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
            <?php echo "SELECT PROGRAMME"; ?>
        </div> <?php
               }
           }
        ?>
        <?php
        include 'connect.php';

        if ($conn) {
            $sql = "select a.prog,b.subject,c.prog_sub_type from programme a join prog_subject c on (a.prog_id=c.prog_id) join waec_subject b on (b.sub_code=c.sub_code) where a.prog_id = $pr_id and a.s_id = $sid order by c.prog_sub_type,b.subject";
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
                        Subject</th>
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
                            <?php echo $row['SUBJECT']; ?>

                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['PROG_SUB_TYPE']; ?>

                        </td>
                </tr>
            <?php
                    }
            ?>
            </tr>
            </tbody>
        </table>

        <Label style="font-size: 18px; font-family: sans-serif;
    font-weight: bold; color: #1D5B79;">Create Programme</Label>

        <div class="input-container" style="display: flex;">
            <div class="input-field" style="margin-right: 10px; ">
                <input name="dept" placeholder="Add Programme" pattern="[A-z ]+">
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
  text-decoration: none;" name="add" type="submit">
                CREATE PROGRAMME
                <i class="uil uil-plus"></i>
            </button>
        </div>


        <Label style="font-size: 18px; font-family: sans-serif;
    font-weight: bold; color: #1D5B79;">Edit Programme</Label>
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
  background-color: #1D5B79;
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

                <a class="btnText" href="registra.php">
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

</html>