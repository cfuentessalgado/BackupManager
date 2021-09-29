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
    public $backupPath;
    public string $outputFile;
    public string $username;
    public string $ip;
    public string $privateKey;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $backupPath, string $username, string $ip, string $privateKey)
    {
        $this->backupPath = $backupPath;
        $this->username = $username;
        $this->ip = $ip;
        $this->privateKey = $privateKey;
        $this->outputFile = '~/bm_backups/'.basename($backupPath);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if($this->backupPath == '') {
            return;
        }
        $process = Ssh::create(
            $this->username,
            $this->ip
        )->disableStrictHostKeyChecking()->usePrivateKey($this->privateKey)->disablePasswordAuthentication();
        $process->execute('rm ' . $this->outputFile);
    }
}
