# Biểu đồ dòng điều khiển - Chức năng thêm tài khoản (store method)

## 1. Sơ đồ tổng quan (Control Flow Graph)
```
                                    START
                                      ↓
                            [1] Name Required?
                                   ↙     ↘
                              NO [E1]    YES
                                          ↓
                            [2] Name Length ≥ 2?
                                   ↙     ↘
                              NO [E2]    YES
                                          ↓
                            [3] Name Length ≤ 100?
                                   ↙     ↘
                              NO [E3]    YES
                                          ↓
                            [4] Name Contains Digits?
                                   ↙     ↘
                              YES [E4]   NO
                                          ↓
                            [5] Name Special Chars?
                                   ↙     ↘
                              YES [E5]   NO
                                          ↓
                            [6] Name Leading/Trailing Space?
                                   ↙     ↘
                              YES [E6]   NO
                                          ↓
                            [7] Name Multiple Spaces?
                                   ↙     ↘
                              YES [E7]   NO
                                          ↓
                            [8] Email Required?
                                   ↙     ↘
                              NO [E8]    YES
                                          ↓
                            [9] Email Has Whitespace?
                                   ↙     ↘
                              YES [E9]   NO
                                          ↓
                            [10] Email Has Exactly 1 '@'?
                                   ↙     ↘
                              NO [E10]   YES
                                          ↓
                            [11] Local-part ≥ 1 char?
                                   ↙     ↘
                              NO [E11]   YES
                                          ↓
                            [12] Local-part ≤ 64 chars?
                                   ↙     ↘
                              NO [E12]   YES
                                          ↓
                            [13] Local-part Starts with '.'?
                                   ↙     ↘
                              YES [E13]  NO
                                          ↓
                            [14] Local-part Ends with '.'?
                                   ↙     ↘
                              YES [E14]  NO
                                          ↓
                            [15] Local-part Has '..'?
                                   ↙     ↘
                              YES [E15]  NO
                                          ↓
                            [16] Local-part Valid Chars?
                                   ↙     ↘
                              NO [E16]   YES
                                          ↓
                            [17] Domain Empty?
                                   ↙     ↘
                              YES [E17]  NO
                                          ↓
                            [18] Domain Has Dot?
                                   ↙     ↘
                              NO [E18]   YES
                                          ↓
                            [19] Domain Has '..'?
                                   ↙     ↘
                              YES [E19]  NO
                                          ↓
                            [20] Domain ASCII Only?
                                   ↙     ↘
                              NO [E28]   YES
                                          ↓
                            [21] TLD Letters Only?
                                   ↙     ↘
                              NO [E24]   YES
                                          ↓
                            [22] TLD ≥ 2 chars?
                                   ↙     ↘
                              NO [E25]   YES
                                          ↓
                            [23] TLD ≤ 63 chars?
                                   ↙     ↘
                              NO [E26]   YES
                                          ↓
                            [24] Non-TLD Labels Valid Chars?
                                   ↙     ↘
                              NO [E20]   YES
                                          ↓
                            [25] Non-TLD Labels No Hyphen Start/End?
                                   ↙     ↘
                              NO [E21]   YES
                                          ↓
                            [26] Non-TLD Labels ≤ 63 chars?
                                   ↙     ↘
                              NO [E22]   YES
                                          ↓
                            [27] TLD Valid Chars?
                                   ↙     ↘
                              NO [E20]   YES
                                          ↓
                            [28] TLD No Hyphen Start/End?
                                   ↙     ↘
                              NO [E21]   YES
                                          ↓
                            [29] Domain ≤ 253 chars?
                                   ↙     ↘
                              NO [E23]   YES
                                          ↓
                            [30] Total Email ≤ 254 chars?
                                   ↙     ↘
                              NO [E27]   YES
                                          ↓
                            [31] Email Unique?
                                   ↙     ↘
                              NO [E29]   YES
                                          ↓
                            [32] Password Required?
                                   ↙     ↘
                              NO [E30]   YES
                                          ↓
                            [33] Password ≥ 8 chars?
                                   ↙     ↘
                              NO [E31]   YES
                                          ↓
                            [34] Password ≤ 128 chars?
                                   ↙     ↘
                              NO [E32]   YES
                                          ↓
                            [35] Password No Whitespace?
                                   ↙     ↘
                              NO [E37]   YES
                                          ↓
                            [36] Password Has Uppercase?
                                   ↙     ↘
                              NO [E33]   YES
                                          ↓
                            [37] Password Has Lowercase?
                                   ↙     ↘
                              NO [E34]   YES
                                          ↓
                            [38] Password Has Digit?
                                   ↙     ↘
                              NO [E35]   YES
                                          ↓
                            [39] Password Has Special Char?
                                   ↙     ↘
                              NO [E36]   YES
                                          ↓
                            [40] Type Required?
                                   ↙     ↘
                              NO [E38]   YES
                                          ↓
                            [41] Type Valid?
                                   ↙     ↘
                              NO [E39]   YES
                                          ↓
                            [42] Extract Credentials
                                          ↓
                            [43] Hash Password
                                          ↓
                            [44] Create User
                                          ↓
                            [45] Redirect Success
                                          ↓
                                       END

Legend:
- [En] = Error path với mã lỗi UC8-En
- Mỗi diamond shape = 1 điều kiện boolean
- Total paths = 39 error paths + 1 success path = 40 paths
- Cyclomatic Complexity V(G) = 40
```

