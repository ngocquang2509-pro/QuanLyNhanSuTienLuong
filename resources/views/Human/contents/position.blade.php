<div class="col-md-10 p-4">
    @if(session('success'))
    <div class="alert alert-success" role="alert">
        {{session('success')}}
    </div>
    @endif
    <nav class="navbar px-3">
        <h3 class="">QUẢN LÝ CHỨC VỤ</h3>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPositionModal"> Thêm chức vụ</button>
    </nav>
    <table class="table table-bordered table-hover">
        <thead>
            <th>Mã chức vụ</th>
            <th>Tên chức vụ</th>
            <th>Lương cơ bản</th>
            <th>Hành động</th>
        </thead>
        <tbody>
            @foreach($positions as $position)
            <tr>
                <td>{{$position->id}}</td>
                <td>{{$position->TenChucVu}}</td>
                <td>{{$position->LuongCoBan}}</td>

                <td>
                    <button class="btn btn-warning mx-2 EditPosition "
                        data-id="{{$position->id}}"
                        data-namePosition="{{$position->TenChucVu}}"
                        data-nameSalaryBase="{{$position->LuongCoBan}}"
                        data-PC-Chuc-vu="{{$position->PC_Chuc_vu}}"
                        data-PC-Trach-nhiem="{{$position->PC_Trach_nhiem}}"
                        data-bs-toggle="modal" data-bs-target="#editPositionModal"><i class="fa-solid fa-pen"></i></button>
                    <button class="btn btn-danger mx-2 DeletePosition"
                        data-id="{{$position->id}}"
                        data-bs-toggle="modal" data-bs-target="#deletePositionModal"><i class="fa-solid fa-trash"></i></button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="modal fade" id="addPositionModal" tabindex="-1" aria-labelledby="addPositionModalLabel" aria-hidden="true">
        <form class="modal-dialog" action="{{route('Human.positionAdd')}}" method="POST">
            @csrf

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPositionModalLabel">Thêm chức vụ mới</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="mb-3">
                        <label for="positionName" class="form-label">Tên chức vụ</label>
                        <input type="text" class="form-control" placeholder="Nhập tên chức vụ" required name="TenChucVu">
                    </div>
                    <div class="mb-3">
                        <label for="positionName" class="form-label">Lương cơ bản</label>
                        <input type="text" class="form-control" placeholder="Nhập lương cơ bản" required name="LuongCoBan">
                    </div>
                    <div class="mb-3">
                        <label for="positionName" class="form-label">Phụ cấp chức vụ</label>
                        <input type="text" class="form-control" placeholder="Nhập tên chức vụ" required name="PC_Chuc_vu">
                    </div>
                    <div class="mb-3">
                        <label for="positionName" class="form-label">Phụ cấp trách nhiệm</label>
                        <input type="text" class="form-control" placeholder="Nhập lương cơ bản" required name="PC_Trach_nhiem">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary" id="savePosition">Lưu</button>
                </div>
            </div>
        </form>
    </div>
    <div class="modal fade" id="editPositionModal" tabindex="-1" aria-labelledby="editPositionModalLabel" aria-hidden="true">
        <form id="EditForm" class="modal-dialog" action="" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPositionModalLabel">Sửa thông tin chức vụ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="mb-3">
                        <label for="positionName" class="form-label">Tên chức vụ</label>
                        <input type="text" id="TenChucVu" class="form-control" placeholder="Nhập tên chức vụ" required name="TenChucVu">
                    </div>
                    <div class="mb-3">
                        <label for="positionName" class="form-label">Lương cơ bản</label>
                        <input type="text" id="LuongCoBan" class="form-control" placeholder="Nhập lương cơ bản" required name="LuongCoBan">
                    </div>
                    <div class="mb-3">
                        <label for="positionName" class="form-label">Phụ cấp chức vụ</label>
                        <input type="text" id="PC_Chuc_vu" class="form-control" placeholder="Nhập tên chức vụ" required name="PC_Chuc_vu">
                    </div>
                    <div class="mb-3">
                        <label for="positionName" class="form-label">Phụ cấp trách nhiệm</label>
                        <input type="text" id="PC_Trach_nhiem" class="form-control" placeholder="Nhập lương cơ bản" required name="PC_Trach_nhiem">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary" id="savePosition">Lưu</button>
                </div>
            </div>
        </form>
    </div>
    <div class="modal fade" id="deletePositionModal" tabindex="-1" aria-labelledby="deletePositionModalLabel" aria-hidden="true">
        <form id="deleteForm" class="modal-dialog" action="" method="POST">
            @csrf
            @method('DELETE')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPositionModalLabel">Bạn có muốn xóa chức vụ?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-danger" id="savePosition">Xóa</button>
                </div>
            </div>
        </form>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const viewButtons = document.querySelectorAll(".EditPosition");
            viewButtons.forEach(button => {
                button.addEventListener("click", function() {
                    const id = button.getAttribute("data-id");
                    const namePosition = button.getAttribute("data-namePosition");
                    const salaryBase = button.getAttribute("data-nameSalaryBase");
                    const PC_Chuc_vu = button.getAttribute("data-PC-Chuc-vu");
                    const PC_Trach_nhiem = button.getAttribute("data-PC-Trach-nhiem");
                    const form = document.getElementById("EditForm");
                    document.querySelector("#TenChucVu").value = namePosition;
                    document.querySelector("#LuongCoBan").value = salaryBase;
                    document.querySelector("#PC_Chuc_vu").value = PC_Chuc_vu;
                    document.querySelector("#PC_Trach_nhiem").value = PC_Trach_nhiem;
                    form.action = `/ManagerPS/${id}`;
                });
            });
        });
        document.addEventListener("DOMContentLoaded", function() {
            const viewButtons = document.querySelectorAll(".DeletePosition");
            viewButtons.forEach(button => {
                button.addEventListener("click", function() {
                    const id = button.getAttribute("data-id");
                    const form = document.getElementById("deleteForm");
                    form.action = `/ManagerPS/${id}`;
                });
            });
        });
    </script>
</div>