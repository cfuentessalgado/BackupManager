<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Server extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function folders()
    {
        return $this->hasMany(Folder::class);
    }

    public function getPublicKeyAttribute()
    {
        return Storage::disk('keys')->get($this->id.'/id_rsa.pub');
    }

    public function getPublicKeyPathAttribute()
    {
        return Storage::disk('keys')->path($this->id.'/id_rsa.pub');
    }

    public function getPrivateKeyPathAttribute()
    {
        return Storage::disk('keys')->path($this->id.'/id_rsa');
    }

    public function getBackupPathAttribute()
    {
        return Storage::disk('backups')->path($this->id);
    }
}
