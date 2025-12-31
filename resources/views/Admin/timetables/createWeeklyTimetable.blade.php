@extends('Admin.pageAdmin')

@section('content')
<div class="weekly-container">
    <div class="form-header">
        <h1>📅 Tạo thời khóa biểu theo tuần</h1>
        <p>Chọn lớp và tạo thời khóa biểu cho cả tuần một lúc</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <!-- Chọn lớp và thông tin cơ bản -->
    <div class="class-selection">
        <h3>🏫 Thông tin cơ bản</h3>
        <div class="selection-grid">
            <div class="form-group">
                <label for="selected_lop">Lớp học *</label>
                <select id="selected_lop" class="form-control" onchange="loadTimetableEditor()">
                    <option value="">Chọn lớp</option>
                    @foreach($classes as $class)
                        <option value="{{ $class->lop }}" data-khoi="{{ $class->khoi }}">
                            {{ $class->lop }} (Khối {{ $class->khoi }})
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="form-group">
                <label for="selected_nam_hoc">Năm học *</label>
                <select id="selected_nam_hoc" class="form-control">
                    <option value="2024-2025">2024-2025</option>
                    <option value="2025-2026">2025-2026</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="selected_hoc_ky">Học kỳ *</label>
                <select id="selected_hoc_ky" class="form-control">
                    <option value="1">Học kỳ 1</option>
                    <option value="2">Học kỳ 2</option>
                </select>
            </div>
            
            <div class="form-group">
                <button type="button" class="btn btn-primary" onclick="loadTimetableEditor()">
                    📋 Tạo bảng thời khóa biểu
                </button>
            </div>
        </div>
    </div>

    <!-- Bảng chỉnh sửa thời khóa biểu -->
    <div id="timetableEditor" class="timetable-editor">
        <div class="editor-header">
            <h3 id="editorTitle">📝 Chỉnh sửa thời khóa biểu</h3>
            <p>Chọn môn học, giáo viên và phòng học cho từng tiết. Để trống nếu không có tiết học.</p>
        </div>
        
        <table class="timetable-table">
            <thead>
                <tr>
                    <th class="time-header">Tiết / Thứ</th>
                    <th class="day-header">Thứ Hai<br><small style="font-size: 10px;">(thu=2)</small></th>
                    <th class="day-header">Thứ Ba<br><small style="font-size: 10px;">(thu=3)</small></th>
                    <th class="day-header">Thứ Tư<br><small style="font-size: 10px;">(thu=4)</small></th>
                    <th class="day-header">Thứ Năm<br><small style="font-size: 10px;">(thu=5)</small></th>
                    <th class="day-header">Thứ Sáu<br><small style="font-size: 10px;">(thu=6)</small></th>
                    <th class="day-header">Thứ Bảy<br><small style="font-size: 10px;">(thu=7)</small></th>
                </tr>
            </thead>
            <tbody id="timetableBody">
                <!-- Sẽ được tạo bằng JavaScript -->
            </tbody>
        </table>
        
        <div class="save-section">
            <button type="button" class="btn btn-success" onclick="saveWeeklyTimetable()">
                💾 Lưu thời khóa biểu
            </button>
            <button type="button" class="btn btn-secondary" onclick="clearAllSchedules()">
                🗑️ Xóa tất cả
            </button>
            <button type="button" class="btn btn-secondary" onclick="testFormElements()" style="background: #17a2b8;">
                🔍 Test Form Elements
            </button>
            <button type="button" class="btn btn-secondary" onclick="testSetData()" style="background: #28a745;">
                🧪 Test Set Data
            </button>
            <button type="button" class="btn btn-secondary" onclick="debugCurrentData()" style="background: #dc3545;">
                🔍 Debug Current Data
            </button>
            <button type="button" class="btn btn-secondary" onclick="clearAllData()" style="background: #6c757d;">
                🗑️ Clear All DB Data
            </button>
            <button type="button" class="btn btn-secondary" onclick="testTeacherData()" style="background: #fd7e14;">
                👨‍🏫 Test Teacher Data
            </button>
            <button type="button" class="btn btn-secondary" onclick="fixTeacherNames()" style="background: #20c997;">
                🔧 Fix Teacher Names
            </button>
            <a href="{{ route('admin.timetable.index') }}" class="btn btn-secondary">
                ↩️ Quay lại
            </a>
        </div>
    </div>
