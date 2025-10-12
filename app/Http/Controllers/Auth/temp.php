<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.dashboard', compact('users'));
    }
    public function HR_Manager()
    {

        return view('admin.HR_Manager', compact('users'));
    }
    public function store(Request $request)
    {
        // BƯỚC 1: VALIDATION - Kiểm tra tính hợp lệ của tất cả dữ liệu đầu vào
        // Sử dụng custom validation rules để kiểm tra từng field theo đặc tả UC8
        // Nếu validation fail, Laravel tự động redirect với error messages
        $request->validate([
            // HỌ VÀ TÊN - Tất cả validation rules
            'name' => [
                'required',
                'min:2',
                'max:100',
                function ($attribute, $value, $fail) {
                    if (preg_match('/\d/', $value)) {
                        $fail('Họ và tên không được chứa chữ số. [UC8-E4]');
                    } elseif (!preg_match('/^[\p{L}\s]+$/u', $value)) {
                        $fail('Họ và tên không được chứa ký tự đặc biệt. [UC8-E5]');
                    } elseif (preg_match('/^\s|\s$/', $value)) {
                        $fail('Họ và tên không được có khoảng trắng ở đầu hoặc cuối. [UC8-E6]');
                    } elseif (preg_match('/\s{2,}/', $value)) {
                        $fail('Họ và tên không được có nhiều khoảng trắng liên tiếp. [UC8-E7]');
                    }
                },
            ],
            
            // EMAIL - Validation rules chi tiết theo đặc tả
            'email' => [
                'required',
                function ($attribute, $value, $fail) {
                    // UC8-E9: Kiểm tra khoảng trắng
                    if (preg_match('/\s/', $value)) {
                        $fail('Email không được chứa khoảng trắng. [UC8-E9]');
                        return;
                    }
                    
                    // UC8-E10: Kiểm tra đúng 1 ký tự '@'
                    $atCount = substr_count($value, '@');
                    if ($atCount !== 1) {
                        $fail('Email phải chứa đúng 1 ký tự \'@\'. [UC8-E10]');
                        return;
                    }
                    
                    // Tách local-part và domain
                    $parts = explode('@', $value);
                    $localPart = $parts[0];
                    $domain = $parts[1];
                    
                    // VALIDATION LOCAL-PART
                    
                    // UC8-E11: Local-part ít nhất 1 ký tự
                    if (strlen($localPart) < 1) {
                        $fail('Local-part không hợp lệ: Ít nhất 1 ký tự. [UC8-E11]');
                        return;
                    }
                    
                    // UC8-E12: Local-part không vượt quá 64 ký tự
                    if (strlen($localPart) > 64) {
                        $fail('Local-part không hợp lệ: độ dài không được vượt quá 64 ký tự. [UC8-E12]');
                        return;
                    }
                    
                    // UC8-E13: Local-part không bắt đầu bằng '.'
                    if (substr($localPart, 0, 1) === '.') {
                        $fail('Local-part không hợp lệ: không được bắt đầu bằng dấu chấm (\'.\')。[UC8-E13]');
                        return;
                    }
                    
                    // UC8-E14: Local-part không kết thúc bằng '.'
                    if (substr($localPart, -1) === '.') {
                        $fail('Local-part không hợp lệ: không được kết thúc bằng dấu chấm (\'.\')。[UC8-E14]');
                        return;
                    }
                    
                    // UC8-E15: Local-part không chứa chuỗi '..'
                    if (strpos($localPart, '..') !== false) {
                        $fail('Local-part không hợp lệ: không được chứa chuỗi \'..\'. [UC8-E15]');
                        return;
                    }
                    
                    // UC8-E16: Local-part chỉ cho phép [A–Z a–z 0–9 . _ + -]
                    if (!preg_match('/^[A-Za-z0-9._+-]+$/', $localPart)) {
                        $fail('Local-part không hợp lệ: chỉ cho phép [A–Z a–z 0–9 . _ + -]. [UC8-E16]');
                        return;
                    }
                    
                    // VALIDATION DOMAIN
                    
                    // UC8-E17: Domain rỗng
                    if (empty($domain)) {
                        $fail('Domain không hợp lệ: để trống sau ký tự \'@\'. [UC8-E17]');
                        return;
                    }
                    
                    // UC8-E18: Domain phải có ít nhất 1 dấu chấm
                    if (strpos($domain, '.') === false) {
                        $fail('Domain không hợp lệ: phải có ít nhất một dấu chấm. [UC8-E18]');
                        return;
                    }
                    
                    // UC8-E19: Domain không chứa chuỗi '..'
                    if (strpos($domain, '..') !== false) {
                        $fail('Domain không hợp lệ: không được chứa chuỗi \'..\'. [UC8-E19]');
                        return;
                    }
                    
                    // UC8-E28: Domain chỉ chấp nhận ASCII (không hỗ trợ IDN)
                    if (!mb_check_encoding($domain, 'ASCII')) {
                        $fail('Domain không hợp lệ: chỉ chấp nhận ASCII (không hỗ trợ IDN). [UC8-E28]');
                        return;
                    }
                    
                    // Kiểm tra từng label trong domain
                    $labels = explode('.', $domain);
                    $tld = end($labels); // Label cuối cùng là TLD
                    
                    // VALIDATION TLD TRƯỚC (ưu tiên cao)
                    
                    // UC8-E24: TLD phải là chữ cái [a–z]
                    if (!preg_match('/^[a-z]+$/i', $tld)) {
                        $fail('Domain không hợp lệ: TLD phải là chữ cái [a–z]. [UC8-E24]');
                        return;
                    }
                    
                    // UC8-E25: TLD ít nhất 2 ký tự
                    if (strlen($tld) < 2) {
                        $fail('Domain không hợp lệ: ít nhất 2 ký tự [UC8-E25]');
                        return;
                    }
                    
                    // UC8-E26: TLD nhiều nhất 63 ký tự
                    if (strlen($tld) > 63) {
                        $fail('Domain không hợp lệ: nhiều nhất 63 ký tự [UC8-E26]');
                        return;
                    }
                    
                    // VALIDATION CÁC LABEL KHÁC (CHỈ NON-TLD LABELS) 
                    $nonTldLabels = array_slice($labels, 0, -1); // Bỏ TLD
                    foreach ($nonTldLabels as $label) {
                        // UC8-E20: Mỗi label chỉ cho phép [a–z0–9-]
                        if (!preg_match('/^[a-z0-9-]+$/i', $label)) {
                            $fail('Domain không hợp lệ: mỗi nhãn chỉ cho phép [a–z 0–9 -]. [UC8-E20]');
                            return;
                        }
                        
                        // UC8-E21: Label không bắt đầu/kết thúc bằng '-'
                        if (substr($label, 0, 1) === '-' || substr($label, -1) === '-') {
                            $fail('Domain không hợp lệ: nhãn không được bắt đầu hoặc kết thúc bằng dấu \'-\'. [UC8-E21]');
                            return;
                        }
                        
                        // UC8-E22: NON-TLD label không vượt quá 63 ký tự
                        if (strlen($label) > 63) {
                            $fail('Domain không hợp lệ: mỗi nhãn không được vượt quá 63 ký tự. [UC8-E22]');
                            return;
                        }
                    }
                    
                    // Kiểm tra UC8-E20, UC8-E21 cho TLD (nhưng KHÔNG UC8-E22)
                    if (!preg_match('/^[a-z0-9-]+$/i', $tld)) {
                        $fail('Domain không hợp lệ: mỗi nhãn chỉ cho phép [a–z 0–9 -]. [UC8-E20]');
                        return;
                    }
                    
                    if (substr($tld, 0, 1) === '-' || substr($tld, -1) === '-') {
                        $fail('Domain không hợp lệ: nhãn không được bắt đầu hoặc kết thúc bằng dấu \'-\'. [UC8-E21]');
                        return;
                    }
                    
                    // UC8-E23: Tổng domain không vượt quá 253 ký tự
                    if (strlen($domain) > 253) {
                        $fail('Domain không hợp lệ: tổng độ dài phần domain không được vượt quá 253 ký tự. [UC8-E23]');
                        return;
                    }
                    
                    // UC8-E27: Kiểm tra tổng độ dài ≤ 254 ký tự (CUỐI CÙNG)
                    if (strlen($value) > 254) {
                        $fail('Domain không hợp lệ: tổng độ dài địa chỉ email không được vượt quá 254 ký tự. [UC8-E27]');
                        return;
                    }
                },
                'unique:users,email', // UC8-E29: Cuối cùng mới check unique
            ],
            
            // MẬT KHẨU - Tất cả validation rules
            'password' => [
                'required',
                'min:8',
                'max:128',
                function ($attribute, $value, $fail) {
                    // UC8-E37: Kiểm tra khoảng trắng trước (cơ bản nhất)
                    if (!preg_match('/^\S+$/', $value)) {
                        $fail('Mật khẩu chứa khoảng trắng. [UC8-E37]');
                        return;
                    }
                    
                    // UC8-E33: Kiểm tra chữ hoa
                    if (!preg_match('/(?=.*[A-Z])/', $value)) {
                        $fail('Mật khẩu thiếu chữ hoa (A–Z). [UC8-E33]');
                        return;
                    }
                    
                    // UC8-E34: Kiểm tra chữ thường
                    if (!preg_match('/(?=.*[a-z])/', $value)) {
                        $fail('Mật khẩu thiếu chữ thường (a–z). [UC8-E34]');
                        return;
                    }
                    
                    // UC8-E35: Kiểm tra chữ số
                    if (!preg_match('/(?=.*\d)/', $value)) {
                        $fail('Mật khẩu thiếu chữ số (0–9). [UC8-E35]');
                        return;
                    }
                    
                    // UC8-E36: Kiểm tra ký tự đặc biệt
                    if (!preg_match('/(?=.*[!@#$%^&*()_+\-=\[\]{};\':",.<>\/\?\\|~`])/', $value)) {
                        $fail('Mật khẩu thiếu ký tự đặc biệt (ví dụ: !@#$%^&*()_+-=[]{};\':",.<>/?\\|`~). [UC8-E36]');
                        return;
                    }
                },
            ],
            
            // VAI TRÒ - Validation rules
            'type' => [
                'required',
                'in:CTO,ACC,HMN',
            ],
        ], [
            // CUSTOM ERROR MESSAGES CHO CÁC RULES CƠ BẢN
            'name.required' => 'Vui lòng nhập họ và tên. [UC8-E1]',
            'name.min' => 'Họ và tên phải có ít nhất 2 ký tự. [UC8-E2]',
            'name.max' => 'Họ và tên không được vượt quá 100 ký tự. [UC8-E3]',
            
            'email.required' => 'Vui lòng nhập email. [UC8-E8]',
            'email.unique' => 'Email đã được sử dụng. [UC8-E29]',
            
            'password.required' => 'Vui lòng nhập mật khẩu. [UC8-E30]',
            'password.min' => 'Mật khẩu phải có độ dài lớn hơn 8 ký tự. [UC8-E31]',
            'password.max' => 'Mật khẩu phải có độ dài nhỏ hơn 128 ký tự. [UC8-E32]',
            
            'type.required' => 'Vui lòng chọn vai trò. [UC8-E38]',
            'type.in' => 'Giá trị vai trò không hợp lệ. [UC8-E39]',
        ]);
        
        // BƯỚC 2: EXTRACT CREDENTIALS - Trích xuất dữ liệu đã được validate từ request
        // only() chỉ lấy các field được chỉ định, bỏ qua các field khác (như _token, _method)
        // Kết quả: $credentials = ['name' => 'John Doe', 'email' => 'john@example.com', 'password' => 'plaintext', 'type' => 'CTO']
        $credentials = $request->only(['name', 'email', 'password', 'type']);
        
        // BƯỚC 3: HASH PASSWORD - Mã hóa mật khẩu bằng bcrypt để bảo mật
        // bcrypt() sử dụng thuật toán Blowfish với salt ngẫu nhiên, cost factor mặc định = 10
        // Chuyển từ plaintext thành hash: 'password123' → '$2y$10$...' (60 ký tự)
        $credentials['password'] = bcrypt($credentials['password']);
        
        // BƯỚC 4: CREATE USER - Tạo bản ghi mới trong bảng users
        // User::create() sử dụng Eloquent ORM để insert dữ liệu vào database
        // Mass assignment được bảo vệ bởi $fillable trong User model
        User::create($credentials);
        
        // BƯỚC 5: REDIRECT SUCCESS - Redirect về trang dashboard với thông báo thành công
        // redirect() tạo HTTP 302 response, route() tạo URL từ tên route
        // with() flash message vào session, hiển thị 1 lần rồi tự xóa
        return redirect()->route('admin.dashboard')->with('success', 'Thêm tài khoản thành công');
    }
    
    public function update(Request $request, $id)
    {
        // Validation rules cơ bản cho tất cả fields
        $rules = [
            // HỌ VÀ TÊN - Tất cả validation rules
            'name' => [
                'required',
                'min:2',
                'max:100',
                function ($attribute, $value, $fail) {
                    if (preg_match('/\d/', $value)) {
                        $fail('Họ và tên không được chứa chữ số. [UC8-E4]');
                    } elseif (!preg_match('/^[\p{L}\s]+$/u', $value)) {
                        $fail('Họ và tên không được chứa ký tự đặc biệt. [UC8-E5]');
                    } elseif (preg_match('/^\s|\s$/', $value)) {
                        $fail('Họ và tên không được có khoảng trắng ở đầu hoặc cuối. [UC8-E6]');
                    } elseif (preg_match('/\s{2,}/', $value)) {
                        $fail('Họ và tên không được có nhiều khoảng trắng liên tiếp. [UC8-E7]');
                    }
                },
            ],
            
            // EMAIL - Validation rules chi tiết theo đặc tả
            'email' => [
                'required',
                function ($attribute, $value, $fail) use ($id) {
                    // UC8-E9: Kiểm tra khoảng trắng
                    if (preg_match('/\s/', $value)) {
                        $fail('Email không được chứa khoảng trắng. [UC8-E9]');
                        return;
                    }
                    
                    // UC8-E10: Kiểm tra đúng 1 ký tự '@'
                    $atCount = substr_count($value, '@');
                    if ($atCount !== 1) {
                        $fail('Email phải chứa đúng 1 ký tự \'@\'. [UC8-E10]');
                        return;
                    }
                    
                    // Tách local-part và domain
                    $parts = explode('@', $value);
                    $localPart = $parts[0];
                    $domain = $parts[1];
                    
                    // VALIDATION LOCAL-PART
                    
                    // UC8-E11: Local-part rỗng
                    if (empty($localPart)) {
                        $fail('Local-part không hợp lệ: để trống trước ký tự \'@\'. [UC8-E11]');
                        return;
                    }
                    
                    // UC8-E12A: Local-part ít nhất 1 ký tự
                    if (strlen($localPart) < 1) {
                        $fail('Local-part không hợp lệ: Ít nhất 1 ký tự. [UC8-E12A]');
                        return;
                    }
                    
                    // UC8-E12B: Local-part không vượt quá 64 ký tự
                    if (strlen($localPart) > 64) {
                        $fail('Local-part không hợp lệ: độ dài không được vượt quá 64 ký tự. [UC8-E12B]');
                        return;
                    }
                    
                    // UC8-E13: Local-part không bắt đầu bằng '.'
                    if (substr($localPart, 0, 1) === '.') {
                        $fail('Local-part không hợp lệ: không được bắt đầu bằng dấu chấm (\'.\')。[UC8-E13]');
                        return;
                    }
                    
                    // UC8-E14: Local-part không kết thúc bằng '.'
                    if (substr($localPart, -1) === '.') {
                        $fail('Local-part không hợp lệ: không được kết thúc bằng dấu chấm (\'.\')。[UC8-E14]');
                        return;
                    }
                    
                    // UC8-E15: Local-part không chứa chuỗi '..'
                    if (strpos($localPart, '..') !== false) {
                        $fail('Local-part không hợp lệ: không được chứa chuỗi \'..\'. [UC8-E15]');
                        return;
                    }
                    
                    // UC8-E16: Local-part chỉ cho phép [A–Z a–z 0–9 . _ + -]
                    if (!preg_match('/^[A-Za-z0-9._+-]+$/', $localPart)) {
                        $fail('Local-part không hợp lệ: chỉ cho phép [A–Z a–z 0–9 . _ + -]. [UC8-E16]');
                        return;
                    }
                    
                    // VALIDATION DOMAIN
                    
                    // UC8-E17: Domain rỗng
                    if (empty($domain)) {
                        $fail('Domain không hợp lệ: để trống sau ký tự \'@\'. [UC8-E17]');
                        return;
                    }
                    
                    // UC8-E18: Domain phải có ít nhất 1 dấu chấm
                    if (strpos($domain, '.') === false) {
                        $fail('Domain không hợp lệ: phải có ít nhất một dấu chấm. [UC8-E18]');
                        return;
                    }
                    
                    // UC8-E19: Domain không chứa chuỗi '..'
                    if (strpos($domain, '..') !== false) {
                        $fail('Domain không hợp lệ: không được chứa chuỗi \'..\'. [UC8-E19]');
                        return;
                    }
                    
                    // UC8-E28: Domain chỉ chấp nhận ASCII (không hỗ trợ IDN)
                    if (!mb_check_encoding($domain, 'ASCII')) {
                        $fail('Domain không hợp lệ: chỉ chấp nhận ASCII (không hỗ trợ IDN). [UC8-E28]');
                        return;
                    }
                    
                    // Kiểm tra từng label trong domain
                    $labels = explode('.', $domain);
                    $tld = end($labels); // Label cuối cùng là TLD
                    
                    // VALIDATION TLD TRƯỚC (ưu tiên cao)
                    
                    // UC8-E24: TLD phải là chữ cái [a–z]
                    if (!preg_match('/^[a-z]+$/i', $tld)) {
                        $fail('Domain không hợp lệ: TLD phải là chữ cái [a–z]. [UC8-E24]');
                        return;
                    }
                    
                    // UC8-E25: TLD ít nhất 2 ký tự
                    if (strlen($tld) < 2) {
                        $fail('Domain không hợp lệ: ít nhất 2 ký tự [UC8-E25]');
                        return;
                    }
                    
                    // UC8-E26: TLD nhiều nhất 63 ký tự
                    if (strlen($tld) > 63) {
                        $fail('Domain không hợp lệ: nhiều nhất 63 ký tự [UC8-E26]');
                        return;
                    }
                    
                    // VALIDATION CÁC LABEL KHÁC (trừ TLD)
                    foreach ($labels as $index => $label) {
                        // UC8-E20: Mỗi label chỉ cho phép [a–z0–9-]
                        if (!preg_match('/^[a-z0-9-]+$/i', $label)) {
                            $fail('Domain không hợp lệ: mỗi nhãn chỉ cho phép [a–z 0–9 -]. [UC8-E20]');
                            return;
                        }
                        
                        // UC8-E21: Label không bắt đầu/kết thúc bằng '-'
                        if (substr($label, 0, 1) === '-' || substr($label, -1) === '-') {
                            $fail('Domain không hợp lệ: nhãn không được bắt đầu hoặc kết thúc bằng dấu \'-\'. [UC8-E21]');
                            return;
                        }
                        
                        // UC8-E22: Mỗi label không vượt quá 63 ký tự (chỉ áp dụng cho NON-TLD)
                        if ($label !== $tld && strlen($label) > 63) {
                            $fail('Domain không hợp lệ: mỗi nhãn không được vượt quá 63 ký tự. [UC8-E22]');
                            return;
                        }
                    }
                    
                    // UC8-E23: Tổng domain không vượt quá 253 ký tự
                    if (strlen($domain) > 253) {
                        $fail('Domain không hợp lệ: tổng độ dài phần domain không được vượt quá 253 ký tự. [UC8-E23]');
                        return;
                    }
                    
                    // UC8-E27: Kiểm tra tổng độ dài ≤ 254 ký tự (CUỐI CÙNG)
                    if (strlen($value) > 254) {
                        $fail('Domain không hợp lệ: tổng độ dài địa chỉ email không được vượt quá 254 ký tự. [UC8-E27]');
                        return;
                    }
                },
                'unique:users,email,' . $id, // UC8-E29: Cuối cùng mới check unique
            ],
            
            // VAI TRÒ - Validation rules
            'type' => [
                'required',
                'in:CTO,ACC,HMN',
            ],
        ];

        $messages = [
            'name.required' => 'Vui lòng nhập họ và tên. [UC8-E1]',
            'name.min' => 'Họ và tên phải có ít nhất 2 ký tự. [UC8-E2]',
            'name.max' => 'Họ và tên không được vượt quá 100 ký tự. [UC8-E3]',
            
            'email.required' => 'Vui lòng nhập email. [UC8-E8]',
            'email.unique' => 'Email đã được sử dụng. [UC8-E29]',
            
            'type.required' => 'Vui lòng chọn vai trò. [UC8-E38]',
            'type.in' => 'Giá trị vai trò không hợp lệ. [UC8-E39]',
        ];

        // Thêm validation cho password nếu có nhập
        if ($request->password != '') {
            $rules['password'] = [
                'required',
                'min:8',
                'max:128',
                function ($attribute, $value, $fail) {
                    // UC8-E37: Kiểm tra khoảng trắng trước (cơ bản nhất)
                    if (!preg_match('/^\S+$/', $value)) {
                        $fail('Mật khẩu chứa khoảng trắng. [UC8-E37]');
                        return;
                    }
                    
                    // UC8-E33: Kiểm tra chữ hoa
                    if (!preg_match('/(?=.*[A-Z])/', $value)) {
                        $fail('Mật khẩu thiếu chữ hoa (A–Z). [UC8-E33]');
                        return;
                    }
                    
                    // UC8-E34: Kiểm tra chữ thường
                    if (!preg_match('/(?=.*[a-z])/', $value)) {
                        $fail('Mật khẩu thiếu chữ thường (a–z). [UC8-E34]');
                        return;
                    }
                    
                    // UC8-E35: Kiểm tra chữ số
                    if (!preg_match('/(?=.*\d)/', $value)) {
                        $fail('Mật khẩu thiếu chữ số (0–9). [UC8-E35]');
                        return;
                    }
                    
                    // UC8-E36: Kiểm tra ký tự đặc biệt
                    if (!preg_match('/(?=.*[!@#$%^&*()_+\-=\[\]{};\':",.<>\/\?\\|~`])/', $value)) {
                        $fail('Mật khẩu thiếu ký tự đặc biệt (ví dụ: !@#$%^&*()_+-=[]{};\':",.<>/?\\|`~). [UC8-E36]');
                        return;
                    }
                },
            ];
            
            $messages['password.required'] = 'Vui lòng nhập mật khẩu. [UC8-E30]';
            $messages['password.min'] = 'Mật khẩu phải có độ dài lớn hơn 8 ký tự. [UC8-E31]';
            $messages['password.max'] = 'Mật khẩu phải có độ dài nhỏ hơn 128 ký tự. [UC8-E32]';
        }

        $request->validate($rules, $messages);
        
        $credentials = $request->only(['name', 'email', 'type']);
        if ($request->password != '') {
            $credentials['password'] = bcrypt($request->password);
        }
        
        User::find($id)->update($credentials);
        return redirect()->route('admin.dashboard')->with('success', 'Cập nhật tài khoản thành công');
    }
    public function destroy($id)
    {
        User::destroy($id);
        return redirect()->route('admin.dashboard')->with('success', 'Xóa tài khoản thành công');
    }
}
