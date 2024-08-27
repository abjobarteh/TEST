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
$emp_id = $_SESSION['emp_id'];
?>
<?php
// Include the auto_logout.php file
include('auto_logout.php');

// Your page content goes here
// ...
?>

<body>
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
    <h2>Subject</h2>
    <form action="select_subject_marks.php" method="post" style="min-height: 250px;">
      <div class="input-box">
        <select required name="subject">
          <option disabled selected>Select Subject</option>
          <?php
          $get_hos = "select distinct(a.subject),a.sub_code,c.CLASS_NAME from waec_subject a join teacher_subject b on (a.sub_code=b.sub_code) join sub_class c on (b.s_code=c.sub_code) where b.emp_id= $emp_id order by a.subject,c.class_name";
          $get = oci_parse(oci_connect($username, $password, $connection), $get_hos);
          oci_execute($get);
          while ($row = oci_fetch_array($get)) {
          ?><option>
              <?php
              echo $row["SUBJECT"] . " (" . $row['CLASS_NAME'] . ")"; ?>
            </option> <?php
                    }
                      ?>
        </select>
      </div>
      <button class="input-box button">
        <input type="Submit" value="Continue" name="change" required>
      </button>
      <div class="text">
        <h3><a href="teacher.php" style="text-decoration: none; font-size:15px; font-weight: 500px;">Return</a></h3>
      </div>
      <div class="message">
        <?php
        include 'connect.php';
        if (isset($_POST['change'])) {
          if (isset($_POST['subject'])) {
            $classValue = $_POST['subject'];

            // If $row['CLASS_NAME'] is in the format "ClassName (AdditionalInfo)"
            // You can use the following code to extract the value within parentheses
            // If $classValue is in the format "Subject (ClassName)"
            if (strpos($classValue, '(') !== false && strpos($classValue, ')') !== false) {
              $startPos = strpos($classValue, '(') + 1;
              $endPos = strpos($classValue, ')', $startPos);
              $className = substr($classValue, $startPos, $endPos - $startPos);
              $subject = rtrim(substr($classValue, 0, $startPos - 1)); // Remove trailing space from subject
            } else {
              // If there are no parentheses, use the entire value as subject
              $subject = $classValue;
              $className = ''; // No class name
            }
//echo  "select a.SUB_CODE,c.S_CODE from waec_subject a join teacher_subject c on (a.sub_code=c.sub_code) join sub_class d on (c.s_code=d.sub_code) where c.emp_id= $emp_id and a.subject = '$subject' and d.class_name = '$className' ";
            $sql = oci_parse($conn, "select a.SUB_CODE,c.S_CODE from waec_subject a join teacher_subject c on (a.sub_code=c.sub_code) join sub_class d on (c.s_code=d.sub_code) where c.emp_id= $emp_id and a.subject = '$subject' and d.class_name = '$className' ");
            oci_execute($sql);
            while ($r = oci_fetch_array($sql)) {
              $s_code  = $r["S_CODE"];
              $sub_code = $r['SUB_CODE'];
            }
            $sql = oci_parse($conn, "select class_name from sub_class where sub_code = $s_code ");
            oci_execute($sql);
            while ($r = oci_fetch_array($sql)) {
              $class_name = $r["CLASS_NAME"];
            }
            $_SESSION['s_code'] = $s_code;
            $_SESSION['sub_code'] = $sub_code;
            $_SESSION['class_name'] = $class_name;
            $_SESSION['subject'] = $subject;
        ?><div style="font-size:15px;
                    color: green;
                    position: relative;
                     display:flex;
                    animation:button .3s linear;text-align: center;">
            <?php echo "STUDENT MARKS FOR $class_name TAKING $subject ";
            header("refresh:2;url=student_marks.php"); 
          } else {
            ?><div style="font-size:15px;
                    color: red;
                    position: relative;
                     display:flex;
                    animation:button .3s linear;text-align: center;">
                <?php echo "SELECT SUBJECT";
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