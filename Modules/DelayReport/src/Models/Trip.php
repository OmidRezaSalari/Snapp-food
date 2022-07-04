<?php

namespace DelayReport\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;

    protected $fillable = ["order_id", "delivery_id", "status"];


    public function scopeInProcess($query)
    {
        return $query->whereIn("status", ['ASSIGNED', "VENDOR_AT", "PICKED"]);
    }
    public function scopeDeliverd($query)
    {
        return $query->where("status", "DELIVERED");
    }
}
