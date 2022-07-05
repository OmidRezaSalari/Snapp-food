<?php

namespace DelayReport\Models;

use DelayReport\Database\Factories\VendorFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    protected $fillable = ['name'];


    protected static function newFactory()
    {
        return VendorFactory::new();
    }

    public function orders(){

        return $this->hasMany(Order::class);
    }
}
