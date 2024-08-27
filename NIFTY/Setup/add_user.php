<!DOCTYPE html>
<!-- Coding By CodingNepal - youtube.com/codingnepal -->
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="stylesheet" href="css/school.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
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
</head>
<?php
ob_start();
include 'connect.php'; ?>
<body>
    <div class="wrapper">
        <header>
            <h3 style="color:#1D5B79;">Academix: School Management System</h3>
            <img src="img/logo.png" style="height:100px;">
        </header>
        <h2 style="margin:20px;">Create School System Administrator</h2>
        <form action="add_user.php" method="post" id="form" enctype="multipart/form-data">
            <div class="dbl-field">

                <div class="field">
                    <select name="school" required>
                        <option value="" disabled selected>Select School</option>
                        <?php
                        include 'connect.php';
                        $get_hos = "select * from school order by school";
                        $get = oci_parse($conn, $get_hos);
                        oci_execute($get);
                        while ($row = oci_fetch_array($get)) {
                        ?><option>
                                <?php echo $row["SCHOOL"]; ?>
                            </option> <?php
                                    }
                                        ?>
                    </select>
                    <i class="fa fa-university" aria-hidden="true"></i>
                </div>
            </div>
            <div class="dbl-field">
                <div class="field">
                    <input type="text" name="firstname" placeholder="Enter Firstname" required>
                    <i class="fa fa-user" aria-hidden="true"></i>
                </div>
                <div class="field" style="margin-left:10px;">
                    <input type="text" name="middlename" placeholder="Enter Middlename">
                    <i class="fa fa-user" aria-hidden="true"></i>
                </div>
                <div class="field" style="margin-left:10px;">
                    <input type="text" name="lastname" placeholder="Enter Lastname" required>
                    <i class="fa fa-user" aria-hidden="true"></i>
                </div>
            </div>
            <div class="dbl-field">
                <div class="field">
                    <input type="date" name="dob" placeholder="Enter Date Of Birth" required>
                    <i class="fa fa-calendar" aria-hidden="true"></i>
                </div>
                <div class="field">
                    <select name="gender" required>
                        <option value="" disabled selected>Select Gender</option>
                        <option>MALE</option>
                        <option>FEMALE</option>
                        <option>OTHER</option>
                    </select>
                    <i class="fa fa-transgender" aria-hidden="true"></i>
                </div>
            </div>
            <div class="dbl-field">
                <div class="field">
                    <input type="text" name="address" placeholder="Enter Address" required>
                    <i class="fa fa-location-arrow" aria-hidden="true"></i>
                </div>
                <div class="field">
                    <input type="number" name="mobile" placeholder="Enter Mobile" required>
                    <i class='fas fa-phone-alt'></i>
                </div>
            </div>
            <div class="dbl-field">

                <div class="field">
                    <input type="number" name="work" placeholder="Enter Work Telephone" required>
                    <i class='fas fa-phone-alt'></i>
                </div>
                <div class="field">
                    <input type="email" name="email" placeholder="Enter Email" required>
                    <i class="fa fa-envelope" aria-hidden="true"></i>
                </div>
            </div>
            <div class="dbl-field">
                <div class="field">
                    <input type="text" name="username" placeholder="Enter Username" required>
                    <i class="fa fa-user" aria-hidden="true"></i>
                </div>
                <div class="field">
                    <select name="rights" required>
                        <option value="" disabled selected>Select Right</option>
                        <option>REGISTRA</option>
                        <option>FINANCE</option>
                        <option>HR</option>
                        <option>PRINCIPAL</option>
                        <option>SYSADMIN</option>
                    </select>
                    <i class="fa fa-cogs" aria-hidden="true"></i>
                </div>
            </div>
            <div class="button-area">
                <div>
                    <h3><a href="setup_menu.php" style="text-decoration: none; font-size:15px; font-weight: 500px; color:#1D5B79;">Return</a></h3>
                </div>
                <div type="submit">
                    <input style="color: #fff;
  border: none;
  outline: none;
  font-size: 18px;
  margin-left:10px;
  text-align:center;
  width: 130px;
  cursor: pointer;
  border-radius: 5px;
  padding: 10px 5px;
  background: #1D5B79;
  transition: background 0.3s ease;" value="Add" name="save" type="submit">
                </div>

                <?php if (isset($_POST['back'])) {
                    header('refresh:2;url=setup_menu.php');
                }
                if (isset($_POST['save'])) {
                    $school = $_POST['school'];
                    $get_hos = "select * from school where school = '$school' order by school";
                    $get = oci_parse($conn, $get_hos);
                    oci_execute($get);
                    while ($r = oci_fetch_array($get)) {
                        $sid = $r['S_ID'];
                    }
                    $first = strtoupper($_POST['firstname']);
                    $middle = strtoupper($_POST['middlename']);
                    $last = strtoupper($_POST['lastname']);
                    $dob = $_POST['dob'];
                    $gender = $_POST['gender'];
                    $address = strtoupper($_POST['address']);
                    $mobile = $_POST['mobile'];
                    $telephone = $_POST['work'];
                    $email = $_POST['email'];
                    $user = $_POST['username'];
                    $pass = 'ChangePassword';
                    $rights = $_POST['rights'];
                    $status = 'ACTIVE';
                  
                    $check = oci_parse($conn, "select * from school where status = 'ACTIVE' and s_id=$sid ");
                    oci_execute($check);
                    if (oci_fetch_all($check, $a) > 0) {
                        $check = oci_parse($conn, "select * from school_users where username='$user' and s_id=$sid ");
                        oci_execute($check);
                        if (oci_fetch_all($check, $a) > 0) {
                ?><div style="font-size:15px;
                            color: red;
                            position: relative;
                             display:flex;
                             margin-left:10px;
                            animation:button .3s linear;text-align: center;">
                                <?php echo "USERNAME EXISTS ";
                             header("refresh:3;");
                                ?></div><?php
                                    } else {
                                        $insert = oci_parse($conn, "insert into school_users (S_ID,firstname,middlename,lastname,dob,gender,address,mobile,work,email,username,password,rights,status,create_dt)  values
                             ($sid,'$first','$middle','$last','$dob','$gender','$address',$mobile,$telephone,'$email','$user','$pass','$rights','$status',sysdate)");
                                        oci_execute($insert);
                                        $check = oci_parse($conn, "select * from school_users where username='$user' and s_id='$sid' ");
                                        oci_execute($check);
                                        if (oci_fetch_all($check, $a) > 0) {
                                        ?><div style="font-size:15px;
                                color: green;
                                position: relative;
                                 display:flex;
                                 margin-left:10px;
                                animation:button .3s linear;text-align: center;">
                                    <?php echo "USER: $user created successfully ";
                                           header("refresh:3;");
                                    ?></div><?php
                                        } else {
                                            ?><div style="font-size:15px;
                                color: red;
                                position: relative;
                                 display:flex;
                                 margin-left:10px;
                                animation:button .3s linear;text-align: center;">
                                    <?php echo "ERROR CREATING USER ";
                                    ?></div><?php
                                        }
                                    }
                                } else {
                                            ?><div style="font-size:15px;
                        color: red;
                        position: relative;
                         display:flex;
                         margin-left:10px;
                        animation:button .3s linear;text-align: center;">
                            <?php echo "STATUS INACTIVE";
                                  header("refresh:3;");
                            ?></div><?php
                                }
                            } else {
                                    ?><div style="font-size:15px;
        color: red;
        position: relative;
         display:flex;
         margin-left:10px;
        animation:button .3s linear;text-align: center;">
                        <?php
                        ?></div><?php
                            }

                                ?>
                <span></span>
            </div>


        </form>
    </div>
</body>

</html>