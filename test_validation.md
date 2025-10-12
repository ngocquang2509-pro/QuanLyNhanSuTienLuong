# Test Validation Chức năng Thêm Tài khoản

## ✅ HOÀN THÀNH: Validation theo đặc tả

### 1. **HỌ VÀ TÊN** - Đã implement đầy đủ:
- ✅ UC8-E1: Bỏ trống → "Vui lòng nhập họ và tên."
- ✅ UC8-E2: Quá ngắn (< 2) → "Họ và tên phải có ít nhất 2 ký tự."  
- ✅ UC8-E3: Quá dài (> 100) → "Họ và tên không được vượt quá 100 ký tự."
- ✅ UC8-E4: Chứa chữ số → "Họ và tên không được chứa chữ số."
- ✅ UC8-E5: Chứa ký tự đặc biệt → "Họ và tên không được chứa ký tự đặc biệt."
- ✅ UC8-E6: Khoảng trắng đầu/cuối → "Họ và tên không được có khoảng trắng ở đầu hoặc cuối."
- ✅ UC8-E7: Nhiều khoảng trắng liên tiếp → "Họ và tên không được có nhiều khoảng trắng liên tiếp."

### 2. **MẬT KHẨU** - Đã implement đầy đủ:
- ✅ UC8-E30: Bỏ trống → "Vui lòng nhập mật khẩu."
- ✅ UC8-E31: Độ dài < 8 → "Mật khẩu phải có độ dài lớn hơn 8 ký tự."
- ✅ UC8-E32: Độ dài > 128 → "Mật khẩu phải có độ dài nhỏ hơn 128 ký tự."
- ✅ UC8-E33: Thiếu chữ hoa → "Mật khẩu thiếu chữ hoa (A–Z)."
- ✅ UC8-E34: Thiếu chữ thường → "Mật khẩu thiếu chữ thường (a–z)."
- ✅ UC8-E35: Thiếu chữ số → "Mật khẩu thiếu chữ số (0–9)."
- ✅ UC8-E36: Thiếu ký tự đặc biệt → "Mật khẩu thiếu ký tự đặc biệt..."
- ✅ UC8-E37: Chứa khoảng trắng → "Mật khẩu chứa khoảng trắng."

### 3. **VAI TRÒ** - Đã implement đầy đủ:
- ✅ UC8-E38: Chưa chọn → "Vui lòng chọn vai trò."
- ✅ UC8-E39: Giá trị không hợp lệ → "Giá trị vai trò không hợp lệ."

### 4. **EMAIL** - Tạm thời validation cơ bản:
- ✅ UC8-E8: Bỏ trống → "Vui lòng nhập email."
- ✅ UC8-E29: Email đã tồn tại → "Email đã được sử dụng."
- ⏳ **CẦN IMPLEMENT CHI TIẾT THÊM** cho các mã lỗi UC8-E9 đến UC8-E28

## ✅ CÁC TÍNH NĂNG ĐÃ IMPLEMENT:

### 1. **Controller Validation:**
- Custom validation rules cho từng trường
- Error messages với mã lỗi theo đặc tả
- Xử lý riêng cho trường hợp có/không có password trong update

### 2. **View Enhancements:**
- Loại bỏ HTML validation attributes 
- Hiển thị error messages với styling
- Preserve old input values khi có lỗi
- Auto-open modal khi có validation errors
- Styling cho fields có lỗi (border đỏ)

### 3. **User Experience:**
- Modal tự động mở lại khi có lỗi validation
- Giữ nguyên giá trị đã nhập khi submit lỗi
- Error messages rõ ràng với mã lỗi

## 🔄 TIẾP THEO:
Sau khi test xong 3 trường này, sẽ implement validation chi tiết cho **EMAIL** theo đặc tả (UC8-E9 đến UC8-E28).

## 📝 Test Cases để kiểm tra:

### Họ và tên:
- [ ] Bỏ trống
- [ ] Nhập "A" (< 2 ký tự)
- [ ] Nhập tên dài hơn 100 ký tự
- [ ] Nhập "Nguyễn Văn A1" (có số)
- [ ] Nhập "Nguyễn@Văn" (ký tự đặc biệt)
- [ ] Nhập " Nguyễn Văn A" (khoảng trắng đầu)
- [ ] Nhập "Nguyễn  Văn A" (2 khoảng trắng)

### Mật khẩu:
- [ ] Bỏ trống
- [ ] Nhập "1234567" (< 8 ký tự)
- [ ] Nhập mật khẩu > 128 ký tự
- [ ] Nhập "password123" (thiếu chữ hoa)
- [ ] Nhập "PASSWORD123" (thiếu chữ thường)
- [ ] Nhập "Password" (thiếu số)
- [ ] Nhập "Password123" (thiếu ký tự đặc biệt)
- [ ] Nhập "Pass word123!" (có khoảng trắng)

### Vai trò:
- [ ] Không chọn (để trống)
- [ ] Chọn giá trị hợp lệ: CTO, ACC, HMN