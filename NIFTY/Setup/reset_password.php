<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
</head>

<body>
    <div class="wrapper">
        <div class="com">
            <h3>
                Academix: School Management System
            </h3>
            <img src="img/logo.png">
        </div>
        <h2>Reset Password</h2>
        <form action="reset_password.php" id="form" method="post">
            <div class="input-box username">
                <select name="school">
                    <option disabled selected>Select School</option>
                    <?php
                    include 'connect.php';
                    $check = oci_parse($conn, "select * from school where status = 'ACTIVE' ");
                    oci_execute($check);
                    while ($row = oci_fetch_array($check)) {
                    ?><option><?php echo $row["SCHOOL"] ?></option><?php
                                                                }
                                                                    ?>
                </select>
            </div>
        
            <button class="input-box button">
                <input type="Submit" value="Reset Password" title="login successfully" id="redirect" href="login.html" name="Save">
                </a>
            </button>

            <div class="text">
                <h3><a href="setup_menu.php" style="text-decoration: none; font-size:15px; font-weight: 500px;">Return</a></h3>
            </div>

            <div class="message">
                <?php
                if (isset($_POST['Save'])) {
                    include 'connect.php';
                    if ($conn) { 
                        $school = $_POST['school'];
                        $password='ChangePassword';
                        $sql = oci_parse($conn, "update school set password = '$password' where school = '$school' ");
                        oci_execute($sql);
                        $sql = oci_parse($conn, "select * from school where password  = '$password' and school = '$school' ");
                        oci_execute($sql);
                        if(oci_fetch_all($sql,$a)>0){
                            ?><div style="font-size:13px;
                            color: green;
                            position: relative;
                             display:flex;
                            animation:button .3s linear;text-align: center;">
                                            <?php echo "PASSWORD RESET";
                                                header("refresh:3;"); ?>
                                        </div> <?php
                        }else {
                            ?><div style="font-size:13px;
                            color: red;
                            position: relative;
                             display:flex;
                            animation:button .3s linear;text-align: center;">
                                            <?php echo "ERROR RESETING PASSWORD";
                                                header("refresh:3;"); ?>
                                        </div> <?php
                        }
                            } else {
                                        ?><div style="font-size:13px;
            color: red;
            position: relative;
             display:flex;
            animation:button .3s linear;text-align: center;">
                            <?php echo "ERROR CONNECTING TO DATABASE";
                                header("refresh:3;"); ?>
                        </div> <?php
                            }
                        }
                                ?>
            </div>
        </form>
    </div>
</body>
</html>