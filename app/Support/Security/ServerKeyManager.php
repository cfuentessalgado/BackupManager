<?php
namespace App\Support\Security;

use App\Models\Server;
use Illuminate\Support\Facades\Storage;

class ServerKeyManager {
    public static function generateKeyPair(Server $server)
    {
        $config = [
            "digest_alg" => "sha512",
            "private_key_bits" => 4096,
            "private_key_type" => OPENSSL_KEYTYPE_RSA,
        ];
        $privateKey = openssl_pkey_new($config);
        $privateKeyContent = '';
        openssl_pkey_export($privateKey, $privateKeyContent);
        $publicKeyPem = openssl_pkey_get_details($privateKey)['key'];
        $privatePath = sprintf('%d/%s', $server->id, 'id_rsa');
        $publicPath = sprintf('%d/%s', $server->id, 'id_rsa.pub');
        Storage::disk('keys')->put($privatePath, $privateKeyContent);
        Storage::disk('keys')->put($publicPath, $publicKeyPem);
    }
}