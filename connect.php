<?php
// Set TNS_ADMIN path
putenv("TNS_ADMIN=C:\wamp64\www\connections");
$username = 'system';
$password = 'Kotu%sss1234';
$service_name = 'KOTU';
$wallet_path = 'C:\wamp64\www\connections';

// Connect to Oracle Autonomous Database using a secure connection
$tns = '(DESCRIPTION =
    (ADDRESS = (PROTOCOL = TCP)(HOST = 10.0.0.132)(PORT = 1521))
    (CONNECT_DATA =
      (SERVER = DEDICATED)
      (SERVICE_NAME = KOTU)
    ))';

// Set the Oracle wallet directory
putenv("TNS_ADMIN=$wallet_path");

// Connect to the Autonomous Database
$connection='(DESCRIPTION =
    (ADDRESS = (PROTOCOL = TCP)(HOST = 10.0.0.132)(PORT = 1521))
    (CONNECT_DATA =
      (SERVER = DEDICATED)
      (SERVICE_NAME = KOTU)
    ))';
$conn=oci_connect($username,$password , '(DESCRIPTION =
    (ADDRESS = (PROTOCOL = TCP)(HOST = 10.0.0.132)(PORT = 1521))
    (CONNECT_DATA =
      (SERVER = DEDICATED)
      (SERVICE_NAME = KOTU)
    ))');

$con=oci_connect($username,$password , '(DESCRIPTION =
    (ADDRESS = (PROTOCOL = TCP)(HOST = 10.0.0.132)(PORT = 1521))
    (CONNECT_DATA =
      (SERVER = DEDICATED)
      (SERVICE_NAME = KOTU)
    ))');

//$conn = oci_connect($username, $password, $tns);

// Check if connection is successful
/*if (!$conn) {
    $error = oci_error();
    die("Connection failed: " . $error['message']);
} else {
    echo "Connected to Oracle Autonomous Database successfully!";
}
*/
// Close the connection
//oci_close($con); 

// Set TNS_ADMIN path
/*putenv("TNS_ADMIN=C:\wamp64\www\connections");
$username = 'ACADEMIX';
$password = 'Kotu%sss1234';
$service_name = 'g4b632736ce2819_iobdb_high.adb.oraclecloud.com';
$wallet_path = 'C:\wamp64\www\connections';

// Connect to Oracle Autonomous Database using a secure connection
//$tns = "(description= (retry_count=20)(retry_delay=3)(address=(protocol=tcps)(port=1522)(host=adb.uk-london-1.oraclecloud.com))(connect_data=(service_name=g4b632736ce2819_iobdb_high.adb.oraclecloud.com))(security=(ssl_server_dn_match=yes)))";

// Set the Oracle wallet directory
putenv("TNS_ADMIN=$wallet_path");

// Connect to the Autonomous Database
$connection='tcps://adb.uk-london-1.oraclecloud.com:1522/g4b632736ce2819_iobdb_high.adb.oraclecloud.com?wallet_location=C:\wamp64\www\connections';
$conn=oci_connect($username,$password , 'tcps://adb.uk-london-1.oraclecloud.com:1522/g4b632736ce2819_iobdb_high.adb.oraclecloud.com?wallet_location=C:\wamp64\www\connections');

$con=oci_connect($username,$password , 'tcps://adb.uk-london-1.oraclecloud.com:1522/g4b632736ce2819_iobdb_high.adb.oraclecloud.com?wallet_location=C:\wamp64\www\connections');

//$conn = oci_connect($username, $password, $tns);

// Check if connection is successful
/*if (!$conn) {
    $error = oci_error();
    die("Connection failed: " . $error['message']);
} else {
    echo "Connected to Oracle Autonomous Database successfully!";
}
*/
// Close the connection
//oci_close($con); */
?>
