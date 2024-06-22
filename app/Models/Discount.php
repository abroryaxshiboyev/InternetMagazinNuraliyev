<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Discount extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'name',
        'percent',
        'sum',
        'from',
        'to',
    ];

    public function product():BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
