<?php
require $_SERVER['DOCUMENT_ROOT'].'/files/config.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST"); 
if($webinfo['fakebillfree'] > 0){
    DB::query("UPDATE settings SET fakebillfree=fakebillfree-1 WHERE id = '1'");
}
function canletrai($image,$fontsize,$y,$textColor,$font,$text,$x_tcb){

    
    // Thiết lập kích thước font chữ
    $fontSize = $fontsize;
    

    imagettftext($image, $fontSize, 0, $x_tcb, $y, $textColor, $font, $text);

}
function cangiua($image, $fontsize, $y, $textColor, $font, $text) {
    $fontSize = $fontsize;
    $textBoundingBox = imagettfbbox($fontSize, 0, $font, $text);
    $textWidth = $textBoundingBox[2] - $textBoundingBox[0];
    $imageWidth = imagesx($image);
    $x = ($imageWidth - $textWidth) / 2; // Căn giữa theo chiều ngang
    imagettftext($image, $fontSize, 0, $x, $y, $textColor, $font, $text);
}
 function alignRight($image, $text, $font, $size, $color, $y,$nhan=50)
        {
            $bbox = imagettfbbox($size, 0, $font, $text);
            $text_width = $bbox[2] - $bbox[0];
            $x = imagesx($image) - $text_width - $nhan; // Điều chỉnh giá trị 10 tùy theo lề phải mong muốn
            imagettftext($image, $size, 0, $x, $y, $color, $font, $text);
        }
        function convertCurrencyToWords($amount)
{
  $data = file_get_contents('http://forum.vdevs.net/nossl/mtw.php?number='.$amount);
$data = json_decode($data, true);
if ($data['success'] == true) {
    return htmlspecialchars($data['result']);
}
}

