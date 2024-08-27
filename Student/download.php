<?php
// Start the session
session_start();

// Retrieve the session variables
$school = $_SESSION['school'];
$class_name = $_SESSION['class_name'];
$filePath=$_SESSION['path'];
$name = $_SESSION['name'];
// PDF file path
$pdfFilePath = $filePath;

// Set the name of the downloaded PDF file
$downloadedFileName = $name . '.pdf';

// Set the appropriate headers for PDF download
header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="' . $downloadedFileName . '"');
header('Content-Length: ' . filesize($pdfFilePath));

// Read and output the content of the PDF file
readfile($pdfFilePath);
header("Location=grades.php");
?>
