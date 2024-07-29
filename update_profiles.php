<?php
header('Content-Type: application/json');

require_once 'config_data.php';
require 'config.php';
require 'database.php';

function sendTelegramMessage($botToken, $chatID, $message) {
    $apiURL = "https://api.telegram.org/bot{$botToken}/sendMessage";
    $postData = [
        'chat_id' => $chatID,
        'text'    => $message,
        'parse_mode' => 'Markdown'
    ];

    $ch = curl_init($apiURL);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
    $response = curl_exec($ch);

    curl_close($ch);

    return $response;
}

try {
    $db = new Database();
    $conn = $db->getConnection();

    $sql = "SELECT id, email, token FROM v2_user WHERE token IS NOT NULL AND token != ''";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $id = $row['id'];
            $email = $row['email'];
            $token = $row['token'];

            $profileFiles = glob(__DIR__ . "/profile/{$id}_{$email}_*.conf");
            if ($profileFiles) {
                foreach ($profileFiles as $file) {
                    $fileContent = getConfigData("https://subscribe.genzpn.com/api/v1/client/subscribe?token={$token}");
                    file_put_contents($file, $fileContent);
                }
            }
        }

        $timestamp = date('[d-m-Y H:i]');
        $message = "{$timestamp}\n-------------------------------\nProfiles updated successfully.";
        $response = sendTelegramMessage(TELEGRAM_BOT_TOKEN, TELEGRAM_CHAT_ID, $message);
    }

    echo json_encode(['status' => 'Profiles updated successfully.']);
} catch (Exception $e) {
    echo json_encode(['error' => 'An unexpected error occurred.']);
}
?>
