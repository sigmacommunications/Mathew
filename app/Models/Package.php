<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $appends = ['converted_amount'];

    public function getConvertedAmountAttribute()
    {
        // Access the convertedAmount attribute directly
        return $this->convertedAmount ?? $this->amount;
    }

}
