<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateServerFolderRequest;
use App\Models\Folder;
use App\Models\Schedule;
use App\Models\Server;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class ServerFolderController extends Controller
{

    public function create(Server $server)
    {
        return Inertia::render('Servers/Folders/Create', [
            'server' => $server,
            'schedules' => Schedule::all(),
        ]);
    }

    public function store(CreateServerFolderRequest $request, Server $server)
    {
        $server->folders()->save(new Folder([
            'path' => $request->get('path'),
            'ignore_patterns' => $request->get('ignore_patterns')??[],
            'backup_patterns' => $request->get('backup_patterns')??[],
            'schedule_id' => $request->get('schedule'),
            'hour' => $request->get('hour'),
            'max_backups' => $request->get('max_backups')?? 1,
        ]));

        return Redirect::route('servers.show', $server)->withSuccess('Folder Created');
    }
}
