<link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css"
    rel="stylesheet" />
<!-- Font Awesome for icons -->
<link
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
    rel="stylesheet" />
<style>
    .stat-card {
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
    }

    .stat-icon {
        font-size: 2.5rem;
        padding: 15px;
        border-radius: 50%;
        margin-bottom: 15px;
    }

    .chart-container {
        height: 300px;
        margin-top: 20px;
    }

    .header-section {
        background-color: #f8f9fa;
        padding: 20px 0;
        border-bottom: 1px solid #e9ecef;
    }

    .salary-stat {
        padding: 10px;
        border-radius: 5px;
        margin: 5px 0;
        font-weight: bold;
    }
</style>
<div class="col-md-10 p4">
    <div class="header-section">
        <div class="container">
            <h1 class="text-center mb-0">Thống Kê Nhân Sự</h1>
            <p class="text-center text-muted">
                Cập nhật ngày: <span id="currentDate"></span>
            </p>
        </div>
    </div>
    <!-- Main Content -->
    <div class="container mt-4">
        <div class="row">
            <!-- Total Employees Card -->
            <div class="col-md-6 mb-4">
                <div class="card stat-card bg-white">
                    <div class="card-body text-center">
                        <div class="stat-icon bg-primary text-white mx-auto">
                            <i class="fas fa-users"></i>
                        </div>
                        <h5 class="card-title">Số lượng nhân sự hiện có</h5>
                        <h2 class="card-text" id="totalEmployees">{{$nhanviens}}</h2>
                        <div class="progress mt-2">
                            <div
                                class="progress-bar bg-primary"
                                role="progressbar"
                                style="width: 75%"></div>
                        </div>
                        <small class="text-muted mt-2 d-block">75% so với chỉ tiêu</small>
                    </div>
                </div>
            </div>

            <!-- Salary Statistics Card -->
            <div class="col-md-6 mb-4">
                <div class="card stat-card">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Phân bố nhân sự theo phòng ban</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="departmentChart" class="chart-container"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="row mt-2">

            <div class="col-md-6 mb-4">
                <div class="card stat-card">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Biến động nhân sự theo tháng</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="employeeChangeChart" class="chart-container"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detailed Information Table -->

    </div>

    <!-- Footer -->


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Chart.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>

    <script>
        // Set current date
        document.getElementById("currentDate").textContent =
            new Date().toLocaleDateString("vi-VN");

        // Sample data for employees
        const sampleEmployees = [{
                id: 1,
                name: "Nguyễn Văn A",
                department: "IT",
                position: "Developer",
                salary: 15000000,
                status: "Đang làm việc",
            },
            {
                id: 2,
                name: "Trần Thị B",
                department: "HR",
                position: "Manager",
                salary: 20000000,
                status: "Đang làm việc",
            },
            {
                id: 3,
                name: "Lê Văn C",
                department: "Marketing",
                position: "Specialist",
                salary: 12000000,
                status: "Đang làm việc",
            },
            {
                id: 4,
                name: "Phạm Thị D",
                department: "Finance",
                position: "Accountant",
                salary: 13000000,
                status: "Đang làm việc",
            },
            {
                id: 5,
                name: "Hoàng Văn E",
                department: "Sales",
                position: "Executive",
                salary: 18000000,
                status: "Nghỉ phép",
            },
        ];

        // Populate employee table


        // Department Distribution Chart
        const deptCtx = document
            .getElementById("departmentChart")
            .getContext("2d");
        const departmentChart = new Chart(deptCtx, {
            type: "pie",
            data: {
                labels: ["Hành chính", "Kế toán", "Nhân sự", "Kinh doanh", "Kĩ thuật", "Sản xuất", "Nghiên cứu và phát triển"],
                datasets: [{
                    data: [10, 10, 10, 10, 10, 10, 10],
                    backgroundColor: [
                        "#4e73df",
                        "#1cc88a",
                        "#36b9cc",
                        "#f6c23e",
                        "#e74a3b",
                        "#333",
                        "purple",
                    ],
                    hoverBackgroundColor: [
                        "#2e59d9",
                        "#17a673",
                        "#2c9faf",
                        "#dda20a",
                        "#be2617", "#333",
                        "purple",
                    ],
                    hoverBorderColor: "rgba(234, 236, 244, 1)",
                }, ],
            },
            options: {
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: "bottom",
                    },
                },
            },
        });

        // Employee Change Chart
        const changeCtx = document
            .getElementById("employeeChangeChart")
            .getContext("2d");
        const employeeChangeChart = new Chart(changeCtx, {
            type: "line",
            data: {
                labels: [
                    "Tháng 1",
                    "Tháng 2",
                    "Tháng 3",
                    "Tháng 4",
                    "Tháng 5",
                    "Tháng 6",
                ],
                datasets: [{
                    label: "Tổng số nhân viên",
                    lineTension: 0.3,
                    backgroundColor: "rgba(78, 115, 223, 0.05)",
                    borderColor: "rgba(78, 115, 223, 1)",
                    pointRadius: 3,
                    pointBackgroundColor: "rgba(78, 115, 223, 1)",
                    pointBorderColor: "rgba(78, 115, 223, 1)",
                    pointHoverRadius: 3,
                    pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                    pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                    pointHitRadius: 10,
                    pointBorderWidth: 2,
                    data: [100, 105, 115, 110, 120, 125],
                    fill: true,
                }, ],
            },
            options: {
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: false,
                        min: 90,
                    },
                },
                plugins: {
                    legend: {
                        display: true,
                        position: "bottom",
                    },
                },
            },
        });
    </script>
</div>