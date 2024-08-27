<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/show_users.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <!-- Option 1: Include in HTML -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
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
</head>
<?php
include 'connect.php';
ob_start();
session_start();
$class = '';
$school =  $_SESSION['school'];
$sid = $_SESSION['sid'];
$c=$_SESSION['class']= $c;
$n_c=$_SESSION['next_class'];
$currennt_class=$_SESSION['C_class'];
$sub_title =  $_SESSION['sub_t'];
$s_code=$_SESSION['s_code'] ;
$emp_id = $_SESSION['emp_id'];
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

?>

<body>
    <form class="container" enctype="multipart/form-data" action="promotion.php" method="post">
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
        <header>Promotion</header>
        <?php
        include 'connect.php';
        $sql = oci_parse($conn, "select * from academic_calendar a join term_calendar b on (a.academic_year=b.academic_year) where b.start_dt is not null order by b.term desc");
        oci_execute($sql);
        if ($row = oci_fetch_array($sql)) {
            $a_y = $row['ACADEMIC_YEAR'];
            $t = $row['TERM'];
        }
        $sql = oci_parse($conn,"SELECT * FROM SUB_CLASS A JOIN CLASS_TEACHER B ON (A.SUB_CODE=B.SUB_CODE) JOIN CLASS C ON (C.CLASS=A.CLASS) WHERE B.EMP_ID = '$emp_id'");
        oci_execute($sql);
        while($r=oci_fetch_array($sql)){
            $currennt_class = $r['CLASS_NAME'];
            $n_c=$r['CLASS']+1;
        }

        ?>
        <div class="input-container" style="display: flex;">
            <div class="input-field" style="margin-right: 10px;">
                <label>Academic Year</label>
                <input type="text" placeholder="<?php echo $a_y ?>" style="width:300px;" readonly>
            </div>

            <div class="input-field" style="margin-right: 10px;">
                <label>Current Class</label>
                <input type="text" placeholder="<?php 
                
                echo $currennt_class?>" style="width:300px;" readonly>
            </div>
        
            
        </div>
       <?php //echo "select * from CLASS WHERE S_ID= $sid and  class = 10 or class = 11 order by class"; ?>
                        
        <div class="input-field" style="margin-right: 10px;">
           
          
            <?php //echo "select DISTINCT(B.CLASS_NAME),B.SUB_CODE from CLASS a join sub_class b on (a.class=b.class) join class_student c on (b.sub_code=c.sub_code) join student d on (c.stud_id=d.stud_id) where a.class = '$next_class' and  b.SUB_CODE != 286 AND b.SUB_CODE != 290 AND b.SUB_CODE != 141 ORDER BY b.CLASS_NAME"; ?>
            <label>Promoting Class</label>
            <select required name="class_name">
                <option disabled selected>Select Class Name</option>
                <?php
                $class = $_SESSION['fil_class'];
                $get_hos = "select DISTINCT(B.CLASS_NAME),B.SUB_CODE from CLASS a join sub_class b on (a.class=b.class) join class_student c on (b.sub_code=c.sub_code) join student d on (c.stud_id=d.stud_id) where a.class = '$n_c' and  b.SUB_CODE != 286 AND b.SUB_CODE != 290 AND b.SUB_CODE != 141 ORDER BY b.CLASS_NAME ";
                $get = oci_parse(oci_connect($username, $password, $connection), $get_hos);
                oci_execute($get);
                while ($row = oci_fetch_array($get)) {
                ?><option value="<?php echo $row["SUB_CODE"]; ?> ">
                        <?php echo $row["CLASS_NAME"]; ?>
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
  margin-top:10px;
  margin-bottom:10px;
  text-decoration: none;" name="promote" type="submit">
                PROMOTE
                <i class="bi bi-card-checklist"></i>
            </button>
            <?php 
              if(isset($_POST['promote'])){
                if(isset($_POST['class_name'])){
                $code = $_POST['class_name'];
                  $sql = oci_parse($conn,"SELECT * FROM STUDENT_STANDINGS WHERE STUD_ID IN (SELECT * FROM CLASS_STUDENT WHERE SUB_CODE = $s_code) AND GPA >= 2.0 AND ACADEMIC_YEAR  = '$a_y' AND CLASS_CODE = $s_code  ");
                  oci_execute($sql);
               //   echo $code;
                 while($r=oci_fetch_array($sql)){
                    $st = $r['STUD_ID'];
                    $sql = oci_parse($conn,"UPDATE CLASS_STUDENT SET SUB_CODE = $code WHERE STUD_ID = '$st'");
                  } 
                  echo '<script>
                  Swal.fire({
                      position: "center",
                      icon: "success",
                      title: "PROMOTION COMPLETE",
                      showConfirmButton: false,
                      timer: 1500
                    });
                  </script>';
                }else {
                    echo '<script>
															Swal.fire({
																position: "center",
																icon: "warning",
																title: "SELECT PROMOTING CLASS",
																showConfirmButton: false,
																timer: 1500
															  });
															</script>';
                }

              }
            ?>
            <button style=" display: inline-block;
  padding: 6px 12px;
  background-color: #04716f;
  color: white;
  border: none;
  border-radius: 4px;
  margin-top:10px;
  margin-bottom:10px;
  text-decoration: none;" name="download" type="submit">
                REFRESH
                <i class="bi bi-arrow-clockwise"></i>
            </button>
            <?php

                    if (isset($_POST['download'])) {
                        header("refresh:2;");
                    }
                            ?>
        </div>
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