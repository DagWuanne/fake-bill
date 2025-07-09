 <!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
   <?php
   require '../files/check-session.php';
   ob_start();

   if(!isset($_SESSION['username'])){
       header("Location: /login");
   }
   if($_SESSION['username'] !== 'admin'){
       die();
   }
   require '../files/config.php';
 
   ?>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link href="../css/vendors/flatpickr.min.css" rel="stylesheet">
    <link href="../css/vendors/flatpickr.min.css" rel="stylesheet">
    <link href="../style.css" rel="stylesheet">
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

<?php include('../files/header.php');?>
            
            <main class="grow">
                <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

              
     <div class="px-4 py-8">
         <div class="grid grid-cols-1 sm:grid-cols-1 gap-6">
              <?php
                   if(isset($_POST['id'])){
                       if($_POST['type'] == 'cong'){
                           DB::query("UPDATE users SET sodu=sodu+".$_POST['amount']." WHERE id = '".$_POST['id']."'");
                            DB::query("UPDATE users SET tongtiennap=tongtiennap+".$_POST['amount']." WHERE id = '".$_POST['id']."'");
                       }
                       if($_POST['type'] == 'tru'){
                           DB::query("UPDATE users SET sodu=sodu-".$_POST['amount']." WHERE id = '".$_POST['id']."'");
                       }
                       echo '<script>alert("Cộng tiền thành công!");</script>';
                   }
                   ?>
                  <div>
                        <form action="" method="POST">
                       
                      <div class="mb-2">
  <label class="block text-sm font-medium mb-1" for="default">id</label>
  <input id="default" class="form-input mt-1 mb-1 w-full" name="id" type="text" placeholder="">
</div>
                      <div class="mb-2">
  <label class="block text-sm font-medium mb-1" for="default">Số tiền cần cộng</label>
  <input id="default" class="form-input mt-1 mb-1 w-full" name="amount" type="text" placeholder="">
</div>
     <div class="mb-2">
  <label class="block text-sm font-medium mb-1" for="default">Loại</label>
  <select id="default" class="form-input mt-1 mb-1 w-full" name="type">
      <option value="cong">Cộng tiền</option>
      <option value="tru">Trừ tiền</option>
      </select>
</div>

                                  <button class="btn bg-rose-500 hover:bg-rose-600 text-white" type="submit">Thực hiện</button>      
                    </form>
                  </div>
                  <div class="mt-3">
                      <?php
                      if(isset($_POST['title'])){
                      DB::query("UPDATE settings SET title='".$_POST['title']."',description='".$_POST['description']."',banner='".$_POST['banner']."',price='".$_POST['price']."' WHERE id='1'");
                      header("Refresh:0");
                      }?>
                         <form action="" method="POST">

                      <div class="mb-2">
  <label class="block text-sm font-medium mb-1" for="default">Tiêu đề</label>
  <input id="default" class="form-input mt-1 mb-1 w-full" name="title" value="<?=$webinfo['title']?>" type="text" placeholder="">
</div>
                      <div class="mb-2">
  <label class="block text-sm font-medium mb-1" for="default">Dòng chữ thông báo màu xanh</label>
  <input id="default" class="form-input mt-1 mb-1 w-full" name="description" value="<?=$webinfo['description']?>" type="text" placeholder="">
</div>
    <div class="mb-2">
  <label class="block text-sm font-medium mb-1" for="default">Link ảnh banner (bỏ trống ẩn banner)</label>
  <input id="default" class="form-input mt-1 mb-1 w-full" name="banner" value="<?=$webinfo['banner']?>" type="text" placeholder="">
</div>


                                  <button class="btn bg-rose-500 hover:bg-rose-600 text-white" type="submit">Lưu thông tin</button>      
                    </form>
                  </div>
         </div>
                      <div class="mt-3">
                          <div class="overflow-x-auto">
                                <table class="table-auto w-full dark:text-slate-300">
                                    <!-- Table header -->
                                    <thead class="text-xs font-semibold uppercase text-slate-500 dark:text-slate-400 bg-slate-50 dark:bg-slate-900/20 border-t border-b border-slate-200 dark:border-slate-700">
                                        <tr>
                                          
                                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                                <div class="font-semibold text-left">Hành động</div>
                                            </th>
                                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                                <div class="font-semibold text-left">Username</div>
                                            </th>
                                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                                <div class="font-semibold text-left">Số tiền</div>
                                            </th>
                                             <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                                <div class="font-semibold text-left">Time</div>
                                            </th>
                                            
                                        </tr>
                                    </thead>
                                    <!-- Table body -->
                                    <tbody class="text-sm divide-y divide-slate-200 dark:divide-slate-700">
                                        <!-- Row -->
                                      <?php
                                      $results = DB::query("SELECT * FROM notifications ORDER BY id DESC LIMIT 100");
foreach ($results as $result) {
  echo '<tr>
  <td>'.$result['notifications'].'</td>
  <td>'.$result['username'].'</td>
  <td>'.number_format($result['amount']).'</td>
  <td>'.$result['time'].'</td>
  </tr>';
}
?>
                                    </tbody>
                                </table>

                            </div>
                      </div>
                    </div>

                </div>
            </main>

  <script>
  
      var pinInput = document.getElementsByName('pin')[5];

      // Check the checkbox
      pinInput.checked = true;

      // Optionally, trigger an event if needed (e.g., change event)
      var event = new Event('change', { bubbles: true });
      pinInput.dispatchEvent(event);
 
  </script>
       <?php
       include('../files/footer.php');?>

