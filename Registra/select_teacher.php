<!DOCTYPE html>

<html lang="en" dir="ltr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/login.css">
</head>
<?php
include 'connect.php';
ob_start();
session_start();
$school =  $_SESSION['school'];
$sid = $_SESSION['sid'];
?>

<body>
<?php
// Include the auto_logout.php file
include('auto_logout.php');
?>

  <div class="wrapper">
    <div class="com">
      <h3 class="title" style="justify-content:center; text-align:center; color:#1D5B79; 	font-size: 18px;">Welcome To Academix
      </h3>
      <h3 class="title" style="justify-content:center; text-align:center; color:#1D5B79; 	font-size: 18px;"><?php echo $school ?>
      </h3>
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
    <h2>Teacher</h2>
    <form action="select_teacher.php" method="post" style="min-height: 250px;">
      <div class="input-box">
      <select required name="teacher">
                <option disabled selected>Select Teacher</option>
                <?php
                $get_hos = "select * from employee where s_id = $sid and status = 'ACTIVE' ";
                $get = oci_parse(oci_connect($username, $password, $connection), $get_hos);
                oci_execute($get);
                while ($row = oci_fetch_array($get)) {
                ?><option value= <?php echo $row['EMP_ID']; ?> >
                        <?php echo $row['FIRSTNAME'].' '.$row['MIDDLENAME'].' '.$row['LASTNAME']; ?>
                    </option> <?php
                            }
                                ?>
            </select>
      </div>
      <button class="input-box button">
        <input type="Submit" value="Continue" name="change" required>
      </button>
      <div class="text">
        <h3><a href="registra.php" style="text-decoration: none; font-size:15px; font-weight: 500px;">Return</a></h3>
      </div>
      <div class="message">
        <?php
        include 'connect.php';
        if (isset($_POST['change'])) {
                if(isset($_POST['teacher'])) {
                   $emp_id = $_POST['teacher'];
                   $_SESSION['emp_id'] = $emp_id;
                   $sql = oci_parse($conn,"select * from employee where emp_id = $emp_id");
                   oci_execute($sql);
                   while($r= oci_fetch_array($sql)) {
                    $teacher = $r['FIRSTNAME'].' '.$r['MIDDLENAME'].' '.$r['LASTNAME'];
                    ?><div style="font-size:15px;
                    color: green;
                    position: relative;
                     display:flex;
                    animation:button .3s linear;text-align: center;">
                                    <?php echo "SELECTED TEACHER: $teacher";
                                        header("refresh:2;url=teacher_subject.php"); ?>
                                </div> <?php
                   }
                }else {
                    ?><div style="font-size:15px;
                    color: red;
                    position: relative;
                     display:flex;
                    animation:button .3s linear;text-align: center;">
                                    <?php echo "SELECT TEACHER ID";
                                        header("refresh:2;"); ?>
                                </div> <?php
                }
            }
                    ?>
      </div>
    </form>
  </div>
</body>

</html>