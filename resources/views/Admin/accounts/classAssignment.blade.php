@extends('admin.pageAdmin')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/class-assignment.css') }}">
@endpush

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="main-content">
            <div class="header">
                <h1><i class="fas fa-chalkboard-teacher"></i> Phân Công Giảng Dạy</h1>
                <div class="breadcrumb">
                    <span>Admin</span> > <span>Phân công giảng dạy</span>
                </div>
            </div>

            <div class="content-wrapper">
                @if (session('success'))
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i>
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-error">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ session('error') }}
                    </div>
                @endif

                @if (session('info'))
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        {{ session('info') }}
                    </div>
                @endif

                <!-- Filter Section -->
                <div class="filter-section">
                    <div class="filter-card">
                        <h3><i class="fas fa-filter"></i> Bộ lọc</h3>
                        <form method="GET" action="{{ route('admin.class.assignment') }}">
                            <div class="filter-row">
                                <div class="filter-group">
                                    <label for="nam_hoc">Năm học:</label>
                                    <select name="nam_hoc" id="nam_hoc">
                                        <option value="2024-2025" {{ $academicYear == '2024-2025' ? 'selected' : '' }}>2024-2025</option>
                                        <option value="2025-2026" {{ $academicYear == '2025-2026' ? 'selected' : '' }}>2025-2026</option>
                                        <option value="2026-2027" {{ $academicYear == '2026-2027' ? 'selected' : '' }}>2026-2027</option>
                                    </select>
                                </div>
                                <div class="filter-group">
                                    <label for="lop">Lớp:</label>
                                    <select name="lop" id="lop">
                                        <option value="">Tất cả lớp</option>
                                        @foreach ($classes as $class)
                                            <option value="{{ $class }}" {{ $selectedClass == $class ? 'selected' : '' }}>
                                                {{ $class }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="filter-group">
                                    <label for="mon_hoc">Môn học:</label>
                                    <select name="mon_hoc" id="mon_hoc">
                                        <option value="">Tất cả môn</option>
                                        @foreach ($subjects as $subject)
                                            <option value="{{ $subject }}" {{ $selectedSubject == $subject ? 'selected' : '' }}>
                                                {{ $subject }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="filter-group">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-search"></i> Lọc
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Integration Info -->
                <div class="integration-info">
                    <div class="info-card">
                        <div class="info-header">
                            <i class="fas fa-info-circle"></i>
                            <h4>Tích hợp Thời khóa biểu & Phân công</h4>
                        </div>
                        <div class="info-content">
                            <p><strong>Tự động tạo phân công:</strong> Khi tạo thời khóa biểu, hệ thống sẽ tự động tạo phân công giảng dạy cho giáo viên.</p>
                            <p><strong>Nhập điểm:</strong> Giáo viên được phân công có thể nhập điểm cho học sinh của lớp được giao.</p>
                            <p><strong>Cột TKB:</strong> Hiển thị số tiết trong thời khóa biểu cho mỗi phân công.</p>
                        </div>
                        <div class="info-actions">
                            <a href="{{ route('admin.timetable.create-weekly') }}" class="btn btn-primary">
                                <i class="fas fa-calendar-plus"></i> Tạo thời khóa biểu
                            </a>
                            <a href="{{ route('admin.integration.guide') }}" class="btn btn-outline">
                                <i class="fas fa-book"></i> Hướng dẫn chi tiết
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="action-section">
                    <div class="action-buttons">
                        <button class="btn btn-success" onclick="openAddModal()">
                            <i class="fas fa-plus"></i> Thêm phân công
                        </button>
                        <button class="btn btn-info" onclick="openBulkModal()">
                            <i class="fas fa-upload"></i> Phân công hàng loạt
                        </button>
                        <button class="btn btn-secondary" onclick="exportTemplate()">
                            <i class="fas fa-download"></i> Tải template
                        </button>
                        <button class="btn btn-warning" onclick="viewStatistics()">
                            <i class="fas fa-chart-bar"></i> Thống kê
                        </button>
                    </div>
                </div>

                <!-- Assignments Table -->
                <div class="table-container">
                    <div class="table-header">
                        <h3><i class="fas fa-table"></i> Danh sách phân công ({{ $assignments->count() }} bản ghi)</h3>
                    </div>

                    @if ($assignments->count() > 0)
                        <div class="table-responsive">
                            <table class="data-table">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Năm học</th>
                                        <th>Lớp</th>
                                        <th>Môn học</th>
                                        <th>Giáo viên</th>
                                        <th>Mã GV</th>
                                        <th>Chuyên môn</th>
                                        <th>TKB</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($assignments as $index => $assignment)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $assignment->nam_hoc }}</td>
                                            <td>
                                                <span class="class-badge">{{ $assignment->display_class }}</span>
                                            </td>
                                            <td>
                                                <span class="subject-badge">{{ $assignment->mon_hoc }}</span>
                                            </td>
                                            <td>
                                                <strong>{{ $assignment->teacher->ho_ten ?? 'N/A' }}</strong>
                                            </td>
                                            <td>{{ $assignment->ma_giao_vien }}</td>
                                            <td>{{ $assignment->teacher->mon_day ?? 'N/A' }}</td>
                                            <td>
                                                @if($assignment->timetable_count > 0)
                                                    <span class="timetable-badge">{{ $assignment->timetable_count }} tiết</span>
                                                @else
                                                    <span class="no-timetable">Chưa có TKB</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="action-buttons">
                                                    <button class="btn btn-sm btn-primary" 
                                                            onclick="editAssignment({{ $assignment->id }}, '{{ $assignment->ma_giao_vien }}', '{{ $assignment->khoi }}', '{{ $assignment->lop }}', '{{ $assignment->mon_hoc }}', '{{ $assignment->nam_hoc }}')"
                                                            title="Chỉnh sửa">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger" 
                                                            onclick="deleteAssignment({{ $assignment->id }})"
                                                            title="Xóa">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="no-data">
                            <i class="fas fa-inbox"></i>
                            <h3>Chưa có phân công nào</h3>
                            <p>Hãy thêm phân công giảng dạy cho năm học {{ $academicYear }}</p>
                        </div>
                    @endif
                </div>
            </div>
    </div>
