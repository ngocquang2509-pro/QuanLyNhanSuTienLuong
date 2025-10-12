# Biểu đồ dòng điều khiển có T/F - Hàm store() (Refactored Version)

## 1. Sơ đồ tổng quan với True/False branches (Không có loop back)
```
                                    START
                                      ↓
                            [1] Call validateName()
                                   ↙     ↘
                          F (Error)     T (Success)
                              ↓           ↓
                      [E1-E7] Return   [2] Call validateEmail()
                         Error             ↙     ↘
                         ↓         F (Error)     T (Success)
                       END             ↓           ↓
                                [E8-E29] Return   [3] Call validatePassword()
                                   Error             ↙     ↘
                                   ↓         F (Error)     T (Success)
                                 END             ↓           ↓
                                         [E30-E37] Return   [4] Call validateType()
                                            Error             ↙     ↘
                                            ↓         F (Error)     T (Success)
                                          END             ↓           ↓
                                                  [E38-E39] Return   [5] Extract Credentials
                                                     Error             ↓
                                                     ↓        [6] Hash Password
                                                   END                ↓
                                                              [7] Create User
                                                                      ↓
                                                              [8] Redirect Success
                                                                      ↓
                                                                    END

Legend:
- Mỗi return error → END (không quay lại)
- Chỉ có 1 đường dẫn đến success
- Fail fast: gặp lỗi đầu tiên → dừng ngay
```

## 1.1 Giải thích chi tiết flow execution

### ❌ Không có loop back vì:
```php
// Code thực tế trong store()
$nameValidation = $this->validateName($request->name);
if ($nameValidation !== true) {
    return back()->withErrors(['name' => $nameValidation])->withInput(); // DỪNG TẠI ĐÂY
}
// Code này chỉ chạy nếu name validation PASS

$emailValidation = $this->validateEmail($request->email);
if ($emailValidation !== true) {
    return back()->withErrors(['email' => $emailValidation])->withInput(); // DỪNG TẠI ĐÂY  
}
// Code này chỉ chạy nếu email validation PASS
```

### ✅ Execution paths thực tế:
1. **Path 1**: START → validateName() → F → Return E1 → END
2. **Path 2**: START → validateName() → F → Return E2 → END  
3. **Path 8**: START → validateName() → T → validateEmail() → F → Return E8 → END
4. **Path 40**: START → validateName() → T → validateEmail() → T → validatePassword() → T → validateType() → T → Success → END

### 🔄 Nếu muốn có loop back, cần refactor:
```php
// Hypothetical loop-back version (không phải code hiện tại)
public function store(Request $request)
{
    $errors = [];
    
    // Validate all fields và collect errors
    $nameValidation = $this->validateName($request->name);
    if ($nameValidation !== true) {
        $errors['name'] = $nameValidation;
    }
    
    $emailValidation = $this->validateEmail($request->email);  
    if ($emailValidation !== true) {
        $errors['email'] = $emailValidation;
    }
    
    // Nếu có errors → return, nếu không → continue
    if (!empty($errors)) {
        return back()->withErrors($errors)->withInput();
    }
    
    // Success path...
}
```

## 2. Chi tiết từng validation method với T/F

### Method validateName() - Chi tiết internal logic
```
validateName($name)
    ↓
[1.1] empty($name)?
    ↙     ↘
   T       F
   ↓       ↓
[E1]   [1.2] strlen($name) < 2?
           ↙     ↘
          T       F
          ↓       ↓
       [E2]   [1.3] strlen($name) > 100?
                  ↙     ↘
                 T       F
                 ↓       ↓
              [E3]   [1.4] preg_match('/\d/', $name)?
                         ↙     ↘
                        T       F
                        ↓       ↓
                     [E4]   [1.5] !preg_match('/^[\p{L}\s]+$/u', $name)?
                                ↙     ↘
                               T       F
                               ↓       ↓
                            [E5]   [1.6] preg_match('/^\s|\s$/', $name)?
                                       ↙     ↘
                                      T       F
                                      ↓       ↓
                                   [E6]   [1.7] preg_match('/\s{2,}/', $name)?
                                              ↙     ↘
                                             T       F
                                             ↓       ↓
                                          [E7]   return true
```

### Method validateEmail() - Chi tiết internal logic  
```
validateEmail($email)
    ↓
[2.1] empty($email)?
    ↙     ↘
   T       F
   ↓       ↓
[E8]   [2.2] preg_match('/\s/', $email)?
           ↙     ↘
          T       F
          ↓       ↓
       [E9]   [2.3] substr_count($email, '@') !== 1?
                  ↙     ↘
                 T       F
                 ↓       ↓
              [E10]  [2.4] strlen($localPart) < 1?
                         ↙     ↘
                        T       F
                        ↓       ↓
                     [E11]  [2.5] strlen($localPart) > 64?
                                ↙     ↘
                               T       F
                               ↓       ↓
                            [E12]  [... continues for all 22 email rules]
                                   ↓
                               return true (when all pass)
```

