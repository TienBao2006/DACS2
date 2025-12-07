<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css')}}">
    <link rel="stylesheet" href="{{ asset('css/account.css')}}">
</head>
<body>
    
    <div class="sidebar" id="sidebar">

    <h2>Admin Panel</h2>
    
        <button id="toggleBtn" class="toggle-btn"><i class="fas fa-bars"></i></button>
  <ul>
    <li><a href="{{route('admin.user')}}"><i class="fas fa-home"></i> <span>Trang chủ</span></a></li>
    <li><a href="{{route('admin.account.index')}}"><i class="fas fa-user"></i> <span>Quản lý tài khoản</span></a></li>
    <li><a href="#"><i class="fas fa-box"></i> <span>Products</span></a></li>
    <li><a href="#"><i class="fas fa-shopping-cart"></i> <span>Orders</span></a></li>
    <li><a href="#"><i class="fas fa-cog"></i> <span>Settings</span></a></li>
    <li><a href="{{route('admin.logout')}}"><i class="fas fa-sign-out-alt"></i> <span>Logout</span></a></li>
</ul>

</div>
<div class="content">
    @yield('content') 
</div>
<script>
    const toggleBtn = document.getElementById('toggleBtn');
    const sidebar = document.getElementById('sidebar');

    toggleBtn.addEventListener('click', () => {
        sidebar.classList.toggle('collapsed');
    });
</script>

</body>
</html>