</div>

<!-- Add/Edit Modal -->
    <div id="assignmentModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="modalTitle">Thêm phân công giảng dạy</h3>
                <span class="close" onclick="closeModal()">&times;</span>
            </div>
            <form id="assignmentForm" method="POST">
                @csrf
                <input type="hidden" id="assignmentId" name="assignment_id">
                <input type="hidden" id="formMethod" name="_method" value="POST">

                <div class="form-group">
                    <label for="form_nam_hoc">Năm học:</label>
                    <select name="nam_hoc" id="form_nam_hoc" required>
                        <option value="2024-2025">2024-2025</option>
                        <option value="2025-2026">2025-2026</option>
                        <option value="2026-2027">2026-2027</option>
                    </select>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="form_khoi">Khối:</label>
                        <select name="khoi" id="form_khoi" required onchange="updateClassOptions()">
                            <option value="">Chọn khối</option>
                            <option value="6">Khối 6</option>
                            <option value="7">Khối 7</option>
                            <option value="8">Khối 8</option>
                            <option value="9">Khối 9</option>
                            <option value="10">Khối 10</option>
                            <option value="11">Khối 11</option>
                            <option value="12">Khối 12</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="form_lop">Lớp:</label>
                        <select name="lop" id="form_lop" required>
                            <option value="">Chọn lớp</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="form_mon_hoc">Môn học:</label>
                    <select name="mon_hoc" id="form_mon_hoc" required onchange="loadTeachersBySubject()">
                        <option value="">Chọn môn học</option>
                        @foreach ($subjects as $subject)
                            <option value="{{ $subject }}">{{ $subject }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="form_ma_giao_vien">Giáo viên:</label>
                    <select name="ma_giao_vien" id="form_ma_giao_vien" required>
                        <option value="">Chọn giáo viên</option>
                        @if (isset($teachers) && $teachers->count() > 0)
                            @foreach ($teachers as $teacher)
                                <option value="{{ $teacher->ma_giao_vien }}" data-subject="{{ $teacher->mon_day }}">
                                    {{ $teacher->ho_ten }} ({{ $teacher->ma_giao_vien }}) - {{ $teacher->mon_day }}
                                </option>
                            @endforeach
                        @else
                            <option value="">Không có giáo viên nào</option>
                        @endif
                    </select>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" onclick="closeModal()">Hủy</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Lưu
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Statistics Modal -->
    <div id="statisticsModal" class="modal">
        <div class="modal-content large">
            <div class="modal-header">
                <h3>Thống kê phân công giảng dạy</h3>
                <span class="close" onclick="closeStatisticsModal()">&times;</span>
            </div>
            <div id="statisticsContent">
                <div class="loading">
                    <i class="fas fa-spinner fa-spin"></i> Đang tải dữ liệu...
                </div>
            </div>
        </div>
    </div>

<script>
        // Set active navigation item
        document.addEventListener('DOMContentLoaded', function() {
            // Remove active class from all nav items
            const navItems = document.querySelectorAll('.sidebar ul li');
            navItems.forEach(item => item.classList.remove('active'));
            
            // Add active class to class assignment nav item
            const classAssignmentNav = document.querySelector('a[href="{{ route('admin.class.assignment') }}"]');
            if (classAssignmentNav) {
                classAssignmentNav.parentElement.classList.add('active');
            }
        });

        // JavaScript functions
        function openAddModal() {
            document.getElementById('modalTitle').textContent = 'Thêm phân công giảng dạy';
            document.getElementById('assignmentForm').action = '{{ route('admin.class.assignment.store') }}';
            document.getElementById('formMethod').value = 'POST';
            document.getElementById('assignmentId').value = '';

            // Reset form
            document.getElementById('assignmentForm').reset();
            document.getElementById('form_nam_hoc').value = '{{ $academicYear }}';

            document.getElementById('assignmentModal').style.display = 'block';
        }

        function editAssignment(id, teacherId, khoi, lop, subject, year) {
            document.getElementById('modalTitle').textContent = 'Chỉnh sửa phân công';
            document.getElementById('assignmentForm').action = `/admin/class-assignment/${id}`;
            document.getElementById('formMethod').value = 'PUT';
            document.getElementById('assignmentId').value = id;

            // Fill form data
            document.getElementById('form_ma_giao_vien').value = teacherId;
            document.getElementById('form_khoi').value = khoi;
            document.getElementById('form_lop').value = lop;
            document.getElementById('form_mon_hoc').value = subject;
            document.getElementById('form_nam_hoc').value = year;

            updateClassOptions();

            document.getElementById('assignmentModal').style.display = 'block';
        }

        function deleteAssignment(id) {
            if (confirm('Bạn có chắc chắn muốn xóa phân công này?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/admin/class-assignment/${id}`;

                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'DELETE';

                form.appendChild(csrfToken);
                form.appendChild(methodInput);
                document.body.appendChild(form);
                form.submit();
            }
        }

        function closeModal() {
            document.getElementById('assignmentModal').style.display = 'none';
        }

        function updateClassOptions() {
            const khoi = document.getElementById('form_khoi').value;
            const lopSelect = document.getElementById('form_lop');

            lopSelect.innerHTML = '<option value="">Chọn lớp</option>';

            if (khoi) {
                const classes = ['A1', 'A2', 'A3', 'A4', 'A5'];
                classes.forEach(className => {
                    const option = document.createElement('option');
                    option.value = className;
                    option.textContent = `${khoi}${className}`;
                    lopSelect.appendChild(option);
                });
            }
        }

        function loadTeachersBySubject() {
            const subject = document.getElementById('form_mon_hoc').value;
            const teacherSelect = document.getElementById('form_ma_giao_vien');

            if (subject) {
                // Filter teachers by subject
                const options = teacherSelect.querySelectorAll('option');
                options.forEach(option => {
                    if (option.value === '') return;

                    const teacherSubject = option.dataset.subject || '';
                    if (teacherSubject.includes(subject)) {
                        option.style.display = 'block';
                    } else {
                        option.style.display = 'none';
                    }
                });
            } else {
                // Show all teachers
                const options = teacherSelect.querySelectorAll('option');
                options.forEach(option => {
                    option.style.display = 'block';
                });
            }
        }

        function openBulkModal() {
            alert('Chức năng phân công hàng loạt đang được phát triển');
        }

        function exportTemplate() {
            window.location.href = '{{ route('admin.class.assignment.export') }}';
        }

        function viewStatistics() {
            document.getElementById('statisticsModal').style.display = 'block';
            loadStatistics();
        }

        function closeStatisticsModal() {
            document.getElementById('statisticsModal').style.display = 'none';
        }

        function loadStatistics() {
            const year = '{{ $academicYear }}';
            fetch(`/admin/class-assignment/statistics/${year}`)
                .then(response => response.json())
                .then(data => {
                    let html = '<div class="statistics-grid">';

                    data.forEach(stat => {
                        const syncIcon = stat.sync_status === 'synced' ? 
                            '<i class="fas fa-check-circle" style="color: #28a745;"></i>' : 
                            '<i class="fas fa-exclamation-triangle" style="color: #ffc107;"></i>';
                        
                        html += `
                            <div class="stat-card">
                                <h4>Lớp ${stat.khoi}${stat.lop} ${syncIcon}</h4>
                                <div class="stat-numbers">
                                    <div class="stat-item">
                                        <span class="number">${stat.total_subjects}</span>
                                        <span class="label">Môn phân công</span>
                                    </div>
                                    <div class="stat-item">
                                        <span class="number">${stat.total_teachers}</span>
                                        <span class="label">Giáo viên</span>
                                    </div>
                                    <div class="stat-item">
                                        <span class="number">${stat.timetable_periods || 0}</span>
                                        <span class="label">Tiết TKB</span>
                                    </div>
                                    <div class="stat-item">
                                        <span class="number">${stat.timetable_subjects || 0}</span>
                                        <span class="label">Môn TKB</span>
                                    </div>
                                </div>
                                <div class="sync-status">
                                    ${stat.sync_status === 'synced' ? 
                                        '<span class="sync-ok">Đồng bộ</span>' : 
                                        '<span class="sync-warning">Chưa đồng bộ</span>'
                                    }
                                </div>
                            </div>
                        `;
                    });

                    html += '</div>';
                    document.getElementById('statisticsContent').innerHTML = html;
                })
                .catch(error => {
                    document.getElementById('statisticsContent').innerHTML =
                        '<div class="error">Có lỗi xảy ra khi tải dữ liệu thống kê</div>';
                });
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            const assignmentModal = document.getElementById('assignmentModal');
            const statisticsModal = document.getElementById('statisticsModal');

            if (event.target === assignmentModal) {
                assignmentModal.style.display = 'none';
            }
            if (event.target === statisticsModal) {
                statisticsModal.style.display = 'none';
            }
        }

    </script>
@endsection