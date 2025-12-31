@extends('Student.PageStudent')

@section('title', 'Thanh toán học phí')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-credit-card"></i> Thanh toán học phí
                    </h3>
                </div>
                
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle"></i>
                                <strong>Thông tin học sinh:</strong> {{ $student->ho_va_ten }} - Lớp {{ $student->lop }}
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th>STT</th>
                                    <th>Khoản thu</th>
                                    <th>Số tiền</th>
                                    <th>Hạn thanh toán</th>
                                    <th>Trạng thái</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($payments as $index => $payment)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <strong>{{ $payment['title'] }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $payment['description'] }}</small>
                                        </td>
                                        <td class="fw-bold text-primary">
                                            {{ number_format($payment['amount']) }} VNĐ
                                        </td>
                                        <td>
                                            {{ \Carbon\Carbon::parse($payment['due_date'])->format('d/m/Y') }}
                                            @if($payment['status'] == 'pending' && \Carbon\Carbon::parse($payment['due_date'])->isPast())
                                                <br><span class="badge bg-danger">Quá hạn</span>
                                            @elseif($payment['status'] == 'pending' && \Carbon\Carbon::parse($payment['due_date'])->diffInDays() <= 7)
                                                <br><span class="badge bg-warning">Sắp hết hạn</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($payment['status'] == 'completed')
                                                <span class="badge bg-success">Đã thanh toán</span>
                                            @elseif($payment['status'] == 'pending')
                                                <span class="badge bg-warning">Chưa thanh toán</span>
                                            @else
                                                <span class="badge bg-secondary">{{ $payment['status'] }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($payment['status'] == 'pending')
                                                <button type="button" class="btn btn-primary btn-sm" 
                                                        onclick="createPayment({{ $payment['id'] }}, {{ $payment['amount'] }}, '{{ $payment['title'] }}')">
                                                    <i class="fas fa-qrcode"></i> Thanh toán
                                                </button>
                                            @elseif($payment['status'] == 'completed')
                                                <button type="button" class="btn btn-success btn-sm" disabled>
                                                    <i class="fas fa-check"></i> Đã thanh toán
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Không có khoản thu nào</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Tổng kết -->
                    @php
                        $totalPending = collect($payments)->where('status', 'pending')->sum('amount');
                        $totalCompleted = collect($payments)->where('status', 'completed')->sum('amount');
                    @endphp
                    
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="card bg-warning text-white">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <i class="fas fa-clock"></i> Chưa thanh toán
                                    </h5>
                                    <h3>{{ number_format($totalPending) }} VNĐ</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-success text-white">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <i class="fas fa-check-circle"></i> Đã thanh toán
                                    </h5>
                                    <h3>{{ number_format($totalCompleted) }} VNĐ</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal thanh toán -->
<div class="modal fade" id="paymentModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-qrcode"></i> Thanh toán QR Code
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Thông tin thanh toán:</h6>
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>Học sinh:</strong></td>
                                <td>{{ $student->ho_va_ten }}</td>
                            </tr>
                            <tr>
                                <td><strong>Lớp:</strong></td>
                                <td>{{ $student->lop }}</td>
                            </tr>
                            <tr>
                                <td><strong>Khoản thu:</strong></td>
                                <td id="paymentTitle"></td>
                            </tr>
                            <tr>
                                <td><strong>Số tiền:</strong></td>
                                <td id="paymentAmount" class="fw-bold text-primary"></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <div id="qrResult" style="display: none;">
                            <h6>Mã QR thanh toán:</h6>
                            <div class="text-center">
                                <img id="qrImage" class="img-fluid" style="max-width: 250px; border: 1px solid #ddd; padding: 10px;">
                            </div>
                            <div class="mt-2 text-center">
                                <small class="text-muted">Quét mã QR để thanh toán</small>
                            </div>
                        </div>
                        <div id="loadingQR" style="display: none;" class="text-center">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Đang tạo mã QR...</span>
                            </div>
                            <p class="mt-2">Đang tạo mã QR...</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-primary" id="generateQRBtn" onclick="generateQR()">
                    <i class="fas fa-qrcode"></i> Tạo mã QR
                </button>
            </div>
        </div>
    </div>
</div>

<script>
let currentPayment = null;

function createPayment(paymentId, amount, title) {
    currentPayment = {
        id: paymentId,
        amount: amount,
        title: title
    };
    
    document.getElementById('paymentTitle').textContent = title;
    document.getElementById('paymentAmount').textContent = new Intl.NumberFormat('vi-VN').format(amount) + ' VNĐ';
    
    // Reset modal
    document.getElementById('qrResult').style.display = 'none';
    document.getElementById('loadingQR').style.display = 'none';
    document.getElementById('generateQRBtn').style.display = 'block';
    
    // Show modal
    new bootstrap.Modal(document.getElementById('paymentModal')).show();
}

function generateQR() {
    if (!currentPayment) return;
    
    // Show loading
    document.getElementById('loadingQR').style.display = 'block';
    document.getElementById('generateQRBtn').style.display = 'none';
    
    fetch('/api/payments/qr', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            order_id: currentPayment.id,
            amount: currentPayment.amount
        })
    })
    .then(async res => {
        const data = await res.json();
        if (!res.ok) {
            throw new Error(data.error || `HTTP ${res.status}: ${res.statusText}`);
        }
        return data;
    })
    .then(data => {
        if (data.error) {
            throw new Error(data.error);
        } else {
            document.getElementById('qrImage').src = data.qr;
            document.getElementById('qrResult').style.display = 'block';
            document.getElementById('loadingQR').style.display = 'none';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Có lỗi xảy ra: ' + error.message);
        document.getElementById('loadingQR').style.display = 'none';
        document.getElementById('generateQRBtn').style.display = 'block';
    });
}
</script>
@endsection