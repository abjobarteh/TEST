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
$sid = $_SESSION['sid'];
$class = '';
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

// Your page content goes here
// ...
?>

<body>
    <form class="container" enctype="multipart/form-data" action="class.php" method="post">
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
                                                                                                                                                                                                    }                                                                                                                                                                             ?>
        </div>
        <div class="buttons">
            <button class="backBtn" type="submit" style="width: 150px;">

                <a class="btnText" href="admin.php" style="font-size: 15px;">
                    HOME
                    <i class="uil uil-estate" style="width: 50px;"></i>
                </a>

            </button>
        </div>
        <header>Class Management</header>
        <?php
        include 'connect.php';
        if ($conn) {
            $sql = "select * from class where  s_id = $sid order by class ";

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
                        <th style="padding: 5px 8px; font-size: 10px; margin: 5px;">Class Title</th>
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
                                <td style="padding: 5px 8px; font-size: 10px; margin: 5px;"><?php echo $row['CLASS']; ?></td>
                                <td style="padding: 5px 8px; font-size: 10px; margin: 5px;"><?php echo $row['CLASS_TITLE']; ?></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <?php

        ?>
        <div class="input-field" style="margin-right: 10px;">
            <label>Class</label>
            <select required name="filter_class">
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
        </div>
        <?php
        if (isset($_POST['filter'])) {
            if (isset($_POST['filter_class'])) {
                $class = $_POST['filter_class'];
            } else {
        ?><div style="font-size:15px;
                color: red;
                position: relative;
                 display:flex;
                animation:button .3s linear;text-align: center;">
                    <?php echo "SELECT CLASS"; ?>
                </div> <?php
                    }
                }
                $sql = "select * from class c join sub_class s on (c.class=s.class) where s.s_id = $sid and c.class_title = '$class' order by c.class_title ";
                $stid = oci_parse($conn, $sql);
                oci_execute($stid);
                        ?>
        <div style="overflow-x:auto;">
            <table class="table-content" style="font-size: 14px; border-collapse: collapse; margin: 10px 0; font: 0.9em; border-radius: 5px 5px; box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);">
                <thead>
                    <tr style="background-color: #04716f; color: #ffffff; text-align: left; font-weight: bold;">
                        <th style="padding: 5px 8px; font-size: 10px; margin: 5px;">Class Title</th>
                        <th style="padding: 5px 8px; font-size: 10px; margin: 5px;">Sub Class Title</th>
                        <th style="padding: 5px 8px; font-size: 10px; margin: 5px;">Class Name</th>
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
                                <td style="padding: 5px 8px; font-size: 10px; margin: 5px;"><?php echo $row['CLASS_TITLE']; ?></td>
                                <td style="padding: 5px 8px; font-size: 10px; margin: 5px;"><?php echo $row['SUB_TITLE']; ?></td>
                                <td style="padding: 5px 8px; font-size: 10px; margin: 5px;"><?php echo $row['CLASS_NAME']; ?></td>
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
    font-weight: bold; color: #04716f;">Define Class</Label>
        <div class="input-container" style="display: flex;">
            <div class="input-field" style="margin-right: 10px;">
                <label>Class</label>
                <input type="number" placeholder="Enter Class" title="Only Numbers" name="class" min="10" max="12" style="width:150px;">
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
  text-decoration: none;" name="establish" type="submit">
                DEFINE CLASS
                <i class="uil uil-create-dashboard"></i>
            </button>
        </div>
        <?php
        include 'connect.php';
        if (isset($_POST['establish'])) {
            $class = trim($_POST['class']);
            if (!($class == '')) {

                $sql = oci_parse($conn, "select * from class where class = $class and s_id = $sid");
                oci_execute($sql);
                if (oci_fetch_all($sql, $a) == 0) {
                    $grade = trim("GRADE " . $class);
                    echo "INSERT INTO CLASS (S_ID,class,class_title) values ($sid,$class,'$grade')";
                    $sql = oci_parse($conn, "INSERT INTO CLASS (S_ID,class,class_title) values ($sid,$class,'$grade')");
                    oci_execute($sql);
                    $sql = oci_parse($conn, "select * from class where s_id = $sid and class = $class and class_title = '$grade' ");
                    oci_execute($sql);
                    if (oci_fetch_all($sql, $a) > 0) {
        ?><div style="font-size:15px;
                        color: green;
                        position: relative;
                         display:flex;
                        animation:button .3s linear;text-align: center;">
                            <?php echo "CLASS $class CREATED SUCESSFULLY";
                            header("refresh:3;"); ?>
                        </div> <?php
                            } else {
                                ?><div style="font-size:15px;
                        color: red;
                        position: relative;
                         display:flex;
                        animation:button .3s linear;text-align: center;">
                            <?php echo "ERROR CREATING CLASS";
                                header("refresh:3;");
                            ?>
                        </div> <?php
                            }
                        } else {
                                ?><div style="font-size:15px;
                    color: red;
                    position: relative;
                     display:flex;
                    animation:button .3s linear;text-align: center;">
                        <?php echo "CLASS ALREADY CREATED";
                            header("refresh:3;"); ?>
                    </div> <?php
                        }
                    } else {
                            ?><div style="font-size:15px;
                color: red;
                position: relative;
                 display:flex;
                animation:button .3s linear;text-align: center;">
                    <?php echo "ENTER CLASS";
                        header("refresh:3;"); ?>
                </div> <?php
                    }
                }

                        ?>
        <Label style="font-size: 18px; font-family: sans-serif;font-weight: bold; color: #04716f; margin-top: 20px;">Add Class</Label>
        <div class="input-field" style="margin-right: 10px; ">

        </div>
        <div class="input-container" style="display: flex;">
            <div class="input-field" style="margin-right: 10px; ">
                <label for="class">Programme</label>
                <select id="class" name="prog">
                    <option disabled selected>Select Programme</option>
                    <?php
                    $get_hos = "select * from programme";
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
            <div class="input-field" style="margin-right: 10px;">
                <label>Class</label>
                <select required name="reg">
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
            <div class="input-field" style="margin-right: 10px;">
                <label>Class Name</label>
                <label>Class</label>
                <input type="text" placeholder="Enter Class" title="Only Letters And Numbers" name="sub_title1" pattern="[A-z0-9 ]+" style="width:150px;">
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
  text-decoration: none;" name="add_sub" type="submit">
                Add Sub Class
                <i class="uil uil-plus"></i>
            </button>
        </div>
        <?php
        if (isset($_POST['add_sub'])) {
            if (isset($_POST['reg'])) {
                $sub = trim($_POST['sub_title1']);
                if ($sub != '') {
                    if (isset($_POST['prog'])) {
                        $prog = $_POST['prog'];
                        $sql = oci_parse($conn, "select * from programme where prog = '$prog' ");
                        oci_execute($sql);
                        while ($r = oci_fetch_array($sql)) {
                            $pr_id = $r["PROG_ID"];
                        }
                        $class = trim($_POST['reg']);
                        $sql = oci_parse($conn, "select * from class where class_title = '$class' and s_id = $sid");
                        oci_execute($sql);
                        while ($r = oci_fetch_array($sql)) {
                            $class_code = $r['CLASS'];
                        }
                        $sub = strtoupper($_POST['sub_title1']);
                        $sql = oci_parse($conn, "select *  from sub_class where class = $class_code and s_id = $sid and sub_title = '$sub' ");
                        oci_execute($sql);
                        $class_name = trim($class . " " . $sub);
                        if (oci_fetch_all($sql, $a) == 0) {
                            $sql = oci_parse($conn, "INSERT INTO SUB_CLASS (s_id,class,sub_title,class_name) VALUES ($sid,$class_code,'$sub','$class_name')");
                            oci_execute($sql);
                            $sql = oci_parse($conn, "select * from sub_class where s_id = $sid and class = $class_code and sub_title = '$sub' ");
                            oci_execute($sql);
                            while ($r = oci_fetch_array($sql)) {
                                $class_code = $r["SUB_CODE"];
                            }
                            oci_execute($sql);
                            if (oci_fetch_all($sql, $a) > 0) {
                                $sql = oci_parse($conn, "INSERT INTO PROG_CLASS (PROG_ID,CLASS,SUB_CODE,S_ID) VALUES ($pr_id,'$sub',$class_code,$sid)");
                                oci_execute($sql);
        ?><div style="font-size:15px;
                                color: green;
                                position: relative;
                                 display:flex;
                                animation:button .3s linear;text-align: center;">
                                    <?php echo "CLASS $class_name CREATED SUCCESSFULLY ";
                                    header("refresh:3;"); ?>
                                </div> <?php
                                    } else {
                                        ?><div style="font-size:15px;
                                color: red;
                                position: relative;
                                 display:flex;
                                animation:button .3s linear;text-align: center;">
                                    <?php echo "ERROR CREATING SUB CLASS $sub";
                                        header("refresh:3;"); ?>
                                </div> <?php
                                    }
                                } else {
                                        ?><div style="font-size:15px;
                            color: red;
                            position: relative;
                             display:flex;
                            animation:button .3s linear;text-align: center;">
                                <?php echo "SUB CLASS ALREADY EXIST ";
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
                        } else {
                                ?><div style="font-size:15px;
                    color: red;
                    position: relative;
                     display:flex;
                    animation:button .3s linear;text-align: center;">
                        <?php echo "ENTER SUB CLASS";
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

        <Label style="font-size: 18px; font-family: sans-serif;font-weight: bold; color: #04716f; margin-top: 20px;">Edit Class</Label>
        <div class="input-container" style="display: flex;">
            <div class="input-field" style="margin-right: 10px;">
                <label>Class </label>
                <select required name="c1">
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
            <div class="input-field" style="margin-right: 10px;">
                <label>Old Class Name</label>
                <select required name="c2">
                    <option disabled selected>Select Class Name</option>
                    <?php
                    $get_hos = "select DISTINCT(SUB_TITLE) from SUB_CLASS WHERE S_ID= $sid and 
                    SUB_TITLE != 'UMAR 1' AND SUB_TITLE NOT LIKE 'AISHA' and SUB_CODE  != 286 AND SUB_CODE  != 290 AND  SUB_CODE  != 202 AND  SUB_CODE  != 291 AND  SUB_CODE  != 122 AND  SUB_CODE  != 242 AND  SUB_CODE  != 103 and sub_code != 221 AND SUB_TITLE != 'NAFISATOU 2' AND SUB_TITLE != 'SAFFIAH' AND SUB_TITLE != 'ZAINAB' AND SUB_TITLE != 'AISHA 2' AND SUB_TITLE != 'ISHA' ORDER BY SUB_TITLE";
                    $get = oci_parse(oci_connect($username, $password, $connection), $get_hos);
                    oci_execute($get);
                    while ($row = oci_fetch_array($get)) {
                    ?><option>
                            <?php echo $row["SUB_TITLE"]; ?>
                        </option> <?php
                                }
                                    ?>
                </select>
            </div>
            <div class="input-field" style="margin-right: 10px;">
                <label>New Class Name</label>
                <input type="text" placeholder="Enter New Class" title="Only Numbers" name="sub_title" pattern="[A-z0-9 ]+" style="width:150px;">
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
  text-decoration: none;" name="edit_sub" type="submit">
                Edit Sub Class
                <i class="uil uil-edit"></i>
            </button>
        </div>

        <?php
        if (isset($_POST['edit_sub'])) {
            if (isset($_POST['c1'])) {
                if (isset($_POST['c2'])) {
                    $new_name = trim(strtoupper($_POST['sub_title']));

                    if (!($new_name == '')) {

                        $clas = $_POST['c1'];
                        $sub = trim($_POST['c2']);

                        $sql = oci_parse($conn, "select * from sub_class where sub_title = '$sub' ");
                        oci_execute($sql);
                        while ($r = oci_fetch_array($sql)) {
                            $sub_code = $r['SUB_CODE'];
                        }
                        $sql = oci_parse($conn, "select * from class where class_title = '$clas' ");
                        oci_execute($sql);
                        while ($r = oci_fetch_array($sql)) {
                            $code = $r['CLASS'];
                        }

                        $sql = oci_parse($conn, "select * from sub_class where class = $code and sub_title= '$sub' and s_id = $sid ");
                        oci_execute($sql);
                        while ($r = oci_fetch_array($sql)) {
                            $sub_code = $r["SUB_CODE"];
                        }
                        $sql = oci_parse($conn, "select * from sub_class where class = $code and sub_title= '$sub' and s_id = $sid ");
                        oci_execute($sql);

                        if (oci_fetch_all($sql, $a) > 0) {
                            $C_N = trim($clas . " " . $new_name);

                            $sql = oci_parse($conn, "update sub_class set sub_title='$new_name', class_name = '$C_N' where class = $code and sub_title = '$sub' ");
                            if (oci_execute($sql)) {
                                $sql = oci_parse($conn, "update prog_class set class = '$new_name' where sub_code = $sub_code");
                                oci_execute($sql);
        ?><div style="font-size:15px;
                                color: green;
                                position: relative;
                                 display:flex;
                                animation:button .3s linear;text-align: center;">
                                    <?php echo "CLASS NAME UPDATED SUCCESSFULLY";
                                    header("refresh:3;"); ?>
                                </div> <?php
                                    } else {
                                        ?><div style="font-size:15px;
                                color: red;
                                position: relative;
                                 display:flex;
                                animation:button .3s linear;text-align: center;">
                                    <?php echo "ERROR UPDATING CLASS NAME";
                                        header("refresh:3;"); ?>
                                </div> <?php
                                    }
                                } else {
                                        ?><div style="font-size:15px;
                            color: red;
                            position: relative;
                             display:flex;
                            animation:button .3s linear;text-align: center;">
                                <?php echo "WRONG CLASS NAME SELECTED";
                                    header("refresh:3;"); ?>
                            </div> <?php
                                }
                            } else {
                                    ?><div style="font-size:15px;
                        color: red;
                        position: relative;
                         display:flex;
                        animation:button .3s linear;text-align: center;">
                            <?php echo "ENTER NEW CLASS NAME";
                                header("refresh:3;"); ?>
                        </div> <?php
                            }
                        } else {
                                ?><div style="font-size:15px;
                    color: red;
                    position: relative;
                     display:flex;
                    animation:button .3s linear;text-align: center;">
                        <?php echo "SELECT CLASS NAME TO BE EDITED";
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

                <a class="btnText" href="admin.php">
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