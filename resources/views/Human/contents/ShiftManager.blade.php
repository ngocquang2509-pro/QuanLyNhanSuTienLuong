<style>
    .navbar-brand {
        font-weight: bold;
    }

    .table th {
        background-color: #f8f9fa;
    }

    .action-btns {
        white-space: nowrap;
    }

    .modal-header {
        background-color: #f8f9fa;
    }

    .time-invalid {
        border-color: #dc3545;
    }
</style>
<div class="col-md-10 p-4">
    @if(session('success'))
    <div class="alert alert-success" role="alert">
        {{session('success')}}
    </div>
    @endif
    <div class=" mt-4">
        <div class="card shadow-sm mb-4">
            <div class="card-header d-flex justify-content-between align-items-center" style="background: linear-gradient(135deg, #0d6efd, #0a58ca);;">
                <h5 class="mb-0 text-light">Danh Sách Ca Làm Việc</h5>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#shiftModalAdd">
                    <i class="bi bi-plus-circle me-1"></i> Thêm Ca Mới
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr class="table-light">
                                <th scope="col" width="5%">ID</th>
                                <th scope="col" width="25%">Tên Loại Ca</th>
                                <th scope="col" width="20%">Giờ Bắt Đầu</th>
                                <th scope="col" width="20%">Giờ Kết Thúc</th>
                                <th scope="col" width="15%">Hành Động</th>
                            </tr>
                        </thead>
                        <tbody id="shiftTableBody">
                            @foreach($shifts as $shift)
                            <tr>
                                <td>{{$shift->id}}</td>
                                <td>{{ $shift->TenLoaiCa }}</td>
                                <td>{{ $shift->Giobatdau }}</td>
                                <td>{{ $shift->Gioketthuc }}</td>

                                <td>
                                    <button class="btn btn-warning mx-2 EditBtn"
                                        data-id="{{$shift->id}}"
                                        data-name="{{$shift->TenLoaiCa}}"
                                        data-timeStart="{{$shift->Giobatdau}}"
                                        data-timeEnd="{{$shift->Gioketthuc}}"
                                        data-bs-toggle="modal" data-bs-target="#shiftModalEdit"><i class="fa-solid fa-pen"></i></button>
                                    <button class="btn btn-danger mx-2 DeleteBtn"
                                        data-id="{{$shift->id}}"
                                        data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="fa-solid fa-trash"></i></button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Add/Edit -->
    <div class="modal fade" id="shiftModalAdd" tabindex="-1" aria-labelledby="shiftModalLabel" aria-hidden="true">
        <form class="modal-dialog" action="{{route('Human.ShiftManagerAdd')}}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="shiftModalLabel">Thêm Ca Làm Việc</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="shiftId">
                    <div class="mb-3">
                        <label for="shiftName" class="form-label">Tên Loại Ca</label>
                        <input type="text" class="form-control" name="TenLoaiCa" required>
                    </div>
                    <div class="mb-3">
                        <label for="startTime" class="form-label">Giờ Bắt Đầu</label>
                        <input type="time" class="form-control" name="Giobatdau" required>
                    </div>
                    <div class="mb-3">
                        <label for="endTime" class="form-label">Giờ Kết Thúc</label>
                        <input type="time" class="form-control" name="Gioketthuc" required>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i> Hủy
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i> Thêm
                    </button>
                </div>
            </div>
        </form>
    </div>
    <div class="modal fade" id="shiftModalEdit" tabindex="-1" aria-labelledby="shiftModalLabel" aria-hidden="true">
        <form id="shiftFormEdit" class="modal-dialog" action="" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="shiftModalLabel">Sửa Thông Tin Ca Làm Việc</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="shiftId">
                    <div class="mb-3">
                        <label for="shiftName" class="form-label">Tên Loại Ca</label>
                        <input type="text" class="form-control" name="TenLoaiCa" id="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="startTime" class="form-label">Giờ Bắt Đầu</label>
                        <input type="time" class="form-control" name="Giobatdau" id="timeStart" required>
                    </div>
                    <div class="mb-3">
                        <label for="endTime" class="form-label">Giờ Kết Thúc</label>
                        <input type="time" class="form-control" name="Gioketthuc" id="timeEnd" required>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i> Hủy
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i> Lưu
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
        <form class="modal-dialog modal-dialog-centered" action="" method="POST" id="deleteForm">
            @csrf
            @method('DELETE')
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">Xác Nhận Xóa</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Bạn có chắc chắn muốn xóa ca làm việc này?</p>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i> Hủy
                    </button>
                    <button type="submit" class="btn btn-danger" id="confirmDeleteBtn">
                        <i class="bi bi-trash me-1"></i> Xóa
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Toast Notification -->
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
        <div id="liveToast" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <strong class="me-auto" id="toastTitle">Thông báo</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body" id="toastMessage"></div>
        </div>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const EditBtn = document.querySelectorAll(".EditBtn");
        const DeleteBtn = document.querySelectorAll(".DeleteBtn");
        EditBtn.forEach(button => {
            button.addEventListener("click", function() {
                const id = button.getAttribute("data-id");
                const name = button.getAttribute("data-name");
                const timeStart = button.getAttribute("data-timeStart");
                const timeEnd = button.getAttribute("data-timeEnd");
                const form = document.querySelector("#shiftFormEdit");
                document.querySelector("#shiftId").value = id;
                document.querySelector("#name").value = name;
                document.querySelector("#timeStart").value = timeStart;
                document.querySelector("#timeEnd").value = timeEnd;
                form.action = `/ShiftManager/${id}`;

            });
        });
        DeleteBtn.forEach(button => {
            button.addEventListener("click", function() {
                const id = button.getAttribute("data-id");
                const form = document.querySelector("#deleteForm");
                form.action = `/ShiftManager/${id}`;
                console.log(id);
            });
        });
    });
</script>