<?php

namespace App\Models;

use App\Jobs\ClearRemoteBackups;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Backup extends Model
{
    use HasFactory;
    protected $appends = ['since'];

    public static function booted()
    {
        static::deleting(function ($backup) {
            ClearRemoteBackups::dispatch($backup);
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
