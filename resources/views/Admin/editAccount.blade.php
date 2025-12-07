@extends('admin.pageAdmin')

@section('content')
<h2>Sửa tài khoản</h2>
@if (session('error'))
    <script>alert('{{ session('error') }}');</script>
@endif
<form action="{{ route('admin.account.update', $account->id) }}" method="POST">
    @csrf

    <label>Tên tài khoản</label>
    <input type="text" name="username" value="{{ $account->username }}">

    <label>Mật khẩu</label>
    <input type="password" name="password">

    <label>Vai trò</label>
    <select name="role">
        <option value="admin" {{ $account->role == 'admin' ? 'selected' : '' }}>Admin</option>
        <option value="Teacher" {{ $account->role == 'Teacher' ? 'selected' : '' }}>Giáo viên</option>
        <option value="Student" {{ $account->role == 'Student' ? 'selected' : '' }}>Học sinh</option>
    </select>

    <button type="submit">Cập nhật</button>
</form>
@endsection
