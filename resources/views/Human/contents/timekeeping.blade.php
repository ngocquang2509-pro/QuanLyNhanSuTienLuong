<!-- Bootstrap CSS -->
<link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
    rel="stylesheet" />
<!-- Font Awesome -->
<link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
<style>
    body {
        background-color: #f8f9fa;
        font-family: "Segoe UI", Roboto, "Helvetica Neue", sans-serif;
    }

    .content-wrapper {
        padding: 2rem;
        max-width: 1200px;
        margin: 0 auto;
    }

    .card {
        transition: all 0.2s ease;
    }

    .card:hover {
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .badge {
        font-weight: 500;
    }

    .btn-action {
        min-width: 120px;
    }

    .card {
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        padding: 20px;
    }

    .card-title {
        font-size: 18px;
        margin-bottom: 15px;
        color: var(--dark-color);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .card-title i {
        color: var(--secondary-color);
    }

    .dashboard {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }
</style>
</head>

<div class="col-md-10 p-3">
    <div class="row mb-4">
        <div class="col-12">

            <div class="card shadow-sm">
                <div class="dashboard">
                    <div class="card">
                        @if(isset($nhanvien))
                        <div class="card-title">
                            <span>{{$nhanvien->HoTen}}</span>
                            <i>📅</i>
                        </div>
                        <div class="stat">Số công: {{$nhanvien->TongSoCong}}</div>
                        @else
                        <div class="card-title">
                            <span>Số công ngày</span>
                            <span>{{ request('dateWork') }}</span>
                        </div>
                        @endif
                    </div>

                    <div class="card">
                        <div class="card-title">
                            <span>Dữ liệu đồng bộ</span>
                            <i>🔄</i>
                        </div>
                        <div class="stat">100%</div>
                        <div class="stat-detail">Cập nhật lần cuối: 10:15 AM</div>
                    </div>


                </div>
                <div class="card-body">
                    <form class="row align-items-center" method="" action="{{route('Human.Timekeeping')}}">
                        @csrf
                        <div class="col-md-4">
                            <div class="input-group mb-2 mb-md-0">
                                <h3>Danh Sách chấm công</h3>

                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="input-group custom-filter mb-2 mb-md-0">
                                <span class="input-group-text bg-white">
                                    <i class="fas fa-sitemap me-1"></i> Phòng ban
                                </span>
                                <select class="form-select" name="department">
                                    <option value="">Tất cả phòng ban</option>
                                    @foreach ($departments as $department)
                                    <option value="{{$department->id}}">{{$department->TenPhongBan}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="input-group custom-filter mb-2 mb-md-0">
                                <span class="input-group-text bg-white">
                                    Ngày làm việc
                                </span>

                                <input type="date" name="dateWork" class="form-control">

                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="search-bar">

                                <select name="employee" id="" class="form-control">
                                    <option value="">Tìm kiếm theo nhân viên....</option>
                                    @foreach ($employees as $employee)
                                    <option value="{{$employee->id}}">{{$employee->id}}-{{$employee->HoTen}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2 text-md-end">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-filter me-1"></i> Lọc
                            </button>

                        </div>
                    </form>
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Họ và tên</th>
                                <th>Ca làm việc</th>
                                <th>Giờ vào</th>
                                <th>Giờ ra</th>
                                <th>Giờ vào thực tế</th>
                                <th>Giờ ra thực tế</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($timekeepings->count() != 0)
                            @foreach ($timekeepings as $timekeeping)<tr>

                                <td class="">{{$timekeeping->nhanVien->id}}-{{$timekeeping->nhanVien->HoTen}}</td>
                                <td class="">{{$timekeeping->lichLamViec->caLamViec->TenLoaiCa}}</td>
                                <td class="">{{$timekeeping->lichLamViec->caLamViec->Giobatdau}}</td>
                                <td class="">{{$timekeeping->lichLamViec->caLamViec->Gioketthuc}}</td>
                                <td class="">{{$timekeeping->GioVao}}</td>
                                <td class="">{{$timekeeping->GioRa}}</td>


                                <td>
                                    <!-- Nút mở modal -->
                                    <button
                                        type="button"
                                        class="btn btn-sm btn-primary detailBtn"
                                        data-name="{{$timekeeping->nhanVien->HoTen}}"
                                        data-department="{{$timekeeping->nhanVien->phongBan->TenPhongBan}}"
                                        data-date-work="{{$timekeeping->lichLamViec->NgayLamViec}}"
                                        data-shift="{{$timekeeping->lichLamViec->caLamViec->TenLoaiCa}}"
                                        data-time-start="{{$timekeeping->GioVao}}"
                                        data-time-end="{{$timekeeping->GioRa}}"
                                        data-status="{{$timekeeping->TrangThai}}"
                                        data-total="{{$timekeeping->SoCong}}"
                                        data-bs-toggle="modal"
                                        data-bs-target="#detailView">
                                        <i class="fas fa-eye me-1"></i>Chi tiết
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Chi Tiết Chấm Công -->
<div
    class="modal fade"
    id="detailView"
    tabindex="-1"
    aria-labelledby="attendanceDetailModalLabel"
    aria-hidden="true">
    <form>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-3 shadow">
                <div class="modal-header bg-primary text-white py-3">
                    <h5
                        class="modal-title fs-5 fw-semibold"
                        id="attendanceDetailModalLabel">
                        <i class="fas fa-user-clock me-2"></i>Chi tiết chấm công
                    </h5>
                    <button
                        type="button"
                        class="btn-close btn-close-white"
                        data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <!-- Thông tin nhân viên -->
                        <div class="col-md-6">
                            <div class="card border-0 bg-light rounded-3 h-100">
                                <div class="card-body">
                                    <h6 class="card-title text-secondary mb-3">
                                        <i class="fas fa-id-card me-2"></i>Thông tin nhân viên
                                    </h6>
                                    <div class="mb-3">
                                        <div class="text-muted small">Họ và tên:</div>
                                        <div class="fw-semibold" id="name">Phạm Thị D (NV004)</div>
                                    </div>
                                    <div class="mb-0">
                                        <div class="text-muted small">Phòng ban:</div>
                                        <div class="fw-semibold" id="deparment">Hành chính</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Thông tin chấm công -->
                        <div class="col-md-6">
                            <div class="card border-0 bg-light rounded-3 h-100">
                                <div class="card-body">
                                    <h6 class="card-title text-secondary mb-3">
                                        <i class="fas fa-calendar-day me-2"></i>Thông tin ngày
                                    </h6>
                                    <div class="mb-3">
                                        <div class="text-muted small">Ngày làm việc:</div>
                                        <div class="fw-semibold" id="dateWork">06/03/2025</div>
                                    </div>
                                    <div class="mb-0">
                                        <div class="text-muted small">Nguồn dữ liệu:</div>
                                        <div class="fw-semibold">Máy chấm công (DEV001)</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Chi tiết giờ làm việc -->
                        <div class="col-12">
                            <div class="card border-0 bg-light rounded-3">
                                <div class="card-body">
                                    <h6 class="card-title text-secondary mb-3">
                                        <i class="fas fa-clock me-2"></i>Chi tiết giờ làm việc
                                    </h6>
                                    <div class="row my-2">
                                        <div class="mb-0">
                                            <div class="text-muted small">Ca làm việc:</div>
                                            <div class="d-flex align-items-center">
                                                <span class="fw-semibold me-2" id="shift">FullTime</span>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-3">

                                        <div class="col-md-6">
                                            <div class="mb-0">
                                                <div class="text-muted small">Giờ vào:</div>
                                                <div class="d-flex align-items-center">
                                                    <span class="fw-semibold me-2" id="timeStart">07:50 AM</span>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-0">
                                                <div class="text-muted small">Giờ ra:</div>
                                                <div class="d-flex align-items-center">
                                                    <span class="fw-semibold me-2" id="timeEnd">04:30 PM</span>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Trạng thái -->
                        <div class="col-md-6">
                            <div class="card border-0 bg-light rounded-3">
                                <div class="card-body">
                                    <div class="text-muted small mb-1">Trạng thái:</div>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-check-circle text-success me-2"></i>
                                        <span class="fw-semibold" id="status">Đúng giờ</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Số công -->
                        <div class="col-md-6">
                            <div class="card border-0 bg-light rounded-3">
                                <div class="card-body">
                                    <div class="text-muted small mb-1">Số công:</div>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-calculator text-primary me-2"></i>
                                        <span class="fw-semibold" id="total">40</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light py-3">
                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Đóng
                    </button>
                    <button type="submit" class="btn btn-primary btn-action">
                        <i class="fas fa-check me-1"></i>Xác nhận dữ liệu
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- JavaScript tùy chỉnh -->
<script>
    // Khởi tạo tooltips nếu cần

    document.addEventListener("DOMContentLoaded", function() {
        // Lắng nghe sự kiện khi nút chi tiết được click
        const detailBtns = document.querySelectorAll(".detailBtn");
        detailBtns.forEach(function(btn) {
            btn.addEventListener("click", function() {
                // Lấy dữ liệu từ nút được click
                const name = btn.getAttribute("data-name");
                const department = btn.getAttribute("data-department");
                const dateWork = btn.getAttribute("data-date-work");
                const shift = btn.getAttribute("data-shift");
                const timeStart = btn.getAttribute("data-time-start");
                const timeEnd = btn.getAttribute("data-time-end");
                const status = btn.getAttribute("data-status");
                const total = btn.getAttribute("data-total");
                console.log(name);
                console.log(department);
                console.log(dateWork);
                console.log(shift);
                console.log(timeStart);
                console.log(timeEnd);
                console.log(status);
                console.log(total);
                // Hiển thị dữ liệu lên modal
                document.getElementById("name").textContent = name;
                document.getElementById("deparment").textContent = department;
                document.getElementById("dateWork").textContent = dateWork;
                document.getElementById("shift").textContent = shift;
                document.getElementById("timeStart").textContent = timeStart;
                document.getElementById("timeEnd").textContent = timeEnd;
                document.getElementById("status").textContent = status;
                document.getElementById("total").textContent = total;
            });
        });
    });
</script>