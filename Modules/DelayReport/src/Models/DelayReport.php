<?php

namespace DelayReport\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DelayReport extends Model
{
    use HasFactory;

    protected $fillable = ["order_id", "status", "agent_id"];


    public function scopeDelay($query)
    {

        return $query->where('status', "DELAY");
    }
}
