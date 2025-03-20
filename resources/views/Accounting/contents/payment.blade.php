<meta name="csrf-token" content="{{ csrf_token() }}">
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

.paid-status {
    color: #198754;
    font-weight: bold;
}

.pending-status {
    color: #ffc107;
    font-weight: bold;
}

.empty-table {
    text-align: center;
    padding: 50px;
    font-size: 1.2rem;
    color: #6c757d;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Search button click event
    document.getElementById('searchButton').addEventListener('click', function(e) {
        e.preventDefault();

        const departmentId = document.getElementById('departmentSelect').value;
        const monthValue = document.getElementById('monthSelect').value;

        if (!departmentId) {
            alert('Vui lòng chọn phòng ban');
            return;
        }

        console.log(`Fetching data for department: ${departmentId}, month: ${monthValue}`);

        // Fetch employee salaries by department
        fetch(`/get-salaries-by-department?departmentId=${departmentId}&month=${monthValue}`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                        'content')
                }
            })
            .then(response => {
                console.log('Response status:', response.status);
                console.log('Response headers:', response.headers.get('content-type'));

                // Kiểm tra nếu response không phải là JSON
                const contentType = response.headers.get('content-type');
                if (!contentType || !contentType.includes('application/json')) {
                    return response.text().then(text => {
                        console.error('Không phải JSON response:', text);
                        throw new Error('Server trả về định dạng không phải JSON');
                    });
                }

                return response.json();
            })
            .then(data => {
                console.log('Data received:', data);
                const tableBody = document.querySelector('#salaryTable tbody');
                tableBody.innerHTML = '';

                if (data.length === 0) {
                    tableBody.innerHTML = `
                    <tr>
                        <td colspan="6" class="empty-table">
                            <i class="fa-solid fa-exclamation-circle me-2"></i>
                            Không có dữ liệu lương cho phòng ban này
                        </td>
                    </tr>
                `;
                    return;
                }

                data.forEach((salary, index) => {
                    const isPaid = salary.NgayThanhToan !== null;
                    const status = isPaid ?
                        `<span class="paid-status">Đã thanh toán</span>` :
                        `<span class="pending-status">Chờ thanh toán</span>`;

                    const actionButton = isPaid ?
                        `<button disabled class="btn btn-secondary d-flex align-items-center justify-content-center mx-auto" 
                    style="width: 32px; height: 32px;">
                        <i class="fa-solid fa-check"></i>
                    </button>` :
                        `<button data-bs-toggle="modal" data-bs-target="#salaryModal" 
                    data-salary-id="${salary.id}"
                    data-employee-name="${salary.HoTen}"
                    data-position="${salary.ChucVu}"
                    data-department="${salary.PhongBan}"
                    data-base-salary="${salary.LuongCoBan}"
                    data-workdays="${salary.SoNgayCong}"
                    data-position-allowance="${salary.pc_chuc_vu}"
                    data-responsibility-allowance="${salary.pc_trach_nhiem}"
                    data-income="${salary.TongThuNhap}"
                    data-social-insurance="${salary.bhxh}"
                    data-health-insurance="${salary.bhyt}"
                    data-income-tax="${salary.thue_tncn}"
                    data-net-salary="${salary.luong_thuc_lanh}"
                    data-advance="${salary.tam_ung}"
                    data-final-payment="${salary.con_lanh}"
                    data-employee-id="${salary.MaNV}"
                    class="btn btn-success d-flex align-items-center justify-content-center mx-auto" 
                    style="width: 32px; height: 32px;">
                        <i class="fa-solid fa-dollar-sign"></i>
                    </button>`;

                    tableBody.innerHTML += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>NV${salary.MaNV.toString().padStart(3, '0')}</td>
                        <td>${salary.HoTen}</td>
                        <td>${new Intl.NumberFormat('vi-VN').format(salary.luong_thuc_lanh)} đ</td>
                        <td>${status}</td>
                        <td class="text-center align-middle">
                            ${actionButton}
                        </td>
                    </tr>
                `;
                });

                // Add event listeners to the newly created buttons
                initializePaymentButtons();
            })
            .catch(error => {
                console.error('Error fetching data:', error);
                const tableBody = document.querySelector('#salaryTable tbody');
                tableBody.innerHTML = `
                <tr>
                    <td colspan="6" class="empty-table text-danger">
                        <i class="fa-solid fa-exclamation-triangle me-2"></i>
                        Lỗi khi tải dữ liệu: ${error.message}
                    </td>
                </tr>
                `;
            });
    });

    // Initialize payment buttons event handlers
    function initializePaymentButtons() {
        const salaryModal = document.getElementById('salaryModal');

        salaryModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const salaryId = button.getAttribute('data-salary-id');
            const employeeName = button.getAttribute('data-employee-name');
            const position = button.getAttribute('data-position');
            const department = button.getAttribute('data-department');
            const baseSalary = button.getAttribute('data-base-salary');
            const workdays = button.getAttribute('data-workdays');
            const positionAllowance = button.getAttribute('data-position-allowance');
            const responsibilityAllowance = button.getAttribute('data-responsibility-allowance');
            const income = button.getAttribute('data-income');
            const socialInsurance = button.getAttribute('data-social-insurance');
            const healthInsurance = button.getAttribute('data-health-insurance');
            const incomeTax = button.getAttribute('data-income-tax');
            const netSalary = button.getAttribute('data-net-salary');
            const advance = button.getAttribute('data-advance');
            const finalPayment = button.getAttribute('data-final-payment');
            const employeeId = button.getAttribute('data-employee-id');

            // Set data in modal
            document.getElementById('modalEmployeeName').textContent = employeeName;
            document.getElementById('modalEmployeeId').textContent =
                `NV${employeeId.toString().padStart(3, '0')}`;
            document.getElementById('modalPosition').textContent = position;
            document.getElementById('modalDepartment').textContent = department;
            document.getElementById('modalBaseSalary').textContent = new Intl.NumberFormat('vi-VN')
                .format(baseSalary) + ' đ';
            document.getElementById('modalPositionAllowance').textContent = new Intl.NumberFormat(
                'vi-VN').format(positionAllowance) + ' đ';
            document.getElementById('modalResponsibilityAllowance').textContent = new Intl.NumberFormat(
                'vi-VN').format(responsibilityAllowance) + ' đ';
            document.getElementById('modalWorkdays').textContent = workdays;
            document.getElementById('modalIncome').textContent = new Intl.NumberFormat('vi-VN').format(
                income) + ' đ';
            document.getElementById('modalSocialInsurance').textContent = new Intl.NumberFormat('vi-VN')
                .format(socialInsurance) + ' đ';
            document.getElementById('modalHealthInsurance').textContent = new Intl.NumberFormat('vi-VN')
                .format(healthInsurance) + ' đ';
            document.getElementById('modalIncomeTax').textContent = new Intl.NumberFormat('vi-VN')
                .format(incomeTax) + ' đ';
            document.getElementById('modalNetSalary').textContent = new Intl.NumberFormat('vi-VN')
                .format(netSalary) + ' đ';
            document.getElementById('modalAdvance').textContent = new Intl.NumberFormat('vi-VN').format(
                advance) + ' đ';
            document.getElementById('modalFinalPayment').textContent = new Intl.NumberFormat('vi-VN')
                .format(finalPayment) + ' đ';

            // Set salary ID to payment button
            document.getElementById('paySalaryButton').setAttribute('data-salary-id', salaryId);
        });

        // Pay salary button click event
        document.getElementById('paySalaryButton').addEventListener('click', function() {
            const salaryId = this.getAttribute('data-salary-id');

            fetch('/pay-salary', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                            .getAttribute('content')
                    },
                    body: JSON.stringify({
                        salaryId: salaryId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Close modal
                        const modal = bootstrap.Modal.getInstance(document.getElementById(
                            'salaryModal'));
                        modal.hide();

                        // Show success message
                        alert('Thanh toán lương thành công!');

                        // Trigger search again to refresh the table
                        document.getElementById('searchButton').click();
                    } else {
                        alert('Lỗi: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error paying salary:', error);
                    alert('Có lỗi xảy ra khi thanh toán lương!');
                });
        });
    }
});
</script>

<div class="col-md-10 p-4">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <h3 class="navbar-brand">Thanh Toán Lương</h3>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarControls">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarControls">
                <form class="d-flex align-items-center ms-auto gap-3">
                    <input type="month" class="form-control" id="monthSelect" style="width: 200px;"
                        value="{{ date('Y-m') }}">
                    <select class="form-select" style="width: 200px;" id="departmentSelect">
                        <option value="">Chọn Phòng Ban</option>
                        @foreach($departments as $department)
                        <option value="{{ $department->id }}">{{ $department->TenPhongBan }}</option>
                        @endforeach
                    </select>
                    <button class="btn btn-primary" id="searchButton">Tìm kiếm</button>
                </form>
            </div>
        </div>
    </nav>
    <div class="table-responsive">
        <table class="table table-bordered" id="salaryTable">
            <thead>
                <tr class="text-center">
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
                    <td colspan="6" class="empty-table">
                        <i class="fa-solid fa-filter me-2"></i>
                        Vui lòng chọn phòng ban và tháng để xem danh sách thanh toán lương
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Salary Detail Modal -->
<div class="modal fade" id="salaryModal" tabindex="-1" aria-labelledby="salaryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="salaryModalLabel">
                    <i class="fas fa-file-invoice-dollar me-2"></i>
                    CÔNG TY ABC - PHIẾU THANH TOÁN LƯƠNG
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-end mb-3">Tháng {{ date('m/Y') }}</div>

                <div class="detail-row">
                    <div class="detail-label">Họ và tên:</div>
                    <div class="detail-value" id="modalEmployeeName"></div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">Mã số NV:</div>
                    <div class="detail-value" id="modalEmployeeId"></div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">Chức vụ:</div>
                    <div class="detail-value" id="modalPosition"></div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">Bộ phận:</div>
                    <div class="detail-value" id="modalDepartment"></div>
                </div>

                <div class="highlight-section">
                    <div class="detail-row">
                        <div class="detail-label">Lương cơ bản:</div>
                        <div class="detail-value" id="modalBaseSalary"></div>
                    </div>

                    <div class="detail-row">
                        <div class="detail-label">Phụ cấp:</div>
                        <div class="detail-value">
                            <div class="d-inline" id="modalPositionAllowance"></div> (Chức vụ),
                            <div class="d-inline" id="modalResponsibilityAllowance"></div> (Trách nhiệm)
                        </div>
                    </div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">Ngày công:</div>
                    <div class="detail-value" id="modalWorkdays"></div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">Tổng thu nhập:</div>
                    <div class="detail-value" id="modalIncome"></div>
                </div>

                <div class="highlight-section">
                    <div class="detail-row">
                        <div class="detail-label">BHXH:</div>
                        <div class="detail-value" id="modalSocialInsurance"></div>
                    </div>

                    <div class="detail-row">
                        <div class="detail-label">BHYT:</div>
                        <div class="detail-value" id="modalHealthInsurance"></div>
                    </div>

                    <div class="detail-row">
                        <div class="detail-label">Thuế TNCN:</div>
                        <div class="detail-value" id="modalIncomeTax"></div>
                    </div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">Lương thực lãnh:</div>
                    <div class="detail-value fw-bold" id="modalNetSalary"></div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">Tạm ứng lương:</div>
                    <div class="detail-value" id="modalAdvance"></div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">Còn lãnh:</div>
                    <div class="detail-value fw-bold text-primary" id="modalFinalPayment"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-primary" id="paySalaryButton">
                    <i class="fas fa-money-check-alt me-2"></i>Thanh toán lương
                </button>
            </div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>