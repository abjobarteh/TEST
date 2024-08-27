<?php
// Start the session
session_start();

// Retrieve the session variables
$school = $_SESSION['school'];
$filePath=$_SESSION['path'];
$filename =  $_SESSION['filename'];
$redirect=$_SESSION['redirect'];

// Set the appropriate headers for PDF download

header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Content-Length: ' . filesize($filePath));

// Read and output the content of the PDF file
readfile($filePath);
unlink($filePath);
header("Location=$redirect");
?>
