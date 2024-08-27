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
// Include the auto_logout.php file
include('auto_logout.php');

// Your page content goes here
// ...
?>

<body>
    <form class="container" enctype="multipart/form-data" action="subject_management.php" method="post">
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
        <header>Department And Subject Management</header>
        <div class="input-field">
            <select id="class" name="class" onchange="handleClassSelection(this)">
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
        <button style=" display: inline-block;
  padding: 6px 12px;
  background-color: #1D5B79;
  color: white;
  border: none;
  border-radius: 4px;
  text-decoration: none;" name="filter" type="submit">
            FILTER BY CLASS
            <i class="uil uil-filter"></i>
        </button>
        <?php
        include 'connect.php';

        if ($conn) {

            $sql = "select c.class_name,b.subject,b.sub_type,b.sub_code from subject b join sub_class c on (b.subs=c.sub_code) where b.s_id = $sid order by c.class_name , b.sub_type  ";
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
                            <?php echo $row['CLASS_NAME']; ?>

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
       
            <div id="message"></div>
            <div class="input-field" style="margin-right: 10px; ">
                <label for="type">Subject Type</label>
                <select id="type" name="type" onchange="handleClassSelection(this)">
                    <option disabled selected>Select Subject Type</option>
                    <option>CORE</option>
                    <option>ELECTIVE</option>
                </select>
            </div>
            <?php

            echo "<script>
            
            function handleClassSelection(selectElement) {
              // Get the selected value for class
              const selectedClass = selectElement.value;
              
              // Get the selected value for type
              const selectedType = document.getElementById('type').value;
              
              // Create a new XMLHttpRequest object
              const xhr = new XMLHttpRequest();
              
              // Define the PHP script URL and specify that it's a POST request
              const phpScriptURL = 'subject_management.php';
              xhr.open('POST','subject.php?c='+ selectedClass, true);
              
              // Set the request header
              xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
              
              // Define a callback function to handle the response
              xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                  // Handle the response from the PHP script
                  const messageDiv = document.getElementById('message');
               //   messageDiv.textContent = 'Received: ' + selectedClass;
                   $.ajax({

                    url: 'subject_management.php',
                    method: 'POST',
                    data: {'class': selectedClass}
                   });
                 
                }
              };
              
              // Send the selected values to the PHP script
              xhr.send();
            }
          </script>
          ";
            ?>
            <?php

            if (isset($_REQUEST['c'])) {
                $class = $_REQUEST['c'];
                echo $class;
            }

            ?>
            <?php
            $ty = 'TYPE';

            if (isset($_POST['class'])) {
                if (isset($_POST['type'])) {
                    $class = $_POST['class'];
                    $type = $_POST['type'];
                    $_SESSION['CLASS'] = $class;
                    $_SESSION['TYPE'] = $type;
                    $sql = oci_parse($conn, "select * from sub_class where class_name = '$class'");
                    oci_execute($sql);
                    while ($a = oci_fetch_array($sql)) {
                        $st = $a['SUB_TITLE'];
                    }
                    $sql = oci_parse($conn, "select * from PROG_CLASS where class  = '$st' ");
                    oci_execute($sql);
                    while ($r = oci_fetch_array($sql)) {
                        $pr_id = $r['PROG_ID'];
                        $_SESSION['PR_ID'] = $pr_id;
                    }
                } else {
            ?><div style="font-size:15px;
                color: red;
                position: relative;
                 display:flex;
                animation:button .3s linear;text-align: center;">
                        <?php // echo "SELECT TYPE";
                        //   header("refresh:3;"); 
                        ?>
                    </div> <?php
                        }
                    } else {
                            ?><div style="font-size:15px;
                color: red;
                position: relative;
                 display:flex;
                animation:button .3s linear;text-align: center;">
                    <?php //echo "SELECT CLASS";
                        //    header("refresh:3;"); 
                    ?>
                </div> <?php
                    }

                        ?>


            <div class="input-field" style="margin-right: 10px; ">
                <label for="class" style="font-size: 12px;">Subject</label>
                <select id="class" name="waec">
                    <option disabled selected>Select Subject</option>
                    <?php
                    $get_hos = "select a.prog,c.subject,b.prog_sub_type from programme a join prog_subject b on (a.prog_id=b.prog_id) join waec_subject c on (b.sub_code=c.sub_code) where b.prog_id = $pr_id and b.prog_sub_type='$type' order by c.subject";
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
            if (isset($_POST['waec'])) {
                $class = $_SESSION['CLASS'];
                $type = $_SESSION['TYPE'];
                $pr_id = $_SESSION['PR_ID'];
                $waec = $_POST['waec'];

                $get = oci_parse($conn, "select * from sub_class where class_name = '$class' and s_id = $sid ");
                oci_execute($get);
                while ($r = oci_fetch_array(($get))) {
                    $c = $r['CLASS'];
                    $subs = $r['SUB_CODE'];
                }

                $get = oci_parse($conn, "select * from prog_subject a join waec_subject b on (a.sub_code=b.sub_code) where a.prog_id = $pr_id and b.subject = '$waec' ");
                oci_execute($get);
                while ($r = oci_fetch_array(($get))) {
                    $s = $r['SUB_CODE'];
                }
                $sql = oci_parse($conn, "select * from subject where sub_code = $s and class = $c and s_id = $sid and subs = '$subs' ");
                oci_execute($sql);
                if (oci_fetch_all($sql, $a) == 0) {

                    $sql = oci_parse($conn, "INSERT INTO SUBJECT (SUB_CODE,CLASS,SUB_TYPE,S_ID,SUBJECT,SUBS) VALUES ($s,$c,'$type',$sid,'$waec',$subs) ");
                    if (oci_execute($sql)) {
        ?><div style="font-size:15px;
                                color: green;
                                position: relative;
                                 display:flex;
                                animation:button .3s linear;text-align: center;">
                            <?php echo "SUBJECT ADDED TO CLASS SUCCESSFULLY";
                            header("refresh:3;"); ?>
                        </div> <?php
                            } else {
                                ?><div style="font-size:15px;
                                color: green;
                                position: relative;
                                 display:flex;
                                animation:button .3s linear;text-align: center;">
                            <?php echo "ERROR ADDING SUBJECT TO CLASS";
                                header("refresh:3;"); ?>
                        </div> <?php
                            }
                        } else {
                                ?><div style="font-size:15px;
                            color: red;
                            position: relative;
                             display:flex;
                            animation:button .3s linear;text-align: center;">
                        <?php echo "SUBJECT ALREADY ADDED TO CLASS";
                            header("refresh:3;"); ?>
                    </div> <?php
                        }
                    } else {
                            ?><div style="font-size:15px;
                            color: red;
                            position: relative;
                             display:flex;
                            animation:button .3s linear;text-align: center;">
                    <?php echo "SELECT SUBJECT ";
                        header("refresh:3;"); ?>
                </div> <?php
                    }
                }

                        ?>

        <Label style="font-size: 18px; font-family: sans-serif;
    font-weight: bold; color: #1D5B79;">Edit Subject</Label>
        <?php
        if (isset($_POST['filter_edit'])) {
            if (isset($_POST['edit_class'])) {
                $class = $_POST['edit_class'];
                $sql = oci_parse($conn, "select * from sub_class where s_id=$sid and class_name = '$class' ");
                oci_execute($sql);
                while ($r = oci_fetch_array($sql)) {
                    $class = $r['SUB_TITLE'];
                }
                $sql = oci_parse($conn, "select * from prog_class where class = '$class' ");
                oci_execute($sql);
                while ($a = oci_fetch_array($sql)) {
                    $pr_id = $a['PROG_ID'];
                    $_SESSION['PR'] = $pr_id;
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


        <div class="input-container" style="display: flex;">
            <div class="input-field" style="margin-right: 10px; ">
                <label for="class">Subject</label>
                <select id="class" name="edit_waec">
                    <option disabled selected>Select Subject</option>
                    <?php
                    $get_hos = "select distinct(a.subject) from waec_subject a join prog_subject b on (a.sub_code=b.sub_code) WHERE b.prog_id = $pr_id order by a.subject ";
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
                        ?>
        <Label style="font-size: 18px; font-family: sans-serif;
    font-weight: bold; color: #1D5B79;">Remove Subject From Class</Label>
        <div class="input-container" style="display: flex;">
      
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
        if (isset($_POST['rem_sub'])) {
            if (isset($_POST['rem_class'])) {
                $class = $_POST['rem_class'];
                $sql = oci_parse($conn, "select * from sub_class where class_name = '$class' ");
                oci_execute($sql);
                while ($r = oci_fetch_array($sql)) {
                    $c = $r['CLASS'];
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
                            <?php echo "SELECT SUBJECT";
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

    </script>
</body>

</html>