<!DOCTYPE html>

<html lang="en" dir="ltr">

<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="css/login.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
  <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
  <script src="https://kit.fontawesome.com/a81368914c.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="stylesheet" type="text/css" href="https://common.olemiss.edu/_js/sweet-alert/sweet-alert.css" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
</head>
<?php
include 'connect.php';
ob_start();
session_start();
$school =  $_SESSION['school'];
$sid = $_SESSION['sid'];
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
    <h2>Change Password</h2>
    <form action="forgot.php" method="post" style="min-height: 250px;">
      <div class="input-box">
        <input type="password" placeholder="Enter your Password" required name="p1">
      </div>
      <div class="input-box">
        <input type="password" placeholder="Confirm Password" required name="p2">
      </div>
      <button class="input-box button">
        <input type="Submit" value="Change" name="change">
      </button>
      <div class="message">
        <?php
        include 'connect.php';
        if (isset($_POST['change'])) {
          if ($conn) {
            $pass = $_POST['p1'];
            $con = $_POST['p2'];
            if ($pass == $con) {
              $pass = password_hash($pass, PASSWORD_DEFAULT);
              $uname = $_SESSION['username'];
              $sql = "update school_users set password='$pass' where username='$uname' and s_id = $sid ";
              $st = oci_parse($conn, $sql);
              if (oci_execute($st)) {
        ?><div style="font-size:15px;
                      color: green;
                      position: relative;
                      display:flex;
                      animation:button .3s linear;text-align: center;">
                  <?php
                  echo
                  '<script>
Swal.fire({
	position: "center",
	icon: "success",
	title: "PASSWORD CHANGED SUCCESSFULLY",
	showConfirmButton: false,
	timer: 1500
  });
</script>';
                  header("refresh:3;url=login.php");
                  ?>
                </div><?php
                    }
                  } else {
                      ?><div style="font-size:15px;
                    color: red;
                    position: relative;
                    display:flex;
                    animation:button .3s linear;text-align: center;">
              <?php
                    echo   '<script>
                    Swal.fire({
                      position: "center",
                      icon: "error",
                      title: "PASSWORDS DO NOT MATCH",
                      showConfirmButton: false,
                      timer: 1500
                      });
                    </script>';
                    header("refresh:2;");
                  }
              ?>
              </div><?php
                  } else {
                    ?><div style="font-size:15px;
                  color: red;
                  position: relative;
                  display:flex;
                  animation:button .3s linear;text-align: center;">
                <?php
                    echo '<script>
                    Swal.fire({
                      position: "center",
                      icon: "error",
                      title: "ERROR CONNECTING TO DATABASE",
                      showConfirmButton: false,
                      timer: 1500
                      });
                    </script>';
                ?>
              </div><?php
                  }
                }
                    ?>
      </div>
    </form>
  </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</html>