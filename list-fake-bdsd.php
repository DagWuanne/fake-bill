<!DOCTYPE html>
<html lang="vi">
<link rel="icon" href="/favicon.ico">
<head>
    <meta charset="utf-8">
   <?php
   session_start();
   require 'files/config.php';
   use Melbahja\Seo\MetaTags;

$metatags = new MetaTags();

$metatags
        ->title('Công cụ fake bill chuyển khoản chuẩn dùng để seeding')
        ->description('Dịch vụ fake bill Vietcombank,Sacombank,MBBank,...')
        ->meta('author', 'Mohamed Elabhja')
        ->image('https://avatars3.githubusercontent.com/u/8259014');

echo $metatags;
   ?>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link href="./css/vendors/flatpickr.min.css" rel="stylesheet">
    <link href="./css/vendors/flatpickr.min.css" rel="stylesheet">
    <link href="./style.css" rel="stylesheet">
    <script>
        if (localStorage.getItem('dark-mode') === 'false' || !('dark-mode' in localStorage)) {
            document.querySelector('html').classList.remove('dark');
            document.querySelector('html').style.colorScheme = 'light';
        } else {
            document.querySelector('html').classList.add('dark');
            document.querySelector('html').style.colorScheme = 'dark';
        }
    </script>  
    <style>
    @media only screen and (min-width: 800px) {

        .grid-cols-5 {
    grid-template-columns: repeat(7, minmax(0, 1fr));
}
}
 @media only screen and (max-width: 800px) {

        .grid-cols-5 {
    grid-template-columns: repeat(2, minmax(0, 1fr));
}
}

    </style>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body
    class="font-inter antialiased bg-slate-100 dark:bg-slate-900 text-slate-600 dark:text-slate-400"
    :class="{ 'sidebar-expanded': sidebarExpanded }"
    x-data="{ sidebarOpen: false, sidebarExpanded: localStorage.getItem('sidebar-expanded') == 'true' }"
    x-init="$watch('sidebarExpanded', value => localStorage.setItem('sidebar-expanded', value))"
>

<?php include('files/header.php');?>

            <main class="grow">  
                <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
                   

                    <!-- Page header -->
                    <div class="sm:flex sm:justify-between sm:items-center mb-5">
                    
                        <!-- Left: Title -->
                    
                        <div class="mb-4 sm:mb-0">
                            <h1 class="text-2xl md:text-3xl text-slate-800 dark:text-slate-100 font-bold">Fake biến động số dư ✨</h1>

  </div>
                    
                      
                    </div>

                    <!-- Cards -->
             <div class="grid gap-5 sm:grid-cols-3 grid-cols-5  grid:items-center">
<?php
$results = DB::query("SELECT * FROM bank1 WHERE active = '1' AND bdsd = '1' ORDER BY id ASC");
foreach ($results as $result) {
  echo '<a href="fake-bien-dong-'.$result['file_name'].'" class="bg-white dark:bg-slate-800 shadow-lg rounded-xl p-5">
                                        <!-- Start -->
                                        <div class="relative">
                                           <center>
                                                Tạo Bill</br>
                                            <b><medium>'.$result['name'].'</medium></b>
                                            </center>
                                        </div>
                                        
                                        <!-- End -->
                                    </a>';
}
?>
                                     </div>
                                    
                              
                                <br/>

                     <div class="flex flex-col col-span-full sm:col-span-6 xl:col-span-4 bg-white dark:bg-slate-800 shadow-lg rounded-sm border border-slate-200 dark:border-slate-700 mt-4">
                            <header class="px-5 py-4 border-b border-slate-100 dark:border-slate-700 flex items-center">
                                <h2 class="font-semibold text-slate-800 dark:text-slate-100">Demo bill biến động số dư</h2>
                                <div class="relative ml-2" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                                    <button class="block" aria-haspopup="true" :aria-expanded="open" @focus="open = true" @focusout="open = false" @click.prevent="" aria-expanded="false">
                                        <svg class="w-4 h-4 fill-current text-slate-400 dark:text-slate-500" viewBox="0 0 16 16">
                                            <path d="M8 0C3.6 0 0 3.6 0 8s3.6 8 8 8 8-3.6 8-8-3.6-8-8-8zm0 12c-.6 0-1-.4-1-1s.4-1 1-1 1 .4 1 1-.4 1-1 1zm1-3H7V4h2v5z"></path>
                                        </svg>
                                    </button>
                                    <div class="z-10 absolute bottom-full left-1/2 -translate-x-1/2">
                                        <div class="bg-white dark:bg-slate-700 dark:text-slate-100 border border-slate-200 dark:border-slate-600 p-3 rounded shadow-lg overflow-hidden mb-2" x-show="open" x-transition:enter="transition ease-out duration-200 transform" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-out duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" style="display: none;">
                                            <div class="text-xs text-center whitespace-nowrap">Ảnh demo các bill được tạo trên web</div>
                                        </div>
                                    </div>
                                </div>
                            </header>
<div class="py-3 px-5 grid grid-cols-12 gap-6">
                        
                        <!-- Card 1 -->
                       
           <?php
           $thuMucAnh = 'demo_bdsd/';

// Lấy danh sách tất cả các tệp trong thư mục
$danhSachTep = scandir($thuMucAnh);

// Loại bỏ các tệp . và ..
$danhSachTep = array_diff($danhSachTep, array('..', '.'));

// Hiển thị các ảnh trong thẻ <img>
foreach ($danhSachTep as $tep) {
    // Kiểm tra nếu là file ảnh (có thể cần kiểm tra phần mở rộng tệp hợp lệ)
    $duongDanTep = $thuMucAnh . $tep;
    if (is_file($duongDanTep) && getimagesize($duongDanTep)) {
        echo ' <div onclick="window.location.href=\'tao-bill-chuyen-tien\'" class="col-span-6 sm:col-span-6 xl:col-span-3 bg-white dark:bg-slate-800 shadow-lg rounded-sm border border-slate-200 dark:border-slate-700"><img src="' . $duongDanTep . '" alt="' . $tep . '"></div>';
    }
}
           ?>
              </div> </div>
           
                </div>
                
            </main>

       <?php
       include('files/footer.php');?>