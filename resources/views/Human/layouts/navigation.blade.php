<div class="col-md-2 sidebar">
    <div class="d-flex align-items-center mb-4 px-3">
        <i class="fa-solid fa-user-tie mx-3"></i>
        <div>
            <span class="fw-bold">{{Auth::user()->name}} </span>

        </div>
    </div>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link" href="{{route('Human.dashboard')}}"><i class="fas fa-chart-bar me-2"></i> Bảng số liệu thống kê</a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{route('Human.Manager')}}"><i class="fas fa-users me-2 me-2"></i> Quản lý nhân sự</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{route('Human.ManagerDP')}}"><i class="fa-solid fa-building me-2 me-2"></i> Quản lý phòng ban</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{route('Human.ManagerPS')}}"><i class="fa-solid fa-suitcase me-2 me-2"></i>Quản lý chức vụ</a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{route('Human.Timekeeping')}}"><i class="fas fa-tasks me-2"></i> Quản lý chấm công</a>
        </li>

    </ul>
</div>