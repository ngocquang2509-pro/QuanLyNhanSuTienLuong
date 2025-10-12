<?php

namespace Tests\Unit;

use App\Http\Controllers\AdminController;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class AdminControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that the store method creates a user with valid data.
     */
    public function test_store_creates_user_with_valid_data(): void
    {
        $userData = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'type' => 'Admin',
        ];

        $response = $this->post(route('admin.store'), $userData);

        $response->assertRedirect(route('admin.dashboard'));
        $response->assertSessionHas('success', 'Thêm tài khoản thành công');

        $this->assertDatabaseHas('users', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'type' => 'Admin',
        ]);

        $user = User::where('email', 'test@example.com')->first();
        $this->assertTrue(Hash::check('password123', $user->password));
    }

    /**
     * Test that name field is required.
     */
    public function test_name_is_required(): void
    {
        $userData = [
            'name' => '',
            'email' => 'test@example.com',
            'password' => 'password123',
            'type' => 'Admin',
        ];

        $response = $this->post(route('admin.store'), $userData);

        $response->assertSessionHasErrors('name');
    }

    /**
     * Test that email field is required.
     */
    public function test_email_is_required(): void
    {
        $userData = [
            'name' => 'Test User',
            'email' => '',
            'password' => 'password123',
            'type' => 'Admin',
        ];

        $response = $this->post(route('admin.store'), $userData);

        $response->assertSessionHasErrors('email');
    }

    /**
     * Test that password field is required.
     */
    public function test_password_is_required(): void
    {
        $userData = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => '',
            'type' => 'Admin',
        ];

        $response = $this->post(route('admin.store'), $userData);

        $response->assertSessionHasErrors('password');
    }

    /**
     * Test that type field is required.
     */
    public function test_type_is_required(): void
    {
        $userData = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'type' => '',
        ];

        $response = $this->post(route('admin.store'), $userData);

        $response->assertSessionHasErrors('type');
    }
}
