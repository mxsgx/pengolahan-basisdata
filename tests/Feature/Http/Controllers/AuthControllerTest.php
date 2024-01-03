<?php

namespace Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_guests_can_visit_auth_page()
    {
        $response = $this->get(route('auth.index'));

        $response->assertOk();
    }

    public function test_users_can_not_visit_auth_page()
    {
        $user = User::factory()->createOne();
        $response = $this->actingAs($user)->get(route('auth.index'));

        $response->assertRedirect(route('homepage'));
    }

    public function test_guests_can_visit_login_page()
    {
        $response = $this->get(route('auth.login.page'));

        $response->assertOk();
    }

    public function test_users_can_not_visit_login_page()
    {
        $user = User::factory()->createOne();
        $response = $this->actingAs($user)->get(route('auth.login.page'));

        $response->assertRedirect(route('homepage'));
    }

    public function test_guests_can_login()
    {
        $user = User::factory()->createOne();
        $response = $this->fromRoute('auth.login.page')->post(route('auth.login.action'), [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertRedirect(route('homepage'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_guests_can_not_login_with_invalid_credentials()
    {
        $user = User::factory()->createOne();
        $response = $this->fromRoute('auth.login.page')->post(route('auth.login.action'), [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $response->assertRedirect(route('auth.login.page'));
        $response->assertSessionHasErrors();
        $this->assertGuest();
    }

    public function test_guests_can_visit_register_page()
    {
        $response = $this->get(route('auth.register.page'));

        $response->assertOk();
    }

    public function test_users_can_not_visit_register_page()
    {
        $user = User::factory()->createOne();
        $response = $this->actingAs($user)->get(route('auth.register.page'));

        $response->assertRedirect(route('homepage'));
    }

    public function test_guests_can_register()
    {
        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'password' => 'password',
            'password_confirmation' => 'password',
        ];
        $response = $this->fromRoute('auth.register.page')->post(route('auth.register.action'), $data);

        $response->assertRedirect();
        $this->assertAuthenticated();
        $this->assertDatabaseHas(User::getModel()->getTable(), [
            'email' => $data['email'],
        ]);
    }

    public function test_guests_can_register_with_invalid_data()
    {
        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'password' => 'password',
            'password_confirmation' => 'miss-password',
        ];
        $response = $this->fromRoute('auth.register.page')->post(route('auth.register.action'), $data);

        $response->assertRedirect();
        $response->assertSessionHasErrors();
        $this->assertGuest();
    }

    public function test_users_can_logout()
    {
        $user = User::factory()->createOne();
        $response = $this->post(route('auth.logout'));

        $response->assertRedirect();
        $this->assertGuest();
    }
}
