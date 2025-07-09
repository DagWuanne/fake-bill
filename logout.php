<?php

// Khởi động phiên làm việc
session_start();

// Hủy toàn bộ phiên làm việc
session_destroy();
header("Location: /");
// Chuyển hướng đến trang gốc
?>

<?php
exit;
?>
