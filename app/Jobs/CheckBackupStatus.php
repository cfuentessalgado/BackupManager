<?php

namespace App\Jobs;

use App\Models\Backup;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class CheckBackupStatus implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Backup $backup;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Backup $backup)
    {
        $this->backup = $backup;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
         if(!Storage::disk('backups')->exists($this->backup->path) ){
            $this->backup->successful = false;
            $this->backup->pending = false;
            $this->backup->size = 0;
            $this->backup->path = 'NO FILE';
            $this->backup->save();
            return;
         }

         $size = Storage::disk('backups')->size($this->backup->path);

         if ($size == $this->backup->size) {
            $this->backup->successful = true;
            $this->backup->pending = false;
            $this->backup->save();
            ClearOldBackups::dispatch($this->backup->folder);
            return;
         }

         if ($size > $this->backup->size) {
             $this->backup->size = $size;
             $this->backup->save();
             CheckBackupStatus::dispatch($this->backup)->delay(now()->addMinutes(2));
             return;
         }
    }
}
