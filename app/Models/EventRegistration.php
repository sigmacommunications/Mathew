<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventRegistration extends Model
{
    use HasFactory;
    protected $table = 'event_registration';
    // protected $guarded = [];
    protected $fillable = ['event_id', 'name', 'email', 'description'];
}
