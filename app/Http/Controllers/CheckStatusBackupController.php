<?php

namespace App\Http\Controllers;

use App\Jobs\CheckBackupStatus;
use App\Models\Backup;
use Illuminate\Http\Request;

class CheckStatusBackupController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, Backup $backup)
    {
        CheckBackupStatus::dispatch($backup);
        return back();
    }
}
