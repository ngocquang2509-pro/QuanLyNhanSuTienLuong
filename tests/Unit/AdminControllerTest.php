<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Http\Controllers\AdminController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Foundation\Testing\RefreshDatabase;
use ReflectionClass;

/**
 * Kiểm thử đơn vị cho AdminController
 * Kiểm thử các hàm validation và hàm store
 */
class AdminControllerTest extends TestCase
{
    use RefreshDatabase;

    private $controller;
    private $reflection;

    /**
     * Thiết lập trước mỗi test
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->controller = new AdminController();
        $this->reflection = new ReflectionClass($this->controller);
    }

    /**
     * Helper method để gọi private method
     */
    private function callPrivateMethod($methodName, $parameters = [])
    {
        $method = $this->reflection->getMethod($methodName);
        $method->setAccessible(true);
        return $method->invokeArgs($this->controller, $parameters);
    }

    // ===== KIỂM THỬ validateName() - 8 test cases =====

    /**
     * Test UC8-E1: Name required
     */
    public function test_validateName_empty_returns_E1()
    {
        $result = $this->callPrivateMethod('validateName', ['']);
        $this->assertEquals('Vui lòng nhập họ và tên. [UC8-E1]', $result);
    }

    /**
     * Test UC8-E2: Name min length 2
     */
    public function test_validateName_too_short_returns_E2()
    {
        $result = $this->callPrivateMethod('validateName', ['a']);
        $this->assertEquals('Họ và tên phải có ít nhất 2 ký tự. [UC8-E2]', $result);
    }

    /**
     * Test UC8-E3: Name max length 100
     */
    public function test_validateName_too_long_returns_E3()
    {
        $longName = str_repeat('a', 101);
        $result = $this->callPrivateMethod('validateName', [$longName]);
        $this->assertEquals('Họ và tên không được vượt quá 100 ký tự. [UC8-E3]', $result);
    }

    /**
     * Test UC8-E4: Name no digits
     */
    public function test_validateName_with_digits_returns_E4()
    {
        $result = $this->callPrivateMethod('validateName', ['John1']);
        $this->assertEquals('Họ và tên không được chứa chữ số. [UC8-E4]', $result);
    }

    /**
     * Test UC8-E5: Name no special characters
     */
    public function test_validateName_with_special_chars_returns_E5()
    {
        $result = $this->callPrivateMethod('validateName', ['John@']);
        $this->assertEquals('Họ và tên không được chứa ký tự đặc biệt. [UC8-E5]', $result);
    }

    /**
     * Test UC8-E6: Name no leading/trailing spaces
     */
    public function test_validateName_with_leading_trailing_spaces_returns_E6()
    {
        $result = $this->callPrivateMethod('validateName', [' John ']);
        $this->assertEquals('Họ và tên không được có khoảng trắng ở đầu hoặc cuối. [UC8-E6]', $result);
    }

    /**
     * Test UC8-E7: Name no multiple consecutive spaces
     */
    public function test_validateName_with_multiple_spaces_returns_E7()
    {
        $result = $this->callPrivateMethod('validateName', ['John  Doe']);
        $this->assertEquals('Họ và tên không được có nhiều khoảng trắng liên tiếp. [UC8-E7]', $result);
    }

    /**
     * Test name validation success
     */
    public function test_validateName_valid_returns_true()
    {
        $result = $this->callPrivateMethod('validateName', ['John Doe']);
        $this->assertTrue($result);
    }

    // ===== KIỂM THỬ validateEmail() - 23 test cases =====

    /**
     * Test UC8-E8: Email required
     */
    public function test_validateEmail_empty_returns_E8()
    {
        $result = $this->callPrivateMethod('validateEmail', ['']);
        $this->assertEquals('Vui lòng nhập email. [UC8-E8]', $result);
    }

    /**
     * Test UC8-E9: Email no whitespace
     */
    public function test_validateEmail_with_whitespace_returns_E9()
    {
        $result = $this->callPrivateMethod('validateEmail', ['test @example.com']);
        $this->assertEquals('Email không được chứa khoảng trắng. [UC8-E9]', $result);
    }

    /**
     * Test UC8-E10: Email exactly one '@'
     */
    public function test_validateEmail_multiple_at_returns_E10()
    {
        $result = $this->callPrivateMethod('validateEmail', ['test@@example.com']);
        $this->assertEquals('Email phải chứa đúng 1 ký tự \'@\'. [UC8-E10]', $result);
    }

