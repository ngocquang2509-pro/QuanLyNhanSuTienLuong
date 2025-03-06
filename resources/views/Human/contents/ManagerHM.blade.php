<style>
    .modal.fade .modal-dialog {
        transform: scale(0.7);
        opacity: 0;
        transition: all 0.3s ease-in-out;
    }

    .modal.show .modal-dialog {
        transform: scale(1);
        opacity: 1;
    }

    .modal-content {
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
    }

    .modal-header {
        background: linear-gradient(135deg, #0d6efd, #0a58ca);
        color: white;
        border-radius: 15px 15px 0 0;
        padding: 1.5rem;
    }

    .modal-title {
        font-weight: 600;
        letter-spacing: 0.5px;
    }

    .modal-body {
        padding: 2rem;
    }

    .modal-footer {
        background-color: #f8f9fa;
        border-radius: 0 0 15px 15px;
        padding: 1rem;
    }

    .detail-row {
        display: flex;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid #dee2e6;
    }

    .detail-label {
        width: 180px;
        font-weight: 600;
        color: #495057;
    }

    .detail-value {
        flex: 1;
        color: #212529;
    }

    .modal .close {
        color: white;
        opacity: 1;
    }

    .modal .close:hover {
        color: #dee2e6;
    }

    .highlight-section {
        background-color: #f8f9fa;
        border-radius: 10px;
        padding: 1rem;
        margin: 1rem 0;
    }

    .company-logo {
        max-height: 80px;
    }

    .contract-header {
        border-bottom: 2px solid #dee2e6;
        margin-bottom: 20px;
        padding-bottom: 15px;
    }

    .section-title {
        background-color: #f8f9fa;
        padding: 10px;
        margin: 15px 0;
        border-left: 4px solid #0d6efd;
    }

    .signature-area {
        border: 1px dashed #ddd;
        height: 100px;
        margin-top: 10px;
        background-color: #f9f9f9;
        position: relative;
    }

    .signature-seal {
        width: 70px;
        height: 70px;
        position: absolute;
        right: 15px;
        bottom: 10px;
        opacity: 0.8;
    }

    .form-label {
        font-weight: 500;
    }

    .contract-column {
        border-right: 1px solid #dee2e6;
    }

    @media (max-width: 767.98px) {
        .contract-column {
            border-right: none;
            border-bottom: 1px solid #dee2e6;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }
    }
</style>

<div class="col-md-10 p-4">
    @if(session('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
    @endif
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">

            <h3 class="navbar-brand">Quản lý nhân sự</h3>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarControls">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarControls">
                <form class="d-flex align-items-center ms-auto gap-3" action="{{ route('Human.ManagerFind') }}">
                    <select class="form-select" style="width: 200px;" name="department">
                        @if(isset($departmentFind))
                        @foreach($departments as $department)
                        <option value="{{ $department->id }}" {{$department->id == $departmentFind->id ? 'selected':'' }}>{{ $department->TenPhongBan }}</option>
                        @endforeach
                        @else
                        @foreach($departments as $department)
                        <option value="{{ $department->id }}">{{ $department->TenPhongBan }}</option>
                        @endforeach
                        @endif
                    </select>
                    <button class="btn btn-primary">Tìm kiếm</button>
                </form>
                <button class="btn btn-primary mx-2" data-bs-toggle="modal" data-bs-target="#FileAddModal">Thêm nhân sự</button>
            </div>
        </div>
    </nav>
    <div class="table-responsive ">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Mã NV</th>
                    <th>Họ Tên</th>
                    <th>Chức vụ</th>
                    <th>Phòng ban</th>
                    <th>Hồ sơ</th>
                </tr>
            </thead>
            <tbody>
                @foreach($employees as $index => $employee)
                <tr>
                    <td>{{$employee->id}}</td>
                    <td>{{$employee->HoTen}}</td>
                    <td>{{$employee->chucVu->TenChucVu}}</td>
                    <td>{{$employee->phongBan->TenPhongBan}}</td>
                    <td class="text-center align-middle">
                        @if($employee->hopDong)
                        <button class="btn btn-primary d-flex align-items-center justify-content-center mx-auto view-profile"
                            style="width: 32px; height: 32px;" type="button"
                            data-id="{{ $employee->id }}"
                            data-name="{{$employee->HoTen}}"
                            data-gioitinh="{{$employee->GioiTinh}}"
                            data-ngaySinh="{{$employee->NgaySinh}}"
                            data-cccd="{{$employee->CCCD}}"
                            data-dienThoai="{{$employee->DienThoai}}"
                            data-diachi="{{$employee->DiaChi}}"
                            data-email="{{$employee->Email}}"
                            data-position="{{$employee->chucVu->TenChucVu}}"
                            data-deparment="{{$employee->phongBan->TenPhongBan}}"
                            data-MaPhongBan="{{$employee->MaPhongBan}}"
                            data-MaChucVu="{{$employee->MaChucVu}}"
                            data-bankAccount="{{$employee->hopDong->TaiKhoan}}"
                            data-typeContract="{{$employee->hopDong->LoaiHopDong}}"
                            data-startDate="{{$employee->hopDong->ngay_bat_dau}}"
                            data-endDate="{{$employee->hopDong->ngay_ket_thuc}}"
                            data-signDate="{{$employee->hopDong->ngay_ky}}"
                            data-baseSalary="{{$employee->chucVu->LuongCoBan}}"
                            data-content="{{$employee->hopDong->noi_dung}}"
                            data-bs-toggle="modal"
                            data-bs-target="#contractModal">
                            <i class="fa-solid fa-eye"></i>
                        </button>
                        @else
                        <button class="btn btn-primary d-flex align-items-center justify-content-center mx-auto view-profile "
                            style="width: 32px; height: 32px;" type="button"
                            data-id="{{ $employee->id }}"
                            data-name="{{$employee->HoTen}}"
                            data-gioitinh="{{$employee->GioiTinh}}"
                            data-ngaySinh="{{$employee->NgaySinh}}"
                            data-cccd="{{$employee->CCCD}}"
                            data-dienThoai="{{$employee->DienThoai}}"
                            data-diachi="{{$employee->DiaChi}}"
                            data-email="{{$employee->Email}}"
                            data-position="{{$employee->chucVu->TenChucVu}}"
                            data-deparment="{{$employee->phongBan->TenPhongBan}}"
                            data-MaPhongBan="{{$employee->MaPhongBan}}"
                            data-MaChucVu="{{$employee->MaChucVu}}"
                            data-baseSalary="{{$employee->chucVu->LuongCoBan}}"
                            data-bs-toggle="modal"
                            data-bs-target="#contractModal">
                            <i class="fa-solid fa-plus"></i>
                        </button>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div
    class="modal fade"
    id="contractModal"
    tabindex="-1"
    aria-labelledby="contractModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="contractModalLabel">
                    HỢP ĐỒNG LAO ĐỘNG
                </h5>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div
                    class="contract-header d-flex justify-content-between align-items-center">
                    <div>
                        <img
                            src="https://online.itehcmc.travel/wp-content/uploads/2022/09/LOGO-9.png"
                            alt="Logo công ty"
                            class="company-logo" />
                    </div>
                    <div class="text-end">
                        <h4>Công ty TNHH Dược Phẩm Sâm Ngọc Linh</h4>
                        <p class="mb-0">
                            Số: <span id="contractNumber">HD-2025/.....</span>
                        </p>
                    </div>
                </div>

                <div class="text-center mb-4">
                    <h3>HỢP ĐỒNG LAO ĐỘNG</h3>
                    <p>(Thời hạn 12 tháng)</p>
                </div>

                <p>
                    Hôm nay, ngày <span class="fw-bold">......</span> tháng
                    <span class="fw-bold">......</span> năm
                    <span class="fw-bold">2025</span>, tại trụ sở Công ty TNHH Dược Phẩm Sâm Ngọc Linh
                </p>

                <!-- Bố cục chia làm 2 cột -->
                <form action="" id="ViewForm" method="POST">

                    @csrf
                    @method('PUT')
                    <div class="row">
                        <!-- CỘT 1 - Bên thuê và bên lao động -->
                        <div class="col-md-6 contract-column">
                            <h5 class="section-title">I. BÊN SỬ DỤNG LAO ĐỘNG</h5>
                            <div class="mb-3">
                                <label class="form-label">Tên công ty:</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    value="CÔNG TY TNHH DƯỢC PHẨM SÂM NGỌC LINH"
                                    readonly />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Địa chỉ:</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    value=" 216 Trần Quang Khải,P.Tràng Tiền,Q.Hoàn Kiếm,Hà Nội"
                                    readonly />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Mã số doanh nghiệp:</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    value="0123456789"
                                    readonly />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Điện thoại:</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    value="0703.216.216"
                                    readonly />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Đại diện bởi:</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    value="Ông Nguyễn Văn A - Chức vụ: Giám đốc nhân sự"
                                    readonly />
                            </div>

                            <h5 class="section-title">II. NGƯỜI LAO ĐỘNG</h5>
                            <div class="mb-3">
                                <label class="form-label">Họ và tên:</label>
                                <input type="text" class="form-control" id="employeeName" name="HoTen" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Giới tính:</label>
                                <select class="form-select" id="employeeGender" name="GioiTinh">
                                    <option value="Nam">Nam</option>
                                    <option value="Nữ">Nữ</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Ngày sinh:</label>
                                <input
                                    type="date"
                                    class="form-control"
                                    id="employeeBirthday"
                                    name="NgaySinh" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">CCCD/CMND:</label>
                                <input type="text" class="form-control" id="employeeId" name="CCCD" />
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Địa chỉ thường trú:</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="employeeAddress"
                                    name="DiaChi" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Số điện thoại:</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    name="DienThoai"
                                    id="employeePhone" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email:</label>
                                <input
                                    type="email"
                                    class="form-control"
                                    name="Email"
                                    id="employeeEmail" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Vị trí công việc:</label>
                                <select name="MaChucVu" id="jobPosition" class="form-control">
                                    @foreach($positions as $position)
                                    <option value="{{ $position->id }}">{{ $position->TenChucVu }}</option>
                                    @endforeach
                                </select>

                            </div>
                            <div class="mb-3">
                                <label class="form-label">Phòng ban:</label>
                                <select name="MaPhongBan" id="department" class="form-control">
                                    @foreach($departments as $department)
                                    <option value="{{ $department->id }}">{{ $department->TenPhongBan }}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>

                        <!-- CỘT 2 - Nội dung hợp đồng -->
                        <div class="col-md-6">
                            <h5 class="section-title">III. NỘI DUNG HỢP ĐỒNG</h5>
                            <div class="mb-3">
                                <label class="form-label">Loại hợp đồng:</label>
                                <input type="text" class="form-control" id="typeContract" name="LoaiHopDong" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Thời hạn hợp đồng:</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    value="12 tháng"
                                    id="timeContract"
                                    readonly />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Ngày bắt đầu làm việc:</label>
                                <input type="date" class="form-control" id="startDate" name="ngay_bat_dau" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Ngày kết thúc làm việc:</label>
                                <input type="date" class="form-control" id="endDate" name="ngay_ket_thuc" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Ngày ký:</label>
                                <input type="date" class="form-control" id="signDate" name="ngay_ky" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Lương cơ bản:</label>
                                <div class="input-group">
                                    <input
                                        type="number"
                                        class="form-control"
                                        id="baseSalary" />

                                    <span class="input-group-text">VNĐ</span>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Phụ cấp (nếu có):</label>
                                <div class="input-group">
                                    <input
                                        type="number"
                                        class="form-control"
                                        id="allowance" />
                                    <span class="input-group-text">VNĐ</span>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Hình thức trả lương:</label>
                                <select class="form-select" id="paymentMethod">
                                    <option value="bank">Chuyển khoản ngân hàng</option>
                                    <option value="cash">Tiền mặt</option>
                                </select>
                            </div>
                            <div id="bankInfoSection">
                                <div class="mb-3">
                                    <label class="form-label">Số tài khoản:</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="bankAccount" name="TaiKhoan" />

                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Ngân hàng:</label>
                                    <input type="text" class="form-control" id="bankName" value="VietComBank" />
                                </div>
                                <label class="form-label">Nội dung:</label>
                                <textarea class="form-control" rows="3" name="noi_dung" id="content">
                            </div>

                            <h5 class="section-title">
                                IV. THỜI GIAN LÀM VIỆC VÀ NGHỈ NGƠI
                            </h5>
                            <div class="mb-3">
                                <label class="form-label">Thời gian làm việc:</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    value="8 giờ/ngày, 40 giờ/tuần (Từ thứ Hai đến thứ Sáu)"
                                    readonly />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Chế độ nghỉ ngơi:</label>
                                <textarea class="form-control" rows="3" readonly>
- Nghỉ hằng tuần: Thứ Bảy và Chủ nhật
- Nghỉ lễ, Tết: Theo quy định của Bộ Luật Lao động hiện hành
- Nghỉ phép năm: 12 ngày/năm</textarea>
                            </div>

                            <h5 class="section-title">V. CHẾ ĐỘ BẢO HIỂM XÃ HỘI</h5>
                            <div class="mb-3">
                                <label class="form-label">Các loại bảo hiểm:</label>
                                <textarea class="form-control" rows="3" readonly>
- Bảo hiểm xã hội
- Bảo hiểm y tế
- Bảo hiểm thất nghiệp
Theo quy định của pháp luật hiện hành</textarea>
                            </div>
                        </div>
                    </div>


                    <!-- Phần chữ ký ở cuối trang -->
                    <h5 class="section-title">VI. CHỮ KÝ XÁC NHẬN</h5>
                    <div class="row mb-4">
                        <div class="col-md-6 text-center">
                            <h6>NGƯỜI LAO ĐỘNG</h6>
                            <p><em>(Ký và ghi rõ họ tên)</em></p>
                            <div class="signature-area"></div>
                        </div>
                        <div class="col-md-6 text-center">
                            <h6>ĐẠI DIỆN BÊN SỬ DỤNG LAO ĐỘNG</h6>
                            <p><em>(Ký, ghi rõ họ tên và đóng dấu)</em></p>
                            <div class="signature-area">
                                <!-- Dấu đỏ của công ty -->

                                <svg
                                    class="signature-seal"
                                    viewBox="0 0 100 100"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <circle
                                        cx="50"
                                        cy="50"
                                        r="50"
                                        fill="rgba(255, 0, 0, 0.2)"
                                        stroke="red"
                                        stroke-width="2" />
                                    <circle
                                        cx="50"
                                        cy="50"
                                        r="35"
                                        fill="none"
                                        stroke="red"
                                        stroke-width="1" />
                                    <text
                                        x="50"
                                        y="45"
                                        text-anchor="middle"
                                        fill="red"
                                        font-size="12"
                                        font-weight="bold">
                                        CÔNG TY
                                    </text>
                                    <text
                                        x="50"
                                        y="60"
                                        text-anchor="middle"
                                        fill="red"
                                        font-size="12"
                                        font-weight="bold">
                                        DƯỢC PHẨM
                                    </text>
                                    <text
                                        x="50"
                                        y="75"
                                        text-anchor="middle"
                                        fill="red"
                                        font-size="12"
                                        font-weight="bold">
                                        SÂM NGỌC LINH
                                    </text>
                                </svg>

                            </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button
                    type="button"
                    class="btn btn-secondary"
                    data-bs-dismiss="modal">
                    Đóng
                </button>
                <button type="submit" class="btn btn-success" id="saveBtn">
                    Lưu hợp đồng
                </button>
                <button type="button" class="btn btn-primary" id="printBtn">
                    In hợp đồng
                </button>
            </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="FileAddModal" tabindex="-1" aria-labelledby="salaryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="salaryModalLabel">
                    THÊM NHÂN SỰ MỚI
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('Human.ManagerAdd') }}" method="POST">
                    @csrf
                    @method('POST')
                    <!-- Personal Information Section -->
                    <div class="mb-4">
                        <h6 class="border-bottom pb-2">Thông Tin Cá Nhân</h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="hoTen" class="form-label">Họ Tên</label>
                                <input type="text" class="form-control" name="HoTen" id="hoTen" />
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="gioiTinh" class="form-label">Giới Tính</label>
                                <select class="form-select" id="gioiTinh" name="GioiTinh">
                                    <option value="nam">Nam</option>
                                    <option value="nu">Nữ</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="ngaySinh" class="form-label">Ngày Sinh</label>
                                <input type="date" class="form-control" id="ngaySinh" name="NgaySinh" />
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="cccd" class="form-label">CCCD</label>
                                <input type="text" class="form-control" id="cccd" name="CCCD" />
                            </div>
                        </div>
                    </div>

                    <!-- Contact Information Section -->
                    <div class="mb-4">
                        <h6 class="border-bottom pb-2">Thông Tin Liên Hệ</h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="dienThoai" class="form-label">Điện Thoại</label>
                                <input type="tel" class="form-control" id="dienThoai" name="DienThoai" />
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="Email" />
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="diaChi" class="form-label">Địa Chỉ</label>
                            <textarea
                                name="DiaChi"
                                class="form-control"
                                id="diaChi"
                                rows="2"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="phongBan" class="form-label">Phòng Ban</label>
                            <select name="MaPhongBan" class="form-control" id="">
                                @foreach($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->TenPhongBan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Chức vụ</label>
                            <select name="MaChucVu" id="" class="form-control">
                                @foreach($positions as $position)
                                <option value="{{ $position->id }}">{{ $position->TenChucVu }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Additional Information Section -->

            </div>
            <div class="modal-footer">
                <button
                    type="button"
                    class="btn btn-secondary"
                    data-bs-dismiss="modal">
                    Đóng
                </button>
                <button type="submit" class="btn btn-primary">Lưu</button>
            </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <form class="modal-dialog" method="POST" id="deleteForm" action="">
        @csrf
        @method('DELETE')
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Xác nhận xóa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Bạn có chắc chắn muốn xóa hợp đồng của nhân viên này không?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <input type="submit" class="btn btn-danger" id="deleteBtn" value="Xóa">
            </div>
        </div>
    </form>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const viewButtons = document.querySelectorAll(".view-profile");
        viewButtons.forEach(button => {
            button.addEventListener("click", function() {
                // Lấy dữ liệu từ data-* attributes

                const employeeName = button.getAttribute("data-name");
                const employeeGender = button.getAttribute("data-gioitinh");
                const employeeBirthday = button.getAttribute("data-ngaySinh");
                const employeeId = button.getAttribute("data-cccd");
                const employeePhone = button.getAttribute("data-dienThoai");
                const employeeAddress = button.getAttribute("data-diachi");
                const employeeEmail = button.getAttribute("data-email");
                const idFile = button.getAttribute("data-id");
                const jobPosition = button.getAttribute("data-position");
                const department = button.getAttribute("data-deparment");
                const typeContract = button.getAttribute("data-typeContract");
                const startDate = button.getAttribute("data-startDate");
                const EndDate = button.getAttribute("data-EndDate");
                const signDate = button.getAttribute("data-signDate");
                const baseSalary = button.getAttribute("data-baseSalary");
                const content = button.getAttribute("data-content");
                const viewForm = document.getElementById("ViewForm");
                const bankAccount = button.getAttribute("data-bankAccount");
                const MaPhongBan = button.getAttribute("data-MaPhongBan");
                const MaChucVu = button.getAttribute("data-MaChucVu");
                // Gán dữ liệu vào các input trong modal
                document.getElementById("employeeName").value = employeeName;
                if (["Nam", "Nữ"].includes(gioiTinh)) {
                    document.getElementById("employeeGender").value = gioiTinh;

                }
                document.getElementById("employeeBirthday").value = employeeBirthday;
                document.getElementById("employeeId").value = employeeId;
                document.getElementById("employeePhone").value = employeePhone;
                document.getElementById("employeeAddress").value = employeeAddress;
                document.getElementById("employeeEmail").value = employeeEmail;
                document.getElementById("jobPosition").value = jobPosition;
                document.getElementById("department").value = department;
                document.getElementById("bankAccount").value = bankAccount;
                document.getElementById("typeContract").value = typeContract;
                document.getElementById("startDate").value = startDate;
                document.getElementById("endDate").value = EndDate;
                document.getElementById("signDate").value = signDate;
                document.getElementById("baseSalary").value = baseSalary;
                document.getElementById("content").value = content;
                viewForm.action = `/ManagerHM/${idFile}`;
                document.getElementById("department").value = MaPhongBan;
                document.getElementById("jobPosition").value = MaChucVu;
            });
        });
    });
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>