<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPackage extends Model
{
    protected $gurded = [];
    // protected $fillable = ['user_id', 'package_id']; // Define the fillable fields for mass assignment

    // Define relationships if you have any
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}