## 2. Chi tiết từng node validation

### Node 1: Name Validation
```
[1] Name Validation
    ↓
[1.1] required? → NO → [E1] Return UC8-E1
    ↓ YES
[1.2] length ≥ 2? → NO → [E2] Return UC8-E2  
    ↓ YES
[1.3] length ≤ 100? → NO → [E3] Return UC8-E3
    ↓ YES
[1.4] contains digits? → YES → [E4] Return UC8-E4
    ↓ NO
[1.5] contains special chars? → YES → [E5] Return UC8-E5
    ↓ NO  
[1.6] starts/ends with space? → YES → [E6] Return UC8-E6
    ↓ NO
[1.7] multiple spaces? → YES → [E7] Return UC8-E7
    ↓ NO
    Continue to Node 2
```

### Node 2: Email Validation (22 kiểm tra)
```
[2] Email Validation
    ↓
[2.1] required? → NO → [E8] Return UC8-E8
    ↓ YES
[2.2] contains whitespace? → YES → [E9] Return UC8-E9
    ↓ NO
[2.3] exactly one '@'? → NO → [E10] Return UC8-E10
    ↓ YES
[2.4] Split local-part & domain
    ↓
[2.5] local-part ≥ 1 char? → NO → [E11] Return UC8-E11
    ↓ YES
[2.6] local-part ≤ 64 chars? → NO → [E12] Return UC8-E12
    ↓ YES
[2.7] local-part starts with '.'? → YES → [E13] Return UC8-E13
    ↓ NO
[2.8] local-part ends with '.'? → YES → [E14] Return UC8-E14
    ↓ NO
[2.9] local-part contains '..'? → YES → [E15] Return UC8-E15
    ↓ NO
[2.10] local-part valid chars [A-Za-z0-9._+-]? → NO → [E16] Return UC8-E16
    ↓ YES
[2.11] domain empty? → YES → [E17] Return UC8-E17
    ↓ NO
[2.12] domain has at least one '.'? → NO → [E18] Return UC8-E18
    ↓ YES
[2.13] domain contains '..'? → YES → [E19] Return UC8-E19
    ↓ NO
[2.14] domain is ASCII only? → NO → [E28] Return UC8-E28
    ↓ YES
[2.15] Split domain into labels
    ↓
[2.16] TLD is letters only [a-z]? → NO → [E24] Return UC8-E24
    ↓ YES
[2.17] TLD ≥ 2 chars? → NO → [E25] Return UC8-E25
    ↓ YES
[2.18] TLD ≤ 63 chars? → NO → [E26] Return UC8-E26
    ↓ YES
[2.19] For each non-TLD label:
    ↓
[2.20] label valid chars [a-z0-9-]? → NO → [E20] Return UC8-E20
    ↓ YES
[2.21] label starts/ends with '-'? → YES → [E21] Return UC8-E21
    ↓ NO
[2.22] non-TLD label ≤ 63 chars? → NO → [E22] Return UC8-E22
    ↓ YES
[2.23] Check TLD chars [a-z0-9-]? → NO → [E20] Return UC8-E20
    ↓ YES
[2.24] TLD starts/ends with '-'? → YES → [E21] Return UC8-E21
    ↓ YES
[2.25] domain ≤ 253 chars? → NO → [E23] Return UC8-E23
    ↓ YES
[2.26] total email ≤ 254 chars? → NO → [E27] Return UC8-E27
    ↓ YES
[2.27] email unique in DB? → NO → [E29] Return UC8-E29
    ↓ YES
    Continue to Node 3
```

