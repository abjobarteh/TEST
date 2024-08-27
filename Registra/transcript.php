<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/transcript.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a81368914c.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" />
    <?php
    ob_start();
    include('auto_logout.php');
    include('connect.php');
    $school =  $_SESSION['school'];
    $sid = $_SESSION['sid'];
    ?>
    <title>Transcript</title>
</head>
<style>
    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgb(0, 0, 0);
        background-color: rgba(0, 0, 0, 0.4);
        padding-top: 60px;
    }

    .modal-content {
        background-color: #fefefe;
        margin: 2% auto;
        /* Reduced margin to increase vertical space */
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
        height: 80%;
        /* Set height to 80% of the viewport height */
        overflow-y: auto;
        /* Enable vertical scrolling if content overflows */
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th,
    td {
        padding: 12px;
        border: 1px solid #ddd;
        text-align: left;
        font-size: 12px;
    }

    th {
        background-color: #f2f2f2;
    }
</style>

<body>
    <div class="container">
    <div class="com" style="
    vertical-align: middle;
    text-align: center;
    justify-content: center;
    align-items: center;">
      <h3 class="title" style="justify-content:center; text-align:center; color:#1D5B79; 	font-size: 18px;">Welcome To Academix
      </h3>
      <h3 class="title" style="justify-content:center; text-align:center; color:#1D5B79; 	font-size: 18px;"><?php echo $school ?>
      </h3>
      <?php
      $stmt = oci_parse($conn, "select * from school where school = :name");
      oci_bind_by_name($stmt, ':name', $school);
      oci_execute($stmt);
      if ($rowS = oci_fetch_array($stmt)) {
        $imageData = $rowS['LOGO']->load(); // Load OCILob data

        // Encode the image data as base64
        $base64Image = base64_encode($imageData);
      ?> <td style=" padding: 5px 8px; font-size: 10px; margin: 5px; align-items: center;"><?php

                                                                        echo '<img src="data:image/png;base64,' . $base64Image . '" alt="Image" style="width: 100px; height: 100px;">'; ?></td> <?php
                                                                                                                                                              }
                                                                                                                                                                ?>
    </div>
        <div class="buttons">
            <button class="backBtn" style="width: 150px;">
                <a class="btnText" href="registra" style="font-size: 15px; color: white; text-decoration: none;">
                    HOME
                    <i class="uil uil-estate" style="width: 50px; color: white;"></i>
                </a>
            </button>
        </div>
        <header>Transcript</header>
        <form method="POST" action="transcript" enctype="multipart/form-data">
            <div class="form first">
               

                <div class="details personal">
                    <div class="details personal">
                        <span class="title">Add Student Activities And Responsibilities</span>

                        <div class="fields">
                            <div class="input-field" style="   display: flex;
    flex-direction: column;
    margin-bottom: 15px;
    width: calc(75% / 4 - 10px);">
                                <label>Existing Student</label>
                                <select name="select_existstudent" required>
                                    <option disabled selected>Select Student</option>
                                    <?php
                                    $sql = oci_parse($conn, "SELECT DISTINCT(STUD_ID),NAME FROM STUDENT WHERE NAME IS NOT NULL ORDER BY NAME");
                                    oci_execute($sql);
                                    while ($row = oci_fetch_array($sql)) {
                                        echo '<option value="' . $row["STUD_ID"] . '">' . strtoupper($row["NAME"]) . ' ' . strtoupper($row['STUD_ID']) . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="input-field" style="   display: flex;
    flex-direction: column;
    margin-bottom: 15px;
    width: calc(75% / 6 - 10px);">
                                <label>Class</label>
                                <select name="class" required>
                                    <option disabled selected>Select Class</option>
                                    <?php
                                    $sql = oci_parse($conn, "SELECT * FROM CLASS WHERE S_ID = 41 ORDER BY CLASS");
                                    oci_execute($sql);
                                    while ($row = oci_fetch_array($sql)) {
                                        echo '<option value="' . $row["CLASS"] . '">' . strtoupper($row["CLASS_TITLE"])  . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="input-field" style=" display: flex;
    flex-direction: column;
    margin-bottom: 15px;
    width: calc(85% / 3 - 10px);">
                                <label>Activities</label>
                                <input type="text" placeholder="Enter Student Activities" name="stu_act">
                            </div>
                            <div class="input-field" style=" display: flex;
    flex-direction: column;
    margin-bottom: 15px;
    width: calc(85% / 3 - 10px);">
                                <label>Responsibilities</label>
                                <input type="text" placeholder="Enter Student Responsibilities" name="stu_resp">
                            </div>
                            <button class="nextBtn" name="save_act_btn" style="display: flex; align-items: center; justify-content: center; height: 45px; max-width: 350px; width: 100%; border: none; outline: none; color: #fff; border-radius: 5px; margin: 25px 0; background-color: #1D5B79;; transition: all 0.3s linear; cursor: pointer; margin-left: 10px;">
                                <span class="btnText">SAVE STUDENT ACTIVITIES RECORDS</span>
                                <i class="uil uil-save"></i>
                            </button>
                            <button class="nextBtn" name="save_resp_btn" style="display: flex; align-items: center; justify-content: center; height: 45px; max-width: 450px; width: 100%; border: none; outline: none; color: #fff; border-radius: 5px; margin: 25px 0; background-color: #1D5B79;; transition: all 0.3s linear; cursor: pointer; margin-left: 10px;">
                                <span class="btnText">SAVE STUDENT RESPONSIBILITIES RECORDS</span>
                                <i class="uil uil-save"></i>
                            </button>

                        </div>
                    </div>
                </div>
                <div class="buttons" style="display: flex; align-items: center; gap: 10px;">
                    <label>Existing Student</label>
                    <div class="input-field" style="flex: 1; display: flex; flex-direction: column; margin-bottom: 15px;">
                        <select name="student" required style="width: 400px; max-width: 100%;">
                            <option disabled selected>Select Student</option>
                            <?php
                            $sql = oci_parse($conn, "SELECT DISTINCT(STUD_ID),NAME FROM STUDENT WHERE NAME IS NOT NULL ORDER BY NAME");
                            oci_execute($sql);
                            while ($row = oci_fetch_array($sql)) {
                                echo '<option value="' . $row["STUD_ID"] . '">' . strtoupper($row["NAME"]) . ' ' . strtoupper($row['STUD_ID']) . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <label>Principal Comments</label>
                    <div class="input-field" style="flex: 1; display: flex; flex-direction: column; margin-bottom: 15px;">
                        <input type="text" placeholder="Enter Principal Comments" name="comments" style="width: 400px; max-width: 100%;">
                    </div>
                    <button class="nextBtn" name="gen_transcript" style="display: flex; align-items: center; justify-content: center; height: 45px; max-width: 450px; width: 100%; border: none; outline: none; color: #fff; border-radius: 5px; margin: 25px 0; background-color: #1D5B79;; transition: all 0.3s linear; cursor: pointer; margin-left: 10px;">
                        <span class="btnText">GENERATE TRANSCRIPT</span>
                        <i class="uil uil-save"></i>
                    </button>
                </div>


        </form>
        <div class="footer">
            <p style="font-size: 19px; color: #1D5B79;; flex-basis: 100%; font-weight: bold">Developed and Powered By Nifty ICT Solutions Ltd</p>
            <p style="font-size: 19px; color: #1D5B79;; flex-basis: 100%; font-weight: bold">Phone: +2209067411 | Website: www.niftyict.com | Email: enquiries@niftyict.com</p>
        </div>
    </div>

    <?php
    require '../vendor/autoload.php';

    use Dompdf\Dompdf;
    use Dompdf\Options;

    if (isset($_POST['gen_transcript'])) {
        if (isset($_POST['student'])) {
            if ($_POST['comments'] != '') {

                $comments = strtoupper($_POST['comments']);
                $student_id = $_POST['student'];
                $options = new Options();
                $options->set('isHtml5ParserEnabled', true);
                $options->set('isRemoteEnabled', true);

                $dompdf = new Dompdf($options);
                $dompdf->setPaper('letter', 'landscape');

                $stmt = oci_parse($conn, "select a.region,b.district,c.school,c.address,c.phone_one,c.phone_two,c.email,c.logo from region a join district b on (a.reg_code=b.reg_code) join school c on (b.dis_code=c.dis_code) where c.s_id =:sid  ");
                oci_bind_by_name($stmt, ':sid', $sid);
                oci_execute($stmt);
                while ($row = oci_fetch_array($stmt)) {
                    $region = 'REGION ONE';
                    $district = $row['DISTRICT'];
                    $school = $row['SCHOOL'];
                    $address = $row['ADDRESS'];
                    $phone_one = $row['PHONE_ONE'];
                    $phone_two = $row['PHONE_TWO'];
                    $email = $row['EMAIL'];
                    $imageData = $row['LOGO']->load(); // Load OCILob data
                    $decodedContent = base64_decode($imageData);
                    $saveDirectory = 'C:/wamp64/www/Academix/KSSS/Registra/img/';
                    $fileName = "school logo.jpg";
                }
                $logoPath = 'img/school logo.png';
                $logoData = base64_encode(file_get_contents($logoPath));
                $logoBase64 = 'data:image/png;base64,' . $logoData;

                $companyInfo = "$address\n$district\nREGION\nThe Gambia\n$email\nTel: $phone_one/ $phone_two";
                // Fetch student information=
                $sql_student = oci_parse($conn, "SELECT A.NAME,A.STDNUMBER,A.STUD_ID ,G.DOB, F.PROG, A.CREATE_DT
                FROM STUDENT A
                JOIN STUDENT_PERSONAL G ON (A.STUD_ID=G.STUD_ID)
                JOIN STUDENT_ACADEMIC C ON (A.STUD_ID=C.STUD_ID)
                JOIN SUB_CLASS D ON (C.SUB_CODE=D.SUB_CODE)
                JOIN PROG_CLASS E ON (D.SUB_CODE=E.SUB_CODE)
                JOIN PROGRAMME F ON (E.PROG_ID=F.PROG_ID)
                WHERE A.STUD_ID = '$student_id'");

                oci_execute($sql_student);

                if ($row_student = oci_fetch_array($sql_student)) {
                    $student_name = $row_student['NAME'];
                    if ($row_student['STDNUMBER'] != '') {
                        $stid = $row_student['STDNUMBER'];
                    } else {
                        $stid = $row_student['STUD_ID'];
                    }
     
                    $dob = $row_student['DOB'];
                    $prog = $row_student['PROG'];
                    $create_dt = $row_student['CREATE_DT'];

                    // Fetch academic records
                    $sql_academic = oci_parse($conn, "SELECT DISTINCT TERM,CLASS_NAME FROM STUDENT_CUMULATIVE A JOIN SUB_CLASS B ON (A.SUB_CODE=B.SUB_CODE) WHERE STUD_ID = '$student_id' ORDER BY TERM");
                    $dt = date('d/m/Y');
                    oci_execute($sql_academic);

                    if (oci_fetch_all($sql_academic, $a) > 0) {
                        $terms = [];
                        oci_execute($sql_academic);
                        while ($row_academic = oci_fetch_array($sql_academic)) {
                            $terms[] = $row_academic['TERM'];
                            $class[] = $row_academic['CLASS_NAME'];
                        }
                        // Prepare HTML for transcript
                        $html = <<<HTML
                        <head>
                            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
                            <link href="https://fonts.googleapis.com/css2?family=Anton+SC&display=swap" rel="stylesheet">
                            <link rel="preconnect" href="https://fonts.googleapis.com">
                            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
                            <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400..700&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900&display=swap" rel="stylesheet">
                            <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400..700&family=Oswald:wght@200..700&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
                        </head>
                        <style>
                             @page {
                            size: A4 portrait; /* Set page size to A4 landscape */
                            margin: 5px; /* Reduce page margin to fit more content */
                        }
                            body {
                                font-family: Arial, sans-serif;
                                font-size: 8px;
                            }
                            .transcript {
                                margin: 10px;
                                padding: 10px;
                                border: 3px solid #1D5B79;;
                                box-shadow: 0 0 10px rgba(0, 0, 255, 0.5); /* Blue shadow border */
                            }
                            .header {
                                text-align: center;
                                margin-bottom: 5px;
                            }
                            .roboto-bold-italic {
                                font-family: "Roboto", sans-serif;
                                font-weight: 300;
                                font-style: normal;
                            }
                            .oswald-uniquifier {
                                font-family: "Helvetica", sans-serif;
                                font-optical-sizing: auto;
                                font-weight: bold;
                                font-style: normal;
                                font-size: 8px;
                            }
                            .student-info {
                                font-size: 7px;
                                font-weight: bold;
                                font-family: "Anton SC", sans-serif;
                                font-weight: 400;
                                font-style: normal;
                                text-align: left; /* Align student info to the left */
                            }
                            .school-info {
                                font-size: 8px;
                                font-weight: bold;
                                font-family: "Anton SC", sans-serif;
                                font-weight: 400;
                                font-style: italic;
                                text-align: right; /* Align school info to the right */
                            }
                            .info-container {
                                display: flex;
                                justify-content: space-between;
                            }
                            .academic-record {
                                margin-bottom: 5px;
                            }
                            
                            table {
                                width: 100%;
                                margin-bottom: 5px;
                                box-shadow: 0 0 10px rgba(0, 0, 255, 0.5); 
                                page-break-inside: auto; 
                                page-break-inside: avoid; 
                                /* Blue shadow border */
                            }
                        
                            .gpa-table {
                                width: 70%;
                                margin-bottom: 10px;
                                box-shadow: 0 0 10px rgba(0, 0, 255, 0.5); 
                                margin: 0 auto 10px auto; 
                                page-break-inside: avoid; 
                                page-break-inside: auto; 
                                /* Blue shadow border */
                            }
                            th {
                                font-weight: bold;
                                border: 1px solid #1D5B79;
                                padding: 5px;
                                font-size: 9px;
                                text-align: left;
                                page-break-inside: auto; 
                                page-break-inside: avoid; 
                            }
                            td {
                                font-family: Courier;
                                border: 1px solid #1D5B79;
                                padding: 8px;
                                font-size: 9px;
                                page-break-inside: auto; 
                                page-break-inside: avoid; 
                                text-align: left;
                            }
                            .extra-curricular-list {
                                font-size: 7px;
                                list-style-type: disc;
                                margin-left: 20px;
                            }
                            .principal-comment-signature {
                                    margin-top: 20px;
                                    margin-bottom: 5px;
                                }
                                .principal-comment-signature .signature {
                                    margin-top: 20px;
                                    text-align: center;
                                }

                                .footer {
                                margin-top: 20px;
                                margin-bottom: 5px;
                            }
                            .principal-comment-signature .signature {
                                margin-top: 20px;
                                text-align: left;
                            }
                            .page-break {
                                page-break-before: always;
                                
                                height: 0;
                            }
                        </style>
                        
                        <div class="transcript">
                            <div class="header">
                                <h2 style="font-family: 'Baskerville', cursive; font-size: 15px; color: #1D5B79">Transcript</h2>
                                <h3 style="font-family: 'Impact', cursive; font-size: 12px; color: #1D5B79">$school</h3>
                                <img src="$logoBase64" alt="School Logo" style="width: 50px; height: 50px;">
                            </div>
                            <div class="info-container">
                                    <div class="student-info">
                                        <p class="school-info"><strong>$region</strong></p>
                                        <p class="school-info"><strong>$district</strong></p>
                                        <p class="school-info"><strong>$address</strong></p>
                                        <p class="school-info"><strong>$phone_one $phone_two</strong></p>
                                        <p class="school-info"><strong>$email</strong></p>
                                        <p class="school-info"><strong>Date:</strong> $dt</p>
                                        <p class="oswald-uniquifier">
                                       
                                        <p class="oswald-uniquifier"><strong>Student ID:</strong> $stid</p>
                                        <p class="oswald-uniquifier"><strong>Student Name:</strong> $student_name</p>
                                        <p class="oswald-uniquifier"><strong>Date of Birth:</strong> $dob</p>
                                        <p class="oswald-uniquifier"><strong>Programme:</strong> $prog</p>
                                        <p class="oswald-uniquifier"><strong>Entry Date:</strong> $create_dt</p>
                                  
                                    </div>
                                </div>
                            <div class="academic-record">
                                <h3 class="oswald-uniquifier">Academic Records</h3>
                        HTML;

                        // Iterate through academic records for each term
                        foreach ($terms as $index => $term) {
                            $html .= <<<HTML
                                <!-- Page break before each table -->
                                <table>
                                    <thead>
                                        <tr>
                                            <th colspan="7" style="color: #9B0906; font-size: 7px;">Term: $term</th>
                                        </tr>
                                        <tr>
                                            <th colspan="7" style="color: #9B0906; font-size: 7px;">Class: $class[$index]</th>
                                        </tr>
                                        <tr style="font-size: 7px;">
                                            <th>Subject</th>
                                            <th>Total</th>
                                            <th>Grade</th>
                                            <th>Remark</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                            HTML;

                            $query = "SELECT DISTINCT A.SUBJECT, 
                                                    ROUND(C.CONST_ASS, 0) AS CA, 
                                                    ROUND(C.EXAM, 0) AS EXAM, 
                                                    ROUND(D.MARK,0) AS MARK, 
                                                    F.GRADE, 
                                                    F.INTERPRETATION,
                                                    C.TERM
                                        FROM WAEC_SUBJECT A 
                                        JOIN STUDENT_SUBJECT B ON A.SUB_CODE = B.SUB_CODE 
                                        JOIN STUDENT_EVALUATION C ON B.SUB_CODE = C.SUB_CODE AND B.STUD_ID = C.STUD_ID 
                                        JOIN STUDENT_CUMULATIVE D ON A.SUB_CODE = D.SUBJ_CODE AND D.STUD_ID = C.STUD_ID 
                                        JOIN STUDENT E ON D.STUD_ID = E.STUD_ID 
                                        JOIN GRADE F ON D.G_CODE = F.G_CODE 
                                        WHERE TRIM(C.STUD_ID) = TRIM('$student_id') 
                                            AND TRIM(D.STUD_ID) = TRIM('$student_id') 
                                            AND TRIM(B.STUD_ID) = TRIM('$student_id') 
                                            AND C.TERM = '$term' 
                                            AND D.TERM = '$term' 
                                            AND C.CONST_ASS+C.EXAM=D.MARK
                                            AND C.MARK_STATUS = 'ACCEPTED' 
                                        ORDER BY C.TERM, A.SUBJECT";

                            $sql = oci_parse($conn, $query);
                            oci_execute($sql);

                            while ($row = oci_fetch_array($sql)) {
                                $subject = $row['SUBJECT'];
                                $ca = $row['CA'];
                                $exam = $row['EXAM'];
                                $mark = $row['MARK'];
                                $grade = $row['GRADE'];
                                $remark = $row['INTERPRETATION'];

                                $html .= <<<HTML
                                    <tr>
                                        <td>$subject</td>
                                        <td>$mark</td>
                                        <td>$grade</td>
                                        <td>$remark</td>
                                    </tr>
                            HTML;
                            }

                            $html .= <<<HTML
                                </tbody>
                            </table>
                            HTML;
                            $html .= <<<HTML
                            <div class="gpa-table">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Term</th>
                                      
                                            <th>GPA</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                        HTML;
                            // Fetch and add GPA data
                            $getgpa = oci_parse($conn, "SELECT * FROM STUDENT_STANDINGS WHERE stud_id = '$student_id' and term = '$term' ");
                            oci_execute($getgpa);

                            while ($r = oci_fetch_array($getgpa)) {
                                $term = $r['TERM'];
                              
                                $gpa = $r['GPA'] / 1.00;

                                $html .= <<<HTML
                                        <tr>
                                            <td>$term</td>
                                           
                                            <td>$gpa</td>
                                        </tr>
                            HTML;
                            }

                            $html .= <<<HTML
                                    </tbody>
                                </table>
                            </div>
                            HTML;
                        }

                        $html .= <<<HTML
                        <div class="gpa-table">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>CGPA</th>
                                         
                                            <th>REMARK</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                        HTML;

                        // Fetch and add GPA data
                        $getgpa = oci_parse($conn, "SELECT ROUND(AVG(GPA),2) AS CGPA AS AVERAGE FROM STUDENT_STANDINGS  WHERE stud_id = '$student_id' ");
                        oci_execute($getgpa);

                        while ($r = oci_fetch_array($getgpa)) {
                            $term = $r['TERM'];
                       
                            $gpa = $r['CGPA'] / 1.00;

                            $getrm = oci_parse($conn, "SELECT * FROM GRADE A JOIN GPA B ON A.G_CODE = B.G_CODE WHERE B.GPA <= CAST($gpa AS INT) AND CAST($gpa AS INT) <= B.GPA");
                            oci_execute($getrm);
                            while ($r = oci_fetch_array($getrm)) {
                                $rm = $r['INTERPRETATION'];
                            }

                            $html .= <<<HTML
                                        <tr>
                                            <td>$gpa</td>
                                            <td>$cavg</td>
                                            <td>$rm</td>
                                        </tr>
                            HTML;
                        }
                        $html .= <<<HTML
                                            </tbody>
                                        </table>
                                    </div>
                           
                                   <div class="extra-curricular">
                                    <h3 class="oswald-uniquifier">Extra-Curricular Activities</h3>
                                    <p>
                                        <!-- Fetch and display extra-curricular activities -->
                                HTML;

                        // Query to fetch extracurricular activities
                        $activityQuery = "SELECT ACT FROM STUDENT_ACTIVITIES WHERE STUD_ID = '$student_id'";
                        $activitySql = oci_parse($conn, $activityQuery);
                        oci_execute($activitySql);

                        // Fetch activities and add to HTML
                        while ($activityRow = oci_fetch_array($activitySql)) {
                            $activity = $activityRow['ACT'];
                            $html .= "<p>$activity</p>";
                        }



                        $html .= <<<HTML
                                  
                                                </div>
                                                        <div class="student-responsibilities">
                                                            <h3 class="oswald-uniquifier">Student Responsibilities</h3>
                                                            <p>
                                            <!-- Fetch and display student responsibilities -->
                             HTML;

                        // Query to fetch student responsibilities
                        $responsibilityQuery = "SELECT A.RESPON, B.CLASS_TITLE FROM STUDENT_RESPON A JOIN CLASS B ON A.CLASS = B.CLASS WHERE A.STUD_ID = '$student_id' ";
                        $responsibilitySql = oci_parse($conn, $responsibilityQuery);
                        oci_execute($responsibilitySql);

                        // Fetch responsibilities and add to HTML
                        while ($responsibilityRow = oci_fetch_array($responsibilitySql)) {
                            $responsibility = $responsibilityRow['RESPON'];
                            $classTitle = $responsibilityRow['CLASS_TITLE'];
                            $html .= "<p><strong>$classTitle:</strong> $responsibility</p>";
                        }

                        $html .= <<<HTML
                                        </p>
                                        <div class="principal-comment-signature">
                            <h3>Principal's Signature:</h3>
                            <p>___________________</p>
                            <h3>School Stamp</h3>
                        </div>
                        
                                    </div>
                                 
                                    
                         <div class="gpa-table">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Letter Grade</th>
                                            <th>Grade Range</th>
                                            <th>Interpretation</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                        HTML;

                        // Fetch and add GPA data
                        $getgpa = oci_parse($conn, "SELECT * FROM GRADE A JOIN GRADE_SETTING B ON (A.G_CODE = B.G_CODE) ORDER BY END_GRADE_RANGE DESC");
                        oci_execute($getgpa);
                        while ($r = oci_fetch_array($getgpa)) {
                            $lg = $r['GRADE'];
                            $gr = $r['START_GRADE_RANGE'] . '-' . $r['END_GRADE_RANGE'];
                            $in = $r['INTERPRETATION'];

                            $html .= <<<HTML
                                        <tr>
                                            <td>$lg</td>
                                            <td>$gr</td>
                                            <td>$in</td>
                                        </tr>
                            HTML;
                        }
                        $html .= <<<HTML
                                    </tbody>
                                </table>
                            </div>
                            <div class="gpa-table">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Letter Grade</th>
                                            <th>GPA</th>
                                            <th>Interpretation</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                        HTML;

                        // Fetch and add GPA data
                        $getgpa = oci_parse($conn, "SELECT * FROM GRADE A JOIN GPA  B ON (A.G_CODE = B.G_CODE) ORDER BY GPA DESC");
                        oci_execute($getgpa);
                        while ($r = oci_fetch_array($getgpa)) {
                            $lg = $r['GRADE'];
                            $gr = $r['GPA'] / 1.00;
                            $in = $r['INTERPRETATION'];

                            $html .= <<<HTML
                                        <tr>
                                            <td>$lg</td>
                                            <td>$gr</td>
                                            <td>$in</td>
                                        </tr>
                            HTML;
                        }
                        $html .= <<<HTML
                                        </tbody>
                                    </table>
                      
                    
                        </div>
                        <div class="footer" style="font-size: 12px; color: #1D5B79; text-align: center; width: 100%;">
                                <p style="font-size: 8px; color: #1D5B79;">Thank You For Being Part Of $school</p>
                                <p style="font-size: 8px; color: #1D5B79;">Developed and Powered By Nifty ICT Solutions Ltd</p>
                                <p style="font-size: 8px; color: #1D5B79;">Phone: +2209067411 | +2203553291 Website: www.niftyict.com | Email: enquiries@niftyict.com</p>
                         </div>
                        HTML;

                        $dompdf = new Dompdf();
                        $dompdf->loadHtml($html);

                        // (Optional) Setup the paper size and orientation
                        $dompdf->setPaper('A4', 'portrait');

                        // Render the HTML as PDF
                        $dompdf->render();

                        $filename = strtoupper(trim($stid) . '_' . $student_name);
                        $filePath = 'D:/Senior/Transcript/TRANSCRIPT_' . $filename . '.pdf';
                        file_put_contents($filePath, $dompdf->output());
                        $_SESSION['school'] = $school;
                        $_SESSION['class_name'] = $class_name;

                        $_SESSION['path'] = $filePath;
                        $_SESSION['filename'] = $filename . '.pdf';

                        $_SESSION['redirect'] = 'transcript.php';
                        header('Location: download_pdf.php');
                        // Success message
                        echo '<script>
    Swal.fire({
    position: "center",
    icon: "success",
    title: "TRANSCRIPT GENERATED SUCCESSFULLY",
    showConfirmButton: false,
    timer: 1500
    });
    </script>';
                        header("refresh:2;");
                    } else {
                        // No academic records found message
                        echo '<script>
    Swal.fire({
    position: "center",
    icon: "warning",
    title: "NO ACADEMIC RECORDS FOR THIS STUDENT",
    showConfirmButton: false,
    timer: 1500
    });
    </script>';
                        header("refresh:2;");
                    }
                } else {
                    // No student records found message
                    echo '<script>
    Swal.fire({
    position: "center",
    icon: "warning",
    title: "NO STUDENT RECORDS FOR STUDENT",
    showConfirmButton: false,
    timer: 1500
    });
    </script>';
                    header("refresh:2;");
                }
            } else {
                echo "<script> Swal.fire({
                        title: 'ENTER PRINCIPAL COMMENTS',
                        icon: 'warning',
                        showConfirmButton: true
                    });</script>";
            }
        } else {
            echo "<script> Swal.fire({
                    title: 'SELECT STUDENT',
                    icon: 'warning',
                    showConfirmButton: true
                });</script>";
        }
    }

    if (isset($_POST['save_resp_btn'])) {
        if (isset($_POST['select_existstudent'])) {
            if (isset($_POST['class'])) {
                if ($_POST['stu_resp'] != '') {
                    $sql = oci_parse($conn, "SELECT * FROM STUDENT_RESPON WHERE CLASS =:CLASS AND STUD_ID =:ID ");
                    oci_bind_by_name($sql, ":CLASS", $_POST['class']);
                    oci_bind_by_name($sql, ":ID", $_POST['select_existstudent']);
                    oci_execute($sql);
                    if (oci_fetch_all($sql, $a) > 0) {
                        $sql = oci_parse($conn, "UPDATE STUDENT_RESPON SET RESPON=:RESPON WHERE CLASS =:CLASS AND STUD_ID =:ID ");
                        oci_bind_by_name($sql, ":CLASS", $_POST['class']);
                        oci_bind_by_name($sql, ":ID", $_POST['select_existstudent']);
                        $respon = strtoupper($_POST['stu_resp']);
                        oci_bind_by_name($sql, ":RESPON", $respon);
                        if (oci_execute($sql)) {
                            echo "<script> Swal.fire({
                                    title: 'STUDENT RESPONSIBILITIES RECORD SAVED SUCCESSFULLY',
                                    icon: 'success',
                                    showConfirmButton: true
                                });</script>";
                        } else {
                            echo "<script> Swal.fire({
                                    title: 'ERROR SAVING STUDENT RESPONSIBILITY',
                                    icon: 'warning',
                                    showConfirmButton: true
                                });</script>";
                        }
                    } else {
                        $sql = oci_parse($conn, "INSERT INTO STUDENT_RESPON (S_ID,STUD_ID,RESPON,CLASS) VALUES (:SID,:ID,:RESPON,:CLASS)");
                        oci_bind_by_name($sql, ":CLASS", $_POST['class']);
                        oci_bind_by_name($sql, ":ID", $_POST['select_existstudent']);
                        $respon = strtoupper($_POST['stu_resp']);
                        oci_bind_by_name($sql, ":RESPON", $respon);
                        oci_bind_by_name($sql, ":SID", $sid);
                        if (oci_execute($sql)) {
                            echo "<script> Swal.fire({
                                    title: 'STUDENT RESPONSIBILITIES RECORD SAVED SUCCESSFULLY',
                                    icon: 'success',
                                    showConfirmButton: true
                                });</script>";
                        } else {
                            echo "<script> Swal.fire({
                                title: 'ERROR SAVING STUDENT RESPONSIBILITY',
                                icon: 'warning',
                                showConfirmButton: true
                            });</script>";
                        }
                    }
                } else {
                    echo "<script> Swal.fire({
                            title: 'ENTER STUDENT RESPONSIBILITY',
                            icon: 'warning',
                            showConfirmButton: true
                        });</script>";
                }
            } else {
                echo "<script> Swal.fire({
                    title: 'SELECT CLASS',
                    icon: 'warning',
                    showConfirmButton: true
                });</script>";
            }
        } else {
            echo "<script> Swal.fire({
                title: 'SELECT STUDENT',
                icon: 'warning',
                showConfirmButton: true
            });</script>";
        }
    }
    if (isset($_POST['save_act_btn'])) {
        if (isset($_POST['select_existstudent'])) {
            if (($_POST['stu_act']) != '') {
                $sql = oci_parse($conn, "SELECT * FROM STUDENT_ACTIVITIES WHERE STUD_ID = :ID ");
                oci_bind_by_name($sql, ":ID", $_POST['select_existstudent']);
                oci_execute($sql);
                if (oci_fetch_all($sql, $a) > 0) {
                    $sql = oci_parse($conn, "UPDATE STUDENT_ACTIVITIES SET ACT =:ACT WHERE STUD_ID =:ID ");
                    oci_bind_by_name($sql, ":ID", $_POST['select_existstudent']);
                    $act = strtoupper($_POST['stu_act']);
                    oci_bind_by_name($sql, ":ACT", $act);
                    if (oci_execute($sql)) {
                        echo "<script> Swal.fire({
                        title: 'STUDENT ACTIVITIES RECORD SAVED SUCCESSFULLY',
                        icon: 'success',
                        showConfirmButton: true
                    });</script>";
                    } else {
                        echo "<script> Swal.fire({
                        title: 'ERROR ADDING STUDENT ACTIVITIES RECORD',
                        icon: 'error',
                        showConfirmButton: true
                    });</script>";
                    }
                } else {
                    $sql = oci_parse($conn, "INSERT INTO STUDENT_ACTIVITIES (S_ID,STUD_ID,ACT) VALUES (:S_ID,:ID,:ACT) ");
                    oci_bind_by_name($sql, ":ID", $_POST['select_existstudent']);
                    $act = strtoupper($_POST['stu_act']);
                    oci_bind_by_name($sql, ":ACT", $act);
                    oci_bind_by_name($sql, ":S_ID", $sid);
                    if (oci_execute($sql)) {
                        echo "<script> Swal.fire({
                      title: 'STUDENT ACTIVITIES RECORD SAVED SUCCESSFULLY',
                      icon: 'success',
                      showConfirmButton: true
                  });</script>";
                    } else {
                        echo "<script> Swal.fire({
                      title: 'ERROR ADDING STUDENT ACTIVITIES RECORD',
                      icon: 'error',
                      showConfirmButton: true
                  });</script>";
                    }
                }
            } else {
                echo "<script> Swal.fire({
                    title: 'ENTER STUDENT ACTIVITIES',
                    icon: 'warning',
                    showConfirmButton: true
                });</script>";
            }
        } else {
            echo "<script> Swal.fire({
                title: 'SELECT STUDENT',
                icon: 'warning',
                showConfirmButton: true
            });</script>";
        }
    }

    if (isset($_POST['save_btn'])) {

        if (isset($_POST['select_exist_student'])) {
            $id = strtoupper(trim($_POST['select_exist_student']));
            if (isset($_POST['select_term'])) {
                if (isset($_POST['select_class'])) {
                    if (isset($_POST['select_subject'])) {
                        if ($_POST['mark'] != '') {
                            $mark = floatval($_POST['mark']);
                            $emp_id = 20240726221;
                            $ca = $mark * 0.3;
                            $exam = $mark * 0.7;
                            $total = $exam + $ca;

                            $sql = oci_parse($conn, "SELECT * FROM TERM_CALENDAR WHERE TERM =:TERM");
                            oci_bind_by_name($sql, ":TERM", $_POST['select_term']);
                            oci_execute($sql);

                            while ($get = oci_fetch_array($sql)) {
                                $acad_year = $get['ACADEMIC_YEAR'];
                            }

                            $sql = oci_parse($conn, "SELECT * FROM STUDENT_EVALUATION WHERE SUB_CODE=:SUB_CODE AND CLASS_CODE =:CLASS_CODE AND STUD_ID=:ID AND TERM =:TERM");
                            oci_bind_by_name($sql, ":CLASS_CODE", $_POST['select_class']);
                            oci_bind_by_name($sql, ":ID", $id);
                            oci_bind_by_name($sql, ":SUB_CODE", $_POST['select_subject']);
                            oci_bind_by_name($sql, ":TERM", $_POST['select_term']);
                            oci_execute($sql);
                            if (oci_fetch_all($sql, $a) > 0) {
                                $sql = oci_parse($conn, "UPDATE STUDENT_EVALUATION SET CONST_ASS = :CA,EXAM=:EXAM, ENTRY_DT = SYSDATE,EMP_ID=:EMP_ID WHERE SUB_CODE=:SUB_CODE AND CLASS_CODE =:CLASS_CODE AND STUD_ID=:ID AND TERM =:TERM ");
                                oci_bind_by_name($sql, ":CLASS_CODE", $_POST['select_class']);
                                oci_bind_by_name($sql, ":ID", $id);
                                oci_bind_by_name($sql, ":SUB_CODE", $_POST['select_subject']);
                                oci_bind_by_name($sql, ":TERM", $_POST['select_term']);
                                oci_bind_by_name($sql, ":EMP_ID", $emp_id);
                                oci_bind_by_name($sql, ":CA", $ca);
                                oci_bind_by_name($sql, ":EXAM", $exam);
                                if (oci_execute($sql)) {

                                    $getgrade = oci_parse($conn, "SELECT * FROM GRADE A JOIN GRADE_SETTING B ON A.G_CODE = B.G_CODE WHERE B.START_GRADE_RANGE <= CAST($total AS INT) AND CAST($total AS INT) <= B.END_GRADE_RANGE  ORDER BY A.GRADE");
                                    oci_execute($getgrade);

                                    while ($b = oci_fetch_array($getgrade)) {
                                        $g_code = $b["G_CODE"];
                                        $grade = $b["GRADE"];
                                    }

                                    $sql = oci_parse($conn, "SELECT * FROM STUDENT_CUMULATIVE WHERE SUBJ_CODE=:SUB_CODE AND SUB_CODE =:CLASS_CODE AND STUD_ID=:ID AND TERM =:TERM");
                                    oci_bind_by_name($sql, ":CLASS_CODE", $_POST['select_class']);
                                    oci_bind_by_name($sql, ":ID", $id);
                                    oci_bind_by_name($sql, ":SUB_CODE", $_POST['select_subject']);
                                    oci_bind_by_name($sql, ":TERM", $_POST['select_term']);
                                    oci_execute($sql);

                                    if (oci_fetch_all($sql, $a) > 0) {
                                        $sql = oci_parse($conn, "UPDATE STUDENT_CUMULATIVE SET MARK =:MARK,ENTRY_DT = SYSDATE, G_CODE= :G_CODE WHERE SUBJ_CODE=:SUB_CODE AND SUB_CODE =:CLASS_CODE AND STUD_ID=:ID AND TERM =:TERM");
                                        oci_bind_by_name($sql, ":CLASS_CODE", $_POST['select_class']);
                                        oci_bind_by_name($sql, ":ID", $id);
                                        oci_bind_by_name($sql, ":SUB_CODE", $_POST['select_subject']);
                                        oci_bind_by_name($sql, ":TERM", $_POST['select_term']);
                                        oci_bind_by_name($sql, ":MARK", $total);
                                        oci_bind_by_name($sql, ":G_CODE", $g_code);

                                        if (oci_execute($sql)) {
                                            $sql = oci_parse($conn, "SELECT * FROM STUDENT_STANDINGS WHERE TERM = :TERM AND STUD_ID = :ID AND CLASS_CODE =:CLASS_CODE");
                                            oci_bind_by_name($sql, ":ID", $id);
                                            oci_bind_by_name($sql, ":TERM", $_POST['select_term']);
                                            oci_bind_by_name($sql, ":CLASS_CODE", $_POST['select_class']);

                                            oci_execute($sql);
                                            if (oci_fetch_all($sql, $a) > 0) {
                                                $sql = oci_parse($conn, "SELECT ROUND(AVG(MARK),2) AS AVERAGE FROM STUDENT_CUMULATIVE WHERE TERM = :TERM AND STUD_ID = :ID AND SUB_CODE =:CLASS_CODE");
                                                oci_bind_by_name($sql, ":ID", $id);
                                                oci_bind_by_name($sql, ":TERM", $_POST['select_term']);
                                                oci_bind_by_name($sql, ":CLASS_CODE", $_POST['select_class']);
                                                oci_execute($sql);
                                                while ($get = oci_fetch_array($sql)) {
                                                    $avg = $get['AVERAGE'];
                                                }
                                                $getgrade = oci_parse($conn, "SELECT * FROM GRADE A JOIN GRADE_SETTING B ON A.G_CODE = B.G_CODE WHERE B.START_GRADE_RANGE <= CAST($avg AS INT) AND CAST($avg AS INT) <= B.END_GRADE_RANGE  ORDER BY A.GRADE");
                                                oci_execute($getgrade);

                                                while ($b = oci_fetch_array($getgrade)) {
                                                    $g_code = $b["G_CODE"];
                                                    $grade = $b["GRADE"];
                                                }

                                                $sql = oci_parse($conn, "SELECT * FROM GPA WHERE G_CODE = :G_CODE");
                                                oci_bind_by_name($sql, ":G_CODE", $g_code);
                                                oci_execute($sql);
                                                while ($get = oci_fetch_array($sql)) {
                                                    $gpa = $get['GPA'];
                                                }
                                                $sql = oci_parse($conn, "UPDATE STUDENT_STANDINGS SET GPA = :GPA , AVERAGE=:AVERAGE WHERE STUD_ID=:ID AND TERM =:TERM AND CLASS_CODE =:CLASS_CODE ");
                                                oci_bind_by_name($sql, ":GPA", $gpa);
                                                oci_bind_by_name($sql, ":AVERAGE", $avg);
                                                oci_bind_by_name($sql, ":CLASS_CODE", $_POST['select_class']);
                                                oci_bind_by_name($sql, ":ID", $id);
                                                oci_bind_by_name($sql, ":TERM", $_POST['select_term']);
                                                if (oci_execute($sql)) {
                                                    echo "<script> Swal.fire({
                                                        title: 'RECORD SAVED SUCCESSFULLY',
                                                        icon: 'success',
                                                        showConfirmButton: true
                                                    });</script>";
                                                } else {
                                                    echo "<script> Swal.fire({
                                                        title: 'ERROR SAVING RECORD',
                                                        icon: 'error',
                                                        showConfirmButton: true
                                                    });</script>";
                                                }
                                            } else {
                                                $sql = oci_parse($conn, "SELECT ROUND(AVG(MARK),2) AS AVERAGE FROM STUDENT_CUMULATIVE WHERE TERM = :TERM AND STUD_ID = :ID AND SUB_CODE =:CLASS_CODE");
                                                oci_bind_by_name($sql, ":ID", $id);
                                                oci_bind_by_name($sql, ":TERM", $_POST['select_term']);
                                                oci_bind_by_name($sql, ":CLASS_CODE", $_POST['select_class']);
                                                oci_execute($sql);
                                                while ($get = oci_fetch_array($sql)) {
                                                    $avg = $get['AVERAGE'];
                                                }

                                                $getgrade = oci_parse($conn, "SELECT * FROM GRADE A JOIN GRADE_SETTING B ON A.G_CODE = B.G_CODE WHERE B.START_GRADE_RANGE <= CAST($avg AS INT) AND CAST($avg AS INT) <= B.END_GRADE_RANGE  ORDER BY A.GRADE");
                                                oci_execute($getgrade);

                                                while ($b = oci_fetch_array($getgrade)) {
                                                    $g_code = $b["G_CODE"];
                                                    $grade = $b["GRADE"];
                                                }

                                                $sql = oci_parse($conn, "SELECT * FROM GPA WHERE G_CODE = :G_CODE");
                                                oci_bind_by_name($sql, ":G_CODE", $g_code);
                                                oci_execute($sql);
                                                while ($get = oci_fetch_array($sql)) {
                                                    $gpa = $get['GPA'];
                                                }

                                                $sql = oci_parse($conn, "INSERT INTO STUDENT_STANDINGS (CLASS_CODE,GPA,STUD_ID,TERM,ACADEMIC_YEAR,S_ID,STATUS) VALUES (:CLASS_CODE,:GPA,:ID,:TERM,:A_Y,:S_ID,'COMPILED')");
                                                oci_bind_by_name($sql, ":GPA", $gpa);
                                           
                                                oci_bind_by_name($sql, ":CLASS_CODE", $_POST['select_class']);
                                                oci_bind_by_name($sql, ":ID", $id);
                                                oci_bind_by_name($sql, ":S_ID", $sid);
                                                oci_bind_by_name($sql, ":TERM", $_POST['select_term']);
                                                oci_bind_by_name($sql, ":A_Y", $acad_year);
                                                if (oci_execute($sql)) {
                                                    echo "<script> Swal.fire({
                                                        title: 'RECORD SAVED SUCCESSFULLY',
                                                        icon: 'success',
                                                        showConfirmButton: true
                                                    });</script>";
                                                } else {
                                                    echo "<script> Swal.fire({
                                                        title: 'ERROR SAVING RECORD',
                                                        icon: 'error',
                                                        showConfirmButton: true
                                                    });</script>";
                                                }
                                            }
                                        } else {
                                            echo "<script> Swal.fire({
                                                title: 'ERROR SAVING RECORD',
                                                icon: 'error',
                                                showConfirmButton: true
                                            });</script>";
                                        }
                                    } else {
                                        $getgrade = oci_parse($conn, "SELECT * FROM GRADE A JOIN GRADE_SETTING B ON A.G_CODE = B.G_CODE WHERE B.START_GRADE_RANGE <= CAST($total AS INT) AND CAST($total AS INT) <= B.END_GRADE_RANGE  ORDER BY A.GRADE");
                                        oci_execute($getgrade);

                                        while ($b = oci_fetch_array($getgrade)) {
                                            $g_code = $b["G_CODE"];
                                            $grade = $b["GRADE"];
                                        }
                                        $sql = oci_parse($conn, "INSERT INTO STUDENT_CUMULATIVE(S_ID,SUB_CODE,G_CODE,SUBJ_CODE,ACADEMIC_YEAR,TERM,STUD_ID,MARK,ENTRY_DT) VALUES (:S_ID,:CLASS_CODE,:G_CODE,:SUB_CODE,:A_Y,:TERM,:STUD_ID,:MARK,SYSDATE)");
                                        oci_bind_by_name($sql, ":CLASS_CODE", $_POST['select_class']);
                                        oci_bind_by_name($sql, ":STUD_ID", $id);
                                        oci_bind_by_name($sql, ":SUB_CODE", $_POST['select_subject']);
                                        oci_bind_by_name($sql, ":TERM", $_POST['select_term']);
                                        oci_bind_by_name($sql, ":A_Y", $acad_year);
                                        oci_bind_by_name($sql, ":MARK", $total);
                                        oci_bind_by_name($sql, ":G_CODE", $g_code);
                                        oci_bind_by_name($sql, ":G_CODE", $g_code);
                                        oci_bind_by_name($sql, ":S_ID", $sid);
                                        if (oci_execute($sql)) {
                                            $sql = oci_parse($conn, "SELECT * FROM STUDENT_STANDINGS WHERE TERM = :TERM AND STUD_ID = :ID AND CLASS_CODE =:CLASS_CODE");
                                            oci_bind_by_name($sql, ":ID", $id);
                                            oci_bind_by_name($sql, ":TERM", $_POST['select_term']);
                                            oci_bind_by_name($sql, ":CLASS_CODE", $_POST['select_class']);

                                            oci_execute($sql);
                                            if (oci_fetch_all($sql, $a) > 0) {
                                                $sql = oci_parse($conn, "SELECT ROUND(AVG(MARK),2) AS AVERAGE FROM STUDENT_CUMULATIVE WHERE TERM = :TERM AND STUD_ID = :ID AND SUB_CODE =:CLASS_CODE ");
                                                oci_bind_by_name($sql, ":ID", $id);
                                                oci_bind_by_name($sql, ":TERM", $_POST['select_term']);
                                                oci_bind_by_name($sql, ":CLASS_CODE", $_POST['select_class']);
                                                oci_execute($sql);
                                                while ($get = oci_fetch_array($sql)) {
                                                    $avg = $get['AVERAGE'];
                                                }
                                                $getgrade = oci_parse($conn, "SELECT * FROM GRADE A JOIN GRADE_SETTING B ON A.G_CODE = B.G_CODE WHERE B.START_GRADE_RANGE <= CAST($avg AS INT) AND CAST($avg AS INT) <= B.END_GRADE_RANGE  ORDER BY A.GRADE");
                                                oci_execute($getgrade);

                                                while ($b = oci_fetch_array($getgrade)) {
                                                    $g_code = $b["G_CODE"];
                                                    $grade = $b["GRADE"];
                                                }

                                                $sql = oci_parse($conn, "SELECT * FROM GPA WHERE G_CODE = :G_CODE");
                                                oci_bind_by_name($sql, ":G_CODE", $g_code);
                                                oci_execute($sql);
                                                while ($get = oci_fetch_array($sql)) {
                                                    $gpa = $get['GPA'];
                                                }

                                                $sql = oci_parse($conn, "UPDATE STUDENT_STANDINGS SET GPA = :GPA  WHERE STUD_ID=:ID AND TERM =:TERM AND CLASS_CODE =:CLASS_CODE ");
                                                oci_bind_by_name($sql, ":GPA", $gpa);
                                            
                                                oci_bind_by_name($sql, ":CLASS_CODE", $_POST['select_class']);
                                                oci_bind_by_name($sql, ":ID", $id);
                                                oci_bind_by_name($sql, ":TERM", $_POST['select_term']);
                                                if (oci_execute($sql)) {
                                                    echo "<script> Swal.fire({
                                                        title: 'RECORD SAVED SUCCESSFULLY',
                                                        icon: 'success',
                                                        showConfirmButton: true
                                                    });</script>";
                                                } else {
                                                    echo "<script> Swal.fire({
                                                        title: 'ERROR SAVING RECORD',
                                                        icon: 'error',
                                                        showConfirmButton: true
                                                    });</script>";
                                                }
                                            } else {
                                                $sql = oci_parse($conn, "SELECT ROUND(AVG(MARK),2) AS AVERAGE FROM STUDENT_CUMULATIVE WHERE TERM = :TERM AND STUD_ID = :ID AND SUB_CODE =:CLASS_CODE");
                                                oci_bind_by_name($sql, ":ID", $id);
                                                oci_bind_by_name($sql, ":TERM", $_POST['select_term']);
                                                oci_bind_by_name($sql, ":CLASS_CODE", $_POST['select_class']);
                                                oci_execute($sql);
                                                while ($get = oci_fetch_array($sql)) {
                                                    $avg = $get['AVERAGE'];
                                                }
                                                $getgrade = oci_parse($conn, "SELECT * FROM GRADE A JOIN GRADE_SETTING B ON A.G_CODE = B.G_CODE WHERE B.START_GRADE_RANGE <= CAST($avg AS INT) AND CAST($avg AS INT) <= B.END_GRADE_RANGE  ORDER BY A.GRADE");
                                                oci_execute($getgrade);

                                                while ($b = oci_fetch_array($getgrade)) {
                                                    $g_code = $b["G_CODE"];
                                                    $grade = $b["GRADE"];
                                                }

                                                $sql = oci_parse($conn, "SELECT * FROM GPA WHERE G_CODE = :G_CODE");
                                                oci_bind_by_name($sql, ":G_CODE", $g_code);
                                                oci_execute($sql);
                                                while ($get = oci_fetch_array($sql)) {
                                                    $gpa = $get['GPA'];
                                                }

                                                $sql = oci_parse($conn, "INSERT INTO STUDENT_STANDINGS (CLASS_CODE,GPA,AVERAGE,STUD_ID,TERM,ACADEMIC_YEAR,S_ID,STATUS) VALUES (:CLASS_CODE,:GPA,:AVERAGE,:ID,:TERM,:A_Y,:S_ID,'COMPILED')");
                                                oci_bind_by_name($sql, ":GPA", $gpa);
                                                oci_bind_by_name($sql, ":AVERAGE", $avg);
                                                oci_bind_by_name($sql, ":CLASS_CODE", $_POST['select_class']);
                                                oci_bind_by_name($sql, ":ID", $id);
                                                oci_bind_by_name($sql, ":S_ID", $sid);
                                                oci_bind_by_name($sql, ":TERM", $_POST['select_term']);
                                                oci_bind_by_name($sql, ":A_Y", $acad_year);
                                                if (oci_execute($sql)) {
                                                    echo "<script> Swal.fire({
                                                        title: 'RECORD SAVED SUCCESSFULLY',
                                                        icon: 'success',
                                                        showConfirmButton: true
                                                    });</script>";
                                                } else {
                                                    echo "<script> Swal.fire({
                                                        title: 'ERROR SAVING RECORD',
                                                        icon: 'error',
                                                        showConfirmButton: true
                                                    });</script>";
                                                }
                                            }
                                        }
                                    }
                                } else {
                                    echo "<script> Swal.fire({
                                                    title: 'ERROR SAVING RECORD',
                                                    icon: 'error',
                                                    showConfirmButton: true
                                                });</script>";
                                }
                            } else {
                                $sql = oci_parse($conn, "INSERT INTO STUDENT_EVALUATION (S_ID,SUB_CODE,STUD_ID,EMP_ID,ACADEMIC_YEAR,TERM,CONST_ASS,EXAM,ENTRY_DT,CLASS_CODE,MARK_STATUS) 
                                     VALUES (:S_ID,:SUB_CODE,:ID,:EMP_ID,:A_Y,:TERM,:CA,:EXAM,SYSDATE,:CLASS_CODE,'ACCEPTED')");
                                oci_bind_by_name($sql, ":ID", $id);
                                oci_bind_by_name($sql, ":S_ID", $sid);
                                oci_bind_by_name($sql, ":TERM", $_POST['select_term']);
                                oci_bind_by_name($sql, ":A_Y", $acad_year);
                                oci_bind_by_name($sql, ":EMP_ID", $emp_id);
                                oci_bind_by_name($sql, ":CA", $ca);
                                oci_bind_by_name($sql, ":EXAM", $exam);
                                oci_bind_by_name($sql, ":CLASS_CODE", $_POST['select_class']);
                                oci_bind_by_name($sql, ":SUB_CODE", $_POST['select_subject']);
                                if (oci_execute($sql)) {
                                    $getgrade = oci_parse($conn, "SELECT * FROM GRADE A JOIN GRADE_SETTING B ON A.G_CODE = B.G_CODE WHERE B.START_GRADE_RANGE <= CAST($total AS INT) AND CAST($total AS INT) <= B.END_GRADE_RANGE  ORDER BY A.GRADE");
                                    oci_execute($getgrade);

                                    while ($b = oci_fetch_array($getgrade)) {
                                        $g_code = $b["G_CODE"];
                                        $grade = $b["GRADE"];
                                    }
                                    $sql = oci_parse($conn, "INSERT INTO STUDENT_CUMULATIVE(S_ID,SUB_CODE,G_CODE,SUBJ_CODE,ACADEMIC_YEAR,TERM,STUD_ID,MARK,ENTRY_DT) VALUES (:S_ID,:CLASS_CODE,:G_CODE,:SUB_CODE,:A_Y,:TERM,:STUD_ID,:MARK,SYSDATE)");
                                    oci_bind_by_name($sql, ":CLASS_CODE", $_POST['select_class']);
                                    oci_bind_by_name($sql, ":STUD_ID", $id);
                                    oci_bind_by_name($sql, ":SUB_CODE", $_POST['select_subject']);
                                    oci_bind_by_name($sql, ":TERM", $_POST['select_term']);
                                    oci_bind_by_name($sql, ":A_Y", $acad_year);
                                    oci_bind_by_name($sql, ":MARK", $total);
                                    oci_bind_by_name($sql, ":G_CODE", $g_code);
                                    oci_bind_by_name($sql, ":S_ID", $sid);
                                    if (oci_execute($sql)) {
                                        $sql = oci_parse($conn, "SELECT * FROM STUDENT_STANDINGS WHERE TERM = :TERM AND STUD_ID = :ID AND CLASS_CODE =:CLASS_CODE");
                                        oci_bind_by_name($sql, ":ID", $id);
                                        oci_bind_by_name($sql, ":TERM", $_POST['select_term']);
                                        oci_bind_by_name($sql, ":CLASS_CODE", $_POST['select_class']);

                                        oci_execute($sql);
                                        if (oci_fetch_all($sql, $a) > 0) {
                                            $sql = oci_parse($conn, "SELECT ROUND(AVG(MARK),2) AS AVERAGE FROM STUDENT_CUMULATIVE WHERE TERM = :TERM AND STUD_ID = :ID AND SUB_CODE =:CLASS_CODE ");
                                            oci_bind_by_name($sql, ":ID", $id);
                                            oci_bind_by_name($sql, ":TERM", $_POST['select_term']);
                                            oci_bind_by_name($sql, ":CLASS_CODE", $_POST['select_class']);
                                            oci_execute($sql);
                                            while ($get = oci_fetch_array($sql)) {
                                                $avg = $get['AVERAGE'];
                                            }
                                            $getgrade = oci_parse($conn, "SELECT * FROM GRADE A JOIN GRADE_SETTING B ON A.G_CODE = B.G_CODE WHERE B.START_GRADE_RANGE <= CAST($avg AS INT) AND CAST($avg AS INT) <= B.END_GRADE_RANGE  ORDER BY A.GRADE");
                                            oci_execute($getgrade);

                                            while ($b = oci_fetch_array($getgrade)) {
                                                $g_code = $b["G_CODE"];
                                                $grade = $b["GRADE"];
                                            }

                                            $sql = oci_parse($conn, "SELECT * FROM GPA WHERE G_CODE = :G_CODE");
                                            oci_bind_by_name($sql, ":G_CODE", $g_code);
                                            oci_execute($sql);
                                            while ($get = oci_fetch_array($sql)) {
                                                $gpa = $get['GPA'];
                                            }

                                            $sql = oci_parse($conn, "UPDATE STUDENT_STANDINGS SET GPA = :GPA , AVERAGE=:AVERAGE WHERE STUD_ID=:ID AND TERM =:TERM AND CLASS_CODE =:CLASS_CODE ");
                                            oci_bind_by_name($sql, ":GPA", $gpa);
                                            oci_bind_by_name($sql, ":AVERAGE", $avg);
                                            oci_bind_by_name($sql, ":CLASS_CODE", $_POST['select_class']);
                                            oci_bind_by_name($sql, ":ID", $id);
                                            oci_bind_by_name($sql, ":TERM", $_POST['select_term']);
                                            if (oci_execute($sql)) {
                                                echo "<script> Swal.fire({
                                                            title: 'RECORD SAVED SUCCESSFULLY',
                                                            icon: 'success',
                                                            showConfirmButton: true
                                                        });</script>";
                                            } else {
                                                echo "<script> Swal.fire({
                                                            title: 'ERROR SAVING RECORD',
                                                            icon: 'error',
                                                            showConfirmButton: true
                                                        });</script>";
                                            }
                                        } else {
                                            $sql = oci_parse($conn, "SELECT ROUND(AVG(MARK),2) AS AVERAGE FROM STUDENT_CUMULATIVE WHERE TERM = :TERM AND STUD_ID = :ID AND SUB_CODE =:CLASS_CODE");
                                            oci_bind_by_name($sql, ":ID", $id);
                                            oci_bind_by_name($sql, ":TERM", $_POST['select_term']);
                                            oci_bind_by_name($sql, ":CLASS_CODE", $_POST['select_class']);
                                            oci_execute($sql);
                                            while ($get = oci_fetch_array($sql)) {
                                                $avg = $get['AVERAGE'];
                                            }
                                            $getgrade = oci_parse($conn, "SELECT * FROM GRADE A JOIN GRADE_SETTING B ON A.G_CODE = B.G_CODE WHERE B.START_GRADE_RANGE <= CAST($avg AS INT) AND CAST($avg AS INT) <= B.END_GRADE_RANGE  ORDER BY A.GRADE");
                                            oci_execute($getgrade);

                                            while ($b = oci_fetch_array($getgrade)) {
                                                $g_code = $b["G_CODE"];
                                                $grade = $b["GRADE"];
                                            }

                                            $sql = oci_parse($conn, "SELECT * FROM GPA WHERE G_CODE = :G_CODE");
                                            oci_bind_by_name($sql, ":G_CODE", $g_code);
                                            oci_execute($sql);
                                            while ($get = oci_fetch_array($sql)) {
                                                $gpa = $get['GPA'];
                                            }

                                            $sql = oci_parse($conn, "INSERT INTO STUDENT_STANDINGS (CLASS_CODE,GPA,AVERAGE,STUD_ID,TERM,ACADEMIC_YEAR,S_ID,STATUS) VALUES (:CLASS_CODE,:GPA,:AVERAGE,:ID,:TERM,:A_Y,:S_ID,'COMPILED')");
                                            oci_bind_by_name($sql, ":GPA", $gpa);
                                            oci_bind_by_name($sql, ":AVERAGE", $avg);
                                            oci_bind_by_name($sql, ":CLASS_CODE", $_POST['select_class']);
                                            oci_bind_by_name($sql, ":ID", $id);
                                            oci_bind_by_name($sql, ":S_ID", $sid);
                                            oci_bind_by_name($sql, ":TERM", $_POST['select_term']);
                                            oci_bind_by_name($sql, ":A_Y", $acad_year);
                                            if (oci_execute($sql)) {
                                                echo "<script> Swal.fire({
                                                            title: 'RECORD SAVED SUCCESSFULLY',
                                                            icon: 'success',
                                                            showConfirmButton: true
                                                        });</script>";
                                            } else {
                                                echo "<script> Swal.fire({
                                                            title: 'ERROR SAVING RECORD',
                                                            icon: 'error',
                                                            showConfirmButton: true
                                                        });</script>";
                                            }
                                        }
                                    }
                                } else {
                                    echo "<script> Swal.fire({
                                                title: 'ERROR SAVING RECORD',
                                                icon: 'error',
                                                showConfirmButton: true
                                            });</script>";
                                }
                            }
                        } else {
                            echo "<script> Swal.fire({
                                                    title: 'ENTER MARK',
                                                    icon: 'warning',
                                                    showConfirmButton: true
                                                });</script>";
                        }
                    } else {
                        echo "<script> Swal.fire({
                                            title: 'SELECT SUBJECT',
                                            icon: 'warning',
                                            showConfirmButton: true
                                        });</script>";
                    }
                } else {
                    echo "<script> Swal.fire({
                                title: 'SELECT CLASS',
                                icon: 'warning',
                                showConfirmButton: true
                            });</script>";
                }
            } else {
                echo "<script> Swal.fire({
                            title: 'SELECT TERM',
                            icon: 'warning',
                            showConfirmButton: true
                        });</script>";
            }
        } else {
            echo "<script> Swal.fire({
                    title: 'SELECT STUDENT',
                    icon: 'warning',
                    showConfirmButton: true
                });</script>";
        }
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
</body>

</html>