    /**
     * Test UC8-E11: Local-part at least 1 character
     */
    public function test_validateEmail_empty_localpart_returns_E11()
    {
        $result = $this->callPrivateMethod('validateEmail', ['@example.com']);
        $this->assertEquals('Local-part không hợp lệ: Ít nhất 1 ký tự. [UC8-E11]', $result);
    }

    /**
     * Test UC8-E12: Local-part max 64 characters
     */
    public function test_validateEmail_long_localpart_returns_E12()
    {
        $longLocal = str_repeat('a', 65);
        $result = $this->callPrivateMethod('validateEmail', [$longLocal . '@example.com']);
        $this->assertEquals('Local-part không hợp lệ: độ dài không được vượt quá 64 ký tự. [UC8-E12]', $result);
    }

    /**
     * Test UC8-E13: Local-part cannot start with '.'
     */
    public function test_validateEmail_localpart_starts_with_dot_returns_E13()
    {
        $result = $this->callPrivateMethod('validateEmail', ['.test@example.com']);
        $this->assertEquals('Local-part không hợp lệ: không được bắt đầu bằng dấu chấm (\'.\')。[UC8-E13]', $result);
    }

    /**
     * Test UC8-E14: Local-part cannot end with '.'
     */
    public function test_validateEmail_localpart_ends_with_dot_returns_E14()
    {
        $result = $this->callPrivateMethod('validateEmail', ['test.@example.com']);
        $this->assertEquals('Local-part không hợp lệ: không được kết thúc bằng dấu chấm (\'.\')。[UC8-E14]', $result);
    }

    /**
     * Test UC8-E15: Local-part cannot contain '..'
     */
    public function test_validateEmail_localpart_double_dot_returns_E15()
    {
        $result = $this->callPrivateMethod('validateEmail', ['te..st@example.com']);
        $this->assertEquals('Local-part không hợp lệ: không được chứa chuỗi \'..\'. [UC8-E15]', $result);
    }

    /**
     * Test UC8-E16: Local-part valid characters
     */
    public function test_validateEmail_localpart_invalid_chars_returns_E16()
    {
        $result = $this->callPrivateMethod('validateEmail', ['te#st@example.com']);
        $this->assertEquals('Local-part không hợp lệ: chỉ cho phép [A–Z a–z 0–9 . _ + -]. [UC8-E16]', $result);
    }

    /**
     * Test UC8-E17: Domain empty
     */
    public function test_validateEmail_empty_domain_returns_E17()
    {
        $result = $this->callPrivateMethod('validateEmail', ['test@']);
        $this->assertEquals('Domain không hợp lệ: để trống sau ký tự \'@\'. [UC8-E17]', $result);
    }

    /**
     * Test UC8-E18: Domain must have at least one dot
     */
    public function test_validateEmail_domain_no_dot_returns_E18()
    {
        $result = $this->callPrivateMethod('validateEmail', ['test@domain']);
        $this->assertEquals('Domain không hợp lệ: phải có ít nhất một dấu chấm. [UC8-E18]', $result);
    }

    /**
     * Test UC8-E19: Domain cannot contain '..'
     */
    public function test_validateEmail_domain_double_dot_returns_E19()
    {
        $result = $this->callPrivateMethod('validateEmail', ['test@sub..domain.com']);
        $this->assertEquals('Domain không hợp lệ: không được chứa chuỗi \'..\'. [UC8-E19]', $result);
    }

    /**
     * Test UC8-E24: TLD must be letters only
     */
    public function test_validateEmail_tld_with_numbers_returns_E24()
    {
        $result = $this->callPrivateMethod('validateEmail', ['test@domain.c0m']);
        $this->assertEquals('Domain không hợp lệ: TLD phải là chữ cái [a–z]. [UC8-E24]', $result);
    }

    /**
     * Test UC8-E25: TLD at least 2 characters
     */
    public function test_validateEmail_tld_too_short_returns_E25()
    {
        $result = $this->callPrivateMethod('validateEmail', ['test@domain.c']);
        $this->assertEquals('Domain không hợp lệ: ít nhất 2 ký tự [UC8-E25]', $result);
    }

    /**
     * Test UC8-E26: TLD max 63 characters
     */
    public function test_validateEmail_tld_too_long_returns_E26()
    {
        $longTld = str_repeat('a', 64);
        $result = $this->callPrivateMethod('validateEmail', ['test@domain.' . $longTld]);
        $this->assertEquals('Domain không hợp lệ: nhiều nhất 63 ký tự [UC8-E26]', $result);
    }

