<!DOCTYPE html>

<html lang="en" dir="ltr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/login.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="stylesheet" type="text/css" href="https://common.olemiss.edu/_js/sweet-alert/sweet-alert.css" />
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
    <h2>Class</h2>
    <form action="select_class_compile.php" method="post" style="min-height: 250px;">
      <div class="input-box">
      <select required name="class">
                <option disabled selected>Select Class</option>
                <?php
                $get_hos = "SELECT DISTINCT(A.SUB_CODE),A.CLASS_NAME FROM SUB_CLASS A JOIN CLASS_STUDENT B ON (A.SUB_CODE=B.SUB_CODE) ORDER BY A.CLASS_NAME ";
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


      <div class="input-box">
        <select required name="term">
          <option disabled selected>Select Term</option>
          <?php
          $get_hos = "select DISTINCT(C.TERM) from academic_calendar a join term_calendar b on (a.academic_year=b.academic_year) JOIN STUDENT_CUMULATIVE C ON (B.TERM=C.TERM) ORDER BY C.TERM";
          $conn = oci_connect($username, $password, $connection);
          $get = oci_parse($conn, $get_hos);
          oci_execute($get);
          while ($row = oci_fetch_array($get, OCI_ASSOC)) {
          ?>
            <option >
              <?php echo $row["TERM"]; ?>
            </option>
          <?php
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
          if (isset($_POST['class'])) {
            if (isset($_POST['term'])) {
              $term = $_POST['term'];
              $class = $_POST['class'];

              // If $row['CLASS_NAME'] is in the format "ClassName (AdditionalInfo)"
              // You can use the following code to extract the value within parentheses
        
            //  echo  "select a.SUB_CODE,c.S_CODE from waec_subject a join teacher_subject c on (a.sub_code=c.sub_code) join sub_class d on (c.s_code=d.sub_code) where c.emp_id= $emp_id and a.subject = '$subject' and d.class_name = '$className' ";
          //  echo "select from sub_class where class_name = '$class'";
            $sql = oci_parse($conn,"select * from sub_class where class_name = '$class'");
              oci_execute($sql);
              while ($r = oci_fetch_array($sql)) {
            
                $sub_code = $r['SUB_CODE'];
            //    echo $sub_code;
              }
              $sql = oci_parse($conn, "select * class_name from sub_class where sub_code = $s_code ");
              oci_execute($sql);
              while ($r = oci_fetch_array($sql)) {
                $class_name = $r["CLASS_NAME"];
              }
           //  echo $sub_code;
              $_SESSION['sub_code'] = $sub_code;
              $_SESSION['class_name'] = $class_name;
              $_SESSION['term']=$term ;
        ?><div style="font-size:15px;
                      color: green;
                      position: relative;
                       display:flex;
                      animation:button .3s linear;text-align: center;">
              <?php
          echo '<script>
                     Swal.fire({
                       position: "center",
                       icon: "success",
                       title: "COMPILE STUDENT GPA UNDER ' . $class . ' FOR ' . $term .'",
                       showConfirmButton: false,
                       timer: 1500
                       });
                     </script>';
              //  echo "VERIFY STUDENT MARKS FOR $class_name TAKING $subject";
            header("refresh:2;url=compile_gpa.php");
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
                          title: "SELECT TERM",
                          showConfirmButton: false,
                          timer: 1500
                          });
                        </script>';
                  header("refresh:2;"); ?>
                </div> <?php
                      }
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
                      header("refresh:2;"); ?>
              </div> <?php
                    }
                  }
                    ?>
      </div>
    </form>
  </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</html>