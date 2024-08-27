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

<body>
<?php
// Include the auto_logout.php file
include('auto_logout.php');

// Your page content goes here
// ...
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

    <h2>Grade</h2>
    <form action="grade.php" method="post" style="min-height: 250px;">
      <div class="input-box">
        <input name="grade" placeholder="Enter Letter Grade" pattern="[A-F0-9+-]+"  required >
      </div>
      <button class="input-box button">
        <input type="Submit" value="Create Letter Grade" name="change" required type="text" >
      </button>
      <div class="text">
        <h3><a href="registra.php" style="text-decoration: none; font-size:15px; font-weight: 500px;">Return</a></h3>
      </div>
      <div class="message">
        <?php
        include 'connect.php';
        if (isset($_POST['change'])) {
            $grade = strtoupper($_POST['grade']);
              $sql = oci_parse($conn, "select *  from grade where grade = '$grade' ");
              oci_execute($sql);
              if(oci_fetch_all($sql,$a)==0){
                 $sql = oci_parse($conn, "INSERT INTO GRADE (GRADE,S_ID) VALUES ('$grade',$sid)");
                 if(oci_execute($sql)){
                    ?><div style="font-size:15px;
                color: green;
                position: relative;
                 display:flex;
                animation:button .3s linear;text-align: center;">
            <?php echo "GRADE CREATED SUCCESSFULLY";
            header("refresh:2;"); ?>
          </div> <?php
                 }else {
                    ?><div style="font-size:15px;
                    color: red;
                    position: relative;
                     display:flex;
                    animation:button .3s linear;text-align: center;">
                <?php echo "ERROR CREATING GRADE";
                header("refresh:2;"); ?>
              </div> <?php
                 }
              }else {
                ?><div style="font-size:15px;
                color: red;
                position: relative;
                 display:flex;
                animation:button .3s linear;text-align: center;">
            <?php echo "ENTER GRADE";
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