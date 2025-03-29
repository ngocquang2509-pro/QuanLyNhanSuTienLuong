<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
    .table-header {
        background-color: #f8f9fa;
        font-weight: bold;
    }

    .sub-header {
        background-color: #e9ecef;
    }

    .salary-table th,
    .salary-table td {
        font-size: 0.85rem;
        vertical-align: middle;
    }

    .department {
        background-color: #f1f3f5;
        font-weight: bold;
    }

    .action-btn {
        color: #0d6efd;
        cursor: pointer;
        padding: 5px;
        transition: color 0.2s;
    }

    .action-btn:hover {
        color: #0a58ca;
    }

    .tax-button {
        padding: 4px 8px;
        font-size: 0.8rem;
    }

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

    .tax-modal .modal-content {
        background: #f8f9fa;
        border: none;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    }

    .tax-modal .modal-header {
        background: linear-gradient(135deg, #20bf55 0%, #01baef 100%);
        color: white;
        border-radius: 20px 20px 0 0;
        padding: 1.5rem;
    }

    .tax-calculation-table {
        background: white;
        border-radius: 15px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        margin: 1rem 0;
    }

    .tax-calculation-table th {
        background: #e9ecef;
        border: none;
    }

    .tax-calculation-table td,
    .tax-calculation-table th {
        padding: 1rem;
        vertical-align: middle;
    }

    .tax-result {
        background: #e8f5e9;
        border-radius: 10px;
        padding: 1.5rem;
        margin-top: 1.5rem;
    }

    .tax-value {
        font-size: 1.2rem;
        font-weight: bold;
        color: #2e7d32;
    }

    /* Animation for tax modal */
    @keyframes slideIn {
        from {
            transform: translateY(-100px);
            opacity: 0;
        }

        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    .tax-modal.fade .modal-dialog {
        transform: translateY(-100px);
        opacity: 0;
        transition: all 0.3s ease-out;
    }

    .tax-modal.show .modal-dialog {
        transform: translateY(0);
        opacity: 1;
    }

    .tax-row {
        animation: slideIn 0.3s ease-out forwards;
    }

    .tax-row:nth-child(2) {
        animation-delay: 0.1s;
    }

    .tax-row:nth-child(3) {
        animation-delay: 0.2s;
    }

    .tax-row:nth-child(4) {
        animation-delay: 0.3s;
    }

    .tax-row:nth-child(5) {
        animation-delay: 0.4s;
    }

    .calculation-step {
        background: white;
        border-radius: 10px;
        padding: 1rem;
        margin-bottom: 1rem;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
    }

    .step-number {
        width: 30px;
        height: 30px;
        background: #20bf55;
        color: white;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-right: 10px;
    }
</style>
</head>

<body>
    <div class="container-fluid py-4 col-md-10 ">
        @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @elseif (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>


        @endif
        <form class="navbar px-5" action="{{route('Accounting.salaryAdd')}}" method="get">
            <h4 class=" mb-4">BẢNG LƯƠNG THÁNG {{ request()->get('month')?\Carbon\Carbon::parse(request('month'))->format('m/Y'): '01/2025' }}
            </h4>
            <div>
                <input name="month" type="month" class="form-control" value="{{ request()->get('month') }}"
                    placeholder="Nhập tháng" required>
                <button name="searchBtn" class="btn btn-primary" value="search ">Tìm kiếm</button>
                <button name="createBtn" class="btn btn-success" value="create">Tạo lương</button>
            </div>
        </form>
        <div class="table-responsive">
            <h6 class="m-3 text-danger"> Nhân viên chính thức</h6>
            <table class="table table-bordered table-hover salary-table" id="salaryTable">
                <thead>
                    <tr class="table-header text-center">
                        <th rowspan="2">Mã số NV</th>
                        <th rowspan="2">Họ tên</th>
                        <th rowspan="2">Chức vụ</th>
                        <th rowspan="2">Bộ phận</th>
                        <th colspan="4">LƯƠNG CB + PHỤ CẤP THEO HĐLĐ</th>
                        <th rowspan="2">Số ngày công</th>
                        <th rowspan="2">Khen thưởng - Kỷ luật</th>
                        <th rowspan="2">Tổng thu nhập</th>
                        <th colspan="3">BẢO HIỂM NHÂN VIÊN ĐÓNG</th>
                        <th rowspan="2">Thuế TNCN phải nộp</th>
                        <th rowspan="2">Lương thực lãnh</th>
                        <th rowspan="2">Tạm ứng</th>
                        <th rowspan="2">Còn lãnh</th>
                        <td rowspan="2">Phiếu lương</td>
                    </tr>
                    <tr class="table-header text-center">
                        <th>Lương CB</th>
                        <th>Hệ số lương</th>
                        <th>PC Chức vụ</th>
                        <th>PC Trách nhiệm</th>

                        <th>BHXH (8%)</th>
                        <th>BHYT (1.5%)</th>
                        <th>BHTN (1%)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($salaries->groupBy('PhongBan') as $phongBan => $salaries)
                    <tr>
                        <td colspan="7"><strong>Phòng: {{ $phongBan }}</strong></td>
                    </tr>
                    @foreach ($salaries as $salary)



                    <tr class="text-center">
                        <td>{{ $salary->id }}</td>
                        <td class="text-start">{{ $salary->HoTen }}</td>
                        <td>{{ $salary->ChucVu }}</td>
                        <td>{{ $salary->PhongBan }}</td>
                        <td>{{ number_format($salary->LuongCB) }}</td>
                        <td>{{ $salary->HSL }}</td>
                        <td>{{ number_format($salary->pc_chuc_vu) }}</td>
                        <td>{{ number_format($salary->pc_trach_nhiem) }}</td>
                        <td>{{ $salary->SoNgayCong }}</td>
                        <td>{{ $salary->KTKL }}</td>
                        <td>
                            {{ number_format(($salary->TongThuNhap)) }}
                        </td>
                        <td>{{ number_format($salary->bhxh) }}</td>
                        <td>{{ number_format($salary->bhyt) }}</td>
                        <td>{{ number_format($salary->bhtn) }}</td>

                        <td>

                            <span>{{number_format($salary->thue_tncn)}}</span>
                            <button class="btn btn-primary btn-sm tax-button ms-2 taxCalculation"
                                data-bs-toggle="modal" data-bs-target="#taxCalculationModal"
                                data-id="{{$salary->id}}" data-hoten="{{$salary->HoTen}}"
                                data-position="{{$salary->ChucVu}}"
                                data-department="{{$salary->PhongBan}}"
                                data-luongcoban="{{number_format($salary->LuongCB)}}"
                                data-ngaycong="{{$salary->SoNgayCong}}"
                                data-phucap="{{number_format($salary->pc_chuc_vu+$salary->pc_trach_nhiem)}}"
                                data-TongThuNhap="{{number_format($salary->TongThuNhap)}}"
                                data-bhxh="{{number_format($salary->bhxh)}}" data-bhyt="{{number_format($salary->bhyt)}}"
                                data-bhtn="{{number_format($salary->bhtn)}}"
                                data-NPT=" {{number_format($salary->NPT*4400000)}}"
                                data-TongGiamTru="{{number_format($salary->bhxh + $salary->bhyt + $salary->bhtn+11000000+$salary->NPT*4400000)}}"
                                data-TNTT="{{number_format($salary->TongThuNhap-($salary->bhxh + $salary->bhyt + $salary->bhtn+11000000+$salary->NPT*4400000))}}"
                                data-TNTTtypeNumber="{{($salary->TongThuNhap-($salary->bhxh + $salary->bhyt + $salary->bhtn+11000000+$salary->NPT*4400000))}}"
                                data-TNCN="{{number_format($salary->thue_tncn)}}">
                                <i class="fas fa-calculator"></i> Tính thuế
                            </button>


                        </td>
                        <td>{{number_format($salary->luong_thuc_lanh)}}</td>
                        <td>{{number_format(2000000)}}</td>
                        <td>{{number_format($salary->luong_thuc_lanh-2000000)}}</td>
                        <td> <button class="btn btn-primary phieuChiBTN" data-bs-toggle="modal" data-bs-target="#phieuLuongModal" data-name="{{$salary->HoTen}}"
                                data-id="{{$salary->id}}"
                                data-position="{{$salary->ChucVu}}"
                                data-department="{{$salary->PhongBan}}"
                                data-luongcoban="{{number_format($salary->LuongCB)}}"
                                data-HSL="{{$salary->HSL}}"
                                data-ngaycong="{{$salary->SoNgayCong}}"
                                data-PCCV="{{number_format($salary->pc_chuc_vu)}}"
                                data-PCTN="{{number_format($salary->pc_trach_nhiem)}}"
                                data-KTKL="{{number_format($salary->KTKL)}}"
                                data-TongThuNhap="{{number_format($salary->TongThuNhap)}}"
                                data-bhxh="{{number_format($salary->bhxh)}}"
                                data-bhyt="{{number_format($salary->bhyt)}}"
                                data-bhtn="{{number_format($salary->bhtn)}}"
                                data-TongBH="{{number_format($salary->bhxh + $salary->bhyt + $salary->bhtn)}}"
                                data-TNTT="{{number_format($salary->thue_tncn)}}"
                                data-luongthucnhan="{{number_format($salary->luong_thuc_lanh)}}"
                                data-conlanh="{{number_format($salary->con_lanh)}}"><i class="fas fa-eye"></i></button></td>

                    </tr>

                    @endforeach
                    @endforeach

                </tbody>
            </table>
            <h6 class="m-3 text-danger"> Nhân viên thời vụ</h6>
            <table class="table table-bordered table-hover salary-table" id="salaryTable">
                <thead>
                    <th>Mã số NV</th>
                    <th>Họ tên</th>
                    <th>Chức vụ</th>
                    <th>Bộ phận</th>
                    <th>Số giờ làm việc</th>
                    <th>Lương giờ</th>
                    <th>Tổng thu nhập</th>
                    <th>Phiếu lương</th>
                </thead>

                <tbody>
                    @foreach ($salariesThoiVu->groupBy('PhongBan') as $phongBan => $salaries)
                    <tr>
                        <td colspan="7"><strong>Phòng: {{ $phongBan }}</strong></td>
                    </tr>
                    @foreach ($salaries as $salary)
                    <tr>
                        <td>{{ $salary->id }}</td>
                        <td>{{ $salary->HoTen }}</td>
                        <td>{{ $salary->ChucVu }}</td>
                        <td>{{ $salary->PhongBan }}</td>
                        <td>{{ $salary->SoNgayCong }}</td>
                        <td>{{ number_format($salary->LuongTheoGio) }}</td>
                        <td>{{ number_format($salary->TongThuNhap) }}</td>
                        <td> <button class="btn btn-primary phieuChiBTN" data-bs-toggle="modal" data-bs-target="#phieuLuongModal" data-name="{{$salary->HoTen}}"
                                data-id="{{$salary->id}}"
                                data-position="{{$salary->ChucVu}}"
                                data-department="{{$salary->PhongBan}}"
                                data-luongcoban="{{number_format($salary->LuongCB)}}"
                                data-HSL="{{$salary->HSL}}"
                                data-ngaycong="{{$salary->SoNgayCong}}"
                                data-PCCV="{{number_format($salary->pc_chuc_vu)}}"
                                data-PCTN="{{number_format($salary->pc_trach_nhiem)}}"
                                data-KTKL="{{number_format($salary->KTKL)}}"
                                data-TongThuNhap="{{number_format($salary->TongThuNhap)}}"
                                data-bhxh="{{number_format($salary->bhxh)}}"
                                data-bhyt="{{number_format($salary->bhyt)}}"
                                data-bhtn="{{number_format($salary->bhtn)}}"
                                data-TongBH="{{number_format($salary->bhxh + $salary->bhyt + $salary->bhtn)}}"
                                data-TNTT="{{number_format($salary->thue_tncn)}}"
                                data-luongthucnhan="{{number_format($salary->luong_thuc_lanh)}}"
                                data-conlanh="{{number_format($salary->con_lanh)}}"><i class="fas fa-eye"></i></button></td>
                    </tr>
                    @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>

    <div class="modal fade" id="taxCalculationModal" tabindex="-1" aria-labelledby="salaryModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-calculator me-2"></i>
                        Bảng Tính Thuế Thu Nhập Cá Nhân
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="salarythoivu-info mb-4">
                        <h6 class="text-muted mb-3">Thông tin nhân viên</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Họ và tên:</strong> <span id="HoTen">Nguyễn Văn A</span></p>
                                <p><strong>Mã số NV:</strong> <span id="MaNV">NV-001</span></p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Chức vụ:</strong> <span id="ChucVu">Trưởng phòng</span></p>
                                <p><strong>Phòng ban:</strong> <span id="PhongBan">Hành chính</span></p>
                            </div>
                        </div>
                    </div>

                    <div class="calculation-steps">
                        <div class="calculation-step tax-row">
                            <div class="step-number">1</div>
                            <h6 class="d-inline-block mb-3">Thu nhập chịu thuế</h6>
                            <table class="table tax-calculation-table">
                                <thead>
                                    <tr>
                                        <th>Khoản thu nhập</th>
                                        <th class="text-end">Số tiền</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Lương cơ bản</td>
                                        <td class="text-end" id="LuongCoBan">10,000,000</td>
                                    </tr>
                                    <tr>
                                        <td>Số ngày công</td>
                                        <td class="text-end" id="NgayCong">1,500,000</td>
                                    </tr>
                                    <tr>
                                        <td>Phụ cấp</td>
                                        <td class="text-end" id="PhuCap">3,800,000</td>
                                    </tr>

                                    <tr class="table-info">
                                        <td><strong>Tổng thu nhập</strong></td>
                                        <td class="text-end" id="TongThuNhap"><strong>15,300,000</strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="calculation-step tax-row">
                            <div class="step-number">2</div>
                            <h6 class="d-inline-block mb-3">Các khoản giảm trừ</h6>
                            <table class="table tax-calculation-table">
                                <tbody>
                                    <tr>
                                        <td>Bảo hiểm xã hội (8%)</td>
                                        <td class="text-end"><span id="BHXH">800,000</span></td>
                                    </tr>
                                    <tr>
                                        <td>Bảo hiểm y tế (1.5%)</td>
                                        <td class="text-end" id="BHYT">150,000</td>
                                    </tr>
                                    <tr>
                                        <td>Bảo hiểm thất nghiệp (1%)</td>
                                        <td class="text-end" id="BHTT">100,000</td>
                                    </tr>
                                    <tr>
                                        <td>Giảm trừ gia cảnh</td>
                                        <td class="text-end">11,000,000</td>
                                    </tr>
                                    <tr>
                                        <td>Người phụ thuộc</td>
                                        <td class="text-end" id="NPT">4,400,000</td>
                                    </tr>
                                    <tr class="table-info">
                                        <td><strong>Tổng giảm trừ</strong></td>
                                        <td class="text-end" id="TongGiamTru"><strong>2,050,000</strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="calculation-step tax-row">
                            <div class="step-number">3</div>
                            <h6 class="d-inline-block mb-3">Thu nhập tính thuế</h6>
                            <table class="table tax-calculation-table">
                                <tbody>
                                    <tr>
                                        <td>Thu nhập tính thuế</td>
                                        <td class="text-end" id="TNTT">13,800,000</td>
                                    </tr>
                                    <tr>
                                        <td>Bậc thuế áp dụng</td>
                                        <td class="text-end" id="BacThue">3 (15%)</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="tax-result tax-row">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h6 class="mb-0">Thuế TNCN phải nộp:</h6>
                                    <small class="text-muted">Đã tính theo biểu thuế lũy tiến từng phần</small>
                                </div>
                                <div class="col-auto">
                                    <span class="tax-value"><span id="TNCN">600,000</span> VNĐ</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary">
                        <i class="fas fa-download me-2"></i>Xuất báo cáo
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="phieuLuongModal" tabindex="-1" aria-labelledby="salaryModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-calculator me-2"></i>
                        Phiếu chi lương của nhân viên
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="salarythoivu-info mb-4">
                        <h6 class="text-muted mb-3">Thông tin nhân viên</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Họ và tên:</strong> <span id="salaryName">Nguyễn Văn A</span></p>
                                <p><strong>Mã số NV:</strong> <span id="salaryMa">NV-001</span></p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Chức vụ:</strong> <span id="salaryPosition">Trưởng phòng</span></p>
                                <p><strong>Phòng ban:</strong> <span id="salaryDepartment">Hành chính</span></p>
                            </div>
                        </div>
                    </div>

                    <div class="calculation-steps">
                        <div class="calculation-step tax-row">
                            <div class="step-number">1</div>
                            <h6 class="d-inline-block mb-3">Tổng thu nhập</h6>
                            <table class="table tax-calculation-table">
                                <thead>
                                    <tr>
                                        <th>Khoản thu nhập</th>
                                        <th class="text-end">Số tiền</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Lương cơ bản</td>
                                        <td class="text-end" id="salaryLuongCB">10,000,000</td>
                                    </tr>
                                    <tr>
                                        <td>Hệ số lương</td>
                                        <td class="text-end" id="salaryHSL">1,500,000</td>
                                    </tr>
                                    <tr>
                                        <td>Số ngày công</td>
                                        <td class="text-end" id="salaryCong">1,500,000</td>
                                    </tr>
                                    <tr>
                                        <td>Phụ cấp chức vụ</td>
                                        <td class="text-end" id="salaryPhuCapCV">3,800,000</td>
                                    </tr>

                                    <tr>
                                        <td>Phụ cấp trách nhiệm</td>
                                        <td class="text-end" id="salaryPhuCapTN">3,800,000</td>
                                    </tr>
                                    <tr>
                                        <td>Khen thưởng kỷ luật</td>
                                        <td class="text-end" id="salaryKTKL">3,800,000</td>
                                    </tr>
                                    <tr class="table-info">
                                        <td><strong>Tổng thu nhập</strong></td>
                                        <td class="text-end" id="salaryTongThuNhap"><strong>15,300,000</strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="calculation-step tax-row">
                            <div class="step-number">2</div>
                            <h6 class="d-inline-block mb-3">Bảo hiểm nhân viên</h6>
                            <table class="table tax-calculation-table">
                                <tbody>
                                    <tr>
                                        <td>Bảo hiểm xã hội (8%)</td>
                                        <td class="text-end"><span id="salaryBHXH">800,000</span></td>
                                    </tr>
                                    <tr>
                                        <td>Bảo hiểm y tế (1.5%)</td>
                                        <td class="text-end" id="salaryBHYT">150,000</td>
                                    </tr>
                                    <tr>
                                        <td>Bảo hiểm thất nghiệp (1%)</td>
                                        <td class="text-end" id="salaryBHTT">100,000</td>
                                    </tr>
                                    <tr class="table-info">
                                        <td><strong>Tổng bảo hiểm</strong></td>
                                        <td class="text-end" id="salaryBH"><strong>2,050,000</strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="calculation-step tax-row">

                            <table class="table tax-calculation-table">
                                <tbody>
                                    <tr>
                                        <td>Thuế TNCN phải nộp</td>
                                        <td class="text-end" id="salaryTNTT">13,800,000</td>
                                    </tr>
                                    <tr>
                                        <td>Lương thực lãnh</td>
                                        <td class="text-end" id="salaryThucLanh">3 (15%)</td>
                                    </tr>
                                    <tr>
                                        <td>Lương tạm ứng</td>
                                        <td class="text-end" id="">2,000,000</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="tax-result tax-row">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h6 class="mb-0">Còn lãnh:</h6>
                                </div>
                                <div class="col-auto">
                                    <span class="tax-value"><span id="salaryConLanh">600,000</span> VNĐ</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary">
                        <i class="fas fa-download me-2"></i>Xuất báo cáo
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const viewButtons = document.querySelectorAll(".taxCalculation");
            const phieuChiButtons = document.querySelectorAll(".phieuChiBTN");
            viewButtons.forEach(button => {
                button.addEventListener("click", function() {
                    const MaNV = button.getAttribute("data-id");
                    const HoTen = button.getAttribute("data-hoten");
                    const ChucVu = button.getAttribute("data-position");
                    const PhongBan = button.getAttribute("data-department");
                    const LuongCoBan = button.getAttribute("data-luongcoban");
                    const NgayCong = button.getAttribute("data-ngaycong");
                    const PhuCap = button.getAttribute("data-phucap");
                    const TongThuNhap = button.getAttribute("data-TongThuNhap");
                    const BHXH = button.getAttribute("data-bhxh");

                    const BHYT = button.getAttribute("data-bhyt");
                    const BHTN = button.getAttribute("data-bhtn");
                    const NPT = button.getAttribute("data-NPT");

                    const TongGiamTru = button.getAttribute("data-TongGiamTru");
                    const TNTT = button.getAttribute("data-TNTT");
                    const TNCN = button.getAttribute("data-TNCN");
                    document.getElementById("MaNV").innerText = MaNV;
                    document.getElementById("HoTen").innerText = HoTen;
                    document.getElementById("ChucVu").innerText = ChucVu;
                    document.getElementById("PhongBan").innerText = PhongBan;
                    document.getElementById("LuongCoBan").innerText = LuongCoBan;
                    document.getElementById("NgayCong").innerText = NgayCong;
                    document.getElementById("PhuCap").innerText = PhuCap;
                    document.getElementById("TongThuNhap").innerText = TongThuNhap;
                    document.getElementById("BHXH").innerText = BHXH;
                    document.getElementById("BHYT").innerText = BHYT;
                    document.getElementById("BHTT").innerText = BHTN;
                    document.getElementById("NPT").innerText = NPT;
                    document.getElementById("TongGiamTru").innerText = TongGiamTru;
                    document.getElementById("TNTT").innerText = TNTT;
                    document.getElementById("TNCN").innerText = TNCN;
                    const TNTTtypeNumber = (button.getAttribute("data-TNTTtypeNumber"));

                    let bac;
                    switch (true) {
                        case (TNTTtypeNumber <= 5000000):
                            bac = "1 (5% x TNTT)";
                            break;
                        case (TNTTtypeNumber <= 10000000):
                            bac = "2 (10% x TNTT - 250,000)";
                            break;
                        case (TNTTtypeNumber <= 18000000):
                            bac = "3 (15% x TNTT - 750,000)";
                            break;
                        case (TNTTtypeNumber <= 32000000):
                            bac = "4 (20% x TNTT - 1,650,000)";
                            break;
                        case (TNTTtypeNumber <= 52000000):
                            bac = "5 (25% x TNTT - 3,250,000)";
                            break;
                        case (TNTTtypeNumber <= 80000000):
                            bac = "6 (30% x TNTT - 5,850,000)";
                            break;
                        default:
                            bac = "7 (35% x TNTT - 9,850,000)";
                            break;
                    }
                    document.getElementById("BacThue").innerText = bac;
                });
            });
            phieuChiButtons.forEach(button => {
                button.addEventListener("click", function() {
                    console.log("Button clicked!");
                    const MaNV = button.getAttribute("data-id");
                    const HoTen = button.getAttribute("data-name");
                    const ChucVu = button.getAttribute("data-position");
                    const PhongBan = button.getAttribute("data-department");
                    const LuongCoBan = button.getAttribute("data-luongcoban");
                    const HSL = button.getAttribute("data-HSL");
                    const NgayCong = button.getAttribute("data-ngaycong");
                    const PCCV = button.getAttribute("data-PCCV");
                    const PCTN = button.getAttribute("data-PCTN");
                    const KTKL = button.getAttribute("data-KTKL");
                    const TongThuNhap = button.getAttribute("data-TongThuNhap");
                    const BHXH = button.getAttribute("data-bhxh");

                    const BHYT = button.getAttribute("data-bhyt");
                    const BHTN = button.getAttribute("data-bhtn");

                    const TongBH = button.getAttribute("data-TongBH");

                    const TNTT = button.getAttribute("data-TNTT");
                    const luongthucnhan = button.getAttribute("data-luongthucnhan");
                    const conlanh = button.getAttribute("data-conlanh");
                    console.log(HoTen);
                    console.log(ChucVu);
                    console.log(PhongBan);
                    console.log(LuongCoBan);
                    console.log(HSL);
                    console.log(NgayCong);
                    console.log(PCCV);
                    console.log(PCTN);
                    console.log(KTKL);
                    console.log(TongThuNhap);
                    console.log(BHXH);
                    console.log(BHYT);
                    console.log(BHTN);
                    console.log(TongBH);
                    console.log(TNTT);
                    console.log(luongthucnhan);
                    console.log(conlanh);


                    document.getElementById("salaryMa").innerText = MaNV;
                    document.getElementById("salaryName").innerText = HoTen;
                    document.getElementById("salaryPosition").innerText = ChucVu;
                    document.getElementById("salaryDepartment").innerText = PhongBan;
                    document.getElementById("salaryLuongCB").innerText = LuongCoBan;
                    document.getElementById("salaryHSL").innerText = HSL;
                    document.getElementById("salaryCong").innerText = NgayCong;
                    document.getElementById("salaryPhuCapCV").innerText = PCCV;
                    document.getElementById("salaryPhuCapTN").innerText = PCTN;
                    document.getElementById("salaryKTKL").innerText = KTKL;
                    document.getElementById("salaryTongThuNhap").innerText = TongThuNhap;
                    document.getElementById("salaryBHXH").innerText = BHXH;
                    document.getElementById("salaryBHYT").innerText = BHYT;
                    document.getElementById("salaryBHTT").innerText = BHTN;
                    document.getElementById("salaryBH").innerText = TongBH;
                    document.getElementById("salaryTNTT").innerText = TNTT;
                    document.getElementById("salaryThucLanh").innerText = luongthucnhan;
                    document.getElementById("salaryConLanh").innerText = conlanh;
                });
            });
        });
    </script>