<?php

$botToken = '6968928130:AAE94Py8CsLXov2N-elpNiIgE_FBEGOCfrY';
$chatId = '1002074057808';

// Tạo URL để lấy tin nhắn từ nhóm
$apiUrl = "https://api.telegram.org/bot{$botToken}/getUpdates";

// Gửi yêu cầu HTTP bằng cURL
$ch = curl_init($apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

// Giải mã JSON response
$data = json_decode($response, true);

// Lấy tin nhắn và ID của nhóm từ response
if (isset($data['result']) && count($data['result']) > 0) {
    foreach ($data['result'] as $update) {
        $messageText = $update['message']['text'];
        $messageDate = date('m/d/Y H:i:s', $update['message']['date']);
        $chatId = $update['message']['chat']['id'];

        // In thông tin tin nhắn và ID của nhóm
        echo "Nội dung tin nhắn: {$messageText}\n";
        echo "Ngày gửi: {$messageDate}\n";
        echo "Chat ID của nhóm: {$chatId}\n";
        echo "-----------------------------\n";
    }
} else {
    echo "Không có tin nhắn mới trong nhóm.\n";
}

?>