@extends('admin.pageAdmin')

@section('content')
<h1>Quản lý tài khoản</h1>

@if(session('success'))
    <script>alert('{{ session('success') }}');</script>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <strong>Có lỗi xảy ra:</strong>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<button class="click" id="click">Thêm tài khoản mới</button>
<div class="hidden" id="showAdd">

<form action="{{ route('admin.account.store') }}" method="POST">
    @csrf
    <div>Thêm tài khoản</div>
    <div>
        <label>Tên tài khoản</label>
        <input type="text" name="username" value="{{ old('username') }}">
    </div>
    <div>
        <label>Mật khẩu</label>
        <input type="password" name="password">
    </div>
    <div>
        <label>Vai trò</label>
        <select name="role">
            <option value="admin">Admin</option>
            <option value="Teacher">Giáo viên</option>
            <option value="Student">Học sinh</option>
        </select>
    </div>
    <div>
        <button type="submit">Thêm</button>
    </div>
</form>
</div>
<div>
    <table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Tên tài khoản</th>
            <th>Vai trò</th>
            <th>Thời gian</th>
            <th>Chuc nang</th>
        </tr>
    </thead>
    <tbody>
        @foreach($accounts as $account)
        <tr>
            <td>{{ $account->id }}</td>
            <td>{{ $account->username }}</td>
            <td>{{ $account->role }}</td>
            <td>{{ $account->created_at->format('d/m/Y H:i') }}</td>
            <td><a href="{{ route('admin.account.edit', $account->id) }}">
                <button>Sua</button>
                </a>
                <form action="{{ route('admin.account.delete', $account->id) }}" method="GET" style="display:inline;">
                    @csrf
                    @method('DELETE')
                <button>Xoa</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

</div>

<script>
 const btn =document.getElementById('click');
 const showAdd = document.getElementById('showAdd');
 btn.addEventListener('click',()=>{
    showAdd.classList.toggle('hidden');
 })

  
</script>
@endsection
