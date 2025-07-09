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
        function canchinhphai($image, $fontsize, $y, $textColor, $font, $text, $customX = null)
        {
            $fontSize = $fontsize;
            $textBoundingBox = imagettfbbox($fontSize, 0, $font, $text);
            $textWidth = $textBoundingBox[2] - $textBoundingBox[0];
            $imageWidth = imagesx($image);
            $x = ($customX === null) ? ($imageWidth - $textWidth - 96) : $customX;
            imagettftext($image, $fontSize, 0, $x, $y, $textColor, $font, $text);
        }
        function canchinhgiua($image, $fontsize, $y, $textColor, $font, $text)
        {
            $fontSize = (int)$fontsize; 
            $textBoundingBox = imagettfbbox($fontSize, 0, $font, $text);
            $textWidth = $textBoundingBox[2] - $textBoundingBox[0];
            $imageWidth = imagesx($image);
            $x = (int)(($imageWidth - $textWidth) / 2); 
            $y = (int)$y;
            imagettftext($image, $fontSize, 0, $x, $y, $textColor, $font, $text);
        }
        
        function canletrai($image, $fontsize, $y, $textColor, $font, $text, $x_tcb)
        {
            $fontSize = (int)$fontsize;
            $x = (int)$x_tcb; 
            $y = (int)$y;
            imagettftext($image, $fontSize, 0, $x, $y, $textColor, $font, $text);
        }
 function alignRight($image, $text, $font, $size, $color, $y,$nhan=130)
        {
            $bbox = imagettfbbox($size, 0, $font, $text);
            $text_width = $bbox[2] - $bbox[0];
            $x = imagesx($image) - $text_width - $nhan; // Điều chỉnh giá trị 10 tùy theo lề phải mong muốn
            imagettftext($image, $size, 0, $x, $y, $color, $font, $text);
        }
        
function canlephai($image,$fontsize,$y,$textColor,$font,$text){

    
    // Thiết lập kích thước font chữ
    $fontSize = $fontsize;
    

    $textBoundingBox = imagettfbbox($fontSize, 0, $font, $text);
    $textWidth = $textBoundingBox[2] - $textBoundingBox[0];
    $x = imagesx($image) - 100 - $textWidth;
    imagettftext($image, $fontSize, 0, $x, $y, $textColor, $font, $text);

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
            $sodu = DB::queryFirstField("SELECT sodu FROM `users` WHERE username = '$username'");
            if($sodu >= $tiengoc){
            DB::query("UPDATE settings SET luottaobill=luottaobill+1 WHERE id = '1'");
            $watermark = 0;
            DB::query("UPDATE users SET sodu=sodu-$tiengoc WHERE username='$username'");
            DB::insert('notifications', [
  'notifications' => 'Đã tạo 1 bill MSB, số tiền trừ '.$tiengoc,
  'username' => $username,
  'amount' => $tiengoc
]);
            }
        }
        if($_POST['theme'] == 'ios'){
            $theme = 'msb.png';
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
                   canletrai($sourceImage, 33, 320, imagecolorallocate($sourceImage, 255, 255, 255), $fontPath.'/Inter/Inter-Regular.ttf', '(TPBank): lúc '.$_POST['time_bill'],220);
canletrai($sourceImage, 33, 385, imagecolorallocate($sourceImage, 255, 255, 255), $fontPath.'/Inter/Inter-Regular.ttf', 'TK: XXXX'.substr($_POST['stkgui'], 4).' -'.number_format($_POST['amount']).' VND...',220);
               }
             if (strpos($_POST['theme'], 'ios') !== false) {
            imagettftext($sourceImage, 38, 0, 140, 105, imagecolorallocate($sourceImage, 255,255,255), $fontPath.'/San Francisco/SanFranciscoText-Semibold.otf', $_POST['time_dt']);
              }
                if (strpos($_POST['theme'], 'android') !== false) {
             imagettftext($sourceImage, 38, 0, 140, 105, imagecolorallocate($sourceImage, 255,255,255), $_SERVER['DOCUMENT_ROOT'].'/fonts/Inter/Inter-SemiBold.ttf', trim($_POST['time_dt']));
              }
   canchinhphai($sourceImage, 27, 1280, imagecolorallocate($sourceImage, 39, 39 ,39), $fontPath.'/vietcombank-new/UTM HelveBold.ttf', removeAccentsAndToUpper($_POST['name_nhan']),270);
  
  $words = mb_strlen($_POST['noidung'],'UTF-8');

    // Nếu số từ ít hơn hoặc bằng 4, trả về chuỗi gốc
    if ($words < 30) {
           canchinhphai($sourceImage, 27, 1452, imagecolorallocate($sourceImage, 39, 39, 39), $fontPath.'/vietcombank-new/UTM HelveBold.ttf', $_POST['noidung']);
    } else {
       $firstPart = substr(strtoupper($_POST['noidung']), 0, 30);

// Lấy các kí tự từ kí tự thứ 15 trở đi
$secondPart = substr(strtoupper($_POST['noidung']), 30);
     canchinhphai($sourceImage, 27, 1452, imagecolorallocate($sourceImage, 39, 39, 39), $fontPath.'/vietcombank-new/UTM HelveBold.ttf', $firstPart);
     canchinhphai($sourceImage, 27, 1452, imagecolorallocate($sourceImage, 39, 39, 39), $fontPath.'/vietcombank-new/UTM HelveBold.ttf', $secondPart);
    }

 canchinhphai($sourceImage, 27, 820, imagecolorallocate($sourceImage, 39, 39 ,39), $fontPath.'/vietcombank-new/UTM HelveBold.ttf', removeAccentsAndToUpper($_POST['name_gui']),270);

canchinhphai($sourceImage, 27, 1090, imagecolorallocate($sourceImage, 39, 39, 39), $fontPath.'/vietcombank-new/UTM HelveBold.ttf', $_POST['stk_nhan'],270);

canchinhphai($sourceImage, 27, 945, imagecolorallocate($sourceImage,39, 39 ,39), $fontPath.'/vietcombank-new/UTM HelveBold.ttf', number_format($_POST['amount']).' VND',2);
  
canchinhphai($sourceImage, 27, 1600, imagecolorallocate($sourceImage, 39, 39, 39), $fontPath.'vietcombank-new/UTM HelveBold.ttf', $_POST['time_bill']);
     $childImage = imagecreatefromstring(file_get_contents('https://img.mservice.com.vn/momo_app_v2/img/'.$_POST['code'].'.png'));

// Lấy kích thước của ảnh con
$childWidth = imagesx($childImage);
$childHeight = imagesy($childImage);

// Kích thước mới của ảnh con
$newChildWidth = 100;
$newChildHeight = 100;

// Tạo ảnh con mới với kích thước mới
$resizedChildImage = imagescale($childImage, $newChildWidth, $newChildHeight);

// Chèn ảnh con đã co dãn vào hình ảnh chính
imagecopy($sourceImage, $resizedChildImage, 100, 1145, 0, 0, $newChildWidth, $newChildHeight);

// Giải phóng bộ nhớ ảnh con đã co dãn
imagedestroy($resizedChildImage);
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
            $newWidth = 60;
            $newHeight = 55;
             $pinx = 1090;
            $piny = 60;
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