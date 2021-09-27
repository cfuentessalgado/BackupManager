<?php

namespace App\Http\Controllers;

use App\Models\Backup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DownloadBackupController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, Backup $backup)
    {
        return Storage::disk('backups')->download($backup->path);
    }
}
