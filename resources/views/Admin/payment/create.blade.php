@extends('Admin.pageAdmin')

@section('title', 'Tạo khoản thu mới')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-plus"></i> Tạo khoản thu mới
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.payments.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Quay lại
                        </a>
                    </div>
                </div>
                
                <form action="{{ route('admin.payments.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="title" class="form-label">Tên khoản thu <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="title" name="title" 
                                           value="{{ old('title') }}" required
                                           placeholder="VD: Học phí học kỳ I">
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="amount" class="form-label">Số tiền (VNĐ) <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="amount" name="amount" 
                                           value="{{ old('amount') }}" required min="0"
                                           placeholder="VD: 2500000">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="due_date" class="form-label">Hạn thanh toán <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="due_date" name="due_date" 
                                           value="{{ old('due_date') }}" required>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="payment_type" class="form-label">Loại khoản thu <span class="text-danger">*</span></label>
                                    <select class="form-control" id="payment_type" name="payment_type" required>
                                        <option value="">-- Chọn loại khoản thu --</option>
                                        <option value="tuition" {{ old('payment_type') == 'tuition' ? 'selected' : '' }}>Học phí</option>
                                        <option value="activity" {{ old('payment_type') == 'activity' ? 'selected' : '' }}>Hoạt động ngoại khóa</option>
                                        <option value="uniform" {{ old('payment_type') == 'uniform' ? 'selected' : '' }}>Đồng phục</option>
                                        <option value="book" {{ old('payment_type') == 'book' ? 'selected' : '' }}>Sách giáo khoa</option>
                                        <option value="insurance" {{ old('payment_type') == 'insurance' ? 'selected' : '' }}>Bảo hiểm</option>
                                        <option value="other" {{ old('payment_type') == 'other' ? 'selected' : '' }}>Khác</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="description" class="form-label">Mô tả</label>
                            <textarea class="form-control" id="description" name="description" rows="3"
                                      placeholder="Mô tả chi tiết về khoản thu...">{{ old('description') }}</textarea>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="apply_to" class="form-label">Áp dụng cho <span class="text-danger">*</span></label>
                                    <select class="form-control" id="apply_to" name="apply_to" required onchange="toggleClassFilter()">
                                        <option value="">-- Chọn đối tượng áp dụng --</option>
                                        <option value="all_students" {{ old('apply_to') == 'all_students' ? 'selected' : '' }}>Tất cả học sinh</option>
                                        <option value="specific_class" {{ old('apply_to') == 'specific_class' ? 'selected' : '' }}>Lớp cụ thể</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group mb-3" id="class_filter_group" style="display: none;">
                                    <label for="class_filter" class="form-label">Chọn lớp</label>
                                    <select class="form-control" id="class_filter" name="class_filter">
                                        <option value="">-- Chọn lớp --</option>
                                        @foreach($classes as $class)
                                            <option value="{{ $class }}" {{ old('class_filter') == $class ? 'selected' : '' }}>
                                                {{ $class }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            <strong>Lưu ý:</strong> 
                            <ul class="mb-0 mt-2">
                                <li>Khi chọn "Tất cả học sinh", khoản thu sẽ được tạo cho tất cả {{ \App\Models\Student::count() }} học sinh trong hệ thống</li>
                                <li>Khi chọn "Lớp cụ thể", khoản thu chỉ áp dụng cho học sinh của lớp được chọn</li>
                                <li>Mỗi học sinh sẽ có một bản ghi thanh toán riêng biệt</li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Tạo khoản thu
                        </button>
                        <a href="{{ route('admin.payments.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Hủy
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function toggleClassFilter() {
    const applyTo = document.getElementById('apply_to').value;
    const classFilterGroup = document.getElementById('class_filter_group');
    const classFilter = document.getElementById('class_filter');
    
    if (applyTo === 'specific_class') {
        classFilterGroup.style.display = 'block';
        classFilter.required = true;
    } else {
        classFilterGroup.style.display = 'none';
        classFilter.required = false;
        classFilter.value = '';
    }
}

// Khởi tạo khi trang load
document.addEventListener('DOMContentLoaded', function() {
    toggleClassFilter();
});
</script>
@endsection