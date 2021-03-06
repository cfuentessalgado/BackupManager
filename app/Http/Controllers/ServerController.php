<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateServerRequest;
use App\Models\Schedule;
use App\Models\Server;
use App\Support\Security\ServerKeyManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class ServerController extends Controller
{
    public function index()
    {
        return Inertia::render('Servers/Index', [
            'servers' => Server::withCount('folders', 'backups')->get(),
        ]);
    }

    public function show(Server $server)
    {
        $server->load('folders', 'folders.schedule', 'folders.backups')->loadCount('folders', 'backups');
        $server->append('public_key');
        return Inertia::render('Servers/Show', [
            'server' => $server,
        ]);
    }

    public function create()
    {
        return Inertia::render('Servers/Create');
    }

    public function store(CreateServerRequest $request)
    {
        $server = Server::create($request->safe()->all());
        ServerKeyManager::generateKeyPair($server);
        return Redirect::route('servers.index')->withSuccess('Server created');
    }
}
