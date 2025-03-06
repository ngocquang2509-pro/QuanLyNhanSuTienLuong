<div class="col-md-10 p-4">
    @if(session('success'))
    <div class="alert alert-success" role="alert">
        {{session('success')}}
    </div>
    @endif
    <nav class="navbar px-3">
        <h3 class="">QUẢN LÝ PHÒNG BAN</h3>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addDepartmentModal"> Thêm phòng ban</button>
    </nav>
    <table class="table table-bordered table-hover">
        <thead>
            <th>Mã phòng ban</th>
            <th>Tên phòng ban</th>
            <th>Số lượng nhân viên</th>
            <th>Hành động</th>
        </thead>
        <tbody>
            @foreach($departments as $department)
            <tr>
                <td>{{$department->id}}</td>
                <td>{{$department->TenPhongBan}}</td>
                <td>{{$department->nhanviens_count}}</td>
                <td>
                    <button class="btn btn-warning mx-2 EditDepartment"
                        data-id="{{$department->id}}"
                        data-nameDepartment="{{$department->TenPhongBan}}"
                        data-bs-toggle="modal" data-bs-target="#editDepartmentModal"><i class="fa-solid fa-pen"></i></button>
                    <button class="btn btn-danger mx-2 DeleteDepartment"
                        data-id="{{$department->id}}"
                        data-bs-toggle="modal" data-bs-target="#deleteDepartmentModal"><i class="fa-solid fa-trash"></i></button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="modal fade" id="addDepartmentModal" tabindex="-1" aria-labelledby="addDepartmentModalLabel" aria-hidden="true">
        <form class="modal-dialog" action="{{route('Human.departmentAdd')}}" method="POST">
            @csrf

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addDepartmentModalLabel">Thêm phòng ban mới</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="mb-3">
                        <label for="departmentName" class="form-label">Tên phòng ban</label>
                        <input type="text" class="form-control" placeholder="Nhập tên phòng ban" required name="TenPhongBan">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary" id="saveDepartment">Lưu</button>
                </div>
            </div>
        </form>
    </div>
    <div class="modal fade" id="editDepartmentModal" tabindex="-1" aria-labelledby="editDepartmentModalLabel" aria-hidden="true">
        <form id="EditForm" class="modal-dialog" action="" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addDepartmentModalLabel">Sửa thông tin phòng ban</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="mb-3">
                        <label for="departmentName" class="form-label">Tên phòng ban</label>
                        <input type="text" class="form-control" id="departmentName" placeholder="Nhập tên phòng ban" required name="TenPhongBan">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary" id="saveDepartment">Lưu</button>
                </div>
            </div>
        </form>
    </div>
    <div class="modal fade" id="deleteDepartmentModal" tabindex="-1" aria-labelledby="deleteDepartmentModalLabel" aria-hidden="true">
        <form id="deleteForm" class="modal-dialog" action="" method="POST">
            @csrf
            @method('DELETE')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addDepartmentModalLabel">Bạn có muốn xóa phòng ban?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-danger" id="saveDepartment">Xóa</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const viewButtons = document.querySelectorAll(".EditDepartment");
        viewButtons.forEach(button => {
            button.addEventListener("click", function() {
                const id = button.getAttribute("data-id");
                const nameDepartment = button.getAttribute("data-nameDepartment");
                const form = document.getElementById("EditForm");
                document.querySelector("#departmentName").value = nameDepartment;
                form.action = `/ManagerDP/${id}`;
            });
        });
    });
    document.addEventListener("DOMContentLoaded", function() {
        const viewButtons = document.querySelectorAll(".DeleteDepartment");
        viewButtons.forEach(button => {
            button.addEventListener("click", function() {
                const id = button.getAttribute("data-id");
                const form = document.getElementById("deleteForm");
                form.action = `/ManagerDP/${id}`;
            });
        });
    });
</script>