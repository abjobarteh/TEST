<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/show.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
</head>
<?php
ob_start();
session_start();
$school =  $_SESSION['school'];
$sid = $_SESSION['sid'];
$sub_cd =  $_SESSION['s_code'];
$stuid = $_SESSION['username'];
include 'connect.php'; ?>
<style>
    .field select:focus {
        padding-left: 47px;
        border: 2px solid #1D5B79;
        background-color: #ffffff;
    }

    .field select:focus~i {
        color: #1D5B79;
    }
</style>
<?php
// Include the auto_logout.php file
include('auto_logout.php');

// Your page content goes here
// ...
?>

<body>
    <form class="container" enctype="multipart/form-data" action="subject.php" method="post" style ="width: 2500px;">
        <div class="com">
            <h3>
                Academix: School Management System
            </h3>
            <h2 class="title" style="justify-content:center; text-align:center; color:#1D5B79; 	font-size: 18px;"><?php echo $school ?>
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

                <a class="btnText" href="student.php" style="font-size: 15px;">
                     HOME
                    <i class="uil uil-estate" style="width: 50px;"></i>
                </a>
            </button>
        </div>
        <header>Subject Information</header>
        <?php
        include 'connect.php';
        $region = " ";
     
   //  echo  "select * from student a  join class_student c on (a.stud_id=c.stud_id) where a.s_id = $sid and c.sub_code = $sub_cd and a.status != 'GRADUATED' ORDER BY NAME";
        ?>
    
        <?php

        include 'connect.php';
     
        
        if ($conn) {

            ob_start();
            $sql = "select * from class_student where stud_id = '$stuid'";
            $getsub= oci_parse($conn,$sql);
            oci_execute($getsub);
            while($ro = oci_fetch_array($getsub)){
                $sub_cd = $ro["SUB_CODE"];
            }
            $s = "select distinct(f.emp_id),a.subject,h.firstname,h.middlename,h.lastname from waec_subject a join student_subject b on (a.sub_code=b.sub_code) join teacher_subject f on (f.sub_code=a.sub_code) join sub_class g on (f.s_code=g.sUB_code) join employee h ON (f.emp_id=h.emp_id)  JOIN CLASS_STUDENT I  ON (G.SUB_CODE=I.SUB_CODE) where b.stud_id = '$stuid' AND i.SUB_code = $sub_cd order by a.subject ";
   //   echo $s;
            $subj = oci_parse($conn, $s);
            oci_execute($subj);
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
        <div style="display:flex; margin-top:20px;">
            <Label style="font-size: 18px; font-family: righteous;
         font-weight: bold; color: #1D5B79;">Subject Information</Label>
        </div>
        <table class="table-content" style="  font-size: 14px;
    border-collapse: collapse;
    margin: 10px 0;
    font: 0.9em;
    min-width: 400px;
    border-radius: 5px 5px;
    overflow: hidden;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);">
            <thead>
                <tr style="  background-color: #1D5B79;
    color: #ffffff;
    text-align: left;
    font-weight: bold;">

                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Subject</th>
                  
                        <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Subject Teacher</th>
                </tr>
            </thead>
            <tbody>
                <tr style=" border-bottom: 1px solid #dddddd;">
                    <?php
                    while ($row = oci_fetch_array($subj)) {
                    ?>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['SUBJECT']; ?>

                        </td>
                      
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['FIRSTNAME'] ." ".$row['MIDDLENAME']." ".$row['LASTNAME'];; ?>

                        </td>
                </tr>
            <?php
                    }
            ?>
            </tr>
            </tbody>
        </table>

        <div class="buttons">

            <button class="backBtn" type="submit">

                <a class="btnText" href="student.php">
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