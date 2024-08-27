<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8" />
    <title>Teacher Dashboard</title>
    <!-- update css path -->
    <link rel="stylesheet" href="css/menu.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
</head>
<?php
ob_start();
session_start();
include 'connect.php';
$school =  $_SESSION['school'];
$sid= $_SESSION['sid'];
 ?>
<body>
<?php
include('auto_logout.php');
?>

    <nav class="sidebar">
        <a href="#" class="logo"> <?php

                                    ?>
        </a>
        <div class="menu-content">
            <ul class="menu-items">
                <div class="menu-title">Teacher</div>

                <li class="item">
                    <div class="submenu-item">
                        <span>Course Administration</span>
                        <span class="fas fa-caret-down first"></span>
                    </div>

                    <ul class="menu-items submenu">
                        <div class="menu-title">
                            <span class="fas fa-caret-down first"></span>
                            Course Administration
                        </div>
                        <li class="item">
                            <a href="my_subjects.php">My Subjects</a>
                        </li>
                        <li class="item">
                            <a href="select_subject_grade.php">Grade Settings</a>
                        </li>
                    </ul>
                </li>

                <li class="item">
                    <div class="submenu-item">
                        <span>Class Administration</span>
                        <span class="fas fa-caret-down first"></span>
                    </div>

                    <ul class="menu-items submenu">
                        <div class="menu-title">
                            <span class="fas fa-caret-down first"></span>
                            Class Administration
                        </div>
                        <li class="item">
                            <a href="class_roster.php">View Class Rosters</a>
                        </li>   
                        <li class="item">
                            <a href="compile_gpa.php">Compile Student Grades</a>
                        </li>   
                    </ul>
                </li>
                <li class="item">
                    <div class="submenu-item">
                        <span>Student Grades</span>
                        <span class="fas fa-caret-down first"></span>
                    </div>

                    <ul class="menu-items submenu">
                        <div class="menu-title">
                            <span class="fas fa-caret-down first"></span>
                            Student Grades
                        </div>
                        <li class="item">
                            <a href="select_subject_marks.php">Show Student Grade</a>
                        </li>
                        <li class="item">
                            <a href="select_subject.php">Enter Student Grade</a>
                        </li>
                        <li class="item">
                            <a href="select_verify.php">Verify Grade Batches</a>
                        </li>
                        <li class="item">
                            <a href="select_cumulate.php">Cumulate Student Marks</a>
                        </li>
                    </ul>
                </li>
                <li class="item">
                    <a href="../Landing/login.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>


    <nav class="navbar">
        <span class="fas fa-bars" id="sidebar-close"></span>
    </nav>
    <!-- End of Sidebar -->

    <!-- Content -->
    <main class="main">
        <h1>Academix:School Management System</h1>
        <h1><?php echo $school; ?></h1>
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
     <div style="font-size:25px;
                    color: red;
                    position: relative;
                     display:flex;
                    animation:button .3s linear;text-align: center;">
            <?php
            $sql = oci_parse($conn, "select * from academic_calendar  where s_id = $sid and start_dt is not null and end_dt is not null ");
            oci_execute($sql);
            if (oci_fetch_all($sql, $a) > 0) {
                $sql = oci_parse($conn, "select * from academic_calendar where s_id = $sid and start_dt is not null and end_dt is not null");
                oci_execute($sql);
                while ($r = oci_fetch_array($sql)) {
                    $end_dt = $r['END_DT'];
                    $a_y = $r['ACADEMIC_YEAR'];
                }
                if (date('Y-m-d') == $end_dt ||  date('Y-m-d') > $end_dt) {
                    $sql = oci_parse($conn, "UPDATE ACADEMIC_CALENDAR SET STATUS = 'EXPIRED' WHERE S_ID = $sid and ACADEMIC_YEAR = '$term' ");
                    oci_execute($sql);
                    echo "ACADEMIC YEAR HAS ENDED!!!!!!";
                } else {
                    $currentDate = date("Y-m-d");
                    $currentDateTime = new DateTime($currentDate);
                    $targetDateTime = new DateTime($end_dt);
                    ///Calculate the difference in days
                    $interval = $currentDateTime->diff($targetDateTime);
                    //  $numberOfDays = $interval->days;
                    echo "$interval->days Days Left To The End Of $a_y";
                };
            }
            ?>
        </div>
                    <div style="font-size:25px;
                    color: red;
                    position: relative;
                     display:flex;
                    animation:button .3s linear;text-align: center;">
            <?php
      
  $sql = oci_parse($conn, "select * from term_calendar  where s_id = $sid and start_dt is not null and end_dt is not null ");
  oci_execute($sql);
  if (oci_fetch_all($sql, $a) > 0) {
      $sql = oci_parse($conn, "select * from term_calendar where s_id = $sid and start_dt is not null and end_dt is not null ");
      oci_execute($sql);
      if ($r = oci_fetch_array($sql)) {
          $end_dt = $r['END_DT'];
          $term = $r['TERM'];
      }
      if (date('Y-m-d') == $end_dt || date('Y-m-d') > $end_dt) {
        
          $sql = oci_parse($conn, "UPDATE TERM_CALENDAR SET STATUS = 'EXPIRED' WHERE S_ID = $sid and term = '$term' ");
        oci_execute($sql);
          echo "$term HAS ENDED!!!!!!";
      } else {
          $currentDate = date("Y-m-d");
          $currentDateTime = new DateTime($currentDate);
          $targetDateTime = new DateTime($end_dt);

          ///Calculate the difference in days
          $interval = $currentDateTime->diff($targetDateTime);
          //  $numberOfDays = $interval->days;

          echo "$interval->days Days Left To The End Of $term";
      }
  }
            ?>
        </div>
    </main>
    <!-- update path -->
    <script src="js/script.js"></script>
</body>
</html>