    /**
     * Test UC8-E20: Non-TLD label invalid characters
     */
    public function test_validateEmail_nonTld_invalid_chars_returns_E20()
    {
        $result = $this->callPrivateMethod('validateEmail', ['test@sub$.domain.com']);
        $this->assertEquals('Domain không hợp lệ: mỗi nhãn chỉ cho phép [a–z 0–9 -]. [UC8-E20]', $result);
    }

    /**
     * Test UC8-E21: Non-TLD label cannot start/end with '-'
     */
    public function test_validateEmail_nonTld_hyphen_edge_returns_E21()
    {
        $result = $this->callPrivateMethod('validateEmail', ['test@-sub.domain.com']);
        $this->assertEquals('Domain không hợp lệ: nhãn không được bắt đầu hoặc kết thúc bằng dấu \'-\'. [UC8-E21]', $result);
    }

    /**
     * Test UC8-E22: Non-TLD label max 63 characters
     */
    public function test_validateEmail_nonTld_too_long_returns_E22()
    {
        $longLabel = str_repeat('a', 64);
        $result = $this->callPrivateMethod('validateEmail', ['test@' . $longLabel . '.com']);
        $this->assertEquals('Domain không hợp lệ: mỗi nhãn không được vượt quá 63 ký tự. [UC8-E22]', $result);
    }

    /**
     * Test UC8-E23: Total domain max 253 characters
     */
    public function test_validateEmail_domain_too_long_returns_E23()
    {
        // Create domain > 253 chars with each label <= 63 chars
        $label = str_repeat('ab', 31) . 'c'; // 63 chars exactly
        $domain = $label . '.' . $label . '.' . $label . '.' . $label . '.com'; // 63*4 + 4 dots + 3 = 259 chars
        $result = $this->callPrivateMethod('validateEmail', ['test@' . $domain]);
        $this->assertEquals('Domain không hợp lệ: tổng độ dài phần domain không được vượt quá 253 ký tự. [UC8-E23]', $result);
    }

    /**
     * Test UC8-E27: Total email max 254 characters
     */
    public function test_validateEmail_total_too_long_returns_E27()
    {
        // Create email > 254 chars with valid domain length
        $localPart = str_repeat('a', 64); // Exactly 64 chars (max allowed)
        $label = str_repeat('ab', 31) . 'c'; // 63 chars
        $domain = $label . '.' . $label . '.com'; // 63 + 1 + 63 + 1 + 3 = 131 chars
        $email = $localPart . '@' . $domain; // 64 + 1 + 131 = 196 chars (this won't work)
        
        // Need longer domain that's still valid
        $label1 = str_repeat('ab', 31) . 'c'; // 63 chars
        $label2 = str_repeat('cd', 31) . 'e'; // 63 chars  
        $label3 = str_repeat('fg', 31) . 'h'; // 63 chars
        $domain = $label1 . '.' . $label2 . '.' . $label3 . '.com'; // 63*3 + 3 dots + 3 = 195 chars
        $email = $localPart . '@' . $domain; // 64 + 1 + 195 = 260 chars total
        $result = $this->callPrivateMethod('validateEmail', [$email]);
        $this->assertEquals('Domain không hợp lệ: tổng độ dài địa chỉ email không được vượt quá 254 ký tự. [UC8-E27]', $result);
    }

