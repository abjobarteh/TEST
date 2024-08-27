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
    <h2>Edit School</h2>
    <form action="select_school.php" id="form" method="post">
      <div class="input-box username">
         <select required name="school">
         <option disabled selected>Select School</option>
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
      </div>
      <button class="input-box button">
        <input type="Submit" value="Continue" title="login successfully" id="redirect" href="login.html" name="Continue">
        </a>
      </button>
      
      <div class="text">
        <h3><a href="setup_menu.php" style="text-decoration: none; font-size:15px; font-weight: 500px;">Return</a></h3>
      </div>
    <?php 
    if(isset($_POST['Continue'])){
      session_start();
       $school = $_POST['school'];
       $get_hos = "select * from school where school = '$school' order by school";
       $get = oci_parse($conn, $get_hos);
       oci_execute($get);
       while($r=oci_fetch_array($get)){
            $_SESSION['sid']=$r['S_ID'];
       }
      $_SESSION['school']=$school;
      ?><div style="font-size:13px;
      color: green;
      position: relative;
      display:flex;
      margin-left:10px;
      text-align: center;
      justify-content:center;
      animation:button .3s linear;text-align: center;">
                <?php echo "USERS UNDER $school CAN BE EDITED";
                    header("refresh:3;url=edit_user.php"); ?>
            </div> <?php
    }
    ?>
    </form>
  </div>
</body>

</html>