</div>

<script>
// Dữ liệu giáo viên
const teachers = @json($teachers);

// Danh sách môn học từ controller - sử dụng tên đầy đủ
const subjects = [
    'Toán', 'Ngữ văn', 'Tiếng Anh', 'Vật lý', 'Hóa học', 'Sinh học',
    'Lịch sử', 'Địa lý', 'GDCD', 'Tin học', 'Thể dục',
    'Công nghệ', 'Âm nhạc', 'Mỹ thuật', 'Hoạt động trải nghiệm',
    'Giáo dục quốc phòng', 'Giáo dục kinh tế và pháp luật'
];

// Thời gian các tiết học
const times = {
    1: '7:00-7:45', 2: '7:45-8:30', 3: '8:30-9:15',
    4: '9:30-10:15', 5: '10:15-11:00', 6: '13:00-13:45',
    7: '13:45-14:30', 8: '14:30-15:15', 9: '15:30-16:15', 10: '16:15-17:00'
};

function loadTimetableEditor() {
    const lop = document.getElementById('selected_lop').value;
    const namHoc = document.getElementById('selected_nam_hoc').value;
    const hocKy = document.getElementById('selected_hoc_ky').value;
    
    if (!lop) {
        alert('Vui lòng chọn lớp học!');
        return;
    }
    
    // Hiển thị editor
    document.getElementById('timetableEditor').style.display = 'block';
    document.getElementById('editorTitle').textContent = `📝 Thời khóa biểu lớp ${lop} - ${namHoc} - Học kỳ ${hocKy}`;
    
    // Tạo bảng thời khóa biểu
    createTimetableGrid();
    
    // Test form creation
    setTimeout(() => {
        testFormElements();
    }, 100);
    
    // Tải dữ liệu hiện có (nếu có)
    loadExistingSchedules(lop, namHoc, hocKy);
}

function testFormElements() {
    console.log('=== KIỂM TRA FORM ELEMENTS ===');
    
    for (let thu = '2'; thu <= '7'; thu = String(parseInt(thu) + 1)) {
        const dayName = thu === '2' ? 'Thứ Hai' : thu === '3' ? 'Thứ Ba' : thu === '4' ? 'Thứ Tư' : thu === '5' ? 'Thứ Năm' : thu === '6' ? 'Thứ Sáu' : 'Thứ Bảy';
        console.log(`\n--- Kiểm tra ${dayName} (thu=${thu}) ---`);
        
        for (let tiet = 1; tiet <= 3; tiet++) {
            const subjectSelect = document.querySelector(`select.subject-select[data-thu="${thu}"][data-tiet="${tiet}"]`);
            
            if (subjectSelect) {
                const actualThu = subjectSelect.getAttribute('data-thu');
                const actualTiet = subjectSelect.getAttribute('data-tiet');
                console.log(`✓ Tiết ${tiet}: Found elements - data-thu="${actualThu}", data-tiet="${actualTiet}"`);
                
                if (actualThu != thu || actualTiet != tiet) {
                    console.error(`❌ MISMATCH! Expected thu=${thu}, tiet=${tiet} but got thu=${actualThu}, tiet=${actualTiet}`);
                }
            } else {
                console.error(`❌ Không tìm thấy subject select cho thu=${thu}, tiet=${tiet}`);
            }
        }
    }
}

function createTimetableGrid() {
    const tbody = document.getElementById('timetableBody');
    tbody.innerHTML = '';
    
    for (let tiet = 1; tiet <= 10; tiet++) {
        const row = document.createElement('tr');
        
        // Cột thời gian
        const timeCell = document.createElement('td');
        timeCell.className = 'time-header';
        timeCell.innerHTML = `<strong>Tiết ${tiet}</strong><br><small>${times[tiet]}</small>`;
        row.appendChild(timeCell);
        
        // Các cột thứ (2-7) - sử dụng string values
        for (let thu = '2'; thu <= '7'; thu = String(parseInt(thu) + 1)) {
            const cell = document.createElement('td');
            cell.className = 'schedule-cell';
            cell.innerHTML = createScheduleForm(thu, tiet);
            row.appendChild(cell);
        }
        
        tbody.appendChild(row);
    }
}

