<?php
// Tự động autoload các thư viện
require_once $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';

// Chỉ gọi session nếu chưa tồn tại
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Cấu hình múi giờ Việt Nam
date_default_timezone_set('Asia/Ho_Chi_Minh');

// Thông tin kết nối MySQL (sửa lại theo môi trường của bạn)
DB::$user = 'root';
DB::$password = '185'; // Nếu dùng XAMPP/MAMP thường để trống
DB::$dbName = 'fakebill'; // Tên cơ sở dữ liệu
DB::$host = '127.0.0.1';
DB::$encoding = 'utf8';

// Truy vấn thông tin cài đặt chung
$webinfo = DB::queryFirstRow("SELECT * FROM settings");

// Lấy thông tin người dùng nếu đã đăng nhập
$user_new = null;
if (isset($_SESSION['username'])) {
    $user_new = DB::queryFirstRow("SELECT * FROM users WHERE username=%s", $_SESSION['username']);
}

// Hàm chống XSS
if (!function_exists('xss_clean')) {
    function xss_clean($data) {
        $data = str_replace(['&amp;','&lt;','&gt;'], ['&amp;amp;','&amp;lt;','&amp;gt;'], $data);
        $data = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $data);
        $data = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $data);
        $data = html_entity_decode($data, ENT_COMPAT, 'UTF-8');
        $data = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu', '$1>', $data);
        $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t:#iu', '$1=$2nojavascript...', $data);
        $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t:#iu', '$1=$2novbscript...', $data);
        $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[^>]*+>#i', '$1>', $data);
        $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[^>]*+>#i', '$1>', $data);
        $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?script:*[^>]*+>#iu', '$1>', $data);
        $data = preg_replace('#</*\w+:\w[^>]*+>#i', '', $data);
        do {
            $old_data = $data;
            $data = preg_replace('#</*(?:applet|base|embed|iframe|meta|object|script|style|title|xml)[^>]*+>#i', '', $data);
        } while ($old_data !== $data);
        return $data;
    }
}

// Định nghĩa các giá trị mặc định
$domain = 'https://billfake.com';
$tiengoc = $tiengoc1 = $tiengoc2 = $tiengoc3 = 0;

// Tính toán logic theo free hay key
if ($webinfo['fakebillfree'] > 0) {
    // Người dùng được miễn phí
} else {
    $array = []; // Mảng chứa các key hợp lệ nếu có
    if (isset($_POST['key']) && in_array($_POST['key'], $array)) {
        $tiengoc = 5000;
        $tiengoc1 = 10000;
        $tiengoc2 = 10000;
        $tiengoc3 = 0;
    } else {
        $tiengoc = 5000;
        $tiengoc1 = 10000;
        $tiengoc2 = 10000;
        $tiengoc3 = 0;
    }

    if ($user_new && isset($user_new['username'])) {
        $timestampHetHan = strtotime(DB::queryFirstField("SELECT date_bill FROM `users` WHERE username=%s", $user_new['username']));
        if (time() < $timestampHetHan) {
            $tiengoc = $tiengoc1 = $tiengoc2 = 0;
        } else {
            DB::query("UPDATE users SET date_bill='' WHERE username=%s", $user_new['username']);
        }
    }
}

// Các hàm tiện ích
if (!function_exists('formatTimeAgo')) {
    function formatTimeAgo($time) {
        $timestamp = strtotime($time);
        $diff = time() - $timestamp;
        if ($diff < 60) return $diff . " giây trước";
        elseif ($diff < 3600) return floor($diff / 60) . " phút trước";
        elseif ($diff < 86400) return floor($diff / 3600) . " giờ trước";
        elseif ($diff < 604800) return floor($diff / 86400) . " ngày trước";
        else return date("d/m/Y", $timestamp);
    }
}

if (!function_exists('canchinhgiua')) {
    function canchinhgiua($image, $fontsize, $y, $textColor, $font, $text) {
        $textBox = imagettfbbox($fontsize, 0, $font, $text);
        $textWidth = $textBox[2] - $textBox[0];
        $x = (imagesx($image) - $textWidth) / 2;
        imagettftext($image, $fontsize, 0, $x, $y, $textColor, $font, $text);
    }
}

if (!function_exists('removeAccentsAndToUpper')) {
    function removeAccentsAndToUpper($str) {
        $str = mb_strtolower($str, 'UTF-8');
        $str = strtr($str, [
            'á'=>'a','à'=>'a','ả'=>'a','ã'=>'a','ạ'=>'a','ă'=>'a','ắ'=>'a','ằ'=>'a','ẳ'=>'a','ẵ'=>'a','ặ'=>'a',
            'â'=>'a','ấ'=>'a','ầ'=>'a','ẩ'=>'a','ẫ'=>'a','ậ'=>'a','đ'=>'d',
            'é'=>'e','è'=>'e','ẻ'=>'e','ẽ'=>'e','ẹ'=>'e','ê'=>'e','ế'=>'e','ề'=>'e','ể'=>'e','ễ'=>'e','ệ'=>'e',
            'í'=>'i','ì'=>'i','ỉ'=>'i','ĩ'=>'i','ị'=>'i',
            'ó'=>'o','ò'=>'o','ỏ'=>'o','õ'=>'o','ọ'=>'o','ô'=>'o','ố'=>'o','ồ'=>'o','ổ'=>'o','ỗ'=>'o','ộ'=>'o',
            'ơ'=>'o','ớ'=>'o','ờ'=>'o','ở'=>'o','ỡ'=>'o','ợ'=>'o',
            'ú'=>'u','ù'=>'u','ủ'=>'u','ũ'=>'u','ụ'=>'u','ư'=>'u','ứ'=>'u','ừ'=>'u','ử'=>'u','ữ'=>'u','ự'=>'u',
            'ý'=>'y','ỳ'=>'y','ỷ'=>'y','ỹ'=>'y','ỵ'=>'y'
        ]);
        return strtoupper($str);
    }
}

if (!function_exists('removeAccentsAndToUpper1')) {
    function removeAccentsAndToUpper1($str) {
        return removeAccentsAndToUpper($str);
    }
}

if (!function_exists('thongbao')) {
    function thongbao($status, $content) {
        if ($status == 'error') $status = 'danger';
        return '<div class="mt-3 alert alert-'.$status.'" role="alert">'.$content.'</div>';
    }
}

if (!function_exists('generateRandomString')) {
    function generateRandomString($length = 15) {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }
}

// Phân tích MEMO bank
$MEMO_PREFIX = 'nap';
if (!function_exists('get_id_bank')) {
    function get_id_bank($des) {
        global $MEMO_PREFIX;
        preg_match('/'.$MEMO_PREFIX.'\d+/i', $des, $matches);
        if (!empty($matches[0])) {
            return intval(substr($matches[0], strlen($MEMO_PREFIX)));
        }
        return null;
    }
}