    /**
     * Test UC8-E29: Email unique check (cần setup database)
     */
    public function test_validateEmail_duplicate_returns_E29()
    {
        // Tạo user với email test@example.com
        User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'type' => 'CTO'
        ]);

        $result = $this->callPrivateMethod('validateEmail', ['test@example.com']);
        $this->assertEquals('Email đã được sử dụng. [UC8-E29]', $result);
    }

    /**
     * Test email validation success
     */
    public function test_validateEmail_valid_returns_true()
    {
        $result = $this->callPrivateMethod('validateEmail', ['test@example.com']);
        $this->assertTrue($result);
    }

    // ===== KIỂM THỬ validatePassword() - 9 test cases =====

    /**
     * Test UC8-E30: Password required
     */
    public function test_validatePassword_empty_returns_E30()
    {
        $result = $this->callPrivateMethod('validatePassword', ['']);
        $this->assertEquals('Vui lòng nhập mật khẩu. [UC8-E30]', $result);
    }

    /**
     * Test UC8-E31: Password min length 8
     */
    public function test_validatePassword_too_short_returns_E31()
    {
        $result = $this->callPrivateMethod('validatePassword', ['Abc1@']);
        $this->assertEquals('Mật khẩu phải có độ dài lớn hơn 8 ký tự. [UC8-E31]', $result);
    }

    /**
     * Test UC8-E32: Password max length 128
     */
    public function test_validatePassword_too_long_returns_E32()
    {
        $longPassword = str_repeat('Abc1@', 26); // 130 chars
        $result = $this->callPrivateMethod('validatePassword', [$longPassword]);
        $this->assertEquals('Mật khẩu phải có độ dài nhỏ hơn 128 ký tự. [UC8-E32]', $result);
    }

    /**
     * Test UC8-E37: Password no whitespace
     */
    public function test_validatePassword_with_whitespace_returns_E37()
    {
        $result = $this->callPrivateMethod('validatePassword', ['Abc 123@']);
        $this->assertEquals('Mật khẩu chứa khoảng trắng. [UC8-E37]', $result);
    }

    /**
     * Test UC8-E33: Password must contain uppercase
     */
    public function test_validatePassword_no_uppercase_returns_E33()
    {
        $result = $this->callPrivateMethod('validatePassword', ['abcdefg123@']);
        $this->assertEquals('Mật khẩu thiếu chữ hoa (A–Z). [UC8-E33]', $result);
    }

    /**
     * Test UC8-E34: Password must contain lowercase
     */
    public function test_validatePassword_no_lowercase_returns_E34()
    {
        $result = $this->callPrivateMethod('validatePassword', ['ABCDEFG123@']);
        $this->assertEquals('Mật khẩu thiếu chữ thường (a–z). [UC8-E34]', $result);
    }

    /**
     * Test UC8-E35: Password must contain digit
     */
    public function test_validatePassword_no_digit_returns_E35()
    {
        $result = $this->callPrivateMethod('validatePassword', ['Abcdefgh@']);
        $this->assertEquals('Mật khẩu thiếu chữ số (0–9). [UC8-E35]', $result);
    }

    /**
     * Test UC8-E36: Password must contain special character
     */
    public function test_validatePassword_no_special_returns_E36()
    {
        $result = $this->callPrivateMethod('validatePassword', ['Abcdef123']);
        $this->assertEquals('Mật khẩu thiếu ký tự đặc biệt (ví dụ: !@#$%^&*()_+-=[]{};\':",.<>/?\\|`~). [UC8-E36]', $result);
    }

    /**
     * Test password validation success
     */
    public function test_validatePassword_valid_returns_true()
    {
        $result = $this->callPrivateMethod('validatePassword', ['Password123@']);
        $this->assertTrue($result);
    }

    // ===== KIỂM THỬ validateType() - 3 test cases =====

    /**
     * Test UC8-E38: Type required
     */
    public function test_validateType_empty_returns_E38()
    {
        $result = $this->callPrivateMethod('validateType', ['']);
        $this->assertEquals('Vui lòng chọn vai trò. [UC8-E38]', $result);
    }

    /**
     * Test UC8-E39: Type valid values
     */
    public function test_validateType_invalid_returns_E39()
    {
        $result = $this->callPrivateMethod('validateType', ['INVALID']);
        $this->assertEquals('Giá trị vai trò không hợp lệ. [UC8-E39]', $result);
    }

    /**
     * Test type validation success
     */
    public function test_validateType_valid_returns_true()
    {
        $validTypes = ['CTO', 'ACC', 'HMN'];
        foreach ($validTypes as $type) {
            $result = $this->callPrivateMethod('validateType', [$type]);
            $this->assertTrue($result, "Type '$type' should be valid");
        }
    }

    // ===== KIỂM THỬ store() method - Integration tests =====

    /**
     * Test store method with invalid name
     */
    public function test_store_invalid_name_returns_error()
    {
        $request = Request::create('/admin/store', 'POST', [
            'name' => 'a', // Too short
            'email' => 'test@example.com',
            'password' => 'Password123@',
            'type' => 'CTO'
        ]);

        $response = $this->controller->store($request);
        
        // Kiểm tra redirect back with error
        $this->assertEquals(302, $response->getStatusCode());
        $this->assertArrayHasKey('name', session('errors')->getBag('default')->getMessages());
    }

    /**
     * Test store method success
     */
    public function test_store_valid_data_creates_user()
    {
        $request = Request::create('/admin/store', 'POST', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'Password123@',
            'type' => 'CTO'
        ]);

        $response = $this->controller->store($request);

        // Kiểm tra user đã được tạo
        $this->assertDatabaseHas('users', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'type' => 'CTO'
        ]);

        // Kiểm tra redirect success
        $this->assertEquals(302, $response->getStatusCode());
    }
}