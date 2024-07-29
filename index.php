<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Quantumult X GenzPN Profile</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://unpkg.com/sweetalert/dist/sweetalert.css">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js" defer></script>
    <script src="script.js" defer></script>
</head>
<body>
    <div class="container">
        <h1>Generate Quantumult X GenzPN Profile</h1>
        <input type="text" id="url" placeholder="Enter URL">
        <button class="button paste" onclick="pasteUrl()">Paste URL</button>
        <button class="button generate" onclick="generateProfile()">Generate Config</button>
        <div id="result"></div>
    </div>
    <div class="footer">
        <a href="https://t.me/genzpn" target="_blank">Telegram</a> |
        <a href="https://panel.genzpn.com" target="_blank">Home</a>
    </div>
</body>
</html>
