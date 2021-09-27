<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Folder extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function server()
    {
        return $this->belongsTo(Server::class);
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class, 'schedule_id', 'label');
    }

    public function backups()
    {
        return $this->hasMany(Backup::class);
    }

    public function getIgnorePatternsAttribute($value)
    {
        return explode(',', $value);
    }

    public function getBackupPatternsAttribute($value)
    {
        return explode(',', $value);
    }

    public function setIgnorePatternsAttribute(array $value)
    {
       $this->attributes['ignore_patterns'] = implode(',', $value);
    }

    public function setBackupPatternsAttribute(array $value)
    {
       $this->attributes['backup_patterns'] = implode(',', $value);
    }

    public function getBackupPathAttribute()
    {
        return Storage::disk('backups')->path($this->id);
    }
}