function createScheduleForm(thu, tiet) {
    // Debug: Log việc tạo form
    console.log(`Creating form for Thu: ${thu}, Tiet: ${tiet}`);
    
    // Thêm debug info để hiển thị thứ nào
    const dayNames = {
        '2': 'T2', '3': 'T3', '4': 'T4', '5': 'T5', '6': 'T6', '7': 'T7'
    };
    
    return `
        <div class="debug-info" style="font-size: 10px; color: #666; margin-bottom: 2px;">
            ${dayNames[thu]} - Tiết ${tiet}
        </div>
        <select class="subject-select" onchange="updateTeachers(this, '${thu}', ${tiet})" data-thu="${thu}" data-tiet="${tiet}">
            <option value="">Chọn môn</option>
            ${subjects.map(subject => `<option value="${subject}">${subject}</option>`).join('')}
        </select>
        
        <select class="teacher-select" data-thu="${thu}" data-tiet="${tiet}">
            <option value="">Chọn GV</option>
        </select>
        
        <input type="text" class="room-input" placeholder="Phòng" data-thu="${thu}" data-tiet="${tiet}">
    `;
}

function updateTeachers(subjectSelect, thu, tiet) {
    const subject = subjectSelect.value;
    const teacherSelect = document.querySelector(`select.teacher-select[data-thu="${thu}"][data-tiet="${tiet}"]`);
    
    // Reset teacher options
    teacherSelect.innerHTML = '<option value="">Chọn GV</option>';
    
    if (subject) {
        // Gọi API để lấy giáo viên theo môn học
        fetch(`/api/teachers/by-subject/${encodeURIComponent(subject)}`)
            .then(response => response.json())
            .then(teacherData => {
                console.log(`Loaded ${teacherData.length} teachers for subject: ${subject}`);
                teacherData.forEach(teacher => {
                    const option = document.createElement('option');
                    option.value = teacher.ma_giao_vien;
                    option.textContent = teacher.ho_ten;
                    option.setAttribute('data-teacher-name', teacher.ho_ten); // Lưu tên giáo viên
                    teacherSelect.appendChild(option);
                    console.log(`Added teacher: ${teacher.ho_ten} (${teacher.ma_giao_vien})`);
                });
            })
            .catch(error => {
                console.error('Error fetching teachers:', error);
            });
    }
}

function loadExistingSchedules(lop, namHoc, hocKy) {
    // Tải dữ liệu thời khóa biểu hiện có
    fetch(`/api/timetable/get-weekly?lop=${lop}&nam_hoc=${namHoc}&hoc_ky=${hocKy}`)
        .then(response => response.json())
        .then(schedules => {
            console.log('Loaded existing schedules:', schedules);
            
            schedules.forEach(schedule => {
                const dayName = schedule.thu === '2' ? 'Thứ Hai' : schedule.thu === '3' ? 'Thứ Ba' : schedule.thu === '4' ? 'Thứ Tư' : schedule.thu === '5' ? 'Thứ Năm' : schedule.thu === '6' ? 'Thứ Sáu' : 'Thứ Bảy';
                console.log(`Loading schedule - Thu: ${schedule.thu} (${dayName}), Tiet: ${schedule.tiet}, Mon: ${schedule.mon_hoc}, Teacher: ${schedule.ten_giao_vien}`);
                
                // Điền dữ liệu vào form
                const subjectSelect = document.querySelector(`select.subject-select[data-thu="${schedule.thu}"][data-tiet="${schedule.tiet}"]`);
                const teacherSelect = document.querySelector(`select.teacher-select[data-thu="${schedule.thu}"][data-tiet="${schedule.tiet}"]`);
                const roomInput = document.querySelector(`input.room-input[data-thu="${schedule.thu}"][data-tiet="${schedule.tiet}"]`);
                
                if (subjectSelect) {
                    subjectSelect.value = schedule.mon_hoc;
                    
                    // Load teachers for this subject first
                    updateTeachers(subjectSelect, schedule.thu, schedule.tiet);
                    
                    // Set teacher after a delay to allow options to load
                    setTimeout(() => {
                        if (teacherSelect && schedule.ma_giao_vien) {
                            // Try to find the teacher option
                            const teacherOption = Array.from(teacherSelect.options).find(option => 
                                option.value === schedule.ma_giao_vien
                            );
                            
                            if (teacherOption) {
                                teacherSelect.value = schedule.ma_giao_vien;
                                console.log(`✓ Set teacher: ${schedule.ten_giao_vien} (${schedule.ma_giao_vien})`);
                            } else {
                                // If teacher not found in options, add it manually
                                const newOption = document.createElement('option');
                                newOption.value = schedule.ma_giao_vien;
                                newOption.textContent = schedule.ten_giao_vien || 'Giáo viên không xác định';
                                newOption.setAttribute('data-teacher-name', schedule.ten_giao_vien || 'Giáo viên không xác định');
                                teacherSelect.appendChild(newOption);
                                teacherSelect.value = schedule.ma_giao_vien;
                                console.log(`✓ Added and set teacher: ${schedule.ten_giao_vien} (${schedule.ma_giao_vien})`);
                            }
                        }
                    }, 200);
                }
                
                if (roomInput) {
                    roomInput.value = schedule.phong_hoc || '';
                }
            });
        })
        .catch(error => {
            console.error('Error loading existing schedules:', error);
        });
}

