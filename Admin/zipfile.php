<?php
// Start the session
session_start();
ob_start();

// Retrieve the session variables
$school = $_SESSION['school'];
$class_name = $_SESSION['class_name'];
$location = $_SESSION['location'];
$dpath = $_SESSION['path'];
// Directory path
$directoryPath = $dpath;

// Set the name of the zip file
$zipFileName = 'REPORTS FOR '.$class_name.'.zip';

// Create a ZipArchive object
$zip = new ZipArchive();

// Open the zip file for writing
if ($zip->open($zipFileName, ZipArchive::CREATE) !== TRUE) {
    die('Cannot open ' . $zipFileName);
}

// Create recursive directory iterator
$files = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($directoryPath),
    RecursiveIteratorIterator::LEAVES_ONLY
);

foreach ($files as $name => $file) {
    // Skip directories (they would be added automatically)
    if (!$file->isDir()) {
        // Get real and relative path for the current file
        $filePath = $file->getRealPath();
        $relativePath = substr($filePath, strlen($directoryPath));

        // Read the content of the PDF file
        $pdfContent = file_get_contents($filePath);

        // Add the PDF content to the archive
        $zip->addFromString($relativePath, $pdfContent);
    }
}

// Close the zip file
$zip->close();

// Force download the zip file
header('Content-Type: application/zip');
header('Content-Disposition: attachment; filename="' . $zipFileName . '"');
header('Content-Length: ' . filesize($zipFileName));
readfile($zipFileName);

// Delete the zip file after download
unlink($zipFileName);

function deleteFolder($folderPath) {
    if (!is_dir($folderPath)) {
        return false; // Not a directory
    }

    $files = glob($folderPath . '/*');
    foreach ($files as $file) {
        if (is_file($file)) {
            unlink($file); // Delete file
        } elseif (is_dir($file)) {
            deleteFolder($file); // Recursively delete subfolder
        }
    }

    // Delete the empty folder
    return rmdir($folderPath);
}

(deleteFolder($directoryPath)) ;

header("Location=report.php");

?>
