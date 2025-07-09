<?php

try {
    // Kiểm tra nếu các tham số cần thiết được truyền qua URL
    if (!isset($_GET['name']) || !isset($_GET['socccd']) || !isset($_GET['birthday']) || !isset($_GET['sex']) || !isset($_GET['quequan']) || !isset($_GET['thuongtru']) || !isset($_GET['ngaycap']) || !isset($_GET['anhthe'])) {
        throw new Exception('Thiếu tham số cần thiết.');
    }

    $socccd = trim($_GET['socccd']);
    $name = trim($_GET['name']);
    $birthday = trim($_GET['birthday']);
    $sex = trim($_GET['sex']);
    $quequan = trim($_GET['quequan']);
    $thuongtru = trim($_GET['thuongtru']);
    $thuongtru2 = trim($_GET['thuongtru2']);
    $ngayhethan = trim($_GET['ngayhethan']);
    $ngaycap = trim($_GET['ngaycap']);
    $anhthe = trim($_GET['anhthe']);
    $socmnd = trim($_GET['socmnd']);

    if (empty($socccd) || empty($name) || empty($birthday) || empty($sex) || empty($quequan) || empty($thuongtru) || empty($ngaycap) || empty($ngayhethan) || empty($thuongtru2) || empty($anhthe) || empty($socmnd)) {
        throw new Exception('Các trường không được để trống.');
    }

    function imagettftextSpWithEffectsCCCD($image, $size, $angle, $x, $y, $text, $font, $spacing = 0, $textColor, $shadowColor, $shadowOffsetX, $shadowOffsetY, $outerGlowSize)
    {
        // Create a temporary image for the text with shadow
        $temp_image = imagecreatetruecolor(imagesx($image), imagesy($image));

        // Allocate colors for text and shadow
        $textColor = imagecolorallocatealpha($temp_image, $textColor[0], $textColor[1], $textColor[2], $textColor[3]);
        $shadowColor = imagecolorallocatealpha($temp_image, $shadowColor[0], $shadowColor[1], $shadowColor[2], $shadowColor[3]);

        // Fill the temporary image with a transparent background
        $transparentColor = imagecolorallocatealpha($temp_image, 0, 0, 0, 127);
        imagefill($temp_image, 0, 0, $transparentColor);
        imagesavealpha($temp_image, true);

        // Draw the text on the temporary image with shadow
        if ($spacing == 0) {
            for ($i = 0; $i < $outerGlowSize; $i++) {
                imagettftext($temp_image, $size, $angle, $x + $shadowOffsetX, $y + $shadowOffsetY, $shadowColor, $font, $text);
            }
            imagettftext($temp_image, $size, $angle, $x, $y, $textColor, $font, $text);
        } else {
            $temp_x = $x;
            for ($i = 0; $i < strlen($text); $i++) {
                for ($j = 0; $j < $outerGlowSize; $j++) {
                    imagettftext($temp_image, $size, $angle, $temp_x + $shadowOffsetX, $y + $shadowOffsetY, $shadowColor, $font, $text[$i]);
                }
                $bbox = imagettftext($temp_image, $size, $angle, $temp_x, $y, $textColor, $font, $text[$i]);
                $temp_x += $spacing + ($bbox[2] - $bbox[0]);
            }
        }

        // Merge the temporary image with the original image
        imagecopy($image, $temp_image, 0, 0, 0, 0, imagesx($image), imagesy($image));

        // Clean up
        imagedestroy($temp_image);
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
    if (!$jpg_image) {
        throw new Exception('Không thể mở file fsdf.png.');
    }

    $white_image = imagecreatetruecolor(imagesx($jpg_image), imagesy($jpg_image));
    $whiteColor = imagecolorallocate($white_image, 255, 255, 255);
    imagefill($white_image, 0, 0, $whiteColor);
    imagecopy($jpg_image, $white_image, 0, 0, 0, 0, imagesx($white_image), imagesy($white_image));

    // Handle QR code
    $qr_image_url = 'https://quickchart.io/qr?text=' . urlencode($socccd . '|' . $socmnd . '|' . $name . '|' . str_replace('/', '', $birthday) . '|' . $sex . '|' . $thuongtru2 . ', ' . $thuongtru . '|' . str_replace('/', '', $ngaycap)) . '&light=0000&ecLevel=Q&format=png&size=170';

    // Tải nội dung QR từ URL
    $qr_image_data = file_get_contents($qr_image_url);
    if (!$qr_image_data) {
        throw new Exception('Không thể tải QR code từ URL.');
    }

    // Tạo hình ảnh từ nội dung QR
    $qr_image = imagecreatefromstring($qr_image_data);
    if (!$qr_image) {
        throw new Exception('Không thể tạo hình ảnh QR từ dữ liệu.');
    }

    // Copy ảnh mặt trước lên
    $mattruoc = imagecreatefrompng('f.png');
    imagecopy($jpg_image, $mattruoc, 0, 0, 0, 0, imagesx($mattruoc), imagesy($mattruoc));

    // Copy QR vào ảnh chính tại vị trí (X, Y)
    imagecopy($jpg_image, $qr_image, 1330, 210, 0, 0, imagesx($qr_image), imagesy($qr_image));

    // Define colors
    $textColor = [26, 27, 35]; // Black text with alpha channel for transparency
    $shadowColor = [0, 50, 50, 50]; // Black shadow with alpha channel for transparency

    // Add the text with effects to the image
    imagettftextSpWithEffectsCCCD($jpg_image, 40, 0, 845, 535, $socccd, './Arial-Bold.ttf', 0, $textColor, $shadowColor, 0, 0, 2);
    imagettftextSpWithEffects($jpg_image, 33, 0, 720, 630, mb_strtoupper($name, 'UTF-8'), './Arial-Regular.ttf', 0, $textColor, $shadowColor, 1, 1, 1);
    imagettftextSpWithEffects($jpg_image, 28, 0, 1060, 670, $birthday, './Arial-Regular.ttf', 0, $textColor, $shadowColor, 1, 1, 1);
    imagettftextSpWithEffects($jpg_image, 28, 0, 935, 715, $sex, './Arial-Regular.ttf', 0, $textColor, $shadowColor, 1, 1, 1);
    imagettftextSpWithEffects($jpg_image, 28, 0, 1340, 722, 'Việt Nam', './Arial-Regular.ttf', 0, $textColor, $shadowColor, 1, 1, 1);
    imagettftextSpWithEffects($jpg_image, 28, 0, 725, 810, $quequan, './Arial-Regular.ttf', 0, $textColor, $shadowColor, 1, 1, 1);
    imagettftextSpWithEffects($jpg_image, 28, 0, 725, 900, $thuongtru, './Arial-Regular.ttf', 0, $textColor, $shadowColor, 1, 1, 1);
    imagettftextSpWithEffects($jpg_image, 18, 0, 555, 875, $ngayhethan, './Arial-Regular.ttf', 0, $textColor, $shadowColor, 0, 0, 1);
    imagettftextSpWithEffects($jpg_image, 28, 0, 1185, 860, $thuongtru2, './Arial-Regular.ttf', 0, $textColor, $shadowColor, 1, 1, 1);

    // Handle photo image
    $anhthe = imagecreatefromstring(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/uploads/" . $anhthe));
    if (!$anhthe) {
        throw new Exception('Không thể mở ảnh thẻ.');
    }

    // Desired width and height for the image
    $desiredWidth = 285;
    $desiredHeight = 398;

    $adjustedImage = imagecreatetruecolor($desiredWidth, $desiredHeight);

    // Màu nền trong suốt
    $transparentColor = imagecolorallocatealpha($adjustedImage, 0, 0, 0, 127);
    imagefill($adjustedImage, 0, 0, $transparentColor);
    imagesavealpha($adjustedImage, true);

    // Tạo viền trắng có độ mờ
    $borderThickness = 10; // Độ dày của viền trắng
    $whiteColor = imagecolorallocatealpha($adjustedImage, 255, 255, 255, 80); // Màu trắng với độ mờ

    // Tạo viền trắng bằng cách vẽ một hình chữ nhật xung quanh ảnh thẻ
    imagefilledrectangle($adjustedImage, 0, 0, $desiredWidth, $borderThickness, $whiteColor); // Viền trên
    imagefilledrectangle($adjustedImage, 0, 0, $borderThickness, $desiredHeight, $whiteColor); // Viền trái
    imagefilledrectangle($adjustedImage, 0, $desiredHeight - $borderThickness, $desiredWidth, $desiredHeight, $whiteColor); // Viền dưới
    imagefilledrectangle($adjustedImage, $desiredWidth - $borderThickness, 0, $desiredWidth, $desiredHeight, $whiteColor); // Viền phải

    // Đặt ảnh thẻ vào hình đã có viền trắng
    imagecopyresampled($adjustedImage, $anhthe, $borderThickness, $borderThickness, 0, 0, $desiredWidth - 2 * $borderThickness, $desiredHeight - 2 * $borderThickness, $sourceWidth, $sourceHeight);

    // Calculate the aspect ratio of the source image
    $sourceWidth = imagesx($anhthe);
    $sourceHeight = imagesy($anhthe);
    $sourceAspectRatio = $sourceWidth / $sourceHeight;

    // Calculate the aspect ratio of the desired dimensions
    $desiredAspectRatio = $desiredWidth / $desiredHeight;

    // Calculate the cropping or resizing dimensions
    if ($sourceAspectRatio > $desiredAspectRatio) {
        // Crop horizontally
        $cropWidth = $sourceHeight * $desiredAspectRatio;
        $cropX = ($sourceWidth - $cropWidth) / 2;
        imagecopyresampled($adjustedImage, $anhthe, 0, 0, $cropX, 0, $desiredWidth, $desiredHeight, $cropWidth, $sourceHeight);
    } else {
        // Crop vertically
        $cropHeight = $sourceWidth / $desiredAspectRatio;
        $cropY = ($sourceHeight - $cropHeight) / 2;
        imagecopyresampled($adjustedImage, $anhthe, 0, 0, 0, $cropY, $desiredWidth, $desiredHeight, $sourceWidth, $cropHeight);
    }

    // Create a black overlay image with opacity
    $blackOverlay = imagecreatetruecolor($desiredWidth, $desiredHeight);
    $black = imagecolorallocatealpha($blackOverlay, 0, 0, 0, 100); // Opacity value
    imagefill($blackOverlay, 0, 0, $black);
    imagecopymerge($adjustedImage, $blackOverlay, 0, 0, 0, 0, $desiredWidth, $desiredHeight, 20);

    // Now, copy the adjusted image to your destination image
    $originalWidth = imagesx($jpg_image);
    $originalHeight = imagesy($jpg_image);
    $blurredImage = imagecreatetruecolor($desiredWidth, $desiredHeight);
    imagecopy($blurredImage, $adjustedImage, 0, 0, 0, 0, $desiredWidth, $desiredHeight);
    $blurAmount = 10; // Adjust blur amount as needed
    $blurImage = imagecreatetruecolor($desiredWidth, $desiredHeight);
    imagefilledrectangle($blurImage, 0, 0, $desiredWidth, $desiredHeight, imagecolorallocate($blurImage, 255, 255, 255));
    imagecopymerge($blurImage, $blurredImage, 0, 0, 0, 0, $desiredWidth, $desiredHeight, 100 - $blurAmount);
    imagecopy($jpg_image, $blurImage, 400, 440, 0, 0, $desiredWidth, $desiredHeight);

    // Output the final image
    imagejpeg($jpg_image);

    // Clean up
    imagedestroy($jpg_image);
    imagedestroy($qr_image);
    imagedestroy($anhthe);
    imagedestroy($blackOverlay);
    imagedestroy($adjustedImage);
    imagedestroy($blurredImage);
    imagedestroy($blurImage);
} catch (Exception $e) {
    // Handle exceptions and display error messages
    header('Content-type: text/plain');
    // echo 'Lỗi: ' . $e->getMessage();
}
