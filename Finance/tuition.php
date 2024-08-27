<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/showss.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
</head>

<?php
ob_start();
session_start();
$school =  $_SESSION['school'];
$sid = $_SESSION['sid'];
include 'connect.php'; ?>
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
include('auto_logout.php');
?>
<body>
    <form class="container" enctype="multipart/form-data" action="tuition.php" method="post">
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
        <header>Tuition</header>

        <?php
        include 'connect.php';

        include 'connect.php';
        $region = " ";
        ?>
        <div class="input-field">
            <select required name="reg">
                <option disabled selected>Select Class Tuition</option>
                <?php
                $get_hos = "select * from sub_CLASS where s_id = $sid";
                $get = oci_parse(oci_connect($username, $password, $connection), $get_hos);
                oci_execute($get);
                while ($row = oci_fetch_array($get)) {
                ?><option>
                        <?php echo $row["CLASS_NAME"]; ?>
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
            <i class="uil uil-filter"></i>
        </button>
        <?php
        $id = 0;
        $cc=0;
        if (isset($_POST['filter'])) {
            if (isset($_POST['reg'])) {
                $region = $_POST['reg'];
                $get_hos = "select * from sub_class where class_name = '$region' and s_id=$sid  ";

                $get = oci_parse(oci_connect($username, $password, $connection), $get_hos);
                oci_execute($get);
                if ($row = oci_fetch_array($get)) {
                    $id = $row['CLASS'];
                    $cc=$row['SUB_CODE'];
                }
            } else {
        ?><div style="font-size:15px;
                color: red;
                position: relative;
                 display:flex;
                animation:button .3s linear;text-align: center;">
                    <?php echo "SELECT CLASS"; ?>
                </div> <?php
                    }
                }
                        ?>
        <?php
        if ($conn) {
            $sql = "SELECT A.CLASS_TITLE,B.DESCRIPTION,B.COST,C.CLASS_NAME FROM CLASS A JOIN TUITION B ON (A.CLASS=B.CLASS) JOIN SUB_CLASS C ON (A.CLASS=C.CLASS) WHERE B.CLASS = $id and B.S_ID = $sid and c.sub_code = $cc";
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
                        Class Name</th>
                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Description</th>
                    <th style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                        Cost</th>
            </thead>
            <tbody>
                <tr style=" border-bottom: 1px solid #dddddd;">
                    <?php
                    while ($row = oci_fetch_array($stid)) {
                    ?>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['CLASS_NAME']; ?>

                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['DESCRIPTION']; ?>

                        </td>
                        <td style=" padding: 5px 8px;
    font-size: 10px;
    margin: 5px;">
                            <?php echo $row['COST']; ?>

                        </td>
                </tr>
            <?php
                    }
            ?>
            </tr>
            </tbody>
        </table>
        <?php
        $tt = 0;
        $sql = "SELECT SUM(COST) FROM TUITION WHERE S_ID = $sid and class = $id and sub_code = $cc";
        $total = oci_parse($conn, $sql);
        oci_execute($total);
        while ($r = oci_fetch_array($total)) {
            $tt = $r['SUM(COST)'];
        }
        ?>
        <div style="display:flex; margin-top:20px;">
            <Label style="font-size: 18px; font-family: righteous;
         font-weight: bold; color: #000000;">Total:<?php echo "D" . $tt ?></Label>
        </div>

        <div style="display: flex;">
            <button style=" display: inline-block;
  padding: 6px 12px;
  background-color: #1D5B79;
  color: white;
  border: none;
  border-radius: 4px;
  margin-top:10px;
  margin-bottom:10px;
  text-decoration: none;" name="generate" type="submit">
                GENERATE TUITION INVOICE
                <i class="uil uil-file-export"></i>
            </button>
        </div>
        <?php
        if (isset($_POST['generate'])) {

            require('tcpdf/tcpdf.php');
            if (isset($_POST['reg'])) {
                $reg = $_POST['reg'];
                $get_hos = "select * from sub_class where class_name = '$reg' and s_id=$sid ";
                $get = oci_parse(oci_connect($username, $password, $connection), $get_hos);
                oci_execute($get);
                if ($row = oci_fetch_array($get)) {
                    $class = $row['CLASS'];
                    $cc = $row['SUB_CODE'];
                }
                $stmt = oci_parse($conn, "select a.region,b.district,c.school,c.address,c.phone_one,c.phone_two,c.email,c.logo,d.class_title from region a join district b on (a.reg_code=b.reg_code) join school c on (b.dis_code=c.dis_code) JOIN CLASS D on (c.s_id=d.s_id)  where c.s_id =:sid and d.class=:class");
                oci_bind_by_name($stmt, ':sid', $sid);
                oci_bind_by_name($stmt, 'class', $class);
                oci_execute($stmt);
                while ($row = oci_fetch_array($stmt)) {
                    $region = $row['REGION'];
                    $district = $row['DISTRICT'];
                    $school = $row['SCHOOL'];
                    $address = $row['ADDRESS'];
                    $phone_one = $row['PHONE_ONE'];
                    $phone_two = $row['PHONE_TWO'];
                    $email = $row['EMAIL'];
                    $imageData = $row['LOGO']->load(); // Load OCILob data
                    $class_t = $row['CLASS_TITLE'];
                    $decodedContent = base64_decode($imageData);
                    // Save the decoded content to a file
                    $saveDirectory = 'C:/wamp64/www/Academix/Finance/img/';
                    $fileName = "school_logo.png";
                    // Create the directory if it doesn't exist
                    if (!is_dir($saveDirectory)) {
                        mkdir($saveDirectory, 0777, true); // Specify the appropriate permissions
                    }
                    // Construct the file path
                    $filePath = $saveDirectory . $fileName;
                    file_put_contents($filePath, $imageData);
                }
                $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
                // Add a page
                $pdf->AddPage();
                $pdf->SetHeaderMargin(0); // Set the header margin to zero
                $pdf->setPrintHeader(false);
                $pdf->setPrintFooter(false);
                $pdf->SetFont('helvetica', '', 10);
                $pdf->SetTextColor(29, 91, 121);
                $pdf->SetFont('helvetica', 'B', 25);
                $pdf->Cell(0, 130, 'INVOICE FOR ' . $reg, 0, 1, 'L');
                $pdf->Ln();
                $logoPath  = 'img/school_logo.png';
                $pdf->Image($logoPath, 170, 15, 30, 35);
                $pdf->Image($logoPath, 170, 15, 30, 35);
                $pdf->SetTextColor(29, 91, 121);
                $pdf->SetFont('dejavusans', '', 6.5);
                $companyInfo = "$school\n$address\n$district\n$region\nThe Gambia\n$email\nTel: $phone_one/ $phone_two";
                $pdf->SetXY(140, 60);
                $pdf->MultiCell(0, 9, $companyInfo, 0, 'R');

                // Get the Y-coordinate of the bottom of the "Invoice" title
                $invoiceTitleBottomY = $pdf->GetY();

                $pdf->SetY($invoiceTitleBottomY + 5);
                $pdf->Cell(10, 10, 'Date:', 0, 0);
                $pdf->Cell(0, 10, date('Y-m-d'), 0, 1);

                $s = "select description,cost,sum(cost) from tuition where class = $class and s_id = $sid and sub_code = $cc GROUP by description,cost";
                $stmts = oci_parse($conn, $s);
                oci_execute($stmts);
                // Table headers
                $pdf->SetFont('courier', 'B', 10);
                $pdf->Cell(60, 10, 'Description', 1, 0, 'C');
                //  $pdf->Cell(60, 10, 'Cost', 1, 0, 'C'); // Centralize the text
                $pdf->Cell(0, 10, 'Price', 1, 1, 'C'); // Centralize the text

                // Table content
                $pdf->SetFont('courier', 'B', 10);
                while ($row = oci_fetch_assoc($stmts)) {
                    $itemName = $row['DESCRIPTION'];
                    $curr = $row['COST'];
                    $itemPrice = $row['COST'];

                    $pdf->Cell(60, 10, $itemName, 1, 0, 'C');
                    //  $pdf->Cell(60, 10, $curr, 1, 0, 'C');
                    $pdf->Cell(0, 10, $itemPrice, 1, 1, 'C');;
                }
                $sql = "SELECT SUM(COST) FROM TUITION WHERE S_ID = $sid and class = $class and sub_code = $cc  ";
                $total = oci_parse($conn, $sql);
                oci_execute($total);
                while ($r = oci_fetch_array($total)) {
                    $tt = $r['SUM(COST)'];
                }
                // Set the Y-coordinate below the table for the total
                $pdf->SetY($pdf->GetY() + 10); // You may need to adjust the value based on your layout

                // Output the total on the far right
                $pdf->Cell(0, 10, 'Total: D' . number_format($tt, 2), 0, 1, 'R');

                $disclaimer = "This invoice was generated by $school";
                $pdf->SetFont('dejavusans', 'I', 8);
                $pdf->Cell(0, 5, $disclaimer, 0, 0, 'C');
                $directoryPath = 'C:\ACADEMIX\\' . $school . '\generated_reports\invoice\\';
                if (!is_dir($directoryPath)) {
                    if (!mkdir($directoryPath, 0777, true)) {
                        die('Failed to create directories.');
                    }
                }
                $filePath = $directoryPath . 'INVOICE.pdf';
                $pdf->Output($filePath, 'F'); // 'F' parameter saves to a file
        ?><div style="font-size:15px;
                color: green;
                position: relative;
                 display:flex;
                animation:button .3s linear;text-align: center;">
                    <?php echo "INVOICE GENERATED";
                    ?>
                    // ... your existing code to generate the Excel file ...
                    <?php
                    // Check if the file was successfully generated
                  if (file_exists($filePath)) {
                        // Construct the URL to the file
                        $fileUrl = 'http://' . $_SERVER['HTTP_HOST'] . '/' . $filePath ;
                        // Redirect the user to the file URL
                      //  header('Location: ' . $fileUrl);
                        exit; // Terminate the script
                    } else {
                        echo "File not found or could not be generated.";
                    } 
                   /* $filename = basename('INVOICE.pdf');
                    header("Cache-Control: public");
                    header("Content-Description: File Transfer");
                    header("Content-Disposition: attachment; filename=$filename");
                    header("Content-Type: application\zip");
                    header("Content-Transfer-Encoding: binary");
                    readfile($filePath);  */
                     if (file_put_contents($file_name, file_get_contents($url)))
    {
        echo "File downloaded successfully";
    }
    else
    {
        echo "File downloading failed.";
    }

                    ?>
                    <?php header("refresh:2;");
                    ?>
                </div> <?php
                    } else {
                        ?><div style="font-size:15px;
            color: red;
            position: relative;
             display:flex;
            animation:button .3s linear;text-align: center;">
                    <?php echo "SELECT CLASS";
                        header("refresh:2"); ?>
                </div> <?php
                    }
                }
                        ?>
        </div>
        <Label style="font-size: 18px; font-family: sans-serif;
    font-weight: bold; color: #1D5B79;">Add Tuition Details</Label>
        <div class="input-container" style="display: flex;">
            <div class="input-field" style="margin-right: 10px;">
                <label for="subjectCode">Class</label>
                <select required name="grade">
                    <option disabled selected>Select Class</option>
                    <?php
                    $get_hos = "select * from sub_CLASS where s_id = $sid";
                    $get = oci_parse(oci_connect($username, $password, $connection), $get_hos);
                    oci_execute($get);
                    while ($row = oci_fetch_array($get)) {
                    ?><option>
                            <?php echo $row["CLASS_NAME"]; ?>
                        </option> <?php
                                }
                                    ?>
                </select>
            </div>

            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">Description</label>
                <input type="text" placeholder="Enter Description" title="Only Letters" pattern="[A-z ]+" name="description">
            </div>

            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">Cost</label>
                <input type="number" placeholder="Enter Cost" title="Only Numbers" pattern="[A-z]+" name="costs">
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
  margin-bottom:10px;
  text-decoration: none;" name="add" type="submit">
                Add Tuition Details
                <i class="uil uil-plus"></i>
            </button>
        </div>
        <?php
        if (isset($_POST['add'])) {
            if (isset($_POST['grade'])) {
                $grade = $_POST['grade'];
                $des = strtoupper($_POST['description']);
                if ($des != '') {
                    $cost = $_POST['costs'];
                    if ($cost != '') {
                        $cost = $_POST['costs'];
                        $get_hos = "select * from sub_CLASS where s_id = $sid and class_name = '$grade' ";
                        $get = oci_parse(oci_connect($username, $password, $connection), $get_hos);
                        oci_execute($get);
                        while ($r = oci_fetch_array($get)) {
                            $c = $r['CLASS'];
                            $code = $r['SUB_CODE'];
                        }
                        $sql = oci_parse($conn, "select * from tuition where description like '%$des' and class = $c and s_id = $sid and sub_code = $code");
                        oci_execute($sql);
                        if (oci_fetch_all($sql, $a) == 0) {
                            $sql = oci_parse($conn, "insert into tuition (S_ID,class,description,cost,sub_code) values ($sid,$c,'$des',$cost,$code)");
                            if (oci_execute($sql)) {
        ?><div style="font-size:15px;
                                    color: green;
                                    position: relative;
                                     display:flex;
                                     margin-left:10px;
                                    animation:button .3s linear;text-align: center;">
                                    <?php echo "TUITION DETAILS ADDED FOR $grade";
                                    header("refresh:2;");
                                    ?></div><?php
                                        } else {
                                            ?><div style="font-size:15px;
                                    color: red;
                                    position: relative;
                                     display:flex;
                                     margin-left:10px;
                                    animation:button .3s linear;text-align: center;">
                                    <?php echo "ERROR ADDING TUITION DETAILS FOR $grade";
                                            header("refresh:2;");
                                    ?></div><?php
                                        }
                                    } else {
                                            ?><div style="font-size:15px;
                            color: red;
                            position: relative;
                             display:flex;
                             margin-left:10px;
                            animation:button .3s linear;text-align: center;">
                                <?php echo "TUITION DETAILS ALREADY ADDED FOR $grade";
                                        header("refresh:2;");
                                ?></div><?php
                                    }
                                } else {
                                        ?><div style="font-size:15px;
                        color: red;
                        position: relative;
                         display:flex;
                         margin-left:10px;
                        animation:button .3s linear;text-align: center;">
                            <?php echo "ENTER COST";
                                    header("refresh:2;");
                            ?></div><?php
                                }
                            } else {
                                    ?><div style="font-size:15px;
                    color: red;
                    position: relative;
                     display:flex;
                     margin-left:10px;
                    animation:button .3s linear;text-align: center;">
                        <?php echo "ENTER DESCRIPTION";
                                header("refresh:2;");
                        ?></div><?php
                            }
                        } else {
                                ?><div style="font-size:15px;
                color: red;
                position: relative;
                 display:flex;
                 margin-left:10px;
                animation:button .3s linear;text-align: center;">
                    <?php echo "SELECT CLASS";
                            header("refresh:2;");
                    ?></div><?php
                        }
                    }

                            ?>
        <Label style="font-size: 18px; font-family: sans-serif;
    font-weight: bold; color: #1D5B79;">Edit Tuition Details</Label>
        <div class="input-container" style="display: flex;">

            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">Field</label>
                <select name="field" required>
                    <option disabled selected>Select Field To Edit</option>
                    <option>DESCRIPTION</option>
                    <option>COST</option>
                </select>
            </div>

            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">Description</label>
                <select name="descr" required>
                    <option disabled selected>Select Description To Edit</option>
                    <?php
                    $get_hos = "select * from tuition where s_id = $sid";
                    $get = oci_parse(oci_connect($username, $password, $connection), $get_hos);
                    oci_execute($get);
                    while ($row = oci_fetch_array($get)) {
                    ?><option>
                            <?php echo $row["DESCRIPTION"]; ?>
                        </option> <?php
                                }
                                    ?>
                </select>
            </div>

            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">Class</label>
                <select required name="class">
                    <option disabled selected>Select Class</option>
                    <?php
                $get_hos = "select * from sub_CLASS where s_id = $sid";
                $get = oci_parse(oci_connect($username, $password, $connection), $get_hos);
                oci_execute($get);
                while ($row = oci_fetch_array($get)) {
                ?><option>
                        <?php echo $row["CLASS_NAME"]; ?>
                    </option> <?php
                            }
                                ?>
                </select>
            </div>

        </div>
        <div class="input-container" style="display: flex;">

            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">New Description</label>
                <input type="text" placeholder="Enter Description" title="Only Letters" pattern="[A-z]+" name="des">
            </div>

            <div class="input-field" style="margin-right: 10px; ">
                <label for="subjectCode">New Cost</label>
                <input type="number" placeholder="Enter Cost" title="Only Numbers" name="cost">
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
  margin-bottom:10px;
  text-decoration: none;" name="edit" type="submit">
                Edit Tuition Details
                <i class="uil uil-edit"></i>
            </button>
        </div>
        <?php
        if (isset($_POST['edit'])) {
            if (isset($_POST['field'])) {
                if (isset($_POST['descr'])) {
                    $d = $_POST['descr'];
                    if (isset($_POST['class'])) {
                        $field = $_POST['field'];
                        $class_title = $_POST['class'];
                        $sql = oci_parse($conn, "select * from sub_class where class_name = '$class_title' ");
                        oci_execute($sql);
                        while ($r = oci_fetch_array($sql)) {
                            $class = $r['CLASS'];
                            $ccc=$r['SUB_CODE'];
                        }

                        if ($field == 'DESCRIPTION') {
                            $first = strtoupper($_POST['des']);
                            if ($first != '') {
                                $sql = oci_parse($conn, "update tuition set description = '$first' where s_id = $sid and class=$class and description = '$d' and sub_code = $ccc");
                                oci_execute($sql);
                                $sql = oci_parse($conn, "select * from tuition where description = '$first' and s_id = $sid and class=$class and description = '$first'  and sub_code = $ccc ");
                                oci_execute($sql);
                                if (oci_fetch_all($sql, $a) > 0) {
        ?><div style="font-size:15px;
                                color: green;
                                position: relative;
                                 display:flex;
                                 margin-left:10px;
                                animation:button .3s linear;text-align: center;">
                                        <?php echo "DESCRIPTION UPDATED SUCCESSFULLY";
                                        header("refresh:2;");
                                        ?></div><?php
                                            } else {
                                                ?><div style="font-size:15px;
                                color: red;
                                position: relative;
                                 display:flex;
                                 margin-left:10px;
                                animation:button .3s linear;text-align: center;">
                                        <?php echo "ERROR UPDATING DESCRIPTION ";
                                                header("refresh:2;");
                                        ?></div><?php
                                            }
                                        } else {
                                                ?><div style="font-size:15px;
                            color: red;
                            position: relative;
                             display:flex;
                             margin-left:10px;
                            animation:button .3s linear;text-align: center;">
                                    <?php echo "ENTER DESCRIPTION";
                                            header("refresh:2;");
                                    ?></div><?php
                                        }
                                    } else if ($field == 'COST') {
                                        $first = $_POST['cost'];
                                        if ($first != '') {
                                            $sql = oci_parse($conn, "update tuition set cost = $first where s_id = $sid and class = $class and description = '$d' and sub_code = $ccc");
                                            oci_execute($sql);
                                            $sql = oci_parse($conn, "select * from tuition where cost = $first and s_id = $sid and class = $class and description = '$d'  and sub_code = $ccc");
                                            oci_execute($sql);
                                            if (oci_fetch_all($sql, $a) > 0) {
                                            ?><div style="font-size:15px;
                             color: green;
                             position: relative;
                              display:flex;
                              margin-left:10px;
                             animation:button .3s linear;text-align: center;">
                                        <?php echo "COST UPDATED SUCCESSFULLY";
                                                header("refresh:2;");
                                        ?></div><?php
                                            } else {
                                                ?><div style="font-size:15px;
                             color: red;
                             position: relative;
                              display:flex;
                              margin-left:10px;
                             animation:button .3s linear;text-align: center;">
                                        <?php echo "ERROR UPDATING COST ";
                                                header("refresh:2;");
                                        ?></div><?php
                                            }
                                        } else {
                                                ?><div style="font-size:15px;
                         color: red;
                         position: relative;
                          display:flex;
                          margin-left:10px;
                         animation:button .3s linear;text-align: center;">
                                    <?php echo "ENTER COST";
                                            header("refresh:2;");
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
                            <?php echo "SELECT CLASS";
                                    header("refresh:2;");
                            ?></div><?php
                                }
                            } else {
                                    ?><div style="font-size:15px;
                    color: red;
                    position: relative;
                     display:flex;
                     margin-left:10px;
                    animation:button .3s linear;text-align: center;">
                        <?php echo "SELECT DESCRIPTION TO EDIT";
                                header("refresh:2;");
                        ?></div><?php
                            }
                        } else {
                                ?><div style="font-size:15px;
                color: red;
                position: relative;
                 display:flex;
                 margin-left:10px;
                animation:button .3s linear;text-align: center;">
                    <?php echo "SELECT FIELD TO EDIT";
                            header("refresh:2;");
                    ?></div><?php
                        }
                    }
                            ?>
        <div class="buttons">

            <button class="backBtn" type="submit">

                <a class="btnText" href="finance.php">
                    BACK
                </a>
            </button>
        </div>
    </form>
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
    <script>
        $(document).ready(function() {
            $('#example').DataTable();
        });
    </script>
</body>

</html>