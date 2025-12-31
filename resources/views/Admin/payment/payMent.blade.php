@extends('Admin.pageAdmin')

@section('title', 'Tạo thanh toán')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tạo mã QR thanh toán nhanh</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.payments.create') }}" class="btn btn-success btn-sm">
                            <i class="fas fa-plus"></i> Tạo khoản thu chi tiết
                        </a>
                    </div>
                </div>
                
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <form id="paymentForm">
                                @csrf
                                <div class="alert alert-success">
                                    <i class="fas fa-magic"></i>
                                    <strong>Tạo nhanh:</strong> Nhập thông tin cơ bản để tự động tạo khoản thu và QR code ngay lập tức.
                                </div>

                                <div class="mb-3">
                                    <label for="title" class="form-label">Tên khoản thu <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="title" name="title" 
                                           placeholder="VD: Học phí học kỳ I, Phí hoạt động ngoại khóa..." required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="amount" class="form-label">Số tiền (VNĐ) <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="amount" name="amount" 
                                           placeholder="Nhập số tiền (tối thiểu 1,000 VNĐ)" min="1000" required>
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label">Mô tả</label>
                                    <textarea class="form-control" id="description" name="description" rows="3" 
                                              placeholder="Mô tả chi tiết về khoản thu..."></textarea>
                                </div>
                                
                                <button type="button" class="btn btn-primary btn-lg" onclick="taoQR()">
                                    <i class="fas fa-magic"></i> Tạo khoản thu & QR Code
                                </button>
                            </form>
                        </div>
                        
                        <div class="col-md-6">
                            <div id="qrResult" style="display: none;">
                                <h5>Mã QR thanh toán:</h5>
                                <div class="text-center">
                                    <img id="qr" class="img-fluid" style="max-width: 300px; border: 1px solid #ddd; padding: 10px;">
                                </div>
                                <div class="mt-3">
                                    <table class="table table-borderless table-sm">
                                        <tr>
                                            <td><strong>Khoản thu:</strong></td>
                                            <td id="displayTitle">-</td>
                                        </tr>
                                        <tr>
                                            <td><strong>ID thanh toán:</strong></td>
                                            <td id="paymentId">-</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Mã đơn hàng:</strong></td>
                                            <td id="orderId">-</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Số tiền:</strong></td>
                                            <td id="displayAmount">-</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Trạng thái:</strong></td>
                                            <td><span class="badge bg-warning">PENDING</span></td>
                                        </tr>
                                    </table>
                                    <a href="{{ route('admin.payments.index') }}" class="btn btn-success">
                                        <i class="fas fa-list"></i> Xem danh sách thanh toán
                                    </a>
                                </div>
                            </div>

                            <!-- Thông tin -->
                            <div class="card bg-light">
                                <div class="card-header">
                                    <h6 class="mb-0"><i class="fas fa-info-circle"></i> Thông tin</h6>
                                </div>
                                <div class="card-body">
                                    <ul class="mb-0">
                                        <li>Khoản thu sẽ được tự động tạo với trạng thái <strong>PENDING</strong></li>
                                        <li>Hạn thanh toán mặc định: <strong>30 ngày</strong> từ ngày tạo</li>
                                        <li>Mã đơn hàng và ID sẽ được tự động sinh</li>
                                        <li>Khoản thu sẽ xuất hiện trong danh sách quản lý</li>
                                        <li>QR code có thể được chia sẻ cho học sinh thanh toán</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function taoQR() {
    const title = document.getElementById('title').value;
    const amount = document.getElementById('amount').value;
    const description = document.getElementById('description').value;
    
    if (!title || !amount) {
        alert('Vui lòng nhập tên khoản thu và số tiền!');
        return;
    }
    
    if (amount < 1000) {
        alert('Số tiền phải tối thiểu 1,000 VNĐ!');
        return;
    }
    
    // Hiển thị loading
    const button = document.querySelector('button[onclick="taoQR()"]');
    const originalText = button.innerHTML;
    button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang tạo...';
    button.disabled = true;
    
    const requestData = {
        title: title,
        amount: parseInt(amount),
        description: description || 'Thanh toán được tạo từ QR Generator',
        payment_type: 'other'
    };
    
    fetch('/api/payments/qr', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify(requestData)
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
            document.getElementById('qr').src = data.qr;
            document.getElementById('paymentId').textContent = data.payment_id;
            document.getElementById('orderId').textContent = data.order_id;
            document.getElementById('displayTitle').textContent = title;
            document.getElementById('displayAmount').textContent = new Intl.NumberFormat('vi-VN').format(amount) + ' VNĐ';
            document.getElementById('qrResult').style.display = 'block';
            
            // Scroll to result
            document.getElementById('qrResult').scrollIntoView({ behavior: 'smooth' });
            
            // Show success message
            alert('Tạo khoản thu và QR code thành công!');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Có lỗi xảy ra: ' + error.message);
    })
    .finally(() => {
        // Restore button
        button.innerHTML = originalText;
        button.disabled = false;
    });
}

// Auto-format amount input
document.getElementById('amount').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    if (value) {
        e.target.value = value;
    }
});
</script>
@endsection
