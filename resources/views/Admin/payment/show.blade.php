@extends('Admin.pageAdmin')

@section('title', 'Chi tiết thanh toán')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Chi tiết thanh toán #{{ $payment->id }}</h3>
                    <a href="{{ route('admin.payments.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Quay lại
                    </a>
                </div>
                
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="30%">ID thanh toán:</th>
                                    <td>{{ $payment->id }}</td>
                                </tr>
                                <tr>
                                    <th>Mã đơn hàng:</th>
                                    <td>{{ $payment->order_id }}</td>
                                </tr>
                                <tr>
                                    <th>Số tiền:</th>
                                    <td class="fw-bold text-primary">{{ number_format($payment->amount) }} VNĐ</td>
                                </tr>
                                <tr>
                                    <th>Trạng thái:</th>
                                    <td>
                                        <span class="badge fs-6
                                            @if($payment->status == 'COMPLETED') bg-success
                                            @elseif($payment->status == 'PENDING') bg-warning
                                            @elseif($payment->status == 'FAILED') bg-danger
                                            @else bg-secondary
                                            @endif">
                                            {{ $payment->status }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Ngày tạo:</th>
                                    <td>{{ $payment->created_at->format('d/m/Y H:i:s') }}</td>
                                </tr>
                                <tr>
                                    <th>Cập nhật lần cuối:</th>
                                    <td>{{ $payment->updated_at->format('d/m/Y H:i:s') }}</td>
                                </tr>
                            </table>
                        </div>
                        
                        <div class="col-md-6">
                            <h5>Thao tác</h5>
                            
                            @if($payment->status == 'PENDING')
                                <div class="mb-3">
                                    <form action="{{ route('admin.payments.update-status', $payment->id) }}" 
                                          method="POST" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="COMPLETED">
                                        <button type="submit" class="btn btn-success"
                                                onclick="return confirm('Xác nhận thanh toán đã hoàn thành?')">
                                            <i class="fas fa-check"></i> Đánh dấu hoàn thành
                                        </button>
                                    </form>
                                </div>
                                
                                <div class="mb-3">
                                    <form action="{{ route('admin.payments.update-status', $payment->id) }}" 
                                          method="POST" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="FAILED">
                                        <button type="submit" class="btn btn-danger"
                                                onclick="return confirm('Đánh dấu thanh toán thất bại?')">
                                            <i class="fas fa-times"></i> Đánh dấu thất bại
                                        </button>
                                    </form>
                                </div>
                                
                                <div class="mb-3">
                                    <form action="{{ route('admin.payments.update-status', $payment->id) }}" 
                                          method="POST" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="CANCELLED">
                                        <button type="submit" class="btn btn-warning"
                                                onclick="return confirm('Hủy thanh toán này?')">
                                            <i class="fas fa-ban"></i> Hủy thanh toán
                                        </button>
                                    </form>
                                </div>
                            @endif
                            
                            <div class="mb-3">
                                <form action="{{ route('admin.payments.destroy', $payment->id) }}" 
                                      method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger"
                                            onclick="return confirm('Bạn có chắc muốn xóa thanh toán này? Hành động này không thể hoàn tác!')">
                                        <i class="fas fa-trash"></i> Xóa thanh toán
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection