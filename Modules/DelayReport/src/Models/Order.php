<?php

namespace DelayReport\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ["owner_id", "identifier", "vendor_id", "time_delivery", "created_at"];
}
