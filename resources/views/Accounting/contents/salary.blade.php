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
                        <th rowspan="2">STT</th>
                        <th rowspan="2">Mã số NV</th>
                        <th rowspan="2">Họ tên</th>
                        <th rowspan="2">Chức vụ</th>
                        <th rowspan="2">Bộ phận</th>
                        <th colspan="6">LƯƠNG CB + PHỤ CẤP THEO HĐLĐ</th>
                        <th rowspan="2">Lương công (ngày công)</th>
                        <th rowspan="2">Làm thêm</th>
                        <th rowspan="2">Thu nhập khác</th>
                        <th rowspan="2">Tổng thu nhập</th>
                        <th colspan="3">BẢO HIỂM CÔNG TY ĐÓNG</th>
                        <th colspan="3">BẢO HIỂM NHÂN VIÊN ĐÓNG</th>
                        <th rowspan="2">Thuế TNCN phải nộp</th>
                        <th rowspan="2">Lương thực lãnh</th>
                        <th rowspan="2">Tạm ứng</th>
                        <th rowspan="2">Còn lãnh</th>
                        <th rowspan="2">Ghi chú</th>
                        <th rowspan="2">Hành động</th>
                    </tr>
                    <tr class="table-header text-center">
                        <th>Lương CB</th>
                        <th>PC Chức vụ</th>
                        <th>PC Trách nhiệm</th>
                        <th>PC Ăn ca</th>
                        <th>PC Xăng xe</th>
                        <th>PC khác</th>
                        <th>BHXH (17.5%)</th>
                        <th>BHYT (3%)</th>
                        <th>BHTN (1%)</th>
                        <th>BHXH (8%)</th>
                        <th>BHYT (1.5%)</th>
                        <th>BHTN (1%)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="department">
                        <td colspan="26">Phòng Hành Chính</td>
                    </tr>
                    <tr class="text-center">
                        <td>1</td>
                        <td>NV-001</td>
                        <td class="text-start">Nguyễn Văn A</td>
                        <td>Trưởng phòng</td>
                        <td>Hành chính</td>
                        <td>10,000,000</td>
                        <td>2,000,000</td>
                        <td>1,000,000</td>
                        <td>500,000</td>
                        <td>300,000</td>
                        <td>0</td>
                        <td>26</td>
                        <td>10</td>
                        <td>1,500,000</td>
                        <td>15,300,000</td>
                        <td>1,750,000</td>
                        <td>300,000</td>
                        <td>150,000</td>
                        <td>800,000</td>
                        <td>150,000</td>
                        <td>100,000</td>
                        <td>

                            <button class="btn btn-primary btn-sm tax-button ms-2" data-bs-toggle="modal" data-bs-target="#taxCalculationModal">
                                <i class="fas fa-calculator"></i> Tính thuế
                            </button>
                        </td>
                        <td>13,500,000</td>
                        <td>2,000,000</td>
                        <td>11,500,000</td>
                        <td>Không có</td>
                        <td data-bs-toggle="modal" data-bs-target="#salaryModal">
                            <i class="fa-solid fa-eye action-btn"></i>
                        </td>
                    </tr>
                    <tr class="department">
                        <td colspan="26">Phòng Kinh Doanh</td>
                    </tr>
                    <tr class="text-center">
                        <td>2</td>
                        <td>NV-002</td>
                        <td class="text-start">Trần Thị B</td>
                        <td>Nhân viên</td>
                        <td>Kinh doanh</td>
                        <td>8,000,000</td>
                        <td>1,000,000</td>
                        <td>500,000</td>
                        <td>400,000</td>
                        <td>200,000</td>
                        <td>0</td>
                        <td>24</td>
                        <td>5</td>
                        <td>1,000,000</td>
                        <td>11,100,000</td>
                        <td>1,400,000</td>
                        <td>240,000</td>
                        <td>80,000</td>
                        <td>640,000</td>
                        <td>120,000</td>
                        <td>80,000</td>
                        <td>

                            <button class="btn btn-primary btn-sm tax-button ms-2" data-bs-toggle="modal" data-bs-target="#taxCalculationModal">
                                <i class="fas fa-calculator"></i> Tính thuế
                            </button>
                        </td>
                        <td>9,700,000</td>
                        <td>1,000,000</td>
                        <td>8,700,000</td>
                        <td>Không có</td>
                        <td data-bs-toggle="modal" data-bs-target="#salaryModal">
                            <i class="fa-solid fa-eye action-btn"></i>
                        </td>
                    </tr>
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
                        CÔNG TY ABC - PHIẾU CHI LƯƠNG
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-end mb-3">Tháng 02/2025</div>

                    <div class="detail-row">
                        <div class="detail-label">Họ và tên:</div>
                        <div class="detail-value">Nguyễn Văn A</div>
                    </div>

                    <div class="detail-row">
                        <div class="detail-label">Mã số NV:</div>
                        <div class="detail-value">NV-001</div>
                    </div>

                    <div class="detail-row">
                        <div class="detail-label">Chức vụ:</div>
                        <div class="detail-value">Trưởng phòng</div>
                    </div>

                    <div class="detail-row">
                        <div class="detail-label">Bộ phận:</div>
                        <div class="detail-value">Hành chính</div>
                    </div>

                    <div class="highlight-section">
                        <div class="detail-row">
                            <div class="detail-label">Lương cơ bản:</div>
                            <div class="detail-value">10,000,000</div>
                        </div>

                        <div class="detail-row">
                            <div class="detail-label">Phụ cấp:</div>
                            <div class="detail-value">
                                2,000,000 (Chức vụ), 1,000,000 (Trách nhiệm),<br>
                                500,000 (Ăn ca), 300,000 (Xăng xe)
                            </div>
                        </div>
                    </div>

                    <div class="detail-row">
                        <div class="detail-label">Ngày công:</div>
                        <div class="detail-value">26</div>
                    </div>

                    <div class="detail-row">
                        <div class="detail-label">Làm thêm:</div>
                        <div class="detail-value">10 giờ</div>
                    </div>

                    <div class="detail-row">
                        <div class="detail-label">Thu nhập khác:</div>
                        <div class="detail-value">1,500,000</div>
                    </div>

                    <div class="highlight-section">
                        <div class="detail-row">
                            <div class="detail-label">TN miễn thuế:</div>
                            <div class="detail-value">500,000</div>
                        </div>

                        <div class="detail-row">
                            <div class="detail-label">Giảm trừ:</div>
                            <div class="detail-value">1,000,000</div>
                        </div>

                        <div class="detail-row">
                            <div class="detail-label">TN tính thuế:</div>
                            <div class="detail-value">13,800,000</div>
                        </div>

                        <div class="detail-row">
                            <div class="detail-label">Bậc thuế:</div>
                            <div class="detail-value">3</div>
                        </div>

                        <div class="detail-row">
                            <div class="detail-label">Thuế TNCN phải nộp:</div>
                            <div class="detail-value">600,000</div>
                        </div>
                    </div>

                    <div class="detail-row">
                        <div class="detail-label">Tạm ứng lương:</div>
                        <div class="detail-value">2,000,000</div>
                    </div>

                    <div class="detail-row">
                        <div class="detail-label">Lương thực lãnh:</div>
                        <div class="detail-value fw-bold">13,500,000</div>
                    </div>

                    <div class="detail-row">
                        <div class="detail-label">Còn lãnh:</div>
                        <div class="detail-value fw-bold text-primary">11,500,000</div>
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
                    <div class="employee-info mb-4">
                        <h6 class="text-muted mb-3">Thông tin nhân viên</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Họ và tên:</strong> Nguyễn Văn A</p>
                                <p><strong>Mã số NV:</strong> NV-001</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Chức vụ:</strong> Trưởng phòng</p>
                                <p><strong>Bộ phận:</strong> Hành chính</p>
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
                                        <td class="text-end">10,000,000</td>
                                    </tr>
                                    <tr>
                                        <td>Phụ cấp</td>
                                        <td class="text-end">3,800,000</td>
                                    </tr>
                                    <tr>
                                        <td>Thu nhập khác</td>
                                        <td class="text-end">1,500,000</td>
                                    </tr>
                                    <tr class="table-info">
                                        <td><strong>Tổng thu nhập</strong></td>
                                        <td class="text-end"><strong>15,300,000</strong></td>
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
                                        <td class="text-end">800,000</td>
                                    </tr>
                                    <tr>
                                        <td>Bảo hiểm y tế (1.5%)</td>
                                        <td class="text-end">150,000</td>
                                    </tr>
                                    <tr>
                                        <td>Bảo hiểm thất nghiệp (1%)</td>
                                        <td class="text-end">100,000</td>
                                    </tr>
                                    <tr>
                                        <td>Giảm trừ gia cảnh</td>
                                        <td class="text-end">1,000,000</td>
                                    </tr>
                                    <tr class="table-info">
                                        <td><strong>Tổng giảm trừ</strong></td>
                                        <td class="text-end"><strong>2,050,000</strong></td>
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
                                        <td>Thu nhập chịu thuế</td>
                                        <td class="text-end">13,800,000</td>
                                    </tr>
                                    <tr>
                                        <td>Bậc thuế áp dụng</td>
                                        <td class="text-end">3 (15%)</td>
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
                                    <span class="tax-value">600,000 VNĐ</span>
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