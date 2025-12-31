@extends('TeacherPage.TeacherPage')

@section('content')
    <div style="padding: 30px;">
        <div style="background: white; border-radius: 12px; padding: 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
                <div>
                    <h1 style="color: #2c3e50; margin: 0;">
                        <i class="fas fa-home"></i> Dashboard Giáo viên
                    </h1>
                    <p style="color: #6c757d; margin: 5px 0 0 0;">Chào mừng {{ $teacher->ho_ten ?? 'Giáo viên' }}!</p>
                </div>
                <div style="text-align: right;">
                    <div style="background: linear-gradient(135deg, #667eea, #764ba2); color: white; padding: 10px 20px; border-radius: 25px; display: inline-block;">
                        <i class="fas fa-calendar-alt"></i> Năm học {{ $academicYear }}
                    </div>
                    <div style="margin-top: 5px; font-size: 14px; color: #6c757d;">
                        <i class="fas fa-clock"></i> {{ date('d/m/Y H:i') }}
                    </div>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 30px;">
                <!-- Students Card -->
                <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                    <div style="display: flex; align-items: center; gap: 15px;">
                        <i class="fas fa-users" style="font-size: 40px; opacity: 0.8;"></i>
                        <div>
                            <h3 style="margin: 0; font-size: 24px;">{{ $statistics['total_students'] }}</h3>
                            <p style="margin: 5px 0 0 0; opacity: 0.9;">Học sinh</p>
                        </div>
                    </div>
                </div>

                <!-- Classes Card -->
                <div style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                    <div style="display: flex; align-items: center; gap: 15px;">
                        <i class="fas fa-clipboard-list" style="font-size: 40px; opacity: 0.8;"></i>
                        <div>
                            <h3 style="margin: 0; font-size: 24px;">{{ $statistics['total_classes'] }}</h3>
                            <p style="margin: 5px 0 0 0; opacity: 0.9;">Lớp học</p>
                        </div>
                    </div>
                </div>

                <!-- Pass Rate Card -->
                <div style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                    <div style="display: flex; align-items: center; gap: 15px;">
                        <i class="fas fa-chart-line" style="font-size: 40px; opacity: 0.8;"></i>
                        <div>
                            <h3 style="margin: 0; font-size: 24px;">{{ $statistics['pass_rate'] }}%</h3>
                            <p style="margin: 5px 0 0 0; opacity: 0.9;">Tỷ lệ đạt</p>
                        </div>
                    </div>
                </div>

                <!-- Subjects Card -->
                <div style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); color: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                    <div style="display: flex; align-items: center; gap: 15px;">
                        <i class="fas fa-book" style="font-size: 40px; opacity: 0.8;"></i>
                        <div>
                            <h3 style="margin: 0; font-size: 24px;">{{ $statistics['total_subjects'] }}</h3>
                            <p style="margin: 5px 0 0 0; opacity: 0.9;">Môn học</p>
                        </div>
                    </div>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 30px; margin-top: 30px;">
                <!-- Recent Activities -->
                <div style="background: #f8f9fa; padding: 25px; border-radius: 12px;">
                    <h3 style="color: #2c3e50; margin-bottom: 20px;">
                        <i class="fas fa-clock"></i> Hoạt động gần đây
                    </h3>
                    <div style="space-y: 15px;">
                        @if(count($recentActivities) > 0)
                            @foreach($recentActivities as $activity)
                            <div style="display: flex; align-items: center; gap: 15px; padding: 15px; background: white; border-radius: 8px; margin-bottom: 10px;">
                                <div style="width: 40px; height: 40px; background: {{ $activity['color'] }}; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                    <i class="{{ $activity['icon'] }}" style="color: white;"></i>
                                </div>
                                <div>
                                    <p style="margin: 0; font-weight: 600;">{{ $activity['title'] }}</p>
                                    <small style="color: #6c757d;">{{ $activity['time'] }}</small>
                                </div>
                            </div>
                            @endforeach
                        @else
                            <div style="text-align: center; padding: 40px; color: #6c757d;">
                                <i class="fas fa-inbox" style="font-size: 48px; margin-bottom: 15px; opacity: 0.5;"></i>
                                <p>Chưa có hoạt động nào gần đây</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Quick Actions -->
                <div style="background: #f8f9fa; padding: 25px; border-radius: 12px;">
                    <h3 style="color: #2c3e50; margin-bottom: 20px;">
                        <i class="fas fa-bolt"></i> Thao tác nhanh
                    </h3>
                    <div style="space-y: 10px;">
                        <a href="{{ route('teacher.list.point') }}"
                            style="display: block; padding: 15px; background: white; border-radius: 8px; text-decoration: none; color: #2c3e50; margin-bottom: 10px; transition: all 0.3s ease;">
                            <i class="fas fa-clipboard-list" style="margin-right: 10px; color: #667eea;"></i>
                            Nhập điểm học sinh
                        </a>

                        <a href="{{ route('teacher.profile') }}"
                            style="display: block; padding: 15px; background: white; border-radius: 8px; text-decoration: none; color: #2c3e50; margin-bottom: 10px; transition: all 0.3s ease;">
                            <i class="fas fa-user-edit" style="margin-right: 10px; color: #f093fb;"></i>
                            Cập nhật hồ sơ
                        </a>

                        <a href="{{ route('teacher.timetable') }}"
                            style="display: block; padding: 15px; background: white; border-radius: 8px; text-decoration: none; color: #2c3e50; margin-bottom: 10px; transition: all 0.3s ease;">
                            <i class="fas fa-calendar-alt" style="margin-right: 10px; color: #fa709a;"></i>
                            Thời khóa biểu
                        </a>

                        <a href="#"
                            style="display: block; padding: 15px; background: white; border-radius: 8px; text-decoration: none; color: #2c3e50; transition: all 0.3s ease;">
                            <i class="fas fa-chart-bar" style="margin-right: 10px; color: #4facfe;"></i>
                            Xem báo cáo
                        </a>
                    </div>
                </div>
            </div>

            <!-- Additional Information Sections -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-top: 30px;">
                <!-- Assigned Classes -->
                <div style="background: #f8f9fa; padding: 25px; border-radius: 12px;">
                    <h3 style="color: #2c3e50; margin-bottom: 20px;">
                        <i class="fas fa-chalkboard"></i> Lớp được phân công
                    </h3>
                    @if(count($assignedClasses) > 0)
                        @foreach($assignedClasses as $class)
                        <div style="background: white; padding: 15px; border-radius: 8px; margin-bottom: 10px; border-left: 4px solid #667eea;">
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <div>
                                    <h4 style="margin: 0; color: #2c3e50;">Lớp {{ $class['name'] }}</h4>
                                    <p style="margin: 5px 0 0 0; color: #6c757d; font-size: 14px;">
                                        {{ $class['student_count'] }} học sinh
                                    </p>
                                </div>
                                <div style="text-align: right;">
                                    <span style="background: #e3f2fd; color: #1976d2; padding: 4px 8px; border-radius: 12px; font-size: 12px;">
                                        {{ count($class['subjects']) }} môn
                                    </span>
                                </div>
                            </div>
                            <div style="margin-top: 10px;">
                                <small style="color: #6c757d;">Môn học: {{ implode(', ', $class['subjects']) }}</small>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div style="text-align: center; padding: 40px; color: #6c757d;">
                            <i class="fas fa-chalkboard" style="font-size: 48px; margin-bottom: 15px; opacity: 0.5;"></i>
                            <p>Chưa được phân công lớp nào</p>
                        </div>
                    @endif
                </div>

                <!-- Today's Schedule -->
                <div style="background: #f8f9fa; padding: 25px; border-radius: 12px;">
                    <h3 style="color: #2c3e50; margin-bottom: 20px;">
                        <i class="fas fa-calendar-day"></i> Lịch dạy hôm nay
                    </h3>
                    @if(count($todaySchedule) > 0)
                        @foreach($todaySchedule as $schedule)
                        <div style="background: white; padding: 15px; border-radius: 8px; margin-bottom: 10px; border-left: 4px solid #28a745;">
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <div>
                                    <h4 style="margin: 0; color: #2c3e50;">Tiết {{ $schedule->tiet }}</h4>
                                    <p style="margin: 5px 0 0 0; color: #6c757d; font-size: 14px;">
                                        {{ $schedule->mon_hoc }} - Lớp {{ $schedule->lop }}
                                    </p>
                                </div>
                                <div style="text-align: right;">
                                    <span style="background: #e8f5e8; color: #2e7d32; padding: 4px 8px; border-radius: 12px; font-size: 12px;">
                                        {{ $schedule->phong_hoc ?? 'Phòng TBD' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div style="text-align: center; padding: 40px; color: #6c757d;">
                            <i class="fas fa-calendar-day" style="font-size: 48px; margin-bottom: 15px; opacity: 0.5;"></i>
                            <p>Không có lịch dạy hôm nay</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    </div>

    <style>
        a:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1) !important;
        }
    </style>
@endsection
