# Refactor Store Method cho White Box Testing

## Vấn đề hiện tại
```php
// Code hiện tại - chỉ thấy success path
public function store(Request $request)
{
    $request->validate([...]); // Black box - không thấy 39 error paths
    $credentials = $request->only([...]);  // Chỉ chạy khi success
    User::create($credentials);
    return redirect()->route('admin.dashboard');
}
```

## Giải pháp 1: Manual Validation (Explicit Error Paths)
```php
public function store(Request $request)
{
    // BƯỚC 1: VALIDATION - Explicit error handling
    $validator = Validator::make($request->all(), [
        'name' => [
            'required',
            'min:2', 
            'max:100',
            // ... các rules khác
        ],
        'email' => [
            'required',
            // ... các rules khác
        ],
        // ... các field khác
    ]);

    // Kiểm tra validation results
    if ($validator->fails()) {
        // Explicit error paths - có thể test được
        $errors = $validator->errors();
        
        // Path 1: Name errors
        if ($errors->has('name')) {
            return back()->withErrors($errors)->withInput();
        }
        
        // Path 2: Email errors  
        if ($errors->has('email')) {
            return back()->withErrors($errors)->withInput();
        }
        
        // Path 3: Password errors
        if ($errors->has('password')) {
            return back()->withErrors($errors)->withInput();
        }
        
        // Path 4: Type errors
        if ($errors->has('type')) {
            return back()->withErrors($errors)->withInput();
        }
    }
    
    // Success path
    $credentials = $request->only(['name', 'email', 'password', 'type']);
    $credentials['password'] = bcrypt($credentials['password']);
    User::create($credentials);
    return redirect()->route('admin.dashboard')->with('success', 'Thêm tài khoản thành công');
}
```

## Giải pháp 2: Custom Validation Functions  
```php
public function store(Request $request)
{
    // BƯỚC 1: Name validation
    $nameValidation = $this->validateName($request->name);
    if ($nameValidation !== true) {
        return back()->withErrors(['name' => $nameValidation])->withInput();
    }
    
    // BƯỚC 2: Email validation  
    $emailValidation = $this->validateEmail($request->email);
    if ($emailValidation !== true) {
        return back()->withErrors(['email' => $emailValidation])->withInput();
    }
    
    // BƯỚC 3: Password validation
    $passwordValidation = $this->validatePassword($request->password);
    if ($passwordValidation !== true) {
        return back()->withErrors(['password' => $passwordValidation])->withInput();
    }
    
    // BƯỚC 4: Type validation
    $typeValidation = $this->validateType($request->type);
    if ($typeValidation !== true) {
        return back()->withErrors(['type' => $typeValidation])->withInput();
    }
    
    // Success path
    $credentials = $request->only(['name', 'email', 'password', 'type']);
    $credentials['password'] = bcrypt($credentials['password']);
    User::create($credentials);
    return redirect()->route('admin.dashboard')->with('success', 'Thêm tài khoản thành công');
}

// Custom validation methods
private function validateName($name)
{
    if (empty($name)) {
        return 'Vui lòng nhập họ và tên. [UC8-E1]';
    }
    if (strlen($name) < 2) {
        return 'Họ và tên phải có ít nhất 2 ký tự. [UC8-E2]';
    }
    if (strlen($name) > 100) {
        return 'Họ và tên không được vượt quá 100 ký tự. [UC8-E3]';
    }
    if (preg_match('/\d/', $name)) {
        return 'Họ và tên không được chứa chữ số. [UC8-E4]';
    }
    // ... các validation khác
    return true; // Success
}

private function validateEmail($email)
{
    if (empty($email)) {
        return 'Vui lòng nhập email. [UC8-E8]';
    }
    // ... 22 email validation rules
    return true; // Success
}

// ... các method khác
```

## Giải pháp 3: Exception-based Testing
```php
public function store(Request $request)
{
    try {
        // Validation với try-catch
        $validatedData = $request->validate([
            // ... validation rules
        ]);
        
        // Success path
        $credentials = $request->only(['name', 'email', 'password', 'type']);
        $credentials['password'] = bcrypt($credentials['password']);
        User::create($credentials);
        return redirect()->route('admin.dashboard')->with('success', 'Thêm tài khoản thành công');
        
    } catch (ValidationException $e) {
        // Explicit error handling
        return back()->withErrors($e->errors())->withInput();
    }
}
```

## So sánh Approaches

| Approach | White Box Testable | Code Complexity | Maintenance |
|----------|-------------------|-----------------|-------------|
| Current (Laravel validate()) | ❌ | ⭐⭐⭐⭐⭐ | ⭐⭐⭐⭐⭐ |
| Manual Validation | ✅ | ⭐⭐ | ⭐⭐ |
| Custom Functions | ✅ | ⭐⭐⭐ | ⭐⭐⭐ |
| Exception-based | ⭐⭐⭐ | ⭐⭐⭐⭐ | ⭐⭐⭐⭐ |

## Khuyến nghị cho White Box Testing

### Cho mục đích học tập:
**Chọn Giải pháp 2 (Custom Functions)** vì:
- ✅ Explicit error paths 
- ✅ Dễ test từng validation rule
- ✅ Clear control flow  
- ✅ 40 paths đều visible trong code

### Cho production:
**Giữ code hiện tại** và test ở **Integration level** vì:
- Laravel validation đã được test kỹ
- Code cleaner và maintainable hơn
- Focus vào business logic testing