<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">
   <?php
   require 'files/check-session.php';
   if(!isset($_SESSION['username'])){
       header("Location: /");
   }
   require 'files/config.php';
   use Melbahja\Seo\MetaTags;

$metatags = new MetaTags();

$metatags
        ->title('Nạp tiền vào hệ thống')
        ->description('Dịch vụ fake bill Vietcombank,Sacombank,MBBank,...')
        ->meta('author', 'Mohamed Elabhja')
        ->image('https://avatars3.githubusercontent.com/u/8259014');

echo $metatags;
   ?>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link href="./css/vendors/flatpickr.min.css" rel="stylesheet">
    <link href="./css/vendors/flatpickr.min.css" rel="stylesheet">
    <link href="./css/nhan.css?v2" rel="stylesheet">
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
</head>

<body
    class="font-inter antialiased bg-slate-100 dark:bg-slate-900 text-slate-600 dark:text-slate-400"
    :class="{ 'sidebar-expanded': sidebarExpanded }"
    x-data="{ sidebarOpen: false, sidebarExpanded: localStorage.getItem('sidebar-expanded') == 'true' }"
    x-init="$watch('sidebarExpanded', value => localStorage.setItem('sidebar-expanded', value))"
>

<?php include('files/header.php');?>
            
            <main class="grow">
                <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-2xl mx-auto">

              
     <div class="px-4 py-8">
                        <div class="">
    
                            <h1 class="text-3xl text-slate-800 dark:text-slate-100 font-bold mb-6">Member Topup</h1>
                            <?=thongbao('success','<li>Nạp tiền vào hệ thống sẽ được duyệt tiền tự động</li>
                            <li>Thời gian duyệt sẽ từ 30s-1p</li>
                            <li>Chuyển khoản sai nội dung vui lòng nhắn tin fanpage để được hỗ trợ cộng tiền thủ công (phạt 20%)</li>
                            <li>Nạp tiền bằng thẻ cào sẽ có chiết khấu %</li>')?>
                            
                                <div class="space-y-3 mb-8">
                                    <a href="transfer" class="relative block cursor-pointer">
                                        <input type="radio" name="type" value="transfer" class="peer sr-only" >
                                        <div class="flex items-center bg-white text-sm font-medium text-slate-800 dark:text-slate-100 p-4 rounded dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:border-slate-300 dark:hover:border-slate-600 shadow-sm duration-150 ease-in-out">
                                            <svg class="w-6 h-6 shrink-0 fill-current mr-4" viewBox="0 0 24 24">
                                                <path class="text-indigo-500" d="m12 10.856 9-5-8.514-4.73a1 1 0 0 0-.972 0L3 5.856l9 5Z"></path>
                                                <path class="text-indigo-300" d="m11 12.588-9-5V18a1 1 0 0 0 .514.874L11 23.588v-11Z"></path>
                                                <path class="text-indigo-200" d="M13 12.588v11l8.486-4.714A1 1 0 0 0 22 18V7.589l-9 4.999Z"></path>
                                            </svg>
                                            <span>Chuyển khoản ngân hàng</span>
                                        </div>
                                        <div class="absolute inset-0 border-2 border-transparent peer-checked:border-indigo-400 dark:peer-checked:border-indigo-500 rounded pointer-events-none" aria-hidden="true"></div>
                                    </a>
                             
                             
                                </div>
                               
                       
    
                        </div>
                    </div>

                </div>
            </main>

       <?php
       include('files/footer.php');?>