<div class="col-md-10 p4">
    <div class="container mt-5">
        <div class="row">
            <!-- Biểu đồ đường -->
            <div class="col-md-12 mb-4">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-chart-line me-2"></i>Xu hướng doanh thu và chi phí</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="lineChart" height="100"></canvas>
                    </div>
                </div>
            </div>

            <!-- Biểu đồ cột -->
            <div class="col-md-6 mb-4">
                <div class="card shadow">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Lợi nhuận theo tháng</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="barChart" height="200"></canvas>
                    </div>
                </div>
            </div>

            <!-- Biểu đồ tròn -->
            <div class="col-md-6 mb-4">
                <div class="card shadow">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="fas fa-chart-pie me-2"></i>Phân bổ chi phí</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="pieChart" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>