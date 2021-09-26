<?php

use App\Models\Folder;
use App\Models\Server;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Inertia\Testing\Assert;

use function Pest\Laravel\withoutExceptionHandling;

uses(RefreshDatabase::class);
it('shows list of servers', function () {
    Server::factory()->times(10)->create();
    $response = $this->actingAs(User::factory()->create())->get('/servers');
    $response->assertInertia(fn (Assert $page) =>
        $page->component('Servers/Index')->has('servers', 10)
    );
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

it('shows server details', function () {
    $server = Server::factory()->create();
    $response = $this->actingAs(User::factory()->create())->get('/servers/'.$server->id);
    $response->assertOK();
});

test('a folder can be added to a server', function () {
    $server = Server::factory()->create();
    $data = [
        'path' => '~/test',
        'ignore_patterns' => [
            'cache',
            '.env',
        ],
        'backup_patterns' => [],
        'schedule' => 'dailyAt',
        'hour' => '9:00',
    ];

    $this->withoutExceptionHandling();
    $this->actingAs(User::factory()->create())->post(route('servers.folders.store', $server), $data);
    $this->assertDatabaseCount('folders', 1);
    $folder = Folder::first();
    $this->assertEquals($data['ignore_patterns'], $folder->ignore_patterns);
    $this->assertEquals($data['schedule'], $folder->schedule_id);
    $this->assertEquals($data['hour'], $folder->hour);
});

test('when creating a server it creates a private/public ssh key pair', function () {
    Storage::fake('keys');
    $data = [
        'name' => 'Server 1',
        'ip' => '10.10.1.20',
        'backup_username' => 'backup',
    ];

    $response = $this->followingRedirects()->actingAs(User::factory()->create())->post('/servers', $data);
    $response->assertOK();
    $this->assertDatabaseCount('servers', 1);
    Storage::disk('keys')->assertExists(['1/id_rsa','1/id_rsa']);
});
