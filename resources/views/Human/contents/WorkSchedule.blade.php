<link
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css"
    rel="stylesheet" />
<link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
<style>
    .card {
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .card-header {
        background: linear-gradient(135deg, #0d6efd, #0a58ca);
        color: white;
        border-radius: 10px 10px 0 0 !important;
    }

    .calendar-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid #dee2e6;
        padding: 15px;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
    }

    .table thead th {
        background-color: #f1f3f9;
        border-bottom: 2px solid #dee2e6;
        font-weight: 600;
    }

    .badge-shift {
        font-size: 0.8rem;
        padding: 0.35em 0.65em;
    }

    .shift-morning {
        background-color: #c8e6c9;
        color: #388e3c;
    }

    .shift-afternoon {
        background-color: #ffecb3;
        color: #ffa000;
    }

    .shift-night {
        background-color: #bbdefb;
        color: #1976d2;
    }

    .shift-full {
        background-color: #e1bee7;
        color: #7b1fa2;
    }

    .custom-filter {
        max-width: 200px;
    }

    .search-bar {
        position: relative;
    }

    .search-bar i {
        position: absolute;
        top: 50%;
        left: 10px;
        transform: translateY(-50%);
        color: #6c757d;
    }

    .search-bar input {
        padding-left: 30px;
    }
</style>
<div class="col-md-10 p-4">
    @if(session('success'))
    <div class="alert alert-success" role="alert">
        {{session('success')}}
    </div>
    @endif
    <div class="container-fluid py-4">
        <div class="row mb-4">
            <div class="col">
                <div class="card">
                    <div
                        class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-calendar-alt me-2"></i>
                            Lịch làm việc nhân viên
                        </h5>

                    </div>

                    <form class="calendar-header" action="{{route('Human.WorkSchedule')}}" method="GET">
                        <div class="row align-items-center">
                            <div class="col-md-4">
                                <div class="input-group mb-2 mb-md-0">
                                    <span class="input-group-text bg-white">
                                        <i class="fas fa-calendar me-1"></i> Khoảng thời gian
                                    </span>
                                    <input
                                        type="date"
                                        class="form-control"
                                        value="{{$startDate}}"
                                        name="start_date" />

                                    <span class="input-group-text bg-white">đến</span>
                                    <input
                                        type="date"
                                        class="form-control"
                                        value="{{$endDate}}"
                                        name="end_date" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="input-group custom-filter mb-2 mb-md-0">
                                    <span class="input-group-text bg-white">
                                        <i class="fas fa-sitemap me-1"></i> Loại hợp đồng
                                    </span>
                                    <select class="form-select" name="typeContract">
                                        <option value="Nhân viên chính thức">Nhân viên chính thức</option>
                                        <option value="Nhân viên thời vụ">Nhân viên thời vụ</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="search-bar">
                                    <i class="fas fa-search"></i>
                                    <select name="idEmployee" id="" class="form-control">
                                        <option value="" selected disabled>-- Chọn nhân viên --</option>
                                        @foreach($employees as $employee)
                                        <option value="{{$employee->id}}">{{$employee->id}}-{{$employee->HoTen}}-{{isset($employee->hopDong)?$employee->hopDong->LoaiHopDong:''}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2 text-md-end">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-filter me-1"></i> Lọc
                                </button>
                                <div class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addScheduleModal">
                                    <i class="fas fa-plus me-1"></i> Thêm
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr class="text-center">
                                        <th style="width: 5%">Mã NV</th>
                                        <th style="width: 20%">Tên nhân viên</th>
                                        <th style="width: 10%">Chức vụ</th>
                                        <th style="width: 10%">Phòng ban</th>

                                        <th style="width: 15%">Tên ca</th>
                                        <th style="width: 15%">Giờ vào - Giờ ra</th>
                                        <th style="width: 15%">Ngày làm việc</th>
                                        <th style="width: 10%">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>

                                <tbody>
                                    @foreach ($schedules->groupBy('nhanVien.phongBan.TenPhongBan') as $tenPhongBan => $dsLichLam)
                                    <!-- Hiển thị tiêu đề phòng ban -->
                                    <tr>
                                        <td colspan="8" class=""><strong>Phòng: {{ $tenPhongBan }}</strong></td>
                                    </tr>

                                    <!-- Hiển thị danh sách lịch làm việc của nhân viên trong phòng -->
                                    @foreach ($dsLichLam as $schedule)
                                    <tr>
                                        <td class="text-center">{{ $schedule->nhanVien->id }}</td>
                                        <td class="text-center">{{ $schedule->nhanVien->HoTen }}</td>
                                        <td class="text-center">{{ $schedule->nhanVien->chucVu->TenChucVu }}</td>
                                        <td class="text-center">{{ $schedule->nhanVien->phongBan->TenPhongBan }}</td>
                                        <td class="text-center">{{ $schedule->caLamViec->TenLoaiCa }}</td>
                                        <td class="text-center">{{ $schedule->caLamViec->Giobatdau }} - {{ $schedule->caLamViec->Gioketthuc }}</td>
                                        <td class="text-center">{{ $schedule->NgayLamViec }}</td>
                                        <td class="text-center">
                                            <button class="btn btn-warning mx-2 EditBtn"
                                                data-id="{{ $schedule->id }}"
                                                data-name="{{ $schedule->nhanVien->id }}"
                                                data-shift="{{ $schedule->caLamViec->id }}"
                                                data-dateWork="{{ $schedule->NgayLamViec }}"
                                                data-description="{{ $schedule->MoTa }}"
                                                data-bs-toggle="modal" data-bs-target="#editScheduleModal">
                                                <i class="fa-solid fa-pen"></i>
                                            </button>
                                            <button class="btn btn-danger mx-2 DeleteBtn"
                                                data-id="{{ $schedule->id }}"
                                                data-bs-toggle="modal" data-bs-target="#deleteScheduleModal">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @endforeach
                                </tbody>

                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="addScheduleModal" tabindex="-1" aria-labelledby="addScheduleModalLabel" aria-hidden="true">
    <form action="{{route('Human.WorkScheduleAdd')}}" method="POST">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addScheduleModalLabel">
                        <i class="fas fa-calendar-plus me-2"></i>Thêm lịch làm việc mới
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    @csrf
                    <div class="mb-3">
                        <label for="workDate" class="form-label required">Ngày làm việc</label>
                        <input type="date" class="form-control" name="NgayLamViec" required value="2025-03-17">
                    </div>

                    <div class="mb-3">
                        <label for="employeeSelect" class="form-label required">Tên nhân viên</label>
                        <select class="form-select" name="nhanvien_id" required>
                            <option value="" selected disabled>-- Chọn nhân viên --</option>
                            @foreach($employees as $employee)
                            <option value="{{$employee->id}}">{{$employee->id}}-{{$employee->HoTen}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="shiftSelect" class="form-label required">Ca làm việc</label>
                        <select class="form-select" name="ca_id" required>
                            <option value="" selected disabled>-- Chọn ca làm việc --</option>
                            @foreach($shifts as $shift)
                            <option value="{{$shift->id}}">{{$shift->TenLoaiCa}}</option>
                            @endforeach
                        </select>
                    </div>



                    <div class="mb-3">
                        <label for="noteText" class="form-label">Ghi chú</label>
                        <textarea class="form-control" name="MoTa" rows="3" placeholder="Nhập ghi chú nếu cần..."></textarea>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Hủy
                    </button>
                    <button type="submit" class="btn btn-primary" id="saveScheduleBtn">
                        <i class="fas fa-save me-2"></i>Thêm lịch làm việc
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
<div class="modal fade" id="editScheduleModal" tabindex="-1" aria-labelledby="editScheduleModalLabel" aria-hidden="true">
    <form id="scheduleForm" action="" method="POST">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addScheduleModalLabel">
                        <i class="fas fa-calendar-plus me-2"></i>Sửa thông tin lịch làm việc
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="workDate" class="form-label required">Ngày làm việc</label>
                        <input type="date" class="form-control" name="NgayLamViec" id="NgayLamViec" required value="2025-03-17">
                    </div>

                    <div class="mb-3">
                        <label for="employeeSelect" class="form-label required">Tên nhân viên</label>
                        <select class="form-select" name="nhanvien_id" required id="nhanvien_id">
                            <option value="" selected disabled>-- Chọn nhân viên --</option>
                            @foreach($employees as $employee)
                            <option value="{{$employee->id}}">{{$employee->id}}-{{$employee->HoTen}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="shiftSelect" class="form-label required">Ca làm việc</label>
                        <select class="form-select" name="ca_id" id="ca_id" required>
                            <option value="" selected disabled>-- Chọn ca làm việc --</option>
                            @foreach($shifts as $shift)
                            <option value="{{$shift->id}}">{{$shift->TenLoaiCa}}</option>
                            @endforeach
                        </select>
                    </div>



                    <div class="mb-3">
                        <label for="noteText" class="form-label">Ghi chú</label>
                        <textarea class="form-control" name="MoTa" id="MoTa" rows="3" placeholder="Nhập ghi chú nếu cần..."></textarea>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Hủy
                    </button>
                    <button type="submit" class="btn btn-primary" id="saveScheduleBtn">
                        <i class="fas fa-save me-2"></i>Lưu lịch làm việc
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
<div class="modal fade" id="deleteScheduleModal" tabindex="-1" aria-hidden="true">
    <form class="modal-dialog modal-dialog-centered" action="" method="POST" id="deleteForm">
        @csrf
        @method('DELETE')
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Xác Nhận Xóa</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Bạn có chắc chắn muốn xóa lịch làm việc này?</p>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-1"></i> Hủy
                </button>
                <button type="submit" class="btn btn-danger" id="confirmDeleteBtn">
                    <i class="bi bi-trash me-1"></i> Xóa
                </button>
            </div>
        </div>
    </form>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const editBtns = document.querySelectorAll(".EditBtn");
        const deleteBtns = document.querySelectorAll(".DeleteBtn");
        editBtns.forEach(btn => {
            btn.addEventListener("click", function() {
                const id = btn.getAttribute("data-id");
                const name = btn.getAttribute("data-name");
                const shift = btn.getAttribute("data-shift");
                const dateWork = btn.getAttribute("data-dateWork");
                const description = btn.getAttribute("data-description");
                const form = document.querySelector("#scheduleForm");
                console.log(name, shift, dateWork, description);
                document.querySelector("#nhanvien_id").value = name;
                document.querySelector("#ca_id").value = shift;
                document.querySelector("#NgayLamViec").value = dateWork;
                document.querySelector("#MoTa").value = description;
                form.action = `/WorkSchedule/${id}`;
            });
        });
        deleteBtns.forEach(btn => {
            btn.addEventListener("click", function() {
                const id = btn.getAttribute("data-id");
                const form = document.querySelector("#deleteForm");
                form.action = `/WorkSchedule/${id}`;
            });
        });
    });
</script>