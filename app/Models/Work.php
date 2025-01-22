<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
class Work extends Model
{
    use  Uuid;
    protected $fillable = [
        
        'title',
        'description',
        // 'budget',
        // 'hourly_rate',
        // 'work_type',
        // 'skills_required',
    ];
    protected $keyType = 'string'; // Specify UUIDs as the key type
    public $incrementing = false;
}
