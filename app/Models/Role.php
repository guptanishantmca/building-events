<?php 
namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Role as SpatieRole;
use Illuminate\Support\Str;

class Role extends SpatieRole
{
    use HasFactory, Uuid;

    protected $keyType = 'string'; // Specify UUIDs as the key type
    public $incrementing = false;
    
}
