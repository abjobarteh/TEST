<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/showss.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
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
    <title>Finance</title>
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
        border: 2px solid #909290;
        background-color: #ffffff;
    }

    .field select:focus~i {
        color: #909290;
    }
</style>
<?php
include('auto_logout.php');
?>

<body>
    <form class="container" enctype="multipart/form-data" action="parameters.php" method="post">
        <div class="com">
            <h3 style="color:#909290;">Academix: School Management System</h3>
            <h3 class="title" style="justify-content:center; text-align:center; color:#909290; 	font-size: 18px;"><?php echo $school ?>
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
        <header>Fee</header>

        <?php
        include 'connect.php';

        include 'connect.php';
        $region = " ";
        ?>

        <?php
        $id = 0;
        $cc = 0;



        $sql = "SELECT * FROM FEE_PARAMETER WHERE S_ID = $sid  ORDER BY DESCRIPTION";
        $stid = oci_parse($conn, $sql);
        oci_execute($stid);
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
                <tr style="  background-color: #909290;
    color: #ffffff;
    text-align: left;
    font-weight: bold;">
                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Description</th>
                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Fee Type</th>
                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Fee Parameter</th>
            </thead>
            <tbody>
                <tr style=" border-bottom: 1px solid #dddddd;">
                    <?php
                    while ($row = oci_fetch_array($stid)) {
                    ?>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['DESCRIPTION']; ?>

                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['FEE_TYPE']; ?>

                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['COST']; ?>

                        </td>
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
  background-color: #909290;
  color: white;
  border: none;
  border-radius: 4px;
  margin-top:10px;
  margin-bottom:10px;
  text-decoration: none;" name="generate" type="submit">
                GENERATE TUITION INVOICE
                <i class="uil uil-file-export"></i>
            </button>
        </div>

        </div>
        <Label style="font-size: 18px; font-family: sans-serif;
    font-weight: bold; color: #909290;">Add Fee Parameter</Label>
        <div class="input-container" style="display: flex;">
            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">Description</label>
                <input type="text" placeholder="Enter Description" title="Only Letters" pattern="[A-z ]+" name="description">
            </div>

            <div class="input-field" style="margin-right: 10px;">
                <label for="subjectCode">Fee Type</label>
                <select required name="fee_type">
                    <option disabled selected>Select Fee Type</option>
                    <option>COMPULSORY</option>
                    <option>NON-COMPULSORY</option>
                </select>
            </div>


            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">Cost</label>
                <input type="number" placeholder="Enter Cost" title="Only Numbers" pattern="[0-9]+" name="fee_cost">
            </div>

        </div>
        <div style="display: flex;">
            <button style=" display: inline-block;
  padding: 6px 12px;
  background-color: #909290;
  color: white;
  border: none;
  border-radius: 4px;
  margin-top:10px;
  margin-bottom:10px;
  text-decoration: none;" name="add" type="submit">
                Add Parameter
                <i class="uil uil-plus"></i>
            </button>
        </div>
        <?php
        if (isset($_POST['add'])) {
            $des = strtoupper($_POST['description']);
            if ($des != '') {
                if (isset($_POST['fee_type'])) {
                    $type = $_POST['fee_type'];
                    $cost = $_POST['fee_cost'];

                    if ($cost != '') {
                        $cost = $_POST['fee_cost'];

                        $sql = oci_parse($conn, "SELECT * FROM FEE_PARAMETER WHERE DESCRIPTION LIKE '$des%' ");
                        oci_execute($sql);
                        if (oci_fetch_all($sql, $a) == 0) {
                            //   echo "INSERT INTO FEE_PARAMETER(DESCRIPTION,FEE_TYPE,COST) VALUES ('$des','$type',$cost) ";
                            $sql = oci_parse($conn, "INSERT INTO FEE_PARAMETER (DESCRIPTION,FEE_TYPE,COST,S_ID) VALUES ('$des','$type',$cost,$sid) ");
                            if (oci_execute($sql)) {
                                echo  '<script>
                                 Swal.fire({
                                     position: "center",
                                     icon: "success",
                                     title: "' . $des . ' ADDED SUCCESSFULLY",
                                     showConfirmButton: false,
                                     timer: 1500
                                   });
                                 </script>';
                                header("refresh:3;");
                            } else {
                                echo  '<script>
                                 Swal.fire({
                                     position: "center",
                                     icon: "error",
                                     title: "ERROR ADDING PARAMETER",
                                     showConfirmButton: false,
                                     timer: 1500
                                   });
                                 </script>';
                                header("refresh:3;");
                            }
                        } else {
                            echo  '<script>
                                Swal.fire({
                                    position: "center",
                                    icon: "warning",
                                    title: "' . $des . ' PAARMETER ALREADY ADDED",
                                    showConfirmButton: false,
                                    timer: 1500
                                  });
                                </script>';
                            header("refresh:3;");
                        }
                    } else {
                        echo  '<script>
                                Swal.fire({
                                    position: "center",
                                    icon: "warning",
                                    title: "ENTER COST",
                                    showConfirmButton: false,
                                    timer: 1500
                                  });
                                </script>';
                        header("refresh:3;");
                    }
                } else {
                    echo  '<script>
                        Swal.fire({
                            position: "center",
                            icon: "warning",
                            title: "SELECT FEE TYPE",
                            showConfirmButton: false,
                            timer: 1500
                          });
                        </script>';
                    header("refresh:3;");
                }
            } else {
                echo  '<script>
                    Swal.fire({
                        position: "center",
                        icon: "warning",
                        title: "ENTER DESCRIPTION",
                        showConfirmButton: false,
                        timer: 1500
                      });
                    </script>';
            }
        }

        ?>
        <Label style="font-size: 18px; font-family: sans-serif;
    font-weight: bold; color: #909290;">Edit Fee Parameter</Label>
        <div class="input-container" style="display: flex;">

            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">Field</label>
                <select name="field" required>
                    <option disabled selected>Select Field To Edit</option>
                    <option>DESCRIPTION</option>
                    <option>FEE TYPE</option>
                    <option>COST</option>
                </select>
            </div>

            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">Fee Parameter</label>
                <select name="descr" required>
                    <option disabled selected>Select Description To Edit</option>
                    <?php
                    $get_hos = "select DESCRIPTION,FEE_ID FROM FEE_PARAMETER ORDER BY DESCRIPTION";
                    $get = oci_parse(oci_connect($username, $password, $connection), $get_hos);
                    oci_execute($get);
                    while ($row = oci_fetch_array($get)) {
                        // 
                    ?><option value="<?php echo $row['FEE_ID'] ?>">
                            <?php echo $row["DESCRIPTION"]; ?>
                        </option> <?php
                                }
                                    ?>
                </select>
            </div>
        </div>
        <div class="input-container" style="display: flex;">

            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">New Description</label>
                <input type="text" placeholder="Enter Description" title="Only Letters" pattern="[A-z ]+" name="des">
            </div>

            <div class="input-field" style="margin-right: 10px;">
                <label for="subjectCode">Fee Type</label>
                <select required name="fee_type">
                    <option disabled selected>Select Fee Type</option>
                    <option>COMPULSORY</option>
                    <option>NON-COMPULSORY</option>
                </select>
            </div>

            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">New Cost</label>
                <input type="number" placeholder="Enter Cost" title="Only Numbers" name="cost">
            </div>

        </div>
        <div style="display: flex;">
            <button style=" display: inline-block;
  padding: 6px 12px;
  background-color: #909290;
  color: white;
  border: none;
  border-radius: 4px;
  margin-top:10px;
  margin-bottom:10px;
  text-decoration: none;" name="edit" type="submit">
                Edit Fee Parameter
                <i class="uil uil-edit"></i>
            </button>
        </div>

        <div class="input-field">

            <select required name="reg">
                <option disabled selected>Select Grade </option>
                <?php

                $get_hos = "select DISTINCT(CLASS_NAME),A.SUB_CODE  from SUB_CLASS A JOIN STUDENT_ACADEMIC B ON (A.SUB_CODE=B.SUB_CODE) WHERE a.S_ID= $sid order by a.class_name";
                //  echo $get_hos;
                $get = oci_parse(oci_connect($username, $password, $connection), $get_hos);
                oci_execute($get);
                while ($row = oci_fetch_array($get)) {
                ?><option value="<?php echo $row['SUB_CODE'] ?>">
                        <?php echo $row["CLASS_NAME"]; ?>
                    </option> <?php
                            }
                                ?>
            </select>
        </div>
        <button style=" display: inline-block;
  padding: 6px 12px;
  background-color: #909290;
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
                
                $sc = $_POST['reg'];
           //     header("refresh:2;");
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
        <?php

        $sql = "select * from student A JOIN STUDENT_ACADEMIC C ON (A.STUD_ID=C.STUD_ID) WHERE C.SUB_CODE= $sc ORDER BY A.NAME,A.CREATE_DT DESC";
        //  echo $sql;
        $stid = oci_parse($conn, $sql);
        oci_execute($stid);

        ?>
        <div style="display:flex; margin-top:20px;">
            <Label style="font-size: 18px; font-family: righteous;
         font-weight: bold; color: #909290;">Assign Non Compulsory Fee To Student</Label>
        </div>
        <div style="max-height: 200px; overflow-y: auto;">
            <table class="table-content" style="font-size: 14px; border-collapse: collapse; margin: 10px 0; font: 0.9em; min-width: 400px; border-radius: 5px 5px; overflow: hidden; box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);">
                <thead>
                    <tr style="background-color: #909290; color: #ffffff; text-align: left; font-weight: bold;">
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
        
        <div class="input-field">
        <select required name="fee">
                <option disabled selected>Select Fee</option>
                <?php

                $get_hos = "SELECT * FROM FEE_PARAMETER WHERE FEE_TYPE = 'NON-COMPULSORY' AND S_ID = $sid ";
                //  echo $get_hos;
                $get = oci_parse(oci_connect($username, $password, $connection), $get_hos);
                oci_execute($get);
                while ($row = oci_fetch_array($get)) {
                ?><option value="<?php echo $row['FEE_ID'] ?>">
                        <?php echo $row["DESCRIPTION"]; ?>
                    </option> <?php
                            }
                                ?>
            </select>
        </div>
        <div style="display: flex;">
            <button style=" display: inline-block;
  padding: 6px 12px;
  background-color: #909290;
  color: white;
  border: none;
  border-radius: 4px;
  margin-top:10px;
  margin-right: 10px;
  margin-bottom:10px;
  text-decoration: none;" name="enroll_student" type="submit">
                ASSIGN FEE
                <i class="uil uil-user-check"></i>
            </button>
        </div>
            <?php 
            if(isset($_POST['enroll_student'])){
                if (isset($_POST['enroll']) && !empty($_POST['enroll'])) {
                     if(isset($_POST['fee'])){
                        $selectedid = $_POST['enroll'];
                        foreach( $selectedid as $id){
                            $fid = $_POST['fee'];
                       //     echo $fid;
                            $sql = oci_parse($conn,"SELECT * FROM ACADEMIC_CALENDAR A JOIN TERM_CALENDAR B ON (A.ACADEMIC_YEAR = B.ACADEMIC_YEAR) WHERE A.STATUS ='ACCEPTED' AND B.STATUS = 'ACCEPTED' ");
                            oci_execute($sql);
                               while($r=oci_fetch_array($sql)){
                                   $a_y = $r['ACADEMIC_YEAR'];
                                   $t=$r['TERM'];
                               }
                             $sql = oci_parse($conn,"SELECT * FROM STUDENT_FINANCE WHERE ACADEMIC_YEAR = '$a_y' AND TERM ='$t' AND FEE_ID = $fid AND STUD_ID = '$id' ");
                             oci_execute($sql);
                             if(oci_fetch_all($sql,$a)>0){
                                echo '<script>
                                Swal.fire({
                                    position: "center",
                                    icon: "warning",
                                    title: "FEE ALREADY ASSIGNED FOR THIS TERM",
                                    showConfirmButton: false,
                                    timer: 1500
                                  });
                                </script>';
                                continue;
                                }
                            $sql = oci_parse($conn,"SELECT * FROM FEE_PARAMETER WHERE FEE_ID = $fid ");
                            oci_execute($sql);
                            while($r=oci_fetch_array($sql)){
                                $fee=$r['COST'];
                            }

                            $sql = oci_parse($conn,"INSERT INTO  STUDENT_FINANCE (STUD_ID,FEE_ID,AMOUNT,ACADEMIC_YEAR,TERM,BALANCE) VALUES ('$id',$fid,$fee,'$a_y','$t',$fee)");
                            if(oci_execute($sql)){
                                echo '<script>
                                Swal.fire({
                                    position: "center",
                                    icon: "success",
                                    title: "FEE ASSIGNED SUCCESSFULLY",
                                    showConfirmButton: false,
                                    timer: 1500
                                  });
                                </script>';
                            }else {
                                echo '<script>
                                Swal.fire({
                                    position: "center",
                                    icon: "error",
                                    title: "ERROR ASSIGNING FEE",
                                    showConfirmButton: false,
                                    timer: 1500
                                  });
                                </script>'; 
                            }
                        }
            
                     }else {
                        echo '<script>
                        Swal.fire({
                            position: "center",
                            icon: "warning",
                            title: "SELECT FEE",
                            showConfirmButton: false,
                            timer: 1500
                          });
                        </script>';
                     }
                }else {
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
            
?>
        <?php
        if (isset($_POST['edit'])) {
            if (isset($_POST['field'])) {
                if (isset($_POST['descr'])) {
                    $d = $_POST['descr'];

                    $field = $_POST['field'];

                    if ($field == 'DESCRIPTION') {
                        $des = strtoupper($_POST['des']);
                        if ($des != '') {
                            $sql = oci_parse($conn, "UPDATE FEE_PARAMETER SET DESCRIPTION = '$des' WHERE FEE_ID = $d ");
                            //echo "UPDATE FEE_PARAMETER SET DESCRIPTION = '$des' WHERE FEE_ID = $d ";
                            if (oci_execute($sql)) {
                                echo  '<script>
                                    Swal.fire({
                                        position: "center",
                                        icon: "success",
                                        title: "DESCRIPTION UPDATED SUCCESSFULLY",
                                        showConfirmButton: false,
                                        timer: 1500
                                      });
                                    </script>';
                                header("refresh:2;");
        ?></div><?php
                                            } else {
                                                echo  '<script>
                                                Swal.fire({
                                                    position: "center",
                                                    icon: "error",
                                                    title: "ERROR UPDATING DESCRIPTION",
                                                    showConfirmButton: false,
                                                    timer: 1500
                                                  });
                                                </script>';
                                                header("refresh:2;");
                                            }
                                        } else {
                                            echo  '<script>
                                Swal.fire({
                                    position: "center",
                                    icon: "warning",
                                    title: "ENTER DESCRIPTION",
                                    showConfirmButton: false,
                                    timer: 1500
                                  });
                                </script>';
                                            header("refresh:2;");
                                        }
                                    } else if ($field == 'COST') {
                                        $first = $_POST['cost'];
                                        if ($first != '') {
                                            $sql = oci_parse($conn, "UPDATE FEE_PARAMETER SET COST = $first WHERE FEE_ID = $d ");
                                            //echo "UPDATE FEE_PARAMETER SET DESCRIPTION = '$des' WHERE FEE_ID = $d ";
                                            if (oci_execute($sql)) {
                                                echo  '<script>
                                                 Swal.fire({
                                                     position: "center",
                                                     icon: "success",
                                                     title: "COST UPDATED SUCCESSFULLY",
                                                     showConfirmButton: false,
                                                     timer: 1500
                                                   });
                                                 </script>';
                                                header("refresh:2;");
                                            } else {
                                                echo  '<script>
                                                Swal.fire({
                                                    position: "center",
                                                    icon: "error",
                                                    title: "ERROR UPDATING COST",
                                                    showConfirmButton: false,
                                                    timer: 1500
                                                  });
                                                </script>';
                                                header("refresh:2;");
                                            }
                                        } else {
                                            echo  '<script>
                                Swal.fire({
                                    position: "center",
                                    icon: "warning",
                                    title: "ENTER COST",
                                    showConfirmButton: false,
                                    timer: 1500
                                  });
                                </script>';
                                            header("refresh:2;");
                                        }
                                    } else if ($field == 'FEE TYPE') {
                                        $first = $_POST['fee_type'];
                                        if ($first != '') {
                                            $sql = oci_parse($conn, "UPDATE FEE_PARAMETER SET FEE_TYPE = '$first' WHERE FEE_ID = $d ");
                                            //echo "UPDATE FEE_PARAMETER SET DESCRIPTION = '$des' WHERE FEE_ID = $d ";
                                            if (oci_execute($sql)) {
                                                echo  '<script>
                                                 Swal.fire({
                                                     position: "center",
                                                     icon: "success",
                                                     title: "FEE TYPE UPDATED SUCCESSFULLY",
                                                     showConfirmButton: false,
                                                     timer: 1500
                                                   });
                                                 </script>';
                                                header("refresh:2;");
                                            } else {
                                                echo  '<script>
                                                Swal.fire({
                                                    position: "center",
                                                    icon: "error",
                                                    title: "ERROR UPDATING FEE TYPE",
                                                    showConfirmButton: false,
                                                    timer: 1500
                                                  });
                                                </script>';
                                                header("refresh:2;");
                                            }
                                        } else {
                                            echo  '<script>
                                Swal.fire({
                                    position: "center",
                                    icon: "warning",
                                    title: "SELECT FEE TYPE",
                                    showConfirmButton: false,
                                    timer: 1500
                                  });
                                </script>';
                                            header("refresh:2;");
                                        }
                                    }
                                } else {
                                    echo  '<script>
                                Swal.fire({
                                    position: "center",
                                    icon: "warning",
                                    title: "SELECT DESCRIPTION TO EDIT",
                                    showConfirmButton: false,
                                    timer: 1500
                                  });
                                </script>';
                                }
                            } else {
                                echo  '<script>
                    Swal.fire({
                        position: "center",
                        icon: "warning",
                        title: "SELECT FIELD TO UPDATE",
                        showConfirmButton: false,
                        timer: 1500
                      });
                    </script>';
                            }
                        }
                                                ?>

        <?php
        if (isset($_POST['generate'])) {

            require('tcpdf/tcpdf.php');
            if (isset($_POST['reg'])) {
                $reg = $_POST['reg'];
                $get_hos = "select * from sub_class where class_name = '$reg' and s_id=$sid ";
                $get = oci_parse(oci_connect($username, $password, $connection), $get_hos);
                oci_execute($get);
                if ($row = oci_fetch_array($get)) {
                    $class = $row['CLASS'];
                    $cc = $row['SUB_CODE'];
                }
                $stmt = oci_parse($conn, "select a.region,b.district,c.school,c.address,c.phone_one,c.phone_two,c.email,c.logo,d.class_title from region a join district b on (a.reg_code=b.reg_code) join school c on (b.dis_code=c.dis_code) JOIN CLASS D on (c.s_id=d.s_id)  where c.s_id =:sid and d.class=:class");
                oci_bind_by_name($stmt, ':sid', $sid);
                oci_bind_by_name($stmt, 'class', $class);
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
                    $class_t = $row['CLASS_TITLE'];
                    $decodedContent = base64_decode($imageData);
                    // Save the decoded content to a file
                    $saveDirectory = 'C:/wamp64/www/Academix/Finance/img/';
                    $fileName = "school_logo.png";
                    // Create the directory if it doesn't exist
                    if (!is_dir($saveDirectory)) {
                        mkdir($saveDirectory, 0777, true); // Specify the appropriate permissions
                    }
                    // Construct the file path
                    $filePath = $saveDirectory . $fileName;
                    file_put_contents($filePath, $imageData);
                }
                $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
                // Add a page
                $pdf->AddPage();
                $pdf->SetHeaderMargin(0); // Set the header margin to zero
                $pdf->setPrintHeader(false);
                $pdf->setPrintFooter(false);
                $pdf->SetFont('helvetica', '', 10);
                $pdf->SetTextColor(29, 91, 121);
                $pdf->SetFont('helvetica', 'B', 25);
                $pdf->Cell(0, 130, 'INVOICE FOR ' . $reg, 0, 1, 'L');
                $pdf->Ln();
                $logoPath  = 'img/school_logo.png';
                $pdf->Image($logoPath, 170, 15, 30, 35);
                $pdf->Image($logoPath, 170, 15, 30, 35);
                $pdf->SetTextColor(29, 91, 121);
                $pdf->SetFont('dejavusans', '', 6.5);
                $companyInfo = "$school\n$address\n$district\n$region\nThe Gambia\n$email\nTel: $phone_one/ $phone_two";
                $pdf->SetXY(140, 60);
                $pdf->MultiCell(0, 9, $companyInfo, 0, 'R');

                // Get the Y-coordinate of the bottom of the "Invoice" title
                $invoiceTitleBottomY = $pdf->GetY();

                $pdf->SetY($invoiceTitleBottomY + 5);
                $pdf->Cell(10, 10, 'Date:', 0, 0);
                $pdf->Cell(0, 10, date('Y-m-d'), 0, 1);

                $s = "select description,cost,sum(cost) from tuition where class = $class and s_id = $sid and sub_code = $cc GROUP by description,cost";
                $stmts = oci_parse($conn, $s);
                oci_execute($stmts);
                // Table headers
                $pdf->SetFont('courier', 'B', 10);
                $pdf->Cell(60, 10, 'Description', 1, 0, 'C');
                //  $pdf->Cell(60, 10, 'Cost', 1, 0, 'C'); // Centralize the text
                $pdf->Cell(0, 10, 'Price', 1, 1, 'C'); // Centralize the text

                // Table content
                $pdf->SetFont('courier', 'B', 10);
                while ($row = oci_fetch_assoc($stmts)) {
                    $itemName = $row['DESCRIPTION'];
                    $curr = $row['COST'];
                    $itemPrice = $row['COST'];

                    $pdf->Cell(60, 10, $itemName, 1, 0, 'C');
                    //  $pdf->Cell(60, 10, $curr, 1, 0, 'C');
                    $pdf->Cell(0, 10, $itemPrice, 1, 1, 'C');;
                }
                $sql = "SELECT SUM(COST) FROM TUITION WHERE S_ID = $sid and class = $class and sub_code = $cc  ";
                $total = oci_parse($conn, $sql);
                oci_execute($total);
                while ($r = oci_fetch_array($total)) {
                    $tt = $r['SUM(COST)'];
                }
                // Set the Y-coordinate below the table for the total
                $pdf->SetY($pdf->GetY() + 10); // You may need to adjust the value based on your layout

                // Output the total on the far right
                $pdf->Cell(0, 10, 'Total: D' . number_format($tt, 2), 0, 1, 'R');

                $disclaimer = "This invoice was generated by $school";
                $pdf->SetFont('dejavusans', 'I', 8);
                $pdf->Cell(0, 5, $disclaimer, 0, 0, 'C');
                $directoryPath = 'C:\ACADEMIX\\' . $school . '\generated_reports\invoice\\';
                if (!is_dir($directoryPath)) {
                    if (!mkdir($directoryPath, 0777, true)) {
                        die('Failed to create directories.');
                    }
                }
                $filePath = $directoryPath . 'INVOICE.pdf';
                $pdf->Output($filePath, 'F'); // 'F' parameter saves to a file
        ?><div style="font-size:15px;
                color: green;
                position: relative;
                 display:flex;
                animation:button .3s linear;text-align: center;">
                    <?php echo "INVOICE GENERATED";
                    ?>
                    // ... your existing code to generate the Excel file ...
                    <?php
                    // Check if the file was successfully generated
                    if (file_exists($filePath)) {
                        // Construct the URL to the file
                        $fileUrl = 'http://' . $_SERVER['HTTP_HOST'] . '/' . $filePath;
                        // Redirect the user to the file URL
                        //  header('Location: ' . $fileUrl);
                        exit; // Terminate the script
                    } else {
                        echo "File not found or could not be generated.";
                    }
                    /* $filename = basename('INVOICE.pdf');
                    header("Cache-Control: public");
                    header("Content-Description: File Transfer");
                    header("Content-Disposition: attachment; filename=$filename");
                    header("Content-Type: application\zip");
                    header("Content-Transfer-Encoding: binary");
                    readfile($filePath);  */
                    if (file_put_contents($file_name, file_get_contents($url))) {
                        echo "File downloaded successfully";
                    } else {
                        echo "File downloading failed.";
                    }

                    ?>
                    <?php header("refresh:2;");
                    ?>
                </div> <?php
                    } else {
                        ?><div style="font-size:15px;
            color: red;
            position: relative;
             display:flex;
            animation:button .3s linear;text-align: center;">
                    <?php echo "SELECT CLASS";
                        header("refresh:2"); ?>
                </div> <?php
                    }
                }
                        ?>
        <div class="buttons">

            <button class="backBtn" type="submit">

                <a class="btnText" href="finance.php">
                    BACK
                </a>
            </button>
        </div>
    </form>
    <?php
    function ispdf_word($file)
    {
        $ext = pathinfo($file, PATHINFO_EXTENSION);
        if (in_array(strtolower($ext), ['pdf', 'doc', 'docx'])) {
            return true;
        }
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimetype = finfo_file($finfo, $file);
        finfo_close($finfo);
        if (in_array($mimetype, ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'])) {
            return true;
        }

        return false;
    }

    function isjpeg_png($file)
    {
        $type = [IMAGETYPE_JPEG, IMAGETYPE_PNG];
        $detect = exif_imagetype($file);
        if (in_array($detect, $type)) {
            return true;
        } else {
            return false;
        }
    }
    ?>
    <script>
        $(document).ready(function() {
            $('#example').DataTable();
        });
    </script>
</body>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</html>