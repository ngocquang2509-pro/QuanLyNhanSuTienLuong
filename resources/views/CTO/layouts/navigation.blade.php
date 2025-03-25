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
            <a href="{{route('Human.dashboard')}}" class="nav-link">Bảng thống kê chấm công</a>
        </li>
        <li class="nav-item">
            <a href="{{route('Human.chartHuman')}}" class="nav-link">Bảng thống kê nhân sự </a>
        </li>
        <li class="nav-item">
            <a href="{{route('Accounting.dashboard')}}" class="nav-link">Bảng thống kê lương </a>
        </li>
        <li class="nav-item">
            <a href="{{route('Accounting.salary')}}" class="nav-link">Bảng lương chi tiết </a>
        </li>
    </ul>
</div>