function saveWeeklyTimetable() {
    const lop = document.getElementById('selected_lop').value;
    const khoi = document.getElementById('selected_lop').selectedOptions[0].dataset.khoi;
    const namHoc = document.getElementById('selected_nam_hoc').value;
    const hocKy = document.getElementById('selected_hoc_ky').value;
    
    if (!lop) {
        alert('Vui lòng chọn lớp học!');
        return;
    }
    
    // Thu thập dữ liệu từ form
    const schedules = [];
    
    console.log('=== BẮT ĐẦU THU THẬP DỮ LIỆU ===');
    
    for (let thu = '2'; thu <= '7'; thu = String(parseInt(thu) + 1)) {
        const dayName = thu === '2' ? 'Thứ Hai' : thu === '3' ? 'Thứ Ba' : thu === '4' ? 'Thứ Tư' : thu === '5' ? 'Thứ Năm' : thu === '6' ? 'Thứ Sáu' : 'Thứ Bảy';
        console.log(`\n--- Đang xử lý ${dayName} (thu=${thu}) ---`);
        
        for (let tiet = 1; tiet <= 10; tiet++) {
            const subjectSelect = document.querySelector(`select.subject-select[data-thu="${thu}"][data-tiet="${tiet}"]`);
            const teacherSelect = document.querySelector(`select.teacher-select[data-thu="${thu}"][data-tiet="${tiet}"]`);
            const roomInput = document.querySelector(`input.room-input[data-thu="${thu}"][data-tiet="${tiet}"]`);
            
            if (!subjectSelect) {
                console.error(`Không tìm thấy subject select cho thu=${thu}, tiet=${tiet}`);
                continue;
            }
            
            const subject = subjectSelect.value;
            
            if (subject) {
                const teacherOption = teacherSelect.selectedOptions[0];
                
                const scheduleData = {
                    lop: lop,
                    khoi: khoi,
                    thu: thu, // Giữ nguyên string value
                    tiet: tiet,
                    mon_hoc: subject,
                    ma_giao_vien: teacherSelect.value || null,
                    ten_giao_vien: teacherSelect.value ? teacherSelect.selectedOptions[0].getAttribute('data-teacher-name') : null,
                    phong_hoc: roomInput.value || null,
                    nam_hoc: namHoc,
                    hoc_ky: hocKy
                };
                
                // Debug: Log dữ liệu được thu thập
                const teacherName = teacherSelect.value ? teacherSelect.selectedOptions[0].getAttribute('data-teacher-name') : null;
                console.log(`✓ Tiết ${tiet}: ${subject} - Thu=${thu} (${dayName}) - Teacher: ${teacherName} (${teacherSelect.value}) - Phòng: ${roomInput.value || 'Không có'}`);
                
                schedules.push(scheduleData);
            }
        }
    }
    
    console.log('\n=== TỔNG KẾT DỮ LIỆU THU THẬP ===');
    console.log(`Tổng số tiết học: ${schedules.length}`);
    schedules.forEach((s, index) => {
        const dayName = s.thu === '2' ? 'Thứ Hai' : s.thu === '3' ? 'Thứ Ba' : s.thu === '4' ? 'Thứ Tư' : s.thu === '5' ? 'Thứ Năm' : s.thu === '6' ? 'Thứ Sáu' : 'Thứ Bảy';
        console.log(`${index + 1}. ${s.mon_hoc} - ${dayName} (thu=${s.thu}) - Tiết ${s.tiet}`);
    });
    
    if (schedules.length === 0) {
        alert('Vui lòng thêm ít nhất một tiết học!');
        return;
    }
    
    // Gửi dữ liệu lên server
    console.log('\n=== GỬI DỮ LIỆU LÊN SERVER ===');
    fetch('/admin/timetable/save-weekly', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            schedules: schedules
        })
    })
    .then(response => response.json())
    .then(data => {
        console.log('Phản hồi từ server:', data);
        if (data.success) {
            alert(`Lưu thành công ${data.saved_count} tiết học!`);
            window.location.href = '/admin/timetable';
        } else {
            alert('Có lỗi xảy ra: ' + (data.message || 'Vui lòng thử lại'));
        }
    })
    .catch(error => {
        console.error('Error saving timetable:', error);
        alert('Có lỗi xảy ra khi lưu dữ liệu!');
    });
}

