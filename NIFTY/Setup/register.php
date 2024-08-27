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

<body>
  <div class="wrapper">
    <header>
      <img src="img/logo.png" alt="Academix Logo">
      <h2>Academix: School Management System</h2>
    </header>
    <h2 style="margin:20px;">Register School</h2>
    <form action="register.php" method="post" id="form" enctype="multipart/form-data">
      <div class="dbl-field">
        <div class="field">
          <select name="district" required>
            <option value="" disabled selected>Select District</option>
            <?php
            include 'connect.php';
            $check = oci_parse($conn, "select * from district ORDER BY DIS_CODE");
            oci_execute($check);
            while ($row = oci_fetch_array($check)) {
            ?><option><?php echo $row["DISTRICT"] ?></option><?php
                                                                    }
                                                                      ?>
            <!-- Add more options as needed -->
          </select>
          <i class="fa fa-compass" aria-hidden="true"></i>
          <style>
          </style>
        </div>
        <div class="field">
          <input type="text" name="school" placeholder="Enter School" required>
          <i class="fa fa-university" aria-hidden="true"></i>
        </div>
      </div>
      <div class="dbl-field">
        <div class= "field">
          <select name="type" required>
          <option value="" disabled selected>Select School Type</option>
            <option>
                DAYCARE
            </option>
            <option>
                PRIMARY
            </option>
            <option>
                JUNIOR
            </option>
            <option>
                SECONDARY
            </option>
          </select>
          <i class="fa fa-cogs" aria-hidden="true"></i>
        </div>
        <div class="field">
          <input type="" name="address" placeholder="Enter Address" required>
          <i class="fa fa-address-book" aria-hidden="true"></i>
        </div>
       
      </div>
      <div class="dbl-field">
      <div class="field">
          <input type="text" name="email" placeholder="Enter your email" required>
          <i class='fas fa-envelope'></i>
        </div>
        <div class="field">
          <input type="number" name="p1" placeholder="Enter Telephone" required >
          <i class='fas fa-phone-alt'></i>
        </div>
        
       
      </div>

      <div class="dbl-field">
      <div class="field">
          <input type="number" name="p2" placeholder="Enter Mobile"  required >
          <i class='fas fa-phone-alt'></i>
        </div>
        <div class="field">
          <input type="file" name="file" required >
          <i class="fa fa-file" aria-hidden="true"></i>
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
  transition: background 0.3s ease;" value="Register" name="save" type="submit">
        </div>

        <?php if (isset($_POST['back'])) {
          header('refresh:2;url=setup_menu.php');
      } 
      if(isset($_POST['save'])){
      
        if(isset($_POST['district'])){
        
           include 'connect.php';
           $district=$_POST['district'];

           $school =strtoupper($_POST['school']);
           $address =strtoupper($_POST['address']);
           $email=$_POST['email'];
           $p1=$_POST['p1'];
           $p2=$_POST['p2'];
           $type=$_POST['type'];
           $getregcode = oci_parse($conn, "select * from district where district ='$district'");
           oci_execute($getregcode);

           while ($row = oci_fetch_array($getregcode)) {
               $reg_code = $row['REG_CODE'];
               $dis_code=$row['DIS_CODE'];
           }
           $check=oci_parse($conn,"select * from school where school = '$school'");
           oci_execute($check);
           if(oci_fetch_all($check,$a)>0){
            ?><div style="font-size:13px;
                color: red;
                position: relative;
                margin-left:10px;
                 display:flex;
                animation:button .3s linear;text-align: center;">
                                <?php echo "SCHOOL ALREADY EXIST";
                                  header("refresh:3;"); ?>
                            </div> <?php
           }
           else {
           
            if(isset($_FILES['file'])){
              
              $file = $_FILES['file']['tmp_name'];
              function isjpeg_png($file)
                {
                  $type = [IMAGETYPE_JPEG, IMAGETYPE_PNG];
                  $detect = exif_imagetype($file);
                  if (in_array($detect, $type)) {
                    return true;
                  } else {
                    return false;
                  }
                }
                if(isjpeg_png($file)==true){
                  $content = file_get_contents($file);
                  $status="ACTIVE";
                  $password="ChangePassword";
                  $rights = "SYSADMIN";
                
                  $query = "INSERT INTO school (school,address,reg_code,dis_code,phone_one,phone_two,email,logo,status,rights,type) values (:school,:address,:reg,:dis,:p1,:p2,:email,:logo,:status,:rights,:type)";
                  $statement = oci_parse($conn, $query);
                  oci_bind_by_name($statement, ':school', $school);
                  oci_bind_by_name($statement, ':address', $address);
                  oci_bind_by_name($statement, ':email', $email);
                  oci_bind_by_name($statement, ':reg', $reg_code);
                  oci_bind_by_name($statement, ':dis', $dis_code);
                  oci_bind_by_name($statement, ':p1', $p1);
                  oci_bind_by_name($statement, ':p2', $p2);
                  oci_bind_by_name($statement, ':status', $status);
                  oci_bind_by_name($statement, ':rights', $rights);
                  oci_bind_by_name($statement, ':type', $type);
                  $content = file_get_contents($file);

                  $lob = oci_new_descriptor($conn, OCI_D_LOB);
                  oci_bind_by_name($statement, ':logo', $lob, -1, OCI_B_BLOB);
                  $lob->writeTemporary($content, OCI_TEMP_BLOB);
                  oci_execute($statement, OCI_DEFAULT);
                  
                  $check=(oci_parse($conn,"select * from school where school='$school'"));
                  oci_execute($check);
                  if(oci_fetch_all($check,$a)>0){
                    ?><div style="font-size:15px;
                    color: green;
                    position: relative;
                     display:flex;
                     margin-left:10px;
                    animation:button .3s linear;text-align: center;">
                      <?php echo "SCHOOL REGISTERED";
                             header("refresh:2;");
                      ?></div><?php
                  }else {
                    ?><div style="font-size:15px;
                    color: red;
                    position: relative;
                     display:flex;
                     margin-left:10px;
                    animation:button .3s linear;text-align: center;">
                      <?php echo "ERROR REGISTERING SCHOOL";
                              header("refresh:2;");
                      ?></div><?php
                  }
                }else{
                  ?><div style="font-size:15px;
                  color: red;
                  position: relative;
                   display:flex;
                   margin-left:10px;
                  animation:button .3s linear;text-align: center;">
                    <?php echo "ALLOWED FILE TYPES ARE JPEG AND PNG";
                          header("refresh:2;");
                    ?></div><?php
                }
            }
           }
        }
      }else {
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