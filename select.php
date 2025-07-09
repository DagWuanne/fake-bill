<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">
   <?php
   session_start();
   require 'files/config.php';
   use Melbahja\Seo\MetaTags;
$user = DB::queryFirstRow("SELECT * FROM bank1 WHERE file_name=%s", $_GET['name']);
$metatags = new MetaTags();

$metatags
        ->title('Fake bill chuyển tiền ngân hàng '.$user['name'])
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

              
     <div class="px-4 py-8">
                        <div class="max-w-md mx-auto">
    
                            <h1 class="text-3xl text-slate-800 dark:text-slate-100 font-bold mb-6">Dịch vụ cần dùng</h1>
                            
                                <div class="space-y-3 mb-8">
                                   
                                    <a href="<?=$domain?>/fake-bill-chuyen-tien-<?=$_GET['name']?>" class="relative block cursor-pointer">
                                        
                                        <div class="flex items-center bg-white text-sm font-medium text-slate-800 dark:text-slate-100 p-4 rounded dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:border-slate-300 dark:hover:border-slate-600 shadow-sm duration-150 ease-in-out">
                                          
                                            <svg xmlns="http://www.w3.org/2000/svg" class=" w-6 h-6 shrink-0 fill-current mr-4 icon icon-tabler icon-tabler-wallet" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round">
  <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
  <path class="text-indigo-500" d="M17 8v-3a1 1 0 0 0 -1 -1h-10a2 2 0 0 0 0 4h12a1 1 0 0 1 1 1v3m0 4v3a1 1 0 0 1 -1 1h-12a2 2 0 0 1 -2 -2v-12" />
  <path class="text-indigo-300" d="M20 12v4h-4a2 2 0 0 1 0 -4h4" />
</svg>
                                            <span>Fake bill chuyển tiền</span>
                                        </div>
                                        <div class="absolute inset-0 border-2 border-transparent peer-checked:border-indigo-400 dark:peer-checked:border-indigo-500 rounded pointer-events-none" aria-hidden="true"></div>
                                    </a>
                                   <a  href="<?=$domain?>/fake-lich-su-giao-dich-<?=$_GET['name']?>" class="relative block cursor-pointer">
                                    
                                        <div class="flex items-center bg-white text-sm font-medium text-slate-800 dark:text-slate-100 p-4 rounded dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:border-slate-300 dark:hover:border-slate-600 shadow-sm duration-150 ease-in-out">
                                           
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 shrink-0 fill-current mr-4 icon icon-tabler icon-tabler-history" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round">
  <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
  <path class="text-indigo-500" d="M12 8l0 4l2 2" />
  <path class="text-indigo-500" d="M3.05 11a9 9 0 1 1 .5 4m-.5 5v-5h5" />
</svg>
                                            <span>Fake lịch sử giao dịch</span>
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