function clearAllSchedules() {
    if (confirm('Bạn có chắc chắn muốn xóa tất cả lịch học đã nhập?')) {
        // Reset tất cả form
        document.querySelectorAll('.subject-select').forEach(select => select.value = '');
        document.querySelectorAll('.teacher-select').forEach(select => select.innerHTML = '<option value="">Chọn GV</option>');
        document.querySelectorAll('.room-input').forEach(input => input.value = '');
    }
}

function testSetData() {
    console.log('=== TEST SET DATA ===');
    
    // Clear tất cả dữ liệu trước
    document.querySelectorAll('.subject-select').forEach(select => select.value = '');
    
    // Test: Đặt môn Toán vào Thứ Hai, Tiết 1
    console.log('Đang tìm select cho Thứ Hai (thu="2"), Tiết 1...');
    const testSelect = document.querySelector('select.subject-select[data-thu="2"][data-tiet="1"]');
    
    if (testSelect) {
        console.log('✓ Tìm thấy select element');
        console.log('Element parent:', testSelect.parentElement);
        console.log('Column index:', Array.from(testSelect.parentElement.parentElement.children).indexOf(testSelect.parentElement));
        
        testSelect.value = 'Toán';
        testSelect.style.backgroundColor = '#ffeb3b'; // Highlight màu vàng
        
        console.log('✓ Đã đặt môn Toán vào select');
        
        // Kiểm tra vị trí cột
        const row = testSelect.closest('tr');
        const cellIndex = Array.from(row.children).indexOf(testSelect.closest('td'));
        console.log(`Vị trí cột vật lý: ${cellIndex} (0=time, 1=T2, 2=T3, 3=T4, 4=T5, 5=T6, 6=T7)`);
        
        // Test thu thập dữ liệu
        setTimeout(() => {
            const subject = testSelect.value;
            const thu = testSelect.getAttribute('data-thu');
            const tiet = testSelect.getAttribute('data-tiet');
            console.log(`Kiểm tra: Subject="${subject}", Thu="${thu}", Tiet="${tiet}"`);
            
            if (thu === '2' && subject === 'Toán') {
                console.log('✅ ĐÚNG: Dữ liệu được đặt và đọc chính xác');
                console.log('Nếu bạn thấy màu vàng ở cột Thứ Ba thay vì Thứ Hai, đó là lỗi!');
            } else {
                console.error('❌ SAI: Dữ liệu không khớp');
            }
        }, 100);
    } else {
        console.error('❌ Không tìm thấy select cho Thứ Hai, Tiết 1');
        
        // Debug: Liệt kê tất cả select elements
        console.log('Tất cả select elements:');
        document.querySelectorAll('.subject-select[data-tiet="1"]').forEach((select, index) => {
            const thu = select.getAttribute('data-thu');
            const tiet = select.getAttribute('data-tiet');
            console.log(`Select ${index}: data-thu="${thu}", data-tiet="${tiet}"`);
        });
    }
}

