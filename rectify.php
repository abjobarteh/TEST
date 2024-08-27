<?php 
include('connect.php');

// Open the file for writing
$file = fopen('queries_live.sql', 'w');

// Check if the file was successfully opened
if ($file === false) {
    die('Error: Unable to open or create the file.');
}

$query = "SELECT 
            DISTINCT A.STUD_ID,
            B.CLASS_CODE,
            B.SUB_CODE,
            B.TERM,
            B.CONST_ASS,
            B.EXAM
          FROM 
            STUDENT A
          JOIN 
            STUDENT_EVALUATION B ON A.STUD_ID = B.STUD_ID
          JOIN 
            STUDENT_CUMULATIVE C ON A.STUD_ID = C.STUD_ID 
          WHERE 
            B.MARK_STATUS = 'ACCEPTED' 
            AND C.TERM = '2023/2024 ACADEMIC YEAR SECOND TERM'
            AND B.TERM = '2023/2024 ACADEMIC YEAR SECOND TERM'
            AND (B.CONST_ASS + B.EXAM) != C.MARK";

$sql = oci_parse($conn, $query);
oci_execute($sql);

while ($r = oci_fetch_array($sql, OCI_ASSOC)) {

    $stud_id = $r['STUD_ID'];
    $term = $r['TERM'];
    $class_code = $r['CLASS_CODE'];
    $sub_code = $r['SUB_CODE'];
    $total = $r['CONST_ASS'] + $r['EXAM'];
  //  echo "SUB_CODE $sub_code, CLASS_CODE $class_code<br>";
    
    $getgrade = oci_parse($conn, "SELECT A.G_CODE, A.GRADE 
                                  FROM GRADE A 
                                  JOIN GRADE_SETTING B ON A.G_CODE = B.G_CODE 
                                  WHERE B.START_GRADE_RANGE <= CAST($total AS INT)
                                    AND CAST($total AS INT) <= B.END_GRADE_RANGE 
                                  ORDER BY A.GRADE");
    oci_execute($getgrade);

    $g_code = null;
    $grade = null;
    while ($b = oci_fetch_array($getgrade, OCI_ASSOC)) {
        $g_code = $b['G_CODE'];
        $grade = $b['GRADE'];
    }

    if ($g_code !== null) {
        $getgpa = oci_parse($conn, "SELECT GPA 
                                    FROM GPA 
                                    WHERE G_CODE = $g_code");
        oci_execute($getgpa);

        $gpa = null;
        while ($c = oci_fetch_array($getgpa, OCI_ASSOC)) {
            $gpa = $c['GPA'];
        }

        if ($gpa !== null) {
            $gethrs = oci_parse($conn, "SELECT SUBJECT_CREDIT_HRS 
                                        FROM SUBJECT 
                                        WHERE SUB_CODE = $sub_code 
                                          AND SUBS = $class_code 
                                          AND S_ID = 41");
                                       
            oci_execute($gethrs);

            $hrs = null;
            while ($d = oci_fetch_array($gethrs, OCI_ASSOC)) {
                $hrs = $d['SUBJECT_CREDIT_HRS'];
            }

            if ($hrs !== null) {
                $pro_gpa_hrs = $gpa * $hrs;

                $updateQuery = "UPDATE STUDENT_CUMULATIVE  SET MARK = $total, G_CODE = $g_code, GPA = $gpa, TOTAL_GPA_CREDIT = $pro_gpa_hrs WHERE STUD_ID = '$stud_id' AND TERM = '$term' AND SUB_CODE = '$class_code' AND SUBJ_CODE = '$sub_code';";
                
                // Write the query to the file
                fwrite($file, $updateQuery . "\n");
               
              
            } else {
              echo "SELECT SUBJECT_CREDIT_HRS 
                                        FROM SUBJECT 
                                        WHERE SUB_CODE = $sub_code 
                                          AND SUBS = $class_code 
                                          AND S_ID = 41";
                echo "Error: Credit hours not found for SUB_CODE $sub_code, CLASS_CODE $class_code<br>";
            }
        } else {
            echo "Error: GPA not found for G_CODE $g_code<br>";
        }
    } else {
        echo "Error: G_CODE not found for total score $total<br>";
    }
}
echo "RECTIFIED<br>";
// Close the file
fclose($file);

?>
