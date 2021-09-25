<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('shows list of servers', function () {
    $response = $this->actingAs(User::factory()->create())->get('/servers');
    $response->assertStatus(200);
});

it('shows view for creating server', function(){
    $response = $this->actingAs(User::factory()->create())->get('/servers/create');
    $response->assertStatus(200);
});

it('allows to create a server', function(){
    $data = [
        'name' => 'Server 1',
        'ip' => '10.10.1.20',
        'backup_username' => 'backup',
    ];

    $response = $this->followingRedirects()->actingAs(User::factory()->create())->post('/servers', $data);
    $response->assertOK();
    $this->assertDatabaseCount('servers', 1);
});
