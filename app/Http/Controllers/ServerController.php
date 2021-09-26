<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateServerRequest;
use App\Models\Schedule;
use App\Models\Server;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ServerController extends Controller
{
    public function index()
    {
        return Inertia::render('Servers/Index', [
            'servers' => Server::all(),
        ]);
    }

    public function show(Server $server)
    {
        $server->load('folders', 'folders.schedule');
        return Inertia::render('Servers/Show', [
            'server' => $server,
            'schedules' => Schedule::all(),
        ]);
    }

    public function create()
    {
        return true;
    }

    public function store(CreateServerRequest $request)
    {
        Server::create($request->safe()->all());

        return back()->withSuccess('Server created');
    }
}
