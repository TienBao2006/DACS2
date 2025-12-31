@extends('Admin.pageAdmin')

@section('title', 'Quản lý thanh toán')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">
                        <i class="fas fa-credit-card"></i> Quản lý thanh toán
                    </h3>
                    <a href="{{ route('admin.payments.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tạo khoản thu mới
                    </a>
                </div>
                
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Thống kê tổng quan -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card bg-primary text-white">
                                <div class="card-body">
                                    <h5>Tổng khoản thu</h5>
                                    <h3>{{ $payments->total() }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-warning text-white">
                                <div class="card-body">
                                    <h5>Chưa thanh toán</h5>
                                    <h3>{{ \App\Models\Payment::where('status', 'PENDING')->count() }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-success text-white">
                                <div class="card-body">
                                    <h5>Đã thanh toán</h5>
                                    <h3>{{ \App\Models\Payment::where('status', 'COMPLETED')->count() }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-info text-white">
                                <div class="card-body">
                                    <h5>Tổng số tiền</h5>
                                    <h3>{{ number_format(\App\Models\Payment::sum('amount')) }} VNĐ</h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Học sinh</th>
                                    <th>Lớp</th>
                                    <th>Khoản thu</th>
                                    <th>Số tiền</th>
                                    <th>Hạn thanh toán</th>
                                    <th>Trạng thái</th>
                                    <th>Ngày tạo</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($payments as $payment)
                                    <tr>
                                        <td>{{ $payment->id }}</td>
                                        <td>
                                            @if($payment->student)
                                                <strong>{{ $payment->student->ho_va_ten }}</strong>
                                                <br>
                                                <small class="text-muted">{{ $payment->student->ma_hoc_sinh }}</small>
                                            @else
                                                <span class="text-muted">Không xác định</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($payment->student)
                                                <span class="badge bg-secondary">{{ $payment->student->lop }}</span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <strong>{{ $payment->title ?? 'Không có tiêu đề' }}</strong>
                                            @if($payment->description)
                                                <br>
                                                <small class="text-muted">{{ Str::limit($payment->description, 50) }}</small>
                                            @endif
                                        </td>
                                        <td class="fw-bold text-primary">
                                            {{ number_format($payment->amount) }} VNĐ
                                        </td>
                                        <td>
                                            {{ $payment->due_date ? $payment->due_date->format('d/m/Y') : '-' }}
                                            @if($payment->due_date && $payment->due_date->isPast() && $payment->status == 'PENDING')
                                                <br><span class="badge bg-danger">Quá hạn</span>
                                            @elseif($payment->due_date && $payment->due_date->diffInDays() <= 7 && $payment->status == 'PENDING')
                                                <br><span class="badge bg-warning">Sắp hết hạn</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge 
                                                @if($payment->status == 'COMPLETED') bg-success
                                                @elseif($payment->status == 'PENDING') bg-warning
                                                @elseif($payment->status == 'FAILED') bg-danger
                                                @else bg-secondary
                                                @endif">
                                                @if($payment->status == 'COMPLETED') Đã thanh toán
                                                @elseif($payment->status == 'PENDING') Chưa thanh toán
                                                @elseif($payment->status == 'FAILED') Thất bại
                                                @else {{ $payment->status }}
                                                @endif
                                            </span>
                                        </td>
                                        <td>{{ $payment->created_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.payments.show', $payment->id) }}" 
                                                   class="btn btn-info btn-sm" title="Xem chi tiết">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                
                                                @if($payment->status == 'PENDING')
                                                    <form action="{{ route('admin.payments.update-status', $payment->id) }}" 
                                                          method="POST" style="display: inline;">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="status" value="COMPLETED">
                                                        <button type="submit" class="btn btn-success btn-sm" 
                                                                title="Đánh dấu đã thanh toán"
                                                                onclick="return confirm('Xác nhận đã thanh toán?')">
                                                            <i class="fas fa-check"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                                
                                                <form action="{{ route('admin.payments.destroy', $payment->id) }}" 
                                                      method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" 
                                                            title="Xóa"
                                                            onclick="return confirm('Bạn có chắc muốn xóa khoản thu này?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">Chưa có khoản thu nào</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center">
                        {{ $payments->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection