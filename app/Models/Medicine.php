<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'item_id',
        'dosage',
        'expiry_date',
        'requires_prescription',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'expiry_date' => 'date',
        'requires_prescription' => 'boolean',
    ];

    /**
     * Get the item that owns the medicine.
     */
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}