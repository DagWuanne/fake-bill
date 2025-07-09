<?php

// error_reporting(E_ALL);
ini_set('display_errors', 'On');
// var_dump($_SESSION);

require $_SERVER['DOCUMENT_ROOT'].'/files/config.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
if($webinfo['fakebillfree'] > 0){
    DB::query("UPDATE settings SET fakebillfree=fakebillfree-1 WHERE id = '1'");
}
 function alignRight($image, $text, $font, $size, $color, $y,$nhan=90)
        {
            $bbox = imagettfbbox($size, 0, $font, $text);
            $text_width = $bbox[2] - $bbox[0];
            $x = imagesx($image) - $text_width - $nhan; // Điều chỉnh giá trị 10 tùy theo lề phải mong muốn
            imagettftext($image, $size, 0, $x, $y, $color, $font, $text);
        }
        
// function alignRight($image, $text,$font,$fontsize,$textColor,$y,$nhan=60){

    
//     // Thiết lập kích thước font chữ
//     $fontSize = $fontsize;
    

//     $textBoundingBox = imagettfbbox($fontSize, 0, $font, $text);
//     $textWidth = $textBoundingBox[2] - $textBoundingBox[0];
//     $x = imagesx($image) - 60 - $textWidth;
//     imagettftext($image, $fontSize, 0, $x, $y, $textColor, $font, $text);

// }

function canlephai($image,$fontsize,$y,$textColor,$font,$text){

    
    // Thiết lập kích thước font chữ
    $fontSize = $fontsize;
    

    $textBoundingBox = imagettfbbox($fontSize, 0, $font, $text);
    $textWidth = $textBoundingBox[2] - $textBoundingBox[0];
    $x = imagesx($image) - 60 - $textWidth;
    imagettftext($image, $fontSize, 0, $x, $y, $textColor, $font, $text);

}
function canletrai($image,$fontsize,$y,$textColor,$font,$text,$box2 = 270){

    
    // Thiết lập kích thước font chữ
    $fontSize = $fontsize;
    

    imagettftext($image, $fontSize, 0, $box2, $y, $textColor, $font, $text);

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
  'notifications' => 'Đã tạo 1 bill, số tiền trừ '.$tiengoc,
  'username' => $username,
  'amount' => $tiengoc
]);
            }
        }
        $theme = 'phoimomo.jpg';
        if($_POST['theme'] == 'ios'){
            $theme = 'phoimomo.jpg';
        }
        if($_POST['theme'] == 'android'){
            $theme = 'tcb910.png';
        }
          if($_POST['theme'] == 'ios4g'){
            $theme = 'Tphoimomo.jpg';
        }
        if($_POST['theme'] == 'android4g'){
            $theme = 'Ttcb910.png';
        }
        if($_POST['bdsd'] == '1'){
            if($_POST['theme'] == 'ios'){
                $theme = 'tcb789.png';
            }
             if($_POST['theme'] == 'android'){
                $theme = 'tcb1112.png';
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
           
            imagettftext($sourceImage, 40, 0, 110, 110, imagecolorallocate($sourceImage, 0, 0, 0), $fontPath.'/San Francisco/SanFranciscoText-Semibold.otf', $_POST['time_dt']);
              }
                  if (strpos($_POST['theme'], 'android') !== false) {
             imagettftext($sourceImage, 30, 0, 120, 75, imagecolorallocate($sourceImage, 0,0,0), $_SERVER['DOCUMENT_ROOT'].'/fonts/Inter/Inter-SemiBold.ttf', trim($_POST['time_dt']));
              }
imagettftext($sourceImage, 31, 0, 288, 422, imagecolorallocate($sourceImage, 114, 114, 114), $_SERVER['DOCUMENT_ROOT'].'/fonts/Inter/Inter-Regular.ttf', mb_strtoupper('chuyển tiền đến '.$_POST['name_nhan'], 'UTF-8'));
        imagettftext($sourceImage, 49, 0, 290, 500, imagecolorallocate($sourceImage, 49, 50, 52), $_SERVER['DOCUMENT_ROOT'].'/fonts/Inter/Inter-Bold.ttf', '-'.number_format($_POST['amount'], 0, ',', '.').'đ');
        alignRight($sourceImage, $_POST['time_bill'], $_SERVER['DOCUMENT_ROOT'].'/fonts/Inter/Inter-SemiBold.ttf', 36, imagecolorallocate($sourceImage, 49, 50 ,52), 735);
        alignRight($sourceImage, $_POST['magiaodich'], $_SERVER['DOCUMENT_ROOT'].'/fonts/Inter/Inter-SemiBold.ttf', 36, imagecolorallocate($sourceImage, 49, 50 ,52), 875,145);
         alignRight($sourceImage, mb_convert_case($_POST['name_nhan'], MB_CASE_TITLE, "UTF-8"), $_SERVER['DOCUMENT_ROOT'].'/fonts/Inter/Inter-SemiBold.ttf', 36, imagecolorallocate($sourceImage, 49, 50 ,52), 1370);
         alignRight($sourceImage, mb_convert_case($_POST['stk_nhan'], MB_CASE_TITLE, "UTF-8"), $_SERVER['DOCUMENT_ROOT'].'/fonts/Inter/Inter-SemiBold.ttf', 36, imagecolorallocate($sourceImage, 49, 50 ,52), 1590);
                  alignRight($sourceImage, mb_convert_case($_POST['stk_nhan'], MB_CASE_TITLE, "UTF-8"), $_SERVER['DOCUMENT_ROOT'].'/fonts/Inter/Inter-SemiBold.ttf', 36, imagecolorallocate($sourceImage, 49, 50 ,52), 960);
   
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