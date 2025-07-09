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
    $x = imagesx($image) - 60 - $textWidth;
    imagettftext($image, $fontSize, 0, $x, $y, $textColor, $font, $text);

}

function canletrai($image, $fontsize, $y, $textColor, $font, $text, $box2 = 270)
{


    // Thiết lập kích thước font chữ
    $fontSize = $fontsize;


    imagettftext($image, $fontSize, 0, $box2, $y, $textColor, $font, $text);

}

if (isset($_GET['type'])) {

    $username;
    $trongMB = $_POST['bank_nhan'] == 'Quân Đội';

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
        if (empty(trim($_POST['stk_nhan'])) || empty(trim($_POST['name_nhan'])) || empty(trim($_POST['amount'])) || empty(trim($_POST['noidung'])) || empty(trim($_POST['bank_nhan']))) {
            die ('<span style="color:red">Vui lòng không bỏ trống dữ liệu</span>');
        }

        $tmbStr = '';
        if ($trongMB) $tmbStr = 'trongmb_';
        if ($_POST['theme'] == 'ios4g') {
            if ($_POST['theme_bill'] == 'macdinh') {
                $theme = 'macdinh/'.$tmbStr.'xanh_4G_1.png';
            } else if ($_POST['theme_bill'] == 'priority') {
                $theme = 'priority/'.$tmbStr.'mbpri_4g_1.png';
            } else if ($_POST['theme_bill'] == 'tet') {
                $theme = 'tet/'.$tmbStr.'tet_4g_1.png';
            }

        }
        if ($_POST['theme'] == 'ioswifi') {
            if ($_POST['theme_bill'] == 'macdinh') {
                $theme = 'macdinh/'.$tmbStr.'xanh_wifi_1.png';
            } else if ($_POST['theme_bill'] == 'priority') {
                $theme = 'priority/'.$tmbStr.'mbpri_wifi_1.png';
            } else if ($_POST['theme_bill'] == 'tet') {
                $theme = 'tet/'.$tmbStr.'tet_wifi_1.png';
            }

        }

        if ($_POST['theme'] == 'android') {
            $theme = 'mb910.png';
        }
//        if ($_POST['theme'] == 'ios4g') {
//            $theme = 'mb123.png';
//        }
        if ($_POST['theme'] == 'android4g') {
            $theme = 'mb910.png';
        }
        if ($_POST['bdsd'] == '1') {
            if ($_POST['theme'] == 'ios4g') {
                //$theme = 'mb789.png';
                if ($_POST['theme_bill'] == 'macdinh') {
                    $theme = 'macdinh/'.$tmbStr.'xanh_4G_2.png';
                } else if ($_POST['theme_bill'] == 'priority') {
                    $theme = 'priority/'.$tmbStr.'mbpri_4G_2.png';
                } else if ($_POST['theme_bill'] == 'tet') {
                    $theme = 'tet/'.$tmbStr.'tet_4g_2.png';
                }
            }
            if ($_POST['theme'] == 'ioswifi') {
                if ($_POST['theme_bill'] == 'macdinh') {
                    $theme = 'macdinh/'.$tmbStr.'xanh_wifi_2.png';
                } else if ($_POST['theme_bill'] == 'priority') {
                    $theme = 'priority/'.$tmbStr.'mbpri_wifi_2.png';
                } else if ($_POST['theme_bill'] == 'tet') {
                    $theme = 'tet/'.$tmbStr.'tet_wifi_2.png';
                }

            }
            if ($_POST['theme'] == 'android') {

                $theme = 'mb1112.png';
            }
        }
        if ($sodu >= $tiengoc) {
            {

                $sourceImage = imagecreatefrompng($theme);

                if ($watermark == 1) {
                    canchinhgiua($sourceImage, 25, 400, imagecolorallocate($sourceImage, 255, 0, 0), $_SERVER['DOCUMENT_ROOT'] . '/fonts/San Francisco/SanFranciscoText-Semibold.otf', 'Ảnh này chỉ để xem demo');
                    canchinhgiua($sourceImage, 25, 1140, imagecolorallocate($sourceImage, 255, 0, 0), $_SERVER['DOCUMENT_ROOT'] . '/fonts/San Francisco/SanFranciscoText-Semibold.otf', 'Vui lòng ấn vào nút' . "\n" . '"Tải ảnh gốc" để xóa dòng chữ này' . "\n" . 'Đây chỉ là demo để xem trước khi tải');
                }
                if ($_POST['bdsd'] == '1') {
                    canletrai($sourceImage, 20, 155, imagecolorallocate($sourceImage, 255, 255, 255), $_SERVER['DOCUMENT_ROOT'] . '/fonts/Inter/Inter-Medium.ttf', 'Thông báo biến động số dư', 140);
                    $text = "12, 34";
                    $numbers = explode(', ', $_POST['time_bill']);
                    canletrai($sourceImage, 20, 195, imagecolorallocate($sourceImage, 255, 255, 255), $_SERVER['DOCUMENT_ROOT'] . '/fonts/Inter/Inter-Regular.ttf', 'TK ' . substr($_POST['stkgui'], 0, 2) . 'xxx' . substr($_POST['stkgui'], -3) . '|GD: -' . number_format($_POST['amount']) . 'VND ' . $numbers[1], 140);

                    canletrai($sourceImage, 20, 235, imagecolorallocate($sourceImage, 255, 255, 255), $_SERVER['DOCUMENT_ROOT'] . '/fonts/Inter/Inter-Regular.ttf', substr($numbers[0], 0, -3) . '|SD:' . number_format($_POST['sdc']) . 'VND|ND: ' . substr($_POST['noidung'], 0, 10) . '...', 140);
                }
                if (strpos($_POST['theme'], 'ios') != false or $_POST['theme'] == 'ios4g' or $_POST['theme'] == 'ioswifi') {
                    $r = 255;
                    $g = 255;
                    $b = 255;
                    if ($_POST['theme_bill'] == 'tet') {
                        $r = 0;
                        $g = 0;
                        $b = 0;
                    }
                    imagettftext($sourceImage, 28, 0, 105, 68, imagecolorallocate($sourceImage, $r, $g, $b), $_SERVER['DOCUMENT_ROOT'] . '/fonts/San Francisco/SanFranciscoText-Semibold_Fix.otf', trim($_POST['time_dt']));
                }
                if (strpos($_POST['theme'], 'android') !== false) {
                    imagettftext($sourceImage, 21, 0, 740, 58, imagecolorallocate($sourceImage, 255, 255, 255), $_SERVER['DOCUMENT_ROOT'] . '/fonts/San Francisco/SanFranciscoText-Semibold_Fix.otf', trim($_POST['time_dt']));
                }
                $r = 255;
                $g = 255;
                $b = 255;
                if ($_POST['theme_bill'] == 'tet') {
                    $r = 118;
                    $g = 29;
                    $b = 11;
                }
                canchinhgiua($sourceImage, 63, 338, imagecolorallocate($sourceImage, $r, $g, $b), $_SERVER['DOCUMENT_ROOT'] . '/fonts/AvertaStd/AvertaStd-Bold.otf', number_format(trim($_POST['amount']), 0, ',', ',') . ' VND');


                $words = explode(' ', removeAccentsAndToUpper($_POST['name_nhan']));

                // Nếu số từ ít hơn hoặc bằng 4, trả về chuỗi gốc
                if (count($words) <= 4) {
                    canlephai($sourceImage, 40, 632, imagecolorallocate($sourceImage, 255, 255, 255), $_SERVER['DOCUMENT_ROOT'] . '/fonts/San Francisco/SanFranciscoText-Bold.otf', removeAccentsAndToUpper($_POST['name_nhan']));
                } else {
                    // Tính chỉ số giữa của mảng
                    $middleIndex = ceil(count($words) / 2);

                    // Tách mảng thành hai phần
                    $firstPart = implode(' ', array_slice($words, 0, $middleIndex));
                    $secondPart = implode(' ', array_slice($words, $middleIndex));
                    canlephai($sourceImage, 30, 725, imagecolorallocate($sourceImage, 255, 255, 255), $_SERVER['DOCUMENT_ROOT'] . '/fonts/San Francisco/SanFranciscoText-Bold.otf', removeAccentsAndToUpper($firstPart));

                }
                canlephai($sourceImage, 30, 888, imagecolorallocate($sourceImage, 255, 255, 255), $_SERVER['DOCUMENT_ROOT'] . '/fonts/San Francisco/SanFranciscoText-Bold.otf', trim($_POST['stk_nhan']));
                $words = explode(' ', $_POST['bank_nhan']);

                // Số từ cần lấy cho phần 1
                $countFirstPart = 1;

                // Lấy từng phần
                $firstPart = implode(' ', array_slice($words, 0, $countFirstPart));
                $secondPart = implode(' ', array_slice($words, $countFirstPart));
                if (!$trongMB) {
                    canlephai($sourceImage, 25, 1254, imagecolorallocate($sourceImage, 0, 0, 0), $_SERVER['DOCUMENT_ROOT'] . '/fonts/AvertaStd/AvertaStd-Regular.otf', $_POST['magiaodich']);
                } else {
                    canlephai($sourceImage, 25, 1185, imagecolorallocate($sourceImage, 0, 0, 0), $_SERVER['DOCUMENT_ROOT'] . '/fonts/AvertaStd/AvertaStd-Regular.otf', $_POST['magiaodich']);

                }
                if ($_POST['code'] == 'MB' or $trongMB) {
                    canlephai($sourceImage, 25, 1120, imagecolorallocate($sourceImage, 0, 0, 0), $_SERVER['DOCUMENT_ROOT'] . '/fonts/AvertaStd/AvertaStd-Regular.otf', 'Trong MB');
                } else {

                    if (trim($_POST['loaichuyen']) == 'nhanh') {
                        canlephai($sourceImage, 25, 1153, imagecolorallocate($sourceImage, 0, 0, 0), $_SERVER['DOCUMENT_ROOT'] . '/fonts/AvertaStd/AvertaStd-Regular.otf', 'Chuyển nhanh Napas');
                        canlephai($sourceImage, 25, 1190, imagecolorallocate($sourceImage, 0, 0, 0), $_SERVER['DOCUMENT_ROOT'] . '/fonts/AvertaStd/AvertaStd-Regular.otf', '247');
                    } else {
                        canlephai($sourceImage, 25, 1153, imagecolorallocate($sourceImage, 0, 0, 0), $_SERVER['DOCUMENT_ROOT'] . '/fonts/AvertaStd/AvertaStd-Regular.otf', 'Chuyển chậm');
                    }
                }
                if ($trongMB){
                    canlephai($sourceImage, 25, 1060, imagecolorallocate($sourceImage, 0, 0, 0), $_SERVER['DOCUMENT_ROOT'] . '/fonts/AvertaStd/AvertaStd-Regular.otf', $_POST['time_bill']);
                } else {
                    canlephai($sourceImage, 25, 1090, imagecolorallocate($sourceImage, 0, 0, 0), $_SERVER['DOCUMENT_ROOT'] . '/fonts/AvertaStd/AvertaStd-Regular.otf', $_POST['time_bill']);

                }
//                $words = mb_strlen($_POST['noidung'], 'UTF-8');
//
//                // Nếu số từ ít hơn hoặc bằng 4, trả về chuỗi gốc
//                if ($words < 30) {
//                    if ($trongMB) {
//                        canlephai($sourceImage, 25, 960, imagecolorallocate($sourceImage, 0, 0, 0), $_SERVER['DOCUMENT_ROOT'] . '/fonts/AvertaStd/AvertaStd-Regular.otf', $_POST['noidung']);
//
//                    } else {
//                        canlephai($sourceImage, 25, 990, imagecolorallocate($sourceImage, 0, 0, 0), $_SERVER['DOCUMENT_ROOT'] . '/fonts/AvertaStd/AvertaStd-Regular.otf', $_POST['noidung']);
//
//                    }
//                } else {
//                    $firstPart = substr($_POST['noidung'], 0, 30);
//
//// Lấy các kí tự từ kí tự thứ 15 trở đi
//                    $secondPart = substr($_POST['noidung'], 30);
//
//                    if ($trongMB) {
//                        canlephai($sourceImage, 25, 965, imagecolorallocate($sourceImage, 0, 0, 0), $_SERVER['DOCUMENT_ROOT'] . '/fonts/AvertaStd/AvertaStd-Regular.otf', $firstPart);
//                        canlephai($sourceImage, 25, 1005, imagecolorallocate($sourceImage, 0, 0, 0), $_SERVER['DOCUMENT_ROOT'] . '/fonts/AvertaStd/AvertaStd-Regular.otf', $secondPart);
//                    } else {
//                        canlephai($sourceImage, 25, 990, imagecolorallocate($sourceImage, 0, 0, 0), $_SERVER['DOCUMENT_ROOT'] . '/fonts/AvertaStd/AvertaStd-Regular.otf', $firstPart);
//                        canlephai($sourceImage, 25, 1030, imagecolorallocate($sourceImage, 0, 0, 0), $_SERVER['DOCUMENT_ROOT'] . '/fonts/AvertaStd/AvertaStd-Regular.otf', $secondPart);
//                    }
//
//                }


//                $words = mb_strlen($_POST['noidung'], 'UTF-8');
                $words = explode(" ", $_POST['noidung']);

                // Kiểm tra số từ trong chuỗi
                $numWords = count($words);

                // Nếu số từ ít hơn hoặc bằng 4, trả về chuỗi gốc
                if ($numWords < 5) {
                    if ($trongMB) {
                        canlephai($sourceImage, 25, 960, imagecolorallocate($sourceImage, 0, 0, 0), $_SERVER['DOCUMENT_ROOT'] . '/fonts/AvertaStd/AvertaStd-Regular.otf', $_POST['noidung']);

                    } else {
                        canlephai($sourceImage, 25, 990, imagecolorallocate($sourceImage, 0, 0, 0), $_SERVER['DOCUMENT_ROOT'] . '/fonts/AvertaStd/AvertaStd-Regular.otf', $_POST['noidung']);

                    }
                } else {
//                    $midIndex = ceil($numWords / 2);
                    $lW = 0;
                    $sW = 0;
                    for ($i = 0 ; $i < $numWords ; $i ++){
                        $lW += strlen($words[$i]);
                        $sW ++;
                        if ($lW >= 25) {
                            $sW --;
                            break;
                        }
                    }
                    $firstPart = implode(" ", array_slice($words, 0, $sW));
                    $secondPart = implode(" ", array_slice($words, $sW));

                    if ($trongMB) {
                        canlephai($sourceImage, 25, 965, imagecolorallocate($sourceImage, 0, 0, 0), $_SERVER['DOCUMENT_ROOT'] . '/fonts/AvertaStd/AvertaStd-Regular.otf', $firstPart);
                        canlephai($sourceImage, 25, 1005, imagecolorallocate($sourceImage, 0, 0, 0), $_SERVER['DOCUMENT_ROOT'] . '/fonts/AvertaStd/AvertaStd-Regular.otf', $secondPart);
                    } else {
                        canlephai($sourceImage, 25, 990, imagecolorallocate($sourceImage, 0, 0, 0), $_SERVER['DOCUMENT_ROOT'] . '/fonts/AvertaStd/AvertaStd-Regular.otf', $firstPart);
                        canlephai($sourceImage, 25, 1030, imagecolorallocate($sourceImage, 0, 0, 0), $_SERVER['DOCUMENT_ROOT'] . '/fonts/AvertaStd/AvertaStd-Regular.otf', $secondPart);
                    }

                }

//


                if($trongMB){
                    canlephai($sourceImage, 25, 895, imagecolorallocate($sourceImage, 0, 0, 0), $_SERVER['DOCUMENT_ROOT'] . '/fonts/AvertaStd/AvertaStd-Bold.otf', removeAccentsAndToUpper($_POST['name_gui']));
                    canlephai($sourceImage, 25, 855, imagecolorallocate($sourceImage, 0, 0, 0), $_SERVER['DOCUMENT_ROOT'] . '/fonts/AvertaStd/AvertaStd-Regular.otf', $_POST['stkgui']);
                } else {
                    canlephai($sourceImage, 25, 925, imagecolorallocate($sourceImage, 0, 0, 0), $_SERVER['DOCUMENT_ROOT'] . '/fonts/AvertaStd/AvertaStd-Bold.otf', removeAccentsAndToUpper($_POST['name_gui']));
                    canlephai($sourceImage, 25, 887, imagecolorallocate($sourceImage, 0, 0, 0), $_SERVER['DOCUMENT_ROOT'] . '/fonts/AvertaStd/AvertaStd-Regular.otf', $_POST['stkgui']);
                }

                canletrai($sourceImage, 25, 630, imagecolorallocate($sourceImage, 0, 0, 0), $_SERVER['DOCUMENT_ROOT'] . '/fonts/AvertaStd/AvertaStd-Bold.otf', removeAccentsAndToUpper($_POST['name_nhan']), 150);
                canletrai($sourceImage, 25, 670, imagecolorallocate($sourceImage, 0, 0, 0), $_SERVER['DOCUMENT_ROOT'] . '/fonts/AvertaStd/AvertaStd-Regular.otf', $_POST['stk_nhan'], 150);
                canletrai($sourceImage, 24, 710, imagecolorallocate($sourceImage, 0, 0, 0), $_SERVER['DOCUMENT_ROOT'] . '/fonts/AvertaStd/AvertaStd-Regular.otf',  ($trongMB == true ? "Quân Đội " : 'Ngân hàng ' . $_POST['bank_nhan'] . "\n") . '(' . strtoupper($_POST['code']) . ')', 150);

                // if (!in_array($_POST['code'], array("TCB", "MBBank", "STB"))) {
                //     $childImage = imagecreatefromstring(file_get_contents('https://img.mservice.com.vn/momo_app_v2/img/' . $_POST['code'] . '.png'));

                // } else {
                //     $childImage = imagecreatefrompng( 'icons/' . $_POST['code'] . '.png');
                // }
                $childImage = imagecreatefrompng( 'icons/' . $_POST['code'] . '.png');

// Lấy kích thước của ảnh con
                $childWidth = imagesx($childImage);
                $childHeight = imagesy($childImage);

// Kích thước mới của ảnh con
                $newChildWidth = 50;
                $newChildHeight = 50;

// Tạo ảnh con mới với kích thước mới
                $resizedChildImage = imagescale($childImage, $newChildWidth, $newChildHeight);

// Chèn ảnh con đã co dãn vào hình ảnh chính
                if ($trongMB) {
                    imagecopy($sourceImage, $resizedChildImage, 55, 635, 0, 0, $newChildWidth, $newChildHeight);

                } else {
                    imagecopy($sourceImage, $resizedChildImage, 55, 650, 0, 0, $newChildWidth, $newChildHeight);

                }

// Giải phóng bộ nhớ ảnh con đã co dãn
                imagedestroy($resizedChildImage);



                $overlayImagePath = 'pin_' . str_replace('ios4g', 'ios', $_POST['theme']) . '/' . $_POST['pin'] . '.png';
                $overlayImagePath = 'pin_' . str_replace('wifi', '', $_POST['theme']) . '/' . $_POST['pin'] . '.png';


                if ($_POST['theme'] == 'ios4g' or $_POST['theme'] == 'ioswifi') {
                    $overlayImagePath = $_POST['theme_bill'] . '/pin' . '/' . $_POST['pin'] . '.png';
                }


                // Đọc ảnh sẽ được chèn
                $overlayImage = imagecreatefrompng($overlayImagePath);



                if (strpos($_POST['theme'], 'ios') !== false) {
                    // Kích thước mới của ảnh sẽ được chèn (tùy chỉnh theo yêu cầu)
                    $newWidth = 58;
                    $newHeight = 27;
                    $pinx = 695;
                    $piny = 43;
                }
                if (strpos($_POST['theme'], 'android') !== false) {
                    // Kích thước mới của ảnh sẽ được chèn (tùy chỉnh theo yêu cầu)
                    $newWidth = 20;
                    $newHeight = 30;
                    $pinx = 700;
                    $piny = 31;
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
