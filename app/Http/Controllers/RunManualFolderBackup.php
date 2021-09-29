<?php

namespace App\Http\Controllers;

use App\Jobs\BackupFolder;
use App\Jobs\ClearOldBackups;
use App\Models\Folder;
use Illuminate\Http\Request;

class RunManualFolderBackup extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, Folder $folder)
    {
        BackupFolder::dispatch($folder)->onQueue('long-running-queue');
        return back();
    }
}
