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
        <h4 class="text-center mb-4">BẢNG LƯƠNG THÁNG 02/2025</h4>
        <div class="table-responsive">
            <table class="table table-bordered table-hover salary-table">
                <thead>
                    <tr class="table-header text-center">
                        <th rowspan="2">Mã số NV</th>
                        <th rowspan="2">Họ tên</th>
                        <th rowspan="2">Chức vụ</th>
                        <th rowspan="2">Bộ phận</th>
                        <th colspan="3">LƯƠNG CB + PHỤ CẤP THEO HĐLĐ</th>
                        <th rowspan="2">Số ngày công</th>

                        <th rowspan="2">Tổng thu nhập</th>
                        <th colspan="3">BẢO HIỂM NHÂN VIÊN ĐÓNG</th>
                        <th rowspan="2">Thuế TNCN phải nộp</th>
                        <th rowspan="2">Lương thực lãnh</th>
                        <th rowspan="2">Tạm ứng</th>
                        <th rowspan="2">Còn lãnh</th>
                        <th rowspan="2">Hành động</th>
                    </tr>
                    <tr class="table-header text-center">
                        <th>Lương CB</th>
                        <th>PC Chức vụ</th>
                        <th>PC Trách nhiệm</th>
                        <th>BHXH (8%)</th>
                        <th>BHYT (1.5%)</th>
                        <th>BHTN (1%)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="department">
                        <td colspan="19">Nhân viên chính thức</td>
                    </tr>
                    @foreach($nhanvienchinhthucs as $nhanvienchinhthuc)
                    <tr class="text-center">
                        <td>{{ $nhanvienchinhthuc->id }}</td>
                        <td class="text-start">{{ $nhanvienchinhthuc->HoTen }}</td>
                        <td>{{ $nhanvienchinhthuc->chucVu->TenChucVu }}</td>
                        <td>{{ $nhanvienchinhthuc->phongBan->TenPhongBan }}</td>
                        <td>{{ number_format($nhanvienchinhthuc->chucVu->LuongCoBan) }}</td>
                        <td>{{ number_format($nhanvienchinhthuc->chucVu->PC_Chuc_vu) }}</td>
                        <td>{{ number_format($nhanvienchinhthuc->chucVu->PC_Trach_nhiem) }}</td>
                        <td>{{ $nhanvienchinhthuc->TongSoCong }}</td>


                        @php
                        $Tongthunhap = ($nhanvienchinhthuc->chucVu->LuongCoBan / 26) * $nhanvienchinhthuc->TongSoCong
                        + $nhanvienchinhthuc->chucVu->PC_Chuc_vu
                        + $nhanvienchinhthuc->chucVu->PC_Trach_nhiem;
                        $bhxh =( $nhanvienchinhthuc->chucVu->LuongCoBan + $nhanvienchinhthuc->chucVu->PC_Chuc_vu+ $nhanvienchinhthuc->chucVu->PC_Trach_nhiem)*0.08;
                        $bhyt = ($nhanvienchinhthuc->chucVu->LuongCoBan + $nhanvienchinhthuc->chucVu->PC_Chuc_vu+ $nhanvienchinhthuc->chucVu->PC_Trach_nhiem)*0.015;
                        $bhtn = ($nhanvienchinhthuc->chucVu->LuongCoBan + $nhanvienchinhthuc->chucVu->PC_Chuc_vu+ $nhanvienchinhthuc->chucVu->PC_Trach_nhiem)*0.01;
                        $tongBH = $bhxh + $bhyt + $bhtn;
                        if($nhanvienchinhthuc->hopDong){
                        $TNTT = $Tongthunhap - 11000000 - $nhanvienchinhthuc->hopDong->NPT*4400000- $tongBH;
                        switch (true) {
                        case ($TNTT <= 5000000):
                            $thue=$TNTT * 0.05;
                            break;
                            case ($TNTT <=10000000):
                            $thue=$TNTT * 0.1 - 250000;
                            break;
                            case ($TNTT <=18000000):
                            $thue=$TNTT * 0.15 - 750000;
                            break;
                            case ($TNTT <=32000000):
                            $thue=$TNTT * 0.2 - 1650000;
                            break;
                            case ($TNTT <=52000000):
                            $thue=$TNTT * 0.25 - 3250000;
                            break;
                            case ($TNTT <=80000000):
                            $thue=$TNTT * 0.3 - 5850000;
                            break;
                            default:
                            $thue=$TNTT * 0.35 - 9850000;
                            break;
                            }
                            }
                            else
                            $thue=0;

                            $luongThucLanh=($Tongthunhap - $bhxh - $bhyt - $bhtn-$thue);
                            if($thue < 0)
                            $thue=0;
                            @endphp

                            <td>{{ number_format(($Tongthunhap)) }}</td>
                            <td>{{ number_format($bhxh) }}</td>
                            <td>{{ number_format($bhyt) }}</td>
                            <td>{{ number_format($bhtn) }}</td>

                            <td>

                                <span>{{number_format($thue)}}</span>
                                @if($nhanvienchinhthuc->hopDong)
                                <button class="btn btn-primary btn-sm tax-button ms-2 taxCalculation" data-bs-toggle="modal" data-bs-target="#taxCalculationModal"
                                    data-id="{{$nhanvienchinhthuc->id}}"
                                    data-hoten="{{$nhanvienchinhthuc->HoTen}}"
                                    data-position="{{$nhanvienchinhthuc->chucVu->TenChucVu}}"
                                    data-department="{{$nhanvienchinhthuc->phongBan->TenPhongBan}}"
                                    data-luongcoban="{{number_format($nhanvienchinhthuc->chucVu->LuongCoBan)}}"
                                    data-ngaycong="{{$nhanvienchinhthuc->TongSoCong}}"
                                    data-phucap="{{number_format($nhanvienchinhthuc->chucVu->PC_Chuc_vu + $nhanvienchinhthuc->chucVu->PC_Trach_nhiem)}}"
                                    data-TongThuNhap="{{number_format($Tongthunhap)}}"
                                    data-bhxh="{{number_format($bhxh)}}"
                                    data-bhyt="{{number_format($bhyt)}}"
                                    data-bhtn="{{number_format($bhtn)}}"
                                    data-NPT=" {{number_format($nhanvienchinhthuc->hopDong->NPT*4400000)}}"
                                    data-TongGiamTru="{{number_format($bhxh + $bhyt + $bhtn+11000000+$nhanvienchinhthuc->hopDong->NPT*4400000)}}"
                                    data-TNTT="{{number_format($TNTT)}}"
                                    data-TNTTtypeNumber={{$TNTT}}
                                    data-TNCN="{{number_format($thue)}}">
                                    <i class="fas fa-calculator"></i> Tính thuế
                                </button>

                                @else
                                <button class="btn btn-primary btn-sm tax-button ms-2 taxCalculation" data-bs-toggle="modal" data-bs-target="#taxCalculationModal">
                                    <i class="fas fa-calculator"></i> Tính thuế
                                </button>

                                @endif
                            </td>
                            <td>{{number_format($luongThucLanh)}}</td>
                            <td>{{number_format(2000000)}}</td>
                            <td>{{number_format($luongThucLanh-2000000)}}</td>

                            <td data-bs-toggle="modal" data-bs-target="#salaryModal">
                                <i class="fa-solid fa-eye action-btn"></i>
                            </td>
                    </tr>

                    @endforeach
                    <tr class="department">
                        <td colspan="19">Nhân viên thời vụ</td>
                    </tr>
                    @foreach($nhanvienthoivus as $nhanvienthoivu)
                    <tr class="text-center">
                        <td>{{ $nhanvienthoivu->id }}</td>
                        <td class="text-start">{{ $nhanvienthoivu->HoTen }}</td>
                        <td>{{ $nhanvienthoivu->chucVu->TenChucVu }}</td>
                        <td>{{ $nhanvienthoivu->phongBan->TenPhongBan }}</td>
                        <td>{{ number_format($nhanvienthoivu->chucVu->LuongCoBan) }}</td>
                        <td>{{ number_format($nhanvienthoivu->chucVu->PC_Chuc_vu) }}</td>
                        <td>{{ number_format($nhanvienthoivu->chucVu->PC_Trach_nhiem) }}</td>
                        <td>{{ $nhanvienthoivu->TongSoCong }}</td>


                        @php
                        $Tongthunhap = ($nhanvienthoivu->chucVu->LuongCoBan / 26) * $nhanvienthoivu->TongSoCong
                        + $nhanvienthoivu->chucVu->PC_Chuc_vu
                        + $nhanvienthoivu->chucVu->PC_Trach_nhiem;
                        $bhxh =( $nhanvienthoivu->chucVu->LuongCoBan + $nhanvienthoivu->chucVu->PC_Chuc_vu+ $nhanvienthoivu->chucVu->PC_Trach_nhiem)*0.08;
                        $bhyt = ($nhanvienthoivu->chucVu->LuongCoBan + $nhanvienthoivu->chucVu->PC_Chuc_vu+ $nhanvienthoivu->chucVu->PC_Trach_nhiem)*0.015;
                        $bhtn = ($nhanvienthoivu->chucVu->LuongCoBan + $nhanvienthoivu->chucVu->PC_Chuc_vu+ $nhanvienthoivu->chucVu->PC_Trach_nhiem)*0.01;
                        $tongBH = $bhxh + $bhyt + $bhtn;
                        if($nhanvienthoivu->hopDong){
                        $TNTT = $Tongthunhap - 11000000 - $nhanvienthoivu->hopDong->NPT*4400000- $tongBH;
                        switch (true) {
                        case ($TNTT <= 5000000):
                            $thue=$TNTT * 0.05;
                            break;
                            case ($TNTT <=10000000):
                            $thue=$TNTT * 0.1 - 250000;
                            break;
                            case ($TNTT <=18000000):
                            $thue=$TNTT * 0.15 - 750000;
                            break;
                            case ($TNTT <=32000000):
                            $thue=$TNTT * 0.2 - 1650000;
                            break;
                            case ($TNTT <=52000000):
                            $thue=$TNTT * 0.25 - 3250000;
                            break;
                            case ($TNTT <=80000000):
                            $thue=$TNTT * 0.3 - 5850000;
                            break;
                            default:
                            $thue=$TNTT * 0.35 - 9850000;
                            break;
                            }
                            }
                            else
                            $thue=0;

                            $luongThucLanh=($Tongthunhap - $bhxh - $bhyt - $bhtn-$thue);
                            if($thue < 0)
                            $thue=0;
                            @endphp

                            <td>{{ number_format(($Tongthunhap)) }}</td>
                            <td>{{ number_format($bhxh) }}</td>
                            <td>{{ number_format($bhyt) }}</td>
                            <td>{{ number_format($bhtn) }}</td>

                            <td>

                                <span>{{number_format($thue)}}</span>
                                @if($nhanvienthoivu->hopDong)
                                <button class="btn btn-primary btn-sm tax-button ms-2 taxCalculation" data-bs-toggle="modal" data-bs-target="#taxCalculationModal"
                                    data-id="{{$nhanvienthoivu->id}}"
                                    data-hoten="{{$nhanvienthoivu->HoTen}}"
                                    data-position="{{$nhanvienthoivu->chucVu->TenChucVu}}"
                                    data-department="{{$nhanvienthoivu->phongBan->TenPhongBan}}"
                                    data-luongcoban="{{number_format($nhanvienthoivu->chucVu->LuongCoBan)}}"
                                    data-ngaycong="{{$nhanvienthoivu->TongSoCong}}"
                                    data-phucap="{{number_format($nhanvienthoivu->chucVu->PC_Chuc_vu + $nhanvienthoivu->chucVu->PC_Trach_nhiem)}}"
                                    data-TongThuNhap="{{number_format($Tongthunhap)}}"
                                    data-bhxh="{{number_format($bhxh)}}"
                                    data-bhyt="{{number_format($bhyt)}}"
                                    data-bhtn="{{number_format($bhtn)}}"
                                    data-NPT=" {{number_format($nhanvienthoivu->hopDong->NPT*4400000)}}"
                                    data-TongGiamTru="{{number_format($bhxh + $bhyt + $bhtn+11000000+$nhanvienthoivu->hopDong->NPT*4400000)}}"
                                    data-TNTT="{{number_format($TNTT)}}"
                                    data-TNTTtypeNumber={{$TNTT}}
                                    data-TNCN="{{number_format($thue)}}">
                                    <i class="fas fa-calculator"></i> Tính thuế
                                </button>

                                @else
                                <button class="btn btn-primary btn-sm tax-button ms-2 taxCalculation" data-bs-toggle="modal" data-bs-target="#taxCalculationModal">
                                    <i class="fas fa-calculator"></i> Tính thuế
                                </button>

                                @endif
                            </td>
                            <td>{{number_format($luongThucLanh)}}</td>
                            <td>{{number_format(2000000)}}</td>
                            <td>{{number_format($luongThucLanh-2000000)}}</td>

                            <td data-bs-toggle="modal" data-bs-target="#salaryModal">
                                <i class="fa-solid fa-eye action-btn"></i>
                            </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal fade" id="salaryModal" tabindex="-1" aria-labelledby="salaryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="salaryModalLabel">
                        <i class="fas fa-file-invoice-dollar me-2"></i>
                        CÔNG TY TNHH DƯỢC PHẨM SÂM NGỌC LINH - PHIẾU CHI LƯƠNG
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-end mb-3">Tháng 02/2025</div>

                    <div class="detail-row">
                        <div class="detail-label">Họ và tên:</div>
                        <div class="detail-value" id="salaryName">Nguyễn Văn A</div>
                    </div>

                    <div class="detail-row">
                        <div class="detail-label">Mã số NV:</div>
                        <div class="detail-value" id="salaryID">NV-001</div>
                    </div>

                    <div class="detail-row">
                        <div class="detail-label">Chức vụ:</div>
                        <div class="detail-value" id="salaryPosition">Trưởng phòng</div>
                    </div>

                    <div class="detail-row">
                        <div class="detail-label">Phòng ban:</div>
                        <div class="detail-value" id="salaryDeparment">Hành chính</div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">Tiền lương:</div>
                        <div class="detail-value" id="salary"></div>
                    </div>

                    <div class="detail-row">
                        <div class="detail-label">Ghi chú:</div>
                        <div class="detail-value">Không có</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary">
                        <i class="fas fa-print me-2"></i>In phiếu lương
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="taxCalculationModal" tabindex="-1" aria-labelledby="salaryModalLabel" aria-hidden="true">
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
                    <div class="nhanvienthoivu-info mb-4">
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const viewButtons = document.querySelectorAll(".taxCalculation");
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
        });
    </script>