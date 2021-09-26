<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateServerFolderRequest;
use App\Models\Folder;
use App\Models\Server;
use Illuminate\Support\Facades\Redirect;

class ServerFolderController extends Controller
{
    public function store(CreateServerFolderRequest $request, Server $server)
    {
        $server->folders()->save(new Folder([
            'path' => $request->get('path'),
            'ignore_patterns' => $request->get('ignore_patterns'),
            'backup_patterns' => $request->get('backup_patterns'),
            'schedule_id' => $request->get('schedule'),
            'hour' => $request->get('hour'),
        ]));

        return Redirect::route('servers.show', $server)->withSuccess('Folder Created');
    }
}
