<?php

try {
    // Kiểm tra nếu các tham số cần thiết được truyền qua URL
     if (!isset($_GET['name']) || !isset($_GET['sohochieu']) || !isset($_GET['gcmnd']) || !isset($_GET['birthday']) || !isset($_GET['sex']) || !isset($_GET['noisinh']) || !isset($_GET['ngaycap']) || !isset($_GET['ngayhethan'])) {
         throw new Exception('Thiếu tham số cần thiết.');
     }

    $name = trim($_GET['name']);
    $sohochieu = trim($_GET['sohochieu']);
    $birthday = trim($_GET['birthday']);
    $sex = trim($_GET['sex']);
    $noisinh = trim($_GET['noisinh']);
    $gcmnd = trim($_GET['gcmnd']);
    $ngayhethan = trim($_GET['ngayhethan']);
    $ngaycap = trim($_GET['ngaycap']);
    $footer = trim($_GET['footer']);
    $anhthe = trim($_GET['anhthe']);

    // Kiểm tra các trường có bị rỗng không
     if (empty($name) || empty($sohochieu) || empty($birthday) || empty($sex) || empty($noisinh) || empty($gcmnd) || empty($ngaycap) || empty($ngayhethan)) {
         throw new Exception('Các trường không được để trống.');
     }

    // Hàm thêm text với hiệu ứng (chữ đậm, bóng)
    function imagettftextSpWithEffects($image, $size, $angle, $x, $y, $text, $font, $spacing = 0, $textColor, $shadowColor, $shadowOffsetX, $shadowOffsetY, $outerGlowSize, $boldness = 1, $opacity = 25)
    {
        // Tạo hình tạm thời để xử lý hiệu ứng
        $temp_image = imagecreatetruecolor(imagesx($image), imagesy($image));

        // Cấp phát màu cho chữ và bóng
        $textColor = imagecolorallocatealpha($temp_image, $textColor[0], $textColor[1], $textColor[2], $opacity);
        $shadowColor = imagecolorallocatealpha($temp_image, $shadowColor[0], $shadowColor[1], $shadowColor[2], $shadowColor[3]);

        // Điền nền trong suốt cho ảnh tạm
        $transparentColor = imagecolorallocatealpha($temp_image, 0, 0, 0, 127);
        imagefill($temp_image, 0, 0, $transparentColor);
        imagesavealpha($temp_image, true);

        // Tạo chữ đậm bằng cách vẽ nhiều lần
        for ($i = 0; $i < $boldness; $i++) {
            for ($j = 0; $j < $boldness; $j++) {
                imagettftext($temp_image, $size, $angle, $x + $i, $y + $j, $textColor, $font, $text);
            }
        }

        // Ghép ảnh tạm vào ảnh chính
        imagecopy($image, $temp_image, 0, 0, 0, 0, imagesx($image), imagesy($image));

        // Dọn dẹp ảnh tạm
        imagedestroy($temp_image);
    }

    // Set the Content Type
    header('Content-type: image/jpeg');

    // Tạo ảnh từ file PNG chính (đã thay thế tên ảnh)
    $jpg_image = imagecreatefrompng('img-passport.png');
    if (!$jpg_image) {
        throw new Exception('Không thể mở file passport.png.');
    }

    // Định nghĩa các màu
    $textColor = [0, 0, 0]; // Màu chữ
    $shadowColor = [90, 90, 90, 90]; // Màu bóng

    // Thêm văn bản vào ảnh chính với hiệu ứng
    imagettftextSpWithEffects($jpg_image, 37, 0, 1434, 1610, $sohochieu, './Times New Roman.ttf', 0, $textColor, $shadowColor, 1, 1, 1);
    imagettftextSpWithEffects($jpg_image, 37, 0, 743, 1736, mb_strtoupper($name, 'UTF-8'), './Times New Roman.ttf', 0, $textColor, $shadowColor, 1, 1, 1);
    imagettftextSpWithEffects($jpg_image, 37, 0, 756, 1937, $birthday, './Times New Roman.ttf', 0, $textColor, $shadowColor, 1, 1, 1);
    imagettftextSpWithEffects($jpg_image, 37, 0, 1289, 1937, mb_strtoupper($noisinh, 'UTF-8'), './Times New Roman.ttf', 0, $textColor, $shadowColor, 1, 1, 1);
    imagettftextSpWithEffects($jpg_image, 37, 0, 753, 2053, mb_strtoupper($sex), './Times New Roman.ttf', 0, $textColor, $shadowColor, 1, 1, 1);
    imagettftextSpWithEffects($jpg_image, 37, 0, 1290, 2057, mb_strtoupper($gcmnd, 'UTF-8'), './Times New Roman.ttf', 0, $textColor, $shadowColor, 1, 1, 1);
    imagettftextSpWithEffects($jpg_image, 37, 0, 748, 2168, $ngaycap, './Times New Roman.ttf', 0, $textColor, $shadowColor, 0, 0, 1);
    imagettftextSpWithEffects($jpg_image, 37, 0, 1290, 2168, $ngayhethan, './Times New Roman.ttf', 0, $textColor, $shadowColor, 0, 0, 1);
    imagettftextSpWithEffects($jpg_image, 45, 0.5, 751, 2316, 'Cục Quản lý xuất nhập cảnh', './Times New Roman.ttf', 0, $textColor, $shadowColor, 0, 0, 1);
    // imagettftextSpWithEffects($jpg_image, 50, 0.8, 155, 2475, mb_strtoupper($footer), 'OCR-B10PitchBT Regular.otf', 0, $textColor, $shadowColor, 0, 0, 1);

    // Giả sử footer đã được thiết lập, ví dụ:
    $footer = mb_strtoupper($footer);

    // Tách footer thành 2 dòng
    $firstLine = mb_substr($footer, 0, 44, 'UTF-8'); // Dòng đầu tiên (44 ký tự)
    $secondLine = mb_substr($footer, 44, null, 'UTF-8'); // Phần còn lại

    // Vẽ dòng đầu tiên
    imagettftextSpWithEffects($jpg_image, 50, 0.8, 155, 2475, mb_strtoupper($firstLine, 'UTF-8'), './OCR-B10PitchBT Regular.otf', 0, $textColor, $shadowColor, 0, 0, 1);

    // Vẽ dòng thứ hai (dịch tọa độ Y xuống để phù hợp với dòng thứ hai)
    imagettftextSpWithEffects($jpg_image, 50, 0.9, 154, 2516, mb_strtoupper($secondLine, 'UTF-8'), './OCR-B10PitchBT Regular.otf', 0, $textColor, $shadowColor, 0, 0, 1);

    $anhthe_path = $_SERVER['DOCUMENT_ROOT'] . '/uploads/' . $anhthe;
    // $anhthe_path = "https://img.upanh.tv/2024/09/13/cach-chup-hinh-the-dep-removebg-preview.png";
    $anhthe = imagecreatefromstring(file_get_contents($anhthe_path));
    if (!$anhthe) {
        throw new Exception('Không thể mở ảnh thẻ.');
    }

    // Desired width and height for the image
    $desiredWidth = 480;
    $desiredHeight = 598;

    // Tạo ảnh thẻ mới với kích thước mong muốn
    $adjustedImage = imagecreatetruecolor($desiredWidth, $desiredHeight);
    $transparentColor = imagecolorallocatealpha($adjustedImage, 0, 0, 0, 127);
    imagefill($adjustedImage, 0, 0, $transparentColor);
    imagesavealpha($adjustedImage, true);

    // Điều chỉnh kích thước ảnh thẻ
    $sourceWidth = imagesx($anhthe);
    $sourceHeight = imagesy($anhthe);
    $sourceAspectRatio = $sourceWidth / $sourceHeight;
    $desiredAspectRatio = $desiredWidth / $desiredHeight;

    if ($sourceAspectRatio > $desiredAspectRatio) {
        $cropWidth = $sourceHeight * $desiredAspectRatio;
        $cropX = ($sourceWidth - $cropWidth) / 2;
        imagecopyresampled($adjustedImage, $anhthe, 0, 0, $cropX, 0, $desiredWidth, $desiredHeight, $cropWidth, $sourceHeight);
    } else {
        $cropHeight = $sourceWidth / $desiredAspectRatio;
        $cropY = ($sourceHeight - $cropHeight) / 2;
        imagecopyresampled($adjustedImage, $anhthe, 0, 0, 0, $cropY, $desiredWidth, $desiredHeight, $sourceWidth, $cropHeight);
    }

    // Ghi đè ảnh thẻ đã chỉnh sửa lên ảnh chính
    imagecopy($jpg_image, $adjustedImage, 185, 1675, 0, 0, $desiredWidth, $desiredHeight);

    // Output the final image
    // Xuất ảnh cuối cùng
    imagejpeg( $jpg_image);


    // Dọn dẹp ảnh chính
    imagedestroy($jpg_image);
    imagedestroy($anhthe);
    imagedestroy($adjustedImage);
} catch (Exception $e) {
    // Hiển thị lỗi ngay lập tức
    header('Content-type: text/plain');
    echo 'Lỗi: ' . $e->getMessage();
}
