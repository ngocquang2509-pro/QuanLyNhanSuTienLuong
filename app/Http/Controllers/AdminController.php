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
        //NAME VALIDATION - Kiểm tra họ và tên (7 validation rules)
        $nameValidation = $this->validateName($request->name);
        if ($nameValidation !== true) {
            return back()->withErrors(['name' => $nameValidation])->withInput();
        }
        
        //EMAIL VALIDATION - Kiểm tra email (22 validation rules)
        $emailValidation = $this->validateEmail($request->email);
        if ($emailValidation !== true) {
            return back()->withErrors(['email' => $emailValidation])->withInput();
        }
        
        //PASSWORD VALIDATION - Kiểm tra mật khẩu (8 validation rules)
        $passwordValidation = $this->validatePassword($request->password);
        if ($passwordValidation !== true) {
            return back()->withErrors(['password' => $passwordValidation])->withInput();
        }
        
        //TYPE VALIDATION - Kiểm tra vai trò (2 validation rules)
        $typeValidation = $this->validateType($request->type);
        if ($typeValidation !== true) {
            return back()->withErrors(['type' => $typeValidation])->withInput();
        }
        
        //EXTRACT CREDENTIALS - Trích xuất dữ liệu đã được validate
        $credentials = $request->only(['name', 'email', 'password', 'type']);
        
        //HASH PASSWORD - Mã hóa mật khẩu
        $credentials['password'] = bcrypt($credentials['password']);
        
        //CREATE USER - Tạo user trong database
        User::create($credentials);
        
        //REDIRECT SUCCESS - Chuyển hướng thành công
        return redirect()->route('admin.dashboard')->with('success', 'Thêm tài khoản thành công');
    }
    
    // CUSTOM VALIDATION METHODS
    
    /**
     * Validate Name field - 7 validation rules
     * UC8-E1 to UC8-E7
     */
    private function validateName($name)
    {
        // UC8-E1: Required
        if (empty($name)) {
            return 'Vui lòng nhập họ và tên. [UC8-E1]';
        }
        
        // UC8-E2: Min length 2
        if (strlen($name) < 2) {
            return 'Họ và tên phải có ít nhất 2 ký tự. [UC8-E2]';
        }
        
        // UC8-E3: Max length 100
        if (strlen($name) > 100) {
            return 'Họ và tên không được vượt quá 100 ký tự. [UC8-E3]';
        }
        
        // UC8-E4: No digits
        if (preg_match('/\d/', $name)) {
            return 'Họ và tên không được chứa chữ số. [UC8-E4]';
        }
        
        // UC8-E5: No special characters
        if (!preg_match('/^[\p{L}\s]+$/u', $name)) {
            return 'Họ và tên không được chứa ký tự đặc biệt. [UC8-E5]';
        }
        
        // UC8-E6: No leading/trailing spaces
        if (preg_match('/^\s|\s$/', $name)) {
            return 'Họ và tên không được có khoảng trắng ở đầu hoặc cuối. [UC8-E6]';
        }
        
        // UC8-E7: No multiple consecutive spaces
        if (preg_match('/\s{2,}/', $name)) {
            return 'Họ và tên không được có nhiều khoảng trắng liên tiếp. [UC8-E7]';
        }
        
        return true; // Success
    }
    
    /**
     * Validate Email field - 22 validation rules
     * UC8-E8 to UC8-E29
     */
    private function validateEmail($email)
    {
        // UC8-E8: Required
        if (empty($email)) {
            return 'Vui lòng nhập email. [UC8-E8]';
        }
        
        // UC8-E9: No whitespace
        if (preg_match('/\s/', $email)) {
            return 'Email không được chứa khoảng trắng. [UC8-E9]';
        }
        
        // UC8-E10: Exactly one '@'
        $atCount = substr_count($email, '@');
        if ($atCount !== 1) {
            return 'Email phải chứa đúng 1 ký tự \'@\'. [UC8-E10]';
        }
        
        // Split local-part and domain
        $parts = explode('@', $email);
        $localPart = $parts[0];
        $domain = $parts[1];
        
        // LOCAL-PART VALIDATION
        
        // UC8-E11: Local-part at least 1 character
        if (strlen($localPart) < 1) {
            return 'Local-part không hợp lệ: Ít nhất 1 ký tự. [UC8-E11]';
        }
        
        // UC8-E12: Local-part max 64 characters
        if (strlen($localPart) > 64) {
            return 'Local-part không hợp lệ: độ dài không được vượt quá 64 ký tự. [UC8-E12]';
        }
        
        // UC8-E13: Local-part cannot start with '.'
        if (substr($localPart, 0, 1) === '.') {
            return 'Local-part không hợp lệ: không được bắt đầu bằng dấu chấm (\'.\')。[UC8-E13]';
        }
        
        // UC8-E14: Local-part cannot end with '.'
        if (substr($localPart, -1) === '.') {
            return 'Local-part không hợp lệ: không được kết thúc bằng dấu chấm (\'.\')。[UC8-E14]';
        }
        
        // UC8-E15: Local-part cannot contain '..'
        if (strpos($localPart, '..') !== false) {
            return 'Local-part không hợp lệ: không được chứa chuỗi \'..\'. [UC8-E15]';
        }
        
        // UC8-E16: Local-part valid characters [A-Za-z0-9._+-]
        if (!preg_match('/^[A-Za-z0-9._+-]+$/', $localPart)) {
            return 'Local-part không hợp lệ: chỉ cho phép [A–Z a–z 0–9 . _ + -]. [UC8-E16]';
        }
        
        // DOMAIN VALIDATION
        
        // UC8-E17: Domain empty
        if (empty($domain)) {
            return 'Domain không hợp lệ: để trống sau ký tự \'@\'. [UC8-E17]';
        }
        
        // UC8-E18: Domain must have at least one dot
        if (strpos($domain, '.') === false) {
            return 'Domain không hợp lệ: phải có ít nhất một dấu chấm. [UC8-E18]';
        }
        
        // UC8-E19: Domain cannot contain '..'
        if (strpos($domain, '..') !== false) {
            return 'Domain không hợp lệ: không được chứa chuỗi \'..\'. [UC8-E19]';
        }
        
        // UC8-E28: Domain ASCII only (no IDN support)
        if (!mb_check_encoding($domain, 'ASCII')) {
            return 'Domain không hợp lệ: chỉ chấp nhận ASCII (không hỗ trợ IDN). [UC8-E28]';
        }
        
        // Split domain into labels
        $labels = explode('.', $domain);
        $tld = end($labels); // Last label is TLD
        
        // TLD VALIDATION (high priority)
        
        // UC8-E24: TLD must be letters only [a-z]
        if (!preg_match('/^[a-z]+$/i', $tld)) {
            return 'Domain không hợp lệ: TLD phải là chữ cái [a–z]. [UC8-E24]';
        }
        
        // UC8-E25: TLD at least 2 characters
        if (strlen($tld) < 2) {
            return 'Domain không hợp lệ: ít nhất 2 ký tự [UC8-E25]';
        }
        
        // UC8-E26: TLD max 63 characters
        if (strlen($tld) > 63) {
            return 'Domain không hợp lệ: nhiều nhất 63 ký tự [UC8-E26]';
        }
        
        // NON-TLD LABELS VALIDATION
        $nonTldLabels = array_slice($labels, 0, -1); // Remove TLD
        foreach ($nonTldLabels as $label) {
            // UC8-E20: Each label valid characters [a-z0-9-]
            if (!preg_match('/^[a-z0-9-]+$/i', $label)) {
                return 'Domain không hợp lệ: mỗi nhãn chỉ cho phép [a–z 0–9 -]. [UC8-E20]';
            }
            
            // UC8-E21: Label cannot start/end with '-'
            
            if (substr($label, 0, 1) === '-' || substr($label, -1) === '-') {
                return 'Domain không hợp lệ: nhãn không được bắt đầu hoặc kết thúc bằng dấu \'-\'. [UC8-E21]';
            }
            
            // UC8-E22: NON-TLD label max 63 characters
            if (strlen($label) > 63) {
                return 'Domain không hợp lệ: mỗi nhãn không được vượt quá 63 ký tự. [UC8-E22]';
            }
        }
        
        // UC8-E23: Total domain max 253 characters
        if (strlen($domain) > 253) {
            return 'Domain không hợp lệ: tổng độ dài phần domain không được vượt quá 253 ký tự. [UC8-E23]';
        }
        
        // UC8-E27: Total email max 254 characters
        if (strlen($email) > 254) {
            return 'Domain không hợp lệ: tổng độ dài địa chỉ email không được vượt quá 254 ký tự. [UC8-E27]';
        }
        
        // UC8-E29: Email unique check
        if (User::where('email', $email)->exists()) {
            return 'Email đã được sử dụng. [UC8-E29]';
        }
        
        return true; // Success
    }
    
    /**
     * Validate Password field - 8 validation rules
     * UC8-E30 to UC8-E37
     */
    private function validatePassword($password)
    {
        // UC8-E30: Required
        if (empty($password)) {
            return 'Vui lòng nhập mật khẩu. [UC8-E30]';
        }
        
        // UC8-E31: Min length 8
        if (strlen($password) < 8) {
            return 'Mật khẩu phải có độ dài lớn hơn 8 ký tự. [UC8-E31]';
        }
        
        // UC8-E32: Max length 128
        if (strlen($password) > 128) {
            return 'Mật khẩu phải có độ dài nhỏ hơn 128 ký tự. [UC8-E32]';
        }
        
        // UC8-E37: No whitespace (check first)
        if (!preg_match('/^\S+$/', $password)) {
            return 'Mật khẩu chứa khoảng trắng. [UC8-E37]';
        }
        
        // UC8-E33: Must contain uppercase
        if (!preg_match('/(?=.*[A-Z])/', $password)) {
            return 'Mật khẩu thiếu chữ hoa (A–Z). [UC8-E33]';
        }
        
        // UC8-E34: Must contain lowercase
        if (!preg_match('/(?=.*[a-z])/', $password)) {
            return 'Mật khẩu thiếu chữ thường (a–z). [UC8-E34]';
        }
        
        // UC8-E35: Must contain digit
        if (!preg_match('/(?=.*\d)/', $password)) {
            return 'Mật khẩu thiếu chữ số (0–9). [UC8-E35]';
        }
        
        // UC8-E36: Must contain special character
        if (!preg_match('/(?=.*[!@#$%^&*()_+\-=\[\]{};\':",.<>\/\?\\|~`])/', $password)) {
            return 'Mật khẩu thiếu ký tự đặc biệt (ví dụ: !@#$%^&*()_+-=[]{};\':",.<>/?\\|`~). [UC8-E36]';
        }
        
        return true; // Success
    }
    
    /**
     * Validate Type field - 2 validation rules  
     * UC8-E38 to UC8-E39
     */
    private function validateType($type)
    {
        // UC8-E38: Required
        if (empty($type)) {
            return 'Vui lòng chọn vai trò. [UC8-E38]';
        }
        
        // UC8-E39: Valid values
        if (!in_array($type, ['CTO', 'ACC', 'HMN'])) {
            return 'Giá trị vai trò không hợp lệ. [UC8-E39]';
        }
        
        return true; // Success
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