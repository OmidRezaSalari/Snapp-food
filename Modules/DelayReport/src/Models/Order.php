<?php

namespace DelayReport\Models;

use DelayReport\Database\Factories\OrderFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ["owner_id", "identifier", "vendor_id", "time_delivery", "created_at"];


    protected static function newFactory()
    {
        return OrderFactory::new();
    }

    public function vendor()
    {

        return $this->belongsTo(Vendor::class);
    }
}
