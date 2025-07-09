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
function alignRight($image, $text, $font, $size, $color, $y, $nhan = 130)
{
    $bbox = imagettfbbox($size, 0, $font, $text);
    $text_width = $bbox[2] - $bbox[0];
    $x = imagesx($image) - $text_width - $nhan; // Điều chỉnh giá trị 10 tùy theo lề phải mong muốn
    imagettftext($image, $size, 0, $x, $y, $color, $font, $text);
}
function convertCurrencyToWords($amount)
{
    $data = file_get_contents('http://forum.vdevs.net/nossl/mtw.php?number=' . $amount);
    $data = json_decode($data, true);
    if ($data['success'] == true) {
        return htmlspecialchars($data['result']);
    }
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
            $sodu = DB::queryFirstField("SELECT sodu FROM `users` WHERE username = '$username'  LIMIT 1");
            if ($sodu >= $tiengoc) {
                DB::query("UPDATE settings SET luottaobill=luottaobill+1 WHERE id = '1'");
                $watermark = 0;
                DB::query("UPDATE users SET sodu=sodu-$tiengoc WHERE username='$username'");
                DB::insert('notifications', [
                    'notifications' => 'Đã tạo 1 bill ACB, số tiền trừ ' . $tiengoc,
                    'username' => $username,
                    'amount' => $tiengoc
                ]);
            }
        }
        if ($_POST['theme'] == 'ios') {
            $theme = 'acb.png';
        }
        if ($_POST['theme'] == 'android') {
            $theme = 'acb910.png';
        }
        if ($_POST['theme'] == 'ios4g') {
            $theme = 'Tacb123.png';
        }
        if ($_POST['theme'] == 'android4g') {
            $theme = 'Tacb910.png';
        }
        if ($_POST['bdsd'] == '1') {
            if ($_POST['theme'] == 'ios') {
                $theme = 'acb.png';
            }
            if ($_POST['theme'] == 'android') {
                $theme = 'ac1112.png';
            }
        }
        if (empty(trim($_POST['stk_nhan'])) || empty(trim($_POST['name_nhan'])) || empty(trim($_POST['amount'])) || empty(trim($_POST['noidung'])) || empty(trim($_POST['bank_nhan']))) {
            die('<span style="color:red">Vui lòng không bỏ trống dữ liệu</span>');
        }
        if ($sodu >= $tiengoc) { {

                $sourceImage = imagecreatefrompng($theme);

                if ($watermark == 1) {
                    canchinhgiua($sourceImage, 30, 200, imagecolorallocate($sourceImage, 255, 0, 0), $fontPath . '/San Francisco/SanFranciscoText-Semibold.otf', 'Ảnh này chỉ để xem demo');
                     canchinhgiua($sourceImage, 25, 840, imagecolorallocate($sourceImage, 255, 0, 0), $fontPath . '/San Francisco/SanFranciscoText-Semibold.otf', 'Vui lòng ấn vào nút' . "\n" . '"Tải ảnh gốc" để xóa dòng chữ này' . "\n" . 'Đây chỉ là demo để xem trước khi tải');
                }

                if (strpos($_POST['theme'], 'ios') !== false) {

                    imagettftext($sourceImage, 32, 0, 115, 78, imagecolorallocate($sourceImage, 0, 0, 0), $fontPath . '/San Francisco/SanFranciscoText-Semibold.otf', $_POST['time_dt']);
                }
                if (strpos($_POST['theme'], 'android') !== false) {
                    imagettftext($sourceImage, 34, 0, 120, 75, imagecolorallocate($sourceImage, 255, 255, 255), $fontPath . '/Inter/Inter-SemiBold.ttf', trim($_POST['time_dt']));
                }
                $words = explode(' ', removeAccentsAndToUpper($_POST['name_nhan']));

                // Nếu số từ ít hơn hoặc bằng 4, trả về chuỗi gốc
                if (count($words) <= 4) {
                    imagettftext($sourceImage, 27, 0, 330, 785, imagecolorallocate($sourceImage, 68, 75, 81), $fontPath . '/Inter/Inter-Bold.ttf', removeAccentsAndToUpper($_POST['name_nhan']));
                } else {
                    // Tính chỉ số giữa của mảng
                    $middleIndex = ceil(count($words) / 1.5);

                    // Tách mảng thành hai phần
                    $firstPart = implode(' ', array_slice($words, 0, $middleIndex));
                    $secondPart = implode(' ', array_slice($words, $middleIndex));
                    // alignRight($sourceImage, removeAccentsAndToUpper($firstPart), $fontPath . '/Inter/Inter-Regular.ttf', 36, imagecolorallocate($sourceImage, 68, 75, 81), 2000);
                    // alignRight($sourceImage, removeAccentsAndToUpper($secondPart), $fontPath . '/Inter/Inter-Regular.ttf', 36, imagecolorallocate($sourceImage, 68, 75, 81), 2070);
                    imagettftext($sourceImage, 27, 0, 330, 780, imagecolorallocate($sourceImage, 68, 75, 81), $fontPath . '/Inter/Inter-Bold.ttf', removeAccentsAndToUpper($firstPart));
                    imagettftext($sourceImage, 27, 0, 330, 825, imagecolorallocate($sourceImage, 68, 75, 81), $fontPath . '/Inter/Inter-Bold.ttf', removeAccentsAndToUpper($secondPart));
                }
                alignRight($sourceImage, removeAccentsAndToUpper($_POST['code1'] . ' - NH'), $fontPath . '/Inter/Inter-Regular.ttf', 36, imagecolorallocate($sourceImage, 50, 63, 75), 2140);
                // alignRight($sourceImage, str_replace(' VIET NAM', '', removeAccentsAndToUpper($_POST['bank_nhan'])), $fontPath . '/Inter/Inter-Regular.ttf', 36, imagecolorallocate($sourceImage, 50, 63, 75), 2210);
                $wordsName = explode(' ', removeAccentsAndToUpper($_POST['name_nhan']));
                if (count($wordsName) <= 4) {
                    imagettftext($sourceImage, 25, 0, 330, 835, imagecolorallocate($sourceImage, 68, 75, 81), $fontPath . '/Inter/Inter-Regular.ttf', str_replace(' VIET NAM', '', removeAccentsAndToUpper($_POST['bank_nhan'])));
                    imagettftext($sourceImage, 24, 0, 330, 885, imagecolorallocate($sourceImage, 68, 75, 81), $fontPath . '/Inter/Inter-Regular.ttf', trim($_POST['stk_nhan']));
                }else {

                    imagettftext($sourceImage, 19, 0, 330, 865, imagecolorallocate($sourceImage, 68, 75, 81), $fontPath . '/Inter/Inter-Regular.ttf', str_replace(' VIET NAM', '', removeAccentsAndToUpper($_POST['bank_nhan'])));
                    imagettftext($sourceImage, 23, 0, 330, 905, imagecolorallocate($sourceImage, 68, 75, 81), $fontPath . '/Inter/Inter-Regular.ttf', trim($_POST['stk_nhan']));
                }

                // alignRight($sourceImage, trim($_POST['stk_nhan']), $fontPath . '/Inter/Inter-Regular.ttf', 36, imagecolorallocate($sourceImage, 68,75,81), 2345);
                $words = mb_strlen($_POST['noidung'], 'UTF-8');
                canletrai($sourceImage, 45, 505, imagecolorallocate($sourceImage,  0, 117, 255), $fontPath . '/Inter/Inter-Bold.ttf', str_replace(',', '.', number_format(trim($_POST['amount']), 0, ',', ',')) . ' VND', 60);

                // Nếu số từ ít hơn hoặc bằng 4, trả về chuỗi gốc
                if ($words < 30) {
                    imagettftext($sourceImage, 29, 0, 58, 1310, imagecolorallocate($sourceImage, 68, 75, 81), $fontPath . '/Inter/Inter-Regular.ttf', strtoupper($_POST['noidung']));

                    // alignRight($sourceImage, strtoupper(string: $_POST['noidung']), $fontPath . '/Inter/Inter-Regular.ttf', 38, imagecolorallocate($sourceImage, 22, 63, 161), 3115);
                } else {
                    $firstPart = substr(strtoupper($_POST['noidung']), 0, 30);

                    // Lấy các kí tự từ kí tự thứ 15 trở đi
                    $secondPart = substr(strtoupper($_POST['noidung']), 30);
                    imagettftext($sourceImage, 29, 0, 58, 1310, imagecolorallocate($sourceImage, 68, 75, 81), $fontPath . '/Inter/Inter-Regular.ttf', $firstPart);
                    imagettftext($sourceImage, 29, 0, 58, 1360, imagecolorallocate($sourceImage, 68, 75, 81), $fontPath . '/Inter/Inter-Regular.ttf', $secondPart . '-' . str_replace('/', '', str_replace('/202', '/2', substr($_POST['time_bill'], 0, 11))));
                }
                $words = explode(' ',  convertCurrencyToWords($_POST['amount']));

                // Nếu số từ ít hơn hoặc bằng 4, trả về chuỗi gốc
                if (count($words) <= 6) {

                    canletrai($sourceImage, 28, 560, imagecolorallocate($sourceImage,  98, 100, 155), $fontPath . '/Inter/Inter-Light.ttf', convertCurrencyToWords($_POST['amount']), 62);
                } else {
                    // Tính chỉ số giữa của mảng
                    $middleIndex = ceil(count($words) / 2);

                    // Tách mảng thành hai phần
                    $firstPart = implode(' ', array_slice($words, 0, $middleIndex));
                    $secondPart = implode(' ', array_slice($words, $middleIndex));

                    canletrai($sourceImage, 25, 550, imagecolorallocate($sourceImage,  98, 100, 155), $fontPath . '/Inter/Inter-Light.ttf', $firstPart, 62);

                    canletrai($sourceImage, 25, 585, imagecolorallocate($sourceImage,  98, 100, 155), $fontPath . '/Inter/Inter-Light.ttf', $secondPart, 62);
                }


                // alignRight($sourceImage, $_POST['time_bill'], $fontPath . '/Inter/Inter-SemiBold.ttf', 29, imagecolorallocate($sourceImage, 68,75,81), 1055);
                imagettftext($sourceImage, 30, 0, 330, 995, imagecolorallocate($sourceImage, 68, 75, 81), $fontPath . '/Inter/Inter-Medium.ttf', $_POST['time_bill']);

                // alignRight($sourceImage, substr(string: $_POST['time_bill'], 0, 11), $fontPath . '/Inter/Inter-Regular.ttf', 36, imagecolorallocate($sourceImage, 68,75,81), 1185);
                imagettftext($sourceImage, 27, 0, 330, 670, imagecolorallocate($sourceImage, 68, 75, 81), $fontPath . '/Inter/Inter-Bold.ttf', removeAccentsAndToUpper($_POST['name_gui']));
                imagettftext($sourceImage, 25, 0, 330, 720, imagecolorallocate($sourceImage, 68, 75, 81), $fontPath . '/Inter/Inter-Regular.ttf', removeAccentsAndToUpper($_POST['stkgui']));
                imagettftext($sourceImage, 27, 0, 330, 1128, imagecolorallocate($sourceImage, 68, 75, 81), $fontPath . '/Inter/Inter-Medium.ttf', removeAccentsAndToUpper($_POST['magiaodich']));
                $overlayImagePath = 'pin_' . str_replace('4g', '', $_POST['theme']) . '/' . $_POST['pin'] . '.png';

                if ($_POST['bdsd'] == '1') {

                    $overlayImage1Path = './bdsd-acb.png';

                    $overlayImage1 = imagecreatefrompng($overlayImage1Path);

                    // Kích thước mới của ảnh sẽ được chèn (tùy chỉnh theo yêu cầu)
                    $newWidth =  imagesx($sourceImage) - 20;
                    $newHeight = imagesy($overlayImage1);

                    // Chọn hàm tùy thuộc vào phiên bản PHP và yêu cầu của bạn
                    // Nếu sử dụng PHP >= 7.3, bạn có thể sử dụng imagescale
                    if (function_exists('imagescale')) {
                        $scaledOverlayImage1 = imagescale($overlayImage1, $newWidth, $newHeight);
                    } else {
                        // Sử dụng imagecopyresampled nếu không sử dụng được imagescale
                        $scaledOverlayImage1 = imagecreatetruecolor($newWidth, $newHeight);
                        imagecopyresampled($scaledOverlayImage1, $overlayImage1, 0, 0, 0, 0, $newWidth, $newHeight, imagesx($overlayImage1), imagesy($overlayImage1));
                    }

                    // Vị trí (x, y) để chèn ảnh sẽ được chèn (tùy chỉnh theo yêu cầu)
                    $positionX = 7; // Vị trí X
                    $positionY = 120; // Vị trí Y

                    // Chèn ảnh vào ảnh cơ sở
                    imagecopy($sourceImage, $scaledOverlayImage1, $positionX, $positionY, 0, 0, $newWidth, $newHeight);

                    imagettftext($sourceImage, 21, 0, 63, 340, imagecolorallocate($sourceImage, 0, 0, 0), $fontPath . '/Inter/Inter-Regular.ttf', 'ACB: TK ' . $_POST['stkgui'] . '(VND) - ' . number_format($_POST['amount']) . ' luc ' . date_format(date_create($_POST['time_bill']), "H:i d/m/Y") . '.');
                    imagettftext($sourceImage, 21, 0, 63, 390, imagecolorallocate($sourceImage, 0, 0, 0), $fontPath . '/Inter/Inter-Regular.ttf', 'So du: ' . number_format($_POST['sdc']) . '. GD: ' . $_POST['noidung']);
                    imagettftext($sourceImage, 21, 0, 63, 440, imagecolorallocate($sourceImage, 0, 0, 0), $fontPath . '/Inter/Inter-Regular.ttf',  '-' .  date_format(date_create($_POST['time_bill']), "dmy") . '-' . date_format(date_create($_POST['time_bill']), 'H:m:i'));
                }

                // Đọc ảnh sẽ được chèn
                $overlayImage = imagecreatefrompng($overlayImagePath);

                if (strpos($_POST['theme'], 'ios') !== false) {
                    // Kích thước mới của ảnh sẽ được chèn (tùy chỉnh theo yêu cầu)
                    $newWidth = 65;
                    $newHeight = 35;
                    $pinx = imagesx($sourceImage) - 150;
                    $piny = 47;
                }
                if (strpos($_POST['theme'], 'android') !== false) {
                    // Kích thước mới của ảnh sẽ được chèn (tùy chỉnh theo yêu cầu)
                    $newWidth = 60;
                    $newHeight = 55;
                    $pinx = 170;
                    $piny = 25;
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
