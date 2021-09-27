<?php
namespace App\Support\Security;

use App\Models\Server;
use Illuminate\Support\Facades\Storage;

class ServerKeyManager {
    public static function generateKeyPair(Server $server)
    {
        $command = "yes 'y' | ssh-keygen -t rsa -b 4096 -f %s -q -N '' > /dev/null";
        Storage::disk('keys')->makeDirectory($server->id);
        $fullCommand = sprintf($command, Storage::disk('keys')->path($server->id.'/id_rsa'));
        exec($fullCommand);
    }
}