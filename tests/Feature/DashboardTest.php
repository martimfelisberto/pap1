<?php

use App\Models\User;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('guests are redirected to the login page', function () {
    $response = $this->get('/dashboard');
    $response->assertRedirect('/login');
});

test('non-admin users cannot access the dashboard', function () {
    $user = User::factory()->create(['is_admin' => false]);

    $this->actingAs($user);

    $response = $this->get('/dashboard');
    $response->assertForbidden(); // HTTP 403
});

test('admin users can access the dashboard', function () {
    $admin = User::factory()->create(['is_admin' => true]);

    $this->actingAs($admin);

    $response = $this->get('/dashboard');
    $response->assertStatus(200);
});
