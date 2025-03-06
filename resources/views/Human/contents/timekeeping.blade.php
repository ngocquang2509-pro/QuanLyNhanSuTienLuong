<link
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css"
    rel="stylesheet" />
<style>
    :root {
        --primary-color: #2c3e50;
        --secondary-color: #3498db;
        --success-color: #2ecc71;
        --warning-color: #f39c12;
        --danger-color: #e74c3c;
        --light-color: #ecf0f1;
        --dark-color: #34495e;
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
        background-color: #f5f7fa;
    }

    .container {
        width: 100%;
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    header {
        background-color: var(--primary-color);
        color: white;
        padding: 20px 0;
        margin-bottom: 30px;
    }

    .header-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .logo {
        font-size: 24px;
        font-weight: bold;
    }

    .user-info {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: var(--secondary-color);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
    }

    .tabs {
        display: flex;
        margin-bottom: 20px;
        border-bottom: 1px solid #ddd;
    }

    .tab {
        padding: 12px 20px;
        cursor: pointer;
        border-bottom: 3px solid transparent;
    }

    .tab.active {
        border-bottom: 3px solid var(--secondary-color);
        color: var(--secondary-color);
        font-weight: bold;
    }

    .dashboard {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
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

    .stat {
        font-size: 28px;
        font-weight: bold;
        margin-bottom: 10px;
        color: var(--primary-color);
    }

    .stat-detail {
        color: #666;
        font-size: 14px;
    }

    .table-container {
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        margin-bottom: 30px;
    }

    .table-header {
        padding: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #eee;
    }

    .table-title {
        font-size: 18px;
        font-weight: bold;
        color: var(--dark-color);
    }

    .filters {
        display: flex;
        gap: 10px;
    }

    select,
    input,
    button {
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
    }

    button {
        background-color: var(--secondary-color);
        color: white;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    button:hover {
        background-color: #2980b9;
    }

    button.success {
        background-color: var(--success-color);
    }

    button.success:hover {
        background-color: #27ae60;
    }

    button.warning {
        background-color: var(--warning-color);
    }

    button.warning:hover {
        background-color: #e67e22;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th,
    td {
        padding: 15px 20px;
        text-align: left;
    }

    th {
        background-color: #f8f9fa;
        font-weight: 600;
        color: #666;
        border-bottom: 1px solid #eee;
    }

    td {
        border-bottom: 1px solid #eee;
    }

    tr:last-child td {
        border-bottom: none;
    }

    .status {
        padding: 6px 12px;
        border-radius: 30px;
        font-size: 12px;
        font-weight: 600;
    }

    .status.verified {
        background-color: rgba(46, 204, 113, 0.1);
        color: var(--success-color);
    }

    .status.pending {
        background-color: rgba(243, 156, 18, 0.1);
        color: var(--warning-color);
    }

    .status.anomaly {
        background-color: rgba(231, 76, 60, 0.1);
        color: var(--danger-color);
    }

    .pagination {
        display: flex;
        justify-content: flex-end;
        padding: 15px 20px;
        border-top: 1px solid #eee;
    }

    .pagination button {
        background-color: transparent;
        color: #666;
        border: 1px solid #ddd;
        margin-left: 5px;
    }

    .pagination button.active {
        background-color: var(--secondary-color);
        color: white;
        border-color: var(--secondary-color);
    }

    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 1000;
        justify-content: center;
        align-items: center;
    }

    .modal-content {
        background-color: white;
        border-radius: 8px;
        width: 600px;
        max-width: 90%;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
    }

    .modal-header {
        padding: 20px;
        border-bottom: 1px solid #eee;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-title {
        font-size: 18px;
        font-weight: bold;
        color: var(--dark-color);
    }

    .modal-close {
        font-size: 24px;
        cursor: pointer;
        color: #999;
    }

    .modal-body {
        padding: 20px;
        max-height: 70vh;
        overflow-y: auto;
    }

    .modal-footer {
        padding: 20px;
        border-top: 1px solid #eee;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: var(--dark-color);
    }

    .form-input {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
    }

    .device-info {
        background-color: #f8f9fa;
        padding: 15px;
        border-radius: 4px;
        margin-top: 15px;
    }

    .device-info p {
        margin: 5px 0;
        font-size: 14px;
        color: #666;
    }

    .sync-status {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-top: 20px;
        padding: 15px;
        border-radius: 4px;
        background-color: rgba(46, 204, 113, 0.1);
    }

    .api-info {
        margin-top: 20px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }

    .api-header {
        background-color: #f8f9fa;
        padding: 10px 15px;
        border-bottom: 1px solid #ddd;
        font-weight: 600;
    }

    .api-body {
        padding: 15px;
        font-family: monospace;
        font-size: 14px;
        white-space: pre-wrap;
        color: #666;
    }

    .highlight {
        color: var(--secondary-color);
    }

    @media (max-width: 768px) {
        .dashboard {
            grid-template-columns: 1fr;
        }

        .filters {
            flex-direction: column;
        }

        th,
        td {
            padding: 12px 10px;
        }

        .user-name {
            display: none;
        }
    }
</style>
<div class="col-md-10 p-4">
    <!-- Tiêu đề và bộ lọc -->

    </header>

    <div class="">


        <div class="container dashboard">
            <div class="card">
                <div class="card-title">
                    <span>Chấm công hôm nay</span>
                    <i>📅</i>
                </div>
                <div class="stat">152/180</div>
                <div class="stat-detail">84% nhân viên đã chấm công</div>
            </div>

            <div class="card">
                <div class="card-title">
                    <span>Dữ liệu đồng bộ</span>
                    <i>🔄</i>
                </div>
                <div class="stat">100%</div>
                <div class="stat-detail">Cập nhật lần cuối: 10:15 AM</div>
            </div>

            <div class="card">
                <div class="card-title">
                    <span>Dữ liệu cần xác nhận</span>
                    <i>⚠️</i>
                </div>
                <div class="stat">12</div>
                <div class="stat-detail">Cần xác nhận trước 5:00 PM</div>
            </div>
        </div>

        <div class="table-container">
            <div class="table-header">
                <div class="table-title">Dữ liệu chấm công</div>
                <div class="filters">
                    <input type="date" value="2025-03-06" />
                    <select>
                        <option>Tất cả phòng ban</option>
                        <option>Phòng Nhân sự</option>
                        <option>Phòng Kỹ thuật</option>
                        <option>Phòng Kinh doanh</option>
                    </select>
                    <select>
                        <option>Tất cả trạng thái</option>
                        <option>Đã xác nhận</option>
                        <option>Đang chờ</option>
                        <option>Bất thường</option>
                    </select>
                    <button class="success">Đồng bộ dữ liệu</button>
                </div>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>Nhân viên</th>
                        <th>Phòng ban</th>
                        <th>Giờ vào</th>
                        <th>Giờ ra</th>
                        <th>Nguồn</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Nguyễn Văn A</td>
                        <td>Phòng Nhân sự</td>
                        <td>08:02 AM</td>
                        <td>05:15 PM</td>
                        <td>Máy chấm công</td>
                        <td><span class="status verified">Đã xác nhận</span></td>
                        <td><button onclick="showDetailModal()">Chi tiết</button></td>
                    </tr>
                    <tr>
                        <td>Trần Thị B</td>
                        <td>Phòng Kỹ thuật</td>
                        <td>08:30 AM</td>
                        <td>05:00 PM</td>
                        <td>Mobile App</td>
                        <td><span class="status verified">Đã xác nhận</span></td>
                        <td><button onclick="showDetailModal()">Chi tiết</button></td>
                    </tr>
                    <tr>
                        <td>Lê Văn C</td>
                        <td>Phòng Kinh doanh</td>
                        <td>09:15 AM</td>
                        <td>-</td>
                        <td>Mobile App</td>
                        <td><span class="status pending">Đang chờ</span></td>
                        <td><button onclick="showDetailModal()">Chi tiết</button></td>
                    </tr>
                    <tr>
                        <td>Phạm Thị D</td>
                        <td>Phòng Kỹ thuật</td>
                        <td>07:50 AM</td>
                        <td>04:30 PM</td>
                        <td>Máy chấm công</td>
                        <td><span class="status anomaly">Bất thường</span></td>
                        <td><button onclick="showDetailModal()">Chi tiết</button></td>
                    </tr>
                    <tr>
                        <td>Hoàng Văn E</td>
                        <td>Phòng Kinh doanh</td>
                        <td>08:05 AM</td>
                        <td>05:10 PM</td>
                        <td>Máy chấm công</td>
                        <td><span class="status verified">Đã xác nhận</span></td>
                        <td><button onclick="showDetailModal()">Chi tiết</button></td>
                    </tr>
                </tbody>
            </table>

            <div class="pagination">
                <button>&lt;</button>
                <button class="active">1</button>
                <button>2</button>
                <button>3</button>
                <button>&gt;</button>
            </div>
        </div>

        <div class="table-container">
            <div class="table-header">
                <div class="table-title">Cấu hình thiết bị chấm công</div>
                <div class="filters">
                    <button onclick="showDeviceModal()">Thêm thiết bị mới</button>
                </div>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>Mã thiết bị</th>
                        <th>Loại thiết bị</th>
                        <th>Vị trí</th>
                        <th>Trạng thái kết nối</th>
                        <th>Lần đồng bộ cuối</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>DEV001</td>
                        <td>Máy vân tay ZK-F18</td>
                        <td>Tầng 1 - Sảnh chính</td>
                        <td><span class="status verified">Đang kết nối</span></td>
                        <td>10:15 AM - 06/03/2025</td>
                        <td>
                            <button>Cấu hình</button>
                            <button class="warning" onclick="showSyncModal()">
                                Đồng bộ
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>DEV002</td>
                        <td>Máy quét QR Code</td>
                        <td>Tầng 2 - Hành lang</td>
                        <td><span class="status verified">Đang kết nối</span></td>
                        <td>10:12 AM - 06/03/2025</td>
                        <td>
                            <button>Cấu hình</button>
                            <button class="warning" onclick="showSyncModal()">
                                Đồng bộ
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>DEV003</td>
                        <td>Máy nhận diện khuôn mặt</td>
                        <td>Tầng 3 - Sảnh</td>
                        <td><span class="status anomaly">Mất kết nối</span></td>
                        <td>09:00 AM - 06/03/2025</td>
                        <td>
                            <button>Cấu hình</button>
                            <button class="warning" onclick="showSyncModal()">
                                Đồng bộ
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal chi tiết chấm công -->
    <div id="detailModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title">Chi tiết chấm công</div>
                <div class="modal-close" onclick="closeModal('detailModal')">
                    &times;
                </div>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <div class="form-label">Nhân viên</div>
                    <div>Phạm Thị D (NV004)</div>
                </div>
                <div class="form-group">
                    <div class="form-label">Ngày</div>
                    <div>06/03/2025</div>
                </div>
                <div class="form-group">
                    <div class="form-label">Giờ vào</div>
                    <div>
                        07:50 AM
                        <span class="status anomaly" style="font-size: 11px">Sớm hơn quy định</span>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-label">Giờ ra</div>
                    <div>
                        04:30 PM
                        <span class="status anomaly" style="font-size: 11px">Sớm hơn quy định</span>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-label">Nguồn dữ liệu</div>
                    <div>Máy chấm công (DEV001)</div>
                </div>
                <div class="device-info">
                    <p><strong>Thông tin thiết bị:</strong></p>
                    <p>Mã thiết bị: DEV001</p>
                    <p>Loại: Máy vân tay ZK-F18</p>
                    <p>Vị trí: Tầng 1 - Sảnh chính</p>
                    <p>Dữ liệu nhận: Vân tay ID #2445</p>
                </div>
                <div class="form-group">
                    <div class="form-label">Ghi chú</div>
                    <textarea
                        class="form-input"
                        rows="3"
                        placeholder="Nhập ghi chú..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button onclick="closeModal('detailModal')">Đóng</button>
                <button class="success">Xác nhận dữ liệu</button>
            </div>
        </div>
    </div>

    <!-- Modal đồng bộ thiết bị -->
    <div id="syncModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title">Đồng bộ dữ liệu thiết bị</div>
                <div class="modal-close" onclick="closeModal('syncModal')">
                    &times;
                </div>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <div class="form-label">Mã thiết bị</div>
                    <div>DEV001</div>
                </div>
                <div class="form-group">
                    <div class="form-label">Loại thiết bị</div>
                    <div>Máy vân tay ZK-F18</div>
                </div>
                <div class="sync-status">
                    <div>
                        <div style="font-weight: bold; margin-bottom: 5px">
                            Trạng thái đồng bộ
                        </div>
                        <div>Lần cuối: 10:15 AM - 06/03/2025</div>
                    </div>
                </div>
                <div class="api-info">
                    <div class="api-header">API Endpoint</div>
                    <div class="api-body">
                        GET https://api.example.com/attendance-devices/DEV001/sync
                        Authorization: Bearer {API_TOKEN} Content-Type: application/json
                    </div>
                </div>
                <div class="api-info">
                    <div class="api-header">API Response (Preview)</div>
                    <div class="api-body">
                        { "device_id": "DEV001", "sync_time": "2025-03-06T10:15:00",
                        "records": [ { "employee_id": "NV001", "timestamp":
                        "2025-03-06T08:02:00", "type": "check_in", "verification":
                        "fingerprint" }, { "employee_id": "NV004", "timestamp":
                        "2025-03-06T07:50:00", "type": "check_in", "verification":
                        "fingerprint" }, // ... more records ], "status": "success" }
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button onclick="closeModal('syncModal')">Đóng</button>
                <button class="success">Đồng bộ ngay</button>
            </div>
        </div>
    </div>

    <!-- Modal thêm thiết bị -->
    <div id="deviceModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title">Thêm thiết bị chấm công mới</div>
                <div class="modal-close" onclick="closeModal('deviceModal')">
                    &times;
                </div>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <div class="form-label">Mã thiết bị</div>
                    <input
                        type="text"
                        class="form-input"
                        placeholder="Nhập mã thiết bị..." />
                </div>
                <div class="form-group">
                    <div class="form-label">Loại thiết bị</div>
                    <select class="form-input">
                        <option>Máy vân tay</option>
                        <option>Máy quét QR Code</option>
                        <option>Máy nhận diện khuôn mặt</option>
                        <option>Ứng dụng Mobile</option>
                    </select>
                </div>
                <div class="form-group">
                    <div class="form-label">Vị trí</div>
                    <input
                        type="text"
                        class="form-input"
                        placeholder="Nhập vị trí lắp đặt..." />
                </div>
                <div class="form-group">
                    <div class="form-label">API Endpoint</div>
                    <input type="text" class="form-input" placeholder="https://..." />
                </div>
                <div class="form-group">
                    <div class="form-label">API Key</div>
                    <input
                        type="text"
                        class="form-input"
                        placeholder="Nhập API key..." />
                </div>
                <div class="form-group">
                    <div class="form-label">Tần suất đồng bộ</div>
                    <select class="form-input">
                        <option>5 phút</option>
                        <option>15 phút</option>
                        <option>30 phút</option>
                        <option>1 giờ</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button onclick="closeModal('deviceModal')">Huỷ</button>
                <button class="success">Lưu thiết bị</button>
            </div>
        </div>
    </div>


</div>
<script>
    // Hiện modal chi tiết
    function showDetailModal() {
        document.getElementById("detailModal").style.display = "flex";
    }

    // Hiện modal đồng bộ
    function showSyncModal() {
        document.getElementById("syncModal").style.display = "flex";
    }

    // Hiện modal thiết bị
    function showDeviceModal() {
        document.getElementById("deviceModal").style.display = "flex";
    }

    // Đóng modal
    function closeModal(id) {
        document.getElementById(id).style.display = "none";
    }
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>