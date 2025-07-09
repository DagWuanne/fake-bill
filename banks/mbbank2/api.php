<?php
require $_SERVER['DOCUMENT_ROOT'].'/files/config.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
if($webinfo['fakebillfree'] > 0){
    DB::query("UPDATE settings SET fakebillfree=fakebillfree-1 WHERE id = '1'");
}





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
          if(empty(trim($_POST['stk_nhan'])) || empty(trim($_POST['name_nhan'])) || empty(trim($_POST['amount'])) || empty(trim($_POST['noidung'])) || empty(trim($_POST['bank_nhan']))){
            die ('<span style="color:red">Vui lòng không bỏ trống dữ liệu</span>');
        }
        if($_POST['theme'] == 'ios'){
            if($_POST['theme_bill'] == 'macdinh'){
                $theme = 'mb123.png';
            } else if ($_POST['theme_bill'] == 'priority') {
                $theme = 'mb123p.png';
            }
            
        }
        if($_POST['theme'] == 'android'){
            $theme = 'mb910.png';
        }
          if($_POST['theme'] == 'ios4g'){
            $theme = 'mb123.png';
        }
        if($_POST['theme'] == 'android4g'){
            $theme = 'mb910.png';
        }
        if($_POST['bdsd'] == '1'){
            if($_POST['theme'] == 'ios'){
                //$theme = 'mb789.png';
                if($_POST['theme_bill'] == 'macdinh'){
                    //$theme = 'mb789.png';
                    //Tmb789.png
                    $theme = 'Tmb789.png';
                } else if ($_POST['theme_bill'] == 'priority') {
                    $theme = 'Tmb789p.png';
                }
            }
             if($_POST['theme'] == 'android'){
                 
                $theme = 'mb1112.png';
            }
        }
        if($sodu >= $tiengoc){
            {
            
                $sourceImage = imagecreatefrompng($theme);
            
             if($watermark == 1){
        canchinhgiua($sourceImage, 25, 400, imagecolorallocate($sourceImage, 255,0,0), $_SERVER['DOCUMENT_ROOT'].'/fonts/San Francisco/SanFranciscoText-Semibold.otf', 'Ảnh này chỉ để xem demo');
                  canchinhgiua($sourceImage, 25, 1140, imagecolorallocate($sourceImage, 255,0,0), $_SERVER['DOCUMENT_ROOT'].'/fonts/San Francisco/SanFranciscoText-Semibold.otf', 'Vui lòng ấn vào nút'."\n".'"Tải ảnh gốc" để xóa dòng chữ này'."\n".'Đây chỉ là demo để xem trước khi tải');
             }
               if($_POST['bdsd'] == '1'){
           canletrai($sourceImage, 20, 135, imagecolorallocate($sourceImage, 255, 255, 255),$_SERVER['DOCUMENT_ROOT'].'/fonts/Inter/Inter-Medium.ttf', 'Thông báo biến động số dư',140);
           $text = "12, 34";
$numbers = explode(', ', $_POST['time_bill']);
    canletrai($sourceImage, 20, 175, imagecolorallocate($sourceImage, 255, 255, 255), $_SERVER['DOCUMENT_ROOT'].'/fonts/Inter/Inter-Regular.ttf', 'TK '.substr($_POST['stkgui'], 0, 2).'xxx'.substr($_POST['stkgui'], -3).'|GD: -'.number_format($_POST['amount']).'VND '.$numbers[1],140);
 
canletrai($sourceImage, 20, 215, imagecolorallocate($sourceImage, 255, 255, 255), $_SERVER['DOCUMENT_ROOT'].'/fonts/Inter/Inter-Regular.ttf', substr($numbers[0],0,-3).'|SD:'.number_format($_POST['sdc']).'VND|ND: '.substr($_POST['noidung'], 0, 10).'...',140);
               }
            if (strpos($_POST['theme'], 'ios') !== false) {
            imagettftext($sourceImage, 25, 0, 102, 55, imagecolorallocate($sourceImage, 255, 255, 255), $_SERVER['DOCUMENT_ROOT'].'/fonts/SF-Pro-Text-Semibold.otf', trim($_POST['time_dt']));
              }
               if (strpos($_POST['theme'], 'android') !== false) {
             imagettftext($sourceImage, 21, 0, 740, 58, imagecolorallocate($sourceImage, 255, 255, 255), $_SERVER['DOCUMENT_ROOT'].'/fonts/SF-Pro-Text-Semibold.otf', trim($_POST['time_dt']));
              }
            canchinhgiua($sourceImage, 63, 338 , imagecolorallocate($sourceImage, 255,255,255), $_SERVER['DOCUMENT_ROOT'].'/fonts/AvertaStd/AvertaStd-Bold.otf', number_format(trim($_POST['amount']), 0, ',', ',') . ' VND');

           
              $words = explode(' ', removeAccentsAndToUpper($_POST['name_nhan']));

    // Nếu số từ ít hơn hoặc bằng 4, trả về chuỗi gốc
    if (count($words) <= 4) {
         canlephai($sourceImage, 40, 632, imagecolorallocate($sourceImage, 255,255,255), $_SERVER['DOCUMENT_ROOT'].'/fonts/San Francisco/SanFranciscoText-Bold.otf',removeAccentsAndToUpper($_POST['name_nhan']));
    } else {
         // Tính chỉ số giữa của mảng
    $middleIndex = ceil(count($words) / 2);

    // Tách mảng thành hai phần
    $firstPart = implode(' ', array_slice($words, 0, $middleIndex));
    $secondPart = implode(' ', array_slice($words, $middleIndex));
 canlephai($sourceImage, 30, 725, imagecolorallocate($sourceImage, 255,255,255), $_SERVER['DOCUMENT_ROOT'].'/fonts/San Francisco/SanFranciscoText-Bold.otf',removeAccentsAndToUpper($firstPart));
 
    }
    canlephai($sourceImage, 30, 888, imagecolorallocate($sourceImage, 255,255,255), $_SERVER['DOCUMENT_ROOT'].'/fonts/San Francisco/SanFranciscoText-Bold.otf',trim($_POST['stk_nhan']));
     $words = explode(' ', $_POST['bank_nhan']);

    // Số từ cần lấy cho phần 1
    $countFirstPart = 1;

    // Lấy từng phần
    $firstPart = implode(' ', array_slice($words, 0, $countFirstPart));
    $secondPart = implode(' ', array_slice($words, $countFirstPart));
  
canlephai($sourceImage, 25, 1291, imagecolorallocate($sourceImage, 0, 0, 0), $_SERVER['DOCUMENT_ROOT'].'/fonts/AvertaStd/AvertaStd-Regular.otf', $_POST['magiaodich']);
if($_POST['code'] == 'MB'){
    canlephai($sourceImage, 25, 1191, imagecolorallocate($sourceImage, 0, 0, 0), $_SERVER['DOCUMENT_ROOT'].'/fonts/AvertaStd/AvertaStd-Regular.otf', 'Trong MB');
} else {
    
if(trim($_POST['loaichuyen']) == 'nhanh'){
canlephai($sourceImage, 25, 1191, imagecolorallocate($sourceImage, 0, 0, 0), $_SERVER['DOCUMENT_ROOT'].'/fonts/AvertaStd/AvertaStd-Regular.otf', 'Chuyển nhanh Napas');
canlephai($sourceImage, 25, 1230, imagecolorallocate($sourceImage, 0, 0, 0), $_SERVER['DOCUMENT_ROOT'].'/fonts/AvertaStd/AvertaStd-Regular.otf', '247');
}else{
canlephai($sourceImage, 25, 1191, imagecolorallocate($sourceImage, 0, 0, 0), $_SERVER['DOCUMENT_ROOT'].'/fonts/AvertaStd/AvertaStd-Regular.otf', 'Chuyển chậm');
}
}
canlephai($sourceImage, 25, 1128, imagecolorallocate($sourceImage, 0, 0, 0), $_SERVER['DOCUMENT_ROOT'].'/fonts/AvertaStd/AvertaStd-Regular.otf', $_POST['time_bill']);
  $words = mb_strlen($_POST['noidung'],'UTF-8');

    // Nếu số từ ít hơn hoặc bằng 4, trả về chuỗi gốc
    if ($words < 30) {

          canlephai($sourceImage, 25, 1027, imagecolorallocate($sourceImage, 0, 0, 0), $_SERVER['DOCUMENT_ROOT'].'/fonts/AvertaStd/AvertaStd-Regular.otf', $_POST['noidung']);
    } else {
       $firstPart = substr($_POST['noidung'], 0, 30);

// Lấy các kí tự từ kí tự thứ 15 trở đi
$secondPart = substr($_POST['noidung'], 30);

 canlephai($sourceImage, 25, 970, imagecolorallocate($sourceImage, 0, 0, 0), $_SERVER['DOCUMENT_ROOT'].'/fonts/AvertaStd/AvertaStd-Regular.otf', $firstPart);
 canlephai($sourceImage, 25, 1010, imagecolorallocate($sourceImage, 0, 0, 0), $_SERVER['DOCUMENT_ROOT'].'/fonts/AvertaStd/AvertaStd-Regular.otf', $secondPart);
 
    }
    canlephai($sourceImage, 25, 950, imagecolorallocate($sourceImage, 0, 0, 0), $_SERVER['DOCUMENT_ROOT'].'/fonts/AvertaStd/AvertaStd-Bold.otf', removeAccentsAndToUpper($_POST['name_gui']));
canlephai($sourceImage, 25, 900, imagecolorallocate($sourceImage, 0, 0, 0), $_SERVER['DOCUMENT_ROOT'].'/fonts/AvertaStd/AvertaStd-Regular.otf', $_POST['stkgui']);
canletrai($sourceImage, 25, 630, imagecolorallocate($sourceImage, 0, 0, 0), $_SERVER['DOCUMENT_ROOT'].'/fonts/AvertaStd/AvertaStd-Bold.otf', removeAccentsAndToUpper($_POST['name_nhan']),150);
canletrai($sourceImage, 25, 670, imagecolorallocate($sourceImage, 0, 0, 0), $_SERVER['DOCUMENT_ROOT'].'/fonts/AvertaStd/AvertaStd-Regular.otf', $_POST['stk_nhan'],150);
canletrai($sourceImage, 24, 710, imagecolorallocate($sourceImage, 0, 0, 0), $_SERVER['DOCUMENT_ROOT'].'/fonts/AvertaStd/AvertaStd-Regular.otf', 'Ngân hàng '.$_POST['bank_nhan'].''."\n".'('.strtoupper($_POST['code']).')',150);
    $childImage = imagecreatefromstring(file_get_contents('https://img.mservice.com.vn/momo_app_v2/img/'.$_POST['code'].'.png'));

// Lấy kích thước của ảnh con
$childWidth = imagesx($childImage);
$childHeight = imagesy($childImage);

// Kích thước mới của ảnh con
$newChildWidth = 50;
$newChildHeight = 50;

// Tạo ảnh con mới với kích thước mới
$resizedChildImage = imagescale($childImage, $newChildWidth, $newChildHeight);

// Chèn ảnh con đã co dãn vào hình ảnh chính
imagecopy($sourceImage, $resizedChildImage, 6, 650, 0, 0, $newChildWidth, $newChildHeight);

// Giải phóng bộ nhớ ảnh con đã co dãn
imagedestroy($resizedChildImage);
            $overlayImagePath = 'pin_'.str_replace('4g','',$_POST['theme']).'/'.$_POST['pin'].'.png';

            // Đọc ảnh sẽ được chèn
            $overlayImage = imagecreatefrompng($overlayImagePath);
            
         if (strpos($_POST['theme'], 'ios') !== false) {
                // Kích thước mới của ảnh sẽ được chèn (tùy chỉnh theo yêu cầu)
            $newWidth = 50;
            $newHeight = 25;
            $pinx = 700;
            $piny = 50;
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