### Method validatePassword() - Chi tiết internal logic
```
validatePassword($password)
    ↓
[3.1] empty($password)?
    ↙     ↘
   T       F
   ↓       ↓
[E30]  [3.2] strlen($password) < 8?
           ↙     ↘
          T       F
          ↓       ↓
       [E31]  [3.3] strlen($password) > 128?
                  ↙     ↘
                 T       F
                 ↓       ↓
              [E32]  [3.4] !preg_match('/^\S+$/', $password)?
                         ↙     ↘
                        T       F
                        ↓       ↓
                     [E37]  [3.5] !preg_match('/(?=.*[A-Z])/', $password)?
                                ↙     ↘
                               T       F
                               ↓       ↓
                            [E33]  [... continues for remaining rules]
                                   ↓
                               return true
```

### Method validateType() - Chi tiết internal logic
```
validateType($type)
    ↓
[4.1] empty($type)?
    ↙     ↘
   T       F
   ↓       ↓
[E38]  [4.2] !in_array($type, ['CTO','ACC','HMN'])?
           ↙     ↘
          T       F
          ↓       ↓
       [E39]  return true
```

## 3. Complete Control Flow Graph với Node IDs (No Loop Back)

```
Node ID | Description | Type | True Branch | False Branch | Can Return?
--------|-------------|------|-------------|--------------|-------------
N1      | validateName() call | Decision | N2 | E1-E7 → END | ❌ No return
N2      | validateEmail() call | Decision | N3 | E8-E29 → END | ❌ No return  
N3      | validatePassword() call | Decision | N4 | E30-E37 → END | ❌ No return
N4      | validateType() call | Decision | N5 | E38-E39 → END | ❌ No return
N5      | Extract credentials | Process | N6 | - | -
N6      | Hash password | Process | N7 | - | -
N7      | Create user | Process | N8 | - | -
N8      | Redirect success | Process | END | - | -
E1-E39  | Error returns | Terminal | - | - | ❌ Function ends
END     | Success end | Terminal | - | - | ❌ Function ends
```

## 3.1 Execution Flow Analysis

### 🔍 Fail-Fast Pattern:
- **Validation 1 fail** → Return error → END (không check validation 2,3,4)
- **Validation 2 fail** → Return error → END (không check validation 3,4)  
- **Validation 3 fail** → Return error → END (không check validation 4)
- **Validation 4 fail** → Return error → END
- **All pass** → Continue to success

### 📊 Path Distribution:
```
Total possible combinations: 2^4 = 16 theoretical paths
Actual executable paths: 40 paths (39 errors + 1 success)

Why 40 instead of 16?
- validateName() có 7 different error conditions
- validateEmail() có 22 different error conditions  
- validatePassword() có 8 different error conditions
- validateType() có 2 different error conditions
- Success có 1 path
Total: 7 + 22 + 8 + 2 + 1 = 40 paths
```

## 4. Paths Matrix cho Testing

| Path ID | Route | Description | Test Case |
|---------|-------|-------------|-----------|
| P1 | N1→E1 | Name empty | name="" |
| P2 | N1→E2 | Name too short | name="a" |
| P3 | N1→E3 | Name too long | name="a"×101 |
| P4 | N1→E4 | Name has digit | name="John1" |
| P5 | N1→E5 | Name special char | name="John@" |
| P6 | N1→E6 | Name space edge | name=" John " |
| P7 | N1→E7 | Name double space | name="John  Doe" |
| P8 | N1→N2→E8 | Email empty | name="John", email="" |
| P9 | N1→N2→E9 | Email whitespace | name="John", email="a @b.com" |
| ... | ... | ... | ... |
| P40 | N1→N2→N3→N4→N5→N6→N7→N8→END | Success | All valid inputs |

## 5. Cyclomatic Complexity Calculation

### Main store() method:
- **Decision nodes**: 4 (4 validation calls)  
- **V(G) = 4 + 1 = 5**

### Individual validation methods:
- **validateName()**: V(G) = 7 + 1 = 8
- **validateEmail()**: V(G) = 22 + 1 = 23  
- **validatePassword()**: V(G) = 8 + 1 = 9
- **validateType()**: V(G) = 2 + 1 = 3

### Total complexity: 
- **Combined V(G) = 5 + 8 + 23 + 9 + 3 = 48**

## 6. Testing Strategy

### Unit Testing (Individual Methods):
```php
// Test validateName() - 8 paths (7 errors + 1 success)
testValidateNameEmpty() // P1: E1
testValidateNameTooShort() // P2: E2  
testValidateNameTooLong() // P3: E3
// ... etc

// Test validateEmail() - 23 paths (22 errors + 1 success)
testValidateEmailEmpty() // P8: E8
// ... etc
```

### Integration Testing (Complete store()):
```php
// Test complete paths through store()
testStoreNameError() // P1-P7: Name validation fails
testStoreEmailError() // P8-P29: Email validation fails  
testStorePasswordError() // P30-P37: Password validation fails
testStoreTypeError() // P38-P39: Type validation fails
testStoreSuccess() // P40: All validations pass
```

## 7. Advantages of This Structure

### For White Box Testing:
✅ **Clear T/F branches** for each decision point
✅ **Explicit error paths** visible in code
✅ **Modular testing** - test each validation separately
✅ **Path coverage** easily measurable  
✅ **40 distinct execution paths** all testable

### Control Flow Benefits:
✅ **Sequential validation** - fail fast approach
✅ **Early returns** - no nested conditions
✅ **Single responsibility** - each method validates one field
✅ **Predictable flow** - easy to trace execution

---
*Biểu đồ này phù hợp cho White Box Testing với explicit True/False branches và clear path identification.*