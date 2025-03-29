<div class="col-md-10 p-4 container my-5">
    <div class="navbar">
        <h1 class=" mb-4">Hệ Thống Thống Kê Lương {{request()->get('month')?'Tháng '.\Carbon\Carbon::parse(request('month'))->format('m/Y'):'Tháng 1/2025'}}</h1>
        <div class="d-flex justify-content-end">
            <form action="{{route('Accounting.dashboard')}}" method="GET" class="d-flex">
                <input type="month" name="month" class="form-control me-2" value="{{request()->get('month')}}">
                <button type="submit" class="btn btn-primary">Lọc</button>
            </form>
        </div>
    </div>
    <input type="hidden" id="HanhChinhAvg" data-HanhChinh="{{($HanhChinhAvg)}}">
    <input type="hidden" id="KeToanAvg" data-KeToan="{{($KeToanAvg)}}">
    <input type="hidden" id="NhanSuAvg" data-NhanSu="{{($NhanSuAvg)}}">
    <input type="hidden" id="KinhDoanhAvg" data-KinhDoanh="{{($KinhDoanhAvg)}}">
    <input type="hidden" id="KyThuatAvg" data-KiThuat="{{($KyThuatAvg)}} " value="{{$KyThuatAvg}}">
    <input type="hidden" id="SanXuatAvg" data-SanXuat="{{($SanXuatAvg)}}">
    <input type="hidden" id="NghienCuuAvg" data-NghienCuu="{{($NghienCuuAvg)}}">
    <!-- Thống kê tổng quan -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary">
                <div class="card-body text-center">
                    <h5 class="card-title">Tổng nhân viên</h5>
                    <h2 id="totalEmployees">{{$nhanviens}}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success">
                <div class="card-body text-center">
                    <h5 class="card-title">Lương TB</h5>
                    <h2 id="averageSalary">{{number_format($salaryAvg)}}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning">
                <div class="card-body text-center">
                    <h5 class="card-title">Lương cao nhất</h5>
                    <h2 id="highestSalary">{{number_format($salaryMax)}}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-danger">
                <div class="card-body text-center">
                    <h5 class="card-title">Lương thấp nhất</h5>
                    <h2 id="lowestSalary">{{number_format($salaryMin)}}</h2>
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
    const departments = ["Hành chính", "Kế toán", "Nhân sự", "Kinh doanh", "Kĩ thuật", "Sản xuất", "Nghiên cứu và phát triển"];
    const HanhChinhAvg = document.getElementById('HanhChinhAvg').getAttribute('data-HanhChinh');
    const KeToanAvg = document.getElementById('KeToanAvg').getAttribute('data-KeToan');
    const NhanSuAvg = document.getElementById('NhanSuAvg').getAttribute('data-NhanSu');
    const KinhDoanhAvg = document.getElementById('KinhDoanhAvg').getAttribute('data-KinhDoanh');
    const KyThuatAvg = document.getElementById('KyThuatAvg').getAttribute('data-KiThuat');

    const SanXuatAvg = document.getElementById('SanXuatAvg').getAttribute('data-SanXuat');
    const NghienCuuAvg = document.getElementById('NghienCuuAvg').getAttribute('data-NghienCuu');
    const salaryByDept = [HanhChinhAvg, KeToanAvg, NhanSuAvg, KinhDoanhAvg, KyThuatAvg, SanXuatAvg, NghienCuuAvg];
    const employeeCountByDept = [10, 8, 6, 9, 7];

    // Biến lưu trữ biểu đồ
    let departmentChart;

    // Khởi tạo khi trang được tải
    document.addEventListener('DOMContentLoaded', function() {
        updateStatistics();
        renderCharts();
        console.log(SanXuatAvg);
    });

    // Cập nhật thống kê
    function updateStatistics() {
        const totalEmployees = employeeCountByDept.reduce((sum, count) => sum + count, 0);

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