$fontPath =  $_SERVER['DOCUMENT_ROOT'].'/fonts';
if(isset($_GET['type'])){

    $username;
    if(isset($_POST['key'])){
       $username = xss_clean(DB::queryFirstField("SELECT username FROM users WHERE serial_key = '".trim($_POST['key'])."' LIMIT 1"));
    }
    
    if(!empty($username) || $_GET['type'] == 'demo'){
         $timestampHetHan = strtotime(DB::queryFirstField("SELECT date_bill FROM `users` WHERE username = '$username'"));
            if (time() < $timestampHetHan) {
                $tiengoc = 0;
            }
        $sodu = DB::queryFirstField("SELECT sodu FROM `users` WHERE username = '$username'");
        if($_GET['type'] == 'demo'){
            $tiengoc = 0;
            $watermark = 1;
        } else {
            DB::query("UPDATE settings SET luottaobill=luottaobill+1 WHERE id = '1'");
            $sodu = DB::queryFirstField("SELECT sodu FROM `users` WHERE username = '$username'");
            if($sodu >= $tiengoc){
            $watermark = 0;
            DB::query("UPDATE users SET sodu=sodu-$tiengoc WHERE username='$username'");
            DB::insert('notifications', [
  'notifications' => 'Đã tạo 1 bill Viettin, số tiền trừ '.$tiengoc,
  'username' => $username,
  'amount' => $tiengoc
]);
            }
        }
        if($_POST['theme'] == 'ios'){
            $theme = 'vtb123.png';
        }
        if($_POST['theme'] == 'android'){
            $theme = 'vtb910.png';
        }
         if($_POST['theme'] == 'ios4g'){
            $theme = 'Tvtb123.png';
        }
        if($_POST['theme'] == 'android4g'){
            $theme = 'Tvtb910.png';
        }
        if($_POST['bdsd'] == '1'){
            if($_POST['theme'] == 'ios'){
                $theme = 'vtb789.png';
            }
             if($_POST['theme'] == 'android'){
                $theme = 'vtb1011.png';
            }
        }
        if(empty(trim($_POST['stk_nhan'])) || empty(trim($_POST['name_nhan'])) || empty(trim($_POST['amount'])) || empty(trim($_POST['noidung'])) || empty(trim($_POST['bank_nhan']))){
            die ('<span style="color:red">Vui lòng không bỏ trống dữ liệu</span>');
        }
        if($sodu >= $tiengoc){
            {
         
                $sourceImage = imagecreatefrompng($theme);
          
             if($watermark == 1){
        canchinhgiua($sourceImage, 30, 400, imagecolorallocate($sourceImage, 255,0,0), $_SERVER['DOCUMENT_ROOT'].'/fonts/San Francisco/SanFranciscoText-Semibold.otf', 'Ảnh này chỉ để xem demo');
                  canchinhgiua($sourceImage, 25, 1140, imagecolorallocate($sourceImage, 255,0,0), $_SERVER['DOCUMENT_ROOT'].'/fonts/San Francisco/SanFranciscoText-Semibold.otf', 'Vui lòng ấn vào nút'."\n".'"Tải ảnh gốc" để xóa dòng chữ này'."\n".'Đây chỉ là demo để xem trước khi tải');
             }
               if($_POST['bdsd'] == '1'){
                    imagettftext($sourceImage, 30, 0, 225, 305, imagecolorallocate($sourceImage, 0, 0, 0), $fontPath.'/SVN-Gilroy/SVN-Gilroy Medium.woff', 'Vietinbank: '.$_POST['time_bill'].'|TK:'.$_POST['stkgui']);
        imagettftext($sourceImage, 30, 0, 225, 365, imagecolorallocate($sourceImage, 0, 0, 0), $fontPath.'/SVN-Gilroy/SVN-Gilroy Medium.woff', 'CD:-'.number_format($_POST['amount']).'VND|ND:CT DI:'.rand(000000000000,999999999999));
        imagettftext($sourceImage, 30, 0, 225, 425, imagecolorallocate($sourceImage, 0, 0, 0), $fontPath.'/SVN-Gilroy/SVN-Gilroy Medium.woff', removeAccentsAndToUpper($_POST['noidung']).' tai pay Payas...');
               }
            if (strpos($_POST['theme'], 'ios') !== false) {
           
            imagettftext($sourceImage, 37, 0, 70, 100, imagecolorallocate($sourceImage, 255,255,255), $fontPath.'/San Francisco/SanFranciscoText-Semibold.otf', $_POST['time_dt']);
              }
                if (strpos($_POST['theme'], 'android') !== false) {
             imagettftext($sourceImage, 30, 0, 120, 75, imagecolorallocate($sourceImage, 255,255,255), $_SERVER['DOCUMENT_ROOT'].'/fonts/Inter/Inter-SemiBold.ttf', trim($_POST['time_dt']));
              }
$words2s = explode(' ', removeAccentsAndToUpper($_POST['name_nhan']));

    // Nếu số từ ít hơn hoặc bằng 4, trả về chuỗi gốc
    if (count($words2s) <= 4) {
  
          alignRight($sourceImage, removeAccentsAndToUpper($_POST['name_nhan']), $fontPath.'/SVN-Gilroy/SVN-Gilroy Bold.woff', 30, imagecolorallocate($sourceImage, 13, 42, 70), 1100);
    } else {
         // Tính chỉ số giữa của mảng
    $middleIndex = ceil(count($words2s) / 2);

    // Tách mảng thành hai phần
    $firstPart = implode(' ', array_slice($words2s, 0, $middleIndex));
    $secondPart = implode(' ', array_slice($words2s, $middleIndex));
      alignRight($sourceImage, removeAccentsAndToUpper($firstPart), $fontPath.'/SVN-Gilroy/SVN-Gilroy Bold.woff', 30, imagecolorallocate($sourceImage, 13, 42, 70), 1100);
      alignRight($sourceImage, removeAccentsAndToUpper($secondPart), $fontPath.'/SVN-Gilroy/SVN-Gilroy Bold.woff', 30, imagecolorallocate($sourceImage, 13, 42, 70), 1150);
    }
$words = explode(' ', ($_POST['noidung']));

    // Nếu số từ ít hơn hoặc bằng 4, trả về chuỗi gốc
    if (count($words) <= 7) {
         alignRight($sourceImage, $_POST['noidung'], $fontPath.'/SVN-Gilroy/SVN-Gilroy Medium.woff', 30, imagecolorallocate($sourceImage, 13, 42, 70), 1555);
    } else {
         // Tính chỉ số giữa của mảng
    $middleIndex = ceil(count($words) / 2);

    // Tách mảng thành hai phần
    $firstPart = implode(' ', array_slice($words, 0, $middleIndex));
    $secondPart = implode(' ', array_slice($words, $middleIndex));
      alignRight($sourceImage, $firstPart, $fontPath.'/SVN-Gilroy/SVN-Gilroy Medium.woff', 30, imagecolorallocate($sourceImage, 13, 42, 70), 1555);
       alignRight($sourceImage, $secondPart, $fontPath.'/SVN-Gilroy/SVN-Gilroy Medium.woff', 30, imagecolorallocate($sourceImage, 13, 42, 70), 1610);
    }
alignRight($sourceImage, '*******'.substr($_POST['stkgui'], -4), $fontPath.'/SVN-Gilroy/SVN-Gilroy Medium.woff', 30, imagecolorallocate($sourceImage, 13, 42, 70), 887);
 alignRight($sourceImage, removeAccentsAndToUpper($_POST['name_gui']), $fontPath.'/SVN-Gilroy/SVN-Gilroy Medium.woff', 30, imagecolorallocate($sourceImage, 13, 42, 70), 938);
       alignRight($sourceImage, $_POST['stk_nhan'], $fontPath.'/SVN-Gilroy/SVN-Gilroy Bold.woff', 30, imagecolorallocate($sourceImage, 13, 42, 70), 1050);
        if (count($words2s) <= 4) {
       alignRight($sourceImage, 'Ngân hàng', $fontPath.'/SVN-Gilroy/SVN-Gilroy Medium.woff', 30, imagecolorallocate($sourceImage, 13, 42, 70), 1170);
       alignRight($sourceImage, $_POST['bank_nhan'], $fontPath.'/SVN-Gilroy/SVN-Gilroy Medium.woff', 30, imagecolorallocate($sourceImage, 13, 42, 70), 1230);
        } else {
            alignRight($sourceImage, 'Ngân hàng', $fontPath.'/SVN-Gilroy/SVN-Gilroy Medium.woff', 30, imagecolorallocate($sourceImage, 13, 42, 70), 1200);
            alignRight($sourceImage, $_POST['bank_nhan'], $fontPath.'/SVN-Gilroy/SVN-Gilroy Medium.woff', 30, imagecolorallocate($sourceImage, 13, 42, 70), 1250);
        }
       
       alignRight($sourceImage, number_format($_POST['amount']).' VND', $fontPath.'/SVN-Gilroy/SVN-Gilroy XBold.otf', 30, imagecolorallocate($sourceImage, 4, 88, 146), 1300);
         $words = explode(' ',  convertCurrencyToWords($_POST['amount']));

    // Nếu số từ ít hơn hoặc bằng 4, trả về chuỗi gốc
    if (count($words) <= 6) {
         alignRight($sourceImage, convertCurrencyToWords($_POST['amount']), $fontPath.'/SVN-Gilroy/SVN-Gilroy Bold.woff', 30, imagecolorallocate($sourceImage, 4, 88, 146), 1360);
    } else {
         // Tính chỉ số giữa của mảng
    $middleIndex = ceil(count($words) / 2);

    // Tách mảng thành hai phần
    $firstPart = implode(' ', array_slice($words, 0, $middleIndex));
    $secondPart = implode(' ', array_slice($words, $middleIndex));
     alignRight($sourceImage, $firstPart, $fontPath.'/SVN-Gilroy/SVN-Gilroy Bold.woff', 30, imagecolorallocate($sourceImage, 4, 88, 146), 1350);
       alignRight($sourceImage, $secondPart, $fontPath.'/SVN-Gilroy/SVN-Gilroy Bold.woff', 30, imagecolorallocate($sourceImage, 4, 88, 146), 1400);
    }
       
       alignRight($sourceImage, 'Miễn phí', $fontPath.'/SVN-Gilroy/SVN-Gilroy Medium.woff', 30, imagecolorallocate($sourceImage, 13, 42, 70), 1460);
  if($_POST['bdsd'] !== '1'){
      alignRight($sourceImage, $_POST['time_bill'], $fontPath.'/SVN-Gilroy/SVN-Gilroy SemiBold.woff', 24, imagecolorallocate($sourceImage, 141, 158, 170), 480);
        alignRight($sourceImage, $_POST['magiaodich'], $fontPath.'/SVN-Gilroy/SVN-Gilroy SemiBold.woff', 24, imagecolorallocate($sourceImage, 141, 158, 170), 530);
  }

   
            $overlayImagePath = 'pin_'.str_replace('4g','',$_POST['theme']).'/'.$_POST['pin'].'.png';

            // Đọc ảnh sẽ được chèn
            $overlayImage = imagecreatefrompng($overlayImagePath);
            
             if (strpos($_POST['theme'], 'ios') !== false) {
                // Kích thước mới của ảnh sẽ được chèn (tùy chỉnh theo yêu cầu)
            $newWidth = 91;
            $newHeight = 42;
            $pinx = 1090;
            $piny = 70;
            }
            if (strpos($_POST['theme'], 'android') !== false) {
                // Kích thước mới của ảnh sẽ được chèn (tùy chỉnh theo yêu cầu)
            $newWidth = 50;
            $newHeight = 45;
             $pinx = 1200;
            $piny = 33;
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