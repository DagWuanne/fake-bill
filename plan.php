<!DOCTYPE html>
<html lang="vi">
<link rel="icon" href="/favicon.ico">
<head>
    <meta charset="utf-8">
   <?php
   require 'files/check-session.php';
   if(!isset($_SESSION['username'])){
       header("Location: /login");
   }
   require 'files/config.php';
   use Melbahja\Seo\MetaTags;

$metatags = new MetaTags();

$metatags
        ->title('Thuê gói tháng')
        ->description('Dịch vụ fake bill Vietcombank,Sacombank,MBBank,...')
        ->meta('author', 'BillFake.Com')
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
                <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-5xl mx-auto">

              
     <div class="px-4 py-8">
                        <div class="">
    
                            <h1 class="text-3xl text-slate-800 dark:text-slate-100 font-bold mb-6">Thuê Gói Định Kì</h1>
                            <?php

                            if(isset($_POST['nangcap'])){
                                $plan = $_POST['nangcap'];
                                if($plan == '1ngay'){
                                    $sotien = 125000;
                                    $ngay = 1;
                                }
                                if($plan == '1tuan'){
                                    $sotien = 499000;
                                    $ngay = 7;
                                }
                                if($plan == '1thang'){
                                    $sotien = 1500000;
                                    $ngay = 30;
                                }
                                if($plan == 'vinhvien'){
                                    $sotien = 5000000;
                                    $ngay = 99999;
                                }
                                $sodu = DB::queryFirstField("SELECT sodu FROM `users` WHERE username = '".$_SESSION['username']."'");
                                if($sodu >= $sotien){
                                     DB::query("UPDATE users SET sodu=sodu-$sotien WHERE username='".$_SESSION['username']."'");
                                                                 // Lấy ngày hiện tại
                                        $currentDate = new DateTime();
                                        
                                        // Thêm 30 ngày vào ngày hiện tại
                                        $currentDate->add(new DateInterval('P'.$ngay.'D'));
                                        
                                        // Định dạng ngày sau 30 ngày theo m/d/Y
                                        $formattedDate = $currentDate->format('m/d/Y');
                                        DB::query("UPDATE users SET date_bill='$formattedDate' WHERE username = '".$_SESSION['username']."'");
                                        header("Location: /");
                                     
                                } else {
                                    echo '<script>alert("Số tiền trong tài khoản không đủ, vui lòng nạp thêm.")</script>';
                                }
                            }
                            ?>
                           <div class="grid grid-cols-12 gap-6">
                              
                                                <!-- Tab 3 -->
                                                <div class="relative col-span-full xl:col-span-4 bg-white dark:bg-slate-800 shadow-md rounded-sm border border-slate-200 dark:border-slate-700">
                                                    <div class="absolute top-0 left-0 right-0 h-0.5 bg-indigo-500" aria-hidden="true"></div>
                                                    <div class="px-5 pt-5 pb-6 border-b border-slate-200 dark:border-slate-700">
                                                        <header class="flex items-center mb-2">
                                                            <div class="w-6 h-6 rounded-full shrink-0 bg-gradient-to-tr from-indigo-500 to-indigo-300 mr-3">
                                                                <svg class="w-6 h-6 fill-current text-white" viewBox="0 0 24 24">
                                                                    <path d="M12 17a.833.833 0 01-.833-.833 3.333 3.333 0 00-3.334-3.334.833.833 0 110-1.666 3.333 3.333 0 003.334-3.334.833.833 0 111.666 0 3.333 3.333 0 003.334 3.334.833.833 0 110 1.666 3.333 3.333 0 00-3.334 3.334c0 .46-.373.833-.833.833z"></path>
                                                                </svg>
                                                            </div>
                                                            <h3 class="text-lg text-slate-800 dark:text-slate-100 font-semibold">Khởi đầu</h3>
                                                        </header>
                                                        <div class="text-sm mb-2">Giúp bạn tiết kiệm chi phí sử dụng hàng ngày khi số lượng đơn hàng cao, web con</div>
                                                        <!-- Price -->
                                                        <div class="text-slate-800 dark:text-slate-100 font-bold mb-4">
                                                            <span class="text-2xl">125.000đ</span><span class="text-3xl" x-text="annual ? '74' : '79'">79</span><span class="text-slate-500 font-medium text-sm">/ngày</span>
                                                        </div>
                                                        <!-- CTA -->
                                                       <form action="" method="POST">
                                                            <input name="nangcap" hidden value="1ngay"/>
                                                            <button class="btn bg-indigo-500 hover:bg-indigo-600 text-white w-full">Thuê gói này</button>
                                                        </form>
                                                    </div>
                                                    <div class="px-5 pt-4 pb-5">
                                                        <div class="text-xs text-slate-800 dark:text-slate-100 font-semibold uppercase mb-4">Chúng tôi cung cấp những gì ?</div>
                                                        <!-- List -->
                                                        <ul>
                                                            <li class="flex items-center py-1">
                                                                <svg class="w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2" viewBox="0 0 12 12">
                                                                    <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z"></path>
                                                                </svg>
                                                                <div class="text-sm">Fake bill không giới hạn</div>
                                                            </li>
                                                               <li class="flex items-center py-1">
                                                                <svg class="w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2" viewBox="0 0 12 12">
                                                                    <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z"></path>
                                                                </svg>
                                                                <div class="text-sm">Fake CCCD không giới hạn</div>
                                                            </li>
                                                                <li class="flex items-center py-1">
                                                                <svg class="w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2" viewBox="0 0 12 12">
                                                                    <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z"></path>
                                                                </svg>
                                                                <div class="text-sm">Fake Hộ Chiếu không giới hạn</div>
                                                            </li>
                                                            <li class="flex items-center py-1">
                                                                <svg class="w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2" viewBox="0 0 12 12">
                                                                    <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z"></path>
                                                                </svg>
                                                                <div class="text-sm">Fake BĐSD không giới hạn</div>
                                                            </li>
                                                             <li class="flex items-center py-1">
                                                                <svg class="w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2" viewBox="0 0 12 12">
                                                                    <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z"></path>
                                                                </svg>
                                                                <div class="text-sm">Fake số dư không giới hạn</div>
                                                            </li>
                                                          
                                                        </ul>
                                                    </div>
                                                </div>
                                                 <div class="relative col-span-full xl:col-span-4 bg-white dark:bg-slate-800 shadow-md rounded-sm border border-slate-200 dark:border-slate-700">
                                                    <div class="absolute top-0 left-0 right-0 h-0.5 bg-indigo-500" aria-hidden="true"></div>
                                                    <div class="px-5 pt-5 pb-6 border-b border-slate-200 dark:border-slate-700">
                                                        <header class="flex items-center mb-2">
                                                            <div class="w-6 h-6 rounded-full shrink-0 bg-gradient-to-tr from-indigo-500 to-indigo-300 mr-3">
                                                                <svg class="w-6 h-6 fill-current text-white" viewBox="0 0 24 24">
                                                                    <path d="M12 17a.833.833 0 01-.833-.833 3.333 3.333 0 00-3.334-3.334.833.833 0 110-1.666 3.333 3.333 0 003.334-3.334.833.833 0 111.666 0 3.333 3.333 0 003.334 3.334.833.833 0 110 1.666 3.333 3.333 0 00-3.334 3.334c0 .46-.373.833-.833.833z"></path>
                                                                </svg>
                                                            </div>
                                                            <h3 class="text-lg text-slate-800 dark:text-slate-100 font-semibold">Gói Tuần</h3>
                                                        </header>
                                                        <div class="text-sm mb-2">Tạo vô hạn trong 1 tuần, còn chần chờ gì nữa?</div>
                                                        <!-- Price -->
                                                        <div class="text-slate-800 dark:text-slate-100 font-bold mb-4">
                                                            <span class="text-2xl">499.000đ</span><span class="text-3xl" x-text="annual ? '74' : '79'">79</span><span class="text-slate-500 font-medium text-sm">/tuần</span>
                                                        </div>
                                                        <!-- CTA -->
                                                      <form action="" method="POST">
                                                            <input name="nangcap" hidden value="1tuan"/>
                                                            <button class="btn bg-indigo-500 hover:bg-indigo-600 text-white w-full">Thuê gói này</button>
                                                        </form>
                                                    </div>
                                                    <div class="px-5 pt-4 pb-5">
                                                        <div class="text-xs text-slate-800 dark:text-slate-100 font-semibold uppercase mb-4">Chúng tôi cung cấp những gì ?</div>
                                                        <!-- List -->
                                                        <ul>
                                                            <li class="flex items-center py-1">
                                                                <svg class="w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2" viewBox="0 0 12 12">
                                                                    <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z"></path>
                                                                </svg>
                                                                <div class="text-sm">Fake bill không giới hạn</div>
                                                            </li>
                                                           <li class="flex items-center py-1">
                                                                <svg class="w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2" viewBox="0 0 12 12">
                                                                    <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z"></path>
                                                                </svg>
                                                                <div class="text-sm">Fake CCCD không giới hạn</div>
                                                            </li>
                                                             <li class="flex items-center py-1">
                                                                <svg class="w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2" viewBox="0 0 12 12">
                                                                    <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z"></path>
                                                                </svg>
                                                                <div class="text-sm">Fake Hộ Chiếu không giới hạn</div>
                                                            </li>
                                                            <li class="flex items-center py-1">
                                                                <svg class="w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2" viewBox="0 0 12 12">
                                                                    <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z"></path>
                                                                </svg>
                                                                <div class="text-sm">Fake BĐSD không giới hạn</div>
                                                            </li>
                                                            <li class="flex items-center py-1">
                                                                <svg class="w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2" viewBox="0 0 12 12">
                                                                    <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z"></path>
                                                                </svg>
                                                                <div class="text-sm">Fake số dư không giới hạn</div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                              
                                                                     <div class="relative col-span-full xl:col-span-4 bg-white dark:bg-slate-800 shadow-md rounded-sm border border-slate-200 dark:border-slate-700">
                                                    <div class="absolute top-0 left-0 right-0 h-0.5 bg-indigo-500" aria-hidden="true"></div>
                                                    <div class="px-5 pt-5 pb-6 border-b border-slate-200 dark:border-slate-700">
                                                        <header class="flex items-center mb-2">
                                                            <div class="w-6 h-6 rounded-full shrink-0 bg-gradient-to-tr from-indigo-500 to-indigo-300 mr-3">
                                                                <svg class="w-6 h-6 fill-current text-white" viewBox="0 0 24 24">
                                                                    <path d="M12 17a.833.833 0 01-.833-.833 3.333 3.333 0 00-3.334-3.334.833.833 0 110-1.666 3.333 3.333 0 003.334-3.334.833.833 0 111.666 0 3.333 3.333 0 003.334 3.334.833.833 0 110 1.666 3.333 3.333 0 00-3.334 3.334c0 .46-.373.833-.833.833z"></path>
                                                                </svg>
                                                            </div>
                                                            <h3 class="text-lg text-slate-800 dark:text-slate-100 font-semibold">Plus</h3>
                                                        </header>
                                                        <div class="text-sm mb-2">Tạo vô hạn trong 1 tháng, còn chần chờ gì nữa?</div>
                                                        <!-- Price -->
                                                        <div class="text-slate-800 dark:text-slate-100 font-bold mb-4">
                                                            <span class="text-2xl">1.500.000đ</span><span class="text-3xl" x-text="annual ? '74' : '79'">79</span><span class="text-slate-500 font-medium text-sm">/tháng</span>
                                                        </div>
                                                        <!-- CTA -->
                                                      <form action="" method="POST">
                                                            <input name="nangcap" hidden value="1thang"/>
                                                            <button class="btn bg-indigo-500 hover:bg-indigo-600 text-white w-full">Thuê gói này</button>
                                                        </form>
                                                    </div>
                                                    <div class="px-5 pt-4 pb-5">
                                                        <div class="text-xs text-slate-800 dark:text-slate-100 font-semibold uppercase mb-4">Chúng tôi cung cấp những gì ?</div>
                                                        <!-- List -->
                                                        <ul>
                                                            <li class="flex items-center py-1">
                                                                <svg class="w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2" viewBox="0 0 12 12">
                                                                    <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z"></path>
                                                                </svg>
                                                                <div class="text-sm">Fake bill không giới hạn</div>
                                                            </li>
                                                           <li class="flex items-center py-1">
                                                                <svg class="w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2" viewBox="0 0 12 12">
                                                                    <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z"></path>
                                                                </svg>
                                                                <div class="text-sm">Fake CCCD không giới hạn</div>
                                                            </li>
                                                             <li class="flex items-center py-1">
                                                                <svg class="w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2" viewBox="0 0 12 12">
                                                                    <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z"></path>
                                                                </svg>
                                                                <div class="text-sm">Fake Hộ Chiếu không giới hạn</div>
                                                            </li>
                                                            <li class="flex items-center py-1">
                                                                <svg class="w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2" viewBox="0 0 12 12">
                                                                    <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z"></path>
                                                                </svg>
                                                                <div class="text-sm">Fake BĐSD không giới hạn</div>
                                                            </li>
                                                            <li class="flex items-center py-1">
                                                                <svg class="w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2" viewBox="0 0 12 12">
                                                                    <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z"></path>
                                                                </svg>
                                                                <div class="text-sm">Fake số dư không giới hạn</div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                                      <div class="relative col-span-full xl:col-span-4 bg-white dark:bg-slate-800 shadow-md rounded-sm border border-slate-200 dark:border-slate-700">
                                                    <div class="absolute top-0 left-0 right-0 h-0.5 bg-indigo-500" aria-hidden="true"></div>
                                                    <div class="px-5 pt-5 pb-6 border-b border-slate-200 dark:border-slate-700">
                                                        <header class="flex items-center mb-2">
                                                            <div class="w-6 h-6 rounded-full shrink-0 bg-gradient-to-tr from-indigo-500 to-indigo-300 mr-3">
                                                                <svg class="w-6 h-6 fill-current text-white" viewBox="0 0 24 24">
                                                                    <path d="M12 17a.833.833 0 01-.833-.833 3.333 3.333 0 00-3.334-3.334.833.833 0 110-1.666 3.333 3.333 0 003.334-3.334.833.833 0 111.666 0 3.333 3.333 0 003.334 3.334.833.833 0 110 1.666 3.333 3.333 0 00-3.334 3.334c0 .46-.373.833-.833.833z"></path>
                                                                </svg>
                                                            </div>
                                                            <h3 class="text-lg text-slate-800 dark:text-slate-100 font-semibold">Vô hạn</h3>
                                                        </header>
                                                        <div class="text-sm mb-2">Tạo vô hạn trong vĩnh viễn, còn chần chờ gì nữa?</div>
                                                        <!-- Price -->
                                                        <div class="text-slate-800 dark:text-slate-100 font-bold mb-4">
                                                            <span class="text-2xl">5.000.000đ</span><span class="text-3xl" x-text="annual ? '74' : '79'">79</span><span class="text-slate-500 font-medium text-sm">/vĩnh viễn</span>
                                                        </div>
                                                        <!-- CTA -->
                                                      <form action="" method="POST">
                                                            <input name="nangcap" hidden value="vinhvien"/>
                                                            <button class="btn bg-indigo-500 hover:bg-indigo-600 text-white w-full">Thuê gói này</button>
                                                        </form>
                                                    </div>
                                                    <div class="px-5 pt-4 pb-5">
                                                        <div class="text-xs text-slate-800 dark:text-slate-100 font-semibold uppercase mb-4">Chúng tôi cung cấp những gì ?</div>
                                                        <!-- List -->
                                                        <ul>
                                                            <li class="flex items-center py-1">
                                                                <svg class="w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2" viewBox="0 0 12 12">
                                                                    <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z"></path>
                                                                </svg>
                                                                <div class="text-sm">Fake bill không giới hạn</div>
                                                            </li>
                                                            <li class="flex items-center py-1">
                                                                <svg class="w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2" viewBox="0 0 12 12">
                                                                    <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z"></path>
                                                                </svg>
                                                                <div class="text-sm">Fake CCCD không giới hạn</div>
                                                            </li>
                                                             <li class="flex items-center py-1">
                                                                <svg class="w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2" viewBox="0 0 12 12">
                                                                    <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z"></path>
                                                                </svg>
                                                                <div class="text-sm">Fake Hộ Chiếu không giới hạn</div>
                                                            </li>
                                                            <li class="flex items-center py-1">
                                                                <svg class="w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2" viewBox="0 0 12 12">
                                                                    <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z"></path>
                                                                </svg>
                                                                <div class="text-sm">Fake BĐSD không giới hạn</div>
                                                            </li>
                                                            <li class="flex items-center py-1">
                                                                <svg class="w-3 h-3 shrink-0 fill-current text-emerald-500 mr-2" viewBox="0 0 12 12">
                                                                    <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z"></path>
                                                                </svg>
                                                                <div class="text-sm">Fake số dư không giới hạn</div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                       
    
                        </div>
                    </div>

                </div>
            </main>

       <?php
       include('files/footer.php');?>