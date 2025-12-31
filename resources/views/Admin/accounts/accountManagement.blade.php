@extends('Admin.pageAdmin')

@section('title', 'Quản lý tài khoản')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-users"></i> Quản lý tài khoản
                    </h3>
                </div>
                
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        <strong>Thông báo:</strong> Trang quản lý tài khoản đang được phát triển.
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card bg-primary text-white">
                                <div class="card-body">
                                    <h5>Quản lý tài khoản học sinh</h5>
                                    <p>Tạo, chỉnh sửa và quản lý tài khoản học sinh</p>
                                    <a href="{{ route('admin.student-accounts.index') }}" class="btn btn-light">
                                        <i class="fas fa-user-graduate"></i> Truy cập
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="card bg-success text-white">
                                <div class="card-body">
                                    <h5>Quản lý tài khoản giáo viên</h5>
                                    <p>Tạo, chỉnh sửa và quản lý tài khoản giáo viên</p>
                                    <a href="{{ route('admin.teacher-accounts.index') }}" class="btn btn-light">
                                        <i class="fas fa-chalkboard-teacher"></i> Truy cập
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="card bg-warning text-white">
                                <div class="card-body">
                                    <h5>Quản lý thanh toán</h5>
                                    <p>Tạo và quản lý khoản thu cho học sinh</p>
                                    <a href="{{ route('admin.payments.index') }}" class="btn btn-light">
                                        <i class="fas fa-credit-card"></i> Truy cập
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <a href="{{ route('admin.user') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Quay lại Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection