<?php
namespace App\Models;

use Laravel\Sanctum\PersonalAccessToken as SanctumPersonalAccessToken;

class PersonalAccessToken extends SanctumPersonalAccessToken
{
    protected $keyType = 'string'; // Specify UUIDs as the key type
    public $incrementing = false; // Disable auto-incrementing IDs
}
