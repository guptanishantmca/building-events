<?php
namespace App\Traits;
use Illuminate\Support\Str;
trait Uuid {
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }
        });
    }
    public function getIncrementing(): bool {
        return false;
    }
    public function getKeyType(): string {
        return 'string';
    }
}