@extends('Admin.pageAdmin')

@section('content')

<div class="account-management">
    <div class="page-header">
        <h1 class="page-title">
            <i class="fas fa-user-graduate"></i>
            Quản lý tài khoản học sinh
        </h1>
        <a href="{{ route('admin.student-accounts.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i>
            Thêm tài khoản học sinh
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
            <div class="stat-number">{{ $studentAccounts->count() }}</div>
            <div class="stat-label">Tổng học sinh</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $studentAccounts->where('has_login', true)->where('is_active', true)->count() }}</div>
            <div class="stat-label">Có tài khoản hoạt động</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $studentAccounts->where('has_login', false)->count() }}</div>
            <div class="stat-label">Chưa có tài khoản</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $studentAccounts->where('created_at', '>=', now()->startOfMonth())->count() }}</div>
            <div class="stat-label">Tạo tháng này</div>
        </div>
    </div>

    @if($studentAccounts->count() > 0)
    <div class="table-container">
        <table class="accounts-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Thông tin học sinh</th>
                    <th>Lớp</th>
                    <th>Trạng thái</th>
                    <th>Ngày tạo</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @foreach($studentAccounts as $account)
                <tr>
                    <td>{{ $account->student->id }}</td>
                    <td>
                        <strong>{{ $account->username }}</strong>
                        @if(!$account->has_login)
                            <br><small class="text-warning">Chưa có tài khoản login</small>
                        @else
                            <br><small class="text-muted">Có tài khoản login</small>
                        @endif
                    </td>
                    <td>
                        <div class="student-info">
                            <span class="student-name">{{ $account->student->ho_va_ten ?? 'Chưa cập nhật' }}</span>
                            <span class="student-code">{{ $account->student->ma_hoc_sinh ?? 'N/A' }}</span>
                        </div>
                    </td>
                    <td>
                        <span class="class-badge">{{ $account->student->lop }}</span>
                    </td>
                    <td>
                        @if($account->has_login)
                            <span class="status-badge {{ $account->is_active ? 'status-active' : 'status-inactive' }}">
                                <i class="fas fa-{{ $account->is_active ? 'check-circle' : 'times-circle' }}"></i>
                                {{ $account->is_active ? 'Hoạt động' : 'Bị khóa' }}
                            </span>
                        @else
                            <span class="status-badge status-inactive">
                                <i class="fas fa-user-slash"></i>
                                Chưa có tài khoản
                            </span>
                        @endif
                    </td>
                    <td>{{ $account->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <div class="action-buttons">
                            @if($account->has_login)
                                <a href="{{ route('admin.student-accounts.edit', $account->id) }}" 
                                   class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                    Sửa
                                </a>
                                
                                <form action="{{ route('admin.student-accounts.toggle-status', $account->id) }}" 
                                      method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" 
                                            class="btn {{ $account->is_active ? 'btn-danger' : 'btn-success' }} btn-sm">
                                        <i class="fas fa-{{ $account->is_active ? 'lock' : 'unlock' }}"></i>
                                        {{ $account->is_active ? 'Khóa' : 'Mở khóa' }}
                                    </button>
                                </form>
                                
                                <form action="{{ route('admin.student-accounts.destroy', $account->id) }}" 
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
                                <a href="{{ route('admin.student-accounts.create-for-student', $account->student->id) }}" 
                                   class="btn btn-primary btn-sm">
                                    <i class="fas fa-plus"></i>
                                    Tạo tài khoản
                                </a>
                                
                                <a href="#" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i>
                                    Xem hồ sơ
                                </a>
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
        <i class="fas fa-user-graduate"></i>
        <h3>Chưa có tài khoản học sinh nào</h3>
        <p>Hãy tạo tài khoản đầu tiên cho học sinh</p>
        <a href="{{ route('admin.student-accounts.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i>
            Tạo tài khoản học sinh
        </a>
    </div>
    @endif
</div>

<script>
function createLoginAccount(studentId) {
    if (confirm('Bạn có muốn tạo tài khoản login cho học sinh này?')) {
        // Tạo form để gửi request
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '/admin/student-accounts/create-login/' + studentId;
        
        // CSRF token
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        form.appendChild(csrfToken);
        
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endsection