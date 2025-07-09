  <?php
   require 'files/config.php';
   require 'files/check-session.php';
   if(isset($_SESSION['username'])){
    header('Location: /');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy dữ liệu từ biểu mẫu
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Kiểm tra xem người dùng tồn tại trong cơ sở dữ liệu
    $user = DB::queryFirstRow("SELECT * FROM users WHERE username = %s", $username);

    if ($user && password_verify($password, $user['password'])) {
        // Đăng nhập thành công
        
        $successMessage = "Đăng nhập thành công!";
        $_SESSION['username'] = $username;
        echo '<script>window.location.href="/";</script>';
    } else {
        // Đăng nhập thất bại, hiển thị thông báo lỗi
        $errorMessage = "Tên người dùng hoặc mật khẩu không đúng.";
    }
}
   ?>
<!DOCTYPE html>
<html lang="vi">
<link rel="icon" href="/favicon.ico">
<head>
    <meta charset="utf-8">
    <title>Đăng nhập BillFake.Com</title>
    <meta name="viewport" content="width=device-width,initial-scale=0">
    <link href="./css/vendors/flatpickr.min.css" rel="stylesheet">
    <link href="./style.css" rel="stylesheet">
    <link href="./css/nhan.css?v1" rel="stylesheet">
    <script>
        if (localStorage.getItem('dark-mode') === 'false' || !('dark-mode' in localStorage)) {
            document.querySelector('html').classList.remove('dark');
            document.querySelector('html').style.colorScheme = 'light';
        } else {
            document.querySelector('html').classList.add('dark');
            document.querySelector('html').style.colorScheme = 'dark';
        }
    </script>    
</head>

<body class="font-inter antialiased bg-slate-100 dark:bg-slate-900 text-slate-600 dark:text-slate-400">

    <script>
        if (localStorage.getItem('sidebar-expanded') == 'true') {
            document.querySelector('body').classList.add('sidebar-expanded');
        } else {
            document.querySelector('body').classList.remove('sidebar-expanded');
        }
    </script>    

    <main class="bg-white dark:bg-slate-900">

        <div class="relative flex">

            <!-- Content -->
            <div class="w-full md:w-1/2">

                <div class="min-h-[100dvh] h-full flex flex-col after:flex-1">

                    <!-- Header -->
                    <div class="flex-1">
                        <div class="flex items-center justify-between h-16 px-4 sm:px-6 lg:px-8">
                            <!-- Logo -->
                            <a class="block" href="/">
                              <img src="/logo.png" width="200" height="40"/>
                            </a>
                        </div>
                    </div>
    
                    <div class="max-w-sm mx-auto w-full px-4 py-8">
        
                        <h1 class="text-3xl text-slate-800 dark:text-slate-100 font-bold mb-6">Chào mừng bạn đến với BillFake.Com! ✨</h1>
                        <!-- Form -->
                         <?php if (isset($errorMessage)): echo thongbao('error',$errorMessage)?>
 <?php elseif (isset($successMessage)): echo thongbao('success',$successMessage)?>
 <?php endif; ?>
                        <form action="" method="POST">
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium mb-1" for="username">Tên đăng nhập</label>
                                    <input id="text" class="form-input w-full" name="username" type="text" />
                                </div>
                                <div>
                                    <label class="block text-sm font-medium mb-1" for="password">Mật khẩu</label>
                                    <input id="password" class="form-input w-full" name="password" type="password" autocomplete="on" />
                                </div>
                            </div>
                            <div class="flex items-center justify-between mt-6">
                               
                                <button class="btn bg-indigo-500 hover:bg-indigo-600 text-white" type="submit">Đăng nhập</button>
                            </div>
                        </form>
                        <!-- Footer -->
                        <div class="pt-5 mt-6 border-t border-slate-200 dark:border-slate-700">
                            <div class="text-sm">
                               Bạn chưa có tài khoản? <a class="font-medium text-indigo-500 hover:text-indigo-600 dark:hover:text-indigo-400" href="register">Đăng ký ngay</a>
                            </div>
                            <!-- Warning -->
                            <div class="mt-5">
                                <div class="bg-amber-100 dark:bg-amber-400/30 text-amber-600 dark:text-amber-400 px-3 py-2 rounded">
                                    <svg class="inline w-3 h-3 shrink-0 fill-current" viewBox="0 0 12 12">
                                        <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z" />
                                    </svg>
                                    <span class="text-sm">
                                        Dịch vụ fake bill chất lượng cao, ảnh full HD, hỗ trợ giao diện android/ios và hơn thế nữa
                                    </span>
                                </div>
                            </div>
                        </div>
        
                    </div>

                </div>

            </div>

            <!-- Image -->
            <div class="hidden md:block absolute top-0 bottom-0 right-0 md:w-1/2" aria-hidden="true">
                <img class="object-cover object-center w-full h-full" src="./uploads/login-v2-dark.svg" width="300" height="600" alt="Authentication image" />
               
            </div>

        </div>

    </main>

    <script src="./js/vendors/alpinejs.min.js" defer></script>
    <script src="./js/main.js"></script>

</body>

</html>