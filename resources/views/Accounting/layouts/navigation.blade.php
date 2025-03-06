<div class="col-md-2 sidebar">
    <div class="d-flex align-items-center mb-4 px-3">
        <i class="fa-solid fa-user-tie mx-3"></i>
        <div>
            <span class="fw-bold">{{Auth::user()->name}} </span>

        </div>
    </div>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link" href="{{route('Accounting.dashboard')}}"><i class="fas fa-chart-bar me-2"></i> Bảng số liệu thống kê</a>
        </li>

        <li class="nav-item">
            <a class="nav-link toggle-submenu" href="#">
                <i class="fas fa-dollar-sign me-2"></i> Quản lý tiền lương
            </a>
            <ul class="submenu nav flex-column ps-3">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('Accounting.salary') }}">Danh sách lương</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('Accounting.payment')}}">Thanh toán lương</a>
                </li>
            </ul>
        </li>

    </ul>
</div>
<style>
    .submenu {
        display: none;
        transition: all 0.3s ease;
    }

    .nav-item:hover .submenu {
        display: block;
    }
</style>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll(".toggle-submenu").forEach(item => {
            item.addEventListener("click", function(e) {
                e.preventDefault();
                let submenu = this.nextElementSibling;
                submenu.style.display = submenu.style.display === "block" ? "none" : "block";
            });
        });
    });
</script>