### Node 3: Password Validation
```
[3] Password Validation
    ↓
[3.1] required? → NO → [E30] Return UC8-E30
    ↓ YES
[3.2] length ≥ 8? → NO → [E31] Return UC8-E31
    ↓ YES
[3.3] length ≤ 128? → NO → [E32] Return UC8-E32
    ↓ YES
[3.4] contains whitespace? → YES → [E37] Return UC8-E37
    ↓ NO
[3.5] contains uppercase [A-Z]? → NO → [E33] Return UC8-E33
    ↓ YES
[3.6] contains lowercase [a-z]? → NO → [E34] Return UC8-E34
    ↓ YES
[3.7] contains digit [0-9]? → NO → [E35] Return UC8-E35
    ↓ YES
[3.8] contains special char? → NO → [E36] Return UC8-E36
    ↓ YES
    Continue to Node 4
```

### Node 4: Type Validation
```
[4] Type Validation
    ↓
[4.1] required? → NO → [E38] Return UC8-E38
    ↓ YES
[4.2] in ['CTO','ACC','HMN']? → NO → [E39] Return UC8-E39
    ↓ YES
    Continue to Node 5
```

### Node 5: Success Path
```
[5] Extract credentials
    ↓
[6] Hash password
    ↓
[7] Create user in database
    ↓
[8] Redirect with success message
    ↓
END
```

## 3. Tổng hợp đường dẫn kiểm thử

### 3.1 Số lượng đường dẫn
- **Tổng số điều kiện**: 39 điều kiện validation + 1 success path = **40 đường dẫn**
- **Đường dẫn lỗi**: 39 đường dẫn (UC8-E1 đến UC8-E39)
- **Đường dẫn thành công**: 1 đường dẫn

### 3.2 McCabe Cyclomatic Complexity
- **V(G) = E - N + 2P**
- **E**: Số cạnh = 40
- **N**: Số node = 41 (40 điều kiện + 1 start)
- **P**: Số thành phần kết nối = 1
- **V(G) = 40 - 41 + 2(1) = 1**

Với mỗi điều kiện validation, complexity tăng thêm 1:
**Cyclomatic Complexity = 39 + 1 = 40**

### 3.3 Phân loại độ phức tạp
- **1-10**: Đơn giản, ít rủi ro
- **11-20**: Phức tạp vừa phải  
- **21-50**: Phức tạp cao, rủi ro cao ⬅️ **Hàm store() hiện tại**
- **>50**: Rất phức tạp, khó kiểm thử

## 4. Ma trận kiểm thử đường dẫn

