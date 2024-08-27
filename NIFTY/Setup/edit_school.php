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
    <h2 style="margin:20px;">Edit School</h2>
    <form action="edit_school.php" method="post" id="form" enctype="multipart/form-data">
    <div class="dbl-field">
    <div class="field">
          <select required name="type">
            <option value="" disabled selected>Select Data Type</option>
            <option >School Name</option>
            <option >School Address</option>
            <option >School Email</option>
            <option >School Phone One</option>
            <option>School Phone Two</option>
            <option >School Logo</option>
            <option >School Status</option>
            <?php
            include 'connect.php';?>
          </select>
         
        </div>
   
      </div>
      <div class="dbl-field">
      <div class="field">
          <select name="sch" required>
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
            <!-- Add more options as needed -->
          </select>
          <i class="fa fa-university" aria-hidden="true"></i>
        </div>
        <div class="field">
          <input type="text" name="school" placeholder="Enter School" >
          <i class="fa fa-university" aria-hidden="true"></i>
        </div>
      </div>
      <div class="dbl-field">
        <div class="field">
          <input type="" name="address" placeholder="Enter Address" >
          <i class="fa fa-address-book" aria-hidden="true"></i>
        </div>
        <div class="field">
          <input type="text" name="email" placeholder="Enter your email" >
          <i class='fas fa-envelope'></i>
        </div>
      </div>
      <div class="dbl-field">
        <div class="field">
          <input type="number" name="p1" placeholder="Enter Telephone" >
          <i class='fas fa-phone-alt'></i>
        </div>
        <div class="field">
          <input type="number" name="p2" placeholder="Enter Mobile"  >
          <i class='fas fa-phone-alt'></i>
        </div>
      </div>

      <div class="dbl-field">

        <div class="field">
          <input type="file" name="file" >
          <i class="fa fa-file" aria-hidden="true"></i>
        </div>
        <div class="field">
          <select  name="sta">
            <option value="" disabled selected>Select Status</option>
            <option >ACTIVE</option>
            <option >INACTIVE</option>
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
  transition: background 0.3s ease;" value="Update" name="save" type="submit">
        </div>

        <?php if (isset($_POST['back'])) {
          header('refresh:2;url=setup_menu.php');
      } 
      if(isset($_POST['save'])){

           include 'connect.php';
         $type=$_POST['type'];
         $name=$_POST['sch'];
     
     /*    if($type === 'School Address'){
          $school = $_POST['address'];
          if($school===''){
            ?><div style="font-size:13px;
            color: red;
            position: relative;
            display:flex;
            margin-left:10px;
            animation:button .3s linear;text-align: center;">
                      <?php echo "ENTER SCHOOL ADDRESS";
                          header("refresh:3;"); ?>
                  </div> <?php
          }else {
            $check = oci_parse($conn, "select * from school where school = '$school' and school = '$name' ");
            oci_execute($check);
          
              $check = oci_parse($conn, "update school set ADDRESS = '$school' where school = '$name' ");
              oci_execute($check);
              $check = oci_parse($conn, "select * from school where school = '$school'");
              oci_execute($check);
              if(oci_fetch_all($check,$a)>0){
                ?><div style="font-size:13px;
                color: green;
                position: relative;
                display:flex;
                margin-left:10px;
                animation:button .3s linear;text-align: center;">
                          <?php echo "SCHOOL ADDRESS UPDATED";
                              header("refresh:3;"); ?>
                      </div> <?php
              }

          }
         }else */ if($type === 'School Name'){
          $school = strtoupper($_POST['school']);
          if($school===''){
            ?><div style="font-size:13px;
            color: red;
            position: relative;
            display:flex;
            margin-left:10px;
            animation:button .3s linear;text-align: center;">
                      <?php echo "ENTER SCHOOL NAME";
                          header("refresh:3;"); ?>
                  </div> <?php
          }else {
            $check = oci_parse($conn, "select * from school where school = '$school' and school = '$name' ");
            oci_execute($check);
            if (oci_fetch_all($check, $a) > 0) {
            ?><div style="font-size:13px;
  color: red;
  position: relative;
  display:flex;
  margin-left:10px;
  animation:button .3s linear;text-align: center;">
            <?php echo "SCHOOL ALREADY EXIST";
                header("refresh:3;"); ?>
        </div> <?php
            }else {
              $check = oci_parse($conn, "update school set school = '$school' where school = '$name' ");
              oci_execute($check);
              $check = oci_parse($conn, "select * from school where school = '$school'");
              oci_execute($check);
              if(oci_fetch_all($check,$a)>0){
                ?><div style="font-size:13px;
                color: green;
                position: relative;
                display:flex;
                margin-left:10px;
                animation:button .3s linear;text-align: center;">
                          <?php echo "SCHOOL NAME UPDATED";
                              header("refresh:3;"); ?>
                      </div> <?php
              }
            }
          }
         } else if($type === 'School Address'){
          $school = $_POST['address'];
          if($school===''){
            ?><div style="font-size:13px;
            color: red;
            position: relative;
            display:flex;
            margin-left:10px;
            animation:button .3s linear;text-align: center;">
                      <?php echo "ENTER SCHOOL ADDRESS";
                          header("refresh:3;"); ?>
                  </div> <?php
          }else {
              $check = oci_parse($conn, "update school set ADDRESS = '$school' where school = '$name' ");
              oci_execute($check);
              $check = oci_parse($conn, "select * from school where address = '$school' and school = '$name'");
              oci_execute($check);
              if(oci_fetch_all($check,$a)>0){
                ?><div style="font-size:13px;
                color: green;
                position: relative;
                display:flex;
                margin-left:10px;
                animation:button .3s linear;text-align: center;">
                          <?php echo "SCHOOL ADDRESS UPDATED";
                              header("refresh:3;"); ?>
                      </div> <?php
              }

          }
         }else if($type === 'School Email'){
          $school = $_POST['email'];
          if($school===''){
            ?><div style="font-size:13px;
            color: red;
            position: relative;
            display:flex;
            margin-left:10px;
            animation:button .3s linear;text-align: center;">
                      <?php echo "ENTER SCHOOL EMAIL";
                          header("refresh:3;"); ?>
                  </div> <?php
          }else {
            $check = oci_parse($conn, "select * from school where email='$school'");
            oci_execute($check);
            if (oci_fetch_all($check, $a) > 0) {
            ?><div style="font-size:13px;
  color: red;
  position: relative;
  display:flex;
  margin-left:10px;
  animation:button .3s linear;text-align: center;">
            <?php echo "EMAIL ALREADY EXIST";
                header("refresh:3;"); ?>
        </div> <?php
            }else {
              $check = oci_parse($conn, "update school set email = '$school' where school = '$name' ");
              oci_execute($check);
              $check = oci_parse($conn, "select * from school where email = '$school' and school = '$name'");
              oci_execute($check);
              if(oci_fetch_all($check,$a)>0){
                ?><div style="font-size:13px;
                color: green;
                position: relative;
                display:flex;
                margin-left:10px;
                animation:button .3s linear;text-align: center;">
                          <?php echo "SCHOOL EMAIL UPDATED";
                              header("refresh:3;"); ?>
                      </div> <?php
              }
              }

          }
         }
         else if($type === 'School Phone One'){
          $school = $_POST['p1'];
          if($school===''){
            ?><div style="font-size:13px;
            color: red;
            position: relative;
            display:flex;
            margin-left:10px;
            animation:button .3s linear;text-align: center;">
                      <?php echo "ENTER SCHOOL PHONE NUMBER ONE";
                          header("refresh:3;"); ?>
                  </div> <?php
          }else {
            $check = oci_parse($conn, "select * from school where phone_one='$school'");
            oci_execute($check);
            if (oci_fetch_all($check, $a) > 0) {
            ?><div style="font-size:13px;
  color: red;
  position: relative;
  display:flex;
  margin-left:10px;
  animation:button .3s linear;text-align: center;">
            <?php echo "PHONE ONE ALREADY EXIST";
                header("refresh:3;"); ?>
        </div> <?php
            }else {
              $check = oci_parse($conn, "update school set phone_one = '$school' where school = '$name' ");
              oci_execute($check);
              $check = oci_parse($conn, "select * from school where phone_one = '$school' and school = '$name'");
              oci_execute($check);
              if(oci_fetch_all($check,$a)>0){
                ?><div style="font-size:13px;
                color: green;
                position: relative;
                display:flex;
                margin-left:10px;
                animation:button .3s linear;text-align: center;">
                          <?php echo "SCHOOL PHONE ONE UPDATED";
                              header("refresh:3;"); ?>
                      </div> <?php
              }
              }
          }
         }
         else if($type === 'School Phone Two'){
          $school = $_POST['p2'];
          if($school===''){
            ?><div style="font-size:13px;
            color: red;
            position: relative;
            display:flex;
            margin-left:10px;
            animation:button .3s linear;text-align: center;">
                      <?php echo "ENTER SCHOOL PHONE NUMBER TWO";
                          header("refresh:3;"); ?>
                  </div> <?php
          }else {
            $check = oci_parse($conn, "select * from school where phone_two='$school'");
            oci_execute($check);
            if (oci_fetch_all($check, $a) > 0) {
            ?><div style="font-size:13px;
  color: red;
  position: relative;
  display:flex;
  margin-left:10px;
  animation:button .3s linear;text-align: center;">
            <?php echo "PHONE TWO ALREADY EXIST";
                header("refresh:3;"); ?>
        </div> <?php
            }else {
              $check = oci_parse($conn, "update school set phone_two = '$school' where school = '$name' ");
              oci_execute($check);
              $check = oci_parse($conn, "select * from school where phone_two = '$school' and school = '$name'");
              oci_execute($check);
              if(oci_fetch_all($check,$a)>0){
                ?><div style="font-size:13px;
                color: green;
                position: relative;
                display:flex;
                margin-left:10px;
                animation:button .3s linear;text-align: center;">
                          <?php echo "SCHOOL PHONE TWO UPDATED";
                              header("refresh:3;"); ?>
                      </div> <?php
              }
              }
          }
         }  
         else if($type === 'School Status'){
          ob_start();
          $school = $_POST['sta'];
          if($school===''){
            ?><div style="font-size:13px;
            color: red;
            position: relative;
            display:flex;
            margin-left:10px;
            animation:button .3s linear;text-align: center;">
                      <?php echo "SELECT SCHOOL STATUS";
                          header("refresh:3;"); ?>
                  </div> <?php
          }else {
            $check = oci_parse($conn, "select * from school where STATUS='$school' AND school = '$name' ");
            oci_execute($check);
            if (oci_fetch_all($check, $a) > 0) {
            ?><div style="font-size:13px;
  color: red;
  position: relative;
  display:flex;
  margin-left:10px;
  animation:button .3s linear;text-align: center;">
            <?php echo "SCHOOL IS ALREADY $school";
                header("refresh:3;"); ?>
        </div> <?php
            }else {
              $check = oci_parse($conn, "update school set status = '$school' where school = '$name' ");
              oci_execute($check);
              $check = oci_parse($conn, "select * from school where status = '$school' and school = '$name'");
              oci_execute($check);
              if(oci_fetch_all($check,$a)>0){
                ?><div style="font-size:13px;
                color: green;
                position: relative;
                display:flex;
                margin-left:10px;
                animation:button .3s linear;text-align: center;">
                          <?php echo "SCHOOL STATUS IS UPDATED";
                              header("refresh:3;"); ?>
                      </div> <?php
              }
              }
          }
         }  else if ($type === 'School Logo'){
          ob_start();
          
          if(!isset($_FILES['file'])){
            ?><div style="font-size:13px;
            color: red;
            position: relative;
            display:flex;
            margin-left:10px;
            animation:button .3s linear;text-align: center;">
                      <?php echo "UPLOAD LOGO";
                          header("refresh:3;"); ?>
                  </div> <?php
          }else {
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
                  $query = "update school set logo=:logo where school=:school";
                  $statement = oci_parse($conn, $query);
                  oci_bind_by_name($statement, ':school', $name);
                  $content = file_get_contents($file);
                  $lob = oci_new_descriptor(oci_connect($username, $password, $connection), OCI_D_LOB);
                  oci_bind_by_name($statement, ':logo', $lob, -1, OCI_B_BLOB);
                  $lob->writeTemporary($content, OCI_TEMP_BLOB);
                  oci_execute($statement, OCI_DEFAULT);
                  $check=(oci_parse($conn,"select * from school where school='$name'"));
                  oci_execute($check);
                  if(oci_fetch_all($check,$a)>0){
                    ?><div style="font-size:15px;
                    color: green;
                    position: relative;
                     display:flex;
                     margin-left:10px;
                    animation:button .3s linear;text-align: center;">
                      <?php echo "LOGO UPDATED";
                             header("refresh:2;");
                      ?></div><?php
                  }else {
                    ?><div style="font-size:15px;
                    color: red;
                    position: relative;
                     display:flex;
                     margin-left:10px;
                    animation:button .3s linear;text-align: center;">
                      <?php echo "ERROR UPDATING LOGO";
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
                          //  header("refresh:2;");
                    ?></div><?php
                }
          }
         }
         /*   $check=oci_parse($conn,"select * from school where school = '$school'");
           oci_execute($check);
           if(oci_fetch_all($check,$a)>0){
            ?><div style="font-size:13px;
                color: red;
                position: relative;
                margin-left:10px;
                 display:flex;
                animation:button .3s linear;text-align: center;">
                                <?php echo "SCHOOL ALREADY EXIST";
                                  //  header("refresh:3;"); ?>
                            </div> <?php
           }
           else {
           
         /*   if(isset($_FILES['file'])){
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
                  $query = "INSERT INTO school (school,address,reg_code,dis_code,phone_one,phone_two,email,logo,status) values (:school,:address,:reg,:dis,:p1,:p2,:email,:logo,:status)";
                  $statement = oci_parse($conn, $query);
                  oci_bind_by_name($statement, ':school', $school);
                  oci_bind_by_name($statement, ':address', $address);
                  oci_bind_by_name($statement, ':email', $email);
                  oci_bind_by_name($statement, ':reg', $reg_code);
                  oci_bind_by_name($statement, ':dis', $dis_code);
                  oci_bind_by_name($statement, ':p1', $p1);
                  oci_bind_by_name($statement, ':p2', $p2);
                  oci_bind_by_name($statement, ':status', $status);
                  $content = file_get_contents($file);
                  $lob = oci_new_descriptor(oci_connect($username, $password, $connection), OCI_D_LOB);
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
                             // header("refresh:2;");
                      ?></div><?php
                  }else {
                    ?><div style="font-size:15px;
                    color: red;
                    position: relative;
                     display:flex;
                     margin-left:10px;
                    animation:button .3s linear;text-align: center;">
                      <?php echo "ERROR REGISTERING SCHOOL";
                              //header("refresh:2;");
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
                          //  header("refresh:2;");
                    ?></div><?php
                }
            }
           } */
        
      }else {
        ?><div style="font-size:15px;
        color: red;
        position: relative;
         display:flex;
         margin-left:10px;
        animation:button .3s linear;text-align: center;">
          <?php //echo "NOT CLICKED";
                
          ?></div><?php
      }
      
      ?>
        <span></span>
      </div>
     
      
    </form>
  </div>
</body>

</html>