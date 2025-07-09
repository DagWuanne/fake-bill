<?php
require $_SERVER['DOCUMENT_ROOT'] . '/files/config.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
if ($webinfo['fakebillfree'] > 0) {
    DB::query("UPDATE settings SET fakebillfree=fakebillfree-1 WHERE id = '1'");
}
function canlephai($image, $fontsize, $y, $textColor, $font, $text)
{
    // Thiết lập kích thước font chữ
    $fontSize = $fontsize;


    $textBoundingBox = imagettfbbox($fontSize, 0, $font, $text);
    $textWidth = $textBoundingBox[2] - $textBoundingBox[0];
    $x = imagesx($image) - 70 - $textWidth;
    imagettftext($image, $fontSize, 0, $x, $y, $textColor, $font, $text);
}

function canchinhtien($image, $fontsize, $y, $textColor, $font, $text, $subtext = "VND", $subtextColor = null, $subtextFontsize = null, $subtextFont = null) {
    // Tính toán kích thước của số tiền
    $textBoundingBox = imagettfbbox($fontsize, 0, $font, $text);
    $textWidth = $textBoundingBox[2] - $textBoundingBox[0];
    $imageWidth = imagesx($image);

    // Tính toán vị trí x để căn giữa số tiền
    $x = ($imageWidth - $textWidth) / 2;
    imagettftext($image, $fontsize, 0, $x, $y, $textColor, $font, $text);

    // Sử dụng cỡ chữ và font riêng cho "VND" nếu được cung cấp, nếu không thì dùng cỡ chữ và font của số tiền
    $subtextFontsize = $subtextFontsize ?? $fontsize;
    $subtextFont = $subtextFont ?? $font;

    // Tính toán kích thước và vị trí cho chữ "VND"
    $subtextBoundingBox = imagettfbbox($subtextFontsize, 0, $subtextFont, $subtext);
    $subtextWidth = $subtextBoundingBox[2] - $subtextBoundingBox[0];
    $subtextX = $x + $textWidth + 15; // Thêm khoảng cách giữa số tiền và "VND"
    $subtextY = $y - $subtextFontsize -5; // Vị trí phía trên số tiền

    if ($subtextColor === null) {
        $subtextColor = $textColor; // Mặc định màu chữ "VND" giống màu số tiền
    }

    imagettftext($image, $subtextFontsize, 0, $subtextX, $subtextY, $subtextColor, $subtextFont, $subtext);
}

