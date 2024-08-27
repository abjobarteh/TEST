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

include 'connect.php';
$school =  $_SESSION['school'];
$sid = $_SESSION['sid'];
?>
<?php
// Include the auto_logout.php file
include('auto_logout.php');

// Your page content goes here
// ...
?>

<body>
<form class="container" enctype="multipart/form-data" action="school_users.php" method="post" style ="width:1500px;">
        <div class="com">
        <h3 style="color:#1D5B79;">Academix: School Management System</h3>
            <h3 class="title" style="justify-content:center; text-align:center; color:#1D5B79; 	font-size: 18px;"><?php echo $school ?>
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
        <header>School User Details</header>
    <?php 
        include 'connect.php'; 
        $region=" ";
        ?> 
     
        <?php

        include 'connect.php';

        if ($conn) {
            ob_start();
            $sql = "select * from school s join school_users u on (s.s_id=u.s_id) where u.s_id=$sid and u.rights !='STUDENT' order by u.firstname";
            
            $stid = oci_parse($conn, $sql);
            oci_execute($stid);
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
                        Firstname</th>
                        <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Middlename</th>
                        <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Lastname</th>
                        <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Date Of Birth</th>
                        <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Gender</th>
                        <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Address</th>
                        <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Mobile</th>
                        <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Work Telephone</th>
                          <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Email</th>
                        <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Username</th>
                        <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        User Rights</th>
                        <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        User Creation Date</th>
                        <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        User Status</th>
                </tr>
            </thead>
            <tbody>
                <tr style=" border-bottom: 1px solid #dddddd;">
                    <?php
                    while ($row = oci_fetch_array($stid)) {
                    ?>
                        <td style=" padding: 5px 8px;
    font-size: 13px;
    margin: 5px;">
                            <?php echo $row['FIRSTNAME']; ?>
                            
                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 13px;
    margin: 5px;">
                            <?php echo $row['MIDDLENAME']; ?>
                            
                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 13px;
    margin: 5px;">
                            <?php echo $row['LASTNAME']; ?>
                            
                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['DOB']; ?>
                            
                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 13px;
    margin: 5px;">
                            <?php echo $row['GENDER']; ?>
                            
                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 13px;
    margin: 5px;">
                            <?php echo $row['ADDRESS']; ?>
                            
                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 13px;
    margin: 5px;">
                            <?php echo $row['MOBILE']; ?>
                            
                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 13px;
    margin: 5px;">
                            <?php echo $row['WORK']; ?>
                            
                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 13px;
    margin: 5px;">
                            <?php echo $row['EMAIL']; ?>
                            
                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 13px;
    margin: 5px;">
                            <?php echo $row['USERNAME']; ?>
                            
                        </td>

                        <td style=" padding: 5px 8px;
    font-size: 13px;
    margin: 5px;">
                            <?php echo $row['RIGHTS']; ?>
                            
                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 13px;
    margin: 5px;">
                            <?php echo $row['CREATE_DT']; ?>
                            
                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 13px;
    margin: 5px;">
                            <?php echo $row['STATUS']; ?>
                            
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

                <a class="btnText" href="sysadmin.php">
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