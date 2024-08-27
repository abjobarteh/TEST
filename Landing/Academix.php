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
    <h2>Designated School Login</h2>
    <form action="Academix.php" id="form" method="post">
      <div class="input-box username">
         <select required name="school">
         <option disabled selected>Select Designated School</option>
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
                <?php echo "WELCOME $school";
                    header("refresh:3;url=login.php"); ?>
            </div> <?php
    }
    ?>
    </form>
  </div>
</body>

</html>