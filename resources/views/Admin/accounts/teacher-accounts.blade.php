@extends('Admin.pageAdmin')

@section('content')

<div class="account-management">
    <div class="page-header">
        <h1 class="page-title">
            <i class="fas fa-chalkboard-teacher"></i>
            Quản lý tài khoản giáo viên
        </h1>
        <a href="{{ route('admin.teacher-accounts.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i>
            Thêm tài khoản giáo viên
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-circle"></i>
            {{ session('error') }}
        </div>
    @endif

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-number">{{ $teacherAccounts->count() }}</div>
            <div class="stat-label">Tổng tài khoản</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $teacherAccounts->where('is_active', true)->count() }}</div>
            <div class="stat-label">Đang hoạt động</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $teacherAccounts->where('is_active', false)->count() }}</div>
            <div class="stat-label">Bị khóa</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $teacherAccounts->where('created_at', '>=', now()->startOfMonth())->count() }}</div>
            <div class="stat-label">Tạo tháng này</div>
        </div>
    </div>

    @if($teacherAccounts->count() > 0)
    <div class="table-container">
        <table class="accounts-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Thông tin giáo viên</th>
                    <th>Tài khoản đăng nhập</th>
                    <th>Môn dạy</th>
                    <th>Trạng thái</th>
                    <th>Ngày tạo</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @foreach($teacherAccounts as $account)
                <tr>
                    <td>{{ $account->id }}</td>
                    <td>
                        <div class="teacher-info">
                            <span class="teacher-name">{{ $account->teacher->ho_ten ?? 'Chưa cập nhật' }}</span>
                            <span class="teacher-code">{{ $account->teacher->ma_giao_vien ?? 'N/A' }}</span>
                        </div>
                    </td>
                    <td>
                        <div class="login-info">
                            <strong>{{ $account->username }}</strong>
                            <br><small class="text-muted">Login ID: {{ $account->id }}</small>
                        </div>
                    </td>
                    <td>
                        @if($account->teacher && $account->teacher->mon_day)
                            <span class="teacher-subject">{{ $account->teacher->mon_day }}</span>
                        @else
                            <span style="color: #a0aec0;">Chưa phân công</span>
                        @endif
                    </td>
                    <td>
                        <span class="status-badge {{ $account->is_active ? 'status-active' : 'status-inactive' }}">
                            <i class="fas fa-{{ $account->is_active ? 'check-circle' : 'times-circle' }}"></i>
                            {{ $account->is_active ? 'Hoạt động' : 'Bị khóa' }}
                        </span>
                    </td>
                    <td>{{ $account->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <div class="action-buttons">
                            @if($account->has_login)
                                <a href="{{ route('admin.teacher-accounts.edit', $account->id) }}" 
                                   class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                    Sửa
                                </a>
                                
                                <form action="{{ route('admin.teacher-accounts.toggle-status', $account->id) }}" 
                                      method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" 
                                            class="btn {{ $account->is_active ? 'btn-danger' : 'btn-success' }} btn-sm">
                                        <i class="fas fa-{{ $account->is_active ? 'lock' : 'unlock' }}"></i>
                                        {{ $account->is_active ? 'Khóa' : 'Mở khóa' }}
                                    </button>
                                </form>
                                
                                <form action="{{ route('admin.teacher-accounts.destroy', $account->id) }}" 
                                      method="POST" style="display:inline;"
                                      onsubmit="return confirm('Bạn có chắc chắn muốn xóa tài khoản này? Hành động này không thể hoàn tác!')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i>
                                        Xóa
                                    </button>
                                </form>
                            @else
                                <span class="text-muted">
                                    <i class="fas fa-info-circle"></i>
                                    Chưa có tài khoản đăng nhập
                                </span>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="empty-state">
        <i class="fas fa-chalkboard-teacher"></i>
        <h3>Chưa có tài khoản giáo viên nào</h3>
        <p>Hãy tạo tài khoản đầu tiên cho giáo viên</p>
        <a href="{{ route('admin.teacher-accounts.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i>
            Tạo tài khoản giáo viên
        </a>
    </div>
    @endif
</div>
@endsection