<style>
    .profile-modal-content {
        background-color: #f8f9fa;
    }

    .modal-header {
        background-color: #007bff;
        color: white;
    }

    .modal-header .btn-close {
        filter: invert(1) grayscale(100%) brightness(200%);
    }
</style>

<div class="col-md-10 p-4 container my-5">
    <h2 class="text-danger">Hồ sơ lương</h2>
    <div class="table-responsive">
        <table class="table table-bordered" id="nhanvienTable">
            <thead>
                <tr class="text-center">
                    <th>STT</th>
                    <th>Họ Tên</th>
                    <th>Phòng ban</th>
                    <th>Hồ sơ</th>
                </tr>
            </thead>
            <tbody>
                @php
                $groupedEmployees = $nhanviens->groupBy('phongBan.id');
                @endphp

                @foreach ($groupedEmployees as $phongBanId => $employees)
                <tr class="bg-light">
                    <td colspan="4" class="fw-bold">Phòng: {{ $employees->first()->phongBan->TenPhongBan }}</td>
                </tr>

                @foreach ($employees as $index => $nhanvien)
                <tr class="text-center">
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $nhanvien->HoTen }}</td>
                    <td>{{ $nhanvien->phongBan->TenPhongBan }}</td>
                    <td>
                        <button class="btn btn-primary viewProfileBtn"
                            data-bs-toggle="modal"
                            data-bs-target="#profileModal"
                            data-id="{{ $nhanvien->id }}">
                            <i class="fa-solid fa-eye"></i> Xem hồ sơ
                        </button>
                    </td>
                </tr>
                @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content profile-modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="profileModalLabel">Hồ Sơ Nhân Viên</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6 class="text-primary mb-3">Danh sách phiếu lương theo tháng</h6>
                <table class="table table-bordered">
                    <thead>
                        <tr class="text-center">
                            <th>Tháng</th>
                            <th>Tên nhân viên</th>
                            <th>Số ngày công</th>
                            <th>Tổng thu nhập</th>
                            <th>Tạm ứng</th>
                            <th>Còn lãnh</th>
                        </tr>
                    </thead>
                    <tbody id="profileSalaryList">
                        <!-- Dữ liệu sẽ được thêm bằng AJAX -->
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- AJAX để lấy dữ liệu lương -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll(".viewProfileBtn").forEach(button => {
            button.addEventListener("click", function() {
                let nhanvienId = this.getAttribute("data-id");

                fetch(`/luong/${nhanvienId}`)
                    .then(response => response.json())
                    .then(data => {
                        let salaryList = document.getElementById("profileSalaryList");
                        salaryList.innerHTML = "";

                        data.luong.forEach(luong => {
                            let row = `
                                <tr class="text-center">
                                    <td>${luong.Thang}</td>
                                    <td>${luong.HoTen}</td>
                                    <td>${luong.SoNgayCong}</td>
                                    <td>${luong.TongThuNhap} VND</td>
                                    <td>${luong.TamUng} VND</td>
                                    <td>${luong.ConLanh} VND</td>
                                </tr>
                            `;
                            salaryList.innerHTML += row;
                        });
                    })
                    .catch(error => console.error("Lỗi:", error));
            });
        });
    });
</script>