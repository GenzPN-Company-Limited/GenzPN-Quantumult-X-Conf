<?php
header('Content-Type: application/json');
require 'config_data.php';
require 'config.php';
require 'database.php';

function generateRandomString($length = 10) {
    return substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, $length);
}

if (!isset($_GET['url']) || empty($_GET['url'])) {
    echo json_encode(['error' => 'Invalid request. Please provide a URL.']);
    exit;
}

$url = filter_var($_GET['url'], FILTER_SANITIZE_URL);
$token = parse_url($url, PHP_URL_QUERY);

parse_str($token, $queryParams);
$token = $queryParams['token'] ?? '';

if (empty($token) || strlen($token) != 32) {
    echo json_encode(['error' => 'Invalid token.']);
    exit;
}

try {
    $db = new Database();
    $conn = $db->getConnection();

    $sql = "SELECT id, email FROM v2_user WHERE token = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $email);

    if ($stmt->num_rows === 0) {
        echo json_encode(['error' => 'Token not found.']);
        exit;
    }

    $stmt->fetch();
    $stmt->close();

    $profileFiles = glob(__DIR__ . "/profile/{$id}_{$email}_*.conf");

    $host = $_SERVER['HTTP_HOST'];
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';

    if ($profileFiles) {
        $existingFile = $profileFiles[0];
        $downloadLink = "{$protocol}://{$host}/download_profile.php?file=" . basename($existingFile);
        echo json_encode(['download_link' => $downloadLink, 'id' => $id, 'email' => $email]);
        exit;
    }

    $randomString = generateRandomString(10);
    $filename = "{$id}_{$email}_{$randomString}.conf";
    $fileContent = getConfigData($url);

    if (!file_exists(__DIR__ . '/profile')) {
        mkdir(__DIR__ . '/profile', 0777, true);
    }

    $filePath = __DIR__ . "/profile/{$filename}";
    file_put_contents($filePath, $fileContent);

    $downloadLink = "{$protocol}://{$host}/download_profile.php?file={$filename}";
    echo json_encode(['download_link' => $downloadLink, 'id' => $id, 'email' => $email]);
} catch (Exception $e) {
    echo json_encode(['error' => 'An unexpected error occurred.']);
}
?>
