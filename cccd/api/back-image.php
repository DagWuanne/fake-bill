<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/files/config.php';


if (isset($_GET['name'])) {
    $socccd = trim($_GET['socccd']);
    $name = trim(removeAccentsAndToUpper1($_GET['name']));
    $name = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $name);
    $name = preg_replace('/[^A-Za-z0-9 ]/', '', $name);
    // Tách họ và tên (bao gồm tên đệm nếu có)
    $parts = explode(' ', $name);
    $lastname = array_shift($parts); // Lấy phần họ
    $firstname = implode(' ', $parts); // Lấy phần còn lại là tên và tên đệm

    // Thêm 2 dấu << sau họ và 1 dấu < sau tên
    $fullnameFormatted = $lastname . '<<' . str_replace(' ', '<', $firstname);

    // Ví dụ sử dụng
    $fullname = "\n" . $fullnameFormatted;
    $birthday = trim($_GET['birthday']);
    $sex = trim($_GET['sex']);
    $quequan = trim($_GET['quequan']);
    $thuongtru = trim($_GET['thuongtru']);
    $ngaycap = trim($_GET['ngaycap']);
    if (empty($socccd) || empty($name) || empty($birthday) || empty($sex) || empty($quequan) || empty($thuongtru) || empty($ngaycap)) {
        die();
    }
    function imagettftextSpWithEffects($image, $size, $angle, $x, $y, $text, $font, $spacing = 0, $textColor, $shadowColor, $shadowOffsetX, $shadowOffsetY, $outerGlowSize, $boldness = 2.1, $opacity = 80)
    {
        // Create a temporary image for the text with shadow
        $temp_image = imagecreatetruecolor(imagesx($image), imagesy($image));

        // Allocate colors for text and shadow with opacity for text
        $textColor = imagecolorallocatealpha($temp_image, $textColor[0], $textColor[1], $textColor[2], $opacity); // Opacity for text
        $shadowColor = imagecolorallocatealpha($temp_image, $shadowColor[0], $shadowColor[1], $shadowColor[2], $shadowColor[3]);

        // Fill the temporary image with a transparent background
        $transparentColor = imagecolorallocatealpha($temp_image, 0, 0, 0, 127);
        imagefill($temp_image, 0, 0, $transparentColor);
        imagesavealpha($temp_image, true);

        // Draw the text multiple times to simulate boldness
        for ($i = 0; $i < $boldness; $i++) {
            for ($j = 0; $j < $boldness; $j++) {
                imagettftext($temp_image, $size, $angle, $x + $i, $y + $j, $textColor, $font, $text);
            }
        }

        // Merge the temporary image with the original image
        imagecopy($image, $temp_image, 0, 0, 0, 0, imagesx($image), imagesy($image));

        // Clean up
        imagedestroy($temp_image);
    }

    // Set the Content Type
    header('Content-type: image/jpeg');

    // Create Image From Existing File
    $jpg_image = imagecreatefrompng('fsdf.png');
    $white_image = imagecreatetruecolor(imagesx($jpg_image), imagesy($jpg_image));

    // Allocate the white color
    $whiteColor = imagecolorallocate($white_image, 255, 255, 255);

    // Fill the white image with white color
    imagefill($white_image, 0, 0, $whiteColor);

    // Merge the white background with the original image
    imagecopy($jpg_image, $white_image, 0, 0, 0, 0, imagesx($white_image), imagesy($white_image));


    imagecopy($jpg_image, imagecreatefrompng('b.png'), 0, 0, 0, 0, imagesx(imagecreatefrompng('b.png')), imagesy(imagecreatefrompng('b.png')));

    // Define colors
    $textColor = [68, 68, 68]; // Black text with alpha channel for transparency
    $shadowColor = [0, 0, 50, 50]; // Black shadow with alpha channel for transparency

    // Add the text with effects to the image

    $fullname = mb_strtoupper($fullname, 'UTF-8'); // Chuyển tên thành chữ in hoa nếu cần
    $maxLength = 31; // Số ký tự tối đa mà chuỗi cần đạt
    $fullnameWithPadding = str_pad($fullname, $maxLength, '<'); // Thêm dấu '<' sau fullname để tổng độ dài = 30 ký tự
    // Tạo chuỗi số ngẫu nhiên
    $random_elv_digits = str_pad(rand(0, 9999999), 7, '0', STR_PAD_LEFT);  // Random luôn có 8 số
    $randomPart = $str_pad . 'f' . $str_pad . 'vnm<<<<<<<<<<<6';

    // Tính độ dài chuỗi hiện tại
    $currentLength = strlen($randomPart);

    // Tính toán số dấu < cần thêm để đủ 30 ký tự
    $neededPadding = 30 - $currentLength;

    // Nếu cần thêm dấu <
    if ($neededPadding > 0) {
        // Thêm các dấu < trước số 6
        $randomPart = str_replace('6', str_repeat('<', $neededPadding) . '6', $randomPart);
    }

    imagettftextSpWithEffects($jpg_image, 20, 0, 845, 290, $ngaycap, './SVN-Arial Regular.ttf', 0, $textColor, $shadowColor, 1, 1, 1);
    imagettftextSpWithEffects($jpg_image, 44, 0, 420, 720, strtoupper('idvnm' . substr($socccd, 3) . '1' . $socccd . '<<6
' . rand(000000, 999999) . 'f' . rand(00000000, 99999999) . 'vnm<<<<<<<<<<<6' . $fullnameWithPadding), './font.ttf', 0, $textColor, $shadowColor, 1, 1, 1);
    // Create a black overlay with transparency
    $overlay = imagecreatetruecolor(imagesx($jpg_image), imagesy($jpg_image));
    $black = imagecolorallocatealpha($overlay, 0, 0, 0, 100);
    imagefill($overlay, 0, 0, $black);
    imagecopymerge($jpg_image, $overlay, 0, 0, 0, 0, imagesx($overlay), imagesy($overlay), 5);




    imagejpeg($jpg_image);

    // Clear Memory
    imagedestroy($jpg_image);




    // Đừng quên dọn dẹp $adjustedImage khi bạn đã sử dụng xong
    imagedestroy($adjustedImage);
}
