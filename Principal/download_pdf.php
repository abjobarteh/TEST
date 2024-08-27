<?php
// Start the session
session_start();

// Retrieve the filename parameter
$filename = $_GET['filename'];


// Set the appropriate headers for PDF download
header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="' . basename($filename) . '"');
header('Content-Length: ' . filesize($filename));

// Read and output the content of the PDF file
readfile($filename);

header("Location: {$_SESSION['redirect']}");
exit;
?>