function debugCurrentData() {
    console.log('=== DEBUG CURRENT DATA ===');
    
    // Kiểm tra tất cả dữ liệu hiện tại trong form
    for (let thu = '2'; thu <= '7'; thu = String(parseInt(thu) + 1)) {
        const dayName = thu === '2' ? 'Thứ Hai' : thu === '3' ? 'Thứ Ba' : thu === '4' ? 'Thứ Tư' : thu === '5' ? 'Thứ Năm' : thu === '6' ? 'Thứ Sáu' : 'Thứ Bảy';
        console.log(`\n--- ${dayName} (thu=${thu}) ---`);
        
        let hasData = false;
        for (let tiet = 1; tiet <= 10; tiet++) {
            const subjectSelect = document.querySelector(`select.subject-select[data-thu="${thu}"][data-tiet="${tiet}"]`);
            
            if (subjectSelect && subjectSelect.value) {
                console.log(`Tiết ${tiet}: ${subjectSelect.value}`);
                hasData = true;
            }
        }
        
        if (!hasData) {
            console.log('(Không có dữ liệu)');
        }
    }
    
    // Kiểm tra vị trí vật lý của các cột
    console.log('\n=== KIỂM TRA VỊ TRÍ CỘT ===');
    const headers = document.querySelectorAll('.day-header');
    headers.forEach((header, index) => {
        console.log(`Cột ${index + 1}: ${header.textContent.trim()}`);
    });
    
    // Kiểm tra dữ liệu trong từng cột vật lý
    console.log('\n=== KIỂM TRA DỮ LIỆU THEO CỘT VẬT LÝ ===');
    const firstRow = document.querySelector('#timetableBody tr');
    if (firstRow) {
        const cells = firstRow.querySelectorAll('.schedule-cell');
        cells.forEach((cell, index) => {
            const subjectSelect = cell.querySelector('.subject-select');
            if (subjectSelect) {
                const thu = subjectSelect.getAttribute('data-thu');
                const value = subjectSelect.value;
                console.log(`Cột vật lý ${index + 1}: data-thu="${thu}", value="${value}"`);
            }
        });
    }
}

function clearAllData() {
    if (confirm('Bạn có chắc chắn muốn xóa TẤT CẢ dữ liệu thời khóa biểu trong database? Hành động này không thể hoàn tác!')) {
        fetch('/admin/timetable/clear-all-data', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(`Đã xóa ${data.deleted_count} bản ghi thành công!`);
                // Reload trang để làm mới
                window.location.reload();
            } else {
                alert('Có lỗi xảy ra: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Có lỗi xảy ra khi xóa dữ liệu!');
        });
    }
}

function testTeacherData() {
    console.log('=== TESTING TEACHER DATA ===');
    
    fetch('/admin/timetable/test-teacher-data')
        .then(response => response.json())
        .then(data => {
            console.log('Teacher data test results:', data);
            
            if (data.error) {
                console.error('Error:', data.error);
                alert('Lỗi: ' + data.error);
                return;
            }
            
            console.log(`Total teachers in database: ${data.total_teachers}`);
            console.log('Sample teachers:', data.sample_teachers);
            console.log(`Teachers for ${data.test_subject}:`, data.math_teachers);
            
            // Test API call for getting teachers by subject
            console.log('\n=== TESTING API CALL ===');
            fetch('/api/teachers/by-subject/Toán')
                .then(response => response.json())
                .then(apiData => {
                    console.log('API response for Toán:', apiData);
                    
                    if (apiData.length > 0) {
                        console.log('✅ API working correctly');
                        alert(`Tìm thấy ${data.total_teachers} giáo viên trong database, ${data.math_teachers.length} giáo viên dạy Toán. API hoạt động bình thường.`);
                    } else {
                        console.log('⚠️ No teachers found for Toán');
                        alert('Không tìm thấy giáo viên nào dạy môn Toán. Kiểm tra dữ liệu trong database.');
                    }
                })
                .catch(error => {
                    console.error('API Error:', error);
                    alert('Lỗi API: ' + error.message);
                });
        })
        .catch(error => {
            console.error('Error testing teacher data:', error);
            alert('Có lỗi xảy ra khi test dữ liệu giáo viên!');
        });
}
</script>

@endsection