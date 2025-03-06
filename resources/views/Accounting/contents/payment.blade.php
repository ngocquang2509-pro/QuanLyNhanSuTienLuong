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
</style>
<div class="col-md-10 p-4">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <h3 class="navbar-brand">Thanh Toán Lương</h3>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarControls">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarControls">
                <form class="d-flex align-items-center ms-auto gap-3">
                    <input type="month" class="form-control" style="width: 200px;">
                    <select class="form-select" style="width: 200px;">
                        <option value="">Chọn Phòng Ban</option>
                        <option value="it">Kế toán</option>
                        <option value="hr">Nhân Sự</option>
                    </select>
                    <button class="btn btn-primary">Tìm kiếm</button>
                </form>
            </div>
        </div>
    </nav>
    <div class="table-responsive ">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Mã NV</th>
                    <th>Họ Tên</th>
                    <th>Thực Lãnh</th>
                    <th>Trạng Thái</th>
                    <th>Thanh toán</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>NV001</td>
                    <td>Nguyễn Văn A</td>
                    <td>10,500,000</td>
                    <td><span class="text-warning">Chờ thanh toán</span></td>
                    <td class="text-center align-middle">
                        <button data-bs-toggle="modal" data-bs-target="#salaryModal" class="btn btn-success d-flex align-items-center justify-content-center mx-auto" style="width: 32px; height: 32px;">
                            <i class="fa-solid fa-dollar-sign"></i>
                        </button>
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
                    CÔNG TY ABC - PHIẾU THANH TOÁN LƯƠNG
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
                    <i class="fas fa-print me-2"></i>Thanh toán lương
                </button>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
</div>