function getXLogo($image, $fontsize, $font, $text)
{
    // Thiết lập kích thước font chữ
    $marginRight = 10; // Khoảng cách từ mép phải của ảnh đến văn bản
    // Tính toán kích thước hộp giới hạn của văn bản
    $textBoundingBox = imagettfbbox($fontsize, 0, $font, $text);
    // Tính chiều rộng của văn bản
    $textWidth = $textBoundingBox[2] - $textBoundingBox[0];
    // Tính chiều rộng của hình ảnh
    $imageWidth = imagesx($image);
    // Tính vị trí x sao cho văn bản nằm sát mép phải với khoảng cách $marginRight
    $x = $imageWidth - $textWidth - $marginRight - 115;
    return $x;
}

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
                    'notifications' => 'Đã tạo 1 bill VCB, số tiền trừ ' . $tiengoc,
                    'username' => $username,
                    'amount' => $tiengoc
                ]);
            }
        }
        if (empty(trim($_POST['stk_nhan'])) || empty(trim($_POST['name_nhan'])) || empty(trim($_POST['amount'])) || empty(trim($_POST['noidung'])) || empty(trim($_POST['bank_nhan']))) {
            die('<span style="color:red">Vui lòng không bỏ trống dữ liệu</span>');
        }
        if ($_POST['theme'] == 'ios') {
            $theme = 'vcb1.png';
        }
        if ($_POST['theme'] == 'android') {
            $theme = 'vcbhuunhan456.png';
        }
        if ($_POST['theme'] == 'ios4g') {
            $theme = 'Tvcbhuunhan123.png';
        }
        if ($_POST['theme'] == 'android4g') {
            $theme = 'Tvcbhuunhan456.png';
        }
        if ($_POST['bdsd'] == '1') {
            if ($_POST['theme'] == 'ios') {
                $theme = 'vcb-bdsd1.png';
            }
            if ($_POST['theme'] == 'android') {
                $theme = 'vohuunhan1011.png';
            }
        }
        function xoaChuTrongChuoi($chuoi)
        {
            // Sử dụng biểu thức chính quy để xóa tất cả các kí tự là chữ
            $chuoiDaXoa = preg_replace('/[a-zA-Z]/', '', $chuoi);

            return str_replace('   ', ' ', $chuoiDaXoa);
        }
        if ($sodu >= $tiengoc) { {

                $sourceImage = imagecreatefrompng($theme);
                if ($watermark == 1) {
                     canchinhgiua($sourceImage, 25, 400, imagecolorallocate($sourceImage, 255, 0, 0), $_SERVER['DOCUMENT_ROOT'] . '/fonts/San Francisco/SanFranciscoText-Semibold.otf', 'Ảnh này chỉ để xem demo');
                    canchinhgiua($sourceImage, 25, 1140, imagecolorallocate($sourceImage, 255, 0, 0), $_SERVER['DOCUMENT_ROOT'] . '/fonts/San Francisco/SanFranciscoText-Semibold.otf', 'Vui lòng ấn vào nút' . "\n" . '"Tạo Bill" để xóa dòng chữ này' . "\n" . 'Đây chỉ là demo để xem trước khi tải');
                }
                if ($_POST['bdsd'] == '1') {
                    if (strpos($_POST['theme'], 'ios') !== false) {
                        imagettftext($sourceImage, 22, 0, 159, 195, imagecolorallocate($sourceImage, 11, 11, 11), $_SERVER['DOCUMENT_ROOT'] . '/fonts/Roboto/Roboto-Regular.ttf', 'Số dư TK VCB ' . trim($_POST['stkgui']) . ' -' . number_format($_POST['amount']) . ' VND lúc' . "\n" . xoaChuTrongChuoi(removeAccentsAndToUpper($_POST['time_bill'])) . ' số dư ' . number_format($_POST['sdc']) . ' VND' . "\n" . 'Ref MBVCB.' . trim($_POST['magiaodich']) . '.' . '0' . rand(00000, 99999) . '.' . implode(' ', array_slice(explode(' ', removeAccentsAndToUpper1($_POST['noidung'])), 0, 1)) . '...');
                    }
                    if (strpos($_POST['theme'], 'android') !== false) {
                        imagettftext($sourceImage, 21, 0, 155, 145, imagecolorallocate($sourceImage, 51, 51, 51), $_SERVER['DOCUMENT_ROOT'] . '/fonts/Roboto/Roboto-Regular.ttf', 'Số dư TK VCB ' . trim($_POST['stkgui']) . ' -' . number_format($_POST['amount']) . ' VND lúc' . "\n" . xoaChuTrongChuoi(removeAccentsAndToUpper($_POST['time_bill'])) . ' số dư ' . number_format($_POST['sdc']) . ' VND' . "\n" . 'Ref MBVCB.' . trim($_POST['magiaodich']) . '.' . '0' . rand(00000, 99999) . '.' . implode(' ', array_slice(explode(' ', removeAccentsAndToUpper1($_POST['noidung'])), 0, 1)) . '...');
                    }
                }
                if ($_POST['theme'] == 'ios') {
                    imagettftext($sourceImage, 26, 0, 105, 60, imagecolorallocate($sourceImage, 13, 13, 13), $_SERVER['DOCUMENT_ROOT'] . '/fonts/Inter/Inter-SemiBold.ttf', trim($_POST['time_dt']));
                }
                if ($_POST['theme'] == 'android') {
                    imagettftext($sourceImage, 21, 0, 740, 55, imagecolorallocate($sourceImage, 255, 255, 255), $_SERVER['DOCUMENT_ROOT'] . '/fonts/Roboto/Roboto-Bold.ttf', trim($_POST['time_dt']));
                }
                canchinhtien($sourceImage, 45, 475, imagecolorallocate($sourceImage, 20, 73, 54), $_SERVER['DOCUMENT_ROOT'] . '/fonts/Snv Becker Regular/Snv Becker Regular.ttf',  number_format(trim($_POST['amount']), 0, ',', ','),'VND',imagecolorallocate($sourceImage, 45, 129, 51),22,$_SERVER['DOCUMENT_ROOT'] . '/fonts/Inter/Inter-Regular.ttf');

                // canchinhgiua($sourceImage, 45, 465, imagecolorallocate($sourceImage, 20, 73, 54), $_SERVER['DOCUMENT_ROOT'] . '/bank/fonts/San Francisco/SanFranciscoText-Bold.otf', number_format(trim($_POST['amount']), 0, ',', ','));
                canchinhgiua($sourceImage, 22, 525, imagecolorallocate($sourceImage, 77, 77, 77), $_SERVER['DOCUMENT_ROOT'] . '/fonts/Inter/Inter-Regular.ttf', $_POST['time_bill']);

                $words = explode(' ', removeAccentsAndToUpper($_POST['name_nhan']));

                // Nếu số từ ít hơn hoặc bằng 4, trả về chuỗi gốc
                if (count($words) <= 4) {
                    canlephai($sourceImage, 25, 738, imagecolorallocate($sourceImage, 13, 13, 13), $_SERVER['DOCUMENT_ROOT'] . '/fonts/Inter/Inter-SemiBold.ttf', removeAccentsAndToUpper($_POST['name_nhan']));
                } else {
                    // Tính chỉ số giữa của mảng
                    $middleIndex = ceil(count($words) / 2);

                    // Tách mảng thành hai phần
                    $firstPart = implode(' ', array_slice($words, 0, $middleIndex));
                    $secondPart = implode(' ', array_slice($words, $middleIndex));
                    canlephai($sourceImage, 25, 725, imagecolorallocate($sourceImage, 13, 13, 13), $_SERVER['DOCUMENT_ROOT'] . '/fonts/Inter/Inter-SemiBold.ttf', removeAccentsAndToUpper($firstPart));
                    canlephai($sourceImage, 25, 765, imagecolorallocate($sourceImage, 13, 13, 13), $_SERVER['DOCUMENT_ROOT'] . '/fonts/Inter/Inter-SemiBold.ttf', removeAccentsAndToUpper($secondPart));
                }
                canlephai($sourceImage, 25, 645, imagecolorallocate($sourceImage, 13, 13, 13), $_SERVER['DOCUMENT_ROOT'] . '/fonts/Snv Becker Regular/Snv Becker Regular.ttf', trim($_POST['stk_nhan']));
                $words = explode(' ', $_POST['bank_nhan']);

                // Số từ cần lấy cho phần 1
                $countFirstPart = 1;

                // Lấy từng phần
                $logoBank = `<div class="h-[50px] w[50px] rounded-full mr-2 bg-white"><img src="./vcb.png"/></div>`;
                $firstPart = implode(' ', array_slice($words, 0, $countFirstPart));
                $secondPart = implode(' ', array_slice($words, $countFirstPart));
                $secondPart = str_replace('Thành phố Hồ Chí Minh', 'TP Hồ Chí Minh', $secondPart);
                canlephai($sourceImage, 17, 880, imagecolorallocate($sourceImage, 13, 13, 13), $_SERVER['DOCUMENT_ROOT'] . '/fonts/Inter/Inter-Regular.ttf', 'Ngân hàng ' . $firstPart . ' ' . $secondPart);
                canlephai($sourceImage, 25, 833, imagecolorallocate($sourceImage, 13, 13, 13), $_SERVER['DOCUMENT_ROOT'] . '/fonts/Inter/Inter-SemiBold.ttf', $logoBank . $_POST['code']);


                canlephai($sourceImage, 25, 1322, imagecolorallocate($sourceImage, 13, 13, 13), $_SERVER['DOCUMENT_ROOT'] . '/fonts/Snv Becker Regular/Snv Becker Regular.ttf', trim($_POST['magiaodich']));
                $words = explode(' ', removeAccentsAndToUpper1($_POST['noidung']));

                // Nếu số từ ít hơn hoặc bằng 4, trả về chuỗi gốc
                if (count($words) <= 4) {
                    canlephai($sourceImage, 25, 965, imagecolorallocate($sourceImage, 13, 13, 13), $_SERVER['DOCUMENT_ROOT'] . '/fonts/Inter/Inter-SemiBold.ttf', removeAccentsAndToUpper1($_POST['noidung']));
                } else {
                    // Tính chỉ số giữa của mảng
                    $middleIndex = ceil(count($words) / 2);

                    // Tách mảng thành hai phần
                    $firstPart = implode(' ', array_slice($words, 0, $middleIndex));
                    $secondPart = implode(' ', array_slice($words, $middleIndex));
                    canlephai($sourceImage, 25, 964, imagecolorallocate($sourceImage, 13, 13, 13), $_SERVER['DOCUMENT_ROOT'] . '/fonts/Inter/Inter-SemiBold.ttf', removeAccentsAndToUpper1($firstPart));
                    canlephai($sourceImage, 25, 1007, imagecolorallocate($sourceImage, 13, 13, 13), $_SERVER['DOCUMENT_ROOT'] . '/fonts/Inter/Inter-SemiBold.ttf', removeAccentsAndToUpper1($secondPart));
                }

                if ($_POST['type'] == '0') {
                    canlephai($sourceImage, 25, 1184, imagecolorallocate($sourceImage, 13, 13, 13), $_SERVER['DOCUMENT_ROOT'] . '/fonts/Inter/Inter-SemiBold.ttf', 'Chuyển tiền nhanh');
                    $iconImagePath = './napas.png';

                    $iconBank = imagecreatefrompng($iconImagePath);

                    // Kích thước mới của ảnh sẽ được chèn (tùy chỉnh theo yêu cầu)
                    $newWidth =  160;
                    $newHeight = 80;

                    // Chọn hàm tùy thuộc vào phiên bản PHP và yêu cầu của bạn
                    // Nếu sử dụng PHP >= 7.3, bạn có thể sử dụng imagescale
                    if (function_exists('imagescale')) {
                        $scaledOverlayIcon = imagescale($iconBank, $newWidth, $newHeight);
                    } else {
                        // Sử dụng imagecopyresampled nếu không sử dụng được imagescale
                        $scaledOverlayIcon = imagecreatetruecolor($newWidth, $newHeight);
                        imagecopyresampled($scaledOverlayIcon, $overlayImage1, 0, 0, 0, 0, $newWidth, $newHeight, imagesx($overlayImage1), imagesy($overlayImage1));
                    }

                    // Vị trí (x, y) để chèn ảnh sẽ được chèn (tùy chỉnh theo yêu cầu)
                    $positionX = 660; // Vị trí X
                    $positionY = 1189; // Vị trí Y
                    // Chèn ảnh vào ảnh cơ sở
                    imagecopy($sourceImage, $scaledOverlayIcon, $positionX, $positionY, 0, 0, $newWidth, $newHeight);
                } else {
                    canlephai($sourceImage, 25, 1183, imagecolorallocate($sourceImage, 13, 13, 13), $_SERVER['DOCUMENT_ROOT'] . '/fonts/Inter/Inter-SemiBold.ttf', 'Chuyển tiền trong');
                    canlephai($sourceImage, 25, 1227, imagecolorallocate($sourceImage, 13, 13, 13), $_SERVER['DOCUMENT_ROOT'] . '/fonts/Inter/Inter-SemiBold.ttf', 'Vietcombank');
                }



                $overlayImagePath = 'pin_' . str_replace('4g', '', $_POST['theme']) . '/' . $_POST['pin'] . '.png';
                // Đọc ảnh sẽ được chèn
                $overlayImage = imagecreatefrompng($overlayImagePath);

                if (strpos($_POST['theme'], 'ios') !== false) {
                    // Kích thước mới của ảnh sẽ được chèn (tùy chỉnh theo yêu cầu)
                    if ($_POST['bdsd'] == '1') {
                        $pinx = 755;
                        $piny = 35;
                    } else {
                        $pinx = 738;
                        $piny = 37;
                    }
                    $newWidth = 65;
                    $newHeight = 33;
                }
                if (strpos($_POST['theme'], 'android') !== false) {
                    // Kích thước mới của ảnh sẽ được chèn (tùy chỉnh theo yêu cầu)
                    $newWidth = 20;
                    $newHeight = 33;
                    $pinx = 700;
                    $piny = 35;
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



                // thêm logo bank vào tên bank
                $circleImagePath = './circle.png';

                $iconBank = imagecreatefrompng($circleImagePath);

                // Kích thước mới của ảnh sẽ được chèn (tùy chỉnh theo yêu cầu)
                $newWidth =  57;
                $newHeight = 57;

                // Chọn hàm tùy thuộc vào phiên bản PHP và yêu cầu của bạn
                // Nếu sử dụng PHP >= 7.3, bạn có thể sử dụng imagescale
                if (function_exists('imagescale')) {
                    $scaledOverlayCicle = imagescale($iconBank, $newWidth, $newHeight);
                } else {
                    // Sử dụng imagecopyresampled nếu không sử dụng được imagescale
                    $scaledOverlayCicle = imagecreatetruecolor($newWidth, $newHeight);
                    imagecopyresampled($scaledOverlayCicle, $overlayImage1, 0, 0, 0, 0, $newWidth, $newHeight, imagesx($overlayImage1), imagesy($overlayImage1));
                }

                // Vị trí (x, y) để chèn ảnh sẽ được chèn (tùy chỉnh theo yêu cầu)
                $positionX = getXLogo($sourceImage, 25, $_SERVER['DOCUMENT_ROOT'] . '/fonts/Inter/Inter-SemiBold.ttf', $_POST['code']) - 13; // Vị trí X; // Vị trí X
                $positionY = 788; // Vị trí Y

                // Chèn ảnh vào ảnh cơ sở
                imagecopy($sourceImage, $scaledOverlayCicle, $positionX, $positionY, 0, 0, $newWidth, $newHeight);



                // thêm logo bank vào tên bank
                $iconImagePath = $_SERVER['DOCUMENT_ROOT'] . '/icon_banks/' . strtolower($_POST['bank']) . '.png';

                $iconBank = imagecreatefrompng($iconImagePath);

                // Kích thước mới của ảnh sẽ được chèn (tùy chỉnh theo yêu cầu)
                $newWidth =  30;
                $newHeight = 30;

                // Chọn hàm tùy thuộc vào phiên bản PHP và yêu cầu của bạn
                // Nếu sử dụng PHP >= 7.3, bạn có thể sử dụng imagescale
                if (function_exists('imagescale')) {
                    $scaledOverlayIcon = imagescale($iconBank, $newWidth, $newHeight);
                } else {
                    // Sử dụng imagecopyresampled nếu không sử dụng được imagescale
                    $scaledOverlayIcon = imagecreatetruecolor($newWidth, $newHeight);
                    imagecopyresampled($scaledOverlayIcon, $overlayImage1, 0, 0, 0, 0, $newWidth, $newHeight, imagesx($overlayImage1), imagesy($overlayImage1));
                }

                // Vị trí (x, y) để chèn ảnh sẽ được chèn (tùy chỉnh theo yêu cầu)
                $positionX = getXLogo($sourceImage, 25, $_SERVER['DOCUMENT_ROOT'] . '/fonts/Inter/Inter-SemiBold.ttf', $_POST['code']); // Vị trí X
                $positionY = 802; // Vị trí Y
                // Chèn ảnh vào ảnh cơ sở
                imagecopy($sourceImage, $scaledOverlayIcon, $positionX, $positionY, 0, 0, $newWidth, $newHeight);

                //----------------------------------------------------------------//

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
