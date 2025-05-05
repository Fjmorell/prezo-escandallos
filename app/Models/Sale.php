<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sale extends Model
{
    protected $fillable = ['date'];

    public function saleLines(): HasMany
    {
        return $this->hasMany(SaleLine::class);
    }
}
