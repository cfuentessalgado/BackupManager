<?php

namespace App\Models;

use App\Jobs\ClearRemoteBackups;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Backup extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $appends = ['since'];

    public static function booted()
    {
        static::deleting(function ($backup) {
            ClearRemoteBackups::dispatch($backup->path??'', $backup->folder->server->backup_username, $backup->folder->server->ip, $backup->folder->server->privateKeyPath);
            Storage::disk('backups')->delete($backup->path);
        });
    }

    public function folder()
    {
        return $this->belongsTo(Folder::class);
    }

    public function getSinceAttribute()
    {
        return $this->created_at->diffForHumans();
    }
}
