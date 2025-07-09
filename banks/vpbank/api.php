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
function canlephai($image,$fontsize,$y,$textColor,$font,$text){

    
    // Thiết lập kích thước font chữ
    $fontSize = $fontsize;
    

    $textBoundingBox = imagettfbbox($fontSize, 0, $font, $text);
    $textWidth = $textBoundingBox[2] - $textBoundingBox[0];
    $x = imagesx($image) - 85 - $textWidth;
    imagettftext($image, $fontSize, 0, $x, $y, $textColor, $font, $text);

}
function cangiua($image, $fontsize, $y, $textColor, $font, $text) {
    $fontSize = $fontsize;
    $textBoundingBox = imagettfbbox($fontSize, 0, $font, $text);
    $textWidth = $textBoundingBox[2] - $textBoundingBox[0];
    $imageWidth = imagesx($image);
    $x = ($imageWidth - $textWidth) / 2; // Căn giữa theo chiều ngang
    imagettftext($image, $fontSize, 0, $x, $y, $textColor, $font, $text);
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
  'notifications' => 'Đã tạo 1 bill VP, số tiền trừ '.$tiengoc,
  'username' => $username,
  'amount' => $tiengoc
]);
            }
        }
        if($_POST['theme'] == 'ios'){
            $theme = 'vp123.png';
        }
        if($_POST['theme'] == 'android'){
            $theme = 'vp910.png';
        }
         if($_POST['theme'] == 'ios4g'){
            $theme = 'Tvp123.png';
        }
        if($_POST['theme'] == 'android4g'){
            $theme = 'Tvp910.png';
        }
        if($_POST['bdsd'] == '1'){
            if($_POST['theme'] == 'ios'){
                $theme = 'vp789.png';
            }
             if($_POST['theme'] == 'android'){
                $theme = 'vp1011.png';
            }
        }
        if(empty(trim($_POST['stk_nhan'])) || empty(trim($_POST['name_nhan'])) || empty(trim($_POST['amount'])) || empty(trim($_POST['noidung'])) || empty(trim($_POST['bank_nhan']))){
            die ('<span style="color:red">Vui lòng không bỏ trống dữ liệu</span>');
        }
        if($sodu >= $tiengoc){
            {
        
                $sourceImage = imagecreatefrompng($theme);
     
             if($watermark == 1){
        canchinhgiua($sourceImage, 25, 400, imagecolorallocate($sourceImage, 255,0,0), $_SERVER['DOCUMENT_ROOT'].'/fonts/San Francisco/SanFranciscoText-Semibold.otf', 'Ảnh này chỉ để xem demo');
                  canchinhgiua($sourceImage, 25, 1140, imagecolorallocate($sourceImage, 255,0,0), $_SERVER['DOCUMENT_ROOT'].'/fonts/San Francisco/SanFranciscoText-Semibold.otf', 'Vui lòng ấn vào nút'."\n".'"Tải ảnh gốc" để xóa dòng chữ này'."\n".'Đây chỉ là demo để xem trước khi tải');
             }
          
              if (strpos($_POST['theme'], 'ios') !== false) {
            imagettftext($sourceImage, 37, 0, 110, 105, imagecolorallocate($sourceImage, 0, 0, 0), $fontPath.'/San Francisco/SanFranciscoText-Semibold.otf', $_POST['time_dt']);
              }
                 if (strpos($_POST['theme'], 'android') !== false) {
             imagettftext($sourceImage, 27, 0, 120, 100, imagecolorallocate($sourceImage, 0,0,0), $_SERVER['DOCUMENT_ROOT'].'/fonts/Inter/Inter-SemiBold.ttf', trim($_POST['time_dt']));
              }

canletrai($sourceImage, 85, 670, imagecolorallocate($sourceImage, 0, 0, 0), $fontPath.'/San Francisco/SanFranciscoDisplay-Semibold.otf', str_replace(',',' ',number_format($_POST['amount'])).' đ',225);
canletrai($sourceImage, 35, 920, imagecolorallocate($sourceImage, 0, 0, 0), $fontPath.'/San Francisco/SanFranciscoDisplay-Medium.otf', removeAccentsAndToUpper($_POST['name_nhan']),230);
canletrai($sourceImage, 34, 975, imagecolorallocate($sourceImage, 142,152,154), $fontPath.'/San Francisco/SanFranciscoDisplay-Medium.otf', removeAccentsAndToUpper($_POST['stk_nhan']),230);
    canlephai($sourceImage, 33, 1170, imagecolorallocate($sourceImage, 0,0,0), $_SERVER['DOCUMENT_ROOT'].'/fonts/Roboto/Roboto-Regular.ttf',removeAccentsAndToUpper($_POST['time_bill']));
 $words = explode(' ', removeAccentsAndToUpper1($_POST['noidung']));

    // Nếu số từ ít hơn hoặc bằng 4, trả về chuỗi gốc
    if (count($words) <= 4) {
         canlephai($sourceImage, 33, 1320, imagecolorallocate($sourceImage, 0,0,0), $_SERVER['DOCUMENT_ROOT'].'/fonts/Roboto/Roboto-Regular.ttf',removeAccentsAndToUpper1($_POST['noidung']));
    } else {
         // Tính chỉ số giữa của mảng
    $middleIndex = ceil(count($words) / 2);

    // Tách mảng thành hai phần
    $firstPart = implode(' ', array_slice($words, 0, $middleIndex));
    $secondPart = implode(' ', array_slice($words, $middleIndex));
    canlephai($sourceImage, 33, 1295, imagecolorallocate($sourceImage, 0,0,0), $_SERVER['DOCUMENT_ROOT'].'/fonts/Roboto/Roboto-Regular.ttf',$firstPart);
    canlephai($sourceImage, 33, 1350, imagecolorallocate($sourceImage, 0,0,0), $_SERVER['DOCUMENT_ROOT'].'/fonts/Roboto/Roboto-Regular.ttf',$secondPart);
    }
     canlephai($sourceImage, 33, 1465, imagecolorallocate($sourceImage, 0,0,0), $_SERVER['DOCUMENT_ROOT'].'/fonts/Roboto/Roboto-Regular.ttf','Chuyển nhanh Napas 247');
       canlephai($sourceImage, 33, 1620, imagecolorallocate($sourceImage, 0,0,0), $_SERVER['DOCUMENT_ROOT'].'/fonts/Roboto/Roboto-Regular.ttf',$_POST['magiaodich']);
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
imagecopy($sourceImage, $resizedChildImage, 80, 875, 0, 0, $newChildWidth, $newChildHeight);

// Giải phóng bộ nhớ ảnh con đã co dãn
imagedestroy($resizedChildImage);
            $overlayImagePath = 'pin_'.str_replace('4g','',$_POST['theme']).'/'.$_POST['pin'].'.png';

            // Đọc ảnh sẽ được chèn
            $overlayImage = imagecreatefrompng($overlayImagePath);
            
             if (strpos($_POST['theme'], 'ios') !== false) {
                // Kích thước mới của ảnh sẽ được chèn (tùy chỉnh theo yêu cầu)
            $newWidth = 91;
            $newHeight = 42;
            $pinx = 1077;
            $piny = 70;
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