<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Đăng Nhập</title>
    <link rel="stylesheet" href="{{ asset('css/login.css')}}">
</head>
<body>
    @if(session('success'))
    <script>
        alert('{{ session('success') }}');
    </script>
@endif

@if(session('error'))
    <script>
        alert('{{ session('error') }}');
    </script>
@endif

    <form action="{{route('login.submit')}}" method="POST">
        @csrf
    <div>Đăng nhập</div>
    <div>
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
    </div>
    <div>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
    </div>
    <div>
        <button type="submit">Login</button>
    </div>
</form>

</body>
</html>