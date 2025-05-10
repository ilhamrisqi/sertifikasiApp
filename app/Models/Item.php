<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'quantity',
        'price',
        'item_type',
    ];

    /**
     * Get the medicine details for this item.
     */
    public function medicine()
    {
        return $this->hasOne(Medicine::class);
    }

    /**
     * Get the medical equipment details for this item.
     */
    public function medicalEquipment()
    {
        return $this->hasOne(MedicalEquipment::class);
    }

    /**
     * Get the consumable details for this item.
     */
    public function consumable()
    {
        return $this->hasOne(Consumable::class);
    }

    /**
     * Get the stock transactions for this item.
     */
    public function stockTransactions()
    {
        return $this->hasMany(StockTransaction::class);
    }
}