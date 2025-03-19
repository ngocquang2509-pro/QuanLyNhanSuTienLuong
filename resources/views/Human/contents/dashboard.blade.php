<link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css"
    rel="stylesheet" />
<!-- Biểu đồ với Chart.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js"></script>
<style>
    .card {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: 0.3s;
    }

    .card:hover {
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }

    .header {
        background-color: #f8f9fa;
        padding: 20px 0;
        margin-bottom: 30px;
    }

    .chart-container {
        position: relative;
        height: 300px;
        margin-bottom: 30px;
    }

    .summary-card {
        text-align: center;
        padding: 20px;
        border-radius: 10px;
    }

    .on-time {
        background-color: rgba(75, 192, 192, 0.2);
        border: 1px solid rgba(75, 192, 192, 1);
    }

    .late {
        background-color: rgba(255, 99, 132, 0.2);
        border: 1px solid rgba(255, 99, 132, 1);
    }

    .absent {
        background-color: rgba(255, 206, 86, 0.2);
        border: 1px solid rgba(255, 206, 86, 1);
    }
</style>
<div class="col-md-10 ">
    <input type="hidden" data-department="{{$department->id}}" id="departmentData">
    <input type="hidden" data-dateWork="{{$dateWork}}" id="dateWorkData" value="{{$dateWork}}">
    <input type="hidden" data-dataset1="@json($dataset1)" id="dataset1" value="@json($dataset1)">
    <input type="hidden" data-dataset2="@json($dataset2)" id="dataset2" value="@json($dataset2)">
    <input type="hidden" data-dataset3="@json($dataset3)" id="dataset3" value="@json($dataset3)">
    <input type="hidden" data-datasetDeparment1="@json($datasetDeparment1)" id="datasetDeparment1" value="@json($datasetDeparment1)">
    <input type="hidden" data-datasetDeparment2="@json($datasetDeparment2)" id="datasetDeparment2" value="@json($datasetDeparment2)">
    <input type="hidden" data-datasetDeparment3="@json($datasetDeparment3)" id="datasetDeparment3" value="@json($datasetDeparment3)">



    <!-- Header -->
    <div class="header">
        <div class="container">
            <h1 class="text-center">Thống kê chấm công nhân viên</h1>
            <p class="text-center text-muted">
                Dữ liệu được cập nhật đến ngày: <span id="currentDate"></span>
            </p>
        </div>
    </div>

    <!-- Main content -->
    <div class="container">
        <!-- Bộ lọc -->
        <form class="row mb-4" action="{{route('Human.dashboard')}}" method="get">
            <div class="col-md-3">
                <label for="departmentFilter" class="form-label">Phòng ban:</label>
                <select class="form-select" id="department" name="department">
                    @foreach($departments as $department)
                    <option value="{{$department->id}}">{{$department->TenPhongBan}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label for="dateRangeFilter" class="form-label">Khoảng thời gian:</label>
                <input type="text" readonly value="Tuần" class="form-control">
            </div>
            <div class="col-md-3">
                <label for="dateWork" class="form-label">Ngày làm việc:</label>
                <input type="date" class="form-control" id="dateWork" name="dateWork" />
            </div>
            <div class="col-md-3">
                <label for="dateWork" class="form-label">Lọc:</label>

                <button type="submit" class="btn btn-primary form-control">Lọc</button>
            </div>
        </form>

        <!-- Thống kê tổng quan -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="summary-card on-time">
                    <h3>Đúng giờ</h3>
                    <p><span id="onTimeNumber">{{$nhanviendunggio}}</span> nhân viên</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="summary-card late">
                    <h3>Đi muộn</h3>

                    <p><span id="lateNumber">{{$nhanviendimuon}}</span> nhân viên</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="summary-card absent">
                    <h3>Vắng mặt</h3>
                    <p><span id="absentNumber">{{$nhanvienvangmat}}</span> nhân viên</p>
                </div>
            </div>
        </div>

        <!-- Biểu đồ -->
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Tình hình chấm công theo ngày</h5>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="dailyChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Phân bổ trạng thái chấm công</h5>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="pieChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Biểu đồ theo phòng ban -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Tình hình chấm công theo phòng ban</h5>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="departmentChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>



    </div>

    <!-- Footer -->
    <footer class="mt-5 py-3 bg-light">
        <div class="container text-center">
            <p class="text-muted">© 2025 Hệ thống quản lý chấm công</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Dữ liệu mẫu
        const dataset1 = JSON.parse(document.getElementById("dataset1").getAttribute("data-dataset1"));
        const dataset2 = JSON.parse(document.getElementById("dataset2").getAttribute("data-dataset2"));
        const dataset3 = JSON.parse(document.getElementById("dataset3").getAttribute("data-dataset3"));
        console.log(dataset1);
        console.log(dataset2);
        console.log(dataset3);
        const attendanceData = {
            labels: [
                "Thứ 2",
                "Thứ 3",
                "Thứ 4",
                "Thứ 5",
                "Thứ 6",
                "Thứ 7",
                "Chủ nhật",
            ],

            datasets: [{
                    label: "Đúng giờ",
                    data: dataset1,
                    backgroundColor: "rgba(75, 192, 192, 0.5)",
                    borderColor: "rgba(75, 192, 192, 1)",
                    borderWidth: 1,
                },
                {
                    label: "Đi muộn",
                    data: dataset2,
                    backgroundColor: "rgba(255, 99, 132, 0.5)",
                    borderColor: "rgba(255, 99, 132, 1)",
                    borderWidth: 1,
                },
                {
                    label: "Vắng mặt",
                    data: dataset3,
                    backgroundColor: "rgba(255, 206, 86, 0.5)",
                    borderColor: "rgba(255, 206, 86, 1)",
                    borderWidth: 1,
                },
            ],
        };

        const pieData = {
            labels: ["Đúng giờ", "Đi muộn", "Vắng mặt"],
            datasets: [{
                data: [75, 20, 5],
                backgroundColor: [
                    "rgba(75, 192, 192, 0.5)",
                    "rgba(255, 99, 132, 0.5)",
                    "rgba(255, 206, 86, 0.5)",
                ],
                borderColor: [
                    "rgba(75, 192, 192, 1)",
                    "rgba(255, 99, 132, 1)",
                    "rgba(255, 206, 86, 1)",
                ],
                borderWidth: 1,
            }, ],
        };

        const departmentData = {
            labels: [
                " Hành chính",
                " Kế toán",
                " Nhân sự",
                " Kinh doanh",
                " Kĩ thuật",
                " Sản xuất",
                " Nghiên cứu và phát triển",
            ],
            datasets: [{
                    label: "Đúng giờ",
                    data: [50, 40, 30, 30, 20, 30, 50],
                    backgroundColor: "rgba(75, 192, 192, 0.5)",
                    borderColor: "rgba(75, 192, 192, 1)",
                    borderWidth: 1,
                },
                {
                    label: "Đi muộn",
                    data: [70, 80, 90, 70, 100, 90, 60],
                    backgroundColor: "rgba(255, 99, 132, 0.5)",
                    borderColor: "rgba(255, 99, 132, 1)",
                    borderWidth: 1,
                },
                {
                    label: "Vắng mặt",
                    data: [0, 0, 0, 0, 0, 0, 0],
                    backgroundColor: "rgba(255, 206, 86, 0.5)",
                    borderColor: "rgba(255, 206, 86, 1)",
                    borderWidth: 1,
                },
            ],
        };



        // Hiện thị ngày hiện tại
        document.getElementById("currentDate").textContent =
            new Date().toLocaleDateString("vi-VN");

        // Khởi tạo biểu đồ
        window.onload = function() {
            document.getElementById("department").value = document.getElementById("departmentData").getAttribute("data-department");
            document.getElementById("dateWork").value = document.getElementById("dateWorkData").getAttribute("data-dateWork");
            // Biểu đồ dữ liệu theo ngày
            const dailyCtx = document.getElementById("dailyChart").getContext("2d");
            const dailyChart = new Chart(dailyCtx, {
                type: "bar",
                data: attendanceData,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            stacked: true,
                        },
                        y: {
                            stacked: true,
                            beginAtZero: true,
                        },
                    },
                },
            });

            // Biểu đồ tròn
            const pieCtx = document.getElementById("pieChart").getContext("2d");
            const pieChart = new Chart(pieCtx, {
                type: "pie",
                data: pieData,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: "bottom",
                        },
                    },
                },
            });

            // Biểu đồ phòng ban
            const deptCtx = document
                .getElementById("departmentChart")
                .getContext("2d");
            const deptChart = new Chart(deptCtx, {
                type: "bar",
                data: departmentData,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            grid: {
                                display: false,
                            },
                        },
                        y: {
                            beginAtZero: true,
                            max: 100,
                            ticks: {
                                callback: function(value) {
                                    return value + "%";
                                },
                            },
                        },
                    },
                },
            });

            // Hiển thị dữ liệu chi tiết
            const attendanceTable = document.getElementById("attendanceData");
            employeeData.forEach((employee) => {
                const row = document.createElement("tr");

                // Thêm màu cho trạng thái
                let statusClass = "";
                if (employee.status === "Đúng giờ") {
                    statusClass = "text-success";
                } else if (employee.status === "Đi muộn") {
                    statusClass = "text-danger";
                } else {
                    statusClass = "text-warning";
                }

                row.innerHTML = `
                    <td>${employee.id}</td>
                    <td>${employee.name}</td>
                    <td>${employee.department}</td>
                    <td>${employee.date}</td>
                    <td>${employee.time}</td>
                    <td class="${statusClass}">${employee.status}</td>
                `;
                attendanceTable.appendChild(row);
            });

            // Xử lý sự kiện thay đổi bộ lọc
            document
                .getElementById("departmentFilter")
                .addEventListener("change", updateCharts);
            document
                .getElementById("dateRangeFilter")
                .addEventListener("change", updateCharts);
            document
                .getElementById("startDate")
                .addEventListener("change", updateCharts);
            document
                .getElementById("endDate")
                .addEventListener("change", updateCharts);

            // Xử lý nút xuất dữ liệu
            document
                .getElementById("exportBtn")
                .addEventListener("click", function() {
                    alert("Đang xuất dữ liệu ra file Excel...");
                });
        };

        // Hàm cập nhật biểu đồ dựa trên bộ lọc
        function updateCharts() {
            // Trong một ứng dụng thực tế, bạn sẽ gọi API để lấy dữ liệu mới
            // Ở đây chúng tôi chỉ giả lập thay đổi dữ liệu
            alert("Đang cập nhật dữ liệu theo bộ lọc...");
        }
    </script>
</div>