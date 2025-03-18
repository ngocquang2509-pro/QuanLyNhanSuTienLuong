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

    .contract-header {
        text-align: center;
        margin-bottom: 20px;
    }

    .contract-title {
        font-weight: bold;
        text-align: center;
        margin: 20px 0;
    }

    .signature-section {
        margin-top: 30px;
    }

    .contract-number {
        text-align: center;
        font-style: italic;
        margin-bottom: 15px;
    }

    .contract-date {
        text-align: center;
        margin-bottom: 20px;
    }

    .section-title {
        font-weight: bold;
        margin-top: 15px;
    }

    .indent {
        padding-left: 20px;
    }

    .divider {
        text-align: center;
        margin: 10px 0;
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
                    <th>Hành động</th>
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
                            data-id="{{ $employee->hopDong->id }}"
                            data-name="{{$employee->HoTen}}"

                            data-ngaySinh="{{$employee->NgaySinh}}"
                            data-cccd="{{$employee->CCCD}}"
                            data-dienThoai="{{$employee->DienThoai}}"
                            data-diachi="{{$employee->DiaChi}}"
                            data-position="{{$employee->chucVu->TenChucVu}}"
                            data-deparment="{{$employee->phongBan->TenPhongBan}}"
                            data-bankAccount="{{$employee->hopDong->TaiKhoan}}"
                            data-typeContract="{{$employee->hopDong->LoaiHopDong}}"
                            data-startDate="{{$employee->hopDong->ngay_bat_dau}}"
                            data-endDate="{{$employee->hopDong->ngay_ket_thuc}}"
                            data-signDate="{{$employee->hopDong->ngay_ky}}"
                            data-baseSalary="{{$employee->chucVu->LuongCoBan}}"
                            data-bs-toggle="modal"
                            data-bs-target="#ViewContractModel">
                            <i class="fa-solid fa-eye"></i>
                        </button>
                        @else
                        <button class="btn btn-primary d-flex align-items-center justify-content-center mx-auto file-add"
                            style=" width: 32px; height: 32px;" type="button"
                            data-id="{{ $employee->id }}"
                            data-name="{{$employee->HoTen}}"
                            data-gioitinh="{{$employee->GioiTinh}}"
                            data-ngaySinh="{{$employee->NgaySinh}}"
                            data-dienThoai="{{$employee->DienThoai}}"
                            data-cccd="{{$employee->CCCD}}"
                            data-diachi="{{$employee->DiaChi}}"
                            data-email="{{$employee->Email}}"
                            data-position="{{$employee->chucVu->TenChucVu}}"
                            data-deparment="{{$employee->phongBan->TenPhongBan}}"


                            data-bs-toggle="modal"
                            data-bs-target="#contractModalADD">
                            <i class="fa-solid fa-plus"></i>
                        </button>
                        @endif
                    </td>
                    <td class="text-center align-middle">
                        <button class="btn btn-warning mx-2 editBtnEmployee "
                            data-id="{{ $employee->id }}"
                            data-name="{{$employee->HoTen}}"
                            data-gioitinh="{{$employee->GioiTinh}}"
                            data-ngaysinh="{{$employee->NgaySinh}}"
                            data-dienthoai="{{$employee->DienThoai}}"
                            data-cccd="{{$employee->CCCD}}"
                            data-diachi="{{$employee->DiaChi}}"
                            data-email="{{$employee->Email}}"
                            data-phongban="{{$employee->phongBan->id}}"
                            data-chucvu="{{$employee->chucVu->id}}"
                            data-bs-toggle="modal" data-bs-target="#employeeModalEdit"><i class="fa-solid fa-pen"></i></button>
                        <button class="btn btn-danger mx-2 deleteBtnEmployee"
                            data-id="{{ $employee->id }}"
                            data-bs-toggle="modal" data-bs-target="#deleteEmployeeModal"><i class="fa-solid fa-trash"></i></button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="modal fade" id="contractModalADD" tabindex="-1" aria-labelledby="contractModalLabel" aria-hidden="true">
    <form class="modal-dialog modal-xl modal-dialog-scrollable" method="POST" action="{{ route('Human.FileAdd') }}">
        @csrf
        @method('POST')
        <input type="text" name="nhanvien_id" id="employeeID" hidden>
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="contractModalLabel"></h5>
                <button style="color: #fff;" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="contract-header d-flex justify-content-between align-items-center">
                    <div>
                        <img src="https://online.itehcmc.travel/wp-content/uploads/2022/09/LOGO-9.png" alt="Logo công ty" class="company-logo" />
                    </div>
                    <div class="text-end">
                        <h4>CÔNG TY TNHH DƯỢC PHẨM SÂM NGỌC LINH</h4>
                        <p class="mb-0">Số: <span id="contractNumber">HD-2025/.....</span></p>
                    </div>
                </div>

                <div class="text-center mb-4">
                    <h3>THÔNG TIN TẠO HỢP ĐỒNG LAO ĐỘNG</h3>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="employeeName" class="form-label">Họ và tên:</label>
                        <input type="text" class="form-control" id="employeeName" readonly />
                    </div>
                    <div class="col-md-6">
                        <label for="employeeGender" class="form-label">Giới tính:</label>
                        <input type="text" class="form-control" id="employeeGender" readonly />
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="employeeBirthday" class="form-label">Ngày sinh:</label>
                        <input type="date" class="form-control" id="employeeBirthday" readonly />
                    </div>
                    <div class="col-md-6">
                        <label for="employeePhone" class="form-label">Số điện thoại:</label>
                        <input type="text" class="form-control" id="employeePhone" readonly />
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="employeeCCCD" class="form-label">CCCD:</label>
                        <input type="text" class="form-control" id="employeeCCCD" readonly />
                    </div>
                    <div class="col-md-6">
                        <label for="employeeEmail" class="form-label">Email:</label>
                        <input type="email" class="form-control" id="employeeEmail" readonly />
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="employeeDepartment" class="form-label">Phòng ban:</label>
                        <input type="text" class="form-control" id="employeeDepartment" readonly />
                    </div>
                    <div class="col-md-6">
                        <label for="employeePosition" class="form-label">Chức vụ:</label>
                        <input type="text" class="form-control" id="employeePosition" readonly />
                    </div>
                </div>

                <div class="form-group mt-3">
                    <label class="form-label">Loại hợp đồng:</label>
                    <select class="form-control" name="LoaiHopDong">
                        <option value="Chính thức">Hợp đồng chính thức</option>
                        <option value="Thời vụ">Hợp đồng thời vụ</option>
                    </select>
                </div>

                <div class="row mt-3">
                    <div class="col-md-4">
                        <label for="ngay_ky" class="form-label">Ngày ký:</label>
                        <input type="date" class="form-control" id="ngay_ky" name="ngay_ky">
                    </div>
                    <div class="col-md-4">
                        <label for="ngay_bat_dau" class="form-label">Ngày bắt đầu:</label>
                        <input type="date" class="form-control" id="ngay_bat_dau" name="ngay_bat_dau">
                    </div>
                    <div class="col-md-4">
                        <label for="ngay_ket_thuc" class="form-label">Ngày kết thúc:</label>
                        <input type="date" class="form-control" id="ngay_ket_thuc" name="ngay_ket_thuc">
                    </div>
                </div>

                <div class="row mb-3 mt-3">
                    <div class="col-md-6">
                        <label class="form-label">Tài khoản:</label>
                        <input name="TaiKhoan" type="text" class="form-control" />
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Số người phụ thuộc:</label>
                        <input type="number" class="form-control" name="NPT" />
                    </div>
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <button type="submit" class="btn btn-primary" id="printBtn">Thêm hợp đồng</button>
            </div>
        </div>
    </form>
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
<div class="modal fade" id="employeeModalEdit" tabindex="-1" aria-labelledby="salaryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="salaryModalLabel">
                    SỬA THÔNG TIN NHÂN SỰ
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" id="editEmployeeForm" method="POST">
                    @csrf
                    @method('PUT')
                    <!-- Personal Information Section -->
                    <div class="mb-4">
                        <h6 class="border-bottom pb-2">Thông Tin Cá Nhân</h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="hoTen" class="form-label">Họ Tên</label>
                                <input type="text" class="form-control" name="HoTen" id="employeeNameEdit" />
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="gioiTinh" class="form-label">Giới Tính</label>
                                <select class="form-select" id="employeeGenderEdit" name="GioiTinh">
                                    <option value="Nam">Nam</option>
                                    <option value="Nữ">Nữ</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="ngaySinh" class="form-label">Ngày Sinh</label>
                                <input type="date" class="form-control" id="employeeBirthdayEdit" name="NgaySinh" />
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="cccd" class="form-label">CCCD</label>
                                <input type="text" class="form-control" id="employeeCCCDEdit" name="CCCD" />
                            </div>
                        </div>
                    </div>

                    <!-- Contact Information Section -->
                    <div class="mb-4">
                        <h6 class="border-bottom pb-2">Thông Tin Liên Hệ</h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="dienThoai" class="form-label">Điện Thoại</label>
                                <input type="tel" class="form-control" id="employeePhoneEdit" name="DienThoai" />
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="employeeEmailEdit" name="Email" />
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="diaChi" class="form-label">Địa Chỉ</label>
                            <textarea
                                name="DiaChi"
                                class="form-control"
                                id="employeeAddressEdit"
                                rows="2"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="phongBan" class="form-label">Phòng Ban</label>
                            <select name="MaPhongBan" class="form-control" id="employeeDepartmentEdit">
                                @foreach($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->TenPhongBan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Chức vụ</label>
                            <select name="MaChucVu" id="employeePositionEdit" class="form-control">
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
<div class="modal fade" id="deleteEmployeeModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <form class="modal-dialog" method="POST" id="deleteFormEmployee" action="">
        @csrf
        @method('DELETE')
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Xác nhận xóa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <h3 class="modal-body text-danger">
                Bạn có muốn xóa nhân viên này không?
            </h3>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <input type="submit" class="btn btn-danger" id="deleteBtn" value="Xóa">
            </div>
        </div>
    </form>
</div>
<div class="modal fade" id="deleteContractModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <form class="modal-dialog" method="POST" id="deleteFormContract" action="">
        @csrf
        @method('DELETE')
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Xác nhận xóa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <h3 class="modal-body text-danger">
                Bạn có muốn xóa hợp đồng này không?
            </h3>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <input type="submit" class="btn btn-danger" id="deleteBtn" value="Xóa">
            </div>
        </div>
    </form>
</div>
<div class="modal fade" id="ViewContractModel" tabindex="-1" aria-labelledby="salaryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="salaryModalLabel">
                    HỢP ĐỒNG LAO ĐỘNG
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="">
                    <div class="card">
                        <div class="card-body">
                            <div class="contract-header">
                                <h5 class="mb-0">
                                    <strong>CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM</strong>
                                </h5>
                                <p>Độc lập - Tự do - Hạnh phúc</p>
                                <div class="divider">-----o0o-----</div>
                            </div>

                            <div class="contract-title">
                                <h4>HỢP ĐỒNG LAO ĐỘNG</h4>
                            </div>

                            <div class="contract-number">
                                <p>Số: HD-2025/0001</p>
                            </div>



                            <div class="row mb-4">


                                <div class="col-12 mb-4">
                                    <h6><strong>BÊN A: NGƯỜI SỬ DỤNG LAO ĐỘNG</strong></h6>
                                    <div class="indent">
                                        <p class="mb-1">• Tên đơn vị: Công ty TNHH Dược phẩm Sâm Ngọc Linh</p>
                                        <p class="mb-1">• Địa chỉ: Số 94 Vũ Phạm Hàm, Yên Hòa, Cầu Giấy, Hà Nội:</p>
                                        <p class="mb-1">• Điện thoại: 024 36 888 666</p>

                                        <p class="mb-1">• Đại diện bởi: Ông/Bà Trần Văn B</p>
                                        <p class="mb-1">• Chức vụ: Giám đốc</p>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <h6><strong>BÊN B: NGƯỜI LAO ĐỘNG</strong></h6>
                                    <div class="indent">
                                        <p class="mb-1">• Ông/Bà:<span id="nameContract"> Nguyễn Văn A</span></p>
                                        <p class="mb-1">
                                            • CCCD/CMND số: <span id="CCCDContract">012345678901</span>
                                        </p>
                                        <p class="mb-1">
                                            • Địa chỉ thường trú: <span id="addressContract">jkdjfksdjf</span>
                                        </p>
                                        <p class="mb-1">• Điện thoại: <span id="phoneContract">99813923082123</span></p>
                                        <p class="mb-1">• Ngày sinh: <span id="birthdayContract ">2001-02-25</span></p>
                                    </div>
                                </div>
                            </div>

                            <p>
                                Sau khi thỏa thuận, hai bên thống nhất ký kết Hợp đồng lao động với
                                các điều khoản sau:
                            </p>

                            <div class="mb-3">
                                <h6 class="section-title">
                                    ĐIỀU 1: THỜI HẠN VÀ CÔNG VIỆC HỢP ĐỒNG
                                </h6>
                                <div class="indent">
                                    <p class="mb-1">
                                        1. Loại hợp đồng lao động: <span id="typeContract">Chính thức </span>
                                    </p>
                                    <p class="mb-1">
                                        2. Ký ngày: <span id="dateSignContract">727372</span>
                                    </p>
                                    <p class="mb-1">
                                        3. Ngày bắt đầu làm: <span id="dateStartContract">727372</span>
                                    </p>
                                    <p class="mb-1">
                                        4. Thời hạn hợp đồng: <span id="timeContract">727372</span>
                                    </p>
                                    <p class="mb-1">5. Địa điểm làm việc: Trụ sở chính của công ty</p>
                                    <p class="mb-1">6. Chức danh công việc: <span id="positionContract">Nhân viên</span></p>
                                    <p class="mb-1">7. Thuộc phòng ban: <span id="departmentContract">Hành chính</span></p>
                                    <p class="mb-1">
                                        8. Nhiệm vụ công việc: Thực hiện các công việc theo yêu cầu của
                                        quản lý trực tiếp và mô tả công việc đính kèm.
                                    </p>
                                </div>
                            </div>

                            <div class="mb-3">
                                <h6 class="section-title">ĐIỀU 2: CHẾ ĐỘ LÀM VIỆC</h6>
                                <div class="indent">
                                    <p class="mb-1">1. Thời gian làm việc: 8 giờ/ngày, 40 giờ/tuần</p>
                                    <p class="mb-1">
                                        2. Được cấp phát những dụng cụ làm việc gồm: Máy tính, bàn làm
                                        việc và các trang thiết bị cần thiết khác.
                                    </p>
                                </div>
                            </div>

                            <div class="mb-3">
                                <h6 class="section-title">
                                    ĐIỀU 3: NGHĨA VỤ VÀ QUYỀN LỢI CỦA NGƯỜI LAO ĐỘNG
                                </h6>
                                <div class="indent">
                                    <p class="mb-1"><strong>1. Quyền lợi:</strong></p>
                                    <div class="indent">
                                        <p class="mb-1">• Tiền lương cơ bản: <span id="baseSalaryContract">10,000,000 VNĐ/tháng</span></p>
                                        <p class="mb-1">• Hình thức trả lương: Chuyển khoản</p>
                                        <p class="mb-1">• Được trả lương vào ngày 10 hàng tháng</p>
                                        <p class="mb-1">• Tài khoản được công ty cấp: <span id="bankContract">89324723984</span></p>
                                        <p class="mb-1">• Phụ cấp: Theo quy định của công ty</p>
                                        <p class="mb-1">
                                            • Được hưởng các chế độ nâng lương theo quy định của Công ty
                                        </p>
                                        <p class="mb-1">• Tiền thưởng: Theo quy định của Công ty</p>
                                        <p class="mb-1">
                                            • Chế độ nghỉ ngơi: Nghỉ hàng tuần (thứ bảy, chủ nhật), nghỉ
                                            lễ, nghỉ phép, nghỉ việc riêng theo quy định của Bộ Luật Lao
                                            động
                                        </p>
                                        <p class="mb-1">
                                            • Bảo hiểm xã hội, bảo hiểm y tế: Theo quy định hiện hành của
                                            Nhà nước
                                        </p>
                                        <p class="mb-1">
                                            • Chế độ đào tạo: Theo nhu cầu công việc và quy định của Công
                                            ty
                                        </p>
                                    </div>
                                    <p class="mb-1 mt-2"><strong>2. Nghĩa vụ:</strong></p>
                                    <div class="indent">
                                        <p class="mb-1">
                                            • Hoàn thành công việc đúng chất lượng, số lượng và thời hạn
                                            được giao
                                        </p>
                                        <p class="mb-1">
                                            • Chấp hành nghiêm chỉnh nội quy lao động, an toàn lao động,
                                            vệ sinh lao động và các quy định khác của Công ty
                                        </p>
                                        <p class="mb-1">
                                            • Bồi thường vi phạm và vật chất theo quy định của Công ty và
                                            pháp luật
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <h6 class="section-title">
                                    ĐIỀU 4: NGHĨA VỤ VÀ QUYỀN HẠN CỦA NGƯỜI SỬ DỤNG LAO ĐỘNG
                                </h6>
                                <div class="indent">
                                    <p class="mb-1"><strong>1. Nghĩa vụ:</strong></p>
                                    <div class="indent">
                                        <p class="mb-1">
                                            • Bảo đảm việc làm và thực hiện đầy đủ các điều đã cam kết
                                            trong hợp đồng lao động
                                        </p>
                                        <p class="mb-1">
                                            • Thanh toán đầy đủ, đúng hạn các chế độ và quyền lợi cho
                                            người lao động theo hợp đồng lao động
                                        </p>
                                    </div>
                                    <p class="mb-1 mt-2"><strong>2. Quyền hạn:</strong></p>
                                    <div class="indent">
                                        <p class="mb-1">
                                            • Điều hành người lao động hoàn thành công việc theo hợp đồng
                                        </p>
                                        <p class="mb-1">
                                            • Có quyền khen thưởng và xử lý vi phạm kỷ luật lao động theo
                                            quy định của Công ty và phù hợp với pháp luật lao động
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <h6 class="section-title">ĐIỀU 5: ĐIỀU KHOẢN THI HÀNH</h6>
                                <div class="indent">
                                    <p class="mb-1">
                                        1. Những vấn đề về lao động không ghi trong hợp đồng lao động
                                        này thì áp dụng theo quy định của Bộ Luật Lao động, nội quy lao
                                        động và các quy định khác của Công ty
                                    </p>
                                    <p class="mb-1">
                                        2. Hợp đồng lao động được làm thành 02 bản có giá trị pháp lý
                                        như nhau, người sử dụng lao động giữ 01 bản, người lao động giữ
                                        01 bản
                                    </p>
                                    <p class="mb-1">3. Hợp đồng có hiệu lực kể từ ngày <span id="dateEffordContract">01/04/2025</span></p>
                                </div>
                            </div>

                            <div class="row signature-section">
                                <div class="col-6 text-center">
                                    <p><strong>NGƯỜI SỬ DỤNG LAO ĐỘNG</strong></p>
                                    <p><em>(Ký, ghi rõ họ tên và đóng dấu)</em></p>
                                    <p class="mt-5">Trần Văn B</p>
                                </div>
                                <div class="col-6 text-center">
                                    <p><strong>NGƯỜI LAO ĐỘNG</strong></p>
                                    <p><em>(Ký, ghi rõ họ tên)</em></p>
                                    <p class="mt-5" id="signPeopleContract"></p>
                                </div>
                            </div>
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
                <button class="btn btn-danger ClassBtnDeleteContract" id="deleteBtnContract" data-id=""
                    data-bs-toggle="modal" data-bs-target="#deleteContractModal">Xóa</button>
                <button type="submit" class="btn btn-primary">In hợp đồng</button>
            </div>
            </form>
        </div>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const viewButtons = document.querySelectorAll(".file-add");
        const viewContracts = document.querySelectorAll(".view-profile");
        const deleteEmployeeButtons = document.querySelectorAll(".deleteBtnEmployee");
        const editEmployeeButtons = document.querySelectorAll(".editBtnEmployee");
        const deleteContractButtons = document.querySelectorAll(".ClassBtnDeleteContract");
        viewButtons.forEach(button => {
            button.addEventListener("click", function() {
                // Lấy dữ liệu từ data-* attributes

                const employeeName = button.getAttribute("data-name");
                const employeeGender = button.getAttribute("data-gioitinh");
                const employeeBirthday = button.getAttribute("data-ngaySinh");
                const employeeCCCD = button.getAttribute("data-cccd");
                const employeePhone = button.getAttribute("data-dienThoai");
                const employeeEmail = button.getAttribute("data-email");
                const employeeId = button.getAttribute("data-id");
                const jobPosition = button.getAttribute("data-position");
                const department = button.getAttribute("data-deparment");
                console.log(employeeId);

                // Gán dữ liệu vào các input trong modal
                document.getElementById("employeeName").value = employeeName;
                document.getElementById("employeeGender").value = employeeGender;
                document.getElementById("employeeBirthday").value = employeeBirthday;
                document.getElementById("employeeCCCD").value = employeeCCCD;
                document.getElementById("employeePhone").value = employeePhone;

                document.getElementById("employeeEmail").value = employeeEmail;
                document.getElementById("employeePosition").value = jobPosition;
                document.getElementById("employeeDepartment").value = department;
                document.getElementById("employeeID").value = employeeId;


            });
        });
        viewContracts.forEach(button => {
            button.addEventListener("click", function() {
                // Lấy dữ liệu từ data-* attributes
                const employeeName = button.getAttribute("data-name");
                const employeeBirthday = button.getAttribute("data-ngaySinh");
                const employeeCCCD = button.getAttribute("data-cccd");
                const employeePhone = button.getAttribute("data-dienThoai");
                const employeeAddress = button.getAttribute("data-diachi");
                const jobPosition = button.getAttribute("data-position");
                const department = button.getAttribute("data-deparment");
                const bankAccount = button.getAttribute("data-bankAccount");
                const typeContract = button.getAttribute("data-typeContract");
                const startDate = button.getAttribute("data-startDate");
                const endDate = button.getAttribute("data-endDate");
                const signDate = button.getAttribute("data-signDate");
                const baseSalary = button.getAttribute("data-baseSalary");
                const contractID = button.getAttribute("data-id");

                // Gán dữ liệu vào các input trong modal
                document.getElementById("nameContract").innerText = employeeName;
                document.getElementById("CCCDContract").innerText = employeeCCCD;
                document.getElementById("addressContract").innerText = employeeAddress;
                document.getElementById("phoneContract").innerText = employeePhone;
                document.getElementById("positionContract").innerText = jobPosition;
                document.getElementById("departmentContract").innerText = department;
                document.getElementById("bankContract").innerText = bankAccount;
                document.getElementById("typeContract").innerText = typeContract;
                document.getElementById("dateSignContract").innerText = signDate;
                document.getElementById("dateStartContract").innerText = startDate;
                document.getElementById("timeContract").innerText = endDate;
                document.getElementById("baseSalaryContract").innerText = baseSalary;
                document.getElementById("signPeopleContract").innerText = employeeName;
                document.getElementById("dateEffordContract").innerText = signDate;
                document.getElementById("deleteBtnContract").setAttribute("data-id", contractID);

            });
        });

        deleteEmployeeButtons.forEach(button => {
            button.addEventListener("click", function() {
                // Lấy dữ liệu từ data-* attributes
                const form = document.getElementById("deleteFormEmployee");
                const id = button.getAttribute("data-id");
                form.action = `/ManagerHM/${id}`;
            });
        });
        editEmployeeButtons.forEach(button => {
            button.addEventListener("click", function() {
                // Lấy dữ liệu từ data-* attributes
                const id = button.getAttribute("data-id");
                const name = button.getAttribute("data-name");
                const gender = button.getAttribute("data-gioitinh");
                const birthday = button.getAttribute("data-ngaysinh");
                const cccd = button.getAttribute("data-cccd");
                const phone = button.getAttribute("data-dienthoai");
                const email = button.getAttribute("data-email");
                const address = button.getAttribute("data-diachi");
                const position = button.getAttribute("data-phongban");
                const department = button.getAttribute("data-chucvu");
                document.getElementById("employeeNameEdit").value = name;
                document.getElementById("employeeGenderEdit").value = gender;
                document.getElementById("employeeBirthdayEdit").value = birthday;
                document.getElementById("employeeCCCDEdit").value = cccd;
                document.getElementById("employeePhoneEdit").value = phone;
                document.getElementById("employeeEmailEdit").value = email;
                document.getElementById("employeeAddressEdit").value = address;
                document.getElementById("employeePositionEdit").value = position;
                document.getElementById("employeeDepartmentEdit").value = department;
                const form = document.getElementById("editEmployeeForm");
                form.action = `/ManagerHM/${id}`;
            });
        });
        deleteContractButtons.forEach(button => {
            button.addEventListener("click", function() {
                const id = button.getAttribute("data-id");
                const form = document.getElementById("deleteFormContract");
                form.action = `/ManagerHMContract/${id}`;


            });
        });
    });
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>