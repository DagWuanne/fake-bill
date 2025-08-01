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
function cangiua($image, $fontsize, $y, $textColor, $font, $text)
{
    $fontSize = $fontsize;
    $textBoundingBox = imagettfbbox($fontSize, 0, $font, $text);
    $textWidth = $textBoundingBox[2] - $textBoundingBox[0];
    $imageWidth = imagesx($image);
    $x = ($imageWidth - $textWidth) / 2; // Căn giữa theo chiều ngang
    imagettftext($image, $fontSize, 0, $x, $y, $textColor, $font, $text);
}

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
                    'notifications' => 'Đã tạo 1 bill Tech, số tiền trừ ' . $tiengoc,
                    'username' => $username,
                    'amount' => $tiengoc
                ]);
            }
        }
        if ($_POST['theme'] == 'ios') {
            $theme = 'tcb.png';
        }
        if ($_POST['theme'] == 'android') {
            $theme = 'tcb910.png';
        }
        if ($_POST['theme'] == 'ios4g') {
            $theme = 'tcb.png';
        }
        if ($_POST['theme'] == 'android4g') {
            $theme = 'Ttcb910.png';
        }
        if ($_POST['bdsd'] == '1') {
            if ($_POST['theme'] == 'ios') {
                $theme = 'tcb-bdsd.png';
            }
            if ($_POST['theme'] == 'android') {
                $theme = 'tcb1112.png';
            }
        }
        if (empty(trim($_POST['stk_nhan'])) || empty(trim($_POST['name_nhan'])) || empty(trim($_POST['amount'])) || empty(trim($_POST['noidung'])) || empty(trim($_POST['bank_nhan']))) {
            die('<span style="color:red">Vui lòng không bỏ trống dữ liệu</span>');
        }
        if ($sodu >= $tiengoc) { {

                $sourceImage = imagecreatefrompng($theme);

                if ($watermark == 1) {
                    canchinhgiua($sourceImage, 25, 400, imagecolorallocate($sourceImage, 255, 0, 0), $_SERVER['DOCUMENT_ROOT'] . '/fonts/San Francisco/SanFranciscoText-Semibold.otf', 'Ảnh này chỉ để xem demo');
                    canchinhgiua($sourceImage, 25, 1140, imagecolorallocate($sourceImage, 255, 0, 0), $_SERVER['DOCUMENT_ROOT'] . '/fonts/San Francisco/SanFranciscoText-Semibold.otf', 'Vui lòng ấn vào nút' . "\n" . '"Tải ảnh gốc" để xóa dòng chữ này' . "\n" . 'Đây chỉ là demo để xem trước khi tải');
                }
                if ($_POST['bdsd'] == '1') {
                    canletrai($sourceImage, 25, 215, imagecolorallocate($sourceImage, 0, 0, 0), $_SERVER['DOCUMENT_ROOT'] . '/fonts/Inter/Inter-SemiBold.ttf', '- VND ' . number_format($_POST['amount']), 165);
                    canletrai($sourceImage, 25, 285, imagecolorallocate($sourceImage, 0, 0, 0), $_SERVER['DOCUMENT_ROOT'] . '/fonts/Inter/Inter-Regular.ttf', 'Tài khoản: ' . $_POST['stkgui'], 165);
                    canletrai($sourceImage, 25, 335, imagecolorallocate($sourceImage, 0, 0, 0), $_SERVER['DOCUMENT_ROOT'] . '/fonts/Inter/Inter-Regular.ttf', 'Số dư: VND ' . number_format($_POST['sdc']), 165);

                    if (strlen($_POST['noidung']) > 37) {
                        canletrai($sourceImage, 25, 385, imagecolorallocate($sourceImage, 0, 0, 0), $_SERVER['DOCUMENT_ROOT'] . '/fonts/Inter/Inter-Regular.ttf', substr($_POST['noidung'], 0, 37) . '...', 165);
                        canletrai($sourceImage, 25, 425, imagecolorallocate($sourceImage, 0, 0, 0), $_SERVER['DOCUMENT_ROOT'] . '/fonts/Inter/Inter-Regular.ttf', 'chieu '.$_POST['mathamchieu'], 165);

                    } else {
                        canletrai($sourceImage, 25, 385, imagecolorallocate($sourceImage, 0, 0, 0), $_SERVER['DOCUMENT_ROOT'] . '/fonts/Inter/Inter-Regular.ttf', $_POST['noidung']. '. Ma tham', 165);
                        canletrai($sourceImage, 25, 425, imagecolorallocate($sourceImage, 0, 0, 0), $_SERVER['DOCUMENT_ROOT'] . '/fonts/Inter/Inter-Regular.ttf', 'chieu '.$_POST['mathamchieu'], 165);

                    }
                }
                if (strpos($_POST['theme'], 'ios') !== false) {
                    imagettftext($sourceImage, 30, 0, 150, 80, imagecolorallocate($sourceImage, 0, 0, 0), $_SERVER['DOCUMENT_ROOT'] . '/fonts/San Francisco/SanFranciscoText-Semibold_Fix.otf', $_POST['time_dt']);
                }
                if (strpos($_POST['theme'], 'android') !== false) {
                    imagettftext($sourceImage, 30, 0, 120, 85, imagecolorallocate($sourceImage, 0, 0, 0), $_SERVER['DOCUMENT_ROOT'] . '/fonts/San Francisco/SanFranciscoText-Semibold_Fix.otf', trim($_POST['time_dt']));
                }
                canletrai($sourceImage, 44, 677, imagecolorallocate($sourceImage, 0, 0, 0), $fontPath . '/SF-Pro-Text-Semibold.otf',  number_format($_POST['amount']), 198);
                canletrai($sourceImage, 25, 855, imagecolorallocate($sourceImage, 0, 0, 0), $fontPath . '/SF-Pro-Text-Semibold.otf',  removeAccentsAndToUpper($_POST['name_nhan']), 52);
                canletrai($sourceImage, 25, 895, imagecolorallocate($sourceImage, 0, 0, 0), $fontPath . '/SF-Pro-Text-Semibold.otf', $_POST['stk_nhan'], 52);
                canletrai($sourceImage, 25, 995, imagecolorallocate($sourceImage, 0, 0, 0), $fontPath . '/SF-Pro-Text-Semibold.otf', 'Ngân hàng ' . $_POST['bank_nhan'], 52);

                // $words = explode(' ', removeAccentsAndToUpper($_POST['name_nhan']));

                // Nếu số từ ít hơn hoặc bằng 4, trả về chuỗi gốc
                // if (count($words) <= 4) {
                //     canletrai($sourceImage, 44, 677, imagecolorallocate($sourceImage, 0, 0, 0), $fontPath . '/SF-Pro-Text-Semibold.otf',  number_format($_POST['amount']), 198);
                // } else {
                //     // Tính chỉ số giữa của mảng
                //     $middleIndex = ceil(count($words) / 2);

                //     // Tách mảng thành hai phần
                //     $firstPart = implode(' ', array_slice($words, 0, $middleIndex));
                //     $secondPart = implode(' ', array_slice($words, $middleIndex));
                //     canletrai($sourceImage, 60, 1010, imagecolorallocate($sourceImage, 0, 0, 0), $fontPath . '/SF-Pro-Text-Semibold.otf', 'Chuyển thành công' . "\n" . 'tới ' . removeAccentsAndToUpper($firstPart) . "\n" . removeAccentsAndToUpper($secondPart) . "\n" . 'VND ' . number_format($_POST['amount']), 72);
                // }
                $words = explode(' ', ($_POST['noidung']));

                // Nếu số từ ít hơn hoặc bằng 4, trả về chuỗi gốc
                if (count($words) <= 7) {
                    canletrai($sourceImage, 25, 1100, imagecolorallocate($sourceImage, 0, 0, 0), $fontPath . '/SF-Pro-Text-Semibold.otf', trim($_POST['noidung']), 52);
                } else {
                    // Tính chỉ số giữa của mảng
                    $middleIndex = ceil(count($words) / 1.5);

                    // Tách mảng thành hai phần
                    $firstPart = implode(' ', array_slice($words, 0, $middleIndex));
                    $secondPart = implode(' ', array_slice($words, $middleIndex));
                    canletrai($sourceImage, 23, 1090, imagecolorallocate($sourceImage, 0, 0, 0), $fontPath . '/SF-Pro-Text-Semibold.otf', trim($firstPart . "\n" . $secondPart), 52);
                }
                // canletrai($sourceImage, 39, 1465, imagecolorallocate($sourceImage, 0, 0, 0), $fontPath . '/SF-Pro-Text-Semibold.otf', 'Ngân hàng ' . $_POST['bank_nhan'], 72);
                canletrai($sourceImage, 25, 1205, imagecolorallocate($sourceImage, 0, 0, 0), $fontPath . '/SFProText-Semibold_fix.otf', $_POST['time_bill'], 52);
                canletrai($sourceImage, 25, 1315, imagecolorallocate($sourceImage, 0, 0, 0), $fontPath . '/SF-Pro-Text-Semibold.otf', $_POST['magiaodich'], 52);
                canletrai($sourceImage, 25, 1425, imagecolorallocate($sourceImage, 0, 0, 0), $fontPath . '/SF-Pro-Text-Semibold.otf', $_POST['mathamchieu'], 52);


                $overlayImagePath = 'pin_' . str_replace('4g', '', $_POST['theme']) . '/' . $_POST['pin'] . '.png';

                // Đọc ảnh sẽ được chèn
                $overlayImage = imagecreatefrompng($overlayImagePath);

                if (strpos($_POST['theme'], 'ios') !== false) {
                    // Kích thước mới của ảnh sẽ được chèn (tùy chỉnh theo yêu cầu)
                    $newWidth = 75;
                    $newHeight = 35;
                    $pinx = 793;
                    $piny = 46;
                }
                if (strpos($_POST['theme'], 'android') !== false) {
                    // Kích thước mới của ảnh sẽ được chèn (tùy chỉnh theo yêu cầu)
                    $newWidth = 50;
                    $newHeight = 50;
                    $pinx = 1190;
                    $piny = 45;
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
