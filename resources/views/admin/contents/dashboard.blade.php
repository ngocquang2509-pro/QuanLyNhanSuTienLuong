<style>
    .navbarHR {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: linear-gradient(135deg, #1565C0, #0D47A1);
        color: white;
        padding: 15px 20px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .btn {
        padding: 10px 16px;
        border: none;
        cursor: pointer;
        color: white;
        border-radius: 6px;
        transition: all 0.3s ease;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .btn-add {
        background: linear-gradient(to right, #28a745, #218838);
    }

    .btn-add:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(40, 167, 69, 0.2);
    }

    /* Modal styles */
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        opacity: 0;
        transition: opacity 0.3s ease-in-out;
        backdrop-filter: blur(5px);
    }

    .modal.show {
        display: flex;
        justify-content: center;
        align-items: center;
        animation: modalFadeIn 0.3s forwards;
    }

    .modal-contentHR {
        background: white;
        padding: 30px;
        border-radius: 16px;
        width: 90%;
        max-width: 500px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        position: relative;
        margin: auto;
        transform: translateY(-50px);
        opacity: 0;
    }

    .modal.show .modal-contentHR {
        animation: modalSlideIn 0.4s 0.2s forwards;
    }

    .close {
        position: absolute;
        right: 20px;
        top: 20px;
        font-size: 24px;
        cursor: pointer;
        transition: 0.3s;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f8f9fa;
        border: none;
        color: #666;
    }

    .close:hover {
        background: #e9ecef;
        color: #dc3545;
    }

    /* Form styles */
    .modal-form {
        display: flex;
        flex-direction: column;
        gap: 20px;
        margin-top: 20px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .form-group label {
        font-weight: 500;
        color: #495057;
    }

    .form-group input {
        padding: 12px;
        border: 2px solid #e9ecef;
        border-radius: 8px;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .form-group input:focus {
        outline: none;
        border-color: #1565C0;
        box-shadow: 0 0 0 3px rgba(21, 101, 192, 0.1);
    }

    /* Password input group styles */
    .password-input-group {
        position: relative;
        display: flex;
        align-items: center;
    }

    .password-input-group input {
        padding-right: 45px;
    }

    .password-toggle {
        position: absolute;
        right: 12px;
        background: none;
        border: none;
        cursor: pointer;
        color: #6c757d;
        font-size: 18px;
        padding: 0;
        height: 20px;
        width: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: color 0.3s ease;
    }

    .password-toggle:hover {
        color: #1565C0;
    }

    .password-toggle:focus {
        outline: none;
    }

    /* Animations */
    @keyframes modalFadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    @keyframes modalSlideIn {
        from {
            transform: translateY(-50px);
            opacity: 0;
        }

        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    /* Modal header */
    .modal-header {
        margin-bottom: 24px;
        padding-bottom: 16px;
        border-bottom: 2px solid #f8f9fa;
    }

    .modal-header h3 {
        margin: 0;
        color: #1565C0;
        font-size: 24px;
    }

    /* Submit button */
    .submit-btn {
        background: linear-gradient(to right, #1565C0, #0D47A1);
        color: white;
        padding: 12px 24px;
        border: none;
        border-radius: 8px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-top: 10px;
    }

    .submit-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(21, 101, 192, 0.2);
    }

    .table-container {
        margin: 30px auto;
        padding: 0 20px;
        max-width: 1200px;
    }

    .table-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .table-title {

        font-size: 24px;
        margin: 0;
    }

    .data-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        background: white;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }



    .data-table th {
        padding: 15px;
        text-align: left;
        font-weight: 500;
        font-size: 14px;
        text-transform: uppercase;
    }

    .data-table td {
        padding: 12px 15px;
        border-bottom: 1px solid #eee;
        font-size: 14px;
    }

    .data-table tbody tr {
        transition: background-color 0.3s ease;
    }

    .data-table tbody tr:hover {
        background-color: #f8f9fa;
    }

    .data-table tbody tr:last-child td {
        border-bottom: none;
    }

    /* Status badge */
    .status-badge {
        padding: 6px 12px;
        border-radius: 50px;
        font-size: 12px;
        font-weight: 500;
        text-align: center;
        display: inline-block;
    }

    .status-active {
        background-color: #e8f5e9;
        color: #2e7d32;
    }

    .status-inactive {
        background-color: #ffebee;
        color: #c62828;
    }

    /* Action buttons */
    .action-buttons {
        display: flex;
        gap: 8px;
    }

    .action-btn {
        padding: 6px 12px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 13px;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .edit-btn {
        background-color: #fff3cd;
        color: #856404;
    }

    .edit-btn:hover {
        background-color: #ffeeba;
    }

    .delete-btn {
        background-color: #f8d7da;
        color: #721c24;
    }

    .delete-btn:hover {
        background-color: #f5c6cb;
    }

    .modal-content {
        background: white;
        padding: 20px;
        max-width: 500px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        position: relative;
        margin: auto;
        text-align: center;

    }

    .modal-buttons {
        margin-top: 15px;
    }

    .modal-buttons button {
        margin: 5px;
        padding: 10px 15px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .delete-btnMD {
        background-color: red;
        color: white;
    }

    .cancel-btnMD {
        background-color: gray;
        color: white;
    }

    /* Responsive table */
    @media (max-width: 768px) {
        .data-table {
            display: block;
            overflow-x: auto;
            white-space: nowrap;
        }
    }
    
    /* Error message styles */
    .error-message {
        color: #dc3545;
        font-size: 12px;
        margin-top: 5px;
        display: block;
    }
    
    .form-group.has-error input {
        border-color: #dc3545;
    }
</style>

<div class="col-md-10 p-4">
    <div class="navbarHR">
        <h2>Quản lý tài khoản</h2>
        <button class="btn btn-add" onclick="openModal()">
            <span>➕</span> Thêm mới
        </button>
    </div>

    <div id="addModal" class="modal">
        <div class="modal-contentHR">
            <button class="close" onclick="closeModal()">&times;</button>
            <div class="modal-header">
                <h3>Thêm tài khoản mới</h3>
            </div>
            <form class="modal-form" action="{{route('admin.store')}}" method="post">
                @csrf
                <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                    <label>Họ và Tên</label>
                    <input type="text" name="name" placeholder="Nhập họ và tên" value="{{ old('name') }}">
                    @if($errors->has('name'))
                        <span class="error-message">{{ $errors->first('name') }}</span>
                    @endif
                </div>
                <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                    <label>Email</label>
                    <input type="text" name="email" placeholder="Nhập email" value="{{ old('email') }}">
                    @if($errors->has('email'))
                        <span class="error-message">{{ $errors->first('email') }}</span>
                    @endif
                </div>
                <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                    <label>Mật khẩu</label>
                    <div class="password-input-group">
                        <input type="{{ old('password') ? 'text' : 'password' }}" id="password-add" name="password" placeholder="Nhập mật khẩu" value="{{ old('password') }}" data-has-old="{{ old('password') ? 'true' : 'false' }}">
                        <button type="button" class="password-toggle" onclick="togglePassword('password-add', this)">
                            <i class="fa {{ old('password') ? 'fa-eye-slash' : 'fa-eye' }}"></i>
                        </button>
                    </div>
                    @if($errors->has('password'))
                        <span class="error-message">{{ $errors->first('password') }}</span>
                    @endif
                </div>
                <div class="form-group {{ $errors->has('type') ? 'has-error' : '' }}">
                    <label>Quyền</label>
                    <select class="form-select" id="exampleSelect" name="type">
                        <option value="">Chọn quyền</option>
                        <option value="ADM" {{ old('type') == 'ADM' ? 'selected' : '' }}>Quản trị viên</option>
                        <option value="HMN" {{ old('type') == 'HMN' ? 'selected' : '' }}>Quản lý nhân sự</option>
                        <option value="ACC" {{ old('type') == 'ACC' ? 'selected' : '' }}>Quản lý kế toán</option>
                        <option value="CTO" {{ old('type') == 'CTO' ? 'selected' : '' }}>Giám đốc</option>
                    </select>
                    @if($errors->has('type'))
                        <span class="error-message">{{ $errors->first('type') }}</span>
                    @endif
                </div>

                <button type="submit" class="submit-btn">Lưu thông tin</button>
            </form>
        </div>
    </div>
    <div id="EditModal" class="modal">
        <div class="modal-contentHR">
            <button class="close" onclick="closeModalEdit()">&times;</button>
            <div class="modal-header">
                <h3>Sửa thông tin tài khoản</h3>
            </div>
            <form id="edit-form" class="modal-form" method="post">
                @csrf
                @method('PUT')
                <input type="text" id="edit-id" name="id" hidden>

                <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                    <label>Họ và Tên</label>
                    <input type="text" name="name" id="edit-name" placeholder="Nhập họ và tên" value="{{ old('name') }}">
                    @if($errors->has('name'))
                        <span class="error-message">{{ $errors->first('name') }}</span>
                    @endif
                </div>
                <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                    <label>Email</label>
                    <input type="email" name="email" id="edit-email" placeholder="Nhập email" value="{{ old('email') }}">
                    @if($errors->has('email'))
                        <span class="error-message">{{ $errors->first('email') }}</span>
                    @endif
                </div>
                <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                    <label>Mật khẩu (Mới)</label>
                    <div class="password-input-group">
                        <input type="{{ old('password') ? 'text' : 'password' }}" id="password-edit" name="password" placeholder="Nhập mật khẩu" value="{{ old('password') }}" data-has-old="{{ old('password') ? 'true' : 'false' }}">
                        <button type="button" class="password-toggle" onclick="togglePassword('password-edit', this)">
                            <i class="fa {{ old('password') ? 'fa-eye-slash' : 'fa-eye' }}"></i>
                        </button>
                    </div>
                    @if($errors->has('password'))
                        <span class="error-message">{{ $errors->first('password') }}</span>
                    @endif
                </div>
                <div class="form-group {{ $errors->has('type') ? 'has-error' : '' }}">
                    <label>Quyền</label>
                    <select id="edit-type" class="form-select" name="type">
                        <option value="ADM" {{ old('type') == 'ADM' ? 'selected' : '' }}>Quản trị viên</option>
                        <option value="HMN" {{ old('type') == 'HMN' ? 'selected' : '' }}>Quản lý nhân sự</option>
                        <option value="ACC" {{ old('type') == 'ACC' ? 'selected' : '' }}>Quản lý Kế toán</option>
                        <option value="CTO" {{ old('type') == 'CTO' ? 'selected' : '' }}>Giám đốc</option>
                    </select>
                    @if($errors->has('type'))
                        <span class="error-message">{{ $errors->first('type') }}</span>
                    @endif
                </div>
                <button type="submit" class="submit-btn">Cập nhật thông tin</button>
            </form>

        </div>
    </div>

    <div id="DeleteModal" class="modal">
        <form id="delete-form" class="modal-content" method="post">
            @csrf
            @method('DELETE')
            <p>Bạn có muốn xóa tài khoản không?</p>
            <div class="modal-buttons">
                <button type="submit" class="delete-btnMD">Xóa</button>
                <button type="button" class="cancel-btnMD" onclick="closeModalDelete()">Hủy</button>
            </div>
        </form>
    </div>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    <table class="data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Họ và tên</th>
                <th>Email</th>
                <th>Quyền</th>
                <th>Hoạt động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{$user->id}}</td>
                <td>{{$user->name}}</td>
                <td>{{$user->email}}</td>
                @if($user->type == 'ADM')
                <td>Quản trị viên</td>
                @elseif($user->type == 'HMN')
                <td>Quản lý nhân sự</td>
                @elseif($user->type == 'ACC')
                <td>Quản lý Kế toán</td>
                @elseif($user->type == 'CTO')
                <td>Giám đốc</td>
                @endif
                <td>
                    <div class="action-buttons ">
                        <button class="action-btn edit-btn"
                            onclick="openModalEdit(this)"
                            data-id="{{$user->id}}"
                            data-name="{{$user->name}}"
                            data-email="{{$user->email}}"
                            data-type="{{$user->type}}">
                            <span>✏️</span> Sửa
                        </button>



                        <button class="action-btn delete-btn"
                            onclick="openModalDelete(this)"
                            data-id="{{$user->id}}">
                            <span>🗑️</span> Xóa
                        </button>

                    </div>
                </td>
            </tr>
            @endforeach

        </tbody>
    </table>
</div>
<script>
    function openModal() {
        const modal = document.getElementById("addModal");
        
        // Reset form trước khi mở modal
        resetAddForm();
        
        modal.style.display = "flex";
        // Trigger reflow
        modal.offsetHeight;
        modal.classList.add("show");
    }


    function openModalEdit(button) {
        const modal = document.getElementById("EditModal");
        const form = document.getElementById("edit-form");

        // Lấy dữ liệu từ data-attributes của nút được click
        const id = button.getAttribute("data-id");
        const name = button.getAttribute("data-name");
        const email = button.getAttribute("data-email");
        const type = button.getAttribute("data-type");

        // Gán dữ liệu vào các input trong modal
        document.getElementById("edit-id").value = id;
        document.getElementById("edit-name").value = name;
        document.getElementById("edit-email").value = email;
        document.getElementById("edit-type").value = type;

        // Cập nhật action của form
        form.action = `/dashboardAD/${id}`;

        // Hiển thị modal
        modal.style.display = "flex";
        modal.offsetHeight; // Trigger reflow
        modal.classList.add("show");
    }


    function openModalDelete(button) {
        const modal = document.getElementById("DeleteModal");
        const form = modal.querySelector("form");

        // Lấy ID từ nút bấm
        const id = button.getAttribute("data-id");

        // Cập nhật action của form
        form.action = `/dashboardAD/${id}`;

        // Hiển thị modal
        modal.style.display = "flex";
        modal.offsetHeight; // Trigger reflow
        modal.classList.add("show");
    }

    // Function để toggle hiển thị/ẩn mật khẩu
    function togglePassword(inputId, button) {
        const passwordInput = document.getElementById(inputId);
        const icon = button.querySelector('i');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }

    // Function để reset form về trạng thái ban đầu
    function resetAddForm() {
        const form = document.querySelector('#addModal form');
        
        // Reset tất cả input fields
        form.reset();
        
        // Xóa tất cả error messages
        const errorMessages = form.querySelectorAll('.error-message');
        errorMessages.forEach(error => error.remove());
        
        // Xóa class has-error khỏi tất cả form-groups
        const formGroups = form.querySelectorAll('.form-group');
        formGroups.forEach(group => group.classList.remove('has-error'));
        
        // Reset select về option đầu tiên
        const selectType = form.querySelector('select[name="type"]');
        if (selectType) {
            selectType.selectedIndex = 0;
        }
        
        // Reset password input về type="password" và icon về fa-eye
        const passwordInput = document.getElementById('password-add');
        const passwordIcon = form.querySelector('.password-toggle i');
        if (passwordInput && passwordIcon) {
            passwordInput.type = 'password';
            passwordInput.setAttribute('data-has-old', 'false');
            passwordIcon.classList.remove('fa-eye-slash');
            passwordIcon.classList.add('fa-eye');
        }
    }

    // Function để reset edit form
    function resetEditForm() {
        const form = document.querySelector('#EditModal form');
        
        // Reset tất cả input fields
        form.reset();
        
        // Xóa tất cả error messages
        const errorMessages = form.querySelectorAll('.error-message');
        errorMessages.forEach(error => error.remove());
        
        // Xóa class has-error khỏi tất cả form-groups
        const formGroups = form.querySelectorAll('.form-group');
        formGroups.forEach(group => group.classList.remove('has-error'));
        
        // Reset password input về type="password" và icon về fa-eye
        const passwordInput = document.getElementById('password-edit');
        const passwordIcon = form.querySelector('.password-toggle i');
        if (passwordInput && passwordIcon) {
            passwordInput.type = 'password';
            passwordInput.setAttribute('data-has-old', 'false');
            passwordIcon.classList.remove('fa-eye-slash');
            passwordIcon.classList.add('fa-eye');
        }
    }

    function closeModal() {
        const modal = document.getElementById("addModal");
        modal.classList.remove("show");
        setTimeout(() => {
            modal.style.display = "none";
            // Reset form khi đóng modal
            resetAddForm();
        }, 300);
    }

    function closeModalEdit() {
        const modal = document.getElementById("EditModal");
        modal.classList.remove("show");
        setTimeout(() => {
            modal.style.display = "none";
            // Reset form khi đóng modal edit
            resetEditForm();
        }, 300);
    }

    function closeModalDelete() {
        const modal = document.getElementById("DeleteModal");
        modal.classList.remove("show");
        setTimeout(() => {
            modal.style.display = "none";
        }, 300);
    }
    // Close modal when clicking outside
    window.onclick = function(event) {
        const modal = document.getElementById("addModal");
        if (event.target == modal) {
            closeModal(); // Sử dụng function closeModal() để reset form
        }
    }
    
    // Hiển thị modal nếu có validation errors (không reset form)
    @if($errors->any())
        document.addEventListener('DOMContentLoaded', function() {
            // Kiểm tra URL để xác định modal nào cần hiển thị
            const currentUrl = window.location.href;
            
            if (currentUrl.includes('/dashboardAD') && !currentUrl.includes('/dashboardAD/')) {
                // URL không có ID → đây là POST request (add)
                const modal = document.getElementById("addModal");
                modal.style.display = "flex";
                modal.offsetHeight;
                modal.classList.add("show");
            } else if (currentUrl.includes('/dashboardAD/')) {
                // URL có ID → đây là PUT request (update)
                const modal = document.getElementById("EditModal");
                modal.style.display = "flex";
                modal.offsetHeight;
                modal.classList.add("show");
            }
        });
    @endif

    // Xử lý password fields có old value sau khi page load
    document.addEventListener('DOMContentLoaded', function() {
        // Xử lý password field trong add form
        const passwordAddInput = document.getElementById('password-add');
        if (passwordAddInput && passwordAddInput.getAttribute('data-has-old') === 'true') {
            // Giữ nguyên type="text" để hiển thị giá trị, icon đã được set thành fa-eye-slash
            // User có thể click để ẩn nếu muốn
        }

        // Xử lý password field trong edit form  
        const passwordEditInput = document.getElementById('password-edit');
        if (passwordEditInput && passwordEditInput.getAttribute('data-has-old') === 'true') {
            // Giữ nguyên type="text" để hiển thị giá trị, icon đã được set thành fa-eye-slash
            // User có thể click để ẩn nếu muốn
        }
    });
</script>