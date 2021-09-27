<?php

namespace App\Jobs;

use App\Models\Backup;
use App\Models\Folder;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Spatie\Ssh\Ssh;

class BackupFolder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Folder $folder;
    public string $backupFolder;
    public string $outputFile;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Folder $folder)
    {
        $this->folder = $folder;
        $this->backupFolder = '/home/' . $this->folder->server->backup_username . '/bm_backups/';
        $this->outputFile = $this->backupFolder . date('Y_m_d_H_i_s_') . basename($this->folder->path) . '.zip';
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $backup = new Backup();
        $backup->folder_id = $this->folder->id;
        $process = Ssh::create(
            $this->folder->server->backup_username,
            $this->folder->server->ip
        )->usePrivateKey($this->folder->server->private_key_path)->disablePasswordAuthentication();


        $zipCreated = $this->createZip($process, $backup);

        if (!$zipCreated) {
            return false;
        }

        $zipDownloaded = $this->downloadZip($process, $backup);
        if (!$zipDownloaded) {
            return false;
        }

        $zipCleared = $this->clearRemoteZip($process, $backup);

        if(!$zipCleared) {
            return false;
        }

        $backup->save();
        return 0;
    }

    private function createZip($process, $backup)
    {
        $process->execute('mkdir -p ' . $this->backupFolder);
        $zipCommand = View::make('commands.zip_folder', [
            'folder' => $this->folder,
            'outputFile' => $this->outputFile,
        ])->render();
        $zipProc = $process->execute($zipCommand);

        if (!$zipProc->isSuccessful()) {
            $backup->successful = false;
            $backup->error = 'Error during zip file creation.';
            $backup->path = null;
            $backup->save();
            return false;
        }
        return true;
    }

    private function downloadZip($process, Backup $backup)
    {
        Storage::disk('backups')->makeDirectory($this->folder->server->id);
        $storageFolder = $this->folder->server->backup_path . '/' . basename($this->outputFile);

        $copyProc = $process->download($this->outputFile, $storageFolder);
        if (!$copyProc->isSuccessful()) {
            $backup->successful = false;
            $backup->error = 'Error during file download.';
            $backup->path = null;
            $backup->save();
            return false;
        }
        return true;
    }

    private function clearRemoteZip($process, Backup $backup)
    {
        $rmProc = $process->execute('rm ' . $this->outputFile);
        $backup->successful = true;
        $backup->path = $this->folder->server->id . '/' . basename($this->outputFile);
        $backup->size = Storage::disk('backups')->size($backup->path);
        if (!$rmProc->isSuccessful()) {
            $backup->error = 'Warning: remote file could not be deleted.';
            $backup->save();
            return false;
        }
        return true;
    }
}
