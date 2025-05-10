<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockTransaction extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'item_id',
        'user_id',
        'quantity',
        'type',
        'notes',
    ];

    /**
     * Get the item associated with the stock transaction.
     */
    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    /**
     * Get the user who performed the stock transaction.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}