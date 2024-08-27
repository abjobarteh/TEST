<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/shows.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
</head>

<body>
<form class="container" enctype="multipart/form-data" action="school_users.php" method="post">
        <div class="com">
            <h3>
            Academix: School Management System
            </h3>
            <img src="img/logo.png" style="height:100px;">
        </div>
        <header>School User Details</header>
    <?php 
        include 'connect.php'; 
        $region=" ";
        ?> 
        <div class="input-field">
                            <select required name="reg">
                                <option disabled selected>Select School</option>
                                <?php
                                
                                $get_hos = "select * from school order by school";
                                $get = oci_parse(oci_connect($username, $password, $connection), $get_hos);
                                oci_execute($get);
                                while ($row = oci_fetch_array($get)) {
                                ?><option>
                                        <?php echo $row["SCHOOL"]; ?>
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
            $get_hos = "select * from school where school = '$region' ";
            $get = oci_parse(oci_connect($username, $password, $connection), $get_hos);
           oci_execute($get);
            if($row=oci_fetch_array($get)){
                $rcode=$row['S_ID'];
            }
           
         }
         ?>
           <i class="uil uil-filter"></i>
        </button>


        <?php

        include 'connect.php';

        if ($conn) {
            ob_start();
            $sql = "select * from school s join school_users u on (s.s_id=u.s_id) where u.s_id=$rcode";
            
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
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['FIRSTNAME']; ?>
                            
                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['MIDDLENAME']; ?>
                            
                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['LASTNAME']; ?>
                            
                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['DOB']; ?>
                            
                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['GENDER']; ?>
                            
                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['ADDRESS']; ?>
                            
                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['MOBILE']; ?>
                            
                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['WORK']; ?>
                            
                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['EMAIL']; ?>
                            
                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['USERNAME']; ?>
                            
                        </td>

                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['RIGHTS']; ?>
                            
                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['CREATE_DT']; ?>
                            
                        </td>
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

</html>