<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use CrudTrait;

    protected $guarded = [];
    use HasFactory;

    public function payment()
    {
        return $this->belongsTo(Payments::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function getTotalAttribute($value)
    {
        return $value / 100;
    }

   
}