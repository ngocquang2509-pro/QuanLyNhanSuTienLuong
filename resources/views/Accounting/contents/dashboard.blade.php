<div class="col-md-10 p-4 container my-5">
    <h1 class="text-center mb-4">Hệ Thống Thống Kê Lương</h1>

    <!-- Thống kê tổng quan -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary">
                <div class="card-body text-center">
                    <h5 class="card-title">Tổng nhân viên</h5>
                    <h2 id="totalEmployees">0</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success">
                <div class="card-body text-center">
                    <h5 class="card-title">Lương TB</h5>
                    <h2 id="averageSalary">0</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning">
                <div class="card-body text-center">
                    <h5 class="card-title">Lương cao nhất</h5>
                    <h2 id="highestSalary">0</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-danger">
                <div class="card-body text-center">
                    <h5 class="card-title">Lương thấp nhất</h5>
                    <h2 id="lowestSalary">0</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="">
        <div class="card h-100">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">Phân Phối Lương Theo Phòng Ban</h5>
            </div>
            <div class="card-body">
                <canvas id="departmentChart" class="chart-container"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Load Chart.js from CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>

<script>
    // Dữ liệu phòng ban và lương
    const departments = ["Kỹ thuật", "Kinh doanh", "Nhân sự", "Kế toán", "Marketing"];
    const salaryByDept = [50000000, 40000000, 30000000, 45000000, 35000000];
    const employeeCountByDept = [10, 8, 6, 9, 7];

    // Biến lưu trữ biểu đồ
    let departmentChart;

    // Khởi tạo khi trang được tải
    document.addEventListener('DOMContentLoaded', function() {
        updateStatistics();
        renderCharts();
    });

    // Cập nhật thống kê
    function updateStatistics() {
        const totalEmployees = employeeCountByDept.reduce((sum, count) => sum + count, 0);
        document.getElementById('totalEmployees').textContent = totalEmployees;

        const avgSalary = salaryByDept.reduce((sum, salary) => sum + salary, 0) / salaryByDept.length;
        document.getElementById('averageSalary').textContent = formatCurrency(avgSalary);

        const maxSalary = Math.max(...salaryByDept);
        const minSalary = Math.min(...salaryByDept);

        document.getElementById('highestSalary').textContent = formatCurrency(maxSalary);
        document.getElementById('lowestSalary').textContent = formatCurrency(minSalary);
    }

    // Vẽ biểu đồ
    function renderCharts() {
        const deptCtx = document.getElementById('departmentChart').getContext('2d');
        if (departmentChart) {
            departmentChart.destroy();
        }
        departmentChart = new Chart(deptCtx, {
            type: 'bar',
            data: {
                labels: departments,
                datasets: [{
                    label: 'Lương trung bình (VNĐ)',
                    data: salaryByDept,
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgb(54, 162, 235)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return formatCompactCurrency(value);
                            }
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'Lương TB: ' + formatCurrency(context.raw);
                            }
                        }
                    }
                }
            }
        });
    }

    // Format tiền tệ
    function formatCurrency(amount) {
        return new Intl.NumberFormat('vi-VN', {
            style: 'currency',
            currency: 'VND'
        }).format(amount);
    }

    // Format tiền tệ ngắn gọn cho biểu đồ
    function formatCompactCurrency(amount) {
        if (amount >= 1000000) {
            return (amount / 1000000).toFixed(1) + ' triệu';
        }
        return amount.toLocaleString('vi-VN');
    }
</script>