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

<div class="col-md-10 p-4">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <h3 class="navbar-brand">Thanh Toán Lương</h3>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarControls">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarControls">
                <form class="d-flex align-items-center ms-auto gap-3" action="{{route('Accounting.payment')}}" method="GET">
                    <input type="month" class="form-control" id="monthSelect" style="width: 200px;"
                        value="{{ date('Y-m') }}">
                    <select class="form-select" style="width: 200px;" id="departmentSelect" name="department">
                        <option value="">Chọn Phòng Ban</option>
                        @foreach($departments as $departmen)
                        <option value="{{ $departmen->TenPhongBan }}">{{ $departmen->TenPhongBan }}</option>
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
                </tr>
            </thead>
            <tbody>
                @if(empty($salaries))
                <tr>
                    <td colspan="6" class="empty-table">
                        <i class="fa-solid fa-filter me-2"></i>
                        Vui lòng chọn phòng ban và tháng để xem danh sách thanh toán lương
                    </td>
                </tr>
                @else
                @php
                $totalSalary = 0;
                @endphp
                @foreach($salaries as $key => $salary)
                @php
                $totalSalary += $salary->con_lanh;
                @endphp
                <tr class="text-center">
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $salary->id }}</td>
                    <td>{{ $salary->HoTen }}</td>
                    <td>{{ ($salary->con_lanh)!= 0 ? number_format($salary->con_lanh) : number_format($salary-> TongThuNhap) }} VNĐ</td>
                    <td class="{{$salary->TrangThai ==1 ?'text-success':'text-warning'}}">
                        {{$salary->TrangThai ==1 ?'Đã thanh toán':'Chưa thanh toán'}}

                    </td>
                </tr>
                @endforeach
                <!-- Dòng tổng lương -->
                <tr class="text-center fw-bold bg-danger text-white">
                    <td colspan="3">Tổng Lương</td>
                    <td>{{ number_format($totalSalary) }} VNĐ</td>
                    <td class="{{$salaries[0]->TrangThai ==1 ?'text-success':'text-warning'}}">
                        {{$salaries[0]->TrangThai ==1 ?'Đã thanh toán':'Chưa thanh toán'}}

                    </td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>

    <!-- Nút Thanh Toán -->
    @if(!empty($salaries))
    <form class="text-center mt-4 " action="{{ route('Accounting.paySalary') }}" method="">
        <input type="hidden" name="status" value="confirmed">
        <input type="hidden" name="department" value="{{ $department }}">
        <button class="btn btn-success btn-lg" id="paySalaryButton">
            <i class="fa-solid fa-money-bill-wave me-2"></i> Thanh Toán Lương
        </button>

    </form>
    @endif

</div>
<script>
    let deparment = "{{ $department }}";
    document.addEventListener("DOMContentLoaded", function() {
        console.log(deparment);
        document.getElementById("departmentSelect").value = deparment;
    });
</script>