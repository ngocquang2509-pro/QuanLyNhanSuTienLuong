<style>
    .nav-link.toggle-submenu {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .nav-link.toggle-submenu i.fas.fa-chevron-down,
    .nav-link.toggle-submenu i.fas.fa-chevron-up {
        transition: transform 0.3s ease;
    }

    .nav-item .collapse.show {
        display: block;
    }

    .nav-item .collapse {
        transition: all 0.3s ease;
    }
</style>
<div class="col-md-2 sidebar">
    <div class="d-flex align-items-center mb-4 px-3">
        <i class="fa-solid fa-user-tie mx-3"></i>
        <div>
            <span class="fw-bold">{{Auth::user()->name}} </span>

        </div>
    </div>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link " href="{{route('admin.dashboard')}}">
                <i class="fas fa-dollar-sign me-2"></i> Quản lý tài khoản

            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link toggle-submenu" href="#employeeSubmenu" data-bs-toggle="collapse" aria-expanded="false">
                <i class="fas fa-users me-2"></i> Quản lý nhân sự
                <i class="fas fa-chevron-down ms-auto"></i>
            </a>
            <ul class="collapse nav flex-column ms-4" id="employeeSubmenu">
                <li class="nav-item">
                    <a class="nav-link" href="{{route('Human.dashboard')}}">
                        <i class="fas fa-list me-2"></i> Biểu đồ chấm công
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('Human.Manager')}}">
                        <i class="fas fa-list me-2"></i> Quản lý nhân sự
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('Human.ManagerDP')}}">
                        <i class="fas fa-user-plus me-2"></i> Quản lý phòng ban
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('Human.ManagerPS')}}">
                        <i class="fas fa-user-plus me-2"></i> Quản lý chức vụ
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('Human.ShiftManager')}}">
                        <i class="fas fa-chart-bar me-2"></i> Quản lý ca làm việc
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('Human.WorkSchedule')}}">
                        <i class="fas fa-chart-bar me-2"></i> Quản lý lịch làm việc
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('Human.Timekeeping')}}">
                        <i class="fas fa-chart-bar me-2"></i> Quản lý chấm công
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a class="nav-link toggle-submenu" href="#salarySubmenu" data-bs-toggle="collapse" aria-expanded="false">
                <i class="fas fa-dollar-sign me-2"></i> Quản lý tiền lương
                <i class="fas fa-chevron-down ms-auto"></i>
            </a>
            <ul class="collapse nav flex-column ms-4" id="salarySubmenu">
                <li class="nav-item">
                    <a class="nav-link" href="{{route('Accounting.dashboard')}}">
                        <i class="fas fa-list me-2"></i>Biểu đồ lương
                    </a>
                    <a class="nav-link" href="{{route('Accounting.salary')}}">
                        <i class="fas fa-list me-2"></i> Danh sách lương
                    </a>
                </li>
        </li>
    </ul>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Xử lý sự kiện khi click vào menu có submenu
        const toggleSubmenus = document.querySelectorAll('.toggle-submenu');

        toggleSubmenus.forEach(function(toggle) {
            toggle.addEventListener('click', function(e) {
                e.preventDefault();
                const target = this.getAttribute('href');
                const submenu = document.querySelector(target);
                submenu.classList.toggle('show');

                // Đổi icon mũi tên
                const arrow = this.querySelector('.fas.fa-chevron-down');
                if (arrow) {
                    arrow.classList.toggle('fa-chevron-down');
                    arrow.classList.toggle('fa-chevron-up');
                }
            });
        });
    });
</script>