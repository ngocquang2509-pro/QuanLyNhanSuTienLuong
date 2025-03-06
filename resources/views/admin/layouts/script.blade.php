<script>
    // Dữ liệu mẫu
    const months = ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6'];
    const revenue = [150, 180, 165, 190, 185, 200];
    const costs = [80, 95, 85, 100, 95, 105];
    const profit = revenue.map((r, i) => r - costs[i]);

    // Biểu đồ đường
    new Chart(document.getElementById('lineChart'), {
        type: 'line',
        data: {
            labels: months,
            datasets: [{
                label: 'Doanh thu',
                data: revenue,
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.1,
                fill: false
            }, {
                label: 'Chi phí',
                data: costs,
                borderColor: 'rgb(255, 99, 132)',
                tension: 0.1,
                fill: false
            }]
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Xu hướng doanh thu và chi phí (Triệu VNĐ)'
                }
            }
        }
    });

    // Biểu đồ cột
    new Chart(document.getElementById('barChart'), {
        type: 'bar',
        data: {
            labels: months,
            datasets: [{
                label: 'Lợi nhuận',
                data: profit,
                backgroundColor: 'rgba(75, 192, 192, 0.5)',
                borderColor: 'rgb(75, 192, 192)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Lợi nhuận theo tháng (Triệu VNĐ)'
                }
            }
        }
    });

    // Biểu đồ tròn
    new Chart(document.getElementById('pieChart'), {
        type: 'pie',
        data: {
            labels: ['Nhân sự', 'Vận hành', 'Marketing', 'Khác'],
            datasets: [{
                data: [40, 25, 20, 15],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.5)',
                    'rgba(54, 162, 235, 0.5)',
                    'rgba(255, 206, 86, 0.5)',
                    'rgba(75, 192, 192, 0.5)'
                ],
                borderColor: [
                    'rgb(255, 99, 132)',
                    'rgb(54, 162, 235)',
                    'rgb(255, 206, 86)',
                    'rgb(75, 192, 192)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Phân bổ chi phí (%)'
                }
            }
        }
    });
</script>