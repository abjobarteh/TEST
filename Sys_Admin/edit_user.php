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
$rcode = $sid;
?>
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
    <form class="container" enctype="multipart/form-data" action="edit_user.php" method="post">
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
        <header>Edit User</header>

        <?php
        include 'connect.php';


        if ($conn) {
            $sql = "select * from school s join school_users u on (s.s_id=u.s_id) where u.s_id=$sid and u.rights != 'STUDENT' ORDER BY u.username";

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
       <div style="overflow-x:auto; max-height: 300px;">
    <table class="table-content" style="font-size: 14px; border-collapse: collapse; margin: 10px 0; font: 0.9em; min-width: 400px; border-radius: 5px 5px; overflow: hidden; box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);">
        <thead>
            <tr style="background-color: #1D5B79; color: #ffffff; text-align: left; font-weight: bold;">
                <th style="padding: 5px 8px; font-size: 10px; margin: 5px;">Firstname</th>
                <th style="padding: 5px 8px; font-size: 10px; margin: 5px;">Middlename</th>
                <th style="padding: 5px 8px; font-size: 10px; margin: 5px;">Lastname</th>
                <th style="padding: 5px 8px; font-size: 10px; margin: 5px;">Date Of Birth</th>
                <th style="padding: 5px 8px; font-size: 10px; margin: 5px;">Gender</th>
                <th style="padding: 5px 8px; font-size: 10px; margin: 5px;">Address</th>
                <th style="padding: 5px 8px; font-size: 10px; margin: 5px;">Mobile</th>
                <th style="padding: 5px 8px; font-size: 10px; margin: 5px;">Work Telephone</th>
                <th style="padding: 5px 8px; font-size: 10px; margin: 5px;">Email</th>
                <th style="padding: 5px 8px; font-size: 10px; margin: 5px;">Username</th>
                <th style="padding: 5px 8px; font-size: 10px; margin: 5px;">User Rights</th>
                <th style="padding: 5px 8px; font-size: 10px; margin: 5px;">User Creation Date</th>
                <th style="padding: 5px 8px; font-size: 10px; margin: 5px;">User Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = oci_fetch_array($stid)) {
            ?>
                <tr style="border-bottom: 1px solid #dddddd;">
                    <td style="padding: 5px 8px; font-size: 10px; margin: 5px;"><?php echo $row['FIRSTNAME']; ?></td>
                    <td style="padding: 5px 8px; font-size: 10px; margin: 5px;"><?php echo $row['MIDDLENAME']; ?></td>
                    <td style="padding: 5px 8px; font-size: 10px; margin: 5px;"><?php echo $row['LASTNAME']; ?></td>
                    <td style="padding: 5px 8px; font-size: 10px; margin: 5px;"><?php echo $row['DOB']; ?></td>
                    <td style="padding: 5px 8px; font-size: 10px; margin: 5px;"><?php echo $row['GENDER']; ?></td>
                    <td style="padding: 5px 8px; font-size: 10px; margin: 5px;"><?php echo $row['ADDRESS']; ?></td>
                    <td style="padding: 5px 8px; font-size: 10px; margin: 5px;"><?php echo $row['MOBILE']; ?></td>
                    <td style="padding: 5px 8px; font-size: 10px; margin: 5px;"><?php echo $row['WORK']; ?></td>
                    <td style="padding: 5px 8px; font-size: 10px; margin: 5px;"><?php echo $row['EMAIL']; ?></td>
                    <td style="padding: 5px 8px; font-size: 10px; margin: 5px;"><?php echo $row['USERNAME']; ?></td>
                    <td style="padding: 5px 8px; font-size: 10px; margin: 5px;"><?php echo $row['RIGHTS']; ?></td>
                    <td style="padding: 5px 8px; font-size: 10px; margin: 5px;"><?php echo $row['CREATE_DT']; ?></td>
                    <td style="padding: 5px 8px; font-size: 10px; margin: 5px;"><?php echo $row['STATUS']; ?></td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>

        <?php
        include 'connect.php';
        if ($conn) {
            //  $sql = "select * from student s join finance_recordS f on (s.stuid=f.stuid) where f.stuid='$region' ";

            //  $stidD = oci_parse($conn, $sql);
            //  oci_execute($stidD);
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
        <div class="input-container" style="display: flex;">
            <div class="input-field" style="margin-right: 10px;">
                <select required name="user">
                    <option disabled selected>Select Username</option>
                    <?php

                    $get_hos = "select * from sCHOOL_USERS where s_id = $sid and status !='GRADUATED' order by firstname";
                    $get = oci_parse($conn, $get_hos);
                    oci_execute($get);
                    while ($row = oci_fetch_array($get)) {
                    ?><option value="<?php echo $row['USERNAME'] ?>">
                            <?php echo trim($row["FIRSTNAME"] . " " . $row["MIDDLENAME"] . " " . $row["LASTNAME"]."(".$row['USERNAME'].")" ); ?>
                        </option> <?php
                                }
                                    ?>
                </select>
            </div>
            <div class="input-field" style="margin-right: 10px;">
                <select name="act" required>
                    <option value="" disabled selected>Select Data To Update</option>
                    <option>FIRSTNAME</option>
                    <option>MIDDLENAME</option>
                    <option>LASTNAME</option>
                    <option>DOB</option>
                    <option>GENDER</option>
                    <option>ADDRESS</option>
                    <option>MOBILE</option>
                    <option>WORK</option>
                    <option>EMAIL</option>
                    <option>USER RIGHTS</option>
                    <option>USER STATUS</option>
                    <option>PASSWORD</option>
                </select>
            </div>
            <?php
            include 'connect.php';
            if (isset($_POST['update'])) {
                if (isset($_POST['user'])) {
                    $user = $_POST['user'];
                    $act = $_POST['act'];
                    if ($act == 'FIRSTNAME') {
                        $firstname = strtoupper($_POST['first']);
                        $update = oci_parse($conn, "update school_users set firstname = '$firstname'  where username = '$user' and s_id= $rcode ");
                        oci_execute($update);
                        $update = oci_parse($conn, "select * from school_users where firstname = '$firstname' and username = '$user' and s_id= $rcode ");
                        oci_execute($update);
                        if (oci_fetch_all($update, $a) > 0) {
            ?><div style="font-size:13px;
                        color: green;
                        position: relative;
                        display:flex;
                        margin-left:10px;
                        text-align: center;
                        justify-content:center;
                        animation:button .3s linear;text-align: center;">
                                <?php
                                echo "FIRSTNAME UPDATE SUCCESSFUL FOR $user";
                                header("refresh:3;");
                                ?>
                            </div> <?php
                                } else {
                                    ?><div style="font-size:13px;
                                            color: red;
                                            position: relative;
                                            display:flex;
                                            margin-left:10px;
                                            text-align: center;
                                            justify-content:center;
                                            animation:button .3s linear;text-align: center;">
                                <?php
                                    echo "ERROR UPDATING FIRSTNAME FOR $user";
                                    header("refresh:3;");
                                ?>
                            </div> <?php
                                }
                            } else 
                            if ($act == 'MIDDLENAME') {
                                $firstname = strtoupper($_POST['middle']);
                                $update = oci_parse($conn, "update school_users set middlename = '$firstname'  where username = '$user' and s_id= $rcode ");
                                oci_execute($update);
                                $update = oci_parse($conn, "select * from school_users where middlename = '$firstname' and username = '$user' and s_id= $rcode  ");
                                oci_execute($update);
                                if (oci_fetch_all($update, $a) > 0) {
                                    ?><div style="font-size:13px;
                                color: green;
                                position: relative;
                                display:flex;
                                margin-left:10px;
                                text-align: center;
                                justify-content:center;
                                animation:button .3s linear;text-align: center;">
                                <?php
                                    echo "MIDDLENAME UPDATE SUCCESSFUL FOR $user";
                                    header("refresh:3;");
                                ?>
                            </div> <?php
                                } else {
                                    ?><div style="font-size:13px;
                                                    color: red;
                                                    position: relative;
                                                    display:flex;
                                                    margin-left:10px;
                                                    text-align: center;
                                                    justify-content:center;
                                                    animation:button .3s linear;text-align: center;">
                                <?php
                                    echo "ERROR UPDATING MIDDLENAME FOR $user";
                                    header("refresh:3;");
                                ?>
                            </div> <?php
                                }
                            } else 
                            if ($act == 'LASTNAME') {
                                $firstname = strtoupper($_POST['last']);
                                $update = oci_parse($conn, "update school_users set lastname = '$firstname'  where username = '$user' and s_id= $rcode ");
                                oci_execute($update);
                                $update = oci_parse($conn, "select * from school_users where lastname = '$firstname' and username = '$user' and s_id= $rcode  ");
                                oci_execute($update);
                                if (oci_fetch_all($update, $a) > 0) {
                                    ?><div style="font-size:13px;
                                color: green;
                                position: relative;
                                display:flex;
                                margin-left:10px;
                                text-align: center;
                                justify-content:center;
                                animation:button .3s linear;text-align: center;">
                                <?php
                                    echo "LASTNAME UPDATE SUCCESSFUL FOR $user";
                                    header("refresh:3;");
                                ?>
                            </div> <?php
                                } else {
                                    ?><div style="font-size:13px;
                                                    color: red;
                                                    position: relative;
                                                    display:flex;
                                                    margin-left:10px;
                                                    text-align: center;
                                                    justify-content:center;
                                                    animation:button .3s linear;text-align: center;">
                                <?php
                                    echo "ERROR UPDATING LASTNAME FOR $user";
                                    header("refresh:3;");
                                ?>
                            </div> <?php
                                }
                            } else 
                                    if ($act == 'DOB') {
                                $firstname = $_POST['dob'];
                                $update = oci_parse($conn, "update school_users set dob = '$firstname'  where username = '$user' and s_id = $rcode ");
                                oci_execute($update);
                                $update = oci_parse($conn, "select * from school_users where dob = '$firstname' and username = '$user' and s_id = $rcode  ");
                                oci_execute($update);
                                if (oci_fetch_all($update, $a) > 0) {
                                    ?><div style="font-size:13px;
                                        color: green;
                                        position: relative;
                                        display:flex;
                                        margin-left:10px;
                                        text-align: center;
                                        justify-content:center;
                                        animation:button .3s linear;text-align: center;">
                                <?php
                                    echo "DATE OF BIRTH UPDATE SUCCESSFUL FOR $user";
                                    header("refresh:3;");
                                ?>
                            </div> <?php
                                } else {
                                    ?><div style="font-size:13px;
                                                            color: red;
                                                            position: relative;
                                                            display:flex;
                                                            margin-left:10px;
                                                            text-align: center;
                                                            justify-content:center;
                                                            animation:button .3s linear;text-align: center;">
                                <?php
                                    echo "ERROR UPDATING DATE OF BIRTH FOR $user";
                                    header("refresh:3;");
                                ?>
                            </div> <?php
                                }
                            } else 
                                            if ($act == 'GENDER') {
                                $firstname = $_POST['gender'];
                                $update = oci_parse($conn, "update school_users set gender = '$firstname'  where username = '$user' and s_id = $rcode ");
                                oci_execute($update);
                                $update = oci_parse($conn, "select * from school_users where gender = '$firstname' and username = '$user' and s_id = $rcode  ");
                                oci_execute($update);
                                if (oci_fetch_all($update, $a) > 0) {
                                    ?><div style="font-size:13px;
                                                color: green;
                                                position: relative;
                                                display:flex;
                                                margin-left:10px;
                                                text-align: center;
                                                justify-content:center;
                                                animation:button .3s linear;text-align: center;">
                                <?php
                                    echo "GENDER UPDATE SUCCESSFUL FOR $user";
                                    header("refresh:3;");
                                ?>
                            </div> <?php
                                } else {
                                    ?><div style="font-size:13px;
                                                                    color: red;
                                                                    position: relative;
                                                                    display:flex;
                                                                    margin-left:10px;
                                                                    text-align: center;
                                                                    justify-content:center;
                                                                    animation:button .3s linear;text-align: center;">
                                <?php
                                    echo "ERROR UPDATING GENDER FOR $user";
                                    header("refresh:3;");
                                ?>
                            </div> <?php
                                }
                            } else 
                                                    if ($act == 'ADDRESS') {
                                $firstname = strtoupper($_POST['address']);
                                $update = oci_parse($conn, "update school_users set address = '$firstname'  where username = '$user' and s_id = $rcode ");
                                oci_execute($update);
                                $update = oci_parse($conn, "select * from school_users where address = '$firstname' and username = '$user' and s_id = $rcode  ");
                                oci_execute($update);
                                if (oci_fetch_all($update, $a) > 0) {
                                    ?><div style="font-size:13px;
                                                        color: green;
                                                        position: relative;
                                                        display:flex;
                                                        margin-left:10px;
                                                        text-align: center;
                                                        justify-content:center;
                                                        animation:button .3s linear;text-align: center;">
                                <?php
                                    echo "ADDRESS UPDATE SUCCESSFUL FOR $user";
                                    header("refresh:3;");
                                ?>
                            </div> <?php
                                } else {
                                    ?><div style="font-size:13px;
                                                                            color: red;
                                                                            position: relative;
                                                                            display:flex;
                                                                            margin-left:10px;
                                                                            text-align: center;
                                                                            justify-content:center;
                                                                            animation:button .3s linear;text-align: center;">
                                <?php
                                    echo "ERROR UPDATING ADDRESS FOR $user";
                                    header("refresh:3;");
                                ?>
                            </div> <?php
                                }
                            } else 
                                                            if ($act == 'MOBILE') {
                                $firstname = $_POST['mobile'];
                                $update = oci_parse($conn, "update school_users set mobile = $firstname  where username = '$user' and s_id = $rcode  ");
                                oci_execute($update);
                                $update = oci_parse($conn, "select * from school_users where mobile = $firstname and username = '$user' and s_id = $rcode  ");
                                oci_execute($update);
                                if (oci_fetch_all($update, $a) > 0) {
                                    ?><div style="font-size:13px;
                                                                color: green;
                                                                position: relative;
                                                                display:flex;
                                                                margin-left:10px;
                                                                text-align: center;
                                                                justify-content:center;
                                                                animation:button .3s linear;text-align: center;">
                                <?php
                                    echo "MOBILE UPDATE SUCCESSFUL FOR $user";
                                    header("refresh:3;");
                                ?>
                            </div> <?php
                                } else {
                                    ?><div style="font-size:13px;
                                                                                    color: red;
                                                                                    position: relative;
                                                                                    display:flex;
                                                                                    margin-left:10px;
                                                                                    text-align: center;
                                                                                    justify-content:center;
                                                                                    animation:button .3s linear;text-align: center;">
                                <?php
                                    echo "ERROR UPDATING MOBILE FOR $user";
                                    header("refresh:3;");
                                ?>
                            </div> <?php
                                }
                            } else 
                                                                    if ($act == 'WORK') {
                                $firstname = $_POST['work'];
                                $update = oci_parse($conn, "update school_users set WORK = $firstname  where username = '$user' and s_id = $rcode  ");
                                oci_execute($update);
                                $update = oci_parse($conn, "select * from school_users where WORK = $firstname and username = '$user' and s_id = $rcode  ");
                                oci_execute($update);
                                if (oci_fetch_all($update, $a) > 0) {
                                    ?><div style="font-size:13px;
                                                                        color: green;
                                                                        position: relative;
                                                                        display:flex;
                                                                        margin-left:10px;
                                                                        text-align: center;
                                                                        justify-content:center;
                                                                        animation:button .3s linear;text-align: center;">
                                <?php
                                    echo "WORK TELEPHONE UPDATE SUCCESSFUL FOR $user";
                                    header("refresh:3;");
                                ?>
                            </div> <?php
                                } else {
                                    ?><div style="font-size:13px;
                                                                                            color: red;
                                                                                            position: relative;
                                                                                            display:flex;
                                                                                            margin-left:10px;
                                                                                            text-align: center;
                                                                                            justify-content:center;
                                                                                            animation:button .3s linear;text-align: center;">
                                <?php
                                    echo "ERROR UPDATING WORK TELEPHONE FOR $user";
                                    header("refresh:3;");
                                ?>
                            </div> <?php
                                }
                            } else 
                                                                            if ($act == 'EMAIL') {
                                $firstname = $_POST['email'];
                                $update = oci_parse($conn, "update school_users set email = '$firstname'  where username = '$user' and s_id = $rcode  ");
                                oci_execute($update);
                                $update = oci_parse($conn, "select * from school_users where email = '$firstname' and username = '$user' and s_id = $rcode  ");
                                oci_execute($update);
                                if (oci_fetch_all($update, $a) > 0) {
                                    ?><div style="font-size:13px;
                                                                                color: green;
                                                                                position: relative;
                                                                                display:flex;
                                                                                margin-left:10px;
                                                                                text-align: center;
                                                                                justify-content:center;
                                                                                animation:button .3s linear;text-align: center;">
                                <?php
                                    echo "EMAIL UPDATE SUCCESSFUL FOR $user";
                                    header("refresh:3;");
                                ?>
                            </div> <?php
                                } else {
                                    ?><div style="font-size:13px;
                                                                                                    color: red;
                                                                                                    position: relative;
                                                                                                    display:flex;
                                                                                                    margin-left:10px;
                                                                                                    text-align: center;
                                                                                                    justify-content:center;
                                                                                                    animation:button .3s linear;text-align: center;">
                                <?php
                                    echo "ERROR UPDATING EMAIL FOR $user";
                                    header("refresh:3;");
                                ?>
                            </div> <?php
                                }
                            } else 
                                                                                    if ($act == 'USER RIGHTS') {
                                if (isset($_POST['rights'])) {
                                    $firstname = $_POST['rights'];
                                    $update = oci_parse($conn, "update school_users set rights = '$firstname'  where username = '$user' and s_id = $rcode  ");
                                    oci_execute($update);
                                    $update = oci_parse($conn, "select * from school_users where rights = '$firstname' and username = '$user' and s_id = $rcode  ");
                                    oci_execute($update);
                                    if (oci_fetch_all($update, $a) > 0) {
                                    ?><div style="font-size:13px;
                                                                                            color: green;
                                                                                            position: relative;
                                                                                            display:flex;
                                                                                            margin-left:10px;
                                                                                            text-align: center;
                                                                                            justify-content:center;
                                                                                            animation:button .3s linear;text-align: center;">
                                    <?php
                                        echo "USER RIGHTS UPDATE SUCCESSFUL FOR $user";
                                        header("refresh:3;");
                                    ?>
                                </div> <?php
                                    } else {
                                        ?><div style="font-size:13px;
                                                                                                                color: red;
                                                                                                                position: relative;
                                                                                                                display:flex;
                                                                                                                margin-left:10px;
                                                                                                                text-align: center;
                                                                                                                justify-content:center;
                                                                                                                animation:button .3s linear;text-align: center;">
                                    <?php
                                        echo "ERROR UPDATING USER RIGHTS FOR $user";
                                        header("refresh:3;");
                                    ?>
                                </div> <?php
                                    }
                                } else {
                                        ?><div style="font-size:13px;
                                                                                            color: red;
                                                                                            position: relative;
                                                                                            display:flex;
                                                                                            margin-left:10px;
                                                                                            text-align: center;
                                                                                            justify-content:center;
                                                                                            animation:button .3s linear;text-align: center;">
                                <?php
                                    echo "ERROR UPDATING USER RIGHTS FOR $user";
                                    header("refresh:3;");
                                ?>
                            </div> <?php
                                }
                            } else 
                                                                                            if ($act == 'USER STATUS') {
                                if (isset($_POST['status'])) {
                                    $firstname = $_POST['status'];
                                    $update = oci_parse($conn, "update school_users set status = '$firstname'  where username = '$user' and s_id = $rcode  ");
                                    oci_execute($update);
                                    $update = oci_parse($conn, "select * from school_users where status = '$firstname' and username = '$user' and s_id = $rcode  ");
                                    oci_execute($update);
                                    if (oci_fetch_all($update, $a) > 0) {
                                    ?><div style="font-size:13px;
                                                                                                    color: green;
                                                                                                    position: relative;
                                                                                                    display:flex;
                                                                                                    margin-left:10px;
                                                                                                    text-align: center;
                                                                                                    justify-content:center;
                                                                                                    animation:button .3s linear;text-align: center;">
                                    <?php
                                        echo "USER STATUS UPDATE SUCCESSFUL FOR $user";
                                        header("refresh:3;");
                                    ?>
                                </div> <?php
                                    } else {
                                        ?><div style="font-size:13px;
                                                                                                                        color: red;
                                                                                                                        position: relative;
                                                                                                                        display:flex;
                                                                                                                        margin-left:10px;
                                                                                                                        text-align: center;
                                                                                                                        justify-content:center;
                                                                                                                        animation:button .3s linear;text-align: center;">
                                    <?php
                                        echo "ERROR UPDATING USER STATUS FOR $user";
                                        header("refresh:3;");
                                    ?>
                                </div> <?php
                                    }
                                } else {
                                        ?><div style="font-size:13px;
                                                                                                    color: red;
                                                                                                    position: relative;
                                                                                                    display:flex;
                                                                                                    margin-left:10px;
                                                                                                    text-align: center;
                                                                                                    justify-content:center;
                                                                                                    animation:button .3s linear;text-align: center;">
                                <?php
                                    echo "ERROR UPDATING USER STATUS FOR $user";
                                    header("refresh:3;");
                                ?>
                            </div> <?php
                                }
                            }
                        } else {
                                    ?><div style="font-size:13px;
                color: red;
                position: relative;
                display:flex;
                margin-left:10px;
                text-align: center;
                justify-content:center;
                animation:button .3s linear;text-align: center;">
                        <?php
                            echo "SELECT USER";
                            header("refresh:3;");
                        ?>
                    </div> <?php
                        }
                    }
                    if (isset($_POST['Reset'])) {
                        if (isset($_POST['user'])) {
                            $user = $_POST['user'];
                            $act = $_POST['act'];
                            if ($act == 'PASSWORD') {
                                $update = oci_parse($conn, "update school_users set password = 'ChangePassword' where username = '$user' and s_id= $rcode ");
                                oci_execute($update);
                                $update = oci_parse($conn, "select * from school_users where password = 'ChangePassword' and username = '$user' and s_id= $rcode ");
                                oci_execute($update);
                                if (oci_fetch_all($update, $a) > 0) {
                            ?><div style="font-size:13px;
                        color: green;
                        position: relative;
                        display:flex;
                        margin-left:10px;
                        text-align: center;
                        justify-content:center;
                        animation:button .3s linear;text-align: center;">
                                <?php
                                    echo "PASSWORD RESET SUCCESSFUL FOR $user";
                                    header("refresh:3;");
                                ?>
                            </div> <?php
                                } else {
                                    ?><div style="font-size:13px;
                                            color: red;
                                            position: relative;
                                            display:flex;
                                            margin-left:10px;
                                            text-align: center;
                                            justify-content:center;
                                            animation:button .3s linear;text-align: center;">
                                <?php
                                    echo "ERROR RESETING PASSWORD FOR $user";
                                    header("refresh:3;");
                                ?>
                            </div> <?php
                                }
                            } else {
                                    ?><div style="font-size:13px;
                            color: red;
                            position: relative;
                            display:flex;
                            margin-left:10px;
                            text-align: center;
                            justify-content:center;
                            animation:button .3s linear;text-align: center;">
                            <?php
                                echo "SELECT PASSWORD TO PERFORM RESET";
                                header("refresh:3;");
                            ?>
                        </div> <?php
                            }
                        } else {
                                ?><div style="font-size:13px;
                color: red;
                position: relative;
                display:flex;
                margin-left:10px;
                text-align: center;
                justify-content:center;
                animation:button .3s linear;text-align: center;">
                        <?php
                            echo "SELECT USER";
                            header("refresh:3;");
                        ?>
                    </div> <?php
                        }
                    }
                            ?>
        </div>
        <div class="input-container" style="display: flex;">
            <div class="input-field" style="margin-right: 10px;">
                <label>Firstname</label>
                <input type="text" placeholder="Enter Firstname" title="Only Numbers" name="first">
            </div>

            <div class="input-field" style="margin-right: 10px;">
                <label>Middlename</label>
                <input type="text" placeholder="Enter Middlename" title="Only Numbers" name="middle">
            </div>
            <div class="input-field" style="margin-right: 10px;">
                <label>Lastname</label>
                <input type="text" placeholder="Enter Lastname" title="Only Numbers" name="last">
            </div>
            <div class="input-field" style="margin-right: 10px;">
                <label>DOB</label>
                <input type="date" placeholder="Enter Date Of Birth" title="Only Numbers" name="dob">
            </div>
        </div>

        <div class="input-container" style="display: flex;">
            <div class="input-field" style="margin-right: 10px;">
                <label>Gender</label>
                <select name="gender">
                    <option value="" disabled selected>Select Gender</option>
                    <option>MALE</option>
                    <option>FEMALE</option>
                    <option>OTHER</option>
                </select>
            </div>
            <div class="input-field" style="margin-right: 10px;">
                <label>Address</label>
                <input type="text" placeholder="Enter Address" title="Only Numbers And Letters" name="address">
            </div>
            <div class="input-field" style="margin-right: 10px;">
                <label>Mobile</label>
                <input type="number" placeholder="Enter Mobile" title="Only Numbers" name="mobile">
            </div>
            <div class="input-field" style="margin-right: 10px;">
                <label>Work</label>
                <input type="number" placeholder="Enter Work Line" title="Only Numbers" name="work">
            </div>
        </div>


        <div class="input-container" style="display: flex; margin-top:10px">
            <div class="input-field" style="margin-right: 10px;">
                <label>Email</label>
                <input type="email" placeholder="Enter Email" title="Only Numbers And Letters" name="email">
            </div>
            <div class="input-field" style="margin-right: 10px;">
                <label>User Rights</label>
                <select name="rights">
                    <option value="" disabled selected>Select Right</option>
                    <option>REGISTRA</option>
                    <option>FINANCE</option>
                    <option>HR</option>
                    <option>PRINCIPAL</option>
                </select>
            </div>
            <div class="input-field" style="margin-right: 10px;">
                <label>User Status</label>
                <select name="status">
                    <option value="" disabled selected>Select Status</option>
                    <option>ACTIVE</option>
                    <option>INACTIVE</option>
                </select>
            </div>
        </div>

        <div style="display: flex;">
            <button style=" display: inline-block;
  padding: 6px 12px;
  background-color: #1D5B79;
  color: white;
  border: none;
  border-radius: 4px;
  margin-top:10px;
  text-decoration: none;" name="update" type="submit">
                UPDATE

                <i class="uil uil-sync"></i>
            </button>

            <button style=" display: inline-block;
  padding: 6px 12px;
  background-color: #1D5B79;
  color: white;
  border: none;
  border-radius: 4px;
  margin-left: 10px;
  margin-top:10px;
  text-decoration: none;" name="Reset" type="submit">
                RESET PASSWORD
                <i class="uil uil-key-skeleton"></i>
            </button>

        </div>


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