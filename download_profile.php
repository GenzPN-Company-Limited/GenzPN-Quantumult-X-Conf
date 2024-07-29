<?php
if (!isset($_GET['file']) || empty($_GET['file'])) {
    die('Invalid request. Please provide a file.');
}

$filename = basename($_GET['file']);
$filePath = __DIR__ . '/profile/' . $filename;

if (!file_exists($filePath)) {
    die('File not found.');
}

header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize($filePath));
flush(); // Flush system output buffer
readfile($filePath);
exit;
?>
