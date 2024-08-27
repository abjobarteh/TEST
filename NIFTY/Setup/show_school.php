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

<body>
<form class="container" enctype="multipart/form-data" action="show_school.php" method="post">
        <div class="com">
            <h3>
            Academix: School Management System
            </h3>
            <img src="img/logo.png" style="height:100px;">
        </div>
        <header>School</header>
<?php 
        include 'connect.php'; 
        $region=" ";
        ?> 
        <div class="input-field">
                            <select required name="reg">
                                <option disabled selected>Select District</option>
                                <?php
                                
                                $get_hos = "select * from district order by dis_code";
                                $get = oci_parse(oci_connect($username, $password, $connection), $get_hos);
                                oci_execute($get);
                                while ($row = oci_fetch_array($get)) {
                                ?><option>
                                        <?php echo $row["DISTRICT"]; ?>
                                    </option> <?php
                                            }
                                                ?>
                            </select>
                </div>
                        <button style=" display: inline-block;
  padding: 6px 12px;
  background-color: #1D5B79;
  color: white;
  border: none;
  border-radius: 4px;
  text-decoration: none;" name="filter" type="submit">
         FILTER
         <?php 
         $rcode=0;
         if(isset($_POST['filter'])){
            $region=$_POST['reg']; 
            $get_hos = "select * from district where district = '$region' ";
            $get = oci_parse(oci_connect($username, $password, $connection), $get_hos);
           oci_execute($get);
            if($row=oci_fetch_array($get)){
                $rcode=$row['DIS_CODE'];
            }
           
         }
         ?>
           <i class="uil uil-filter"></i>
        </button>


        <?php

        include 'connect.php';

        if ($conn) {
            ob_start();
            $sql = "select * from school s join region r on (s.reg_code=r.reg_code) join district d on (s.dis_code=d.dis_code) where s.dis_code='$rcode'";
            
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
                        Region</th>
                        <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        School</th>
                        <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Address</th>
                        <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Phone 1</th>
                        <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Phone 2</th>
                        <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Email</th>
                        <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Logo</th>
                        <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Status</th>
                       
                </tr>
            </thead>
            <tbody>
                <tr style=" border-bottom: 1px solid #dddddd;">
                    <?php
                    while ($row = oci_fetch_array($stid)) {
                    ?>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['REGION']; ?>
                            
                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['SCHOOL']; ?>
                            
                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['ADDRESS']; ?>
                            
                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['PHONE_ONE']; ?>
                            
                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['PHONE_TWO']; ?>
                            
                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['EMAIL']; ?>
                            
                        </td>

                        
    <?php
       $stmt = oci_parse($conn, "select * from school s join region r on (s.reg_code=r.reg_code) join district d on (s.dis_code=d.dis_code) where s.dis_code=:rcode");
       oci_bind_by_name($stmt, ':rcode', $rcode);
       oci_execute($stmt);
       if($rowS = oci_fetch_array($stmt)) {
        $imageData = $rowS['LOGO']->load(); // Load OCILob data
        
        // Encode the image data as base64
        $base64Image = base64_encode($imageData);
         ?> <td style=" padding: 5px 8px; font-size: 10px; margin: 5px;"><?php 
         
         echo '<img src="data:image/png;base64,' . $base64Image . '" alt="Image" style="width: 50px; height: 50px;">';?></td> <?php
       }
    ?>
    

                        <td style=" padding: 5px 8px;
    font-size: 10px;
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

                <a class="btnText" href="setup_menu.php">
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
<?php
function ispdf_word($file)
{
    $ext = pathinfo($file, PATHINFO_EXTENSION);
    if (in_array(strtolower($ext), ['pdf', 'doc', 'docx'])) {
        return true;
    }
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimetype = finfo_file($finfo, $file);
    finfo_close($finfo);
    if (in_array($mimetype, ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'])) {
        return true;
    }

    return false;
}

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
?>
</html>