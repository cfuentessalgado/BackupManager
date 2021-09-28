<?php

namespace App\Jobs;

use App\Models\Backup;
use App\Models\Folder;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ClearOldBackups implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;
    public Folder $folder;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Folder $folder)
    {
        $this->folder = $folder;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $keepersId = $this->folder->backups()
        ->latest()
        ->take($this
        ->folder->max_backups)
        ->pluck('id');

        $toDelete = Backup::whereNotIn('id', $keepersId)->get();
        $toDelete->each(fn ($backup) =>$backup->delete());
    }
}
