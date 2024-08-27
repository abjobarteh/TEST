<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8" />
    <title>Principal Dashboard</title>
    <!-- update css path -->
    <link rel="stylesheet" href="css/menu.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
</head>
<?php
ob_start();
session_start();
$school =  $_SESSION['school'];
$sid = $_SESSION['sid'];
include 'connect.php'; ?>
<style>
            .card {
                background-color: #1D5B79;
                border-radius: 10px;
                padding: 20px;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
                margin: 20px;
            }

            .card h2 {
                color: white;
                text-align: center;
                font-size: 25px;
            }
        </style>
<body>

    <nav class="sidebar">
        <a href="#" class="logo"> <?php

                                    ?>
        </a>
        <div class="menu-content">
            <ul class="menu-items">
                <div class="menu-title">Principal</div>


                <li class="item">

                    <div class="submenu-item">
                        <span>Academic Year and Term Setup/Management</span>
                        <span class="fas fa-caret-down first"></span>
                    </div>

                    <ul class="menu-items submenu">
                        <div class="menu-title">
                            <span class="fas fa-caret-down first"></span>
                            Academic Year and Term Setup/Management
                        </div>
                        <li class="item">
                            <a href="academic_year_setup.php">Approve/Reject Academic Year Setup</a>
                        </li>
                        <li class="item">
                            <a href="term_setup.php">Approve Term Setup</a>
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
                            <a href="#">View Class Rosters</a>
                        </li>
                        <li class="item">
                            <a href="#">Class Attendance</a>
                        </li>
                    </ul>
                </li>


                <li class="item">
                    <div class="submenu-item">
                        <span>Student Marks</span>
                        <span class="fas fa-caret-down first"></span>
                    </div>

                    <ul class="menu-items submenu">
                        <div class="menu-title">
                            <span class="fas fa-caret-down first"></span>
                            Student Marks
                        </div>
                        <li class="item">
                            <a href="select_unprocess.php">UnProcessed Marks</a>
                        </li>
                        <li class="item">
                            <a href="select_uncumulate.php">UnVerified Marks</a>
                        </li>
                        <li class="item">
                            <a href="pending_marks.php">Pending Teacher Marks</a>
                        </li>
                        <li class="item">
                            <a href="top_students.php">Top Students</a>
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
//  ?>
        <div class="card">
            <h2>Academic Year</h2>
            <?php
            $sql = oci_parse($conn, "select * from academic_calendar  where s_id = $sid and start_dt is not null and end_dt is not null ");
            oci_execute($sql);
            if (oci_fetch_all($sql, $a) > 0) {
                $sql = oci_parse($conn, "select CEIL(TO_DATE(END_DT, 'YYYY-MM-DD') - SYSDATE) AS DAYS_BETWEEN ,START_DT,END_DT,ACADEMIC_YEAR from academic_calendar where s_id = $sid and start_dt is not null and end_dt is not null order by academic_year");
                oci_execute($sql);
                if ($r = oci_fetch_array($sql)) {
                    $start_dt = $r['START_DT'];
                    $end_dtS = $r['END_DT'];
                    $A_Y = $r['ACADEMIC_YEAR'];
                    $dt_1 = $r['DAYS_BETWEEN'];
                }
                if (date('Y-m-d') == $end_dtS || date('Y-m-d') > $end_dtS) {
                    $sql = oci_parse($conn, "UPDATE TERM_CALENDAR SET STATUS = 'EXPIRED' WHERE S_ID = $sid and term = '$term' ");
                    oci_execute($sql);
                    echo "$term HAS ENDED!!!!!!";
                } else {
                    $currentDateS = date("Y-m-d");
                    $currentDateTimeS = new DateTime($start_dt);
                    $targetDateTimeS = new DateTime($end_dtS);
                    $intervals = $currentDateTimeS->diff($targetDateTimeS);
                    echo "$dt_1 Days Left To The End Of $A_Y";
                }
            }
            ?>
        </div>

        <div class="card">
            <h2>Term</h2>
            <?php
            $sql = oci_parse($conn, "select * from term_calendar  where s_id = $sid and start_dt is not null and end_dt is not null ");
            oci_execute($sql);
            if (oci_fetch_all($sql, $a) > 0) {
                $sql = oci_parse($conn, "select CEIL(TO_DATE(END_DT, 'YYYY-MM-DD') - SYSDATE) AS DAYS_BETWEEN ,START_DT,END_DT,TERM from term_calendar where s_id = $sid and start_dt is not null and end_dt is not null order by term desc");
                oci_execute($sql);
                if ($r = oci_fetch_array($sql)) {
                    $start_dt = $r['START_DT'];
                    $end_dtS = $r['END_DT'];
                    $term = $r['TERM'];
                    $day = $r['DAYS_BETWEEN'];
                }
                if (date('Y-m-d') == $end_dtS || date('Y-m-d') > $end_dtS) {
                    $sql = oci_parse($conn, "UPDATE TERM_CALENDAR SET STATUS = 'EXPIRED' WHERE S_ID = $sid and term = '$term' ");
                    oci_execute($sql);
                    echo "$term HAS ENDED!!!!!!";
                } else {
                    $currentDateS = date("Y-m-d");
                    $currentDateTimeS = new DateTime($start_dt);
                    $targetDateTimeS = new DateTime($end_dtS);
                    $intervals = $currentDateTimeS->diff($targetDateTimeS);
                    echo "$day Days Left To The End Of $term";
                }
            }
            ?>
        </div>
    </main>
    <!-- update path -->
    <script src="js/script.js"></script>
</body>

</html>