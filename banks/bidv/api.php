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
function canlephai($image, $fontsize, $y, $textColor, $font, $text)
{


    // Thiết lập kích thước font chữ
    $fontSize = $fontsize;


    $textBoundingBox = imagettfbbox($fontSize, 0, $font, $text);
    $textWidth = $textBoundingBox[2] - $textBoundingBox[0];
    $x = imagesx($image) - 315 - $textWidth;
    imagettftext($image, $fontSize, 0, $x, $y, $textColor, $font, $text);
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

// function canchinhgiua($image, $fontsize, $y, $textColor, $font, $text)
// {
//     $fontSize = $fontsize;
//     $textBoundingBox = imagettfbbox($fontSize, 0, $font, $text);
//     $textWidth = $textBoundingBox[2] - $textBoundingBox[0];
//     $imageWidth = imagesx($image);
//     $x =($imageWidth - $textWidth) / 2; // Căn giữa theo chiều ngang
//     imagettftext($image, $fontSize, 0, $x, $y, $textColor, $font, $text);
// }

$fontPath =  $_SERVER['DOCUMENT_ROOT'] . '/fonts';
try {
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
                        'notifications' => 'Đã tạo 1 bill BIDV, số tiền trừ ' . $tiengoc,
                        'username' => $username,
                        'amount' => $tiengoc
                    ]);
                }
            }
            if ($_POST['theme'] == 'ios') {
                $theme = 'bidv.png';
            }
            if ($_POST['theme'] == 'android') {
                $theme = 'vp910.png';
            }
            if ($_POST['theme'] == 'ios4g') {
                $theme = 'bidv.png';
            }
            if ($_POST['theme'] == 'android4g') {
                $theme = 'vp910.png';
            }
            if ($_POST['bdsd'] == '1') {
                if ($_POST['theme'] == 'ios') {
                    $theme = 'bdsd-bidv.png';
                }
                if ($_POST['theme'] == 'android') {
                    $theme = 'vp1011.png';
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

                        imagettftext($sourceImage, 23, 0, 163, 200, imagecolorallocate($sourceImage, 0, 0, 0), $_SERVER['DOCUMENT_ROOT'] . '/fonts/Roboto/Roboto-Regular.ttf', $_POST['time_dt'] . ' ' . $_POST['time_bill'] . '. Tài khoản thanh toán' . "\n" . $_POST['stkgui'] . '. Số tiền -' . number_format($_POST['amount']) . 'VND. Số dư cuối:' . "\n" . number_format($_POST['sdc']) . 'VND Nội dung giao dịch: MB-TKThe:' . substr($_POST['stk_nhan'], 0, -3) . '...');
                    }
                    if (strpos($_POST['theme'], 'ios') !== false) {
                        if ($_POST['bdsd'] == '1') {
                            imagettftext($sourceImage, 27, 0, 110, 65, imagecolorallocate($sourceImage, 255, 255, 255), $fontPath . '/San Francisco/SanFranciscoText-Semibold.otf', mb_strlen($_POST['time_dt']) == 8 ? substr($_POST['time_dt'], 0, 5) : substr($_POST['time_dt'], 0, 4));
                        } else {
                            imagettftext($sourceImage, 27, 0, 110, 65, imagecolorallocate($sourceImage, 0, 0, 0), $fontPath . '/San Francisco/SanFranciscoText-Semibold.otf', mb_strlen($_POST['time_dt']) == 8 ? substr($_POST['time_dt'], 0, 5) : substr($_POST['time_dt'], 0, 4));
                        }
                    }
                    if (strpos($_POST['theme'], 'android') !== false) {
                        imagettftext($sourceImage, 27, 0, 120, 100, imagecolorallocate($sourceImage, 0, 0, 0), $_SERVER['DOCUMENT_ROOT'] . '/fonts/Inter/Inter-SemiBold.ttf', trim($_POST['time_dt']));
                    }
                    function removebankname($str)
                    {

                        return $str;
                    }
                    canchinhgiua($sourceImage, 26, 850, imagecolorallocate($sourceImage, 61, 68, 87), $fontPath . '/Mulish/Mulish-SemiBold.ttf', 'Quý khách đã chuyển thành công đến số tài ');
                    $number = $_POST['amount'];
                    $vndText = 'khoản';
                    $numberSize = 27;
                    $vndSize = 26;

                    $vndBox = imagettfbbox($vndSize, 0, $fontPath . '/Mulish/Mulish-SemiBold.ttf', $vndText);
                    $vndWidth = $vndBox[2] - $vndBox[0];
                    $vndX = $numberX + $numberWidth + 90;
                    $vndY = 910;
                    imagettftext($sourceImage, $vndSize, 0, $vndX, $vndY, imagecolorallocate($sourceImage, 61, 68, 87), $fontPath . '/Mulish/Mulish-SemiBold.ttf', $vndText);
                    $fullText = $greenText = $_POST['stk_nhan'] . '/ ' . removeAccentsAndToUpper($_POST['name_nhan']) . '/ ' . 'NH ' . removebankname(removeAccentsAndToUpper($_POST['code']));
                    $vndBox = imagettfbbox($vndSize, 0, $fontPath . '/Mulish/Mulish-SemiBold.ttf', $vndText);
                    $vndWidth = $vndBox[2] - $vndBox[0];
                    $vndX = $vndX + $vndWidth + 10;
                    $vndY = 910;

                    $stk = explode(' ', $_POST['stk_nhan']);
                    $words2s = explode(' ', $fullText);
                    $name = explode(' ', $_POST['name_nhan']);
                    if (count($name) < 4) {
                        if (mb_strlen($_POST['stk_nhan'], 'UTF-8') > 12) {
                            $middleIndex = ceil(count($words2s) / 1.25);
                        } else {
                            $middleIndex = ceil(count($words2s) / 1);
                        }
                    } else if (count($name) < 7) {
                        if (mb_strlen($_POST['stk_nhan'], 'UTF-8') > 12) {
                            $middleIndex = ceil(count($words2s) / 1.75);
                        } else {
                            $middleIndex = ceil(count($words2s) / 1.5);
                        }
                    } else {
                        $middleIndex = ceil(count($words2s) / 2.5);
                    }

                    // Tách mảng thành hai phần
                    $firstPart = implode(' ', array_slice($words2s, 0, $middleIndex));
                    $secondPart = implode(' ', array_slice($words2s, $middleIndex));
                    imagettftext($sourceImage, $vndSize, 0, $vndX, $vndY, imagecolorallocate($sourceImage, 0, 102, 173), $fontPath . '/Mulish/Mulish-Bold.ttf', $firstPart);
                    $vndBox = imagettfbbox($vndSize, 0, $fontPath . '/Mulish/Mulish-Bold.ttf', $secondPart);
                    $vndWidth = $vndBox[2] - $vndBox[0];
                    $vndX = $numberX + $numberWidth + 90;
                    imagettftext($sourceImage, $vndSize, 0, $vndX, 970, imagecolorallocate($sourceImage, 0, 102, 173), $fontPath . '/Mulish/Mulish-Bold.ttf', $secondPart);
                    $vndBox = imagettfbbox($vndSize, 0, $fontPath . '/Mulish/Mulish-Bold.ttf', $secondPart);
                    $vndWidth = $vndBox[2] - $vndBox[0];
                    $vndX = $vndX + $vndWidth + 10;
                    $fullText =  ' vào lúc ' . $_POST['time_bill'] . ' ' . $_POST['time_dt'] . ' Nội dung: ' . $_POST['noidung'];
                    $middleIndex = null;
                    $words2s = explode(' ', $fullText);
                    if (count($name) < 4) {
                        if (mb_strlen($_POST['stk_nhan'], 'UTF-8') > 12) {
                            $middleIndex = ceil(count($words2s) / 1.75);
                        } else {
                            $middleIndex = ceil(count($words2s) / 1.5);
                        }
                    } else if (count($name) < 7) {
                        $middleIndex = ceil(count($words2s) / 1.75);
                    } else {
                        $middleIndex = ceil(count($words2s) / 3);
                    }

                    // Tách mảng thành hai phần
                    $firstPart = implode(' ', array_slice($words2s, 0, $middleIndex));
                    $secondPart = implode(' ', array_slice($words2s, $middleIndex));
                    imagettftext($sourceImage, $vndSize, 0, $vndX, 970, imagecolorallocate($sourceImage, 61, 68, 87), $fontPath . '/Mulish/Mulish-SemiBold.ttf', $firstPart);
                    canchinhgiua($sourceImage, 26, 1030, imagecolorallocate($sourceImage, 61, 68, 87), $fontPath . '/Mulish/Mulish-SemiBold.ttf', $secondPart);






                    // $vndBox = imagettfbbox($vndSize, 0, $fontPath . '/Mulish/Mulish-SemiBold.ttf', $vndText);
                    // $vndWidth = $vndBox[2] - $vndBox[0];
                    // $vndX = $vndX + $vndWidth + 10;
                    // $vndY = 910;
                    // imagettftext($sourceImage, $vndSize, 0, $vndX, $vndY, imagecolorallocate($sourceImage, 0, 102, 173), $fontPath . '/Mulish/Mulish-SemiBold.ttf', $_POST['stk_nhan']);

                    // $vndBox = imagettfbbox($vndSize, 0, $fontPath . '/Mulish/Mulish-SemiBold.ttf', $_POST['stk_nhan']);
                    // $vndWidth = $vndBox[2] - $vndBox[0];
                    // $vndX = $vndX + $vndWidth + 10;
                    // $vndY = 910;
                    // imagettftext($sourceImage, $vndSize, 0, $vndX, $vndY, imagecolorallocate($sourceImage, 0, 102, 173), $fontPath . '/Mulish/Mulish-SemiBold.ttf', '/');
                    // $vndBox = imagettfbbox($vndSize, 0, $fontPath . '/Mulish/Mulish-SemiBold.ttf', '/');
                    // $vndWidth = $vndBox[2] - $vndBox[0];
                    // $vndX = $vndX + $vndWidth + 10;
                    // $vndY = 910;
                    // $words2s = explode(' ', removeAccentsAndToUpper($_POST['name_nhan']));
                    // $middleIndex = ceil(count($words2s) / count($words2s));

                    // // Tách mảng thành hai phần
                    // $firstPart = implode(' ', array_slice($words2s, 0, $middleIndex));
                    // $secondPart = implode(' ', array_slice($words2s, $middleIndex));
                    // imagettftext($sourceImage, $vndSize, 0, $vndX, $vndY, imagecolorallocate($sourceImage, 0, 102, 173), $fontPath . '/Mulish/Mulish-SemiBold.ttf', $firstPart);
                    // $vndBox = imagettfbbox($vndSize, 0, $fontPath . '/Mulish/Mulish-SemiBold.ttf', $firstPart);
                    // $vndWidth = $vndBox[2] - $vndBox[0];
                    // $vndX = $vndX + $vndWidth + 10;
                    // imagettftext($sourceImage, $vndSize, 0, $vndX + 10, $vndY, imagecolorallocate($sourceImage, 0, 102, 173), $fontPath . '/Mulish/Mulish-SemiBold.ttf', $secondPart);
                    // $vndBox = imagettfbbox($vndSize, 0, $fontPath . '/Mulish/Mulish-SemiBold.ttf', $secondPart);
                    // $vndWidth = $vndBox[2] - $vndBox[0];
                    // $vndX = $vndX + $vndWidth + 10;
                    // imagettftext($sourceImage, $vndSize, 0, $vndX, $vndY, imagecolorallocate($sourceImage, 61, 68, 87), $fontPath . '/Mulish/Mulish-SemiBold.ttf', '/');
                    // $vndBox = imagettfbbox($vndSize, 0, $fontPath . '/Mulish/Mulish-SemiBold.ttf', '/');
                    // $vndWidth = $vndBox[2] - $vndBox[0];
                    // $vndX = $vndX + $vndWidth + 10;
                    // imagettftext($sourceImage, $vndSize, 0, $vndX, $vndY, imagecolorallocate($sourceImage, 0, 102, 173), $fontPath . '/Mulish/Mulish-SemiBold.ttf', 'NH ' . removebankname(removeAccentsAndToUpper($_POST['code'])));

                    // // canchinhgiua($sourceImage, 26, 1110, imagecolorallocate($sourceImage, 61, 68, 87), $fontPath . '/Mulish/Mulish-SemiBold.ttf', 'vào lúc ' . $_POST['time_bill'] . ' ' . $_POST['time_dt'] . ' Nội dung: ' . $_POST['noidung']);

                    // $words2s = explode(' ', 'vào lúc ' . $_POST['time_bill'] . ' ' . $_POST['time_dt'] . ' Nội dung: ' . $_POST['noidung']);
                    // $middleIndex = ceil(count($words2s) / 1.75);

                    // // Tách mảng thành hai phần
                    // // $vndBox = imagettfbbox($vndSize, 0, $fontPath . '/Mulish/Mulish-SemiBold.ttf', '/');
                    // // $vndWidth = $vndBox[2] - $vndBox[0];
                    // // $vndX = $vndX + $vndWidth + 10;
                    // $firstPart = implode(' ', array_slice($words2s, 0, $middleIndex));
                    // $secondPart = implode(' ', array_slice($words2s, $middleIndex));
                    // // imagettftext($sourceImage, $vndSize, 0, $vndX, $vndY, imagecolorallocate($sourceImage, 0, 102, 173), $fontPath . '/Mulish/Mulish-SemiBold.ttf', $firstPart);
                    // canchinhgiua($sourceImage, 26, 970, imagecolorallocate($sourceImage, 61, 68, 87), $fontPath . '/Mulish/Mulish-SemiBold.ttf', $firstPart);
                    // canchinhgiua($sourceImage, 26, 1030, imagecolorallocate($sourceImage, 61, 68, 87), $fontPath . '/Mulish/Mulish-SemiBold.ttf', $secondPart);


                    // $number = $_POST['amount'];
                    // $vndText = ' đến số tài khoản';
                    // $numberSize = 35;
                    // $vndSize = 26;

                    // $numberBox = imagettfbbox($numberSize, 0, $fontPath . '/Mulish/Mulish-SemiBold.ttf', number_format($number) . ' VND');
                    // $numberWidth = $numberBox[2] - $numberBox[0];
                    // $numberX = 150;
                    // $numberY = 910;
                    // imagettftext($sourceImage, $numberSize, 0, $numberX, $numberY, imagecolorallocate($sourceImage, 0, 102, 173), $fontPath . '/Mulish/Mulish-SemiBold.ttf', $secondPart);

                    // $numberBox = imagettfbbox($numberSize, 0, $fontPath . '/Mulish/Mulish-SemiBold.ttf', $secondPart);
                    // $numberWidth = $numberBox[2] - $numberBox[0];
                    // imagettftext($sourceImage, $numberSize, 0,  $numberX + $numberWidth, $numberY, imagecolorallocate($sourceImage, 61, 68, 87), $fontPath . '/Mulish/Mulish-SemiBold.ttf', '/');
                    // $numberBox = imagettfbbox($numberSize, 0, $fontPath . '/Mulish/Mulish-SemiBold.ttf', $secondPart . '/');
                    // $numberWidth = $numberBox[2] - $numberBox[0];
                    // imagettftext($sourceImage, $numberSize, 0,  $numberX + $numberWidth, $numberY, imagecolorallocate($sourceImage, 0, 102, 173), $fontPath . '/Mulish/Mulish-SemiBold.ttf', 'NH ' . removebankname(removeAccentsAndToUpper($_POST['code'])));
                    // $numberBox = imagettfbbox($numberSize, 0, $fontPath . '/Mulish/Mulish-SemiBold.ttf', $secondPart . '/' . 'NH ' . removebankname(removeAccentsAndToUpper($_POST['code'])));
                    // $numberWidth = $numberBox[2] - $numberBox[0];
                    // if (count($words2s) <= 3) {
                    //     imagettftext($sourceImage, $numberSize, 0,  $numberX + $numberWidth, $numberY, imagecolorallocate($sourceImage, 61, 68, 87), $fontPath . '/Mulish/Mulish-SemiBold.ttf', ' vào lúc ' . $_POST['time_bill'] . ' ' . $_POST['time_dt']);
                    //     canchinhgiua($sourceImage, 35, 1285, imagecolorallocate($sourceImage, 61, 68, 87), $fontPath . '/Mulish/Mulish-SemiBold.ttf', 'Nội dung: ');
                    //     canchinhgiua($sourceImage, 35, 1350, imagecolorallocate($sourceImage, 61, 68, 87), $fontPath . '/Mulish/Mulish-SemiBold.ttf', $_POST['noidung']);
                    // } else {
                    //     imagettftext($sourceImage, $numberSize, 0,  $numberX + $numberWidth, $numberY, imagecolorallocate($sourceImage, 61, 68, 87), $fontPath . '/Mulish/Mulish-SemiBold.ttf', ' vào lúc ');
                    //     canchinhgiua($sourceImage, 35, 1285, imagecolorallocate($sourceImage, 61, 68, 87), $fontPath . '/Mulish/Mulish-SemiBold.ttf',  $_POST['time_bill'] . ' ' . $_POST['time_dt'] . ' Nội dung: ');
                    //     canchinhgiua($sourceImage, 35, 1350, imagecolorallocate($sourceImage, 61, 68, 87), $fontPath . '/Mulish/Mulish-SemiBold.ttf', $_POST['noidung']);
                    // }

                    canlephai($sourceImage, 23, 756, imagecolorallocate($sourceImage, 117, 117, 117), $fontPath . '/Mulish/Mulish-Bold.ttf', trim($_POST['magiaodich']));
                    canchinhgiua($sourceImage, 36, 690, imagecolorallocate($sourceImage, 3, 128, 173), $fontPath . '/Mulish/Mulish-Bold.ttf', number_format($_POST['amount']) . " VND");
                    $overlayImagePath = 'pin_' . str_replace('4g', '', $_POST['theme']) . '/' . $_POST['pin'] . '.png';

                    // Đọc ảnh sẽ được chèn
                    $overlayImage = imagecreatefrompng($overlayImagePath);

                    if (strpos($_POST['theme'], 'ios') !== false) {
                        // Kích thước mới của ảnh sẽ được chèn (tùy chỉnh theo yêu cầu)
                        $newWidth = 65;
                        $newHeight = 35;
                        $pinx = 825;
                        $piny = 37;
                    }
                    if (strpos($_POST['theme'], 'android') !== false) {
                        // Kích thước mới của ảnh sẽ được chèn (tùy chỉnh theo yêu cầu)
                        $newWidth = 50;
                        $newHeight = 47;
                        $pinx = 1165;
                        $piny = 63;
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
} catch (Exception $e) {
    echo 'L��i: ' . $e->getMessage();
}