| Đường dẫn | Điều kiện | Input Test Case | Expected Result |
|-----------|-----------|-----------------|-----------------|
| Path 1 | Name required | name="" | UC8-E1 |
| Path 2 | Name min length | name="a" | UC8-E2 |
| Path 3 | Name max length | name="a"×101 | UC8-E3 |
| Path 4 | Name contains digit | name="John1" | UC8-E4 |
| Path 5 | Name special char | name="John@" | UC8-E5 |
| Path 6 | Name leading/trailing space | name=" John " | UC8-E6 |
| Path 7 | Name multiple spaces | name="John  Doe" | UC8-E7 |
| Path 8 | Email required | email="" | UC8-E8 |
| Path 9 | Email whitespace | email="a @b.com" | UC8-E9 |
| Path 10 | Email multiple @ | email="a@@b.com" | UC8-E10 |
| Path 11 | Local-part empty | email="@domain.com" | UC8-E11 |
| Path 12 | Local-part too long | email="a"×65+"@b.com" | UC8-E12 |
| Path 13 | Local-part starts dot | email=".test@b.com" | UC8-E13 |
| Path 14 | Local-part ends dot | email="test.@b.com" | UC8-E14 |
| Path 15 | Local-part double dot | email="te..st@b.com" | UC8-E15 |
| Path 16 | Local-part invalid char | email="te#st@b.com" | UC8-E16 |
| Path 17 | Domain empty | email="test@" | UC8-E17 |
| Path 18 | Domain no dot | email="test@domain" | UC8-E18 |
| Path 19 | Domain double dot | email="test@sub..domain.com" | UC8-E19 |
| Path 20 | Label invalid char | email="test@sub#.domain.com" | UC8-E20 |
| Path 21 | Label starts/ends hyphen | email="test@-sub.domain.com" | UC8-E21 |
| Path 22 | Non-TLD label too long | email="test@"+"a"×64+".com" | UC8-E22 |
| Path 23 | Domain too long | email="test@"+"a"×250+".com" | UC8-E23 |
| Path 24 | TLD not letters | email="test@domain.c0m" | UC8-E24 |
| Path 25 | TLD too short | email="test@domain.c" | UC8-E25 |
| Path 26 | TLD too long | email="test@domain."+"a"×64 | UC8-E26 |
| Path 27 | Email too long total | email="a"×250+"@b.com" | UC8-E27 |
| Path 28 | Domain non-ASCII | email="test@domäin.com" | UC8-E28 |
| Path 29 | Email duplicate | email=existing_email | UC8-E29 |
| Path 30 | Password required | password="" | UC8-E30 |
| Path 31 | Password too short | password="Abc1@" | UC8-E31 |
| Path 32 | Password too long | password="A"×129 | UC8-E32 |
| Path 33 | Password no uppercase | password="abc123@" | UC8-E33 |
| Path 34 | Password no lowercase | password="ABC123@" | UC8-E34 |
| Path 35 | Password no digit | password="Abcdef@" | UC8-E35 |
| Path 36 | Password no special | password="Abcdef123" | UC8-E36 |
| Path 37 | Password has whitespace | password="Abc 123@" | UC8-E37 |
| Path 38 | Type required | type="" | UC8-E38 |
| Path 39 | Type invalid | type="INVALID" | UC8-E39 |
| Path 40 | Success | Valid inputs | Success redirect |

## 5. Khuyến nghị kiểm thử

### 5.1 Kiểm thử bắt buộc
- **Tất cả 40 đường dẫn** phải được kiểm thử
- **Kiểm thử ranh giới** cho các giới hạn độ dài
- **Kiểm thử tổ hợp** cho các trường hợp phức tạp

### 5.2 Kiểm thử ưu tiên cao  
1. **Email validation** (22 test cases) - phức tạp nhất
2. **Password validation** (8 test cases) - yêu cầu bảo mật
3. **Name validation** (7 test cases) - đầu vào cơ bản
4. **Type validation** (2 test cases) - đơn giản nhất

### 5.3 Test coverage metrics
- **Statement Coverage**: 100% (tất cả câu lệnh)
- **Branch Coverage**: 100% (tất cả nhánh điều kiện)  
- **Path Coverage**: 100% (tất cả 40 đường dẫn)
- **Condition Coverage**: 100% (tất cả điều kiện boolean)

---
*Biểu đồ này hỗ trợ kiểm thử hộp trắng bằng cách thể hiện rõ ràng tất cả đường dẫn thực thi có thể có trong hàm store().*