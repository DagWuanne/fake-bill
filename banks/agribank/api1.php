<?php
require $_SERVER['DOCUMENT_ROOT'] . '/files/config.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
if ($webinfo['fakebillfree'] > 0) {
    DB::query("UPDATE settings SET fakebillfree=fakebillfree-1 WHERE id = '1'");
}
function canletrai($image, $fontsize, $y, $textColor, $font, $text, $x_tcb)
{


    // Thiết lập kích thước font chữ
    $fontSize = $fontsize;


    imagettftext($image, $fontSize, 0, $x_tcb, $y, $textColor, $font, $text);
}

// function canchinhgiua($image, $fontsize, $y, $textColor, $font, $text) {
//     // Tính kích thước hộp giới hạn của văn bản
//     $bbox = imagettfbbox($fontsize, 0, $font, $text);
//     // Chiều rộng của văn bản
//     $textWidth = $bbox[2] - $bbox[0];
//     // Chiều rộng của ảnh
//     $imageWidth = imagesx($image);
//     // Tính toán vị trí x để canh giữa
//     $x = ($imageWidth - $textWidth) / 2;
//     // Vẽ văn bản lên ảnh
//     imagettftext($image, $fontsize, 0, $x, $y, $textColor, $font, $text);
// }

$fontPath =  $_SERVER['DOCUMENT_ROOT'] . '/fonts';
if (isset($_GET['type'])) {

    $username;
    if (isset($_POST['key'])) {
        $username = xss_clean(DB::queryFirstField("SELECT username FROM users WHERE serial_key = '" . trim($_POST['key']) . "' LIMIT 1"));
    }

    if (!empty($username) || $_GET['type'] == 'demo') {
        $timestampHetHan = strtotime(DB::queryFirstField("SELECT date_bill FROM `users` WHERE username = '$username'"));
        if (time() < $timestampHetHan) {
            $tiengoc = 0;
        }
        $sodu = DB::queryFirstField("SELECT sodu FROM `users` WHERE username = '$username'");
        if ($_GET['type'] == 'demo') {
            $tiengoc = 0;
            $watermark = 1;
        } else {
            DB::query("UPDATE settings SET luottaobill=luottaobill+1 WHERE id = '1'");
            $sodu = DB::queryFirstField("SELECT sodu FROM `users` WHERE username = '$username'");
            if ($sodu >= $tiengoc) {
                $watermark = 0;
                DB::query("UPDATE users SET sodu=sodu-$tiengoc WHERE username='$username'");
                DB::insert('notifications', [
                    'notifications' => 'Đã tạo 1 bill, số tiền trừ ' . $tiengoc,
                    'username' => $username,
                    'amount' => $tiengoc
                ]);
            }
        }
        if ($_POST['theme'] == 'ios') {
            $theme = 'argibank.png';
        }
        if ($_POST['theme'] == 'android') {
            $theme = 'agri910.png';
        }

        if ($_POST['theme'] == 'ios4g') {
            $theme = 'Tagri123.png';
        }
        if ($_POST['theme'] == 'android4g') {
            $theme = 'Tagri910.png';
        }

        if ($_POST['bdsd'] == '1') {
            if ($_POST['theme'] == 'ios') {
                $theme = 'argibank.png';
            }
            if ($_POST['theme'] == 'android') {
                $theme = 'agri1011.png';
            }
        }
        if (empty(trim($_POST['stk_nhan'])) || empty(trim($_POST['name_nhan'])) || empty(trim($_POST['amount'])) || empty(trim($_POST['noidung'])) || empty(trim($_POST['bank_nhan']))) {
            die('<span style="color:red">Vui lòng không bỏ trống dữ liệu</span>');
        }
        if ($sodu >= $tiengoc) { {

                $sourceImage = imagecreatefrompng($theme);

                if ($watermark == 1) {
                    canchinhgiua($sourceImage, 20, 400, imagecolorallocate($sourceImage, 255, 0, 0), $_SERVER['DOCUMENT_ROOT'] . '/fonts/San Francisco/SanFranciscoText-Semibold.otf', 'Ảnh này chỉ để xem demo');
                    canchinhgiua($sourceImage, 20, 740, imagecolorallocate($sourceImage, 255, 0, 0), $_SERVER['DOCUMENT_ROOT'] . '/fonts/San Francisco/SanFranciscoText-Semibold.otf', 'Vui lòng ấn vào nút' . "\n" . '"Tải ảnh gốc" để xóa dòng chữ này' . "\n" . 'Đây chỉ là demo để xem trước khi tải');
                }

                if (strpos($_POST['theme'], 'ios') !== false) {

                    imagettftext($sourceImage, 16, 0, 33, 43, imagecolorallocate($sourceImage, 0, 0, 0), $fontPath . '/San Francisco/SanFranciscoText-Semibold.otf', $_POST['time_dt']);
                }
                if (strpos($_POST['theme'], 'android') !== false) {
                    imagettftext($sourceImage, 27, 0, 120, 100, imagecolorallocate($sourceImage, 0, 0, 0), $_SERVER['DOCUMENT_ROOT'] . '/fonts/Inter/Inter-SemiBold.ttf', trim($_POST['time_dt']));
                }



                canchinhgiua($sourceImage, 30, 240, imagecolorallocate($sourceImage, 167, 39, 71), $fontPath . '/Inter/Inter-SemiBold.ttf', number_format($_POST['amount'], 0, ',', ',') . ' VND', 105);
                canletrai($sourceImage, 16, 284, imagecolorallocate($sourceImage, 74, 74, 74), $fontPath . '/Inter/Inter-Regular.ttf', $_POST['magiaodich'], 325);
                // canletrai($sourceImage, 16, 415, imagecolorallocate($sourceImage, 59, 59, 59), $fontPath . '/Inter/Inter-SemiBold.ttf', removeAccentsAndToUpper($_POST['name_nhan']), 295);
                canletrai($sourceImage, 16, 468, imagecolorallocate($sourceImage, 59, 59, 59), $fontPath . '/Inter/Inter-SemiBold.ttf', $_POST['stk_nhan'], 295);
                // canletrai($sourceImage, 16, 520, imagecolorallocate($sourceImage, 59, 59, 59), $fontPath . '/Inter/Inter-SemiBold.ttf', $_POST['bank_nhan'], 295);
                canletrai($sourceImage, 16, 652, imagecolorallocate($sourceImage, 59, 59, 59), $fontPath . '/Inter/Inter-SemiBold.ttf', $_POST['time_bill'], 295);
                canletrai($sourceImage, 16, 733, imagecolorallocate($sourceImage, 59, 59, 59), $fontPath . '/Inter/Inter-SemiBold.ttf', implode(' ', array_slice(explode(' ', removeAccentsAndToUpper1($_POST['noidung'])), 0, 3)) . '...', 295);

                $words = explode(' ',($_POST['bank_nhan']));
                canletrai($sourceImage, 15, 520, imagecolorallocate($sourceImage, 59, 59, 59), $fontPath . '/Inter/Inter-SemiBold.ttf', $_POST['code1'].' - Ngân hàng', 295);

                // Nếu số từ ít hơn hoặc bằng 4, trả về chuỗi gốc
                if (count($words) <=0) {
                    canletrai($sourceImage, 16, 520, imagecolorallocate($sourceImage, 59, 59, 59), $fontPath . '/Inter/Inter-SemiBold.ttf', $_POST['bank_nhan'], 295);
                } else {
                    // Tính chỉ số giữa của mảng
                    $middleIndex = ceil(count($words) / 2);

                    // Tách mảng thành hai phần
                    $firstPart = implode(' ', array_slice($words, 0, $middleIndex));
                    $secondPart = implode(' ', array_slice($words, $middleIndex));
                    canletrai($sourceImage, 15, 542, imagecolorallocate($sourceImage, 59, 59, 59), $fontPath . '/Inter/Inter-SemiBold.ttf', $firstPart,295);
                    canletrai($sourceImage, 15, 564, imagecolorallocate($sourceImage, 59, 59, 59), $fontPath . '/Inter/Inter-SemiBold.ttf', $secondPart, 295);
                }

                $words = explode(' ', removeAccentsAndToUpper($_POST['name_nhan']));

                // Nếu số từ ít hơn hoặc bằng 4, trả về chuỗi gốc
                if (count($words) <= 4) {
                    canletrai($sourceImage, 16, 415, imagecolorallocate($sourceImage, 59, 59, 59), $fontPath . '/Inter/Inter-SemiBold.ttf', removeAccentsAndToUpper($_POST['name_nhan']), 295);
                } else {
                    // Tính chỉ số giữa của mảng
                    $middleIndex = ceil(count($words) / 2);

                    // Tách mảng thành hai phần
                    $firstPart = implode(' ', array_slice($words, 0, $middleIndex));
                    $secondPart = implode(' ', array_slice($words, $middleIndex));
                    canletrai($sourceImage, 16, 400, imagecolorallocate($sourceImage, 59, 59, 59), $fontPath . '/Inter/Inter-SemiBold.ttf', removeAccentsAndToUpper($firstPart), 295);
                    canletrai($sourceImage, 16, 425, imagecolorallocate($sourceImage, 59, 59, 59), $fontPath . '/Inter/Inter-SemiBold.ttf', removeAccentsAndToUpper($secondPart), 295);
                }


                if ($_POST['bdsd'] == '1') {
                    $overlayImagePath = './noti.png';

                    $overlayImage = imagecreatefrompng($overlayImagePath);

                    // Kích thước mới của ảnh sẽ được chèn (tùy chỉnh theo yêu cầu)
                    $newWidth =  imagesx($sourceImage) - 20;
                    $newHeight = imagesy($overlayImage) + 10;

                    // Chọn hàm tùy thuộc vào phiên bản PHP và yêu cầu của bạn
                    // Nếu sử dụng PHP >= 7.3, bạn có thể sử dụng imagescale
                    if (function_exists('imagescale')) {
                        $scaledOverlayImage = imagescale($overlayImage, $newWidth, $newHeight);
                    } else {
                        // Sử dụng imagecopyresampled nếu không sử dụng được imagescale
                        $scaledOverlayImage = imagecreatetruecolor($newWidth, $newHeight);
                        imagecopyresampled($scaledOverlayImage, $overlayImage, 0, 0, 0, 0, $newWidth, $newHeight, imagesx($overlayImage), imagesy($overlayImage));
                    }

                    // Vị trí (x, y) để chèn ảnh sẽ được chèn (tùy chỉnh theo yêu cầu)
                    $positionX = 7; // Vị trí X
                    $positionY = 65; // Vị trí Y

                    // Chèn ảnh vào ảnh cơ sở
                    imagecopy($sourceImage, $scaledOverlayImage, $positionX, $positionY, 0, 0, $newWidth, $newHeight);

                    imagettftext(
                        $sourceImage,
                        15,
                        0,
                        100,
                        107,
                        imagecolorallocate($sourceImage, 11, 11, 11),
                        $_SERVER['DOCUMENT_ROOT']. '/fonts/Roboto/Roboto-Medium.ttf',
                        'Argibank thông báo'
                    );
                    imagettftext(
                        $sourceImage,
                        14,
                        0,
                        100,
                        137,
                        imagecolorallocate($sourceImage, 11, 11, 11),
                        $_SERVER['DOCUMENT_ROOT']. '/fonts/Roboto/Roboto-Regular.ttf',
                        'Argibank: ' . (removeAccentsAndToUpper($_POST['time_bill'])) . ' Tài khoản :' . "\n" . '-' . number_format($_POST['amount']) . ' VND ' . 'Nội dung giao dịch:' . "\n" . implode(' ', array_slice(explode(' ', removeAccentsAndToUpper1($_POST['noidung'])), 0, 5)) . '...'
                    );
                }

                $overlayImagePath = 'pin_' . str_replace('4g', '', $_POST['theme']) . '/' . $_POST['pin'] . '.png';

                // Đọc ảnh sẽ được chèn
                $overlayImage = imagecreatefrompng($overlayImagePath);

                if (strpos($_POST['theme'], 'ios') !== false) {
                    // Kích thước mới của ảnh sẽ được chèn (tùy chỉnh theo yêu cầu)
                    $newWidth = imagesx($overlayImage) - 51;
                    $newHeight = imagesy($overlayImage) - 23;
                    $pinx = imagesx($sourceImage) - 60;
                    $piny = 27;
                }
                if (strpos($_POST['theme'], 'android') !== false) {
                    // Kích thước mới của ảnh sẽ được chèn (tùy chỉnh theo yêu cầu)
                    $newWidth = 60;
                    $newHeight = 55;
                    $pinx = 1070;
                    $piny = 57;
                }
                // Chọn hàm tùy thuộc vào phiên bản PHP và yêu cầu của bạn
                // Nếu sử dụng PHP >= 7.3, bạn có thể sử dụng imagescale
                if (function_exists('imagescale')) {
                    $scaledOverlayImage = imagescale($overlayImage, $newWidth, $newHeight);
                } else {
                    // Sử dụng imagecopyresampled nếu không sử dụng được imagescale
                    $scaledOverlayImage = imagecreatetruecolor($newWidth, $newHeight);
                    imagecopyresampled($scaledOverlayImage, $overlayImage, 0, 0, 0, 0, $newWidth, $newHeight, imagesx($overlayImage), imagesy($overlayImage));
                }

                // Vị trí (x, y) để chèn ảnh sẽ được chèn (tùy chỉnh theo yêu cầu)


                // Chèn ảnh vào ảnh cơ sở
                imagecopy($sourceImage, $scaledOverlayImage, $pinx, $piny, 0, 0, $newWidth, $newHeight);

                ob_start();

                // Hiển thị ảnh vào output buffer
                imagepng($sourceImage, null, 9);

                // Lấy nội dung đối tượng đầu ra (output buffer)
                $imageData = ob_get_clean();

                // Chuyển đổi ảnh thành base64
                $base64Image = base64_encode($imageData);

                // In thẻ img với src là dữ liệu base64
                echo '<img onclick="taiAnh()" class="w-full" src="data:image/png;base64,' . $base64Image . '" alt="Generated Image">';

                // Giải phóng bộ nhớ
                imagedestroy($sourceImage);
                imagedestroy($scaledOverlayImage);
                imagedestroy($overlayImage);
            }
        } else {
            echo '<span style="color:red">Số dư không đủ</span>';
        }
    } else {
        echo '<span style="color:red">Vui lòng đăng nhập</span>';
    }
}
