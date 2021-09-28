<?php

namespace App\Jobs;

use App\Models\Backup;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Spatie\Ssh\Ssh;

class ClearRemoteBackups implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;
    public Backup $backup;
    public string $outputFile;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Backup $backup)
    {
        $this->backup = $backup;
        $this->outputFile = '~/bm_backups/'.basename($backup->path);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $process = Ssh::create(
            $this->backup->folder->server->backup_username,
            $this->backup->folder->server->ip
        )->disableStrictHostKeyChecking()->usePrivateKey($this->backup->folder->server->private_key_path)->disablePasswordAuthentication();
        $process->execute('rm ' . $this->outputFile);
    }
}
